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
class SemaphoreLockTest extends \PHPUnit_Framework_TestCase
{
    use CommonLockTrait;
    use SysvTrait;

    const LOCK_NAME = 'test';

    public function setUp()
    {
        if (!$this->isSysvIPCLoaded()) {
            $this->markTestSkipped(
                'Skipping because SystemV IPC extensions are not loaded'
            );
        }

        $this->setLock(new SemaphoreLock(1));
        MockValues::initialize();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionWithInvalidKey()
    {
        new SemaphoreLock('abc');
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Failed to acquire lock.
     */
    public function testThrowsExceptionWhenSemAcquireFailsOnAcquire()
    {
        MockValues::$sem_acquireReturnValue = false;
        $this->lock->acquire();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Failed to release lock.
     */
    public function testThrowsExceptionWhenSemReleaseFailsOnRelease()
    {
        $this->lock->acquire();
        MockValues::$sem_releaseReturnValue = false;
        $this->lock->release();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Failed to generate semaphore ID.
     */
    public function testThrowsExceptionWhenSemGetFails()
    {
        MockValues::$sem_getReturnValue = false;
        $this->lock->acquire();
    }
}

