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
use Google\Cloud\Core\PhpArray;
use Google\Cloud\Spanner\Connection\Grpc;
use Google\Cloud\Spanner\ValueMapper;
use Google\GAX\OperationResponse;
use Prophecy\Argument;
use google\spanner\v1\KeySet;
use google\spanner\v1\Mutation;
use google\spanner\v1\TransactionOptions;
use google\spanner\v1\TransactionSelector;
use google\spanner\v1\Type;

/**
 * @group spanner
 */
class GrpcTest extends \PHPUnit_Framework_TestCase
{
    use GrpcTrait;

    const PROJECT = 'projects/my-project';

    private $requestWrapper;
    private $successMessage;

    public function setUp()
    {
        if (!extension_loaded('grpc')) {
            $this->markTestSkipped('Must have the grpc extension installed to run this test.');
        }

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
        $codec = new PhpArray;

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
            'state' => \google\spanner\admin\instance\v1\Instance\State::CREATING,
            'labels' => []
        ];

        $instance = (new \google\spanner\admin\instance\v1\Instance)
            ->deserialize(array_filter([
                'labels' => $this->formatLabelsForApi([])
            ] + $instanceArgs), $codec);

        $lro = $this->prophesize(OperationResponse::class)->reveal();

        $mask = array_keys($instance->serialize(new PhpArray([], false)));
        $fieldMask = (new \google\protobuf\FieldMask())->deserialize(['paths' => $mask], $codec);

        $tableName = 'foo';

        $createStmt = 'CREATE TABLE '. $tableName;
        $sql = 'SELECT * FROM '. $tableName;

        $transactionSelector = (new TransactionSelector)
            ->deserialize(['id' => $transactionName], $codec);

        $mapper = new ValueMapper(false);
        $mapped = $mapper->formatParamsForExecuteSql(['foo' => 'bar']);

        $expectedParams = (new \google\protobuf\Struct)
            ->deserialize($this->formatStructForApi($mapped['params']), $codec);

        $expectedParamTypes = $mapped['paramTypes'];
        foreach ($expectedParamTypes as $key => $param) {
            $expectedParamTypes[$key] = (new Type)
                ->deserialize($param, $codec);
        }

        $columns = ['id', 'name'];
        $keySetArgs = [];
        $keySet = (new KeySet)
            ->deserialize($keySetArgs, $codec);

        $readWriteTransactionArgs = ['readWrite' => []];
        $readWriteTransactionOptions = new TransactionOptions;
        $rw = new TransactionOptions\ReadWrite;
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
        $ro = (new TransactionOptions\ReadOnly)
            ->deserialize($roObjArgs['readOnly'], $codec);

        $readOnlyTransactionOptions->setReadOnly($ro);

        $insertMutations = [
            [
                'insert' => [
                    'table' => $tableName,
                    'columns' => ['foo'],
                    'values' => ['bar']
                ]
            ],
            // [
            //     'delete' => [
            //         'table' => $tableName,
            //         'keySet' => [
            //             'keys' => ['foo','bar'],
            //             'ranges' => [
            //                 [
            //                     'startOpen' => ['foo'],
            //                     'endClosed' => ['bar']
            //                 ]
            //             ]
            //         ]
            //     ]
            // ]
        ];

        $insertMutationsArr = [];
        $insert = $insertMutations[0]['insert'];
        $insert['values'] = $this->formatListForApi($insertMutations[0]['insert']['values']);
        $operation = (new Mutation\Write)
            ->deserialize($insert, $codec);

        $mutation = new Mutation;
        $mutation->setInsert($operation);
        $insertMutationsArr[] = $mutation;

        // $delete = $mutations[1]['delete'];
        // $delete['keySet']['keys'] = $this->formatListForApi($delete['keySet']['keys']);
        // $operation = (new Mutation\Delete)
        //     ->deserialize($delete, $codec);
        // $mutation = new Mutation;
        // $mutation->setDelete($operation);
        // $mutationsArr[] = $mutation;

