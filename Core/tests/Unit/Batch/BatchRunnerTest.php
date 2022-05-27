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
use Google\Cloud\Core\Batch\BatchRunner;
use Google\Cloud\Core\Batch\ConfigStorageInterface;
use Google\Cloud\Core\Batch\ProcessItemInterface;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group core
 * @group batch
 */
class BatchRunnerTest extends TestCase
{
    use ExpectException;

    private $configStorage;
    private $processor;

    public function set_up()
    {
        $this->configStorage = $this->prophesize(ConfigStorageInterface::class);
        $this->processor = $this->prophesize(ProcessItemInterface::class);
        $this->batchConfig = $this->prophesize(JobConfig::class);
    }

    public function testRegisterJobClosure()
    {
        $this->expectException('\InvalidArgumentException');

        $runner = new BatchRunner(
            $this->configStorage->reveal(),
            $this->processor->reveal()
        );
        $result = $runner->registerJob(
            'test',
            function () {
                return;
            }
        );
        $this->assertTrue(false, 'It should throw InvalidArgumentException');
    }

    public function testConstructorLoadConfig()
    {
        $job = new BatchJob('test', 'myFunc', 1);
        $this->batchConfig->getJobFromIdNum(1)
            ->willReturn($job)
            ->shouldBeCalledTimes(1);
        $this->batchConfig->getJobFromId('test')
            ->willReturn($job)
            ->shouldBeCalledTimes(1);
        $this->batchConfig->getJobs()
            ->willReturn(array('test' => $job))
            ->shouldBeCalledTimes(1);
        $config = $this->batchConfig->reveal();
        $this->configStorage->lock()
            ->willreturn(true)
            ->shouldBeCalledTimes(1);
        $this->configStorage->load()
            ->willreturn($config)
            ->shouldBeCalledTimes(1);
        $this->configStorage->unlock()
            ->willreturn(true)
            ->shouldBeCalledTimes(1);
        $runner = new BatchRunner(
            $this->configStorage->reveal(),
            $this->processor->reveal()
        );
        $this->assertEquals($job, $runner->getJobFromIdNum(1));
        $this->assertEquals($job, $runner->getJobFromId('test'));
        $this->assertEquals(array('test' => $job), $runner->getJobs());
    }

    public function testRegisterJob()
    {
        $this->batchConfig->registerJob('test', Argument::type(\Closure::class))
            ->shouldBeCalledTimes(1);
        $config = $this->batchConfig->reveal();
        $this->configStorage->lock()
            ->willreturn(true)
            ->shouldBeCalledTimes(2);
        $this->configStorage->load()
            ->willreturn($config)
            ->shouldBeCalledTimes(2);
        $this->configStorage->save(Argument::type(JobConfig::class))
            ->willreturn(true)
            ->shouldBeCalledTimes(1);
        $this->configStorage->unlock()
            ->willreturn(true)
            ->shouldBeCalledTimes(2);
        $runner = new BatchRunner(
            $this->configStorage->reveal(),
            $this->processor->reveal()
        );
        $result = $runner->registerJob('test', 'myFunc');
        $this->assertTrue($result);
    }

    public function testSubmitItem()
    {
        $job = new BatchJob('test', 'myFunc', 1);
        $this->batchConfig->getJobFromId('test')
            ->willReturn($job)
            ->shouldBeCalledTimes(1);
        $config = $this->batchConfig->reveal();
        $this->configStorage->lock()
            ->willreturn(true)
            ->shouldBeCalledTimes(1);
        $this->configStorage->load()
            ->willreturn($config)
            ->shouldBeCalledTimes(1);
        $this->configStorage->unlock()
            ->willreturn(true)
            ->shouldBeCalledTimes(1);
        $this->processor->submit('item', 1)
            ->shouldBeCalledTimes(1);
        $runner = new BatchRunner(
            $this->configStorage->reveal(),
            $this->processor->reveal()
        );
        $runner->submitItem('test', 'item');
    }
}
