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
use Google\Cloud\BigQuery\QueryResults;
use Prophecy\Argument;

class JobTest extends \PHPUnit_Framework_TestCase
{
    public $connection;
    public $projectId = 'myProjectId';
    public $jobId = 'myJobId';
    public $jobInfo = ['status' => ['state' => 'DONE']];

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function getJob($connection, array $data = [])
    {
        return new Job($connection->reveal(), $this->jobId, $this->projectId, $data);
    }

    public function testDoesExistTrue()
    {
        $this->connection->getJob(Argument::any())
            ->willReturn([
                'jobReference' => ['jobId' => $this->jobId]
            ])
            ->shouldBeCalledTimes(1);
        $job = $this->getJob($this->connection);

        $this->assertTrue($job->exists());
    }

    public function testDoesExistFalse()
    {
        $this->connection->getJob(Argument::any())->willThrow(new \Exception(null, 404))
            ->shouldBeCalledTimes(1);
        $job = $this->getJob($this->connection);

        $this->assertFalse($job->exists());
    }

    public function testCancel()
    {
        $this->connection->cancelJob(Argument::any())
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $job = $this->getJob($this->connection);
        $this->assertNull($job->cancel());
    }

    public function testGetsQueryResults()
    {
        $this->connection->getQueryResults(Argument::any())
            ->willReturn(['jobReference' => ['jobId' => $this->jobId]])
            ->shouldBeCalledTimes(1);
        $job = $this->getJob($this->connection);

        $this->assertInstanceOf(QueryResults::class, $job->getQueryResults());
    }

    public function testIsCompleteTrue()
    {
        $job = $this->getJob($this->connection, $this->jobInfo);

        $this->assertTrue($job->isComplete());
    }

    public function testIsCompleteFalse()
    {
        $this->jobInfo['status']['state'] = 'RUNNING';
        $job = $this->getJob($this->connection, $this->jobInfo);

        $this->assertFalse($job->isComplete());
    }

    public function testGetsInfo()
    {
        $this->connection->getJob(Argument::any())->shouldNotBeCalled();
        $job = $this->getJob($this->connection, $this->jobInfo);

        $this->assertEquals($this->jobInfo, $job->getInfo());
    }

    public function testGetsInfoWithRealod()
    {
        $this->connection->getJob(Argument::any())
            ->willReturn($this->jobInfo)
            ->shouldBeCalledTimes(1);
        $job = $this->getJob($this->connection);

        $this->assertEquals($this->jobInfo, $job->getInfo());
    }

    public function testGetsId()
    {
        $job = $this->getJob($this->connection);

        $this->assertEquals($this->jobId, $job->getId());
    }

    public function testGetsIdentity()
    {
        $job = $this->getJob($this->connection);

        $this->assertEquals($this->jobId, $job->getIdentity()['jobId']);
        $this->assertEquals($this->projectId, $job->getIdentity()['projectId']);
    }
}
