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

namespace Google\Cloud\Tests\Unit\Logging\Connection;

use Google\Cloud\Logging\Connection\Grpc;
use Google\Cloud\Tests\GrpcTestTrait;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\GAX\Serializer;
use Google\Logging\V2\LogEntry;
use Google\Logging\V2\LogMetric;
use Google\Logging\V2\LogSink;
use Prophecy\Argument;

/**
 * @group logging
 */
class GrpcTest extends \PHPUnit_Framework_TestCase
{
    use GrpcTestTrait;

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

        $value = 'value';
        $entryData = [
            'logName' => $value,
            'resource' => [
                'type' => $value,
                'labels' => [
                    $value => $value,
                ]
            ],
            'jsonPayload' => [
                'fields' => [
                    $value => ['stringValue' => $value]
                ],
            ],
            'labels' => [
                $value => $value,
            ]
        ];
        $sinkData = [
            'name' => $value,
            'destination' => $value,
            'filter' => $value,
            'outputVersionFormat' => 'V2'
        ];
        $metricData = [
            'name' => $value,
            'description' => $value,
            'filter' => $value
        ];
        $serializer = new Serializer();
        $pbEntry = $serializer->decodeMessage(new LogEntry(), $entryData);
        $pbSink = $serializer->decodeMessage(new LogSink(), ['outputVersionFormat' => 1] + $sinkData);
        $pbMetric = $serializer->decodeMessage(new LogMetric(), $metricData);
        $resourceNames = ['projects/id'];
        $pageSizeSetting = ['pageSize' => 2];

        return [
            [
                'writeEntries',
                [
                    'entries' => [
                        [
                            'logName' => $value,
                            'resource' => [
                                'type' => $value,
                                'labels' => [
                                    $value => $value
                                ]
                            ],
                            'jsonPayload' => [
                                $value => $value
                            ],
                            'labels' => [
                                $value => $value
                            ]
                        ]
                    ]
                ],
                [[$pbEntry], []]
            ],
            [
                'listEntries',
                ['resourceNames' => $resourceNames],
                [$resourceNames, []]
            ],
            [
                'createSink',
                ['parent' => $value] + $sinkData,
                [$value, $pbSink, []]
            ],
            [
                'getSink',
                ['sinkName' => $value],
                [$value, []]
            ],
            [
                'listSinks',
                ['parent' => $value] + $pageSizeSetting,
                [$value, $pageSizeSetting]
            ],
            [
                'updateSink',
                ['sinkName' => $value] + $sinkData,
                [$value, $pbSink, []]
            ],
            [
                'deleteSink',
                ['sinkName' => $value],
                [$value, []]
            ],
            [
                'createMetric',
                ['parent' => $value] + $metricData,
                [$value, $pbMetric, []]
            ],
            [
                'getMetric',
                ['metricName' => $value],
                [$value, []]
            ],
            [
                'listMetrics',
                ['parent' => $value] + $pageSizeSetting,
                [$value, $pageSizeSetting]
            ],
            [
                'updateMetric',
                ['metricName' => $value] + $metricData,
                [$value, $pbMetric, []]
            ],
            [
                'deleteMetric',
                ['metricName' => $value],
                [$value, []]
            ],
            [
                'deleteLog',
                ['logName' => $value],
                [$value, []]
            ]
        ];
    }
}
