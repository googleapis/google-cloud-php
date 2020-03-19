<?php
/**
 * Copyright 2020 Google LLC
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

namespace Google\Cloud\BigQuery\Tests\Snippet;

use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\BigQuery\Routine;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Prophecy\Argument;

/**
 * @group bigquery
 */
class RoutineTest extends SnippetTestCase
{
    const PROJECT_ID = 'my_project';
    const DATASET_ID = 'my_dataset';
    const ROUTINE_ID = 'my_routine';

    private $connection;
    private $routine;
    private $identity;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->identity = [
            'routineId' => self::ROUTINE_ID,
            'datasetId' => self::DATASET_ID,
            'projectId' => self::PROJECT_ID
        ];

        $this->routine = TestHelpers::stub(Routine::class, [
            $this->connection->reveal(),
            self::ROUTINE_ID,
            self::DATASET_ID,
            self::PROJECT_ID
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Routine::class);
        $res = $snippet->invoke('routine');
        $this->assertInstanceOf(Routine::class, $res->returnVal());
        $this->assertEquals(self::ROUTINE_ID, $res->returnVal()->identity()['routineId']);
        $this->assertEquals(self::DATASET_ID, $res->returnVal()->identity()['datasetId']);
    }

    public function testIdentity()
    {
        $snippet = $this->snippetFromMethod(Routine::class, 'identity');
        $snippet->addLocal('routine', $this->routine);
        $res = $snippet->invoke('identity');

        $this->assertEquals($this->identity, $res->returnVal());
        $this->assertEquals(self::ROUTINE_ID, $res->output());
    }

    public function testInfo()
    {
        $info = ['foo' => 'bar'];
        $this->connection->getRoutine(Argument::any())
            ->willReturn($info);
        $this->routine->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Routine::class, 'info');
        $snippet->addLocal('routine', $this->routine);
        $res = $snippet->invoke('res');
        $this->assertEquals($info, $res->returnVal());
    }

    public function testReload()
    {
        $info = ['foo' => 'bar'];
        $this->connection->getRoutine(Argument::any())
            ->willReturn($info);
        $this->routine->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Routine::class, 'reload');
        $snippet->addLocal('routine', $this->routine);
        $res = $snippet->invoke('res');
        $this->assertEquals($info, $res->returnVal());
    }

    public function testExists()
    {
        $this->connection->getRoutine(Argument::any())
            ->willReturn([]);
        $this->routine->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Routine::class, 'exists');
        $snippet->addLocal('routine', $this->routine);
        $res = $snippet->invoke();
        $this->assertEquals('Routine exists!', $res->output());
    }

    public function testUpdate()
    {
        $this->connection->getRoutine(Argument::any())
            ->willReturn([]);
        $this->connection->updateRoutine(Argument::that(function ($args) {
            return isset($args['definitionBody']);
        }))->shouldBeCalled()->willReturn([]);
        $this->routine->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Routine::class, 'update');
        $snippet->addLocal('routine', $this->routine);
        $snippet->invoke();
    }

    public function testUpdateWithMask()
    {
        $this->connection->getRoutine(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'displayName' => 'foo',
                'definitionBody' => 'xxx',
                'language' => 'yyy'
            ]);
        $this->connection->updateRoutine(Argument::allOf(
            Argument::withEntry('definitionBody', 'return x + y;'),
            Argument::withEntry('language', 'JAVASCRIPT'),
            Argument::withEntry('displayName', 'foo')
        ))->willReturn([]);

        $this->routine->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Routine::class, 'update', 1);
        $snippet->addLocal('routine', $this->routine);
        $snippet->invoke();
    }

    public function testDelete()
    {
        $this->connection->deleteRoutine(Argument::any())
            ->shouldBeCalled();
        $this->routine->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Routine::class, 'delete');
        $snippet->addLocal('routine', $this->routine);
        $snippet->invoke();
    }
}
