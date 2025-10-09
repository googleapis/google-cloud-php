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

namespace Google\Cloud\ApigeeRegistry\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Api\HttpBody;
use Google\Cloud\ApigeeRegistry\V1\Api;
use Google\Cloud\ApigeeRegistry\V1\ApiDeployment;
use Google\Cloud\ApigeeRegistry\V1\ApiSpec;
use Google\Cloud\ApigeeRegistry\V1\ApiVersion;
use Google\Cloud\ApigeeRegistry\V1\Artifact;
use Google\Cloud\ApigeeRegistry\V1\Client\RegistryClient;
use Google\Cloud\ApigeeRegistry\V1\CreateApiDeploymentRequest;
use Google\Cloud\ApigeeRegistry\V1\CreateApiRequest;
use Google\Cloud\ApigeeRegistry\V1\CreateApiSpecRequest;
use Google\Cloud\ApigeeRegistry\V1\CreateApiVersionRequest;
use Google\Cloud\ApigeeRegistry\V1\CreateArtifactRequest;
use Google\Cloud\ApigeeRegistry\V1\DeleteApiDeploymentRequest;
use Google\Cloud\ApigeeRegistry\V1\DeleteApiDeploymentRevisionRequest;
use Google\Cloud\ApigeeRegistry\V1\DeleteApiRequest;
use Google\Cloud\ApigeeRegistry\V1\DeleteApiSpecRequest;
use Google\Cloud\ApigeeRegistry\V1\DeleteApiSpecRevisionRequest;
use Google\Cloud\ApigeeRegistry\V1\DeleteApiVersionRequest;
use Google\Cloud\ApigeeRegistry\V1\DeleteArtifactRequest;
use Google\Cloud\ApigeeRegistry\V1\GetApiDeploymentRequest;
use Google\Cloud\ApigeeRegistry\V1\GetApiRequest;
use Google\Cloud\ApigeeRegistry\V1\GetApiSpecContentsRequest;
use Google\Cloud\ApigeeRegistry\V1\GetApiSpecRequest;
use Google\Cloud\ApigeeRegistry\V1\GetApiVersionRequest;
use Google\Cloud\ApigeeRegistry\V1\GetArtifactContentsRequest;
use Google\Cloud\ApigeeRegistry\V1\GetArtifactRequest;
use Google\Cloud\ApigeeRegistry\V1\ListApiDeploymentRevisionsRequest;
use Google\Cloud\ApigeeRegistry\V1\ListApiDeploymentRevisionsResponse;
use Google\Cloud\ApigeeRegistry\V1\ListApiDeploymentsRequest;
use Google\Cloud\ApigeeRegistry\V1\ListApiDeploymentsResponse;
use Google\Cloud\ApigeeRegistry\V1\ListApiSpecRevisionsRequest;
use Google\Cloud\ApigeeRegistry\V1\ListApiSpecRevisionsResponse;
use Google\Cloud\ApigeeRegistry\V1\ListApiSpecsRequest;
use Google\Cloud\ApigeeRegistry\V1\ListApiSpecsResponse;
use Google\Cloud\ApigeeRegistry\V1\ListApiVersionsRequest;
use Google\Cloud\ApigeeRegistry\V1\ListApiVersionsResponse;
use Google\Cloud\ApigeeRegistry\V1\ListApisRequest;
use Google\Cloud\ApigeeRegistry\V1\ListApisResponse;
use Google\Cloud\ApigeeRegistry\V1\ListArtifactsRequest;
use Google\Cloud\ApigeeRegistry\V1\ListArtifactsResponse;
use Google\Cloud\ApigeeRegistry\V1\ReplaceArtifactRequest;
use Google\Cloud\ApigeeRegistry\V1\RollbackApiDeploymentRequest;
use Google\Cloud\ApigeeRegistry\V1\RollbackApiSpecRequest;
use Google\Cloud\ApigeeRegistry\V1\TagApiDeploymentRevisionRequest;
use Google\Cloud\ApigeeRegistry\V1\TagApiSpecRevisionRequest;
use Google\Cloud\ApigeeRegistry\V1\UpdateApiDeploymentRequest;
use Google\Cloud\ApigeeRegistry\V1\UpdateApiRequest;
use Google\Cloud\ApigeeRegistry\V1\UpdateApiSpecRequest;
use Google\Cloud\ApigeeRegistry\V1\UpdateApiVersionRequest;
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsResponse;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group apigeeregistry
 *
 * @group gapic
 */
