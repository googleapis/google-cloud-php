<?php
/**
 * Copyright 2023 Google Inc. All Rights Reserved.
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

use Google\Cloud\Core\Exception;
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\PagedListResponse;
use Google\ApiCore\Serializer;
use Google\ApiCore\ServerStream;
use Google\Protobuf\Internal\Message;
use Google\Rpc\BadRequest;
use Google\Rpc\Code;
use Google\Rpc\RetryInfo;
use LogicException;

/**
 * The GapicRequestWrapper is responsible for delivering REST/gRPC requests.
 */
class GapicRequestWrapper
{
    use RequestWrapperTrait;
    /**
     * @var Serializer A serializer used to encode responses.
     */
    private $serializer;

    /**
     * @var array gRPC specific configuration options passed off to the ApiCore
     * library.
     */
    private $requestOptions;

    /**
     * @var array Map of error metadata types to RPC wrappers.
     */
    private $metadataTypes = [
        'google.rpc.retryinfo-bin' => RetryInfo::class,
        'google.rpc.badrequest-bin' => BadRequest::class
    ];

    /**
     * @param array $config [optional] {
     *     Configuration options. Please see
     *     {@see Google\Cloud\Core\RequestWrapperTrait::setCommonDefaults()} for
     *     the other available options.
     *
     *     @type Serializer $serializer A serializer used to encode responses.
     *     @type array $requestOptions Configuration options passed
     *           off to the ApiCore library.
     * }
     */
    public function __construct(array $config = [])
    {
        // @TODO: Do we need this?
        $this->setCommonDefaults($config);

        // convert retry params to general params here
        // @TODO: Do we need this?
        $config = $this->convertConfigParams($config);

        $this->serializer = $config['serializer'] ?? new Serializer;
        $this->requestOptions = $config['requestOptions'] ?? [];
    }

    /**
     * Deliver the request.
     *
     * @param callable $request The request to execute.
     * @param array $args The arguments for the request.
     * @param array $options [optional] {
     *     Request options.
     * }
     * @return array
     * @throws Exception\ServiceException
     */
    public function send(callable $request, array $args, array $options = [])
    {
        $requestOptions = $options['requestOptions'] ?? $this->requestOptions;

        $optionalArgs = &$args[count($args) - 1];
        $optionalArgs += $requestOptions;

        try {
            $response = call_user_func_array($request, $args);
            return $this->handleResponse($response);
        } catch (\Exception $ex) {
            if ($ex instanceof ApiException) {
                throw $this->convertToGoogleException($ex);
            }

            throw $ex;
        }
    }

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
    private function handleStream($response)
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
     * @return Exception\ServiceException
     */
    private function convertToGoogleException($ex)
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
        if ($ex->getMetadata()) {
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

    /**
     * Helper function that transforms some $config params to another.
     * 
     * @param array $config Input config params to be transformed.
     * @return array
     */
    private function convertConfigParams(array $config)
    {
        // We can either convert restOptions to requestOptions
        // or grpcOptions to requestOptions, if both are supplied,
        // then it's ambiguous so we throw an exception.
        if(isset($config['restOptions']) && isset($config['grpcOptions'])) {
            throw new LogicException("Can't set both restOptions and grpcOptions in the same request.");
        }

        $conversionMap = [
            'restOptions' => 'requestOptions',
            'grpcOptions' => 'requestOptions',
        ];

        foreach($conversionMap as $key => $replace) {
            if(isset($config[$key])) {
                $config[$replace] = $config[$key];
                unset($config[$key]);
            }
        }

        return $config;
    }
}
