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

namespace Google\Cloud\Tests\Unit\Core\Lock;

require_once __DIR__ . '/MockGlobals.php';

use Google\Cloud\Core\Lock\MockValues;
use Google\Cloud\Core\Lock\SemaphoreLock;
use Google\Cloud\Core\SysvTrait;;

/**
 * @group core
 * @group lock
 */
trait CommonLockTrait
{
    private $lock;

    private function setLock($lock)
    {
        $this->lock = $lock;
    }

    public function testAcquireAndReleaseLock()
    {
        $this->assertTrue($this->lock->acquire());
        $this->lock->release();
    }

    public function testAcquireSameLockBeforeRelease()
    {
        $this->assertTrue($this->lock->acquire());
        $this->assertTrue($this->lock->acquire());

        $this->lock->release();
    }

    public function testSynchronizeLock()
    {
        $return = $this->lock->synchronize(function () {
            return true;
        });

        $this->assertTrue($return);
    }

    /**
     * @expectedException \Exception
     */
    public function testSynchronizeLockThrowsException()
    {
        $this->lock->synchronize(function () {
            throw new \Exception();
        });
    }
}

