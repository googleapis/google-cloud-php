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

namespace Google\Ads\AdManager\Tests\Unit\V1\Client;

use Google\Ads\AdManager\V1\BatchCreateTrafficForecastSegmentsRequest;
use Google\Ads\AdManager\V1\BatchCreateTrafficForecastSegmentsResponse;
use Google\Ads\AdManager\V1\BatchUpdateTrafficForecastSegmentsRequest;
use Google\Ads\AdManager\V1\BatchUpdateTrafficForecastSegmentsResponse;
use Google\Ads\AdManager\V1\Client\TrafficForecastSegmentServiceClient;
use Google\Ads\AdManager\V1\CreateTrafficForecastSegmentRequest;
use Google\Ads\AdManager\V1\GetTrafficForecastSegmentRequest;
use Google\Ads\AdManager\V1\ListTrafficForecastSegmentsRequest;
use Google\Ads\AdManager\V1\ListTrafficForecastSegmentsResponse;
use Google\Ads\AdManager\V1\Targeting;
use Google\Ads\AdManager\V1\TrafficForecastSegment;
use Google\Ads\AdManager\V1\UpdateTrafficForecastSegmentRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Rpc\Code;
use stdClass;

/**
 * @group admanager
 *
 * @group gapic
 */
class TrafficForecastSegmentServiceClientTest extends GeneratedTest
{
    /** @return TransportInterface */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /** @return CredentialsWrapper */
    private function createCredentials()
    {
        return $this->getMockBuilder(CredentialsWrapper::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /** @return TrafficForecastSegmentServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new TrafficForecastSegmentServiceClient($options);
    }

    /** @test */
    public function batchCreateTrafficForecastSegmentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCreateTrafficForecastSegmentsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchCreateTrafficForecastSegmentsRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        $response = $gapicClient->batchCreateTrafficForecastSegments($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.TrafficForecastSegmentService/BatchCreateTrafficForecastSegments',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchCreateTrafficForecastSegmentsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchCreateTrafficForecastSegmentsRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        try {
            $gapicClient->batchCreateTrafficForecastSegments($request);
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
    public function batchUpdateTrafficForecastSegmentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchUpdateTrafficForecastSegmentsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchUpdateTrafficForecastSegmentsRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        $response = $gapicClient->batchUpdateTrafficForecastSegments($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.TrafficForecastSegmentService/BatchUpdateTrafficForecastSegments',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchUpdateTrafficForecastSegmentsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchUpdateTrafficForecastSegmentsRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        try {
            $gapicClient->batchUpdateTrafficForecastSegments($request);
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
    public function createTrafficForecastSegmentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $forecastAdjustmentCount = 534214271;
        $expectedResponse = new TrafficForecastSegment();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setForecastAdjustmentCount($forecastAdjustmentCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $trafficForecastSegment = new TrafficForecastSegment();
        $trafficForecastSegmentDisplayName = 'trafficForecastSegmentDisplayName246192754';
        $trafficForecastSegment->setDisplayName($trafficForecastSegmentDisplayName);
        $trafficForecastSegmentTargeting = new Targeting();
        $trafficForecastSegment->setTargeting($trafficForecastSegmentTargeting);
        $request = (new CreateTrafficForecastSegmentRequest())
            ->setParent($formattedParent)
            ->setTrafficForecastSegment($trafficForecastSegment);
        $response = $gapicClient->createTrafficForecastSegment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.TrafficForecastSegmentService/CreateTrafficForecastSegment',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getTrafficForecastSegment();
        $this->assertProtobufEquals($trafficForecastSegment, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createTrafficForecastSegmentExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $trafficForecastSegment = new TrafficForecastSegment();
        $trafficForecastSegmentDisplayName = 'trafficForecastSegmentDisplayName246192754';
        $trafficForecastSegment->setDisplayName($trafficForecastSegmentDisplayName);
        $trafficForecastSegmentTargeting = new Targeting();
        $trafficForecastSegment->setTargeting($trafficForecastSegmentTargeting);
        $request = (new CreateTrafficForecastSegmentRequest())
            ->setParent($formattedParent)
            ->setTrafficForecastSegment($trafficForecastSegment);
        try {
            $gapicClient->createTrafficForecastSegment($request);
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
    public function getTrafficForecastSegmentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $forecastAdjustmentCount = 534214271;
        $expectedResponse = new TrafficForecastSegment();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setForecastAdjustmentCount($forecastAdjustmentCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->trafficForecastSegmentName('[NETWORK_CODE]', '[TRAFFIC_FORECAST_SEGMENT]');
        $request = (new GetTrafficForecastSegmentRequest())->setName($formattedName);
        $response = $gapicClient->getTrafficForecastSegment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.TrafficForecastSegmentService/GetTrafficForecastSegment',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTrafficForecastSegmentExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->trafficForecastSegmentName('[NETWORK_CODE]', '[TRAFFIC_FORECAST_SEGMENT]');
        $request = (new GetTrafficForecastSegmentRequest())->setName($formattedName);
        try {
            $gapicClient->getTrafficForecastSegment($request);
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
    public function listTrafficForecastSegmentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $trafficForecastSegmentsElement = new TrafficForecastSegment();
        $trafficForecastSegments = [$trafficForecastSegmentsElement];
        $expectedResponse = new ListTrafficForecastSegmentsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setTrafficForecastSegments($trafficForecastSegments);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListTrafficForecastSegmentsRequest())->setParent($formattedParent);
        $response = $gapicClient->listTrafficForecastSegments($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTrafficForecastSegments()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.TrafficForecastSegmentService/ListTrafficForecastSegments',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTrafficForecastSegmentsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListTrafficForecastSegmentsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listTrafficForecastSegments($request);
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
    public function updateTrafficForecastSegmentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $forecastAdjustmentCount = 534214271;
        $expectedResponse = new TrafficForecastSegment();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setForecastAdjustmentCount($forecastAdjustmentCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $trafficForecastSegment = new TrafficForecastSegment();
        $trafficForecastSegmentDisplayName = 'trafficForecastSegmentDisplayName246192754';
        $trafficForecastSegment->setDisplayName($trafficForecastSegmentDisplayName);
        $trafficForecastSegmentTargeting = new Targeting();
        $trafficForecastSegment->setTargeting($trafficForecastSegmentTargeting);
        $request = (new UpdateTrafficForecastSegmentRequest())->setTrafficForecastSegment($trafficForecastSegment);
        $response = $gapicClient->updateTrafficForecastSegment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.TrafficForecastSegmentService/UpdateTrafficForecastSegment',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getTrafficForecastSegment();
        $this->assertProtobufEquals($trafficForecastSegment, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateTrafficForecastSegmentExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $trafficForecastSegment = new TrafficForecastSegment();
        $trafficForecastSegmentDisplayName = 'trafficForecastSegmentDisplayName246192754';
        $trafficForecastSegment->setDisplayName($trafficForecastSegmentDisplayName);
        $trafficForecastSegmentTargeting = new Targeting();
        $trafficForecastSegment->setTargeting($trafficForecastSegmentTargeting);
        $request = (new UpdateTrafficForecastSegmentRequest())->setTrafficForecastSegment($trafficForecastSegment);
        try {
            $gapicClient->updateTrafficForecastSegment($request);
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
    public function batchCreateTrafficForecastSegmentsAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCreateTrafficForecastSegmentsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchCreateTrafficForecastSegmentsRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        $response = $gapicClient->batchCreateTrafficForecastSegmentsAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.TrafficForecastSegmentService/BatchCreateTrafficForecastSegments',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
