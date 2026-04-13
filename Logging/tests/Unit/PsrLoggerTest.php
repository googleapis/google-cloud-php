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

namespace Google\Cloud\Logging\Tests\Unit;

use Google\Api\MonitoredResource;
use Google\Cloud\Core\Batch\OpisClosureSerializerV4;
use Google\Cloud\Core\Report\EmptyMetadataProvider;
use Google\Cloud\Logging\Logger;
use Google\Cloud\Logging\PsrLogger;
use Google\Cloud\Logging\Connection\Gapic;
use Google\Cloud\Logging\V2\Client\LoggingServiceV2Client;
use Google\Cloud\Logging\V2\LogEntry;
use Google\Cloud\Logging\V2\WriteLogEntriesRequest;
use Google\Cloud\Logging\V2\WriteLogEntriesResponse;
use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\MapField;
use Google\Protobuf\Struct;
use Google\Protobuf\Timestamp;
use Google\Protobuf\Value;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Log\InvalidArgumentException;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group logging
 */
class PsrLoggerTest extends TestCase
{
    use ProphecyTrait;

    public $connection;
    public $formattedName;
    public $logName = 'myLog';
    public $projectId = 'myProjectId';
    public $textPayload = 'aPayload';
    public $resource = ['type' => 'global'];
    public $severity = 'ALERT';

    public function setUp(): void
    {
        $this->formattedName = "projects/$this->projectId/logs/$this->logName";
        $this->connection = $this->prophesize(Gapic::class);
    }

    public function getPsrLogger($connection, ?array $resource = null, ?array $labels = null, $messageKey = 'message')
    {
        $logger = new Logger($connection, $this->logName, $this->projectId, $resource, $labels);
        return new PsrLogger($logger, $messageKey, ['metadataProvider' => new EmptyMetadataProvider()]);
    }

    /**
     * @dataProvider levelProvider
     */
    public function testWritesEntryWithDefinedLevels($level)
    {
        $this->connection->writeLogEntries([
            'entries' => [
                [
                    'severity' => array_flip(Logger::getLogLevelMap())[$level],
                    'jsonPayload' => ['message' => $this->textPayload],
                    'logName' => $this->formattedName,
                    'resource' => $this->resource,
                    'timestamp' => null
                ]
            ]
        ])
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $psrLogger = $this->getPsrLogger($this->connection->reveal());

        $this->assertNull(
            $psrLogger->$level($this->textPayload, [
                'stackdriverOptions' => ['timestamp' => null]
            ])
        );
    }

    /**
     * @dataProvider levelProvider
     */
    public function testWritesEntryRequestWithDefinedLevels($level)
    {
        $map = new MapField(GPBType::STRING, GPBType::MESSAGE, Value::class);
        $map['message'] = new Value(['string_value' => $this->textPayload]);
        $entry = new LogEntry([
            'severity' => array_flip(Logger::getLogLevelMap())[$level],
            'log_name' => $this->formattedName,
            'resource' => new MonitoredResource($this->resource),
            'timestamp' => new Timestamp(['seconds' => 100]),
            'json_payload' => new Struct(['fields' => $map])
        ]);
        $request = new WriteLogEntriesRequest(['entries' => [$entry]]);

        $loggingClient = $this->prophesize(LoggingServiceV2Client::class);
        $loggingClient->writeLogEntries($request, [])
            ->shouldBeCalledOnce()
            ->willReturn(new WriteLogEntriesResponse());

        $connection = new Gapic([
            'loggingGapicClient' => $loggingClient->reveal()
        ]);

        $psrLogger = $this->getPsrLogger($connection);

        $this->assertNull(
            $psrLogger->$level($this->textPayload, [
                'stackdriverOptions' => ['timestamp' => date('Y-m-d H:i:s', 100)]
            ])
        );
    }

    public function levelProvider()
    {
        return [
            ['EMERGENCY'],
            ['ALERT'],
            ['CRITICAL'],
            ['ERROR'],
            ['WARNING'],
            ['NOTICE'],
            ['INFO'],
            ['DEBUG']
        ];
    }

    public function testWritesEntry()
    {
        $this->connection->writeLogEntries([
            'entries' => [
                [
                    'severity' => $this->severity,
                    'jsonPayload' => ['message' => $this->textPayload],
                    'logName' => $this->formattedName,
                    'resource' => $this->resource,
                    'timestamp' => null
                ]
            ]
        ])
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $psrLogger = $this->getPsrLogger($this->connection->reveal());

        $this->assertNull(
            $psrLogger->log($this->severity, $this->textPayload, [
                'stackdriverOptions' => ['timestamp' => null]
            ])
        );
    }

    public function testPsrLoggerUsesDefaults()
    {
        $resource = ['type' => 'default'];
        $labels = ['testing' => 'labels'];
        $this->connection->writeLogEntries([
            'entries' => [
                [
                    'severity' => $this->severity,
                    'jsonPayload' => ['message' => $this->textPayload],
                    'logName' => $this->formattedName,
                    'resource' => $resource,
                    'labels' => $labels,
                    'timestamp' => null
                ]
            ]
        ])
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $psrLogger = $this->getPsrLogger($this->connection->reveal(), $resource, $labels);

        $this->assertNull(
            $psrLogger->log($this->severity, $this->textPayload, [
                'stackdriverOptions' => ['timestamp' => null]
            ])
        );
    }

