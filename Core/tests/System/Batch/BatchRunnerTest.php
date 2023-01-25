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

namespace Google\Cloud\Core\Tests\System\Batch;

use Google\Cloud\Core\Batch\BatchRunner;
use Google\Cloud\Core\Batch\Retry;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains;

/**
 * @group core
 * @group batch
 *
 * If SystemV IPC extensions are available, it'll spawn the BatchDaemon for
 * this system test. You can run the tests with the in-memory implementation
 * by setting `GOOGLE_CLOUD_PHP_TESTS_WITHOUT_DAEMON` environment variable.
 */
class BatchRunnerTest extends TestCase
{
    use AssertStringContains;

    private $runner;

    private static $daemon;
    private static $targetFile;
    private static $commandFile;
    private static $testDir;
    private static $run_daemon;

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
            '%s/google-cloud-system-test-%d',
            sys_get_temp_dir(),
            getmypid()
        );
        @mkdir(self::$testDir);
        putenv('GOOGLE_CLOUD_BATCH_DAEMON_FAILURE_DIR=' . self::$testDir);
        $daemon_command = 'exec ' . __DIR__
            . '/../../../bin/google-cloud-batch daemon';
        self::$commandFile = tempnam(
            sys_get_temp_dir(),
            'batch-daemon-system-test'
        );
        self::$targetFile = tempnam(
            sys_get_temp_dir(),
            'batch-daemon-system-test'
        );
        self::$run_daemon =
            getenv('GOOGLE_CLOUD_PHP_TESTS_WITHOUT_DAEMON') === false;
        if (extension_loaded('sysvmsg')
            && extension_loaded('sysvsem')
            && extension_loaded('sysvshm') && self::$run_daemon) {
            $descriptorSpec = array(
                0 => array('file', 'php://stdin', 'r'),
                1 => array('file', 'php://stdout', 'w'),
                2 => array('file', 'php://stderr', 'w')
            );
            self::$daemon = proc_open(
                $daemon_command,
                $descriptorSpec,
                $pipes
            );
            putenv('IS_BATCH_DAEMON_RUNNING=true');
        } else {
            // Use in-memory implementation.
            putenv('IS_BATCH_DAEMON_RUNNING');
        }
    }

    public static function tear_down_after_class()
    {
        @proc_terminate(self::$daemon);
        @proc_close(self::$daemon);
        @unlink(self::$targetFile);
        @unlink(self::$commandFile);
        self::delTree(self::$testDir);
        putenv('GOOGLE_CLOUD_BATCH_DAEMON_FAILURE_DIR');
        putenv('IS_BATCH_DAEMON_RUNNING');
    }

    public function set_up()
    {
        $this->runner = new BatchRunner();
        $myJob = new MyJob(self::$commandFile, self::$targetFile);
        $this->runner->registerjob(
            'batch-daemon-system-test',
            array($myJob, 'runJob'),
            array(
                'numWorkers' => 1,
                'batchSize' => 2,
                'callPeriod' => 1,
            )
        );
    }

    public function getResult()
    {
        usleep(100000);
        return file_get_contents(self::$targetFile);
    }

    public function assertResultContains($expected)
    {
        $this->assertStringContainsString($expected, $this->getResult());
    }

    public function testSubmit()
    {
        $this->runner->submitItem('batch-daemon-system-test', 'apple');
        // It should be still in the buffer.
        $this->assertEmpty($this->getResult());
        $this->runner->submitItem('batch-daemon-system-test', 'orange');
        // This item should be picked by the call period.
        sleep(1);
        $this->assertResultContains('APPLE');
        $this->assertResultContains('ORANGE');

        $this->runner->submitItem('batch-daemon-system-test', 'peach');
        sleep(1);
        $this->assertResultContains('PEACH');

        // Failure simulation
        file_put_contents(self::$commandFile, 'fail');

        $this->runner->submitItem('batch-daemon-system-test', 'banana');
        $this->runner->submitItem('batch-daemon-system-test', 'lemon');
        sleep(1);
        $result = $this->getResult();
        $this->assertStringNotContainsString('BANANA', $result);
        $this->assertStringNotContainsString('LEMON', $result);

        // Retry simulation
        unlink(self::$commandFile);
        if (self::$run_daemon) {
            $retry_command = __DIR__
                . '/../../../bin/google-cloud-batch retry';
            exec($retry_command);
        } else {
            // The in-memory implementation doesn't share the JobConfig with
            // other processes, so we need to run retryAll in the same process.
            $retry = new Retry();
            $retry->retryAll();
        }
        sleep(1);
        $this->assertResultContains('BANANA');
        $this->assertResultContains('LEMON');
    }
}
