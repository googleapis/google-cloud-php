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

namespace Google\Cloud\BigQuery\Tests\Unit;

use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\BigQuery\Dataset;
use Google\Cloud\BigQuery\Model;
use Google\Cloud\BigQuery\Routine;
use Google\Cloud\BigQuery\Table;
use Google\Cloud\BigQuery\ValueMapper;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Testing\TestHelpers;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group bigquery
 * @group bigquery-dataset
 */
class DatasetTest extends TestCase
{
    public $connection;
    public $mapper;
    public $projectId = 'myProjectId';
    public $datasetId = 'myDatasetId';
    public $tableId = 'myTableId';
    public $modelId = 'testModelId';
    public $routineId = 'testRoutineId';

    public function setUp()
    {
        $this->mapper = new ValueMapper(false);
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function getDataset($connection, array $data = [], $location = null)
    {
        return new Dataset(
            $connection->reveal(),
            $this->datasetId,
            $this->projectId,
            $this->mapper,
            $data,
            $location
        );
    }

    public function testDoesExistTrue()
    {
        $this->connection->getDataset(Argument::any())
            ->willReturn([
                'datasetReference' => ['datasetId' => $this->datasetId]
            ])
            ->shouldBeCalledTimes(1);
        $dataset = $this->getDataset($this->connection);

        $this->assertTrue($dataset->exists());
    }

    public function testDoesExistFalse()
    {
        $this->connection->getDataset(Argument::any())
            ->willThrow(new NotFoundException(null))
            ->shouldBeCalledTimes(1);
        $dataset = $this->getDataset($this->connection);

        $this->assertFalse($dataset->exists());
    }

    public function testDelete()
    {
        $this->connection->deleteDataset(Argument::any())
            ->shouldBeCalledTimes(1);
        $dataset = $this->getDataset($this->connection);
        $this->assertNull($dataset->delete());
    }

    public function testUpdatesData()
    {
        $updateData = ['friendlyName' => 'wow a name'];
        $this->connection->patchDataset(Argument::any())
            ->willReturn($updateData)
            ->shouldBeCalledTimes(1);
        $dataset = $this->getDataset($this->connection, ['friendlyName' => 'another name']);
        $dataset->update($updateData);

        $this->assertEquals($updateData['friendlyName'], $dataset->info()['friendlyName']);
    }

    public function testUpdatesDataWithEtag()
    {
        $updateData = ['friendlyName' => 'wow a name', 'etag' => 'foo'];
        $this->connection->patchDataset(Argument::that(function ($args) {
            return $args['restOptions']['headers']['If-Match'] === 'foo';
        }))
            ->willReturn($updateData)
            ->shouldBeCalledTimes(1);
        $dataset = $this->getDataset($this->connection, ['friendlyName' => 'another name']);
        $dataset->update($updateData);

        $this->assertEquals($updateData['friendlyName'], $dataset->info()['friendlyName']);
    }

    public function testGetsTable()
    {
        $dataset = $this->getDataset($this->connection);
        $this->assertInstanceOf(Table::class, $dataset->table($this->tableId));
    }

    /**
     * @dataProvider locations
     */
    public function testGetsTableWithLocationFromDataset($expected, $info, $location)
    {
        $dataset = TestHelpers::stub(Dataset::class, [
            $this->connection->reveal(),
            $this->datasetId,
            $this->projectId,
            new ValueMapper(false),
            $info,
            $location
        ]);

        $table = $dataset->table($this->tableId);
        $this->assertInstanceOf(Table::class, $table);
        $this->assertEquals($expected, TestHelpers::getPrivateProperty($table, 'location'));
    }

    public function locations()
    {
        return [
            ['foo', ['location' => 'foo'], 'bar'],
            ['bar', [], 'bar']
        ];
    }

    public function testGetsTablesWithNoResults()
    {
        $this->connection->listTables(Argument::any())
            ->willReturn([])
            ->shouldBeCalledTimes(1);

        $dataset = $this->getDataset($this->connection);
        $tables = iterator_to_array($dataset->tables());

        $this->assertEmpty($tables);
    }

    public function testGetsTablesWithoutToken()
    {
        $this->connection->listTables(Argument::any())
            ->willReturn([
                'tables' => [
                    ['tableReference' => ['tableId' => $this->tableId]]
                ]
            ])
            ->shouldBeCalledTimes(1);

        $dataset = $this->getDataset($this->connection);
        $tables = iterator_to_array($dataset->tables());

        $this->assertEquals($this->tableId, $tables[0]->id());
    }

    public function testGetsTablesWithToken()
    {
        $this->connection->listTables(Argument::any())
            ->willReturn([
                'nextPageToken' => 'token',
                'tables' => [
                    ['tableReference' => ['tableId' => 'someOthertableId']]
                ]
            ], [
                'tables' => [
                    ['tableReference' => ['tableId' => $this->tableId]]
                ]
            ])->shouldBeCalledTimes(2);

        $dataset = $this->getDataset($this->connection);
        $tables = iterator_to_array($dataset->tables());

        $this->assertEquals($this->tableId, $tables[1]->id());
    }

    public function testCreatesTable()
    {
        $this->connection->insertTable(Argument::any())
            ->willReturn([
                'tableReference' => [
                    'tableId' => $this->tableId
                ]
            ])
            ->shouldBeCalledTimes(1);
        $dataset = $this->getDataset($this->connection);

        $table = $dataset->createTable($this->tableId, [
            'metadata' => [
                'friendlyName' => 'A table.'
            ]
        ]);

        $this->assertInstanceOf(Table::class, $table);
    }

    public function testsGetsModel()
    {
        $dataset = $this->getDataset($this->connection);
        $model = $dataset->model($this->modelId);
        $this->assertInstanceOf(Model::class, $model);
        $this->assertEquals($this->datasetId, $model->identity()['datasetId']);
        $this->assertEquals($this->projectId, $model->identity()['projectId']);
        $this->assertEquals($this->modelId, $model->id());
    }

    public function testsGetsModelsWithoutToken()
    {
        $this->connection->listModels(Argument::any())
            ->willReturn([
                'models' => [
                    ['modelReference' => ['modelId' => $this->modelId]]
                ]
            ])
            ->shouldBeCalledTimes(1);

        $dataset = $this->getDataset($this->connection);
        $models = $dataset->models();
        $this->assertInstanceOf(ItemIterator::class, $models);
        $modelsArray = iterator_to_array($models);

        $this->assertEquals($this->modelId, $modelsArray[0]->id());
    }

    public function testGetsModelsWithToken()
    {
        $this->connection->listModels(Argument::any())
            ->willReturn([
                'nextPageToken' => 'token',
                'models' => [
                    ['modelReference' => ['modelId' => $this->modelId]]
                ]
            ], [
                'models' => [
                    ['modelReference' => ['modelId' => 'testModelId2']]
                ]
            ])->shouldBeCalledTimes(2);

        $dataset = $this->getDataset($this->connection);
        $models = iterator_to_array($dataset->models());

        $this->assertEquals($this->modelId, $models[0]->id());
        $this->assertEquals('testModelId2', $models[1]->id());
    }

    /**
     * @covers Google\Cloud\BigQuery\Dataset::routine
     */
    public function testRoutine()
    {
        $routine = $this->getDataset($this->connection)->routine($this->routineId);
        $this->assertInstanceOf(Routine::class, $routine);
        $this->assertEquals([
            'routineId' => $this->routineId,
            'datasetId' => $this->datasetId,
            'projectId' => $this->projectId
        ], $routine->identity());
    }

    /**
     * @covers Google\Cloud\BigQuery\Dataset::routines
     */
    public function testRoutines()
    {
        $this->connection->listRoutines(Argument::any())
            ->willReturn([
                'routines' => [
                    ['routineReference' => ['routineId' => $this->routineId]]
                ]
            ])
            ->shouldBeCalledTimes(1);

        $dataset = $this->getDataset($this->connection);
        $routines = $dataset->routines();
        $this->assertInstanceOf(ItemIterator::class, $routines);
        $routinesArray = iterator_to_array($routines);

        $this->assertEquals(
            $this->routineId,
            $routinesArray[0]->identity()['routineId']
        );
    }

    /**
     * @covers Google\Cloud\BigQuery\Dataset::routines
     */
    public function testRoutinesWithToken()
    {
        $this->connection->listRoutines(Argument::any())
            ->willReturn([
                'nextPageToken' => 'token',
                'routines' => [
                    ['routineReference' => ['routineId' => $this->routineId]]
                ]
            ], [
                'routines' => [
                    ['routineReference' => ['routineId' => 'testRoutineId2']]
                ]
            ])->shouldBeCalledTimes(2);

        $dataset = $this->getDataset($this->connection);
        $routines = iterator_to_array($dataset->routines());

        $this->assertEquals(
            $this->routineId,
            $routines[0]->identity()['routineId']
        );
        $this->assertEquals(
            'testRoutineId2',
            $routines[1]->identity()['routineId']
        );
    }

    /**
     * @covers Google\Cloud\BigQuery\Dataset::createRoutine
     */
    public function testCreateRoutine()
    {
        $routineReference = [
            'routineId' => $this->routineId,
            'datasetId' => $this->datasetId,
            'projectId' => $this->projectId
        ];

        $metadata = [
            'foo' => 'bar',
            'routineReference' => [ // this gets overwritten by client
                'a' => 'b'
            ]
        ];

        $this->connection->insertRoutine(Argument::allOf(
            Argument::withEntry('routineReference', $routineReference),
            Argument::withEntry('foo', 'bar'),
            Argument::withEntry('retries', 0)
        ))->shouldBeCalled()->willReturn([
            'routineReference' => $routineReference
        ]);

        $dataset = $this->getDataset($this->connection);

        $routine = $dataset->createRoutine($this->routineId, $metadata);
        $this->assertInstanceOf(Routine::class, $routine);
        $this->assertEquals($routineReference, $routine->identity());
    }

    public function testGetsInfo()
    {
        $datasetInfo = ['friendlyName' => 'A dataset.'];
        $this->connection->getDataset(Argument::any())->shouldNotBeCalled();
        $dataset = $this->getDataset($this->connection, $datasetInfo);

        $this->assertEquals($datasetInfo, $dataset->info());
    }

    public function testGetsInfoWithReload()
    {
        $datasetInfo = ['friendlyName' => 'A dataset.'];
        $this->connection->getDataset(Argument::any())
            ->willReturn($datasetInfo)
            ->shouldBeCalledTimes(1);
        $dataset = $this->getDataset($this->connection);

        $this->assertEquals($datasetInfo, $dataset->info());
    }

    public function testGetsId()
    {
        $dataset = $this->getDataset($this->connection);

        $this->assertEquals($this->datasetId, $dataset->id());
    }

    public function testGetsIdentity()
    {
        $dataset = $this->getDataset($this->connection);

        $this->assertEquals($this->datasetId, $dataset->identity()['datasetId']);
        $this->assertEquals($this->projectId, $dataset->identity()['projectId']);
    }
}
