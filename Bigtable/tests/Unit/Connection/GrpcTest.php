<?php
/*
 * Copyright 2018, Google LLC All rights reserved.
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

namespace Google\Cloud\Bigtable\Tests\Unit\Connection;

use Google\ApiCore\OperationResponse;
use Google\ApiCore\Serializer;
use Google\Cloud\Bigtable\Admin\V2\Cluster;
use Google\Cloud\Bigtable\Admin\V2\ColumnFamily;
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\Instance_Type;
use Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest_Modification;
use Google\Cloud\Bigtable\Admin\V2\Table;
use Google\Cloud\Bigtable\Connection\Grpc;
use Google\Cloud\Bigtable\V2\MutateRowsRequest_Entry;
use Google\Cloud\Bigtable\V2\Mutation;
use Google\Cloud\Bigtable\V2\ReadModifyWriteRule;
use Google\Cloud\Bigtable\V2\RowFilter;
use Google\Cloud\Bigtable\V2\RowSet;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group bigtable-gapic
 */
class GrpcTest extends TestCase
{
    use GrpcTestTrait;
    use GrpcTrait;

    const PROJECT  = 'projects/my-awesome-project';
    const INSTANCE = 'projects/my-awesome-project/instances/my-instance';
    const LOCATION = 'projects/my-awesome-project/locations/us-east1-b';
    const TABLE    = 'projects/my-awesome-project/instances/my-instance/tables/my-table';
    const CLUSTER  = 'projects/my-awesome-project/instances/my-instance/clusters/my-cluster';
    const SNAPSHOT = 'projects/my-awesome-project/instances/my-instance/clusters/my-cluster/snapshots/my-snapshot';

    private $successMessage;

    private $requestWrapper;

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
        $instanceName = 'test-instance3';
        $tableName = 'test-table';
        $permissions = ['permission1','permission2'];
        $policy = ['foo' => 'bar'];
        $consistencyToken = 'a1b2c3d4';
        $rowKey = 'r1';
        $familyName = 'f1';
        $setValue = 'abc';
        $columnQualifier = 'c1';
        $snapshotTableDesc = 'abc';

        $clusterArgs = [
            'location' => self::LOCATION,
            'serveNodes' => 3,
            'defaultStorageType' => 0,
            'state'=>0
        ];
        $cluster = $serializer->decodeMessage(
            new Cluster(),
            $clusterArgs
        );
        $instanceArgs = [
            'displayName' => $instanceName,
            'type' => Instance_Type::PRODUCTION,
            'labels' => []
        ];
        $instance = $serializer->decodeMessage(
            new Instance(),
            $instanceArgs
        );
        $lro = $this->prophesize(OperationResponse::class)->reveal();

        $tableId = 'my-table';
        $table = $serializer->decodeMessage(
            new Table(),
            []
        );

        $columnFamily = $serializer->decodeMessage(
            new ColumnFamily(),
            []
        );
        // @todo add GCRule option
        $columnFamilyModificationCreate = $serializer->decodeMessage(
            new ModifyColumnFamiliesRequest_Modification(),
            [
                'id' => 'cf1',
                'create' => $columnFamily
            ]
        );
        // @todo add GCRule option
        $columnFamilyModificationUpdate = $serializer->decodeMessage(
            new ModifyColumnFamiliesRequest_Modification(),
            [
                'id' => 'cf2',
                'update' => $columnFamily
            ]
        );
        $columnFamilyModificationdrop = $serializer->decodeMessage(
            new ModifyColumnFamiliesRequest_Modification(),
            [
                'id' => 'cf3',
                'drop' => true
            ]
        );
        $modifications = [
            $columnFamilyModificationCreate,
            $columnFamilyModificationUpdate,
            $columnFamilyModificationdrop
        ];
        $rowSet = $serializer->decodeMessage(
            new RowSet(),
            [
                'rowKeys' => [$rowKey]
            ]
        );
        $filterInArrayFormat = [
            'chain' => [
                'filters' => [
                    [
                        'sink' => true
                    ]
                ]
            ]
        ];
        $filter = $serializer->decodeMessage(
            new RowFilter(),
            $filterInArrayFormat
        );
        $setCellMutation = [
            'setCell' => [
                'familyName' => $familyName,
                'value' => $setValue
            ]
        ];
        $deleteFromColumnMutation = [
            'deleteFromColumn' => [
                'familyName' => $familyName,
                'columnQualifier' => $columnQualifier
            ]
        ];
        $mutationsInArrayFormat = [
            $setCellMutation,
            $deleteFromColumnMutation
        ];
        $mutations = [
            $serializer->decodeMessage(
                new Mutation(),
                $setCellMutation
            ),
            $serializer->decodeMessage(
                new Mutation(),
                $deleteFromColumnMutation
            )
        ];
        $entries = [
            $serializer->decodeMessage(
                new MutateRowsRequest_Entry(),
                [
                    'rowKey' => $rowKey,
                    'mutations' => $mutationsInArrayFormat
                ]
            )
        ];
        $readModifyWriteRulesInArrayFormat = [
            [
                'familyName' => $familyName,
                'columnQualifier' => $columnQualifier,
                'appendValue' => $setValue,
                'incrementAmount' => 1
            ]
        ];
        $readModifyWriteRules = [
            $serializer->decodeMessage(
                new ReadModifyWriteRule(),
                $readModifyWriteRulesInArrayFormat[0]
            )
        ];

