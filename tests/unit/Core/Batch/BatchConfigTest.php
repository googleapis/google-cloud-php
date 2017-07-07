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

namespace Google\Cloud\Tests\Unit\Core\Batch;

use Google\Cloud\Core\Batch\BatchConfig;

/**
 * @group core
 * @group batch
 */
class BatchConfigTest extends \PHPUnit_Framework_TestCase
{
    private $config;
    private $identifier;
    private $func;
    private $idNum;

    public function setUp()
    {
        $this->config = new BatchConfig();
        $this->identifier = 'job1';
        $this->func = 'myFunc';
        $this->config->registerJob(
            $this->identifier,
            $this->func,
            []
        );
        // It must have 1 as the idNum.
        $this->idNum = 1;
    }

    public function testGetJobFromId()
    {
        $job = $this->config->getJobFromId($this->identifier);
        $this->assertEquals($this->idNum, $job->getIdNum());
        $this->assertEquals($this->identifier, $job->getIdentifier());
        $this->assertNull($this->config->getJobFromId('bogus'));
    }

    public function testGetJobFromIdNum()
    {
        $job = $this->config->getJobFromIdNum($this->idNum);
        $this->assertEquals($this->idNum, $job->getIdNum());
        $this->assertEquals($this->identifier, $job->getIdentifier());
        $this->assertNull($this->config->getJobFromIdNum(10));
    }

    public function testRegisterJob()
    {
        $identifier = 'job2';
        $this->config->registerJob(
            $identifier,
            $this->func,
            []
        );
        // The idNum is 1 origin, incremented by 1
        $job = $this->config->getJobFromIdNum(2);
        $this->assertEquals(2, $job->getIdNum());
        $this->assertEquals($identifier, $job->getIdentifier());
    }

    public function testGetjobs()
    {
        $identifier = 'job2';
        $this->config->registerJob(
            $identifier,
            $this->func,
            []
        );
        $jobs = $this->config->getJobs();
        $this->assertEquals(count($jobs), 2);
        $this->assertEquals($this->idNum, $jobs[$this->identifier]->getIdNum());
        $this->assertEquals(2, $jobs[$identifier]->getIdNum());
    }
}
