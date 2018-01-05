<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Tests\Unit\Debugger;

use Google\Cloud\Debugger\VariableTable;
use Google\Cloud\Core\Int64;
use PHPUnit\Framework\TestCase;

/**
 * @group debugger
 */
class VariableTableTest extends TestCase
{
    public function testRegisterObjectCreatesVariable()
    {
        $variableTable = new VariableTable();
        $object = new Int64('123');

        $variable = $variableTable->register('int', $object);
        $data = $variable->jsonSerialize();

        $this->assertEquals('int', $data['name']);
        $this->assertEquals(0, $data['varTableIndex']);
        $this->assertEquals(Int64::class, $data['type']);
        $this->assertArrayNotHasKey('value', $data);
        $this->assertArrayNotHasKey('members', $data);
        $this->assertArrayNotHasKey('status', $data);

        $variables = $variableTable->variables();
        $this->assertCount(1, $variables);

        $variableData = $variables[0]->jsonSerialize();
        $this->assertEquals('int', $variableData['name']);
        $this->assertArrayNotHasKey('varTableIndex', $variableData);
        $this->assertEquals(Int64::class, $variableData['type']);
        $this->assertRegexp('/Google\\\\Cloud\\\\Core\\\\Int64 \([0-9a-z]+\)/', $variableData['value']);
        $this->assertArrayNotHasKey('status', $variableData);
    }

    public function testRegistersSameObjects()
    {
        $variableTable = new VariableTable();
        $object = new Int64('123');

        $variable1 = $variableTable->register('int', $object);
        $variable2 = $variableTable->register('int2', $object);

        $data1 = $variable1;
        $this->assertEquals(0, $data1->jsonSerialize()['varTableIndex']);

        $data2 = $variable2;
        $this->assertEquals(0, $data2->jsonSerialize()['varTableIndex']);

        $this->assertCount(1, $variableTable->variables());
    }

    public function testRegistersSimilarObjects()
    {
        $variableTable = new VariableTable();
        $object1 = new Int64('123');
        $object2 = new Int64('123');

        $this->assertTrue($object1 !== $object2);

        $variable1 = $variableTable->register('int', $object1);
        $variable2 = $variableTable->register('int2', $object2);

        $data1 = $variable1;
        $this->assertEquals(0, $data1->jsonSerialize()['varTableIndex']);

        $data2 = $variable2;
        $this->assertEquals(1, $data2->jsonSerialize()['varTableIndex']);

        $this->assertCount(2, $variableTable->variables());
    }

    public function testRegistersArrayAsSameObjects()
    {
        $this->markTestSkipped('Array deduping NYI');
        $variableTable = new VariableTable();
        $object = ['abc', 123];

        $variable1 = $variableTable->register('int', $object);
        $variable2 = $variableTable->register('int2', $object);

        $data1 = $variable1;
        $this->assertEquals(0, $data1->jsonSerialize()['varTableIndex']);

        $data2 = $variable2;
        $this->assertEquals(0, $data2->jsonSerialize()['varTableIndex']);

        $this->assertCount(1, $variableTable->variables());
    }

    /**
     * @dataProvider primitiveValues
     */
    public function testRegisterScalarObjects($primitive, $expectedType, $expectedStringValue)
    {
        $variableTable = new VariableTable();

        $variable = $variableTable->register('primitive', $primitive);
        $variableData = $variable->jsonSerialize();
        $this->assertEquals('primitive', $variableData['name']);
        $this->assertArrayNotHasKey('varTableIndex', $variableData);
        $this->assertEquals($expectedType, $variableData['type']);
        $this->assertEquals($expectedStringValue, $variableData['value']);
        $this->assertArrayNotHasKey('members', $variableData);
        $this->assertArrayNotHasKey('status', $variableData);

        $this->assertCount(0, $variableTable->variables());
    }

    public function primitiveValues()
    {
        return [
            ['some string', 'string', 'some string'],
            [1234, 'integer', '1234'],
            [1234.2, 'double', '1234.2'],
            [NULL, 'NULL', 'NULL']
        ];
    }
}
