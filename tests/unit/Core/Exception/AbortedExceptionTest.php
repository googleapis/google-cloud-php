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

namespace Google\Cloud\Tests\Unit\Core\Exception;

use Google\Cloud\Core\Exception\AbortedException;

/**
 * @group core
 * @group exception
 */
class AbortedExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testRetryDelay()
    {
        $delay = [
            'seconds' => 1,
            'nanos' => 1
        ];

        $e = new AbortedException('', 500, null, [
            ['retryDelay' => $delay]
        ]);

        $this->assertEquals($delay, $e->getRetryDelay());
    }

    public function testRetryDelayNotSet()
    {
        $e = new AbortedException('', 500, null, []);
        $this->assertEquals(['seconds' => 0, 'nanos' => 0], $e->getRetryDelay());
    }

    public function testRetryDelayNoNanos()
    {
        $delay = [
            'seconds' => 1,
        ];

        $e = new AbortedException('', 500, null, [
            ['retryDelay' => $delay]
        ]);

        $this->assertEquals($delay + ['nanos' => 0], $e->getRetryDelay());
    }

    public function testRetryDelayNoSeconds()
    {
        $delay = [
            'nanos' => 1,
        ];

        $e = new AbortedException('', 500, null, [
            ['retryDelay' => $delay]
        ]);

        $this->assertEquals($delay + ['seconds' => 0], $e->getRetryDelay());
    }
}
