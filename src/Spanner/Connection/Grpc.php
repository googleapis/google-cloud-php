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
use google\spanner\admin\instance\v1\Instance;
use google\spanner\admin\instance\v1\State;
use google\spanner\v1;
use google\spanner\v1\KeySet;
use google\spanner\v1\Mutation;
use google\spanner\v1\TransactionOptions;
use google\spanner\v1\Type;

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
        'replace' => 'setReplace',
        'delete' => 'setDelete'
    ];

    /**
     * @param array $config [optional]
     */
    public function __construct(array $config = [])
    {
        $this->codec = new PhpArray([
            'customFilters' => [
                'commitTimestamp' => function ($v) {
                    return $this->formatTimestampFromApi($v);
                },
                'readTimestamp' => function ($v) {
                    return $this->formatTimestampFromApi($v);
                }
            ]
        ]);

        $config['codec'] = $this->codec;
        $this->setRequestWrapper(new GrpcRequestWrapper($config));

        $grpcConfig = $this->getGaxConfig();
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
            $this->pluck('projectId', $args),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function getConfig(array $args = [])
    {
        return $this->send([$this->instanceAdminClient, 'getInstanceConfig'], [
            $this->pluck('name', $args),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function listInstances(array $args = [])
    {
        return $this->send([$this->instanceAdminClient, 'listInstances'], [
            $this->pluck('projectId', $args),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function getInstance(array $args = [])
    {
        return $this->send([$this->instanceAdminClient, 'getInstance'], [
            $this->pluck('name', $args),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function createInstance(array $args = [])
    {
        $instance = $this->instanceObject($args, true);
        return $this->send([$this->instanceAdminClient, 'createInstance'], [
            $this->pluck('projectId', $args),
            $this->pluck('instanceId', $args),
            $instance,
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function updateInstance(array $args = [])
    {
        $instanceObject = $this->instanceObject($args);

        $mask = array_keys($instanceObject->serialize(new PhpArray(['useCamelCase' => false])));

        $fieldMask = (new protobuf\FieldMask())->deserialize(['paths' => $mask], $this->codec);

        return $this->send([$this->instanceAdminClient, 'updateInstance'], [
            $instanceObject,
            $fieldMask,
            $args
        ]);
    }

    private function instanceObject(array &$args, $required = false)
    {
        return (new Instance())->deserialize(array_filter([
            'name' => $this->pluck('name', $args, $required),
            'config' => $this->pluck('config', $args, $required),
            'displayName' => $this->pluck('displayName', $args, $required),
            'nodeCount' => $this->pluck('nodeCount', $args, $required),
            'state' => $this->pluck('state', $args, $required),
            'labels' => $this->formatLabelsForApi($this->pluck('labels', $args, $required))
        ]), $this->codec);
    }

    /**
     * @param array $args [optional]
     */
    public function deleteInstance(array $args = [])
    {
        return $this->send([$this->instanceAdminClient, 'deleteInstance'], [
            $this->pluck('name', $args),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function getInstanceIamPolicy(array $args = [])
    {
        return $this->send([$this->instanceAdminClient, 'getIamPolicy'], [
            $this->pluck('resource', $args),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function setInstanceIamPolicy(array $args = [])
    {
        return $this->send([$this->instanceAdminClient, 'setIamPolicy'], [
            $this->pluck('resource', $args),
            $this->pluck('policy', $args),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function testInstanceIamPermissions(array $args = [])
    {
        return $this->send([$this->instanceAdminClient, 'testIamPermissions'], [
            $this->pluck('resource', $args),
            $this->pluck('permissions', $args),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function listDatabases(array $args = [])
    {
        return $this->send([$this->databaseAdminClient, 'listDatabases'], [
            $this->pluck('instance', $args),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function createDatabase(array $args = [])
    {
        return $this->send([$this->databaseAdminClient, 'createDatabase'], [
            $this->pluck('instance', $args),
            $this->pluck('createStatement', $args),
            $this->pluck('extraStatements', $args),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function updateDatabase(array $args = [])
    {
        return $this->send([$this->databaseAdminClient, 'updateDatabaseDdl'], [
            $this->pluck('name', $args),
            $this->pluck('statements', $args),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function dropDatabase(array $args = [])
    {
        return $this->send([$this->databaseAdminClient, 'dropDatabase'], [
            $this->pluck('name', $args),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function getDatabaseDDL(array $args = [])
    {
        return $this->send([$this->databaseAdminClient, 'getDatabaseDDL'], [
            $this->pluck('name', $args),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function getDatabaseIamPolicy(array $args = [])
    {
        return $this->send([$this->databaseAdminClient, 'getIamPolicy'], [
            $this->pluck('resource', $args),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function setDatabaseIamPolicy(array $args = [])
    {
        return $this->send([$this->databaseAdminClient, 'setIamPolicy'], [
            $this->pluck('resource', $args),
            $this->pluck('policy', $args),
            $args
        ]);
    }

    /**
     * @param array $args [optional]
     */
    public function testDatabaseIamPermissions(array $args = [])
    {
        return $this->send([$this->databaseAdminClient, 'testIamPermissions'], [
            $this->pluck('resource', $args),
            $this->pluck('permissions', $args),
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

        foreach ($args['paramTypes'] as $key => $param) {
            $args['paramTypes'][$key] = (new Type)
                ->deserialize($param, $this->codec);
        }

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
        $keySet = $this->pluck('keySet', $args);
        $keySet = (new KeySet)
            ->deserialize($this->formatKeySet($keySet), $this->codec);

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

        if (isset($args['transactionOptions']['readOnly'])) {
            $readOnly = (new TransactionOptions\ReadOnly)
                ->deserialize($args['transactionOptions']['readOnly'], $this->codec);

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

                switch ($type) {
                    case 'insert':
                    case 'update':
                    case 'upsert':
                    case 'replace':
                        $data['values'] = $this->formatListForApi($data['values']);

                        $operation = (new Mutation\Write)
                            ->deserialize($data, $this->codec);

                        break;

                    case 'delete':
                        if (isset($data['keySet'])) {
                            $data['keySet'] = $this->formatKeySet($data['keySet']);
                        }

                        $operation = (new Mutation\Delete)
                            ->deserialize($data, $this->codec);

                        break;
                }

                $setterName = $this->mutationSetters[$type];
                $mutation = new Mutation;
                $mutation->$setterName($operation);
                $mutations[] = $mutation;
            }
        }

        if (isset($args['singleUseTransaction'])) {
            $readWrite = (new TransactionOptions\ReadWrite)
                ->deserialize($args['singleUseTransaction']['readWrite'], $this->codec);

            $options = new TransactionOptions;
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

    /**
     * @param array $keySet
     * @return array Formatted keyset
     */
    private function formatKeySet(array $keySet)
    {
        if (isset($keySet['keys'])) {
            $keySet['keys'] = $this->formatListForApi($keySet['keys']);
        }

        if (isset($keySet['ranges'])) {
            foreach ($keySet['ranges'] as $index => $rangeItem) {
                foreach ($rangeItem as $key => $val) {
                    $rangeItem[$key] = $this->formatListForApi($val);
                }

                $keySet['ranges'][$index] = $rangeItem;
            }
        }

        return $keySet;
    }
}
