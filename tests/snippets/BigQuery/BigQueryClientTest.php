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
use Google\Cloud\BigQuery\Bytes;
use Google\Cloud\BigQuery\Date;
use Google\Cloud\BigQuery\Time;
use Google\Cloud\BigQuery\Timestamp;
use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\BigQuery\Dataset;
use Google\Cloud\BigQuery\Job;
use Google\Cloud\BigQuery\QueryResults;
use Google\Cloud\Core\Int64;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Prophecy\Argument;

/**
 * @group bigquery
 */
class BigQueryClientTest extends SnippetTestCase
{
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
        $this->client = \Google\Cloud\Dev\stub(BigQueryClient::class);
        $this->client->___setProperty('connection', $this->connection->reveal());
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(BigQueryClient::class);
        $res = $snippet->invoke('bigQuery');

        $this->assertInstanceOf(BigQueryClient::class, $res->returnVal());
    }

    public function testRunQuery()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'runQuery');
        $snippet->addLocal('bigQuery', $this->client);
        $snippet->replace('sleep(1);', '');
        $this->connection->query(Argument::any())
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
        $snippet->replace('sleep(1);', '');
        $this->connection
            ->query(Argument::withEntry('queryParameters', [
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
            ]))
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
        $snippet->replace('sleep(1);', '');
        $this->connection
            ->query(Argument::withEntry('queryParameters', [
                [
                    'parameterType' => [
                        'type' => 'STRING'
                    ],
                    'parameterValue' => [
                        'value' => 'A commit message.'
                    ]
                ]
            ]))
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

    public function testRunQueryAsJob()
    {
        $snippet = $this->snippetFromMethod(BigQueryClient::class, 'runQueryAsJob');
        $snippet->addLocal('bigQuery', $this->client);
        $snippet->replace('sleep(1);', '');
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
        $res = $snippet->invoke('dataset');

        $this->assertInstanceOf(Dataset::class, $res->returnVal());
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
}
