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

namespace Google\Cloud\Tests\Unit\BigQuery;

use Google\Cloud\BigQuery\Time;

/**
 * @group bigquery
 */
class TimeTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $value = new \DateTime();
        $time = new Time($value);

        $this->assertEquals($value, $time->get());
    }

    public function testGetsType()
    {
        $time = new Time(new \DateTime());

        $this->assertEquals('TIME', $time->type());
    }

    public function testToString()
    {
        $value = new \DateTime();
        $time = new Time($value);
        $expected = $value->format('H:i:s.u');

        $this->assertEquals($expected, (string) $time);
        $this->assertEquals($expected, $time->formatAsString());
    }
}
