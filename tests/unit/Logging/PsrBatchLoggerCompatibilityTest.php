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

use Google\Cloud\Logging\Logger;
use Google\Cloud\Logging\PsrBatchLogger;
use Google\Cloud\Core\Batch\BatchRunner;
use Psr\Log\Test\LoggerInterfaceTest;
use Prophecy\Argument;

/**
 * @group logging
 */
class PsrBatchLoggerCompatibilityTest extends LoggerInterfaceTest
{
    public static $logs = [];

    public function setUp()
    {
        self::$logs = [];
    }

    public function getLogger()
    {
        $runner = $this->prophesize(BatchRunner::class);
        $runner->registerJob(Argument::any(), Argument::any(), Argument::any())
            ->will(function () {});
        $runner->submitItem('stackdriver-logging-my-log', Argument::any())
            ->will(function ($array) {
                $entry = $array[1]->info();
                $map = Logger::getLogLevelMap();
                $severity = is_int($entry['severity'])
                    ? strtolower($map[$entry['severity']])
                    : $entry['severity'];

                self::$logs[] = sprintf('%s %s',
                    $severity,
                    $entry['jsonPayload']['message']
                );
            });
        return new PsrBatchLogger(
            'my-log',
            [
                'batchRunner' => $runner->reveal()
            ]
        );
    }

    public function getLogs()
    {
        return self::$logs;
    }
}
