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
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\Instance_Type;
use Google\Cloud\Bigtable\Admin\V2\Cluster;
use Google\Cloud\Bigtable\Connection\Grpc;
use Google\Cloud\Bigtable\V2\MutateRowsRequest_Entry;
use Google\Cloud\Bigtable\V2\Mutation;
use Google\Cloud\Bigtable\V2\Mutation_SetCell;
use Google\Cloud\Bigtable\V2\ReadModifyWriteRule;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
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

    const PROJECT  = 'projects/my-awesome-project';
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

        /*** MutateRow ***/
        $rowKey = 'user0000000';
        $utc = strtotime(gmdate("M d Y H:i:s", time()))*1000;
        $mutateRowcell = [
            [
                'familyName' => 'cf',
                'columnQualifier' => 'field',
                'value' => 'val',
                'timestampMicros' => $utc
            ]
        ];
        $mutationArr = $this->mutationsArr($serializer ,$mutateRowcell);

        /*** MutateRows ***/
        $mutateRowscell = [
            [
                'rowKey' => $rowKey,
                'cell' => [
                    [
                        'familyName' => 'cf',
                        'columnQualifier' => 'field',
                        'value' => 'val',
                        'timestampMicros' => $utc
                    ],
                    [
                        'familyName' => 'cf',
                        'columnQualifier' => 'field5',
                        'value' => 'val5',
                        'timestampMicros' => $utc
                    ]
                ]
            ]
        ];
        $mutations = [];
        foreach ($mutateRowscell as $val) {
            array_push($mutations, [
                'rowKey' => $val['rowKey'],
                'mutations' => $this->mutationsArr($serializer, $val['cell'])
            ]);
        }
        $entries = [];
        foreach ($mutations as $val) {
            $entries[] = $this->mutateRowsRequestEntryObject($serializer, $val);
        }

        /*** readModifyWriteRow ***/
        $modifyCells = [
            [
                'familyName' => 'cf2',
                'columnQualifier' => 'qualifier',
                'appendValue' => 'Val2'
            ]
        ];
        $rulesArr = [];
        foreach ($modifyCells as $value) {
            $rulesArr[] = $this->readModifyWriteRuleObject($serializer, $value);
        }

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
                'readRows',
                ['tableName' => self::TABLE],
                [self::TABLE, [], ['headers' => ['google-cloud-resource-prefix' => [self::TABLE]]]]
            ],
            [
                'sampleRowKeys',
                ['tableName' => self::TABLE],
                [self::TABLE, [], ['headers' => ['google-cloud-resource-prefix' => [self::TABLE]]]]
            ],
            [
                'mutateRow',
                [
                    'tableName' => self::TABLE,
                    'rowKey' => $rowKey,
                    'cells' => $mutateRowcell
                ],
                [self::TABLE, $rowKey, $mutationArr, [], ['headers' => ['google-cloud-resource-prefix' => [self::TABLE]]]]
            ],
            [
                'mutateRows',
                [
                    'tableName' => self::TABLE,
                    'cells' => $mutateRowscell
                ],
                [self::TABLE, $entries, [], ['headers' => ['google-cloud-resource-prefix' => [self::TABLE]]]]
            ],
            [
                'checkAndMutateRow',
                [
                    'tableName' => self::TABLE,
                    'rowKey' => $rowKey
                ],
                [self::TABLE, $rowKey, [], ['headers' => ['google-cloud-resource-prefix' => [self::TABLE]]]]
            ],
            [
                'readModifyWriteRow',
                [
                    'tableName' => self::TABLE,
                    'rowKey' => $rowKey,
                    'cells' => $modifyCells
                ],
                [self::TABLE, $rowKey, $rulesArr, [], ['headers' => ['google-cloud-resource-prefix' => [self::TABLE]]]]
            ]
        ];
    }

    private function mutationObject($serializer, $args)
    {
        $cellObject = [];
        $cellObject['setCell'] = $serializer->decodeMessage(
            new Mutation_SetCell(),
            $this->pluckArray([
                'familyName',
                'columnQualifier',
                'value',
                'timestampMicros'
            ], $args)
        );

        return $serializer->decodeMessage(
            new Mutation(),
            $this->pluckArray([
                'setCell'
            ], $cellObject)
        );
    }

    private function mutationsArr($serializer ,$cells)
    {
        $mutationsObjArray = [];
        foreach ($cells as $val) {
            $mutationsObjArray[] = $this->mutationObject($serializer, $val);
        }
        return $mutationsObjArray;
    }

    private function mutateRowsRequestEntryObject($serializer, $args)
    {
        return $serializer->decodeMessage(
            new MutateRowsRequest_Entry(),
            $this->pluckArray([
                'rowKey',
                'mutations'
            ], $args)
        );
    }

    private function readModifyWriteRuleObject($serializer, $args)
    {
        return $serializer->decodeMessage(
            new ReadModifyWriteRule(),
            $this->pluckArray([
                'familyName',
                'columnQualifier',
                'appendValue'
            ], $args)
        );
    }
}
