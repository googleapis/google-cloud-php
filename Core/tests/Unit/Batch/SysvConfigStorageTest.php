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
use Google\Cloud\Core\Batch\JobConfig;
use Google\Cloud\Core\Batch\SysvConfigStorage;
use Google\Cloud\Core\SysvTrait;
use Google\Cloud\Core\Tests\Unit\Batch\Fixtures\TestSerializableObjectWithClosure;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 * @group batch
 */
class SysvConfigStorageTest extends TestCase
{
    use SysvTrait;

    private $storage;

    private $originalShmSize;

    private $originalPerm;

    private $originalProject;

    public function setUp()
    {
        if (! $this->isSysvIPCLOaded()) {
            $this->markTestSkipped(
                'Skipping because SystemV IPC extensions are not loaded'
            );
        }
        $this->storage = new SysvConfigStorage();
        $this->originalShmSize = getenv('GOOGLE_CLOUD_BATCH_SHM_SIZE');
        $this->originalPerm = getenv('GOOGLE_CLOUD_BATCH_PERM');
        $this->originalProject = getenv('GOOGLE_CLOUD_BATCH_PROJECT');
    }

    public function tearDown()
    {
        if ($this->originalShmSize === false) {
            putenv("GOOGLE_CLOUD_BATCH_SHM_SIZE");
        } else {
            putenv("GOOGLE_CLOUD_BATCH_SHM_SIZE=$this->originalShmSize");
        }
        if ($this->originalPerm === false) {
            putenv("GOOGLE_CLOUD_BATCH_PERM");
        } else {
            putenv("GOOGLE_CLOUD_BATCH_PERM=$this->originalPerm");
        }
        if ($this->originalProject === false) {
            putenv("GOOGLE_CLOUD_BATCH_PROJECT");
        } else {
            putenv("GOOGLE_CLOUD_BATCH_PROJECT=$this->originalProject");
        }
    }

    public function testLockAndUnlock()
    {
        $this->assertTrue($this->storage->lock());
        $this->assertTrue($this->storage->unlock());
    }

    public function testSaveAndLoad()
    {
        $config = new JobConfig();
        $this->storage->save($config);
        $this->assertEquals($config, $this->storage->load());
    }

    public function testSaveBadConfig()
    {
        $object = new TestSerializableObjectWithClosure();
        $config = new JobConfig();
        $config->registerJob('badConfig', function ($id) use ($object) {
            return new BatchJob('badConfig', $id, [$object, 'callback']);
        });

        try {
            $this->storage->save($config);
        } catch (\RuntimeException $e) {
            // verify we didn't corrupt memory
            $this->storage->load();
            // Just to avoid the test warning
            $this->assertTrue(true);
            return;
        }

        $this->assertTrue(false, 'should have thrown an exception');
    }

    public function testDefaultValues()
    {
        putenv('GOOGLE_CLOUD_BATCH_SHM_SIZE');
        putenv('GOOGLE_CLOUD_BATCH_PERM');
        putenv('GOOGLE_CLOUD_BATCH_PROJECT');
        $r = new \ReflectionObject($this->storage);
        $p = $r->getProperty('shmSize');
        $p->setAccessible(true);
        $this->assertEquals(200000, $p->getValue($this->storage));
        $p = $r->getProperty('perm');
        $p->setAccessible(true);
        $this->assertEquals(0600, $p->getValue($this->storage));
        $p = $r->getProperty('project');
        $p->setAccessible(true);
        $this->assertEquals('A', $p->getValue($this->storage));
    }

    public function testEnvVarCustomization()
    {
        putenv('GOOGLE_CLOUD_BATCH_SHM_SIZE=10');
        putenv('GOOGLE_CLOUD_BATCH_PERM=0666');
        putenv('GOOGLE_CLOUD_BATCH_PROJECT=B');
        $storage = new SysvConfigStorage();
        $r = new \ReflectionObject($storage);
        $p = $r->getProperty('shmSize');
        $p->setAccessible(true);
        $this->assertEquals(10, $p->getValue($storage));
        $p = $r->getProperty('perm');
        $p->setAccessible(true);
        $this->assertEquals(0666, $p->getValue($storage));
        $p = $r->getProperty('project');
        $p->setAccessible(true);
        $this->assertEquals('B', $p->getValue($storage));
    }
}
