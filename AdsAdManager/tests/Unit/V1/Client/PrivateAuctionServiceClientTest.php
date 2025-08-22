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

use Google\Ads\AdManager\V1\Client\PrivateAuctionServiceClient;
use Google\Ads\AdManager\V1\CreatePrivateAuctionRequest;
use Google\Ads\AdManager\V1\GetPrivateAuctionRequest;
use Google\Ads\AdManager\V1\ListPrivateAuctionsRequest;
use Google\Ads\AdManager\V1\ListPrivateAuctionsResponse;
use Google\Ads\AdManager\V1\PrivateAuction;
use Google\Ads\AdManager\V1\UpdatePrivateAuctionRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\FieldMask;
use Google\Rpc\Code;
use stdClass;

/**
 * @group admanager
 *
 * @group gapic
 */
class PrivateAuctionServiceClientTest extends GeneratedTest
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

    /** @return PrivateAuctionServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new PrivateAuctionServiceClient($options);
    }

    /** @test */
    public function createPrivateAuctionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $privateAuctionId = 20317997;
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $archived = true;
        $expectedResponse = new PrivateAuction();
        $expectedResponse->setName($name);
        $expectedResponse->setPrivateAuctionId($privateAuctionId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setArchived($archived);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $privateAuction = new PrivateAuction();
        $privateAuctionDisplayName = 'privateAuctionDisplayName1032179469';
        $privateAuction->setDisplayName($privateAuctionDisplayName);
        $request = (new CreatePrivateAuctionRequest())->setParent($formattedParent)->setPrivateAuction($privateAuction);
        $response = $gapicClient->createPrivateAuction($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.PrivateAuctionService/CreatePrivateAuction', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getPrivateAuction();
        $this->assertProtobufEquals($privateAuction, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createPrivateAuctionExceptionTest()
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
        $privateAuction = new PrivateAuction();
        $privateAuctionDisplayName = 'privateAuctionDisplayName1032179469';
        $privateAuction->setDisplayName($privateAuctionDisplayName);
        $request = (new CreatePrivateAuctionRequest())->setParent($formattedParent)->setPrivateAuction($privateAuction);
        try {
            $gapicClient->createPrivateAuction($request);
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
    public function getPrivateAuctionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $privateAuctionId = 20317997;
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $archived = true;
        $expectedResponse = new PrivateAuction();
        $expectedResponse->setName($name2);
        $expectedResponse->setPrivateAuctionId($privateAuctionId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setArchived($archived);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->privateAuctionName('[NETWORK_CODE]', '[PRIVATE_AUCTION]');
        $request = (new GetPrivateAuctionRequest())->setName($formattedName);
        $response = $gapicClient->getPrivateAuction($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.PrivateAuctionService/GetPrivateAuction', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getPrivateAuctionExceptionTest()
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
        $formattedName = $gapicClient->privateAuctionName('[NETWORK_CODE]', '[PRIVATE_AUCTION]');
        $request = (new GetPrivateAuctionRequest())->setName($formattedName);
        try {
            $gapicClient->getPrivateAuction($request);
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
    public function listPrivateAuctionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $privateAuctionsElement = new PrivateAuction();
        $privateAuctions = [$privateAuctionsElement];
        $expectedResponse = new ListPrivateAuctionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setPrivateAuctions($privateAuctions);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListPrivateAuctionsRequest())->setParent($formattedParent);
        $response = $gapicClient->listPrivateAuctions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getPrivateAuctions()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.PrivateAuctionService/ListPrivateAuctions', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listPrivateAuctionsExceptionTest()
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
        $request = (new ListPrivateAuctionsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listPrivateAuctions($request);
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
    public function updatePrivateAuctionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $privateAuctionId = 20317997;
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $archived = true;
        $expectedResponse = new PrivateAuction();
        $expectedResponse->setName($name);
        $expectedResponse->setPrivateAuctionId($privateAuctionId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setArchived($archived);
        $transport->addResponse($expectedResponse);
        // Mock request
        $privateAuction = new PrivateAuction();
        $privateAuctionDisplayName = 'privateAuctionDisplayName1032179469';
        $privateAuction->setDisplayName($privateAuctionDisplayName);
        $updateMask = new FieldMask();
        $request = (new UpdatePrivateAuctionRequest())->setPrivateAuction($privateAuction)->setUpdateMask($updateMask);
        $response = $gapicClient->updatePrivateAuction($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.PrivateAuctionService/UpdatePrivateAuction', $actualFuncCall);
        $actualValue = $actualRequestObject->getPrivateAuction();
        $this->assertProtobufEquals($privateAuction, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updatePrivateAuctionExceptionTest()
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
        $privateAuction = new PrivateAuction();
        $privateAuctionDisplayName = 'privateAuctionDisplayName1032179469';
        $privateAuction->setDisplayName($privateAuctionDisplayName);
        $updateMask = new FieldMask();
        $request = (new UpdatePrivateAuctionRequest())->setPrivateAuction($privateAuction)->setUpdateMask($updateMask);
        try {
            $gapicClient->updatePrivateAuction($request);
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
    public function createPrivateAuctionAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $privateAuctionId = 20317997;
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $archived = true;
        $expectedResponse = new PrivateAuction();
        $expectedResponse->setName($name);
        $expectedResponse->setPrivateAuctionId($privateAuctionId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setArchived($archived);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $privateAuction = new PrivateAuction();
        $privateAuctionDisplayName = 'privateAuctionDisplayName1032179469';
        $privateAuction->setDisplayName($privateAuctionDisplayName);
        $request = (new CreatePrivateAuctionRequest())->setParent($formattedParent)->setPrivateAuction($privateAuction);
        $response = $gapicClient->createPrivateAuctionAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.PrivateAuctionService/CreatePrivateAuction', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getPrivateAuction();
        $this->assertProtobufEquals($privateAuction, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
