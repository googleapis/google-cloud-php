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
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group spanner
 * @group spanner-structtype
 */
class StructTypeTest extends TestCase
{
    use ExpectException;

    private $definition;

    public function set_up()
    {
        $this->definition = [
            [
                'name' => 'foo',
                'type' => Database::TYPE_STRING
            ], [
                'name' => 'bar',
                'type' => Database::TYPE_ARRAY,
                'child' => new ArrayType(Database::TYPE_STRING)
            ]
        ];
    }

    public function testEnqueueInConstructor()
    {
        $type = new StructType($this->definition);
        $this->definition[0]['child'] = null;
        $this->assertEquals($this->definition, $type->fields());
    }

    public function testChainableAdd()
    {
        $type = new StructType;
        $type->add($this->definition[0]['name'], $this->definition[0]['type'])
            ->add($this->definition[1]['name'], $this->definition[1]['child']);

        $this->definition[0]['child'] = null;
        $this->assertEquals($this->definition, $type->fields());
    }

    public function testAddUnnamed()
    {
        $type = new StructType;
        $type->addUnnamed(Database::TYPE_STRING);
        $this->assertEquals($type->fields(), [
            [
                'name' => null,
                'type' => Database::TYPE_STRING,
                'child' => null
            ]
        ]);
    }

    public function testAddInvalidType()
    {
        $this->expectException('\InvalidArgumentException');
        $this->expectExceptionMessage('Field type `foo` is not valid.');

        (new StructType)->add('name', 'foo');
    }

    /**
     * @dataProvider definitionTypes
     */
    public function testInvalidTypeDefinition($type)
    {
        $this->expectException('\InvalidArgumentException');

        (new StructType)->add('foo', $type);
    }

    public function definitionTypes()
    {
        return [
            [Database::TYPE_ARRAY],
            [Database::TYPE_STRUCT]
        ];
    }

    public function testAddChildStruct()
    {
        $str = new StructType;
        $str->add('foo', new StructType);

        $fields = $str->fields();
        $this->assertEquals(Database::TYPE_STRUCT, $fields[0]['type']);
        $this->assertInstanceOf(StructType::class, $fields[0]['child']);
    }

    public function testAddChildArray()
    {
        $str = new StructType;
        $str->add('foo', new ArrayType(null));

        $fields = $str->fields();
        $this->assertEquals(Database::TYPE_ARRAY, $fields[0]['type']);
        $this->assertInstanceOf(ArrayType::class, $fields[0]['child']);
    }
}
