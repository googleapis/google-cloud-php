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

use Google\Cloud\Logging\Connection\ConnectionInterface;
use Google\Cloud\Logging\Logger;
use Google\Cloud\Logging\PsrLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\Test\LoggerInterfaceTest;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

// phpcs:disable
if (!class_exists(LoggerInterfaceTest::class)) {
    // We have to do this because fig/log-test does not support PHP 7.3 and below,
    // but is required when using psr/log v2 (PHP 8.0 and above).
    // This means that we cannot add that dependency to require-dev in the root
    // composer.json file. As a result, these tests are skipped on PHP 8.0 and above.
    return;
}
// phpcs:enable

/**
 * @group logging
 */
class PsrLoggerCompatibilityTest extends LoggerInterfaceTest
{
    use ProphecyTrait;

    public static $logs = [];

    public function getLogger()
    {
        self::$logs = [];
        $connection = $this->prophesize(ConnectionInterface::class);
        $connection->writeEntries(Argument::any())
            ->will(function ($entries) {
                $map = Logger::getLogLevelMap();
                $entry = $entries[0]['entries'][0];
                $severity = is_int($entry['severity'])
                    ? strtolower($map[$entry['severity']])
                    : $entry['severity'];

                self::$logs[] = sprintf(
                    '%s %s',
                    $severity,
                    $entry['jsonPayload']['message']
                );
            });

        $logger = new Logger($connection->reveal(), 'my-log', 'projectId');

        return new PsrLogger($logger);
    }

    public function testThrowsOnInvalidLevel()
    {
        $this->expectException(InvalidArgumentException::class);

        $logger = $this->getLogger();
        $logger->log('invalid level', 'Foo');
    }

    public function getLogs()
    {
        return self::$logs;
    }
}
