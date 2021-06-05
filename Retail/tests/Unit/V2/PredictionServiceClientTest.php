<?php
/*
 * Copyright 2021 Google LLC
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

namespace Google\Cloud\Retail\Tests\Unit\V2;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;

use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Retail\V2\PredictionServiceClient;
use Google\Cloud\Retail\V2\PredictResponse;
use Google\Cloud\Retail\V2\UserEvent;
use Google\Rpc\Code;
use stdClass;

/**
 * @group retail
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
        $attributionToken = 'attributionToken-729411015';
        $validateOnly2 = true;
        $expectedResponse = new PredictResponse();
        $expectedResponse->setAttributionToken($attributionToken);
        $expectedResponse->setValidateOnly($validateOnly2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $placement = 'placement1792938725';
        $userEvent = new UserEvent();
        $userEventEventType = 'userEventEventType341658661';
        $userEvent->setEventType($userEventEventType);
        $userEventVisitorId = 'userEventVisitorId-2104193702';
        $userEvent->setVisitorId($userEventVisitorId);
        $response = $client->predict($placement, $userEvent);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.PredictionService/Predict', $actualFuncCall);
        $actualValue = $actualRequestObject->getPlacement();
        $this->assertProtobufEquals($placement, $actualValue);
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
        $placement = 'placement1792938725';
        $userEvent = new UserEvent();
        $userEventEventType = 'userEventEventType341658661';
        $userEvent->setEventType($userEventEventType);
        $userEventVisitorId = 'userEventVisitorId-2104193702';
        $userEvent->setVisitorId($userEventVisitorId);
        try {
            $client->predict($placement, $userEvent);
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
