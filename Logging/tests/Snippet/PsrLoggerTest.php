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

namespace Google\Cloud\Logging\Tests\Snippet;

use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Logging\Connection\ConnectionInterface;
use Google\Cloud\Logging\Logger;
use Google\Cloud\Logging\PsrLogger;
use Prophecy\Argument;

/**
 * @group logging
 */
class PsrLoggerTest extends SnippetTestCase
{
    private $connection;
    private $psr;

    public function set_up()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);

        $this->psr = TestHelpers::stub(PsrLogger::class, [
            $this->refreshLogger($this->connection->reveal())
        ], ['logger']);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(PsrLogger::class);
        $res = $snippet->invoke('psrLogger');
        $this->assertInstanceOf(PsrLogger::class, $res->returnVal());
    }

    public function testClassBatch()
    {
        $snippet = $this->snippetFromClass(PsrLogger::class, 1);
        $res = $snippet->invoke('psrLogger');
        $this->assertInstanceOf(PsrLogger::class, $res->returnVal());
    }

    public function testEmergency()
    {
        $snippet = $this->snippetFromMethod(PsrLogger::class, 'emergency');
        $snippet->addLocal('psrLogger', $this->psr);

        $this->connection->writeEntries(Argument::that(function ($args) {
            return $args['entries'][0]['severity'] === Logger::EMERGENCY;
        }))->shouldBeCalled();

        $this->psr->___setProperty(
            'logger',
            $this->refreshLogger($this->connection->reveal())
        );

        $snippet->invoke();
    }

    public function testAlert()
    {
        $snippet = $this->snippetFromMethod(PsrLogger::class, 'alert');
        $snippet->addLocal('psrLogger', $this->psr);

        $this->connection->writeEntries(Argument::that(function ($args) {
            return $args['entries'][0]['severity'] === Logger::ALERT;
        }))->shouldBeCalled();

        $this->psr->___setProperty(
            'logger',
            $this->refreshLogger($this->connection->reveal())
        );

        $snippet->invoke();
    }

    public function testCritical()
    {
        $snippet = $this->snippetFromMethod(PsrLogger::class, 'critical');
        $snippet->addLocal('psrLogger', $this->psr);

        $this->connection->writeEntries(Argument::that(function ($args) {
            return $args['entries'][0]['severity'] === Logger::CRITICAL;
        }))->shouldBeCalled();

        $this->psr->___setProperty(
            'logger',
            $this->refreshLogger($this->connection->reveal())
        );

        $snippet->invoke();
    }

    public function testError()
    {
        $snippet = $this->snippetFromMethod(PsrLogger::class, 'error');
        $snippet->addLocal('psrLogger', $this->psr);

        $this->connection->writeEntries(Argument::that(function ($args) {
            return $args['entries'][0]['severity'] === Logger::ERROR;
        }))->shouldBeCalled();

        $this->psr->___setProperty(
            'logger',
            $this->refreshLogger($this->connection->reveal())
        );

        $snippet->invoke();
    }

    public function testWarning()
    {
        $snippet = $this->snippetFromMethod(PsrLogger::class, 'warning');
        $snippet->addLocal('psrLogger', $this->psr);

        $this->connection->writeEntries(Argument::that(function ($args) {
            return $args['entries'][0]['severity'] === Logger::WARNING;
        }))->shouldBeCalled();

        $this->psr->___setProperty(
            'logger',
            $this->refreshLogger($this->connection->reveal())
        );

        $snippet->invoke();
    }

    public function testNotice()
    {
        $snippet = $this->snippetFromMethod(PsrLogger::class, 'notice');
        $snippet->addLocal('psrLogger', $this->psr);

        $this->connection->writeEntries(Argument::that(function ($args) {
            return $args['entries'][0]['severity'] === Logger::NOTICE;
        }))->shouldBeCalled();

        $this->psr->___setProperty(
            'logger',
            $this->refreshLogger($this->connection->reveal())
        );

        $snippet->invoke();
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(PsrLogger::class, 'info');
        $snippet->addLocal('psrLogger', $this->psr);

        $this->connection->writeEntries(Argument::that(function ($args) {
            return $args['entries'][0]['severity'] === Logger::INFO;
        }))->shouldBeCalled();

        $this->psr->___setProperty(
            'logger',
            $this->refreshLogger($this->connection->reveal())
        );

        $snippet->invoke();
    }

    public function testDebug()
    {
        $snippet = $this->snippetFromMethod(PsrLogger::class, 'debug');
        $snippet->addLocal('psrLogger', $this->psr);

        $this->connection->writeEntries(Argument::that(function ($args) {
            return $args['entries'][0]['severity'] === Logger::DEBUG;
        }))->shouldBeCalled();

        $this->psr->___setProperty(
            'logger',
            $this->refreshLogger($this->connection->reveal())
        );

        $snippet->invoke();
    }

    public function testLog()
    {
        $snippet = $this->snippetFromMethod(PsrLogger::class, 'log');
        $snippet->addLocal('psrLogger', $this->psr);

        $this->connection->writeEntries(Argument::that(function ($args) {
            return $args['entries'][0]['severity'] === Logger::ALERT;
        }))->shouldBeCalled();

        $this->psr->___setProperty(
            'logger',
            $this->refreshLogger($this->connection->reveal())
        );

        $snippet->invoke();
    }

    public function testLogPlaceholder()
    {
        $snippet = $this->snippetFromMethod(PsrLogger::class, 'log', 1);
        $snippet->addLocal('psrLogger', $this->psr);

        $this->connection->writeEntries(Argument::that(function ($args) {
            if ($args['entries'][0]['severity'] !== Logger::ALERT) {
                return false;
            }

            if ($args['entries'][0]['jsonPayload']['message'] !== 'alert: my alert message') {
                return false;
            }

            return true;
        }))->shouldBeCalled();

        $this->psr->___setProperty(
            'logger',
            $this->refreshLogger($this->connection->reveal())
        );

        $snippet->invoke();
    }

    public function testLogStackdriver()
    {
        $snippet = $this->snippetFromMethod(PsrLogger::class, 'log', 2);
        $snippet->addLocal('psrLogger', $this->psr);

        $this->connection->writeEntries(Argument::that(function ($args) {
            if ($args['entries'][0]['severity'] !== Logger::ALERT) {
                return false;
            }

            if ($args['entries'][0]['httpRequest']['requestMethod'] !== 'GET') {
                return false;
            }

            return true;
        }))->shouldBeCalled();

        $this->psr->___setProperty(
            'logger',
            $this->refreshLogger($this->connection->reveal())
        );

        $snippet->invoke();
    }

    private function refreshLogger(ConnectionInterface $connection)
    {
        return new Logger(
            $connection,
            'my-log',
            'my-awesome-project'
        );
    }
}
