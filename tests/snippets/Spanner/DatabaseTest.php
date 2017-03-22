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

namespace Google\Cloud\Tests\Snippets\Spanner;

use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Prophecy\Argument;

/**
 * @group spanner
 * @group spanneradmin
 */
class DatabaseTest extends SnippetTestCase
{
    const PROJECT = 'my-awesome-project';
    const DATABASE = 'my-database';
    const INSTANCE = 'my-instance';

    private $connection;
    private $database;

    public function setUp()
    {
        $instance = $this->prophesize(Instance::class);
        $instance->name()->willReturn(self::INSTANCE);

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->database = \Google\Cloud\Dev\stub(Database::class, [
            $this->connection->reveal(),
            $instance->reveal(),
            $this->prophesize(SessionPoolInterface::class)->reveal(),
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT,
            self::DATABASE
        ]);
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'name');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke('name');
        $this->assertEquals(self::DATABASE, $res->returnVal());
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'exists');
        $snippet->addLocal('database', $this->database);

        $this->connection->getDatabaseDDL(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['statements' => []]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Database exists!', $res->output());
    }

    public function testUpdateDdl()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'updateDdl');
        $snippet->addLocal('database', $this->database);

        $this->connection->updateDatabase(Argument::any())
            ->shouldBeCalled();

        $this->database->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testUpdateDdlBatch()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'updateDdlBatch');
        $snippet->addLocal('database', $this->database);

        $this->connection->updateDatabase(Argument::any())
            ->shouldBeCalled();

        $this->database->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testDrop()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'drop');
        $snippet->addLocal('database', $this->database);

        $this->connection->dropDatabase(Argument::any())
            ->shouldBeCalled();

        $this->database->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testDdl()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'ddl');
        $snippet->addLocal('database', $this->database);

        $stmts = [
            'CREATE TABLE TestSuites',
            'CREATE TABLE TestCases'
        ];

        $this->connection->getDatabaseDDL(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'statements' => $stmts
            ]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('statements');
        $this->assertEquals($stmts, $res->returnVal());
    }

    public function testIam()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'iam');
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('iam');
        $this->assertInstanceOf(Iam::class, $res->returnVal());
    }
}
