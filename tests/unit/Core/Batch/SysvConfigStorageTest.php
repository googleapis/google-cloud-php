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

use Google\Cloud\Core\Batch\BatchConfig;
use Google\Cloud\Core\Batch\SysvConfigStorage;
use Google\Cloud\Core\SysvTrait;

/**
 * @group core
 * @group batch
 */
class SysvConfigStorageTest extends \PHPUnit_Framework_TestCase
{
    use SysvTrait;

    private $storage;

    public function setUp()
    {
        if (! $this->isSysvIPCLOaded()) {
            $this->markTestSkipped(
                'Skipping because SystemV IPC extensions are not loaded');
        }
        $this->storage = new SysvConfigStorage();
    }

    public function testLockAndUnlock()
    {
        $this->assertTrue($this->storage->lock());
        $this->assertTrue($this->storage->unlock());
    }

    public function testSaveAndLoad()
    {
        $config = new BatchConfig();
        $this->storage->save($config);
        $this->assertEquals($config, $this->storage->load());
    }
}
