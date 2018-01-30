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

namespace Google\Cloud\Tests\Unit\Debugger\Connection;

use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Debugger\Connection\Grpc;
use Google\Cloud\Tests\GrpcTestTrait;
use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

/**
 * @group debugger
 */
class GrpcTest extends TestCase
{
    use GrpcTestTrait;
    use GrpcTrait;

    private $successMessage;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->requestWrapper = $this->prophesize(GrpcRequestWrapper::class);
        $this->successMessage = 'success';
    }

    /**
     * @dataProvider methodProvider
     */
    public function testCallBasicMethods($method, $args)
    {
        $options = [
            'debuggeeId' => 'debuggee1'
        ];
        $this->requestWrapper->send(
            Argument::type('callable'),
            Argument::type('array'),
            Argument::type('array')
        )->willReturn($this->successMessage);

        $grpc = new Grpc();
        $grpc->setRequestWrapper($this->requestWrapper->reveal());

        $this->assertEquals($this->successMessage, $grpc->$method($args));
    }

    public function methodProvider()
    {
        return [
            [
                'listDebuggees',
                ['project' => 'project1', 'agentVersion' => '1']
            ],
            [
                'registerDebuggee',
                ['debuggee' => []]
            ],
            [
                'listBreakpoints',
                ['debuggeeId' => 'debuggee1']
            ],
            [
                'updateBreakpoint',
                ['debuggeeId' => 'debuggee1', 'breakpoint' => []]
            ],
            [
                'setBreakpoint',
                ['debuggeeId' => 'debuggee1', 'breakpoint' => [], 'agentVersion' => '1']
            ]
        ];
    }
}
