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

namespace Google\Cloud\Tests\Unit\Spanner\Connection;

use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Spanner\Connection\Grpc;
use Google\Cloud\Spanner\ValueMapper;
use Google\Cloud\Tests\GrpcTestTrait;
use Google\GAX\OperationResponse;
use Google\GAX\Serializer;
use Google\Protobuf\FieldMask;
use Google\Protobuf\Struct;
use Google\Spanner\Admin\Instance\V1\Instance;
use Google\Spanner\Admin\Instance\V1\Instance_State;
use Google\Spanner\V1\Mutation_Write;
use Google\Spanner\V1\TransactionOptions_ReadOnly;
use Google\Spanner\V1\TransactionOptions_ReadWrite;
use Prophecy\Argument;
use Google\Spanner\V1\KeySet;
use Google\Spanner\V1\Mutation;
use Google\Spanner\V1\TransactionOptions;
use Google\Spanner\V1\TransactionSelector;
use Google\Spanner\V1\Type;

/**
 * @group spanner
 */
class GrpcTest extends \PHPUnit_Framework_TestCase
{
    use GrpcTestTrait;
    use GrpcTrait;

    const PROJECT = 'projects/my-project';

    private $requestWrapper;
    private $successMessage;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->requestWrapper = $this->prophesize(GrpcRequestWrapper::class);
        $this->successMessage = 'success';
    }

    /**
     * @dataProvider methodProvider
     */
    public function testCallBasicMethods($method, $args, $expectedArgs, $return = null, $result = '')
    {
        $this->requestWrapper->send(
            Argument::type('callable'),
            $expectedArgs,
            Argument::type('array')
        )->willReturn($return ?: $this->successMessage);

        $grpc = new Grpc();
        $grpc->setRequestWrapper($this->requestWrapper->reveal());

        $this->assertEquals($result !== '' ? $result : $this->successMessage, $grpc->$method($args));
    }

    public function methodProvider()
    {
        if ($this->shouldSkipGrpcTests()) {
            return [];
        }

        $serializer = new Serializer();

        $configName = 'test-config';
        $instanceName = 'test-instance';
        $policy = ['foo' => 'bar'];
        $permissions = ['permission1','permission2'];
        $databaseName = 'test-database';
        $sessionName = 'test-session';
        $transactionName = 'test-transaction';

        $instanceArgs = [
            'name' => $instanceName,
            'config' => $configName,
            'displayName' => $instanceName,
            'nodeCount' => 1,
            'state' => Instance_State::CREATING,
            'labels' => []
        ];

        $instance = $serializer->decodeMessage(
            new Instance(),
            $instanceArgs
        );

        $lro = $this->prophesize(OperationResponse::class)->reveal();

        $mask = [];
        foreach (array_keys($instanceArgs) as $key) {
            $mask[] = Serializer::toSnakeCase($key);
        }

        $fieldMask = $serializer->decodeMessage(new FieldMask(), ['paths' => $mask]);

        $instanceArgsPartial = [
            'name' => $instanceName,
            'displayName' => "",
        ];

        $instancePartial = $serializer->decodeMessage(
            new Instance(),
            $instanceArgsPartial
        );

        $lroPartial = $this->prophesize(OperationResponse::class)->reveal();

        $maskPartial = [];
        foreach (array_keys($instanceArgsPartial) as $key) {
            $maskPartial[] = Serializer::toSnakeCase($key);
        }

        $fieldMaskPartial = $serializer->decodeMessage(new FieldMask(), ['paths' => $maskPartial]);

        $tableName = 'foo';

        $createStmt = 'CREATE TABLE '. $tableName;
        $sql = 'SELECT * FROM '. $tableName;

        $transactionSelector = $serializer->decodeMessage(
            new TransactionSelector,
            ['id' => $transactionName]
        );

        $mapper = new ValueMapper(false);
        $mapped = $mapper->formatParamsForExecuteSql(['foo' => 'bar']);

        $expectedParams = $serializer->decodeMessage(
            new Struct,
            $this->formatStructForApi($mapped['params'])
        );

        $expectedParamTypes = $mapped['paramTypes'];
        foreach ($expectedParamTypes as $key => $param) {
            $expectedParamTypes[$key] = $serializer->decodeMessage(new Type, $param);
        }

        $columns = ['id', 'name'];
        $keySetArgs = [];
        $keySet = $serializer->decodeMessage(new KeySet, $keySetArgs);
        $keySetSingular = $serializer->decodeMessage(
            new KeySet, [
                'keys' => [
                    [
                        'values' => [
                            [
                                'number_value' => 1
                            ]
                        ]
                    ],
                ]
            ]
        );
        $keySetComposite = $serializer->decodeMessage(
            new KeySet, [
                'keys' => [
                    [
                        'values' => [
                            [
                                'number_value' => 1
                            ],
                            [
                                'number_value' => 1
                            ]
                        ]
                    ]
                ]
            ]
        );
        $readWriteTransactionArgs = ['readWrite' => []];
        $readWriteTransactionOptions = new TransactionOptions;
        $rw = new TransactionOptions_ReadWrite();
        $readWriteTransactionOptions->setReadWrite($rw);

        $ts = (new \DateTime)->format('Y-m-d\TH:i:s.u\Z');
        $readOnlyTransactionArgs = [
            'readOnly' => [
                'minReadTimestamp' => $ts,
                'readTimestamp' => $ts
            ]
        ];

        $roObjArgs = $readOnlyTransactionArgs;
        $roObjArgs['readOnly']['minReadTimestamp'] = $this->formatTimestampForApi($ts);
        $roObjArgs['readOnly']['readTimestamp'] = $this->formatTimestampForApi($ts);
        $readOnlyTransactionOptions = new TransactionOptions;
        $ro = $serializer->decodeMessage(new TransactionOptions_ReadOnly(), $roObjArgs['readOnly']);

        $readOnlyTransactionOptions->setReadOnly($ro);

        $insertMutations = [
            [
                'insert' => [
                    'table' => $tableName,
                    'columns' => ['foo'],
                    'values' => [
                        ['bar']
                    ]
                ]
            ]
        ];

        $insertMutationsArr = [];
        $insert = $insertMutations[0]['insert'];
        $insert['values'] = [];
        foreach ($insertMutations[0]['insert']['values'] as $list) {
            $insert['values'][] = $this->formatListForApi($list);
        }
        $operation = $serializer->decodeMessage(new Mutation_Write, $insert);

        $mutation = new Mutation;
        $mutation->setInsert($operation);
        $insertMutationsArr[] = $mutation;

        return [
            [
                'listInstanceConfigs',
                ['projectId' => self::PROJECT],
                [self::PROJECT, ['userHeaders' => ['google-cloud-resource-prefix' => [self::PROJECT]]]]
            ],
            [
                'getInstanceConfig',
                ['name' => $configName, 'projectId' => self::PROJECT],
                [$configName, ['userHeaders' => ['google-cloud-resource-prefix' => [self::PROJECT]]]]
            ],
            [
                'listInstances',
                ['projectId' => self::PROJECT],
                [self::PROJECT, ['userHeaders' => ['google-cloud-resource-prefix' => [self::PROJECT]]]]
            ],
            [
                'getInstance',
                ['name' => $instanceName, 'projectId' => self::PROJECT],
                [$instanceName, ['userHeaders' => ['google-cloud-resource-prefix' => [self::PROJECT]]]]
            ],
            [
                'createInstance',
                ['projectId' => self::PROJECT, 'instanceId' => $instanceName] + $instanceArgs,
                [self::PROJECT, $instanceName, $instance, ['userHeaders' => ['google-cloud-resource-prefix' => [$instanceName]]]],
                $lro,
                null
            ],
            [
                'updateInstance',
                $instanceArgs,
                [$instance, $fieldMask, ['userHeaders' => ['google-cloud-resource-prefix' => [$instanceName]]]],
                $lro,
                null
            ],
            [
                'updateInstance',
                $instanceArgsPartial,
                [$instancePartial, $fieldMaskPartial, ['userHeaders' => ['google-cloud-resource-prefix' => [$instanceName]]]],
                $lroPartial,
                null
            ],
            [
                'deleteInstance',
                ['name' => $instanceName],
                [$instanceName, ['userHeaders' => ['google-cloud-resource-prefix' => [$instanceName]]]]
            ],
            [
                'setInstanceIamPolicy',
                ['resource' => $instanceName, 'policy' => $policy],
                [$instanceName, $policy, ['userHeaders' => ['google-cloud-resource-prefix' => [$instanceName]]]]
            ],
            [
                'getInstanceIamPolicy',
                ['resource' => $instanceName],
                [$instanceName, ['userHeaders' => ['google-cloud-resource-prefix' => [$instanceName]]]]
            ],
            [
                'testInstanceIamPermissions',
                ['resource' => $instanceName, 'permissions' => $permissions],
                [$instanceName, $permissions, ['userHeaders' => ['google-cloud-resource-prefix' => [$instanceName]]]]
            ],
            [
                'listDatabases',
                ['instance' => $instanceName],
                [$instanceName, ['userHeaders' => ['google-cloud-resource-prefix' => [$instanceName]]]]
            ],
            [
                'createDatabase',
                ['instance' => $instanceName, 'createStatement' => $createStmt, 'extraStatements' => []],
                [$instanceName, $createStmt, ['extraStatements' => [], 'userHeaders' => ['google-cloud-resource-prefix' => [$instanceName]]]],
                $lro,
                null
            ],
            [
                'updateDatabaseDdl',
                ['name' => $databaseName, 'statements' => []],
                [$databaseName, [], ['userHeaders' => ['google-cloud-resource-prefix' => [$databaseName]]]],
                $lro,
                null
            ],
            [
                'dropDatabase',
                ['name' => $databaseName],
                [$databaseName, ['userHeaders' => ['google-cloud-resource-prefix' => [$databaseName]]]]
            ],
            [
                'getDatabaseDDL',
                ['name' => $databaseName],
                [$databaseName, ['userHeaders' => ['google-cloud-resource-prefix' => [$databaseName]]]]
            ],
            [
                'setDatabaseIamPolicy',
                ['resource' => $databaseName, 'policy' => $policy],
                [$databaseName, $policy, ['userHeaders' => ['google-cloud-resource-prefix' => [$databaseName]]]]
            ],
            [
                'getDatabaseIamPolicy',
                ['resource' => $databaseName],
                [$databaseName, ['userHeaders' => ['google-cloud-resource-prefix' => [$databaseName]]]]
            ],
            [
                'testDatabaseIamPermissions',
                ['resource' => $databaseName, 'permissions' => $permissions],
                [$databaseName, $permissions, ['userHeaders' => ['google-cloud-resource-prefix' => [$databaseName]]]]
            ],
            [
                'createSession',
                ['database' => $databaseName],
                [$databaseName, ['userHeaders' => ['google-cloud-resource-prefix' => [$databaseName]]]]
            ],
            [
                'getSession',
                ['name' => $sessionName, 'database' => $databaseName],
                [$sessionName, ['userHeaders' => ['google-cloud-resource-prefix' => [$databaseName]]]]
            ],
            [
                'deleteSession',
                ['name' => $sessionName, 'database' => $databaseName],
                [$sessionName, ['userHeaders' => ['google-cloud-resource-prefix' => [$databaseName]]]]
            ],
            [
                'executeStreamingSql',
                [
                    'session' => $sessionName,
                    'sql' => $sql,
                    'transactionId' => $transactionName,
                    'database' => $databaseName
                ] + $mapped,
                [$sessionName, $sql, [
                    'transaction' => $transactionSelector,
                    'params' => $expectedParams,
                    'paramTypes' => $expectedParamTypes,
                    'userHeaders' => ['google-cloud-resource-prefix' => [$databaseName]]
                ]]
            ],
            [
                'streamingRead',
                [
                    'keySet' => [],
                    'transactionId' => $transactionName,
                    'session' => $sessionName,
                    'table' => $tableName,
                    'columns' => $columns,
                    'database' => $databaseName,
                ],
                [$sessionName, $tableName, $columns, $keySet, ['transaction' => $transactionSelector, 'userHeaders' => ['google-cloud-resource-prefix' => [$databaseName]]]]
            ],
            [
                'streamingRead',
                [
                    'keySet' => ['keys' => [1]],
                    'transactionId' => $transactionName,
                    'session' => $sessionName,
                    'table' => $tableName,
                    'columns' => $columns,
                    'database' => $databaseName,
                ],
                [$sessionName, $tableName, $columns, $keySetSingular, ['transaction' => $transactionSelector, 'userHeaders' => ['google-cloud-resource-prefix' => [$databaseName]]]]
            ],
            [
                'streamingRead',
                [
                    'keySet' => ['keys' => [[1,1]]],
                    'transactionId' => $transactionName,
                    'session' => $sessionName,
                    'table' => $tableName,
                    'columns' => $columns,
                    'database' => $databaseName,
                ],
                [$sessionName, $tableName, $columns, $keySetComposite, ['transaction' => $transactionSelector, 'userHeaders' => ['google-cloud-resource-prefix' => [$databaseName]]]]
            ],
            // test read write
            [
                'beginTransaction',
                [
                    'session' => $sessionName,
                    'transactionOptions' => $readWriteTransactionArgs,
                    'database' => $databaseName
                ],
                [$sessionName, $readWriteTransactionOptions, ['userHeaders' => ['google-cloud-resource-prefix' => [$databaseName]]]]
            ],
            // test read only
            [
                'beginTransaction',
                [
                    'session' => $sessionName,
                    'transactionOptions' => $readOnlyTransactionArgs,
                    'database' => $databaseName
                ],
                [$sessionName, $readOnlyTransactionOptions, ['userHeaders' => ['google-cloud-resource-prefix' => [$databaseName]]]]
            ],
            // test insert
            // [
            //     'commit',
            //     ['session' => $sessionName, 'mutations' => $insertMutations],
            //     [$sessionName, $insertMutationsArr, []]
            // ],
            // test single-use transaction
            [
                'commit',
                [
                    'session' => $sessionName,
                    'mutations' => [],
                    'singleUseTransaction' => true,
                    'database' => $databaseName
                ],
                [$sessionName, [], ['singleUseTransaction' => $readWriteTransactionOptions, 'userHeaders' => ['google-cloud-resource-prefix' => [$databaseName]]]]
            ],
            [
                'rollback',
                [
                    'session' => $sessionName,
                    'transactionId' => $transactionName,
                    'database' => $databaseName
                ],
                [$sessionName, $transactionName, ['userHeaders' => ['google-cloud-resource-prefix' => [$databaseName]]]]
            ],
            // ['getOperation'],
            // ['cancelOperation'],
            // ['deleteOperation'],
            // ['listOperations']
        ];
    }
}
