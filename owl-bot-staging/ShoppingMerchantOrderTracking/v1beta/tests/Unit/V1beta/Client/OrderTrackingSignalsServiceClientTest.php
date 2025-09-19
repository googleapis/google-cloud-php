<?php
/*
 * Copyright 2025 Google LLC
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

namespace Google\Shopping\Merchant\OrderTracking\Tests\Unit\V1beta\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Rpc\Code;
use Google\Shopping\Merchant\OrderTracking\V1beta\Client\OrderTrackingSignalsServiceClient;
use Google\Shopping\Merchant\OrderTracking\V1beta\CreateOrderTrackingSignalRequest;
use Google\Shopping\Merchant\OrderTracking\V1beta\OrderTrackingSignal;
use Google\Type\DateTime;
use stdClass;

/**
 * @group ordertracking
 *
 * @group gapic
 */
class OrderTrackingSignalsServiceClientTest extends GeneratedTest
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

    /** @return OrderTrackingSignalsServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new OrderTrackingSignalsServiceClient($options);
    }

    /** @test */
    public function createOrderTrackingSignalTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $orderTrackingSignalId2 = 1466393614;
        $merchantId = 574223090;
        $orderId = 'orderId1234304940';
        $deliveryPostalCode = 'deliveryPostalCode-1062150890';
        $deliveryRegionCode = 'deliveryRegionCode-574970739';
        $expectedResponse = new OrderTrackingSignal();
        $expectedResponse->setOrderTrackingSignalId($orderTrackingSignalId2);
        $expectedResponse->setMerchantId($merchantId);
        $expectedResponse->setOrderId($orderId);
        $expectedResponse->setDeliveryPostalCode($deliveryPostalCode);
        $expectedResponse->setDeliveryRegionCode($deliveryRegionCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $orderTrackingSignal = new OrderTrackingSignal();
        $orderTrackingSignalOrderCreatedTime = new DateTime();
        $orderTrackingSignal->setOrderCreatedTime($orderTrackingSignalOrderCreatedTime);
        $orderTrackingSignalOrderId = 'orderTrackingSignalOrderId-1289238244';
        $orderTrackingSignal->setOrderId($orderTrackingSignalOrderId);
        $orderTrackingSignalShippingInfo = [];
        $orderTrackingSignal->setShippingInfo($orderTrackingSignalShippingInfo);
        $orderTrackingSignalLineItems = [];
        $orderTrackingSignal->setLineItems($orderTrackingSignalLineItems);
        $request = (new CreateOrderTrackingSignalRequest())
            ->setParent($formattedParent)
            ->setOrderTrackingSignal($orderTrackingSignal);
        $response = $gapicClient->createOrderTrackingSignal($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.ordertracking.v1beta.OrderTrackingSignalsService/CreateOrderTrackingSignal', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getOrderTrackingSignal();
        $this->assertProtobufEquals($orderTrackingSignal, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createOrderTrackingSignalExceptionTest()
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
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $orderTrackingSignal = new OrderTrackingSignal();
        $orderTrackingSignalOrderCreatedTime = new DateTime();
        $orderTrackingSignal->setOrderCreatedTime($orderTrackingSignalOrderCreatedTime);
        $orderTrackingSignalOrderId = 'orderTrackingSignalOrderId-1289238244';
        $orderTrackingSignal->setOrderId($orderTrackingSignalOrderId);
        $orderTrackingSignalShippingInfo = [];
        $orderTrackingSignal->setShippingInfo($orderTrackingSignalShippingInfo);
        $orderTrackingSignalLineItems = [];
        $orderTrackingSignal->setLineItems($orderTrackingSignalLineItems);
        $request = (new CreateOrderTrackingSignalRequest())
            ->setParent($formattedParent)
            ->setOrderTrackingSignal($orderTrackingSignal);
        try {
            $gapicClient->createOrderTrackingSignal($request);
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
    public function createOrderTrackingSignalAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $orderTrackingSignalId2 = 1466393614;
        $merchantId = 574223090;
        $orderId = 'orderId1234304940';
        $deliveryPostalCode = 'deliveryPostalCode-1062150890';
        $deliveryRegionCode = 'deliveryRegionCode-574970739';
        $expectedResponse = new OrderTrackingSignal();
        $expectedResponse->setOrderTrackingSignalId($orderTrackingSignalId2);
        $expectedResponse->setMerchantId($merchantId);
        $expectedResponse->setOrderId($orderId);
        $expectedResponse->setDeliveryPostalCode($deliveryPostalCode);
        $expectedResponse->setDeliveryRegionCode($deliveryRegionCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $orderTrackingSignal = new OrderTrackingSignal();
        $orderTrackingSignalOrderCreatedTime = new DateTime();
        $orderTrackingSignal->setOrderCreatedTime($orderTrackingSignalOrderCreatedTime);
        $orderTrackingSignalOrderId = 'orderTrackingSignalOrderId-1289238244';
        $orderTrackingSignal->setOrderId($orderTrackingSignalOrderId);
        $orderTrackingSignalShippingInfo = [];
        $orderTrackingSignal->setShippingInfo($orderTrackingSignalShippingInfo);
        $orderTrackingSignalLineItems = [];
        $orderTrackingSignal->setLineItems($orderTrackingSignalLineItems);
        $request = (new CreateOrderTrackingSignalRequest())
            ->setParent($formattedParent)
            ->setOrderTrackingSignal($orderTrackingSignal);
        $response = $gapicClient->createOrderTrackingSignalAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.ordertracking.v1beta.OrderTrackingSignalsService/CreateOrderTrackingSignal', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getOrderTrackingSignal();
        $this->assertProtobufEquals($orderTrackingSignal, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
