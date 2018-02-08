<?php

use Google\Cloud\Bigtable\src\BigtableInstance;
use PHPUnit\Framework\TestCase;
use Google\GAX\ValidationException;
use Google\GAX\OperationResponse;
// use Google\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\Instance_Type;
use Google\Protobuf\GPBEmpty;
use Google\Cloud\Bigtable\Admin\V2\ListInstancesResponse;

use Prophecy\Argument;

class InstanceTest extends TestCase
{
    const PROJECT_ID = 'grass-clump-479';
    const INSTANCE_ID = 'my-instance';

    public function testProjectName()
    {
        $expected = 'projects/'.self::PROJECT_ID;
        $mock = $this->createMock(BigtableInstance::class);
        $mock->method('projectName')
             ->willReturn($expected);

        $formatedName = $mock->projectName(Argument::type('string'));
        $this->assertEquals($formatedName, $expected);
    }

    public function testInstanceName()
    {
        $expected = 'projects/'.self::PROJECT_ID.'/instances/'.self::INSTANCE_ID;
        $mock = $this->createMock(BigtableInstance::class);
        $mock->method('instanceName')
             ->willReturn($expected);

        $formatedName = $mock->instanceName(Argument::type('string'), Argument::type('string'));
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

        $mock = $this->createMock(BigtableInstance::class);
        $mock->method('updateInstance')
             ->willReturn($Instance);

        $instance = $mock->updateInstance(Argument::type('string'), Argument::type('string'), Argument::type('integer'));
        $this->assertEquals($instance->getDisplayName(), $displayName);
        $this->assertInstanceOf(Instance::class, $instance);
	}

    public function testListInstances()
    {
        $ListInstances = new ListInstancesResponse();
        $mock = $this->createMock(BigtableInstance::class);
        $mock->method('listInstances')
             ->willReturn($ListInstances);
        $instances = $mock->listInstances(Argument::type('string'));        
        $this->assertInstanceOf(ListInstancesResponse::class, $instances);
    }
    
    public function testDeleteInstance()
    {
        $GPBEmpty = new GPBEmpty();
        $mock = $this->createMock(BigtableInstance::class);
        $mock->method('deleteInstance')
             ->willReturn($GPBEmpty);
        
        $res = $mock->deleteInstance(Argument::type('string'));
        $this->assertInstanceOf(GPBEmpty::class, $res);
    }
}
