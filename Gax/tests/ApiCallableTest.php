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

use Google\GAX\ApiCallable;
use Google\GAX\RetrySettings;
use Google\GAX\BackoffSettings;
use Google\GAX\PageStreamingDescriptor;

use Google\GAX\Testing\MockStub;
use Google\GAX\Testing\MockStatus;
use Google\GAX\Testing\MockRequest;
use Google\GAX\Testing\MockResponse;

class ApiCallableTest extends PHPUnit_Framework_TestCase
{
    public function testBaseCall()
    {
        $request = "request";
        $metadata = [];
        $options = ['call_credentials_callback' => 'fake_callback'];
        $response = "response";
        $stub = MockStub::create($response);

        $apiCall = ApiCallable::createApiCall($stub, 'takeAction');
        $actualResponse = $apiCall($request, $metadata, $options);
        $this->assertEquals($response, $actualResponse);

        $actualCalls = $stub->actualCalls;
        $this->assertEquals(1, count($actualCalls));
        $this->assertEquals($request, $actualCalls[0]['request']);
        $this->assertEquals($metadata, $actualCalls[0]['metadata']);
        $this->assertEquals($options, $actualCalls[0]['options']);
    }

    public function testTimeout()
    {
        $request = "request";
        $response = "response";
        $stub = MockStub::create($response);

        $options = ['timeout' => 1500];
        $apiCall = ApiCallable::createApiCall($stub, 'takeAction', $options);
        $actualResponse = $apiCall($request, [], []);

        $this->assertEquals($response, $actualResponse);

        $actualCalls = $stub->actualCalls;
        $this->assertEquals(1, count($actualCalls));
        $this->assertEquals($request, $actualCalls[0]['request']);
        $this->assertEquals([], $actualCalls[0]['metadata']);
        $this->assertEquals(['timeout' => 1500], $actualCalls[0]['options']);
    }

    public function testRetryNoRetryableCode()
    {
        $request = "request";
        $response = "response";
        $status = new MockStatus(\Grpc\STATUS_DEADLINE_EXCEEDED, 'Deadline Exceeded');
        $stub = MockStub::createWithResponseSequence([[$response, $status]]);
        $backoffSettings = new BackoffSettings([
            'initialRetryDelayMillis' => 100,
            'retryDelayMultiplier' => 1.3,
            'maxRetryDelayMillis' => 400,
            'initialRpcTimeoutMillis' => 150,
            'rpcTimeoutMultiplier' => 2,
            'maxRpcTimeoutMillis' => 600,
            'totalTimeoutMillis' => 2000]);
        $retrySettings = new RetrySettings([], $backoffSettings);
        $options = ['retrySettings' => $retrySettings];

        $isExceptionRaised = false;
        try {
            $apiCall = ApiCallable::createApiCall($stub, 'takeAction', $options);
            $response = $apiCall($request, [], []);
        } catch (\Exception $e) {
            $isExceptionRaised = true;
        }

        $actualCalls = $stub->actualCalls;
        $this->assertEquals(1, count($actualCalls));
        $this->assertEquals($request, $actualCalls[0]['request']);

        $this->assertTrue($isExceptionRaised);
    }

    public function testRetryBackoff()
    {
        $request = "request";
        $responseA = "requestA";
        $responseB = "requestB";
        $responseC = "requestC";
        $responseSequence = [
            [$responseA, new MockStatus(Grpc\STATUS_DEADLINE_EXCEEDED, 'Deadline Exceeded')],
            [$responseB, new MockStatus(Grpc\STATUS_DEADLINE_EXCEEDED, 'Deadline Exceeded')],
            [$responseC, new MockStatus(Grpc\STATUS_OK, '')]
                             ];
        $stub = MockStub::createWithResponseSequence($responseSequence);
        $backoffSettings = new BackoffSettings([
            'initialRetryDelayMillis' => 100,
            'retryDelayMultiplier' => 1.3,
            'maxRetryDelayMillis' => 400,
            'initialRpcTimeoutMillis' => 150,
            'rpcTimeoutMultiplier' => 2,
            'maxRpcTimeoutMillis' => 500,
            'totalTimeoutMillis' => 2000]);
        $retrySettings = new RetrySettings(
            [Grpc\STATUS_DEADLINE_EXCEEDED],
            $backoffSettings);
        $options = ['retrySettings' => $retrySettings];
        $apiCall = ApiCallable::createApiCall($stub, 'takeAction', $options);
        $actualResponse = $apiCall($request, [], []);

        $this->assertEquals($responseC, $actualResponse);

        $actualCalls = $stub->actualCalls;
        $this->assertEquals(3, count($actualCalls));

        $this->assertEquals($request, $actualCalls[0]['request']);
        $this->assertEquals(['timeout' => 150], $actualCalls[0]['options']);

        $this->assertEquals($request, $actualCalls[1]['request']);
        $this->assertEquals(['timeout' => 300], $actualCalls[1]['options']);

        $this->assertEquals($request, $actualCalls[2]['request']);
        $this->assertEquals(['timeout' => 500], $actualCalls[2]['options']);
    }

