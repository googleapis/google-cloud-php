<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\LongRunning\Normalizer;

use Google\Cloud\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\LongRunning\LongRunningOperation;
use Google\Cloud\PhpArray;
use Google\GAX\OperationResponse;

class GrpcNormalizer implements LongRunningNormalizerInterface
{
    private $connection;
    private $codec;

    public function __construct(LongRunningConnectionInterface $connection)
    {
        $this->connection = $connection;
        $this->codec = new PhpArray();
    }

    /**
     * @param mixed $operation
     * @return LongRunningOperation
     */
    public function normalize($operation, $method, callable $doneCallback = null)
    {
        if (!($operation instanceof OperationResponse)) {
            throw new \BadMethodCallException('operation must be an instance of OperationResponse');
        }

        return new LongRunningOperation($this->connection, $this, $operation->getName(), $method, $doneCallback);
    }

    /**
     * @param mixed $result
     * @return array
     */
    public function serializeOperation($result)
    {
        return $result->getLastProtoResponse()->serialize($this->codec);
    }

    /**
     * @param mixed $result
     * @return array
     */
    public function serializeResult($result)
    {
        return $result->getResult()->serialize($this->codec);
    }

    /**
     * @param mixed $error
     * @return array
     */
    public function serializeError($error)
    {}
}
