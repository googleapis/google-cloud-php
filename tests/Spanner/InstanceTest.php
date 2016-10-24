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

namespace Google\Cloud\Tests\Spanner;

use Google\Cloud\Exception\NotFoundException;
use Google\Cloud\Iam\Iam;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminApi;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminApi;
use Google\Cloud\Spanner\Configuration;
use Google\Cloud\Spanner\Connection\AdminConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Prophecy\Argument;

/**
 * @group spanner
 */
class InstanceTest extends \PHPUnit_Framework_TestCase
{
    const PROJECT_ID = 'test-project';
    const NAME = 'instance-name';

    private $adminConnection;
    private $instance;

    public function setUp()
    {
        $this->adminConnection = $this->prophesize(AdminConnectionInterface::class);
        $this->instance = new InstanceStub($this->adminConnection->reveal(), self::PROJECT_ID, self::NAME);
    }

    public function testName()
    {
        $this->assertEquals(self::NAME, $this->instance->name());
    }

    public function testInfo()
    {
        $this->adminConnection->getInstance()->shouldNotBeCalled();

        $instance = new Instance($this->adminConnection->reveal(), self::PROJECT_ID, self::NAME, ['foo' => 'bar']);
        $this->assertEquals('bar', $instance->info()['foo']);
    }

    public function testInfoWithReload()
    {
        $instance = $this->getDefaultInstance();

        $this->adminConnection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($instance);

        $this->instance->setAdminConnection($this->adminConnection->reveal());

        $info = $this->instance->info();
        $this->assertEquals('Instance Name', $info['displayName']);

        $this->assertEquals($info, $this->instance->info());
    }

    public function testExists()
    {
        $this->adminConnection->getInstance(Argument::any())->shouldBeCalled()->willReturn([]);

        $this->instance->setAdminConnection($this->adminConnection->reveal());

        $this->assertTrue($this->instance->exists());
    }

    public function testExistsNotFound()
    {
        $this->adminConnection->getInstance(Argument::any())
            ->shouldBeCalled()
            ->willThrow(new NotFoundException('foo', 404));

        $this->instance->setAdminConnection($this->adminConnection->reveal());

        $this->assertFalse($this->instance->exists());
    }

    public function testReload()
    {
        $instance = $this->getDefaultInstance();

        $this->adminConnection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($instance);

        $this->instance->setAdminConnection($this->adminConnection->reveal());

        $info = $this->instance->reload();

        $this->assertEquals('Instance Name', $info['displayName']);
    }

    public function testState()
    {
        $instance = $this->getDefaultInstance();

        $this->adminConnection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($instance);

        $this->instance->setAdminConnection($this->adminConnection->reveal());

        $this->assertEquals(Instance::STATE_READY, $this->instance->state());
    }

    public function testStateIsNull()
    {
        $this->adminConnection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([]);

        $this->instance->setAdminConnection($this->adminConnection->reveal());

        $this->assertNull($this->instance->state());
    }

    public function testUpdate()
    {
        $instance = $this->getDefaultInstance();

        $this->adminConnection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($instance);

        $this->adminConnection->updateInstance([
            'name' => $instance['name'],
            'displayName' => $instance['displayName'],
            'nodeCount' => $instance['nodeCount'],
            'labels' => [],
            'config' => $instance['config']
        ])->shouldBeCalled();

        $this->instance->setAdminConnection($this->adminConnection->reveal());

        $this->instance->update();
    }

    public function testUpdateWithExistingLabels()
    {
        $instance = $this->getDefaultInstance();
        $instance['labels'] = ['foo' => 'bar'];

        $this->adminConnection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($instance);

        $this->adminConnection->updateInstance([
            'name' => $instance['name'],
            'displayName' => $instance['displayName'],
            'nodeCount' => $instance['nodeCount'],
            'labels' => $instance['labels'],
            'config' => $instance['config']
        ])->shouldBeCalled();

        $this->instance->setAdminConnection($this->adminConnection->reveal());

        $this->instance->update();
    }

    public function testUpdateWithChanges()
    {
        $instance = $this->getDefaultInstance();

        $config = $this->prophesize(Configuration::class);
        $config->name()->willReturn('config-name');

        $changes = [
            'labels' => [
                'foo' => 'bar'
            ],
            'nodeCount' => 900,
            'displayName' => 'New Name',
            'config' => $config->reveal()
        ];

        $this->adminConnection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($instance);

        $this->adminConnection->updateInstance([
            'name' => $instance['name'],
            'displayName' => $changes['displayName'],
            'nodeCount' => $changes['nodeCount'],
            'labels' => $changes['labels'],
            'config' => InstanceAdminApi::formatInstanceConfigName(self::PROJECT_ID, $changes['config']->name())
        ])->shouldBeCalled();

        $this->instance->setAdminConnection($this->adminConnection->reveal());

        $this->instance->update($changes);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testUpdateInvalidConfig()
    {
        $instance = $this->getDefaultInstance();

        $changes = [
            'config' => 'foo'
        ];

        $this->adminConnection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($instance);

        $this->instance->setAdminConnection($this->adminConnection->reveal());

        $this->instance->update($changes);
    }

    public function testDelete()
    {
        $this->adminConnection->deleteInstance([
            'name' => InstanceAdminApi::formatInstanceName(self::PROJECT_ID, self::NAME)
        ])->shouldBeCalled();

        $this->instance->setAdminConnection($this->adminConnection->reveal());

        $this->instance->delete();
    }

    public function testCreateDatabase()
    {
        $dbInfo = [
            'name' => 'test-database'
        ];

        $extra = ['foo', 'bar'];

        $this->adminConnection->createDatabase([
            'instance' => InstanceAdminApi::formatInstanceName(self::PROJECT_ID, self::NAME),
            'createStatement' => 'CREATE DATABASE `test-database`',
            'extraStatements' => $extra
        ])
            ->shouldBeCalled()
            ->willReturn($dbInfo);

        $this->instance->setAdminConnection($this->adminConnection->reveal());

        $database = $this->instance->createDatabase('test-database', [
            'statements' => $extra
        ]);

        $this->assertInstanceOf(Database::class, $database);
        $this->assertEquals('test-database', $database->name());
    }

    public function testDatabase()
    {
        $database = $this->instance->database('test-database');
        $this->assertInstanceOf(Database::class, $database);
        $this->assertEquals('test-database', $database->name());
    }

    public function testDatabases()
    {
        $databases = [
            ['name' => DatabaseAdminApi::formatDatabaseName(self::PROJECT_ID, self::NAME, 'database1')],
            ['name' => DatabaseAdminApi::formatDatabaseName(self::PROJECT_ID, self::NAME, 'database2')]
        ];

        $this->adminConnection->listDatabases(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['databases' => $databases]);

        $this->instance->setAdminConnection($this->adminConnection->reveal());

        $dbs = $this->instance->databases();

        $this->assertInstanceOf(\Generator::class, $dbs);

        $dbs = iterator_to_array($dbs);

        $this->assertEquals(2, count($dbs));
        $this->assertEquals('database1', $dbs[0]->name());
        $this->assertEquals('database2', $dbs[1]->name());
    }

    public function testIam()
    {
        $this->assertInstanceOf(Iam::class, $this->instance->iam());
    }

    // ************** //

    private function getDefaultInstance()
    {
        return json_decode(file_get_contents(__DIR__ .'/../fixtures/spanner/instance.json'), true);
    }
}

class InstanceStub extends Instance
{
    public function setAdminConnection($conn)
    {
        $this->adminConnection = $conn;
    }
}
