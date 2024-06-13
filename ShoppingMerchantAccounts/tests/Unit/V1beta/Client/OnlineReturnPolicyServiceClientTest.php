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

namespace Google\Shopping\Merchant\Accounts\Tests\Unit\V1beta\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Rpc\Code;
use Google\Shopping\Merchant\Accounts\V1beta\Client\OnlineReturnPolicyServiceClient;
use Google\Shopping\Merchant\Accounts\V1beta\GetOnlineReturnPolicyRequest;
use Google\Shopping\Merchant\Accounts\V1beta\ListOnlineReturnPoliciesRequest;
use Google\Shopping\Merchant\Accounts\V1beta\ListOnlineReturnPoliciesResponse;
use Google\Shopping\Merchant\Accounts\V1beta\OnlineReturnPolicy;
use stdClass;

/**
 * @group accounts
 *
 * @group gapic
 */
class OnlineReturnPolicyServiceClientTest extends GeneratedTest
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

    /** @return OnlineReturnPolicyServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new OnlineReturnPolicyServiceClient($options);
    }

    /** @test */
    public function getOnlineReturnPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $returnPolicyId = 'returnPolicyId1108665081';
        $label = 'label102727412';
        $returnPolicyUri = 'returnPolicyUri8891214';
        $acceptDefectiveOnly = false;
        $processRefundDays = 1233584878;
        $acceptExchange = true;
        $expectedResponse = new OnlineReturnPolicy();
        $expectedResponse->setName($name2);
        $expectedResponse->setReturnPolicyId($returnPolicyId);
        $expectedResponse->setLabel($label);
        $expectedResponse->setReturnPolicyUri($returnPolicyUri);
        $expectedResponse->setAcceptDefectiveOnly($acceptDefectiveOnly);
        $expectedResponse->setProcessRefundDays($processRefundDays);
        $expectedResponse->setAcceptExchange($acceptExchange);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->onlineReturnPolicyName('[ACCOUNT]', '[RETURN_POLICY]');
        $request = (new GetOnlineReturnPolicyRequest())->setName($formattedName);
        $response = $gapicClient->getOnlineReturnPolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1beta.OnlineReturnPolicyService/GetOnlineReturnPolicy',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getOnlineReturnPolicyExceptionTest()
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
        $formattedName = $gapicClient->onlineReturnPolicyName('[ACCOUNT]', '[RETURN_POLICY]');
        $request = (new GetOnlineReturnPolicyRequest())->setName($formattedName);
        try {
            $gapicClient->getOnlineReturnPolicy($request);
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
    public function listOnlineReturnPoliciesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $onlineReturnPoliciesElement = new OnlineReturnPolicy();
        $onlineReturnPolicies = [$onlineReturnPoliciesElement];
        $expectedResponse = new ListOnlineReturnPoliciesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setOnlineReturnPolicies($onlineReturnPolicies);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $request = (new ListOnlineReturnPoliciesRequest())->setParent($formattedParent);
        $response = $gapicClient->listOnlineReturnPolicies($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getOnlineReturnPolicies()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1beta.OnlineReturnPolicyService/ListOnlineReturnPolicies',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listOnlineReturnPoliciesExceptionTest()
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
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $request = (new ListOnlineReturnPoliciesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listOnlineReturnPolicies($request);
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
    public function getOnlineReturnPolicyAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $returnPolicyId = 'returnPolicyId1108665081';
        $label = 'label102727412';
        $returnPolicyUri = 'returnPolicyUri8891214';
        $acceptDefectiveOnly = false;
        $processRefundDays = 1233584878;
        $acceptExchange = true;
        $expectedResponse = new OnlineReturnPolicy();
        $expectedResponse->setName($name2);
        $expectedResponse->setReturnPolicyId($returnPolicyId);
        $expectedResponse->setLabel($label);
        $expectedResponse->setReturnPolicyUri($returnPolicyUri);
        $expectedResponse->setAcceptDefectiveOnly($acceptDefectiveOnly);
        $expectedResponse->setProcessRefundDays($processRefundDays);
        $expectedResponse->setAcceptExchange($acceptExchange);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->onlineReturnPolicyName('[ACCOUNT]', '[RETURN_POLICY]');
        $request = (new GetOnlineReturnPolicyRequest())->setName($formattedName);
        $response = $gapicClient->getOnlineReturnPolicyAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1beta.OnlineReturnPolicyService/GetOnlineReturnPolicy',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
