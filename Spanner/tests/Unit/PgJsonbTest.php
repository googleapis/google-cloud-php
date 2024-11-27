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

use Google\Cloud\Spanner\PgJsonb;
use Google\Cloud\Spanner\V1\TypeAnnotationCode;
use Google\Cloud\Spanner\V1\TypeCode;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 * @group spanner-pgjsonb
 */
class PgJsonbTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @dataProvider validValueProvider
     */
    public function testValidValues($value, $expectedVal)
    {
        $obj = new PgJsonb($value);
        $this->assertInstanceOf(PgJsonb::class, $obj);
        $this->assertEquals($expectedVal, $obj->get());
    }

    public function validValueProvider()
    {
        $obj = $this->prophesize('stdClass');
        $obj->willImplement('JsonSerializable');
        $obj->jsonSerialize()->willReturn(['a' => 1, 'b' => null]);

        return
            [
                // strings
                ['{}', '{}'],
                ['{"a":1, "b":2}', '{"a":1, "b":2}'],
                // // null value shouldn't be casted
                [null, null],
                // // arrays should be converted to JSON
                [['a' => 1.1, 'b' => '2'], '{"a":1.1,"b":"2"}'],
                // JsonSerializable should be used after a json_encode call
                [$obj->reveal(), '{"a":1,"b":null}']
            ];
    }

    /**
     * @dataProvider validValueProvider
     */
    public function testGetsType($val)
    {
        $obj = new PgJsonb($val);
        $this->assertEquals(TypeCode::JSON, $obj->type());
        $this->assertEquals(TypeAnnotationCode::PG_JSONB, $obj->typeAnnotation());
    }

    public function testToString()
    {
        $expected = '{}';
        $val = new PgJsonb($expected);

        $this->assertEquals($expected, (string) $val);
        $this->assertEquals($expected, $val->formatAsString());
    }

    public function invalidValueProvider()
    {
        return
            [
                ["\xB1\x31"],
                [NAN],
                [INF],
                [fopen('php://temp', 'r')],
            ];
    }

    /**
     * @dataProvider invalidValueProvider
     */
    public function testInvalidValues($value)
    {
        $this->expectException(InvalidArgumentException::class);

        $obj = new PgJsonb([$value]);
    }
}
