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

class ApiCallExecutor implements \IteratorAggregate
{
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

    public function __construct(callable $apiFunction, callable $argumentFunction, callable $retryFunction, $retries)
    {
        $this->retries = $retries;
        $this->apiFunction = $apiFunction;
        $this->argumentFunction = $argumentFunction;
        $this->retryFunction = $retryFunction;
    }

    public function execute()
    {
        $tries = 0;
        do {
            $ex = null;
            $stream = $this->createExponentialBackoff()->execute($this->apiFunction, $this->argumentFunction());
            try {
                foreach ($stream->readAll() as $item) {
                    yield $item;
                }
            } catch (ApiException $ex) {
            }
            $tries++;
        } while ((($this->retryFunction && $this->retryFunction($ex)) || true) && $tries <= $this->retries);

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
        return $this->execute();
    }
}
