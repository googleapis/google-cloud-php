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

namespace Google\Cloud\Core\LongRunning;

/**
 * Represent and interact with a Long Running Operation.
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 * $spanner = $cloud->spanner();
 * $instance = $spanner->instance('my-instance');
 *
 * $operation = $instance->createDatabase('my-database');
 * ```
 */
class LongRunningOperation
{
    const WAIT_INTERVAL = 1.0;

    const STATE_IN_PROGRESS = 'inProgress';
    const STATE_SUCCESS = 'success';
    const STATE_ERROR = 'error';

    /**
     * @var LongRunningConnectionInterface
     */
    private $connection;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $info;

    /**
     * @var array|null
     */
    private $result;

    /**
     * @var array|null
     */
    private $error;

    /**
     * @var array
     */
    private $callablesMap;

    /**
     * @param LongRunningConnectionInterface $connection An implementation
     *        mapping to methods which handle LRO resolution in the service.
     * @param string $name The Operation name.
     * @param array $callablesMap An collection of form [(string) type, (callable) callable]
     *        providing a function to invoke when an operation completes. The
     *        callable Type should correspond to an expected value of
     *        operation.metadata.typeUrl.
     */
    public function __construct(
        LongRunningConnectionInterface $connection,
        $name,
        array $callablesMap
    ) {
        $this->connection = $connection;
        $this->name = $name;
        $this->callablesMap = $callablesMap;
    }

    /**
     * Return the Operation name.
     *
     * Example:
     * ```
     * $name = $operation->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Check if the Operation is done.
     *
     * Example:
     * ```
     * if ($operation->done()) {
     *     echo "The operation is done!";
     * }
     * ```
     *
     * @return bool
     */
    public function done()
    {
        return (isset($this->info()['done']))
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
     * Example:
     * ```
     * switch ($operation->state()) {
     *     case LongRunningOperation::STATE_IN_PROGRESS:
     *         echo "Operation is in progress";
     *         break;
     *
     *     case LongRunningOperation::STATE_SUCCESS:
     *         echo "Operation succeeded";
     *         break;
     *
     *     case LongRunningOperation::STATE_ERROR:
     *         echo "Operation failed";
     *         break;
     * }
     * ```
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
     * Note that if the Operation has not yet been reloaded, this may return
     * null even when the operation has completed. Use
     * {@see Google\Cloud\LongRunning\LongRunningOperation::reload()} to get the
     * Operation state before retrieving the result.
     *
     * Example:
     * ```
     * $result = $operation->result();
     * ```
     *
     * @return mixed|null
     */
    public function result()
    {
        $this->info();
        return $this->result;
    }

    /**
     * Get the Operation error.
     *
     * Returns null if the Operation is not yet complete, or if no error occurred.
     *
     * Note that if the Operation has not yet been reloaded, this may return
     * null even when the operation has completed. Use
     * {@see Google\Cloud\LongRunning\LongRunningOperation::reload()} to get the
     * Operation state before retrieving the result.
     *
     * Example:
     * ```
     * $error = $operation->error();
     * ```
     *
     * @return array|null
     */
    public function error()
    {
        $this->info();
        return $this->error;
    }

    /**
     * Get the Operation info.
     *
     * If the Operation has not been checked previously, a service call will be
     * executed.
     *
     * Example:
     * ```
     * $info = $operation->info();
     * ```
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
     * Example:
     * ```
     * $operation->reload();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @param array $options Configuration Options.
     * @return array [google.longrunning.Operation](https://cloud.google.com/spanner/docs/reference/rpc/google.longrunning#google.longrunning.Operation)
     * @codingStandardsIgnoreEnd
     */
    public function reload(array $options = [])
    {
        $res = $this->connection->get([
            'name' => $this->name,
        ] + $options);

        if (isset($res['done']) && $res['done']) {
            $type = $res['metadata']['typeUrl'];
            $this->result = $this->executeDoneCallback($type, $res['response']);
            $this->error = (isset($res['error']))
                ? $res['error']
                : null;
        }

        return $this->info = $res;
    }

    /**
     * Reload the operation until it is complete.
     *
     * The return type of this method is dictated by the type of Operation. If
     * `$options.maxPollingDurationSeconds` is set, and the poll exceeds the
     * limit, the return will be `null`.
     *
     * Example:
     * ```
     * $result = $operation->pollUntilComplete();
     * ```
     *
     * @param array $options {
     *     Configuration Options
     *
     *     @type float $pollingIntervalSeconds The polling interval to use, in
     *           seconds. **Defaults to** `1.0`.
     *     @type float $maxPollingDurationSeconds The maximum amount of time to
     *           continue polling. **Defaults to** `0.0`.
     * }
     * @return mixed|null
     */
    public function pollUntilComplete(array $options = [])
    {
        $options += [
            'pollingIntervalSeconds' => $this::WAIT_INTERVAL,
            'maxPollingDurationSeconds' => 0.0,
        ];

        $pollingIntervalMicros = $options['pollingIntervalSeconds'] * 1000000;
        $maxPollingDuration = $options['maxPollingDurationSeconds'];
        $hasMaxPollingDuration = $maxPollingDuration > 0.0;
        $endTime = microtime(true) + $maxPollingDuration;

        do {
            usleep($pollingIntervalMicros);
            $this->reload($options);
        } while (!$this->done() && (!$hasMaxPollingDuration || microtime(true) < $endTime));

        return $this->result;
    }

    /**
     * Cancel a Long Running Operation.
     *
     * Example:
     * ```
     * $operation->cancel();
     * ```
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
     * Example:
     * ```
     * $operation->delete();
     * ```
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

    /**
     * When the Operation is complete, there may be a callback enqueued to
     * handle the response. If so, execute it and return the result.
     *
     * @param string $type The response type.
     * @param mixed $response The response data.
     * @return mixed
     */
    private function executeDoneCallback($type, $response)
    {
        if (is_null($response)) {
            return null;
        }

        $callables = array_filter($this->callablesMap, function ($callable) use ($type) {
            return $callable['typeUrl'] === $type;
        });

        if (count($callables) === 0) {
            return $response;
        }

        $callable = current($callables);
        $fn = $callable['callable'];

        return call_user_func($fn, $response);
    }

    /**
     * @access private
     */
    public function __debugInfo()
    {
        return [
            'connection' => get_class($this->connection),
            'name' => $this->name,
            'callablesMap' => array_keys($this->callablesMap)
        ];
    }
}
