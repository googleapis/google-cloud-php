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
use Google\Cloud\Core\ExponentialBackoff;
use Google\Rpc\Code;

/**
 * User stream which handles failure from upstream, retries if necessary and
 * provides single retrying user stream.
 */
class ResumableStream implements \IteratorAggregate
{
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
     * @var callable
     */
    private $apiFunction;

    /**
     * @var callable
     */
    private $argumentFunction;

    /**
     * @var callable
     */
    private $retryFunction;

    /**
     * Constructs a resumable stream.
     *
     * @param callable $apiFunction Function to execute to get server stream. Function signature
     *        should match: `function (...) : Google\ApiCore\ServerStream`.
     * @param callable $argumentFunction Function which returns the argument to be used while
     *        calling `$apiFunction`.
     * @param callable $retryFunction Function which determines whether to retry or not.
     * @param int $retries [optional] Number of times to retry. **Defaults to** `3`.
     */
    public function __construct(
        callable $apiFunction,
        callable $argumentFunction,
        callable $retryFunction,
        $retries = self::DEFAULT_MAX_RETRIES
    ) {
        $this->retries = $retries ?: self::DEFAULT_MAX_RETRIES;
        $this->apiFunction = $apiFunction;
        $this->argumentFunction = $argumentFunction;
        $this->retryFunction = $retryFunction;
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
            $stream = $this->createExponentialBackoff()->execute($this->apiFunction, $argumentFunction());
            try {
                foreach ($stream->readAll() as $item) {
                    yield $item;
                }
            } catch (\Exception $ex) {
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

    private function createExponentialBackoff()
    {
        return new ExponentialBackoff(
            $this->retries,
            function ($ex) {
                return self::isRetryable($ex->getCode());
            }
        );
    }
}
