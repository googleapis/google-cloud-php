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

use Google\ApiCore\Serializer;
use Google\Cloud\Core\RequestHandler;

/**
 * Manges a Long Running Operation.
 */
class LongRunningOperationManager
{
    use OperationResponseTrait;

    const WAIT_INTERVAL = 1.0;

    const STATE_IN_PROGRESS = 'inProgress';
    const STATE_SUCCESS = 'success';
    const STATE_ERROR = 'error';

    /**
     * @var RequestHandler
     */
    private RequestHandler $requestHandler;

    /**
     * @var Serializer
     */
    private Serializer $serializer;

    /**
     * @var string
     */
    private string $clientClass;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $info = [];

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
     * @var array
     */
    private $lroResponseMappers;

    /**
     * @param RequestHandler The request handler that is responsible for sending a request
     *        and serializing responses into relevant classes.
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param array $callablesMap An collection of form [(string) typeUrl, (callable) callable]
     *        providing a function to invoke when an operation completes. The
     *        callable Type should correspond to an expected value of
     *        operation.metadata.typeUrl.
     * @param array $lroResponseMappers A list of mappers for deserializing operation results.
     * @param string $clientClass The client class that will be passed on to the
     *        sendRequest method of the $requestHandler.
     * @param string $name The Operation name.
     * @param array $info [optional] The operation info.
     */
    public function __construct(
        RequestHandler $requestHandler,
        Serializer $serializer,
        array $callablesMap,
        array $lroResponseMappers,
        $name,
        string $clientClass,
        array $info = []
    ) {
        $this->serializer = $serializer;
        $this->requestHandler = $requestHandler;
        $this->callablesMap = $callablesMap;
        $this->lroResponseMappers = $lroResponseMappers;
        $this->clientClass = $clientClass;
        $this->name = $name;
        $this->info = $info;
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
     * If the Operation state is not available, a service request may be executed
     * by this method.
     *
     * Example:
     * ```
     * if ($operation->done()) {
     *     echo "The operation is done!";
     * }
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return bool
     */
    public function done(array $options = [])
    {
        return (isset($this->info($options)['done']))
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
     * If the Operation state is not available, a service request may be executed
     * by this method.
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
     * @param array $options [optional] Configuration options.
     * @return string
     */
    public function state(array $options = [])
    {
        if (!$this->done($options)) {
            return self::STATE_IN_PROGRESS;
        }

        if ($this->done() && $this->result()) {
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
     * If the Operation state is not available, a service request may be executed
     * by this method.
     *
     * Example:
     * ```
     * $result = $operation->result();
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return mixed|null
     */
    public function result(array $options = [])
    {
        $this->info($options);
        return $this->result;
    }

    /**
     * Get the Operation error.
     *
     * Returns null if the Operation is not yet complete, or if no error occurred.
     *
     * If the Operation state is not available, a service request may be executed
     * by this method.
     *
     * Example:
     * ```
     * $error = $operation->error();
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return array|null
     */
    public function error(array $options = [])
    {
        $this->info($options);
        return $this->error;
    }

    /**
     * Get the Operation info.
     *
     * If the Operation state is not available, a service request may be executed
     * by this method.
     *
     * Example:
     * ```
     * $info = $operation->info();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @param array $options [optional] Configuration options.
     * @return array [google.longrunning.Operation](https://cloud.google.com/spanner/docs/reference/rpc/google.longrunning#google.longrunning.Operation)
     * @codingStandardsIgnoreEnd
     */
    public function info(array $options = [])
    {
        return $this->info;
    }
}
