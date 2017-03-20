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

namespace Google\Cloud\Tests\Snippets\SpannerAdmin;

use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Prophecy\Argument;

/**
 * @group spanneradmin
 */
class InstanceTest extends SnippetTestCase
{
    const PROJECT = 'my-awesome-project';
    const INSTANCE = 'my-instance';
    const DATABASE = 'my-database';

    private $connection;
    private $instance;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->instance = \Google\Cloud\Dev\stub(Instance::class, [
            $this->connection->reveal(),
            $this->prophesize(SessionPoolInterface::class)->reveal(),
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT,
            self::INSTANCE
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Instance::class);
        $res = $snippet->invoke('instance');
        $this->assertInstanceOf(Instance::class, $res->returnVal());
        $this->assertEquals(self::INSTANCE, $res->returnVal()->name());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'name');
        $snippet->addLocal('instance', $this->instance);

        $res = $snippet->invoke('name');
        $this->assertEquals(self::INSTANCE, $res->returnVal());
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

    public function testState()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'state');
        $snippet->addLocal('instance', $this->instance);
        $snippet->addUse(Instance::class);

        $this->connection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn(['state' => Instance::STATE_READY]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Instance is ready!', $res->output());
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'update');
        $snippet->addLocal('instance', $this->instance);

        $this->connection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'displayName' => 'foo',
                'nodeCount' => 1
            ]);

        $this->connection->updateInstance(Argument::any())
            ->shouldBeCalled();

        $this->instance->___setProperty('connection', $this->connection->reveal());
        $snippet->invoke();
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'delete');
        $snippet->addLocal('instance', $this->instance);

        $this->connection->deleteInstance(Argument::any())
            ->shouldBeCalled();

        $this->instance->___setProperty('connection', $this->connection->reveal());
        $snippet->invoke();
    }

    public function testCreateDatabase()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'createDatabase');
        $snippet->addLocal('instance', $this->instance);

        $this->connection->createDatabase(Argument::any())
            ->shouldBeCalled();

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('database');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
    }

    public function testDatabase()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'database');
        $snippet->addLocal('instance', $this->instance);

        $res = $snippet->invoke('database');
        $this->assertInstanceOf(Database::class, $res->returnVal());
        $this->assertEquals(self::DATABASE, $res->returnVal()->name());
    }

    public function databases()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'databases');
        $snippet->addLocal('instance', $this->instance);

        $this->connection->listDatabases(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'databases' => [
                    'projects/'. self::PROJECT .'/instances/'. self::INSTANCE .'/database/'. self::DATABASE
                ]
            ]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('databases');

        $this->assertInstanceOf(\Generator::class, $res->returnVal());
        $this->assertInstanceOf(Database::class, $res->returnVal()->current());
    }

    public function testIam()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'iam');
        $snippet->addLocal('instance', $this->instance);

        $res = $snippet->invoke('iam');
        $this->assertInstanceOf(Iam::class, $res->returnVal());
    }
}
