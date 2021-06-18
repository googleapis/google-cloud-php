<?php
/*
 * Copyright 2020 Google LLC
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

namespace Google\Cloud\RecommendationEngine\Tests\Unit\V1beta1;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;

use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\RecommendationEngine\V1beta1\PredictionServiceClient;
use Google\Cloud\RecommendationEngine\V1beta1\PredictResponse;
use Google\Cloud\RecommendationEngine\V1beta1\PredictResponse\PredictionResult;
use Google\Cloud\RecommendationEngine\V1beta1\UserEvent;
use Google\Cloud\RecommendationEngine\V1beta1\UserInfo;
use Google\Rpc\Code;
use stdClass;

/**
 * @group recommendationengine
 *
 * @group gapic
 */
class PredictionServiceClientTest extends GeneratedTest
{
    /**
     * @return TransportInterface
     */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /**
     * @return CredentialsWrapper
     */
    private function createCredentials()
    {
        return $this->getMockBuilder(CredentialsWrapper::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * @return PredictionServiceClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new PredictionServiceClient($options);
    }

    /**
     * @test
     */
    public function predictTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $recommendationToken = 'recommendationToken-1973883405';
        $dryRun2 = true;
        $nextPageToken = '';
        $resultsElement = new PredictionResult();
        $results = [
            $resultsElement,
        ];
        $expectedResponse = new PredictResponse();
        $expectedResponse->setRecommendationToken($recommendationToken);
        $expectedResponse->setDryRun($dryRun2);
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setResults($results);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->placementName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[EVENT_STORE]', '[PLACEMENT]');
        $userEvent = new UserEvent();
        $userEventEventType = 'userEventEventType341658661';
        $userEvent->setEventType($userEventEventType);
        $userEventUserInfo = new UserInfo();
        $userInfoVisitorId = 'userInfoVisitorId-1297088752';
        $userEventUserInfo->setVisitorId($userInfoVisitorId);
        $userEvent->setUserInfo($userEventUserInfo);
        $response = $client->predict($formattedName, $userEvent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getResults()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recommendationengine.v1beta1.PredictionService/Predict', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getUserEvent();
        $this->assertProtobufEquals($userEvent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function predictExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->placementName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[EVENT_STORE]', '[PLACEMENT]');
        $userEvent = new UserEvent();
        $userEventEventType = 'userEventEventType341658661';
        $userEvent->setEventType($userEventEventType);
        $userEventUserInfo = new UserInfo();
        $userInfoVisitorId = 'userInfoVisitorId-1297088752';
        $userEventUserInfo->setVisitorId($userInfoVisitorId);
        $userEvent->setUserInfo($userEventUserInfo);
        try {
            $client->predict($formattedName, $userEvent);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }
}
