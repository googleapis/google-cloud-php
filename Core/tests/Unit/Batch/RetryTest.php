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

use Google\Cloud\Core\Batch\BatchJob;
use Google\Cloud\Core\Batch\BatchRunner;
use Google\Cloud\Core\Batch\Retry;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group core
 * @group batch
 */
class RetryTest extends TestCase
{
    private $runner;
    private $job;
    private $retry;
    private static $testDir;

    public static function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            $target = "$dir/$file";
            (is_dir($target)) ? self::delTree($target) : unlink($target);
        }
        return rmdir($dir);
    }

    public static function set_up_before_class()
    {
        self::$testDir = sprintf(
            '%s/google-cloud-unit-test-%d',
            sys_get_temp_dir(),
            getmypid()
        );
        putenv('GOOGLE_CLOUD_BATCH_DAEMON_FAILURE_DIR=' . self::$testDir);
    }

    public static function tear_down_after_class()
    {
        self::delTree(self::$testDir);
        putenv('GOOGLE_CLOUD_BATCH_DAEMON_FAILURE_DIR');
    }

    public function set_up()
    {
        $this->runner = $this->prophesize(BatchRunner::class);
        $this->job = $this->prophesize(BatchJob::class);
    }

    public function testRetryAll()
    {
        $this->job->callFunc(array('apple', 'orange'))
            ->willReturn(true)
            ->shouldBeCalledTimes(1);
        $this->runner->getJobFromIdNum(1)
            ->willReturn($this->job->reveal())
            ->shouldBeCalledTimes(1);
        $this->retry = new Retry($this->runner->reveal());
        $this->retry->handleFailure(1, array('apple', 'orange'));
        $this->assertCount(1, glob(self::$testDir . '/failed-items*'));
        $this->retry->retryAll();
        $this->assertCount(0, glob(self::$testDir . '/failed-items*'));
    }

    public function testRetryAllWithSingleFailure()
    {
        $this->job->callFunc(array('apple', 'orange'))
            ->willReturn(false, true)
            ->shouldBeCalledTimes(2);
        $this->runner->getJobFromIdNum(1)
            ->willReturn($this->job->reveal())
            ->shouldBeCalledTimes(2);
        $this->retry = new Retry($this->runner->reveal());
        $this->retry->handleFailure(1, array('apple', 'orange'));
        $this->retry->retryAll();
        $this->assertCount(1, glob(self::$testDir . '/failed-items*'));
        $this->retry->retryAll();
        $this->assertCount(0, glob(self::$testDir . '/failed-items*'));
    }
}