        return [
            [
                'listInstanceConfigs',
                ['projectId' => self::PROJECT],
                [self::PROJECT, []]
            ],
            [
                'getInstanceConfig',
                ['name' => $configName],
                [$configName, []]
            ],
            [
                'listInstances',
                ['projectId' => self::PROJECT],
                [self::PROJECT, []]
            ],
            [
                'getInstance',
                ['name' => $instanceName],
                [$instanceName, []]
            ],
            [
                'createInstance',
                ['projectId' => self::PROJECT, 'instanceId' => $instanceName] + $instanceArgs,
                [self::PROJECT, $instanceName, $instance, []],
                $lro,
                null
            ],
            [
                'updateInstance',
                $instanceArgs,
                [$instance, $fieldMask, []],
                $lro,
                null
            ],
            [
                'deleteInstance',
                ['name' => $instanceName],
                [$instanceName, []]
            ],
            [
                'setInstanceIamPolicy',
                ['resource' => $instanceName, 'policy' => $policy],
                [$instanceName, $policy, []]
            ],
            [
                'getInstanceIamPolicy',
                ['resource' => $instanceName],
                [$instanceName, []]
            ],
            [
                'testInstanceIamPermissions',
                ['resource' => $instanceName, 'permissions' => $permissions],
                [$instanceName, $permissions, []]
            ],
            [
                'listDatabases',
                ['instance' => $instanceName],
                [$instanceName, []]
            ],
            [
                'createDatabase',
                ['instance' => $instanceName, 'createStatement' => $createStmt, 'extraStatements' => []],
                [$instanceName, $createStmt, [], []],
                $lro,
                null
            ],
            [
                'updateDatabaseDdl',
                ['name' => $databaseName, 'statements' => []],
                [$databaseName, [], []],
                $lro,
                null
            ],
            [
                'dropDatabase',
                ['name' => $databaseName],
                [$databaseName, []]
            ],
            [
                'getDatabaseDDL',
                ['name' => $databaseName],
                [$databaseName, []]
            ],
            [
                'setDatabaseIamPolicy',
                ['resource' => $databaseName, 'policy' => $policy],
                [$databaseName, $policy, []]
            ],
            [
                'getDatabaseIamPolicy',
                ['resource' => $databaseName],
                [$databaseName, []]
            ],
            [
                'testDatabaseIamPermissions',
                ['resource' => $databaseName, 'permissions' => $permissions],
                [$databaseName, $permissions, []]
            ],
            [
                'createSession',
                ['database' => $databaseName],
                [$databaseName, []]
            ],
            [
                'getSession',
                ['name' => $sessionName],
                [$sessionName, []]
            ],
            [
                'deleteSession',
                ['name' => $sessionName],
                [$sessionName, []]
            ],
            [
                'executeStreamingSql',
                [
                    'session' => $sessionName,
                    'sql' => $sql,
                    'transactionId' => $transactionName
                ] + $mapped,
                [$sessionName, $sql, [
                    'transaction' => $transactionSelector,
                    'params' => $expectedParams,
                    'paramTypes' => $expectedParamTypes
                ]]
            ],
            [
                'streamingRead',
                ['keySet' => [], 'transactionId' => $transactionName, 'session' => $sessionName, 'table' => $tableName, 'columns' => $columns],
                [$sessionName, $tableName, $columns, $keySet, ['transaction' => $transactionSelector]]
            ],
            // test read write
            [
                'beginTransaction',
                ['session' => $sessionName, 'transactionOptions' => $readWriteTransactionArgs],
                [$sessionName, $readWriteTransactionOptions, []]
            ],
            // test read only
            [
                'beginTransaction',
                ['session' => $sessionName, 'transactionOptions' => $readOnlyTransactionArgs],
                [$sessionName, $readOnlyTransactionOptions, []]
            ],
            // test insert
            [
                'commit',
                ['session' => $sessionName, 'mutations' => $insertMutations],
                [$sessionName, $insertMutationsArr, []]
            ],
            // test single-use transaction
            [
                'commit',
                ['session' => $sessionName, 'mutations' => [], 'singleUseTransaction' => true],
                [$sessionName, [], ['singleUseTransaction' => $readWriteTransactionOptions]]
            ],
            [
                'rollback',
                ['session' => $sessionName, 'transactionId' => $transactionName],
                [$sessionName, $transactionName, []]
            ],
            // ['getOperation'],
            // ['cancelOperation'],
            // ['deleteOperation'],
            // ['listOperations']
        ];
    }
}
