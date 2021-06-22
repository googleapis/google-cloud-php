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
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Spanner\Admin\Database\V1\Backup;
use Google\Cloud\Spanner\Admin\Database\V1\CreateBackupEncryptionConfig;
use Google\Cloud\Spanner\Admin\Database\V1\EncryptionConfig;
use Google\Cloud\Spanner\Admin\Database\V1\RestoreDatabaseEncryptionConfig;
use Google\Cloud\Spanner\Admin\Instance\V1\Instance;
use Google\Cloud\Spanner\Admin\Instance\V1\Instance\State;
use Google\Cloud\Spanner\Connection\Grpc;
use Google\Cloud\Spanner\V1\DeleteSessionRequest;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlRequest\Statement;
use Google\Cloud\Spanner\V1\ExecuteSqlRequest\QueryOptions;
use Google\Cloud\Spanner\V1\KeySet;
use Google\Cloud\Spanner\V1\Mutation;
use Google\Cloud\Spanner\V1\Mutation\Delete;
use Google\Cloud\Spanner\V1\Mutation\Write;
use Google\Cloud\Spanner\V1\PartitionOptions;
use Google\Cloud\Spanner\V1\RequestOptions;
use Google\Cloud\Spanner\V1\Session;
use Google\Cloud\Spanner\V1\SpannerClient;
use Google\Cloud\Spanner\V1\TransactionOptions;
use Google\Cloud\Spanner\V1\TransactionOptions\PartitionedDml;
use Google\Cloud\Spanner\V1\TransactionOptions\ReadOnly;
use Google\Cloud\Spanner\V1\TransactionOptions\ReadWrite;
use Google\Cloud\Spanner\V1\TransactionSelector;
use Google\Cloud\Spanner\V1\Type;
use Google\Cloud\Spanner\ValueMapper;
use Google\Protobuf\FieldMask;
use Google\Protobuf\ListValue;
use Google\Protobuf\NullValue;
use Google\Protobuf\Struct;
use Google\Protobuf\Timestamp;
use Google\Protobuf\Value;
use GuzzleHttp\Promise\PromiseInterface;
use http\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group spanner
 * @group spanner-grpc
 */
class GrpcTest extends TestCase
{
    use GrpcTestTrait;
    use GrpcTrait;

    const CONFIG = 'projects/my-project/instanceConfigs/config-1';
    const DATABASE = 'projects/my-project/instances/instance-1/databases/database-1';
    const INSTANCE = 'projects/my-project/instances/instance-1';
    const PROJECT = 'projects/my-project';
    const SESSION = 'projects/my-project/instances/instance-1/databases/database-1/sessions/session-1';
    const TABLE = 'table-1';
    const TRANSACTION = 'transaction-1';

