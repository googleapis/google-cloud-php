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

namespace Google\Cloud;

use DrSlump\Protobuf\Message;
use Google\Auth\FetchAuthTokenInterface;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Cloud\Exception;
use Google\Cloud\PhpArray;
use Google\Cloud\RequestWrapperTrait;
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
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type FetchAuthTokenInterface $credentialsFetcher A credentials
     *           fetcher instance.
     *     @type string $keyFile The contents of the service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type array $grpcOptions gRPC specific configuration options passed
     *           off to the GAX library.
     *     @type int $retries Number of retries for a failed request.
     *           **Defaults to** `3`.
     *     @type array $scopes Scopes to be used for the request.
     * }
     */
    public function __construct(array $config = [])
    {
        $this->setCommonDefaults($config);
        $config += [
            'authHttpHandler' => null,
            'grpcOptions' => []
        ];

        $this->authHttpHandler = $config['authHttpHandler'] ?: HttpHandlerFactory::build();
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
     * @return array
     */
    private function handleResponse($response)
    {
        if ($response instanceof PagedListResponse) {
            return $response->getPage()
                ->getResponseObject()
                ->serialize(new PhpArray());
        }

        if ($response instanceof Message) {
            return $response->serialize(new PhpArray());
        }

        return [];
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
