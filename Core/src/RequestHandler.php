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

use Google\ApiCore\Serializer;
use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Core\WhitelistTrait;
use \Google\Protobuf\Internal\Message;
use Google\ApiCore\ServerStream;
use Google\Rpc\BadRequest;
use Google\Rpc\Code;
use Google\Rpc\RetryInfo;
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\PagedListResponse;

/**
 * @internal
 * Responsible for forwarding the requests to their
 * respective client methdos via the request wrapper.
 */
class RequestHandler
{
    use EmulatorTrait;
    use ArrayTrait;
    use TimeTrait;
    use WhitelistTrait;

    /**
     * @var Serializer
     */
    private Serializer $serializer;

    /**
     * @var array Map of error metadata types to RPC wrappers.
     */
    private array $metadataTypes = [
        'google.rpc.retryinfo-bin' => RetryInfo::class,
        'google.rpc.badrequest-bin' => BadRequest::class
    ];

    private array $clients;

    /**
     * @param Serializer $serializer
     * @param array $clientClasses
     * @param array $clientConfig
     */
    public function __construct(
        Serializer $serializer,
        array $clientClasses,
        array $clientConfig = []
    ) {
        //@codeCoverageIgnoreStart
        $this->serializer = $serializer;
        $clientConfig['serializer'] = $serializer;

        // Adds some defaults
        // gccl needs to be present for handwritten clients
        $clientConfig += [
            'libName' => 'gccl',
            'transport' => $this->getDefaultTransport(),
            'emulatorHost' => null
        ];

        if ((bool) $clientConfig['emulatorHost']) {
            $emulatorConfig = $this->emulatorGapicConfig($clientConfig['emulatorHost']);
            $clientConfig = array_merge(
                $clientConfig,
                $emulatorConfig
            );
        }
        //@codeCoverageIgnoreEnd
        
        // Initialize the client classes and store them in memory
        $this->clients = [];
        foreach ($clientClasses as $className) {
            $this->clients[$className] = new $className($clientConfig);
        }
    }

    /**
     * Helper function that forwards the request to a client obj.
     *
     * @param string $clientClass The request will be forwarded to this client class.
     * @param string $method This method needs to be called on the client obj.
     * @param Message $request The protobuf Request instance to pass as the first argument to the $method.
     * @param array $optionalArgs The optional args.
     * @param bool $whitelisted This decides the behaviour when a NotFoundException is encountered.
     *
     * @return \Generator|OperationResponse|array|null
     *
     * @throws ServiceException
     */
    public function sendRequest(
        string $clientClass,
        string $method,
        Message $request,
        array $optionalArgs,
        bool $whitelisted = false
    ) {
        $clientObj = $this->getClientObject($clientClass);

        if (!$clientObj) {
            return null;
        }

        $allArgs = [$request];
        $allArgs[] = $optionalArgs;

        try {
            $callable = [$clientObj, $method];
            $response = call_user_func_array($callable, $allArgs);

            return $this->handleResponse($response);
        } catch (ApiException $ex) {
            throw $this->convertToGoogleException($ex);
        } catch (NotFoundException $e) {
            if ($whitelisted) {
                throw $this->modifyWhitelistedError($e);
            }

            throw $e;
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

    /**
     * Helper function that returns a client object stored in memory
     * using the client class as key.
     * @param $clientClass The client class whose object we need.
     * @return mixed
     */
    private function getClientObject(string $clientClass)
    {
        return $this->clients[$clientClass] ?? null;
    }

    private function getDefaultTransport() : string
    {
        $isGrpcExtensionLoaded = $this->isGrpcLoaded();
        $defaultTransport = $isGrpcExtensionLoaded ? 'grpc' : 'rest';
        return $defaultTransport;
    }

    private function isGrpcLoaded() : bool
    {
        return extension_loaded('grpc');
    }
}
