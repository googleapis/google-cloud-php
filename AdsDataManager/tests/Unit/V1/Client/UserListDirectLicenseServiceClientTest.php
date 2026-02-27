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

use Google\Ads\DataManager\V1\Client\UserListDirectLicenseServiceClient;
use Google\Ads\DataManager\V1\CreateUserListDirectLicenseRequest;
use Google\Ads\DataManager\V1\GetUserListDirectLicenseRequest;
use Google\Ads\DataManager\V1\ListUserListDirectLicensesRequest;
use Google\Ads\DataManager\V1\ListUserListDirectLicensesResponse;
use Google\Ads\DataManager\V1\UpdateUserListDirectLicenseRequest;
use Google\Ads\DataManager\V1\UserListDirectLicense;
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
class UserListDirectLicenseServiceClientTest extends GeneratedTest
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

    /** @return UserListDirectLicenseServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new UserListDirectLicenseServiceClient($options);
    }

    /** @test */
    public function createUserListDirectLicenseTest()
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
        $clientAccountId = 1552007521;
        $clientAccountDisplayName = 'clientAccountDisplayName1404950702';
        $expectedResponse = new UserListDirectLicense();
        $expectedResponse->setName($name);
        $expectedResponse->setUserListId($userListId);
        $expectedResponse->setUserListDisplayName($userListDisplayName);
        $expectedResponse->setClientAccountId($clientAccountId);
        $expectedResponse->setClientAccountDisplayName($clientAccountDisplayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT_TYPE]', '[ACCOUNT]');
        $userListDirectLicense = new UserListDirectLicense();
        $request = (new CreateUserListDirectLicenseRequest())
            ->setParent($formattedParent)
            ->setUserListDirectLicense($userListDirectLicense);
        $response = $gapicClient->createUserListDirectLicense($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.datamanager.v1.UserListDirectLicenseService/CreateUserListDirectLicense',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getUserListDirectLicense();
        $this->assertProtobufEquals($userListDirectLicense, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createUserListDirectLicenseExceptionTest()
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
        $formattedParent = $gapicClient->accountName('[ACCOUNT_TYPE]', '[ACCOUNT]');
        $userListDirectLicense = new UserListDirectLicense();
        $request = (new CreateUserListDirectLicenseRequest())
            ->setParent($formattedParent)
            ->setUserListDirectLicense($userListDirectLicense);
        try {
            $gapicClient->createUserListDirectLicense($request);
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
    public function getUserListDirectLicenseTest()
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
        $clientAccountId = 1552007521;
        $clientAccountDisplayName = 'clientAccountDisplayName1404950702';
        $expectedResponse = new UserListDirectLicense();
        $expectedResponse->setName($name2);
        $expectedResponse->setUserListId($userListId);
        $expectedResponse->setUserListDisplayName($userListDisplayName);
        $expectedResponse->setClientAccountId($clientAccountId);
        $expectedResponse->setClientAccountDisplayName($clientAccountDisplayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->userListDirectLicenseName(
            '[ACCOUNT_TYPE]',
            '[ACCOUNT]',
            '[USER_LIST_DIRECT_LICENSE]'
        );
        $request = (new GetUserListDirectLicenseRequest())->setName($formattedName);
        $response = $gapicClient->getUserListDirectLicense($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.datamanager.v1.UserListDirectLicenseService/GetUserListDirectLicense',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getUserListDirectLicenseExceptionTest()
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
        $formattedName = $gapicClient->userListDirectLicenseName(
            '[ACCOUNT_TYPE]',
            '[ACCOUNT]',
            '[USER_LIST_DIRECT_LICENSE]'
        );
        $request = (new GetUserListDirectLicenseRequest())->setName($formattedName);
        try {
            $gapicClient->getUserListDirectLicense($request);
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
    public function listUserListDirectLicensesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $userListDirectLicensesElement = new UserListDirectLicense();
        $userListDirectLicenses = [$userListDirectLicensesElement];
        $expectedResponse = new ListUserListDirectLicensesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setUserListDirectLicenses($userListDirectLicenses);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT_TYPE]', '[ACCOUNT]');
        $request = (new ListUserListDirectLicensesRequest())->setParent($formattedParent);
        $response = $gapicClient->listUserListDirectLicenses($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getUserListDirectLicenses()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.datamanager.v1.UserListDirectLicenseService/ListUserListDirectLicenses',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listUserListDirectLicensesExceptionTest()
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
        $formattedParent = $gapicClient->accountName('[ACCOUNT_TYPE]', '[ACCOUNT]');
        $request = (new ListUserListDirectLicensesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listUserListDirectLicenses($request);
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
    public function updateUserListDirectLicenseTest()
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
        $clientAccountId = 1552007521;
        $clientAccountDisplayName = 'clientAccountDisplayName1404950702';
        $expectedResponse = new UserListDirectLicense();
        $expectedResponse->setName($name);
        $expectedResponse->setUserListId($userListId);
        $expectedResponse->setUserListDisplayName($userListDisplayName);
        $expectedResponse->setClientAccountId($clientAccountId);
        $expectedResponse->setClientAccountDisplayName($clientAccountDisplayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $userListDirectLicense = new UserListDirectLicense();
        $request = (new UpdateUserListDirectLicenseRequest())->setUserListDirectLicense($userListDirectLicense);
        $response = $gapicClient->updateUserListDirectLicense($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.datamanager.v1.UserListDirectLicenseService/UpdateUserListDirectLicense',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getUserListDirectLicense();
        $this->assertProtobufEquals($userListDirectLicense, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateUserListDirectLicenseExceptionTest()
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
        $userListDirectLicense = new UserListDirectLicense();
        $request = (new UpdateUserListDirectLicenseRequest())->setUserListDirectLicense($userListDirectLicense);
        try {
            $gapicClient->updateUserListDirectLicense($request);
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
    public function createUserListDirectLicenseAsyncTest()
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
        $clientAccountId = 1552007521;
        $clientAccountDisplayName = 'clientAccountDisplayName1404950702';
        $expectedResponse = new UserListDirectLicense();
        $expectedResponse->setName($name);
        $expectedResponse->setUserListId($userListId);
        $expectedResponse->setUserListDisplayName($userListDisplayName);
        $expectedResponse->setClientAccountId($clientAccountId);
        $expectedResponse->setClientAccountDisplayName($clientAccountDisplayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT_TYPE]', '[ACCOUNT]');
        $userListDirectLicense = new UserListDirectLicense();
        $request = (new CreateUserListDirectLicenseRequest())
            ->setParent($formattedParent)
            ->setUserListDirectLicense($userListDirectLicense);
        $response = $gapicClient->createUserListDirectLicenseAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.datamanager.v1.UserListDirectLicenseService/CreateUserListDirectLicense',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getUserListDirectLicense();
        $this->assertProtobufEquals($userListDirectLicense, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
