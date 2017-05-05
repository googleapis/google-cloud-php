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
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Core\LongRunning\OperationResponseTrait;
use Google\Cloud\Core\PhpArray;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\SpannerClient as VeneerSpannerClient;
use Google\Cloud\Spanner\V1\SpannerClient;
use Google\GAX\ApiException;
use google\protobuf;
use google\spanner\admin\database\v1\Database;
use google\spanner\admin\instance\v1\Instance;
use google\spanner\admin\instance\v1\State;
use google\spanner\v1;
use google\spanner\v1\KeySet;
use google\spanner\v1\Mutation;
use google\spanner\v1\TransactionOptions;
use google\spanner\v1\TransactionSelector;
use google\spanner\v1\Type;

/**
 * Connection to Cloud Spanner over gRPC
 */
class Grpc implements ConnectionInterface
{
    use GrpcTrait;
    use OperationResponseTrait;

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
     * @var OperationsClient
     */
    private $operationsClient;

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
        'insertOrUpdate' => 'setInsertOrUpdate',
        'replace' => 'setReplace',
        'delete' => 'setDelete'
    ];

    /**
     * @var array
     */
    private $lroResponseMappers = [
        [
            'method' => 'updateDatabaseDdl',
            'typeUrl' => 'type.googleapis.com/google.spanner.admin.database.v1.UpdateDatabaseDdlMetadata',
            'message' => protobuf\EmptyC::class
        ], [
            'method' => 'createDatabase',
            'typeUrl' => 'type.googleapis.com/google.spanner.admin.database.v1.CreateDatabaseMetadata',
            'message' => Database::class
        ], [
            'method' => 'createInstance',
            'typeUrl' => 'type.googleapis.com/google.spanner.admin.instance.v1.CreateInstanceMetadata',
            'message' => Instance::class
        ], [
            'method' => 'updateInstance',
            'typeUrl' => 'type.googleapis.com/google.spanner.admin.instance.v1.UpdateInstanceMetadata',
            'message' => Instance::class
        ]
    ];

    /**
     * @var array
     */
    private $longRunningGrpcClients;

    /**
     * @param array $config [optional]
     */
    public function __construct(array $config = [])
    {
        $this->codec = new PhpArray([
            'commitTimestamp' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
            'readTimestamp' => function ($v) {
                return $this->formatTimestampFromApi($v);
            }
        ]);

        $config['codec'] = $this->codec;
        $this->setRequestWrapper(new GrpcRequestWrapper($config));

        $grpcConfig = $this->getGaxConfig(VeneerSpannerClient::VERSION);
        $this->instanceAdminClient = new InstanceAdminClient($grpcConfig);
        $this->databaseAdminClient = new DatabaseAdminClient($grpcConfig);
        $this->spannerClient = new SpannerClient($grpcConfig);
        $this->operationsClient = $this->instanceAdminClient->getOperationsClient();
        $this->longRunningGrpcClients = [
            $this->instanceAdminClient,
            $this->databaseAdminClient
        ];
    }

    /**
     * @param array $args
     */
    public function listInstanceConfigs(array $args)
    {
        return $this->send([$this->instanceAdminClient, 'listInstanceConfigs'], [
            $this->pluck('projectId', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function getInstanceConfig(array $args)
    {
        return $this->send([$this->instanceAdminClient, 'getInstanceConfig'], [
            $this->pluck('name', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function listInstances(array $args)
    {
        return $this->send([$this->instanceAdminClient, 'listInstances'], [
            $this->pluck('projectId', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function getInstance(array $args)
    {
        return $this->send([$this->instanceAdminClient, 'getInstance'], [
            $this->pluck('name', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function createInstance(array $args)
    {
        $instance = $this->instanceObject($args, true);
        $res = $this->send([$this->instanceAdminClient, 'createInstance'], [
            $this->pluck('projectId', $args),
            $this->pluck('instanceId', $args),
            $instance,
            $args
        ]);

        return $this->operationToArray($res, $this->codec, $this->lroResponseMappers);
    }

    /**
     * @param array $args
     */
    public function updateInstance(array $args)
    {
        $instanceObject = $this->instanceObject($args);

        $mask = array_keys($instanceObject->serialize(new PhpArray([], false)));

        $fieldMask = (new protobuf\FieldMask())->deserialize(['paths' => $mask], $this->codec);

        $res = $this->send([$this->instanceAdminClient, 'updateInstance'], [
            $instanceObject,
            $fieldMask,
            $args
        ]);

        return $this->operationToArray($res, $this->codec, $this->lroResponseMappers);
    }

    /**
     * @param array $args
     */
    public function deleteInstance(array $args)
    {
        return $this->send([$this->instanceAdminClient, 'deleteInstance'], [
            $this->pluck('name', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function getInstanceIamPolicy(array $args)
    {
        return $this->send([$this->instanceAdminClient, 'getIamPolicy'], [
            $this->pluck('resource', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function setInstanceIamPolicy(array $args)
    {
        return $this->send([$this->instanceAdminClient, 'setIamPolicy'], [
            $this->pluck('resource', $args),
            $this->pluck('policy', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function testInstanceIamPermissions(array $args)
    {
        return $this->send([$this->instanceAdminClient, 'testIamPermissions'], [
            $this->pluck('resource', $args),
            $this->pluck('permissions', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function listDatabases(array $args)
    {
        return $this->send([$this->databaseAdminClient, 'listDatabases'], [
            $this->pluck('instance', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function createDatabase(array $args)
    {
        $res = $this->send([$this->databaseAdminClient, 'createDatabase'], [
            $this->pluck('instance', $args),
            $this->pluck('createStatement', $args),
            $this->pluck('extraStatements', $args),
            $args
        ]);

        return $this->operationToArray($res, $this->codec, $this->lroResponseMappers);
    }

    /**
     * @param array $args
     */
    public function updateDatabaseDdl(array $args)
    {
        $res = $this->send([$this->databaseAdminClient, 'updateDatabaseDdl'], [
            $this->pluck('name', $args),
            $this->pluck('statements', $args),
            $args
        ]);

        return $this->operationToArray($res, $this->codec, $this->lroResponseMappers);
    }

    /**
     * @param array $args
     */
    public function dropDatabase(array $args)
    {
        return $this->send([$this->databaseAdminClient, 'dropDatabase'], [
            $this->pluck('name', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function getDatabase(array $args)
    {
        return $this->send([$this->databaseAdminClient, 'getDatabase'], [
            $this->pluck('name', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function getDatabaseDDL(array $args)
    {
        return $this->send([$this->databaseAdminClient, 'getDatabaseDDL'], [
            $this->pluck('name', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function getDatabaseIamPolicy(array $args)
    {
        return $this->send([$this->databaseAdminClient, 'getIamPolicy'], [
            $this->pluck('resource', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function setDatabaseIamPolicy(array $args)
    {
        return $this->send([$this->databaseAdminClient, 'setIamPolicy'], [
            $this->pluck('resource', $args),
            $this->pluck('policy', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function testDatabaseIamPermissions(array $args)
    {
        return $this->send([$this->databaseAdminClient, 'testIamPermissions'], [
            $this->pluck('resource', $args),
            $this->pluck('permissions', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function createSession(array $args)
    {
        return $this->send([$this->spannerClient, 'createSession'], [
            $this->pluck('database', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function getSession(array $args)
    {
        return $this->send([$this->spannerClient, 'getSession'], [
            $this->pluck('name', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function deleteSession(array $args)
    {
        return $this->send([$this->spannerClient, 'deleteSession'], [
            $this->pluck('name', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     * @return \Generator
     */
    public function executeStreamingSql(array $args)
    {
        $params = $this->pluck('params', $args);
        if ($params) {
            $args['params'] = (new protobuf\Struct)
                ->deserialize($this->formatStructForApi($params), $this->codec);
        }

        if (isset($args['paramTypes']) && is_array($args['paramTypes'])) {
            foreach ($args['paramTypes'] as $key => $param) {
                $args['paramTypes'][$key] = (new Type)
                    ->deserialize($param, $this->codec);
            }
        }

        $args['transaction'] = $this->createTransactionSelector($args);

        return $this->send([$this->spannerClient, 'executeStreamingSql'], [
            $this->pluck('session', $args),
            $this->pluck('sql', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     * @return \Generator
     */
    public function streamingRead(array $args)
    {
        $keySet = $this->pluck('keySet', $args);
        $keySet = (new KeySet)
            ->deserialize($this->formatKeySet($keySet), $this->codec);

        $args['transaction'] = $this->createTransactionSelector($args);

        return $this->send([$this->spannerClient, 'streamingRead'], [
            $this->pluck('session', $args),
            $this->pluck('table', $args),
            $this->pluck('columns', $args),
            $keySet,
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function beginTransaction(array $args)
    {
        $options = new TransactionOptions;

        $transactionOptions = $this->pluck('transactionOptions', $args);
        if (isset($transactionOptions['readOnly'])) {
            $ro = $transactionOptions['readOnly'];
            if (isset($ro['minReadTimestamp'])) {
                $ro['minReadTimestamp'] = $this->formatTimestampForApi($ro['minReadTimestamp']);
            }

            if (isset($ro['readTimestamp'])) {
                $ro['readTimestamp'] = $this->formatTimestampForApi($ro['readTimestamp']);
            }

            $readOnly = (new TransactionOptions\ReadOnly)
                ->deserialize($ro, $this->codec);

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
     * @param array $args
     */
    public function commit(array $args)
    {
        $inputMutations = $this->pluck('mutations', $args);

        $mutations = [];
        if (is_array($inputMutations)) {
            foreach ($inputMutations as $mutation) {
                $type = array_keys($mutation)[0];
                $data = $mutation[$type];

                switch ($type) {
                    case Operation::OP_DELETE:
                        if (isset($data['keySet'])) {
                            $data['keySet'] = $this->formatKeySet($data['keySet']);
                        }

                        $operation = (new Mutation\Delete)
                            ->deserialize($data, $this->codec);

                        break;
                    default:
                        $data['values'] = $this->formatListForApi($data['values']);

                        $operation = (new Mutation\Write)
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
                ->deserialize([], $this->codec);

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
     * @param array $args
     */
    public function rollback(array $args)
    {
        return $this->send([$this->spannerClient, 'rollback'], [
            $this->pluck('session', $args),
            $this->pluck('transactionId', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function getOperation(array $args)
    {
        $name = $this->pluck('name', $args);

        $operation = $this->getOperationByName($this->databaseAdminClient, $name);

        return $this->operationToArray($operation, $this->codec, $this->lroResponseMappers);
    }

    /**
     * @param array $args
     */
    public function cancelOperation(array $args)
    {
        $name = $this->pluck('name', $args);
        $method = $this->pluck('method', $args);

        $operation = $this->getOperationByName($this->databaseAdminClient, $name, $method);
        $operation->cancel();

        return $this->operationToArray($operation, $this->codec, $this->lroResponseMappers);
    }

    /**
     * @param array $args
     */
    public function deleteOperation(array $args)
    {
        $name = $this->pluck('name', $args);
        $method = $this->pluck('method', $args);

        $operation = $this->getOperationByName($this->databaseAdminClient, $name, $method);
        $operation->delete();

        return $this->operationToArray($operation, $this->codec, $this->lroResponseMappers);
    }

    /**
     * @param array $args
     */
    public function listOperations(array $args)
    {
        $name = $this->pluck('name', $args, false) ?: '';
        $filter = $this->pluck('filter', $args, false) ?: '';

        $client = $this->databaseAdminClient->getOperationsClient();

        return $this->send([$client, 'listOperations'], [
            $name,
            $filter,
            $args
        ]);
    }

    /**
     * @param array $keySet
     * @return array Formatted keyset
     */
    private function formatKeySet(array $keySet)
    {
        $keys = $this->pluck('keys', $keySet, false);
        if ($keys) {
            $keySet['keys'] = $this->formatListForApi($keys);
        }

        if (isset($keySet['ranges'])) {
            foreach ($keySet['ranges'] as $index => $rangeItem) {
                foreach ($rangeItem as $key => $val) {
                    $rangeItem[$key] = $this->formatListForApi($val);
                }

                $keySet['ranges'][$index] = $rangeItem;
            }

            if (empty($keySet['ranges'])) {
                unset($keySet['ranges']);
            }
        }

        return $keySet;
    }

    /**
     * @param array $args
     * @return array
     */
    private function createTransactionSelector(array &$args)
    {
        $selector = new TransactionSelector;
        if (isset($args['transaction'])) {
            $selector = $selector->deserialize($this->pluck('transaction', $args), $this->codec);
        } elseif (isset($args['transactionId'])) {
            $selector = $selector->deserialize(['id' => $this->pluck('transactionId', $args)], $this->codec);
        }

        return $selector;
    }

    /**
     * @param array $args
     * @param bool $isRequired
     */
    private function instanceObject(array &$args, $required = false)
    {
        $labels = null;
        if (isset($args['labels'])) {
            $labels = $this->formatLabelsForApi($this->pluck('labels', $args, $required));
        }

        return (new Instance())->deserialize(array_filter([
            'name' => $this->pluck('name', $args, $required),
            'config' => $this->pluck('config', $args, $required),
            'displayName' => $this->pluck('displayName', $args, $required),
            'nodeCount' => $this->pluck('nodeCount', $args, $required),
            'state' => $this->pluck('state', $args, $required),
            'labels' => $labels
        ]), $this->codec);
    }
}
