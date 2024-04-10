<?php
/**
 * Copyright 2024 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Core;

use Google\ApiCore\ServerStream;
use Google\Rpc\Code;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Core\Exception\ServiceException;
use Google\ApiCore\OperationResponse;
use \Google\Protobuf\Internal\Message;
use Google\Rpc\RetryInfo;
use Google\Rpc\BadRequest;

/**
 * @internal
 * Encapsulates shared functionality of classes that need to send
 * and process requests and responses.
 */
trait RequestProcessorTrait
{
    /**
     * @var array Map of error metadata types to RPC wrappers.
     */
    private $metadataTypes = [
        'google.rpc.retryinfo-bin' => RetryInfo::class,
        'google.rpc.badrequest-bin' => BadRequest::class
    ];

    /**
     * Serializes a gRPC response.
     *
     * @param mixed $response
     * @return \Generator|OperationResponse|array|null
     */
    private function handleResponse($response)
    {
        if ($response instanceof PagedListResponse) {
            $response = $response->getPage()->getResponseObject();
        }

        if ($response instanceof Message) {
            return $this->serializer->encodeMessage($response);
        }

        if ($response instanceof OperationResponse) {
            return $response;
        }

        if ($response instanceof ServerStream) {
            return $this->handleStream($response);
        }

        return null;
    }

    /**
     * Handles a streaming response.
     *
     * @param ServerStream $response
     * @return \Generator|array|null
     * @throws Exception\ServiceException
     */
    private function handleStream(ServerStream $response)
    {
        try {
            foreach ($response->readAll() as $count => $result) {
                $res = $this->serializer->encodeMessage($result);
                yield $res;
            }
        } catch (\Exception $ex) {
            throw $this->convertToGoogleException($ex);
        }
    }

    /**
     * Convert a ApiCore exception to a Google Exception.
     *
     * @param \Exception $ex
     * @return ServiceException
     */
    private function convertToGoogleException(\Exception $ex): ServiceException
    {
        switch ($ex->getCode()) {
            case Code::INVALID_ARGUMENT:
                $exception = Exception\BadRequestException::class;
                break;

            case Code::NOT_FOUND:
            case Code::UNIMPLEMENTED:
                $exception = Exception\NotFoundException::class;
                break;

            case Code::ALREADY_EXISTS:
                $exception = Exception\ConflictException::class;
                break;

            case Code::FAILED_PRECONDITION:
                $exception = Exception\FailedPreconditionException::class;
                break;

            case Code::UNKNOWN:
                $exception = Exception\ServerException::class;
                break;

            case Code::INTERNAL:
                $exception = Exception\ServerException::class;
                break;

            case Code::ABORTED:
                $exception = Exception\AbortedException::class;
                break;

            case Code::DEADLINE_EXCEEDED:
                $exception = Exception\DeadlineExceededException::class;
                break;

            default:
                $exception = Exception\ServiceException::class;
                break;
        }

        $metadata = [];
        if (method_exists($ex, 'getMetadata') && $ex->getMetadata()) {
            foreach ($ex->getMetadata() as $type => $binaryValue) {
                if (!isset($this->metadataTypes[$type])) {
                    continue;
                }
                $metadataElement = new $this->metadataTypes[$type];
                $metadataElement->mergeFromString($binaryValue[0]);
                $metadata[] = $this->serializer->encodeMessage($metadataElement);
            }
        }

        return new $exception($ex->getMessage(), $ex->getCode(), $ex, $metadata);
    }
}
