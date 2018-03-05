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

use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\BigQuery\Bytes;
use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\BigQuery\Dataset;
use Google\Cloud\BigQuery\Date;
use Google\Cloud\BigQuery\Job;
use Google\Cloud\BigQuery\QueryJobConfiguration;
use Google\Cloud\BigQuery\QueryResults;
use Google\Cloud\BigQuery\Time;
use Google\Cloud\BigQuery\Timestamp;
use Google\Cloud\Core\Iterator\ItemIterator;
use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

/**
 * @group bigquery
 */
class BigQueryClientTest extends TestCase
{
    const JOB_ID = 'myJobId';
    const PROJECT_ID = 'myProjectId';
    const DATASET_ID = 'myDatasetId';
    const QUERY_STRING = 'someQuery';

    public $connection;
    public $client;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = \Google\Cloud\Core\Testing\TestHelpers::stub(BigQueryClient::class, ['options' => ['projectId' => self::PROJECT_ID]]);
    }

    public function testQueryConfig()
    {
        $query = $this->client->queryConfig(self::QUERY_STRING);

        $this->assertInstanceOf(QueryJobConfiguration::class, $query);
    }

    public function testRunsQuery()
    {
        $query = $this->client->query(self::QUERY_STRING, [
            'jobReference' => ['jobId' => self::JOB_ID]
        ]);
        $this->connection->insertJob([
            'projectId' => self::PROJECT_ID,
            'configuration' => [
                'query' => [
                    'query' => self::QUERY_STRING,
                    'useLegacySql' => false
                ]
            ],
            'jobReference' => [
                'projectId' => self::PROJECT_ID,
                'jobId' => self::JOB_ID
            ]
        ])
            ->willReturn([
                'jobReference' => ['jobId' => self::JOB_ID]
            ])
            ->shouldBeCalledTimes(1);
        $this->connection->getQueryResults(Argument::any())
            ->willReturn([
                'jobReference' => [
                    'jobId' => self::JOB_ID
                ],
                'jobComplete' => true
            ])
            ->shouldBeCalledTimes(1);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $queryResults = $this->client->runQuery($query);

        $this->assertInstanceOf(QueryResults::class, $queryResults);
        $this->assertEquals(self::JOB_ID, $queryResults->identity()['jobId']);
    }

    public function testRunsQueryWithRetry()
    {
        $query = $this->client->query(self::QUERY_STRING, [
            'jobReference' => ['jobId' => self::JOB_ID]
        ]);
        $this->connection->insertJob([
            'projectId' => self::PROJECT_ID,
            'configuration' => [
                'query' => [
                    'query' => self::QUERY_STRING,
                    'useLegacySql' => false
                ]
            ],
            'jobReference' => [
                'projectId' => self::PROJECT_ID,
                'jobId' => self::JOB_ID
            ]
        ])
            ->willReturn([
                'jobReference' => [
                    'jobId' => self::JOB_ID
                ],
                'jobComplete' => false
            ])
            ->shouldBeCalledTimes(1);
        $this->connection->getQueryResults(Argument::any())
            ->willReturn([
                'jobReference' => [
                    'jobId' => self::JOB_ID
                ],
                'jobComplete' => true
            ])
            ->shouldBeCalledTimes(1);

        $this->client->___setProperty('connection', $this->connection->reveal());
        $queryResults = $this->client->runQuery($query);

        $this->assertInstanceOf(QueryResults::class, $queryResults);
        $this->assertEquals(self::JOB_ID, $queryResults->identity()['jobId']);
    }

    public function testStartQuery()
    {
        $query = $this->client->query(self::QUERY_STRING, [
            'jobReference' => ['jobId' => self::JOB_ID]
        ]);
        $this->connection->insertJob([
            'projectId' => self::PROJECT_ID,
            'configuration' => [
                'query' => [
                    'query' => self::QUERY_STRING,
                    'useLegacySql' => false
                ]
            ],
            'jobReference' => [
                'projectId' => self::PROJECT_ID,
                'jobId' => self::JOB_ID
            ]
        ])
            ->willReturn([
                'jobReference' => ['jobId' => self::JOB_ID]
            ])
            ->shouldBeCalledTimes(1);

        $this->client->___setProperty('connection', $this->connection->reveal());
        $job = $this->client->startQuery($query);

        $this->assertInstanceOf(Job::class, $job);
        $this->assertEquals(self::JOB_ID, $job->id());
    }

    public function testGetsJob()
    {
        $this->client->___setProperty('connection', $this->connection->reveal());
        $this->assertInstanceOf(Job::class, $this->client->job(self::JOB_ID));
    }

    public function testGetsJobsWithNoResults()
    {
        $this->connection->listJobs(['projectId' => self::PROJECT_ID])
            ->willReturn([])
            ->shouldBeCalledTimes(1);

        $this->client->___setProperty('connection', $this->connection->reveal());
        $jobs = iterator_to_array($this->client->jobs());

        $this->assertEmpty($jobs);
    }

    public function testGetsJobsWithoutToken()
    {
        $this->connection->listJobs(['projectId' => self::PROJECT_ID])
            ->willReturn([
                'jobs' => [
                    ['jobReference' => ['jobId' => self::JOB_ID]]
                ]
            ])
            ->shouldBeCalledTimes(1);

        $this->client->___setProperty('connection', $this->connection->reveal());
        $jobs = iterator_to_array($this->client->jobs());

        $this->assertEquals(self::JOB_ID, $jobs[0]->id());
    }

    public function testGetsJobsWithToken()
    {
        $token = 'token';
        $this->connection->listJobs(['projectId' => self::PROJECT_ID])
            ->willReturn([
                'nextPageToken' => $token,
                'jobs' => [
                    ['jobReference' => ['jobId' => 'someOtherJobId']]
                ]
            ])->shouldBeCalledTimes(1);
        $this->connection->listJobs([
            'projectId' => self::PROJECT_ID,
            'pageToken' => $token
        ])
            ->willReturn([
                'jobs' => [
                    ['jobReference' => ['jobId' => self::JOB_ID]]
                ]
            ])->shouldBeCalledTimes(1);

        $this->client->___setProperty('connection', $this->connection->reveal());
        $job = iterator_to_array($this->client->jobs());

        $this->assertEquals(self::JOB_ID, $job[1]->id());
    }

    public function testGetsDataset()
    {
        $this->client->___setProperty('connection', $this->connection->reveal());
        $this->assertInstanceOf(Dataset::class, $this->client->dataset(self::DATASET_ID));
    }

    public function testGetsDatasetsWithNoResults()
    {
        $this->connection->listDatasets(Argument::any())
            ->willReturn([])
            ->shouldBeCalledTimes(1);

        $this->client->___setProperty('connection', $this->connection->reveal());
        $datasets = iterator_to_array($this->client->datasets());

        $this->assertEmpty($datasets);
    }

    public function testGetsDatasetsWithoutToken()
    {
        $this->connection->listDatasets(Argument::any())
            ->willReturn([
                'datasets' => [
                    ['datasetReference' => ['datasetId' => self::DATASET_ID]]
                ]
            ])
            ->shouldBeCalledTimes(1);

        $this->client->___setProperty('connection', $this->connection->reveal());
        $datasets = iterator_to_array($this->client->datasets());

        $this->assertEquals(self::DATASET_ID, $datasets[0]->id());
    }

    public function testGetsDatasetsWithToken()
    {
        $this->connection->listDatasets(Argument::any())
            ->willReturn(
                [
                    'nextPageToken' => 'token',
                    'datasets' => [
                        ['datasetReference' => ['datasetId' => 'someOtherdatasetId']]
                    ]
                ],
                    [
                    'datasets' => [
                        ['datasetReference' => ['datasetId' => self::DATASET_ID]]
                    ]
                ]
            )
            ->shouldBeCalledTimes(2);

        $this->client->___setProperty('connection', $this->connection->reveal());
        $dataset = iterator_to_array($this->client->datasets());

        $this->assertEquals(self::DATASET_ID, $dataset[1]->id());
    }

    public function testCreatesDataset()
    {
        $this->connection->insertDataset(Argument::any())
            ->willReturn([
                'datasetReference' => [
                    'datasetId' => self::DATASET_ID
                ]
            ])
            ->shouldBeCalledTimes(1);
        $this->client->___setProperty('connection', $this->connection->reveal());

        $dataset = $this->client->createDataset(self::DATASET_ID, [
            'metadata' => [
                'friendlyName' => 'A dataset.'
            ]
        ]);

        $this->assertInstanceOf(Dataset::class, $dataset);
    }

    public function testGetsBytes()
    {
        $bytes = $this->client->bytes('1234');

        $this->assertInstanceOf(Bytes::class, $bytes);
    }

    public function testGetsDate()
    {
        $bytes = $this->client->date(new \DateTime());

        $this->assertInstanceOf(Date::class, $bytes);
    }

    public function testGetsTime()
    {
        $bytes = $this->client->time(new \DateTime());

        $this->assertInstanceOf(Time::class, $bytes);
    }

    public function testGetsTimestamp()
    {
        $bytes = $this->client->timestamp(new \DateTime());

        $this->assertInstanceOf(Timestamp::class, $bytes);
    }
}