class RegistryClientTest extends GeneratedTest
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

    /** @return RegistryClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new RegistryClient($options);
    }

    /** @test */
    public function createApiTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $availability = 'availability1997542747';
        $recommendedVersion = 'recommendedVersion265230068';
        $recommendedDeployment = 'recommendedDeployment1339243305';
        $expectedResponse = new Api();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setAvailability($availability);
        $expectedResponse->setRecommendedVersion($recommendedVersion);
        $expectedResponse->setRecommendedDeployment($recommendedDeployment);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $api = new Api();
        $apiId = 'apiId-1411282592';
        $request = (new CreateApiRequest())
            ->setParent($formattedParent)
            ->setApi($api)
            ->setApiId($apiId);
        $response = $gapicClient->createApi($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/CreateApi', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getApi();
        $this->assertProtobufEquals($api, $actualValue);
        $actualValue = $actualRequestObject->getApiId();
        $this->assertProtobufEquals($apiId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createApiExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $api = new Api();
        $apiId = 'apiId-1411282592';
        $request = (new CreateApiRequest())
            ->setParent($formattedParent)
            ->setApi($api)
            ->setApiId($apiId);
        try {
            $gapicClient->createApi($request);
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
    public function createApiDeploymentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $revisionId = 'revisionId513861631';
        $apiSpecRevision = 'apiSpecRevision-1685452166';
        $endpointUri = 'endpointUri-850313278';
        $externalChannelUri = 'externalChannelUri-559177284';
        $intendedAudience = 'intendedAudience-1100067944';
        $accessGuidance = 'accessGuidance24590291';
        $expectedResponse = new ApiDeployment();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setApiSpecRevision($apiSpecRevision);
        $expectedResponse->setEndpointUri($endpointUri);
        $expectedResponse->setExternalChannelUri($externalChannelUri);
        $expectedResponse->setIntendedAudience($intendedAudience);
        $expectedResponse->setAccessGuidance($accessGuidance);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->apiName('[PROJECT]', '[LOCATION]', '[API]');
        $apiDeployment = new ApiDeployment();
        $apiDeploymentId = 'apiDeploymentId-276259984';
        $request = (new CreateApiDeploymentRequest())
            ->setParent($formattedParent)
            ->setApiDeployment($apiDeployment)
            ->setApiDeploymentId($apiDeploymentId);
        $response = $gapicClient->createApiDeployment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/CreateApiDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getApiDeployment();
        $this->assertProtobufEquals($apiDeployment, $actualValue);
        $actualValue = $actualRequestObject->getApiDeploymentId();
        $this->assertProtobufEquals($apiDeploymentId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createApiDeploymentExceptionTest()
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
        $formattedParent = $gapicClient->apiName('[PROJECT]', '[LOCATION]', '[API]');
        $apiDeployment = new ApiDeployment();
        $apiDeploymentId = 'apiDeploymentId-276259984';
        $request = (new CreateApiDeploymentRequest())
            ->setParent($formattedParent)
            ->setApiDeployment($apiDeployment)
            ->setApiDeploymentId($apiDeploymentId);
        try {
            $gapicClient->createApiDeployment($request);
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
    public function createApiSpecTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $filename = 'filename-734768633';
        $description = 'description-1724546052';
        $revisionId = 'revisionId513861631';
        $mimeType = 'mimeType-196041627';
        $sizeBytes = 1796325715;
        $hash = 'hash3195150';
        $sourceUri = 'sourceUri-1111107768';
        $contents = '26';
        $expectedResponse = new ApiSpec();
        $expectedResponse->setName($name);
        $expectedResponse->setFilename($filename);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setMimeType($mimeType);
        $expectedResponse->setSizeBytes($sizeBytes);
        $expectedResponse->setHash($hash);
        $expectedResponse->setSourceUri($sourceUri);
        $expectedResponse->setContents($contents);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->apiVersionName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]');
        $apiSpec = new ApiSpec();
        $apiSpecId = 'apiSpecId800293626';
        $request = (new CreateApiSpecRequest())
            ->setParent($formattedParent)
            ->setApiSpec($apiSpec)
            ->setApiSpecId($apiSpecId);
        $response = $gapicClient->createApiSpec($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/CreateApiSpec', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getApiSpec();
        $this->assertProtobufEquals($apiSpec, $actualValue);
        $actualValue = $actualRequestObject->getApiSpecId();
        $this->assertProtobufEquals($apiSpecId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createApiSpecExceptionTest()
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
        $formattedParent = $gapicClient->apiVersionName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]');
        $apiSpec = new ApiSpec();
        $apiSpecId = 'apiSpecId800293626';
        $request = (new CreateApiSpecRequest())
            ->setParent($formattedParent)
            ->setApiSpec($apiSpec)
            ->setApiSpecId($apiSpecId);
        try {
            $gapicClient->createApiSpec($request);
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
    public function createApiVersionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $state = 'state109757585';
        $expectedResponse = new ApiVersion();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setState($state);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->apiName('[PROJECT]', '[LOCATION]', '[API]');
        $apiVersion = new ApiVersion();
        $apiVersionId = 'apiVersionId790654247';
        $request = (new CreateApiVersionRequest())
            ->setParent($formattedParent)
            ->setApiVersion($apiVersion)
            ->setApiVersionId($apiVersionId);
        $response = $gapicClient->createApiVersion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/CreateApiVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getApiVersion();
        $this->assertProtobufEquals($apiVersion, $actualValue);
        $actualValue = $actualRequestObject->getApiVersionId();
        $this->assertProtobufEquals($apiVersionId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createApiVersionExceptionTest()
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
        $formattedParent = $gapicClient->apiName('[PROJECT]', '[LOCATION]', '[API]');
        $apiVersion = new ApiVersion();
        $apiVersionId = 'apiVersionId790654247';
        $request = (new CreateApiVersionRequest())
            ->setParent($formattedParent)
            ->setApiVersion($apiVersion)
            ->setApiVersionId($apiVersionId);
        try {
            $gapicClient->createApiVersion($request);
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
    public function createArtifactTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $mimeType = 'mimeType-196041627';
        $sizeBytes = 1796325715;
        $hash = 'hash3195150';
        $contents = '26';
        $expectedResponse = new Artifact();
        $expectedResponse->setName($name);
        $expectedResponse->setMimeType($mimeType);
        $expectedResponse->setSizeBytes($sizeBytes);
        $expectedResponse->setHash($hash);
        $expectedResponse->setContents($contents);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $artifact = new Artifact();
        $artifactId = 'artifactId-1130052952';
        $request = (new CreateArtifactRequest())
            ->setParent($formattedParent)
            ->setArtifact($artifact)
            ->setArtifactId($artifactId);
        $response = $gapicClient->createArtifact($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/CreateArtifact', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getArtifact();
        $this->assertProtobufEquals($artifact, $actualValue);
        $actualValue = $actualRequestObject->getArtifactId();
        $this->assertProtobufEquals($artifactId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createArtifactExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $artifact = new Artifact();
        $artifactId = 'artifactId-1130052952';
        $request = (new CreateArtifactRequest())
            ->setParent($formattedParent)
            ->setArtifact($artifact)
            ->setArtifactId($artifactId);
        try {
            $gapicClient->createArtifact($request);
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
    public function deleteApiTest()
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
        $formattedName = $gapicClient->apiName('[PROJECT]', '[LOCATION]', '[API]');
        $request = (new DeleteApiRequest())->setName($formattedName);
        $gapicClient->deleteApi($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/DeleteApi', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteApiExceptionTest()
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
        $formattedName = $gapicClient->apiName('[PROJECT]', '[LOCATION]', '[API]');
        $request = (new DeleteApiRequest())->setName($formattedName);
        try {
            $gapicClient->deleteApi($request);
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
    public function deleteApiDeploymentTest()
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
        $formattedName = $gapicClient->apiDeploymentName('[PROJECT]', '[LOCATION]', '[API]', '[DEPLOYMENT]');
        $request = (new DeleteApiDeploymentRequest())->setName($formattedName);
        $gapicClient->deleteApiDeployment($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/DeleteApiDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteApiDeploymentExceptionTest()
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
        $formattedName = $gapicClient->apiDeploymentName('[PROJECT]', '[LOCATION]', '[API]', '[DEPLOYMENT]');
        $request = (new DeleteApiDeploymentRequest())->setName($formattedName);
        try {
            $gapicClient->deleteApiDeployment($request);
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
    public function deleteApiDeploymentRevisionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $revisionId = 'revisionId513861631';
        $apiSpecRevision = 'apiSpecRevision-1685452166';
        $endpointUri = 'endpointUri-850313278';
        $externalChannelUri = 'externalChannelUri-559177284';
        $intendedAudience = 'intendedAudience-1100067944';
        $accessGuidance = 'accessGuidance24590291';
        $expectedResponse = new ApiDeployment();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setApiSpecRevision($apiSpecRevision);
        $expectedResponse->setEndpointUri($endpointUri);
        $expectedResponse->setExternalChannelUri($externalChannelUri);
        $expectedResponse->setIntendedAudience($intendedAudience);
        $expectedResponse->setAccessGuidance($accessGuidance);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->apiDeploymentName('[PROJECT]', '[LOCATION]', '[API]', '[DEPLOYMENT]');
        $request = (new DeleteApiDeploymentRevisionRequest())->setName($formattedName);
        $response = $gapicClient->deleteApiDeploymentRevision($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/DeleteApiDeploymentRevision', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteApiDeploymentRevisionExceptionTest()
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
        $formattedName = $gapicClient->apiDeploymentName('[PROJECT]', '[LOCATION]', '[API]', '[DEPLOYMENT]');
        $request = (new DeleteApiDeploymentRevisionRequest())->setName($formattedName);
        try {
            $gapicClient->deleteApiDeploymentRevision($request);
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
    public function deleteApiSpecTest()
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
        $formattedName = $gapicClient->apiSpecName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]', '[SPEC]');
        $request = (new DeleteApiSpecRequest())->setName($formattedName);
        $gapicClient->deleteApiSpec($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/DeleteApiSpec', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteApiSpecExceptionTest()
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
        $formattedName = $gapicClient->apiSpecName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]', '[SPEC]');
        $request = (new DeleteApiSpecRequest())->setName($formattedName);
        try {
            $gapicClient->deleteApiSpec($request);
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
    public function deleteApiSpecRevisionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $filename = 'filename-734768633';
        $description = 'description-1724546052';
        $revisionId = 'revisionId513861631';
        $mimeType = 'mimeType-196041627';
        $sizeBytes = 1796325715;
        $hash = 'hash3195150';
        $sourceUri = 'sourceUri-1111107768';
        $contents = '26';
        $expectedResponse = new ApiSpec();
        $expectedResponse->setName($name2);
        $expectedResponse->setFilename($filename);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setMimeType($mimeType);
        $expectedResponse->setSizeBytes($sizeBytes);
        $expectedResponse->setHash($hash);
        $expectedResponse->setSourceUri($sourceUri);
        $expectedResponse->setContents($contents);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->apiSpecName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]', '[SPEC]');
        $request = (new DeleteApiSpecRevisionRequest())->setName($formattedName);
        $response = $gapicClient->deleteApiSpecRevision($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/DeleteApiSpecRevision', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteApiSpecRevisionExceptionTest()
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
        $formattedName = $gapicClient->apiSpecName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]', '[SPEC]');
        $request = (new DeleteApiSpecRevisionRequest())->setName($formattedName);
        try {
            $gapicClient->deleteApiSpecRevision($request);
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
    public function deleteApiVersionTest()
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
        $formattedName = $gapicClient->apiVersionName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]');
        $request = (new DeleteApiVersionRequest())->setName($formattedName);
        $gapicClient->deleteApiVersion($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/DeleteApiVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteApiVersionExceptionTest()
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
        $formattedName = $gapicClient->apiVersionName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]');
        $request = (new DeleteApiVersionRequest())->setName($formattedName);
        try {
            $gapicClient->deleteApiVersion($request);
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
    public function deleteArtifactTest()
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
        $formattedName = $gapicClient->artifactName('[PROJECT]', '[LOCATION]', '[ARTIFACT]');
        $request = (new DeleteArtifactRequest())->setName($formattedName);
        $gapicClient->deleteArtifact($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/DeleteArtifact', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteArtifactExceptionTest()
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
        $formattedName = $gapicClient->artifactName('[PROJECT]', '[LOCATION]', '[ARTIFACT]');
        $request = (new DeleteArtifactRequest())->setName($formattedName);
        try {
            $gapicClient->deleteArtifact($request);
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
    public function getApiTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $availability = 'availability1997542747';
        $recommendedVersion = 'recommendedVersion265230068';
        $recommendedDeployment = 'recommendedDeployment1339243305';
        $expectedResponse = new Api();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setAvailability($availability);
        $expectedResponse->setRecommendedVersion($recommendedVersion);
        $expectedResponse->setRecommendedDeployment($recommendedDeployment);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->apiName('[PROJECT]', '[LOCATION]', '[API]');
        $request = (new GetApiRequest())->setName($formattedName);
        $response = $gapicClient->getApi($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/GetApi', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getApiExceptionTest()
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
        $formattedName = $gapicClient->apiName('[PROJECT]', '[LOCATION]', '[API]');
        $request = (new GetApiRequest())->setName($formattedName);
        try {
            $gapicClient->getApi($request);
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
    public function getApiDeploymentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $revisionId = 'revisionId513861631';
        $apiSpecRevision = 'apiSpecRevision-1685452166';
        $endpointUri = 'endpointUri-850313278';
        $externalChannelUri = 'externalChannelUri-559177284';
        $intendedAudience = 'intendedAudience-1100067944';
        $accessGuidance = 'accessGuidance24590291';
        $expectedResponse = new ApiDeployment();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setApiSpecRevision($apiSpecRevision);
        $expectedResponse->setEndpointUri($endpointUri);
        $expectedResponse->setExternalChannelUri($externalChannelUri);
        $expectedResponse->setIntendedAudience($intendedAudience);
        $expectedResponse->setAccessGuidance($accessGuidance);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->apiDeploymentName('[PROJECT]', '[LOCATION]', '[API]', '[DEPLOYMENT]');
        $request = (new GetApiDeploymentRequest())->setName($formattedName);
        $response = $gapicClient->getApiDeployment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/GetApiDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getApiDeploymentExceptionTest()
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
        $formattedName = $gapicClient->apiDeploymentName('[PROJECT]', '[LOCATION]', '[API]', '[DEPLOYMENT]');
        $request = (new GetApiDeploymentRequest())->setName($formattedName);
        try {
            $gapicClient->getApiDeployment($request);
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
    public function getApiSpecTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $filename = 'filename-734768633';
        $description = 'description-1724546052';
        $revisionId = 'revisionId513861631';
        $mimeType = 'mimeType-196041627';
        $sizeBytes = 1796325715;
        $hash = 'hash3195150';
        $sourceUri = 'sourceUri-1111107768';
        $contents = '26';
        $expectedResponse = new ApiSpec();
        $expectedResponse->setName($name2);
        $expectedResponse->setFilename($filename);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setMimeType($mimeType);
        $expectedResponse->setSizeBytes($sizeBytes);
        $expectedResponse->setHash($hash);
        $expectedResponse->setSourceUri($sourceUri);
        $expectedResponse->setContents($contents);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->apiSpecName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]', '[SPEC]');
        $request = (new GetApiSpecRequest())->setName($formattedName);
        $response = $gapicClient->getApiSpec($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/GetApiSpec', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getApiSpecExceptionTest()
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
        $formattedName = $gapicClient->apiSpecName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]', '[SPEC]');
        $request = (new GetApiSpecRequest())->setName($formattedName);
        try {
            $gapicClient->getApiSpec($request);
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
    public function getApiSpecContentsTest()
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
        $formattedName = $gapicClient->apiSpecName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]', '[SPEC]');
        $request = (new GetApiSpecContentsRequest())->setName($formattedName);
        $response = $gapicClient->getApiSpecContents($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/GetApiSpecContents', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getApiSpecContentsExceptionTest()
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
        $formattedName = $gapicClient->apiSpecName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]', '[SPEC]');
        $request = (new GetApiSpecContentsRequest())->setName($formattedName);
        try {
            $gapicClient->getApiSpecContents($request);
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
    public function getApiVersionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $state = 'state109757585';
        $expectedResponse = new ApiVersion();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setState($state);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->apiVersionName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]');
        $request = (new GetApiVersionRequest())->setName($formattedName);
        $response = $gapicClient->getApiVersion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/GetApiVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getApiVersionExceptionTest()
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
        $formattedName = $gapicClient->apiVersionName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]');
        $request = (new GetApiVersionRequest())->setName($formattedName);
        try {
            $gapicClient->getApiVersion($request);
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
    public function getArtifactTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $mimeType = 'mimeType-196041627';
        $sizeBytes = 1796325715;
        $hash = 'hash3195150';
        $contents = '26';
        $expectedResponse = new Artifact();
        $expectedResponse->setName($name2);
        $expectedResponse->setMimeType($mimeType);
        $expectedResponse->setSizeBytes($sizeBytes);
        $expectedResponse->setHash($hash);
        $expectedResponse->setContents($contents);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->artifactName('[PROJECT]', '[LOCATION]', '[ARTIFACT]');
        $request = (new GetArtifactRequest())->setName($formattedName);
        $response = $gapicClient->getArtifact($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/GetArtifact', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getArtifactExceptionTest()
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
        $formattedName = $gapicClient->artifactName('[PROJECT]', '[LOCATION]', '[ARTIFACT]');
        $request = (new GetArtifactRequest())->setName($formattedName);
        try {
            $gapicClient->getArtifact($request);
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
    public function getArtifactContentsTest()
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
        $formattedName = $gapicClient->artifactName('[PROJECT]', '[LOCATION]', '[ARTIFACT]');
        $request = (new GetArtifactContentsRequest())->setName($formattedName);
        $response = $gapicClient->getArtifactContents($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/GetArtifactContents', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getArtifactContentsExceptionTest()
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
        $formattedName = $gapicClient->artifactName('[PROJECT]', '[LOCATION]', '[ARTIFACT]');
        $request = (new GetArtifactContentsRequest())->setName($formattedName);
        try {
            $gapicClient->getArtifactContents($request);
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
    public function listApiDeploymentRevisionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $apiDeploymentsElement = new ApiDeployment();
        $apiDeployments = [$apiDeploymentsElement];
        $expectedResponse = new ListApiDeploymentRevisionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setApiDeployments($apiDeployments);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->apiDeploymentName('[PROJECT]', '[LOCATION]', '[API]', '[DEPLOYMENT]');
        $request = (new ListApiDeploymentRevisionsRequest())->setName($formattedName);
        $response = $gapicClient->listApiDeploymentRevisions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getApiDeployments()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/ListApiDeploymentRevisions', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listApiDeploymentRevisionsExceptionTest()
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
        $formattedName = $gapicClient->apiDeploymentName('[PROJECT]', '[LOCATION]', '[API]', '[DEPLOYMENT]');
        $request = (new ListApiDeploymentRevisionsRequest())->setName($formattedName);
        try {
            $gapicClient->listApiDeploymentRevisions($request);
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
    public function listApiDeploymentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $apiDeploymentsElement = new ApiDeployment();
        $apiDeployments = [$apiDeploymentsElement];
        $expectedResponse = new ListApiDeploymentsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setApiDeployments($apiDeployments);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->apiName('[PROJECT]', '[LOCATION]', '[API]');
        $request = (new ListApiDeploymentsRequest())->setParent($formattedParent);
        $response = $gapicClient->listApiDeployments($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getApiDeployments()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/ListApiDeployments', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listApiDeploymentsExceptionTest()
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
        $formattedParent = $gapicClient->apiName('[PROJECT]', '[LOCATION]', '[API]');
        $request = (new ListApiDeploymentsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listApiDeployments($request);
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
    public function listApiSpecRevisionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $apiSpecsElement = new ApiSpec();
        $apiSpecs = [$apiSpecsElement];
        $expectedResponse = new ListApiSpecRevisionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setApiSpecs($apiSpecs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->apiSpecName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]', '[SPEC]');
        $request = (new ListApiSpecRevisionsRequest())->setName($formattedName);
        $response = $gapicClient->listApiSpecRevisions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getApiSpecs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/ListApiSpecRevisions', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listApiSpecRevisionsExceptionTest()
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
        $formattedName = $gapicClient->apiSpecName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]', '[SPEC]');
        $request = (new ListApiSpecRevisionsRequest())->setName($formattedName);
        try {
            $gapicClient->listApiSpecRevisions($request);
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
    public function listApiSpecsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $apiSpecsElement = new ApiSpec();
        $apiSpecs = [$apiSpecsElement];
        $expectedResponse = new ListApiSpecsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setApiSpecs($apiSpecs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->apiVersionName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]');
        $request = (new ListApiSpecsRequest())->setParent($formattedParent);
        $response = $gapicClient->listApiSpecs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getApiSpecs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/ListApiSpecs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listApiSpecsExceptionTest()
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
        $formattedParent = $gapicClient->apiVersionName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]');
        $request = (new ListApiSpecsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listApiSpecs($request);
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
    public function listApiVersionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $apiVersionsElement = new ApiVersion();
        $apiVersions = [$apiVersionsElement];
        $expectedResponse = new ListApiVersionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setApiVersions($apiVersions);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->apiName('[PROJECT]', '[LOCATION]', '[API]');
        $request = (new ListApiVersionsRequest())->setParent($formattedParent);
        $response = $gapicClient->listApiVersions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getApiVersions()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/ListApiVersions', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listApiVersionsExceptionTest()
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
        $formattedParent = $gapicClient->apiName('[PROJECT]', '[LOCATION]', '[API]');
        $request = (new ListApiVersionsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listApiVersions($request);
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
    public function listApisTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $apisElement = new Api();
        $apis = [$apisElement];
        $expectedResponse = new ListApisResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setApis($apis);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListApisRequest())->setParent($formattedParent);
        $response = $gapicClient->listApis($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getApis()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/ListApis', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listApisExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListApisRequest())->setParent($formattedParent);
        try {
            $gapicClient->listApis($request);
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
    public function listArtifactsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $artifactsElement = new Artifact();
        $artifacts = [$artifactsElement];
        $expectedResponse = new ListArtifactsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setArtifacts($artifacts);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListArtifactsRequest())->setParent($formattedParent);
        $response = $gapicClient->listArtifacts($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getArtifacts()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/ListArtifacts', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listArtifactsExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListArtifactsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listArtifacts($request);
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
    public function replaceArtifactTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $mimeType = 'mimeType-196041627';
        $sizeBytes = 1796325715;
        $hash = 'hash3195150';
        $contents = '26';
        $expectedResponse = new Artifact();
        $expectedResponse->setName($name);
        $expectedResponse->setMimeType($mimeType);
        $expectedResponse->setSizeBytes($sizeBytes);
        $expectedResponse->setHash($hash);
        $expectedResponse->setContents($contents);
        $transport->addResponse($expectedResponse);
        // Mock request
        $artifact = new Artifact();
        $request = (new ReplaceArtifactRequest())->setArtifact($artifact);
        $response = $gapicClient->replaceArtifact($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/ReplaceArtifact', $actualFuncCall);
        $actualValue = $actualRequestObject->getArtifact();
        $this->assertProtobufEquals($artifact, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function replaceArtifactExceptionTest()
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
        $artifact = new Artifact();
        $request = (new ReplaceArtifactRequest())->setArtifact($artifact);
        try {
            $gapicClient->replaceArtifact($request);
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
    public function rollbackApiDeploymentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $revisionId2 = 'revisionId2-100208654';
        $apiSpecRevision = 'apiSpecRevision-1685452166';
        $endpointUri = 'endpointUri-850313278';
        $externalChannelUri = 'externalChannelUri-559177284';
        $intendedAudience = 'intendedAudience-1100067944';
        $accessGuidance = 'accessGuidance24590291';
        $expectedResponse = new ApiDeployment();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRevisionId($revisionId2);
        $expectedResponse->setApiSpecRevision($apiSpecRevision);
        $expectedResponse->setEndpointUri($endpointUri);
        $expectedResponse->setExternalChannelUri($externalChannelUri);
        $expectedResponse->setIntendedAudience($intendedAudience);
        $expectedResponse->setAccessGuidance($accessGuidance);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->apiDeploymentName('[PROJECT]', '[LOCATION]', '[API]', '[DEPLOYMENT]');
        $revisionId = 'revisionId513861631';
        $request = (new RollbackApiDeploymentRequest())->setName($formattedName)->setRevisionId($revisionId);
        $response = $gapicClient->rollbackApiDeployment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/RollbackApiDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getRevisionId();
        $this->assertProtobufEquals($revisionId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function rollbackApiDeploymentExceptionTest()
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
        $formattedName = $gapicClient->apiDeploymentName('[PROJECT]', '[LOCATION]', '[API]', '[DEPLOYMENT]');
        $revisionId = 'revisionId513861631';
        $request = (new RollbackApiDeploymentRequest())->setName($formattedName)->setRevisionId($revisionId);
        try {
            $gapicClient->rollbackApiDeployment($request);
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
    public function rollbackApiSpecTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $filename = 'filename-734768633';
        $description = 'description-1724546052';
        $revisionId2 = 'revisionId2-100208654';
        $mimeType = 'mimeType-196041627';
        $sizeBytes = 1796325715;
        $hash = 'hash3195150';
        $sourceUri = 'sourceUri-1111107768';
        $contents = '26';
        $expectedResponse = new ApiSpec();
        $expectedResponse->setName($name2);
        $expectedResponse->setFilename($filename);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRevisionId($revisionId2);
        $expectedResponse->setMimeType($mimeType);
        $expectedResponse->setSizeBytes($sizeBytes);
        $expectedResponse->setHash($hash);
        $expectedResponse->setSourceUri($sourceUri);
        $expectedResponse->setContents($contents);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->apiSpecName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]', '[SPEC]');
        $revisionId = 'revisionId513861631';
        $request = (new RollbackApiSpecRequest())->setName($formattedName)->setRevisionId($revisionId);
        $response = $gapicClient->rollbackApiSpec($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/RollbackApiSpec', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getRevisionId();
        $this->assertProtobufEquals($revisionId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function rollbackApiSpecExceptionTest()
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
        $formattedName = $gapicClient->apiSpecName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]', '[SPEC]');
        $revisionId = 'revisionId513861631';
        $request = (new RollbackApiSpecRequest())->setName($formattedName)->setRevisionId($revisionId);
        try {
            $gapicClient->rollbackApiSpec($request);
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
    public function tagApiDeploymentRevisionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $revisionId = 'revisionId513861631';
        $apiSpecRevision = 'apiSpecRevision-1685452166';
        $endpointUri = 'endpointUri-850313278';
        $externalChannelUri = 'externalChannelUri-559177284';
        $intendedAudience = 'intendedAudience-1100067944';
        $accessGuidance = 'accessGuidance24590291';
        $expectedResponse = new ApiDeployment();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setApiSpecRevision($apiSpecRevision);
        $expectedResponse->setEndpointUri($endpointUri);
        $expectedResponse->setExternalChannelUri($externalChannelUri);
        $expectedResponse->setIntendedAudience($intendedAudience);
        $expectedResponse->setAccessGuidance($accessGuidance);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->apiDeploymentName('[PROJECT]', '[LOCATION]', '[API]', '[DEPLOYMENT]');
        $tag = 'tag114586';
        $request = (new TagApiDeploymentRevisionRequest())->setName($formattedName)->setTag($tag);
        $response = $gapicClient->tagApiDeploymentRevision($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/TagApiDeploymentRevision', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getTag();
        $this->assertProtobufEquals($tag, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function tagApiDeploymentRevisionExceptionTest()
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
        $formattedName = $gapicClient->apiDeploymentName('[PROJECT]', '[LOCATION]', '[API]', '[DEPLOYMENT]');
        $tag = 'tag114586';
        $request = (new TagApiDeploymentRevisionRequest())->setName($formattedName)->setTag($tag);
        try {
            $gapicClient->tagApiDeploymentRevision($request);
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
    public function tagApiSpecRevisionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $filename = 'filename-734768633';
        $description = 'description-1724546052';
        $revisionId = 'revisionId513861631';
        $mimeType = 'mimeType-196041627';
        $sizeBytes = 1796325715;
        $hash = 'hash3195150';
        $sourceUri = 'sourceUri-1111107768';
        $contents = '26';
        $expectedResponse = new ApiSpec();
        $expectedResponse->setName($name2);
        $expectedResponse->setFilename($filename);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setMimeType($mimeType);
        $expectedResponse->setSizeBytes($sizeBytes);
        $expectedResponse->setHash($hash);
        $expectedResponse->setSourceUri($sourceUri);
        $expectedResponse->setContents($contents);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->apiSpecName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]', '[SPEC]');
        $tag = 'tag114586';
        $request = (new TagApiSpecRevisionRequest())->setName($formattedName)->setTag($tag);
        $response = $gapicClient->tagApiSpecRevision($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/TagApiSpecRevision', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getTag();
        $this->assertProtobufEquals($tag, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function tagApiSpecRevisionExceptionTest()
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
        $formattedName = $gapicClient->apiSpecName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]', '[SPEC]');
        $tag = 'tag114586';
        $request = (new TagApiSpecRevisionRequest())->setName($formattedName)->setTag($tag);
        try {
            $gapicClient->tagApiSpecRevision($request);
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
    public function updateApiTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $availability = 'availability1997542747';
        $recommendedVersion = 'recommendedVersion265230068';
        $recommendedDeployment = 'recommendedDeployment1339243305';
        $expectedResponse = new Api();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setAvailability($availability);
        $expectedResponse->setRecommendedVersion($recommendedVersion);
        $expectedResponse->setRecommendedDeployment($recommendedDeployment);
        $transport->addResponse($expectedResponse);
        // Mock request
        $api = new Api();
        $request = (new UpdateApiRequest())->setApi($api);
        $response = $gapicClient->updateApi($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/UpdateApi', $actualFuncCall);
        $actualValue = $actualRequestObject->getApi();
        $this->assertProtobufEquals($api, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateApiExceptionTest()
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
        $api = new Api();
        $request = (new UpdateApiRequest())->setApi($api);
        try {
            $gapicClient->updateApi($request);
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
    public function updateApiDeploymentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $revisionId = 'revisionId513861631';
        $apiSpecRevision = 'apiSpecRevision-1685452166';
        $endpointUri = 'endpointUri-850313278';
        $externalChannelUri = 'externalChannelUri-559177284';
        $intendedAudience = 'intendedAudience-1100067944';
        $accessGuidance = 'accessGuidance24590291';
        $expectedResponse = new ApiDeployment();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setApiSpecRevision($apiSpecRevision);
        $expectedResponse->setEndpointUri($endpointUri);
        $expectedResponse->setExternalChannelUri($externalChannelUri);
        $expectedResponse->setIntendedAudience($intendedAudience);
        $expectedResponse->setAccessGuidance($accessGuidance);
        $transport->addResponse($expectedResponse);
        // Mock request
        $apiDeployment = new ApiDeployment();
        $request = (new UpdateApiDeploymentRequest())->setApiDeployment($apiDeployment);
        $response = $gapicClient->updateApiDeployment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/UpdateApiDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getApiDeployment();
        $this->assertProtobufEquals($apiDeployment, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateApiDeploymentExceptionTest()
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
        $apiDeployment = new ApiDeployment();
        $request = (new UpdateApiDeploymentRequest())->setApiDeployment($apiDeployment);
        try {
            $gapicClient->updateApiDeployment($request);
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
    public function updateApiSpecTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $filename = 'filename-734768633';
        $description = 'description-1724546052';
        $revisionId = 'revisionId513861631';
        $mimeType = 'mimeType-196041627';
        $sizeBytes = 1796325715;
        $hash = 'hash3195150';
        $sourceUri = 'sourceUri-1111107768';
        $contents = '26';
        $expectedResponse = new ApiSpec();
        $expectedResponse->setName($name);
        $expectedResponse->setFilename($filename);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setMimeType($mimeType);
        $expectedResponse->setSizeBytes($sizeBytes);
        $expectedResponse->setHash($hash);
        $expectedResponse->setSourceUri($sourceUri);
        $expectedResponse->setContents($contents);
        $transport->addResponse($expectedResponse);
        // Mock request
        $apiSpec = new ApiSpec();
        $request = (new UpdateApiSpecRequest())->setApiSpec($apiSpec);
        $response = $gapicClient->updateApiSpec($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/UpdateApiSpec', $actualFuncCall);
        $actualValue = $actualRequestObject->getApiSpec();
        $this->assertProtobufEquals($apiSpec, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateApiSpecExceptionTest()
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
        $apiSpec = new ApiSpec();
        $request = (new UpdateApiSpecRequest())->setApiSpec($apiSpec);
        try {
            $gapicClient->updateApiSpec($request);
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
    public function updateApiVersionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $state = 'state109757585';
        $expectedResponse = new ApiVersion();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setState($state);
        $transport->addResponse($expectedResponse);
        // Mock request
        $apiVersion = new ApiVersion();
        $request = (new UpdateApiVersionRequest())->setApiVersion($apiVersion);
        $response = $gapicClient->updateApiVersion($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/UpdateApiVersion', $actualFuncCall);
        $actualValue = $actualRequestObject->getApiVersion();
        $this->assertProtobufEquals($apiVersion, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateApiVersionExceptionTest()
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
        $apiVersion = new ApiVersion();
        $request = (new UpdateApiVersionRequest())->setApiVersion($apiVersion);
        try {
            $gapicClient->updateApiVersion($request);
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
        $request = new GetLocationRequest();
        $response = $gapicClient->getLocation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.location.Locations/GetLocation', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
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
        $request = new GetLocationRequest();
        try {
            $gapicClient->getLocation($request);
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
        $locations = [$locationsElement];
        $expectedResponse = new ListLocationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setLocations($locations);
        $transport->addResponse($expectedResponse);
        $request = new ListLocationsRequest();
        $response = $gapicClient->listLocations($request);
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

    /** @test */
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
        $request = new ListLocationsRequest();
        try {
            $gapicClient->listLocations($request);
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
        $request = (new GetIamPolicyRequest())->setResource($resource);
        $response = $gapicClient->getIamPolicy($request);
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

    /** @test */
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
        $resource = 'resource-341064690';
        $request = (new GetIamPolicyRequest())->setResource($resource);
        try {
            $gapicClient->getIamPolicy($request);
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
        $request = (new SetIamPolicyRequest())->setResource($resource)->setPolicy($policy);
        $response = $gapicClient->setIamPolicy($request);
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

    /** @test */
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
        $resource = 'resource-341064690';
        $policy = new Policy();
        $request = (new SetIamPolicyRequest())->setResource($resource)->setPolicy($policy);
        try {
            $gapicClient->setIamPolicy($request);
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
        $request = (new TestIamPermissionsRequest())->setResource($resource)->setPermissions($permissions);
        $response = $gapicClient->testIamPermissions($request);
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

    /** @test */
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
        $resource = 'resource-341064690';
        $permissions = [];
        $request = (new TestIamPermissionsRequest())->setResource($resource)->setPermissions($permissions);
        try {
            $gapicClient->testIamPermissions($request);
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
    public function createApiAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $availability = 'availability1997542747';
        $recommendedVersion = 'recommendedVersion265230068';
        $recommendedDeployment = 'recommendedDeployment1339243305';
        $expectedResponse = new Api();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setAvailability($availability);
        $expectedResponse->setRecommendedVersion($recommendedVersion);
        $expectedResponse->setRecommendedDeployment($recommendedDeployment);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $api = new Api();
        $apiId = 'apiId-1411282592';
        $request = (new CreateApiRequest())
            ->setParent($formattedParent)
            ->setApi($api)
            ->setApiId($apiId);
        $response = $gapicClient->createApiAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeregistry.v1.Registry/CreateApi', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getApi();
        $this->assertProtobufEquals($api, $actualValue);
        $actualValue = $actualRequestObject->getApiId();
        $this->assertProtobufEquals($apiId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
