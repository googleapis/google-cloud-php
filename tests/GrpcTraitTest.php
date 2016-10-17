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

namespace Google\Cloud\Tests;

use Google\Cloud\GrpcRequestWrapper;
use Google\Cloud\GrpcTrait;
use Prophecy\Argument;

/**
 * @group root
 */
class GrpcTraitTest extends \PHPUnit_Framework_TestCase
{
    private $implementation;
    private $requestWrapper;

    public function setUp()
    {
        if (!extension_loaded('grpc')) {
            $this->markTestSkipped('Must have the grpc extension installed to run this test.');
        }

        $this->implementation = $this->getObjectForTrait(GrpcTrait::class);
        $this->requestWrapper = $this->prophesize(GrpcRequestWrapper::class);
    }

    public function testSendsRequest()
    {
        $grpcOptions = [
            'timeoutMs' => 100
        ];
        $message = ['successful' => 'message'];
        $this->requestWrapper->send(
            Argument::type('callable'),
            Argument::type('array'),
            ['grpcOptions' => $grpcOptions]
        )->willReturn($message);

        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());
        $actualResponse = $this->implementation->send(function () {
            return true;
        }, [['grpcOptions' => $grpcOptions]]);

        $this->assertEquals($message, $actualResponse);
    }

    public function testPluck()
    {
        $value = '123';
        $key = 'key';
        $array = [$key => $value];
        $actualValue = $this->implementation->pluck($key, $array);

        $this->assertEquals($value, $actualValue);
        $this->assertEquals([], $array);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPluckThrowsExceptionWithInvalidKey()
    {
        $array = [];
        $actualValue = $this->implementation->pluck('not_here', $array);
    }
}
