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

namespace Google\Shopping\Merchant\Lfp\Tests\Unit\V1beta\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Rpc\Code;
use Google\Shopping\Merchant\Lfp\V1beta\Client\LfpInventoryServiceClient;
use Google\Shopping\Merchant\Lfp\V1beta\InsertLfpInventoryRequest;
use Google\Shopping\Merchant\Lfp\V1beta\LfpInventory;
use stdClass;

/**
 * @group lfp
 *
 * @group gapic
 */
class LfpInventoryServiceClientTest extends GeneratedTest
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

    /** @return LfpInventoryServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new LfpInventoryServiceClient($options);
    }

    /** @test */
    public function insertLfpInventoryTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $targetAccount = 475823745;
        $storeCode = 'storeCode921424523';
        $offerId = 'offerId-768546338';
        $regionCode = 'regionCode-1566082984';
        $contentLanguage = 'contentLanguage-1408137122';
        $gtin = 'gtin3183314';
        $availability = 'availability1997542747';
        $quantity = 1285004149;
        $pickupMethod = 'pickupMethod-950845436';
        $pickupSla = 'pickupSla-964667163';
        $feedLabel = 'feedLabel574920979';
        $expectedResponse = new LfpInventory();
        $expectedResponse->setName($name);
        $expectedResponse->setTargetAccount($targetAccount);
        $expectedResponse->setStoreCode($storeCode);
        $expectedResponse->setOfferId($offerId);
        $expectedResponse->setRegionCode($regionCode);
        $expectedResponse->setContentLanguage($contentLanguage);
        $expectedResponse->setGtin($gtin);
        $expectedResponse->setAvailability($availability);
        $expectedResponse->setQuantity($quantity);
        $expectedResponse->setPickupMethod($pickupMethod);
        $expectedResponse->setPickupSla($pickupSla);
        $expectedResponse->setFeedLabel($feedLabel);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $lfpInventory = new LfpInventory();
        $lfpInventoryTargetAccount = 1536575798;
        $lfpInventory->setTargetAccount($lfpInventoryTargetAccount);
        $lfpInventoryStoreCode = 'lfpInventoryStoreCode-797569720';
        $lfpInventory->setStoreCode($lfpInventoryStoreCode);
        $lfpInventoryOfferId = 'lfpInventoryOfferId1572615665';
        $lfpInventory->setOfferId($lfpInventoryOfferId);
        $lfpInventoryRegionCode = 'lfpInventoryRegionCode-1841774745';
        $lfpInventory->setRegionCode($lfpInventoryRegionCode);
        $lfpInventoryContentLanguage = 'lfpInventoryContentLanguage-367271349';
        $lfpInventory->setContentLanguage($lfpInventoryContentLanguage);
        $lfpInventoryAvailability = 'lfpInventoryAvailability-621632447';
        $lfpInventory->setAvailability($lfpInventoryAvailability);
        $request = (new InsertLfpInventoryRequest())->setParent($formattedParent)->setLfpInventory($lfpInventory);
        $response = $gapicClient->insertLfpInventory($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.lfp.v1beta.LfpInventoryService/InsertLfpInventory',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getLfpInventory();
        $this->assertProtobufEquals($lfpInventory, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function insertLfpInventoryExceptionTest()
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
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $lfpInventory = new LfpInventory();
        $lfpInventoryTargetAccount = 1536575798;
        $lfpInventory->setTargetAccount($lfpInventoryTargetAccount);
        $lfpInventoryStoreCode = 'lfpInventoryStoreCode-797569720';
        $lfpInventory->setStoreCode($lfpInventoryStoreCode);
        $lfpInventoryOfferId = 'lfpInventoryOfferId1572615665';
        $lfpInventory->setOfferId($lfpInventoryOfferId);
        $lfpInventoryRegionCode = 'lfpInventoryRegionCode-1841774745';
        $lfpInventory->setRegionCode($lfpInventoryRegionCode);
        $lfpInventoryContentLanguage = 'lfpInventoryContentLanguage-367271349';
        $lfpInventory->setContentLanguage($lfpInventoryContentLanguage);
        $lfpInventoryAvailability = 'lfpInventoryAvailability-621632447';
        $lfpInventory->setAvailability($lfpInventoryAvailability);
        $request = (new InsertLfpInventoryRequest())->setParent($formattedParent)->setLfpInventory($lfpInventory);
        try {
            $gapicClient->insertLfpInventory($request);
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
    public function insertLfpInventoryAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $targetAccount = 475823745;
        $storeCode = 'storeCode921424523';
        $offerId = 'offerId-768546338';
        $regionCode = 'regionCode-1566082984';
        $contentLanguage = 'contentLanguage-1408137122';
        $gtin = 'gtin3183314';
        $availability = 'availability1997542747';
        $quantity = 1285004149;
        $pickupMethod = 'pickupMethod-950845436';
        $pickupSla = 'pickupSla-964667163';
        $feedLabel = 'feedLabel574920979';
        $expectedResponse = new LfpInventory();
        $expectedResponse->setName($name);
        $expectedResponse->setTargetAccount($targetAccount);
        $expectedResponse->setStoreCode($storeCode);
        $expectedResponse->setOfferId($offerId);
        $expectedResponse->setRegionCode($regionCode);
        $expectedResponse->setContentLanguage($contentLanguage);
        $expectedResponse->setGtin($gtin);
        $expectedResponse->setAvailability($availability);
        $expectedResponse->setQuantity($quantity);
        $expectedResponse->setPickupMethod($pickupMethod);
        $expectedResponse->setPickupSla($pickupSla);
        $expectedResponse->setFeedLabel($feedLabel);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $lfpInventory = new LfpInventory();
        $lfpInventoryTargetAccount = 1536575798;
        $lfpInventory->setTargetAccount($lfpInventoryTargetAccount);
        $lfpInventoryStoreCode = 'lfpInventoryStoreCode-797569720';
        $lfpInventory->setStoreCode($lfpInventoryStoreCode);
        $lfpInventoryOfferId = 'lfpInventoryOfferId1572615665';
        $lfpInventory->setOfferId($lfpInventoryOfferId);
        $lfpInventoryRegionCode = 'lfpInventoryRegionCode-1841774745';
        $lfpInventory->setRegionCode($lfpInventoryRegionCode);
        $lfpInventoryContentLanguage = 'lfpInventoryContentLanguage-367271349';
        $lfpInventory->setContentLanguage($lfpInventoryContentLanguage);
        $lfpInventoryAvailability = 'lfpInventoryAvailability-621632447';
        $lfpInventory->setAvailability($lfpInventoryAvailability);
        $request = (new InsertLfpInventoryRequest())->setParent($formattedParent)->setLfpInventory($lfpInventory);
        $response = $gapicClient->insertLfpInventoryAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.lfp.v1beta.LfpInventoryService/InsertLfpInventory',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getLfpInventory();
        $this->assertProtobufEquals($lfpInventory, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
