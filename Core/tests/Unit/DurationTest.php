<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Core\Tests\Unit;

use Google\Cloud\Core\Duration;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group core
 */
class DurationTest extends TestCase
{
    const SECONDS = 10;
    const NANOS = 1;

    private $duration;

    public function set_up()
    {
        $this->duration = new Duration(self::SECONDS, self::NANOS);
    }

    public function testGet()
    {
        $this->assertEquals([
            'seconds' => self::SECONDS,
            'nanos' => self::NANOS
        ], $this->duration->get());
    }

    public function testFormatAsString()
    {
        $this->assertEquals(
            json_encode($this->duration->get()),
            $this->duration->formatAsString()
        );
    }

    public function testTostring()
    {
        $this->assertEquals(
            json_encode($this->duration->get()),
            (string)$this->duration
        );
    }
}
