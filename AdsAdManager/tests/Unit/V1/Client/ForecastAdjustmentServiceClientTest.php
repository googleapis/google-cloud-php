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

use Google\Ads\AdManager\V1\BatchActivateForecastAdjustmentsRequest;
use Google\Ads\AdManager\V1\BatchActivateForecastAdjustmentsResponse;
use Google\Ads\AdManager\V1\BatchCreateForecastAdjustmentsRequest;
use Google\Ads\AdManager\V1\BatchCreateForecastAdjustmentsResponse;
use Google\Ads\AdManager\V1\BatchDeactivateForecastAdjustmentsRequest;
use Google\Ads\AdManager\V1\BatchDeactivateForecastAdjustmentsResponse;
use Google\Ads\AdManager\V1\BatchUpdateForecastAdjustmentsRequest;
use Google\Ads\AdManager\V1\BatchUpdateForecastAdjustmentsResponse;
use Google\Ads\AdManager\V1\CalculateDailyAdOpportunityCountsRequest;
use Google\Ads\AdManager\V1\CalculateDailyAdOpportunityCountsResponse;
use Google\Ads\AdManager\V1\Client\ForecastAdjustmentServiceClient;
use Google\Ads\AdManager\V1\CreateForecastAdjustmentRequest;
use Google\Ads\AdManager\V1\DateRange;
use Google\Ads\AdManager\V1\ForecastAdjustment;
use Google\Ads\AdManager\V1\ForecastAdjustmentVolumeTypeEnum\ForecastAdjustmentVolumeType;
use Google\Ads\AdManager\V1\GetForecastAdjustmentRequest;
use Google\Ads\AdManager\V1\ListForecastAdjustmentsRequest;
use Google\Ads\AdManager\V1\ListForecastAdjustmentsResponse;
use Google\Ads\AdManager\V1\UpdateForecastAdjustmentRequest;
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
class ForecastAdjustmentServiceClientTest extends GeneratedTest
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

    /** @return ForecastAdjustmentServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new ForecastAdjustmentServiceClient($options);
    }

    /** @test */
    public function batchActivateForecastAdjustmentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchActivateForecastAdjustmentsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $names = [];
        $request = (new BatchActivateForecastAdjustmentsRequest())->setParent($formattedParent)->setNames($names);
        $response = $gapicClient->batchActivateForecastAdjustments($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.ForecastAdjustmentService/BatchActivateForecastAdjustments',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($names, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchActivateForecastAdjustmentsExceptionTest()
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
        $names = [];
        $request = (new BatchActivateForecastAdjustmentsRequest())->setParent($formattedParent)->setNames($names);
        try {
            $gapicClient->batchActivateForecastAdjustments($request);
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
    public function batchCreateForecastAdjustmentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCreateForecastAdjustmentsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchCreateForecastAdjustmentsRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchCreateForecastAdjustments($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.ForecastAdjustmentService/BatchCreateForecastAdjustments',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchCreateForecastAdjustmentsExceptionTest()
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
        $request = (new BatchCreateForecastAdjustmentsRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->batchCreateForecastAdjustments($request);
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
    public function batchDeactivateForecastAdjustmentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchDeactivateForecastAdjustmentsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $names = [];
        $request = (new BatchDeactivateForecastAdjustmentsRequest())->setParent($formattedParent)->setNames($names);
        $response = $gapicClient->batchDeactivateForecastAdjustments($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.ForecastAdjustmentService/BatchDeactivateForecastAdjustments',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($names, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchDeactivateForecastAdjustmentsExceptionTest()
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
        $names = [];
        $request = (new BatchDeactivateForecastAdjustmentsRequest())->setParent($formattedParent)->setNames($names);
        try {
            $gapicClient->batchDeactivateForecastAdjustments($request);
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
    public function batchUpdateForecastAdjustmentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchUpdateForecastAdjustmentsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchUpdateForecastAdjustmentsRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchUpdateForecastAdjustments($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.ForecastAdjustmentService/BatchUpdateForecastAdjustments',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchUpdateForecastAdjustmentsExceptionTest()
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
        $request = (new BatchUpdateForecastAdjustmentsRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->batchUpdateForecastAdjustments($request);
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
    public function calculateDailyAdOpportunityCountsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new CalculateDailyAdOpportunityCountsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $forecastAdjustment = new ForecastAdjustment();
        $forecastAdjustmentTrafficForecastSegment = $gapicClient->trafficForecastSegmentName(
            '[NETWORK_CODE]',
            '[TRAFFIC_FORECAST_SEGMENT]'
        );
        $forecastAdjustment->setTrafficForecastSegment($forecastAdjustmentTrafficForecastSegment);
        $forecastAdjustmentDisplayName = 'forecastAdjustmentDisplayName1181744005';
        $forecastAdjustment->setDisplayName($forecastAdjustmentDisplayName);
        $forecastAdjustmentDateRange = new DateRange();
        $forecastAdjustment->setDateRange($forecastAdjustmentDateRange);
        $forecastAdjustmentVolumeType = ForecastAdjustmentVolumeType::FORECAST_ADJUSTMENT_VOLUME_TYPE_UNSPECIFIED;
        $forecastAdjustment->setVolumeType($forecastAdjustmentVolumeType);
        $request = (new CalculateDailyAdOpportunityCountsRequest())
            ->setParent($formattedParent)
            ->setForecastAdjustment($forecastAdjustment);
        $response = $gapicClient->calculateDailyAdOpportunityCounts($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.ForecastAdjustmentService/CalculateDailyAdOpportunityCounts',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getForecastAdjustment();
        $this->assertProtobufEquals($forecastAdjustment, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function calculateDailyAdOpportunityCountsExceptionTest()
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
        $forecastAdjustment = new ForecastAdjustment();
        $forecastAdjustmentTrafficForecastSegment = $gapicClient->trafficForecastSegmentName(
            '[NETWORK_CODE]',
            '[TRAFFIC_FORECAST_SEGMENT]'
        );
        $forecastAdjustment->setTrafficForecastSegment($forecastAdjustmentTrafficForecastSegment);
        $forecastAdjustmentDisplayName = 'forecastAdjustmentDisplayName1181744005';
        $forecastAdjustment->setDisplayName($forecastAdjustmentDisplayName);
        $forecastAdjustmentDateRange = new DateRange();
        $forecastAdjustment->setDateRange($forecastAdjustmentDateRange);
        $forecastAdjustmentVolumeType = ForecastAdjustmentVolumeType::FORECAST_ADJUSTMENT_VOLUME_TYPE_UNSPECIFIED;
        $forecastAdjustment->setVolumeType($forecastAdjustmentVolumeType);
        $request = (new CalculateDailyAdOpportunityCountsRequest())
            ->setParent($formattedParent)
            ->setForecastAdjustment($forecastAdjustment);
        try {
            $gapicClient->calculateDailyAdOpportunityCounts($request);
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
    public function createForecastAdjustmentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $trafficForecastSegment = 'trafficForecastSegment-1468023055';
        $displayName = 'displayName1615086568';
        $allowAdjustingForecastAboveRecommendedLimit = false;
        $expectedResponse = new ForecastAdjustment();
        $expectedResponse->setName($name);
        $expectedResponse->setTrafficForecastSegment($trafficForecastSegment);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setAllowAdjustingForecastAboveRecommendedLimit($allowAdjustingForecastAboveRecommendedLimit);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $forecastAdjustment = new ForecastAdjustment();
        $forecastAdjustmentTrafficForecastSegment = $gapicClient->trafficForecastSegmentName(
            '[NETWORK_CODE]',
            '[TRAFFIC_FORECAST_SEGMENT]'
        );
        $forecastAdjustment->setTrafficForecastSegment($forecastAdjustmentTrafficForecastSegment);
        $forecastAdjustmentDisplayName = 'forecastAdjustmentDisplayName1181744005';
        $forecastAdjustment->setDisplayName($forecastAdjustmentDisplayName);
        $forecastAdjustmentDateRange = new DateRange();
        $forecastAdjustment->setDateRange($forecastAdjustmentDateRange);
        $forecastAdjustmentVolumeType = ForecastAdjustmentVolumeType::FORECAST_ADJUSTMENT_VOLUME_TYPE_UNSPECIFIED;
        $forecastAdjustment->setVolumeType($forecastAdjustmentVolumeType);
        $request = (new CreateForecastAdjustmentRequest())
            ->setParent($formattedParent)
            ->setForecastAdjustment($forecastAdjustment);
        $response = $gapicClient->createForecastAdjustment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.ForecastAdjustmentService/CreateForecastAdjustment',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getForecastAdjustment();
        $this->assertProtobufEquals($forecastAdjustment, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createForecastAdjustmentExceptionTest()
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
        $forecastAdjustment = new ForecastAdjustment();
        $forecastAdjustmentTrafficForecastSegment = $gapicClient->trafficForecastSegmentName(
            '[NETWORK_CODE]',
            '[TRAFFIC_FORECAST_SEGMENT]'
        );
        $forecastAdjustment->setTrafficForecastSegment($forecastAdjustmentTrafficForecastSegment);
        $forecastAdjustmentDisplayName = 'forecastAdjustmentDisplayName1181744005';
        $forecastAdjustment->setDisplayName($forecastAdjustmentDisplayName);
        $forecastAdjustmentDateRange = new DateRange();
        $forecastAdjustment->setDateRange($forecastAdjustmentDateRange);
        $forecastAdjustmentVolumeType = ForecastAdjustmentVolumeType::FORECAST_ADJUSTMENT_VOLUME_TYPE_UNSPECIFIED;
        $forecastAdjustment->setVolumeType($forecastAdjustmentVolumeType);
        $request = (new CreateForecastAdjustmentRequest())
            ->setParent($formattedParent)
            ->setForecastAdjustment($forecastAdjustment);
        try {
            $gapicClient->createForecastAdjustment($request);
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
    public function getForecastAdjustmentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $trafficForecastSegment = 'trafficForecastSegment-1468023055';
        $displayName = 'displayName1615086568';
        $allowAdjustingForecastAboveRecommendedLimit = false;
        $expectedResponse = new ForecastAdjustment();
        $expectedResponse->setName($name2);
        $expectedResponse->setTrafficForecastSegment($trafficForecastSegment);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setAllowAdjustingForecastAboveRecommendedLimit($allowAdjustingForecastAboveRecommendedLimit);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->forecastAdjustmentName('[NETWORK_CODE]', '[FORECAST_ADJUSTMENT]');
        $request = (new GetForecastAdjustmentRequest())->setName($formattedName);
        $response = $gapicClient->getForecastAdjustment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ForecastAdjustmentService/GetForecastAdjustment', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getForecastAdjustmentExceptionTest()
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
        $formattedName = $gapicClient->forecastAdjustmentName('[NETWORK_CODE]', '[FORECAST_ADJUSTMENT]');
        $request = (new GetForecastAdjustmentRequest())->setName($formattedName);
        try {
            $gapicClient->getForecastAdjustment($request);
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
    public function listForecastAdjustmentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $forecastAdjustmentsElement = new ForecastAdjustment();
        $forecastAdjustments = [$forecastAdjustmentsElement];
        $expectedResponse = new ListForecastAdjustmentsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setForecastAdjustments($forecastAdjustments);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListForecastAdjustmentsRequest())->setParent($formattedParent);
        $response = $gapicClient->listForecastAdjustments($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getForecastAdjustments()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.ForecastAdjustmentService/ListForecastAdjustments',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listForecastAdjustmentsExceptionTest()
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
        $request = (new ListForecastAdjustmentsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listForecastAdjustments($request);
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
    public function updateForecastAdjustmentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $trafficForecastSegment = 'trafficForecastSegment-1468023055';
        $displayName = 'displayName1615086568';
        $allowAdjustingForecastAboveRecommendedLimit = false;
        $expectedResponse = new ForecastAdjustment();
        $expectedResponse->setName($name);
        $expectedResponse->setTrafficForecastSegment($trafficForecastSegment);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setAllowAdjustingForecastAboveRecommendedLimit($allowAdjustingForecastAboveRecommendedLimit);
        $transport->addResponse($expectedResponse);
        // Mock request
        $forecastAdjustment = new ForecastAdjustment();
        $forecastAdjustmentTrafficForecastSegment = $gapicClient->trafficForecastSegmentName(
            '[NETWORK_CODE]',
            '[TRAFFIC_FORECAST_SEGMENT]'
        );
        $forecastAdjustment->setTrafficForecastSegment($forecastAdjustmentTrafficForecastSegment);
        $forecastAdjustmentDisplayName = 'forecastAdjustmentDisplayName1181744005';
        $forecastAdjustment->setDisplayName($forecastAdjustmentDisplayName);
        $forecastAdjustmentDateRange = new DateRange();
        $forecastAdjustment->setDateRange($forecastAdjustmentDateRange);
        $forecastAdjustmentVolumeType = ForecastAdjustmentVolumeType::FORECAST_ADJUSTMENT_VOLUME_TYPE_UNSPECIFIED;
        $forecastAdjustment->setVolumeType($forecastAdjustmentVolumeType);
        $request = (new UpdateForecastAdjustmentRequest())->setForecastAdjustment($forecastAdjustment);
        $response = $gapicClient->updateForecastAdjustment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.ForecastAdjustmentService/UpdateForecastAdjustment',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getForecastAdjustment();
        $this->assertProtobufEquals($forecastAdjustment, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateForecastAdjustmentExceptionTest()
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
        $forecastAdjustment = new ForecastAdjustment();
        $forecastAdjustmentTrafficForecastSegment = $gapicClient->trafficForecastSegmentName(
            '[NETWORK_CODE]',
            '[TRAFFIC_FORECAST_SEGMENT]'
        );
        $forecastAdjustment->setTrafficForecastSegment($forecastAdjustmentTrafficForecastSegment);
        $forecastAdjustmentDisplayName = 'forecastAdjustmentDisplayName1181744005';
        $forecastAdjustment->setDisplayName($forecastAdjustmentDisplayName);
        $forecastAdjustmentDateRange = new DateRange();
        $forecastAdjustment->setDateRange($forecastAdjustmentDateRange);
        $forecastAdjustmentVolumeType = ForecastAdjustmentVolumeType::FORECAST_ADJUSTMENT_VOLUME_TYPE_UNSPECIFIED;
        $forecastAdjustment->setVolumeType($forecastAdjustmentVolumeType);
        $request = (new UpdateForecastAdjustmentRequest())->setForecastAdjustment($forecastAdjustment);
        try {
            $gapicClient->updateForecastAdjustment($request);
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
    public function batchActivateForecastAdjustmentsAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchActivateForecastAdjustmentsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $names = [];
        $request = (new BatchActivateForecastAdjustmentsRequest())->setParent($formattedParent)->setNames($names);
        $response = $gapicClient->batchActivateForecastAdjustmentsAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.ForecastAdjustmentService/BatchActivateForecastAdjustments',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($names, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
