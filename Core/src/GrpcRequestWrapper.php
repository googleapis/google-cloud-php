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

use Google\ApiCore\ApiException;
use Google\ApiCore\Serializer;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Rpc\Code;

/**
 * The GrpcRequestWrapper is responsible for delivering gRPC requests.
 */
class GrpcRequestWrapper
{
    use RequestWrapperTrait;
    use RequestProcessorTrait;

    /**
     * @var callable A handler used to deliver Psr7 requests specifically for
     * authentication.
     */
    private $authHttpHandler;

    /**
     * @var Serializer A serializer used to encode responses.
     */
    private $serializer;

    /**
     * @var array gRPC specific configuration options passed off to the ApiCore
     * library.
     */
    private $grpcOptions;

    /**
     * @var array gRPC retry codes.
     */
    private $grpcRetryCodes = [
        Code::UNKNOWN,
        Code::INTERNAL,
        Code::UNAVAILABLE,
        Code::DATA_LOSS
    ];

    /**
     * @param array $config [optional] {
     *     Configuration options. Please see
     *     {@see \Google\Cloud\Core\RequestWrapperTrait::setCommonDefaults()} for
     *     the other available options.
     *
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type Serializer $serializer A serializer used to encode responses.
     *     @type array $grpcOptions gRPC specific configuration options passed
     *           off to the ApiCore library.
     * }
     */
    public function __construct(array $config = [])
    {
        $this->setCommonDefaults($config);

        $config += [
            'authHttpHandler' => null,
            'serializer' => new Serializer(),
            'grpcOptions' => []
        ];

        $this->authHttpHandler = $config['authHttpHandler'] ?: HttpHandlerFactory::build();
        $this->serializer = $config['serializer'];
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
     *     @type callable $grpcRetryFunction Sets the conditions for whether or
     *           not a request should attempt to retry. Function signature should
     *           match: `function (\Exception $ex) : bool`.
     *     @type array $grpcOptions gRPC specific configuration options.
     * }
     * @return array
     * @throws Exception\ServiceException
     */
    public function send(callable $request, array $args, array $options = [])
    {
        $retries = $options['retries'] ?? $this->retries;
        $retryFunction = $options['grpcRetryFunction']
            ?? function (\Exception $ex) {
                $statusCode = $ex->getCode();
                return in_array($statusCode, $this->grpcRetryCodes);
            };
        $grpcOptions = $options['grpcOptions'] ?? $this->grpcOptions;
        $timeout = $options['requestTimeout'] ?? $this->requestTimeout;
        $backoff = new ExponentialBackoff($retries, $retryFunction);

        if (!isset($grpcOptions['retrySettings'])) {
            $retrySettings = [
                'retriesEnabled' => false
            ];
            if ($timeout) {
                $retrySettings['noRetriesRpcTimeoutMillis'] = $timeout * 1000;
            }
            $grpcOptions['retrySettings'] = $retrySettings;
        }

        $optionalArgs = &$args[count($args) - 1];
        $optionalArgs += $grpcOptions;

        try {
            return $this->handleResponse($backoff->execute($request, $args));
        } catch (\Exception $ex) {
            if ($ex instanceof ApiException) {
                throw $this->convertToGoogleException($ex);
            }

            throw $ex;
        }
    }
}
