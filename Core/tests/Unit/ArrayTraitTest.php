<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Core\Tests\Unit;

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group core
 */
class ArrayTraitTest extends TestCase
{
    use ExpectException;

    private $impl;

    public function set_up()
    {
        $this->impl = TestHelpers::impl(ArrayTrait::class);
    }

    public function testPluck()
    {
        $value = '123';
        $key = 'key';
        $array = [$key => $value];
        $actualValue = $this->impl->call('pluck', [$key, &$array]);

        $this->assertEquals($value, $actualValue);
        $this->assertEquals([], $array);
    }

    public function testPluckThrowsExceptionWithInvalidKey()
    {
        $this->expectException('\InvalidArgumentException');

        $array = [];
        $this->impl->call('pluck', ['not_here', &$array]);
    }

    public function testPluckNonExistentKey()
    {
        $input = ['foo' => 'bar'];
        $this->assertNull(
            $this->impl->call('pluck', [
                'baz',
                &$input,
                false
            ])
        );
    }

    public function testPluckArray()
    {
        $keys = ['key1', 'key2'];
        $array = [
            'key1' => 'test',
            'key2' => 'test'
        ];
        $expectedArray = $array;

        $actualValues = $this->impl->call('pluckArray', [$keys, &$array]);

        $this->assertEquals($expectedArray, $actualValues);
        $this->assertEquals([], $array);
    }

    public function testIsAssocTrue()
    {
        $inputArr = [
            'test' => 1,
            'test' => 2
        ];

        $actual = $this->impl->call('isAssoc', [$inputArr]);
        $this->assertTrue($actual);

        // test second argument is irrelevant when array isn't empty
        $actual = $this->impl->call('isAssoc', [$inputArr, false]);
        $this->assertTrue($actual);
    }

    public function testIsAssocFalse()
    {
        $inputArr = [1, 2, 3];
        $actual = $this->impl->call('isAssoc', [$inputArr]);
        $this->assertFalse($actual);

        // test second argument is irrelevant when array isn't empty
        $actual = $this->impl->call('isAssoc', [$inputArr, true]);
        $this->assertFalse($actual);
    }

    public function testIsAssocEmptyArray()
    {
        // default (with absent $onEmpty)
        $actual = $this->impl->call('isAssoc', [[]]);
        $this->assertTrue($actual);

        // pass $onEmpty = true
        $actual = $this->impl->call('isAssoc', [[], true]);
        $this->assertTrue($actual);

        // pass $onEmpty = false
        $actual = $this->impl->call('isAssoc', [[], false]);
        $this->assertFalse($actual);
    }

    public function testArrayFilterRemoveNull()
    {
        $input = [
            'null' => null,
            'false' => false,
            'zero' => 0,
            'float' => 0.0,
            'empty' => '',
            'array' => [],
        ];

        $res = $this->impl->call('arrayFilterRemoveNull', [$input]);
        $this->assertArrayNotHasKey('null', $res);
        $this->assertArrayHasKey('false', $res);
        $this->assertArrayHasKey('zero', $res);
        $this->assertArrayHasKey('float', $res);
        $this->assertArrayHasKey('empty', $res);
        $this->assertArrayHasKey('array', $res);
    }

    public function testArrayMergeRecursive()
    {
        $array1 = [
            'a' => [
                'b' => 'c'
            ],
            'e' => 'f'
        ];

        $array2 = [
            'a' => [
                'b' => 'd'
            ],
            'g' => 'h'
        ];

        $expected = [
            'a' => [
                'b' => 'd'
            ],
            'e' => 'f',
            'g' => 'h'
        ];

        $res = $this->impl->call('arrayMergeRecursive', [$array1, $array2]);
        $this->assertEquals($expected, $res);
    }
}
