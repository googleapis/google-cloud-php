<?php
/**
 * Copyright 2025 Google Inc.
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

use Google\ApiCore\OperationResponse;
use Google\ApiCore\Serializer;
use Google\Cloud\Core\RequestProcessorTrait;
use Google\LongRunning\ListOperationsRequest;
use Google\Protobuf\Any;

/**
 * Defines the calls required to manage Long Running Operations using a GAPIC
 * generated client.
 *
 * @internal
 */
class LongRunningClientConnection implements LongRunningConnectionInterface
{
    use RequestProcessorTrait;

    public function __construct(
        private object $gapicClient,
        private Serializer $serializer
    ) {
    }

    /**
     * @param array $args
     * @return array
     */
    public function get(array $args): array
    {
        $operationResponse = $this->gapicClient->resumeOperation($args['name']);

        return $this->operationResponseToArray($operationResponse);
    }

    /**
     * @param array $args
     * @return array
     */
    public function cancel(array $args): array
    {
        $operationResponse = $this->gapicClient->resumeOperation(
            $args['name'],
            $args['method'] ?? null
        );
        $operationResponse->cancel();

        return $this->operationResponseToArray($operationResponse);
    }

    /**
     * @param array $args
     * @return array
     */
    public function delete(array $args): array
    {
        $operationResponse = $this->gapicClient->resumeOperation(
            $args['name'],
            $args['method'] ?? null
        );
        $operationResponse->cancel();

        return $this->operationResponseToArray($operationResponse);
    }

    /**
     * @param array $args
     * @return array
     */
    public function operations(array $args): array
    {
        $request = ListOperationsRequest::build($args['name'], $args['filter'] ?? null);
        $response = $this->gapicClient->getOperationsClient()->listOperations($request);

        return $this->handleResponse($response);
    }

    private function operationResponseToArray(OperationResponse $operationResponse): array
    {
        $response = $this->handleResponse($operationResponse->getLastProtoResponse());
        $metaType = $response['metadata']['typeUrl'];

        // unpack result Any type
        $result = $operationResponse->getResult();
        if ($result instanceof Any) {
            // For some reason we aren't doing this in GAX OperationResponse (but we should)
            $result = $result->unpack();
        }
        $response['response'] = $this->handleResponse($result);

        // unpack error Any type
        $response['error'] = $this->handleResponse($operationResponse->getError());

        $metadata = $operationResponse->getMetadata();
        if ($metadata instanceof Any) {
            // For some reason we aren't doing this in GAX OperationResponse (but we should)
            $metadata = $metadata->unpack();
        }
        $response['metadata'] = $this->handleResponse($metadata);

        // Used in LongRunningOperation to invoke callables
        $response['metadata'] += ['typeUrl' => $metaType];

        return $response;
    }
}
