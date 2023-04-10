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

use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\BigQuery\CopyJobConfiguration;
use Google\Cloud\BigQuery\ExtractJobConfiguration;
use Google\Cloud\BigQuery\InsertResponse;
use Google\Cloud\BigQuery\Job;
use Google\Cloud\BigQuery\JobConfigurationInterface;
use Google\Cloud\BigQuery\LoadJobConfiguration;
use Google\Cloud\BigQuery\Table;
use Google\Cloud\BigQuery\ValueMapper;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Storage\Connection\Rest as StorageConnection;
use Google\Cloud\Storage\StorageClient;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group bigquery
 */
class TableTest extends SnippetTestCase
{
    use ProphecyTrait;

    const ID = 'foo';
    const DSID = 'bar';
    const PROJECT = 'my-awesome-project';
    const JOB_ID = '123';

    private $info;
    private $connection;
    private $table;
    private $mapper;

    public function setUp(): void
    {
        $this->info = [
            'rows' => [
                [
                    'f' => [
                        ['v' => 'abcd']
                    ]
                ]
            ],
            'schema' => [
                'fields' => [
                    [
                        'name' => 'name',
                        'type' => 'STRING'
                    ]
                ]
            ],
            'friendlyName' => 'Jeffrey',
            'selfLink' => 'https://www.googleapis.com/bigquery/v2/projects/my-project/datasets/mynewdataset',
        ];

        $this->mapper = new ValueMapper(false);
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->table = TestHelpers::stub(Table::class, [
            $this->connection->reveal(),
            self::ID,
            self::DSID,
            self::PROJECT,
            $this->mapper,
            $this->info
        ]);
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'exists');
        $snippet->addLocal('table', $this->table);

        $this->connection->getTable(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $this->table->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Table exists!', $res->output());
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'delete');
        $snippet->addLocal('table', $this->table);

        $this->connection->deleteTable(Argument::any())
            ->shouldBeCalled();

