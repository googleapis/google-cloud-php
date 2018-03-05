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
use Prophecy\Argument;

/**
 * @group bigquery
 */
class JobTest extends SnippetTestCase
{
    private $identity;
    private $connection;

    public function setUp()
    {
        $this->identity = ['jobId' => 'id', 'projectId' => 'projectId'];
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function getJob($connection, array $info = [])
    {
        $mapper = $this->prophesize(ValueMapper::class);

        return new Job(
            $connection->reveal(),
            $this->identity['jobId'],
            $this->identity['projectId'],
            $mapper->reveal(),
            $info
        );
    }

    public function testExists()
    {
        $this->connection->getJob(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([]);
        $job = $this->getJob($this->connection);
        $snippet = $this->snippetFromMethod(Job::class, 'exists');
        $snippet->addLocal('job', $job);
        $res = $snippet->invoke('job');

        $this->assertEquals(true, $res->output());
    }

    public function testCancel()
    {
        $this->connection->cancelJob(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([]);
        $this->connection->getJob(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'status' => [
                    'state' => 'DONE'
                ]
            ]);
        $job = $this->getJob($this->connection, [
            'status' => [
                'state' => 'PENDING'
            ]
        ]);
        $snippet = $this->snippetFromMethod(Job::class, 'cancel');
        $snippet->addLocal('job', $job);
        $snippet->invoke();
    }

    public function testQueryResults()
    {
        $this->connection->getQueryResults(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn(['jobComplete' => true]);
        $job = $this->getJob($this->connection);
        $snippet = $this->snippetFromMethod(Job::class, 'queryResults');
        $snippet->addLocal('job', $job);
        $res = $snippet->invoke('queryResults');

        $this->assertInstanceOf(QueryResults::class, $res->returnVal());
    }

    public function testWaitUntilComplete()
    {
        $job = $this->getJob($this->connection, [
            'status' => [
                'state' => 'DONE'
            ]
        ]);
        $snippet = $this->snippetFromMethod(Job::class, 'waitUntilComplete');
        $snippet->addLocal('job', $job);
        $snippet->invoke();
    }

    public function testIsComplete()
    {
        $this->connection->getJob(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'status' => [
                    'state' => 'DONE'
                ]
            ]);
        $job = $this->getJob($this->connection, [
            'status' => [
                'state' => 'PENDING'
            ]
        ]);
        $snippet = $this->snippetFromMethod(Job::class, 'isComplete');
        $snippet->addLocal('job', $job);
        $snippet->invoke();
    }

    public function testInfo()
    {
        $startTime = '100';
        $job = $this->getJob($this->connection, [
            'statistics' => [
                'startTime' => $startTime
            ]
        ]);
        $snippet = $this->snippetFromMethod(Job::class, 'info');
        $snippet->addLocal('job', $job);
        $res = $snippet->invoke();

        $this->assertEquals($startTime, $res->output());
    }

    public function testReload()
    {
        $this->connection->getJob(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'status' => [
                    'state' => 'DONE'
                ]
            ]);
        $job = $this->getJob($this->connection, [
            'status' => [
                'state' => 'PENDING'
            ]
        ]);
        $snippet = $this->snippetFromMethod(Job::class, 'reload');
        $snippet->addLocal('job', $job);
        $snippet->invoke();
    }

    public function testId()
    {
        $snippet = $this->snippetFromMethod(Job::class, 'id');
        $snippet->addLocal('job', $this->getJob($this->connection, []));
        $res = $snippet->invoke();

        $this->assertEquals($res->output(), $this->identity['jobId']);
    }

    public function testIdentity()
    {
        $snippet = $this->snippetFromMethod(Job::class, 'identity');
        $snippet->addLocal('job', $this->getJob($this->connection, []));
        $res = $snippet->invoke();

        $this->assertEquals($res->output(), $this->identity['projectId']);
    }
}
