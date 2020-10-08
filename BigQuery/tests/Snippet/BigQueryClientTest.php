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
use Google\Cloud\BigQuery\Bytes;
use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\BigQuery\CopyJobConfiguration;
use Google\Cloud\BigQuery\Dataset;
use Google\Cloud\BigQuery\Date;
use Google\Cloud\BigQuery\ExtractJobConfiguration;
use Google\Cloud\BigQuery\Geography;
use Google\Cloud\BigQuery\Job;
use Google\Cloud\BigQuery\JobConfigurationInterface;
use Google\Cloud\BigQuery\LoadJobConfiguration;
use Google\Cloud\BigQuery\Numeric;
use Google\Cloud\BigQuery\QueryJobConfiguration;
use Google\Cloud\BigQuery\QueryResults;
use Google\Cloud\BigQuery\Time;
use Google\Cloud\BigQuery\Timestamp;
use Google\Cloud\BigQuery\ValueMapper;
use Google\Cloud\Core\Int64;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Prophecy\Argument;

/**
 * @group bigquery
 */
class BigQueryClientTest extends SnippetTestCase
{
    const JOB_ID = 'myJobId';
    const PROJECT_ID = 'my-awesome-project';
    const CREATE_DISPOSITION = 'CREATE_NEVER';
    const QUERY_STRING = 'SELECT commit FROM `bigquery-public-data.github_repos.commits` LIMIT 100';

