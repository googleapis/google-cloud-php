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
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\Testing\GeneratedTest;

use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\AIPlatform\V1\BatchCreateFeaturesResponse;
use Google\Cloud\AIPlatform\V1\BatchReadFeatureValuesResponse;

use Google\Cloud\AIPlatform\V1\EntityType;
use Google\Cloud\AIPlatform\V1\ExportFeatureValuesResponse;
use Google\Cloud\AIPlatform\V1\Feature;
use Google\Cloud\AIPlatform\V1\Feature\ValueType;
use Google\Cloud\AIPlatform\V1\FeatureSelector;
use Google\Cloud\AIPlatform\V1\Featurestore;
use Google\Cloud\AIPlatform\V1\Featurestore\OnlineServingConfig;
use Google\Cloud\AIPlatform\V1\FeaturestoreServiceClient;
use Google\Cloud\AIPlatform\V1\FeatureValueDestination;
use Google\Cloud\AIPlatform\V1\IdMatcher;
use Google\Cloud\AIPlatform\V1\ImportFeatureValuesResponse;
use Google\Cloud\AIPlatform\V1\ListEntityTypesResponse;
use Google\Cloud\AIPlatform\V1\ListFeaturesResponse;
use Google\Cloud\AIPlatform\V1\ListFeaturestoresResponse;
use Google\Cloud\AIPlatform\V1\SearchFeaturesResponse;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group aiplatform
 *
 * @group gapic
 */
