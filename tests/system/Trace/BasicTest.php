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

namespace Google\Cloud\Tests\System\Trace;

use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\Trace\TraceClient;
use Google\Cloud\Trace\TraceSpan;
use Google\Cloud\Trace\Trace;

class BasicTest extends \PHPUnit_Framework_TestCase
{
    private $traceClient;

    public function setUp()
    {
        $this->traceClient = new TraceClient([
            'keyFilePath' => getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH')
        ]);
    }

    public function testCanCreateTraces()
    {
        $trace = $this->traceClient->trace();
        $span = new TraceSpan(['name' => 'main']);
        $span->setStart();

        $span2 = new TraceSpan(['name' => 'inner', 'parentSpanId' => $span->spanId()]);
        $span2->setStart();

        usleep(20000);
        $span2->setFinish();
        $span->setFinish();

        $trace->setSpans([$span, $span2]);

        // create the trace
        $this->assertTrue($this->traceClient->insertTrace($trace));

        // find the created trace (need to retry b/c eventual consistency)
        $backoff = new ExponentialBackoff(5);
        $fetchedTrace = $backoff->execute([$this->traceClient, 'getTrace'], [$trace->traceId()]);

        $this->assertInstanceOf(Trace::class, $fetchedTrace);
        $this->assertEquals($trace->traceId(), $fetchedTrace->traceId());
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\NotFoundException
     */
    public function testFindNonExistentTrace()
    {
        // should not exist (it's possible, but unlikely)
        $this->traceClient->getTrace('00000000000000000000000000000000');
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\BadRequestException
     */
    public function testFindInvalidRequest()
    {
        $this->traceClient->getTrace('invalidid');
    }

    /**
     * @depends testCanCreateTraces
     */
    public function testListTraces()
    {
        $traces = iterator_to_array($this->traceClient->traces());
        $this->assertNotEmpty($traces);
        foreach ($traces as $trace) {
            $this->assertInstanceOf(Trace::class, $trace);
        }
    }
}