        $this->table->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'update');
        $snippet->addLocal('table', $this->table);

        $this->connection->patchTable(Argument::any())
            ->shouldBeCalled();

        $this->table->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testRows()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'rows');
        $snippet->addLocal('table', $this->table);

        $this->connection->listTableData(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'rows' => $this->info['rows']
            ]);

        $this->table->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('rows');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals('abcd' . PHP_EOL, $res->output());
    }

    public function testRunJob()
    {
        $jobConfig = $this->prophesize(JobConfigurationInterface::class);
        $jobConfig->toArray()
            ->willReturn([
                'projectId' => self::PROJECT,
                'jobReference' => [
                    'jobId' => self::JOB_ID,
                    'projectId' => self::PROJECT
                ]
            ]);
        $snippet = $this->snippetFromMethod(Table::class, 'runJob');
        $snippet->addLocal('table', $this->table);
        $snippet->addLocal('jobConfig', $jobConfig->reveal());
        $this->connection->insertJob(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'jobReference' => [
                    'jobId' => self::JOB_ID
                ],
                'status' => [
                    'state' => 'DONE'
                ]
            ]);
        $this->table->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('job');

        $this->assertInstanceOf(Job::class, $res->returnVal());
        $this->assertEquals('1', $res->output());
    }

    public function testStartJob()
    {
        $jobConfig = $this->prophesize(JobConfigurationInterface::class);
        $jobConfig->toArray()
            ->willReturn([
                'projectId' => self::PROJECT,
                'jobReference' => [
                    'jobId' => self::JOB_ID,
                    'projectId' => self::PROJECT
                ]
            ]);
        $snippet = $this->snippetFromMethod(Table::class, 'startJob');
        $snippet->addLocal('table', $this->table);
        $snippet->addLocal('jobConfig', $jobConfig->reveal());
        $this->connection->insertJob(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'jobReference' => [
                    'jobId' => self::JOB_ID
                ]
            ]);
        $this->table->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('job');

        $this->assertInstanceOf(Job::class, $res->returnVal());
    }

    public function testCopy()
    {
        $bq = TestHelpers::stub(BigQueryClient::class);
        $snippet = $this->snippetFromMethod(Table::class, 'copy');
        $snippet->addLocal('bigQuery', $bq);
        $bq->___setProperty('connection', $this->connection->reveal());
        $config = $snippet->invoke('copyJobConfig')
            ->returnVal();

        $this->assertInstanceOf(CopyJobConfiguration::class, $config);
        $this->assertEquals(
            [
                'destinationTable' => [
                    'projectId' => self::PROJECT,
                    'datasetId' => 'myDataset',
                    'tableId' => 'myDestinationTable'
                ],
                'sourceTable' => [
                    'projectId' => self::PROJECT,
                    'datasetId' => 'myDataset',
                    'tableId' => 'mySourceTable'
                ]
            ],
            $config->toArray()['configuration']['copy']
        );
    }

    public function testExtract()
    {
        $storage = TestHelpers::stub(StorageClient::class);
        $storage->___setProperty('connection', $this->prophesize(StorageConnection::class)->reveal());
        $snippet = $this->snippetFromMethod(Table::class, 'extract');
        $snippet->addLocal('storage', $storage);
        $snippet->addLocal('table', $this->table);
        $config = $snippet->invoke('extractJobConfig')
            ->returnVal();

        $this->assertInstanceOf(ExtractJobConfiguration::class, $config);
        $this->assertEquals(
            [
                'destinationUris' => ['gs://myBucket/tableOutput'],
                'sourceTable' => [
                    'projectId' => self::PROJECT,
                    'datasetId' => self::DSID,
                    'tableId' => self::ID
                ]
            ],
            $config->toArray()['configuration']['extract']
        );
    }

    public function testLoad()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'load');
        $snippet->addLocal('table', $this->table);
        $snippet->replace('fopen(\'/path/to/my/data.csv\', \'r\')', '123');
        $config = $snippet->invoke('loadJobConfig')
            ->returnVal();

        $this->assertInstanceOf(LoadJobConfiguration::class, $config);
        $this->assertEquals(
            [
                'destinationTable' => [
                    'projectId' => self::PROJECT,
                    'datasetId' => self::DSID,
                    'tableId' => self::ID
                ]
            ],
            $config->toArray()['configuration']['load']
        );
    }

    public function testLoadFromStorage()
    {
        $storage = TestHelpers::stub(StorageClient::class);
        $storage->___setProperty('connection', $this->prophesize(StorageConnection::class)->reveal());
        $snippet = $this->snippetFromMethod(Table::class, 'loadFromStorage');
        $snippet->addLocal('storage', $storage);
        $snippet->addLocal('table', $this->table);
        $config = $snippet->invoke('loadJobConfig')
            ->returnVal();

        $this->assertInstanceOf(LoadJobConfiguration::class, $config);
        $this->assertEquals(
            [
                'sourceUris' => ['gs://myBucket/important-data.csv'],
                'destinationTable' => [
                    'projectId' => self::PROJECT,
                    'datasetId' => self::DSID,
                    'tableId' => self::ID
                ]
            ],
            $config->toArray()['configuration']['load']
        );
    }

    public function testInsertRow()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'insertRow');
        $snippet->addLocal('table', $this->table);

        $this->connection->insertAllTableData(Argument::any())
            ->shouldBeCalled()
            ->willReturn([

            ]);

        $this->table->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('insertResponse');
        $this->assertInstanceOf(InsertResponse::class, $res->returnVal());
    }

    public function testInsertRows()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'insertRows');
        $snippet->addLocal('table', $this->table);

        $this->connection->insertAllTableData(Argument::any())
            ->shouldBeCalled()
            ->willReturn([

            ]);

        $this->table->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('insertResponse');
        $this->assertInstanceOf(InsertResponse::class, $res->returnVal());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'info');
        $snippet->addLocal('table', $this->table);

        $res = $snippet->invoke();
        $this->assertEquals(
            'https://www.googleapis.com/bigquery/v2/projects/my-project/datasets/mynewdataset',
            $res->output()
        );
    }

    public function testReload()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'reload');
        $snippet->addLocal('table', $this->table);

        $this->connection->getTable(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'selfLink' => 'https://www.googleapis.com/bigquery/v2/projects/my-project/datasets/myupdateddataset'
            ]);

        $this->table->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals(
            'https://www.googleapis.com/bigquery/v2/projects/my-project/datasets/myupdateddataset',
            $res->output()
        );
    }

    public function testId()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'id');
        $snippet->addLocal('table', $this->table);

        $res = $snippet->invoke();
        $this->assertEquals(self::ID, $res->output());
    }

    public function testIdentity()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'identity');
        $snippet->addLocal('table', $this->table);

        $res = $snippet->invoke();
        $this->assertEquals(self::PROJECT, $res->output());
    }

    public function testIam()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'iam');
        $snippet->addLocal('table', $this->table);

        $this->assertInstanceof(Iam::class, $snippet->invoke('iam')->returnVal());
    }
}
