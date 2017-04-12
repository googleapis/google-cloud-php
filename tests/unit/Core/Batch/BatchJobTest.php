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

use Google\Cloud\Core\Batch\BatchJob;

/**
 * @group core
 * @group batch
 */
class BatchJobTest extends \PHPUnit_Framework_TestCase
{
    private $items = array();

    public function testDefault()
    {
        $job = new BatchJob('testing', array($this, 'runJob'), 1);
        $this->assertEquals(100, $job->getBatchSize());
        $this->assertEquals(2.0, $job->getCallPeriod());
        $this->assertEquals(1, $job->getWorkerNum());
        $this->assertNull($job->getBootstrapFile());
        $this->assertEquals(1, $job->getIdNum());
        $this->assertEquals('testing', $job->getIdentifier());
    }

    public function testCustom()
    {
        $job = new BatchJob(
            'testing',
            array($this, 'runJob'),
            1,
            array(
                'batchSize' => 1000,
                'callPeriod' => 1.0,
                'bootstrapFile' => __FILE__,
                'workerNum' => 10
            )
        );
        $this->assertEquals(1000, $job->getBatchSize());
        $this->assertEquals(1.0, $job->getCallPeriod());
        $this->assertEquals(10, $job->getWorkerNum());
        $this->assertEquals(__FILE__, $job->getBootstrapFile());
        $this->assertEquals(1, $job->getIdNum());
        $this->assertEquals('testing', $job->getIdentifier());
    }

    public function testRun()
    {
        $job = new BatchJob('testing', array($this, 'runJob'), 1);
        $items = array('apple', 'orange', 'banana');
        $expected = array('APPLE', 'ORANGE', 'BANANA');
        $job->run($items);
        $this->assertEquals($expected, $this->items);
    }

    /**
     * A method that we use for the test.
     */
    public function runJob($items)
    {
        foreach ($items as $item) {
            $this->items[] = strtoupper($item);
        }
        return true;
    }
}
