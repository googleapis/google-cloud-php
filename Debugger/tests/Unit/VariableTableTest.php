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

namespace Google\Cloud\Debugger\Tests\Unit;

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
        $data = $variable->info();

        $this->assertEquals('int', $data['name']);
        $this->assertEquals(0, $data['varTableIndex']);
        $this->assertEquals(Int64::class, $data['type']);
        $this->assertArrayNotHasKey('value', $data);
        $this->assertArrayNotHasKey('members', $data);
        $this->assertArrayNotHasKey('status', $data);

        $variables = $variableTable->variables();
        $this->assertCount(1, $variables);

        $variableData = $variables[0]->info();
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
        $this->assertEquals(0, $data1->info()['varTableIndex']);

        $data2 = $variable2;
        $this->assertEquals(0, $data2->info()['varTableIndex']);

        $this->assertCount(1, $variableTable->variables());
    }

    public function testRegistersSimilarObjects()
    {
        $variableTable = new VariableTable();
        $object1 = new Int64('123');
        $object2 = new Int64('123');

        $this->assertNotSame($object2, $object1);

        $variable1 = $variableTable->register('int', $object1);
        $variable2 = $variableTable->register('int2', $object2);

        $data1 = $variable1;
        $this->assertEquals(0, $data1->info()['varTableIndex']);

        $data2 = $variable2;
        $this->assertEquals(1, $data2->info()['varTableIndex']);

        $this->assertCount(2, $variableTable->variables());
    }

    public function testRegistersArrayAsSameObjects()
    {
        $variableTable = new VariableTable();
        $object = ['abc', 123];

        $variable1 = $variableTable->register('int', $object, 'hashid');
        $variable2 = $variableTable->register('int2', $object, 'hashid');

        $data1 = $variable1;
        $this->assertEquals(0, $data1->info()['varTableIndex']);

        $data2 = $variable2;
        $this->assertEquals(0, $data2->info()['varTableIndex']);

        $this->assertCount(1, $variableTable->variables());
    }

    /**
     * @dataProvider primitiveValues
     */
    public function testRegisterScalarObjects($primitive, $expectedType, $expectedStringValue)
    {
        $variableTable = new VariableTable();

        $variable = $variableTable->register('primitive', $primitive);
        $variableData = $variable->info();
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

    public function testRegisterObjectWithId()
    {
        $variableTable = new VariableTable();
        $object = new Int64('123');
        $object2 = new Int64('123');

        $variable1 = $variableTable->register('int', $object, 'hashid');
        $variable2 = $variableTable->register('int2', $object2, 'hashid');

        $data1 = $variable1;
        $this->assertEquals(0, $data1->info()['varTableIndex']);

        $data2 = $variable2;
        $this->assertEquals(0, $data2->info()['varTableIndex']);

        $this->assertCount(1, $variableTable->variables());
    }

    public function testRegisterSameStrings()
    {
        $variableTable = new VariableTable();
        $string = 'Hello world';
        $string2 = 'Hello world';

        $variable1 = $variableTable->register('int', $string, 'hashid');
        $variable2 = $variableTable->register('int2', $string2, 'hashid');

        $data1 = $variable1;
        $this->assertEquals(0, $data1->info()['varTableIndex']);

        $data2 = $variable2;
        $this->assertEquals(0, $data2->info()['varTableIndex']);

        $this->assertCount(1, $variableTable->variables());
    }

    public function testRegistersArrayMembers()
    {
        $variableTable = new VariableTable();
        $variable = $variableTable->register('array', [1, 2, 3]);
        $data = $variable->info();
        $this->assertCount(3, $data['members']);
        foreach ($data['members'] as $member) {
            $this->assertInternalType('string', $member['name']);
        }
    }

    public function testLimitsStringLength()
    {
        $variableTable = new VariableTable();
        $var = str_repeat("1234567890", 100);
        $variable = $variableTable->register('foo', $var);
        $data = json_decode(json_encode($variable), true);
        $this->assertStringEndsWith('...', $data['value']);
    }

    public function testConfiguresStringLimit()
    {
        $variableTable = new VariableTable([], [
            'maxValueLength' => 15
        ]);
        $var = str_repeat("1234567890", 10);
        $variable = $variableTable->register('foo', $var);
        $data = json_decode(json_encode($variable), true);
        $this->assertEquals('123456789012...', $data['value']);
    }

    public function testLimitsCompoundVariableDepth()
    {
        $variableTable = new VariableTable();
        $var = [
            [
                [
                    [
                        [
                            [
                                [
                                    1
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $variable = $variableTable->register('deeplyNested', $var);
        $data = json_decode(json_encode($variable), true);

        $depth = 5;
        while ($depth > 0) {
            $this->assertCount(1, $data['members']);
            $data = $data['members'][0];
            $depth--;
        }
        $this->assertEquals('array (1)', $data['value']);
        $this->assertArrayNotHasKey('members', $data);
    }

    public function testConfiguresCompoundVariableDepthLimit()
    {
        $variableTable = new VariableTable([], [
            'maxMemberDepth' => 3
        ]);
        $var = [
            [
                [
                    [
                        [
                            [
                                [
                                    1
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $variable = $variableTable->register('deeplyNested', $var);
        $data = json_decode(json_encode($variable), true);

        $depth = 3;
        while ($depth > 0) {
            $this->assertCount(1, $data['members']);
            $data = $data['members'][0];
            $depth--;
        }
        $this->assertEquals('array (1)', $data['value']);
        $this->assertArrayNotHasKey('members', $data);
    }

    public function testLimitsTotalSize()
    {
        $variableTable = new VariableTable();
        for ($i = 0; $i < 1000; $i++) {
            $v = $variableTable->register('var' . $i, array_fill(0, $i, $i));
        }
        var_dump($variableTable->variables());
        $this->assertTrue(count($variableTable->variables() < 1000));
    }
}
