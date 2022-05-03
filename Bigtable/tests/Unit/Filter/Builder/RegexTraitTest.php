<?php
/**
 * Copyright 2018, Google LLC All rights reserved.
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

namespace Google\Cloud\Bigtable\Tests\Unit\Filter\Builder;

use Google\Cloud\Bigtable\Filter\Builder\RegexTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group bigtable
 * @group bigtabledata
 */
class RegexTraitTest extends TestCase
{
    use ExpectException;

    private $implementation;

    public function set_up()
    {
        $this->implementation = TestHelpers::impl(RegexTrait::class);
    }

    public function testEscapeLiteralValueShouldReturnNullOnNull()
    {
        $this->assertEquals(
            null,
            $this->implementation->call('escapeLiteralValue', [null])
        );
    }

    public function testEscapeLiteralValueShouldThrowIfNotByteArrayOrString()
    {
        $this->expectException('\Exception');
        $this->expectExceptionMessage('Expected byte array or string, instead got \'object\'.');

        $this->implementation->call('escapeLiteralValue', [new \stdClass]);
    }

    public function testEscapeLiteralValueAsciiChr()
    {
        $this->assertEquals(
            'hi',
            $this->implementation->call('escapeLiteralValue', ['hi'])
        );
    }

    public function testEscapeLiteralValueWithEscapeChr()
    {
        $this->assertEquals(
            'h\\.\\*i',
            $this->implementation->call('escapeLiteralValue', ['h.*i'])
        );
    }

    public function testEscapeLiteralValueWithByteArray()
    {
        $value = [ 0xe2, 0x80, 0xb3];
        $escapedValue = $this->implementation->call('escapeLiteralValue', [$value]);
        $expected = implode(array_map('chr', $value));
        $this->assertEquals($expected, $escapedValue);
    }
}
