<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Core\Tests\Unit\Batch;

use Google\Cloud\Core\Batch\JobConfig;
use Google\Cloud\Core\Batch\BatchJob;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group core
 * @group batch
 */
class JobConfigTest extends TestCase
{
    private $config;
    private $identifier;
    private $func;
    private $idNum;

    public function set_up()
    {
        $this->config = new JobConfig();
        $this->identifier = 'job1';
        $this->func = 'myFunc';
        $this->config->registerJob(
            $this->identifier,
            function ($id) {
                return new BatchJob($this->identifier, $this->func, $id);
            },
            []
        );
        // It must have 1 as the idNum.
        $this->idNum = 1;
    }

    public function testGetJobFromId()
    {
        $job = $this->config->getJobFromId($this->identifier);
        $this->assertEquals($this->idNum, $job->id());
        $this->assertEquals($this->identifier, $job->identifier());
        $this->assertNull($this->config->getJobFromId('bogus'));
    }

    public function testGetJobFromIdNum()
    {
        $job = $this->config->getJobFromIdNum($this->idNum);
        $this->assertEquals($this->idNum, $job->id());
        $this->assertEquals($this->identifier, $job->identifier());
        $this->assertNull($this->config->getJobFromIdNum(10));
    }

    public function testRegisterJob()
    {
        $identifier = 'job2';
        $this->config->registerJob(
            $identifier,
            function ($id) use ($identifier) {
                return new BatchJob($identifier, $this->func, $id);
            },
            []
        );
        // The idNum is 1 origin, incremented by 1
        $job = $this->config->getJobFromIdNum(2);
        $this->assertEquals(2, $job->id());
        $this->assertEquals($identifier, $job->identifier());
    }

    public function testGetjobs()
    {
        $identifier = 'job2';
        $this->config->registerJob(
            $identifier,
            function ($id) use ($identifier) {
                return new BatchJob($identifier, $this->func, $id);
            },
            []
        );
        $jobs = $this->config->getJobs();
        $this->assertCount(2, $jobs);
        $this->assertEquals($this->idNum, $jobs[$this->identifier]->id());
        $this->assertEquals(2, $jobs[$identifier]->id());
    }
}
