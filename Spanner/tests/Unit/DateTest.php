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

use Google\Cloud\Spanner\Date;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIsType;

/**
 * @group spanner
 */
class DateTest extends TestCase
{
    use AssertIsType;
    use GrpcTestTrait;

    private $dt;
    private $date;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $this->dt = new \DateTime('1989-10-11');
        $this->date = new Date($this->dt);
    }

    public function testCreateFromValues()
    {
        $date = Date::createFromValues(1989, 10, 11);
        $this->assertEquals($date->formatAsString(), $this->date->formatAsString());
    }

    public function testGet()
    {
        $this->assertEquals($this->dt, $this->date->get());
    }

    public function testFormatAsString()
    {
        $this->assertEquals($this->dt->format(Date::FORMAT), $this->date->formatAsString());
    }

    public function testCast()
    {
        $this->assertEquals($this->dt->format(Date::FORMAT), (string)$this->date);
    }

    public function testType()
    {
        $this->assertIsInt($this->date->type());
    }
}
