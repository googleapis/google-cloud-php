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

namespace Google\Cloud\Tests\Unit\Debugger;

use Google\Cloud\Debugger\StatusMessage;
use Google\Cloud\Debugger\Breakpoint;
use Google\Cloud\Debugger\SourceLocation;
use PHPUnit\Framework\TestCase;

/**
 * @group debugger
 */
class BreakpointValidationTest extends TestCase
{
    public function setUp()
    {
        if (!extension_loaded('stackdriver_debugger')) {
            $this->markTestSkipped('Breakpoint validation requires stackdriver_debugger extension');
        }
    }

    /**
     * @dataProvider conditionsToTest
     */
    public function testValidatesCondition($condition, $expectedValid)
    {
        $breakpoint = new Breakpoint([
            'location' => [
                'path' => __FILE__,
                'line' => __LINE__
            ],
            'condition' => $condition
        ]);
        $this->assertEquals($expectedValid, $breakpoint->validate());
        if (!$expectedValid) {
            $status = $breakpoint->status()->jsonSerialize();
            $this->assertTrue($status['isError']);
            $this->assertEquals(StatusMessage::REFERENCE_BREAKPOINT_CONDITION, $status['refersTo']);
        }
    }

    /**
     * @dataProvider conditionsToTest
     */
    public function testValidatesExpression($expression, $expectedValid)
    {
        $breakpoint = new Breakpoint([
            'location' => [
                'path' => __FILE__,
                'line' => __LINE__
            ],
            'expressions' => [$expression]
        ]);
        $this->assertEquals($expectedValid, $breakpoint->validate());
        if (!$expectedValid) {
            $status = $breakpoint->status()->jsonSerialize();
            $this->assertTrue($status['isError']);
            $this->assertEquals(StatusMessage::REFERENCE_BREAKPOINT_EXPRESSION, $status['refersTo']);
        }
    }

    public function conditionsToTest()
    {
        return [
            ['3 + 3', true],
            ['3 + 3 == 6', true],
            ['foo(3)', false],
            ['abs(-3)', false],
            ['$foo->bar', true],
            ['$foo->bar()', false]
        ];
    }

    public function testValidatesMissingFile()
    {
        $breakpoint = new Breakpoint([
            'location' => [
                'path' => __DIR__ . '/missing_file.php',
                'line' => __LINE__
            ]
        ]);
        $this->assertFalse($breakpoint->validate());
        $status = $breakpoint->status()->jsonSerialize();
        $this->assertTrue($status['isError']);
        $this->assertEquals(
            StatusMessage::REFERENCE_BREAKPOINT_SOURCE_LOCATION,
            $status['refersTo']
        );
    }

    public function testValidatesFileType()
    {
        $breakpoint = new Breakpoint([
            'location' => [
                'path' => __DIR__ . '/../../../composer.json',
                'line' => __LINE__
            ]
        ]);
        $this->assertFalse($breakpoint->validate());
        $status = $breakpoint->status()->jsonSerialize();
        $this->assertTrue($status['isError']);
        $this->assertEquals(
            StatusMessage::REFERENCE_BREAKPOINT_SOURCE_LOCATION,
            $status['refersTo']
        );
    }

    public function testValidatesEmptyLine()
    {
        $breakpoint = new Breakpoint([
            'location' => [
                'path' => __FILE__,
                'line' => __LINE__ - 6
            ]
        ]);
        $this->assertFalse($breakpoint->validate());
        $status = $breakpoint->status()->jsonSerialize();
        $this->assertTrue($status['isError']);
        $this->assertEquals(
            StatusMessage::REFERENCE_BREAKPOINT_SOURCE_LOCATION,
            $status['refersTo']
        );
    }

    public function testValidatesCommentLine()
    {
        $breakpoint = new Breakpoint([
            'location' => [
                'path' => __FILE__,
                'line' => 2
            ]
        ]);
        $this->assertFalse($breakpoint->validate());
        $status = $breakpoint->status()->jsonSerialize();
        $this->assertTrue($status['isError']);
        $this->assertEquals(
            StatusMessage::REFERENCE_BREAKPOINT_SOURCE_LOCATION,
            $status['refersTo']
        );
    }
}