        return [
            [
                'createInstance',
                [
                    'parent' => self::PROJECT,
                    'instanceId' => $instanceName,
                    'instance' => [
                        'displayName' => $instanceName,
                           'type' => Instance_Type::PRODUCTION,
                           'labels' => []
                    ],
                    'clusters' => [
                        'test-cluster3' => [
                            'location' => self::LOCATION,
                            'serveNodes' => 3
                        ]
                    ]
                ],
                [
                    self::PROJECT,
                    $instanceName,
                    $instance,
                    ['test-cluster3' => $cluster],
                    ['headers' => ['google-cloud-resource-prefix' => [self::PROJECT]]]
                ],
                $lro,
                null
            ],
            [
                'deleteInstance',
                ['name' => self::INSTANCE],
                [self::INSTANCE, ['headers' => ['google-cloud-resource-prefix' => [self::INSTANCE]]]]
            ],
            [
                'createTable',
                [
                    'parent' => self::INSTANCE,
                    'tableId' => $tableId,
                    'table' => []
                ],
                [self::INSTANCE, $tableId, $table, ['headers' => ['google-cloud-resource-prefix' => [self::INSTANCE]]]]
            ],
            [
                'createTableFromSnapshot',
                [
                    'parent' => self::INSTANCE,
                    'tableId' => self::TABLE,
                    'sourceSnapshot' => self::SNAPSHOT
                ],
                [
                    self::INSTANCE,
                    self::TABLE,
                    self::SNAPSHOT,
                    ['headers' => ['google-cloud-resource-prefix' => [self::INSTANCE]]]
                ],
                $lro,
                null
            ],
            [
                'listTables',
                ['parent' => self::INSTANCE],
                [self::INSTANCE, ['headers' => ['google-cloud-resource-prefix' => [self::INSTANCE]]]]
            ],
            [
                'getTable',
                ['name' => self::TABLE],
                [self::TABLE, ['headers' => ['google-cloud-resource-prefix' => [self::TABLE]]]]
            ],
            [
                'deleteTable',
                ['name' => self::TABLE],
                [self::TABLE, ['headers' => ['google-cloud-resource-prefix' => [self::TABLE]]]]
            ],
            [
                'modifyColumnFamilies',
                [
                    'name' => self::TABLE,
                    'modifications' => [
                        ['id'=>'cf1', 'create'=> []],
                        ['id'=>'cf2', 'update'=>[]],
                        ['id'=>'cf3', 'drop'=>true]
                    ]
                ],
                [self::TABLE, $modifications, ['headers' => ['google-cloud-resource-prefix' => [self::TABLE]]]]
            ],
            [
                'dropRowRange',
                ['name' => self::TABLE],
                [self::TABLE, ['headers' => ['google-cloud-resource-prefix' => [self::TABLE]]]]
            ],
            [
                'setIamPolicy',
                ['resource' => $instanceName, 'policy' => $policy],
                [$instanceName, $policy, ['headers' => ['google-cloud-resource-prefix' => [$instanceName]]]]
            ],
            [
                'getIamPolicy',
                ['resource' => $instanceName],
                [$instanceName, ['headers' => ['google-cloud-resource-prefix' => [$instanceName]]]]
            ],
            [
                'testIamPermissions',
                ['resource' => $instanceName, 'permissions' => $permissions],
                [$instanceName, $permissions, ['headers' => ['google-cloud-resource-prefix' => [$instanceName]]]]
            ],
            [
                'checkConsistency',
                ['name' => $tableName, 'consistencyToken' => $consistencyToken],
                [$tableName, $consistencyToken, ['headers' => ['google-cloud-resource-prefix' => [$tableName]]]]
            ],
            [
                'generateConsistencyToken',
                ['name' => $tableName],
                [$tableName, ['headers' => ['google-cloud-resource-prefix' => [$tableName]]]]
            ],
            [
                'snapshotTable',
                [
                    'name' => self::TABLE,
                    'cluster' => self::CLUSTER,
                    'snapshotId' => self::SNAPSHOT,
                    'description' => $snapshotTableDesc
                ],
                [
                    self::TABLE,
                    self::CLUSTER,
                    self::SNAPSHOT,
                    $snapshotTableDesc,
                    ['headers' => ['google-cloud-resource-prefix' => [self::TABLE]]]
                ],
                $lro,
                null
            ],
            [
                'getSnapshot',
                ['name' => self::SNAPSHOT],
                [self::SNAPSHOT, ['headers' => ['google-cloud-resource-prefix' => [self::SNAPSHOT]]]]
            ],
            [
                'listSnapshots',
                ['parent' => self::CLUSTER],
                [self::CLUSTER, ['headers' => ['google-cloud-resource-prefix' => [self::CLUSTER]]]]
            ],
            [
                'deleteSnapshot',
                ['name' => self::SNAPSHOT],
                [self::SNAPSHOT, ['headers' => ['google-cloud-resource-prefix' => [self::SNAPSHOT]]]]
            ],
            [
                'readRows',
                [
                    'tableName' => self::TABLE,
                    'rows' => [
                        'rowKeys' => [$rowKey]
                    ],
                    'filter' => $filterInArrayFormat
                ],
                [
                    self::TABLE,
                    [
                        'rows' => $rowSet,
                        'filter' => $filter,
                        'headers' => ['google-cloud-resource-prefix' => [self::TABLE]]
                    ]
                ],
            ],
            [
                'sampleRowKeys',
                ['tableName' => self::TABLE],
                [self::TABLE, ['headers' => ['google-cloud-resource-prefix' => [self::TABLE]]]]
            ],
            [
                'mutateRow',
                [
                    'tableName' => self::TABLE,
                    'rowKey' => $rowKey,
                    'mutations' => $mutationsInArrayFormat
                ],
                [
                    self::TABLE,
                    $rowKey,
                    $mutations,
                    ['headers' => ['google-cloud-resource-prefix' => [self::TABLE]]]
                ]
            ],
            [
                'mutateRows',
                [
                    'tableName' => self::TABLE,
                    'entries' => [
                        [
                            'rowKey' => $rowKey,
                            'mutations' => $mutationsInArrayFormat
                        ]
                    ]
                ],
                [
                    self::TABLE,
                    $entries,
                    ['headers' => ['google-cloud-resource-prefix' => [self::TABLE]]]
                ]
            ],
            [
                'checkAndMutateRow',
                [
                    'tableName' => self::TABLE,
                    'rowKey' => $rowKey,
                    'predicateFilter' => $filterInArrayFormat,
                    'trueMutations' => $mutationsInArrayFormat,
                    'falseMutations' => $mutationsInArrayFormat
                ],
                [
                    self::TABLE,
                    $rowKey,
                    [
                        'predicateFilter' => $filter,
                        'trueMutations' => $mutations,
                        'falseMutations' => $mutations,
                        'headers' => ['google-cloud-resource-prefix' => [self::TABLE]]
                    ]
                ]
            ],
            [
                'readModifyWriteRow',
                [
                    'tableName' => self::TABLE,
                    'rowKey' => $rowKey,
                    'rules' => $readModifyWriteRulesInArrayFormat
                ],
                [
                    self::TABLE,
                    $rowKey,
                    $readModifyWriteRules,
                    ['headers' => ['google-cloud-resource-prefix' => [self::TABLE]]]
                ]
            ]
        ];
    }
}
