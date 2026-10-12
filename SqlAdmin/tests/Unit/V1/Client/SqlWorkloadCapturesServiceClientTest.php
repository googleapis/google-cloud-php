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

namespace Google\Cloud\Sql\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Sql\V1\Client\SqlWorkloadCapturesServiceClient;
use Google\Cloud\Sql\V1\Operation;
use Google\Cloud\Sql\V1\SqlWorkloadCapturesListRequest;
use Google\Cloud\Sql\V1\StartWorkloadReplayContext;
use Google\Cloud\Sql\V1\WorkloadCapturesListResponse;
use Google\Cloud\Sql\V1\WorkloadCapturesStartReplayRequest;
use Google\Cloud\Sql\V1\WorkloadCapturesStartRequest;
use Google\Cloud\Sql\V1\WorkloadCapturesStopReplayRequest;
use Google\Cloud\Sql\V1\WorkloadCapturesStopRequest;
use Google\Rpc\Code;
use stdClass;

/**
 * @group sql
 *
 * @group gapic
 */
class SqlWorkloadCapturesServiceClientTest extends GeneratedTest
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

    /** @return SqlWorkloadCapturesServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new SqlWorkloadCapturesServiceClient($options);
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
        $expectedResponse = new WorkloadCapturesListResponse();
        $expectedResponse->setKind($kind);
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $instance = 'instance555127957';
        $request = (new SqlWorkloadCapturesListRequest())->setProject($project)->setInstance($instance);
        $response = $gapicClient->list($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1.SqlWorkloadCapturesService/List', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
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
        $project = 'project-309310695';
        $instance = 'instance555127957';
        $request = (new SqlWorkloadCapturesListRequest())->setProject($project)->setInstance($instance);
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
    public function startTest()
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
        // Mock request
        $project = 'project-309310695';
        $instance = 'instance555127957';
        $request = (new WorkloadCapturesStartRequest())->setProject($project)->setInstance($instance);
        $response = $gapicClient->start($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1.SqlWorkloadCapturesService/Start', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function startExceptionTest()
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
        $project = 'project-309310695';
        $instance = 'instance555127957';
        $request = (new WorkloadCapturesStartRequest())->setProject($project)->setInstance($instance);
        try {
            $gapicClient->start($request);
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
    public function startReplayTest()
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
        // Mock request
        $project = 'project-309310695';
        $instance = 'instance555127957';
        $startWorkloadReplayContext = new StartWorkloadReplayContext();
        $startWorkloadReplayContextReplayInstance = 'startWorkloadReplayContextReplayInstance-1860219445';
        $startWorkloadReplayContext->setReplayInstance($startWorkloadReplayContextReplayInstance);
        $workloadId = 'workloadId-1479602461';
        $request = (new WorkloadCapturesStartReplayRequest())
            ->setProject($project)
            ->setInstance($instance)
            ->setStartWorkloadReplayContext($startWorkloadReplayContext)
            ->setWorkloadId($workloadId);
        $response = $gapicClient->startReplay($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1.SqlWorkloadCapturesService/StartReplay', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualRequestObject->getStartWorkloadReplayContext();
        $this->assertProtobufEquals($startWorkloadReplayContext, $actualValue);
        $actualValue = $actualRequestObject->getWorkloadId();
        $this->assertProtobufEquals($workloadId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function startReplayExceptionTest()
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
        $project = 'project-309310695';
        $instance = 'instance555127957';
        $startWorkloadReplayContext = new StartWorkloadReplayContext();
        $startWorkloadReplayContextReplayInstance = 'startWorkloadReplayContextReplayInstance-1860219445';
        $startWorkloadReplayContext->setReplayInstance($startWorkloadReplayContextReplayInstance);
        $workloadId = 'workloadId-1479602461';
        $request = (new WorkloadCapturesStartReplayRequest())
            ->setProject($project)
            ->setInstance($instance)
            ->setStartWorkloadReplayContext($startWorkloadReplayContext)
            ->setWorkloadId($workloadId);
        try {
            $gapicClient->startReplay($request);
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
    public function stopTest()
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
        // Mock request
        $project = 'project-309310695';
        $instance = 'instance555127957';
        $request = (new WorkloadCapturesStopRequest())->setProject($project)->setInstance($instance);
        $response = $gapicClient->stop($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1.SqlWorkloadCapturesService/Stop', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function stopExceptionTest()
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
        $project = 'project-309310695';
        $instance = 'instance555127957';
        $request = (new WorkloadCapturesStopRequest())->setProject($project)->setInstance($instance);
        try {
            $gapicClient->stop($request);
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
    public function stopReplayTest()
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
        // Mock request
        $project = 'project-309310695';
        $instance = 'instance555127957';
        $request = (new WorkloadCapturesStopReplayRequest())->setProject($project)->setInstance($instance);
        $response = $gapicClient->stopReplay($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1.SqlWorkloadCapturesService/StopReplay', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function stopReplayExceptionTest()
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
        $project = 'project-309310695';
        $instance = 'instance555127957';
        $request = (new WorkloadCapturesStopReplayRequest())->setProject($project)->setInstance($instance);
        try {
            $gapicClient->stopReplay($request);
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
    public function listAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $expectedResponse = new WorkloadCapturesListResponse();
        $expectedResponse->setKind($kind);
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $instance = 'instance555127957';
        $request = (new SqlWorkloadCapturesListRequest())->setProject($project)->setInstance($instance);
        $response = $gapicClient->listAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1.SqlWorkloadCapturesService/List', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
