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
 * @group spanner-structtype
 */
class StructTypeTest extends TestCase
{
    private $definition;

    public function setUp()
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

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Field type `foo` is not valid.
     */
    public function testAddInvalidType()
    {
        (new StructType)->add('name', 'foo');
    }
}
