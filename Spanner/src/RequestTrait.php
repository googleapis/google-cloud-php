<?php
/**
 * Copyright 2024 Google Inc.
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

namespace Google\Cloud\Spanner;

use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\RequestProcessorTrait;
use Google\Protobuf\Internal\Message;

/**
 * Shared functionality for Spanner requests.
 *
 * @internal
 */
trait RequestTrait
{
    use ApiHelperTrait;
    use RequestProcessorTrait;

    /**
     * Helper making list calls for long running operations.
     *
     *
     * @param callable $call The GAPIC client and method for the list operations request
     * @param Message $request The list operations request
     * @param array $callOptions [optional] Call options for the request
     * @param callable $resultMapper [optional] A callable to map the Operation to an
     *        operation response. Defaults to `$this->resumeOperation()`.
     * @return ItemIterator<LongRunningOperation>
     */
    private function buildLongRunningIterator(
        callable $call,
        Message $request,
        array $callOptions,
        callable $resultMapper
    ): ItemIterator {
        $resultLimit = $this->pluck('resultLimit', $callOptions, false) ?: 0;
        return new ItemIterator(
            new PageIterator(
                $resultMapper,
                function (array $args) use ($call) {
                    if ($pageToken = $this->pluck('pageToken', $args, false) ?: null) {
                        $args['request']->setPageToken($pageToken);
                    }
                    try {
                        $page = $call($args['request'], $args['callOptions'])->getPage();
                    } catch (ApiException $e) {
                        throw $this->convertToGoogleException($e);
                    }
                    return [
                        'operations' => iterator_to_array($page->getResponseObject()->getOperations()),
                        'nextResultToken' => $page->getNextPageToken(),
                    ];
                },
                [
                    'request' => $request,
                    'callOptions' => $callOptions
                ],
                [
                    'itemsKey' => 'operations',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    private function buildListItemsIterator(
        callable $call,
        Message $request,
        array $callOptions,
        callable $resultMapper,
        string $itemsKey,
        ?int $resultLimit = null
    ) {
        return new ItemIterator(
            new PageIterator(
                $resultMapper,
                function ($args) use ($call) {
                    if ($pageToken = $this->pluck('pageToken', $args, false) ?: null) {
                        $args['request']->setPageToken($pageToken);
                    }
                    $response = $call($args['request'], $args['callOptions']);
                    return $this->handleResponse($response);
                },
                [
                    'request' => $request,
                    'callOptions' => $callOptions
                ],
                [
                    'itemsKey' => $itemsKey,
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    private function operationFromOperationResponse(
        OperationResponse $operation
    ): LongRunningOperation {
        if (!method_exists($this, 'resumeOperation')) {
            throw new \BadMethodCallException('This class must implement resumeOperation to call this method.');
        }
        return $this->resumeOperation(
            (string) $operation->getName(),
            $this->handleResponse($operation->getLastProtoResponse()) ?? []
        );
    }
}
