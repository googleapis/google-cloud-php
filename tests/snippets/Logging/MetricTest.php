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
use Google\Cloud\Logging\Metric;
use Prophecy\Argument;

/**
 * @group logging
 */
class MetricTest extends SnippetTestCase
{
    const METRIC = 'my-metric';
    const PROJECT = 'my-awesome-project';

    private $connection;
    private $metric;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->metric = \Google\Cloud\Dev\stub(Metric::class, [
            $this->connection->reveal(),
            self::METRIC,
            self::PROJECT
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Metric::class);
        $res = $snippet->invoke('metric');

        $this->assertInstanceOf(Metric::class, $res->returnVal());
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Metric::class, 'exists');
        $snippet->addLocal('metric', $this->metric);

        $this->connection->getMetric(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $this->metric->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals("Metric exists!", $res->output());
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Metric::class, 'delete');
        $snippet->addLocal('metric', $this->metric);

        $this->connection->deleteMetric(Argument::any())
            ->shouldBeCalled();

        $this->metric->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(Metric::class, 'update');
        $snippet->addLocal('metric', $this->metric);

        $this->connection->updateMetric(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $this->connection->getMetric(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['description' => 'Foo']);

        $this->metric->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Metric::class, 'info');
        $snippet->addLocal('metric', $this->metric);

        $this->connection->getMetric(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['description' => 'Foo']);

        $this->metric->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Foo', $res->output());
    }

    public function testReload()
    {
        $snippet = $this->snippetFromMethod(Metric::class, 'reload');
        $snippet->addLocal('metric', $this->metric);

        $this->connection->getMetric(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['description' => 'Foo']);

        $this->metric->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Foo', $res->output());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Metric::class, 'name');
        $snippet->addLocal('metric', $this->metric);

        $res = $snippet->invoke();
        $this->assertEquals(self::METRIC, $res->output());
    }
}
