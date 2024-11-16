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
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Core\RequestProcessorTrait;
use Google\LongRunning\Operation;
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

    private $larHeader = 'x-goog-spanner-route-to-leader';
    private $resourcePrefixHeader = 'google-cloud-resource-prefix';

    /**
     * Add the `x-goog-spanner-route-to-leader` header value to the request.
     *
     * @param array $args Request arguments.
     * @param bool $value LAR header value.
     * @param string $context Transaction context.
     * @return array
     */
    private function addLarHeader(
        array $args,
        bool $value = true,
        string $context = SessionPoolInterface::CONTEXT_READWRITE
    ) {
        if (!$value) {
            return $args;
        }
        // If value is true and context is READWRITE, set LAR header.
        if ($context === SessionPoolInterface::CONTEXT_READWRITE) {
            $args['headers'][$this->larHeader] = ['true'];
        }
        return $args;
    }

    /**
     * Add the `google-cloud-resource-prefix` header value to the request.
     *
     * @param array $args Request arguments.
     * @param string $value Resource prefix header value.
     * @return array
     */
    private function addResourcePrefixHeader(array $args, string $value)
    {
        $args['headers'][$this->resourcePrefixHeader] = [$value];
        return $args;
    }

    /**
     * Helper making list calls for long running operations.
     *
     *
     * @param callable $call The GAPIC client and method for the list operations request
     * @param Message $request The list operations request
     * @param array $callOptions [optional] Call options for the request
     * @param callable $operationResponseMapper [optional] A callable to map the Operation to an
     *        operation response. Defaults to `$this->resumeOperation()`.
     * @return ItemIterator<OperationResponse>
     */
    private function buildLongRunningIterator(
        callable $call,
        Message $request,
        array $callOptions = [],
        ?callable $operationResponseMapper = null
    ): ItemIterator {
        $resultLimit = $this->pluck('resultLimit', $callOptions, false) ?: 0;
        return new ItemIterator(
            new PageIterator(
                $operationResponseMapper ?: function (Operation $operation) {
                    return $this->resumeOperation(
                        $operation->getName(),
                        ['lastProtoResponse' => $operation]
                    );
                },
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
                }, [
                    'request' => $request,
                    'callOptions' => $callOptions
                ], [
                    'itemsKey' => 'operations',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }
}