class FeaturestoreServiceClientTest extends GeneratedTest
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
     * @return FeaturestoreServiceClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new FeaturestoreServiceClient($options);
    }

    /**
     * @test
     */
    public function batchCreateFeaturesTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/batchCreateFeaturesTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new BatchCreateFeaturesResponse();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/batchCreateFeaturesTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $client->entityTypeName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]');
        $requests = [];
        $response = $client->batchCreateFeatures($formattedParent, $requests);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/BatchCreateFeatures', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/batchCreateFeaturesTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function batchCreateFeaturesExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/batchCreateFeaturesTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedParent = $client->entityTypeName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]');
        $requests = [];
        $response = $client->batchCreateFeatures($formattedParent, $requests);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/batchCreateFeaturesTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function batchReadFeatureValuesTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/batchReadFeatureValuesTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new BatchReadFeatureValuesResponse();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/batchReadFeatureValuesTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedFeaturestore = $client->featurestoreName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]');
        $destination = new FeatureValueDestination();
        $entityTypeSpecs = [];
        $response = $client->batchReadFeatureValues($formattedFeaturestore, $destination, $entityTypeSpecs);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/BatchReadFeatureValues', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getFeaturestore();
        $this->assertProtobufEquals($formattedFeaturestore, $actualValue);
        $actualValue = $actualApiRequestObject->getDestination();
        $this->assertProtobufEquals($destination, $actualValue);
        $actualValue = $actualApiRequestObject->getEntityTypeSpecs();
        $this->assertProtobufEquals($entityTypeSpecs, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/batchReadFeatureValuesTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function batchReadFeatureValuesExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/batchReadFeatureValuesTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedFeaturestore = $client->featurestoreName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]');
        $destination = new FeatureValueDestination();
        $entityTypeSpecs = [];
        $response = $client->batchReadFeatureValues($formattedFeaturestore, $destination, $entityTypeSpecs);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/batchReadFeatureValuesTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function createEntityTypeTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/createEntityTypeTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $description = 'description-1724546052';
        $etag = 'etag3123477';
        $expectedResponse = new EntityType();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setEtag($etag);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createEntityTypeTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $client->featurestoreName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]');
        $entityTypeId = 'entityTypeId1181734884';
        $response = $client->createEntityType($formattedParent, $entityTypeId);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/CreateEntityType', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getEntityTypeId();
        $this->assertProtobufEquals($entityTypeId, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createEntityTypeTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function createEntityTypeExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/createEntityTypeTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedParent = $client->featurestoreName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]');
        $entityTypeId = 'entityTypeId1181734884';
        $response = $client->createEntityType($formattedParent, $entityTypeId);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createEntityTypeTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function createFeatureTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/createFeatureTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $description = 'description-1724546052';
        $etag = 'etag3123477';
        $disableMonitoring = false;
        $expectedResponse = new Feature();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setDisableMonitoring($disableMonitoring);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createFeatureTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $client->entityTypeName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]');
        $feature = new Feature();
        $featureValueType = ValueType::VALUE_TYPE_UNSPECIFIED;
        $feature->setValueType($featureValueType);
        $featureId = 'featureId-150697212';
        $response = $client->createFeature($formattedParent, $feature, $featureId);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/CreateFeature', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getFeature();
        $this->assertProtobufEquals($feature, $actualValue);
        $actualValue = $actualApiRequestObject->getFeatureId();
        $this->assertProtobufEquals($featureId, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createFeatureTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function createFeatureExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/createFeatureTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedParent = $client->entityTypeName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]');
        $feature = new Feature();
        $featureValueType = ValueType::VALUE_TYPE_UNSPECIFIED;
        $feature->setValueType($featureValueType);
        $featureId = 'featureId-150697212';
        $response = $client->createFeature($formattedParent, $feature, $featureId);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createFeatureTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function createFeaturestoreTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/createFeaturestoreTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $etag = 'etag3123477';
        $expectedResponse = new Featurestore();
        $expectedResponse->setName($name);
        $expectedResponse->setEtag($etag);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createFeaturestoreTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $featurestore = new Featurestore();
        $featurestoreOnlineServingConfig = new OnlineServingConfig();
        $featurestore->setOnlineServingConfig($featurestoreOnlineServingConfig);
        $featurestoreId = 'featurestoreId-2136676817';
        $response = $client->createFeaturestore($formattedParent, $featurestore, $featurestoreId);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/CreateFeaturestore', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getFeaturestore();
        $this->assertProtobufEquals($featurestore, $actualValue);
        $actualValue = $actualApiRequestObject->getFeaturestoreId();
        $this->assertProtobufEquals($featurestoreId, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createFeaturestoreTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function createFeaturestoreExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/createFeaturestoreTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $featurestore = new Featurestore();
        $featurestoreOnlineServingConfig = new OnlineServingConfig();
        $featurestore->setOnlineServingConfig($featurestoreOnlineServingConfig);
        $featurestoreId = 'featurestoreId-2136676817';
        $response = $client->createFeaturestore($formattedParent, $featurestore, $featurestoreId);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createFeaturestoreTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteEntityTypeTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/deleteEntityTypeTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteEntityTypeTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $client->entityTypeName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]');
        $response = $client->deleteEntityType($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/DeleteEntityType', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteEntityTypeTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteEntityTypeExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/deleteEntityTypeTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedName = $client->entityTypeName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]');
        $response = $client->deleteEntityType($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteEntityTypeTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteFeatureTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/deleteFeatureTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteFeatureTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $client->featureName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]', '[FEATURE]');
        $response = $client->deleteFeature($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/DeleteFeature', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteFeatureTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteFeatureExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/deleteFeatureTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedName = $client->featureName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]', '[FEATURE]');
        $response = $client->deleteFeature($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteFeatureTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteFeaturestoreTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/deleteFeaturestoreTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteFeaturestoreTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $client->featurestoreName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]');
        $response = $client->deleteFeaturestore($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/DeleteFeaturestore', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteFeaturestoreTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteFeaturestoreExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/deleteFeaturestoreTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedName = $client->featurestoreName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]');
        $response = $client->deleteFeaturestore($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteFeaturestoreTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function exportFeatureValuesTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/exportFeatureValuesTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new ExportFeatureValuesResponse();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/exportFeatureValuesTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedEntityType = $client->entityTypeName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]');
        $destination = new FeatureValueDestination();
        $featureSelector = new FeatureSelector();
        $featureSelectorIdMatcher = new IdMatcher();
        $idMatcherIds = [];
        $featureSelectorIdMatcher->setIds($idMatcherIds);
        $featureSelector->setIdMatcher($featureSelectorIdMatcher);
        $response = $client->exportFeatureValues($formattedEntityType, $destination, $featureSelector);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/ExportFeatureValues', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getEntityType();
        $this->assertProtobufEquals($formattedEntityType, $actualValue);
        $actualValue = $actualApiRequestObject->getDestination();
        $this->assertProtobufEquals($destination, $actualValue);
        $actualValue = $actualApiRequestObject->getFeatureSelector();
        $this->assertProtobufEquals($featureSelector, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/exportFeatureValuesTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function exportFeatureValuesExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/exportFeatureValuesTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedEntityType = $client->entityTypeName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]');
        $destination = new FeatureValueDestination();
        $featureSelector = new FeatureSelector();
        $featureSelectorIdMatcher = new IdMatcher();
        $idMatcherIds = [];
        $featureSelectorIdMatcher->setIds($idMatcherIds);
        $featureSelector->setIdMatcher($featureSelectorIdMatcher);
        $response = $client->exportFeatureValues($formattedEntityType, $destination, $featureSelector);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/exportFeatureValuesTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function getEntityTypeTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $etag = 'etag3123477';
        $expectedResponse = new EntityType();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->entityTypeName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]');
        $response = $client->getEntityType($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/GetEntityType', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getEntityTypeExceptionTest()
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
        $formattedName = $client->entityTypeName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]');
        try {
            $client->getEntityType($formattedName);
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
    public function getFeatureTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $etag = 'etag3123477';
        $disableMonitoring = false;
        $expectedResponse = new Feature();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setDisableMonitoring($disableMonitoring);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->featureName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]', '[FEATURE]');
        $response = $client->getFeature($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/GetFeature', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getFeatureExceptionTest()
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
        $formattedName = $client->featureName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]', '[FEATURE]');
        try {
            $client->getFeature($formattedName);
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
    public function getFeaturestoreTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $etag = 'etag3123477';
        $expectedResponse = new Featurestore();
        $expectedResponse->setName($name2);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->featurestoreName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]');
        $response = $client->getFeaturestore($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/GetFeaturestore', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getFeaturestoreExceptionTest()
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
        $formattedName = $client->featurestoreName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]');
        try {
            $client->getFeaturestore($formattedName);
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
    public function importFeatureValuesTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/importFeatureValuesTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $importedEntityCount = 1840044274;
        $importedFeatureValueCount = 1221471427;
        $invalidRowCount = 366655966;
        $expectedResponse = new ImportFeatureValuesResponse();
        $expectedResponse->setImportedEntityCount($importedEntityCount);
        $expectedResponse->setImportedFeatureValueCount($importedFeatureValueCount);
        $expectedResponse->setInvalidRowCount($invalidRowCount);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/importFeatureValuesTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedEntityType = $client->entityTypeName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]');
        $featureSpecs = [];
        $response = $client->importFeatureValues($formattedEntityType, $featureSpecs);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/ImportFeatureValues', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getEntityType();
        $this->assertProtobufEquals($formattedEntityType, $actualValue);
        $actualValue = $actualApiRequestObject->getFeatureSpecs();
        $this->assertProtobufEquals($featureSpecs, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/importFeatureValuesTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function importFeatureValuesExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/importFeatureValuesTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedEntityType = $client->entityTypeName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]');
        $featureSpecs = [];
        $response = $client->importFeatureValues($formattedEntityType, $featureSpecs);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/importFeatureValuesTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function listEntityTypesTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $entityTypesElement = new EntityType();
        $entityTypes = [
            $entityTypesElement,
        ];
        $expectedResponse = new ListEntityTypesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setEntityTypes($entityTypes);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->featurestoreName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]');
        $response = $client->listEntityTypes($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getEntityTypes()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/ListEntityTypes', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listEntityTypesExceptionTest()
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
        $formattedParent = $client->featurestoreName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]');
        try {
            $client->listEntityTypes($formattedParent);
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
    public function listFeaturesTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $featuresElement = new Feature();
        $features = [
            $featuresElement,
        ];
        $expectedResponse = new ListFeaturesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setFeatures($features);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->entityTypeName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]');
        $response = $client->listFeatures($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getFeatures()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/ListFeatures', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listFeaturesExceptionTest()
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
        $formattedParent = $client->entityTypeName('[PROJECT]', '[LOCATION]', '[FEATURESTORE]', '[ENTITY_TYPE]');
        try {
            $client->listFeatures($formattedParent);
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
    public function listFeaturestoresTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $featurestoresElement = new Featurestore();
        $featurestores = [
            $featurestoresElement,
        ];
        $expectedResponse = new ListFeaturestoresResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setFeaturestores($featurestores);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $response = $client->listFeaturestores($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getFeaturestores()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/ListFeaturestores', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listFeaturestoresExceptionTest()
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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        try {
            $client->listFeaturestores($formattedParent);
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
    public function searchFeaturesTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $featuresElement = new Feature();
        $features = [
            $featuresElement,
        ];
        $expectedResponse = new SearchFeaturesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setFeatures($features);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedLocation = $client->locationName('[PROJECT]', '[LOCATION]');
        $response = $client->searchFeatures($formattedLocation);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getFeatures()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/SearchFeatures', $actualFuncCall);
        $actualValue = $actualRequestObject->getLocation();
        $this->assertProtobufEquals($formattedLocation, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function searchFeaturesExceptionTest()
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
        $formattedLocation = $client->locationName('[PROJECT]', '[LOCATION]');
        try {
            $client->searchFeatures($formattedLocation);
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
    public function updateEntityTypeTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $etag = 'etag3123477';
        $expectedResponse = new EntityType();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $entityType = new EntityType();
        $response = $client->updateEntityType($entityType);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/UpdateEntityType', $actualFuncCall);
        $actualValue = $actualRequestObject->getEntityType();
        $this->assertProtobufEquals($entityType, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function updateEntityTypeExceptionTest()
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
        $entityType = new EntityType();
        try {
            $client->updateEntityType($entityType);
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
    public function updateFeatureTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $etag = 'etag3123477';
        $disableMonitoring = false;
        $expectedResponse = new Feature();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setDisableMonitoring($disableMonitoring);
        $transport->addResponse($expectedResponse);
        // Mock request
        $feature = new Feature();
        $featureValueType = ValueType::VALUE_TYPE_UNSPECIFIED;
        $feature->setValueType($featureValueType);
        $response = $client->updateFeature($feature);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/UpdateFeature', $actualFuncCall);
        $actualValue = $actualRequestObject->getFeature();
        $this->assertProtobufEquals($feature, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function updateFeatureExceptionTest()
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
        $feature = new Feature();
        $featureValueType = ValueType::VALUE_TYPE_UNSPECIFIED;
        $feature->setValueType($featureValueType);
        try {
            $client->updateFeature($feature);
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
    public function updateFeaturestoreTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/updateFeaturestoreTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $etag = 'etag3123477';
        $expectedResponse = new Featurestore();
        $expectedResponse->setName($name);
        $expectedResponse->setEtag($etag);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/updateFeaturestoreTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $featurestore = new Featurestore();
        $featurestoreOnlineServingConfig = new OnlineServingConfig();
        $featurestore->setOnlineServingConfig($featurestoreOnlineServingConfig);
        $response = $client->updateFeaturestore($featurestore);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.FeaturestoreService/UpdateFeaturestore', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getFeaturestore();
        $this->assertProtobufEquals($featurestore, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateFeaturestoreTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function updateFeaturestoreExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/updateFeaturestoreTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $featurestore = new Featurestore();
        $featurestoreOnlineServingConfig = new OnlineServingConfig();
        $featurestore->setOnlineServingConfig($featurestoreOnlineServingConfig);
        $response = $client->updateFeaturestore($featurestore);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateFeaturestoreTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }
}
