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

namespace Google\Cloud\Logging\Tests\Unit\Connection;

use Google\Cloud\Logging\Connection\Grpc;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\ApiCore\Serializer;
use Google\Cloud\Logging\V2\LogEntry;
use Google\Cloud\Logging\V2\LogMetric;
use Google\Cloud\Logging\V2\LogSink;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group logging
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
            ],
            'httpRequest' => [
                'latency' => ['seconds' => 1, 'nanos' => 0]
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
                            ],
                            'httpRequest' => [
                                'latency' => '1.0s'
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
