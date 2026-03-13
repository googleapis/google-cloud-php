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

namespace Google\Ads\DataManager\Tests\Unit\V1\Client;

use Google\Ads\DataManager\V1\Client\IngestionServiceClient;
use Google\Ads\DataManager\V1\IngestAudienceMembersRequest;
use Google\Ads\DataManager\V1\IngestAudienceMembersResponse;
use Google\Ads\DataManager\V1\IngestEventsRequest;
use Google\Ads\DataManager\V1\IngestEventsResponse;
use Google\Ads\DataManager\V1\RemoveAudienceMembersRequest;
use Google\Ads\DataManager\V1\RemoveAudienceMembersResponse;
use Google\Ads\DataManager\V1\RetrieveRequestStatusRequest;
use Google\Ads\DataManager\V1\RetrieveRequestStatusResponse;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Rpc\Code;
use stdClass;

/**
 * @group datamanager
 *
 * @group gapic
 */
class IngestionServiceClientTest extends GeneratedTest
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

    /** @return IngestionServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new IngestionServiceClient($options);
    }

    /** @test */
    public function ingestAudienceMembersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $requestId = 'requestId37109963';
        $expectedResponse = new IngestAudienceMembersResponse();
        $expectedResponse->setRequestId($requestId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $destinations = [];
        $audienceMembers = [];
        $request = (new IngestAudienceMembersRequest())
            ->setDestinations($destinations)
            ->setAudienceMembers($audienceMembers);
        $response = $gapicClient->ingestAudienceMembers($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.IngestionService/IngestAudienceMembers', $actualFuncCall);
        $actualValue = $actualRequestObject->getDestinations();
        $this->assertProtobufEquals($destinations, $actualValue);
        $actualValue = $actualRequestObject->getAudienceMembers();
        $this->assertProtobufEquals($audienceMembers, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function ingestAudienceMembersExceptionTest()
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
        $destinations = [];
        $audienceMembers = [];
        $request = (new IngestAudienceMembersRequest())
            ->setDestinations($destinations)
            ->setAudienceMembers($audienceMembers);
        try {
            $gapicClient->ingestAudienceMembers($request);
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
    public function ingestEventsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $requestId = 'requestId37109963';
        $expectedResponse = new IngestEventsResponse();
        $expectedResponse->setRequestId($requestId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $destinations = [];
        $events = [];
        $request = (new IngestEventsRequest())
            ->setDestinations($destinations)
            ->setEvents($events);
        $response = $gapicClient->ingestEvents($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.IngestionService/IngestEvents', $actualFuncCall);
        $actualValue = $actualRequestObject->getDestinations();
        $this->assertProtobufEquals($destinations, $actualValue);
        $actualValue = $actualRequestObject->getEvents();
        $this->assertProtobufEquals($events, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function ingestEventsExceptionTest()
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
        $destinations = [];
        $events = [];
        $request = (new IngestEventsRequest())
            ->setDestinations($destinations)
            ->setEvents($events);
        try {
            $gapicClient->ingestEvents($request);
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
    public function removeAudienceMembersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $requestId = 'requestId37109963';
        $expectedResponse = new RemoveAudienceMembersResponse();
        $expectedResponse->setRequestId($requestId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $destinations = [];
        $audienceMembers = [];
        $request = (new RemoveAudienceMembersRequest())
            ->setDestinations($destinations)
            ->setAudienceMembers($audienceMembers);
        $response = $gapicClient->removeAudienceMembers($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.IngestionService/RemoveAudienceMembers', $actualFuncCall);
        $actualValue = $actualRequestObject->getDestinations();
        $this->assertProtobufEquals($destinations, $actualValue);
        $actualValue = $actualRequestObject->getAudienceMembers();
        $this->assertProtobufEquals($audienceMembers, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function removeAudienceMembersExceptionTest()
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
        $destinations = [];
        $audienceMembers = [];
        $request = (new RemoveAudienceMembersRequest())
            ->setDestinations($destinations)
            ->setAudienceMembers($audienceMembers);
        try {
            $gapicClient->removeAudienceMembers($request);
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
    public function retrieveRequestStatusTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new RetrieveRequestStatusResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $requestId = 'requestId37109963';
        $request = (new RetrieveRequestStatusRequest())
            ->setRequestId($requestId);
        $response = $gapicClient->retrieveRequestStatus($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.IngestionService/RetrieveRequestStatus', $actualFuncCall);
        $actualValue = $actualRequestObject->getRequestId();
        $this->assertProtobufEquals($requestId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function retrieveRequestStatusExceptionTest()
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
        $requestId = 'requestId37109963';
        $request = (new RetrieveRequestStatusRequest())
            ->setRequestId($requestId);
        try {
            $gapicClient->retrieveRequestStatus($request);
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
    public function ingestAudienceMembersAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $requestId = 'requestId37109963';
        $expectedResponse = new IngestAudienceMembersResponse();
        $expectedResponse->setRequestId($requestId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $destinations = [];
        $audienceMembers = [];
        $request = (new IngestAudienceMembersRequest())
            ->setDestinations($destinations)
            ->setAudienceMembers($audienceMembers);
        $response = $gapicClient->ingestAudienceMembersAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.IngestionService/IngestAudienceMembers', $actualFuncCall);
        $actualValue = $actualRequestObject->getDestinations();
        $this->assertProtobufEquals($destinations, $actualValue);
        $actualValue = $actualRequestObject->getAudienceMembers();
        $this->assertProtobufEquals($audienceMembers, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
