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

use Google\Ads\AdManager\V1\AvailabilityForecastOptions;
use Google\Ads\AdManager\V1\Client\ForecastServiceClient;
use Google\Ads\AdManager\V1\DateRange;
use Google\Ads\AdManager\V1\DeliveryForecastOptions;
use Google\Ads\AdManager\V1\RunAvailabilityForecastRequest;
use Google\Ads\AdManager\V1\RunAvailabilityForecastResponse;
use Google\Ads\AdManager\V1\RunDeliveryForecastRequest;
use Google\Ads\AdManager\V1\RunDeliveryForecastResponse;
use Google\Ads\AdManager\V1\RunTrafficDataRequest;
use Google\Ads\AdManager\V1\RunTrafficDataResponse;
use Google\Ads\AdManager\V1\Targeting;
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
class ForecastServiceClientTest extends GeneratedTest
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

    /** @return ForecastServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new ForecastServiceClient($options);
    }

    /** @test */
    public function runAvailabilityForecastTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new RunAvailabilityForecastResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $availabilityForecastOptions = new AvailabilityForecastOptions();
        $request = (new RunAvailabilityForecastRequest())
            ->setParent($formattedParent)
            ->setAvailabilityForecastOptions($availabilityForecastOptions);
        $response = $gapicClient->runAvailabilityForecast($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ForecastService/RunAvailabilityForecast', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAvailabilityForecastOptions();
        $this->assertProtobufEquals($availabilityForecastOptions, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function runAvailabilityForecastExceptionTest()
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
        $availabilityForecastOptions = new AvailabilityForecastOptions();
        $request = (new RunAvailabilityForecastRequest())
            ->setParent($formattedParent)
            ->setAvailabilityForecastOptions($availabilityForecastOptions);
        try {
            $gapicClient->runAvailabilityForecast($request);
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
    public function runDeliveryForecastTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new RunDeliveryForecastResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $deliveryForecastOptions = new DeliveryForecastOptions();
        $request = (new RunDeliveryForecastRequest())
            ->setParent($formattedParent)
            ->setDeliveryForecastOptions($deliveryForecastOptions);
        $response = $gapicClient->runDeliveryForecast($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ForecastService/RunDeliveryForecast', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getDeliveryForecastOptions();
        $this->assertProtobufEquals($deliveryForecastOptions, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function runDeliveryForecastExceptionTest()
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
        $deliveryForecastOptions = new DeliveryForecastOptions();
        $request = (new RunDeliveryForecastRequest())
            ->setParent($formattedParent)
            ->setDeliveryForecastOptions($deliveryForecastOptions);
        try {
            $gapicClient->runDeliveryForecast($request);
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
    public function runTrafficDataTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new RunTrafficDataResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $targeting = new Targeting();
        $requestedDateRange = new DateRange();
        $request = (new RunTrafficDataRequest())
            ->setParent($formattedParent)
            ->setTargeting($targeting)
            ->setRequestedDateRange($requestedDateRange);
        $response = $gapicClient->runTrafficData($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ForecastService/RunTrafficData', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getTargeting();
        $this->assertProtobufEquals($targeting, $actualValue);
        $actualValue = $actualRequestObject->getRequestedDateRange();
        $this->assertProtobufEquals($requestedDateRange, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function runTrafficDataExceptionTest()
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
        $targeting = new Targeting();
        $requestedDateRange = new DateRange();
        $request = (new RunTrafficDataRequest())
            ->setParent($formattedParent)
            ->setTargeting($targeting)
            ->setRequestedDateRange($requestedDateRange);
        try {
            $gapicClient->runTrafficData($request);
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
    public function runAvailabilityForecastAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new RunAvailabilityForecastResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $availabilityForecastOptions = new AvailabilityForecastOptions();
        $request = (new RunAvailabilityForecastRequest())
            ->setParent($formattedParent)
            ->setAvailabilityForecastOptions($availabilityForecastOptions);
        $response = $gapicClient->runAvailabilityForecastAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ForecastService/RunAvailabilityForecast', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAvailabilityForecastOptions();
        $this->assertProtobufEquals($availabilityForecastOptions, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