    public function testRetryTimeoutExceeds()
    {
        $request = "request";
        $response = "response";
        $status = new MockStatus(\Grpc\STATUS_DEADLINE_EXCEEDED, 'Deadline Exceeded');
        $stub = MockStub::createWithResponseSequence([[$response, $status]]);
        $backoffSettings = new BackoffSettings([
            'initialRetryDelayMillis' => 1000,
            'retryDelayMultiplier' => 1.3,
            'maxRetryDelayMillis' => 4000,
            'initialRpcTimeoutMillis' => 150,
            'rpcTimeoutMultiplier' => 2,
            'maxRpcTimeoutMillis' => 600,
            'totalTimeoutMillis' => 3000]);
        $retrySettings = new RetrySettings(
            [Grpc\STATUS_DEADLINE_EXCEEDED],
            $backoffSettings);
        $options = ['retrySettings' => $retrySettings];

        $raisedException = null;
        try {
            $apiCall = ApiCallable::createApiCall($stub, 'takeAction', $options);
            $response = $apiCall('request', [], []);
        } catch (\Exception $e) {
            $raisedException = $e;
        }

        $actualCalls = $stub->actualCalls;
        $this->assertEquals(3, count($actualCalls));
        $this->assertEquals($request, $actualCalls[0]['request']);

        $this->assertTrue(!empty($raisedException));
        $this->assertEquals(\Grpc\STATUS_DEADLINE_EXCEEDED, $raisedException->getCode());
    }

    public function testPageStreamingNoTimeout()
    {
        $request = MockRequest::createPageStreamingRequest('token');
        $responseA = MockResponse::createPageStreamingResponse('nextPageToken1', 'resource1');
        $responseB = MockResponse::createPageStreamingResponse('nextPageToken2', 'resource2');
        $responseC = MockResponse::createPageStreamingResponse(null, 'resource3');
        $responseSequence = [
            [$responseA, new MockStatus(Grpc\STATUS_OK, '')],
            [$responseB, new MockStatus(Grpc\STATUS_OK, '')],
            [$responseC, new MockStatus(Grpc\STATUS_OK, '')]
                             ];
        $stub = MockStub::createWithResponseSequence($responseSequence);
        $descriptor = new PageStreamingDescriptor([
            'requestPageTokenField' => 'pageToken',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resource'
        ]);
        $options = [
            'pageStreamingDescriptor' => $descriptor
        ];
        $apiCall = ApiCallable::createApiCall($stub, 'takeAction', $options);
        $resources = $apiCall($request, [], []);
        $this->assertEquals(0, count($stub->actualCalls));
        $actualResources = [];
        $actualTokens = [];
        foreach ($resources as $request => $resource) {
            array_push($actualTokens, $request->pageToken);
            array_push($actualResources, $resource);
        }
        $this->assertEquals(3, count($stub->actualCalls));
        $this->assertEquals(['resource1', 'resource2', 'resource3'], $actualResources);
        $this->assertEquals(['token', 'nextPageToken1', 'nextPageToken2'], $actualTokens);
    }

    public function testPageStreamingWithTimeout()
    {
        $request = MockRequest::createPageStreamingRequest('token');
        $responseA = MockResponse::createPageStreamingResponse('nextPageToken1', 'resource1');
        $responseB = MockResponse::createPageStreamingResponse('nextPageToken2', 'resource2');
        $responseC = MockResponse::createPageStreamingResponse(null, 'resource3');
        $responseSequence = [
            [$responseA, new MockStatus(Grpc\STATUS_OK, '')],
            [$responseB, new MockStatus(Grpc\STATUS_OK, '')],
            [$responseC, new MockStatus(Grpc\STATUS_OK, '')]
                             ];
        $stub = MockStub::createWithResponseSequence($responseSequence);
        $descriptor = new PageStreamingDescriptor([
            'requestPageTokenField' => 'pageToken',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resource'
        ]);
        $options = [
            'pageStreamingDescriptor' => $descriptor,
            'timeout' => 1000,
        ];
        $apiCall = ApiCallable::createApiCall($stub, 'takeAction', $options);
        $resources = $apiCall($request, [], []);
        $this->assertEquals(0, count($stub->actualCalls));
        $actualResources = [];
        $actualTokens = [];
        foreach ($resources as $request => $resource) {
            array_push($actualTokens, $request->pageToken);
            array_push($actualResources, $resource);
        }
        $this->assertEquals(3, count($stub->actualCalls));
        $this->assertEquals(['resource1', 'resource2', 'resource3'], $actualResources);
        $this->assertEquals(['token', 'nextPageToken1', 'nextPageToken2'], $actualTokens);
    }
}
