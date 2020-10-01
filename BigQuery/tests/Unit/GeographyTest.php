<?php
/**
 * Copyright 2020 Google LLC
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

namespace Google\Cloud\BigQuery\Tests\Unit;

use Google\Cloud\BigQuery\Geography;
use PHPUnit\Framework\TestCase;

/**
 * @group bigquery
 */
class GeographyTest extends TestCase
{
    public function testGet()
    {
        $value = 'POINT(10 20)';
        $geo = new Geography($value);

        $this->assertEquals($value, $geo->get());
    }

    public function testGetsType()
    {
        $geo = new Geography('');

        $this->assertEquals('GEOGRAPHY', $geo->type());
    }

    public function testToString()
    {
        $value = 'POINT(20 -50)';
        $geo = new Geography($value);

        $this->assertEquals($value, $geo->formatAsString());
    }
}
