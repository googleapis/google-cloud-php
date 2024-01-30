<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

use Google\Auth\GetUniverseDomainInterface;
use Google\ApiCore\CredentialsWrapper;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\GrpcRequestWrapper;

/**
 * Provides shared functionality for gRPC service implementations.
 */
trait GrpcTrait
{
    use WhitelistTrait;
    use ApiHelperTrait;

    /**
     * @var GrpcRequestWrapper Wrapper used to handle sending requests to the
     * gRPC API.
     */
    private $requestWrapper;

    /**
     * Sets the request wrapper.
     *
     * @param GrpcRequestWrapper $requestWrapper
     */
    public function setRequestWrapper(GrpcRequestWrapper $requestWrapper)
    {
        $this->requestWrapper = $requestWrapper;
    }

    /**
     * Get the GrpcRequestWrapper.
     *
     * @return GrpcRequestWrapper|null
     */
    public function requestWrapper()
    {
        return $this->requestWrapper;
    }

    /**
     * Delivers a request.
     *
     * @param callable $request
     * @param array $args
     * @param bool $whitelisted
     * @return \Generator|array
     * @throws ServiceException
     */
    public function send(callable $request, array $args, $whitelisted = false)
    {
        $requestOptions = $this->pluckArray([
            'grpcOptions',
            'retries',
            'requestTimeout',
            'grpcRetryFunction'
        ], $args[count($args) - 1]);

        try {
            return $this->requestWrapper->send($request, $args, $requestOptions);
        } catch (NotFoundException $e) {
            if ($whitelisted) {
                throw $this->modifyWhitelistedError($e);
            }

            throw $e;
        }
    }

    /**
     * Gets the default configuration for generated clients.
     *
     * @param string $version
     * @param callable|null $authHttpHandler
     * @param string|null $universeDomain
     * @return array
     */
    private function getGaxConfig(
        $version,
        callable $authHttpHandler = null,
        string $universeDomain = null
    ) {
        $config = [
            'libName' => 'gccl',
            'libVersion' => $version,
            'transport' => 'grpc'
        ];

        // GAX v0.32.0 introduced the CredentialsWrapper class and a different
        // way to configure credentials. If the class exists, use this new method
        // otherwise default to legacy usage.
        if (class_exists(CredentialsWrapper::class)) {
            $config['credentials'] = new CredentialsWrapper(
                $this->requestWrapper->getCredentialsFetcher(),
                $authHttpHandler,
                $universeDomain ?: GetUniverseDomainInterface::DEFAULT_UNIVERSE_DOMAIN
            );
        } else {
            $config += [
                'credentialsLoader' => $this->requestWrapper->getCredentialsFetcher(),
                'authHttpHandler' => $authHttpHandler,
                'enableCaching' => false
            ];
        }

        return $config;
    }
}
