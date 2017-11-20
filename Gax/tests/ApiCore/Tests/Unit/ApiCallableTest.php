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
namespace Google\ApiCore\Tests\Unit;

use Google\ApiCore\ApiCallable;
use Google\ApiCore\ApiException;
use Google\ApiCore\AgentHeaderDescriptor;
use Google\ApiCore\CallSettings;
use Google\ApiCore\PagedListResponse;
use Google\ApiCore\PageStreamingDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\ApiStatus;
use Google\ApiCore\Testing\MockStatus;
use Google\ApiCore\Tests\Unit\Mocks\MockBidiStreamingStub;
use Google\ApiCore\Tests\Unit\Mocks\MockClientStreamingStub;
use Google\ApiCore\Tests\Unit\Mocks\MockServerStreamingStub;
use Google\ApiCore\Tests\Unit\Mocks\MockStub;
use Google\ApiCore\Tests\Unit\Mocks\MockPageStreamingRequest;
use Google\ApiCore\Tests\Unit\Mocks\MockPageStreamingResponse;
use Google\ApiCore\ValidationException;
use Google\LongRunning\Operation;
use Google\Protobuf\GPBEmpty;
use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Rpc\Code;
use Google\Rpc\Status;
use PHPUnit\Framework\TestCase;

class ApiCallableTest extends TestCase
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

        $actualCalls = $stub->popReceivedCalls();
        $this->assertEquals(1, count($actualCalls));
        $this->assertEquals($request, $actualCalls[0]->getRequestObject());
        $this->assertEquals($metadata, $actualCalls[0]->getMetadata());
        $this->assertEquals($options, $actualCalls[0]->getOptions());
    }

    public function testTimeout()
    {
        $request = "request";
        $response = "response";
        $stub = MockStub::create($response);

        $retrySettings = new RetrySettings([
            'initialRetryDelayMillis' => 100,
            'retryDelayMultiplier' => 1.3,
            'maxRetryDelayMillis' => 400,
            'initialRpcTimeoutMillis' => 150,
            'rpcTimeoutMultiplier' => 2,
            'maxRpcTimeoutMillis' => 600,
            'totalTimeoutMillis' => 2000,
            'retryableCodes' => [],
            'noRetriesRpcTimeoutMillis' => 1500
        ]);
        $callSettings = new CallSettings([
            'retrySettings' => $retrySettings
        ]);
        $apiCall = ApiCallable::createApiCall($stub, 'takeAction', $callSettings);
        $actualResponse = $apiCall($request, [], []);

        $this->assertEquals($response, $actualResponse);

        $actualCalls = $stub->popReceivedCalls();
        $this->assertEquals(1, count($actualCalls));
        $this->assertEquals($request, $actualCalls[0]->getRequestObject());
        $this->assertEquals([], $actualCalls[0]->getMetadata());
        $this->assertEquals(['timeout' => 1500000], $actualCalls[0]->getOptions());
    }

    public function testRetryNoRetryableCode()
    {
        $request = "request";
        $response = "response";
        $status = new MockStatus(Code::DEADLINE_EXCEEDED, 'Deadline Exceeded');
        $stub = MockStub::createWithResponseSequence([[$response, $status]]);
        $retrySettings = new RetrySettings([
            'initialRetryDelayMillis' => 100,
            'retryDelayMultiplier' => 1.3,
            'maxRetryDelayMillis' => 400,
            'initialRpcTimeoutMillis' => 150,
            'rpcTimeoutMultiplier' => 2,
            'maxRpcTimeoutMillis' => 600,
            'totalTimeoutMillis' => 2000,
            'retryableCodes' => [],
        ]);
        $callSettings = new CallSettings(['retrySettings' => $retrySettings]);

        $isExceptionRaised = false;
        try {
            $apiCall = ApiCallable::createApiCall($stub, 'takeAction', $callSettings);
            $response = $apiCall($request, [], []);
        } catch (\Exception $e) {
            $isExceptionRaised = true;
        }

        $actualCalls = $stub->popReceivedCalls();
        $this->assertEquals(1, count($actualCalls));
        $this->assertEquals($request, $actualCalls[0]->getRequestObject());

        $this->assertTrue($isExceptionRaised);
    }

    public function testRetryBackoff()
    {
        $request = "request";
        $responseA = "requestA";
        $responseB = "requestB";
        $responseC = "requestC";
        $responseSequence = [
            [$responseA, new MockStatus(Code::DEADLINE_EXCEEDED, 'Deadline Exceeded')],
            [$responseB, new MockStatus(Code::DEADLINE_EXCEEDED, 'Deadline Exceeded')],
            [$responseC, new MockStatus(Code::OK, '')]
        ];
        $stub = MockStub::createWithResponseSequence($responseSequence);
        $retrySettings = new RetrySettings([
            'initialRetryDelayMillis' => 100,
            'retryDelayMultiplier' => 1.3,
            'maxRetryDelayMillis' => 400,
            'initialRpcTimeoutMillis' => 150,
            'rpcTimeoutMultiplier' => 2,
            'maxRpcTimeoutMillis' => 500,
            'totalTimeoutMillis' => 2000,
            'retryableCodes' => [ApiStatus::DEADLINE_EXCEEDED],
        ]);
        $callSettings = new CallSettings(['retrySettings' => $retrySettings]);
        $apiCall = ApiCallable::createApiCall($stub, 'takeAction', $callSettings);
        $actualResponse = $apiCall($request, [], []);

        $this->assertEquals($responseC, $actualResponse);

        $actualCalls = $stub->popReceivedCalls();
        $this->assertEquals(3, count($actualCalls));

        $this->assertEquals($request, $actualCalls[0]->getRequestObject());
        $this->assertEquals(['timeout' => 150000], $actualCalls[0]->getOptions());

        $this->assertEquals($request, $actualCalls[1]->getRequestObject());
        $this->assertEquals(['timeout' => 300000], $actualCalls[1]->getOptions());

        $this->assertEquals($request, $actualCalls[2]->getRequestObject());
        $this->assertEquals(['timeout' => 500000], $actualCalls[2]->getOptions());
    }

    public function testRetryTimeoutExceeds()
    {
        $request = "request";
        $response = "response";
        $status = new MockStatus(Code::DEADLINE_EXCEEDED, 'Deadline Exceeded');
        $stub = MockStub::createWithResponseSequence([
            [$response, $status],
            [$response, $status],
            [$response, $status]
        ]);
        $retrySettings = new RetrySettings([
            'initialRetryDelayMillis' => 1000,
            'retryDelayMultiplier' => 1.3,
            'maxRetryDelayMillis' => 4000,
            'initialRpcTimeoutMillis' => 150,
            'rpcTimeoutMultiplier' => 2,
            'maxRpcTimeoutMillis' => 600,
            'totalTimeoutMillis' => 3000,
            'retryableCodes' => [ApiStatus::DEADLINE_EXCEEDED],
        ]);
        $callSettings = new CallSettings(['retrySettings' => $retrySettings]);

        // Use time function that simulates 1100ms elapsing with each call to the stub
        $incrementMillis = 1100;
        $elapsed = 0;
        $timeFuncMillis = function () use ($stub, $incrementMillis, $elapsed) {
            $actualCalls = $stub->getReceivedCallCount();
            return $actualCalls * $incrementMillis;
        };

        $raisedException = null;
        try {
            $apiCall = ApiCallable::createApiCall(
                $stub,
                'takeAction',
                $callSettings,
                ['timeFuncMillis' => $timeFuncMillis]
            );
            $response = $apiCall($request, [], []);
        } catch (ApiException $e) {
            $raisedException = $e;
        }

        $actualCalls = $stub->popReceivedCalls();
        $this->assertEquals(3, count($actualCalls));
        $this->assertEquals($request, $actualCalls[0]->getRequestObject());

        $this->assertTrue(!empty($raisedException));
        $this->assertEquals(Code::DEADLINE_EXCEEDED, $raisedException->getCode());
    }

    public function testRetryTimeoutExceedsRealTime()
    {
        $request = "request";
        $response = "response";
        $stub = MockStub::createWithResponseSequence([]);
        $retrySettings = new RetrySettings([
            'initialRetryDelayMillis' => 10,
            'retryDelayMultiplier' => 1,
            'maxRetryDelayMillis' => 10,
            'initialRpcTimeoutMillis' => 350,
            'rpcTimeoutMultiplier' => 1,
            'maxRpcTimeoutMillis' => 350,
            'totalTimeoutMillis' => 1000,
            'retryableCodes' => [ApiStatus::DEADLINE_EXCEEDED],
        ]);
        $callSettings = new CallSettings(['retrySettings' => $retrySettings]);

        $raisedException = null;
        try {
            $apiCall = ApiCallable::createApiCall($stub, 'methodThatSleeps', $callSettings);
            $response = $apiCall($request, [], []);
        } catch (ApiException $e) {
            $raisedException = $e;
        }

        $actualCalls = $stub->popReceivedCalls();
        $this->assertEquals(3, count($actualCalls));
        $this->assertEquals($request, $actualCalls[0]->getRequestObject());

        $this->assertTrue(!empty($raisedException));
        $this->assertEquals(Code::DEADLINE_EXCEEDED, $raisedException->getCode());
    }

    public function testPageStreamingDirectIterationNoTimeout()
    {
        $request = MockPageStreamingRequest::createPageStreamingRequest('token');
        $responseA = MockPageStreamingResponse::createPageStreamingResponse('nextPageToken1', ['resource1']);
        $responseB = MockPageStreamingResponse::createPageStreamingResponse('nextPageToken2', ['resource2']);
        $responseC = MockPageStreamingResponse::createPageStreamingResponse(null, ['resource3', 'resource4']);
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')],
            [$responseB, new MockStatus(Code::OK, '')],
            [$responseC, new MockStatus(Code::OK, '')]
        ];
        $stub = MockStub::createWithResponseSequence($responseSequence);
        $descriptor = PageStreamingDescriptor::createFromFields([
            'requestPageTokenField' => 'pageToken',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resourcesList'
        ]);
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $stub,
            'takeAction',
            $callSettings,
            ['pageStreamingDescriptor' => $descriptor]
        );
        $response = $apiCall($request, [], []);
        $actualCalls = $stub->popReceivedCalls();
        $this->assertEquals(1, count($actualCalls));
        $actualResources = [];
        foreach ($response->iterateAllElements() as $element) {
            array_push($actualResources, $element);
        }
        $actualCalls = array_merge($actualCalls, $stub->popReceivedCalls());
        $this->assertEquals(3, count($actualCalls));
        $this->assertEquals(['resource1', 'resource2', 'resource3', 'resource4'], $actualResources);
    }

    public function testPageStreamingPageIterationNoTimeout()
    {
        $request = MockPageStreamingRequest::createPageStreamingRequest('token');
        $responseA = MockPageStreamingResponse::createPageStreamingResponse('nextPageToken1', ['resource1']);
        $responseB = MockPageStreamingResponse::createPageStreamingResponse('nextPageToken2', ['resource2']);
        $responseC = MockPageStreamingResponse::createPageStreamingResponse(null, ['resource3', 'resource4']);
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')],
            [$responseB, new MockStatus(Code::OK, '')],
            [$responseC, new MockStatus(Code::OK, '')]
        ];
        $stub = MockStub::createWithResponseSequence($responseSequence);
        $descriptor = PageStreamingDescriptor::createFromFields([
            'requestPageTokenField' => 'pageToken',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resourcesList'
        ]);
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $stub,
            'takeAction',
            $callSettings,
            ['pageStreamingDescriptor' => $descriptor]
        );
        /** @var PagedListResponse $response */
        $response = $apiCall($request, [], []);
        $actualCalls = $stub->popReceivedCalls();
        $this->assertEquals(1, count($actualCalls));
        $actualResources = [];
        $actualTokens = [];
        foreach ($response->iteratePages() as $page) {
            array_push($actualTokens, $page->getRequestObject()->getPageToken());
            foreach ($page as $element) {
                array_push($actualResources, $element);
            }
        }
        $actualCalls = array_merge($actualCalls, $stub->popReceivedCalls());
        $this->assertEquals(3, count($actualCalls));
        $this->assertEquals(['resource1', 'resource2', 'resource3', 'resource4'], $actualResources);
        $this->assertEquals(
            ['token', 'nextPageToken1', 'nextPageToken2'],
            $actualTokens
        );
    }

    public function testPageStreamingFixedSizeIterationNoTimeout()
    {
        $request = MockPageStreamingRequest::createPageStreamingRequest('token', 2);
        $responseA = MockPageStreamingResponse::createPageStreamingResponse('nextPageToken1', ['resource1']);
        $responseB = MockPageStreamingResponse::createPageStreamingResponse('nextPageToken2', ['resource2']);
        $responseC = MockPageStreamingResponse::createPageStreamingResponse(null, ['resource3', 'resource4']);
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')],
            [$responseB, new MockStatus(Code::OK, '')],
            [$responseC, new MockStatus(Code::OK, '')]
        ];
        $stub = MockStub::createWithResponseSequence($responseSequence);
        $descriptor = PageStreamingDescriptor::createFromFields([
            'requestPageTokenField' => 'pageToken',
            'requestPageSizeField' => 'pageSize',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resourcesList'
        ]);
        $collectionSize = 2;
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $stub,
            'takeAction',
            $callSettings,
            ['pageStreamingDescriptor' => $descriptor]
        );
        $response = $apiCall($request, [], []);
        $actualCalls = $stub->popReceivedCalls();
        $this->assertEquals(1, count($actualCalls));
        $actualResources = [];
        $collectionCount = 0;
        foreach ($response->iterateFixedSizeCollections($collectionSize) as $collection) {
            $collectionCount += 1;
            foreach ($collection as $element) {
                array_push($actualResources, $element);
            }
        }
        $actualCalls = array_merge($actualCalls, $stub->popReceivedCalls());
        $this->assertEquals(3, count($actualCalls));
        $this->assertEquals(2, $collectionCount);
        $this->assertEquals(['resource1', 'resource2', 'resource3', 'resource4'], $actualResources);
    }

    /**
     * @expectedException \Google\ApiCore\ValidationException
     * @expectedExceptionMessage FixedSizeCollection is not supported
     */
    public function testPageStreamingFixedSizeFailPageSizeNotSupported()
    {
        $request = MockPageStreamingRequest::createPageStreamingRequest('token');
        $responseA = MockPageStreamingResponse::createPageStreamingResponse('nextPageToken1', ['resource1']);
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')],
                             ];
        $stub = MockStub::createWithResponseSequence($responseSequence);
        $descriptor = PageStreamingDescriptor::createFromFields([
            'requestPageTokenField' => 'pageToken',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resourcesList'
        ]);
        $collectionSize = 2;
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $stub,
            'takeAction',
            $callSettings,
            ['pageStreamingDescriptor' => $descriptor]
        );
        $response = $apiCall($request, [], []);
        $response->expandToFixedSizeCollection($collectionSize);
    }

    /**
     * @expectedException \Google\ApiCore\ValidationException
     * @expectedExceptionMessage No page size parameter found
     */
    public function testPageStreamingFixedSizeFailPageSizeNotSet()
    {
        $request = MockPageStreamingRequest::createPageStreamingRequest('token');
        $responseA = MockPageStreamingResponse::createPageStreamingResponse('nextPageToken1', ['resource1']);
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')],
        ];
        $stub = MockStub::createWithResponseSequence($responseSequence);
        $descriptor = PageStreamingDescriptor::createFromFields([
            'requestPageTokenField' => 'pageToken',
            'requestPageSizeField' => 'pageSize',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resourcesList'
        ]);
        $collectionSize = 2;
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $stub,
            'takeAction',
            $callSettings,
            ['pageStreamingDescriptor' => $descriptor]
        );
        $response = $apiCall($request, [], []);
        $response->expandToFixedSizeCollection($collectionSize);
    }

    /**
     * @expectedException \Google\ApiCore\ValidationException
     * @expectedExceptionMessage collectionSize parameter is less than the page size
     */
    public function testPageStreamingFixedSizeFailPageSizeTooLarge()
    {
        $collectionSize = 2;
        $request = MockPageStreamingRequest::createPageStreamingRequest('token', $collectionSize + 1);
        $responseA = MockPageStreamingResponse::createPageStreamingResponse('nextPageToken1', ['resource1']);
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')]
        ];
        $stub = MockStub::createWithResponseSequence($responseSequence);
        $descriptor = PageStreamingDescriptor::createFromFields([
            'requestPageTokenField' => 'pageToken',
            'requestPageSizeField' => 'pageSize',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resourcesList'
        ]);
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $stub,
            'takeAction',
            $callSettings,
            ['pageStreamingDescriptor' => $descriptor]
        );
        $response = $apiCall($request, [], []);
        $response->expandToFixedSizeCollection($collectionSize);
    }

    public function testPageStreamingWithTimeout()
    {
        $request = MockPageStreamingRequest::createPageStreamingRequest('token');
        $responseA = MockPageStreamingResponse::createPageStreamingResponse('nextPageToken1', ['resource1']);
        $responseB = MockPageStreamingResponse::createPageStreamingResponse('nextPageToken2', ['resource2']);
        $responseC = MockPageStreamingResponse::createPageStreamingResponse(null, ['resource3', 'resource4']);
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')],
            [$responseB, new MockStatus(Code::OK, '')],
            [$responseC, new MockStatus(Code::OK, '')]
        ];
        $stub = MockStub::createWithResponseSequence($responseSequence);
        $descriptor = PageStreamingDescriptor::createFromFields([
            'requestPageTokenField' => 'pageToken',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resourcesList'
        ]);
        $callSettings = new CallSettings(['timeout' => 1000]);
        $apiCall = ApiCallable::createApiCall(
            $stub,
            'takeAction',
            $callSettings,
            ['pageStreamingDescriptor' => $descriptor]
        );
        $response = $apiCall($request, [], []);
        $actualCalls = $stub->popReceivedCalls();
        $this->assertEquals(1, count($actualCalls));
        $actualResources = [];
        foreach ($response->iterateAllElements() as $element) {
            array_push($actualResources, $element);
        }
        $actualCalls = array_merge($actualCalls, $stub->popReceivedCalls());
        $this->assertEquals(3, count($actualCalls));
        $this->assertEquals(['resource1', 'resource2', 'resource3', 'resource4'], $actualResources);
    }

    public function testCustomHeader()
    {
        $stub = MockStub::create(new MockPageStreamingResponse());
        $headerDescriptor = new AgentHeaderDescriptor([
            'libName' => 'gccl',
            'libVersion' => '0.0.0',
            'gapicVersion' => '0.9.0',
            'apiCoreVersion' => '1.0.0',
            'phpVersion' => '5.5.0',
            'grpcVersion' => '1.0.1'
        ]);
        $apiCall = ApiCallable::createApiCall(
            $stub,
            'takeAction',
            new CallSettings(),
            ['headerDescriptor' => $headerDescriptor]
        );
        $resources = $apiCall(new MockPageStreamingRequest(), [], []);
        $actualCalls = $stub->popReceivedCalls();
        $this->assertEquals(1, count($actualCalls));
        $expectedMetadata = [
            'x-goog-api-client' => ['gl-php/5.5.0 gccl/0.0.0 gapic/0.9.0 gax/1.0.0 grpc/1.0.1']
        ];
        $this->assertEquals($expectedMetadata, $actualCalls[0]->getMetadata());
    }

    public function testUserHeaders()
    {
        $stub = MockStub::create(new MockPageStreamingResponse());
        $headerDescriptor = new AgentHeaderDescriptor([
            'libName' => 'gccl',
            'libVersion' => '0.0.0',
            'gapicVersion' => '0.9.0',
            'apiCoreVersion' => '1.0.0',
            'phpVersion' => '5.5.0',
            'grpcVersion' => '1.0.1'
        ]);
        $userHeaders = [
            'google-cloud-resource-prefix' => ['my-database'],
        ];
        $callSettings = new CallSettings([
            'userHeaders' => $userHeaders,
        ]);
        $apiCall = ApiCallable::createApiCall(
            $stub,
            'takeAction',
            $callSettings,
            ['headerDescriptor' => $headerDescriptor]
        );
        $resources = $apiCall(new MockPageStreamingRequest(), [], []);
        $actualCalls = $stub->popReceivedCalls();
        $this->assertEquals(1, count($actualCalls));
        $expectedMetadata = [
            'x-goog-api-client' => ['gl-php/5.5.0 gccl/0.0.0 gapic/0.9.0 gax/1.0.0 grpc/1.0.1'],
            'google-cloud-resource-prefix' => ['my-database'],
        ];
        $this->assertEquals($expectedMetadata, $actualCalls[0]->getMetadata());
    }

    public function testUserHeadersOverwriteBehavior()
    {
        $stub = MockStub::create(new MockPageStreamingResponse());
        $headerDescriptor = new AgentHeaderDescriptor([
            'libName' => 'gccl',
            'libVersion' => '0.0.0',
            'gapicVersion' => '0.9.0',
            'apiCoreVersion' => '1.0.0',
            'phpVersion' => '5.5.0',
            'grpcVersion' => '1.0.1'
        ]);
        $userHeaders = [
            'x-goog-api-client' => ['this-should-not-be-used'],
            'new-header' => ['this-should-be-used']
        ];
        $callSettings = new CallSettings([
            'userHeaders' => $userHeaders,
        ]);
        $apiCall = ApiCallable::createApiCall(
            $stub,
            'takeAction',
            $callSettings,
            ['headerDescriptor' => $headerDescriptor]
        );
        $resources = $apiCall(new MockPageStreamingRequest(), [], []);
        $actualCalls = $stub->popReceivedCalls();
        $this->assertEquals(1, count($actualCalls));
        $expectedMetadata = [
            'x-goog-api-client' => ['gl-php/5.5.0 gccl/0.0.0 gapic/0.9.0 gax/1.0.0 grpc/1.0.1'],
            'new-header' => ['this-should-be-used'],
        ];
        $this->assertEquals($expectedMetadata, $actualCalls[0]->getMetadata());
    }

    public static function createIncompleteOperationResponse($name, $metadataString = '')
    {
        $metadata = OperationResponseTest::createAny(OperationResponseTest::createStatus(Code::OK, $metadataString));
        $op = new Operation();
        $op->setName($name);
        $op->setMetadata($metadata);
        $op->setDone(false);
        return $op;
    }

    public static function createSuccessfulOperationResponse($name, $response, $metadataString = '')
    {
        $op = self::createIncompleteOperationResponse($name, $metadataString);
        $op->setDone(true);
        $any = OperationResponseTest::createAny($response);
        $op->setResponse($any);
        return $op;
    }

    public static function createFailedOperationResponse($name, $code, $message, $metadataString = '')
    {
        $error = OperationResponseTest::createStatus($code, $message);
        $op = self::createIncompleteOperationResponse($name, $metadataString);
        $op->setDone(true);
        $op->setError($error);
        return $op;
    }

    public function testLongRunningSuccess()
    {
        $opName = 'operation/someop';

        $request = null;
        $result = OperationResponseTest::createStatus(Code::OK, 'someMessage');
        $initialResponse = self::createIncompleteOperationResponse($opName, 'm1');
        $responseA = self::createIncompleteOperationResponse($opName, 'm2');
        $responseB = self::createSuccessfulOperationResponse($opName, $result, 'm3');
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')],
            [$responseB, new MockStatus(Code::OK, '')],
        ];
        $callStub = MockStub::createWithResponseSequence(
            [[$initialResponse, new MockStatus(Code::OK, '')]],
            ['\Google\LongRunning\Operation', 'mergeFromString']
        );
        $opStub = MockStub::createWithResponseSequence(
            $responseSequence,
            ['\Google\LongRunning\Operation', 'mergeFromString']
        );
        $opClient = OperationResponseTest::createOperationsClient($opStub);
        $descriptor = [
            'operationsClient' => $opClient,
            'operationReturnType' => '\Google\Rpc\Status',
            'metadataReturnType' => '\Google\Rpc\Status',
        ];
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $callStub,
            'takeAction',
            $callSettings,
            ['longRunningDescriptor' => $descriptor]
        );

        /* @var $response \Google\ApiCore\OperationResponse */
        $response = $apiCall($request, [], []);

        $results = [$response->getResult()];
        $errors = [$response->getError()];
        $metadataResponses = [$response->getMetadata()];
        $isDoneResponses = [$response->isDone()];

        $apiReceivedCalls = $callStub->popReceivedCalls();
        $opReceivedCallsEmpty = $opStub->popReceivedCalls();

        $this->assertSame(1, count($apiReceivedCalls));
        $this->assertSame(0, count($opReceivedCallsEmpty));

        while (!$response->isDone()) {
            $response->reload();
            $results[] = $response->getResult();
            $errors[] = $response->getError();
            $metadataResponses[] = $response->getMetadata();
            $isDoneResponses[] = $response->isDone();
        }

        $apiReceivedCallsEmpty = $callStub->popReceivedCalls();
        $opReceivedCalls = $opStub->popReceivedCalls();

        $this->assertSame(0, count($apiReceivedCallsEmpty));
        $this->assertSame(2, count($opReceivedCalls));

        $this->assertSame('takeAction', $apiReceivedCalls[0]->getFuncCall());
        $this->assertSame('GetOperation', $opReceivedCalls[0]->getFuncCall());
        $this->assertSame('GetOperation', $opReceivedCalls[1]->getFuncCall());

        $this->assertEquals([null, null, OperationResponseTest::createStatus(Code::OK, 'someMessage')], $results);
        $this->assertEquals([null, null, null], $errors);
        $this->assertEquals([
            OperationResponseTest::createStatus(Code::OK, 'm1'),
            OperationResponseTest::createStatus(Code::OK, 'm2'),
            OperationResponseTest::createStatus(Code::OK, 'm3')
        ], $metadataResponses);
        $this->assertEquals([false, false, true], $isDoneResponses);
    }

    public function testLongRunningPollingInterval()
    {
        $opName = 'operation/someop';

        $request = null;
        $result = OperationResponseTest::createStatus(Code::OK, 'someMessage');

        $initialResponse = self::createIncompleteOperationResponse($opName, 'm1');
        $responseA = self::createIncompleteOperationResponse($opName, 'm2');
        $responseB = self::createSuccessfulOperationResponse($opName, $result, 'm3');
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')],
            [$responseB, new MockStatus(Code::OK, '')],
        ];
        $callStub = MockStub::createWithResponseSequence(
            [[$initialResponse, new MockStatus(Code::OK, '')]],
            ['\Google\LongRunning\Operation', 'mergeFromString']
        );
        $opStub = MockStub::createWithResponseSequence(
            $responseSequence,
            ['\Google\LongRunning\Operation', 'mergeFromString']
        );
        $opClient = OperationResponseTest::createOperationsClient($opStub);
        $descriptor = [
            'operationsClient' => $opClient,
            'operationReturnType' => '\Google\Rpc\Status',
            'metadataReturnType' => '\Google\Rpc\Status',
        ];
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $callStub,
            'takeAction',
            $callSettings,
            ['longRunningDescriptor' => $descriptor]
        );

        /* @var $response \Google\ApiCore\OperationResponse */
        $response = $apiCall($request, [], []);

        $apiReceivedCalls = $callStub->popReceivedCalls();
        $opReceivedCallsEmpty = $opStub->popReceivedCalls();

        $this->assertSame(1, count($apiReceivedCalls));
        $this->assertSame(0, count($opReceivedCallsEmpty));

        $complete = $response->pollUntilComplete(['pollingIntervalSeconds' => 0.1]);
        $this->assertTrue($complete);
        $this->assertTrue($response->isDone());

        $apiReceivedCallsEmpty = $callStub->popReceivedCalls();
        $opReceivedCalls = $opStub->popReceivedCalls();

        $this->assertSame(0, count($apiReceivedCallsEmpty));
        $this->assertSame(2, count($opReceivedCalls));

        $this->assertSame('takeAction', $apiReceivedCalls[0]->getFuncCall());
        $this->assertSame('GetOperation', $opReceivedCalls[0]->getFuncCall());
        $this->assertSame('GetOperation', $opReceivedCalls[1]->getFuncCall());

        $this->assertEquals(
            OperationResponseTest::createStatus(Code::OK, 'someMessage'),
            $response->getResult()
        );
        $this->assertNull($response->getError());
        $this->assertEquals(
            OperationResponseTest::createStatus(Code::OK, 'm3'),
            $response->getMetadata()
        );
    }

    public function testLongRunningMaxPollingDuration()
    {
        $opName = 'operation/someop';

        $request = null;
        $result = OperationResponseTest::createStatus(Code::OK, 'someMessage');

        $initialResponse = self::createIncompleteOperationResponse($opName, 'm1');
        $responseA = self::createIncompleteOperationResponse($opName, 'm2');
        $responseB = self::createIncompleteOperationResponse($opName, 'm3');
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')],
            [$responseB, new MockStatus(Code::OK, '')],
        ];
        $callStub = MockStub::createWithResponseSequence(
            [[$initialResponse, new MockStatus(Code::OK, '')]],
            ['\Google\LongRunning\Operation', 'mergeFromString']
        );
        $opStub = MockStub::createWithResponseSequence(
            $responseSequence,
            ['\Google\LongRunning\Operation', 'mergeFromString']
        );
        $opClient = OperationResponseTest::createOperationsClient($opStub);
        $descriptor = [
            'operationsClient' => $opClient,
            'operationReturnType' => '\Google\Rpc\Status',
            'metadataReturnType' => '\Google\Rpc\Status',
        ];
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $callStub,
            'takeAction',
            $callSettings,
            ['longRunningDescriptor' => $descriptor]
        );

        /* @var $response \Google\ApiCore\OperationResponse */
        $response = $apiCall($request, [], []);

        $apiReceivedCalls = $callStub->popReceivedCalls();
        $opReceivedCallsEmpty = $opStub->popReceivedCalls();

        $this->assertSame(1, count($apiReceivedCalls));
        $this->assertSame(0, count($opReceivedCallsEmpty));

        $complete = $response->pollUntilComplete([
            'pollingIntervalSeconds' => 0.1,
            'maxPollingDurationSeconds' => 0.15,
        ]);
        $this->assertFalse($complete);
        $this->assertFalse($response->isDone());

        $apiReceivedCallsEmpty = $callStub->popReceivedCalls();
        $opReceivedCalls = $opStub->popReceivedCalls();

        $this->assertSame(0, count($apiReceivedCallsEmpty));
        $this->assertSame(2, count($opReceivedCalls));

        $this->assertSame('takeAction', $apiReceivedCalls[0]->getFuncCall());
        $this->assertSame('GetOperation', $opReceivedCalls[0]->getFuncCall());

        $this->assertNull($response->getResult());
        $this->assertNull($response->getError());
        $this->assertEquals(
            OperationResponseTest::createStatus(Code::OK, 'm3'),
            $response->getMetadata()
        );
    }

    public function testLongRunningFailure()
    {
        $opName = 'operation/someop';

        $request = null;

        $initialResponse = self::createIncompleteOperationResponse($opName, 'm1');
        $responseA = self::createIncompleteOperationResponse($opName, 'm2');
        $responseB = self::createFailedOperationResponse($opName, Code::UNKNOWN, 'someError', 'm3');
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')],
            [$responseB, new MockStatus(Code::OK, '')],
        ];
        $callStub = MockStub::createWithResponseSequence(
            [[$initialResponse, new MockStatus(Code::OK, '')]],
            ['\Google\LongRunning\Operation', 'mergeFromString']
        );
        $opStub = MockStub::createWithResponseSequence(
            $responseSequence,
            ['\Google\LongRunning\Operation', 'mergeFromString']
        );
        $opClient = OperationResponseTest::createOperationsClient($opStub);
        $descriptor = [
            'operationsClient' => $opClient,
            'operationReturnType' => '\Google\Rpc\Status',
            'metadataReturnType' => '\Google\Rpc\Status',
        ];
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $callStub,
            'takeAction',
            $callSettings,
            ['longRunningDescriptor' => $descriptor]
        );

        /* @var $response \Google\ApiCore\OperationResponse */
        $response = $apiCall($request, [], []);

        $results = [$response->getResult()];
        $errors = [$response->getError()];
        $metadataResponses = [$response->getMetadata()];
        $isDoneResponses = [$response->isDone()];

        $apiReceivedCalls = $callStub->popReceivedCalls();
        $opReceivedCallsEmpty = $opStub->popReceivedCalls();

        $this->assertSame(1, count($apiReceivedCalls));
        $this->assertSame(0, count($opReceivedCallsEmpty));

        while (!$response->isDone()) {
            $response->reload();
            $results[] = $response->getResult();
            $errors[] = $response->getError();
            $metadataResponses[] = $response->getMetadata();
            $isDoneResponses[] = $response->isDone();
        }

        $apiReceivedCallsEmpty = $callStub->popReceivedCalls();
        $opReceivedCalls = $opStub->popReceivedCalls();

        $this->assertSame(0, count($apiReceivedCallsEmpty));
        $this->assertSame(2, count($opReceivedCalls));

        $this->assertSame('takeAction', $apiReceivedCalls[0]->getFuncCall());
        $this->assertSame('GetOperation', $opReceivedCalls[0]->getFuncCall());
        $this->assertSame('GetOperation', $opReceivedCalls[1]->getFuncCall());

        $this->assertEquals([null, null, null], $results);
        $this->assertEquals(
            [null, null, OperationResponseTest::createStatus(Code::UNKNOWN, 'someError')],
            $errors
        );
        $this->assertEquals([
            OperationResponseTest::createStatus(Code::OK, 'm1'),
            OperationResponseTest::createStatus(Code::OK, 'm2'),
            OperationResponseTest::createStatus(Code::OK, 'm3')
        ], $metadataResponses);
        $this->assertEquals([false, false, true], $isDoneResponses);
    }

    public function testLongRunningCancel()
    {
        $opName = 'operation/someop';

        $request = null;

        $initialResponse = self::createIncompleteOperationResponse($opName, 'm1');
        $responseA = self::createIncompleteOperationResponse($opName, 'm2');
        $responseB = self::createFailedOperationResponse(
            $opName,
            Code::CANCELLED,
            'someError',
            'm3'
        );
        $responseSequence = [
            [new GPBEmpty(), new MockStatus(Code::OK, '')],
            [$responseA, new MockStatus(Code::OK, '')],
            [$responseB, new MockStatus(Code::OK, '')],
        ];
        $callStub = MockStub::createWithResponseSequence(
            [[$initialResponse, new MockStatus(Code::OK, '')]],
            ['\Google\LongRunning\Operation', 'mergeFromString']
        );
        $opStub = MockStub::createWithResponseSequence(
            $responseSequence,
            ['\Google\LongRunning\Operation', 'mergeFromString']
        );
        $opClient = OperationResponseTest::createOperationsClient($opStub);
        $descriptor = [
            'operationsClient' => $opClient,
            'operationReturnType' => '\Google\Rpc\Status',
            'metadataReturnType' => '\Google\Rpc\Status',
        ];
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $callStub,
            'takeAction',
            $callSettings,
            ['longRunningDescriptor' => $descriptor]
        );

        /* @var $response \Google\ApiCore\OperationResponse */
        $response = $apiCall($request, [], []);

        $apiReceivedCalls = $callStub->popReceivedCalls();
        $opReceivedCallsEmpty = $opStub->popReceivedCalls();

        $this->assertSame(1, count($apiReceivedCalls));
        $this->assertSame(0, count($opReceivedCallsEmpty));

        $response->cancel();

        $apiReceivedCallsEmpty = $callStub->popReceivedCalls();
        $opReceivedCalls = $opStub->popReceivedCalls();

        $this->assertSame(0, count($apiReceivedCallsEmpty));
        $this->assertSame(1, count($opReceivedCalls));

        while (!$response->isDone()) {
            $response->reload();
        }

        $apiReceivedCallsEmpty = $callStub->popReceivedCalls();
        $opReceivedCalls = array_merge($opReceivedCalls, $opStub->popReceivedCalls());

        $this->assertSame(0, count($apiReceivedCallsEmpty));
        $this->assertSame(3, count($opReceivedCalls));

        $this->assertSame('takeAction', $apiReceivedCalls[0]->getFuncCall());
        $this->assertSame('CancelOperation', $opReceivedCalls[0]->getFuncCall());
        $this->assertSame('GetOperation', $opReceivedCalls[1]->getFuncCall());
        $this->assertSame('GetOperation', $opReceivedCalls[2]->getFuncCall());

        $this->assertNull($response->getResult());
        $this->assertEquals(OperationResponseTest::createStatus(Code::CANCELLED, 'someError'), $response->getError());
        $this->assertEquals(OperationResponseTest::createStatus(Code::OK, 'm3'), $response->getMetadata());
    }

    /**
     * @expectedException \Google\ApiCore\ValidationException
     * @expectedExceptionMessage Cannot call reload() on a deleted operation
     */
    public function testLongRunningDelete()
    {
        $opName = 'operation/someop';

        $request = null;

        $initialResponse = self::createIncompleteOperationResponse($opName, 'm1');
        $callStub = MockStub::createWithResponseSequence(
            [[$initialResponse, new MockStatus(Code::OK, '')]],
            ['\Google\LongRunning\Operation', 'mergeFromString']
        );
        $opStub = MockStub::createWithResponseSequence(
            [[new GPBEmpty(), new MockStatus(Code::OK, '')]],
            ['\Google\LongRunning\Operation', 'mergeFromString']
        );
        $opClient = OperationResponseTest::createOperationsClient($opStub);
        $descriptor = [
            'operationsClient' => $opClient,
            'operationReturnType' => '\Google\Rpc\Status',
            'metadataReturnType' => '\Google\Rpc\Status',
        ];
        $callSettings = new CallSettings();
        $apiCall = ApiCallable::createApiCall(
            $callStub,
            'takeAction',
            $callSettings,
            ['longRunningDescriptor' => $descriptor]
        );

        /* @var $response \Google\ApiCore\OperationResponse */
        $response = $apiCall($request, [], []);

        $apiReceivedCalls = $callStub->popReceivedCalls();
        $opReceivedCallsEmpty = $opStub->popReceivedCalls();

        $this->assertSame(1, count($apiReceivedCalls));
        $this->assertSame(0, count($opReceivedCallsEmpty));

        $response->delete();

        $apiReceivedCallsEmpty = $callStub->popReceivedCalls();
        $opReceivedCalls = $opStub->popReceivedCalls();

        $this->assertSame(0, count($apiReceivedCallsEmpty));
        $this->assertSame(1, count($opReceivedCalls));

        $this->assertSame('takeAction', $apiReceivedCalls[0]->getFuncCall());
        $this->assertSame('DeleteOperation', $opReceivedCalls[0]->getFuncCall());

        $response->reload();
    }

    public function testClientStreamingSuccessSimple()
    {
        $request = "request";
        $response = "response";
        $descriptor = [
            'grpcStreamingType' => 'ClientStreaming',
        ];
        $this->clientStreamingTestImpl($request, $response, $descriptor, null);
    }

    public function testClientStreamingSuccessObject()
    {
        $request = new Status();
        $request->setCode(Code::OK);
        $request->setMessage('request');
        $response = new Status();
        $response->setCode(Code::OK);
        $response->setMessage('response');
        $descriptor = [
            'grpcStreamingType' => 'ClientStreaming',
        ];
        $this->clientStreamingTestImpl($request, $response, $descriptor, ['\Google\Rpc\Status', 'mergeFromString']);
    }

    private function clientStreamingTestImpl($request, $response, $descriptor, $deserialize)
    {
        $metadata = [];
        $options = ['call_credentials_callback' => 'fake_callback'];
        $stub = MockClientStreamingStub::create($response, null, $deserialize);

        $callSettings = new CallSettings([]);

        $apiCall = ApiCallable::createApiCall(
            $stub,
            'takeAction',
            $callSettings,
            ['grpcStreamingDescriptor' => $descriptor]
        );

        /* @var $stream \Google\ApiCore\ClientStream */
        $stream = $apiCall(null, $metadata, $options);
        $actualResponse = $stream->writeAllAndReadResponse([$request]);
        $this->assertEquals($response, $actualResponse);

        $actualCalls = $stub->popReceivedCalls();
        $this->assertSame(1, count($actualCalls));
        $this->assertNull($actualCalls[0]->getRequestObject());
        $this->assertEquals($metadata, $actualCalls[0]->getMetadata());
        $this->assertEquals($options, $actualCalls[0]->getOptions());

        /* @var $mockClientStreamingCall \Google\ApiCore\Testing\MockClientStreamingCall */
        $mockClientStreamingCall = $stream->getClientStreamingCall();
        $actualStreamingCalls = $mockClientStreamingCall->popReceivedCalls();
        $this->assertSame(1, count($actualStreamingCalls));
        $this->assertEquals($request, $actualStreamingCalls[0]);
    }

    /**
     * @expectedException \Google\ApiCore\ApiException
     * @expectedExceptionMessage client streaming failure
     */
    public function testClientStreamingFailure()
    {
        $request = "request";
        $response = "response";
        $descriptor = [
            'grpcStreamingType' => 'ClientStreaming',
        ];

        $finalStatus = new MockStatus(Code::INTERNAL, 'client streaming failure');

        $metadata = [];
        $options = ['call_credentials_callback' => 'fake_callback'];
        $stub = MockClientStreamingStub::create($response, $finalStatus);

        $callSettings = new CallSettings([]);
        $apiCall = ApiCallable::createApiCall(
            $stub,
            'takeAction',
            $callSettings,
            ['grpcStreamingDescriptor' => $descriptor]
        );

        /* @var $stream \Google\ApiCore\ClientStream */
        $stream = $apiCall(null, $metadata, $options);
        $stream->write($request);

        $actualCalls = $stub->popReceivedCalls();
        $this->assertSame(1, count($actualCalls));
        $this->assertNull($actualCalls[0]->getRequestObject());
        $this->assertEquals($metadata, $actualCalls[0]->getMetadata());
        $this->assertEquals($options, $actualCalls[0]->getOptions());

        /* @var $mockClientStreamingCall \Google\ApiCore\Testing\MockClientStreamingCall */
        $mockClientStreamingCall = $stream->getClientStreamingCall();
        $actualStreamingCalls = $mockClientStreamingCall->popReceivedCalls();
        $this->assertSame(1, count($actualStreamingCalls));
        $this->assertEquals($request, $actualStreamingCalls[0]);

        $stream->readResponse();
    }

    public function testServerStreamingSuccessSimple()
    {
        $request = "request";
        $response = "response";
        $responses = [$response];
        $descriptor = [
            'grpcStreamingType' => 'ServerStreaming',
        ];
        $this->serverStreamingTestImpl($request, $responses, $descriptor, null);
    }

    public function testServerStreamingSuccessObject()
    {
        $request = new Status();
        $request->setCode(Code::OK);
        $request->setMessage('request');
        $response = new Status();
        $response->setCode(Code::OK);
        $response->setMessage('response');
        $responses = [$response];
        $descriptor = [
            'grpcStreamingType' => 'ServerStreaming',
        ];
        $this->serverStreamingTestImpl($request, $responses, $descriptor, ['\Google\Rpc\Status', 'mergeFromString']);
    }

    private function serverStreamingTestImpl($request, $responses, $descriptor, $deserialize)
    {
        $metadata = [];
        $options = ['call_credentials_callback' => 'fake_callback'];
        $stub = MockServerStreamingStub::createWithResponseSequence($responses, null, $deserialize);

        $callSettings = new CallSettings([]);
        $apiCall = ApiCallable::createApiCall(
            $stub,
            'takeAction',
            $callSettings,
            ['grpcStreamingDescriptor' => $descriptor]
        );

        /* @var $stream \Google\ApiCore\ServerStream */
        $stream = $apiCall($request, $metadata, $options);
        $actualResponses = iterator_to_array($stream->readAll());
        $this->assertSame(1, count($actualResponses));
        $this->assertEquals($responses, $actualResponses);

        $actualCalls = $stub->popReceivedCalls();
        $this->assertSame(1, count($actualCalls));
        $this->assertEquals($request, $actualCalls[0]->getRequestObject());
        $this->assertEquals($metadata, $actualCalls[0]->getMetadata());
        $this->assertEquals($options, $actualCalls[0]->getOptions());
    }

    public function testServerStreamingSuccessResources()
    {
        $request = new Status();
        $request->setCode(Code::OK);
        $request->setMessage('request');
        $resources = ['resource1', 'resource2'];
        $repeatedField = new RepeatedField(GPBType::STRING);
        foreach ($resources as $resource) {
            $repeatedField[] = $resource;
        }
        $response = MockPageStreamingResponse::createPageStreamingResponse(
            'nextPageToken',
            $repeatedField
        );
        $responses = [$response];
        $descriptor = [
            'grpcStreamingType' => 'ServerStreaming',
            'resourcesGetMethod' => 'getResourcesList',
        ];

        $metadata = [];
        $options = ['call_credentials_callback' => 'fake_callback'];
        $stub = MockServerStreamingStub::createWithResponseSequence($responses);

        $callSettings = new CallSettings([]);
        $apiCall = ApiCallable::createApiCall(
            $stub,
            'takeAction',
            $callSettings,
            ['grpcStreamingDescriptor' => $descriptor]
        );

        /* @var $stream \Google\ApiCore\ServerStream */
        $stream = $apiCall($request, $metadata, $options);
        $actualResponses = iterator_to_array($stream->readAll());
        $this->assertSame(2, count($actualResponses));
        $this->assertEquals($resources, $actualResponses);

        $actualCalls = $stub->popReceivedCalls();
        $this->assertSame(1, count($actualCalls));
        $this->assertEquals($request, $actualCalls[0]->getRequestObject());
        $this->assertEquals($metadata, $actualCalls[0]->getMetadata());
        $this->assertEquals($options, $actualCalls[0]->getOptions());
    }

    /**
     * @expectedException \Google\ApiCore\ApiException
     * @expectedExceptionMessage server streaming failure
     */
    public function testServerStreamingFailure()
    {
        $request = "request";
        $response = "response";
        $responses = [$response];
        $descriptor = [
            'grpcStreamingType' => 'ServerStreaming',
        ];

        $finalStatus = new MockStatus(Code::INTERNAL, 'server streaming failure');

        $metadata = [];
        $options = ['call_credentials_callback' => 'fake_callback'];
        $stub = MockServerStreamingStub::createWithResponseSequence($responses, $finalStatus);

        $callSettings = new CallSettings([]);
        $apiCall = ApiCallable::createApiCall(
            $stub,
            'takeAction',
            $callSettings,
            ['grpcStreamingDescriptor' => $descriptor]
        );

        /* @var $stream \Google\ApiCore\ServerStream */
        $stream = $apiCall($request, $metadata, $options);

        foreach ($stream->readAll() as $actualResponse) {
            $this->assertEquals($response, $actualResponse);

            $actualCalls = $stub->popReceivedCalls();
            $this->assertSame(1, count($actualCalls));
            $this->assertEquals($request, $actualCalls[0]->getRequestObject());
            $this->assertEquals($metadata, $actualCalls[0]->getMetadata());
            $this->assertEquals($options, $actualCalls[0]->getOptions());
        }
    }

    public function testBidiStreamingSuccessSimple()
    {
        $request = "request";
        $response = "response";
        $descriptor = [
            'grpcStreamingType' => 'BidiStreaming',
        ];
        $this->bidiStreamingTestImpl($request, [$response], $descriptor, null);
    }

    public function testBidiStreamingSuccessObject()
    {
        $request = new Status();
        $request->setCode(Code::OK);
        $request->setMessage('request');
        $response = new Status();
        $response->setCode(Code::OK);
        $response->setMessage('response');
        $descriptor = [
            'grpcStreamingType' => 'BidiStreaming',
        ];
        $this->bidiStreamingTestImpl($request, [$response], $descriptor, ['\Google\Rpc\Status', 'mergeFromString']);
    }

    private function bidiStreamingTestImpl($request, $responses, $descriptor, $deserialize)
    {
        $metadata = [];
        $options = ['call_credentials_callback' => 'fake_callback'];
        $stub = MockBidiStreamingStub::createWithResponseSequence($responses, null, $deserialize);

        $callSettings = new CallSettings([]);
        $apiCall = ApiCallable::createApiCall(
            $stub,
            'takeAction',
            $callSettings,
            ['grpcStreamingDescriptor' => $descriptor]
        );

        /* @var $stream \Google\ApiCore\BidiStream */
        $stream = $apiCall(null, $metadata, $options);
        $stream->write($request);
        $actualResponses = iterator_to_array($stream->closeWriteAndReadAll());
        $this->assertSame(1, count($actualResponses));
        $this->assertEquals($responses, $actualResponses);

        $actualCalls = $stub->popReceivedCalls();
        $this->assertSame(1, count($actualCalls));
        $this->assertNull($actualCalls[0]->getRequestObject());
        $this->assertEquals($metadata, $actualCalls[0]->getMetadata());
        $this->assertEquals($options, $actualCalls[0]->getOptions());

        /* @var $mockBidiStreamingCall \Google\ApiCore\Testing\MockBidiStreamingCall */
        $mockBidiStreamingCall = $stream->getBidiStreamingCall();
        $actualStreamingCalls = $mockBidiStreamingCall->popReceivedCalls();
        $this->assertSame(1, count($actualStreamingCalls));
        $this->assertEquals($request, $actualStreamingCalls[0]);
    }

    public function testBidiStreamingSuccessResources()
    {
        $request = new Status();
        $request->setCode(Code::OK);
        $request->setMessage('request');
        $resources = ['resource1', 'resource2'];
        $repeatedField = new RepeatedField(GPBType::STRING);
        foreach ($resources as $resource) {
            $repeatedField[] = $resource;
        }
        $response = MockPageStreamingResponse::createPageStreamingResponse(
            'nextPageToken',
            $repeatedField
        );
        $descriptor = [
            'grpcStreamingType' => 'BidiStreaming',
            'resourcesGetMethod' => 'getResourcesList',
        ];

        $metadata = [];
        $options = ['call_credentials_callback' => 'fake_callback'];
        $stub = MockBidiStreamingStub::createWithResponseSequence([$response]);

        $callSettings = new CallSettings([]);
        $apiCall = ApiCallable::createApiCall(
            $stub,
            'takeAction',
            $callSettings,
            ['grpcStreamingDescriptor' => $descriptor]
        );

        /* @var $stream \Google\ApiCore\BidiStream */
        $stream = $apiCall(null, $metadata, $options);
        $stream->write($request);
        $actualResponses = iterator_to_array($stream->closeWriteAndReadAll());
        $this->assertSame(2, count($actualResponses));
        $this->assertEquals($resources, $actualResponses);

        $actualCalls = $stub->popReceivedCalls();
        $this->assertSame(1, count($actualCalls));
        $this->assertNull($actualCalls[0]->getRequestObject());
        $this->assertEquals($metadata, $actualCalls[0]->getMetadata());
        $this->assertEquals($options, $actualCalls[0]->getOptions());

        /* @var $mockBidiStreamingCall \Google\ApiCore\Testing\MockBidiStreamingCall */
        $mockBidiStreamingCall = $stream->getBidiStreamingCall();
        $actualStreamingCalls = $mockBidiStreamingCall->popReceivedCalls();
        $this->assertSame(1, count($actualStreamingCalls));
        $this->assertEquals($request, $actualStreamingCalls[0]);
    }

    /**
     * @expectedException \Google\ApiCore\ApiException
     * @expectedExceptionMessage bidi failure
     */
    public function testBidiStreamingFailure()
    {
        $request = "request";
        $response = "response";
        $descriptor = [
            'grpcStreamingType' => 'BidiStreaming',
        ];
        $responses = [$response];

        $finalStatus = new MockStatus(Code::INTERNAL, 'bidi failure');

        $metadata = [];
        $options = ['call_credentials_callback' => 'fake_callback'];
        $stub = MockBidiStreamingStub::createWithResponseSequence($responses, $finalStatus);

        $callSettings = new CallSettings([]);
        $apiCall = ApiCallable::createApiCall(
            $stub,
            'takeAction',
            $callSettings,
            ['grpcStreamingDescriptor' => $descriptor]
        );

        /* @var $stream \Google\ApiCore\BidiStream */
        $stream = $apiCall(null, $metadata, $options);
        $stream->write($request);
        $stream->closeWrite();
        $actualResponse = $stream->read();
        $this->assertEquals($response, $actualResponse);

        $actualCalls = $stub->popReceivedCalls();
        $this->assertSame(1, count($actualCalls));
        $this->assertNull($actualCalls[0]->getRequestObject());
        $this->assertEquals($metadata, $actualCalls[0]->getMetadata());
        $this->assertEquals($options, $actualCalls[0]->getOptions());

        /* @var $mockBidiStreamingCall \Google\ApiCore\Testing\MockBidiStreamingCall */
        $mockBidiStreamingCall = $stream->getBidiStreamingCall();
        $actualStreamingCalls = $mockBidiStreamingCall->popReceivedCalls();
        $this->assertSame(1, count($actualStreamingCalls));
        $this->assertEquals($request, $actualStreamingCalls[0]);

        $stream->read();
    }
}
