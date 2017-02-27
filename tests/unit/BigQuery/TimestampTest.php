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

use Google\Cloud\BigQuery\Timestamp;

/**
 * @group bigquery
 */
class TimestampTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $value = new \DateTime();
        $timestamp = new Timestamp($value);

        $this->assertEquals($value, $timestamp->get());
    }

    public function testGetsType()
    {
        $timestamp = new Timestamp(new \DateTime());

        $this->assertEquals('TIMESTAMP', $timestamp->type());
    }

    public function testToString()
    {
        $value = new \DateTime();
        $timestamp = new Timestamp($value);
        $expected = $value->format('Y-m-d H:i:s.uP');

        $this->assertEquals($expected, (string) $timestamp);
        $this->assertEquals($expected, $timestamp->formatAsString());
    }
}
