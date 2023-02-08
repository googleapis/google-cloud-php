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

use Google\Cloud\Core\Report\EmptyMetadataProvider;
use Google\Cloud\Logging\Logger;
use Google\Cloud\Logging\PsrLogger;
use Google\Cloud\Logging\Connection\ConnectionInterface;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group logging
 */
class PsrLoggerTest extends TestCase
{
    use ExpectException;

    public $connection;
    public $formattedName;
    public $logName = 'myLog';
    public $projectId = 'myProjectId';
    public $textPayload = 'aPayload';
    public $resource = ['type' => 'global'];
    public $severity = 'ALERT';

    public function set_up()
    {
        $this->formattedName = "projects/$this->projectId/logs/$this->logName";
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function getPsrLogger($connection, array $resource = null, array $labels = null, $messageKey = 'message')
    {
        $logger = new Logger($connection->reveal(), $this->logName, $this->projectId, $resource, $labels);
        return new PsrLogger($logger, $messageKey, ['metadataProvider' => new EmptyMetadataProvider()]);
    }

    /**
     * @dataProvider levelProvider
     */
    public function testWritesEntryWithDefinedLevels($level)
    {
        $this->connection->writeEntries([
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
        $psrLogger = $this->getPsrLogger($this->connection);

        $this->assertNull(
            $psrLogger->$level($this->textPayload, [
                'stackdriverOptions' => ['timestamp' => null]
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
        $this->connection->writeEntries([
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
        $psrLogger = $this->getPsrLogger($this->connection);

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
        $this->connection->writeEntries([
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
        $psrLogger = $this->getPsrLogger($this->connection, $resource, $labels);

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
        $this->connection->writeEntries([
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
        $psrLogger = $this->getPsrLogger($this->connection, null, $defaultLabels);

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
        $this->expectException('Psr\Log\InvalidArgumentException');

        $psrLogger = $this->getPsrLogger($this->connection);
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
        $this->connection->writeEntries([
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
        $psrLogger = $this->getPsrLogger($this->connection, null, null, $customKey);
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
        $debugOutpoutResourceAttr->setAccessible(true);
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
            $attr->setAccessible(true);
            $this->assertEquals(
                $attr->getValue($psrLogger),
                $options[$attributeName]
            );
        }
    }

    private function expectLogWithExceptionInContext($throwable)
    {
        $this->connection->writeEntries([
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
        $psrLogger = $this->getPsrLogger($this->connection);
        $psrLogger->log($this->severity, $this->textPayload, [
            'exception' => $throwable,
            'stackdriverOptions' => ['timestamp' => null]
        ]);
    }
}
