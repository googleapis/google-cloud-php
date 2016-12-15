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
use Google\Cloud\PhpArray;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\V1\SpannerClient;
use Google\GAX\ApiException;
use google\protobuf;
use google\spanner\admin\instance\v1\State;
use google\spanner\v1;
use google\spanner\v1\Mutation;
use google\spanner\v1\TransactionOptions;

class Grpc implements ConnectionInterface
{
    use GrpcTrait;

    /**
     * @var InstanceAdminClient
     */
    private $instanceAdminClient;

    /**
     * @var DatabaseAdmin
     */
    private $databaseAdminClient;

    /**
     * @var SpannerClient
     */
    private $spannerClient;

    /**
     * @var CodecInterface
     */
    private $codec;

    /**
     * @var array
     */
    private $mutationSetters = [
        'insert' => 'setInsert',
        'update' => 'setUpdate',
        'upsert' => 'setInsertOrUpdate',
        'replace' => 'replace',
    ];

    /**
     * @param array $config [optional]
     */
    public function __construct(array $config = [])
    {
        $grpcConfig = [
            'credentialsLoader' => CredentialsLoader::makeCredentials($config['scopes'], $config['keyFile'])
        ];

        $this->codec = new PhpArray([
            'timestamp' => function ($v) {
                return $this->formatTimestampFromApi($v);
            }
        ]);

        $config['codec'] = $this->codec;
        $this->setRequestWrapper(new GrpcRequestWrapper($config));

        $this->instanceAdminClient = new InstanceAdminClient($grpcConfig);
        $this->databaseAdminClient = new DatabaseAdminClient($grpcConfig);
        $this->spannerClient = new SpannerClient($grpcConfig);
    }

