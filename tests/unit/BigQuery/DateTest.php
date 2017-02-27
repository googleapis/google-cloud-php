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

use Google\Cloud\BigQuery\Date;

/**
 * @group bigquery
 */
class DateTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $value = new \DateTime();
        $date = new Date($value);

        $this->assertEquals($value, $date->get());
    }

    public function testGetsType()
    {
        $date = new Date(new \DateTime());

        $this->assertEquals('DATE', $date->type());
    }

    public function testStringFormatting()
    {
        $value = new \DateTime();
        $date = new Date($value);
        $expected = $value->format('Y-m-d');

        $this->assertEquals($expected, (string) $date);
        $this->assertEquals($expected, $date->formatAsString());
    }
}
