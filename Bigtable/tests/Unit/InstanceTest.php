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
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

/**
 * @group bigtable
 * @group bigtableadmin
 */
class InstanceTest extends TestCase
{
    use GrpcTestTrait;

    const PROJECT_ID = 'my-awesome-project';
    const INSTANCE_ID = 'my-instance';
    const INSTANCE_NAME = 'projects/my-awesome-project/instances/my-instance';

    private $connection;
    private $instance;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->instance = TestHelpers::stub(Instance::class, [
            $this->connection->reveal(),
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT_ID,
            self::INSTANCE_ID
        ], [
            'info',
            'connection'
        ]);
    }

    public function testName()
    {
        $this->assertEquals(self::INSTANCE_NAME, $this->instance->name());
    }

    public function testId()
    {
        $this->assertEquals(self::INSTANCE_ID, $this->instance->id());
    }

    public function testInsatnceWhenNameIsPassed()
    {
        $instance = TestHelpers::stub(Instance::class, [
            $this->connection->reveal(),
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT_ID,
            self::INSTANCE_NAME
        ], [
            'info',
            'connection'
        ]);

        $this->assertEquals(self::INSTANCE_NAME, $instance->name());
        $this->assertEquals(self::INSTANCE_ID, $instance->id());
    }

    public function testInsatnceWhenBadIdFormatPassed()
    {
        $badInstanceId = 'badformat/my-instance';
        try{
            $badInstance = TestHelpers::stub(Instance::class, [
                $this->connection->reveal(),
                $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
                [],
                self::PROJECT_ID,
                $badInstanceId
            ], [
                'info',
                'connection'
            ]);
        }catch(\Exception $e){
            $error = 'Instance id '. $badInstanceId. ' is not formatted correctly.
                Please use the format `my-instance` or projects/my-awesome-project/instances/my-instance.';
            $this->assertEquals($error, $e->getMessage());
        }
    }

    public function testInstanceId()
    {
        $instanceId = InstanceAdminClient::parseName($this->instance->name())['instance'];
        $this->assertEquals($this->instance->id(), $instanceId);
    }

    public function testCreate()
    {
        $this->connection->createInstance(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['name' => self::INSTANCE_NAME]);
        $this->instance->___setProperty('connection', $this->connection->reveal());
        $instance = $this->instance->create(
            [],
            'My Insatnce',
            ['foo' => 'bar']
        );
        $this->assertInstanceOf(LongRunningOperation::class, $instance);
        $this->assertEquals(self::INSTANCE_NAME, $instance->name());
    }
}
