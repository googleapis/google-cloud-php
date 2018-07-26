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

namespace Google\Cloud\Spanner\Tests\Unit\Connection;

use Google\ApiCore\Call;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\Serializer;
use Google\ApiCore\Transport\TransportInterface;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Spanner\Connection\Grpc;
use Google\Cloud\Spanner\V1\SpannerClient;
use Google\Cloud\Spanner\ValueMapper;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Protobuf\FieldMask;
use Google\Protobuf\Struct;
use Google\Cloud\Spanner\Admin\Instance\V1\Instance;
use Google\Cloud\Spanner\Admin\Instance\V1\Instance_State;
use Google\Cloud\Spanner\V1\Mutation_Write;
use Google\Cloud\Spanner\V1\TransactionOptions_ReadOnly;
use Google\Cloud\Spanner\V1\TransactionOptions_ReadWrite;
use Google\Cloud\Spanner\V1\DeleteSessionRequest;
use Google\Cloud\Spanner\V1\KeySet;
use Google\Cloud\Spanner\V1\Mutation;
use Google\Cloud\Spanner\V1\SpannerGrpcClient;
use Google\Cloud\Spanner\V1\TransactionOptions;
use Google\Cloud\Spanner\V1\TransactionSelector;
use Google\Cloud\Spanner\V1\Type;
use GuzzleHttp\Promise\PromiseInterface;
use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

/**
 * @group spanner
 */
class GrpcTest extends TestCase
{
    use GrpcTestTrait;
    use GrpcTrait;

    const PROJECT = 'projects/my-project';

