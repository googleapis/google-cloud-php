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

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Exception\ServiceException;
use UnexpectedValueException;

/**
 * Provides shared functionality for REST service implementations.
 */
trait RestTrait
{
    use ArrayTrait;
    use JsonTrait;
    use WhitelistTrait;

    /**
     * @var RequestBuilder Builds PSR7 requests from a service definition.
     */
    private $requestBuilder;

    /**
     * @var RequestWrapper Wrapper used to handle sending requests to the
     * JSON API.
     */
    private $requestWrapper;

    /**
     * Sets the request builder.
     *
     * @param RequestBuilder $requestBuilder Builds PSR7 requests from a service
     *        definition.
     */
    public function setRequestBuilder(RequestBuilder $requestBuilder)
    {
        $this->requestBuilder = $requestBuilder;
    }

    /**
     * Sets the request wrapper.
     *
     * @param RequestWrapper $requestWrapper Wrapper used to handle sending
     *        requests to the JSON API.
     */
    public function setRequestWrapper(RequestWrapper $requestWrapper)
    {
        $this->requestWrapper = $requestWrapper;
    }

    /**
     * Get the RequestWrapper.
     *
     * @return RequestWrapper|null
     */
    public function requestWrapper()
    {
        return $this->requestWrapper;
    }

    /**
     * Delivers a request built from the service definition.
     *
     * @param string $resource The resource type used for the request.
     * @param string $method The method used for the request.
     * @param array $options [optional] Options used to build out the request.
     * @param array $whitelisted [optional]
     * @return array
     * @throws ServiceException
     */
    public function send($resource, $method, array $options = [], $whitelisted = false)
    {
        $options += [
            'prettyPrint' => false,
        ];
        $requestOptions = $this->pluckArray([
            'restOptions',
            'retries',
            'retryHeaders',
            'requestTimeout',
            'restRetryFunction',
            'restRetryListener',
            'restDelayFunction',
            'restCalcDelayFunction',
        ], $options);

        try {
            return json_decode(
                $this->requestWrapper->send(
                    $this->requestBuilder->build($resource, $method, $options),
                    $requestOptions
                )->getBody(),
                true
            );
        } catch (NotFoundException $e) {
            if ($whitelisted) {
                throw $this->modifyWhitelistedError($e);
            }

            throw $e;
        }
    }

    /**
     * Return a custom API endpoint in the proper format, or default if none provided.
     *
     * @param string $default
     * @param array $config
     * @param string $apiEndpointTemplate
     * @return string
     */
    private function getApiEndpoint($default, array $config, ?string $apiEndpointTemplate = null)
    {
        // If the $default parameter is provided, or the user has set an "apiEndoint" config option,
        // fall back to the previous behavior.
        if ($res = $config['apiEndpoint'] ?? $default) {
            if (substr($res, -1) !== '/') {
                $res = $res . '/';
            }

            if (strpos($res, '//') === false) {
                $res = 'https://' . $res;
            }

            return $res;
        }

        // One of the $default or the $template must always be set
        if (!$apiEndpointTemplate) {
            throw new UnexpectedValueException(
                'An API endpoint template must be provided if no "apiEndpoint" or default endpoint is set.'
            );
        }

        if (!isset($config['universeDomain'])) {
            throw new UnexpectedValueException(
                'The "universeDomain" config value must be set to use the default API endpoint template.'
            );
        }

        $apiEndpoint = str_replace(
            'UNIVERSE_DOMAIN',
            $config['universeDomain'],
            $apiEndpointTemplate
        );

        // Preserve the behavior of guaranteeing a trailing "/"
        return $apiEndpoint . (substr($apiEndpoint, -1) !== '/' ? '/' : '');
    }
}
