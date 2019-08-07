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

namespace Google\Cloud\Logging\Connection;

use Google\Cloud\Core\RequestBuilder;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\RestTrait;
use Google\Cloud\Core\UriTrait;
use Google\Cloud\Logging\LoggingClient;

/**
 * Implementation of the
 * [Google Stackdriver Logging JSON API](https://cloud.google.com/logging/docs/api/reference/rest/).
 */
class Rest implements ConnectionInterface
{
    use RestTrait;
    use UriTrait;

    const BASE_URI = 'https://logging.googleapis.com/';

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config += [
            'serviceDefinitionPath' => __DIR__ . '/ServiceDefinition/logging-v2.json',
            'componentVersion' => LoggingClient::VERSION
        ];

        $this->setRequestWrapper(new RequestWrapper($config));
        $this->setRequestBuilder(new RequestBuilder(
            $config['serviceDefinitionPath'],
            $this->getApiEndpoint(self::BASE_URI, $config)
        ));
    }

    /**
     * @param array $args
     * @return array
     */
    public function writeEntries(array $args = [])
    {
        return $this->send('entries', 'write', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function listEntries(array $args = [])
    {
        return $this->send('entries', 'list', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function createSink(array $args = [])
    {
        return $this->send('projects.resources.sinks', 'create', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function getSink(array $args = [])
    {
        return $this->send('projects.resources.sinks', 'get', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function listSinks(array $args = [])
    {
        return $this->send('projects.resources.sinks', 'list', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function updateSink(array $args = [])
    {
        return $this->send('projects.resources.sinks', 'update', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function deleteSink(array $args = [])
    {
        return $this->send('projects.resources.sinks', 'delete', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function createMetric(array $args = [])
    {
        return $this->send('projects.resources.metrics', 'create', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function getMetric(array $args = [])
    {
        return $this->send('projects.resources.metrics', 'get', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function listMetrics(array $args = [])
    {
        return $this->send('projects.resources.metrics', 'list', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function updateMetric(array $args = [])
    {
        return $this->send('projects.resources.metrics', 'update', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function deleteMetric(array $args = [])
    {
        return $this->send('projects.resources.metrics', 'delete', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function deleteLog(array $args = [])
    {
        return $this->send('projects.resources.logs', 'delete', $args);
    }
}