    public function testOverridePsrLoggerDefaults()
    {
        $newResource = ['type' => 'new'];
        $defaultLabels = ['testing' => 'labels'];
        $newLabels = ['new' => 'labels'];
        $this->connection->writeLogEntries([
            'entries' => [
                [
                    'severity' => $this->severity,
                    'jsonPayload' => ['message' => $this->textPayload],
                    'logName' => $this->formattedName,
                    'resource' => $newResource,
                    'labels' => $newLabels,
                    'timestamp' => null
                ]
            ]
        ])
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $psrLogger = $this->getPsrLogger($this->connection->reveal(), null, $defaultLabels);

        $this->assertNull(
            $psrLogger->log($this->severity, $this->textPayload, [
                'stackdriverOptions' => [
                    'resource' => $newResource,
                    'labels' => $newLabels,
                    'timestamp' => null
                ]
            ])
        );
    }

    public function testLogThrowsExceptionWithInvalidLevel()
    {
        $this->expectException(InvalidArgumentException::class);

        $psrLogger = $this->getPsrLogger($this->connection->reveal());
        $psrLogger->log('INVALID-LEVEL', $this->textPayload);
    }

    public function testLogAppendsExceptionWhenPassedThroughAsContext()
    {
        $this->expectLogWithExceptionInContext(new \Exception('test'));
    }

    public function testLogAppendsThrowableWhenPassedThroughAsContext()
    {
        if (!is_subclass_of('Error', 'Throwable')) {
            $this->markTestSkipped('This test requires PHP 7+');
        }

        $this->expectLogWithExceptionInContext(new \Error('test'));
    }

    public function testUsesCustomMessageKey()
    {
        $customKey = 'customKey';
        $this->connection->writeLogEntries([
            'entries' => [
                [
                    'severity' => $this->severity,
                    'jsonPayload' => [$customKey => $this->textPayload],
                    'logName' => $this->formattedName,
                    'resource' => $this->resource,
                    'timestamp' => null
                ]
            ]
        ])
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $psrLogger = $this->getPsrLogger($this->connection->reveal(), null, null, $customKey);
        $psrLogger->log($this->severity, $this->textPayload, [
            'stackdriverOptions' => ['timestamp' => null]
        ]);
    }

    public function testSerializesCorrectly()
    {
        $expectedDebugResource = fopen('php://temp', 'wb');
        $options = [
            'metadataProvider' => new EmptyMetadataProvider,
            'batchEnabled' => true,
            'debugOutput' => true,
            'clientConfig' => [
                'projectId' => 'test'
            ],
            'debugOutputResource' => $expectedDebugResource
        ];
        $logger = $this->prophesize(Logger::class);
        $logger->name()->willReturn($this->logName);
        $psrLogger = new PsrLogger(
            $logger->reveal(),
            null,
            $options
        );
        $options['messageKey'] = 'message';
        $options['batchMethod'] = 'writeBatch';
        $options['logName'] = $this->logName;
        $psrLogger = unserialize(serialize($psrLogger));
        $reflection = new \ReflectionClass($psrLogger);
        $debugOutpoutResourceAttr = $reflection->getProperty('debugOutputResource');
        $debugResourceMetadata = stream_get_meta_data(
            $debugOutpoutResourceAttr->getValue($psrLogger)
        );
        $expectedDebugResourceMetadata = stream_get_meta_data($expectedDebugResource);

        $this->assertEquals($debugResourceMetadata['uri'], $expectedDebugResourceMetadata['uri']);
        $this->assertEquals($debugResourceMetadata['mode'], $expectedDebugResourceMetadata['mode']);
        $attributes = [
            'metadataProvider',
            'batchEnabled',
            'debugOutput',
            'clientConfig',
            'messageKey' ,
            'batchMethod',
            'logName'
        ];
        foreach ($attributes as $attributeName) {
            $attr = $reflection->getProperty($attributeName);
            $this->assertEquals(
                $attr->getValue($psrLogger),
                $attributeName === 'clientConfig'&& class_exists(OpisClosureSerializerV4::class)
                    ? serialize($options[$attributeName])
                    : $options[$attributeName]
            );
        }
    }

    private function expectLogWithExceptionInContext($throwable)
    {
        $this->connection->writeLogEntries([
            'entries' => [
                [
                    'severity' => $this->severity,
                    'jsonPayload' => [
                        'message' => $this->textPayload,
                        'exception' => (string) $throwable
                    ],
                    'logName' => $this->formattedName,
                    'resource' => $this->resource,
                    'timestamp' => null
                ]
            ]
        ])
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $psrLogger = $this->getPsrLogger($this->connection->reveal());
        $psrLogger->log($this->severity, $this->textPayload, [
            'exception' => $throwable,
            'stackdriverOptions' => ['timestamp' => null]
        ]);
    }
}
