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
use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\BackoffSettings;
use Google\GAX\CallSettings;
use Google\GAX\PageStreamingDescriptor;
use Google\GAX\RetrySettings;
use Google\GAX\Testing\MockStub;
use Google\GAX\Testing\MockStatus;
use Google\GAX\Testing\MockRequest;
use Google\GAX\Testing\MockResponse;
use google\longrunning\Operation;
use google\protobuf\EmptyC;
use google\rpc\Code;

class ApiCallableTest extends PHPUnit_Framework_TestCase
{
    public function testBaseCall()
    {
        $request = "request";
        $metadata = [];
        $options = ['call_credentials_callback' => 'fake_callback'];
        $response = "response";
        $stub = MockStub::create($response);

        $callSettings = new CallSettings([]);
        $apiCall = ApiCallable::createApiCall($stub, 'takeAction', $callSettings);
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

        $callSettings = new CallSettings(['timeoutMillis' => 1500]);
        $apiCall = ApiCallable::createApiCall($stub, 'takeAction', $callSettings);
        $actualResponse = $apiCall($request, [], []);

        $this->assertEquals($response, $actualResponse);

        $actualCalls = $stub->actualCalls;
        $this->assertEquals(1, count($actualCalls));
        $this->assertEquals($request, $actualCalls[0]['request']);
        $this->assertEquals([], $actualCalls[0]['metadata']);
        $this->assertEquals(['timeout' => 1500000], $actualCalls[0]['options']);
    }

    public function testRetryNoRetryableCode()
    {
        $request = "request";
        $response = "response";
        $status = new MockStatus(Grpc\STATUS_DEADLINE_EXCEEDED, 'Deadline Exceeded');
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
        $callSettings = new CallSettings(['retrySettings' => $retrySettings]);

        $isExceptionRaised = false;
        try {
            $apiCall = ApiCallable::createApiCall($stub, 'takeAction', $callSettings);
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
        $callSettings = new CallSettings(['retrySettings' => $retrySettings]);
        $apiCall = ApiCallable::createApiCall($stub, 'takeAction', $callSettings);
        $actualResponse = $apiCall($request, [], []);

        $this->assertEquals($responseC, $actualResponse);

        $actualCalls = $stub->actualCalls;
        $this->assertEquals(3, count($actualCalls));

        $this->assertEquals($request, $actualCalls[0]['request']);
        $this->assertEquals(['timeout' => 150000], $actualCalls[0]['options']);

        $this->assertEquals($request, $actualCalls[1]['request']);
        $this->assertEquals(['timeout' => 300000], $actualCalls[1]['options']);

        $this->assertEquals($request, $actualCalls[2]['request']);
        $this->assertEquals(['timeout' => 500000], $actualCalls[2]['options']);
    }

    public function testRetryTimeoutExceeds()
    {
        $request = "request";
        $response = "response";
        $status = new MockStatus(Grpc\STATUS_DEADLINE_EXCEEDED, 'Deadline Exceeded');
        $stub = MockStub::createWithResponseSequence([
            [$response, $status],
            [$response, $status],
            [$response, $status]
        ]);
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
        $callSettings = new CallSettings(['retrySettings' => $retrySettings]);

        // Use time function that simulates 1100ms elapsing with each call to the stub
        $incrementMillis = 1100;
        $timeFuncMillis = function() use ($stub, $incrementMillis) {
            $actualCalls = count($stub->actualCalls);
            return $actualCalls * $incrementMillis;
        };

        $raisedException = null;
        try {
            $apiCall = ApiCallable::createApiCall(
                $stub, 'takeAction', $callSettings, ['timeFuncMillis' => $timeFuncMillis]);
            $response = $apiCall($request, [], []);
        } catch (Google\GAX\ApiException $e) {
            $raisedException = $e;
        }

        $actualCalls = $stub->actualCalls;
        $this->assertEquals(3, count($actualCalls));
        $this->assertEquals($request, $actualCalls[0]['request']);

        $this->assertTrue(!empty($raisedException));
        $this->assertEquals(Grpc\STATUS_DEADLINE_EXCEEDED, $raisedException->getCode());
    }

    public function testPageStreamingDirectIterationNoTimeout()
    {
        $request = MockRequest::createPageStreamingRequest('token');
        $responseA = MockResponse::createPageStreamingResponse('nextPageToken1', ['resource1']);
        $responseB = MockResponse::createPageStreamingResponse('nextPageToken2', ['resource2']);
        $responseC = MockResponse::createPageStreamingResponse(null, ['resource3', 'resource4']);
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
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $stub, 'takeAction', $callSettings, ['pageStreamingDescriptor' => $descriptor]);
        $response = $apiCall($request, [], []);
        $this->assertEquals(1, count($stub->actualCalls));
        $actualResources = [];
        foreach ($response->iterateAllElements() as $element) {
            array_push($actualResources, $element);
        }
        $this->assertEquals(3, count($stub->actualCalls));
        $this->assertEquals(['resource1', 'resource2', 'resource3', 'resource4'], $actualResources);
    }

