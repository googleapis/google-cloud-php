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

namespace Google\Cloud\Tests\Snippets\BigQuery;

use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\BigQuery\InsertResponse;
use Google\Cloud\BigQuery\Job;
use Google\Cloud\BigQuery\Table;
use Google\Cloud\BigQuery\ValueMapper;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Upload\MultipartUploader;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Storage\Connection\ConnectionInterface as StorageConnectionInterface;
use Google\Cloud\Storage\StorageClient;
use Prophecy\Argument;

/**
 * @group bigquery
 */
class TableTest extends SnippetTestCase
{
    const ID = 'foo';
    const DSID = 'bar';
    const PROJECT = 'my-awesome-project';

    private $info;
    private $connection;
    private $table;
    private $mapper;

    public function setUp()
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
            'friendlyName' => 'Jeffrey'
        ];

        $this->mapper = new ValueMapper(false);
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->table = \Google\Cloud\Dev\Stub(Table::class, [
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

    public function testCopy()
    {
        $bq = \Google\Cloud\Dev\stub(BigQueryClient::class);
        $snippet = $this->snippetFromMethod(Table::class, 'copy');
        $snippet->addLocal('bigQuery', $bq);

        $bq->___setProperty('connection', $this->connection->reveal());

        $this->connection->insertJob(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'jobReference' => [
                    'jobId' => '123'
                ]
            ]);

        $this->table->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('job');
        $this->assertInstanceOf(Job::class, $res->returnVal());
    }

    public function testExport()
    {
        $storage = \Google\Cloud\Dev\stub(StorageClient::class);
        $storage->___setProperty('connection', $this->prophesize(StorageConnectionInterface::class)->reveal());

        $snippet = $this->snippetFromMethod(Table::class, 'export');
        $snippet->addLocal('storage', $storage);
        $snippet->addLocal('table', $this->table);

        $this->connection->insertJob(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'jobReference' => [
                    'jobId' => '123'
                ]
            ]);

        $this->table->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('job');
        $this->assertInstanceOf(Job::class, $res->returnVal());
    }

    public function testLoad()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'load');
        $snippet->addLocal('table', $this->table);
        $snippet->replace('/path/to/my/data.csv', 'php://temp');

        $uploader = $this->prophesize(MultipartUploader::class);
        $uploader->upload()
            ->shouldBeCalled()
            ->willReturn([
                'jobReference' => [
                    'jobId' => '123'
                ]
            ]);

        $this->connection->insertJobUpload(Argument::any())
            ->shouldBeCalled()
            ->willReturn($uploader->reveal());

        $this->table->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('job');
        $this->assertInstanceOf(Job::class, $res->returnVal());
    }

    public function testLoadFromStorage()
    {
        $storage = \Google\Cloud\Dev\stub(StorageClient::class);
        $storage->___setProperty('connection', $this->prophesize(StorageConnectionInterface::class)->reveal());

        $snippet = $this->snippetFromMethod(Table::class, 'loadFromStorage');
        $snippet->addLocal('storage', $storage);
        $snippet->addLocal('table', $this->table);

        $uploader = $this->prophesize(MultipartUploader::class);
        $uploader->upload()
            ->shouldBeCalled()
            ->willReturn([
                'jobReference' => [
                    'jobId' => '123'
                ]
            ]);

        $this->connection->insertJobUpload(Argument::any())
            ->shouldBeCalled()
            ->willReturn($uploader->reveal());

        $this->table->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('job');
        $this->assertInstanceOf(Job::class, $res->returnVal());
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
        $this->assertEquals('Jeffrey', $res->output());
    }

    public function testReload()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'reload');
        $snippet->addLocal('table', $this->table);

        $this->connection->getTable(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'friendlyName' => 'El Jefe'
            ]);

        $this->table->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('El Jefe', $res->output());
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
}
