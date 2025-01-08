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

namespace Google\Shopping\Merchant\Reviews\Tests\Unit\V1beta\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use Google\Shopping\Merchant\Reviews\V1beta\Client\MerchantReviewsServiceClient;
use Google\Shopping\Merchant\Reviews\V1beta\DeleteMerchantReviewRequest;
use Google\Shopping\Merchant\Reviews\V1beta\GetMerchantReviewRequest;
use Google\Shopping\Merchant\Reviews\V1beta\InsertMerchantReviewRequest;
use Google\Shopping\Merchant\Reviews\V1beta\ListMerchantReviewsRequest;
use Google\Shopping\Merchant\Reviews\V1beta\ListMerchantReviewsResponse;
use Google\Shopping\Merchant\Reviews\V1beta\MerchantReview;
use stdClass;

/**
 * @group reviews
 *
 * @group gapic
 */
class MerchantReviewsServiceClientTest extends GeneratedTest
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

    /** @return MerchantReviewsServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new MerchantReviewsServiceClient($options);
    }

    /** @test */
    public function deleteMerchantReviewTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->merchantReviewName('[ACCOUNT]', '[NAME]');
        $request = (new DeleteMerchantReviewRequest())->setName($formattedName);
        $gapicClient->deleteMerchantReview($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.reviews.v1beta.MerchantReviewsService/DeleteMerchantReview',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteMerchantReviewExceptionTest()
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
        $formattedName = $gapicClient->merchantReviewName('[ACCOUNT]', '[NAME]');
        $request = (new DeleteMerchantReviewRequest())->setName($formattedName);
        try {
            $gapicClient->deleteMerchantReview($request);
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
    public function getMerchantReviewTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $merchantReviewId = 'merchantReviewId1682589099';
        $dataSource = 'dataSource-1333894576';
        $expectedResponse = new MerchantReview();
        $expectedResponse->setName($name2);
        $expectedResponse->setMerchantReviewId($merchantReviewId);
        $expectedResponse->setDataSource($dataSource);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->merchantReviewName('[ACCOUNT]', '[NAME]');
        $request = (new GetMerchantReviewRequest())->setName($formattedName);
        $response = $gapicClient->getMerchantReview($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.reviews.v1beta.MerchantReviewsService/GetMerchantReview',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getMerchantReviewExceptionTest()
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
        $formattedName = $gapicClient->merchantReviewName('[ACCOUNT]', '[NAME]');
        $request = (new GetMerchantReviewRequest())->setName($formattedName);
        try {
            $gapicClient->getMerchantReview($request);
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
    public function insertMerchantReviewTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $merchantReviewId = 'merchantReviewId1682589099';
        $dataSource2 = 'dataSource2-1972430333';
        $expectedResponse = new MerchantReview();
        $expectedResponse->setName($name);
        $expectedResponse->setMerchantReviewId($merchantReviewId);
        $expectedResponse->setDataSource($dataSource2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $merchantReview = new MerchantReview();
        $merchantReviewMerchantReviewId = 'merchantReviewMerchantReviewId-1175491621';
        $merchantReview->setMerchantReviewId($merchantReviewMerchantReviewId);
        $merchantReviewCustomAttributes = [];
        $merchantReview->setCustomAttributes($merchantReviewCustomAttributes);
        $dataSource = 'dataSource-1333894576';
        $request = (new InsertMerchantReviewRequest())
            ->setParent($parent)
            ->setMerchantReview($merchantReview)
            ->setDataSource($dataSource);
        $response = $gapicClient->insertMerchantReview($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.reviews.v1beta.MerchantReviewsService/InsertMerchantReview',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getMerchantReview();
        $this->assertProtobufEquals($merchantReview, $actualValue);
        $actualValue = $actualRequestObject->getDataSource();
        $this->assertProtobufEquals($dataSource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function insertMerchantReviewExceptionTest()
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
        $merchantReview = new MerchantReview();
        $merchantReviewMerchantReviewId = 'merchantReviewMerchantReviewId-1175491621';
        $merchantReview->setMerchantReviewId($merchantReviewMerchantReviewId);
        $merchantReviewCustomAttributes = [];
        $merchantReview->setCustomAttributes($merchantReviewCustomAttributes);
        $dataSource = 'dataSource-1333894576';
        $request = (new InsertMerchantReviewRequest())
            ->setParent($parent)
            ->setMerchantReview($merchantReview)
            ->setDataSource($dataSource);
        try {
            $gapicClient->insertMerchantReview($request);
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
    public function listMerchantReviewsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $merchantReviewsElement = new MerchantReview();
        $merchantReviews = [$merchantReviewsElement];
        $expectedResponse = new ListMerchantReviewsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setMerchantReviews($merchantReviews);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $request = (new ListMerchantReviewsRequest())->setParent($formattedParent);
        $response = $gapicClient->listMerchantReviews($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getMerchantReviews()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.reviews.v1beta.MerchantReviewsService/ListMerchantReviews',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listMerchantReviewsExceptionTest()
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
        $request = (new ListMerchantReviewsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listMerchantReviews($request);
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
    public function deleteMerchantReviewAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->merchantReviewName('[ACCOUNT]', '[NAME]');
        $request = (new DeleteMerchantReviewRequest())->setName($formattedName);
        $gapicClient->deleteMerchantReviewAsync($request)->wait();
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.reviews.v1beta.MerchantReviewsService/DeleteMerchantReview',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
