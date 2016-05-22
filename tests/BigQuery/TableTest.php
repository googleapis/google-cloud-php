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

namespace Google\Cloud\Tests\BigQuery;

use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\BigQuery\Job;
use Google\Cloud\BigQuery\Table;
use Google\Cloud\Exception\NotFoundException;
use Google\Cloud\Storage\Connection\ConnectionInterface as StorageConnectionInterface;
use Google\Cloud\Storage\Object;
use Google\Cloud\Upload\AbstractUploader;
use Prophecy\Argument;

class TableTest extends \PHPUnit_Framework_TestCase
{
    public $connection;
    public $storageConnection;
    public $fileName = 'myfile.csv';
    public $bucketName = 'myBucket';
    public $projectId = 'myProjectId';
    public $tableId = 'myTableId';
    public $datasetId = 'myDatasetId';
    public $rowData = [
        'rows' => [
            ['f' => [['v' => 'Alton']]]
        ]
    ];
    public $schemaData = [
        'schema' => [
            'fields' => [['name' => 'first_name']]
        ]
    ];
    public $insertJobResponse = [
        'jobReference' => [
            'jobId' => 'myJobId'
        ]
    ];

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->storageConnection = $this->prophesize(StorageConnectionInterface::class);
    }

    public function getObject()
    {
        return new Object(
            $this->storageConnection->reveal(),
            $this->fileName,
            $this->bucketName
        );
    }

    public function getTable($connection, array $data = [], $tableId = null)
    {
        return new Table(
            $connection->reveal(),
            $tableId ?: $this->tableId,
            $this->datasetId,
            $this->projectId,
            $data
        );
    }

    public function testDoesExistTrue()
    {
        $this->connection->getTable(Argument::any())
            ->willReturn([
                'tableReference' => ['tableId' => $this->tableId]
            ])
            ->shouldBeCalledTimes(1);
        $table = $this->getTable($this->connection);

        $this->assertTrue($table->exists());
    }

    public function testDoesExistFalse()
    {
        $this->connection->getTable(Argument::any())
            ->willThrow(new NotFoundException(null))
            ->shouldBeCalledTimes(1);
        $table = $this->getTable($this->connection);

        $this->assertFalse($table->exists());
    }

    public function testGetsRowsWithNoResults()
    {
        $this->connection->getTable(Argument::any())
            ->willReturn($this->schemaData)
            ->shouldBeCalledTimes(1);
        $this->connection->listTableData(Argument::any())
            ->willReturn([])
            ->shouldBeCalledTimes(1);

        $table = $this->getTable($this->connection);
        $rows = iterator_to_array($table->getRows());

        $this->assertEmpty($rows);
    }

    public function testGetsRowsWithoutToken()
    {
        $this->connection->getTable(Argument::any())
            ->willReturn($this->schemaData)
            ->shouldBeCalledTimes(1);
        $this->connection->listTableData(Argument::any())
            ->willReturn($this->rowData)
            ->shouldBeCalledTimes(1);

        $table = $this->getTable($this->connection);
        $rows = iterator_to_array($table->getRows());

        $this->assertEquals(
            $this->rowData['rows'][0]['f'][0]['v'],
            $rows[0]['first_name']
        );
    }

    public function testGetsRowsWithToken()
    {
        $name = 'Mike';
        $secondRowData = $this->rowData;
        $secondRowData['rows'][0]['f'][0]['v'] = $name;
        $this->connection->getTable(Argument::any())
            ->willReturn($this->schemaData)
            ->shouldBeCalledTimes(1);
        $this->connection->listTableData(Argument::any())
            ->willReturn(
                $this->rowData + ['nextPageToken' => 'abc'],
                $secondRowData
            )
            ->shouldBeCalledTimes(2);

        $table = $this->getTable($this->connection);
        $rows = iterator_to_array($table->getRows());

        $this->assertEquals($name, $rows[1]['first_name']);
    }

    public function testRunsCopyJob()
    {
        $destinationTableId = 'destinationTable';
        $destinationTable = $this->getTable($this->connection, [], $destinationTableId);
        $expectedArguments = [
            'projectId' => $this->projectId,
            'configuration' => [
                'copy' => [
                    'destinationTable' => [
                        'datasetId' => $this->datasetId,
                        'tableId' => $destinationTableId,
                        'projectId' => $this->projectId
                    ],
                    'sourceTable' => [
                        'datasetId' => $this->datasetId,
                        'tableId' => $this->tableId,
                        'projectId' => $this->projectId
                    ]
                ]
            ]
        ];
        $this->connection->insertJob(Argument::exact($expectedArguments))
            ->willReturn($this->insertJobResponse)
            ->shouldBeCalledTimes(1);
        $table = $this->getTable($this->connection);
        $job = $table->copy($destinationTable);

        $this->assertInstanceOf(Job::class, $job);
        $this->assertEquals($this->insertJobResponse, $job->getInfo());
    }

    public function testRunsExportJob()
    {
        $destinationObject = $this->getObject();
        $expectedArguments = [
            'projectId' => $this->projectId,
            'configuration' => [
                'extract' => [
                    'destinationUris' => [
                        'gs://' . $this->bucketName . '/' . $this->fileName
                    ],
                    'sourceTable' => [
                        'datasetId' => $this->datasetId,
                        'tableId' => $this->tableId,
                        'projectId' => $this->projectId
                    ]
                ]
            ]
        ];
        $this->connection->insertJob(Argument::exact($expectedArguments))
            ->willReturn($this->insertJobResponse)
            ->shouldBeCalledTimes(1);
        $table = $this->getTable($this->connection);
        $job = $table->export($destinationObject);

        $this->assertInstanceOf(Job::class, $job);
        $this->assertEquals($this->insertJobResponse, $job->getInfo());
    }

    public function testRunsLoadJob()
    {
        $data = 'abc';
        $uploader = $this->prophesize(AbstractUploader::class);
        $uploader->upload()
            ->willReturn($this->insertJobResponse)
            ->shouldBeCalledTimes(1);
        $expectedArguments = [
            'data' => $data,
            'projectId' => $this->projectId,
            'configuration' => [
                'load' => [
                    'destinationTable' => [
                        'datasetId' => $this->datasetId,
                        'tableId' => $this->tableId,
                        'projectId' => $this->projectId
                    ]
                ]
            ]
        ];
        $this->connection->insertJobUpload(Argument::exact($expectedArguments))
            ->willReturn($uploader)
            ->shouldBeCalledTimes(1);
        $table = $this->getTable($this->connection);
        $job = $table->load($data);

        $this->assertInstanceOf(Job::class, $job);
        $this->assertEquals($this->insertJobResponse, $job->getInfo());
    }

    public function testRunsLoadJobFromStorage()
    {
        $sourceObject = $this->getObject();
        $expectedArguments = [
            'projectId' => $this->projectId,
            'configuration' => [
                'load' => [
                    'sourceUris' => [
                        'gs://' . $this->bucketName . '/' . $this->fileName
                    ],
                    'destinationTable' => [
                        'datasetId' => $this->datasetId,
                        'tableId' => $this->tableId,
                        'projectId' => $this->projectId
                    ]
                ]
            ]
        ];
        $this->connection->insertJob(Argument::exact($expectedArguments))
            ->willReturn($this->insertJobResponse)
            ->shouldBeCalledTimes(1);
        $table = $this->getTable($this->connection);
        $job = $table->loadFromStorage($sourceObject);

        $this->assertInstanceOf(Job::class, $job);
        $this->assertEquals($this->insertJobResponse, $job->getInfo());
    }

    public function testGetsInfo()
    {
        $tableInfo = ['tableReference' => ['tableId' => $this->tableId]];
        $this->connection->getTable(Argument::any())->shouldNotBeCalled();
        $table = $this->getTable($this->connection, $tableInfo);

        $this->assertEquals($tableInfo, $table->getInfo());
    }

    public function testGetsInfoWithReload()
    {
        $tableInfo = ['tableReference' => ['tableId' => $this->tableId]];
        $this->connection->getTable(Argument::any())
            ->willReturn($tableInfo)
            ->shouldBeCalledTimes(1);
        $table = $this->getTable($this->connection);

        $this->assertEquals($tableInfo, $table->getInfo());
    }

    public function testGetsId()
    {
        $table = $this->getTable($this->connection);

        $this->assertEquals($this->tableId, $table->getId());
    }

    public function testGetsIdentity()
    {
        $table = $this->getTable($this->connection);

        $this->assertEquals($this->tableId, $table->getIdentity()['tableId']);
        $this->assertEquals($this->projectId, $table->getIdentity()['projectId']);
    }
}
