<?php
/**
 * Copyright 2019, Google LLC All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Bigtable;

use Google\ApiCore\ApiException;
use Google\ApiCore\ArrayTrait;
use Google\ApiCore\RetrySettings;
use Google\Cloud\Bigtable\V2\Client\BigtableClient as GapicClient;
use Google\Protobuf\Internal\Message;
use Google\Rpc\Code;

/**
 * User stream which handles failure from upstream, retries if necessary and
 * provides single retrying user stream.
 * @internal
 */
class ResumableStream implements \IteratorAggregate
{
    use ArrayTrait;

    const DEFAULT_MAX_RETRIES = 3;

    /**
     * @var array
     */
    public static $retryableStatusCodes = [
        Code::DEADLINE_EXCEEDED => Code::DEADLINE_EXCEEDED,
        Code::ABORTED => Code::ABORTED,
        Code::UNAVAILABLE => Code::UNAVAILABLE
    ];

    /**
     * @var int
     */
    private $retries;

    /**
     * @var GapicClient
     */
    private $gapicClient;

    /**
     * @var Message
     */
    private $request;

    /**
     * @var string
     */
    private $method;

    /**
     * @var callable
     */
    private $argumentFunction;

    /**
     * @var callable
     */
    private $retryFunction;

    /**
     * @var array
     */
    private $callOptions;

    /**
     * @var callable
     */
    private $delayFunction;

    /**
     * Constructs a resumable stream.
     *
     * @param GapicClient $gapicClient The GAPIC client to use in order to send requests.
     * @param string $method The method to call on the GAPIC client.
     * @param Message $request The request to pass on to the GAPIC client method.
     * @param callable $argumentFunction Function which returns the argument to be used while
     *        calling `$apiFunction`.
     * @param callable $retryFunction Function which determines whether to retry or not.
     * @param array $callOptions {
     *        @option RetrySettings|array $retrySettings {
     *                @option int $maxRetries Number of times to retry. **Defaults to** `3`.
     *                Only maxRetries works for RetrySettings in this API.
     *            }
     *   }
     */
    public function __construct(
        GapicClient $gapicClient,
        string $method,
        Message $request,
        callable $argumentFunction,
        callable $retryFunction,
        array $callOptions = []
    ) {
        $this->gapicClient = $gapicClient;
        $this->method = $method;
        $this->request = $request;
        $this->retries = $this->getMaxRetries($callOptions);
        $this->argumentFunction = $argumentFunction;
        $this->retryFunction = $retryFunction;
        $this->callOptions = $callOptions;
        // Disable GAX retries because we want to handle the retries here.
        // Once GAX has the provision to modify request/args in between retries,
        // we can re enable GAX's retries and use them completely.
        $this->callOptions['retrySettings'] = [
            'retriesEnabled' => false
        ];

        $this->delayFunction = function (int $attempt) {
            // Values here are taken from the Java Bigtable client, and are
            // different than those set by default in the readRows configuration
            // @see https://github.com/googleapis/java-bigtable/blob/c618969216c90c42dee6ee48db81e90af4fb102b/google-cloud-bigtable/src/main/java/com/google/cloud/bigtable/data/v2/stub/EnhancedBigtableStubSettings.java#L162-L164
            $initialDelayMillis = 10;
            $initialDelayMultiplier = 2;
            $maxDelayMillis = 60000;

            $delayMultiplier = $initialDelayMultiplier ** $attempt;
            $delayMs = min($initialDelayMillis * $delayMultiplier, $maxDelayMillis);
            $actualDelayMs = mt_rand(0, $delayMs); // add jitter
            $delay = 1000 * $actualDelayMs; // convert ms to µs

            usleep((int) $delay);
        };
    }

    /**
     * Starts executing the call and reading elements from server stream.
     *
     * @return \Generator
     * @throws ApiException
     */
    public function readAll()
    {
        // Reset $currentAttempts on successful row read, but keep total attempts for the header.
        $currentAttempt = $totalAttempt = 0;
        do {
            $ex = null;
            list($this->request, $this->callOptions) =
                ($this->argumentFunction)($this->request, $this->callOptions);

            $completed = $this->pluck('requestCompleted', $this->callOptions, false);

            if ($completed !== true) {
                // Send in "bigtable-attempt" header on retry request
                $headers = $this->callOptions['headers'] ?? [];
                if ($totalAttempt > 0) {
                    $headers['bigtable-attempt'] = [(string) $totalAttempt];
                    ($this->delayFunction)($currentAttempt);
                }

                $stream = call_user_func_array(
                    [$this->gapicClient, $this->method],
                    [$this->request, ['headers' => $headers] + $this->callOptions]
                );

                try {
                    foreach ($stream->readAll() as $item) {
                        yield $item;
                        $currentAttempt = 0; // reset delay and attempt on successful read.
                    }
                } catch (\Exception $ex) {
                }
                // It's possible for the retry function to retry even when `$ex` is null
                // (see Table::mutateRowsWithEntries). For this reason, we increment the attemts
                // outside the try/catch block.
                $totalAttempt++;
                $currentAttempt++;
            }
        } while (($this->retryFunction)($ex) && $currentAttempt <= $this->retries);
        if ($ex !== null) {
            throw $ex;
        }
    }

    /**
     * @access private
     * @return \Generator
     * @throws ApiException Thrown in the case of a malformed response.
     */
    #[\ReturnTypeWillChange]
    public function getIterator()
    {
        return $this->readAll();
    }

    /**
     * Checks if code is retryable or not.
     *
     * @param int $code Code to check.
     * @return bool
     */
    public static function isRetryable($code)
    {
        return isset(self::$retryableStatusCodes[$code]);
    }

    private function getMaxRetries(array $options): int
    {
        $retrySettings = $options['retrySettings'] ?? [];

        if ($retrySettings instanceof RetrySettings) {
            return $retrySettings->getMaxRetries();
        }

        return $retrySettings['maxRetries'] ?? ResumableStream::DEFAULT_MAX_RETRIES;
    }
}
