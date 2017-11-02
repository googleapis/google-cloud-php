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

namespace Google\Cloud\Tests\Unit\Core;

use Google\Cloud\Tests\GrpcTestTrait;
use Google\Cloud\Tests\MockTrait;
use Google\Cloud\Tests\Mocks\MockBidiStreamingTransport;
use Google\Cloud\Tests\Mocks\MockClientStreamingTransport;
use Google\Cloud\Tests\Mocks\MockServerStreamingTransport;
use Google\Cloud\Tests\Mocks\MockTransport;
use Google\Cloud\Tests\Mocks\MockStreamingTransport;
use Google\Cloud\Tests\Mocks\MockRequest;
use Google\GAX\ApiException;
use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\CallSettings;
use Google\GAX\PagedListResponse;
use Google\GAX\PageStreamingDescriptor;
use Google\GAX\RetrySettings;
use Google\GAX\ApiStatus;
use Google\GAX\Testing\MockStatus;
use Google\GAX\ValidationException;
use Google\Longrunning\Operation;
use Google\Protobuf\GPBEmpty;
use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Rpc\Code;
use Google\Rpc\Status;
use PHPUnit_Framework_TestCase;

class CallStackTraitTest extends PHPUnit_Framework_TestCase
{
    use GrpcTestTrait;
    use MockTrait;

    public function testBaseCall()
    {
        $request = "request";
        $metadata = [];
        $options = ['call_credentials_callback' => 'fake_callback'];
        $response = "response";
        $transport = MockTransport::create($response);

        $callSettings = new CallSettings([]);
        $apiCall = $transport->createApiCall('takeAction', $callSettings);
        $actualResponse = $apiCall($request, $options);
        $this->assertEquals($response, $actualResponse);

        $actualCalls = $transport->popReceivedCalls();
        $this->assertEquals(1, count($actualCalls));
        $this->assertEquals($request, $actualCalls[0]->getRequestObject());
        $this->assertEquals($metadata, $actualCalls[0]->getMetadata());
        $this->assertEquals($options, $actualCalls[0]->getOptions());
    }

    public function testTimeout()
    {
        $request = "request";
        $response = "response";
        $transport = MockTransport::create($response);

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
        $apiCall = $transport->createApiCall('takeAction', $callSettings);
        $actualResponse = $apiCall($request, []);

        $this->assertEquals($response, $actualResponse);

        $actualCalls = $transport->popReceivedCalls();
        $this->assertEquals(1, count($actualCalls));
        $this->assertEquals($request, $actualCalls[0]->getRequestObject());
        $this->assertEquals([], $actualCalls[0]->getMetadata());
        $this->assertEquals(['timeoutMillis' => 1500], $actualCalls[0]->getOptions());
    }

    public function testRetryNoRetryableCode()
    {
        $request = "request";
        $response = "response";
        $status = new MockStatus(Code::DEADLINE_EXCEEDED, 'Deadline Exceeded');
        $transport = MockTransport::createWithResponseSequence([[$response, $status]]);
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
            $apiCall = $transport->createApiCall('takeAction', $callSettings);
            $response = $apiCall($request, []);
        } catch (\Exception $e) {
            $isExceptionRaised = true;
        }

        $actualCalls = $transport->popReceivedCalls();
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
        $transport = MockTransport::createWithResponseSequence($responseSequence);
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
        $apiCall = $transport->createApiCall('takeAction', $callSettings);
        $actualResponse = $apiCall($request, []);

        $this->assertEquals($responseC, $actualResponse);

        $actualCalls = $transport->popReceivedCalls();
        $this->assertEquals(3, count($actualCalls));

        $this->assertEquals($request, $actualCalls[0]->getRequestObject());
        $this->assertEquals(['timeoutMillis' => 150], $actualCalls[0]->getOptions());

        $this->assertEquals($request, $actualCalls[1]->getRequestObject());
        $this->assertEquals(['timeoutMillis' => 300], $actualCalls[1]->getOptions());

