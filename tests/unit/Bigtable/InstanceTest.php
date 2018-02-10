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

use Google\Cloud\Bigtable\src\BigtableInstance;
use PHPUnit\Framework\TestCase;
use Google\GAX\ValidationException;
use Google\GAX\OperationResponse;

use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\Instance_Type;
use Google\Protobuf\GPBEmpty;
use Google\Cloud\Bigtable\Admin\V2\ListInstancesResponse;

use Prophecy\Argument;

class InstanceTest extends TestCase
{
    const PROJECT_ID = 'grass-clump-479';
    const INSTANCE_ID = 'my-instance';

    public $mock;

    public function setUp()
    {
        $this->mock = $this->getMockBuilder(BigtableInstance::class)
                            ->disableOriginalConstructor()
                            ->getMock();
    }

    public function testProjectName()
    {
        $expected = 'projects/'.self::PROJECT_ID;
        $this->mock->method('projectName')
             ->willReturn($expected);

        $formatedName = $this->mock->projectName(Argument::type('string'));
        $this->assertEquals($formatedName, $expected);
    }

    public function testInstanceName()
    {
        $expected = 'projects/'.self::PROJECT_ID.'/instances/'.self::INSTANCE_ID;
        $this->mock->method('instanceName')
             ->willReturn($expected);

        $formatedName = $this->mock->instanceName(Argument::type('string'), Argument::type('string'));
        $this->assertEquals($formatedName, $expected);
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
        $instances = $this->mock->listInstances(Argument::type('string'));        
        $this->assertInstanceOf(ListInstancesResponse::class, $instances);
    }
    
    public function testDeleteInstance()
    {
        $GPBEmpty = new GPBEmpty();
        $this->mock->method('deleteInstance')
             ->willReturn($GPBEmpty);
        
        $res = $this->mock->deleteInstance(Argument::type('string'));
        $this->assertInstanceOf(GPBEmpty::class, $res);
    }
}
