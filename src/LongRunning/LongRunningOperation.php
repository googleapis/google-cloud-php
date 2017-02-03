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

namespace Google\Cloud\LongRunning;

use Google\Cloud\LongRunning\Normalizer\NormalizerInterface;

class LongRunningOperation
{
    /**
     * @param LongRunningConnectionInterface
     */
    private $connection;

    /**
     * @param NormalizerInterface
     */
    private $normalizer;

    /**
     * @param string
     */
    private $name;

    /**
     * @param array
     */
    private $info;

    /**
     * @param string|null
     */
    private $method;

    /**
     * @param callable|null
     */
    private $doneCallback;

    /**
     * @param LongRunningConnectionInterface $connection An implementation mapping to methods which handle LRO
     *        resolution in the service.
     * @param NormalizerInterface $normalizer Normalizes service interaction differences between REST and gRPC.
     * @param string $name The Operation name.
     * @param string $method The method used to create the operation. Only applicable when using gRPC transport.
     * @param callable $doneCallback [optional] A callback, receiving the operation result as an array, executed when
     *        the operation is complete.
     */
    public function __construct(
        LongRunningConnectionInterface $connection,
        NormalizerInterface $normalizer,
        $name,
        $method = null,
        callable $doneCallback = null
    ) {
        $this->connection = $connection;
        $this->normalizer = $normalizer;
        $this->name = $name;
        $this->method = $method;

        if (is_null($doneCallback)) {
            $this->doneCallback = function($res) { return $res; };
        } else {
            $this->doneCallback = $doneCallback;
        }
    }

    public function name()
    {
        return $this->name;
    }

    public function done()
    {
        return (isset($this->info['done']))
            ? $this->info['done']
            : false;
    }

    public function result()
    {
        return $this->result;
    }

    public function info(array $options = [])
    {
        return $this->info ?: $this->reload($options);
    }

    public function reload(array $options = [])
    {
        $res = $this->connection->reload([
            'name' => $this->name,
            'method' => $this->method
        ] + $options);

        $this->result = $this->executeDoneCallback($this->normalizer->serializeResult($res));
        return $this->info = $this->normalizer->serializeOperation($res);
    }

    public function wait(array $options = [])
    {
        $isComplete = $this->done();

        do {
            $res = $this->reload($options);
            $isComplete = $this->info['done'];
        } while(!$isComplete);

        return $this->result;
    }

    public function cancel(array $options = [])
    {
        $this->connection->cancel([
            'name' => $this->name
        ]);
    }

    public function delete(array $options = [])
    {
        $this->connection->delete([
            'name' => $this->name
        ]);
    }

    private function executeDoneCallback($res)
    {
        if (is_null($res)) {
            return null;
        }

        return call_user_func($this->doneCallback, $res);
    }

    public function __debugInfo()
    {
        return [
            'connection' => get_class($this->connection),
            'normalizer' => get_class($this->normalizer),
            'name' => $this->name,
            'method' => $this->method
        ];
    }
}
