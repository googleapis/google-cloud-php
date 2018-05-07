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

/**
 * @group spanner
 * @group spanner-arraytype
 */
class ArrayTypeTest extends TestCase
{
    public function testArrayType()
    {
        $arr = new ArrayType(Database::TYPE_STRING);
        $this->assertEquals(Database::TYPE_STRING, $arr->type());
    }

    public function testArrayTypeStruct()
    {
        $struct = new StructType;
        $struct->add('foo', Database::TYPE_STRING);

        $arr = new ArrayType($struct);
        $this->assertEquals($struct, $arr->structType());
    }

    /**
     * @dataProvider invalidType
     * @expectedException \InvalidArgumentException
     */
    public function testFailsOnInvalidType($type)
    {
        new ArrayType($type);
    }

    public function invalidType()
    {
        return [
            ['hello'],
            [100],
            [3.1415],
            [Database::TYPE_ARRAY],
            [Database::TYPE_STRUCT]
        ];
    }
}
