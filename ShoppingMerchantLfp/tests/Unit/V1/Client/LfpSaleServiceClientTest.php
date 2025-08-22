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

namespace Google\Shopping\Merchant\Lfp\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\Timestamp;
use Google\Rpc\Code;
use Google\Shopping\Merchant\Lfp\V1\Client\LfpSaleServiceClient;
use Google\Shopping\Merchant\Lfp\V1\InsertLfpSaleRequest;
use Google\Shopping\Merchant\Lfp\V1\LfpSale;
use Google\Shopping\Type\Price;
use stdClass;

/**
 * @group lfp
 *
 * @group gapic
 */
class LfpSaleServiceClientTest extends GeneratedTest
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

    /** @return LfpSaleServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new LfpSaleServiceClient($options);
    }

    /** @test */
    public function insertLfpSaleTest()
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
        $quantity = 1285004149;
        $uid = 'uid115792';
        $feedLabel = 'feedLabel574920979';
        $expectedResponse = new LfpSale();
        $expectedResponse->setName($name);
        $expectedResponse->setTargetAccount($targetAccount);
        $expectedResponse->setStoreCode($storeCode);
        $expectedResponse->setOfferId($offerId);
        $expectedResponse->setRegionCode($regionCode);
        $expectedResponse->setContentLanguage($contentLanguage);
        $expectedResponse->setGtin($gtin);
        $expectedResponse->setQuantity($quantity);
        $expectedResponse->setUid($uid);
        $expectedResponse->setFeedLabel($feedLabel);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $lfpSale = new LfpSale();
        $lfpSaleTargetAccount = 1054087489;
        $lfpSale->setTargetAccount($lfpSaleTargetAccount);
        $lfpSaleStoreCode = 'lfpSaleStoreCode344053585';
        $lfpSale->setStoreCode($lfpSaleStoreCode);
        $lfpSaleOfferId = 'lfpSaleOfferId353693242';
        $lfpSale->setOfferId($lfpSaleOfferId);
        $lfpSaleRegionCode = 'lfpSaleRegionCode-811190658';
        $lfpSale->setRegionCode($lfpSaleRegionCode);
        $lfpSaleContentLanguage = 'lfpSaleContentLanguage1086341524';
        $lfpSale->setContentLanguage($lfpSaleContentLanguage);
        $lfpSaleGtin = 'lfpSaleGtin2062138383';
        $lfpSale->setGtin($lfpSaleGtin);
        $lfpSalePrice = new Price();
        $lfpSale->setPrice($lfpSalePrice);
        $lfpSaleQuantity = 1858119496;
        $lfpSale->setQuantity($lfpSaleQuantity);
        $lfpSaleSaleTime = new Timestamp();
        $lfpSale->setSaleTime($lfpSaleSaleTime);
        $request = (new InsertLfpSaleRequest())->setParent($parent)->setLfpSale($lfpSale);
        $response = $gapicClient->insertLfpSale($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.lfp.v1.LfpSaleService/InsertLfpSale', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getLfpSale();
        $this->assertProtobufEquals($lfpSale, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function insertLfpSaleExceptionTest()
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
        $parent = 'parent-995424086';
        $lfpSale = new LfpSale();
        $lfpSaleTargetAccount = 1054087489;
        $lfpSale->setTargetAccount($lfpSaleTargetAccount);
        $lfpSaleStoreCode = 'lfpSaleStoreCode344053585';
        $lfpSale->setStoreCode($lfpSaleStoreCode);
        $lfpSaleOfferId = 'lfpSaleOfferId353693242';
        $lfpSale->setOfferId($lfpSaleOfferId);
        $lfpSaleRegionCode = 'lfpSaleRegionCode-811190658';
        $lfpSale->setRegionCode($lfpSaleRegionCode);
        $lfpSaleContentLanguage = 'lfpSaleContentLanguage1086341524';
        $lfpSale->setContentLanguage($lfpSaleContentLanguage);
        $lfpSaleGtin = 'lfpSaleGtin2062138383';
        $lfpSale->setGtin($lfpSaleGtin);
        $lfpSalePrice = new Price();
        $lfpSale->setPrice($lfpSalePrice);
        $lfpSaleQuantity = 1858119496;
        $lfpSale->setQuantity($lfpSaleQuantity);
        $lfpSaleSaleTime = new Timestamp();
        $lfpSale->setSaleTime($lfpSaleSaleTime);
        $request = (new InsertLfpSaleRequest())->setParent($parent)->setLfpSale($lfpSale);
        try {
            $gapicClient->insertLfpSale($request);
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
    public function insertLfpSaleAsyncTest()
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
        $quantity = 1285004149;
        $uid = 'uid115792';
        $feedLabel = 'feedLabel574920979';
        $expectedResponse = new LfpSale();
        $expectedResponse->setName($name);
        $expectedResponse->setTargetAccount($targetAccount);
        $expectedResponse->setStoreCode($storeCode);
        $expectedResponse->setOfferId($offerId);
        $expectedResponse->setRegionCode($regionCode);
        $expectedResponse->setContentLanguage($contentLanguage);
        $expectedResponse->setGtin($gtin);
        $expectedResponse->setQuantity($quantity);
        $expectedResponse->setUid($uid);
        $expectedResponse->setFeedLabel($feedLabel);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $lfpSale = new LfpSale();
        $lfpSaleTargetAccount = 1054087489;
        $lfpSale->setTargetAccount($lfpSaleTargetAccount);
        $lfpSaleStoreCode = 'lfpSaleStoreCode344053585';
        $lfpSale->setStoreCode($lfpSaleStoreCode);
        $lfpSaleOfferId = 'lfpSaleOfferId353693242';
        $lfpSale->setOfferId($lfpSaleOfferId);
        $lfpSaleRegionCode = 'lfpSaleRegionCode-811190658';
        $lfpSale->setRegionCode($lfpSaleRegionCode);
        $lfpSaleContentLanguage = 'lfpSaleContentLanguage1086341524';
        $lfpSale->setContentLanguage($lfpSaleContentLanguage);
        $lfpSaleGtin = 'lfpSaleGtin2062138383';
        $lfpSale->setGtin($lfpSaleGtin);
        $lfpSalePrice = new Price();
        $lfpSale->setPrice($lfpSalePrice);
        $lfpSaleQuantity = 1858119496;
        $lfpSale->setQuantity($lfpSaleQuantity);
        $lfpSaleSaleTime = new Timestamp();
        $lfpSale->setSaleTime($lfpSaleSaleTime);
        $request = (new InsertLfpSaleRequest())->setParent($parent)->setLfpSale($lfpSale);
        $response = $gapicClient->insertLfpSaleAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.lfp.v1.LfpSaleService/InsertLfpSale', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getLfpSale();
        $this->assertProtobufEquals($lfpSale, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
