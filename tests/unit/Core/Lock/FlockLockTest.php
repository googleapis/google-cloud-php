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

use Google\Cloud\Core\Lock\FlockLock;
use Google\Cloud\Core\Lock\MockValues;

/**
 * @group core
 * @group lock
 */
class FlockLockTest extends \PHPUnit_Framework_TestCase
{
    use CommonLockTrait;

    const LOCK_NAME = 'test';

    public function setUp()
    {
        MockValues::initialize();
        $this->setLock(new FlockLock(self::LOCK_NAME));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionWithInvalidFileName()
    {
        new FlockLock(123);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Failed to acquire lock.
     */
    public function testThrowsExceptionWhenFlockFailsOnAcquire()
    {
        MockValues::$flockReturnValue = false;
        $this->lock->acquire();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Failed to release lock.
     */
    public function testThrowsExceptionWhenFlockFailsOnRelease()
    {
        $this->lock->acquire();
        MockValues::$flockReturnValue = false;
        $this->lock->release();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Failed to open lock file.
     */
    public function testThrowsExceptionWhenFopenFails()
    {
        MockValues::$fopenReturnValue = false;
        $this->lock->acquire();
    }
}

