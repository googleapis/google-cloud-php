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

namespace Google\Cloud;

use Google\Cloud\UriTrait;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

/**
 * Builds a PSR7 request from a service definition.
 */
class RequestBuilder
{
    use UriTrait;

    /**
     * @var string
     */
    private $servicePath;

    /**
     * @var string
     */
    private $baseUri;

    /**
     * @param string $servicePath
     * @param string $baseUri
     */
    public function __construct($servicePath, $baseUri)
    {
        $this->service = $this->loadServiceDefinition($servicePath);
        $this->baseUri = $baseUri;
    }

    /**
     * Build the request.
     *
     * @param string $resource
     * @param string $method
     * @param array $options
     * @return RequestInterface
     * @todo complexity high, revisit
     * @todo consider validating against the schemas
     */
    public function build($resource, $method, array $options = [])
    {
        if (!isset($this->service['resources'][$resource]['methods'][$method])) {
            throw new \InvalidArgumentException('Provided action ' . $method . ' does not exist.');
        }

        $action = $this->service['resources'][$resource]['methods'][$method];
        $path = [];
        $query = [];
        $body = [];

        foreach ($action['parameters'] as $parameter => $parameterOptions) {
            if ($parameterOptions['location'] === 'path' && array_key_exists($parameter, $options)) {
                $path[$parameter] = $options[$parameter];
            }

            if ($parameterOptions['location'] === 'query' && array_key_exists($parameter, $options)) {
                $query[$parameter] = $options[$parameter];
            }
        }

        if (isset($action['request'])) {
            $schema = $action['request']['$ref'];

            foreach ($this->service['schemas'][$schema]['properties'] as $property => $propertyOptions) {
                if (array_key_exists($property, $options)) {
                    $body[$property] = $options[$property];
                }
            }
        }

        $uri = $this->buildUriWithQuery(
            $this->expandUri($this->baseUri . $action['path'], $path),
            $query
        );

        return new Request(
            $action['httpMethod'],
            $uri,
            ['Content-Type' => 'application/json'],
            $body ? json_encode($body) : []
        );
    }

    /**
     * @param string $servicePath
     * @return array
     */
    private function loadServiceDefinition($servicePath)
    {
        return json_decode(
            file_get_contents($servicePath, true),
            true
        );
    }
}
