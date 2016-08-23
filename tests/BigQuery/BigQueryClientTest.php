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

use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\BigQuery\Dataset;
use Google\Cloud\BigQuery\Job;
use Google\Cloud\BigQuery\QueryResults;
use Prophecy\Argument;

class BigQueryClientTest extends \PHPUnit_Framework_TestCase
{
    public $connection;
    public $jobId = 'myJobId';
    public $projectId = 'myProjectId';
    public $datasetId = 'myDatasetId';
    public $client;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = new BigQueryTestClient(['projectId' => $this->projectId]);
    }

    public function testRunsQuery()
    {
        $this->connection->query(Argument::any())
            ->willReturn([
                'jobReference' => [
                    'jobId' => $this->jobId
                ]
            ])
            ->shouldBeCalledTimes(1);
        $this->client->setConnection($this->connection->reveal());
        $queryResults = $this->client->runQuery('someQuery');

        $this->assertInstanceOf(QueryResults::class, $queryResults);
        $this->assertEquals($this->jobId, $queryResults->identity()['jobId']);
    }

    public function testRunsQueryAsJob()
    {
        $this->connection->insertJob(Argument::any())
            ->willReturn([
                'jobReference' => ['jobId' => $this->jobId]
            ])
            ->shouldBeCalledTimes(1);
        $this->client->setConnection($this->connection->reveal());
        $job = $this->client->runQueryAsJob('someQuery', [
            'jobConfig' => [
                'writeDisposition' => 'WRITE_TRUNCATE'
            ]
        ]);

        $this->assertInstanceOf(Job::class, $job);
        $this->assertEquals($this->jobId, $job->id());
    }

    public function testGetsJob()
    {
        $this->client->setConnection($this->connection->reveal());
        $this->assertInstanceOf(Job::class, $this->client->job($this->jobId));
    }

    public function testGetsJobsWithNoResults()
    {
        $this->connection->listJobs(Argument::any())
            ->willReturn([])
            ->shouldBeCalledTimes(1);

        $this->client->setConnection($this->connection->reveal());
        $jobs = iterator_to_array($this->client->jobs());

        $this->assertEmpty($jobs);
    }

    public function testGetsJobsWithoutToken()
    {
        $this->connection->listJobs(Argument::any())
            ->willReturn([
                'jobs' => [
                    ['jobReference' => ['jobId' => $this->jobId]]
                ]
            ])
            ->shouldBeCalledTimes(1);

        $this->client->setConnection($this->connection->reveal());
        $jobs = iterator_to_array($this->client->jobs());

        $this->assertEquals($this->jobId, $jobs[0]->id());
    }

    public function testGetsJobsWithToken()
    {
        $this->connection->listJobs(Argument::any())
            ->willReturn(
                [
                    'nextPageToken' => 'token',
                    'jobs' => [
                        ['jobReference' => ['jobId' => 'someOtherJobId']]
                    ]
                ],
                    [
                    'jobs' => [
                        ['jobReference' => ['jobId' => $this->jobId]]
                    ]
                ]
            )
            ->shouldBeCalledTimes(2);

        $this->client->setConnection($this->connection->reveal());
        $job = iterator_to_array($this->client->jobs());

        $this->assertEquals($this->jobId, $job[1]->id());
    }

    public function testGetsDataset()
    {
        $this->client->setConnection($this->connection->reveal());
        $this->assertInstanceOf(Dataset::class, $this->client->dataset($this->datasetId));
    }

    public function testGetsDatasetsWithNoResults()
    {
        $this->connection->listDatasets(Argument::any())
            ->willReturn([])
            ->shouldBeCalledTimes(1);

        $this->client->setConnection($this->connection->reveal());
        $datasets = iterator_to_array($this->client->datasets());

        $this->assertEmpty($datasets);
    }

    public function testGetsDatasetsWithoutToken()
    {
        $this->connection->listDatasets(Argument::any())
            ->willReturn([
                'datasets' => [
                    ['datasetReference' => ['datasetId' => $this->datasetId]]
                ]
            ])
            ->shouldBeCalledTimes(1);

        $this->client->setConnection($this->connection->reveal());
        $datasets = iterator_to_array($this->client->datasets());

        $this->assertEquals($this->datasetId, $datasets[0]->id());
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
                        ['datasetReference' => ['datasetId' => $this->datasetId]]
                    ]
                ]
            )
            ->shouldBeCalledTimes(2);

        $this->client->setConnection($this->connection->reveal());
        $dataset = iterator_to_array($this->client->datasets());

        $this->assertEquals($this->datasetId, $dataset[1]->id());
    }

    public function testCreatesDataset()
    {
        $this->connection->insertDataset(Argument::any())
            ->willReturn([
                'datasetReference' => [
                    'datasetId' => $this->datasetId
                ]
            ])
            ->shouldBeCalledTimes(1);
        $this->client->setConnection($this->connection->reveal());

        $dataset = $this->client->createDataset($this->datasetId, [
            'metadata' => [
                'friendlyName' => 'A dataset.'
            ]
        ]);

        $this->assertInstanceOf(Dataset::class, $dataset);
    }

    public function testGetsProjectsWithNoResults()
    {
        $this->connection->listProjects(Argument::any())
            ->willReturn([])
            ->shouldBeCalledTimes(1);

        $this->client->setConnection($this->connection->reveal());
        $projects = iterator_to_array($this->client->projects());

        $this->assertEmpty($projects);
    }

    public function testGetsProjectsWithoutToken()
    {
        $this->connection->listProjects(Argument::any())
            ->willReturn([
                'projects' => [
                    ['id' => $this->projectId]
                ]
            ])
            ->shouldBeCalledTimes(1);

        $this->client->setConnection($this->connection->reveal());
        $projects = iterator_to_array($this->client->projects());

        $this->assertEquals($this->projectId, $projects[0]['id']);
    }

}

class BigQueryTestClient extends BigQueryClient
{
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}
