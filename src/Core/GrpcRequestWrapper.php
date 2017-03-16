<?php
/**
 * Copyright 2015 Google Inc. All Rights Reserved.
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

use DrSlump\Protobuf\Codec\CodecInterface;
use DrSlump\Protobuf\Message;
use Google\Auth\FetchAuthTokenInterface;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Cloud\Core\Exception;
use Google\Cloud\Core\PhpArray;
use Google\Cloud\Core\RequestWrapperTrait;
use Google\GAX\ApiException;
use Google\GAX\PagedListResponse;
use Google\GAX\RetrySettings;
use Grpc;

/**
 * The GrpcRequestWrapper is responsible for delivering gRPC requests.
 */
class GrpcRequestWrapper
{
    use RequestWrapperTrait;

    /**
     * @var callable A handler used to deliver Psr7 requests specifically for
     * authentication.
     */
    private $authHttpHandler;

    /**
     * @var CodecInterface A codec used to encode responses.
     */
    private $codec;

    /**
     * @var array gRPC specific configuration options passed off to the GAX
     * library.
     */
    private $grpcOptions;

    /**
     * @var array gRPC retry codes.
     */
    private $grpcRetryCodes = [
        Grpc\STATUS_UNKNOWN,
        Grpc\STATUS_INTERNAL,
        Grpc\STATUS_UNAVAILABLE,
        Grpc\STATUS_DATA_LOSS
    ];

    /**
     * @param array $config [optional] {
     *     Configuration options. Please see
     *     {@see Google\Cloud\Core\RequestWrapperTrait::setCommonDefaults()} for
     *     the other available options.
     *
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type CodecInterface $codec A codec used to encode responses.
     *     @type array $grpcOptions gRPC specific configuration options passed
     *           off to the GAX library.
     * }
     */
    public function __construct(array $config = [])
    {
        $this->setCommonDefaults($config);
        $config += [
            'authHttpHandler' => null,
            'codec' => new PhpArray(),
            'grpcOptions' => []
        ];

        $this->authHttpHandler = $config['authHttpHandler'] ?: HttpHandlerFactory::build();
        $this->codec = $config['codec'];
        $this->grpcOptions = $config['grpcOptions'];
    }

    /**
     * Deliver the request.
     *
     * @param callable $request The request to execute.
     * @param array $args The arguments for the request.
     * @param array $options [optional] {
     *     Request options.
     *
     *     @type float $requestTimeout Seconds to wait before timing out the
     *           request. **Defaults to** `60`.
     *     @type int $retries Number of retries for a failed request.
     *           **Defaults to** `3`.
     *     @type array $grpcOptions gRPC specific configuration options.
     * }
     * @return array
     */
    public function send(callable $request, array $args, array $options = [])
    {
        $retries = isset($options['retries']) ? $options['retries'] : $this->retries;
        $grpcOptions = isset($options['grpcOptions']) ? $options['grpcOptions'] : $this->grpcOptions;
        $timeout = isset($options['requestTimeout']) ? $options['requestTimeout'] : $this->requestTimeout;
        $backoff = new ExponentialBackoff($retries, function (\Exception $ex) {
            $statusCode = $ex->getCode();

            if (in_array($statusCode, $this->grpcRetryCodes)) {
                return true;
            }

            return false;
        });

        if (!isset($grpcOptions['retrySettings'])) {
            $grpcOptions['retrySettings'] = new RetrySettings(null, null);
        }

        if ($timeout && !array_key_exists('timeoutMs', $grpcOptions)) {
            $grpcOptions['timeoutMs'] = $timeout * 1000;
        }

        $optionalArgs = &$args[count($args) - 1];
        $optionalArgs += $grpcOptions;

        try {
            return $this->handleResponse($backoff->execute($request, $args));
        } catch (\Exception $ex) {
            throw $this->convertToGoogleException($ex);
        }
    }

    /**
     * Serializes a gRPC response.
     *
     * @param mixed $response
     * @return array|null
     */
    private function handleResponse($response)
    {
        if ($response instanceof PagedListResponse) {
            $response = $response->getPage()->getResponseObject();
        }

        if ($response instanceof Message) {
            return $response->serialize($this->codec);
        }

        return null;
    }

    /**
     * Convert a GAX exception to a Google Exception.
     *
     * @param ApiException $ex
     * @return ServiceException
     */
    private function convertToGoogleException(ApiException $ex)
    {
        switch ($ex->getCode()) {
            case Grpc\STATUS_INVALID_ARGUMENT:
                $exception = Exception\BadRequestException::class;
                break;

            case Grpc\STATUS_NOT_FOUND:
                $exception = Exception\NotFoundException::class;
                break;

            case Grpc\STATUS_ALREADY_EXISTS:
                $exception = Exception\ConflictException::class;
                break;

            case Grpc\STATUS_UNKNOWN:
                $exception = Exception\ServerException::class;
                break;

            case Grpc\STATUS_INTERNAL:
                $exception = Exception\ServerException::class;
                break;

            default:
                $exception = Exception\ServiceException::class;
                break;
        }

        return new $exception($ex->getMessage(), $ex->getCode(), $ex);
    }
}
