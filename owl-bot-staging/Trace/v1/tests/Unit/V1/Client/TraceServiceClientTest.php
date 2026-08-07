<?php
/*
 * Copyright 2026 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

namespace Google\Cloud\Trace\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Trace\V1\Client\TraceServiceClient;
use Google\Cloud\Trace\V1\GetTraceRequest;
use Google\Cloud\Trace\V1\ListTracesRequest;
use Google\Cloud\Trace\V1\ListTracesResponse;
use Google\Cloud\Trace\V1\PatchTracesRequest;
use Google\Cloud\Trace\V1\Trace;
use Google\Cloud\Trace\V1\Traces;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group trace
 *
 * @group gapic
 */
class TraceServiceClientTest extends GeneratedTest
{
    /** @return TransportInterface */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /** @return CredentialsWrapper */
    private function createCredentials()
    {
        return $this->getMockBuilder(CredentialsWrapper::class)->disableOriginalConstructor()->getMock();
    }

    /** @return TraceServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new TraceServiceClient($options);
    }

    /** @test */
    public function getTraceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $projectId2 = 'projectId2939242356';
        $traceId2 = 'traceId2987826376';
        $expectedResponse = new Trace();
        $expectedResponse->setProjectId($projectId2);
        $expectedResponse->setTraceId($traceId2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $projectId = 'projectId-1969970175';
        $traceId = 'traceId1270300245';
        $request = (new GetTraceRequest())
            ->setProjectId($projectId)
            ->setTraceId($traceId);
        $response = $gapicClient->getTrace($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.devtools.cloudtrace.v1.TraceService/GetTrace', $actualFuncCall);
        $actualValue = $actualRequestObject->getProjectId();
        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getTraceId();
        $this->assertProtobufEquals($traceId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTraceExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $projectId = 'projectId-1969970175';
        $traceId = 'traceId1270300245';
        $request = (new GetTraceRequest())
            ->setProjectId($projectId)
            ->setTraceId($traceId);
        try {
            $gapicClient->getTrace($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTracesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $tracesElement = new Trace();
        $traces = [
            $tracesElement,
        ];
        $expectedResponse = new ListTracesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTraces($traces);
        $transport->addResponse($expectedResponse);
        // Mock request
        $projectId = 'projectId-1969970175';
        $request = (new ListTracesRequest())
            ->setProjectId($projectId);
        $response = $gapicClient->listTraces($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTraces()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.devtools.cloudtrace.v1.TraceService/ListTraces', $actualFuncCall);
        $actualValue = $actualRequestObject->getProjectId();
        $this->assertProtobufEquals($projectId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTracesExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $projectId = 'projectId-1969970175';
        $request = (new ListTracesRequest())
            ->setProjectId($projectId);
        try {
            $gapicClient->listTraces($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function patchTracesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $projectId = 'projectId-1969970175';
        $traces = new Traces();
        $request = (new PatchTracesRequest())
            ->setProjectId($projectId)
            ->setTraces($traces);
        $gapicClient->patchTraces($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.devtools.cloudtrace.v1.TraceService/PatchTraces', $actualFuncCall);
        $actualValue = $actualRequestObject->getProjectId();
        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getTraces();
        $this->assertProtobufEquals($traces, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function patchTracesExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $projectId = 'projectId-1969970175';
        $traces = new Traces();
        $request = (new PatchTracesRequest())
            ->setProjectId($projectId)
            ->setTraces($traces);
        try {
            $gapicClient->patchTraces($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTraceAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $projectId2 = 'projectId2939242356';
        $traceId2 = 'traceId2987826376';
        $expectedResponse = new Trace();
        $expectedResponse->setProjectId($projectId2);
        $expectedResponse->setTraceId($traceId2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $projectId = 'projectId-1969970175';
        $traceId = 'traceId1270300245';
        $request = (new GetTraceRequest())
            ->setProjectId($projectId)
            ->setTraceId($traceId);
        $response = $gapicClient->getTraceAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.devtools.cloudtrace.v1.TraceService/GetTrace', $actualFuncCall);
        $actualValue = $actualRequestObject->getProjectId();
        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getTraceId();
        $this->assertProtobufEquals($traceId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
