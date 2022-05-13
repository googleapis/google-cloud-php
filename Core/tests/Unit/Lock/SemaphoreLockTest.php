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

namespace Google\Cloud\Core\Tests\Unit\Lock;

use Google\Cloud\Core\Lock\SemaphoreLock;
use Google\Cloud\Core\SysvTrait;
use Google\Cloud\Core\Testing\Lock\MockValues;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group core
 * @group lock
 */
class SemaphoreLockTest extends TestCase
{
    use CommonLockTrait;
    use SysvTrait;

    const LOCK_NAME = 'test';

    public function set_up()
    {
        if (!$this->isSysvIPCLoaded()) {
            $this->markTestSkipped(
                'Skipping because SystemV IPC extensions are not loaded'
            );
        }

        $this->setLock(new SemaphoreLock(1));
        MockValues::initialize();
    }

    public function testThrowsExceptionWithInvalidKey()
    {
        $this->expectException('\InvalidArgumentException');

        new SemaphoreLock('abc');
    }

    public function testThrowsExceptionWhenSemAcquireFailsOnAcquire()
    {
        $this->expectException('\RuntimeException');
        $this->expectExceptionMessage('Failed to acquire lock.');

        MockValues::$sem_acquireReturnValue = false;
        $this->lock->acquire();
    }

    public function testThrowsExceptionWhenSemReleaseFailsOnRelease()
    {
        $this->expectException('\RuntimeException');
        $this->expectExceptionMessage('Failed to release lock.');

        $this->lock->acquire();
        MockValues::$sem_releaseReturnValue = false;
        $this->lock->release();
    }

    public function testThrowsExceptionWhenSemGetFails()
    {
        $this->expectException('\RuntimeException');
        $this->expectExceptionMessage('Failed to generate semaphore ID.');

        MockValues::$sem_getReturnValue = false;
        $this->lock->acquire();
    }
}
