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

namespace Google\Cloud\BigQuery\Tests\Unit\Exception;

use Google\Cloud\BigQuery\Exception\JobException;
use Google\Cloud\BigQuery\Job;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group bigquery
 */
class JobExceptionTest extends TestCase
{
    use ProphecyTrait;

    public function testGetsJob()
    {
        $message = 'Job Failed.';
        $ex = new JobException(
            $message,
            $this->prophesize(Job::class)->reveal()
        );

        $this->assertEquals($message, $ex->getMessage());
        $this->assertInstanceOf(Job::class, $ex->getJob());
    }
}
