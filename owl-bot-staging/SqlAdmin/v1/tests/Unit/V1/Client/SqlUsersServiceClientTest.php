<?php
/*
 * Copyright 2023 Google LLC
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

namespace Google\Cloud\Sql\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Sql\V1\Client\SqlUsersServiceClient;
use Google\Cloud\Sql\V1\Operation;
use Google\Cloud\Sql\V1\SqlUsersDeleteRequest;
use Google\Cloud\Sql\V1\SqlUsersGetRequest;
use Google\Cloud\Sql\V1\SqlUsersInsertRequest;
use Google\Cloud\Sql\V1\SqlUsersListRequest;
use Google\Cloud\Sql\V1\SqlUsersUpdateRequest;
use Google\Cloud\Sql\V1\User;
use Google\Cloud\Sql\V1\UsersListResponse;
use Google\Rpc\Code;
use stdClass;

/**
 * @group sql
 *
 * @group gapic
 */
class SqlUsersServiceClientTest extends GeneratedTest
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

    /** @return SqlUsersServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new SqlUsersServiceClient($options);
    }

    /** @test */
    public function deleteTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name2 = 'name2-1052831874';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name2);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $request = new SqlUsersDeleteRequest();
        $response = $gapicClient->delete($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1.SqlUsersService/Delete', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteExceptionTest()
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
        $request = new SqlUsersDeleteRequest();
        try {
            $gapicClient->delete($request);
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
    public function getTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $password = 'password1216985755';
        $etag = 'etag3123477';
        $name2 = 'name2-1052831874';
        $host2 = 'host2-1211484325';
        $instance2 = 'instance2902024968';
        $project2 = 'project2-894831476';
        $expectedResponse = new User();
        $expectedResponse->setKind($kind);
        $expectedResponse->setPassword($password);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setName($name2);
        $expectedResponse->setHost($host2);
        $expectedResponse->setInstance($instance2);
        $expectedResponse->setProject($project2);
        $transport->addResponse($expectedResponse);
        $request = new SqlUsersGetRequest();
        $response = $gapicClient->get($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1.SqlUsersService/Get', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getExceptionTest()
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
        $request = new SqlUsersGetRequest();
        try {
            $gapicClient->get($request);
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
    public function insertTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $request = new SqlUsersInsertRequest();
        $response = $gapicClient->insert($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1.SqlUsersService/Insert', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function insertExceptionTest()
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
        $request = new SqlUsersInsertRequest();
        try {
            $gapicClient->insert($request);
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
    public function listTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $nextPageToken = 'nextPageToken-1530815211';
        $expectedResponse = new UsersListResponse();
        $expectedResponse->setKind($kind);
        $expectedResponse->setNextPageToken($nextPageToken);
        $transport->addResponse($expectedResponse);
        $request = new SqlUsersListRequest();
        $response = $gapicClient->list($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1.SqlUsersService/List', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listExceptionTest()
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
        $request = new SqlUsersListRequest();
        try {
            $gapicClient->list($request);
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
    public function updateTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name2 = 'name2-1052831874';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name2);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $request = new SqlUsersUpdateRequest();
        $response = $gapicClient->update($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1.SqlUsersService/Update', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateExceptionTest()
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
        $request = new SqlUsersUpdateRequest();
        try {
            $gapicClient->update($request);
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
    public function deleteAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name2 = 'name2-1052831874';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name2);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $request = new SqlUsersDeleteRequest();
        $response = $gapicClient->deleteAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1.SqlUsersService/Delete', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }
}
