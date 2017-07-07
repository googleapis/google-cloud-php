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

namespace Google\Cloud\Tests\Snippets\Logging;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Logging\Connection\ConnectionInterface;
use Google\Cloud\Logging\Logger;
use Google\Cloud\Logging\LoggingClient;
use Google\Cloud\Logging\Metric;
use Google\Cloud\Logging\PsrLogger;
use Google\Cloud\Logging\Sink;
use Google\Cloud\Core\Iterator\ItemIterator;
use Prophecy\Argument;

/**
 * @group logging
 */
class LoggingClientTest extends SnippetTestCase
{
    private $connection;
    private $client;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = \Google\Cloud\Dev\stub(LoggingClient::class);
        $this->client->___setProperty('connection', $this->connection->reveal());
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(LoggingClient::class);
        $res = $snippet->invoke('logging');

        $this->assertInstanceOf(LoggingClient::class, $res->returnVal());
    }

    public function testCreateSink()
    {
        $snippet = $this->snippetFromMethod(LoggingClient::class, 'createSink');
        $snippet->addLocal('logging', $this->client);

        $this->connection->createSink(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $res = $snippet->invoke('sink');
        $this->assertInstanceOf(Sink::class, $res->returnVal());
    }

    public function testSink()
    {
        $snippet = $this->snippetFromMethod(LoggingClient::class, 'sink');
        $snippet->addLocal('logging', $this->client);

        $res = $snippet->invoke();
        $this->assertEquals('my-sink', $res->output());
    }

    public function testSinks()
    {
        $snippet = $this->snippetFromMethod(LoggingClient::class, 'sinks');
        $snippet->addLocal('logging', $this->client);

        $this->connection->listSinks(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'sinks' => [
                    ['name' => 'Sink 1'],
                    ['name' => 'Sink 2'],
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('sinks');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals('Sink 1', explode(PHP_EOL, $res->output())[0]);
        $this->assertEquals('Sink 2', explode(PHP_EOL, $res->output())[1]);
    }

    public function testCreateMetric()
    {
        $snippet = $this->snippetFromMethod(LoggingClient::class, 'createMetric');
        $snippet->addLocal('logging', $this->client);

        $this->connection->createMetric(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('metric');
        $this->assertInstanceOf(Metric::class, $res->returnVal());
    }

    public function testMetric()
    {
        $snippet = $this->snippetFromMethod(LoggingClient::class, 'metric');
        $snippet->addLocal('logging', $this->client);

        $res = $snippet->invoke('metric');
        $this->assertInstanceOf(Metric::class, $res->returnVal());
    }

    public function testMetrics()
    {
        $snippet = $this->snippetFromMethod(LoggingClient::class, 'metrics');
        $snippet->addLocal('logging', $this->client);

        $this->connection->listMetrics(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'metrics' => [
                    ['name' => 'Metric 1'],
                    ['name' => 'Metric 2'],
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('metrics');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals('Metric 1', explode(PHP_EOL, $res->output())[0]);
        $this->assertEquals('Metric 2', explode(PHP_EOL, $res->output())[1]);
    }

    public function testEntries()
    {
        $snippet = $this->snippetFromMethod(LoggingClient::class, 'entries');
        $snippet->addLocal('logging', $this->client);

        $this->connection->listEntries(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'entries' => [
                    ['textPayload' => 'Entry 1'],
                    ['textPayload' => 'Entry 2'],
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('entries');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals('Entry 1', explode(PHP_EOL, $res->output())[0]);
        $this->assertEquals('Entry 2', explode(PHP_EOL, $res->output())[1]);
    }

    public function testEntriesWithFilter()
    {
        $snippet = $this->snippetFromMethod(LoggingClient::class, 'entries', 1);
        $snippet->addLocal('logging', $this->client);

        $this->connection->listEntries(Argument::that(function ($arg) {
            if (strpos($arg['filter'], 'logName') === false) return false;
            return true;
        }))
            ->shouldBeCalled()
            ->willReturn([
                'entries' => [
                    ['textPayload' => 'Entry 1'],
                    ['textPayload' => 'Entry 2'],
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('entries');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals('Entry 1', explode(PHP_EOL, $res->output())[0]);
        $this->assertEquals('Entry 2', explode(PHP_EOL, $res->output())[1]);
    }

    public function testPsrLogger()
    {
        $snippet = $this->snippetFromMethod(LoggingClient::class, 'psrLogger');
        $snippet->addLocal('logging', $this->client);

        $res = $snippet->invoke('psrLogger');
        $this->assertInstanceOf(PsrLogger::class, $res->returnVal());
    }

    public function testPsrBatchLogger()
    {
        $snippet = $this->snippetFromMethod(
            LoggingClient::class,
            'psrLogger',
            1
        );
        $snippet->addLocal('logging', $this->client);

        $res = $snippet->invoke('psrLogger');
        $this->assertInstanceOf(PsrLogger::class, $res->returnVal());
    }

    public function testLogger()
    {
        $snippet = $this->snippetFromMethod(LoggingClient::class, 'logger');
        $snippet->addLocal('logging', $this->client);

        $res = $snippet->invoke('logger');
        $this->assertInstanceOf(Logger::class, $res->returnVal());
    }
}
