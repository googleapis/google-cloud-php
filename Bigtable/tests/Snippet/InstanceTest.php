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

namespace Google\Cloud\Bigtable\Tests\Snippet;

use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient as InstanceAdminClient;
use Google\Cloud\Bigtable\Connection\ConnectionInterface;
use Google\Cloud\Bigtable\Instance;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Prophecy\Argument;

/**
 * @group bigtable
 * @group bigtable-admin
 */
class InstanceTest extends SnippetTestCase
{
    use GrpcTestTrait;

    const PROJECT = 'my-awesome-project';
    const INSTANCE = 'my-instance';
    const CLUSTER = 'my-cluster';
    const LOCATION = 'us-east-b';

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
            self::PROJECT,
            self::INSTANCE
        ], ['connection', 'lroConnection']);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Instance::class);
        $res = $snippet->invoke('instance');

        $this->assertInstanceOf(Instance::class, $res->returnVal());
        $this->assertEquals(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE), $res->returnVal()->name());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'name');
        $snippet->addLocal('instance', $this->instance);

        $res = $snippet->invoke('name');
        $this->assertEquals(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE), $res->returnVal());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'info');
        $snippet->addLocal('instance', $this->instance);

        $this->connection->getInstance(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['nodeCount' => 1]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('1', $res->output());
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'exists');
        $snippet->addLocal('instance', $this->instance);

        $this->connection->getInstance(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['foo' => 'bar']);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Instance exists!', $res->output());
    }

    public function testReload()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'reload');
        $snippet->addLocal('instance', $this->instance);

        $this->connection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn(['nodeCount' => 1]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('info');
        $info = $this->instance->info();
        $this->assertEquals($info, $res->returnVal());
    }

    /**
     * @group bigtabladmin
     */
    public function testCreate()
    {
        $config = $this->prophesize(Instance::class);
        $config->name()->willReturn(InstanceAdminClient::instanceName(self::PROJECT, 'foo'));

        $snippet = $this->snippetFromMethod(Instance::class, 'create');
        $snippet->addLocal('configuration', $config->reveal());
        $snippet->addLocal('instance', $this->instance);
        $snippet->addLocal('clusterId', self::CLUSTER);
        $snippet->addLocal('locationId', self::LOCATION);

        $this->connection->createInstance(Argument::any(), Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(['name' => 'operations/foo']);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
    }

    public function testResumeOperation()
    {
        $snippet = $this->snippetFromMagicMethod(Instance::class, 'resumeOperation');
        $snippet->addLocal('instance', $this->instance);
        $snippet->addLocal('operationName', 'foo');

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
        $this->assertEquals('foo', $res->returnVal()->name());
    }

    public function testLongRunningOperations()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'longRunningOperations');
        $snippet->addLocal('instance', $this->instance);

        $lroConnection = $this->prophesize(LongRunningConnectionInterface::class);
        $lroConnection->operations(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'operations' => [
                    [
                        'name' => 'foo'
                    ]
                ]
            ]);

        $this->instance->___setProperty('lroConnection', $lroConnection->reveal());

        $res = $snippet->invoke('operations');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertContainsOnlyInstancesOf(LongRunningOperation::class, $res->returnVal());
    }
}
