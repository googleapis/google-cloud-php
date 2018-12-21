<?php
/**
 * Copyright 2018, Google LLC All rights reserved.
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

use Google\Cloud\Bigtable\RetryUtil;
use Google\Cloud\Core\ExponentialBackoff;

class ResumableStream implements \IteratorAggregate
{
    const DEFAULT_MAX_RETRIES = 3;

    /**
     * @var integer
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
     * Constructs resumable stream.
     *
     * @param callable $apiFunction Function to execute to get server stream. Function signature
     *        should match: `function (...) : Google\ApiCore\ServerStream`.
     * @param callable $argumentFunction Function which returns the argument to be used while
     *        calling `$apiFunction`.
     * @param callable $retryFunction Function which determines whether to retry or not.
     * @param integer $retries Number of times to retry. **Defaults to** `3`.
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
     * @throws Google\ApiCore\ApiException
     */
    public function readAll()
    {
        $tries = 0;
        do {
            $ex = null;
            $stream = $this->createExponentialBackoff()->execute($this->apiFunction, ($this->argumentFunction)());
            try {
                foreach ($stream->readAll() as $item) {
                    yield $item;
                }
            } catch (\Exception $ex) {
            }
            $tries++;
        } while ((!$this->retryFunction || ($this->retryFunction)($ex)) && $tries <= $this->retries);
        if ($ex !== null) {
            throw $ex;
        }
    }

    private function createExponentialBackoff()
    {
        return new ExponentialBackoff($this->retries, RetryUtil::getDefaultRetryFunction());
    }

    /**
     * @access private
     * @return \Generator
     * @throws ApiException Thrown in the case of a malformed response.
     */
    public function getIterator()
    {
        return $this->readAll();
    }
}
