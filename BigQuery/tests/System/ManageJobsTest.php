<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\BigQuery\Tests\System;

use Google\Cloud\BigQuery\Job;

/**
 * @group bigquery
 * @group bigquery-job
 */
class ManageJobsTest extends BigQueryTestCase
{
    public function testListJobs()
    {
        $query = self::$client->query(sprintf(
            'SELECT * FROM [%s.%s]',
            self::$dataset->id(),
            self::$table->id()
        ));
        self::$client->startQuery($query);
        $jobs = self::$client->jobs();
        $job = null;

        // break early to prevent subsequent requests
        foreach ($jobs as $j) {
            $job = $j;
            break;
        }

        $this->assertInstanceOf(Job::class, $job);

        return $job;
    }

    public function testListJobsWithTimeFilter()
    {
        $query = self::$client->query(sprintf(
            'SELECT * FROM [%s.%s]',
            self::$dataset->id(),
            self::$table->id()
        ));
        $job = self::$client->startQuery($query);
        $info = $job->info();
        $jobId = $job->id();
        $creationTime = $info['statistics']['creationTime'];
        $jobs = self::$client->jobs([
            'maxCreationTime' => $creationTime + 1,
            'minCreationTime' => $creationTime - 1,
        ]);
        $job = null;

        // break early to prevent subsequent requests
        foreach ($jobs as $j) {
            $job = $j;
            break;
        }

        $this->assertInstanceOf(Job::class, $job);
        $this->assertEquals($jobId, $job->id());
    }

    /**
     * @depends testListJobs
     */
    public function testJobExists($job)
    {
        $this->assertTrue($job->exists());
        $this->assertFalse(self::$client->job('not_a_job')->exists());
    }

    public function testCancelsJob()
    {
        $query = self::$client->query(sprintf(
            'SELECT * FROM [%s.%s]',
            self::$dataset->id(),
            self::$table->id()
        ));
        $job = self::$client->startQuery($query);
        $job->cancel();
    }

    /**
     * @depends testListJobs
     */
    public function testGetsJobInfo($job)
    {
        $this->assertEquals('bigquery#job', $job->info()['kind']);
    }

    /**
     * @depends testListJobs
     */
    public function testReloadsJob($job)
    {
        $this->assertEquals('bigquery#job', $job->reload()['kind']);
    }

    public function testListsJobsWithParent()
    {
        $query = self::$client->query('SELECT "a";SELECT "b";');
        $job = self::$client->startQuery($query);
        $jobId = $job->id();

        $job->waitUntilComplete();

        $children = iterator_to_array(self::$client->jobs([
            'parentJobId' => $jobId
        ]));

        $this->assertEquals(2, count($children));
        $this->assertStringStartsWith('script_job_', $children[0]->id());
        $this->assertStringStartsWith('script_job_', $children[1]->id());
        $this->assertNotEquals($children[0]->id(), $children[1]->id());
    }
}
