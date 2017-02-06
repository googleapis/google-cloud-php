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

/**
 * Normalizes LRO operations performed via GAX.
 */
class GrpcNormalizer implements LongRunningNormalizerInterface
{
    /**
     * @var LongRunningConnectionInterface
     */
    private $connection;

    /**
     * @var CodecInterface
     */
    private $codec;

    /**
     * @param LongRunningConnectionInterface $connection A connection to an LRO service.
     */
    public function __construct(LongRunningConnectionInterface $connection)
    {
        $this->connection = $connection;
        $this->codec = new PhpArray();
    }

    /**
     * Creates a Long Running Operation instance from an operation.
     *
     * In gRPC, $operation is an instance of `Google\Gax\OperationResponse`.
     *
     * @param mixed $operation
     * @param string $method The API method which created the operation.
     *        Required by GAX to hydrate an OperationResponse.
     * @param callable $doneCallback [optional] A callback, receiving the
     *        operation result as an array, executed when the operation is
     *        complete.
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
     * Get the operation response as a php array.
     *
     * In gRPC, $operation is an instance of `Google\Gax\OperationResponse`.
     *
     * @param mixed $operation
     * @return array
     */
    public function serializeOperation($operation)
    {
        return $operation->getLastProtoResponse()->serialize($this->codec);
    }

    /**
     * Get the operation response as a php array.
     *
     * In gRPC, $operation is an instance of `Google\Gax\OperationResponse`.
     *
     * @param mixed $operation
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
