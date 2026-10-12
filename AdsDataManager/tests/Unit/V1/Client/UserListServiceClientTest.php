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

use Google\Ads\DataManager\V1\Client\UserListServiceClient;
use Google\Ads\DataManager\V1\CreateUserListRequest;
use Google\Ads\DataManager\V1\DeleteUserListRequest;
use Google\Ads\DataManager\V1\GetUserListRequest;
use Google\Ads\DataManager\V1\ListUserListsRequest;
use Google\Ads\DataManager\V1\ListUserListsResponse;
use Google\Ads\DataManager\V1\UpdateUserListRequest;
use Google\Ads\DataManager\V1\UserList;
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
class UserListServiceClientTest extends GeneratedTest
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

    /** @return UserListServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new UserListServiceClient($options);
    }

    /** @test */
    public function createUserListTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $id = 3355;
        $readOnly = false;
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $integrationCode = 'integrationCode79787384';
        $expectedResponse = new UserList();
        $expectedResponse->setName($name);
        $expectedResponse->setId($id);
        $expectedResponse->setReadOnly($readOnly);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setIntegrationCode($integrationCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT_TYPE]', '[ACCOUNT]');
        $userList = new UserList();
        $userListDisplayName = 'userListDisplayName1315716004';
        $userList->setDisplayName($userListDisplayName);
        $request = (new CreateUserListRequest())->setParent($formattedParent)->setUserList($userList);
        $response = $gapicClient->createUserList($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.UserListService/CreateUserList', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getUserList();
        $this->assertProtobufEquals($userList, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createUserListExceptionTest()
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
        $userList = new UserList();
        $userListDisplayName = 'userListDisplayName1315716004';
        $userList->setDisplayName($userListDisplayName);
        $request = (new CreateUserListRequest())->setParent($formattedParent)->setUserList($userList);
        try {
            $gapicClient->createUserList($request);
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
    public function deleteUserListTest()
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
        $formattedName = $gapicClient->userListName('[ACCOUNT_TYPE]', '[ACCOUNT]', '[USER_LIST]');
        $request = (new DeleteUserListRequest())->setName($formattedName);
        $gapicClient->deleteUserList($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.UserListService/DeleteUserList', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteUserListExceptionTest()
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
        $formattedName = $gapicClient->userListName('[ACCOUNT_TYPE]', '[ACCOUNT]', '[USER_LIST]');
        $request = (new DeleteUserListRequest())->setName($formattedName);
        try {
            $gapicClient->deleteUserList($request);
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
    public function getUserListTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $id = 3355;
        $readOnly = false;
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $integrationCode = 'integrationCode79787384';
        $expectedResponse = new UserList();
        $expectedResponse->setName($name2);
        $expectedResponse->setId($id);
        $expectedResponse->setReadOnly($readOnly);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setIntegrationCode($integrationCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->userListName('[ACCOUNT_TYPE]', '[ACCOUNT]', '[USER_LIST]');
        $request = (new GetUserListRequest())->setName($formattedName);
        $response = $gapicClient->getUserList($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.UserListService/GetUserList', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getUserListExceptionTest()
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
        $formattedName = $gapicClient->userListName('[ACCOUNT_TYPE]', '[ACCOUNT]', '[USER_LIST]');
        $request = (new GetUserListRequest())->setName($formattedName);
        try {
            $gapicClient->getUserList($request);
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
    public function listUserListsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $userListsElement = new UserList();
        $userLists = [$userListsElement];
        $expectedResponse = new ListUserListsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setUserLists($userLists);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT_TYPE]', '[ACCOUNT]');
        $request = (new ListUserListsRequest())->setParent($formattedParent);
        $response = $gapicClient->listUserLists($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getUserLists()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.UserListService/ListUserLists', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listUserListsExceptionTest()
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
        $request = (new ListUserListsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listUserLists($request);
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
    public function updateUserListTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $id = 3355;
        $readOnly = false;
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $integrationCode = 'integrationCode79787384';
        $expectedResponse = new UserList();
        $expectedResponse->setName($name);
        $expectedResponse->setId($id);
        $expectedResponse->setReadOnly($readOnly);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setIntegrationCode($integrationCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $userList = new UserList();
        $userListDisplayName = 'userListDisplayName1315716004';
        $userList->setDisplayName($userListDisplayName);
        $request = (new UpdateUserListRequest())->setUserList($userList);
        $response = $gapicClient->updateUserList($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.UserListService/UpdateUserList', $actualFuncCall);
        $actualValue = $actualRequestObject->getUserList();
        $this->assertProtobufEquals($userList, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateUserListExceptionTest()
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
        $userList = new UserList();
        $userListDisplayName = 'userListDisplayName1315716004';
        $userList->setDisplayName($userListDisplayName);
        $request = (new UpdateUserListRequest())->setUserList($userList);
        try {
            $gapicClient->updateUserList($request);
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
    public function createUserListAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $id = 3355;
        $readOnly = false;
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $integrationCode = 'integrationCode79787384';
        $expectedResponse = new UserList();
        $expectedResponse->setName($name);
        $expectedResponse->setId($id);
        $expectedResponse->setReadOnly($readOnly);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setIntegrationCode($integrationCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT_TYPE]', '[ACCOUNT]');
        $userList = new UserList();
        $userListDisplayName = 'userListDisplayName1315716004';
        $userList->setDisplayName($userListDisplayName);
        $request = (new CreateUserListRequest())->setParent($formattedParent)->setUserList($userList);
        $response = $gapicClient->createUserListAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.UserListService/CreateUserList', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getUserList();
        $this->assertProtobufEquals($userList, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
