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
use Google\Cloud\BigQuery\Job;
use Google\Cloud\BigQuery\QueryResults;
use Google\Cloud\BigQuery\ValueMapper;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group bigquery
 */
class QueryResultsTest extends SnippetTestCase
{
    use ProphecyTrait;

    const JOB_ID = 1;
    const PROJECT = 'my-awesome-project';

    private $info;
    private $reload;
    private $connection;
    private $qr;

    public function setUp(): void
    {
        $this->info = [
            'totalBytesProcessed' => 3,
            'jobComplete' => false,
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
                        'name' => 'name',
                        'type' => 'STRING'
                    ]
                ]
            ]
        ];

        $job = $this->prophesize(Job::class);
        $job->identity()
            ->willReturn([
                'jobId' => 'job',
                'projectId' => 'project',
                'location' => 'us-west1'
            ]);
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->qr = TestHelpers::stub(QueryResults::class, [
            $this->connection->reveal(),
            self::JOB_ID,
            self::PROJECT,
            $this->info,
            new ValueMapper(false),
            $job->reveal()
        ]);
    }

    public function testRows()
    {
        $snippet = $this->snippetFromMethod(QueryResults::class, 'rows');
        $snippet->addLocal('queryResults', $this->qr);

        $this->info['jobComplete'] = true;
        $this->connection->getQueryResults(Argument::any())
            ->willReturn($this->info);

        $this->qr->___setProperty('connection', $this->connection->reveal());

        $this->qr->reload();

        $res = $snippet->invoke();
        $this->assertEquals('abcd', trim($res->output()));
    }

    public function testWaitUntilComplete()
    {
        $snippet = $this->snippetFromMethod(QueryResults::class, 'waitUntilComplete');
        $snippet->addLocal('queryResults', $this->qr);

        $this->info['jobComplete'] = true;
        $this->connection->getQueryResults(Argument::any())
            ->willReturn($this->info);

        $this->qr->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testIsComplete()
    {
        $snippet = $this->snippetFromMethod(QueryResults::class, 'isComplete');
        $snippet->addLocal('queryResults', $this->qr);

        $this->info['jobComplete'] = true;
        $this->connection->getQueryResults(Argument::any())
            ->willReturn($this->info);

        $this->qr->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Query complete!', $res->output());
    }

    public function testIdentity()
    {
        $snippet = $this->snippetFromMethod(QueryResults::class, 'identity');
        $snippet->addLocal('queryResults', $this->qr);

        $res = $snippet->invoke();
        $this->assertEquals(self::PROJECT, $res->output());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(QueryResults::class, 'info');
        $snippet->addLocal('queryResults', $this->qr);

        $res = $snippet->invoke();
        $this->assertEquals($this->info['totalBytesProcessed'], $res->output());
    }

    public function testJob()
    {
        $snippet = $this->snippetFromMethod(QueryResults::class, 'job');
        $snippet->addLocal('queryResults', $this->qr);

        $res = $snippet->invoke('job');
        $this->assertInstanceOf(Job::class, $res->returnVal());
    }

    public function testReload()
    {
        $this->connection->getQueryResults(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['jobComplete' => true] + $this->info);

        $this->qr->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(QueryResults::class, 'reload');
        $snippet->addLocal('queryResults', $this->qr);

        $res = $snippet->invoke();
    }
}
