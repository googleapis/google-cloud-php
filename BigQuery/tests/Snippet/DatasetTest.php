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

namespace Google\Cloud\BigQuery\Tests\Snippet;

use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\BigQuery\Dataset;
use Google\Cloud\BigQuery\Routine;
use Google\Cloud\BigQuery\Table;
use Google\Cloud\BigQuery\ValueMapper;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Prophecy\Argument;

/**
 * @group bigquery
 */
class DatasetTest extends SnippetTestCase
{
    private $identity;
    private $connection;
    private $mapper;

    public function set_up()
    {
        $this->mapper = new ValueMapper(false);
        $this->identity = ['datasetId' => 'id', 'projectId' => 'projectId'];
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function getDataset($connection, array $info = [])
    {
        return new Dataset(
            $connection->reveal(),
            $this->identity['datasetId'],
            $this->identity['projectId'],
            $this->mapper,
            $info
        );
    }

    public function testExists()
    {
        $this->connection->getDataset(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([]);
        $dataset = $this->getDataset($this->connection);
        $snippet = $this->snippetFromMethod(Dataset::class, 'exists');
        $snippet->addLocal('dataset', $dataset);
        $res = $snippet->invoke('dataset');

        $this->assertEquals(true, $res->output());
    }

    public function testDelete()
    {
        $this->connection->deleteDataset(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([]);
        $dataset = $this->getDataset($this->connection);
        $snippet = $this->snippetFromMethod(Dataset::class, 'delete');
        $snippet->addLocal('dataset', $dataset);

        $snippet->invoke();
    }

    public function testUpdate()
    {
        $this->connection->patchDataset(Argument::withEntry('friendlyName', 'A fanciful dataset.'))
            ->shouldBeCalledTimes(1)
            ->willReturn([]);
        $dataset = $this->getDataset($this->connection);
        $snippet = $this->snippetFromMethod(Dataset::class, 'update');
        $snippet->addLocal('dataset', $dataset);

        $snippet->invoke();
    }

    public function testTable()
    {
        $dataset = $this->getDataset($this->connection);
        $snippet = $this->snippetFromMethod(Dataset::class, 'table');
        $snippet->addLocal('dataset', $dataset);
        $res = $snippet->invoke('table');

        $this->assertInstanceOf(Table::class, $res->returnVal());
    }

    public function testTables()
    {
        $this->connection->listTables(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'tables' => [
                    [
                        'tableReference' => [
                            'tableId' => 'table'
                        ]
                    ]
                ]
            ]);
        $dataset = $this->getDataset($this->connection);
        $snippet = $this->snippetFromMethod(Dataset::class, 'tables');
        $snippet->addLocal('dataset', $dataset);
        $res = $snippet->invoke('tables');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals('table', trim($res->output()));
    }

    public function testCreateTable()
    {
        $this->connection->insertTable(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([]);
        $dataset = $this->getDataset($this->connection);
        $snippet = $this->snippetFromMethod(Dataset::class, 'createTable');
        $snippet->addLocal('dataset', $dataset);
        $res = $snippet->invoke('table');

        $this->assertInstanceOf(Table::class, $res->returnVal());
    }

    public function testInfo()
    {
        $selfLink = 'https://www.googleapis.com/bigquery/v2/projects/my-project/datasets/mynewdataset';
        $dataset = $this->getDataset($this->connection, ['selfLink' => $selfLink]);
        $snippet = $this->snippetFromMethod(Dataset::class, 'info');
        $snippet->addLocal('dataset', $dataset);
        $res = $snippet->invoke();

        $this->assertEquals($selfLink, $res->output());
    }

    public function testReload()
    {
        $selfLink = 'https://www.googleapis.com/bigquery/v2/projects/my-project/datasets/mynewdataset';
        $this->connection->getDataset(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn(['selfLink' => $selfLink]);
        $dataset = $this->getDataset($this->connection);
        $snippet = $this->snippetFromMethod(Dataset::class, 'reload');
        $snippet->addLocal('dataset', $dataset);
        $res = $snippet->invoke();

        $this->assertEquals($selfLink, $res->output());
    }

    public function testId()
    {
        $dataset = $this->getDataset($this->connection);
        $snippet = $this->snippetFromMethod(Dataset::class, 'id');
        $snippet->addLocal('dataset', $dataset);
        $res = $snippet->invoke();

        $this->assertEquals($this->identity['datasetId'], $res->output());
    }

    public function testIdentity()
    {
        $dataset = $this->getDataset($this->connection);
        $snippet = $this->snippetFromMethod(Dataset::class, 'identity');
        $snippet->addLocal('dataset', $dataset);
        $res = $snippet->invoke();

        $this->assertEquals($this->identity['projectId'], $res->output());
    }

    public function testModel()
    {
        $dataset = $this->getDataset($this->connection);
        $snippet = $this->snippetFromMethod(Dataset::class, 'model');
        $snippet->addLocal('dataset', $dataset);
        $res = $snippet->invoke();

        $this->assertEquals('my_model', $res->output());
    }

    public function testModels()
    {
        $this->connection->listModels(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'models' => [
                    [
                        'modelReference' => [
                            'modelId' => 'my_model'
                        ]
                    ]
                ]
            ]);
        $dataset = $this->getDataset($this->connection);
        $snippet = $this->snippetFromMethod(Dataset::class, 'models');
        $snippet->addLocal('dataset', $dataset);
        $res = $snippet->invoke('models');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals('my_model', trim($res->output()));
    }

    public function testRoutine()
    {
        $snippet = $this->snippetFromMethod(Dataset::class, 'routine');
        $snippet->addLocal('dataset', $this->getDataset($this->connection));

        $res = $snippet->invoke('routine');
        $this->assertInstanceOf(Routine::class, $res->returnVal());
        $this->assertEquals('my_routine', $res->output());
    }

    public function testRoutines()
    {
        $this->connection->listRoutines(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'routines' => [
                    [
                        'routineReference' => [
                            'routineId' => 'my_routine'
                        ]
                    ]
                ]
            ]);

        $dataset = $this->getDataset($this->connection);
        $snippet = $this->snippetFromMethod(Dataset::class, 'routines');
        $snippet->addLocal('dataset', $dataset);
        $res = $snippet->invoke('routines');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals('my_routine', trim($res->output()));
    }

    public function testCreateRoutine()
    {
        $this->connection->insertRoutine(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([]);

        $dataset = $this->getDataset($this->connection);
        $snippet = $this->snippetFromMethod(Dataset::class, 'createRoutine');
        $snippet->addLocal('dataset', $dataset);
        $res = $snippet->invoke('routine');

        $this->assertInstanceOf(Routine::class, $res->returnVal());
    }
}
