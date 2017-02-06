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
    const MAX_RELOADS = 10;
    const WAIT_INTERVAL = 1000;

    const STATE_IN_PROGRESS = 'inProgress';
    const STATE_SUCCESS = 'success';
    const STATE_ERROR = 'error';

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
        $method,
        callable $doneCallback = null
    ) {
        $this->connection = $connection;
        $this->normalizer = $normalizer;
        $this->name = $name;
        $this->method = $method;

        $this->doneCallback = (!is_null($doneCallback))
            ? $doneCallback
            : function($res) { return $res; };
    }

    /**
     * Return the Operation name.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Return the Operation method.
     *
     * @return string
     */
    public function method()
    {
        return $this->method;
    }

    /**
     * Check if the Operation is done.
     *
     * @return bool
     */
    public function done()
    {
        return (isset($this->info['done']))
            ? $this->info['done']
            : false;
    }

    /**
     * Get the state of the Operation.
     *
     * Return value will be one of `LongRunningOperation::STATE_IN_PROGRESS`,
     * `LongRunningOperation::STATE_SUCCESS` or
     * `LongRunningOperation::STATE_ERROR`.
     *
     * @return string
     */
    public function state()
    {
        if (!$this->done()) {
            return self::STATE_IN_PROGRESS;
        }

        if (isset($this->info['response'])) {
            return self::STATE_SUCCESS;
        }

        return self::STATE_ERROR;
    }

    /**
     * Get the Operation result.
     *
     * The return type of this method is dictated by the type of Operation.
     *
     * Returns null if the Operation is not yet complete, or if an error occurred.
     *
     * @return mixed|null
     */
    public function result()
    {
        return $this->result;
    }

    /**
     * Get the Operation error.
     *
     * Returns null if the Operation is not yet complete, or if no error occurred.
     *
     * @return array|null
     */
    public function error()
    {
        return $this->error;
    }

    /**
     * Get the Operation info.
     *
     * @codingStandardsIgnoreStart
     * @param array $options Configuration options.
     * @return array [google.longrunning.Operation](https://cloud.google.com/spanner/docs/reference/rpc/google.longrunning#google.longrunning.Operation)
     * @codingStandardsIgnoreEnd
     */
    public function info(array $options = [])
    {
        return $this->info ?: $this->reload($options);
    }

    /**
     * Reload the Operation to check its status.
     *
     * @codingStandardsIgnoreStart
     * @param array $options Configuration Options.
     * @return array [google.longrunning.Operation](https://cloud.google.com/spanner/docs/reference/rpc/google.longrunning#google.longrunning.Operation)
     * @codingStandardsIgnoreEnd
     */
    public function reload(array $options = [])
    {
        $res = $this->connection->reload([
            'name' => $this->name,
            'method' => $this->method
        ] + $options);

        $this->result = $this->executeDoneCallback($this->normalizer->serializeResult($res));
        return $this->info = $this->normalizer->serializeOperation($res);
    }

    /**
     * Reload the operation until it is complete.
     *
     * The return type of this method is dictated by the type of Operation.
     *
     * @param array $options {
     *     Configuration Options
     *
     *     @type int $waitInterval The time, in microseconds, to wait between
     *           checking the status of the Operation. **Defaults to** `1000`.
     *     @type int $maxReloads The maximum number of reload operations the
     *           Operation will be checked. In microseconds, the time before
     *           failure will be `$waitInterval*$maxReloads`. **Defaults to**
     *           10.
     * }
     * @return mixed
     * @throws RuntimeException If the max reloads are exceeded.
     */
    public function wait(array $options = [])
    {
        $options =+ [
            'waitInterval' => self::WAIT_INTERVAL,
            'maxReloads' => self::MAX_RELOADS
        ];

        $isComplete = $this->done();

        $reloads = 0;
        do {
            $res = $this->reload($options);
            $isComplete = $this->done();

            if (!$isComplete) {
                usleep($options['waitInterval']);

                $reloads++;
                if ($reloads > $options['maxReloads']) {
                    throw new \RuntimeException('The maximum number of Operation reloads has been exceeded.');
                }
            }

        } while(!$isComplete);

        return $this->result;
    }

    /**
     * Cancel a Long Running Operation.
     *
     * @param array $options Configuration options.
     * @return void
     */
    public function cancel(array $options = [])
    {
        $this->connection->cancel([
            'name' => $this->name
        ]);
    }

    /**
     * Delete a Long Running Operation.
     *
     * @param array $options Configuration Options.
     * @return void
     */
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

    /**
     * @access private
     */
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
