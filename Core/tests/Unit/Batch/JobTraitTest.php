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

use Google\Cloud\Core\Batch\JobInterface;
use Google\Cloud\Core\Batch\JobTrait;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 * @group batch
 */
class JobTraitTest extends TestCase
{
    public function testDefaults()
    {
        $job = new TestJob();
        $this->assertNull($job->identifier());
        $this->assertNull($job->id());
        $this->assertNull($job->numWorkers());
        $this->assertNull($job->bootstrapFile());
        $this->assertFalse($job->flush());
        $job->run();
    }
}

//@codingStandardsIgnoreStart
class TestJob implements JobInterface
{
    use JobTrait;

    public function run()
    {
        // Do nothing
    }
}
//@codingStandardsIgnoreEnd
