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
use Google\Cloud\Logging\Entry;
use Google\Cloud\Logging\Logger;
use Google\Cloud\Core\Iterator\ItemIterator;
use Prophecy\Argument;

/**
 * @group logging
 */
class LoggerTest extends SnippetTestCase
{
    const NAME = 'myLogger';
    const PROJECT = 'my-awesome-project';

    private $connection;
    private $logger;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->logger = \Google\Cloud\Dev\stub(Logger::class, [
            $this->connection->reveal(),
            self::NAME,
            self::PROJECT
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Logger::class);
        $res = $snippet->invoke('logger');

        $this->assertInstanceOf(Logger::class, $res->returnVal());
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Logger::class, 'delete');
        $snippet->addLocal('logger', $this->logger);

        $this->connection->deleteLog(Argument::any())
            ->shouldBeCalled();

        $this->logger->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testEntries()
    {
        $snippet = $this->snippetFromMethod(Logger::class, 'entries');
        $snippet->addLocal('logger', $this->logger);

        $this->connection->listEntries(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'entries' => [
                    ['textPayload' => 'foo'],
                    ['textPayload' => 'bar']
                ]
            ]);

        $this->logger->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('entries');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals('foo', explode(PHP_EOL, $res->output())[0]);
        $this->assertEquals('bar', explode(PHP_EOL, $res->output())[1]);
    }

    public function testEntriesWithFilter()
    {
        $snippet = $this->snippetFromMethod(Logger::class, 'entries', 1);
        $snippet->addLocal('logger', $this->logger);

        $this->connection->listEntries(Argument::that(function ($arg) {
            if (!isset($arg['filter'])) return false;
            if (strpos($arg['filter'], 'AND') === false) return false;
            return true;
        }))
            ->shouldBeCalled()
            ->willReturn([
                'entries' => [
                    ['textPayload' => 'foo'],
                    ['textPayload' => 'bar']
                ]
            ]);

        $this->logger->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('entries');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals('foo', explode(PHP_EOL, $res->output())[0]);
        $this->assertEquals('bar', explode(PHP_EOL, $res->output())[1]);
    }

    public function testEntry()
    {
        $snippet = $this->snippetFromMethod(Logger::class, 'entry');
        $snippet->addLocal('logger', $this->logger);

        $res = $snippet->invoke('entry');
        $this->assertInstanceOf(Entry::class, $res->returnVal());
    }

    public function testEntryWithString()
    {
        $snippet = $this->snippetFromMethod(Logger::class, 'entry', 1);
        $snippet->addLocal('logger', $this->logger);

        $res = $snippet->invoke('entry');
        $this->assertInstanceOf(Entry::class, $res->returnVal());
    }

    public function testEntryWithOptions()
    {
        $snippet = $this->snippetFromMethod(Logger::class, 'entry', 2);
        $snippet->addLocal('logger', $this->logger);
        $snippet->addUse(Logger::class);

        $res = $snippet->invoke('entry');
        $this->assertInstanceOf(Entry::class, $res->returnVal());
    }

    public function testWrite()
    {
        $snippet = $this->snippetFromMethod(Logger::class, 'write');
        $snippet->addLocal('logger', $this->logger);

        $this->connection->writeEntries(Argument::any())
            ->shouldBeCalled();

        $this->logger->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testWriteKeyValLevel()
    {
        $snippet = $this->snippetFromMethod(Logger::class, 'write', 1);
        $snippet->addLocal('logger', $this->logger);
        $snippet->addUse(Logger::class);

        $this->connection->writeEntries(Argument::any())
            ->shouldBeCalled();

        $this->logger->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testWriteFactory()
    {
        $snippet = $this->snippetFromMethod(Logger::class, 'write', 2);
        $snippet->addLocal('logger', $this->logger);

        $this->connection->writeEntries(Argument::any())
            ->shouldBeCalled();

        $this->logger->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testWriteBatch()
    {
        $snippet = $this->snippetFromMethod(Logger::class, 'writeBatch');
        $snippet->addLocal('logger', $this->logger);

        $this->connection->writeEntries(Argument::any())
            ->shouldBeCalled();

        $this->logger->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }
}
