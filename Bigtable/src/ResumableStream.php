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
     * array $optionalArgs
     */
    private $optionalArgs;

    /**
     * Constructs a resumable stream.
     *
     * @param GapicClient $gapicClient The GAPIC client to use in order to send requests.
     * @param string $method The method to call on the GAPIC client.
     * @param Message $request The request to pass on to the GAPIC client method.
     * @param callable $argumentFunction Function which returns the argument to be used while
     *        calling `$apiFunction`.
     * @param callable $retryFunction Function which determines whether to retry or not.
     * @param int $retries [optional] Number of times to retry. **Defaults to** `3`.
     */
    public function __construct(
        GapicClient $gapicClient,
        string $method,
        Message $request,
        callable $argumentFunction,
        callable $retryFunction,
        $retries = self::DEFAULT_MAX_RETRIES,
        array $optionalArgs = []
    ) {
        $this->gapicClient = $gapicClient;
        $this->method = $method;
        $this->request = $request;
        $this->retries = $retries ?: self::DEFAULT_MAX_RETRIES;
        $this->argumentFunction = $argumentFunction;
        $this->retryFunction = $retryFunction;
        $this->optionalArgs = $optionalArgs;
    }

    /**
     * Starts executing the call and reading elements from server stream.
     *
     * @return \Generator
     * @throws ApiException
     */
    public function readAll()
    {
        $tries = 0;
        $argumentFunction = $this->argumentFunction;
        $retryFunction = $this->retryFunction;
        do {
            $ex = null;
            list($this->request, $this->optionalArgs) = $argumentFunction($this->request, $this->optionalArgs);

            $completed = $this->pluck('requestCompleted', $this->optionalArgs, false);

            if ($completed !== true) {
                $stream = call_user_func_array(
                        [$this->gapicClient, $this->method],
                        [$this->request, $this->optionalArgs]
                    );

                try {
                    foreach ($stream->readAll() as $item) {
                        yield $item;
                    }
                } catch (\Exception $ex) {
                }
            }
            $tries++;
        } while ((!$this->retryFunction || $retryFunction($ex)) && $tries <= $this->retries);
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
}
