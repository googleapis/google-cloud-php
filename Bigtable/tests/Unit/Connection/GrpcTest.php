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

use Google\ApiCore\Call;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\Serializer;
use Google\Cloud\Bigtable\Admin\V2\Cluster;
use Google\Cloud\Bigtable\Admin\V2\ColumnFamily;
use Google\Cloud\Bigtable\Admin\V2\GcRule;
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\Instance_Type;
use Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest_Modification as Modification;
use Google\Cloud\Bigtable\Admin\V2\Table;
use Google\Cloud\Bigtable\Connection\Grpc;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\MapField;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group bigtable
 */
class GrpcTest extends TestCase
{
    use GrpcTestTrait;
    use GrpcTrait;

    const PROJECT  = 'projects/grass-clump-479';
    const LOCATION = 'projects/grass-clump-479/locations/us-east1-b';
    const INSTANCE = 'projects/grass-clump-479/instances/my-instance';
    const CLUSTER  = 'projects/grass-clump-479/clusters/my-cluster';
    const TABLE    = 'projects/grass-clump-479/instances/my-instance/tables/my-table';
    const SNAPSHOT = 'projects/grass-clump-479/clusters/my-cluster/snapshots/my-snapshot';

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
        $clusterName = 'test-cluster';
 
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
        $columnFamilyId = 'cf';
        $maxNumVersions = 3;
        
        $columnFamily = $this->columnFamilyObject($serializer, $maxNumVersions);
        $mapField = new MapField(GPBType::STRING, GPBType::MESSAGE, ColumnFamily::class);
        $mapField[$columnFamilyId] = $columnFamily;

        $tableArgs = [
            'column_families' => $mapField
        ];
        $table = $serializer->decodeMessage(
            new Table(),
            $tableArgs
        );

        $snapshotId = 'my-snapshot';

        $cfArr = [
            ['id' => 'cf', 'action' => 'drop'],
            ['id' => 'cf2', 'action' => 'create', 'max_num_versions' => 2],
        ];
        $modifications = [];
        foreach ($cfArr as $key => $value) {
            $args = [];
            $args['id'] = $value['id'];
            if($value['action'] == 'drop'){
                $args['drop'] = true;
                $modifications[] = $serializer->decodeMessage(
                    new Modification(),
                    $args
                );
            }
            else{
                $maxnum = ($value['max_num_versions']) ? $value['max_num_versions'] : null;
                $args['create'] = $this->columnFamilyObject($serializer, $maxnum);
                $modifications[] = $serializer->decodeMessage(
                    new Modification(),
                    $this->pluckArray([
                        'id',
                        'create'
                    ], $args)
                );
            }
        }
        $description = 'Snapshot description text.';

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
                [self::PROJECT, $instanceName, $instance, ['test-cluster3' =>$cluster], ['headers' => ['google-cloud-resource-prefix' => [self::PROJECT]]]],
                $lro,
                null
            ],
            [
                'createTable',
                [
                    'parent' => self::INSTANCE,
                    'tableId' => $tableId,
                    'columnFamilies' => [
                        ['id' => $columnFamilyId, 'max_num_versions' => $maxNumVersions]
                    ]
                ],
                [self::INSTANCE, $tableId, $table, ['headers' => ['google-cloud-resource-prefix' => [self::INSTANCE]]]]
            ],
            [
                'createTableFromSnapshot',
                [
                    'parent' => self::INSTANCE,
                    'tableId' => $tableId,
                    'sourceSnapshot' => $snapshotId
                ],
                [self::INSTANCE, $tableId, $snapshotId, ['headers' => ['google-cloud-resource-prefix' => [self::INSTANCE]]]]
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
                    'columnFamilies' => [
                        ['id' => 'cf', 'action' => 'drop'],
                        ['id' => 'cf2', 'action' => 'create', 'max_num_versions' => 2],
                    ]
                ],
                [self::TABLE, $modifications, ['headers' => ['google-cloud-resource-prefix' => [self::TABLE]]]]
            ],
            [
                'dropRowRange',
                [
                    'name' => self::TABLE,
                    'optionalArgs' => ['rowKeyPrefix' => 'user']
                ],
                [self::TABLE, ['rowKeyPrefix' => 'user'], ['headers' => ['google-cloud-resource-prefix' => [self::TABLE]]]]
            ],
            [
                'snapshotTable',
                ['name' => self::TABLE, 'cluster' => self::CLUSTER, 'snapshotId' => $snapshotId, 'description' => $description
                ],
                [self::TABLE, self::CLUSTER, $snapshotId, $description, ['headers' => ['google-cloud-resource-prefix' => [self::TABLE]]]]
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
            ]
        ];
    }

    private function columnFamilyObject($serializer, $maxNumVersions)
    {
        $gcRuleArgs['max_num_versions'] = $maxNumVersions;
        $gcRule = $serializer->decodeMessage(
            new GcRule(),
            $gcRuleArgs
        );

        $columnFamilyArgs['gc_rule'] = $gcRule;
        return $serializer->decodeMessage(
            new ColumnFamily(),
            $columnFamilyArgs
        );
    }
}
