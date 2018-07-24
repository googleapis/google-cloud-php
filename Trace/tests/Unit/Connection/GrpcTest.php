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

namespace Google\Cloud\Trace\Tests\Unit\Connection;

use Google\Cloud\Trace\Connection\Grpc;
use Google\Cloud\Trace\TraceClient;
use Google\Cloud\Trace\TimestampTrait;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\ApiCore\Serializer;
use Google\Cloud\Trace\V2\Span;
use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

/**
 * @group trace
 */
class GrpcTest extends TestCase
{
    use GrpcTestTrait;
    use TimestampTrait;

    private $requestWrapper;
    private $successMessage;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->requestWrapper = $this->prophesize(GrpcRequestWrapper::class);
        $this->successMessage = 'success';
    }

    /**
     * @dataProvider methodProvider
     * @group focus
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
        $spanDatum = [
            'spanId' => 'abcd',
            'displayName' => [
                'value' => '/'
            ],
            'startTime' => '2016-05-30T09:34:00.123000Z',
            'endTime' => '2016-05-30T09:34:00.123000Z'
        ];
        $spanData = [$spanDatum];
        $pbSpan = $serializer->decodeMessage(new Span(), [
            'spanId' => 'abcd',
            'displayName' => [
                'value' => '/'
            ],
            'startTime' => ['seconds' => 1464600840, 'nanos' => 123000000],
            'endTime' => ['seconds' => 1464600840, 'nanos' => 123000000]
        ]);
        $pbSpans = [$pbSpan];

        return [
            [
                'traceBatchWrite',
                ['projectsId' => 'my-project-id', 'spans' => $spanData],
                [
                    'projects/my-project-id',
                    $pbSpans,
                    []
                ]
            ],
            [
                'traceSpanCreate',
                ['projectsId' => 'my-project-id'] + $spanDatum,
                [
                    'projects/my-project-id',
                    'abcd',
                    ['value' => '/'],
                    ['seconds' => 1464600840, 'nanos' => 123000000],
                    ['seconds' => 1464600840, 'nanos' => 123000000],
                    []
                ]
            ]
        ];
    }
}
