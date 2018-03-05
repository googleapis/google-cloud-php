<?php
/**
 * Copyright 2018 Google Inc.
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

use Google\Cloud\Core\Batch\InMemoryConfigStorage;
use Google\Cloud\Core\Batch\JobConfig;
use Google\Cloud\Core\Batch\SimpleJob;
use Google\Cloud\Core\Batch\SimpleJobTrait;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 * @group batch
 */
class SimpleJobTraitTest extends TestCase
{
    const ID = 'simple-job';

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetSimpleJobPropertiesThrowsExceptionWithoutIdentifier()
    {
        $job = new SimpleClass();
        $job->setSimpleJobProperties([]);
    }

    public function testRegistersConfig()
    {
        $storage = InMemoryConfigStorage::getInstance();
        $storage->clear();

        $impl = new SimpleClass();
        $impl->setSimpleJobProperties([
            'identifier' => self::ID,
            'configStorage' => $storage
        ]);

        $config = $storage->load();
        $this->assertInstanceOf(JobConfig::class, $config);
        $job = $config->getJobFromId(self::ID);
        $this->assertInstanceOf(SimpleJob::class, $job);

        $job->run();
        $this->assertTrue($impl->hasRun());
    }
}

class SimpleClass
{
    use SimpleJobTrait {
        setSimpleJobProperties as privateSetSimpleJobProperties;
    }

    private $hasRun = false;

    public function setSimpleJobProperties(array $options)
    {
        $this->privateSetSimpleJobProperties($options);
    }

    public function run()
    {
        $this->hasRun = true;
    }

    public function hasRun()
    {
        return $this->hasRun;
    }
}
