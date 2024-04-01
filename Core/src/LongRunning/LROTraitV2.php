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
# TODO: Point to the correct request class
use Google\LongRunning\ListOperationsRequest;

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
     * @var array
     */
    private $lroCallables;

    /**
     * @var string
     */
    private $lroResource;

    /**
     * @var string
     */
    private $clientClass;

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
     * @param string $clientClass The request will be forwarded to this client class.
     */
    private function setLroProperties(
        RequestHandler $requestHandler,
        Serializer $serializer,
        array $lroCallables,
        array $lroResponseMappers,
        string $lroResource = null,
        string $clientClass = null
    ) {
        $this->requestHandler = $requestHandler;
        $this->serializer = $serializer;
        $this->lroCallables = $lroCallables;
        $this->lroResponseMappers = $lroResponseMappers;
        $this->lroResource = $lroResource;
        $this->clientClass = $clientClass;
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
        if (is_null($this->lroResource) || is_null($this->clientClass)) {
            throw new \BadMethodCallException('This service does not support listing operations.');
        }
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $resultLimit = $this->pluck('resultLimit', $data, false) ?: 0;
        $data['name'] = $this->lroResource .'/operations';

        $client = $this->requestHandler->getClientObject($this->clientClass);
        $operationsClient = $client->getOperationsClient();
        if (is_null($client) || is_null($operationsClient)) {
            throw new \BadMethodCallException('This service does not support listing operations.');
        }
        $this->requestHandler->addClientObject(get_class($operationsClient), $operationsClient);
        $request = $this->serializer->decodeMessage(new ListOperationsRequest(), $data);

        return new ItemIterator(
            new PageIterator(
                function (array $operation) {
                    return $this->resumeOperation($operation['name'], $operation);
                },
                function ($callOptions) use ($optionalArgs, $request, $operationsClient) {
                    if (isset($callOptions['pageToken'])) {
                        $request->setPageToken($callOptions['pageToken']);
                    }

                    # TODO: Correct the usage of the operations client and its usage.
                    return $this->requestHandler->sendRequest(
                        get_class($operationsClient),
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
