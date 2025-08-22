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
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use Google\Shopping\Merchant\Accounts\V1\AccountService;
use Google\Shopping\Merchant\Accounts\V1\ApproveAccountServiceRequest;
use Google\Shopping\Merchant\Accounts\V1\Client\AccountServicesServiceClient;
use Google\Shopping\Merchant\Accounts\V1\GetAccountServiceRequest;
use Google\Shopping\Merchant\Accounts\V1\ListAccountServicesRequest;
use Google\Shopping\Merchant\Accounts\V1\ListAccountServicesResponse;
use Google\Shopping\Merchant\Accounts\V1\ProposeAccountServiceRequest;
use Google\Shopping\Merchant\Accounts\V1\RejectAccountServiceRequest;
use stdClass;

/**
 * @group accounts
 *
 * @group gapic
 */
class AccountServicesServiceClientTest extends GeneratedTest
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

    /** @return AccountServicesServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AccountServicesServiceClient($options);
    }

    /** @test */
    public function approveAccountServiceTest()
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
        $externalAccountId = 'externalAccountId-1800056479';
        $expectedResponse = new AccountService();
        $expectedResponse->setName($name2);
        $expectedResponse->setProvider($provider);
        $expectedResponse->setProviderDisplayName($providerDisplayName);
        $expectedResponse->setExternalAccountId($externalAccountId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->accountServiceName('[ACCOUNT]', '[SERVICE]');
        $request = (new ApproveAccountServiceRequest())->setName($formattedName);
        $response = $gapicClient->approveAccountService($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1.AccountServicesService/ApproveAccountService',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function approveAccountServiceExceptionTest()
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
        $formattedName = $gapicClient->accountServiceName('[ACCOUNT]', '[SERVICE]');
        $request = (new ApproveAccountServiceRequest())->setName($formattedName);
        try {
            $gapicClient->approveAccountService($request);
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
    public function getAccountServiceTest()
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
        $externalAccountId = 'externalAccountId-1800056479';
        $expectedResponse = new AccountService();
        $expectedResponse->setName($name2);
        $expectedResponse->setProvider($provider);
        $expectedResponse->setProviderDisplayName($providerDisplayName);
        $expectedResponse->setExternalAccountId($externalAccountId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->accountServiceName('[ACCOUNT]', '[SERVICE]');
        $request = (new GetAccountServiceRequest())->setName($formattedName);
        $response = $gapicClient->getAccountService($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1.AccountServicesService/GetAccountService',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAccountServiceExceptionTest()
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
        $formattedName = $gapicClient->accountServiceName('[ACCOUNT]', '[SERVICE]');
        $request = (new GetAccountServiceRequest())->setName($formattedName);
        try {
            $gapicClient->getAccountService($request);
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
    public function listAccountServicesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $accountServicesElement = new AccountService();
        $accountServices = [$accountServicesElement];
        $expectedResponse = new ListAccountServicesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAccountServices($accountServices);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $request = (new ListAccountServicesRequest())->setParent($formattedParent);
        $response = $gapicClient->listAccountServices($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAccountServices()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1.AccountServicesService/ListAccountServices',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAccountServicesExceptionTest()
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
        $request = (new ListAccountServicesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listAccountServices($request);
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
    public function proposeAccountServiceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $provider2 = 'provider2205150564';
        $providerDisplayName = 'providerDisplayName-1896179850';
        $externalAccountId = 'externalAccountId-1800056479';
        $expectedResponse = new AccountService();
        $expectedResponse->setName($name);
        $expectedResponse->setProvider($provider2);
        $expectedResponse->setProviderDisplayName($providerDisplayName);
        $expectedResponse->setExternalAccountId($externalAccountId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $provider = 'provider-987494927';
        $accountService = new AccountService();
        $request = (new ProposeAccountServiceRequest())
            ->setParent($formattedParent)
            ->setProvider($provider)
            ->setAccountService($accountService);
        $response = $gapicClient->proposeAccountService($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1.AccountServicesService/ProposeAccountService',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getProvider();
        $this->assertProtobufEquals($provider, $actualValue);
        $actualValue = $actualRequestObject->getAccountService();
        $this->assertProtobufEquals($accountService, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function proposeAccountServiceExceptionTest()
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
        $provider = 'provider-987494927';
        $accountService = new AccountService();
        $request = (new ProposeAccountServiceRequest())
            ->setParent($formattedParent)
            ->setProvider($provider)
            ->setAccountService($accountService);
        try {
            $gapicClient->proposeAccountService($request);
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
    public function rejectAccountServiceTest()
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
        $formattedName = $gapicClient->accountServiceName('[ACCOUNT]', '[SERVICE]');
        $request = (new RejectAccountServiceRequest())->setName($formattedName);
        $gapicClient->rejectAccountService($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1.AccountServicesService/RejectAccountService',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function rejectAccountServiceExceptionTest()
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
        $formattedName = $gapicClient->accountServiceName('[ACCOUNT]', '[SERVICE]');
        $request = (new RejectAccountServiceRequest())->setName($formattedName);
        try {
            $gapicClient->rejectAccountService($request);
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
    public function approveAccountServiceAsyncTest()
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
        $externalAccountId = 'externalAccountId-1800056479';
        $expectedResponse = new AccountService();
        $expectedResponse->setName($name2);
        $expectedResponse->setProvider($provider);
        $expectedResponse->setProviderDisplayName($providerDisplayName);
        $expectedResponse->setExternalAccountId($externalAccountId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->accountServiceName('[ACCOUNT]', '[SERVICE]');
        $request = (new ApproveAccountServiceRequest())->setName($formattedName);
        $response = $gapicClient->approveAccountServiceAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1.AccountServicesService/ApproveAccountService',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