    /**
     * @param array $args [optional]
     */
    public function listConfigs(array $args = [])
    {
        return $this->send([$this->instanceAdminClient, 'listInstanceConfigs'], [
            $args['projectId'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function getConfig(array $args = [])
    {
        return $this->send([$this->instanceAdminClient, 'getInstanceConfig'], [
            $args['name'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function listInstances(array $args = [])
    {
        return $this->send([$this->instanceAdminClient, 'listInstances'], [
            InstanceAdminClient::formatProjectName($args['projectId']),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function getInstance(array $args = [])
    {
        return $this->send([$this->instanceAdminClient, 'getInstance'], [
            $args['name'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function createInstance(array $args = [])
    {
        return $this->send([$this->instanceAdminClient, 'createInstance'], [
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
        return $this->send([$this->instanceAdminClient, 'updateInstance'], [
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
        return $this->send([$this->instanceAdminClient, 'deleteInstance'], [
            $args['name'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function getInstanceIamPolicy(array $args = [])
    {
        return $this->send([$this->instanceAdminClient, 'getIamPolicy'], [
            $args['resource'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function setInstanceIamPolicy(array $args = [])
    {
        return $this->send([$this->instanceAdminClient, 'setIamPolicy'], [
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
        return $this->send([$this->instanceAdminClient, 'testIamPermissions'], [
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
        return $this->send([$this->databaseAdminClient, 'listDatabases'], [
            $args['instance'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function createDatabase(array $args = [])
    {
        return $this->send([$this->databaseAdminClient, 'createDatabase'], [
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
        return $this->send([$this->databaseAdminClient, 'updateDatabase'], [
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
        return $this->send([$this->databaseAdminClient, 'dropDatabase'], [
            $args['name'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function getDatabaseDDL(array $args = [])
    {
        return $this->send([$this->databaseAdminClient, 'getDatabaseDDL'], [
            $args['name'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function getDatabaseIamPolicy(array $args = [])
    {
        return $this->send([$this->databaseAdminClient, 'getIamPolicy'], [
            $args['resource'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function setDatabaseIamPolicy(array $args = [])
    {
        return $this->send([$this->databaseAdminClient, 'setIamPolicy'], [
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
        return $this->send([$this->databaseAdminClient, 'testIamPermissions'], [
            $args['resource'],
            $args['permissions'],
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function createSession(array $args = [])
    {
        return $this->send([$this->spannerClient, 'createSession'], [
            $this->pluck('database', $args),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function getSession(array $args = [])
    {
        return $this->send([$this->spannerClient, 'getSession'], [
            $this->pluck('name', $args),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function deleteSession(array $args = [])
    {
        return $this->send([$this->spannerClient, 'deleteSession'], [
            $this->pluck('name', $args),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function executeSql(array $args = [])
    {
        $args['params'] = (new protobuf\Struct)
            ->deserialize($this->formatStructForApi($args['params']), $this->codec);

        return $this->send([$this->spannerClient, 'executeSql'], [
            $this->pluck('session', $args),
            $this->pluck('sql', $args),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function read(array $args = [])
    {
        $keys = $this->pluck('keySet', $args);

        $keySet = new v1\KeySet;
        if (!empty($keys['keys'])) {
            $keySet->setKeys($this->formatListForApi($keys['keys']));
        }

        if (!empty($keys['ranges'])) {
            $ranges = new v1\KeyRange;

            if (isset($keys['ranges']['startClosed'])) {
                $ranges->setStartClosed($this->formatListForApi($keys['ranges']['startClosed']));
            }

            if (isset($keys['ranges']['startOpen'])) {
                $ranges->setStartOpen($this->formatListForApi($keys['ranges']['startOpen']));
            }
            if (isset($keys['ranges']['endClosed'])) {
                $ranges->setEndClosed($this->formatListForApi($keys['ranges']['endClosed']));
            }
            if (isset($keys['ranges']['endOpen'])) {
                $ranges->setEndOpen($this->formatListForApi($keys['ranges']['endOpen']));
            }

            $keySet->setRanges($ranges);
        }

        if (isset($keys['all'])) {
            $keySet->setAll($keys['all']);
        }

        return $this->send([$this->spannerClient, 'read'], [
            $this->pluck('session', $args),
            $this->pluck('table', $args),
            $this->pluck('columns', $args),
            $keySet,
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function beginTransaction(array $args = [])
    {
        $options = new TransactionOptions;

        if (isset($args['readOnly'])) {
            $readOnly = (new TransactionOptions\ReadOnly)
                ->deserialize($args['readOnly'], $this->codec);

            $options->setReadOnly($readOnly);
        } else {
            $readWrite = new TransactionOptions\ReadWrite();
            $options->setReadWrite($readWrite);
        }

        return $this->send([$this->spannerClient, 'beginTransaction'], [
            $this->pluck('session', $args),
            $options,
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function commit(array $args = [])
    {
        $inputMutations = $this->pluck('mutations', $args);

        $mutations = [];
        if (is_array($inputMutations)) {
            foreach ($inputMutations as $mutation) {
                $type = array_keys($mutation)[0];
                $data = $mutation[$type];
                $data['values'] = $this->formatListForApi($data['values']);

                switch ($type) {
                    case 'insert':
                    case 'update':
                    case 'upsert':
                    case 'replace':
                        $write = (new Mutation\Write)
                            ->deserialize($data, $this->codec);

                        $setterName = $this->mutationSetters[$type];
                        $mutation = new Mutation;
                        $mutation->$setterName($write);
                        $mutations[] = $mutation;

                        break;

                    case 'delete':
                        $mutations[] = (new Mutation\Delete)
                            ->deserialize($data, $this->codec);

                        break;
                }
            }
        }

        if (isset($args['singleUseTransaction'])) {
            $options = new TransactionOptions;
            $readWrite = (new TransactionOptions\ReadWrite)
                ->deserialize($args['singleUseTransaction']['readWrite'], $this->codec);
            $options->setReadWrite($readWrite);
            $args['singleUseTransaction'] = $options;
        }

        return $this->send([$this->spannerClient, 'commit'], [
            $this->pluck('session', $args),
            $mutations,
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function rollback(array $args = [])
    {
        return $this->send([$this->spannerClient, 'rollback'], [
            $this->pluck('session', $args),
            $this->pluck('transactionId', $args),
            $args
        ]);
    }
}
