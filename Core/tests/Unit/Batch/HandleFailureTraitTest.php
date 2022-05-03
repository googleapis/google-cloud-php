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

use Google\Cloud\Core\Batch\HandleFailureTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group core
 * @group batch
 */
class HandleFailureTraitTest extends TestCase
{
    use ExpectException;

    private $impl;
    private $testDir;

    public function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            $target = "$dir/$file";
            (is_dir($target)) ? $this->delTree($target) : unlink($target);
        }
        return rmdir($dir);
    }

    public function set_up()
    {
        $this->impl = TestHelpers::impl(HandleFailureTrait::class);
        $this->testDir = sprintf(
            '%s/google-cloud-unit-test-%d',
            sys_get_temp_dir(),
            getmypid()
        );
        @mkdir($this->testDir);
        putenv('GOOGLE_CLOUD_BATCH_DAEMON_FAILURE_DIR');
    }

    public function tear_down()
    {
        $this->delTree($this->testDir);
        putenv('GOOGLE_CLOUD_BATCH_DAEMON_FAILURE_DIR');
    }

    public function testInitFailureFileThrowsException()
    {
        if (0 === posix_getuid()) {
            $this->markTestSkipped('Cannot test init failure as root');
        }
        $this->expectException('\RuntimeException');

        putenv('GOOGLE_CLOUD_BATCH_DAEMON_FAILURE_DIR=/bad/write/dir');
        $this->impl->call('initFailureFile');
    }

    public function testInitFailureFile()
    {
        $this->impl->call('initFailureFile');
        $this->assertEquals(
            sprintf('%s/batch-daemon-failure', sys_get_temp_dir()),
            $this->impl->___getProperty('baseDir')
        );
        $this->assertEquals(
            sprintf(
                '%s/failed-items-%d',
                $this->impl->___getProperty('baseDir'),
                getmypid()
            ),
            $this->impl->___getProperty('failureFile')
        );
        putenv('GOOGLE_CLOUD_BATCH_DAEMON_FAILURE_DIR=/tmp');
        $this->impl->call('initFailureFile');
        $this->assertEquals('/tmp', $this->impl->___getProperty('baseDir'));
        $this->assertEquals(
            sprintf(
                '%s/failed-items-%d',
                $this->impl->___getProperty('baseDir'),
                getmypid()
            ),
            $this->impl->___getProperty('failureFile')
        );
    }

    public function testHandleFailure()
    {
        putenv('GOOGLE_CLOUD_BATCH_DAEMON_FAILURE_DIR=' . $this->testDir);
        $this->impl->call('initFailureFile');
        $this->impl->handleFailure(1, array('apple', 'orange'));
        $files = $this->impl->call('getFailedFiles');
        $this->assertCount(1, $files);
        $unserialized = unserialize(file_get_contents($files[0]));
        $this->assertEquals(
            array(1 => array('apple', 'orange')),
            $unserialized
        );
    }
}
