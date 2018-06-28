<?php
/**
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

namespace Google\Cloud\Bigtable\Tests\Unit;

use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient as InstanceAdminClient;
use Google\Cloud\Bigtable\Connection\ConnectionInterface;
use Google\Cloud\Bigtable\Instance;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

/**
 * @group bigtable
 * @group bigtableadmin
 */
class InstanceTest extends TestCase
{
    use GrpcTestTrait;

    const PROJECT_ID = 'test-project';
    const NAME = 'instance-name';

    private $connection;
    private $instance;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->instance = \Google\Cloud\Core\Testing\TestHelpers::stub(Instance::class, [
            $this->connection->reveal(),
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT_ID,
            self::NAME
        ], [
            'info',
            'connection'
        ]);
    }

    public function testName()
    {
        $this->assertEquals(self::NAME, InstanceAdminClient::parseName($this->instance->name())['instance']);
    }

    public function testInfo()
    {
        $this->connection->getInstance()->shouldNotBeCalled();

        $this->instance->___setProperty('info', ['foo' => 'bar']);
        $this->assertEquals('bar', $this->instance->info()['foo']);
    }

    public function testInfoWithReload()
    {
        $instance = $this->getDefaultInstance();

        $this->connection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($instance);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $info = $this->instance->info();
        $this->assertEquals('Instance Name', $info['displayName']);

        $this->assertEquals($info, $this->instance->info());
    }

    public function testExists()
    {
        $this->connection->getInstance(Argument::any())->shouldBeCalled()->willReturn([]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $this->assertTrue($this->instance->exists());
    }

    public function testExistsNotFound()
    {
        $this->connection->getInstance(Argument::any())
            ->shouldBeCalled()
            ->willThrow(new NotFoundException('foo', 404));

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $this->assertFalse($this->instance->exists());
    }

    public function testReload()
    {
        $instance = $this->getDefaultInstance();

        $this->connection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($instance);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $info = $this->instance->reload();

        $this->assertEquals('Instance Name', $info['displayName']);
    }

    public function testState()
    {
        $instance = $this->getDefaultInstance();

        $this->connection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($instance);

        $this->instance->___setProperty('connection', $this->connection->reveal());
        $this->assertEquals(Instance::STATE_TYPE_CREATING, $this->instance->state());
    }

    public function testStateIsNull()
    {
        $this->connection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $this->assertNull($this->instance->state());
    }

    // ************** //

    private function getDefaultInstance()
    {
        return json_decode(file_get_contents(Fixtures::INSTANCE_FIXTURE()), true);
    }
}
