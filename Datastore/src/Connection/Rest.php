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

namespace Google\Cloud\Datastore\Connection;

use Google\Cloud\Core\EmulatorTrait;
use Google\Cloud\Core\RequestBuilder;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\RestTrait;
use Google\Cloud\Core\UriTrait;
use Google\Cloud\Datastore\DatastoreClient;

/**
 * Implementation of the
 * [Google Datastore JSON API](https://cloud.google.com/datastore/reference/rest/).
 *
 * @internal
 */
class Rest implements ConnectionInterface
{
    use EmulatorTrait;
    use RestTrait;
    use UriTrait;

    const BASE_URI = 'https://datastore.googleapis.com/';

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config += ['emulatorHost' => null];

        $baseUri = $this->getApiEndpoint(self::BASE_URI, $config);
        if ((bool) $config['emulatorHost']) {
            // @codeCoverageIgnoreStart
            $baseUri = $this->emulatorBaseUri($config['emulatorHost']);
            $config['shouldSignRequest'] = false;
            // @codeCoverageIgnoreEnd
        }

        $config += [
            'serviceDefinitionPath' => __DIR__ . '/ServiceDefinition/datastore-v1.json',
            'componentVersion' => DatastoreClient::VERSION
        ];

        $this->setRequestWrapper(new RequestWrapper($config));
        $this->setRequestBuilder(new RequestBuilder(
            $config['serviceDefinitionPath'],
            $baseUri
        ));
    }

    /**
     * @param array $args
     * @return array
     */
    public function allocateIds(array $args)
    {
        return $this->sendWithHeaders('projects', 'allocateIds', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function beginTransaction(array $args)
    {
        return $this->sendWithHeaders('projects', 'beginTransaction', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function commit(array $args)
    {
        return $this->sendWithHeaders('projects', 'commit', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function lookup(array $args)
    {
        return $this->sendWithHeaders('projects', 'lookup', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function rollback(array $args)
    {
        return $this->sendWithHeaders('projects', 'rollback', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function runQuery(array $args)
    {
        return $this->sendWithHeaders('projects', 'runQuery', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function runAggregationQuery(array $args)
    {
        if (isset($args['aggregationQuery']['aggregations'])) {
            foreach ($args['aggregationQuery']['aggregations'] as &$aggregation) {
                $aggregation = array_map(
                    fn ($item) => is_array($item) && count($item) === 0
                        ? new \stdClass
                        : $item,
                    $aggregation
                );
            }
        }
        return $this->sendWithHeaders('projects', 'runAggregationQuery', $args);
    }

    /**
     * Deliver the request built from serice definition.
     * Also apply the `x-goog-request-params` header to the request. This header
     * is required for operations involving a non-default databases.
     *
     * @param string $resource The resource type used for the request.
     * @param string $method The method used for the request.
     * @param array $args Options used to build out the request.
     */
    private function sendWithHeaders($resource, $method, $args)
    {
        if (isset($args['projectId']) && isset($args['databaseId'])) {
            $args['restOptions']['headers']['x-goog-request-params'] = sprintf(
                'project_id=%s&database_id=%s',
                $args['projectId'],
                $args['databaseId']
            );
        }

        return $this->send($resource, $method, $args);
    }
}
