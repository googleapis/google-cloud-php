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
use Google\Cloud\BigQuery\Table;
use Google\Cloud\BigQuery\ValueMapper;
use Google\Cloud\Core\Exception\NotFoundException;
use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

/**
 * @group bigquery
 */
class DatasetTest extends TestCase
{
    public $connection;
    public $mapper;
    public $projectId = 'myProjectId';
    public $datasetId = 'myDatasetId';
    public $tableId = 'myTableId';

    public function setUp()
    {
        $this->mapper = new ValueMapper(false);
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function getDataset($connection, array $data = [])
    {
        return new Dataset(
            $connection->reveal(),
            $this->datasetId,
            $this->projectId,
            $this->mapper,
            $data
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
