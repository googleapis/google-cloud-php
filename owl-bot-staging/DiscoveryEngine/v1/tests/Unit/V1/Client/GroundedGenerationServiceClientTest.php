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

namespace Google\Cloud\DiscoveryEngine\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\DiscoveryEngine\V1\CheckGroundingRequest;
use Google\Cloud\DiscoveryEngine\V1\CheckGroundingResponse;
use Google\Cloud\DiscoveryEngine\V1\Client\GroundedGenerationServiceClient;
use Google\Rpc\Code;
use stdClass;

/**
 * @group discoveryengine
 *
 * @group gapic
 */
class GroundedGenerationServiceClientTest extends GeneratedTest
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

    /** @return GroundedGenerationServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new GroundedGenerationServiceClient($options);
    }

    /** @test */
    public function checkGroundingTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $supportScore = -13206883;
        $expectedResponse = new CheckGroundingResponse();
        $expectedResponse->setSupportScore($supportScore);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedGroundingConfig = $gapicClient->groundingConfigName('[PROJECT]', '[LOCATION]', '[GROUNDING_CONFIG]');
        $request = (new CheckGroundingRequest())
            ->setGroundingConfig($formattedGroundingConfig);
        $response = $gapicClient->checkGrounding($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.GroundedGenerationService/CheckGrounding', $actualFuncCall);
        $actualValue = $actualRequestObject->getGroundingConfig();
        $this->assertProtobufEquals($formattedGroundingConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function checkGroundingExceptionTest()
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
        $formattedGroundingConfig = $gapicClient->groundingConfigName('[PROJECT]', '[LOCATION]', '[GROUNDING_CONFIG]');
        $request = (new CheckGroundingRequest())
            ->setGroundingConfig($formattedGroundingConfig);
        try {
            $gapicClient->checkGrounding($request);
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
    public function checkGroundingAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $supportScore = -13206883;
        $expectedResponse = new CheckGroundingResponse();
        $expectedResponse->setSupportScore($supportScore);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedGroundingConfig = $gapicClient->groundingConfigName('[PROJECT]', '[LOCATION]', '[GROUNDING_CONFIG]');
        $request = (new CheckGroundingRequest())
            ->setGroundingConfig($formattedGroundingConfig);
        $response = $gapicClient->checkGroundingAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.GroundedGenerationService/CheckGrounding', $actualFuncCall);
        $actualValue = $actualRequestObject->getGroundingConfig();
        $this->assertProtobufEquals($formattedGroundingConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
