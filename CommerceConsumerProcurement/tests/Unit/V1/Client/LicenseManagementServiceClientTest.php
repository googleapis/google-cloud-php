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

namespace Google\Cloud\Commerce\Consumer\Procurement\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Commerce\Consumer\Procurement\V1\AssignRequest;
use Google\Cloud\Commerce\Consumer\Procurement\V1\AssignResponse;
use Google\Cloud\Commerce\Consumer\Procurement\V1\AssignmentProtocol;
use Google\Cloud\Commerce\Consumer\Procurement\V1\Client\LicenseManagementServiceClient;
use Google\Cloud\Commerce\Consumer\Procurement\V1\EnumerateLicensedUsersRequest;
use Google\Cloud\Commerce\Consumer\Procurement\V1\EnumerateLicensedUsersResponse;
use Google\Cloud\Commerce\Consumer\Procurement\V1\GetLicensePoolRequest;
use Google\Cloud\Commerce\Consumer\Procurement\V1\LicensePool;
use Google\Cloud\Commerce\Consumer\Procurement\V1\LicensedUser;
use Google\Cloud\Commerce\Consumer\Procurement\V1\UnassignRequest;
use Google\Cloud\Commerce\Consumer\Procurement\V1\UnassignResponse;
use Google\Cloud\Commerce\Consumer\Procurement\V1\UpdateLicensePoolRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Code;
use stdClass;

/**
 * @group procurement
 *
 * @group gapic
 */
class LicenseManagementServiceClientTest extends GeneratedTest
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

    /** @return LicenseManagementServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new LicenseManagementServiceClient($options);
    }

    /** @test */
    public function assignTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new AssignResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $usernames = [];
        $request = (new AssignRequest())->setParent($parent)->setUsernames($usernames);
        $response = $gapicClient->assign($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerce.consumer.procurement.v1.LicenseManagementService/Assign',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getUsernames();
        $this->assertProtobufEquals($usernames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function assignExceptionTest()
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
        $parent = 'parent-995424086';
        $usernames = [];
        $request = (new AssignRequest())->setParent($parent)->setUsernames($usernames);
        try {
            $gapicClient->assign($request);
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
    public function enumerateLicensedUsersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $licensedUsersElement = new LicensedUser();
        $licensedUsers = [$licensedUsersElement];
        $expectedResponse = new EnumerateLicensedUsersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setLicensedUsers($licensedUsers);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $request = (new EnumerateLicensedUsersRequest())->setParent($parent);
        $response = $gapicClient->enumerateLicensedUsers($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getLicensedUsers()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerce.consumer.procurement.v1.LicenseManagementService/EnumerateLicensedUsers',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function enumerateLicensedUsersExceptionTest()
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
        $parent = 'parent-995424086';
        $request = (new EnumerateLicensedUsersRequest())->setParent($parent);
        try {
            $gapicClient->enumerateLicensedUsers($request);
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
    public function getLicensePoolTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $availableLicenseCount = 387091611;
        $totalLicenseCount = 834147882;
        $expectedResponse = new LicensePool();
        $expectedResponse->setName($name2);
        $expectedResponse->setAvailableLicenseCount($availableLicenseCount);
        $expectedResponse->setTotalLicenseCount($totalLicenseCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $request = (new GetLicensePoolRequest())->setName($name);
        $response = $gapicClient->getLicensePool($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerce.consumer.procurement.v1.LicenseManagementService/GetLicensePool',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getLicensePoolExceptionTest()
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
        $name = 'name3373707';
        $request = (new GetLicensePoolRequest())->setName($name);
        try {
            $gapicClient->getLicensePool($request);
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
    public function unassignTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new UnassignResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $usernames = [];
        $request = (new UnassignRequest())->setParent($parent)->setUsernames($usernames);
        $response = $gapicClient->unassign($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerce.consumer.procurement.v1.LicenseManagementService/Unassign',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getUsernames();
        $this->assertProtobufEquals($usernames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function unassignExceptionTest()
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
        $parent = 'parent-995424086';
        $usernames = [];
        $request = (new UnassignRequest())->setParent($parent)->setUsernames($usernames);
        try {
            $gapicClient->unassign($request);
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
    public function updateLicensePoolTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $availableLicenseCount = 387091611;
        $totalLicenseCount = 834147882;
        $expectedResponse = new LicensePool();
        $expectedResponse->setName($name);
        $expectedResponse->setAvailableLicenseCount($availableLicenseCount);
        $expectedResponse->setTotalLicenseCount($totalLicenseCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $licensePool = new LicensePool();
        $licensePoolLicenseAssignmentProtocol = new AssignmentProtocol();
        $licensePool->setLicenseAssignmentProtocol($licensePoolLicenseAssignmentProtocol);
        $updateMask = new FieldMask();
        $request = (new UpdateLicensePoolRequest())->setLicensePool($licensePool)->setUpdateMask($updateMask);
        $response = $gapicClient->updateLicensePool($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerce.consumer.procurement.v1.LicenseManagementService/UpdateLicensePool',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getLicensePool();
        $this->assertProtobufEquals($licensePool, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateLicensePoolExceptionTest()
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
        $licensePool = new LicensePool();
        $licensePoolLicenseAssignmentProtocol = new AssignmentProtocol();
        $licensePool->setLicenseAssignmentProtocol($licensePoolLicenseAssignmentProtocol);
        $updateMask = new FieldMask();
        $request = (new UpdateLicensePoolRequest())->setLicensePool($licensePool)->setUpdateMask($updateMask);
        try {
            $gapicClient->updateLicensePool($request);
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
    public function assignAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new AssignResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $usernames = [];
        $request = (new AssignRequest())->setParent($parent)->setUsernames($usernames);
        $response = $gapicClient->assignAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerce.consumer.procurement.v1.LicenseManagementService/Assign',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getUsernames();
        $this->assertProtobufEquals($usernames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
