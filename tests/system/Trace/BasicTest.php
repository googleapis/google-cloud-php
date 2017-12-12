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
use Google\Cloud\Trace\Annotation;
use Google\Cloud\Trace\Link;
use Google\Cloud\Trace\MessageEvent;
use Google\Cloud\Trace\TraceClient;
use Google\Cloud\Trace\Status;
use PHPUnit\Framework\TestCase;

/**
 * @group trace
 */
class BasicTest extends TestCase
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
        $span = $trace->span(['name' => 'basic']);
        $span->setStartTime();
        $span2 = $trace->span(['name' => 'inner', 'parentSpanId' => $span->spanId()]);
        $span2->setStartTime();

        // just add a little bit of time for the spans
        usleep(20);

        $span2->setEndTime();
        $span->setEndTime();

        $trace->setSpans([$span, $span2]);

        // create the trace
        $this->assertTrue($this->traceClient->insert($trace));
    }

    public function testCanCreateComplexTrace()
    {
        $trace = $this->traceClient->trace();
        $events = [
            new Annotation('some annotation', [
                'attributes' => [
                    'asdf' => 'qwer'
                ]
            ]),
            new MessageEvent(1234, [
                'uncompressedSizeBytes' => 2345
            ])
        ];
        $status = new Status(200, 'OK');
        $span = $trace->span([
            'name' => 'complex',
            'attributes' => [
                'foo' => 'bar'
            ],
            'stackTrace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS),
            'timeEvents' => $events,
            'status' => $status
        ]);
        $links = [
            new Link($trace->traceId(), $span->spanId(), [
                'attributes' => [
                    'key' => 'value'
                ]
            ])
        ];
        $span->setStartTime();
        $span2 = $trace->span([
            'name' => 'inner',
            'parentSpanId' => $span->spanId(),
            'links' => $links
        ]);
        $span2->setStartTime();

        // just add a little bit of time for the spans
        usleep(20);

        $span2->setEndTime();
        $span->setEndTime();

        $trace->setSpans([$span, $span2]);

        // create the trace
        $this->assertTrue($this->traceClient->insert($trace));
    }
}
