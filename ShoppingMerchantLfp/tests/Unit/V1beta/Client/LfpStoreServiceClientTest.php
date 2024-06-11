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
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use Google\Shopping\Merchant\Lfp\V1beta\Client\LfpStoreServiceClient;
use Google\Shopping\Merchant\Lfp\V1beta\DeleteLfpStoreRequest;
use Google\Shopping\Merchant\Lfp\V1beta\GetLfpStoreRequest;
use Google\Shopping\Merchant\Lfp\V1beta\InsertLfpStoreRequest;
use Google\Shopping\Merchant\Lfp\V1beta\LfpStore;
use Google\Shopping\Merchant\Lfp\V1beta\ListLfpStoresRequest;
use Google\Shopping\Merchant\Lfp\V1beta\ListLfpStoresResponse;
use stdClass;

/**
 * @group lfp
 *
 * @group gapic
 */
class LfpStoreServiceClientTest extends GeneratedTest
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

    /** @return LfpStoreServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new LfpStoreServiceClient($options);
    }

    /** @test */
    public function deleteLfpStoreTest()
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
        $formattedName = $gapicClient->lfpStoreName('[ACCOUNT]', '[TARGET_MERCHANT]', '[STORE_CODE]');
        $request = (new DeleteLfpStoreRequest())->setName($formattedName);
        $gapicClient->deleteLfpStore($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.lfp.v1beta.LfpStoreService/DeleteLfpStore', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteLfpStoreExceptionTest()
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
        $formattedName = $gapicClient->lfpStoreName('[ACCOUNT]', '[TARGET_MERCHANT]', '[STORE_CODE]');
        $request = (new DeleteLfpStoreRequest())->setName($formattedName);
        try {
            $gapicClient->deleteLfpStore($request);
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
    public function getLfpStoreTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $targetAccount = 475823745;
        $storeCode = 'storeCode921424523';
        $storeAddress = 'storeAddress-1067464042';
        $storeName = 'storeName921739049';
        $phoneNumber = 'phoneNumber-612351174';
        $websiteUri = 'websiteUri-2118185016';
        $placeId = 'placeId1858938707';
        $matchingStateHint = 'matchingStateHint-1034076425';
        $expectedResponse = new LfpStore();
        $expectedResponse->setName($name2);
        $expectedResponse->setTargetAccount($targetAccount);
        $expectedResponse->setStoreCode($storeCode);
        $expectedResponse->setStoreAddress($storeAddress);
        $expectedResponse->setStoreName($storeName);
        $expectedResponse->setPhoneNumber($phoneNumber);
        $expectedResponse->setWebsiteUri($websiteUri);
        $expectedResponse->setPlaceId($placeId);
        $expectedResponse->setMatchingStateHint($matchingStateHint);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->lfpStoreName('[ACCOUNT]', '[TARGET_MERCHANT]', '[STORE_CODE]');
        $request = (new GetLfpStoreRequest())->setName($formattedName);
        $response = $gapicClient->getLfpStore($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.lfp.v1beta.LfpStoreService/GetLfpStore', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getLfpStoreExceptionTest()
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
        $formattedName = $gapicClient->lfpStoreName('[ACCOUNT]', '[TARGET_MERCHANT]', '[STORE_CODE]');
        $request = (new GetLfpStoreRequest())->setName($formattedName);
        try {
            $gapicClient->getLfpStore($request);
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
    public function insertLfpStoreTest()
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
        $storeAddress = 'storeAddress-1067464042';
        $storeName = 'storeName921739049';
        $phoneNumber = 'phoneNumber-612351174';
        $websiteUri = 'websiteUri-2118185016';
        $placeId = 'placeId1858938707';
        $matchingStateHint = 'matchingStateHint-1034076425';
        $expectedResponse = new LfpStore();
        $expectedResponse->setName($name);
        $expectedResponse->setTargetAccount($targetAccount);
        $expectedResponse->setStoreCode($storeCode);
        $expectedResponse->setStoreAddress($storeAddress);
        $expectedResponse->setStoreName($storeName);
        $expectedResponse->setPhoneNumber($phoneNumber);
        $expectedResponse->setWebsiteUri($websiteUri);
        $expectedResponse->setPlaceId($placeId);
        $expectedResponse->setMatchingStateHint($matchingStateHint);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $lfpStore = new LfpStore();
        $lfpStoreTargetAccount = 1057875153;
        $lfpStore->setTargetAccount($lfpStoreTargetAccount);
        $lfpStoreStoreCode = 'lfpStoreStoreCode1730784867';
        $lfpStore->setStoreCode($lfpStoreStoreCode);
        $lfpStoreStoreAddress = 'lfpStoreStoreAddress-1359855682';
        $lfpStore->setStoreAddress($lfpStoreStoreAddress);
        $request = (new InsertLfpStoreRequest())->setParent($formattedParent)->setLfpStore($lfpStore);
        $response = $gapicClient->insertLfpStore($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.lfp.v1beta.LfpStoreService/InsertLfpStore', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getLfpStore();
        $this->assertProtobufEquals($lfpStore, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function insertLfpStoreExceptionTest()
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
        $lfpStore = new LfpStore();
        $lfpStoreTargetAccount = 1057875153;
        $lfpStore->setTargetAccount($lfpStoreTargetAccount);
        $lfpStoreStoreCode = 'lfpStoreStoreCode1730784867';
        $lfpStore->setStoreCode($lfpStoreStoreCode);
        $lfpStoreStoreAddress = 'lfpStoreStoreAddress-1359855682';
        $lfpStore->setStoreAddress($lfpStoreStoreAddress);
        $request = (new InsertLfpStoreRequest())->setParent($formattedParent)->setLfpStore($lfpStore);
        try {
            $gapicClient->insertLfpStore($request);
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
    public function listLfpStoresTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $lfpStoresElement = new LfpStore();
        $lfpStores = [$lfpStoresElement];
        $expectedResponse = new ListLfpStoresResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setLfpStores($lfpStores);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $targetAccount = 475823745;
        $request = (new ListLfpStoresRequest())->setParent($formattedParent)->setTargetAccount($targetAccount);
        $response = $gapicClient->listLfpStores($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getLfpStores()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.lfp.v1beta.LfpStoreService/ListLfpStores', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getTargetAccount();
        $this->assertProtobufEquals($targetAccount, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listLfpStoresExceptionTest()
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
        $targetAccount = 475823745;
        $request = (new ListLfpStoresRequest())->setParent($formattedParent)->setTargetAccount($targetAccount);
        try {
            $gapicClient->listLfpStores($request);
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
    public function deleteLfpStoreAsyncTest()
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
        $formattedName = $gapicClient->lfpStoreName('[ACCOUNT]', '[TARGET_MERCHANT]', '[STORE_CODE]');
        $request = (new DeleteLfpStoreRequest())->setName($formattedName);
        $gapicClient->deleteLfpStoreAsync($request)->wait();
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.lfp.v1beta.LfpStoreService/DeleteLfpStore', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
