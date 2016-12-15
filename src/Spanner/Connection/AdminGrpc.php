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
use Google\Cloud\GrpcRequestWrapper;
use Google\Cloud\GrpcTrait;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminApi;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminApi;
use Google\GAX\ApiException;
use google\spanner\admin\instance\v1\State;

class AdminGrpc implements AdminConnectionInterface
{
    use GrpcTrait;

    private $instanceAdminApi;

    private $databaseAdminApi;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $grpcConfig = [
            'credentialsLoader' => CredentialsLoader::makeCredentials($config['scopes'], $config['keyFile'])
        ];

        $this->wrapper = new GrpcRequestWrapper;

        $this->instanceAdminApi = new InstanceAdminApi($grpcConfig);
        $this->databaseAdminApi = new DatabaseAdminApi($grpcConfig);
    }

    /**
     * @param array $args [optional]
     */
    public function listConfigs(array $args = [])
    {
        return $this->send([$this->instanceAdminApi, 'listInstanceConfigs'], [
            $args['projectId'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function getConfig(array $args = [])
    {
        return $this->send([$this->instanceAdminApi, 'getInstanceConfig'], [
            $args['name'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function listInstances(array $args = [])
    {
        return $this->send([$this->instanceAdminApi, 'listInstances'], [
            InstanceAdminApi::formatProjectName($args['projectId']),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function getInstance(array $args = [])
    {
        return $this->send([$this->instanceAdminApi, 'getInstance'], [
            $args['name'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function createInstance(array $args = [])
    {
        return $this->send([$this->instanceAdminApi, 'createInstance'], [
            $args['name'],
            $args['config'],
            $args['displayName'],
            $args['nodeCount'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function updateInstance(array $args = [])
    {
        return $this->send([$this->instanceAdminApi, 'updateInstance'], [
            $args['name'],
            $args['config'],
            $args['displayName'],
            $args['nodeCount'],
            new State,
            $args['labels'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function deleteInstance(array $args = [])
    {
        return $this->send([$this->instanceAdminApi, 'deleteInstance'], [
            $args['name'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function getInstanceIamPolicy(array $args = [])
    {
        return $this->send([$this->instanceAdminApi, 'getIamPolicy'], [
            $args['resource'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function setInstanceIamPolicy(array $args = [])
    {
        return $this->send([$this->instanceAdminApi, 'setIamPolicy'], [
            $args['resource'],
            $args['policy'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function testInstanceIamPermissions(array $args = [])
    {
        return $this->send([$this->instanceAdminApi, 'testIamPermissions'], [
            $args['resource'],
            $args['permissions'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function listDatabases(array $args = [])
    {
        return $this->send([$this->databaseAdminApi, 'listDatabases'], [
            $args['instance'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function createDatabase(array $args = [])
    {
        return $this->send([$this->databaseAdminApi, 'createDatabase'], [
            $args['instance'],
            $args['createStatement'],
            $args['extraStatements'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function updateDatabase(array $args = [])
    {
        return $this->send([$this->databaseAdminApi, 'updateDatabase'], [
            $args['name'],
            $args['statements'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function dropDatabase(array $args = [])
    {
        return $this->send([$this->databaseAdminApi, 'dropDatabase'], [
            $args['name'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function getDatabaseDDL(array $args = [])
    {
        return $this->send([$this->databaseAdminApi, 'getDatabaseDDL'], [
            $args['name'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function getDatabaseIamPolicy(array $args = [])
    {
        return $this->send([$this->databaseAdminApi, 'getIamPolicy'], [
            $args['resource'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function setDatabaseIamPolicy(array $args = [])
    {
        return $this->send([$this->databaseAdminApi, 'setIamPolicy'], [
            $args['resource'],
            $args['policy'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function testDatabaseIamPermissions(array $args = [])
    {
        return $this->send([$this->databaseAdminApi, 'testIamPermissions'], [
            $args['resource'],
            $args['permissions'],
            $args
        ]);
    }
}
