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

use Google\Cloud\Core\Batch\BatchDaemonTrait;

/**
 * @group core
 * @group batch
 */
class BatchDaemonTraitTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->impl = new MyBatchDaemonTraitClass();
    }

    public function testIsDaemonRunning()
    {
        // Clear the env
        $orig = getenv('IS_BATCH_DAEMON_RUNNING');
        try {
            putenv('IS_BATCH_DAEMON_RUNNING');
            $this->assertFalse($this->impl->isDaemonRunning());
            putenv('IS_BATCH_DAEMON_RUNNING=true');
            $this->assertTrue($this->impl->isDaemonRunning());
        } finally {
            if ($orig === false) {
                putenv('IS_BATCH_DAEMON_RUNNING');
            } else {
                putenv('IS_BATCH_DAEMON_RUNNING=' . $orig);
            }
        }
    }
}

class MyBatchDaemonTraitClass
{
    use BatchDaemonTrait {
        isDaemonRunning as privateIsDaemonRunning;
    }

    function isDaemonRunning()
    {
        return $this->privateIsDaemonRunning();
    }
}
