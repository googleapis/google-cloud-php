<?php
/*
 * Copyright 2023 Google LLC
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Google\ApiCore\Tests\Unit\Options;

use ArrayAccess;
use BadMethodCallException;
use Google\ApiCore\Options\OptionsTrait;
use Google\ApiCore\ValidationException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use TypeError;

class OptionsTraitTest extends TestCase
{
    use ProphecyTrait;

    public function testDefaultOptionsExistAndUnrecognizedOptionsAreIgnored()
    {
        $options = new OptionsTraitStub([
            'option3' => 'foo',
            'option4' => 'bar',
        ]);

        $this->assertArrayHasKey('option1', $options->toArray());
        $this->assertArrayHasKey('option2', $options->toArray());
        $this->assertArrayNotHasKey('option3', $options->toArray());
        $this->assertArrayNotHasKey('option4', $options->toArray());
    }

    public function testInvalidTypesThrowException()
    {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage(PHP_MAJOR_VERSION < 8
            ? 'Google\ApiCore\Tests\Unit\Options\OptionsTraitStub::$option2 must be int or null, string used'
            : 'Cannot assign string to property Google\ApiCore\Tests\Unit\Options\OptionsTraitStub::$option2 of type ?int'
        );

        $options = new OptionsTraitStub([
            'option1' => 123,   // this is okay because it is cast to a string
            'option2' => 'bar', // this will throw an exception
        ]);
    }

    public function testArrayGet()
    {
        $options = new OptionsTraitStub(['option1' => 'abc']);
        $this->assertEquals('abc', $options['option1']);
    }

    public function testArrayIsset()
    {
        $options = new OptionsTraitStub(['option1' => 'abc']);
        $this->assertTrue(isset($options['option1']));
        $this->assertFalse(isset($options['option2'])); // valid option
        $this->assertFalse(isset($options['option3'])); // invalid option
    }

    public function testArraySetThrowsException()
    {
        $this->expectException(BadMethodCallException::class);
        $options = new OptionsTraitStub([]);
        $options['option1'] = 'abc';
    }

    public function testArrayUnsetThrowsException()
    {
        $this->expectException(BadMethodCallException::class);
        $options = new OptionsTraitStub([]);
        unset($options['option1']);
    }

    public function testInvalidFilePathThrowsException()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Could not find specified file: does/not/exist.php');
        new OptionsTraitStub(['file' => 'does/not/exist.php']);
    }

    public function testValidateFileExists()
    {
        $options = new OptionsTraitStub(['option1' => 'foo', 'file' => __FILE__]);
        $this->assertEquals(__FILE__, $options['file']);
    }
}

class OptionsTraitStub implements ArrayAccess
{
    use OptionsTrait;

    private ?string $option1;
    private ?int $option2;
    private ?string $file;

    public function __construct(array $options)
    {
        $this->option1 = $options['option1'] ?? null;
        $this->option2 = $options['option2'] ?? null;
        $this->setFile($options['file'] ?? null);
    }

    private function setFile(?string $file)
    {
        if (!is_null($file)) {
            self::validateFileExists($file);
        }
        $this->file = $file;
    }
}
