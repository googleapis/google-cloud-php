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

namespace Google\Cloud\DiscoveryEngine\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\DiscoveryEngine\V1\Client\UserStoreServiceClient;
use Google\Cloud\DiscoveryEngine\V1\GetUserStoreRequest;
use Google\Cloud\DiscoveryEngine\V1\UpdateUserStoreRequest;
use Google\Cloud\DiscoveryEngine\V1\UserStore;
use Google\Rpc\Code;
use stdClass;

/**
 * @group discoveryengine
 *
 * @group gapic
 */
class UserStoreServiceClientTest extends GeneratedTest
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

    /** @return UserStoreServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new UserStoreServiceClient($options);
    }

    /** @test */
    public function getUserStoreTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $defaultLicenseConfig = 'defaultLicenseConfig-578154818';
        $enableLicenseAutoRegister = false;
        $enableExpiredLicenseAutoUpdate = false;
        $expectedResponse = new UserStore();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDefaultLicenseConfig($defaultLicenseConfig);
        $expectedResponse->setEnableLicenseAutoRegister($enableLicenseAutoRegister);
        $expectedResponse->setEnableExpiredLicenseAutoUpdate($enableExpiredLicenseAutoUpdate);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->userStoreName('[PROJECT]', '[LOCATION]', '[USER_STORE]');
        $request = (new GetUserStoreRequest())->setName($formattedName);
        $response = $gapicClient->getUserStore($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.UserStoreService/GetUserStore', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getUserStoreExceptionTest()
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
        $formattedName = $gapicClient->userStoreName('[PROJECT]', '[LOCATION]', '[USER_STORE]');
        $request = (new GetUserStoreRequest())->setName($formattedName);
        try {
            $gapicClient->getUserStore($request);
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
    public function updateUserStoreTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $defaultLicenseConfig = 'defaultLicenseConfig-578154818';
        $enableLicenseAutoRegister = false;
        $enableExpiredLicenseAutoUpdate = false;
        $expectedResponse = new UserStore();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDefaultLicenseConfig($defaultLicenseConfig);
        $expectedResponse->setEnableLicenseAutoRegister($enableLicenseAutoRegister);
        $expectedResponse->setEnableExpiredLicenseAutoUpdate($enableExpiredLicenseAutoUpdate);
        $transport->addResponse($expectedResponse);
        // Mock request
        $userStore = new UserStore();
        $request = (new UpdateUserStoreRequest())->setUserStore($userStore);
        $response = $gapicClient->updateUserStore($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.UserStoreService/UpdateUserStore', $actualFuncCall);
        $actualValue = $actualRequestObject->getUserStore();
        $this->assertProtobufEquals($userStore, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateUserStoreExceptionTest()
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
        $userStore = new UserStore();
        $request = (new UpdateUserStoreRequest())->setUserStore($userStore);
        try {
            $gapicClient->updateUserStore($request);
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
    public function getUserStoreAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $defaultLicenseConfig = 'defaultLicenseConfig-578154818';
        $enableLicenseAutoRegister = false;
        $enableExpiredLicenseAutoUpdate = false;
        $expectedResponse = new UserStore();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDefaultLicenseConfig($defaultLicenseConfig);
        $expectedResponse->setEnableLicenseAutoRegister($enableLicenseAutoRegister);
        $expectedResponse->setEnableExpiredLicenseAutoUpdate($enableExpiredLicenseAutoUpdate);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->userStoreName('[PROJECT]', '[LOCATION]', '[USER_STORE]');
        $request = (new GetUserStoreRequest())->setName($formattedName);
        $response = $gapicClient->getUserStoreAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.UserStoreService/GetUserStore', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