    private $successMessage;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->requestWrapper = $this->prophesize(GrpcRequestWrapper::class);
        $this->successMessage = 'success';
    }

    public function testDeleteSessionAsync()
    {
        $promise = $this->prophesize(PromiseInterface::class)
            ->reveal();
        $sessionName = 'session1';
        $databaseName = 'database1';
        $request = new DeleteSessionRequest();
        $request->setName($sessionName);
        $client = $this->prophesize(SpannerClient::class);
        $transport = $this->prophesize(TransportInterface::class);
        $transport->startUnaryCall(
            Argument::type(Call::class),
            Argument::type('array')
        )->willReturn($promise);
        $client->getTransport()
            ->willReturn($transport->reveal());
        $grpc = new Grpc(['gapicSpannerClient' => $client->reveal()]);
        $call = $grpc->deleteSessionAsync([
            'name' => $sessionName,
            'database' => $databaseName
        ]);

        $this->assertInstanceOf(PromiseInterface::class, $call);
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
        $keySetSingular = $serializer->decodeMessage(new KeySet, [
            'keys' => [
                [
                    'values' => [
                        [
                            'number_value' => 1
                        ]
                    ]
                ],
            ]
        ]);

        $keySetComposite = $serializer->decodeMessage(new KeySet, [
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
        ]);

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
                [
                    'projectId' => self::PROJECT
                ], [
                    self::PROJECT,
                    [
                        'headers' => $this->header(self::PROJECT)
                    ]
                ]
            ], [
                'getInstanceConfig',
                [
                    'name' => $configName,
                    'projectId' => self::PROJECT
                ], [
                    $configName,
                    [
                        'headers' => $this->header(self::PROJECT)
                    ]
                ]
            ], [
                'listInstances',
                [
                    'projectId' => self::PROJECT
                ], [
                    self::PROJECT,
                    [
                        'headers' => $this->header(self::PROJECT)
                    ]
                ]
            ], [
                'getInstance',
                [
                    'name' => $instanceName,
                    'projectId' => self::PROJECT
                ], [
                    $instanceName,
                    [
                        'headers' => $this->header(self::PROJECT)
                    ]
                ]
            ], [
                'createInstance',
                [
                    'projectId' => self::PROJECT,
                    'instanceId' => $instanceName
                ] + $instanceArgs, [
                    self::PROJECT,
                    $instanceName,
                    $instance,
                    [
                        'headers' => $this->header($instanceName)
                    ]
                ],
                $lro,
                null
            ], [
                'updateInstance',
                $instanceArgs,
                [
                    $instance,
                    $fieldMask,
                    [
                        'headers' => $this->header($instanceName)
                    ]
                ],
                $lro,
                null
            ], [
                'updateInstance',
                $instanceArgsPartial,
                [
                    $instancePartial,
                    $fieldMaskPartial,
                    [
                        'headers' => $this->header($instanceName)
                    ]
                ],
                $lroPartial,
                null
            ], [
                'deleteInstance',
                [
                    'name' => $instanceName
                ], [
                    $instanceName, [
                        'headers' => $this->header($instanceName)
                    ]
                ]
            ], [
                'setInstanceIamPolicy',
                [
                    'resource' => $instanceName,
                    'policy' => $policy
                ], [
                    $instanceName,
                    $policy,
                    [
                        'headers' => $this->header($instanceName)
                    ]
                ]
            ], [
                'getInstanceIamPolicy',
                [
                    'resource' => $instanceName
                ], [
                    $instanceName,
                    [
                        'headers' => $this->header($instanceName)
                    ]
                ]
            ], [
                'testInstanceIamPermissions',
                [
                    'resource' => $instanceName,
                    'permissions' => $permissions
                ], [
                    $instanceName,
                    $permissions, [
                        'headers' => $this->header($instanceName)
                    ]
                ]
            ], [
                'listDatabases',
                [
                    'instance' => $instanceName
                ], [
                    $instanceName,
                    [
                        'headers' => $this->header($instanceName)
                    ]
                ]
            ], [
                'createDatabase',
                [
                    'instance' => $instanceName,
                    'createStatement' => $createStmt,
                    'extraStatements' => []
                ], [
                    $instanceName,
                    $createStmt,
                    [
                        'extraStatements' => [],
                        'headers' => $this->header($instanceName)
                    ]
                ],
                $lro,
                null
            ], [
                'updateDatabaseDdl',
                [
                    'name' => $databaseName,
                    'statements' => []
                ], [
                    $databaseName,
                    [],
                    [
                        'headers' => $this->header($databaseName)
                    ]
                ],
                $lro,
                null
            ], [
                'dropDatabase',
                [
                    'name' => $databaseName
                ], [
                    $databaseName, [
                        'headers' => $this->header($databaseName)
                    ]
                ]
            ], [
                'getDatabaseDDL',
                [
                    'name' => $databaseName
                ], [
                    $databaseName,
                    [
                        'headers' => $this->header($databaseName)
                    ]
                ]
            ], [
                'setDatabaseIamPolicy',
                [
                    'resource' => $databaseName,
                    'policy' => $policy
                ], [
                    $databaseName,
                    $policy,
                    [
                        'headers' => $this->header($databaseName)
                    ]
                ]
            ], [
                'getDatabaseIamPolicy',
                [
                    'resource' => $databaseName
                ], [
                    $databaseName,
                    [
                        'headers' => $this->header($databaseName)
                    ]
                ]
            ], [
                'testDatabaseIamPermissions',
                [
                    'resource' => $databaseName,
                    'permissions' => $permissions
                ], [
                    $databaseName,
                    $permissions,
                    [
                        'headers' => $this->header($databaseName)
                    ]
                ]
            ], [
                'createSession',
                [
                    'database' => $databaseName
                ], [
                    $databaseName,
                    [
                        'headers' => $this->header($databaseName)
                    ]
                ]
            ], [
                'getSession',
                [
                    'name' => $sessionName,
                    'database' => $databaseName
                ], [
                    $sessionName,
                    [
                        'headers' => $this->header($databaseName)
                    ]
                ]
            ], [
                'deleteSession',
                [
                    'name' => $sessionName,
                    'database' => $databaseName
                ], [
                    $sessionName,
                    [
                        'headers' => $this->header($databaseName)
                    ]
                ]
            ], [
                'executeStreamingSql',
                [
                    'session' => $sessionName,
                    'sql' => $sql,
                    'transactionId' => $transactionName,
                    'database' => $databaseName
                ] + $mapped, [
                    $sessionName,
                    $sql, [
                        'transaction' => $transactionSelector,
                        'params' => $expectedParams,
                        'paramTypes' => $expectedParamTypes,
                        'headers' => $this->header($databaseName)
                    ]
                ]
            ], [
                'streamingRead',
                [
                    'keySet' => [],
                    'transactionId' => $transactionName,
                    'session' => $sessionName,
                    'table' => $tableName,
                    'columns' => $columns,
                    'database' => $databaseName,
                ], [
                    $sessionName,
                    $tableName,
                    $columns,
                    $keySet,
                    [
                        'transaction' => $transactionSelector,
                        'headers' => $this->header($databaseName)
                    ]
                ]
            ], [
                'streamingRead',
                [
                    'keySet' => ['keys' => [1]],
                    'transactionId' => $transactionName,
                    'session' => $sessionName,
                    'table' => $tableName,
                    'columns' => $columns,
                    'database' => $databaseName,
                ], [
                    $sessionName,
                    $tableName,
                    $columns,
                    $keySetSingular,
                    [
                        'transaction' => $transactionSelector,
                        'headers' => $this->header($databaseName)
                    ]
                ]
            ], [
                'streamingRead',
                [
                    'keySet' => ['keys' => [[1,1]]],
                    'transactionId' => $transactionName,
                    'session' => $sessionName,
                    'table' => $tableName,
                    'columns' => $columns,
                    'database' => $databaseName,
                ], [
                    $sessionName,
                    $tableName,
                    $columns,
                    $keySetComposite,
                    [
                        'transaction' => $transactionSelector,
                        'headers' => $this->header($databaseName)
                    ]
                ]
            ],
            // test read write
            [
                'beginTransaction',
                [
                    'session' => $sessionName,
                    'transactionOptions' => $readWriteTransactionArgs,
                    'database' => $databaseName
                ], [
                    $sessionName,
                    $readWriteTransactionOptions,
                    [
                        'headers' => $this->header($databaseName)
                    ]
                ]
            ],
            // test read only
            [
                'beginTransaction',
                [
                    'session' => $sessionName,
                    'transactionOptions' => $readOnlyTransactionArgs,
                    'database' => $databaseName
                ], [
                    $sessionName,
                    $readOnlyTransactionOptions,
                    [
                        'headers' => $this->header($databaseName)
                    ]
                ]
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
                ], [
                    $sessionName,
                    [],
                    [
                        'singleUseTransaction' => $readWriteTransactionOptions,
                        'headers' => $this->header($databaseName)
                    ]
                ]
            ], [
                'rollback',
                [
                    'session' => $sessionName,
                    'transactionId' => $transactionName,
                    'database' => $databaseName
                ], [
                    $sessionName,
                    $transactionName,
                    [
                        'headers' => $this->header($databaseName)
                    ]
                ]
            ],
            // ['getOperation'],
            // ['cancelOperation'],
            // ['deleteOperation'],
            // ['listOperations']
        ];
    }

    private function header($val)
    {
        return [
            'google-cloud-resource-prefix' => [$val]
        ];
    }
}
