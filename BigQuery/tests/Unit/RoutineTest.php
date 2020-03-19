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

namespace Google\Cloud\BigQuery\Tests\Unit;

use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\BigQuery\Routine;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Testing\TestHelpers;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group bigquery
 * @group bigquery-routine
 */
class RoutineTest extends TestCase
{
    const PROJECT_ID = 'project-id';
    const DATASET_ID = 'dataset-id';
    const ROUTINE_ID = 'routine-id';

    private $connection;
    private $routine;
    private $identity = [
        'routineId' => self::ROUTINE_ID,
        'datasetId' => self::DATASET_ID,
        'projectId' => self::PROJECT_ID
    ];

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->routine = TestHelpers::stub(Routine::class, [
            $this->connection->reveal(),
            self::ROUTINE_ID,
            self::DATASET_ID,
            self::PROJECT_ID
        ], ['connection', 'info']);
    }

    public function testIdentity()
    {
        $this->assertEquals($this->identity, $this->routine->identity());
    }

    public function testInfo()
    {
        $res = ['foo' => 'bar'];
        $this->connection->getRoutine($this->identity)
            ->shouldBeCalledOnce()
            ->willReturn($res);

        $this->routine->___setProperty('connection', $this->connection->reveal());
        $this->assertEquals($res, $this->routine->info());

        // test cached value.
        $this->routine->info();
    }

    public function testReload()
    {
        $res = ['foo' => 'bar'];
        $this->connection->getRoutine($this->identity)
            ->shouldBeCalledTimes(2)
            ->willReturn($res);

        $this->routine->___setProperty('connection', $this->connection->reveal());
        $this->assertEquals($res, $this->routine->reload());

        // test refreshes value
        $this->routine->reload();
    }

    public function testExists()
    {
        $this->connection->getRoutine($this->identity)
            ->shouldBeCalled()
            ->willReturn([]);

        $this->routine->___setProperty('connection', $this->connection->reveal());
        $this->assertTrue($this->routine->exists());
    }

    public function testExistsFalse()
    {
        $this->connection->getRoutine($this->identity)
            ->shouldBeCalled()
            ->willThrow(NotFoundException::class);

        $this->routine->___setProperty('connection', $this->connection->reveal());
        $this->assertFalse($this->routine->exists());
    }

    public function testUpdate()
    {
        $updateData = ['description' => 'wow a name'];
        $this->connection->getRoutine(Argument::any())
            ->willReturn(['description' => 'old and busted name'])
            ->shouldBeCalledTimes(1);
        $this->connection->updateRoutine($this->identity + $updateData + ['retries' => 0])
            ->willReturn($updateData)
            ->shouldBeCalledTimes(1);

        $this->routine->___setProperty('connection', $this->connection->reveal());
        $this->routine->update($updateData);

        $this->assertEquals($updateData['description'], $this->routine->info()['description']);
    }

    public function testUpdateWithEtag()
    {
        $updateData = ['description' => 'wow a name', 'etag' => 'foo'];
        $this->connection->getRoutine(Argument::any())
            ->willReturn(['description' => 'old and busted name'])
            ->shouldBeCalledTimes(1);
        $this->connection->updateRoutine(Argument::that(function ($args) {
            return $args['restOptions']['headers']['If-Match'] === 'foo';
        }))->willReturn($updateData)->shouldBeCalledTimes(1);

        $this->routine->___setProperty('connection', $this->connection->reveal());
        $this->routine->update($updateData);

        $this->assertEquals($updateData['description'], $this->routine->info()['description']);
    }

    public function testUpdateWithMask()
    {
        $old = [
            'description' => 'wow a name',
            'routineType' => 'PROCEDURE',
            'arguments' => [
                [
                    'name' => 'a',
                    'dataType' => [
                        'typeKind' => 'STRING'
                    ]
                ], [
                    'name' => 'b',
                    'dataType' => [
                        'typeKind' => 'ARRAY'
                    ]
                ]
            ]
        ];

        $new = $old;
        $new['description'] = 'this one is better i guess';
        $new['routineType'] = 'SCALAR_FUNCTION';
        $new['arguments'][0]['name'] = 'aa';
        $new['arguments'][1]['name'] = 'bb';
        $new['arguments'][1]['dataType']['typeKind'] = 'STRING';

        $paths = [
            'description',
            'arguments.0.name',
            'arguments.1.dataType.typeKind'
        ];

        $expected = $old;
        $expected['description'] = $new['description'];
        $expected['arguments'][0]['name'] = $new['arguments'][0]['name'];
        $expected['arguments'][1]['dataType']['typeKind'] = $new['arguments'][1]['dataType']['typeKind'];

        $this->connection->getRoutine(Argument::any())
            ->willReturn($old)
            ->shouldBeCalledTimes(1);
        $this->connection->updateRoutine($this->identity + $expected + ['retries' => 0])
            ->shouldBeCalledTimes(1)
            ->willReturn($expected);

        $this->routine->___setProperty('connection', $this->connection->reveal());
        $res = $this->routine->update($new, [
            'updateMask' => $paths
        ]);

        $this->assertEquals($expected, $res);
    }

    public function testDelete()
    {
        $this->connection->deleteRoutine($this->identity + ['retries' => 0])
            ->shouldBeCalled();

        $this->routine->___setProperty('connection', $this->connection->reveal());
        $this->routine->delete();
    }
}
