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

namespace Google\Cloud\Trace\Tests\System;

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
    /**
     * @dataProvider transports
     */
    public function testCanCreateTraces($connectionType)
    {
        $traceClient = $this->client($connectionType);
        $trace = $traceClient->trace();
        $span = $trace->span(['name' => 'basic - ' . $connectionType]);
        $span->setStartTime();
        $span2 = $trace->span(['name' => 'inner', 'parentSpanId' => $span->spanId()]);
        $span2->setStartTime();

        // just add a little bit of time for the spans
        usleep(20);

        $span2->setEndTime();
        $span->setEndTime();

        $trace->setSpans([$span, $span2]);

        // create the trace
        $this->assertTrue($traceClient->insert($trace));
    }

    /**
     * @dataProvider transports
     */
    public function testCanCreateComplexTrace($connectionType)
    {
        $traceClient = $this->client($connectionType);
        $trace = $traceClient->trace();
        $status = new Status(200, 'OK');
        $span = $trace->span([
            'name' => 'complex - ' . $connectionType,
            'attributes' => [
                'foo' => 'bar'
            ],
            'stackTrace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS),
            'status' => $status,
            'startTime' => microtime(true)
        ]);
        $span->addTimeEvent(
            new Annotation('some annotation', [
                'attributes' => [
                    'asdf' => 'qwer'
                ]
            ])
        );
        $span->addTimeEvent(
            new MessageEvent(1, [
                'type' => MessageEvent::TYPE_SENT,
                'compressedSizeBytes' => 1234,
                'uncompressedSizeBytes' => 2345
            ])
        );

        $span2 = $trace->span([
            'name' => 'inner',
            'parentSpanId' => $span->spanId(),
            'startTime' => microtime(true)
        ]);
        $span2->addLink(
            new Link($trace->traceId(), $span->spanId(), [
                'attributes' => [
                    'key' => 'value'
                ]
            ])
        );

        // just add a little bit of time for the spans
        usleep(20);

        $span2->setEndTime();
        $span->setEndTime();

        $trace->setSpans([$span, $span2]);

        // create the trace
        $this->assertTrue($traceClient->insert($trace));
    }

    public function transports()
    {
        return [
            ['grpc'],
            ['rest']
        ];
    }

    private function client($connectionType)
    {
        return new TraceClient([
            'keyFilePath' => getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH'),
            'transport' => $connectionType
        ]);
    }
}
