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

namespace Google\Shopping\Merchant\Promotions\Tests\Unit\V1beta\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Rpc\Code;
use Google\Shopping\Merchant\Promotions\V1beta\Client\PromotionsServiceClient;
use Google\Shopping\Merchant\Promotions\V1beta\GetPromotionRequest;
use Google\Shopping\Merchant\Promotions\V1beta\InsertPromotionRequest;
use Google\Shopping\Merchant\Promotions\V1beta\ListPromotionsRequest;
use Google\Shopping\Merchant\Promotions\V1beta\ListPromotionsResponse;
use Google\Shopping\Merchant\Promotions\V1beta\Promotion;
use stdClass;

/**
 * @group promotions
 *
 * @group gapic
 */
class PromotionsServiceClientTest extends GeneratedTest
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

    /** @return PromotionsServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new PromotionsServiceClient($options);
    }

    /** @test */
    public function getPromotionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $promotionId = 'promotionId1962741303';
        $contentLanguage = 'contentLanguage-1408137122';
        $targetCountry = 'targetCountry1659326184';
        $dataSource = 'dataSource-1333894576';
        $versionNumber = 135927952;
        $expectedResponse = new Promotion();
        $expectedResponse->setName($name2);
        $expectedResponse->setPromotionId($promotionId);
        $expectedResponse->setContentLanguage($contentLanguage);
        $expectedResponse->setTargetCountry($targetCountry);
        $expectedResponse->setDataSource($dataSource);
        $expectedResponse->setVersionNumber($versionNumber);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->promotionName('[ACCOUNT]', '[PROMOTION]');
        $request = (new GetPromotionRequest())->setName($formattedName);
        $response = $gapicClient->getPromotion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.promotions.v1beta.PromotionsService/GetPromotion',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getPromotionExceptionTest()
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
        $formattedName = $gapicClient->promotionName('[ACCOUNT]', '[PROMOTION]');
        $request = (new GetPromotionRequest())->setName($formattedName);
        try {
            $gapicClient->getPromotion($request);
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
    public function insertPromotionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $promotionId = 'promotionId1962741303';
        $contentLanguage = 'contentLanguage-1408137122';
        $targetCountry = 'targetCountry1659326184';
        $dataSource2 = 'dataSource2-1972430333';
        $versionNumber = 135927952;
        $expectedResponse = new Promotion();
        $expectedResponse->setName($name);
        $expectedResponse->setPromotionId($promotionId);
        $expectedResponse->setContentLanguage($contentLanguage);
        $expectedResponse->setTargetCountry($targetCountry);
        $expectedResponse->setDataSource($dataSource2);
        $expectedResponse->setVersionNumber($versionNumber);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $promotion = new Promotion();
        $promotionPromotionId = 'promotionPromotionId-209461125';
        $promotion->setPromotionId($promotionPromotionId);
        $promotionContentLanguage = 'promotionContentLanguage390538190';
        $promotion->setContentLanguage($promotionContentLanguage);
        $promotionTargetCountry = 'promotionTargetCountry-1176642334';
        $promotion->setTargetCountry($promotionTargetCountry);
        $promotionRedemptionChannel = [];
        $promotion->setRedemptionChannel($promotionRedemptionChannel);
        $dataSource = 'dataSource-1333894576';
        $request = (new InsertPromotionRequest())
            ->setParent($parent)
            ->setPromotion($promotion)
            ->setDataSource($dataSource);
        $response = $gapicClient->insertPromotion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.promotions.v1beta.PromotionsService/InsertPromotion',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getPromotion();
        $this->assertProtobufEquals($promotion, $actualValue);
        $actualValue = $actualRequestObject->getDataSource();
        $this->assertProtobufEquals($dataSource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function insertPromotionExceptionTest()
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
        $promotion = new Promotion();
        $promotionPromotionId = 'promotionPromotionId-209461125';
        $promotion->setPromotionId($promotionPromotionId);
        $promotionContentLanguage = 'promotionContentLanguage390538190';
        $promotion->setContentLanguage($promotionContentLanguage);
        $promotionTargetCountry = 'promotionTargetCountry-1176642334';
        $promotion->setTargetCountry($promotionTargetCountry);
        $promotionRedemptionChannel = [];
        $promotion->setRedemptionChannel($promotionRedemptionChannel);
        $dataSource = 'dataSource-1333894576';
        $request = (new InsertPromotionRequest())
            ->setParent($parent)
            ->setPromotion($promotion)
            ->setDataSource($dataSource);
        try {
            $gapicClient->insertPromotion($request);
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
    public function listPromotionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $promotionsElement = new Promotion();
        $promotions = [$promotionsElement];
        $expectedResponse = new ListPromotionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setPromotions($promotions);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $request = (new ListPromotionsRequest())->setParent($parent);
        $response = $gapicClient->listPromotions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getPromotions()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.promotions.v1beta.PromotionsService/ListPromotions',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listPromotionsExceptionTest()
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
        $request = (new ListPromotionsRequest())->setParent($parent);
        try {
            $gapicClient->listPromotions($request);
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
    public function getPromotionAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $promotionId = 'promotionId1962741303';
        $contentLanguage = 'contentLanguage-1408137122';
        $targetCountry = 'targetCountry1659326184';
        $dataSource = 'dataSource-1333894576';
        $versionNumber = 135927952;
        $expectedResponse = new Promotion();
        $expectedResponse->setName($name2);
        $expectedResponse->setPromotionId($promotionId);
        $expectedResponse->setContentLanguage($contentLanguage);
        $expectedResponse->setTargetCountry($targetCountry);
        $expectedResponse->setDataSource($dataSource);
        $expectedResponse->setVersionNumber($versionNumber);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->promotionName('[ACCOUNT]', '[PROMOTION]');
        $request = (new GetPromotionRequest())->setName($formattedName);
        $response = $gapicClient->getPromotionAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.promotions.v1beta.PromotionsService/GetPromotion',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
