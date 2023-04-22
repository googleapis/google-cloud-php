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
use Google\Cloud\BigQuery\CopyJobConfiguration;
use Google\Cloud\BigQuery\ExtractJobConfiguration;
use Google\Cloud\BigQuery\InsertResponse;
use Google\Cloud\BigQuery\Job;
use Google\Cloud\BigQuery\JobConfigurationInterface;
use Google\Cloud\BigQuery\LoadJobConfiguration;
use Google\Cloud\BigQuery\Table;
use Google\Cloud\BigQuery\ValueMapper;
use Google\Cloud\Core\Exception\ConflictException;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Upload\AbstractUploader;
use Google\Cloud\Storage\Connection\ConnectionInterface as StorageConnectionInterface;
use Google\Cloud\Storage\StorageObject;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group bigquery
 */
class TableTest extends TestCase
{
    use ProphecyTrait;

    const JOB_ID = 'myJobId';
    const PROJECT_ID = 'myProjectId';
    const BUCKET_NAME = 'myBucket';
    const FILE_NAME = 'myfile.csv';
    const TABLE_ID = 'myTableId';
    const DATASET_ID = 'myDatasetId';

    public $connection;
    public $storageConnection;
    public $mapper;
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
            'jobId' => self::JOB_ID
        ],
        'status' => [
            'state' => 'RUNNING'
        ]
    ];

    public function setUp(): void
    {
        $this->mapper = new ValueMapper(false);
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->storageConnection = $this->prophesize(StorageConnectionInterface::class);
    }

    public function getObject()
    {
        return new StorageObject(
            $this->storageConnection->reveal(),
            self::FILE_NAME,
            self::BUCKET_NAME
        );
    }

    public function getTable($connection, array $data = [], $tableId = null, $location = null)
    {
        return new TableStub(
            $connection->reveal(),
            $tableId ?: self::TABLE_ID,
            self::DATASET_ID,
            self::PROJECT_ID,
            $this->mapper,
            $data,
            $location
        );
    }

    public function testDoesExistTrue()
    {
        $this->connection->getTable(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('tableId', self::TABLE_ID)
        ))
            ->willReturn([
                'tableReference' => ['tableId' => self::TABLE_ID]
            ])
            ->shouldBeCalledTimes(1);

        $table = $this->getTable($this->connection);

        $this->assertTrue($table->exists());
    }

    public function testDoesExistFalse()
    {
        $this->connection->getTable(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('tableId', self::TABLE_ID)
        ))
            ->willThrow(new NotFoundException(null))
            ->shouldBeCalledTimes(1);

        $table = $this->getTable($this->connection);

        $this->assertFalse($table->exists());
    }

    public function testDelete()
    {
        $this->connection->deleteTable(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('tableId', self::TABLE_ID),
            Argument::withEntry('retries', 0)
        ))
            ->shouldBeCalledTimes(1);

        $table = $this->getTable($this->connection);
        $this->assertNull($table->delete());
    }

    public function testUpdatesData()
    {
        $updateData = ['friendlyName' => 'wow a name', 'etag' => 'foo'];
        $this->connection->patchTable(Argument::that(function ($args) {
            return $args['restOptions']['headers']['If-Match'] === 'foo';
        }))
            ->willReturn($updateData)
            ->shouldBeCalledTimes(1);
        $table = $this->getTable($this->connection, ['friendlyName' => 'another name']);
        $table->update($updateData);

        $this->assertEquals($updateData['friendlyName'], $table->info()['friendlyName']);
    }

    public function testUpdatesDataWithEtag()
    {
        $updateData = ['friendlyName' => 'wow a name'];
        $this->connection->patchTable(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('tableId', self::TABLE_ID),
            Argument::withEntry('friendlyName', $updateData['friendlyName'])
        ))
            ->willReturn($updateData)
            ->shouldBeCalledTimes(1);

        $table = $this->getTable($this->connection, ['friendlyName' => 'another name']);
        $table->update($updateData);

        $this->assertEquals($updateData['friendlyName'], $table->info()['friendlyName']);
    }

    public function testGetsRowsWithNoResults()
    {
        $this->connection->getTable(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('tableId', self::TABLE_ID)
        ))
            ->willReturn($this->schemaData)
            ->shouldBeCalledTimes(1);

        $this->connection->listTableData(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('tableId', self::TABLE_ID)
        ))
            ->willReturn([])
            ->shouldBeCalledTimes(1);

        $table = $this->getTable($this->connection);
        $rows = iterator_to_array($table->rows());

        $this->assertEmpty($rows);
    }

    public function testGetsRowsWithoutToken()
    {
        $this->connection->getTable(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('tableId', self::TABLE_ID)
        ))
            ->willReturn($this->schemaData)
            ->shouldBeCalledTimes(1);

        $this->connection->listTableData(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('tableId', self::TABLE_ID)
        ))
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
        $this->connection->getTable(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('tableId', self::TABLE_ID)
        ))
            ->willReturn($this->schemaData)
            ->shouldBeCalledTimes(1);

        $this->connection->listTableData(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('tableId', self::TABLE_ID)
        ))
            ->willReturn(
                $this->rowData + ['pageToken' => 'abc'],
                $secondRowData
            )
            ->shouldBeCalledTimes(2);

        $table = $this->getTable($this->connection);
        $rows = iterator_to_array($table->rows());

        $this->assertEquals($name, $rows[1]['first_name']);
    }

    /**
     * @dataProvider jobConfigDataProvider
     */
    public function testRunJob($expectedData, $expectedMethod, $returnedData)
    {
        $jobConfig = $this->prophesize(JobConfigurationInterface::class);
        $jobConfig->toArray()
            ->willReturn($expectedData);
        $this->connection->$expectedMethod($expectedData)
            ->willReturn($returnedData)
            ->shouldBeCalledTimes(1);

        $this->connection->getJob(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('jobId', self::JOB_ID)
        ))
            ->willReturn([
                'status' => [
                    'state' => 'DONE'
                ]
            ])
            ->shouldBeCalledTimes(1);

        $table = $this->getTable($this->connection);
        $job = $table->runJob($jobConfig->reveal());

        $this->assertInstanceOf(Job::class, $job);
        $this->assertTrue($job->isComplete());
    }

    /**
     * @dataProvider jobConfigDataProvider
     */
    public function testStartJob($expectedData, $expectedMethod, $returnedData)
    {
        $jobConfig = $this->prophesize(JobConfigurationInterface::class);
        $jobConfig->toArray()
            ->willReturn($expectedData);
        $this->connection->$expectedMethod($expectedData)
            ->willReturn($returnedData)
            ->shouldBeCalledTimes(1);

        $this->connection->getJob(Argument::any())
            ->shouldNotBeCalled();

        $table = $this->getTable($this->connection);
        $job = $table->startJob($jobConfig->reveal());

        $this->assertInstanceOf(Job::class, $job);
        $this->assertFalse($job->isComplete());
        $this->assertEquals($this->insertJobResponse, $job->info());
    }

    public function jobConfigDataProvider()
    {
        $expected = [
            'projectId' => self::PROJECT_ID,
            'jobReference' => [
                'projectId' => self::PROJECT_ID,
                'jobId' => self::JOB_ID
            ]
        ];
        $uploader = $this->prophesize(AbstractUploader::class);
        $uploader->upload()
            ->willReturn($this->insertJobResponse)
            ->shouldBeCalledTimes(1);

        return [
            [
                $expected,
                'insertJob',
                $this->insertJobResponse
            ],
            [
                $expected + ['data' => 'abc'],
                'insertJobUpload',
                $uploader->reveal()
            ]
        ];
    }

    public function testGetsCopyJobConfiguration()
    {
        $destinationTableId = 'destinationTable';
        $destinationTable = $this->getTable($this->connection, [], $destinationTableId);
        $expected = [
            'projectId' => self::PROJECT_ID,
            'configuration' => [
                'copy' => [
                    'destinationTable' => [
                        'datasetId' => self::DATASET_ID,
                        'tableId' => $destinationTableId,
                        'projectId' => self::PROJECT_ID
                    ],
                    'sourceTable' => [
                        'datasetId' => self::DATASET_ID,
                        'tableId' => self::TABLE_ID,
                        'projectId' => self::PROJECT_ID
                    ]
                ]
            ],
            'jobReference' => [
                'projectId' => self::PROJECT_ID,
                'jobId' => self::JOB_ID
            ]
        ];
        $table = $this->getTable($this->connection);
        $config = $table->copy($destinationTable, [
            'jobReference' => ['jobId' => self::JOB_ID]
        ]);

        $this->assertInstanceOf(CopyJobConfiguration::class, $config);
        $this->assertEquals($expected, $config->toArray());
    }

    /**
     * @dataProvider destinationProvider
     */
    public function testGetsExtractJobConfiguration($destinationObject)
    {
        $expected = [
            'projectId' => self::PROJECT_ID,
            'configuration' => [
                'extract' => [
                    'destinationUris' => [
                        'gs://' . self::BUCKET_NAME . '/' . self::FILE_NAME
                    ],
                    'sourceTable' => [
                        'datasetId' => self::DATASET_ID,
                        'tableId' => self::TABLE_ID,
                        'projectId' => self::PROJECT_ID
                    ]
                ]
            ],
            'jobReference' => [
                'projectId' => self::PROJECT_ID,
                'jobId' => self::JOB_ID
            ]
        ];
        $table = $this->getTable($this->connection);
        $config = $table->extract($destinationObject, [
            'jobReference' => ['jobId' => self::JOB_ID]
        ]);

        $this->assertInstanceOf(ExtractJobConfiguration::class, $config);
        $this->assertEquals($expected, $config->toArray());
    }

    public function destinationProvider()
    {
        $this->setUp();

        return [
            [$this->getObject()],
            [sprintf(
                'gs://%s/%s',
                self::BUCKET_NAME,
                self::FILE_NAME
            )]
        ];
    }

    public function testGetsLoadJobConfiguration()
    {
        $data = 'abc';
        $expected = [
            'data' => $data,
            'projectId' => self::PROJECT_ID,
            'configuration' => [
                'load' => [
                    'destinationTable' => [
                        'datasetId' => self::DATASET_ID,
                        'tableId' => self::TABLE_ID,
                        'projectId' => self::PROJECT_ID
                    ]
                ]
            ],
            'jobReference' => [
                'projectId' => self::PROJECT_ID,
                'jobId' => self::JOB_ID
            ]
        ];
        $table = $this->getTable($this->connection);
        $config = $table->load($data, [
            'jobReference' => ['jobId' => self::JOB_ID]
        ]);

        $this->assertInstanceOf(LoadJobConfiguration::class, $config);
        $this->assertEquals($expected, $config->toArray());
    }

    public function testGetsLoadJobConfigurationFromStorage()
    {
        $sourceObject = $this->getObject();
        $expected = [
            'projectId' => self::PROJECT_ID,
            'configuration' => [
                'load' => [
                    'sourceUris' => [
                        'gs://' . self::BUCKET_NAME . '/' . self::FILE_NAME
                    ],
                    'destinationTable' => [
                        'datasetId' => self::DATASET_ID,
                        'tableId' => self::TABLE_ID,
                        'projectId' => self::PROJECT_ID
                    ]
                ]
            ],
            'jobReference' => [
                'projectId' => self::PROJECT_ID,
                'jobId' => self::JOB_ID
            ]
        ];
        $table = $this->getTable($this->connection);
        $config = $table->loadFromStorage($sourceObject, [
            'jobReference' => ['jobId' => self::JOB_ID]
        ]);

        $this->assertInstanceOf(LoadJobConfiguration::class, $config);
        $this->assertEquals($expected, $config->toArray());
    }

    public function testInsertsRow()
    {
        $insertId = '1';
        $rowData = ['key' => 'value'];
        $expectedArguments = [
            'tableId' => self::TABLE_ID,
            'projectId' => self::PROJECT_ID,
            'datasetId' => self::DATASET_ID,
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
            'tableId' => self::TABLE_ID,
            'projectId' => self::PROJECT_ID,
            'datasetId' => self::DATASET_ID,
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

    public function testInsertsRowsWithAutoCreate()
    {
        $insertId = '1';
        $data = ['key' => 'value'];
        $rowData = [
            [
                'insertId' => $insertId,
                'data' => $data
            ]
        ];
        $schema = [
            'fields' => [
                [
                    'name' => 'key',
                    'type' => 'STRING'
                ]
            ]
        ];
        $expectedInsertTableDataArguments = [
            'tableId' => self::TABLE_ID,
            'projectId' => self::PROJECT_ID,
            'datasetId' => self::DATASET_ID,
            'rows' => [
                [
                    'json' => $data,
                    'insertId' => $insertId
                ]
            ]
        ];
        $expectedInsertTableArguments = [
            'schema' => $schema,
            'retries' => 0,
            'projectId' => self::PROJECT_ID,
            'datasetId' => self::DATASET_ID,
            'tableReference' => [
                'projectId' => self::PROJECT_ID,
                'datasetId' => self::DATASET_ID,
                'tableId' => self::TABLE_ID
            ]
        ];
        $callCount = 0;
        $this->connection->insertAllTableData($expectedInsertTableDataArguments)
            ->will(function () use (&$callCount) {
                if ($callCount === 0) {
                    $callCount++;
                    throw new NotFoundException(null);
                }

                return [];
            })
            ->shouldBeCalledTimes(2);
        $this->connection->insertTable($expectedInsertTableArguments)
            ->willReturn([]);
        $table = $this->getTable($this->connection);
        $insertResponse = $table->insertRows($rowData, [
            'autoCreate' => true,
            'tableMetadata' => [
                'schema' => $schema
            ]
        ]);

        $this->assertInstanceOf(InsertResponse::class, $insertResponse);
        $this->assertTrue($insertResponse->isSuccessful());
    }

    public function testInsertRowsThrowsExceptionWithoutSchema()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('A schema is required when creating a table.');

        $options = [
            'autoCreate' => true
        ];
        $this->connection->insertAllTableData(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('tableId', self::TABLE_ID),
            Argument::withKey('rows'),
            Argument::that(function ($arg) {
                return !isset($arg['tableMetadata']['schema']);
            })
        ))
            ->willThrow(new NotFoundException(null));

        $table = $this->getTable($this->connection);
        $table->insertRows([
            [
                'data' => [
                    'city' => 'state'
                ]
            ]
        ], $options);
    }

    public function testInsertRowsThrowsExceptionWithUnretryableTableFailure()
    {
        $this->expectException(\Exception::class);

        $options = [
            'autoCreate' => true,
            'tableMetadata' => [
                'schema' => []
            ]
        ];
        $this->connection->insertAllTableData(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('tableId', self::TABLE_ID),
            Argument::withKey('rows')
        ))
            ->willThrow(new NotFoundException(null))
            ->shouldBeCalledTimes(1);

        $this->connection->insertTable(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('tableReference', [
                'projectId' => self::PROJECT_ID,
                'datasetId' => self::DATASET_ID,
                'tableId' => self::TABLE_ID,
            ]),
            Argument::withEntry('schema', $options['tableMetadata']['schema']),
            Argument::withEntry('retries', 0)
        ))
            ->willThrow(new \Exception())
            ->shouldBeCalledTimes(1);

        $table = $this->getTable($this->connection);
        $table->insertRows([
            [
                'data' => [
                    'city' => 'state'
                ]
            ]
        ], $options);
    }

    public function testInsertRowsThrowsExceptionWhenMaxRetryLimitHit()
    {
        $this->expectException(NotFoundException::class);

        $options = [
            'autoCreate' => true,
            'maxRetries' => 0,
            'tableMetadata' => [
                'schema' => []
            ]
        ];
        $this->connection->insertAllTableData(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('tableId', self::TABLE_ID),
            Argument::withKey('rows')
        ))
            ->willThrow(new NotFoundException(null))
            ->shouldBeCalledTimes(Table::MAX_RETRIES + 2);

        $this->connection->insertTable(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('tableReference', [
                'projectId' => self::PROJECT_ID,
                'datasetId' => self::DATASET_ID,
                'tableId' => self::TABLE_ID,
            ]),
            Argument::withEntry('schema', $options['tableMetadata']['schema']),
            Argument::withEntry('retries', 0)
        ))
            ->willThrow(new ConflictException(null))
            ->shouldBeCalledTimes(Table::MAX_RETRIES + 1);

        $table = $this->getTable($this->connection);
        $table->insertRows([
            [
                'data' => [
                    'city' => 'state'
                ]
            ]
        ], $options);
    }

    public function testInsertRowsThrowsExceptionWithoutDataKey()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('A row must have a data key.');

        $table = $this->getTable($this->connection);
        $table->insertRows([[], []]);
    }

    public function testInsertRowsThrowsExceptionWithZeroRows()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Must provide at least a single row.');

        $table = $this->getTable($this->connection);
        $table->insertRows([]);
    }

    public function testGetsInfo()
    {
        $tableInfo = ['tableReference' => ['tableId' => self::TABLE_ID]];
        $this->connection->getTable(Argument::any())->shouldNotBeCalled();
        $table = $this->getTable($this->connection, $tableInfo);

        $this->assertEquals($tableInfo, $table->info());
    }

    public function testGetsInfoWithReload()
    {
        $tableInfo = ['tableReference' => ['tableId' => self::TABLE_ID]];
        $this->connection->getTable(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT_ID),
            Argument::withEntry('datasetId', self::DATASET_ID),
            Argument::withEntry('tableId', self::TABLE_ID)
        ))
            ->willReturn($tableInfo)
            ->shouldBeCalledTimes(1);

        $table = $this->getTable($this->connection);

        $this->assertEquals($tableInfo, $table->info());
    }

    public function testGetsId()
    {
        $table = $this->getTable($this->connection);

        $this->assertEquals(self::TABLE_ID, $table->id());
    }

    public function testGetsIdentity()
    {
        $table = $this->getTable($this->connection);

        $this->assertEquals(self::TABLE_ID, $table->identity()['tableId']);
        $this->assertEquals(self::PROJECT_ID, $table->identity()['projectId']);
    }

    /**
     * @dataProvider locations
     */
    public function testCopyLocations($expected, $info, $location)
    {
        $table = $this->getTable($this->connection, $info, null, $location);
        $res = $table->copy($table);

        $this->assertEquals($expected, $res->toArray()['jobReference']['location']);
    }

    /**
     * @dataProvider locations
     */
    public function testExtractLocations($expected, $info, $location)
    {
        $table = $this->getTable($this->connection, $info, null, $location);
        $res = $table->extract('foo');

        $this->assertEquals($expected, $res->toArray()['jobReference']['location']);
    }

    /**
     * @dataProvider locations
     */
    public function testLoadLocations($expected, $info, $location)
    {
        $table = $this->getTable($this->connection, $info, null, $location);
        $res = $table->load('foo');

        $this->assertEquals($expected, $res->toArray()['jobReference']['location']);
    }

    public function locations()
    {
        return [
            ['foo', ['location' => 'foo'], 'bar'],
            ['bar', [], 'bar']
        ];
    }

    public function testIam()
    {
        $this->assertInstanceOf(Iam::class, $this->getTable($this->connection)->iam());
    }

    public function testCloneMetadata()
    {
        $table = $this->getTable($this->connection);
        $expected = [
            'cloneDefinition' => [
                'baseTableReference' => [
                    'projectId' => 'test_project',
                    'datasetId' => 'test_dataset',
                    'tableId' => 'test_table'
                ],
                'cloneTime' => '2023-01-11T03:42:11.054Z'
            ]
        ];
        $this->connection->getTable($table->identity())->willReturn($expected);
        $result = $table->reload();

        $this->assertEquals(
            $expected['cloneDefinition'],
            $result['cloneDefinition']
        );
    }

    public function testSnapshotMetadata()
    {
        $table = $this->getTable($this->connection);
        $expected = [
            'snapshotDefinition' => [
                'baseTableReference' => [
                    'projectId' => 'test_project',
                    'datasetId' => 'test_dataset',
                    'tableId' => 'test_table'
                ],
                'snapshotTime' => '2023-01-11T03:42:11.054Z'
            ]
        ];
        $this->connection->getTable($table->identity())->willReturn($expected);

        $result = $table->reload();

        $this->assertEquals(
            $expected['snapshotDefinition'],
            $result['snapshotDefinition']
        );
    }
}

//@codingStandardsIgnoreStart
class TableStub extends Table
{
    protected function usleep($ms)
    {
        return;
    }
}
//@codingStandardsIgnoreEnd
