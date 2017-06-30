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

use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Core\LongRunning\OperationResponseTrait;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\SpannerClient as ManualSpannerClient;
use Google\Cloud\Spanner\V1\SpannerClient;
use Google\GAX\Serializer;
use Google\Protobuf;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Protobuf\ListValue;
use Google\Protobuf\Struct;
use Google\Protobuf\Value;
use Google\Spanner\Admin\Database\V1\Database;
use Google\Spanner\Admin\Instance\V1\Instance;
use Google\Spanner\V1\KeySet;
use Google\Spanner\V1\Mutation;
use Google\Spanner\V1\Mutation_Delete;
use Google\Spanner\V1\Mutation_Write;
use Google\Spanner\V1\TransactionOptions;
use Google\Spanner\V1\TransactionOptions_ReadOnly;
use Google\Spanner\V1\TransactionOptions_ReadWrite;
use Google\Spanner\V1\TransactionSelector;
use Google\Spanner\V1\Type;

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
     * @var Serializer
     */
    private $serializer;

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
            'message' => GPBEmpty::class
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
        $this->serializer = new Serializer([
            'commit_timestamp' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
            'read_timestamp' => function ($v) {
                return $this->formatTimestampFromApi($v);
            }
        ], [
            '.google.protobuf.Value' => function ($v) {
                return $this->flattenValue($v);
            },
            '.google.protobuf.ListValue' => function ($v) {
                return $this->flattenListValue($v);
            },
            '.google.protobuf.Struct' => function ($v) {
                return $this->flattenStruct($v);
            },
        ]);

        $config['serializer'] = $this->serializer;
        $this->setRequestWrapper(new GrpcRequestWrapper($config));

        $grpcConfig = $this->getGaxConfig(ManualSpannerClient::VERSION);
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
        $projectId = $this->pluck('projectId', $args);
        return $this->send([$this->instanceAdminClient, 'listInstanceConfigs'], [
            $projectId,
            $this->addResourcePrefixHeader($args, $projectId)
        ]);
    }

    /**
     * @param array $args
     */
    public function getInstanceConfig(array $args)
    {
        $projectId = $this->pluck('projectId', $args);
        return $this->send([$this->instanceAdminClient, 'getInstanceConfig'], [
            $this->pluck('name', $args),
            $this->addResourcePrefixHeader($args, $projectId)
        ]);
    }

    /**
     * @param array $args
     */
    public function listInstances(array $args)
    {
        $projectId = $this->pluck('projectId', $args);
        return $this->send([$this->instanceAdminClient, 'listInstances'], [
            $projectId,
            $this->addResourcePrefixHeader($args, $projectId)
        ]);
    }

    /**
     * @param array $args
     */
    public function getInstance(array $args)
    {
        $projectId = $this->pluck('projectId', $args);
        return $this->send([$this->instanceAdminClient, 'getInstance'], [
            $this->pluck('name', $args),
            $this->addResourcePrefixHeader($args, $projectId)
        ]);
    }

    /**
     * @param array $args
     */
    public function createInstance(array $args)
    {
        $instanceName = $args['name'];

        $instance = $this->instanceObject($args, true);
        $res = $this->send([$this->instanceAdminClient, 'createInstance'], [
            $this->pluck('projectId', $args),
            $this->pluck('instanceId', $args),
            $instance,
            $this->addResourcePrefixHeader($args, $instanceName)
        ]);

        return $this->operationToArray($res, $this->serializer, $this->lroResponseMappers);
    }

    /**
     * @param array $args
     */
    public function updateInstance(array $args)
    {
        $instanceName = $args['name'];

        $instanceArray = $this->instanceArray($args);

        $fieldMask = $this->fieldMask($instanceArray);

        $instanceObject = $this->serializer->decodeMessage(new Instance(), $instanceArray);

        $res = $this->send([$this->instanceAdminClient, 'updateInstance'], [
            $instanceObject,
            $fieldMask,
            $this->addResourcePrefixHeader($args, $instanceName)
        ]);

        return $this->operationToArray($res, $this->serializer, $this->lroResponseMappers);
    }

    /**
     * @param array $args
     */
    public function deleteInstance(array $args)
    {
        $instanceName = $this->pluck('name', $args);
        return $this->send([$this->instanceAdminClient, 'deleteInstance'], [
            $instanceName,
            $this->addResourcePrefixHeader($args, $instanceName)
        ]);
    }

    /**
     * @param array $args
     */
    public function getInstanceIamPolicy(array $args)
    {
        $resource = $this->pluck('resource', $args);
        return $this->send([$this->instanceAdminClient, 'getIamPolicy'], [
            $resource,
            $this->addResourcePrefixHeader($args, $resource)
        ]);
    }

    /**
     * @param array $args
     */
    public function setInstanceIamPolicy(array $args)
    {
        $resource = $this->pluck('resource', $args);
        return $this->send([$this->instanceAdminClient, 'setIamPolicy'], [
            $resource,
            $this->pluck('policy', $args),
            $this->addResourcePrefixHeader($args, $resource)
        ]);
    }

    /**
     * @param array $args
     */
    public function testInstanceIamPermissions(array $args)
    {
        $resource = $this->pluck('resource', $args);
        return $this->send([$this->instanceAdminClient, 'testIamPermissions'], [
            $resource,
            $this->pluck('permissions', $args),
            $this->addResourcePrefixHeader($args, $resource)
        ]);
    }

    /**
     * @param array $args
     */
    public function listDatabases(array $args)
    {
        $instanceName = $this->pluck('instance', $args);
        return $this->send([$this->databaseAdminClient, 'listDatabases'], [
            $instanceName,
            $this->addResourcePrefixHeader($args, $instanceName)
        ]);
    }

    /**
     * @param array $args
     */
    public function createDatabase(array $args)
    {
        $instanceName = $this->pluck('instance', $args);
        $res = $this->send([$this->databaseAdminClient, 'createDatabase'], [
            $instanceName,
            $this->pluck('createStatement', $args),
            $this->addResourcePrefixHeader($args, $instanceName)
        ]);

        return $this->operationToArray($res, $this->serializer, $this->lroResponseMappers);
    }

    /**
     * @param array $args
     */
    public function updateDatabaseDdl(array $args)
    {
        $databaseName = $this->pluck('name', $args);
        $res = $this->send([$this->databaseAdminClient, 'updateDatabaseDdl'], [
            $databaseName,
            $this->pluck('statements', $args),
            $this->addResourcePrefixHeader($args, $databaseName)
        ]);

        return $this->operationToArray($res, $this->serializer, $this->lroResponseMappers);
    }

    /**
     * @param array $args
     */
    public function dropDatabase(array $args)
    {
        $databaseName = $this->pluck('name', $args);
        return $this->send([$this->databaseAdminClient, 'dropDatabase'], [
            $databaseName,
            $this->addResourcePrefixHeader($args, $databaseName)
        ]);
    }

    /**
     * @param array $args
     */
    public function getDatabase(array $args)
    {
        $databaseName = $this->pluck('name', $args);
        return $this->send([$this->databaseAdminClient, 'getDatabase'], [
            $databaseName,
            $this->addResourcePrefixHeader($args, $databaseName)
        ]);
    }

    /**
     * @param array $args
     */
    public function getDatabaseDDL(array $args)
    {
        $databaseName = $this->pluck('name', $args);
        return $this->send([$this->databaseAdminClient, 'getDatabaseDDL'], [
            $databaseName,
            $this->addResourcePrefixHeader($args, $databaseName)
        ]);
    }

    /**
     * @param array $args
     */
    public function getDatabaseIamPolicy(array $args)
    {
        $databaseName = $this->pluck('resource', $args);
        return $this->send([$this->databaseAdminClient, 'getIamPolicy'], [
            $databaseName,
            $this->addResourcePrefixHeader($args, $databaseName)
        ]);
    }

    /**
     * @param array $args
     */
    public function setDatabaseIamPolicy(array $args)
    {
        $databaseName = $this->pluck('resource', $args);
        return $this->send([$this->databaseAdminClient, 'setIamPolicy'], [
            $databaseName,
            $this->pluck('policy', $args),
            $this->addResourcePrefixHeader($args, $databaseName)
        ]);
    }

    /**
     * @param array $args
     */
    public function testDatabaseIamPermissions(array $args)
    {
        $databaseName = $this->pluck('resource', $args);
        return $this->send([$this->databaseAdminClient, 'testIamPermissions'], [
            $databaseName,
            $this->pluck('permissions', $args),
            $this->addResourcePrefixHeader($args, $databaseName)
        ]);
    }

    /**
     * @param array $args
     */
    public function createSession(array $args)
    {
        $databaseName = $this->pluck('database', $args);
        return $this->send([$this->spannerClient, 'createSession'], [
            $databaseName,
            $this->addResourcePrefixHeader($args, $databaseName)
        ]);
    }

    /**
     * @param array $args
     */
    public function getSession(array $args)
    {
        $database = $this->pluck('database', $args);
        return $this->send([$this->spannerClient, 'getSession'], [
            $this->pluck('name', $args),
            $this->addResourcePrefixHeader($args, $database)
        ]);
    }

    /**
     * @param array $args
     */
    public function deleteSession(array $args)
    {
        $database = $this->pluck('database', $args);
        return $this->send([$this->spannerClient, 'deleteSession'], [
            $this->pluck('name', $args),
            $this->addResourcePrefixHeader($args, $database)
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
            $modifiedParams = [];
            foreach ($params as $key => $param) {
                $modifiedParams[$key] = $this->fieldValue($param);
            }
            $args['params'] = new Struct;
            $args['params']->setFields($modifiedParams);
        }

        if (isset($args['paramTypes']) && is_array($args['paramTypes'])) {
            foreach ($args['paramTypes'] as $key => $param) {
                $args['paramTypes'][$key] = $this->serializer->decodeMessage(new Type, $param);
            }
        }

        $args['transaction'] = $this->createTransactionSelector($args);

        $database = $this->pluck('database', $args);
        return $this->send([$this->spannerClient, 'executeStreamingSql'], [
            $this->pluck('session', $args),
            $this->pluck('sql', $args),
            $this->addResourcePrefixHeader($args, $database)
        ]);
    }

    /**
     * @param array $args
     * @return \Generator
     */
    public function streamingRead(array $args)
    {
        $keySet = $this->pluck('keySet', $args);
        $keySet = $this->serializer->decodeMessage(new KeySet, $this->formatKeySet($keySet));

        $args['transaction'] = $this->createTransactionSelector($args);

        $database = $this->pluck('database', $args);
        return $this->send([$this->spannerClient, 'streamingRead'], [
            $this->pluck('session', $args),
            $this->pluck('table', $args),
            $this->pluck('columns', $args),
            $keySet,
            $this->addResourcePrefixHeader($args, $database)
        ]);
    }

    /**
     * @param array $args
     */
    public function beginTransaction(array $args)
    {
        $options = new TransactionOptions;

        $transactionOptions = $this->formatTransactionOptions($this->pluck('transactionOptions', $args));
        if (isset($transactionOptions['readOnly'])) {
            $readOnly = $this->serializer->decodeMessage(
                new TransactionOptions_ReadOnly(),
                $transactionOptions['readOnly']
            );
            $options->setReadOnly($readOnly);
        } else {
            $readWrite = new TransactionOptions_ReadWrite();
            $options->setReadWrite($readWrite);
        }

        $database = $this->pluck('database', $args);
        return $this->send([$this->spannerClient, 'beginTransaction'], [
            $this->pluck('session', $args),
            $options,
            $this->addResourcePrefixHeader($args, $database)
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

                        $operation = $this->serializer->decodeMessage(
                            new Mutation_Delete,
                            $data
                        );
                        break;
                    default:
                        $operation = new Mutation_Write;
                        $operation->setTable($data['table']);
                        $operation->setColumns($data['columns']);

                        $modifiedData = [];
                        foreach ($data['values'] as $key => $param) {
                            $modifiedData[$key] = $this->fieldValue($param);
                        }

                        $list = new ListValue;
                        $list->setValues($modifiedData);
                        $values = [$list];
                        $operation->setValues($values);

                        break;
                }

                $setterName = $this->mutationSetters[$type];
                $mutation = new Mutation;
                $mutation->$setterName($operation);
                $mutations[] = $mutation;
            }
        }

        if (isset($args['singleUseTransaction'])) {
            $readWrite = $this->serializer->decodeMessage(
                new TransactionOptions_ReadWrite,
                []
            );

            $options = new TransactionOptions;
            $options->setReadWrite($readWrite);
            $args['singleUseTransaction'] = $options;
        }

        $database = $this->pluck('database', $args);
        return $this->send([$this->spannerClient, 'commit'], [
            $this->pluck('session', $args),
            $mutations,
            $this->addResourcePrefixHeader($args, $database)
        ]);
    }

    /**
     * @param array $args
     */
    public function rollback(array $args)
    {
        $database = $this->pluck('database', $args);
        return $this->send([$this->spannerClient, 'rollback'], [
            $this->pluck('session', $args),
            $this->pluck('transactionId', $args),
            $this->addResourcePrefixHeader($args, $database)
        ]);
    }

    /**
     * @param array $args
     */
    public function getOperation(array $args)
    {
        $name = $this->pluck('name', $args);

        $operation = $this->getOperationByName($this->databaseAdminClient, $name);

        return $this->operationToArray($operation, $this->serializer, $this->lroResponseMappers);
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

        return $this->operationToArray($operation, $this->serializer, $this->lroResponseMappers);
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

        return $this->operationToArray($operation, $this->serializer, $this->lroResponseMappers);
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
            $keySet['keys'] = [];

            foreach ($keys as $key) {
                $keySet['keys'][] = $this->formatListForApi((array) $key);
            }
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
     * @return TransactionSelector
     */
    private function createTransactionSelector(array &$args)
    {
        $selector = new TransactionSelector;
        if (isset($args['transaction'])) {
            $transaction = $this->pluck('transaction', $args);

            if (isset($transaction['singleUse'])) {
                $transaction['singleUse'] = $this->formatTransactionOptions($transaction['singleUse']);
            }

            if (isset($transaction['begin'])) {
                $transaction['begin'] = $this->formatTransactionOptions($transaction['begin']);
            }

            $selector = $this->serializer->decodeMessage($selector, $transaction);
        } elseif (isset($args['transactionId'])) {
            $selector = $this->serializer->decodeMessage($selector, ['id' => $this->pluck('transactionId', $args)]);
        }

        return $selector;
    }

    /**
     * @param array $args
     * @param bool $required
     * @return Instance
     */
    private function instanceObject(array &$args, $required = false)
    {
        return $this->serializer->decodeMessage(
            new Instance(),
            $this->instanceArray($args, $required)
        );
    }

    /**
     * @param array $args
     * @param bool $required
     * @return array
     */
    private function instanceArray(array &$args, $required = false)
    {
        $argsCopy = $args;
        return array_intersect_key([
            'name' => $this->pluck('name', $args, $required),
            'config' => $this->pluck('config', $args, $required),
            'displayName' => $this->pluck('displayName', $args, $required),
            'nodeCount' => $this->pluck('nodeCount', $args, $required),
            'state' => $this->pluck('state', $args, $required),
            'labels' => $this->pluck('labels', $args, $required),
        ], $argsCopy);
    }

    /**
     * @param array $instanceArray
     * @return FieldMask
     */
    private function fieldMask($instanceArray)
    {
        $mask = [];
        foreach (array_keys($instanceArray) as $key) {
            $mask[] = Serializer::toSnakeCase($key);
        }
        return $this->serializer->decodeMessage(new FieldMask(), ['paths' => $mask]);
    }

    /**
     * @param mixed $param
     * @return Value
     */
    private function fieldValue($param)
    {
        $field = new Value;
        $value = $this->formatValueForApi($param);

        switch (array_keys($value)[0]) {
            case 'string_value':
                $setter = 'setStringValue';
                break;
            case 'number_value':
                $setter = 'setNumberValue';
                break;
            case 'bool_value':
                $setter = 'setBoolValue';
                break;
            case 'null_value':
                $setter = 'setNullValue';
                break;
            case 'struct_value':
                $setter = 'setStructValue';
                break;
            case 'list_value':
                $setter = 'setListValue';
                $modifiedParams = [];
                foreach ($param as $item) {
                    $modifiedParams[] = $this->fieldValue($item);
                }
                $list = new ListValue;
                $list->setValues($modifiedParams);
                $value = $list;

                break;
        }

        $value = is_array($value) ? current($value) : $value;
        $field->$setter($value);

        return $field;
    }

    /**
     * @param array $transactionOptions
     * @return array
     */
    private function formatTransactionOptions(array $transactionOptions)
    {
        if (isset($transactionOptions['readOnly'])) {
            $ro = $transactionOptions['readOnly'];
            if (isset($ro['minReadTimestamp'])) {
                $ro['minReadTimestamp'] = $this->formatTimestampForApi($ro['minReadTimestamp']);
            }

            if (isset($ro['readTimestamp'])) {
                $ro['readTimestamp'] = $this->formatTimestampForApi($ro['readTimestamp']);
            }

            $transactionOptions['readOnly'] = $ro;
        }

        return $transactionOptions;
    }

    /**
     * Add the `google-cloud-resource-prefix` header value to the request.
     *
     * @param array $args
     * @param string $value
     * @return array
     */
    private function addResourcePrefixHeader(array $args, $value)
    {
        $args['userHeaders'] = [
            'google-cloud-resource-prefix' => [$value]
        ];

        return $args;
    }
}
