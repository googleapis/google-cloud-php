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

namespace Google\Cloud\Chronicle\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Chronicle\V1\Client\RuleExecutionErrorServiceClient;
use Google\Cloud\Chronicle\V1\ListRuleExecutionErrorsRequest;
use Google\Cloud\Chronicle\V1\ListRuleExecutionErrorsResponse;
use Google\Cloud\Chronicle\V1\RuleExecutionError;
use Google\Rpc\Code;
use stdClass;

/**
 * @group chronicle
 *
 * @group gapic
 */
class RuleExecutionErrorServiceClientTest extends GeneratedTest
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

    /** @return RuleExecutionErrorServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new RuleExecutionErrorServiceClient($options);
    }

    /** @test */
    public function listRuleExecutionErrorsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $ruleExecutionErrorsElement = new RuleExecutionError();
        $ruleExecutionErrors = [$ruleExecutionErrorsElement];
        $expectedResponse = new ListRuleExecutionErrorsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setRuleExecutionErrors($ruleExecutionErrors);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new ListRuleExecutionErrorsRequest())->setParent($formattedParent);
        $response = $gapicClient->listRuleExecutionErrors($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getRuleExecutionErrors()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.chronicle.v1.RuleExecutionErrorService/ListRuleExecutionErrors',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listRuleExecutionErrorsExceptionTest()
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
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new ListRuleExecutionErrorsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listRuleExecutionErrors($request);
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
    public function listRuleExecutionErrorsAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $ruleExecutionErrorsElement = new RuleExecutionError();
        $ruleExecutionErrors = [$ruleExecutionErrorsElement];
        $expectedResponse = new ListRuleExecutionErrorsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setRuleExecutionErrors($ruleExecutionErrors);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new ListRuleExecutionErrorsRequest())->setParent($formattedParent);
        $response = $gapicClient->listRuleExecutionErrorsAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getRuleExecutionErrors()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.chronicle.v1.RuleExecutionErrorService/ListRuleExecutionErrors',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
