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
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Core\RequestHandler;
use Google\LongRunning\ListOperationsRequest;
use Google\LongRunning\OperationsGrpcClient;

/**
 * Provide Long Running Operation support to Google Cloud PHP Clients.
 *
 * This trait should be used by a user-facing client which implements LRO.
 */
trait LROTraitV2
{
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
    private $clientClass;

    /**
     * @var array
     */
    private $lroCallables;

    /**
     * @var string
     */
    private $lroResource;

    /**
     * Populate required LRO properties.
     *
     * @param RequestHandler The request handler that is responsible for sending a request
     *        and serializing responses into relevant classes.
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param array $callablesMap An collection of form [(string) typeUrl, (callable) callable]
     *        providing a function to invoke when an operation completes. The
     *        callable Type should correspond to an expected value of
     *        operation.metadata.typeUrl.
     * @param array $lroResponseMappers A list of mappers for deserializing operation results.
     * @param string $lroResource [optional] The resource for which operations
     *        may be listed.
     */
    private function setLroProperties(
        RequestHandler $requestHandler,
        Serializer $serializer,
        string $clientClass,
        array $lroCallables,
        array $lroResponseMappers,
        $resource = null
    ) {
        $this->requestHandler = $requestHandler;
        $this->serializer = $serializer;
        $this->clientClass = $clientClass;
        $this->lroCallables = $lroCallables;
        $this->lroResponseMappers = $lroResponseMappers;
        $this->lroResource = $resource;
    }

    /**
     * Resume a Long Running Operation
     *
     * @param string $operationName The Long Running Operation name.
     * @param array $lroResponseMappers A list of mappers for deserializing operation results.
     * @param array $info [optional] The operation data.
     * @return LongRunningOperationManger
     */
    public function resumeOperation($operationName, array $info = [])
    {
        return new LongRunningOperationManager(
            $this->requestHandler,
            $this->serializer,
            $this->lroCallables,
            $this->lroResponseMappers,
            $this->clientClass,
            $operationName,
            $info
        );
    }

    /**
     * List long running operations.
     *
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $name The name of the operation collection.
     *     @type string $filter The standard list filter.
     *     @type int $pageSize Maximum number of results to return per
     *           request.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<LongRunningOperation>
     */
    public function longRunningOperations(array $options = [])
    {
        if (is_null($this->lroResource)) {
            throw new \BadMethodCallException('This service does not support listing operations.');
        }
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $resultLimit = $this->pluck('resultLimit', $data, false) ?: 0;
        $data['name'] = $this->lroResource .'/operations';

        $request = $this->serializer->decodeMessage(new ListOperationsRequest(), $data);

        return new ItemIterator(
            new PageIterator(
                function (array $operation) {
                    return $this->resumeOperation($operation['name'], $operation);
                },
                function ($callOptions) use ($optionalArgs, $request) {
                    if (isset($callOptions['pageToken'])) {
                        $request->setPageToken($callOptions['pageToken']);
                    }

                    return $this->requestHandler->sendRequest(
                        OperationsGrpcClient::class,
                        'listOperations',
                        $request,
                        $optionalArgs
                    );
                },
                $options,
                [
                    'itemsKey' => 'operations',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }
}
