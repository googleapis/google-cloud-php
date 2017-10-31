<?php
/*
 * Copyright 2016, Google Inc.
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

namespace Google\Cloud\Tests\Unit\Core\Grpc;

use Google\Cloud\Core\Grpc\GrpcServerStream;
use Google\Cloud\Tests\GrpcTestTrait;
use Google\Cloud\Tests\Mocks\MockPageStreamingResponse;
use Google\Cloud\Tests\Mocks\MockServerStreamingCall;
use Google\GAX\Testing\MockStatus;
use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Grpc;
use PHPUnit_Framework_TestCase;

class GrpcServerStreamTest extends PHPUnit_Framework_TestCase
{
    use GrpcTestTrait;

    public function testEmptySuccess()
    {
        $call = new MockServerStreamingCall([]);
        $stream = new GrpcServerStream($call);

        $this->assertSame($call, $stream->getServerStreamingCall());
        $this->assertSame([], iterator_to_array($stream->readAll()));
    }

    /**
     * @expectedException \Google\GAX\ApiException
     * @expectedExceptionMessage empty failure
     */
    public function testEmptyFailure()
    {
        $call = new MockServerStreamingCall([], null, new MockStatus(Grpc\STATUS_INTERNAL, 'empty failure'));
        $stream = new GrpcServerStream($call);

        $this->assertSame($call, $stream->getServerStreamingCall());
        iterator_to_array($stream->readAll());
    }

    public function testStringsSuccess()
    {
        $responses = ['abc', 'def'];
        $call = new MockServerStreamingCall($responses);
        $stream = new GrpcServerStream($call);

        $this->assertSame($call, $stream->getServerStreamingCall());
        $this->assertSame($responses, iterator_to_array($stream->readAll()));
    }

    /**
     * @expectedException \Google\GAX\ApiException
     * @expectedExceptionMessage strings failure
     */
    public function testStringsFailure()
    {
        $responses = ['abc', 'def'];
        $call = new MockServerStreamingCall(
            $responses,
            null,
            new MockStatus(Grpc\STATUS_INTERNAL, 'strings failure')
        );
        $stream = new GrpcServerStream($call);

        $this->assertSame($call, $stream->getServerStreamingCall());
        $index = 0;
        try {
            foreach ($stream->readAll() as $response) {
                $this->assertSame($response, $responses[$index]);
                $index++;
            }
        } finally {
            $this->assertSame(2, $index);
        }
    }

    public function testObjectsSuccess()
    {
        $responses = [
            GrpcServerStreamTest::createStatus(Grpc\STATUS_OK, 'response1'),
            GrpcServerStreamTest::createStatus(Grpc\STATUS_OK, 'response2')
        ];
        $serializedResponses = [];
        foreach ($responses as $response) {
            $serializedResponses[] = $response->serializeToString();
        }
        $call = new MockServerStreamingCall($serializedResponses, ['\Google\Rpc\Status', 'mergeFromString']);
        $stream = new GrpcServerStream($call);

        $this->assertSame($call, $stream->getServerStreamingCall());
        $this->assertEquals($responses, iterator_to_array($stream->readAll()));
    }

    /**
     * @expectedException \Google\GAX\ApiException
     * @expectedExceptionMessage objects failure
     */
    public function testObjectsFailure()
    {
        $responses = [
            GrpcServerStreamTest::createStatus(Grpc\STATUS_OK, 'response1'),
            GrpcServerStreamTest::createStatus(Grpc\STATUS_OK, 'response2')
        ];
        $serializedResponses = [];
        foreach ($responses as $response) {
            $serializedResponses[] = $response->serializeToString();
        }
        $call = new MockServerStreamingCall(
            $serializedResponses,
            ['\Google\Rpc\Status', 'mergeFromString'],
            new MockStatus(Grpc\STATUS_INTERNAL, 'objects failure')
        );
        $stream = new GrpcServerStream($call);

        $this->assertSame($call, $stream->getServerStreamingCall());
        $index = 0;
        try {
            foreach ($stream->readAll() as $response) {
                $this->assertEquals($response, $responses[$index]);
                $index++;
            }
        } finally {
            $this->assertSame(2, $index);
        }
    }

    public function testResourcesSuccess()
    {
        $resources = ['resource1', 'resource2', 'resource3'];
        $repeatedField1 = new RepeatedField(GPBType::STRING);
        $repeatedField1[] = 'resource1';
        $repeatedField2 = new RepeatedField(GPBType::STRING);
        $repeatedField2[] = 'resource2';
        $repeatedField2[] = 'resource3';
        $responses = [
            MockPageStreamingResponse::createPageStreamingResponse('nextPageToken1', $repeatedField1),
            MockPageStreamingResponse::createPageStreamingResponse('nextPageToken1', $repeatedField2)
        ];
        $call = new MockServerStreamingCall($responses);
        $stream = new GrpcServerStream($call, [
            'resourcesGetMethod' => 'getResourcesList'
        ]);

        $this->assertSame($call, $stream->getServerStreamingCall());
        $this->assertEquals($resources, iterator_to_array($stream->readAll()));
    }

    /**
     * @expectedException \Google\GAX\ApiException
     * @expectedExceptionMessage resources failure
     */
    public function testResourcesFailure()
    {
        $resources = ['resource1', 'resource2', 'resource3'];
        $responses = [
            MockPageStreamingResponse::createPageStreamingResponse('nextPageToken1', ['resource1']),
            MockPageStreamingResponse::createPageStreamingResponse('nextPageToken1', ['resource2', 'resource3'])
        ];
        $call = new MockServerStreamingCall(
            $responses,
            null,
            new MockStatus(Grpc\STATUS_INTERNAL, 'resources failure')
        );
        $stream = new GrpcServerStream($call, [
            'resourcesGetMethod' => 'getResourcesList'
        ]);

        $this->assertSame($call, $stream->getServerStreamingCall());
        $index = 0;
        try {
            foreach ($stream->readAll() as $response) {
                $this->assertSame($response, $resources[$index]);
                $index++;
            }
        } finally {
            $this->assertSame(3, $index);
        }
    }
}