    public function testPageStreamingPageIterationNoTimeout()
    {
        $request = MockRequest::createPageStreamingRequest('token');
        $responseA = MockResponse::createPageStreamingResponse('nextPageToken1', ['resource1']);
        $responseB = MockResponse::createPageStreamingResponse('nextPageToken2', ['resource2']);
        $responseC = MockResponse::createPageStreamingResponse(null, ['resource3', 'resource4']);
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
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $stub, 'takeAction', $callSettings, ['pageStreamingDescriptor' => $descriptor]);
        $response = $apiCall($request, [], []);
        $this->assertEquals(1, count($stub->actualCalls));
        $actualResources = [];
        $actualTokens = [];
        foreach ($response->iteratePages() as $page) {
            array_push($actualTokens, $page->getRequestObject()->pageToken);
            foreach ($page as $element) {
                array_push($actualResources, $element);
            }
        }
        $this->assertEquals(3, count($stub->actualCalls));
        $this->assertEquals(['resource1', 'resource2', 'resource3', 'resource4'], $actualResources);
        $this->assertEquals(['token', 'nextPageToken1', 'nextPageToken2'],
            $actualTokens);
    }

    public function testPageStreamingFixedSizeIterationNoTimeout()
    {
        $request = MockRequest::createPageStreamingRequest('token', 2);
        $responseA = MockResponse::createPageStreamingResponse('nextPageToken1', ['resource1']);
        $responseB = MockResponse::createPageStreamingResponse('nextPageToken2', ['resource2']);
        $responseC = MockResponse::createPageStreamingResponse(null, ['resource3', 'resource4']);
        $responseSequence = [
            [$responseA, new MockStatus(Grpc\STATUS_OK, '')],
            [$responseB, new MockStatus(Grpc\STATUS_OK, '')],
            [$responseC, new MockStatus(Grpc\STATUS_OK, '')]
        ];
        $stub = MockStub::createWithResponseSequence($responseSequence);
        $descriptor = new PageStreamingDescriptor([
            'requestPageTokenField' => 'pageToken',
            'requestPageSizeField' => 'pageSize',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resource'
        ]);
        $collectionSize = 2;
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $stub, 'takeAction', $callSettings, ['pageStreamingDescriptor' => $descriptor]);
        $response = $apiCall($request, [], []);
        $this->assertEquals(1, count($stub->actualCalls));
        $actualResources = [];
        $collectionCount = 0;
        foreach ($response->iterateFixedSizeCollections($collectionSize) as $collection) {
            $collectionCount += 1;
            foreach ($collection as $element) {
                array_push($actualResources, $element);
            }
        }
        $this->assertEquals(3, count($stub->actualCalls));
        $this->assertEquals(2, $collectionCount);
        $this->assertEquals(['resource1', 'resource2', 'resource3', 'resource4'], $actualResources);
    }

    /**
     * @expectedException Google\GAX\ValidationException
     * @expectedExceptionMessage FixedSizeCollection is not supported
     */
    public function testPageStreamingFixedSizeFailPageSizeNotSupported()
    {
        $request = MockRequest::createPageStreamingRequest('token');
        $responseA = MockResponse::createPageStreamingResponse('nextPageToken1', ['resource1']);
        $responseSequence = [
            [$responseA, new MockStatus(Grpc\STATUS_OK, '')],
                             ];
        $stub = MockStub::createWithResponseSequence($responseSequence);
        $descriptor = new PageStreamingDescriptor([
            'requestPageTokenField' => 'pageToken',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resource'
        ]);
        $collectionSize = 2;
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $stub, 'takeAction', $callSettings, ['pageStreamingDescriptor' => $descriptor]);
        $response = $apiCall($request, [], []);
        $response->expandToFixedSizeCollection($collectionSize);
    }

    /**
     * @expectedException Google\GAX\ValidationException
     * @expectedExceptionMessage No page size parameter found
     */
    public function testPageStreamingFixedSizeFailPageSizeNotSet()
    {
        $request = MockRequest::createPageStreamingRequest('token');
        $responseA = MockResponse::createPageStreamingResponse('nextPageToken1', ['resource1']);
        $responseSequence = [
            [$responseA, new MockStatus(Grpc\STATUS_OK, '')],
        ];
        $stub = MockStub::createWithResponseSequence($responseSequence);
        $descriptor = new PageStreamingDescriptor([
            'requestPageTokenField' => 'pageToken',
            'requestPageSizeField' => 'pageSize',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resource',
        ]);
        $collectionSize = 2;
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $stub, 'takeAction', $callSettings, ['pageStreamingDescriptor' => $descriptor]);
        $response = $apiCall($request, [], []);
        $response->expandToFixedSizeCollection($collectionSize);
    }

    /**
     * @expectedException Google\GAX\ValidationException
     * @expectedExceptionMessage collectionSize parameter is less than the page size
     */
    public function testPageStreamingFixedSizeFailPageSizeTooLarge()
    {
        $collectionSize = 2;
        $request = MockRequest::createPageStreamingRequest('token', $collectionSize + 1);
        $responseA = MockResponse::createPageStreamingResponse('nextPageToken1', ['resource1']);
        $responseSequence = [
            [$responseA, new MockStatus(Grpc\STATUS_OK, '')]
        ];
        $stub = MockStub::createWithResponseSequence($responseSequence);
        $descriptor = new PageStreamingDescriptor([
            'requestPageTokenField' => 'pageToken',
            'requestPageSizeField' => 'pageSize',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resource'
        ]);
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $stub, 'takeAction', $callSettings, ['pageStreamingDescriptor' => $descriptor]);
        $response = $apiCall($request, [], []);
        $response->expandToFixedSizeCollection($collectionSize);
    }

    public function testPageStreamingWithTimeout()
    {
        $request = MockRequest::createPageStreamingRequest('token');
        $responseA = MockResponse::createPageStreamingResponse('nextPageToken1', ['resource1']);
        $responseB = MockResponse::createPageStreamingResponse('nextPageToken2', ['resource2']);
        $responseC = MockResponse::createPageStreamingResponse(null, ['resource3', 'resource4']);
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
        $callSettings = new CallSettings(['timeout' => 1000]);
        $apiCall = ApiCallable::createApiCall(
            $stub, 'takeAction', $callSettings, ['pageStreamingDescriptor' => $descriptor]);
        $response = $apiCall($request, [], []);
        $this->assertEquals(1, count($stub->actualCalls));
        $actualResources = [];
        foreach ($response->iterateAllElements() as $element) {
            array_push($actualResources, $element);
        }
        $this->assertEquals(3, count($stub->actualCalls));
        $this->assertEquals(['resource1', 'resource2', 'resource3', 'resource4'], $actualResources);
    }

    public function testCustomHeader()
    {
        $stub = MockStub::create(new MockResponse());
        $headerDescriptor = new AgentHeaderDescriptor([
            'clientName' => 'testClient',
            'clientVersion' => '0.0.0',
            'codeGenName' => 'testCodeGen',
            'codeGenVersion' => '0.9.0',
            'gaxVersion' => '1.0.0',
            'phpVersion' => '5.5.0',
        ]);
        $apiCall = ApiCallable::createApiCall(
            $stub, 'takeAction', new CallSettings(), ['headerDescriptor' => $headerDescriptor]);
        $resources = $apiCall(new MockRequest(), [], []);
        $actualCalls = $stub->actualCalls;
        $this->assertEquals(1, count($actualCalls));
        $expectedMetadata = [
            'x-goog-api-client' => ['testClient/0.0.0 testCodeGen/0.9.0 gax/1.0.0 php/5.5.0']
        ];
        $this->assertEquals($expectedMetadata, $actualCalls[0]['metadata']);
    }

    public static function createIncompleteOperationResponse($name, $metadataString = '')
    {
        $metadata = OperationResponseTest::createAny(OperationResponseTest::createStatus(Code::OK, $metadataString));
        $op = new Operation();
        $op->setName($name)->setMetadata($metadata)->setDone(false);
        return $op;
    }

    public static function createSuccessfulOperationResponse($name, $response, $metadataString = '')
    {
        $op = self::createIncompleteOperationResponse($name, $metadataString);
        $op->setDone(true)->setResponse(OperationResponseTest::createAny($response));
        return $op;
    }

    public static function createFailedOperationResponse($name, $code, $message, $metadataString = '')
    {
        $error = OperationResponseTest::createStatus($code, $message);
        $op = self::createIncompleteOperationResponse($name, $metadataString);
        $op->setDone(true)->setError($error);
        return $op;
    }

    public function testLongrunningSuccess()
    {
        $opName = 'operation/someop';

        $request = null;
        $result = OperationResponseTest::createStatus(Code::OK, 'someMessage');

        $initialResponse = self::createIncompleteOperationResponse($opName, 'm1');
        $responseA = self::createIncompleteOperationResponse($opName, 'm2');
        $responseB = self::createSuccessfulOperationResponse($opName, $result, 'm3');
        $responseSequence = [
            [$responseA, new MockStatus(Grpc\STATUS_OK, '')],
            [$responseB, new MockStatus(Grpc\STATUS_OK, '')],
        ];
        $callStub = MockStub::createWithResponseSequence([[$initialResponse, new MockStatus(Grpc\STATUS_OK, '')]]);
        $opStub = MockStub::createWithResponseSequence($responseSequence);
        $opClient = OperationResponseTest::createOperationsClient($opStub);
        $descriptor = [
            'operationsClient' => $opClient,
            'operationReturnType' => '\google\rpc\Status',
            'metadataReturnType' => '\google\rpc\Status',
        ];
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $callStub, 'takeAction', $callSettings, ['longRunningDescriptor' => $descriptor]);

        /* @var $response \Google\GAX\OperationResponse */
        $response = $apiCall($request, [], []);

        $results = [$response->getResult()];
        $errors = [$response->getError()];
        $metadataResponses = [$response->getMetadata()];
        $isDoneResponses = [$response->isDone()];

        $this->assertSame(1, count($callStub->actualCalls));
        $this->assertSame(0, count($opStub->actualCalls));

        while (!$response->isDone()) {
            $response->reload();
            $results[] = $response->getResult();
            $errors[] = $response->getError();
            $metadataResponses[] = $response->getMetadata();
            $isDoneResponses[] = $response->isDone();
        }

        $this->assertSame(1, count($callStub->actualCalls));
        $this->assertSame(2, count($opStub->actualCalls));

        $this->assertSame('takeAction', $callStub->actualCalls[0]['funcName']);
        $this->assertSame('GetOperation', $opStub->actualCalls[0]['funcName']);
        $this->assertSame('GetOperation', $opStub->actualCalls[1]['funcName']);

        $this->assertEquals([null, null, OperationResponseTest::createStatus(Code::OK, 'someMessage')], $results);
        $this->assertEquals([null, null, null], $errors);
        $this->assertEquals([
            OperationResponseTest::createStatus(Code::OK, 'm1'),
            OperationResponseTest::createStatus(Code::OK, 'm2'),
            OperationResponseTest::createStatus(Code::OK, 'm3')
        ], $metadataResponses);
        $this->assertEquals([false, false, true], $isDoneResponses);
    }

    public function testLongrunningPollingInterval()
    {
        $opName = 'operation/someop';

        $request = null;
        $result = OperationResponseTest::createStatus(Code::OK, 'someMessage');

        $initialResponse = self::createIncompleteOperationResponse($opName, 'm1');
        $responseA = self::createIncompleteOperationResponse($opName, 'm2');
        $responseB = self::createSuccessfulOperationResponse($opName, $result, 'm3');
        $responseSequence = [
            [$responseA, new MockStatus(Grpc\STATUS_OK, '')],
            [$responseB, new MockStatus(Grpc\STATUS_OK, '')],
        ];
        $callStub = MockStub::createWithResponseSequence([[$initialResponse, new MockStatus(Grpc\STATUS_OK, '')]]);
        $opStub = MockStub::createWithResponseSequence($responseSequence);
        $opClient = OperationResponseTest::createOperationsClient($opStub);
        $descriptor = [
            'operationsClient' => $opClient,
            'operationReturnType' => '\google\rpc\Status',
            'metadataReturnType' => '\google\rpc\Status',
        ];
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $callStub, 'takeAction', $callSettings, ['longRunningDescriptor' => $descriptor]);

        /* @var $response \Google\GAX\OperationResponse */
        $response = $apiCall($request, [], []);

        $this->assertSame(1, count($callStub->actualCalls));
        $this->assertSame(0, count($opStub->actualCalls));

        $complete = $response->pollUntilComplete(['pollingIntervalSeconds' => 0.1]);
        $this->assertTrue($complete);
        $this->assertTrue($response->isDone());

        $this->assertSame(1, count($callStub->actualCalls));
        $this->assertSame(2, count($opStub->actualCalls));

        $this->assertSame('takeAction', $callStub->actualCalls[0]['funcName']);
        $this->assertSame('GetOperation', $opStub->actualCalls[0]['funcName']);
        $this->assertSame('GetOperation', $opStub->actualCalls[1]['funcName']);

        $this->assertEquals(OperationResponseTest::createStatus(Code::OK, 'someMessage'), $response->getResult());
        $this->assertNull($response->getError());
        $this->assertEquals(OperationResponseTest::createStatus(Code::OK, 'm3'), $response->getMetadata());
    }

    public function testLongrunningMaxPollingDuration()
    {
        $opName = 'operation/someop';

        $request = null;
        $result = OperationResponseTest::createStatus(Code::OK, 'someMessage');

        $initialResponse = self::createIncompleteOperationResponse($opName, 'm1');
        $responseA = self::createIncompleteOperationResponse($opName, 'm2');
        $responseB = self::createIncompleteOperationResponse($opName, 'm3');
        $responseSequence = [
            [$responseA, new MockStatus(Grpc\STATUS_OK, '')],
            [$responseB, new MockStatus(Grpc\STATUS_OK, '')],
        ];
        $callStub = MockStub::createWithResponseSequence([[$initialResponse, new MockStatus(Grpc\STATUS_OK, '')]]);
        $opStub = MockStub::createWithResponseSequence($responseSequence);
        $opClient = OperationResponseTest::createOperationsClient($opStub);
        $descriptor = [
            'operationsClient' => $opClient,
            'operationReturnType' => '\google\rpc\Status',
            'metadataReturnType' => '\google\rpc\Status',
        ];
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $callStub, 'takeAction', $callSettings, ['longRunningDescriptor' => $descriptor]);

        /* @var $response \Google\GAX\OperationResponse */
        $response = $apiCall($request, [], []);

        $this->assertSame(1, count($callStub->actualCalls));
        $this->assertSame(0, count($opStub->actualCalls));

        $complete = $response->pollUntilComplete([
            'pollingIntervalSeconds' => 0.1,
            'maxPollingDurationSeconds' => 0.15,
        ]);
        $this->assertFalse($complete);
        $this->assertFalse($response->isDone());

        $this->assertSame(1, count($callStub->actualCalls));
        $this->assertSame(2, count($opStub->actualCalls));

        $this->assertSame('takeAction', $callStub->actualCalls[0]['funcName']);
        $this->assertSame('GetOperation', $opStub->actualCalls[0]['funcName']);

        $this->assertNull($response->getResult());
        $this->assertNull($response->getError());
        $this->assertEquals(OperationResponseTest::createStatus(Code::OK, 'm3'), $response->getMetadata());
    }

    public function testLongrunningFailure()
    {
        $opName = 'operation/someop';

        $request = null;

        $initialResponse = self::createIncompleteOperationResponse($opName, 'm1');
        $responseA = self::createIncompleteOperationResponse($opName, 'm2');
        $responseB = self::createFailedOperationResponse($opName, Code::UNKNOWN, 'someError', 'm3');
        $responseSequence = [
            [$responseA, new MockStatus(Grpc\STATUS_OK, '')],
            [$responseB, new MockStatus(Grpc\STATUS_OK, '')],
        ];
        $callStub = MockStub::createWithResponseSequence(
            [[$initialResponse, new MockStatus(Grpc\STATUS_OK, '')]]);
        $opStub = MockStub::createWithResponseSequence($responseSequence);
        $opClient = OperationResponseTest::createOperationsClient($opStub);
        $descriptor = [
            'operationsClient' => $opClient,
            'operationReturnType' => '\google\rpc\Status',
            'metadataReturnType' => '\google\rpc\Status',
        ];
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $callStub, 'takeAction', $callSettings, ['longRunningDescriptor' => $descriptor]);

        /* @var $response \Google\GAX\OperationResponse */
        $response = $apiCall($request, [], []);

        $results = [$response->getResult()];
        $errors = [$response->getError()];
        $metadataResponses = [$response->getMetadata()];
        $isDoneResponses = [$response->isDone()];

        $this->assertSame(1, count($callStub->actualCalls));
        $this->assertSame(0, count($opStub->actualCalls));

        while (!$response->isDone()) {
            $response->reload();
            $results[] = $response->getResult();
            $errors[] = $response->getError();
            $metadataResponses[] = $response->getMetadata();
            $isDoneResponses[] = $response->isDone();
        }

        $this->assertSame(1, count($callStub->actualCalls));
        $this->assertSame(2, count($opStub->actualCalls));

        $this->assertSame('takeAction', $callStub->actualCalls[0]['funcName']);
        $this->assertSame('GetOperation', $opStub->actualCalls[0]['funcName']);
        $this->assertSame('GetOperation', $opStub->actualCalls[1]['funcName']);

        $this->assertEquals([null, null, null], $results);
        $this->assertEquals([null, null, OperationResponseTest::createStatus(Code::UNKNOWN, 'someError')], $errors);
        $this->assertEquals([
            OperationResponseTest::createStatus(Code::OK, 'm1'),
            OperationResponseTest::createStatus(Code::OK, 'm2'),
            OperationResponseTest::createStatus(Code::OK, 'm3')
        ], $metadataResponses);
        $this->assertEquals([false, false, true], $isDoneResponses);
    }

    public function testLongrunningCancel()
    {
        $opName = 'operation/someop';

        $request = null;

        $initialResponse = self::createIncompleteOperationResponse($opName, 'm1');
        $responseA = self::createIncompleteOperationResponse($opName, 'm2');
        $responseB = self::createFailedOperationResponse($opName, Code::CANCELLED, 'someError', 'm3');
        $responseSequence = [
            [new EmptyC(), new MockStatus(Grpc\STATUS_OK, '')],
            [$responseA, new MockStatus(Grpc\STATUS_OK, '')],
            [$responseB, new MockStatus(Grpc\STATUS_OK, '')],
        ];
        $callStub = MockStub::createWithResponseSequence([[$initialResponse, new MockStatus(Grpc\STATUS_OK, '')]]);
        $opStub = MockStub::createWithResponseSequence($responseSequence);
        $opClient = OperationResponseTest::createOperationsClient($opStub);
        $descriptor = [
            'operationsClient' => $opClient,
            'operationReturnType' => '\google\rpc\Status',
            'metadataReturnType' => '\google\rpc\Status',
        ];
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $callStub, 'takeAction', $callSettings, ['longRunningDescriptor' => $descriptor]);

        /* @var $response \Google\GAX\OperationResponse */
        $response = $apiCall($request, [], []);

        $this->assertSame(1, count($callStub->actualCalls));
        $this->assertSame(0, count($opStub->actualCalls));

        $response->cancel();

        $this->assertSame(1, count($callStub->actualCalls));
        $this->assertSame(1, count($opStub->actualCalls));

        while (!$response->isDone()) {
            $response->reload();
        }

        $this->assertSame(1, count($callStub->actualCalls));
        $this->assertSame(3, count($opStub->actualCalls));

        $this->assertSame('takeAction', $callStub->actualCalls[0]['funcName']);
        $this->assertSame('CancelOperation', $opStub->actualCalls[0]['funcName']);
        $this->assertSame('GetOperation', $opStub->actualCalls[1]['funcName']);
        $this->assertSame('GetOperation', $opStub->actualCalls[2]['funcName']);

        $this->assertNull($response->getResult());
        $this->assertEquals(OperationResponseTest::createStatus(Code::CANCELLED, 'someError'), $response->getError());
        $this->assertEquals(OperationResponseTest::createStatus(Code::OK, 'm3'), $response->getMetadata());
    }

    /**
     * @expectedException \Google\GAX\ValidationException
     * @expectedExceptionMessage Cannot call reload() on a deleted operation
     */
    public function testLongrunningDelete()
    {
        $opName = 'operation/someop';

        $request = null;

        $initialResponse = self::createIncompleteOperationResponse($opName, 'm1');
        $callStub = MockStub::createWithResponseSequence([[$initialResponse, new MockStatus(Grpc\STATUS_OK, '')]]);
        $opStub = MockStub::createWithResponseSequence([[new EmptyC(), new MockStatus(Grpc\STATUS_OK, '')]]);
        $opClient = OperationResponseTest::createOperationsClient($opStub);
        $descriptor = [
            'operationsClient' => $opClient,
            'operationReturnType' => '\google\rpc\Status',
            'metadataReturnType' => '\google\rpc\Status',
        ];
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $callStub, 'takeAction', $callSettings, ['longRunningDescriptor' => $descriptor]);

        /* @var $response \Google\GAX\OperationResponse */
        $response = $apiCall($request, [], []);

        $this->assertSame(1, count($callStub->actualCalls));
        $this->assertSame(0, count($opStub->actualCalls));

        $response->delete();

        $this->assertSame(1, count($callStub->actualCalls));
        $this->assertSame(1, count($opStub->actualCalls));

        $this->assertSame('takeAction', $callStub->actualCalls[0]['funcName']);
        $this->assertSame('DeleteOperation', $opStub->actualCalls[0]['funcName']);

        $response->reload();
    }
}
