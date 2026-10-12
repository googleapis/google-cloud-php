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
use Google\Cloud\BigQuery\Job;
use Google\Cloud\BigQuery\QueryResults;
use Google\Cloud\BigQuery\ValueMapper;
use Google\Cloud\Core\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group bigquery
 */
class JobTest extends TestCase
{
    use ProphecyTrait;

    public $connection;
    public $location = 'asia-northeast1';
    public $projectId = 'myProjectId';
    public $jobId = 'myJobId';
    public $jobInfo = ['status' => ['state' => 'DONE']];

    public function setUp(): void
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function getJob($connection, array $data = [], $location = null)
    {
        $mapper = $this->prophesize(ValueMapper::class);
        return new Job($connection->reveal(), $this->jobId, $this->projectId, $mapper->reveal(), $data, $location);
    }

    public function testDoesExistTrue()
    {
        $this->connection->getJob(Argument::allOf(
            Argument::withEntry('projectId', $this->projectId),
            Argument::withEntry('jobId', $this->jobId)
        ))
            ->willReturn([
                'jobReference' => ['jobId' => $this->jobId]
            ])
            ->shouldBeCalledTimes(1);

        $job = $this->getJob($this->connection);

        $this->assertTrue($job->exists());
    }

    public function testDoesExistFalse()
    {
        $this->connection->getJob(Argument::allOf(
            Argument::withEntry('projectId', $this->projectId),
            Argument::withEntry('jobId', $this->jobId)
        ))
            ->willThrow(new NotFoundException(null))
            ->shouldBeCalledTimes(1);

        $job = $this->getJob($this->connection);

        $this->assertFalse($job->exists());
    }

    public function testCancel()
    {
        $this->connection->cancelJob(Argument::allOf(
            Argument::withEntry('projectId', $this->projectId),
            Argument::withEntry('jobId', $this->jobId)
        ))
            ->willReturn([])
            ->shouldBeCalledTimes(1);

        $job = $this->getJob($this->connection);
        $this->assertNull($job->cancel());
    }

    public function testGetsQueryResults()
    {
        $this->connection->getQueryResults(Argument::allOf(
            Argument::withEntry('projectId', $this->projectId),
            Argument::withEntry('jobId', $this->jobId)
        ))
            ->willReturn([
                'jobReference' => [
                    'jobId' => $this->jobId
                ],
                'jobComplete' => true
            ])
            ->shouldBeCalledTimes(1);

        $job = $this->getJob($this->connection);

        $this->assertInstanceOf(QueryResults::class, $job->queryResults());
    }

    public function testWaitsUntilComplete()
    {
        $this->jobInfo['status']['state'] = 'RUNNING';
        $this->connection->getJob(Argument::allOf(
            Argument::withEntry('projectId', $this->projectId),
            Argument::withEntry('jobId', $this->jobId)
        ))
            ->willReturn([
                'status' => [
                    'state' => 'DONE'
                ]
            ])->shouldBeCalledTimes(1);

        $job = $this->getJob($this->connection, $this->jobInfo);
        $job->waitUntilComplete();
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

        $this->assertEquals($this->jobInfo, $job->info());
    }

    public function testGetsInfoWithRealod()
    {
        $this->connection->getJob(Argument::allOf(
            Argument::withEntry('projectId', $this->projectId),
            Argument::withEntry('jobId', $this->jobId)
        ))
            ->willReturn($this->jobInfo)
            ->shouldBeCalledTimes(1);

        $job = $this->getJob($this->connection);

        $this->assertEquals($this->jobInfo, $job->info());
    }

    public function testGetsId()
    {
        $job = $this->getJob($this->connection);

        $this->assertEquals($this->jobId, $job->id());
    }

    public function testGetsIdentity()
    {
        $job = $this->getJob($this->connection);

        $this->assertEquals($this->jobId, $job->identity()['jobId']);
        $this->assertEquals($this->projectId, $job->identity()['projectId']);
    }

    public function testDefaultLocationSurfaced()
    {
        $job = $this->getJob($this->connection, [], $this->location);

        $this->assertEquals($this->location, $job->identity()['location']);
    }

    public function testMetadataLocationSurfaced()
    {
        $job = $this->getJob($this->connection, [
            'jobReference' => [
                'location' => $this->location
            ]
        ]);

        $this->assertEquals($this->location, $job->identity()['location']);
    }
}
