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

namespace Google\Cloud\Tests\Unit\Core\Batch;

use Google\Cloud\Core\Batch\SimpleJob;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 * @group batch
 */
class SimpleJobTest extends TestCase
{
    private $success = false;

    public function testBasic()
    {
        $job = new SimpleJob('testing', [$this, 'runJob'], 1);
        $this->assertEquals('testing', $job->identifier());
        $this->assertEquals(1, $job->numWorkers());
        $this->assertFalse($job->flush());
        $this->assertNull($job->bootstrapFile());

        $job->run();
        $this->assertTrue($this->success);
    }

    public function runJob()
    {
        $this->success = true;
    }
}
