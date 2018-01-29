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

namespace Google\Cloud\Tests\System\Debugger;

use Google\Cloud\Debugger\Breakpoint;
use Google\Cloud\Debugger\Debuggee;
use Google\Cloud\Debugger\DebuggerClient;
use Google\Cloud\Debugger\V2\Gapic\Debugger2GapicClient as GapicClient;
use Google\Cloud\Debugger\V2\Breakpoint as GapicBreakpoint;
use Google\Cloud\Debugger\V2\SourceLocation;

use PHPUnit\Framework\TestCase;

/**
 * @group debugger
 */
class BasicTest extends TestCase
{
    private $debuggerClient;

    public function setUp()
    {
        $this->debuggerClient = new DebuggerClient([
            'keyFilePath' => getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH')
        ]);
    }

    /**
     * @dataProvider transports
     */
    public function testCanListDebuggees($transport)
    {
        $debuggerClient = $this->getClient($transport);

        $debuggees = $debuggerClient->debuggees();
        $this->assertInternalType('array', $debuggees);
        $this->assertContainsOnlyInstancesOf(
            Debuggee::class,
            $debuggees
        );
    }

    /**
     * @dataProvider transports
     */
    public function testRegisterSetUseBreakpoint($transport)
    {
        $debuggerClient = $this->getClient($transport);

        $debuggee = $debuggerClient->debuggee('', [
            'uniquifier' => 'debugger-system-test',
            'description' => 'Debugger System Test'
        ]);

        // Register the debuggee
        $debuggee->register();
        $this->assertNotEmpty($debuggee->id());

        // Set a breakpoint
        $breakpoint = $debuggee->setBreakpoint('tests/system/Debugger/BasicTest.php', __LINE__);
        $this->assertInstanceOf(Breakpoint::class, $breakpoint);
        $this->assertNotNull($breakpoint->location());

        // Fetch the list of breakpoints
        $breakpoints = $debuggee->breakpoints();
        $this->assertInternalType('array', $breakpoints);
        $this->assertContainsOnlyInstancesOf(
            Breakpoint::class,
            $breakpoints
        );

        // fulfill a breakpoint
        $this->assertTrue($breakpoint->resolveLocation());
        $breakpoint->finalize();
        $debuggee->updateBreakpoint($breakpoint);
    }

    public function getClient($transport)
    {
        return new DebuggerClient([
            'transport' => $transport,
            'keyFilePath' => getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH')
        ]);
    }

    public function transports()
    {
        return [
            ['grpc'],
            ['rest']
        ];
    }
}
