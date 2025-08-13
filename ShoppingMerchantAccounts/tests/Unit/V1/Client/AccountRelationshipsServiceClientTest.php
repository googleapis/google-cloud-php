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

namespace Google\Shopping\Merchant\Accounts\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Rpc\Code;
use Google\Shopping\Merchant\Accounts\V1\AccountRelationship;
use Google\Shopping\Merchant\Accounts\V1\Client\AccountRelationshipsServiceClient;
use Google\Shopping\Merchant\Accounts\V1\GetAccountRelationshipRequest;
use Google\Shopping\Merchant\Accounts\V1\ListAccountRelationshipsRequest;
use Google\Shopping\Merchant\Accounts\V1\ListAccountRelationshipsResponse;
use Google\Shopping\Merchant\Accounts\V1\UpdateAccountRelationshipRequest;
use stdClass;

/**
 * @group accounts
 *
 * @group gapic
 */
class AccountRelationshipsServiceClientTest extends GeneratedTest
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

    /** @return AccountRelationshipsServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AccountRelationshipsServiceClient($options);
    }

    /** @test */
    public function getAccountRelationshipTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $provider = 'provider-987494927';
        $providerDisplayName = 'providerDisplayName-1896179850';
        $accountIdAlias = 'accountIdAlias499535870';
        $expectedResponse = new AccountRelationship();
        $expectedResponse->setName($name2);
        $expectedResponse->setProvider($provider);
        $expectedResponse->setProviderDisplayName($providerDisplayName);
        $expectedResponse->setAccountIdAlias($accountIdAlias);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->accountRelationshipName('[ACCOUNT]', '[RELATIONSHIP]');
        $request = (new GetAccountRelationshipRequest())->setName($formattedName);
        $response = $gapicClient->getAccountRelationship($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1.AccountRelationshipsService/GetAccountRelationship',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAccountRelationshipExceptionTest()
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
        $formattedName = $gapicClient->accountRelationshipName('[ACCOUNT]', '[RELATIONSHIP]');
        $request = (new GetAccountRelationshipRequest())->setName($formattedName);
        try {
            $gapicClient->getAccountRelationship($request);
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
    public function listAccountRelationshipsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $accountRelationshipsElement = new AccountRelationship();
        $accountRelationships = [$accountRelationshipsElement];
        $expectedResponse = new ListAccountRelationshipsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAccountRelationships($accountRelationships);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $request = (new ListAccountRelationshipsRequest())->setParent($formattedParent);
        $response = $gapicClient->listAccountRelationships($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAccountRelationships()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1.AccountRelationshipsService/ListAccountRelationships',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAccountRelationshipsExceptionTest()
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
        $request = (new ListAccountRelationshipsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listAccountRelationships($request);
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
    public function updateAccountRelationshipTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $provider = 'provider-987494927';
        $providerDisplayName = 'providerDisplayName-1896179850';
        $accountIdAlias = 'accountIdAlias499535870';
        $expectedResponse = new AccountRelationship();
        $expectedResponse->setName($name);
        $expectedResponse->setProvider($provider);
        $expectedResponse->setProviderDisplayName($providerDisplayName);
        $expectedResponse->setAccountIdAlias($accountIdAlias);
        $transport->addResponse($expectedResponse);
        // Mock request
        $accountRelationship = new AccountRelationship();
        $request = (new UpdateAccountRelationshipRequest())->setAccountRelationship($accountRelationship);
        $response = $gapicClient->updateAccountRelationship($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1.AccountRelationshipsService/UpdateAccountRelationship',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getAccountRelationship();
        $this->assertProtobufEquals($accountRelationship, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateAccountRelationshipExceptionTest()
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
        $accountRelationship = new AccountRelationship();
        $request = (new UpdateAccountRelationshipRequest())->setAccountRelationship($accountRelationship);
        try {
            $gapicClient->updateAccountRelationship($request);
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
    public function getAccountRelationshipAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $provider = 'provider-987494927';
        $providerDisplayName = 'providerDisplayName-1896179850';
        $accountIdAlias = 'accountIdAlias499535870';
        $expectedResponse = new AccountRelationship();
        $expectedResponse->setName($name2);
        $expectedResponse->setProvider($provider);
        $expectedResponse->setProviderDisplayName($providerDisplayName);
        $expectedResponse->setAccountIdAlias($accountIdAlias);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->accountRelationshipName('[ACCOUNT]', '[RELATIONSHIP]');
        $request = (new GetAccountRelationshipRequest())->setName($formattedName);
        $response = $gapicClient->getAccountRelationshipAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1.AccountRelationshipsService/GetAccountRelationship',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
