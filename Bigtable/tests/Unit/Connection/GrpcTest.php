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
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Protobuf\FieldMask; 
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group bigtable
 */
class GrpcTest extends TestCase
{
    use GrpcTestTrait;
    use GrpcTrait;

    const PROJECT = 'projects/grass-clump-479';
    const LOCATION = 'projects/grass-clump-479/locations/us-east1-b';

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
        $updateMaskArgs = [
            'paths' => [],
        ];
        $updateMask = $serializer->decodeMessage(
            new FieldMask(),
            $updateMaskArgs
        );
        $lro = $this->prophesize(OperationResponse::class)->reveal();

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
                'getInstance',
                ['name' => 'projects/grass-clump-479/instances/test-instance3'],
                ['projects/grass-clump-479/instances/test-instance3', ['headers' => ['google-cloud-resource-prefix' => ['projects/grass-clump-479/instances/test-instance3']]]]
            ],
            [

                'listInstances',
                ['parent' => self::PROJECT],
                [self::PROJECT,['headers' => ['google-cloud-resource-prefix' => [self::PROJECT]]]]
            ],
            [
                'updateInstance',
                ['name' => 'projects/grass-clump-479/instances/test-instance3',
                 'displayName' => $instanceName,
                 'type' => Instance_Type::PRODUCTION,
                 'labels' => []
                ],
                [
                    'projects/grass-clump-479/instances/test-instance3',
                    $instanceName,Instance_Type::PRODUCTION,[],['headers' => ['google-cloud-resource-prefix' => ['projects/grass-clump-479/instances/test-instance3']]]

                ]
            ],
            [
                'partialUpdateInstance',
                [
                    'parent' => 'projects/grass-clump-479/instances/test-instance3',
                    'instance' => [
                        'displayName' => $instanceName,
                           'type' => Instance_Type::PRODUCTION,
                           'labels' => []
                    ],
                    'updateMask' => [

                            'paths' => []

                    ]
                ],
                [$instance,$updateMask, ['headers' => ['google-cloud-resource-prefix' => ['projects/grass-clump-479/instances/test-instance3']]]],
                $lro,
                null
            ],
            [
                'deleteInstance',
                ['name' => 'projects/grass-clump-479/instances/test-instance3'],
                ['projects/grass-clump-479/instances/test-instance3', ['headers' => ['google-cloud-resource-prefix' => ['projects/grass-clump-479/instances/test-instance3']]]]
            ]
        ];
    }
}
