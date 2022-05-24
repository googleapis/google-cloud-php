<?php
/*
 * Copyright 2022 Google LLC
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

namespace Google\Cloud\AIPlatform\Tests\Unit\V1;

use Google\ApiCore\ApiException;

use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\ServerStream;
use Google\ApiCore\Testing\GeneratedTest;

use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\AIPlatform\V1\FeatureSelector;
use Google\Cloud\AIPlatform\V1\FeaturestoreOnlineServingServiceClient;
use Google\Cloud\AIPlatform\V1\IdMatcher;
use Google\Cloud\AIPlatform\V1\ReadFeatureValuesResponse;
use Google\Rpc\Code;
use stdClass;

/**
 * @group aiplatform
 *
 * @group gapic
 */
class FeaturestoreOnlineServingServiceClientTest extends GeneratedTest
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
     * @return FeaturestoreOnlineServingServiceClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new FeaturestoreOnlineServingServiceClient($options);
    }

    /**
     * @test
     */
    public function readFeatureValuesTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ReadFeatureValuesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedEntityType = $client->entityTypeName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]');
        $entityId = 'entityId-740565257';
        $featureSelector = new FeatureSelector();
        $featureSelectorIdMatcher = new IdMatcher();
        $idMatcherIds = [];
        $featureSelectorIdMatcher->setIds($idMatcherIds);
        $featureSelector->setIdMatcher($featureSelectorIdMatcher);
        $response = $client->readFeatureValues($formattedEntityType, $entityId, $featureSelector);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreOnlineServingService/ReadFeatureValues', $actualFuncCall);
        $actualValue = $actualRequestObject->getEntityType();
        $this->assertProtobufEquals($formattedEntityType, $actualValue);
        $actualValue = $actualRequestObject->getEntityId();
        $this->assertProtobufEquals($entityId, $actualValue);
        $actualValue = $actualRequestObject->getFeatureSelector();
        $this->assertProtobufEquals($featureSelector, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function readFeatureValuesExceptionTest()
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
        $formattedEntityType = $client->entityTypeName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]');
        $entityId = 'entityId-740565257';
        $featureSelector = new FeatureSelector();
        $featureSelectorIdMatcher = new IdMatcher();
        $idMatcherIds = [];
        $featureSelectorIdMatcher->setIds($idMatcherIds);
        $featureSelector->setIdMatcher($featureSelectorIdMatcher);
        try {
            $client->readFeatureValues($formattedEntityType, $entityId, $featureSelector);
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

    /**
     * @test
     */
    public function streamingReadFeatureValuesTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ReadFeatureValuesResponse();
        $transport->addResponse($expectedResponse);
        $expectedResponse2 = new ReadFeatureValuesResponse();
        $transport->addResponse($expectedResponse2);
        $expectedResponse3 = new ReadFeatureValuesResponse();
        $transport->addResponse($expectedResponse3);
        // Mock request
        $formattedEntityType = $client->entityTypeName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]');
        $entityIds = [];
        $featureSelector = new FeatureSelector();
        $featureSelectorIdMatcher = new IdMatcher();
        $idMatcherIds = [];
        $featureSelectorIdMatcher->setIds($idMatcherIds);
        $featureSelector->setIdMatcher($featureSelectorIdMatcher);
        $serverStream = $client->streamingReadFeatureValues($formattedEntityType, $entityIds, $featureSelector);
        $this->assertInstanceOf(ServerStream::class, $serverStream);
        $responses = iterator_to_array($serverStream->readAll());
        $expectedResponses = [];
        $expectedResponses[] = $expectedResponse;
        $expectedResponses[] = $expectedResponse2;
        $expectedResponses[] = $expectedResponse3;
        $this->assertEquals($expectedResponses, $responses);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreOnlineServingService/StreamingReadFeatureValues', $actualFuncCall);
        $actualValue = $actualRequestObject->getEntityType();
        $this->assertProtobufEquals($formattedEntityType, $actualValue);
        $actualValue = $actualRequestObject->getEntityIds();
        $this->assertProtobufEquals($entityIds, $actualValue);
        $actualValue = $actualRequestObject->getFeatureSelector();
        $this->assertProtobufEquals($featureSelector, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function streamingReadFeatureValuesExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->setStreamingStatus($status);
        $this->assertTrue($transport->isExhausted());
        // Mock request
        $formattedEntityType = $client->entityTypeName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]');
        $entityIds = [];
        $featureSelector = new FeatureSelector();
        $featureSelectorIdMatcher = new IdMatcher();
        $idMatcherIds = [];
        $featureSelectorIdMatcher->setIds($idMatcherIds);
        $featureSelector->setIdMatcher($featureSelectorIdMatcher);
        $serverStream = $client->streamingReadFeatureValues($formattedEntityType, $entityIds, $featureSelector);
        $results = $serverStream->readAll();
        try {
            iterator_to_array($results);
            // If the close stream method call did not throw, fail the test
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