    private $requestWrapper;
    private $serializer;
    private $successMessage;
    private $lro;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->requestWrapper = $this->prophesize(GrpcRequestWrapper::class);
        $this->serializer = new Serializer;
        $this->successMessage = 'success';
        $this->lro = $this->prophesize(OperationResponse::class)->reveal();
    }

    public function testApiEndpoint()
    {
        $expected = 'foobar.com';

        $grpc = new GrpcStub(['apiEndpoint' => $expected]);

        $this->assertEquals($expected, $grpc->config['apiEndpoint']);
    }

    public function testListInstanceConfigs()
    {
        $this->assertCallCorrect('listInstanceConfigs', [
            'projectName' => self::PROJECT
        ], $this->expectResourceHeader(self::PROJECT, [
            self::PROJECT
        ]));
    }

    public function testGetInstanceConfig()
    {
        $this->assertCallCorrect('getInstanceConfig', [
            'name' => self::CONFIG,
            'projectName' => self::PROJECT
        ], $this->expectResourceHeader(self::PROJECT, [
            self::CONFIG
        ]));
    }

    public function testListInstances()
    {
        $this->assertCallCorrect('listInstances', [
            'projectName' => self::PROJECT
        ], $this->expectResourceHeader(self::PROJECT, [
            self::PROJECT
        ]));
    }

    public function testGetInstance()
    {
        $this->assertCallCorrect('getInstance', [
            'name' => self::INSTANCE,
            'projectName' => self::PROJECT
        ], $this->expectResourceHeader(self::PROJECT, [
            self::INSTANCE
        ]));
    }

    public function testGetInstanceWithFieldMaskArray()
    {
        $fieldNames = ['name', 'displayName', 'nodeCount'];

        $mask = [];
        foreach (array_values($fieldNames) as $key) {
            $mask[] = Serializer::toSnakeCase($key);
        }

        $fieldMask = $this->serializer->decodeMessage(new FieldMask, ['paths' => $mask]);
        $this->assertCallCorrect('getInstance', [
            'name' => self::INSTANCE,
            'projectName' => self::PROJECT,
            'fieldMask' => $fieldNames
        ], $this->expectResourceHeader(self::PROJECT, [
            self::INSTANCE,
            ['fieldMask' => $fieldMask]
        ]));
    }

    public function testGetInstanceWithFieldMaskString()
    {
        $fieldNames = 'nodeCount';
        $mask[] = Serializer::toSnakeCase($fieldNames);

        $fieldMask = $this->serializer->decodeMessage(new FieldMask, ['paths' => $mask]);
        $this->assertCallCorrect('getInstance', [
            'name' => self::INSTANCE,
            'projectName' => self::PROJECT,
            'fieldMask' => $fieldNames
        ], $this->expectResourceHeader(self::PROJECT, [
            self::INSTANCE,
            ['fieldMask' => $fieldMask]
        ]));
    }

    public function testCreateInstance()
    {
        list ($args, $instance) = $this->instance();

        $this->assertCallCorrect('createInstance', [
            'projectName' => self::PROJECT,
            'instanceId' => self::INSTANCE
        ] + $args, $this->expectResourceHeader(self::INSTANCE, [
            self::PROJECT,
            self::INSTANCE,
            $instance
        ]), $this->lro, null);
    }

    public function testUpdateInstance()
    {
        list ($args, $instance, $fieldMask) = $this->instance(false);

        $this->assertCallCorrect('updateInstance', $args, $this->expectResourceHeader(self::INSTANCE, [
            $instance, $fieldMask
        ]), $this->lro, null);
    }

    public function testDeleteInstance()
    {
        $this->assertCallCorrect('deleteInstance', [
            'name' => self::INSTANCE
        ], $this->expectResourceHeader(self::INSTANCE, [
            self::INSTANCE
        ]));
    }

    public function testSetInstanceIamPolicy()
    {
        $policy = ['foo' => 'bar'];

        $this->assertCallCorrect('setInstanceIamPolicy', [
            'resource' => self::INSTANCE,
            'policy' => $policy
        ], $this->expectResourceHeader(self::INSTANCE, [
            self::INSTANCE,
            $policy
        ], false));
    }

    public function testGetInstanceIamPolicy()
    {
        $this->assertCallCorrect('getInstanceIamPolicy', [
            'resource' => self::INSTANCE
        ], $this->expectResourceHeader(self::INSTANCE, [
            self::INSTANCE
        ]));
    }

    public function testTestInstanceIamPermissions()
    {
        $permissions = ['permission1', 'permission2'];
        $this->assertCallCorrect('testInstanceIamPermissions', [
            'resource' => self::INSTANCE,
            'permissions' => $permissions
        ], $this->expectResourceHeader(self::INSTANCE, [
            self::INSTANCE,
            $permissions
        ], false));
    }

    public function testListDatabases()
    {
        $this->assertCallCorrect('listDatabases', [
            'instance' => self::INSTANCE
        ], $this->expectResourceHeader(self::INSTANCE, [
            self::INSTANCE
        ]));
    }

    public function testCreateDatabase()
    {
        $createStmt = 'CREATE Foo';
        $extraStmts = [
            'CREATE TABLE Bar'
        ];
        $encryptionConfig = ['kmsKeyName' => 'kmsKeyName'];
        $expectedEncryptionConfig = $this->serializer->decodeMessage(new EncryptionConfig, $encryptionConfig);

        $this->assertCallCorrect('createDatabase', [
            'instance' => self::INSTANCE,
            'createStatement' => $createStmt,
            'extraStatements' => $extraStmts,
            'encryptionConfig' => $encryptionConfig
        ], $this->expectResourceHeader(self::INSTANCE, [
            self::INSTANCE,
            $createStmt,
            [
                'extraStatements' => $extraStmts,
                'encryptionConfig' => $expectedEncryptionConfig
            ]
        ]), $this->lro, null);
    }

    public function testCreateBackup()
    {
        $backupId = "backup-id";
        $expireTime = new \DateTime("+ 7 hours");
        $backup = [
            'database' => self::DATABASE,
            'expireTime' => $expireTime->format('Y-m-d\TH:i:s.u\Z')
        ];
        $expectedBackup = $this->serializer->decodeMessage(new Backup(), [
            'expireTime' => $this->formatTimestampForApi($backup['expireTime'])
        ] + $backup);

        $encryptionConfig = [
            'kmsKeyName' => 'kmsKeyName',
            'encryptionType' => CreateBackupEncryptionConfig\EncryptionType::CUSTOMER_MANAGED_ENCRYPTION
        ];
        $expectedEncryptionConfig = $this->serializer->decodeMessage(
            new CreateBackupEncryptionConfig,
            $encryptionConfig
        );

        $this->assertCallCorrect('createBackup', [
            'instance' => self::INSTANCE,
            'backupId' => $backupId,
            'backup' => $backup,
            'encryptionConfig' => $encryptionConfig
        ], $this->expectResourceHeader(self::INSTANCE, [
            self::INSTANCE,
            $backupId,
            $expectedBackup,
            [
                'encryptionConfig' => $expectedEncryptionConfig
            ]
        ]), $this->lro, null);
    }

    public function testRestoreDatabase()
    {
        $databaseId = 'test-database';
        $encryptionConfig = [
            'kmsKeyName' => 'kmsKeyName',
            'encryptionType' => RestoreDatabaseEncryptionConfig\EncryptionType::CUSTOMER_MANAGED_ENCRYPTION
        ];
        $expectedEncryptionConfig = $this->serializer->decodeMessage(
            new RestoreDatabaseEncryptionConfig,
            $encryptionConfig
        );

        $this->assertCallCorrect('restoreDatabase', [
            'instance' => self::INSTANCE,
            'databaseId' => $databaseId,
            'encryptionConfig' => $encryptionConfig
        ], $this->expectResourceHeader(self::INSTANCE, [
            self::INSTANCE,
            $databaseId,
            [
                'encryptionConfig' => $expectedEncryptionConfig
            ]
        ]), $this->lro, null);
    }

    public function testUpdateDatabaseDdl()
    {
        $statements = [
            'CREATE TABLE Bar'
        ];

        $this->assertCallCorrect('updateDatabaseDdl', [
            'name' => self::DATABASE,
            'statements' => $statements
        ], $this->expectResourceHeader(self::DATABASE, [
            self::DATABASE,
            $statements
        ], false), $this->lro, null);
    }

    public function testDropDatabase()
    {
        $this->assertCallCorrect('dropDatabase', [
            'name' => self::DATABASE
        ], $this->expectResourceHeader(self::DATABASE, [
            self::DATABASE
        ]));
    }

    public function testGetDatabase()
    {
        $this->assertCallCorrect('getDatabase', [
            'name' => self::DATABASE
        ], $this->expectResourceHeader(self::DATABASE, [
            self::DATABASE
        ]));
    }

    public function testGetDatabaseDdl()
    {
        $this->assertCallCorrect('getDatabaseDdl', [
            'name' => self::DATABASE
        ], $this->expectResourceHeader(self::DATABASE, [
            self::DATABASE
        ]));
    }

    public function testSetDatabaseIamPolicy()
    {
        $policy = ['foo' => 'bar'];

        $this->assertCallCorrect('setDatabaseIamPolicy', [
            'resource' => self::DATABASE,
            'policy' => $policy
        ], $this->expectResourceHeader(self::DATABASE, [
            self::DATABASE,
            $policy
        ], false));
    }

    public function testGetDatabaseIamPolicy()
    {
        $this->assertCallCorrect('getDatabaseIamPolicy', [
            'resource' => self::DATABASE
        ], $this->expectResourceHeader(self::DATABASE, [
            self::DATABASE
        ]));
    }

    public function testTestDatabaseIamPermissions()
    {
        $permissions = ['permission1', 'permission2'];
        $this->assertCallCorrect('testDatabaseIamPermissions', [
            'resource' => self::DATABASE,
            'permissions' => $permissions
        ], $this->expectResourceHeader(self::DATABASE, [
            self::DATABASE,
            $permissions
        ], false));
    }

    public function testCreateSession()
    {
        $labels = ['foo' => 'bar'];

        $this->assertCallCorrect('createSession', [
            'database' => self::DATABASE,
            'session' => [
                'labels' => $labels
            ]
        ], $this->expectResourceHeader(self::DATABASE, [
            self::DATABASE,
            [
                'session' => (new Session)->setLabels($labels)
            ]
        ]));
    }

    public function testCreateSessionAsync()
    {
        $promise = $this->prophesize(PromiseInterface::class)->reveal();
        $client = $this->prophesize(SpannerClient::class);
        $transport = $this->prophesize(TransportInterface::class);
        $transport->startUnaryCall(
            Argument::type(Call::class),
            Argument::type('array')
        )->willReturn($promise);

        $client->getTransport()->willReturn($transport->reveal());

        $grpc = new Grpc(['gapicSpannerClient' => $client->reveal()]);

        $promise = $grpc->createSessionAsync([
            'database' => 'database1',
            'session' => [
                'labels' => [ 'foo' => 'bar' ]
            ]
        ]);

        $this->assertInstanceOf(PromiseInterface::class, $promise);
    }

    public function testBatchCreateSessions()
    {
        $count = 10;
        $template = [
            'labels' => [
                'foo' => 'bar'
            ]
        ];

        $this->assertCallCorrect('batchCreateSessions', [
            'database' => self::DATABASE,
            'sessionCount' => $count,
            'sessionTemplate' => $template
        ], $this->expectResourceHeader(self::DATABASE, [
            self::DATABASE, $count, [
                'sessionTemplate' => $this->serializer->decodeMessage(new Session, $template)
            ]
        ]));
    }

    public function testGetSession()
    {
        $this->assertCallCorrect('getSession', [
            'database' => self::DATABASE,
            'name' => self::SESSION
        ], $this->expectResourceHeader(self::DATABASE, [
            self::SESSION
        ]));
    }

    public function testDeleteSession()
    {
        $this->assertCallCorrect('deleteSession', [
            'database' => self::DATABASE,
            'name' => self::SESSION
        ], $this->expectResourceHeader(self::DATABASE, [
            self::SESSION
        ]));
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

    public function testExecuteStreamingSql()
    {
        $sql = 'SELECT 1';

        $mapper = new ValueMapper(false);
        $mapped = $mapper->formatParamsForExecuteSql(['foo' => 'bar']);

        $expectedParams = $this->serializer->decodeMessage(
            new Struct,
            $this->formatStructForApi($mapped['params'])
        );

        $expectedParamTypes = $mapped['paramTypes'];
        foreach ($expectedParamTypes as $key => $param) {
            $expectedParamTypes[$key] = $this->serializer->decodeMessage(new Type, $param);
        }

        $this->assertCallCorrect('executeStreamingSql', [
            'session' => self::SESSION,
            'sql' => $sql,
            'transactionId' => self::TRANSACTION,
            'database' => self::DATABASE
        ] + $mapped, $this->expectResourceHeader(self::DATABASE, [
            self::SESSION,
            $sql,
            [
                'transaction' => $this->transactionSelector(),
                'params' => $expectedParams,
                'paramTypes' => $expectedParamTypes
            ]
        ]));
    }

    public function testExecuteStreamingSqlWithRequestOptions()
    {
        $sql = 'SELECT 1';
        $requestOptions = ["priority" => RequestOptions\Priority::PRIORITY_LOW];
        $expectedRequestOptions = $this->serializer->decodeMessage(
            new RequestOptions,
            $requestOptions
        );

        $this->assertCallCorrect('executeStreamingSql', [
                'session' => self::SESSION,
                'sql' => $sql,
                'transactionId' => self::TRANSACTION,
                'database' => self::DATABASE,
                'params' => [],
                'requestOptions' => $requestOptions
            ], $this->expectResourceHeader(self::DATABASE, [
                self::SESSION,
                $sql,
                [
                    'transaction' => $this->transactionSelector(),
                    'requestOptions' => $expectedRequestOptions
                ]
            ]));
    }

    /**
     * @dataProvider queryOptions
     */
    public function testExecuteStreamingSqlWithQueryOptions(
        array $methodOptions,
        array $envOptions,
        array $clientOptions,
        array $expectedOptions
    ) {
        $sql = 'SELECT 1';

        if (array_key_exists('optimizerVersion', $envOptions)) {
            putenv('SPANNER_OPTIMIZER_VERSION=' . $envOptions['optimizerVersion']);
        }
        if (array_key_exists('optimizerStatisticsPackage', $envOptions)) {
            putenv('SPANNER_OPTIMIZER_STATISTICS_PACKAGE=' . $envOptions['optimizerStatisticsPackage']);
        }
        $gapic = $this->prophesize(SpannerClient::class);
        $gapic->executeStreamingSql(
            self::SESSION,
            $sql,
            Argument::withEntry('queryOptions', $expectedOptions)
        );

        $grpc = new Grpc([
            'gapicSpannerClient' => $gapic->reveal()
        ] + ['queryOptions' => $clientOptions]);

        $grpc->executeStreamingSql([
            'database' => self::DATABASE,
            'session' => self::SESSION,
            'sql' => $sql,
            'params' => []
        ] + ['queryOptions' => $methodOptions]);

        if ($envOptions) {
            putenv('SPANNER_OPTIMIZER_VERSION=');
            putenv('SPANNER_OPTIMIZER_STATISTICS_PACKAGE=');
        }
    }

    public function queryOptions()
    {
        return [
            [
                ['optimizerVersion' => '8'],
                [
                    'optimizerVersion' => '7',
                    'optimizerStatisticsPackage' => "auto_20191128_18_47_22UTC",
                ],
                ['optimizerStatisticsPackage' => "auto_20191128_14_47_22UTC"],
                [
                    'optimizerVersion' => '8',
                    'optimizerStatisticsPackage' => "auto_20191128_18_47_22UTC",
                ]
            ],
            [
                [],
                ['optimizerVersion' => '7'],
                [
                    'optimizerVersion' => '6',
                    'optimizerStatisticsPackage' => "auto_20191128_14_47_22UTC",
                ],
                [
                    'optimizerVersion' => '7',
                    'optimizerStatisticsPackage' => "auto_20191128_14_47_22UTC",
                ]
            ],
            [
                ['optimizerStatisticsPackage' => "auto_20191128_23_47_22UTC"],
                [],
                [
                    'optimizerVersion' => '6',
                    'optimizerStatisticsPackage' => "auto_20191128_14_47_22UTC",
                ],
                [
                    'optimizerVersion' => '6',
                    'optimizerStatisticsPackage' => "auto_20191128_23_47_22UTC",
                ]
            ],
            [
                [],
                [],
                [],
                []
            ]
        ];
    }

    /**
     * @dataProvider readKeysets
     */
    public function testStreamingRead($keyArg, $keyObj)
    {
        $columns = [
            'id',
            'name'
        ];

        $this->assertCallCorrect('streamingRead', [
            'keySet' => $keyArg,
            'transactionId' => self::TRANSACTION,
            'session' => self::SESSION,
            'table' => self::TABLE,
            'columns' => $columns,
            'database' => self::DATABASE
        ], $this->expectResourceHeader(self::DATABASE, [
            self::SESSION,
            self::TABLE,
            $columns,
            $keyObj,
            [
                'transaction' => $this->transactionSelector()
            ]
        ]));
    }

    public function testStreamingReadWithRequestOptions()
    {
        $columns = [
            'id',
            'name'
        ];
        $requestOptions = ['priority' => RequestOptions\Priority::PRIORITY_LOW];
        $expectedRequestOptions = $this->serializer->decodeMessage(
            new RequestOptions,
            $requestOptions
        );

        $this->assertCallCorrect('streamingRead', [
            'keySet' => [],
            'transactionId' => self::TRANSACTION,
            'session' => self::SESSION,
            'table' => self::TABLE,
            'columns' => $columns,
            'database' => self::DATABASE,
            'requestOptions' => $requestOptions
        ], $this->expectResourceHeader(self::DATABASE, [
            self::SESSION,
            self::TABLE,
            $columns,
            new KeySet,
            [
                'transaction' => $this->transactionSelector(),
                'requestOptions' => $expectedRequestOptions
            ]
        ]));
    }

    public function readKeysets()
    {
        $this->setUp();

        return [
            [
                [],
                new KeySet
            ], [
                ['keys' => [1]],
                $this->serializer->decodeMessage(new KeySet, [
                    'keys' => [
                        [
                            'values' => [
                                [
                                    'number_value' => 1
                                ]
                            ]
                        ]
                    ]
                ])
            ], [
                ['keys' => [[1,1]]],
                $this->serializer->decodeMessage(new KeySet, [
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
                ])
            ]
        ];
    }

    public function testExecuteBatchDml()
    {
        $statements = [
            [
                'sql' => 'SELECT 1',
                'params' => []
            ]
        ];

        $statementsObjs = [
            new Statement([
                'sql' => 'SELECT 1'
            ])
        ];

        $this->assertCallCorrect('executeBatchDml', [
            'session' => self::SESSION,
            'database' => self::DATABASE,
            'transactionId' => self::TRANSACTION,
            'statements' => $statements,
            'seqno' => 1
        ], $this->expectResourceHeader(self::DATABASE, [
            self::SESSION,
            $this->transactionSelector(),
            $statementsObjs,
            1
        ]));
    }

    public function testExecuteBatchDmlWithRequestOptions()
    {
        $statements = [
            [
                'sql' => 'SELECT 1',
                'params' => []
            ]
        ];

        $statementsObjs = [
            new Statement([
                'sql' => 'SELECT 1'
            ])
        ];
        $requestOptions = ['priority' => RequestOptions\Priority::PRIORITY_LOW];
        $expectedRequestOptions = $this->serializer->decodeMessage(
            new RequestOptions,
            $requestOptions
        );


        $this->assertCallCorrect('executeBatchDml', [
            'session' => self::SESSION,
            'database' => self::DATABASE,
            'transactionId' => self::TRANSACTION,
            'statements' => $statements,
            'seqno' => 1,
            'requestOptions' => $requestOptions
        ], $this->expectResourceHeader(self::DATABASE, [
            self::SESSION,
            $this->transactionSelector(),
            $statementsObjs,
            1,
            ['requestOptions' => $expectedRequestOptions]
        ]));
    }

    /**
     * @dataProvider transactionTypes
     */
    public function testBeginTransaction($optionsArr, $optionsObj)
    {
        $this->assertCallCorrect('beginTransaction', [
            'session' => self::SESSION,
            'transactionOptions' => $optionsArr,
            'database' => self::DATABASE
        ], $this->expectResourceHeader(self::DATABASE, [
            self::SESSION,
            $optionsObj
        ]));
    }

    public function transactionTypes()
    {
        $ts = (new \DateTime)->format('Y-m-d\TH:i:s.u\Z');
        $pbTs = new Timestamp($this->formatTimestampForApi($ts));

        return [
            [
                ['readWrite' => []],
                new TransactionOptions([
                    'read_write' => new ReadWrite
                ])
            ], [
                [
                    'readOnly' => [
                        'minReadTimestamp' => $ts,
                        'readTimestamp' => $ts
                    ]
                ],
                new TransactionOptions([
                    'read_only' => new ReadOnly([
                        'min_read_timestamp' => $pbTs,
                        'read_timestamp' => $pbTs
                    ])
                ])
            ], [
                ['partitionedDml' => []],
                new TransactionOptions([
                    'partitioned_dml' => new PartitionedDml
                ])
            ]
        ];
    }

    /**
     * @dataProvider commit
     */
    public function testCommit($mutationsArr, $mutationsObjArr)
    {
        $this->assertCallCorrect('commit', [
            'session' => self::SESSION,
            'mutations' => $mutationsArr,
            'singleUseTransaction' => true,
            'database' => self::DATABASE
        ], $this->expectResourceHeader(self::DATABASE, [
            self::SESSION,
            $mutationsObjArr,
            [
                'singleUseTransaction' => new TransactionOptions([
                    'read_write' => new ReadWrite
                ])
            ]
        ]));
    }

    /**
     * @dataProvider commit
     */
    public function testCommitWithRequestOptions($mutationsArr, $mutationsObjArr)
    {
        $requestOptions = ['priority' => RequestOptions\Priority::PRIORITY_LOW];
        $expectedRequestOptions = $this->serializer->decodeMessage(
            new RequestOptions,
            $requestOptions
        );
        $this->assertCallCorrect('commit', [
            'session' => self::SESSION,
            'mutations' => $mutationsArr,
            'singleUseTransaction' => true,
            'database' => self::DATABASE,
            'requestOptions' => $requestOptions
        ], $this->expectResourceHeader(self::DATABASE, [
            self::SESSION,
            $mutationsObjArr,
            [
                'singleUseTransaction' => new TransactionOptions([
                    'read_write' => new ReadWrite
                ]),
                'requestOptions' => $expectedRequestOptions
            ]
        ]));
    }

    public function commit()
    {
        $mutation = [
            'table' => self::TABLE,
            'columns' => [
                'col1'
            ],
            'values' => [
                'val1'
            ]
        ];

        $write = new Write([
            'table' => self::TABLE,
            'columns' => ['col1'],
            'values' => [
                new ListValue([
                    'values' => [
                        new Value([
                            'string_value' => 'val1'
                        ])
                    ]
                ])
            ]
        ]);

        return [
            [
                [], []
            ], [
                [
                    [
                        'delete' => [
                            'table' => self::TABLE,
                            'keySet' => []
                        ]
                    ]
                ],
                [
                    new Mutation([
                        'delete' => new Delete([
                            'table' => self::TABLE,
                            'key_set' => new KeySet
                        ])
                    ])
                ]
            ], [
                [
                    [
                        'insert' => $mutation
                    ]
                ],
                [
                    new Mutation([
                        'insert' => $write
                    ])
                ]
            ], [
                [
                    [
                        'update' => $mutation
                    ]
                ],
                [
                    new Mutation([
                        'update' => $write
                    ])
                ]
            ], [
                [
                    [
                        'insertOrUpdate' => $mutation
                    ]
                ],
                [
                    new Mutation([
                        'insert_or_update' => $write
                    ])
                ]
            ], [
                [
                    [
                        'replace' => $mutation
                    ]
                ],
                [
                    new Mutation([
                        'replace' => $write
                    ])
                ]
            ]
        ];
    }

    public function testRollback()
    {
        $this->assertCallCorrect('rollback', [
            'session' => self::SESSION,
            'transactionId' => self::TRANSACTION,
            'database' => self::DATABASE
        ], $this->expectResourceHeader(self::DATABASE, [
            self::SESSION,
            self::TRANSACTION
        ]));
    }

    /**
     * @dataProvider partitionOptions
     */
    public function testPartitionQuery($partitionOptions, $partitionOptionsObj)
    {
        $sql = 'SELECT 1';
        $this->assertCallCorrect('partitionQuery', [
            'session' => self::SESSION,
            'sql' => $sql,
            'params' => [],
            'transactionId' => self::TRANSACTION,
            'database' => self::DATABASE,
            'partitionOptions' => $partitionOptions,
        ], $this->expectResourceHeader(self::DATABASE, [
            self::SESSION,
            $sql,
            [
                'transaction' => $this->transactionSelector(),
                'partitionOptions' => $partitionOptionsObj
            ]
        ]));
    }

    /**
     * @dataProvider partitionOptions
     */
    public function testPartitionRead($partitionOptions, $partitionOptionsObj)
    {
        $this->assertCallCorrect('partitionRead', [
            'session' => self::SESSION,
            'keySet' => [],
            'table' => self::TABLE,
            'transactionId' => self::TRANSACTION,
            'database' => self::DATABASE,
            'partitionOptions' => $partitionOptions,
        ], $this->expectResourceHeader(self::DATABASE, [
            self::SESSION,
            self::TABLE,
            new KeySet,
            [
                'transaction' => $this->transactionSelector(),
                'partitionOptions' => $partitionOptionsObj
            ]
        ]));
    }

    public function partitionOptions()
    {
        return [
            [
                [],
                new PartitionOptions
            ],
            [
                ['maxPartitions' => 10],
                new PartitionOptions([
                    'max_partitions' => 10
                ])
            ]
        ];
    }

    /**
     * @dataProvider keysets
     */
    public function testFormatKeySet($input, $expected)
    {
        $this->assertEquals(
            $expected,
            $this->callPrivateMethod('formatKeySet', [$input])
        );
    }

    public function keysets()
    {
        return [
            [
                [],
                []
            ], [
                [
                    'keys' => [
                        [
                            1,
                            2
                        ]
                    ]
                ],
                [
                    'keys' => [
                        $this->formatListForApi([1, 2])
                    ]
                ]
            ], [
                [
                    'ranges' => [
                        [
                            'startOpen' => [1],
                            'endClosed' => [2]
                        ]
                    ],
                ], [
                    'ranges' => [
                        [
                            'startOpen' => $this->formatListForApi([1]),
                            'endClosed' => $this->formatListForApi([2]),
                        ]
                    ]
                ]
            ], [
                [
                    'ranges' => []
                ],
                []
            ]
        ];
    }

    /**
     * @dataProvider fieldvalues
     */
    public function testFieldValue($input, $expected)
    {
        $this->assertEquals(
            $expected,
            $this->callPrivateMethod('fieldValue', [$input])
        );
    }

    public function fieldvalues()
    {
        return [
            [
                'foo',
                new Value([
                    'string_value' => 'foo'
                ])
            ], [
                1,
                new Value([
                    'number_value' => 1
                ])
            ], [
                false,
                new Value([
                    'bool_value' => false
                ])
            ], [
                null,
                new Value([
                    'null_value' => NullValue::NULL_VALUE
                ])
            ], [
                [
                    'a' => 'b'
                ],
                new Value([
                    'struct_value' => new Struct([
                        'fields' => [
                            'a' => new Value([
                                'string_value' => 'b'
                            ])
                        ]
                    ])
                ])
            ], [
                [
                    'a', 'b', 'c'
                ],
                new Value([
                    'list_value' => new ListValue([
                        'values' => [
                            new Value([
                                'string_value' => 'a'
                            ]),
                            new Value([
                                'string_value' => 'b'
                            ]),
                            new Value([
                                'string_value' => 'c'
                            ]),
                        ]
                    ])
                ])
            ]
        ];
    }

    /**
     * @dataProvider transactionOptions
     */
    public function testTransactionOptions($input, $expected)
    {
        // Since the tested method uses pass-by-reference arg, the callPrivateMethod function won't work.
        // test on php7 only is better than nothing.
        if (version_compare(PHP_VERSION, '7.0.0', '<')) {
            $this->markTestSkipped('only works in php 7.');
            return;
        }

        $grpc = new Grpc;
        $createTransactionSelector = function () {
            $args = func_get_args();
            return $this->createTransactionSelector($args[0]);
        };

        $this->assertEquals(
            $expected->serializeToJsonString(),
            $createTransactionSelector->call($grpc, $input)->serializeToJsonString()
        );
    }

    public function transactionOptions()
    {
        return [
            [
                [
                    'transactionId' => self::TRANSACTION
                ],
                $this->transactionSelector()
            ], [
                [
                    'transaction' => [
                        'singleUse' => [
                            'readWrite' => []
                        ]
                    ]
                ],
                new TransactionSelector([
                    'single_use' => new TransactionOptions([
                        'read_write' => new ReadWrite
                    ])
                ])
            ], [
                [
                    'transaction' => [
                        'begin' => [
                            'readWrite' => []
                        ]
                    ]
                ],
                new TransactionSelector([
                    'begin' => new TransactionOptions([
                        'read_write' => new ReadWrite
                    ])
                ])
            ]
        ];
    }

    private function assertCallCorrect($method, array $args, array $expectedArgs, $return = null, $result = '')
    {
        $this->requestWrapper->send(
            Argument::type('callable'),
            $expectedArgs,
            Argument::type('array')
        )->willReturn($return ?: $this->successMessage);

        $connection = new Grpc();
        $connection->setRequestWrapper($this->requestWrapper->reveal());

        $this->assertEquals($result !== '' ? $result : $this->successMessage, $connection->$method($args));
    }

    /**
     * Add the resource header to the args list.
     *
     * @param string $val The header value to add.
     * @param array $args The remaining call args.
     * @param boolean $append If true, should the last value in $args be an
     *     array, the header will be appended to that array. If false, the
     *     header will be added to a separate array.
     * @return array
     */
    private function expectResourceHeader($val, array $args, $append = true)
    {
        $header = [
            'google-cloud-resource-prefix' => [$val]
        ];

        $end = end($args);
        if (!is_array($end) || !$append) {
            $args[]['headers'] = $header;
        } elseif (is_array($end)) {
            $keys = array_keys($args);
            $key = end($keys);
            $args[$key]['headers'] = $header;
        }

        return $args;
    }

    private function callPrivateMethod($method, array $args)
    {
        $grpc = new Grpc;
        $ref = new \ReflectionClass($grpc);

        $method = $ref->getMethod($method);
        $method->setAccessible(true);

        array_unshift($args, $grpc);
        return call_user_func_array([$method, 'invoke'], $args);
    }

    private function instance($full = true)
    {
        $args = [
            'name' => self::INSTANCE,
            'displayName' => self::INSTANCE,
        ];

        if ($full) {
            $args = array_merge($args, [
                'config' => self::CONFIG,
                'nodeCount' => 1,
                'state' => State::CREATING,
                'labels' => []
            ]);
        }

        $mask = [];
        foreach (array_keys($args) as $key) {
            $mask[] = Serializer::toSnakeCase($key);
        }

        $fieldMask = $this->serializer->decodeMessage(new FieldMask, ['paths' => $mask]);

        return [
            $args,
            $this->serializer->decodeMessage(new Instance, $args),
            $fieldMask
        ];
    }

    private function transactionSelector()
    {
        return new TransactionSelector([
            'id' => self::TRANSACTION
        ]);
    }
}

//@codingStandardsIgnoreStart
class GrpcStub extends Grpc
{
    public $config;

    protected function constructGapic($gapicName, array $config)
    {
        $this->config = $config;

        return parent::constructGapic($gapicName, $config);
    }
}
//@codingStandardsIgnoreEnd
