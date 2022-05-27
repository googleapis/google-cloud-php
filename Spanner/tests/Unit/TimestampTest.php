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

namespace Google\Cloud\Spanner\Tests\Unit;

use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIsType;

/**
 * @group spanner
 */
class TimestampTest extends TestCase
{
    use AssertIsType;
    use GrpcTestTrait;

    private $dt;
    private $ts;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $this->dt = new \DateTime('1989-10-11 08:58:00 +00:00');
        $this->ts = new Timestamp($this->dt);
    }

    public function testGet()
    {
        $this->assertEquals($this->dt, $this->ts->get());
    }

    public function testFormatAsString()
    {
        $this->assertEquals(
            (new \DateTime($this->dt->format(Timestamp::FORMAT)))->format('U'),
            (new \DateTime($this->ts->formatAsString()))->format('U')
        );
    }

    public function testCast()
    {
        $this->assertEquals(
            (new \DateTime($this->dt->format(Timestamp::FORMAT)))->format('U'),
            (new \DateTime(str_replace('000000000', '000000', (string)$this->ts)))->format('U')
        );
    }

    public function testType()
    {
        $this->assertIsInt($this->ts->type());
    }
}
