<?php
/*
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Tests\Unit\Bigtable;

use Google\ApiCore\OperationResponse;
use Google\ApiCore\ValidationException;
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\Instance_Type;
use Google\Cloud\Bigtable\Admin\V2\ListInstancesResponse;
use Google\Cloud\Bigtable\Admin\V2\Cluster;
use Google\Cloud\Bigtable\Admin\V2\ListClustersResponse;
use Google\Protobuf\GPBEmpty;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * 
 */
class InstanceTest extends TestCase
{
    const PROJECT_ID = 'grass-clump-479';
    const INSTANCE_ID = 'my-instance';
    public $mock;

    public function setUp()
    {
        $this->mock = $this->getMockBuilder(\Google\Cloud\Bigtable\Instance::class)
                            ->disableOriginalConstructor()
                            ->getMock();
    }

    public function testCreateInstance()
    {
        $this->mock->method('createInstance')
             ->willReturn(OperationResponse::class);
        $response = $this->mock->createInstance(Argument::type('string'), Argument::type('string'), Argument::type('string'));
        $this->assertEquals(OperationResponse::class, $response);
    }

    public function testGetInstance()
    {
        $Instance = new Instance();
        $this->mock->method('getInstance')
             ->willReturn($Instance);
        $instances = $this->mock->getInstance(Argument::type('string'));
        $this->assertInstanceOf(Instance::class, $instances);
    }

    public function testUpdateInstance()
	{   
        $parent = 'projects/'.self::PROJECT_ID.'/instances/'.self::INSTANCE_ID;
        $displayName = 'my-instance2';
        $Instance = new Instance();
        $Instance->setName($parent);
        $Instance->setDisplayName($displayName);
        $Instance->setType(Instance_Type::DEVELOPMENT);

        $this->mock->method('updateInstance')
             ->willReturn($Instance);

        $instance = $this->mock->updateInstance(Argument::type('string'), Argument::type('string'), Argument::type('integer'));
        $this->assertEquals($instance->getDisplayName(), $displayName);
        $this->assertInstanceOf(Instance::class, $instance);
    }
    
    public function testListInstances()
    {
        $ListInstances = new ListInstancesResponse();
        $this->mock->method('listInstances')
             ->willReturn($ListInstances);
        $instances = $this->mock->listInstances();
        $this->assertInstanceOf(ListInstancesResponse::class, $instances);
    }
    
    public function testDeleteInstance()
    {
        $GPBEmpty = new GPBEmpty();
        $this->mock->method('deleteInstance')
             ->willReturn($GPBEmpty);
        
        $response = $this->mock->deleteInstance(Argument::type('string'));
        $this->assertInstanceOf(GPBEmpty::class, $response);
    }

    public function testCreateCluster()
    {
        $this->mock->method('createCluster')
             ->willReturn(OperationResponse::class);
        $response = $this->mock->createCluster(Argument::type('string'), Argument::type('string'));
        $this->assertEquals(OperationResponse::class, $response);
    }

    public function testGetCluster()
    {
        $Cluster = new Cluster();
        $this->mock->method('getCluster')
             ->willReturn($Cluster);
        $cluster = $this->mock->getCluster(Argument::type('string'));
        $this->assertInstanceOf(Cluster::class, $cluster);
    }

    public function testListClusters()
    {
        $listClusters = new ListClustersResponse();
        $this->mock->method('listClusters')
             ->willReturn($listClusters);
        $clusters = $this->mock->listClusters(Argument::type('string'));
        $this->assertInstanceOf(ListClustersResponse::class, $clusters);
    }

    public function testUpdateCluster()
    {
        $this->mock->method('updateCluster')
             ->willReturn(OperationResponse::class);
        $response = $this->mock->updateCluster(Argument::type('string'), Argument::type('string'), 0);
        $this->assertEquals(OperationResponse::class, $response);
    }

    public function testDeleteCluster()
    {
        $GPBEmpty = new GPBEmpty();
        $this->mock->method('deleteCluster')
             ->willReturn($GPBEmpty);
        
        $res = $this->mock->deleteCluster(Argument::type('string'));
        $this->assertInstanceOf(GPBEmpty::class, $res);
    }
}
