<?php
/**
 * Copyright 2025 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Core\Tests\Unit;

use Google\Cloud\Core\TypedOptions;
use Google\Protobuf\Internal\Message;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use stdClass;
use TypeError;

/**
 * @group core
 */
class TypedOptionsTest extends TestCase
{
    private $optionsAndTypes;

    public function setUp(): void
    {
        $this->optionsAndTypes = [
            'string' => 'string',
            'int' => 'int',
            'bool' => 'bool',
            'float' => 'float',
            'array' => 'array',
            'object' => stdClass::class,
        ];
    }

    public function testValidateBasicTypes()
    {
        $options = [
            'string' => 'hello',
            'int' => 123,
            'bool' => true,
            'float' => 1.23,
            'array' => ['a', 'b'],
            'object' => new stdClass(),
        ];

        $typedOptions = new TypedOptions($this->optionsAndTypes);
        $validated = $typedOptions->validate($options);

        $this->assertEquals($options, $validated);
    }

    public function testValidateRemovesUnknownOptions()
    {
        $options = [
            'string' => 'hello',
            'unknown' => 'world',
        ];

        $typedOptions = new TypedOptions($this->optionsAndTypes);
        $validated = $typedOptions->validate($options);

        $this->assertArrayNotHasKey('unknown', $validated);
        $this->assertArrayHasKey('string', $validated);
    }

    public function testValidateLooseTypeDoesNotThrowError()
    {
        $options = [
            'string' => 123, // expecting string, given integer
        ];

        $typedOptions = new TypedOptions($this->optionsAndTypes);
        $validatedOptions = $typedOptions->validate($options);
        $this->assertEquals('123', $validatedOptions['string']);
    }

    public function testValidateInvalidObjectTypeThrowsTypeError()
    {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Option object must be of type stdClass, array given');

        $options = [
            'object' => [], // expecting stdClass, given array
        ];

        $typedOptions = new TypedOptions($this->optionsAndTypes);
        $typedOptions->validate($options);
    }

    public function testValidateWithInvalidOptionTypeThrowsRuntimeException()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('invalid option type "NULL" for option "bad_type"');

        $options = [
            'bad_type' => 'value',
        ];

        $typedOptions = new TypedOptions(['bad_type' => null]);
        $typedOptions->validate($options);
    }

    public function testValidateWithMessage()
    {
        $message = new class extends Message {
            public function __construct()
            {
                // override protected constructor in protobuf extension
            }

            public function setFooBar($var)
            {
                // do nothing
            }
        };

        $options = [
            'foo_bar' => 'baz',
            'unknown' => 'qux',
        ];

        $typedOptions = new TypedOptions([], $message);
        $validated = $typedOptions->validate($options);

        $this->assertArrayHasKey('foo_bar', $validated);
        $this->assertEquals('baz', $validated['foo_bar']);
        $this->assertArrayNotHasKey('unknown', $validated);
    }
}
