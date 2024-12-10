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

namespace Google\Shopping\Merchant\Accounts\Tests\Unit\V1beta\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use Google\Shopping\Merchant\Accounts\V1beta\Account;
use Google\Shopping\Merchant\Accounts\V1beta\Client\AccountsServiceClient;
use Google\Shopping\Merchant\Accounts\V1beta\CreateAndConfigureAccountRequest;
use Google\Shopping\Merchant\Accounts\V1beta\DeleteAccountRequest;
use Google\Shopping\Merchant\Accounts\V1beta\GetAccountRequest;
use Google\Shopping\Merchant\Accounts\V1beta\ListAccountsRequest;
use Google\Shopping\Merchant\Accounts\V1beta\ListAccountsResponse;
use Google\Shopping\Merchant\Accounts\V1beta\ListSubAccountsRequest;
use Google\Shopping\Merchant\Accounts\V1beta\ListSubAccountsResponse;
use Google\Shopping\Merchant\Accounts\V1beta\UpdateAccountRequest;
use Google\Type\TimeZone;
use stdClass;

/**
 * @group accounts
 *
 * @group gapic
 */
class AccountsServiceClientTest extends GeneratedTest
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

    /** @return AccountsServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AccountsServiceClient($options);
    }

    /** @test */
    public function createAndConfigureAccountTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $accountId = 803333011;
        $accountName = 'accountName1091239261';
        $adultContent = true;
        $testAccount = true;
        $languageCode = 'languageCode-412800396';
        $expectedResponse = new Account();
        $expectedResponse->setName($name);
        $expectedResponse->setAccountId($accountId);
        $expectedResponse->setAccountName($accountName);
        $expectedResponse->setAdultContent($adultContent);
        $expectedResponse->setTestAccount($testAccount);
        $expectedResponse->setLanguageCode($languageCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $account = new Account();
        $accountAccountName = 'accountAccountName-1464628757';
        $account->setAccountName($accountAccountName);
        $accountTimeZone = new TimeZone();
        $account->setTimeZone($accountTimeZone);
        $accountLanguageCode = 'accountLanguageCode-1326363598';
        $account->setLanguageCode($accountLanguageCode);
        $service = [];
        $request = (new CreateAndConfigureAccountRequest())
            ->setAccount($account)
            ->setService($service);
        $response = $gapicClient->createAndConfigureAccount($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1beta.AccountsService/CreateAndConfigureAccount', $actualFuncCall);
        $actualValue = $actualRequestObject->getAccount();
        $this->assertProtobufEquals($account, $actualValue);
        $actualValue = $actualRequestObject->getService();
        $this->assertProtobufEquals($service, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createAndConfigureAccountExceptionTest()
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
        $account = new Account();
        $accountAccountName = 'accountAccountName-1464628757';
        $account->setAccountName($accountAccountName);
        $accountTimeZone = new TimeZone();
        $account->setTimeZone($accountTimeZone);
        $accountLanguageCode = 'accountLanguageCode-1326363598';
        $account->setLanguageCode($accountLanguageCode);
        $service = [];
        $request = (new CreateAndConfigureAccountRequest())
            ->setAccount($account)
            ->setService($service);
        try {
            $gapicClient->createAndConfigureAccount($request);
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
    public function deleteAccountTest()
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
        $formattedName = $gapicClient->accountName('[ACCOUNT]');
        $request = (new DeleteAccountRequest())
            ->setName($formattedName);
        $gapicClient->deleteAccount($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1beta.AccountsService/DeleteAccount', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteAccountExceptionTest()
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
        $formattedName = $gapicClient->accountName('[ACCOUNT]');
        $request = (new DeleteAccountRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteAccount($request);
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
    public function getAccountTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $accountId = 803333011;
        $accountName = 'accountName1091239261';
        $adultContent = true;
        $testAccount = true;
        $languageCode = 'languageCode-412800396';
        $expectedResponse = new Account();
        $expectedResponse->setName($name2);
        $expectedResponse->setAccountId($accountId);
        $expectedResponse->setAccountName($accountName);
        $expectedResponse->setAdultContent($adultContent);
        $expectedResponse->setTestAccount($testAccount);
        $expectedResponse->setLanguageCode($languageCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->accountName('[ACCOUNT]');
        $request = (new GetAccountRequest())
            ->setName($formattedName);
        $response = $gapicClient->getAccount($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1beta.AccountsService/GetAccount', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAccountExceptionTest()
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
        $formattedName = $gapicClient->accountName('[ACCOUNT]');
        $request = (new GetAccountRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getAccount($request);
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
    public function listAccountsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $accountsElement = new Account();
        $accounts = [
            $accountsElement,
        ];
        $expectedResponse = new ListAccountsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAccounts($accounts);
        $transport->addResponse($expectedResponse);
        $request = new ListAccountsRequest();
        $response = $gapicClient->listAccounts($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAccounts()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1beta.AccountsService/ListAccounts', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAccountsExceptionTest()
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
        $request = new ListAccountsRequest();
        try {
            $gapicClient->listAccounts($request);
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
    public function listSubAccountsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $accountsElement = new Account();
        $accounts = [
            $accountsElement,
        ];
        $expectedResponse = new ListSubAccountsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAccounts($accounts);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedProvider = $gapicClient->accountName('[ACCOUNT]');
        $request = (new ListSubAccountsRequest())
            ->setProvider($formattedProvider);
        $response = $gapicClient->listSubAccounts($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAccounts()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1beta.AccountsService/ListSubAccounts', $actualFuncCall);
        $actualValue = $actualRequestObject->getProvider();
        $this->assertProtobufEquals($formattedProvider, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listSubAccountsExceptionTest()
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
        $formattedProvider = $gapicClient->accountName('[ACCOUNT]');
        $request = (new ListSubAccountsRequest())
            ->setProvider($formattedProvider);
        try {
            $gapicClient->listSubAccounts($request);
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
    public function updateAccountTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $accountId = 803333011;
        $accountName = 'accountName1091239261';
        $adultContent = true;
        $testAccount = true;
        $languageCode = 'languageCode-412800396';
        $expectedResponse = new Account();
        $expectedResponse->setName($name);
        $expectedResponse->setAccountId($accountId);
        $expectedResponse->setAccountName($accountName);
        $expectedResponse->setAdultContent($adultContent);
        $expectedResponse->setTestAccount($testAccount);
        $expectedResponse->setLanguageCode($languageCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $account = new Account();
        $accountAccountName = 'accountAccountName-1464628757';
        $account->setAccountName($accountAccountName);
        $accountTimeZone = new TimeZone();
        $account->setTimeZone($accountTimeZone);
        $accountLanguageCode = 'accountLanguageCode-1326363598';
        $account->setLanguageCode($accountLanguageCode);
        $updateMask = new FieldMask();
        $request = (new UpdateAccountRequest())
            ->setAccount($account)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateAccount($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1beta.AccountsService/UpdateAccount', $actualFuncCall);
        $actualValue = $actualRequestObject->getAccount();
        $this->assertProtobufEquals($account, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateAccountExceptionTest()
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
        $account = new Account();
        $accountAccountName = 'accountAccountName-1464628757';
        $account->setAccountName($accountAccountName);
        $accountTimeZone = new TimeZone();
        $account->setTimeZone($accountTimeZone);
        $accountLanguageCode = 'accountLanguageCode-1326363598';
        $account->setLanguageCode($accountLanguageCode);
        $updateMask = new FieldMask();
        $request = (new UpdateAccountRequest())
            ->setAccount($account)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateAccount($request);
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
    public function createAndConfigureAccountAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $accountId = 803333011;
        $accountName = 'accountName1091239261';
        $adultContent = true;
        $testAccount = true;
        $languageCode = 'languageCode-412800396';
        $expectedResponse = new Account();
        $expectedResponse->setName($name);
        $expectedResponse->setAccountId($accountId);
        $expectedResponse->setAccountName($accountName);
        $expectedResponse->setAdultContent($adultContent);
        $expectedResponse->setTestAccount($testAccount);
        $expectedResponse->setLanguageCode($languageCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $account = new Account();
        $accountAccountName = 'accountAccountName-1464628757';
        $account->setAccountName($accountAccountName);
        $accountTimeZone = new TimeZone();
        $account->setTimeZone($accountTimeZone);
        $accountLanguageCode = 'accountLanguageCode-1326363598';
        $account->setLanguageCode($accountLanguageCode);
        $service = [];
        $request = (new CreateAndConfigureAccountRequest())
            ->setAccount($account)
            ->setService($service);
        $response = $gapicClient->createAndConfigureAccountAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1beta.AccountsService/CreateAndConfigureAccount', $actualFuncCall);
        $actualValue = $actualRequestObject->getAccount();
        $this->assertProtobufEquals($account, $actualValue);
        $actualValue = $actualRequestObject->getService();
        $this->assertProtobufEquals($service, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
