<?php
/*
 * Copyright 2021 Google LLC
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Google\ApiCore\Tests\Unit\Transport\Rest;

use Google\ApiCore\Tests\Unit\TestTrait;
use Google\ApiCore\Transport\Rest\JsonStreamDecoder;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Rpc\Status;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\BufferStream;
use PHPUnit\Framework\TestCase;


class JsonStreamDecoderTest extends TestCase
{
    use TestTrait;

    /**
     * @dataProvider buildResponseStreams
     */
    public function testJsonStreamDecoder(array $responses, $decodeType, $stream, $readChunkSizeBytes) {
        $decoder = new JsonStreamDecoder($stream, $decodeType, ['readChunkSizeBytes' => $readChunkSizeBytes]);
        $num = 0;
        foreach($decoder->decode() as $op) {
            $this->assertEquals($responses[$num], $op);
            $num++;
        }
        $this->assertEquals(count($responses), $num);
    }

    public function buildResponseStreams() {
        $any = new Any();
        $any->pack(new Operation([
            'name' => 'any_metadata',
        ]));
        $operations = [
            new Operation([
                'name' => 'foo',
                'done' => true,
                'metadata' => $any,
            ]),
            new Operation([
                'name' => 'bar',
                'done' => true,
                'error' => new Status([
                    'code' => 1,
                    'message' => "This contains an \"escaped string\" and\n'single quotes' on a new \line",
                ]),
            ]),
            new Operation([
                'name' => 'foo',
                'done' => true,
                'error' => new Status([
                    'code' => 1,
                    'message' => 'This contains \\escaped slashes\\',
                ]),
            ]),
            new Operation([
                'name' => 'foo',
                'done' => true,
                'error' => new Status([
                    'code' => 1,
                    'message' => 'This contains [brackets]',
                ]),
            ]),
            new Operation([
                'name' => 'foo',
                'done' => true,
                'error' => new Status([
                    'code' => 1,
                    'message' => 'This contains {braces}',
                ]),
            ]),
            new Operation([
                'name' => 'foo',
                'done' => true,
                'error' => new Status([
                    'code' => 1,
                    'message' => "This contains everything \\\"{['\'",
                ]),
            ]),
        ];
        
        $stream = function($data) {return $this->messagesToStream($data);};
        return [
            [$operations, Operation::class, $stream($operations), /*readChunkSizeBytes*/ 10],
            [$operations, Operation::class, $stream($operations), /*readChunkSizeBytes*/ 1024],
            [$operations, Operation::class, $stream($operations), /*readChunkSizeBytes*/ 1]
        ];
    }

    private function messagesToStream(array $messages) {
        $data = [];
        foreach($messages as $message) {
            $data[] = $message->serializeToJsonString();
        }
        return Psr7\Utils::streamFor('['.implode(',', $data).']');
    }

    /**
     * @dataProvider buildBadPayloads
     * @expectedException \Exception
     */
    public function testJsonStreamDecoderBadClose($payload) {
        $stream = new BufferStream();
        $stream->write($payload);
        $decoder = new JsonStreamDecoder($stream, Operation::class, ['readChunkSizeBytes' => 10]);
        foreach($decoder->decode() as $op) {
            $this->assertEquals('foo', $op->getName());
            $stream->close();
        }
    }

    public function buildBadPayloads() {
        return
        [
            ['[{"name": "foo"},{'],
            ['[{"name": "foo"},'],
            ['[{"name": "foo"},{"name":'],
            ['[{"name": "foo"},{]'],
        ];
    }
}
