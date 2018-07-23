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
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\Instance_Type;
use Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest_Modification;
use Google\Cloud\Bigtable\Admin\V2\Table;
use Google\Cloud\Bigtable\Connection\Grpc;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group bigtable
 */
class GrpcTest extends TestCase
{
    use GrpcTestTrait;
    use GrpcTrait;

    const PROJECT = 'projects/my-awesome-project';
    const INSTANCE = 'projects/my-awesome-project/instances/my-instance';
    const LOCATION = 'projects/my-awesome-project/locations/us-east1-b';
    const TABLE    = 'projects/my-awesome-project/instances/my-instance/tables/my-table';

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
        $tableName = 'test-table';
        $permissions = ['permission1','permission2'];
        $policy = ['foo' => 'bar'];
        $consistencyToken = 'a1b2c3d4';

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

        $columnFamilyModificationCreate = $serializer->decodeMessage(
            new ModifyColumnFamiliesRequest_Modification(),
            [
                'id' => 'cf1',
                'create' => $columnFamily
            ]
        );

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
                'deleteInstance',
                ['name' => self::INSTANCE],
                [self::INSTANCE, ['headers' => ['google-cloud-resource-prefix' => [self::INSTANCE]]]]
            ],
            [
                'createTable',
                [
                    'parent' => self::INSTANCE,
                    'tableId' => $tableId
                ],
                [self::INSTANCE, $tableId, $table, ['headers' => ['google-cloud-resource-prefix' => [self::INSTANCE]]]]
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
                'deleteTable',
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
            ]
        ];
    }
}
