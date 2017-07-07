<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Tests\Snippets\Trace;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Trace\Connection\ConnectionInterface;
use Google\Cloud\Trace\Reporter\NullReporter;
use Google\Cloud\Trace\Reporter\ReporterInterface;
use Google\Cloud\Trace\RequestHandler;
use Google\Cloud\Trace\RequestTracer;
use Google\Cloud\Trace\Sampler\QpsSampler;
use Google\Cloud\Trace\TraceClient;
use Prophecy\Argument;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @group trace
 */
class RequestTracerTest extends SnippetTestCase
{
    private $connection;
    private $client;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = \Google\Cloud\Dev\stub(TraceClient::class);
        $this->client->___setProperty('connection', $this->connection->reveal());
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(RequestTracer::class);
        $snippet->addUse(NullReporter::class);
        $snippet->replace('new SyncReporter', 'new NullReporter');

        $snippet->invoke();
        $handler = RequestTracer::instance();

        $this->assertInstanceOf(RequestHandler::class, $handler);
        $this->assertCount(1, $handler->tracer()->spans());
    }

    public function testClassApcu()
    {
        $snippet = $this->snippetFromClass(RequestTracer::class, 1);
        $snippet->addUse(RequestTracer::class);
        $snippet->addUse(QpsSampler::class);
        $cache = $this->prophesize(CacheItemPoolInterface::class);
        $snippet->addLocal('cache', $cache->reveal());
        $reporter = $this->prophesize(ReporterInterface::class);
        $snippet->addLocal('reporter', $reporter->reveal());

        $res = $snippet->invoke();
        $handler = RequestTracer::instance();

        $this->assertInstanceOf(RequestHandler::class, $handler);
        $this->assertCount(1, $handler->tracer()->spans());
    }

    public function testClassApcuFactory()
    {
        $snippet = $this->snippetFromClass(RequestTracer::class, 2);
        $snippet->addUse(RequestTracer::class);
        $cache = $this->prophesize(CacheItemPoolInterface::class);
        $snippet->addLocal('cache', $cache->reveal());
        $reporter = $this->prophesize(ReporterInterface::class);
        $snippet->addLocal('reporter', $reporter->reveal());

        $res = $snippet->invoke();
        $handler = RequestTracer::instance();

        $this->assertInstanceOf(RequestHandler::class, $handler);
        $this->assertCount(1, $handler->tracer()->spans());
    }

    public function testNestedSpans()
    {
        $snippet = $this->snippetFromClass(RequestTracer::class, 3);
        $snippet->addUse(RequestTracer::class);
        $reporter = $this->prophesize(ReporterInterface::class);
        $snippet->addLocal('reporter', $reporter->reveal());

        $res = $snippet->invoke();
        $handler = RequestTracer::instance();

        $this->assertInstanceOf(RequestHandler::class, $handler);
        $this->assertEquals(3, count($handler->tracer()->spans()));
    }

    public function testExplicitSpans()
    {
        $snippet = $this->snippetFromClass(RequestTracer::class, 4);
        $snippet->addUse(RequestTracer::class);
        $reporter = $this->prophesize(ReporterInterface::class);
        $snippet->addLocal('reporter', $reporter->reveal());

        $res = $snippet->invoke();
        $handler = RequestTracer::instance();

        $this->assertInstanceOf(RequestHandler::class, $handler);
        $this->assertEquals(2, count($handler->tracer()->spans()));
    }

    public function testInSpanClosure()
    {
        $snippet = $this->snippetFromMethod(RequestTracer::class, 'inSpan');
        $snippet->addUse(RequestTracer::class);
        $snippet->invoke();

        $spans = RequestTracer::instance()->tracer()->spans();
        $lastSpan = $spans[count($spans) - 1];
        $this->assertEquals('some-closure', $lastSpan->name());
    }

    public function testInSpanCallable()
    {
        $snippet = $this->snippetFromMethod(RequestTracer::class, 'inSpan', 1);
        $snippet->addUse(RequestTracer::class);
        $snippet->invoke();

        $spans = RequestTracer::instance()->tracer()->spans();
        $lastSpan = $spans[count($spans) - 1];
        $this->assertEquals('some-callable', $lastSpan->name());
    }

    public function testStartSpan()
    {
        $snippet = $this->snippetFromMethod(RequestTracer::class, 'startSpan');
        $snippet->addUse(RequestTracer::class);
        $snippet->invoke();

        $spans = RequestTracer::instance()->tracer()->spans();
        $lastSpan = $spans[count($spans) - 1];
        $this->assertEquals('expensive-operation', $lastSpan->name());
    }
}
