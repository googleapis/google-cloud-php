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
use Google\Cloud\Core\Batch\InMemoryConfigStorage;

/**
 * @group core
 * @group batch
 */
class InMemoryConfigStorageTest extends \PHPUnit_Framework_TestCase
{
    private $items;

    public function testSingletonEquality()
    {
        $configStorage1 = InMemoryConfigStorage::getInstance();
        $configStorage2 = InMemoryConfigStorage::getInstance();
        $this->assertEquals($configStorage1, $configStorage2);
    }

    public function testConstructorIsForbidden()
    {
        $reflection = new \ReflectionClass(
            '\Google\Cloud\Core\Batch\InMemoryConfigStorage');
        $constructor = $reflection->getConstructor();
        $this->assertFalse($constructor->isPublic());
    }

    public function testLock()
    {
        $configStorage = InMemoryConfigStorage::getInstance();
        $result = $configStorage->lock();
        $this->assertTrue($result);
    }

    public function testUnLock()
    {
        $configStorage = InMemoryConfigStorage::getInstance();
        $result = $configStorage->unlock();
        $this->assertTrue($result);
    }

    public function testSaveAndLoad()
    {
        $configStorage = InMemoryConfigStorage::getInstance();
        $config = new BatchConfig();
        $configStorage->save($config);
        $this->assertEquals($config, $configStorage->load());
    }

    public function testSubmit()
    {
        $configStorage = InMemoryConfigStorage::getInstance();
        $config = new BatchConfig();
        $config->registerJob(
            'testSubmit',
            array($this, 'runJob'),
            array('batchSize' => 2)
        );
        $configStorage->save($config);

        $configStorage->submit('apple', 1);
        // The job hasn't been run because of the batchSize.
        $this->assertEmpty($this->items);
        $configStorage->submit('orange', 1);
        $this->assertEquals(
            array('APPLE', 'ORANGE'),
            $this->items
        );
        $configStorage->submit('banana', 1);
        // It's in the buffer.
        $this->assertEquals(
            array('APPLE', 'ORANGE'),
            $this->items
        );
        // shutdown will pick the remainder.
        $configStorage->shutdown();
        $this->assertEquals(
            array('APPLE', 'ORANGE', 'BANANA'),
            $this->items
        );
    }

    /**
     * A method that we use for the test.
     */
    public function runJob($items)
    {
        foreach ($items as $item) {
            $this->items[] = strtoupper($item);
        }
        return true;
    }
}
