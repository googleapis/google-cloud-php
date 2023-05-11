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

namespace Google\Cloud\Run\Tests\Unit\V2\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Run\V2\Client\TasksClient;
use Google\Cloud\Run\V2\GetTaskRequest;
use Google\Cloud\Run\V2\ListTasksRequest;
use Google\Cloud\Run\V2\ListTasksResponse;
use Google\Cloud\Run\V2\Task;
use Google\Rpc\Code;
use stdClass;

/**
 * @group run
 *
 * @group gapic
 */
class TasksClientTest extends GeneratedTest
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

    /** @return TasksClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new TasksClient($options);
    }

    /** @test */
    public function getTaskTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $uid = 'uid115792';
        $generation = 305703192;
        $job = 'job105405';
        $execution = 'execution-1090974952';
        $maxRetries = 1129288043;
        $serviceAccount = 'serviceAccount-1948028253';
        $reconciling = false;
        $observedGeneration = 900833007;
        $index = 100346066;
        $retried = 1098377527;
        $encryptionKey = 'encryptionKey-1122344029';
        $logUri = 'logUri342054385';
        $satisfiesPzs = false;
        $etag = 'etag3123477';
        $expectedResponse = new Task();
        $expectedResponse->setName($name2);
        $expectedResponse->setUid($uid);
        $expectedResponse->setGeneration($generation);
        $expectedResponse->setJob($job);
        $expectedResponse->setExecution($execution);
        $expectedResponse->setMaxRetries($maxRetries);
        $expectedResponse->setServiceAccount($serviceAccount);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setObservedGeneration($observedGeneration);
        $expectedResponse->setIndex($index);
        $expectedResponse->setRetried($retried);
        $expectedResponse->setEncryptionKey($encryptionKey);
        $expectedResponse->setLogUri($logUri);
        $expectedResponse->setSatisfiesPzs($satisfiesPzs);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->taskName('[PROJECT]', '[LOCATION]', '[JOB]', '[EXECUTION]', '[TASK]');
        $request = (new GetTaskRequest())
            ->setName($formattedName);
        $response = $gapicClient->getTask($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.run.v2.Tasks/GetTask', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTaskExceptionTest()
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
        $formattedName = $gapicClient->taskName('[PROJECT]', '[LOCATION]', '[JOB]', '[EXECUTION]', '[TASK]');
        $request = (new GetTaskRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getTask($request);
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
    public function listTasksTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $tasksElement = new Task();
        $tasks = [
            $tasksElement,
        ];
        $expectedResponse = new ListTasksResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTasks($tasks);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->executionName('[PROJECT]', '[LOCATION]', '[JOB]', '[EXECUTION]');
        $request = (new ListTasksRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listTasks($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTasks()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.run.v2.Tasks/ListTasks', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTasksExceptionTest()
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
        $formattedParent = $gapicClient->executionName('[PROJECT]', '[LOCATION]', '[JOB]', '[EXECUTION]');
        $request = (new ListTasksRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listTasks($request);
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
    public function getTaskAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $uid = 'uid115792';
        $generation = 305703192;
        $job = 'job105405';
        $execution = 'execution-1090974952';
        $maxRetries = 1129288043;
        $serviceAccount = 'serviceAccount-1948028253';
        $reconciling = false;
        $observedGeneration = 900833007;
        $index = 100346066;
        $retried = 1098377527;
        $encryptionKey = 'encryptionKey-1122344029';
        $logUri = 'logUri342054385';
        $satisfiesPzs = false;
        $etag = 'etag3123477';
        $expectedResponse = new Task();
        $expectedResponse->setName($name2);
        $expectedResponse->setUid($uid);
        $expectedResponse->setGeneration($generation);
        $expectedResponse->setJob($job);
        $expectedResponse->setExecution($execution);
        $expectedResponse->setMaxRetries($maxRetries);
        $expectedResponse->setServiceAccount($serviceAccount);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setObservedGeneration($observedGeneration);
        $expectedResponse->setIndex($index);
        $expectedResponse->setRetried($retried);
        $expectedResponse->setEncryptionKey($encryptionKey);
        $expectedResponse->setLogUri($logUri);
        $expectedResponse->setSatisfiesPzs($satisfiesPzs);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->taskName('[PROJECT]', '[LOCATION]', '[JOB]', '[EXECUTION]', '[TASK]');
        $request = (new GetTaskRequest())
            ->setName($formattedName);
        $response = $gapicClient->getTaskAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.run.v2.Tasks/GetTask', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
