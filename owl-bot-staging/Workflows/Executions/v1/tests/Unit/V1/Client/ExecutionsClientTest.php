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

namespace Google\Cloud\Workflows\Executions\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Workflows\Executions\V1\CancelExecutionRequest;
use Google\Cloud\Workflows\Executions\V1\Client\ExecutionsClient;
use Google\Cloud\Workflows\Executions\V1\CreateExecutionRequest;
use Google\Cloud\Workflows\Executions\V1\Execution;
use Google\Cloud\Workflows\Executions\V1\GetExecutionRequest;
use Google\Cloud\Workflows\Executions\V1\ListExecutionsRequest;
use Google\Cloud\Workflows\Executions\V1\ListExecutionsResponse;
use Google\Rpc\Code;
use stdClass;

/**
 * @group executions
 *
 * @group gapic
 */
class ExecutionsClientTest extends GeneratedTest
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

    /** @return ExecutionsClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new ExecutionsClient($options);
    }

    /** @test */
    public function cancelExecutionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $argument = 'argument-1589682499';
        $result = 'result-934426595';
        $workflowRevisionId = 'workflowRevisionId-1453295745';
        $expectedResponse = new Execution();
        $expectedResponse->setName($name2);
        $expectedResponse->setArgument($argument);
        $expectedResponse->setResult($result);
        $expectedResponse->setWorkflowRevisionId($workflowRevisionId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->executionName('[PROJECT]', '[LOCATION]', '[WORKFLOW]', '[EXECUTION]');
        $request = (new CancelExecutionRequest())
            ->setName($formattedName);
        $response = $gapicClient->cancelExecution($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.workflows.executions.v1.Executions/CancelExecution', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function cancelExecutionExceptionTest()
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
        $formattedName = $gapicClient->executionName('[PROJECT]', '[LOCATION]', '[WORKFLOW]', '[EXECUTION]');
        $request = (new CancelExecutionRequest())
            ->setName($formattedName);
        try {
            $gapicClient->cancelExecution($request);
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
    public function createExecutionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $argument = 'argument-1589682499';
        $result = 'result-934426595';
        $workflowRevisionId = 'workflowRevisionId-1453295745';
        $expectedResponse = new Execution();
        $expectedResponse->setName($name);
        $expectedResponse->setArgument($argument);
        $expectedResponse->setResult($result);
        $expectedResponse->setWorkflowRevisionId($workflowRevisionId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->workflowName('[PROJECT]', '[LOCATION]', '[WORKFLOW]');
        $execution = new Execution();
        $request = (new CreateExecutionRequest())
            ->setParent($formattedParent)
            ->setExecution($execution);
        $response = $gapicClient->createExecution($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.workflows.executions.v1.Executions/CreateExecution', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getExecution();
        $this->assertProtobufEquals($execution, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createExecutionExceptionTest()
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
        $formattedParent = $gapicClient->workflowName('[PROJECT]', '[LOCATION]', '[WORKFLOW]');
        $execution = new Execution();
        $request = (new CreateExecutionRequest())
            ->setParent($formattedParent)
            ->setExecution($execution);
        try {
            $gapicClient->createExecution($request);
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
    public function getExecutionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $argument = 'argument-1589682499';
        $result = 'result-934426595';
        $workflowRevisionId = 'workflowRevisionId-1453295745';
        $expectedResponse = new Execution();
        $expectedResponse->setName($name2);
        $expectedResponse->setArgument($argument);
        $expectedResponse->setResult($result);
        $expectedResponse->setWorkflowRevisionId($workflowRevisionId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->executionName('[PROJECT]', '[LOCATION]', '[WORKFLOW]', '[EXECUTION]');
        $request = (new GetExecutionRequest())
            ->setName($formattedName);
        $response = $gapicClient->getExecution($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.workflows.executions.v1.Executions/GetExecution', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getExecutionExceptionTest()
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
        $formattedName = $gapicClient->executionName('[PROJECT]', '[LOCATION]', '[WORKFLOW]', '[EXECUTION]');
        $request = (new GetExecutionRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getExecution($request);
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
    public function listExecutionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $executionsElement = new Execution();
        $executions = [
            $executionsElement,
        ];
        $expectedResponse = new ListExecutionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setExecutions($executions);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->workflowName('[PROJECT]', '[LOCATION]', '[WORKFLOW]');
        $request = (new ListExecutionsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listExecutions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getExecutions()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.workflows.executions.v1.Executions/ListExecutions', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listExecutionsExceptionTest()
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
        $formattedParent = $gapicClient->workflowName('[PROJECT]', '[LOCATION]', '[WORKFLOW]');
        $request = (new ListExecutionsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listExecutions($request);
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
    public function cancelExecutionAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $argument = 'argument-1589682499';
        $result = 'result-934426595';
        $workflowRevisionId = 'workflowRevisionId-1453295745';
        $expectedResponse = new Execution();
        $expectedResponse->setName($name2);
        $expectedResponse->setArgument($argument);
        $expectedResponse->setResult($result);
        $expectedResponse->setWorkflowRevisionId($workflowRevisionId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->executionName('[PROJECT]', '[LOCATION]', '[WORKFLOW]', '[EXECUTION]');
        $request = (new CancelExecutionRequest())
            ->setName($formattedName);
        $response = $gapicClient->cancelExecutionAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.workflows.executions.v1.Executions/CancelExecution', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
