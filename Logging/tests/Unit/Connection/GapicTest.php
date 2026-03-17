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

use Google\ApiCore\Page;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Logging\Connection\Grpc;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\ApiCore\Serializer;
use Google\Cloud\Logging\Connection\Gapic;
use Google\Cloud\Logging\V2\Client\ConfigServiceV2Client;
use Google\Cloud\Logging\V2\Client\LoggingServiceV2Client;
use Google\Cloud\Logging\V2\Client\MetricsServiceV2Client;
use Google\Cloud\Logging\V2\CreateLogMetricRequest;
use Google\Cloud\Logging\V2\CreateSinkRequest;
use Google\Cloud\Logging\V2\DeleteLogMetricRequest;
use Google\Cloud\Logging\V2\DeleteLogRequest;
use Google\Cloud\Logging\V2\DeleteSinkRequest;
use Google\Cloud\Logging\V2\GetLogMetricRequest;
use Google\Cloud\Logging\V2\GetSinkRequest;
use Google\Cloud\Logging\V2\ListLogEntriesRequest;
use Google\Cloud\Logging\V2\ListLogEntriesResponse;
use Google\Cloud\Logging\V2\ListLogMetricsRequest;
use Google\Cloud\Logging\V2\ListSinksRequest;
use Google\Cloud\Logging\V2\LogEntry;
use Google\Cloud\Logging\V2\LogMetric;
use Google\Cloud\Logging\V2\LogSink;
use Google\Cloud\Logging\V2\UpdateLogMetricRequest;
use Google\Cloud\Logging\V2\UpdateSinkRequest;
use Google\Cloud\Logging\V2\WriteLogEntriesRequest;
use Google\Cloud\Logging\V2\WriteLogEntriesResponse;
use Google\Protobuf\Internal\Message;
use Google\Protobuf\RepeatedField;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group logging
 */
class GapicTest extends TestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;

    private $loggingGapicClient;
    private $metricsGapicClient;
    private $configGapicClient;

    public function setUp(): void
    {
        $this->loggingGapicClient = $this->prophesize(LoggingServiceV2Client::class);
        $this->metricsGapicClient = $this->prophesize(MetricsServiceV2Client::class);
        $this->configGapicClient = $this->prophesize(ConfigServiceV2Client::class);
    }

    /**
     * @dataProvider methodProvider
     */
    public function testCallBasicMethods(
        string $method,
        array $args,
        string $client,
        Message $expectedRequest,
        $mockResponse
    ) {
        $mockMethod = $this->$client->$method(
            $expectedRequest,
            Argument::type('array')
        )->shouldBeCalledOnce();

        if (null !== $mockResponse) {
            $mockMethod->willReturn($mockResponse);
        }

        $connection = new Gapic([$client => $this->$client->reveal()]);

        $connection->$method($args);
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
        ];
        $metricData = [
            'name' => $value,
            'description' => $value,
            'filter' => $value
        ];

        $serializer = new Serializer();
        $pbEntry = $serializer->decodeMessage(new LogEntry(), $entryData);
        $pbSink = $serializer->decodeMessage(new LogSink(), $sinkData);
        $pbMetric = $serializer->decodeMessage(new LogMetric(), $metricData);
        $resourceNames = ['projects/id'];

        $pagedListResponse = $this->prophesize(PagedListResponse::class);
        $pagedListResponse->getPage()
            ->willReturn($this->prophesize(Page::class)->reveal());

        return [
            [
                'writeLogEntries',
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
                'loggingGapicClient',
                new WriteLogEntriesRequest(['entries' => [$pbEntry]]),
                new WriteLogEntriesResponse(),
            ],
            [
                'listLogEntries',
                ['resourceNames' => $resourceNames],
                'loggingGapicClient',
                new ListLogEntriesRequest(['resource_names' => $resourceNames]),
                $pagedListResponse->reveal(),
            ],
            [
                'createSink',
                ['parent' => $value] + $sinkData,
                'configGapicClient',
                new CreateSinkRequest(['parent' => $value, 'sink' => $pbSink]),
                $pbSink,
            ],
            [
                'getSink',
                ['sinkName' => $value],
                'configGapicClient',
                new GetSinkRequest(['sink_name' => $value]),
                $pbSink
            ],
            [
                'listSinks',
                ['parent' => $value, 'pageSize' => 2],
                'configGapicClient',
                new ListSinksRequest(['parent' => $value, 'page_size' => 2]),
                $pagedListResponse->reveal(),
            ],
            [
                'updateSink',
                ['sinkName' => $value] + $sinkData,
                'configGapicClient',
                new UpdateSinkRequest(['sink_name' => $value, 'sink' => $pbSink]),
                $pbSink,
            ],
            [
                'deleteSink',
                ['sinkName' => $value],
                'configGapicClient',
                new DeleteSinkRequest(['sink_name' => $value]),
                null,
            ],
            [
                'createLogMetric',
                ['parent' => $value] + $metricData,
                'metricsGapicClient',
                new CreateLogMetricRequest(['parent' => $value, 'metric' => $pbMetric]),
                $pbMetric,
            ],
            [
                'getLogMetric',
                ['metricName' => $value],
                'metricsGapicClient',
                new GetLogMetricRequest(['metric_name' => $value]),
                $pbMetric,
            ],
            [
                'listLogMetrics',
                ['parent' => $value, 'pageSize' => 2],
                'metricsGapicClient',
                new ListLogMetricsRequest(['parent' => $value, 'page_size' => 2]),
                $pagedListResponse->reveal(),
            ],
            [
                'updateLogMetric',
                ['metricName' => $value] + $metricData,
                'metricsGapicClient',
                new UpdateLogMetricRequest(['metric_name' => $value, 'metric' => $pbMetric]),
                $pbMetric,
            ],
            [
                'deleteLogMetric',
                ['metricName' => $value],
                'metricsGapicClient',
                new DeleteLogMetricRequest(['metric_name' => $value]),
                null,
            ],
            [
                'deleteLog',
                ['logName' => $value],
                'loggingGapicClient',
                new DeleteLogRequest(['log_name' => $value]),
                null,
            ]
        ];
    }
}
