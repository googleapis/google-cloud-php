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

namespace Google\Ads\AdManager\Tests\Unit\V1\Client;

use Google\Ads\AdManager\V1\Client\PrivateAuctionDealServiceClient;
use Google\Ads\AdManager\V1\CreatePrivateAuctionDealRequest;
use Google\Ads\AdManager\V1\GetPrivateAuctionDealRequest;
use Google\Ads\AdManager\V1\ListPrivateAuctionDealsRequest;
use Google\Ads\AdManager\V1\ListPrivateAuctionDealsResponse;
use Google\Ads\AdManager\V1\PrivateAuctionDeal;
use Google\Ads\AdManager\V1\UpdatePrivateAuctionDealRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\FieldMask;
use Google\Rpc\Code;
use Google\Type\Money;
use stdClass;

/**
 * @group admanager
 *
 * @group gapic
 */
class PrivateAuctionDealServiceClientTest extends GeneratedTest
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

    /** @return PrivateAuctionDealServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new PrivateAuctionDealServiceClient($options);
    }

    /** @test */
    public function createPrivateAuctionDealTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $privateAuctionDealId = 1870574870;
        $privateAuctionId = 20317997;
        $privateAuctionDisplayName = 'privateAuctionDisplayName742713760';
        $buyerAccountId = 994282887;
        $externalDealId = 66314918;
        $auctionPriorityEnabled = true;
        $blockOverrideEnabled = true;
        $expectedResponse = new PrivateAuctionDeal();
        $expectedResponse->setName($name);
        $expectedResponse->setPrivateAuctionDealId($privateAuctionDealId);
        $expectedResponse->setPrivateAuctionId($privateAuctionId);
        $expectedResponse->setPrivateAuctionDisplayName($privateAuctionDisplayName);
        $expectedResponse->setBuyerAccountId($buyerAccountId);
        $expectedResponse->setExternalDealId($externalDealId);
        $expectedResponse->setAuctionPriorityEnabled($auctionPriorityEnabled);
        $expectedResponse->setBlockOverrideEnabled($blockOverrideEnabled);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $privateAuctionDeal = new PrivateAuctionDeal();
        $privateAuctionDealFloorPrice = new Money();
        $privateAuctionDeal->setFloorPrice($privateAuctionDealFloorPrice);
        $request = (new CreatePrivateAuctionDealRequest())
            ->setParent($formattedParent)
            ->setPrivateAuctionDeal($privateAuctionDeal);
        $response = $gapicClient->createPrivateAuctionDeal($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.PrivateAuctionDealService/CreatePrivateAuctionDeal',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getPrivateAuctionDeal();
        $this->assertProtobufEquals($privateAuctionDeal, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createPrivateAuctionDealExceptionTest()
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
        $privateAuctionDeal = new PrivateAuctionDeal();
        $privateAuctionDealFloorPrice = new Money();
        $privateAuctionDeal->setFloorPrice($privateAuctionDealFloorPrice);
        $request = (new CreatePrivateAuctionDealRequest())
            ->setParent($formattedParent)
            ->setPrivateAuctionDeal($privateAuctionDeal);
        try {
            $gapicClient->createPrivateAuctionDeal($request);
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
    public function getPrivateAuctionDealTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $privateAuctionDealId = 1870574870;
        $privateAuctionId = 20317997;
        $privateAuctionDisplayName = 'privateAuctionDisplayName742713760';
        $buyerAccountId = 994282887;
        $externalDealId = 66314918;
        $auctionPriorityEnabled = true;
        $blockOverrideEnabled = true;
        $expectedResponse = new PrivateAuctionDeal();
        $expectedResponse->setName($name2);
        $expectedResponse->setPrivateAuctionDealId($privateAuctionDealId);
        $expectedResponse->setPrivateAuctionId($privateAuctionId);
        $expectedResponse->setPrivateAuctionDisplayName($privateAuctionDisplayName);
        $expectedResponse->setBuyerAccountId($buyerAccountId);
        $expectedResponse->setExternalDealId($externalDealId);
        $expectedResponse->setAuctionPriorityEnabled($auctionPriorityEnabled);
        $expectedResponse->setBlockOverrideEnabled($blockOverrideEnabled);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->privateAuctionDealName('[NETWORK_CODE]', '[PRIVATE_AUCTION_DEAL]');
        $request = (new GetPrivateAuctionDealRequest())->setName($formattedName);
        $response = $gapicClient->getPrivateAuctionDeal($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.PrivateAuctionDealService/GetPrivateAuctionDeal', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getPrivateAuctionDealExceptionTest()
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
        $formattedName = $gapicClient->privateAuctionDealName('[NETWORK_CODE]', '[PRIVATE_AUCTION_DEAL]');
        $request = (new GetPrivateAuctionDealRequest())->setName($formattedName);
        try {
            $gapicClient->getPrivateAuctionDeal($request);
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
    public function listPrivateAuctionDealsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $privateAuctionDealsElement = new PrivateAuctionDeal();
        $privateAuctionDeals = [$privateAuctionDealsElement];
        $expectedResponse = new ListPrivateAuctionDealsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setPrivateAuctionDeals($privateAuctionDeals);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListPrivateAuctionDealsRequest())->setParent($formattedParent);
        $response = $gapicClient->listPrivateAuctionDeals($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getPrivateAuctionDeals()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.PrivateAuctionDealService/ListPrivateAuctionDeals',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listPrivateAuctionDealsExceptionTest()
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
        $request = (new ListPrivateAuctionDealsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listPrivateAuctionDeals($request);
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
    public function updatePrivateAuctionDealTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $privateAuctionDealId = 1870574870;
        $privateAuctionId = 20317997;
        $privateAuctionDisplayName = 'privateAuctionDisplayName742713760';
        $buyerAccountId = 994282887;
        $externalDealId = 66314918;
        $auctionPriorityEnabled = true;
        $blockOverrideEnabled = true;
        $expectedResponse = new PrivateAuctionDeal();
        $expectedResponse->setName($name);
        $expectedResponse->setPrivateAuctionDealId($privateAuctionDealId);
        $expectedResponse->setPrivateAuctionId($privateAuctionId);
        $expectedResponse->setPrivateAuctionDisplayName($privateAuctionDisplayName);
        $expectedResponse->setBuyerAccountId($buyerAccountId);
        $expectedResponse->setExternalDealId($externalDealId);
        $expectedResponse->setAuctionPriorityEnabled($auctionPriorityEnabled);
        $expectedResponse->setBlockOverrideEnabled($blockOverrideEnabled);
        $transport->addResponse($expectedResponse);
        // Mock request
        $privateAuctionDeal = new PrivateAuctionDeal();
        $privateAuctionDealFloorPrice = new Money();
        $privateAuctionDeal->setFloorPrice($privateAuctionDealFloorPrice);
        $updateMask = new FieldMask();
        $request = (new UpdatePrivateAuctionDealRequest())
            ->setPrivateAuctionDeal($privateAuctionDeal)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updatePrivateAuctionDeal($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.PrivateAuctionDealService/UpdatePrivateAuctionDeal',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getPrivateAuctionDeal();
        $this->assertProtobufEquals($privateAuctionDeal, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updatePrivateAuctionDealExceptionTest()
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
        $privateAuctionDeal = new PrivateAuctionDeal();
        $privateAuctionDealFloorPrice = new Money();
        $privateAuctionDeal->setFloorPrice($privateAuctionDealFloorPrice);
        $updateMask = new FieldMask();
        $request = (new UpdatePrivateAuctionDealRequest())
            ->setPrivateAuctionDeal($privateAuctionDeal)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updatePrivateAuctionDeal($request);
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
    public function createPrivateAuctionDealAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $privateAuctionDealId = 1870574870;
        $privateAuctionId = 20317997;
        $privateAuctionDisplayName = 'privateAuctionDisplayName742713760';
        $buyerAccountId = 994282887;
        $externalDealId = 66314918;
        $auctionPriorityEnabled = true;
        $blockOverrideEnabled = true;
        $expectedResponse = new PrivateAuctionDeal();
        $expectedResponse->setName($name);
        $expectedResponse->setPrivateAuctionDealId($privateAuctionDealId);
        $expectedResponse->setPrivateAuctionId($privateAuctionId);
        $expectedResponse->setPrivateAuctionDisplayName($privateAuctionDisplayName);
        $expectedResponse->setBuyerAccountId($buyerAccountId);
        $expectedResponse->setExternalDealId($externalDealId);
        $expectedResponse->setAuctionPriorityEnabled($auctionPriorityEnabled);
        $expectedResponse->setBlockOverrideEnabled($blockOverrideEnabled);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $privateAuctionDeal = new PrivateAuctionDeal();
        $privateAuctionDealFloorPrice = new Money();
        $privateAuctionDeal->setFloorPrice($privateAuctionDealFloorPrice);
        $request = (new CreatePrivateAuctionDealRequest())
            ->setParent($formattedParent)
            ->setPrivateAuctionDeal($privateAuctionDeal);
        $response = $gapicClient->createPrivateAuctionDealAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.PrivateAuctionDealService/CreatePrivateAuctionDeal',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getPrivateAuctionDeal();
        $this->assertProtobufEquals($privateAuctionDeal, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
