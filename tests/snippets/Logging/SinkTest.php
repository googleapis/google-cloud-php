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
use Google\Cloud\Logging\Sink;
use Prophecy\Argument;

/**
 * @group logging
 */
class SinkTest extends SnippetTestCase
{
    const SINK = 'my-sink';
    const PROJECT = 'my-awesome-project';

    private $connection;
    private $sink;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->sink = \Google\Cloud\Dev\stub(Sink::class, [
            $this->connection->reveal(),
            self::SINK,
            self::PROJECT
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Sink::class);
        $res = $snippet->invoke('sink');

        $this->assertInstanceOf(Sink::class, $res->returnVal());
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Sink::class, 'exists');
        $snippet->addLocal('sink', $this->sink);

        $this->connection->getSink(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $this->sink->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Sink exists!', $res->output());
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Sink::class, 'delete');
        $snippet->addLocal('sink', $this->sink);

        $this->connection->deleteSink(Argument::any())
            ->shouldBeCalled();

        $this->sink->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(Sink::class, 'update');
        $snippet->addLocal('sink', $this->sink);

        $this->connection->updateSink(Argument::any())
            ->shouldBeCalled();

        $this->connection->getSink(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'destination' => 'Foo'
            ]);

        $this->sink->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Sink::class, 'info');
        $snippet->addLocal('sink', $this->sink);

        $this->connection->getSink(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'destination' => 'Foo'
            ]);

        $this->sink->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Foo', $res->output());
    }

    public function testReload()
    {
        $snippet = $this->snippetFromMethod(Sink::class, 'reload');
        $snippet->addLocal('sink', $this->sink);

        $this->connection->getSink(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'destination' => 'Foo'
            ]);

        $this->sink->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Foo', $res->output());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Sink::class, 'name');
        $snippet->addLocal('sink', $this->sink);

        $res = $snippet->invoke();

        $this->assertEquals(self::SINK, $res->output());
    }
}
