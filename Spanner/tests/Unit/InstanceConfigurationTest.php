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

namespace Google\Cloud\Spanner\Tests\Unit;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\InstanceConfiguration;
use Google\Cloud\Spanner\Tests\StubCreationTrait;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner-admin
 * @group spanner
 */
class InstanceConfigurationTest extends TestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;
    use StubCreationTrait;

    const PROJECT_ID = 'test-project';
    const NAME = 'test-config';

    private $connection;
    private $configuration;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->getConnStub();
        $this->configuration = TestHelpers::stub(InstanceConfiguration::class, [
            $this->connection->reveal(),
            self::PROJECT_ID,
            self::NAME,
            [],
            $this->prophesize(LongRunningConnectionInterface::class)->reveal()
        ]);
    }

    public function testName()
    {
        $this->assertEquals(
            InstanceAdminClient::parseName($this->configuration->name())['instance_config'],
            self::NAME
        );
    }

    public function testInfo()
    {
        $this->connection->getInstanceConfig(Argument::any())->shouldNotBeCalled();
        $this->configuration->___setProperty('connection', $this->connection->reveal());

        $info = ['foo' => 'bar'];
        $config = TestHelpers::stub(InstanceConfiguration::class, [
            $this->connection->reveal(),
            self::PROJECT_ID,
            self::NAME,
            $info,
            $this->prophesize(LongRunningConnectionInterface::class)->reveal()
        ]);

        $this->assertEquals($info, $config->info());
    }

    public function testInfoWithReload()
    {
        $info = ['foo' => 'bar'];

        $this->connection->getInstanceConfig([
            'name' => InstanceAdminClient::instanceConfigName(self::PROJECT_ID, self::NAME),
            'projectName' => InstanceAdminClient::projectName(self::PROJECT_ID)
        ])->shouldBeCalled()->willReturn($info);

        $this->configuration->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals($info, $this->configuration->info());
    }

    public function testExists()
    {
        $this->connection->getInstanceConfig(Argument::allOf(
            Argument::withEntry(
                'projectName',
                InstanceAdminClient::projectName(self::PROJECT_ID)
            ),
            Argument::withEntry('name', $this->configuration->name())
        ))
            ->shouldBeCalled()
            ->willReturn([]);
        $this->configuration->___setProperty('connection', $this->connection->reveal());

        $this->assertTrue($this->configuration->exists());
    }

    public function testExistsDoesntExist()
    {
        $this->connection->getInstanceConfig(Argument::allOf(
            Argument::withEntry(
                'projectName',
                InstanceAdminClient::projectName(self::PROJECT_ID)
            ),
            Argument::withEntry('name', $this->configuration->name())
        ))
            ->shouldBeCalled()
            ->willThrow(new NotFoundException('', 404));
        $this->configuration->___setProperty('connection', $this->connection->reveal());

        $this->assertFalse($this->configuration->exists());
    }

    public function testReload()
    {
        $info = ['foo' => 'bar'];

        $this->connection->getInstanceConfig([
            'name' => InstanceAdminClient::instanceConfigName(self::PROJECT_ID, self::NAME),
            'projectName' => InstanceAdminClient::projectName(self::PROJECT_ID)
        ])->shouldBeCalledTimes(1)->willReturn($info);

        $this->configuration->___setProperty('connection', $this->connection->reveal());

        $info = $this->configuration->reload();

        $info2 = $this->configuration->info();

        $this->assertEquals($info, $info2);
    }

    public function testUpdate()
    {
        $config = $this->getDefaultInstance();

        $this->connection->updateInstanceConfig([
            'name' => $config['name'],
            'displayName' => 'bar',
        ])->shouldBeCalled()->willReturn([
            'name' => 'my-operation'
        ]);

        $this->configuration->___setProperty('connection', $this->connection->reveal());

        $this->configuration->update(['displayName' => 'bar']);
    }

    public function testUpdateWithExistingLabels()
    {
        $config = $this->getDefaultInstance();
        $config['labels'] = ['foo' => 'bar'];

        $this->connection->updateInstanceConfig([
            'labels' => $config['labels'],
            'name' => $config['name'],
        ])->shouldBeCalled()->willReturn([
            'name' => 'my-operation'
        ]);

        $this->configuration->___setProperty('connection', $this->connection->reveal());

        $this->configuration->update(['labels' => $config['labels']]);
    }

    public function testUpdateWithChanges()
    {
        $config = $this->getDefaultInstance();

        $changes = [
            'labels' => [
                'foo' => 'bar'
            ],
            'displayName' => 'New Name',
        ];

        $this->connection->updateInstanceConfig([
            'name' => $config['name'],
            'displayName' => $changes['displayName'],
            'labels' => $changes['labels'],
        ])->shouldBeCalled()->willReturn([
            'name' => 'my-operation'
        ]);

        $this->configuration->___setProperty('connection', $this->connection->reveal());

        $this->configuration->update($changes);
    }

    public function testDelete()
    {
        $this->connection->deleteInstanceConfig([
            'name' => InstanceAdminClient::instanceConfigName(self::PROJECT_ID, self::NAME)
        ])->shouldBeCalled();

        $this->configuration->___setProperty('connection', $this->connection->reveal());

        $this->configuration->delete();
    }

    private function getDefaultInstance()
    {
        return json_decode(file_get_contents(Fixtures::INSTANCE_CONFIG_FIXTURE()), true);
    }
}
