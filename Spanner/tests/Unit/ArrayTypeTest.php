<?php
/**
 * Copyright 2018 Google Inc.
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

use Google\Cloud\Spanner\ArrayType;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\StructType;
use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group spanner
 * @group spanner-arraytype
 */
class ArrayTypeTest extends TestCase
{
    use ExpectException;

    public function typesProvider()
    {
        return [
            // native types (w/o typeAnnotation)
            [Database::TYPE_BOOL],
            [Database::TYPE_INT64],
            [Database::TYPE_FLOAT64],
            [Database::TYPE_TIMESTAMP],
            [Database::TYPE_DATE],
            [Database::TYPE_STRING],
            [Database::TYPE_BYTES],
            [Database::TYPE_NUMERIC],
            [Database::TYPE_JSON],

            // types (w/ typeAnnotation)
            [Database::TYPE_PG_NUMERIC],
        ];
    }

    public function invalidTypeProvider()
    {
        return [
            ['hello'],
            [100],
            [3.1415],
            [Database::TYPE_ARRAY],
            [Database::TYPE_STRUCT]
        ];
    }

    /**
     * @dataProvider typesProvider
     */
    public function testArrayType($type)
    {
        $arr = new ArrayType($type);
        $this->assertEquals($type, $arr->type());
    }

    public function testArrayTypeStruct()
    {
        $struct = new StructType;
        $struct->add('foo', Database::TYPE_STRING);

        $arr = new ArrayType($struct);
        $this->assertEquals($struct, $arr->structType());
    }

    /**
     * @dataProvider invalidTypeProvider
     */
    public function testFailsOnInvalidType($type)
    {
        $this->expectException('\InvalidArgumentException');

        new ArrayType($type);
    }
}
