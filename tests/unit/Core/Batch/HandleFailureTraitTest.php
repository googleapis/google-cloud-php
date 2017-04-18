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

use Google\Cloud\Core\Batch\HandleFailureTrait;

/**
 * @group core
 * @group batch
 */
class HandleFailureTraitTest extends \PHPUnit_Framework_TestCase
{

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

    public function setUp()
    {
        $this->impl = new HandleFailureClass();
        $this->testDir = sprintf(
            '%s/google-cloud-unit-test-%d',
            sys_get_temp_dir(),
            getmypid()
        );
        @mkdir($this->testDir);
        putenv('GOOGLE_CLOUD_BATCH_DAEMON_FAILURE_DIR');
    }

    public function tearDown()
    {
        $this->delTree($this->testDir);
        putenv('GOOGLE_CLOUD_BATCH_DAEMON_FAILURE_DIR');
    }

    /**
     * @ExpectedException \RuntimeException
     */
    public function testInitFailureFileThrowsException()
    {
        putenv(
            'GOOGLE_CLOUD_BATCH_DAEMON_FAILURE_DIR=/tmp/non-existent/subdir');
        $this->impl->initFailureFile();
    }

    public function testInitFailureFile()
    {
        $this->impl->initFailureFile();
        $this->assertEquals(
            sprintf('%s/batch-daemon-failure', sys_get_temp_dir()),
            $this->impl->getBaseDir()
        );
        $this->assertEquals(
            sprintf(
                '%s/failed-items-%d',
                $this->impl->getBaseDir(),
                getmypid()
            ),
            $this->impl->getFailureFile()
        );
        putenv('GOOGLE_CLOUD_BATCH_DAEMON_FAILURE_DIR=/tmp');
        $this->impl->initFailureFile();
        $this->assertEquals('/tmp', $this->impl->getBaseDir());
        $this->assertEquals(
            sprintf(
                '%s/failed-items-%d',
                $this->impl->getBaseDir(),
                getmypid()
            ),
            $this->impl->getFailureFile()
        );
    }

    public function testHandleFailure()
    {
        putenv('GOOGLE_CLOUD_BATCH_DAEMON_FAILURE_DIR=' . $this->testDir);
        $this->impl->initFailureFile();
        $this->impl->handleFailure(1, array('apple', 'orange'));
        $files = $this->impl->getFailedFiles();
        $this->assertCount(1, $files);
        $unserialized = unserialize(file_get_contents($files[0]));
        $this->assertEquals(
            array(1 => array('apple', 'orange')),
            $unserialized
        );
    }
}

class HandleFailureClass
{
    use HandleFailureTrait {
        initFailureFile as privateInitFailureFile;
        getFailedFiles as privateGetFailedFiles;
    }

    public function getFailureFile()
    {
        return $this->failureFile;
    }

    public function getBaseDir()
    {
        return $this->baseDir;
    }

    public function initFailureFile()
    {
        return $this->privateInitFailureFile();
    }

    public function getFailedFiles()
    {
        return $this->privateGetFailedFiles();
    }
}
