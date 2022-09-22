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
use Google\Api\HttpBody;

use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\AIPlatform\V1\ExplainResponse;
use Google\Cloud\AIPlatform\V1\PredictionServiceClient;
use Google\Cloud\AIPlatform\V1\PredictResponse;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\TestIamPermissionsResponse;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\Rpc\Code;
use stdClass;

/**
 * @group aiplatform
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
    public function explainTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $deployedModelId2 = 'deployedModelId2-380204163';
        $expectedResponse = new ExplainResponse();
        $expectedResponse->setDeployedModelId($deployedModelId2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedEndpoint = $gapicClient->endpointName('[PROJECT]', '[LOCATION]', '[ENDPOINT]');
        $instances = [];
        $response = $gapicClient->explain($formattedEndpoint, $instances);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.PredictionService/Explain', $actualFuncCall);
        $actualValue = $actualRequestObject->getEndpoint();
        $this->assertProtobufEquals($formattedEndpoint, $actualValue);
        $actualValue = $actualRequestObject->getInstances();
        $this->assertProtobufEquals($instances, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function explainExceptionTest()
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
        $formattedEndpoint = $gapicClient->endpointName('[PROJECT]', '[LOCATION]', '[ENDPOINT]');
        $instances = [];
        try {
            $gapicClient->explain($formattedEndpoint, $instances);
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

    /**
     * @test
     */
    public function predictTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $deployedModelId = 'deployedModelId866642506';
        $model = 'model104069929';
        $modelVersionId = 'modelVersionId-1385431880';
        $modelDisplayName = 'modelDisplayName1757732158';
        $expectedResponse = new PredictResponse();
        $expectedResponse->setDeployedModelId($deployedModelId);
        $expectedResponse->setModel($model);
        $expectedResponse->setModelVersionId($modelVersionId);
        $expectedResponse->setModelDisplayName($modelDisplayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedEndpoint = $gapicClient->endpointName('[PROJECT]', '[LOCATION]', '[ENDPOINT]');
        $instances = [];
        $response = $gapicClient->predict($formattedEndpoint, $instances);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.PredictionService/Predict', $actualFuncCall);
        $actualValue = $actualRequestObject->getEndpoint();
        $this->assertProtobufEquals($formattedEndpoint, $actualValue);
        $actualValue = $actualRequestObject->getInstances();
        $this->assertProtobufEquals($instances, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function predictExceptionTest()
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
        $formattedEndpoint = $gapicClient->endpointName('[PROJECT]', '[LOCATION]', '[ENDPOINT]');
        $instances = [];
        try {
            $gapicClient->predict($formattedEndpoint, $instances);
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

    /**
     * @test
     */
    public function rawPredictTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $contentType = 'contentType831846208';
        $data = '-86';
        $expectedResponse = new HttpBody();
        $expectedResponse->setContentType($contentType);
        $expectedResponse->setData($data);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedEndpoint = $gapicClient->endpointName('[PROJECT]', '[LOCATION]', '[ENDPOINT]');
        $response = $gapicClient->rawPredict($formattedEndpoint);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.PredictionService/RawPredict', $actualFuncCall);
        $actualValue = $actualRequestObject->getEndpoint();
        $this->assertProtobufEquals($formattedEndpoint, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function rawPredictExceptionTest()
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
        $formattedEndpoint = $gapicClient->endpointName('[PROJECT]', '[LOCATION]', '[ENDPOINT]');
        try {
            $gapicClient->rawPredict($formattedEndpoint);
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

    /**
     * @test
     */
    public function getLocationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $locationId = 'locationId552319461';
        $displayName = 'displayName1615086568';
        $expectedResponse = new Location();
        $expectedResponse->setName($name2);
        $expectedResponse->setLocationId($locationId);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->getLocation();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.location.Locations/GetLocation', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getLocationExceptionTest()
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
        try {
            $gapicClient->getLocation();
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

    /**
     * @test
     */
    public function listLocationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $locationsElement = new Location();
        $locations = [
            $locationsElement,
        ];
        $expectedResponse = new ListLocationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setLocations($locations);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->listLocations();
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getLocations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.location.Locations/ListLocations', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listLocationsExceptionTest()
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
        try {
            $gapicClient->listLocations();
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

    /**
     * @test
     */
    public function getIamPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $version = 351608024;
        $etag = '21';
        $expectedResponse = new Policy();
        $expectedResponse->setVersion($version);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $resource = 'resource-341064690';
        $response = $gapicClient->getIamPolicy($resource);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.iam.v1.IAMPolicy/GetIamPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getIamPolicyExceptionTest()
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
        $resource = 'resource-341064690';
        try {
            $gapicClient->getIamPolicy($resource);
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

    /**
     * @test
     */
    public function setIamPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $version = 351608024;
        $etag = '21';
        $expectedResponse = new Policy();
        $expectedResponse->setVersion($version);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $resource = 'resource-341064690';
        $policy = new Policy();
        $response = $gapicClient->setIamPolicy($resource, $policy);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.iam.v1.IAMPolicy/SetIamPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $actualValue = $actualRequestObject->getPolicy();
        $this->assertProtobufEquals($policy, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function setIamPolicyExceptionTest()
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
        $resource = 'resource-341064690';
        $policy = new Policy();
        try {
            $gapicClient->setIamPolicy($resource, $policy);
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

    /**
     * @test
     */
    public function testIamPermissionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new TestIamPermissionsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $resource = 'resource-341064690';
        $permissions = [];
        $response = $gapicClient->testIamPermissions($resource, $permissions);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.iam.v1.IAMPolicy/TestIamPermissions', $actualFuncCall);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $actualValue = $actualRequestObject->getPermissions();
        $this->assertProtobufEquals($permissions, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function testIamPermissionsExceptionTest()
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
        $resource = 'resource-341064690';
        $permissions = [];
        try {
            $gapicClient->testIamPermissions($resource, $permissions);
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
}
