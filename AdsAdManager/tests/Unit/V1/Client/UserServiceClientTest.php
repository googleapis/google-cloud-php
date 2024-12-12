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

namespace Google\Ads\AdManager\Tests\Unit\V1\Client;

use Google\Ads\AdManager\V1\Client\UserServiceClient;
use Google\Ads\AdManager\V1\GetUserRequest;
use Google\Ads\AdManager\V1\User;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Rpc\Code;
use stdClass;

/**
 * @group admanager
 *
 * @group gapic
 */
class UserServiceClientTest extends GeneratedTest
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

    /** @return UserServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new UserServiceClient($options);
    }

    /** @test */
    public function getUserTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $userId = 147132913;
        $displayName = 'displayName1615086568';
        $email = 'email96619420';
        $role = 'role3506294';
        $active = true;
        $externalId = 'externalId-1153075697';
        $serviceAccount = false;
        $ordersUiLocalTimeZone = 'ordersUiLocalTimeZone-1376832007';
        $expectedResponse = new User();
        $expectedResponse->setName($name2);
        $expectedResponse->setUserId($userId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEmail($email);
        $expectedResponse->setRole($role);
        $expectedResponse->setActive($active);
        $expectedResponse->setExternalId($externalId);
        $expectedResponse->setServiceAccount($serviceAccount);
        $expectedResponse->setOrdersUiLocalTimeZone($ordersUiLocalTimeZone);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->userName('[NETWORK_CODE]', '[USER]');
        $request = (new GetUserRequest())->setName($formattedName);
        $response = $gapicClient->getUser($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.UserService/GetUser', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getUserExceptionTest()
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
        $formattedName = $gapicClient->userName('[NETWORK_CODE]', '[USER]');
        $request = (new GetUserRequest())->setName($formattedName);
        try {
            $gapicClient->getUser($request);
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
    public function getUserAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $userId = 147132913;
        $displayName = 'displayName1615086568';
        $email = 'email96619420';
        $role = 'role3506294';
        $active = true;
        $externalId = 'externalId-1153075697';
        $serviceAccount = false;
        $ordersUiLocalTimeZone = 'ordersUiLocalTimeZone-1376832007';
        $expectedResponse = new User();
        $expectedResponse->setName($name2);
        $expectedResponse->setUserId($userId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEmail($email);
        $expectedResponse->setRole($role);
        $expectedResponse->setActive($active);
        $expectedResponse->setExternalId($externalId);
        $expectedResponse->setServiceAccount($serviceAccount);
        $expectedResponse->setOrdersUiLocalTimeZone($ordersUiLocalTimeZone);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->userName('[NETWORK_CODE]', '[USER]');
        $request = (new GetUserRequest())->setName($formattedName);
        $response = $gapicClient->getUserAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.UserService/GetUser', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
