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

namespace Google\Shopping\Merchant\Lfp\Tests\Unit\V1beta\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Rpc\Code;
use Google\Shopping\Merchant\Lfp\V1beta\Client\LfpMerchantStateServiceClient;
use Google\Shopping\Merchant\Lfp\V1beta\GetLfpMerchantStateRequest;
use Google\Shopping\Merchant\Lfp\V1beta\LfpMerchantState;
use stdClass;

/**
 * @group lfp
 *
 * @group gapic
 */
class LfpMerchantStateServiceClientTest extends GeneratedTest
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

    /** @return LfpMerchantStateServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new LfpMerchantStateServiceClient($options);
    }

    /** @test */
    public function getLfpMerchantStateTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $linkedGbps = 1308276092;
        $expectedResponse = new LfpMerchantState();
        $expectedResponse->setName($name2);
        $expectedResponse->setLinkedGbps($linkedGbps);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->lfpMerchantStateName('[ACCOUNT]', '[LFP_MERCHANT_STATE]');
        $request = (new GetLfpMerchantStateRequest())->setName($formattedName);
        $response = $gapicClient->getLfpMerchantState($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.lfp.v1beta.LfpMerchantStateService/GetLfpMerchantState',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getLfpMerchantStateExceptionTest()
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
        $formattedName = $gapicClient->lfpMerchantStateName('[ACCOUNT]', '[LFP_MERCHANT_STATE]');
        $request = (new GetLfpMerchantStateRequest())->setName($formattedName);
        try {
            $gapicClient->getLfpMerchantState($request);
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
    public function getLfpMerchantStateAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $linkedGbps = 1308276092;
        $expectedResponse = new LfpMerchantState();
        $expectedResponse->setName($name2);
        $expectedResponse->setLinkedGbps($linkedGbps);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->lfpMerchantStateName('[ACCOUNT]', '[LFP_MERCHANT_STATE]');
        $request = (new GetLfpMerchantStateRequest())->setName($formattedName);
        $response = $gapicClient->getLfpMerchantStateAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.lfp.v1beta.LfpMerchantStateService/GetLfpMerchantState',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
