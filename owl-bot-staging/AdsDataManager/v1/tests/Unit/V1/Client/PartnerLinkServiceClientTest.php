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

namespace Google\Ads\DataManager\Tests\Unit\V1\Client;

use Google\Ads\DataManager\V1\Client\PartnerLinkServiceClient;
use Google\Ads\DataManager\V1\CreatePartnerLinkRequest;
use Google\Ads\DataManager\V1\DeletePartnerLinkRequest;
use Google\Ads\DataManager\V1\PartnerLink;
use Google\Ads\DataManager\V1\ProductAccount;
use Google\Ads\DataManager\V1\SearchPartnerLinksRequest;
use Google\Ads\DataManager\V1\SearchPartnerLinksResponse;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group datamanager
 *
 * @group gapic
 */
class PartnerLinkServiceClientTest extends GeneratedTest
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

    /** @return PartnerLinkServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new PartnerLinkServiceClient($options);
    }

    /** @test */
    public function createPartnerLinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $partnerLinkId = 'partnerLinkId-1867169015';
        $expectedResponse = new PartnerLink();
        $expectedResponse->setName($name);
        $expectedResponse->setPartnerLinkId($partnerLinkId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT_TYPE]', '[ACCOUNT]');
        $partnerLink = new PartnerLink();
        $partnerLinkOwningAccount = new ProductAccount();
        $owningAccountAccountId = 'owningAccountAccountId4879159';
        $partnerLinkOwningAccount->setAccountId($owningAccountAccountId);
        $partnerLink->setOwningAccount($partnerLinkOwningAccount);
        $partnerLinkPartnerAccount = new ProductAccount();
        $partnerAccountAccountId = 'partnerAccountAccountId-604306077';
        $partnerLinkPartnerAccount->setAccountId($partnerAccountAccountId);
        $partnerLink->setPartnerAccount($partnerLinkPartnerAccount);
        $request = (new CreatePartnerLinkRequest())
            ->setParent($formattedParent)
            ->setPartnerLink($partnerLink);
        $response = $gapicClient->createPartnerLink($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.PartnerLinkService/CreatePartnerLink', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getPartnerLink();
        $this->assertProtobufEquals($partnerLink, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createPartnerLinkExceptionTest()
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
        $formattedParent = $gapicClient->accountName('[ACCOUNT_TYPE]', '[ACCOUNT]');
        $partnerLink = new PartnerLink();
        $partnerLinkOwningAccount = new ProductAccount();
        $owningAccountAccountId = 'owningAccountAccountId4879159';
        $partnerLinkOwningAccount->setAccountId($owningAccountAccountId);
        $partnerLink->setOwningAccount($partnerLinkOwningAccount);
        $partnerLinkPartnerAccount = new ProductAccount();
        $partnerAccountAccountId = 'partnerAccountAccountId-604306077';
        $partnerLinkPartnerAccount->setAccountId($partnerAccountAccountId);
        $partnerLink->setPartnerAccount($partnerLinkPartnerAccount);
        $request = (new CreatePartnerLinkRequest())
            ->setParent($formattedParent)
            ->setPartnerLink($partnerLink);
        try {
            $gapicClient->createPartnerLink($request);
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
    public function deletePartnerLinkTest()
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
        $formattedName = $gapicClient->partnerLinkName('[ACCOUNT_TYPE]', '[ACCOUNT]', '[PARTNER_LINK]');
        $request = (new DeletePartnerLinkRequest())
            ->setName($formattedName);
        $gapicClient->deletePartnerLink($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.PartnerLinkService/DeletePartnerLink', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deletePartnerLinkExceptionTest()
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
        $formattedName = $gapicClient->partnerLinkName('[ACCOUNT_TYPE]', '[ACCOUNT]', '[PARTNER_LINK]');
        $request = (new DeletePartnerLinkRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deletePartnerLink($request);
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
    public function searchPartnerLinksTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $partnerLinksElement = new PartnerLink();
        $partnerLinks = [
            $partnerLinksElement,
        ];
        $expectedResponse = new SearchPartnerLinksResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setPartnerLinks($partnerLinks);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT_TYPE]', '[ACCOUNT]');
        $request = (new SearchPartnerLinksRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->searchPartnerLinks($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getPartnerLinks()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.PartnerLinkService/SearchPartnerLinks', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchPartnerLinksExceptionTest()
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
        $formattedParent = $gapicClient->accountName('[ACCOUNT_TYPE]', '[ACCOUNT]');
        $request = (new SearchPartnerLinksRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->searchPartnerLinks($request);
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
    public function createPartnerLinkAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $partnerLinkId = 'partnerLinkId-1867169015';
        $expectedResponse = new PartnerLink();
        $expectedResponse->setName($name);
        $expectedResponse->setPartnerLinkId($partnerLinkId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT_TYPE]', '[ACCOUNT]');
        $partnerLink = new PartnerLink();
        $partnerLinkOwningAccount = new ProductAccount();
        $owningAccountAccountId = 'owningAccountAccountId4879159';
        $partnerLinkOwningAccount->setAccountId($owningAccountAccountId);
        $partnerLink->setOwningAccount($partnerLinkOwningAccount);
        $partnerLinkPartnerAccount = new ProductAccount();
        $partnerAccountAccountId = 'partnerAccountAccountId-604306077';
        $partnerLinkPartnerAccount->setAccountId($partnerAccountAccountId);
        $partnerLink->setPartnerAccount($partnerLinkPartnerAccount);
        $request = (new CreatePartnerLinkRequest())
            ->setParent($formattedParent)
            ->setPartnerLink($partnerLink);
        $response = $gapicClient->createPartnerLinkAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.PartnerLinkService/CreatePartnerLink', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getPartnerLink();
        $this->assertProtobufEquals($partnerLink, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
