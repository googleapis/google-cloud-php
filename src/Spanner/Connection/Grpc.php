<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Spanner\Connection;

use Google\Auth\CredentialsLoader;
use Google\Cloud\GrpcTrait;
use Google\Cloud\PhpArray;
use Google\Cloud\Spanner\V1\SpannerApi;

class Grpc implements ConnectionInterface
{
    use GrpcTrait;

    private $spannerApi;

    /**
     * @param array $config [optional]
     */
    public function __construct(array $config = [])
    {
        $grpcConfig = [
            'credentialsLoader' => CredentialsLoader::makeCredentials($config['scopes'], $config['keyFile'])
        ];

        $this->spannerApi = new SpannerApi($grpcConfig);
    }

    /**
     * @param array $args [optional]
     */
    public function createSession(array $args = [])
    {
        return $this->spannerApi->createSession(
            SpannerApi::formatDatabaseName($args['projectId'], $args['instance'], $args['database']),
            $this->filteredArgs($args)
        )->serialize(new PhpArray());
    }

    /**
     * @param array $args [optional]
     */
    public function getSession(array $args = [])
    {
        $sessionName = SpannerApi::formatSessionName(
            $args['projectId'],
            $args['instance'],
            $args['database'],
            $args['name']
        );

        return $this->spannerApi->getSession(
            $sessionName,
            $this->filteredArgs($args)
        )->serialize(new PhpArray());
    }

    /**
     * @param array $args [optional]
     */
    public function deleteSession(array $args = [])
    {
        $sessionName = SpannerApi::formatSessionName(
            $args['projectId'],
            $args['instance'],
            $args['database'],
            $args['name']
        );

        return $this->spannerApi->deleteSession(
            $sessionName,
            $this->filteredArgs($args)
        )->serialize(new PhpArray());
    }

    /**
     * @param array $args [optional]
     */
    public function executeSql(array $args = [])
    {}

    /**
     * @param array $args [optional]
     */
    public function read(array $args = [])
    {}

    /**
     * @param array $args [optional]
     */
    public function beginTransaction(array $args = [])
    {}

    /**
     * @param array $args [optional]
     */
    public function commit(array $args = [])
    {}

    /**
     * @param array $args [optional]
     */
    public function rollback(array $args = [])
    {}
}
