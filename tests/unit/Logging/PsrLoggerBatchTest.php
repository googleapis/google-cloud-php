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

namespace Google\Cloud\Tests\Unit\Logging;

use Google\Cloud\Core\Batch\BatchRunner;
use Google\Cloud\Core\Report\GAEFlexMetadataProvider;
use Google\Cloud\Logging\Connection\Rest;
use Google\Cloud\Logging\Entry;
use Google\Cloud\Logging\Logger;
use Google\Cloud\Logging\LoggingClient;
use Google\Cloud\Logging\PsrLogger;
use GuzzleHttp\Psr7\Response;
use Prophecy\Argument;

/**
 * @group logging
 */
class PsrLoggerBatchTest extends \PHPUnit_Framework_TestCase
{
    const LOG_NAME = 'my-log';

    private $runner;
    private $logger;

    private static $logName;
    private static $entry;

    public function setUp()
    {
        $this->runner = $this->prophesize(BatchRunner::class);
        $this->logger = $this->prophesize(Logger::class);
    }

    /**
     * @dataProvider optionProvider
     */
    public function testSend(
        $logName,
        $options,
        $expectedOutput
    ) {
        $this->logger->writeBatch(Argument::any())
            ->willReturn(true)
            ->shouldBeCalledTimes(1);
        $this->logger->name()
            ->willReturn($logName)
            ->shouldBeCalledTimes(2);
        $logger = $this->logger->reveal();
        $temp = fopen('php://temp', 'rw');
        $psrBatchLogger = new PsrLogger(
            $logger,
            null,
            $options + ['debugOutputResource' => $temp]
        );
        $class =
            new \ReflectionClass('\\Google\\Cloud\\Logging\\PsrLogger');
        $prop = $class->getProperty('loggers');
        $prop->setAccessible(true);
        $prop = $prop->setValue([$logName => $logger]);
        $psrBatchLogger->send([new Entry()]);
        rewind($temp);
        $output = stream_get_contents($temp);

        if ($expectedOutput === false) {
            $this->assertEmpty($output);
        } else {
            $this->assertContains($expectedOutput, $output);
        }
    }

    /**
     * @dataProvider traceIdProvider
     */
    public function testTraceIdLabelOnGAEFlex(
        $traceId,
        $labels,
        $expectedLabels
    ) {
        if (empty($traceId)) {
            $server = [];
            unset($_SERVER['HTTP_X_CLOUD_TRACE_CONTEXT']);
        } else {
            $server = ['HTTP_X_CLOUD_TRACE_CONTEXT' => $traceId];
        }
        $this->runner->submitItem(
            'stackdriver-logging-my-log', Argument::any()
        )
            ->will(function($args) {
                self::$logName = $args[0];
                self::$entry = $args[1];
            })
            ->shouldBeCalledTimes(1);
        $this->runner->registerJob(
            Argument::any(), Argument::any(), Argument::any()
        )->willReturn(true);
        $logger = new Logger(
            $this->prophesize(Rest::class)->reveal(),
            self::LOG_NAME,
            'my-project'
        );
        $psrBatchLogger = new PsrLogger(
            $logger,
            null,
            [
                'batchEnabled' => true,
                'batchRunner' => $this->runner->reveal(),
                'metadataProvider' => new GaeFlexMetadataProvider($server)
            ]
        );
        $psrBatchLogger->info(
            'test log',
            ['stackdriverOptions' => ['labels' => $labels]]
        );
        $this->assertEquals('stackdriver-logging-my-log', self::$logName);
        $info = self::$entry->info();
        $this->assertEquals($expectedLabels, $info['labels']);
    }

    /**
     * @dataProvider levelProvider
     */
    public function testWritesEntryWithLevels($level)
    {
        $this->runner->submitItem(
            'stackdriver-logging-my-log', Argument::any()
        )
            ->will(function($args) {
                self::$logName = $args[0];
                self::$entry = $args[1];
            })
            ->shouldBeCalledTimes(1);
        $this->runner->registerJob(
            Argument::any(), Argument::any(), Argument::any()
        )->willReturn(true);
        $logger = new Logger(
            $this->prophesize(Rest::class)->reveal(),
            self::LOG_NAME,
            'my-project'
        );
        $psrBatchLogger = new PsrLogger(
            $logger,
            null,
            [
                'batchEnabled' => true,
                'batchRunner' => $this->runner->reveal()
            ]
        );
        $psrBatchLogger->$level('test log');
        $this->assertEquals('stackdriver-logging-my-log', self::$logName);
        $info = self::$entry->info();
        $this->assertEquals(
            array_flip(Logger::getLogLevelMap())[$level],
            $info['severity']
        );
    }

    public function traceIdProvider()
    {
        return [
            [
                '',
                [],
                [],
            ],
            [
                str_repeat('x', 32),
                [],
                ['appengine.googleapis.com/trace_id' => str_repeat('x', 32)]
            ],
            [
                str_repeat('x', 32),
                ['myKey' => 'myVal'],
                [
                    'appengine.googleapis.com/trace_id' => str_repeat('x', 32),
                    'myKey' => 'myVal'
                ]
            ],
        ];
    }

    public function optionProvider()
    {
        return [
            [
                'log1',
                [
                    'batchEnabled' => true,
                    'debugOutput' => true
                ],
                'seconds for writeBatch',
            ],
            [
                'log2',
                [
                    'batchEnabled' => true,
                    'debugOutput' => false
                ],
                false,
            ],
        ];
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

}
