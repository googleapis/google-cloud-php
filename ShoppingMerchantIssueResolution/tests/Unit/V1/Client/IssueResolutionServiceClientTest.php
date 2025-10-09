<?php
/*
 * Copyright 2025 Google LLC
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

namespace Google\Shopping\Merchant\IssueResolution\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Rpc\Code;
use Google\Shopping\Merchant\IssueResolution\V1\ActionInput;
use Google\Shopping\Merchant\IssueResolution\V1\Client\IssueResolutionServiceClient;
use Google\Shopping\Merchant\IssueResolution\V1\RenderAccountIssuesRequest;
use Google\Shopping\Merchant\IssueResolution\V1\RenderAccountIssuesResponse;
use Google\Shopping\Merchant\IssueResolution\V1\RenderProductIssuesRequest;
use Google\Shopping\Merchant\IssueResolution\V1\RenderProductIssuesResponse;
use Google\Shopping\Merchant\IssueResolution\V1\TriggerActionPayload;
use Google\Shopping\Merchant\IssueResolution\V1\TriggerActionRequest;
use Google\Shopping\Merchant\IssueResolution\V1\TriggerActionResponse;
use stdClass;

/**
 * @group issueresolution
 *
 * @group gapic
 */
class IssueResolutionServiceClientTest extends GeneratedTest
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

    /** @return IssueResolutionServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new IssueResolutionServiceClient($options);
    }

    /** @test */
    public function renderAccountIssuesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new RenderAccountIssuesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->accountName('[ACCOUNT]');
        $request = (new RenderAccountIssuesRequest())->setName($formattedName);
        $response = $gapicClient->renderAccountIssues($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.issueresolution.v1.IssueResolutionService/RenderAccountIssues',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function renderAccountIssuesExceptionTest()
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
        $formattedName = $gapicClient->accountName('[ACCOUNT]');
        $request = (new RenderAccountIssuesRequest())->setName($formattedName);
        try {
            $gapicClient->renderAccountIssues($request);
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
    public function renderProductIssuesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new RenderProductIssuesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->productName('[ACCOUNT]', '[PRODUCT]');
        $request = (new RenderProductIssuesRequest())->setName($formattedName);
        $response = $gapicClient->renderProductIssues($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.issueresolution.v1.IssueResolutionService/RenderProductIssues',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function renderProductIssuesExceptionTest()
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
        $formattedName = $gapicClient->productName('[ACCOUNT]', '[PRODUCT]');
        $request = (new RenderProductIssuesRequest())->setName($formattedName);
        try {
            $gapicClient->renderProductIssues($request);
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
    public function triggerActionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $message = 'message954925063';
        $expectedResponse = new TriggerActionResponse();
        $expectedResponse->setMessage($message);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->accountName('[ACCOUNT]');
        $payload = new TriggerActionPayload();
        $payloadActionContext = 'payloadActionContext85248939';
        $payload->setActionContext($payloadActionContext);
        $payloadActionInput = new ActionInput();
        $actionInputActionFlowId = 'actionInputActionFlowId1420321299';
        $payloadActionInput->setActionFlowId($actionInputActionFlowId);
        $actionInputInputValues = [];
        $payloadActionInput->setInputValues($actionInputInputValues);
        $payload->setActionInput($payloadActionInput);
        $request = (new TriggerActionRequest())->setName($formattedName)->setPayload($payload);
        $response = $gapicClient->triggerAction($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.issueresolution.v1.IssueResolutionService/TriggerAction',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getPayload();
        $this->assertProtobufEquals($payload, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function triggerActionExceptionTest()
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
        $formattedName = $gapicClient->accountName('[ACCOUNT]');
        $payload = new TriggerActionPayload();
        $payloadActionContext = 'payloadActionContext85248939';
        $payload->setActionContext($payloadActionContext);
        $payloadActionInput = new ActionInput();
        $actionInputActionFlowId = 'actionInputActionFlowId1420321299';
        $payloadActionInput->setActionFlowId($actionInputActionFlowId);
        $actionInputInputValues = [];
        $payloadActionInput->setInputValues($actionInputInputValues);
        $payload->setActionInput($payloadActionInput);
        $request = (new TriggerActionRequest())->setName($formattedName)->setPayload($payload);
        try {
            $gapicClient->triggerAction($request);
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
    public function renderAccountIssuesAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new RenderAccountIssuesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->accountName('[ACCOUNT]');
        $request = (new RenderAccountIssuesRequest())->setName($formattedName);
        $response = $gapicClient->renderAccountIssuesAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.issueresolution.v1.IssueResolutionService/RenderAccountIssues',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
