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
use Google\Cloud\Logging\Entry;
use Google\Cloud\Logging\Logger;
use Google\Cloud\Logging\LoggingClient;
use Google\Cloud\Logging\PsrBatchLogger;
use GuzzleHttp\Psr7\Response;
use Prophecy\Argument;

/**
 * @group logging
 */
class PsrBatchLoggerTest extends \PHPUnit_Framework_TestCase
{
    private $runner;

    private static $logName;
    private static $entry;

    public function setUp()
    {
        $this->runner = $this->prophesize(BatchRunner::class);
    }

    /**
     * @dataProvider optionProvider
     */
    public function testSendEntries(
        $logName,
        $options,
        $expectedOutput
    ) {
        $logger = $this->prophesize(Logger::class);
        $logger->writeBatch(Argument::any())
            ->willReturn(true)
            ->shouldBeCalledTimes(1);
        $psrBatchLogger = new PsrBatchLogger($logName, $options);
        $class =
            new \ReflectionClass('\\Google\\Cloud\\Logging\\PsrBatchLogger');
        $prop = $class->getProperty('loggers');
        $prop->setAccessible(true);
        $prop = $prop->setValue([$logName => $logger->reveal()]);
        ob_start();
        $psrBatchLogger->sendEntries([new Entry()]);
        $output = ob_get_contents();
        ob_end_clean();
        if ($expectedOutput === false) {
            $this->assertEmpty($output);
        } else {
            $this->assertContains($expectedOutput, $output);
        }
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
        $psrBatchLogger = new PsrBatchLogger(
            'my-log',
            ['batchRunner' => $this->runner->reveal()]
        );
        $psrBatchLogger->$level('test log');
        $this->assertEquals('stackdriver-logging-my-log', self::$logName);
        $info = self::$entry->info();
        $this->assertEquals(
            array_flip(Logger::getLogLevelMap())[$level],
            $info['severity']
        );
    }

    public function optionProvider()
    {
        return [
            [
                'log1',
                ['debugOutput' => true],
                'seconds for writeBatch',
            ],
            [
                'log2',
                ['debugOutput' => false],
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
