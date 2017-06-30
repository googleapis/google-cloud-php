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

namespace Google\Cloud\Tests\Unit\SpannerAdmin;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\InstanceConfiguration;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Tests\GrpcTestTrait;
use Prophecy\Argument;

/**
 * @group spanneradmin
 * @group spanner
 */
class InstanceConfigurationTest extends \PHPUnit_Framework_TestCase
{
    use GrpcTestTrait;

    const PROJECT_ID = 'test-project';
    const NAME = 'test-config';

    private $connection;
    private $configuration;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->configuration = \Google\Cloud\Dev\stub(InstanceConfiguration::class, [
            $this->connection->reveal(),
            self::PROJECT_ID,
            self::NAME
        ]);
    }

    public function testName()
    {
        $this->assertEquals(self::NAME, InstanceAdminClient::parseInstanceConfigFromInstanceConfigName($this->configuration->name()));
    }

    public function testInfo()
    {
        $this->connection->getInstanceConfig(Argument::any())->shouldNotBeCalled();
        $this->configuration->___setProperty('connection', $this->connection->reveal());

        $info = ['foo' => 'bar'];
        $config = \Google\Cloud\Dev\stub(InstanceConfiguration::class, [
            $this->connection->reveal(),
            self::PROJECT_ID,
            self::NAME,
            $info
        ]);

        $this->assertEquals($info, $config->info());
    }

    public function testInfoWithReload()
    {
        $info = ['foo' => 'bar'];

        $this->connection->getInstanceConfig([
            'name' => InstanceAdminClient::formatInstanceConfigName(self::PROJECT_ID, self::NAME),
            'projectId' => self::PROJECT_ID
        ])->shouldBeCalled()->willReturn($info);

        $this->configuration->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals($info, $this->configuration->info());
    }

    public function testExists()
    {
        $this->connection->getInstanceConfig(Argument::any())->willReturn([]);
        $this->configuration->___setProperty('connection', $this->connection->reveal());

        $this->assertTrue($this->configuration->exists());
    }

    public function testExistsDoesntExist()
    {
        $this->connection->getInstanceConfig(Argument::any())->willThrow(new NotFoundException('', 404));
        $this->configuration->___setProperty('connection', $this->connection->reveal());

        $this->assertFalse($this->configuration->exists());
    }

    public function testReload()
    {
        $info = ['foo' => 'bar'];

        $this->connection->getInstanceConfig([
            'name' => InstanceAdminClient::formatInstanceConfigName(self::PROJECT_ID, self::NAME),
            'projectId' => self::PROJECT_ID
        ])->shouldBeCalledTimes(1)->willReturn($info);

        $this->configuration->___setProperty('connection', $this->connection->reveal());

        $info = $this->configuration->reload();

        $info2 = $this->configuration->info();

        $this->assertEquals($info, $info2);
    }
}