        $this->assertEquals($request, $actualCalls[2]->getRequestObject());
        $this->assertEquals(['timeoutMillis' => 500], $actualCalls[2]->getOptions());
    }

    public function testRetryTimeoutExceeds()
    {
        $request = "request";
        $response = "response";
        $status = new MockStatus(Code::DEADLINE_EXCEEDED, 'Deadline Exceeded');
        $transport = MockTransport::createWithResponseSequence([
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
        $timeFuncMillis = function () use ($transport, $incrementMillis, $elapsed) {
            $actualCalls = $transport->getReceivedCallCount();
            return $actualCalls * $incrementMillis;
        };

        $raisedException = null;
        try {
            $apiCall = $transport->createApiCall(
                'takeAction',
                $callSettings,
                ['timeFuncMillis' => $timeFuncMillis]
            );
            $response = $apiCall($request, []);
        } catch (ApiException $e) {
            $raisedException = $e;
        }

        $actualCalls = $transport->popReceivedCalls();
        $this->assertEquals(3, count($actualCalls));
        $this->assertEquals($request, $actualCalls[0]->getRequestObject());

        $this->assertTrue(!empty($raisedException));
        $this->assertEquals(Code::DEADLINE_EXCEEDED, $raisedException->getCode());
    }

    public function testRetryTimeoutExceedsRealTime()
    {
        $request = "request";
        $response = "response";
        $transport = MockTransport::createWithResponseSequence([]);
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
            $apiCall = $transport->createApiCall('methodThatSleeps', $callSettings);
            $response = $apiCall($request, []);
        } catch (ApiException $e) {
            $raisedException = $e;
        }

        $actualCalls = $transport->popReceivedCalls();
        $this->assertEquals(3, count($actualCalls));
        $this->assertEquals($request, $actualCalls[0]->getRequestObject());

        $this->assertTrue(!empty($raisedException));
        $this->assertEquals(Code::DEADLINE_EXCEEDED, $raisedException->getCode());
    }

    public function testPageStreamingDirectIterationNoTimeout()
    {
        $request = $this->createMockRequest('token');
        $responseA = $this->createMockResponse('nextPageToken1', ['resource1']);
        $responseB = $this->createMockResponse('nextPageToken2', ['resource2']);
        $responseC = $this->createMockResponse(null, ['resource3', 'resource4']);
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')],
            [$responseB, new MockStatus(Code::OK, '')],
            [$responseC, new MockStatus(Code::OK, '')]
        ];
        $transport = MockTransport::createWithResponseSequence($responseSequence);
        $descriptor = PageStreamingDescriptor::createFromFields([
            'requestPageTokenField' => 'pageToken',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resourcesList'
        ]);
        $callSettings = new CallSettings();
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['pageStreamingDescriptor' => $descriptor]
        );
        $response = $apiCall($request, []);
        $actualCalls = $transport->popReceivedCalls();
        $this->assertEquals(1, count($actualCalls));
        $actualResources = [];
        foreach ($response->iterateAllElements() as $element) {
            array_push($actualResources, $element);
        }
        $actualCalls = array_merge($actualCalls, $transport->popReceivedCalls());
        $this->assertEquals(3, count($actualCalls));
        $this->assertEquals(['resource1', 'resource2', 'resource3', 'resource4'], $actualResources);
    }

    public function testPageStreamingPageIterationNoTimeout()
    {
        $request = $this->createMockRequest('token', 3);
        $responseA = $this->createMockResponse('nextPageToken1', ['resource1']);
        $responseB = $this->createMockResponse('nextPageToken2', ['resource2']);
        $responseC = $this->createMockResponse(null, ['resource3', 'resource4']);
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')],
            [$responseB, new MockStatus(Code::OK, '')],
            [$responseC, new MockStatus(Code::OK, '')]
        ];
        $transport = MockTransport::createWithResponseSequence($responseSequence);
        $descriptor = PageStreamingDescriptor::createFromFields([
            'requestPageTokenField' => 'pageToken',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resourcesList'
        ]);
        $callSettings = new CallSettings();
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['pageStreamingDescriptor' => $descriptor]
        );
        /** @var PagedListResponse $response */
        $response = $apiCall($request, []);
        $actualCalls = $transport->popReceivedCalls();
        $this->assertEquals(1, count($actualCalls));
        $actualResources = [];
        $actualTokens = [];
        foreach ($response->iteratePages() as $page) {
            array_push($actualTokens, $page->getRequestObject()->getPageToken());
            foreach ($page as $element) {
                array_push($actualResources, $element);
            }
        }
        $actualCalls = array_merge($actualCalls, $transport->popReceivedCalls());
        $this->assertEquals(3, count($actualCalls));
        $this->assertEquals(['resource1', 'resource2', 'resource3', 'resource4'], $actualResources);
        $this->assertEquals(
            ['token', 'nextPageToken1', 'nextPageToken2'],
            $actualTokens
        );
    }

    public function testPageStreamingFixedSizeIterationNoTimeout()
    {
        $request = $this->createMockRequest('token', 2);
        $responseA = $this->createMockResponse('nextPageToken1', ['resource1']);
        $responseB = $this->createMockResponse('nextPageToken2', ['resource2']);
        $responseC = $this->createMockResponse(null, ['resource3', 'resource4']);
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')],
            [$responseB, new MockStatus(Code::OK, '')],
            [$responseC, new MockStatus(Code::OK, '')]
        ];
        $transport = MockTransport::createWithResponseSequence($responseSequence);
        $descriptor = PageStreamingDescriptor::createFromFields([
            'requestPageTokenField' => 'pageToken',
            'requestPageSizeField' => 'pageSize',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resourcesList'
        ]);
        $collectionSize = 2;
        $callSettings = new CallSettings();
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['pageStreamingDescriptor' => $descriptor]
        );
        $response = $apiCall($request, []);
        $actualCalls = $transport->popReceivedCalls();
        $this->assertEquals(1, count($actualCalls));
        $actualResources = [];
        $collectionCount = 0;
        foreach ($response->iterateFixedSizeCollections($collectionSize) as $collection) {
            $collectionCount += 1;
            foreach ($collection as $element) {
                array_push($actualResources, $element);
            }
        }
        $actualCalls = array_merge($actualCalls, $transport->popReceivedCalls());
        $this->assertEquals(3, count($actualCalls));
        $this->assertEquals(2, $collectionCount);
        $this->assertEquals(['resource1', 'resource2', 'resource3', 'resource4'], $actualResources);
    }

    /**
     * @expectedException \Google\GAX\ValidationException
     * @expectedExceptionMessage FixedSizeCollection is not supported
     */
    public function testPageStreamingFixedSizeFailPageSizeNotSupported()
    {
        $request = $this->createMockRequest('token');
        $responseA = $this->createMockResponse('nextPageToken1', ['resource1']);
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')],
                             ];
        $transport = MockTransport::createWithResponseSequence($responseSequence);
        $descriptor = PageStreamingDescriptor::createFromFields([
            'requestPageTokenField' => 'pageToken',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resourcesList'
        ]);
        $collectionSize = 2;
        $callSettings = new CallSettings();
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['pageStreamingDescriptor' => $descriptor]
        );
        $response = $apiCall($request, []);
        $response->expandToFixedSizeCollection($collectionSize);
    }

    /**
     * @expectedException \Google\GAX\ValidationException
     * @expectedExceptionMessage No page size parameter found
     */
    public function testPageStreamingFixedSizeFailPageSizeNotSet()
    {
        $request = $this->createMockRequest('token');
        $responseA = $this->createMockResponse('nextPageToken1', ['resource1']);
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')],
        ];
        $transport = MockTransport::createWithResponseSequence($responseSequence);
        $descriptor = PageStreamingDescriptor::createFromFields([
            'requestPageTokenField' => 'pageToken',
            'requestPageSizeField' => 'pageSize',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resourcesList'
        ]);
        $collectionSize = 2;
        $callSettings = new CallSettings();
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['pageStreamingDescriptor' => $descriptor]
        );
        $response = $apiCall($request, []);
        $response->expandToFixedSizeCollection($collectionSize);
    }

    /**
     * @expectedException \Google\GAX\ValidationException
     * @expectedExceptionMessage collectionSize parameter is less than the page size
     */
    public function testPageStreamingFixedSizeFailPageSizeTooLarge()
    {
        $collectionSize = 2;
        $request = $this->createMockRequest('token', $collectionSize + 1);
        $responseA = $this->createMockResponse('nextPageToken1', ['resource1']);
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')]
        ];
        $transport = MockTransport::createWithResponseSequence($responseSequence);
        $descriptor = PageStreamingDescriptor::createFromFields([
            'requestPageTokenField' => 'pageToken',
            'requestPageSizeField' => 'pageSize',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resourcesList'
        ]);
        $callSettings = new CallSettings();
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['pageStreamingDescriptor' => $descriptor]
        );
        $response = $apiCall($request, []);
        $response->expandToFixedSizeCollection($collectionSize);
    }

    public function testPageStreamingWithTimeout()
    {
        $request = $this->createMockRequest('token');
        $responseA = $this->createMockResponse('nextPageToken1', ['resource1']);
        $responseB = $this->createMockResponse('nextPageToken2', ['resource2']);
        $responseC = $this->createMockResponse(null, ['resource3', 'resource4']);
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')],
            [$responseB, new MockStatus(Code::OK, '')],
            [$responseC, new MockStatus(Code::OK, '')]
        ];
        $transport = MockTransport::createWithResponseSequence($responseSequence);
        $descriptor = PageStreamingDescriptor::createFromFields([
            'requestPageTokenField' => 'pageToken',
            'responsePageTokenField' => 'nextPageToken',
            'resourceField' => 'resourcesList'
        ]);
        $callSettings = new CallSettings(['timeout' => 1000]);
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['pageStreamingDescriptor' => $descriptor]
        );
        $response = $apiCall($request, []);
        $actualCalls = $transport->popReceivedCalls();
        $this->assertEquals(1, count($actualCalls));
        $actualResources = [];
        foreach ($response->iterateAllElements() as $element) {
            array_push($actualResources, $element);
        }
        $actualCalls = array_merge($actualCalls, $transport->popReceivedCalls());
        $this->assertEquals(3, count($actualCalls));
        $this->assertEquals(['resource1', 'resource2', 'resource3', 'resource4'], $actualResources);
    }

    public function testCustomHeader()
    {
        $transport = MockTransport::create($this->createMockResponse());
        $headerDescriptor = new AgentHeaderDescriptor([
            'libName' => 'gccl',
            'libVersion' => '0.0.0',
            'gapicVersion' => '0.9.0',
            'gaxVersion' => '1.0.0',
            'phpVersion' => '5.5.0',
            'grpcVersion' => '1.0.1'
        ]);
        $apiCall = $transport->createApiCall(
            'takeAction',
            new CallSettings(),
            ['headerDescriptor' => $headerDescriptor]
        );
        $resources = $apiCall($this->createMockRequest(), []);
        $actualCalls = $transport->popReceivedCalls();
        $this->assertEquals(1, count($actualCalls));
        $expectedMetadata = [
            'x-goog-api-client' => ['gl-php/5.5.0 gccl/0.0.0 gapic/0.9.0 gax/1.0.0 grpc/1.0.1']
        ];
        $this->assertEquals($expectedMetadata, $actualCalls[0]->getMetadata());
    }

    public function testUserHeaders()
    {
        $transport = MockTransport::create($this->createMockResponse());
        $headerDescriptor = new AgentHeaderDescriptor([
            'libName' => 'gccl',
            'libVersion' => '0.0.0',
            'gapicVersion' => '0.9.0',
            'gaxVersion' => '1.0.0',
            'phpVersion' => '5.5.0',
            'grpcVersion' => '1.0.1'
        ]);
        $userHeaders = [
            'google-cloud-resource-prefix' => ['my-database'],
        ];
        $callSettings = new CallSettings([
            'userHeaders' => $userHeaders,
        ]);
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['headerDescriptor' => $headerDescriptor]
        );
        $resources = $apiCall($this->createMockRequest(), []);
        $actualCalls = $transport->popReceivedCalls();
        $this->assertEquals(1, count($actualCalls));
        $expectedMetadata = [
            'x-goog-api-client' => ['gl-php/5.5.0 gccl/0.0.0 gapic/0.9.0 gax/1.0.0 grpc/1.0.1'],
            'google-cloud-resource-prefix' => ['my-database'],
        ];
        $this->assertEquals($expectedMetadata, $actualCalls[0]->getMetadata());
    }

    public function testUserHeadersOverwriteBehavior()
    {
        $transport = MockTransport::create($this->createMockResponse());
        $headerDescriptor = new AgentHeaderDescriptor([
            'libName' => 'gccl',
            'libVersion' => '0.0.0',
            'gapicVersion' => '0.9.0',
            'gaxVersion' => '1.0.0',
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
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['headerDescriptor' => $headerDescriptor]
        );
        $resources = $apiCall($this->createMockRequest(), []);
        $actualCalls = $transport->popReceivedCalls();
        $this->assertEquals(1, count($actualCalls));
        $expectedMetadata = [
            'x-goog-api-client' => ['gl-php/5.5.0 gccl/0.0.0 gapic/0.9.0 gax/1.0.0 grpc/1.0.1'],
            'new-header' => ['this-should-be-used'],
        ];
        $this->assertEquals($expectedMetadata, $actualCalls[0]->getMetadata());
    }

    public function createIncompleteOperationResponse($name, $metadataString = '')
    {
        $metadata = $this->createAny($this->createStatus(Code::OK, $metadataString));
        $op = new Operation();
        $op->setName($name);
        $op->setMetadata($metadata);
        $op->setDone(false);
        return $op;
    }

    public function createSuccessfulOperationResponse($name, $response, $metadataString = '')
    {
        $op = self::createIncompleteOperationResponse($name, $metadataString);
        $op->setDone(true);
        $any = $this->createAny($response);
        $op->setResponse($any);
        return $op;
    }

    public function createFailedOperationResponse($name, $code, $message, $metadataString = '')
    {
        $error = $this->createStatus($code, $message);
        $op = self::createIncompleteOperationResponse($name, $metadataString);
        $op->setDone(true);
        $op->setError($error);
        return $op;
    }

    public function testLongrunningSuccess()
    {
        $opName = 'operation/someop';

        $request = null;
        $result = $this->createStatus(Code::OK, 'someMessage');
        $initialResponse = self::createIncompleteOperationResponse($opName, 'm1');
        $responseA = self::createIncompleteOperationResponse($opName, 'm2');
        $responseB = self::createSuccessfulOperationResponse($opName, $result, 'm3');
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')],
            [$responseB, new MockStatus(Code::OK, '')],
        ];
        $transport = MockTransport::createWithResponseSequence(
            [[$initialResponse, new MockStatus(Code::OK, '')]],
            ['\Google\Longrunning\Operation', 'mergeFromString']
        );
        $opTransport = MockTransport::createWithResponseSequence(
            $responseSequence,
            ['\Google\Longrunning\Operation', 'mergeFromString']
        );
        $opClient = $this->createOperationsClient($opTransport);
        $descriptor = [
            'operationsClient' => $opClient,
            'operationReturnType' => '\Google\Rpc\Status',
            'metadataReturnType' => '\Google\Rpc\Status',
        ];
        $callSettings = new CallSettings();
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['longRunningDescriptor' => $descriptor]
        );

        /* @var $response \Google\GAX\OperationResponse */
        $response = $apiCall($request, []);

        $results = [$response->getResult()];
        $errors = [$response->getError()];
        $metadataResponses = [$response->getMetadata()];
        $isDoneResponses = [$response->isDone()];

        $apiReceivedCalls = $transport->popReceivedCalls();
        $opReceivedCallsEmpty = $opTransport->popReceivedCalls();

        $this->assertSame(1, count($apiReceivedCalls));
        $this->assertSame(0, count($opReceivedCallsEmpty));

        while (!$response->isDone()) {
            $response->reload();
            $results[] = $response->getResult();
            $errors[] = $response->getError();
            $metadataResponses[] = $response->getMetadata();
            $isDoneResponses[] = $response->isDone();
        }

        $apiReceivedCallsEmpty = $transport->popReceivedCalls();
        $opReceivedCalls = $opTransport->popReceivedCalls();

        $this->assertSame(0, count($apiReceivedCallsEmpty));
        $this->assertSame(2, count($opReceivedCalls));

        $this->assertSame('takeAction', $apiReceivedCalls[0]->getFuncCall());
        $this->assertSame('GetOperation', $opReceivedCalls[0]->getFuncCall());
        $this->assertSame('GetOperation', $opReceivedCalls[1]->getFuncCall());

        $this->assertEquals([null, null, $this->createStatus(Code::OK, 'someMessage')], $results);
        $this->assertEquals([null, null, null], $errors);
        $this->assertEquals([
            $this->createStatus(Code::OK, 'm1'),
            $this->createStatus(Code::OK, 'm2'),
            $this->createStatus(Code::OK, 'm3')
        ], $metadataResponses);
        $this->assertEquals([false, false, true], $isDoneResponses);
    }

    public function testLongrunningPollingInterval()
    {
        $opName = 'operation/someop';

        $request = null;
        $result = $this->createStatus(Code::OK, 'someMessage');

        $initialResponse = self::createIncompleteOperationResponse($opName, 'm1');
        $responseA = self::createIncompleteOperationResponse($opName, 'm2');
        $responseB = self::createSuccessfulOperationResponse($opName, $result, 'm3');
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')],
            [$responseB, new MockStatus(Code::OK, '')],
        ];
        $transport = MockTransport::createWithResponseSequence(
            [[$initialResponse, new MockStatus(Code::OK, '')]],
            ['\Google\Longrunning\Operation', 'mergeFromString']
        );
        $opTransport = MockTransport::createWithResponseSequence(
            $responseSequence,
            ['\Google\Longrunning\Operation', 'mergeFromString']
        );
        $opClient = $this->createOperationsClient($opTransport);
        $descriptor = [
            'operationsClient' => $opClient,
            'operationReturnType' => '\Google\Rpc\Status',
            'metadataReturnType' => '\Google\Rpc\Status',
        ];
        $callSettings = new CallSettings();
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['longRunningDescriptor' => $descriptor]
        );

        /* @var $response \Google\GAX\OperationResponse */
        $response = $apiCall($request, []);

        $apiReceivedCalls = $transport->popReceivedCalls();
        $opReceivedCallsEmpty = $opTransport->popReceivedCalls();

        $this->assertSame(1, count($apiReceivedCalls));
        $this->assertSame(0, count($opReceivedCallsEmpty));

        $complete = $response->pollUntilComplete(['pollingIntervalSeconds' => 0.1]);
        $this->assertTrue($complete);
        $this->assertTrue($response->isDone());

        $apiReceivedCallsEmpty = $transport->popReceivedCalls();
        $opReceivedCalls = $opTransport->popReceivedCalls();

        $this->assertSame(0, count($apiReceivedCallsEmpty));
        $this->assertSame(2, count($opReceivedCalls));

        $this->assertSame('takeAction', $apiReceivedCalls[0]->getFuncCall());
        $this->assertSame('GetOperation', $opReceivedCalls[0]->getFuncCall());
        $this->assertSame('GetOperation', $opReceivedCalls[1]->getFuncCall());

        $this->assertEquals(
            $this->createStatus(Code::OK, 'someMessage'),
            $response->getResult()
        );
        $this->assertNull($response->getError());
        $this->assertEquals(
            $this->createStatus(Code::OK, 'm3'),
            $response->getMetadata()
        );
    }

    public function testLongrunningMaxPollingDuration()
    {
        $opName = 'operation/someop';

        $request = null;
        $result = $this->createStatus(Code::OK, 'someMessage');

        $initialResponse = self::createIncompleteOperationResponse($opName, 'm1');
        $responseA = self::createIncompleteOperationResponse($opName, 'm2');
        $responseB = self::createIncompleteOperationResponse($opName, 'm3');
        $responseSequence = [
            [$responseA, new MockStatus(Code::OK, '')],
            [$responseB, new MockStatus(Code::OK, '')],
        ];
        $transport = MockTransport::createWithResponseSequence(
            [[$initialResponse, new MockStatus(Code::OK, '')]],
            ['\Google\Longrunning\Operation', 'mergeFromString']
        );
        $opTransport = MockTransport::createWithResponseSequence(
            $responseSequence,
            ['\Google\Longrunning\Operation', 'mergeFromString']
        );
        $opClient = $this->createOperationsClient($opTransport);
        $descriptor = [
            'operationsClient' => $opClient,
            'operationReturnType' => '\Google\Rpc\Status',
            'metadataReturnType' => '\Google\Rpc\Status',
        ];
        $callSettings = new CallSettings();
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['longRunningDescriptor' => $descriptor]
        );

        /* @var $response \Google\GAX\OperationResponse */
        $response = $apiCall($request, []);

        $apiReceivedCalls = $transport->popReceivedCalls();
        $opReceivedCallsEmpty = $opTransport->popReceivedCalls();

        $this->assertSame(1, count($apiReceivedCalls));
        $this->assertSame(0, count($opReceivedCallsEmpty));

        $complete = $response->pollUntilComplete([
            'pollingIntervalSeconds' => 0.1,
            'maxPollingDurationSeconds' => 0.15,
        ]);
        $this->assertFalse($complete);
        $this->assertFalse($response->isDone());

        $apiReceivedCallsEmpty = $transport->popReceivedCalls();
        $opReceivedCalls = $opTransport->popReceivedCalls();

        $this->assertSame(0, count($apiReceivedCallsEmpty));
        $this->assertSame(2, count($opReceivedCalls));

        $this->assertSame('takeAction', $apiReceivedCalls[0]->getFuncCall());
        $this->assertSame('GetOperation', $opReceivedCalls[0]->getFuncCall());

        $this->assertNull($response->getResult());
        $this->assertNull($response->getError());
        $this->assertEquals(
            $this->createStatus(Code::OK, 'm3'),
            $response->getMetadata()
        );
    }

    public function testLongrunningFailure()
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
        $transport = MockTransport::createWithResponseSequence(
            [[$initialResponse, new MockStatus(Code::OK, '')]],
            ['\Google\Longrunning\Operation', 'mergeFromString']
        );
        $opTransport = MockTransport::createWithResponseSequence(
            $responseSequence,
            ['\Google\Longrunning\Operation', 'mergeFromString']
        );
        $opClient = $this->createOperationsClient($opTransport);
        $descriptor = [
            'operationsClient' => $opClient,
            'operationReturnType' => '\Google\Rpc\Status',
            'metadataReturnType' => '\Google\Rpc\Status',
        ];
        $callSettings = new CallSettings();
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['longRunningDescriptor' => $descriptor]
        );

        /* @var $response \Google\GAX\OperationResponse */
        $response = $apiCall($request, []);

        $results = [$response->getResult()];
        $errors = [$response->getError()];
        $metadataResponses = [$response->getMetadata()];
        $isDoneResponses = [$response->isDone()];

        $apiReceivedCalls = $transport->popReceivedCalls();
        $opReceivedCallsEmpty = $opTransport->popReceivedCalls();

        $this->assertSame(1, count($apiReceivedCalls));
        $this->assertSame(0, count($opReceivedCallsEmpty));

        while (!$response->isDone()) {
            $response->reload();
            $results[] = $response->getResult();
            $errors[] = $response->getError();
            $metadataResponses[] = $response->getMetadata();
            $isDoneResponses[] = $response->isDone();
        }

        $apiReceivedCallsEmpty = $transport->popReceivedCalls();
        $opReceivedCalls = $opTransport->popReceivedCalls();

        $this->assertSame(0, count($apiReceivedCallsEmpty));
        $this->assertSame(2, count($opReceivedCalls));

        $this->assertSame('takeAction', $apiReceivedCalls[0]->getFuncCall());
        $this->assertSame('GetOperation', $opReceivedCalls[0]->getFuncCall());
        $this->assertSame('GetOperation', $opReceivedCalls[1]->getFuncCall());

        $this->assertEquals([null, null, null], $results);
        $this->assertEquals(
            [null, null, $this->createStatus(Code::UNKNOWN, 'someError')],
            $errors
        );
        $this->assertEquals([
            $this->createStatus(Code::OK, 'm1'),
            $this->createStatus(Code::OK, 'm2'),
            $this->createStatus(Code::OK, 'm3')
        ], $metadataResponses);
        $this->assertEquals([false, false, true], $isDoneResponses);
    }

    public function testLongrunningCancel()
    {
        $opName = 'operation/someop';

        $request = null;

        $initialResponse = $this->createIncompleteOperationResponse($opName, 'm1');
        $responseA = $this->createIncompleteOperationResponse($opName, 'm2');
        $responseB = $this->createFailedOperationResponse(
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
        $transport = MockTransport::createWithResponseSequence(
            [[$initialResponse, new MockStatus(Code::OK, '')]],
            ['\Google\Longrunning\Operation', 'mergeFromString']
        );
        $opTransport = MockTransport::createWithResponseSequence(
            $responseSequence,
            ['\Google\Longrunning\Operation', 'mergeFromString']
        );
        $opClient = $this->createOperationsClient($opTransport);
        $descriptor = [
            'operationsClient' => $opClient,
            'operationReturnType' => '\Google\Rpc\Status',
            'metadataReturnType' => '\Google\Rpc\Status',
        ];
        $callSettings = new CallSettings();
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['longRunningDescriptor' => $descriptor]
        );

        /* @var $response \Google\GAX\OperationResponse */
        $response = $apiCall($request, []);

        $apiReceivedCalls = $transport->popReceivedCalls();
        $opReceivedCallsEmpty = $opTransport->popReceivedCalls();

        $this->assertSame(1, count($apiReceivedCalls));
        $this->assertSame(0, count($opReceivedCallsEmpty));

        $response->cancel();

        $apiReceivedCallsEmpty = $transport->popReceivedCalls();
        $opReceivedCalls = $opTransport->popReceivedCalls();

        $this->assertSame(0, count($apiReceivedCallsEmpty));
        $this->assertSame(1, count($opReceivedCalls));

        while (!$response->isDone()) {
            $response->reload();
        }

        $apiReceivedCallsEmpty = $transport->popReceivedCalls();
        $opReceivedCalls = array_merge($opReceivedCalls, $opTransport->popReceivedCalls());

        $this->assertSame(0, count($apiReceivedCallsEmpty));
        $this->assertSame(3, count($opReceivedCalls));

        $this->assertSame('takeAction', $apiReceivedCalls[0]->getFuncCall());
        $this->assertSame('CancelOperation', $opReceivedCalls[0]->getFuncCall());
        $this->assertSame('GetOperation', $opReceivedCalls[1]->getFuncCall());
        $this->assertSame('GetOperation', $opReceivedCalls[2]->getFuncCall());

        $this->assertNull($response->getResult());
        $this->assertEquals($this->createStatus(Code::CANCELLED, 'someError'), $response->getError());
        $this->assertEquals($this->createStatus(Code::OK, 'm3'), $response->getMetadata());
    }

    /**
     * @expectedException \Google\GAX\ValidationException
     * @expectedExceptionMessage Cannot call reload() on a deleted operation
     */
    public function testLongrunningDelete()
    {
        $opName = 'operation/someop';

        $request = null;

        $initialResponse = $this->createIncompleteOperationResponse($opName, 'm1');
        $transport = MockTransport::createWithResponseSequence(
            [[$initialResponse, new MockStatus(Code::OK, '')]],
            ['\Google\Longrunning\Operation', 'mergeFromString']
        );
        $opTransport = MockTransport::createWithResponseSequence(
            [[new GPBEmpty(), new MockStatus(Code::OK, '')]],
            ['\Google\Longrunning\Operation', 'mergeFromString']
        );
        $opClient = $this->createOperationsClient($opTransport);
        $descriptor = [
            'operationsClient' => $opClient,
            'operationReturnType' => '\Google\Rpc\Status',
            'metadataReturnType' => '\Google\Rpc\Status',
        ];
        $callSettings = new CallSettings();
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['longRunningDescriptor' => $descriptor]
        );

        /* @var $response \Google\GAX\OperationResponse */
        $response = $apiCall($request, []);

        $apiReceivedCalls = $transport->popReceivedCalls();
        $opReceivedCallsEmpty = $opTransport->popReceivedCalls();

        $this->assertSame(1, count($apiReceivedCalls));
        $this->assertSame(0, count($opReceivedCallsEmpty));

        $response->delete();

        $apiReceivedCallsEmpty = $transport->popReceivedCalls();
        $opReceivedCalls = $opTransport->popReceivedCalls();

        $this->assertSame(0, count($apiReceivedCallsEmpty));
        $this->assertSame(1, count($opReceivedCalls));

        $this->assertSame('takeAction', $apiReceivedCalls[0]->getFuncCall());
        $this->assertSame('DeleteOperation', $opReceivedCalls[0]->getFuncCall());

        $response->reload();
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
        $options = ['call_credentials_callback' => 'fake_callback'];
        $transport = MockStreamingTransport::create($response, null, $deserialize);
        $transport->setStreamingDescriptor($descriptor);

        $callSettings = new CallSettings([]);

        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['grpcStreamingDescriptor' => $descriptor]
        );

        /* @var $stream \Google\GAX\ClientStreamInterface */
        $stream = $apiCall(null, $options);
        $actualResponse = $stream->writeAllAndReadResponse([$request]);
        $this->assertEquals($response, $actualResponse);

        $actualCalls = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualCalls));
        $this->assertNull($actualCalls[0]->getRequestObject());
        $this->assertEquals([], $actualCalls[0]->getMetadata());
        $this->assertEquals($options, $actualCalls[0]->getOptions());

        /* @var $mockClientStreamingCall \Google\GAX\Testing\MockClientStreamingCall */
        $mockClientStreamingCall = $stream->getClientStreamingCall();
        $actualStreamingCalls = $mockClientStreamingCall->popReceivedCalls();
        $this->assertSame(1, count($actualStreamingCalls));
        $this->assertEquals($request, $actualStreamingCalls[0]);
    }

    /**
     * @expectedException \Google\GAX\ApiException
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

        $options = ['call_credentials_callback' => 'fake_callback'];
        $transport = MockStreamingTransport::create($response, $finalStatus);
        $transport->setStreamingDescriptor($descriptor);

        $callSettings = new CallSettings([]);
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['grpcStreamingDescriptor' => $descriptor]
        );

        /* @var $stream \Google\GAX\ClientStream */
        $stream = $apiCall(null, $options);
        $stream->write($request);

        $actualCalls = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualCalls));
        $this->assertNull($actualCalls[0]->getRequestObject());
        $this->assertEquals([], $actualCalls[0]->getMetadata());
        $this->assertEquals($options, $actualCalls[0]->getOptions());

        /* @var $mockClientStreamingCall \Google\GAX\Testing\MockClientStreamingCall */
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
        $options = ['call_credentials_callback' => 'fake_callback'];
        $transport = MockStreamingTransport::createWithResponseSequence($responses, $deserialize);
        $transport->setStreamingDescriptor($descriptor);

        $callSettings = new CallSettings([]);
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['grpcStreamingDescriptor' => $descriptor]
        );

        /* @var $stream \Google\GAX\ServerStream */
        $stream = $apiCall($request, $options);
        $actualResponses = iterator_to_array($stream->readAll());
        $this->assertSame(1, count($actualResponses));
        $this->assertEquals($responses, $actualResponses);

        $actualCalls = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualCalls));
        $this->assertEquals($request, $actualCalls[0]->getRequestObject());
        $this->assertEquals([], $actualCalls[0]->getMetadata());
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
        $response = $this->createMockResponse(
            'nextPageToken',
            $repeatedField
        );
        $responses = [$response];
        $descriptor = [
            'grpcStreamingType' => 'ServerStreaming',
            'resourcesGetMethod' => 'getResourcesList',
        ];

        $options = ['call_credentials_callback' => 'fake_callback'];
        $transport = MockStreamingTransport::createWithResponseSequence($responses);
        $transport->setStreamingDescriptor($descriptor);

        $callSettings = new CallSettings([]);
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['grpcStreamingDescriptor' => $descriptor]
        );

        /* @var $stream \Google\GAX\ServerStream */
        $stream = $apiCall($request, $options);
        $actualResponses = iterator_to_array($stream->readAll());
        $this->assertSame(2, count($actualResponses));
        $this->assertEquals($resources, $actualResponses);

        $actualCalls = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualCalls));
        $this->assertEquals($request, $actualCalls[0]->getRequestObject());
        $this->assertEquals([], $actualCalls[0]->getMetadata());
        $this->assertEquals($options, $actualCalls[0]->getOptions());
    }

    /**
     * @expectedException \Google\GAX\ApiException
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

        $options = ['call_credentials_callback' => 'fake_callback'];
        $transport = MockStreamingTransport::createWithResponseSequence($responses, null, $finalStatus);
        $transport->setStreamingDescriptor($descriptor);

        $callSettings = new CallSettings([]);
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            ['grpcStreamingDescriptor' => $descriptor]
        );

        /* @var $stream \Google\GAX\ServerStream */
        $stream = $apiCall($request, $options);

        foreach ($stream->readAll() as $actualResponse) {
            $this->assertEquals($response, $actualResponse);

            $actualCalls = $transport->popReceivedCalls();
            $this->assertSame(1, count($actualCalls));
            $this->assertEquals($request, $actualCalls[0]->getRequestObject());
            $this->assertEquals([], $actualCalls[0]->getMetadata());
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
        $options = ['grpcStreamingDescriptor' => $descriptor];
        $transport = MockStreamingTransport::createWithResponseSequence($responses, $deserialize);
        $transport->setStreamingDescriptor($descriptor);

        $callSettings = new CallSettings([]);
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            $options
        );

        /* @var $stream \Google\GAX\BidiStream */
        $stream = $apiCall(null, $options);
        $stream->write($request);
        $actualResponses = iterator_to_array($stream->closeWriteAndReadAll());
        $this->assertSame(1, count($actualResponses));
        $this->assertEquals($responses, $actualResponses);

        $actualCalls = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualCalls));
        $this->assertNull($actualCalls[0]->getRequestObject());
        $this->assertEquals([], $actualCalls[0]->getMetadata());
        $this->assertEquals($options, $actualCalls[0]->getOptions());

        /* @var $mockBidiStreamingCall \Google\GAX\Testing\MockBidiStreamingCall */
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
        $response = $this->createMockResponse(
            'nextPageToken',
            $repeatedField
        );
        $descriptor = [
            'grpcStreamingType' => 'BidiStreaming',
            'resourcesGetMethod' => 'getResourcesList',
        ];

        $options = ['grpcStreamingDescriptor' => $descriptor];
        $transport = MockStreamingTransport::createWithResponseSequence([$response]);
        $transport->setStreamingDescriptor($descriptor);

        $callSettings = new CallSettings([]);
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            $options
        );

        /* @var $stream \Google\GAX\BidiStream */
        $stream = $apiCall(null, $options);
        $stream->write($request);
        $actualResponses = iterator_to_array($stream->closeWriteAndReadAll());
        $this->assertSame(2, count($actualResponses));
        $this->assertEquals($resources, $actualResponses);

        $actualCalls = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualCalls));
        $this->assertNull($actualCalls[0]->getRequestObject());
        $this->assertEquals([], $actualCalls[0]->getMetadata());
        $this->assertEquals($options, $actualCalls[0]->getOptions());

        /* @var $mockBidiStreamingCall \Google\GAX\Testing\MockBidiStreamingCall */
        $mockBidiStreamingCall = $stream->getBidiStreamingCall();
        $actualStreamingCalls = $mockBidiStreamingCall->popReceivedCalls();
        $this->assertSame(1, count($actualStreamingCalls));
        $this->assertEquals($request, $actualStreamingCalls[0]);
    }

    /**
     * @expectedException \Google\GAX\ApiException
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

        $options = ['grpcStreamingDescriptor' => $descriptor];
        $transport = MockStreamingTransport::createWithResponseSequence($responses, null, $finalStatus);
        $transport->setStreamingDescriptor($descriptor);

        $callSettings = new CallSettings([]);
        $apiCall = $transport->createApiCall(
            'takeAction',
            $callSettings,
            $options
        );

        /* @var $stream \Google\GAX\BidiStream */
        $stream = $apiCall(null, $options);
        $stream->write($request);
        $stream->closeWrite();
        $actualResponse = $stream->read();
        $this->assertEquals($response, $actualResponse);

        $actualCalls = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualCalls));
        $this->assertNull($actualCalls[0]->getRequestObject());
        $this->assertEquals([], $actualCalls[0]->getMetadata());
        $this->assertEquals($options, $actualCalls[0]->getOptions());

        /* @var $mockBidiStreamingCall \Google\GAX\Testing\MockBidiStreamingCall */
        $mockBidiStreamingCall = $stream->getBidiStreamingCall();
        $actualStreamingCalls = $mockBidiStreamingCall->popReceivedCalls();
        $this->assertSame(1, count($actualStreamingCalls));
        $this->assertEquals($request, $actualStreamingCalls[0]);

        $stream->read();
    }
}
