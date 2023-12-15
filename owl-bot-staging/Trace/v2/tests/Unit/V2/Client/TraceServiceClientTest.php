<?php
/*
 * Copyright 2023 Google LLC
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

namespace Google\Cloud\Trace\Tests\Unit\V2\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Trace\V2\BatchWriteSpansRequest;
use Google\Cloud\Trace\V2\Client\TraceServiceClient;
use Google\Cloud\Trace\V2\Span;
use Google\Cloud\Trace\V2\TruncatableString;
use Google\Protobuf\GPBEmpty;
use Google\Protobuf\Timestamp;
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
    public function batchWriteSpansTest()
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
        $formattedName = $gapicClient->projectName('[PROJECT]');
        $spans = [];
        $request = (new BatchWriteSpansRequest())
            ->setName($formattedName)
            ->setSpans($spans);
        $gapicClient->batchWriteSpans($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.devtools.cloudtrace.v2.TraceService/BatchWriteSpans', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getSpans();
        $this->assertProtobufEquals($spans, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchWriteSpansExceptionTest()
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
        $formattedName = $gapicClient->projectName('[PROJECT]');
        $spans = [];
        $request = (new BatchWriteSpansRequest())
            ->setName($formattedName)
            ->setSpans($spans);
        try {
            $gapicClient->batchWriteSpans($request);
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
    public function createSpanTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $spanId2 = 'spanId2-643891741';
        $parentSpanId2 = 'parentSpanId2-1321225074';
        $expectedResponse = new Span();
        $expectedResponse->setName($name2);
        $expectedResponse->setSpanId($spanId2);
        $expectedResponse->setParentSpanId($parentSpanId2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $spanId = 'spanId-2011840976';
        $displayName = new TruncatableString();
        $startTime = new Timestamp();
        $endTime = new Timestamp();
        $request = (new Span())
            ->setName($name)
            ->setSpanId($spanId)
            ->setDisplayName($displayName)
            ->setStartTime($startTime)
            ->setEndTime($endTime);
        $response = $gapicClient->createSpan($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.devtools.cloudtrace.v2.TraceService/CreateSpan', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualRequestObject->getSpanId();
        $this->assertProtobufEquals($spanId, $actualValue);
        $actualValue = $actualRequestObject->getDisplayName();
        $this->assertProtobufEquals($displayName, $actualValue);
        $actualValue = $actualRequestObject->getStartTime();
        $this->assertProtobufEquals($startTime, $actualValue);
        $actualValue = $actualRequestObject->getEndTime();
        $this->assertProtobufEquals($endTime, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createSpanExceptionTest()
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
        $name = 'name3373707';
        $spanId = 'spanId-2011840976';
        $displayName = new TruncatableString();
        $startTime = new Timestamp();
        $endTime = new Timestamp();
        $request = (new Span())
            ->setName($name)
            ->setSpanId($spanId)
            ->setDisplayName($displayName)
            ->setStartTime($startTime)
            ->setEndTime($endTime);
        try {
            $gapicClient->createSpan($request);
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
    public function batchWriteSpansAsyncTest()
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
        $formattedName = $gapicClient->projectName('[PROJECT]');
        $spans = [];
        $request = (new BatchWriteSpansRequest())
            ->setName($formattedName)
            ->setSpans($spans);
        $gapicClient->batchWriteSpansAsync($request)->wait();
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.devtools.cloudtrace.v2.TraceService/BatchWriteSpans', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getSpans();
        $this->assertProtobufEquals($spans, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
