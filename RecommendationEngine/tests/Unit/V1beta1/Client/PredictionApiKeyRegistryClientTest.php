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

namespace Google\Cloud\RecommendationEngine\Tests\Unit\V1beta1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\RecommendationEngine\V1beta1\Client\PredictionApiKeyRegistryClient;
use Google\Cloud\RecommendationEngine\V1beta1\CreatePredictionApiKeyRegistrationRequest;
use Google\Cloud\RecommendationEngine\V1beta1\DeletePredictionApiKeyRegistrationRequest;
use Google\Cloud\RecommendationEngine\V1beta1\ListPredictionApiKeyRegistrationsRequest;
use Google\Cloud\RecommendationEngine\V1beta1\ListPredictionApiKeyRegistrationsResponse;
use Google\Cloud\RecommendationEngine\V1beta1\PredictionApiKeyRegistration;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group recommendationengine
 *
 * @group gapic
 */
class PredictionApiKeyRegistryClientTest extends GeneratedTest
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

    /** @return PredictionApiKeyRegistryClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new PredictionApiKeyRegistryClient($options);
    }

    /** @test */
    public function createPredictionApiKeyRegistrationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $apiKey = 'apiKey-800085318';
        $expectedResponse = new PredictionApiKeyRegistration();
        $expectedResponse->setApiKey($apiKey);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->eventStoreName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[EVENT_STORE]');
        $predictionApiKeyRegistration = new PredictionApiKeyRegistration();
        $request = (new CreatePredictionApiKeyRegistrationRequest())
            ->setParent($formattedParent)
            ->setPredictionApiKeyRegistration($predictionApiKeyRegistration);
        $response = $gapicClient->createPredictionApiKeyRegistration($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recommendationengine.v1beta1.PredictionApiKeyRegistry/CreatePredictionApiKeyRegistration',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getPredictionApiKeyRegistration();
        $this->assertProtobufEquals($predictionApiKeyRegistration, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createPredictionApiKeyRegistrationExceptionTest()
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
        $formattedParent = $gapicClient->eventStoreName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[EVENT_STORE]');
        $predictionApiKeyRegistration = new PredictionApiKeyRegistration();
        $request = (new CreatePredictionApiKeyRegistrationRequest())
            ->setParent($formattedParent)
            ->setPredictionApiKeyRegistration($predictionApiKeyRegistration);
        try {
            $gapicClient->createPredictionApiKeyRegistration($request);
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
    public function deletePredictionApiKeyRegistrationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->predictionApiKeyRegistrationName(
            '[PROJECT]',
            '[LOCATION]',
            '[CATALOG]',
            '[EVENT_STORE]',
            '[PREDICTION_API_KEY_REGISTRATION]'
        );
        $request = (new DeletePredictionApiKeyRegistrationRequest())->setName($formattedName);
        $gapicClient->deletePredictionApiKeyRegistration($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recommendationengine.v1beta1.PredictionApiKeyRegistry/DeletePredictionApiKeyRegistration',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deletePredictionApiKeyRegistrationExceptionTest()
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
        $formattedName = $gapicClient->predictionApiKeyRegistrationName(
            '[PROJECT]',
            '[LOCATION]',
            '[CATALOG]',
            '[EVENT_STORE]',
            '[PREDICTION_API_KEY_REGISTRATION]'
        );
        $request = (new DeletePredictionApiKeyRegistrationRequest())->setName($formattedName);
        try {
            $gapicClient->deletePredictionApiKeyRegistration($request);
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
    public function listPredictionApiKeyRegistrationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $predictionApiKeyRegistrationsElement = new PredictionApiKeyRegistration();
        $predictionApiKeyRegistrations = [$predictionApiKeyRegistrationsElement];
        $expectedResponse = new ListPredictionApiKeyRegistrationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setPredictionApiKeyRegistrations($predictionApiKeyRegistrations);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->eventStoreName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[EVENT_STORE]');
        $request = (new ListPredictionApiKeyRegistrationsRequest())->setParent($formattedParent);
        $response = $gapicClient->listPredictionApiKeyRegistrations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getPredictionApiKeyRegistrations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recommendationengine.v1beta1.PredictionApiKeyRegistry/ListPredictionApiKeyRegistrations',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listPredictionApiKeyRegistrationsExceptionTest()
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
        $formattedParent = $gapicClient->eventStoreName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[EVENT_STORE]');
        $request = (new ListPredictionApiKeyRegistrationsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listPredictionApiKeyRegistrations($request);
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
    public function createPredictionApiKeyRegistrationAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $apiKey = 'apiKey-800085318';
        $expectedResponse = new PredictionApiKeyRegistration();
        $expectedResponse->setApiKey($apiKey);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->eventStoreName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[EVENT_STORE]');
        $predictionApiKeyRegistration = new PredictionApiKeyRegistration();
        $request = (new CreatePredictionApiKeyRegistrationRequest())
            ->setParent($formattedParent)
            ->setPredictionApiKeyRegistration($predictionApiKeyRegistration);
        $response = $gapicClient->createPredictionApiKeyRegistrationAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recommendationengine.v1beta1.PredictionApiKeyRegistry/CreatePredictionApiKeyRegistration',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getPredictionApiKeyRegistration();
        $this->assertProtobufEquals($predictionApiKeyRegistration, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