    private $connection;
    private $client;
    private $result = [
        'jobComplete' => true,
        'jobReference' => [
            'jobId' => 'job'
        ],
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
                    'name' => 'commit',
                    'type' => 'STRING'
                ]
            ]
        ]
    ];

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = TestHelpers::stub(BigQueryTestClient::class);
        $this->client->___setProperty('connection', $this->connection->reveal());
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(BigQueryClient::class);
        $res = $snippet->invoke('bigQuery');

        $this->assertInstanceOf(BigQueryClient::class, $res->returnVal());
    }

    public function testQuery()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'query');
        $snippet->addLocal('bigQuery', $this->client);
        $config = $snippet->invoke('queryJobConfig')
            ->returnVal();

        $this->assertInstanceOf(QueryJobConfiguration::class, $config);
        $this->assertEquals(
            self::QUERY_STRING,
            $config->toArray()['configuration']['query']['query']
        );
    }

    public function testQueryWithFluentSetters()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'query', 1);
        $snippet->addLocal('bigQuery', $this->client);
        $config = $snippet->invoke('queryJobConfig')
            ->returnVal();
        $array = $config->toArray();

        $this->assertInstanceOf(QueryJobConfiguration::class, $config);
        $this->assertEquals(self::QUERY_STRING, $array['configuration']['query']['query']);
        $this->assertEquals(self::CREATE_DISPOSITION, $array['configuration']['query']['createDisposition']);
    }

    public function testQueryWithArrayOfOptions()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'query', 2);
        $snippet->addLocal('bigQuery', $this->client);
        $config = $snippet->invoke('queryJobConfig')
            ->returnVal();
        $array = $config->toArray();

        $this->assertInstanceOf(QueryJobConfiguration::class, $config);
        $this->assertEquals(self::QUERY_STRING, $array['configuration']['query']['query']);
        $this->assertEquals(self::CREATE_DISPOSITION, $array['configuration']['query']['createDisposition']);
    }

    public function testQueryWithLocation()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'query', 3);
        $snippet->addLocal('bigQuery', $this->client);
        $config = $snippet->invoke('queryJobConfig')
            ->returnVal();
        $array = $config->toArray();

        $this->assertInstanceOf(QueryJobConfiguration::class, $config);
        $this->assertEquals(
            'SELECT name FROM `my_project.users_dataset.users` LIMIT 100',
            $array['configuration']['query']['query']
        );
        $this->assertEquals('asia-northeast1', $array['jobReference']['location']);
    }

    public function testRunQuery()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'runQuery');
        $snippet->addLocal('bigQuery', $this->client);
        $this->connection->insertJob(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'jobComplete' => false,
                'jobReference' => [
                    'jobId' => 'job'
                ]
            ]);
        $this->connection->getQueryResults(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($this->result);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('queryResults');

        $this->assertInstanceOf(QueryResults::class, $res->returnVal());
        $this->assertEquals('abcd', $res->output());
    }

    public function testRunQueryWithNamedParameters()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'runQuery', 1);
        $snippet->addLocal('bigQuery', $this->client);
        $expectedQuery = 'SELECT commit FROM `bigquery-public-data.github_repos.commits`' .
                         'WHERE author.date < @date AND message = @message LIMIT 100';
        $this->connection
            ->insertJob([
                'projectId' => self::PROJECT_ID,
                'jobReference' => ['projectId' => self::PROJECT_ID, 'jobId' => self::JOB_ID],
                'configuration' => [
                    'query' => [
                        'parameterMode' => 'named',
                        'useLegacySql' => false,
                        'queryParameters' => [
                            [
                                'name' => 'date',
                                'parameterType' => [
                                    'type' => 'TIMESTAMP'
                                ],
                                'parameterValue' => [
                                    'value' => '1980-01-01 12:15:00.000000+00:00'
                                ]
                            ],
                            [
                                'name' => 'message',
                                'parameterType' => [
                                    'type' => 'STRING'
                                ],
                                'parameterValue' => [
                                    'value' => 'A commit message.'
                                ]
                            ]
                        ],
                        'query' => $expectedQuery
                    ]
                ]
            ])
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'jobComplete' => false,
                'jobReference' => [
                    'jobId' => 'job'
                ]
            ]);
        $this->connection->getQueryResults(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($this->result);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('queryResults');

        $this->assertInstanceOf(QueryResults::class, $res->returnVal());
        $this->assertEquals('abcd', $res->output());
    }

    public function testRunQueryWithPositionalParameters()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'runQuery', 2);
        $snippet->addLocal('bigQuery', $this->client);
        $expectedQuery = 'SELECT commit FROM `bigquery-public-data.github_repos.commits` WHERE message = ? LIMIT 100';
        $this->connection
            ->insertJob([
                'projectId' => self::PROJECT_ID,
                'jobReference' => ['projectId' => self::PROJECT_ID, 'jobId' => self::JOB_ID],
                'configuration' => [
                    'query' => [
                        'parameterMode' => 'positional',
                        'useLegacySql' => false,
                        'queryParameters' => [
                            [
                                'parameterType' => [
                                    'type' => 'STRING'
                                ],
                                'parameterValue' => [
                                    'value' => 'A commit message.'
                                ]
                            ]
                        ],
                        'query' => $expectedQuery
                    ]
                ]
            ])
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'jobComplete' => false,
                'jobReference' => [
                    'jobId' => 'job'
                ]
            ]);
        $this->connection->getQueryResults(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($this->result);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('queryResults');

        $this->assertInstanceOf(QueryResults::class, $res->returnVal());
        $this->assertEquals('abcd', $res->output());
    }

    public function testStartQuery()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'startQuery');
        $snippet->addLocal('bigQuery', $this->client);
        $this->connection->insertJob(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'jobComplete' => false,
                'jobReference' => [
                    'jobId' => 'job'
                ]
            ]);
        $this->connection->getQueryResults(Argument::any())
            ->shouldBeCalledTimes(2)
            ->willReturn(
                [
                    'jobComplete' => false,
                    'jobReference' => [
                        'jobId' => 'job'
                    ]
                ],
                $this->result
            );
        $this->client->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('queryResults');

        $this->assertInstanceOf(QueryResults::class, $res->returnVal());
        $this->assertEquals('abcd', $res->output());
    }

    public function testJob()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'job');
        $snippet->addLocal('bigQuery', $this->client);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('job');

        $this->assertInstanceOf(Job::class, $res->returnVal());
    }

    public function testJobs()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'jobs');
        $snippet->addLocal('bigQuery', $this->client);
        $this->connection->listJobs(Argument::withEntry('stateFilter', 'done'))
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'jobs' => [
                    [
                        'jobReference' => [
                            'jobId' => 'job'
                        ]
                    ]
                ]
            ]);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('jobs');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals('job', trim($res->output()));
    }

    public function testDataset()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'dataset');
        $snippet->addLocal('bigQuery', $this->client);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $dataset = $snippet->invoke('dataset')->returnVal();

        $this->assertInstanceOf(Dataset::class, $dataset);
        $this->assertEquals(self::PROJECT_ID, $dataset->identity()['projectId']);
    }

    public function testDatasetWithProjectId()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'dataset', 1);
        $snippet->addLocal('bigQuery', $this->client);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $dataset = $snippet->invoke('dataset')->returnVal();

        $this->assertInstanceOf(Dataset::class, $dataset);
        $this->assertEquals('samples', $dataset->id());
        $this->assertEquals('bigquery-public-data', $dataset->identity()['projectId']);
    }

    public function testDatasets()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'datasets');
        $snippet->addLocal('bigQuery', $this->client);
        $this->connection->listDatasets(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'datasets' => [
                    [
                        'datasetReference' => [
                            'datasetId' => 'dataset'
                        ]
                    ]
                ]
            ]);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('datasets');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals('dataset', trim($res->output()));
    }

    public function testCreateDataset()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'createDataset');
        $snippet->addLocal('bigQuery', $this->client);
        $this->connection->insertDataset(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([]);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('dataset');

        $this->assertInstanceOf(Dataset::class, $res->returnVal());
    }

    public function testRunJob()
    {
        $jobConfig = $this->prophesize(JobConfigurationInterface::class);
        $jobConfig->toArray()
            ->willReturn([
                'projectId' => self::PROJECT_ID,
                'jobReference' => [
                    'jobId' => self::JOB_ID,
                    'projectId' => self::PROJECT_ID
                ]
            ]);
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'runJob');
        $snippet->addLocal('bigQuery', $this->client);
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
        $this->client->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('job');

        $this->assertInstanceOf(Job::class, $res->returnVal());
        $this->assertEquals('1', $res->output());
    }

    public function testStartJob()
    {
        $jobConfig = $this->prophesize(JobConfigurationInterface::class);
        $jobConfig->toArray()
            ->willReturn([
                'projectId' => self::PROJECT_ID,
                'jobReference' => [
                    'jobId' => self::JOB_ID,
                    'projectId' => self::PROJECT_ID
                ]
            ]);
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'startJob');
        $snippet->addLocal('bigQuery', $this->client);
        $snippet->addLocal('jobConfig', $jobConfig->reveal());
        $this->connection->insertJob(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'jobReference' => [
                    'jobId' => self::JOB_ID
                ]
            ]);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('job');

        $this->assertInstanceOf(Job::class, $res->returnVal());
    }

    public function testBytes()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'bytes');
        $snippet->addLocal('bigQuery', $this->client);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('bytes');

        $this->assertInstanceOf(Bytes::class, $res->returnVal());
    }

    public function testDate()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'date');
        $snippet->addLocal('bigQuery', $this->client);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('date');

        $this->assertInstanceOf(Date::class, $res->returnVal());
    }

    public function testInt64()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'int64');
        $snippet->addLocal('bigQuery', $this->client);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('int64');

        $this->assertInstanceOf(Int64::class, $res->returnVal());
    }

    public function testNumeric()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'numeric');
        $snippet->addLocal('bigQuery', $this->client);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('numeric');

        $this->assertInstanceOf(Numeric::class, $res->returnVal());
    }

    public function testTime()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'time');
        $snippet->addLocal('bigQuery', $this->client);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('time');

        $this->assertInstanceOf(Time::class, $res->returnVal());
    }

    public function testTimestamp()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'timestamp');
        $snippet->addLocal('bigQuery', $this->client);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('timestamp');

        $this->assertInstanceOf(Timestamp::class, $res->returnVal());
    }

    public function testGeography()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'geography');
        $snippet->addLocal('bigQuery', $this->client);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('geography');

        $this->assertInstanceOf(Geography::class, $res->returnVal());
    }

    public function testGetServiceAccount()
    {
        $expectedEmail = uniqid() . '@bigquery-encryption.iam.gserviceaccount.com';
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'getServiceAccount');
        $snippet->addLocal('bigQuery', $this->client);
        $this->connection->getServiceAccount(['projectId' => self::PROJECT_ID])
            ->willReturn([
                "kind" => "bigquery#getServiceAccountResponse",
                "email" => $expectedEmail
            ])
            ->shouldBeCalledTimes(1);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('serviceAccount');

        $this->assertEquals($expectedEmail, $res->returnVal());
    }

    public function testCopy()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'copy');
        $snippet->addLocal('bigQuery', $this->client);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $snippet->addLocal('myTable', $this->client->dataset('myDataset')->table('myTable'));
        $snippet->addLocal('otherTable', $this->client->dataset('otherDataset', 'otherProject')->table('otherTable'));
        $config = $snippet->invoke('copyJobConfig')->returnVal();
        $this->assertInstanceOf(CopyJobConfiguration::class, $config);
        $this->assertEquals(
            [
                'sourceTable' => [
                    'projectId' => 'otherProject',
                    'datasetId' => 'otherDataset',
                    'tableId' => 'otherTable',
                ],
                'destinationTable' => [
                    'projectId' => self::PROJECT_ID,
                    'datasetId' => 'myDataset',
                    'tableId' => 'myTable',
                ],
            ],
            $config->toArray()['configuration']['copy']
        );
    }

    public function testExtract()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'extract');
        $snippet->addLocal('bigQuery', $this->client);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $snippet->addLocal('table', $this->client->dataset('myDataset')->table('myTable'));
        $config = $snippet->invoke('extractJobConfig')->returnVal();
        $this->assertInstanceOf(ExtractJobConfiguration::class, $config);
        $this->assertEquals(
            [
                'destinationUris' => ['gs://my-bucket/table.csv'],
                'sourceTable' => [
                    'projectId' => self::PROJECT_ID,
                    'datasetId' => 'myDataset',
                    'tableId' => 'myTable',
                ]
            ],
            $config->toArray()['configuration']['extract']
        );
    }

    public function testLoad()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'load');
        $snippet->addLocal('bigQuery', $this->client);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $snippet->addLocal('table', $this->client->dataset('myDataset')->table('myTable'));
        $config = $snippet->invoke('loadJobConfig')->returnVal();
        $this->assertInstanceOf(LoadJobConfiguration::class, $config);
        $this->assertEquals(
            [
                'sourceUris' => ['gs://my-bucket/table.csv'],
                'destinationTable' => [
                    'projectId' => self::PROJECT_ID,
                    'datasetId' => 'myDataset',
                    'tableId' => 'myTable',
                ]
            ],
            $config->toArray()['configuration']['load']
        );
    }
}

//@codingStandardsIgnoreStart
class BigQueryTestClient extends BigQueryClient
{
    public function query($query, array $options = [])
    {
        return (new QueryJobConfigurationStub(
            new ValueMapper(false),
            BigQueryClientTest::PROJECT_ID,
            $options,
            null
        ))->query($query);
    }
}

class QueryJobConfigurationStub extends QueryJobConfiguration
{
    protected function generateJobId()
    {
        return BigQueryClientTest::JOB_ID;
    }
}
//@codingStandardsIgnoreEnd
