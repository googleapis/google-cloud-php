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
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Configuration;
use Google\Cloud\Spanner\Connection\AdminConnectionInterface;
use Prophecy\Argument;

/**
 * @group spanner
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    const PROJECT_ID = 'test-project';
    const NAME = 'test-config';

    private $adminConnection;
    private $configuration;

    public function setUp()
    {
        $this->adminConnection = $this->prophesize(AdminConnectionInterface::class);
        $this->configuration = new ConfigurationStub(
            $this->adminConnection->reveal(),
            self::PROJECT_ID,
            self::NAME
        );
    }

    public function testName()
    {
        $this->assertEquals(self::NAME, $this->configuration->name());
    }

    public function testInfo()
    {
        $this->adminConnection->getConfig(Argument::any())->shouldNotBeCalled();
        $this->configuration->setAdminConnection($this->adminConnection->reveal());

        $info = ['foo' => 'bar'];
        $config = new ConfigurationStub(
            $this->adminConnection->reveal(),
            self::PROJECT_ID,
            self::NAME,
            $info
        );

        $this->assertEquals($info, $config->info());
    }

    public function testInfoWithReload()
    {
        $info = ['foo' => 'bar'];

        $this->adminConnection->getConfig([
            'name' => InstanceAdminClient::formatInstanceConfigName(self::PROJECT_ID, self::NAME),
            'projectId' => self::PROJECT_ID
        ])->shouldBeCalled()->willReturn($info);

        $this->configuration->setAdminConnection($this->adminConnection->reveal());

        $this->assertEquals($info, $this->configuration->info());
    }

    public function testExists()
    {
        $this->adminConnection->getConfig(Argument::any())->willReturn([]);
        $this->configuration->setAdminConnection($this->adminConnection->reveal());

        $this->assertTrue($this->configuration->exists());
    }

    public function testExistsDoesntExist()
    {
        $this->adminConnection->getConfig(Argument::any())->willThrow(new NotFoundException('', 404));
        $this->configuration->setAdminConnection($this->adminConnection->reveal());

        $this->assertFalse($this->configuration->exists());
    }

    public function testReload()
    {
        $info = ['foo' => 'bar'];

        $this->adminConnection->getConfig([
            'name' => InstanceAdminClient::formatInstanceConfigName(self::PROJECT_ID, self::NAME),
            'projectId' => self::PROJECT_ID
        ])->shouldBeCalledTimes(1)->willReturn($info);

        $this->configuration->setAdminConnection($this->adminConnection->reveal());

        $info = $this->configuration->reload();

        $info2 = $this->configuration->info();

        $this->assertEquals($info, $info2);
    }
}

class ConfigurationStub extends Configuration
{
    public function setAdminConnection($conn)
    {
        $this->adminConnection = $conn;
    }
}
