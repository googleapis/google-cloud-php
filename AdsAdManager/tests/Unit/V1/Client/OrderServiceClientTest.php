<?php
/*
 * Copyright 2024 Google LLC
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

use Google\Ads\AdManager\V1\Client\OrderServiceClient;
use Google\Ads\AdManager\V1\GetOrderRequest;
use Google\Ads\AdManager\V1\ListOrdersRequest;
use Google\Ads\AdManager\V1\ListOrdersResponse;
use Google\Ads\AdManager\V1\Order;
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
class OrderServiceClientTest extends GeneratedTest
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

    /** @return OrderServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new OrderServiceClient($options);
    }

    /** @test */
    public function getOrderTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $orderId = 1234304940;
        $displayName = 'displayName1615086568';
        $programmatic = true;
        $trafficker = 'trafficker-606937285';
        $advertiser = 'advertiser72080683';
        $agency = 'agency-1419699195';
        $creator = 'creator1028554796';
        $currencyCode = 'currencyCode1108728155';
        $unlimitedEndTime = false;
        $externalOrderId = 1332092512;
        $archived = true;
        $lastModifiedByApp = 'lastModifiedByApp-1580292922';
        $notes = 'notes105008833';
        $poNumber = 'poNumber1281088905';
        $salesperson = 'salesperson-2087326879';
        $expectedResponse = new Order();
        $expectedResponse->setName($name2);
        $expectedResponse->setOrderId($orderId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setProgrammatic($programmatic);
        $expectedResponse->setTrafficker($trafficker);
        $expectedResponse->setAdvertiser($advertiser);
        $expectedResponse->setAgency($agency);
        $expectedResponse->setCreator($creator);
        $expectedResponse->setCurrencyCode($currencyCode);
        $expectedResponse->setUnlimitedEndTime($unlimitedEndTime);
        $expectedResponse->setExternalOrderId($externalOrderId);
        $expectedResponse->setArchived($archived);
        $expectedResponse->setLastModifiedByApp($lastModifiedByApp);
        $expectedResponse->setNotes($notes);
        $expectedResponse->setPoNumber($poNumber);
        $expectedResponse->setSalesperson($salesperson);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->orderName('[NETWORK_CODE]', '[ORDER]');
        $request = (new GetOrderRequest())->setName($formattedName);
        $response = $gapicClient->getOrder($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.OrderService/GetOrder', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getOrderExceptionTest()
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
        $formattedName = $gapicClient->orderName('[NETWORK_CODE]', '[ORDER]');
        $request = (new GetOrderRequest())->setName($formattedName);
        try {
            $gapicClient->getOrder($request);
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
    public function listOrdersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $ordersElement = new Order();
        $orders = [$ordersElement];
        $expectedResponse = new ListOrdersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setOrders($orders);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListOrdersRequest())->setParent($formattedParent);
        $response = $gapicClient->listOrders($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getOrders()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.OrderService/ListOrders', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listOrdersExceptionTest()
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
        $request = (new ListOrdersRequest())->setParent($formattedParent);
        try {
            $gapicClient->listOrders($request);
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
    public function getOrderAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $orderId = 1234304940;
        $displayName = 'displayName1615086568';
        $programmatic = true;
        $trafficker = 'trafficker-606937285';
        $advertiser = 'advertiser72080683';
        $agency = 'agency-1419699195';
        $creator = 'creator1028554796';
        $currencyCode = 'currencyCode1108728155';
        $unlimitedEndTime = false;
        $externalOrderId = 1332092512;
        $archived = true;
        $lastModifiedByApp = 'lastModifiedByApp-1580292922';
        $notes = 'notes105008833';
        $poNumber = 'poNumber1281088905';
        $salesperson = 'salesperson-2087326879';
        $expectedResponse = new Order();
        $expectedResponse->setName($name2);
        $expectedResponse->setOrderId($orderId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setProgrammatic($programmatic);
        $expectedResponse->setTrafficker($trafficker);
        $expectedResponse->setAdvertiser($advertiser);
        $expectedResponse->setAgency($agency);
        $expectedResponse->setCreator($creator);
        $expectedResponse->setCurrencyCode($currencyCode);
        $expectedResponse->setUnlimitedEndTime($unlimitedEndTime);
        $expectedResponse->setExternalOrderId($externalOrderId);
        $expectedResponse->setArchived($archived);
        $expectedResponse->setLastModifiedByApp($lastModifiedByApp);
        $expectedResponse->setNotes($notes);
        $expectedResponse->setPoNumber($poNumber);
        $expectedResponse->setSalesperson($salesperson);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->orderName('[NETWORK_CODE]', '[ORDER]');
        $request = (new GetOrderRequest())->setName($formattedName);
        $response = $gapicClient->getOrderAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.OrderService/GetOrder', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
