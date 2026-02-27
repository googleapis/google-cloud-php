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

use Google\Ads\DataManager\V1\Client\UserListGlobalLicenseServiceClient;
use Google\Ads\DataManager\V1\CreateUserListGlobalLicenseRequest;
use Google\Ads\DataManager\V1\GetUserListGlobalLicenseRequest;
use Google\Ads\DataManager\V1\ListUserListGlobalLicenseCustomerInfosRequest;
use Google\Ads\DataManager\V1\ListUserListGlobalLicenseCustomerInfosResponse;
use Google\Ads\DataManager\V1\ListUserListGlobalLicensesRequest;
use Google\Ads\DataManager\V1\ListUserListGlobalLicensesResponse;
use Google\Ads\DataManager\V1\UpdateUserListGlobalLicenseRequest;
use Google\Ads\DataManager\V1\UserListGlobalLicense;
use Google\Ads\DataManager\V1\UserListGlobalLicenseCustomerInfo;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Rpc\Code;
use stdClass;

/**
 * @group datamanager
 *
 * @group gapic
 */
class UserListGlobalLicenseServiceClientTest extends GeneratedTest
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

    /** @return UserListGlobalLicenseServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new UserListGlobalLicenseServiceClient($options);
    }

    /** @test */
    public function createUserListGlobalLicenseTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $userListId = 1707617256;
        $userListDisplayName = 'userListDisplayName874645109';
        $expectedResponse = new UserListGlobalLicense();
        $expectedResponse->setName($name);
        $expectedResponse->setUserListId($userListId);
        $expectedResponse->setUserListDisplayName($userListDisplayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT_TYPE]', '[ACCOUNT]');
        $userListGlobalLicense = new UserListGlobalLicense();
        $request = (new CreateUserListGlobalLicenseRequest())
            ->setParent($formattedParent)
            ->setUserListGlobalLicense($userListGlobalLicense);
        $response = $gapicClient->createUserListGlobalLicense($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.UserListGlobalLicenseService/CreateUserListGlobalLicense', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getUserListGlobalLicense();
        $this->assertProtobufEquals($userListGlobalLicense, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createUserListGlobalLicenseExceptionTest()
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
        $userListGlobalLicense = new UserListGlobalLicense();
        $request = (new CreateUserListGlobalLicenseRequest())
            ->setParent($formattedParent)
            ->setUserListGlobalLicense($userListGlobalLicense);
        try {
            $gapicClient->createUserListGlobalLicense($request);
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
    public function getUserListGlobalLicenseTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $userListId = 1707617256;
        $userListDisplayName = 'userListDisplayName874645109';
        $expectedResponse = new UserListGlobalLicense();
        $expectedResponse->setName($name2);
        $expectedResponse->setUserListId($userListId);
        $expectedResponse->setUserListDisplayName($userListDisplayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->userListGlobalLicenseName('[ACCOUNT_TYPE]', '[ACCOUNT]', '[USER_LIST_GLOBAL_LICENSE]');
        $request = (new GetUserListGlobalLicenseRequest())
            ->setName($formattedName);
        $response = $gapicClient->getUserListGlobalLicense($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.UserListGlobalLicenseService/GetUserListGlobalLicense', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getUserListGlobalLicenseExceptionTest()
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
        $formattedName = $gapicClient->userListGlobalLicenseName('[ACCOUNT_TYPE]', '[ACCOUNT]', '[USER_LIST_GLOBAL_LICENSE]');
        $request = (new GetUserListGlobalLicenseRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getUserListGlobalLicense($request);
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
    public function listUserListGlobalLicenseCustomerInfosTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $userListGlobalLicenseCustomerInfosElement = new UserListGlobalLicenseCustomerInfo();
        $userListGlobalLicenseCustomerInfos = [
            $userListGlobalLicenseCustomerInfosElement,
        ];
        $expectedResponse = new ListUserListGlobalLicenseCustomerInfosResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setUserListGlobalLicenseCustomerInfos($userListGlobalLicenseCustomerInfos);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->userListGlobalLicenseName('[ACCOUNT_TYPE]', '[ACCOUNT]', '[USER_LIST_GLOBAL_LICENSE]');
        $request = (new ListUserListGlobalLicenseCustomerInfosRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listUserListGlobalLicenseCustomerInfos($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getUserListGlobalLicenseCustomerInfos()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.UserListGlobalLicenseService/ListUserListGlobalLicenseCustomerInfos', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listUserListGlobalLicenseCustomerInfosExceptionTest()
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
        $formattedParent = $gapicClient->userListGlobalLicenseName('[ACCOUNT_TYPE]', '[ACCOUNT]', '[USER_LIST_GLOBAL_LICENSE]');
        $request = (new ListUserListGlobalLicenseCustomerInfosRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listUserListGlobalLicenseCustomerInfos($request);
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
    public function listUserListGlobalLicensesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $userListGlobalLicensesElement = new UserListGlobalLicense();
        $userListGlobalLicenses = [
            $userListGlobalLicensesElement,
        ];
        $expectedResponse = new ListUserListGlobalLicensesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setUserListGlobalLicenses($userListGlobalLicenses);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT_TYPE]', '[ACCOUNT]');
        $request = (new ListUserListGlobalLicensesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listUserListGlobalLicenses($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getUserListGlobalLicenses()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.UserListGlobalLicenseService/ListUserListGlobalLicenses', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listUserListGlobalLicensesExceptionTest()
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
        $request = (new ListUserListGlobalLicensesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listUserListGlobalLicenses($request);
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
    public function updateUserListGlobalLicenseTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $userListId = 1707617256;
        $userListDisplayName = 'userListDisplayName874645109';
        $expectedResponse = new UserListGlobalLicense();
        $expectedResponse->setName($name);
        $expectedResponse->setUserListId($userListId);
        $expectedResponse->setUserListDisplayName($userListDisplayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $userListGlobalLicense = new UserListGlobalLicense();
        $request = (new UpdateUserListGlobalLicenseRequest())
            ->setUserListGlobalLicense($userListGlobalLicense);
        $response = $gapicClient->updateUserListGlobalLicense($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.UserListGlobalLicenseService/UpdateUserListGlobalLicense', $actualFuncCall);
        $actualValue = $actualRequestObject->getUserListGlobalLicense();
        $this->assertProtobufEquals($userListGlobalLicense, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateUserListGlobalLicenseExceptionTest()
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
        $userListGlobalLicense = new UserListGlobalLicense();
        $request = (new UpdateUserListGlobalLicenseRequest())
            ->setUserListGlobalLicense($userListGlobalLicense);
        try {
            $gapicClient->updateUserListGlobalLicense($request);
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
    public function createUserListGlobalLicenseAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $userListId = 1707617256;
        $userListDisplayName = 'userListDisplayName874645109';
        $expectedResponse = new UserListGlobalLicense();
        $expectedResponse->setName($name);
        $expectedResponse->setUserListId($userListId);
        $expectedResponse->setUserListDisplayName($userListDisplayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT_TYPE]', '[ACCOUNT]');
        $userListGlobalLicense = new UserListGlobalLicense();
        $request = (new CreateUserListGlobalLicenseRequest())
            ->setParent($formattedParent)
            ->setUserListGlobalLicense($userListGlobalLicense);
        $response = $gapicClient->createUserListGlobalLicenseAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.UserListGlobalLicenseService/CreateUserListGlobalLicense', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getUserListGlobalLicense();
        $this->assertProtobufEquals($userListGlobalLicense, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
