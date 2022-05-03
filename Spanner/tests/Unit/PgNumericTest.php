<?php
/**
 * Copyright 2022 Google LLC
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

use Google\Cloud\Spanner\PgNumeric;
use Google\Cloud\Spanner\V1\TypeCode;
use Google\Cloud\Spanner\V1\TypeAnnotationCode;
use PHPUnit\Framework\TestCase;

/**
 * @group spanner
 * @group spanner-pg-numeric
 */
class PgNumericTest extends TestCase
{
    /**
     * @dataProvider validValueProvider
     */
    public function testValidValues($value)
    {
        $val = new PgNumeric($value);
        $this->assertInstanceOf(PgNumeric::class, $val);

        if (is_null($value)) {
            $this->assertNull($val->get());
        } else {
            $this->assertEquals((string) $value, $val->get());
        }
    }

    public function validValueProvider()
    {
        return
            [
                ['0'],
                ['99'],
                ['99.9'],
                ['99999999999999999999999999999999999999.000000999999999'],
                ['+99999999999999999999999999999999999999000000000.999999999'],
                ['-99999999999999999999999999999999999999.999999999000000988888'],
                ['0.999999999'],
                [99], // int
                [99.9], // float
                ['123.'],
                ['.123'],
                ['1.123e+10'],
                ['1.123E-4'],
                ['-1E10'],
                [null],
                ['NaN'],
            ];
    }

    public function testGetsType()
    {
        $numeric = new PgNumeric('0');

        $typeCode = TypeCode::NUMERIC;
        $typeAnnotation = TypeAnnotationCode::PG_NUMERIC;

        $this->assertEquals($typeCode, $numeric->type());
        $this->assertEquals($typeAnnotation, $numeric->typeAnnotation());
    }

    public function testToString()
    {
        $expected = '99999999999999999999999999999999999999.00000999999999';
        $val = new PgNumeric($expected);

        $this->assertEquals($expected, (string) $val);
        $this->assertEquals($expected, $val->formatAsString());
    }
}
