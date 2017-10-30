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

use Google\Cloud\Debugger\Action;
use Google\Cloud\Debugger\Breakpoint;
use Google\Cloud\Debugger\SourceLocation;

/**
 * @group debugger
 */
class BreakpointTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromJson()
    {
        $input = [
            'id' => 'breakpointid',
            'action' => 'CAPTURE',
            'location' => [
                'path' => '/path/to/file.php',
                'line' => 45
            ],
            'createTime' => '2017-09-20T16:29:28.001Z',
            'userEmail' => 'debugger@google.com'
        ];

        $breakpoint = new Breakpoint($input);
        $this->assertEquals('breakpointid', $breakpoint->id());
        $this->assertEquals(Breakpoint::ACTION_CAPTURE, $breakpoint->action());
        $this->assertInstanceOf(SourceLocation::class, $breakpoint->location());
        $this->assertEquals('/path/to/file.php', $breakpoint->location()->path());
        $this->assertEquals(45, $breakpoint->location()->line());

        $this->assertProducesEquivalentJson($input, $breakpoint);
    }

    public function testParsesConditionFromJson()
    {
        $input = [
            'condition' => '$foo == "bar"'
        ];

        $breakpoint = new Breakpoint($input);
        $this->assertEquals('$foo == "bar"', $breakpoint->condition());

        $this->assertProducesEquivalentJson($input, $breakpoint);
    }

    public function testFinalizeSetsFinalStateAndTime()
    {
        $breakpoint = new Breakpoint();
        $breakpoint->finalize();
        $info = $breakpoint->info();

        $this->assertArrayHasKey('finalTime', $info);
        $this->assertArrayHasKey('isFinalState', $info);
        $this->assertTrue($info['isFinalState']);
    }

    public function testAddingStackFrame()
    {

    }

    public function testAddingStackFrames()
    {

    }

    public function testAddingEvaluatedExpressions()
    {

    }

    private function assertProducesEquivalentJson($array1, $array2)
    {
        $this->assertEquals(
            json_decode(json_encode($array1), true),
            json_decode(json_encode($array2), true)
        );
    }
}
