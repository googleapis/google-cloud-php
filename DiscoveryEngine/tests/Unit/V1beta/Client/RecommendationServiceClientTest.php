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

namespace Google\Cloud\DiscoveryEngine\Tests\Unit\V1beta\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\DiscoveryEngine\V1beta\Client\RecommendationServiceClient;
use Google\Cloud\DiscoveryEngine\V1beta\RecommendRequest;
use Google\Cloud\DiscoveryEngine\V1beta\RecommendResponse;
use Google\Cloud\DiscoveryEngine\V1beta\UserEvent;
use Google\Rpc\Code;
use stdClass;

/**
 * @group discoveryengine
 *
 * @group gapic
 */
class RecommendationServiceClientTest extends GeneratedTest
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

    /** @return RecommendationServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new RecommendationServiceClient($options);
    }

    /** @test */
    public function recommendTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $attributionToken = 'attributionToken-729411015';
        $validateOnly2 = true;
        $expectedResponse = new RecommendResponse();
        $expectedResponse->setAttributionToken($attributionToken);
        $expectedResponse->setValidateOnly($validateOnly2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedServingConfig = $gapicClient->servingConfigName('[PROJECT]', '[LOCATION]', '[DATA_STORE]', '[SERVING_CONFIG]');
        $userEvent = new UserEvent();
        $userEventEventType = 'userEventEventType341658661';
        $userEvent->setEventType($userEventEventType);
        $userEventUserPseudoId = 'userEventUserPseudoId-1929667693';
        $userEvent->setUserPseudoId($userEventUserPseudoId);
        $request = (new RecommendRequest())
            ->setServingConfig($formattedServingConfig)
            ->setUserEvent($userEvent);
        $response = $gapicClient->recommend($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1beta.RecommendationService/Recommend', $actualFuncCall);
        $actualValue = $actualRequestObject->getServingConfig();
        $this->assertProtobufEquals($formattedServingConfig, $actualValue);
        $actualValue = $actualRequestObject->getUserEvent();
        $this->assertProtobufEquals($userEvent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function recommendExceptionTest()
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
        $formattedServingConfig = $gapicClient->servingConfigName('[PROJECT]', '[LOCATION]', '[DATA_STORE]', '[SERVING_CONFIG]');
        $userEvent = new UserEvent();
        $userEventEventType = 'userEventEventType341658661';
        $userEvent->setEventType($userEventEventType);
        $userEventUserPseudoId = 'userEventUserPseudoId-1929667693';
        $userEvent->setUserPseudoId($userEventUserPseudoId);
        $request = (new RecommendRequest())
            ->setServingConfig($formattedServingConfig)
            ->setUserEvent($userEvent);
        try {
            $gapicClient->recommend($request);
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
    public function recommendAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $attributionToken = 'attributionToken-729411015';
        $validateOnly2 = true;
        $expectedResponse = new RecommendResponse();
        $expectedResponse->setAttributionToken($attributionToken);
        $expectedResponse->setValidateOnly($validateOnly2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedServingConfig = $gapicClient->servingConfigName('[PROJECT]', '[LOCATION]', '[DATA_STORE]', '[SERVING_CONFIG]');
        $userEvent = new UserEvent();
        $userEventEventType = 'userEventEventType341658661';
        $userEvent->setEventType($userEventEventType);
        $userEventUserPseudoId = 'userEventUserPseudoId-1929667693';
        $userEvent->setUserPseudoId($userEventUserPseudoId);
        $request = (new RecommendRequest())
            ->setServingConfig($formattedServingConfig)
            ->setUserEvent($userEvent);
        $response = $gapicClient->recommendAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1beta.RecommendationService/Recommend', $actualFuncCall);
        $actualValue = $actualRequestObject->getServingConfig();
        $this->assertProtobufEquals($formattedServingConfig, $actualValue);
        $actualValue = $actualRequestObject->getUserEvent();
        $this->assertProtobufEquals($userEvent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
