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

namespace Google\Cloud\Tests\System\BigQuery;

use Google\Cloud\BigQuery\Job;

/**
 * @group bigquery
 */
class ManageJobsTest extends BigQueryTestCase
{
    public function testListJobs()
    {
        self::$client->runQueryAsJob(
            sprintf(
                'SELECT * FROM [%s.%s]',
                self::$dataset->id(),
                self::$table->id()
            )
        );
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
        $job = self::$client->runQueryAsJob(
            sprintf(
                'SELECT * FROM [%s.%s]',
                self::$dataset->id(),
                self::$table->id()
            )
        );
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
}
