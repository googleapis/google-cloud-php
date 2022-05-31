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

namespace Google\Cloud\Debugger\Tests\Unit\Connection;

use Google\Cloud\Debugger\Connection\Grpc;
use Google\Cloud\Debugger\DebuggerClient;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\ApiCore\Serializer;
use Google\Cloud\Debugger\V2\Breakpoint;
use Google\Cloud\Debugger\V2\Debuggee;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group debugger
 */
class GrpcTest extends TestCase
{
    use GrpcTestTrait;

    private $requestWrapper;
    private $successMessage;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $this->requestWrapper = $this->prophesize(GrpcRequestWrapper::class);
        $this->successMessage = 'success';
    }

    public function testApiEndpoint()
    {
        $expected = 'foobar.com';

        $grpc = new GrpcStub(['apiEndpoint' => $expected]);

        $this->assertEquals($expected, $grpc->config['apiEndpoint']);
    }

    /**
     * @dataProvider methodProvider
     */
    public function testCallBasicMethods($method, $args, $expectedArgs)
    {
        $this->requestWrapper->send(
            Argument::type('callable'),
            $expectedArgs,
            Argument::type('array')
        )->willReturn($this->successMessage);

        $grpc = new Grpc();
        $grpc->setRequestWrapper($this->requestWrapper->reveal());

        $this->assertEquals($this->successMessage, $grpc->$method($args));
    }

    public function methodProvider()
    {
        if ($this->shouldSkipGrpcTests()) {
            return [];
        }

        $serializer = new Serializer();
        $debuggeeData = [
            'description' => 'my-debuggee',
            'uniquifier' => 'some-uniquifier'
        ];
        $pbDebuggee = $serializer->decodeMessage(new Debuggee(), $debuggeeData);
        $breakpointData = [
            'location' => [
                'path' => 'foo.php',
                'line' => 123
            ]
        ];
        $pbBreakpoint = $serializer->decodeMessage(new Breakpoint(), $breakpointData);

        return [
            [
                'listDebuggees',
                ['project' => 'my-project-id'],
                ['my-project-id', DebuggerClient::getDefaultAgentVersion(), []]
            ],
            [
                'registerDebuggee',
                ['debuggee' => $debuggeeData],
                [$pbDebuggee, []]
            ],
            [
                'listBreakpoints',
                ['debuggeeId' => 'my-debuggee-id'],
                ['my-debuggee-id', []]
            ],
            [
                'updateBreakpoint',
                ['debuggeeId' => 'my-debuggee-id', 'breakpoint' => $breakpointData],
                ['my-debuggee-id', $pbBreakpoint, []]
            ],
            [
                'setBreakpoint',
                ['debuggeeId' => 'my-debuggee-id'] + $breakpointData,
                ['my-debuggee-id', $pbBreakpoint, DebuggerClient::getDefaultAgentVersion(), []]
            ]
        ];
    }
}

//@codingStandardsIgnoreStart
class GrpcStub extends Grpc
{
    public $config;

    protected function constructGapic($gapicName, array $config)
    {
        $this->config = $config;

        return parent::constructGapic($gapicName, $config);
    }
}
//@codingStandardsIgnoreEnd
