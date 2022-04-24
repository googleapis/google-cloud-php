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
use Google\Cloud\Spanner\ValueMapper;
use Google\Cloud\Spanner\StructType;
use PHPUnit\Framework\TestCase;

/**
 * @group spanner
 * @group spanner-arraytype
 */
class ArrayTypeTest extends TestCase
{
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

            // custom types (w/ typeAnnotation)
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
        $isCustomType = ValueMapper::isCustomType($type);

        // for custom types, the typeCode is derived by creating an object
        if ($isCustomType) {
            $obj = ValueMapper::getCustomTypeObj($type, null);
            $this->assertEquals($obj->type(), $arr->type());
        } else {
            // for native types, the typeCode is simply passed ahead to the ArrayType
            $this->assertEquals($type, $arr->type());
        }
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
     * @expectedException \InvalidArgumentException
     */
    public function testFailsOnInvalidType($type)
    {
        new ArrayType($type);
    }

    /**
     * @dataProvider typesProvider
     */
    public function testTypeAnnotation($type)
    {
        $arr = new ArrayType($type);
        $isCustomType = ValueMapper::isCustomType($type);

        // for custom types, the typeAnnotation is derived by creating an object
        if ($isCustomType) {
            $obj = ValueMapper::getCustomTypeObj($type, null);
            $this->assertEquals($obj->typeAnnotation(), $arr->typeAnnotation());
        } else {
            // for native types, the typeAnnotation is null
            $this->assertNull($arr->typeAnnotation());
        }
    }

    /**
     * @dataProvider typesProvider
     */
    public function testCustomType($type)
    {
        $arr = new ArrayType($type);
        $isCustomType = ValueMapper::isCustomType($type);

        // for custom types, the customType is equal to the type passed
        // to the ArrayType constructor
        if ($isCustomType) {
            $obj = ValueMapper::getCustomTypeObj($type, null);
            $this->assertEquals($type, $arr->customType());
        } else {
            // for native types, the customType getter is null
            $this->assertNull($arr->customType());
        }
    }
}
