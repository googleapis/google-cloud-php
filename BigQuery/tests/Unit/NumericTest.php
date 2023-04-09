<?php
/**
 * Copyright 2018 Google LLC
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

use Google\Cloud\BigQuery\Numeric;
use PHPUnit\Framework\TestCase;

/**
 * @group bigquery
 */
class NumericTest extends TestCase
{
    /**
     * @dataProvider invalidValueProvider
     */
    public function testInvalidValues($value)
    {
        $this->expectException('\InvalidArgumentException');

        new Numeric($value);
    }

    public function invalidValueProvider()
    {
        return
        [
            ['arpha'],
            ['+9'], // doesn't support + sign
            ['999999999999999999999999999999999999999.999999999'], // to many digits
            ['0.9999999999'], // to many digits of scale
            ['0.123.123'],
            ['...']
        ];
    }

    /**
     * @dataProvider validValueProvider
     */
    public function testValidValues($value)
    {
        $numeric = new Numeric($value);
        $this->assertInstanceOf(Numeric::class, $numeric);
        $this->assertEquals((string) $value, $numeric->get());
    }

    public function validValueProvider()
    {
        return
            [
                ['0'],
                ['99'],
                ['99.9'],
                ['99999999999999999999999999999999999999.999999999'],
                ['-99999999999999999999999999999999999999.999999999'],
                ['0.999999999'],
                [99], // int
                [99.9], // float
                ['123.'],
                ['.123']
            ];
    }

    public function testGetsType()
    {
        $numeric = new Numeric('9');

        $this->assertEquals('NUMERIC', $numeric->type());
    }

    public function testToString()
    {
        $expected = '99999999999999999999999999999999999999.999999999';
        $numeric = new Numeric($expected);

        $this->assertEquals($expected, (string) $numeric);
        $this->assertEquals($expected, $numeric->formatAsString());
    }
}
