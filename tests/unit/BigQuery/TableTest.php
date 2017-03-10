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

namespace Google\Cloud\Tests\Unit\BigQuery;

use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\BigQuery\InsertResponse;
use Google\Cloud\BigQuery\Job;
use Google\Cloud\BigQuery\Table;
use Google\Cloud\BigQuery\ValueMapper;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Upload\AbstractUploader;
use Google\Cloud\Storage\Connection\ConnectionInterface as StorageConnectionInterface;
use Google\Cloud\Storage\StorageObject;
use Prophecy\Argument;

/**
 * @group bigquery
 */
class TableTest extends \PHPUnit_Framework_TestCase
{
    public $connection;
    public $storageConnection;
    public $mapper;
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
            'fields' => [
                [
                    'name' => 'first_name',
                    'type' => 'STRING'
                ]
            ]
        ]
    ];
    public $insertJobResponse = [
        'jobReference' => [
            'jobId' => 'myJobId'
        ]
    ];

    public function setUp()
    {
        $this->mapper = new ValueMapper(false);
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->storageConnection = $this->prophesize(StorageConnectionInterface::class);
    }

    public function getObject()
    {
        return new StorageObject(
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
            $this->mapper,
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

    public function testDelete()
    {
        $this->connection->deleteTable(Argument::any())
            ->shouldBeCalledTimes(1);
        $table = $this->getTable($this->connection);
        $this->assertNull($table->delete());
    }

    public function testUpdatesData()
    {
        $updateData = ['friendlyName' => 'wow a name'];
        $this->connection->patchTable(Argument::any())
            ->willReturn($updateData)
            ->shouldBeCalledTimes(1);
        $table = $this->getTable($this->connection, ['friendlyName' => 'another name']);
        $table->update($updateData);

        $this->assertEquals($updateData['friendlyName'], $table->info()['friendlyName']);
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
        $rows = iterator_to_array($table->rows());

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
        $rows = iterator_to_array($table->rows());

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
        $rows = iterator_to_array($table->rows());

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
        $this->assertEquals($this->insertJobResponse, $job->info());
    }

    /**
     * @dataProvider destinationProvider
     */
    public function testRunsExportJob($destinationObject)
    {
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
        $this->assertEquals($this->insertJobResponse, $job->info());
    }

    public function destinationProvider()
    {
        $this->setUp();

        return [
            [$this->getObject()],
            [sprintf(
                'gs://%s/%s',
                $this->bucketName,
                $this->fileName
            )]
        ];
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
        $this->assertEquals($this->insertJobResponse, $job->info());
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
        $this->assertEquals($this->insertJobResponse, $job->info());
    }

    public function testInsertsRow()
    {
        $insertId = '1';
        $rowData = ['key' => 'value'];
        $expectedArguments = [
            'tableId' => $this->tableId,
            'projectId' => $this->projectId,
            'datasetId' => $this->datasetId,
            'rows' => [
                [
                    'json' => $rowData,
                    'insertId' => $insertId
                ]
            ]
        ];
        $this->connection->insertAllTableData($expectedArguments)
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $table = $this->getTable($this->connection);

        $insertResponse = $table->insertRow($rowData, [
            'insertId' => $insertId
        ]);

        $this->assertInstanceOf(InsertResponse::class, $insertResponse);
        $this->assertTrue($insertResponse->isSuccessful());
    }

    public function testInsertsRows()
    {
        $insertId = '1';
        $data = ['key' => 'value'];
        $rowData = [
            [
                'insertId' => $insertId,
                'data' => $data
            ]
        ];
        $expectedArguments = [
            'tableId' => $this->tableId,
            'projectId' => $this->projectId,
            'datasetId' => $this->datasetId,
            'rows' => [
                [
                    'json' => $data,
                    'insertId' => $insertId
                ]
            ]
        ];
        $this->connection->insertAllTableData($expectedArguments)
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $table = $this->getTable($this->connection);

        $insertResponse = $table->insertRows($rowData);

        $this->assertInstanceOf(InsertResponse::class, $insertResponse);
        $this->assertTrue($insertResponse->isSuccessful());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInsertRowsThrowsException()
    {
        $table = $this->getTable($this->connection);
        $table->insertRows([[], []]);
    }

    public function testGetsInfo()
    {
        $tableInfo = ['tableReference' => ['tableId' => $this->tableId]];
        $this->connection->getTable(Argument::any())->shouldNotBeCalled();
        $table = $this->getTable($this->connection, $tableInfo);

        $this->assertEquals($tableInfo, $table->info());
    }

    public function testGetsInfoWithReload()
    {
        $tableInfo = ['tableReference' => ['tableId' => $this->tableId]];
        $this->connection->getTable(Argument::any())
            ->willReturn($tableInfo)
            ->shouldBeCalledTimes(1);
        $table = $this->getTable($this->connection);

        $this->assertEquals($tableInfo, $table->info());
    }

    public function testGetsId()
    {
        $table = $this->getTable($this->connection);

        $this->assertEquals($this->tableId, $table->id());
    }

    public function testGetsIdentity()
    {
        $table = $this->getTable($this->connection);

        $this->assertEquals($this->tableId, $table->identity()['tableId']);
        $this->assertEquals($this->projectId, $table->identity()['projectId']);
    }
}
