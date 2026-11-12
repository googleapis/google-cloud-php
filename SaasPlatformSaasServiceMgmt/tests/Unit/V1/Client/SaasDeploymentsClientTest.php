<?php
/*
 * Copyright 2026 Google LLC
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

namespace Google\Cloud\SaasPlatform\SaasServiceMgmt\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\Client\SaasDeploymentsClient;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\CreateReleaseRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\CreateSaasRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\CreateTenantRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\CreateUnitKindRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\CreateUnitOperationRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\CreateUnitRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\DeleteReleaseRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\DeleteSaasRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\DeleteTenantRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\DeleteUnitKindRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\DeleteUnitOperationRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\DeleteUnitRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\GetReleaseRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\GetSaasRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\GetTenantRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\GetUnitKindRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\GetUnitOperationRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\GetUnitRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\ListReleasesRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\ListReleasesResponse;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\ListSaasRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\ListSaasResponse;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\ListTenantsRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\ListTenantsResponse;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\ListUnitKindsRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\ListUnitKindsResponse;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\ListUnitOperationsRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\ListUnitOperationsResponse;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\ListUnitsRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\ListUnitsResponse;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\Release;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\Saas;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\Tenant;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\Unit;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\UnitKind;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\UnitOperation;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\UpdateReleaseRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\UpdateSaasRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\UpdateTenantRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\UpdateUnitKindRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\UpdateUnitOperationRequest;
use Google\Cloud\SaasPlatform\SaasServiceMgmt\V1\UpdateUnitRequest;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group saasservicemgmt
 *
 * @group gapic
 */
class SaasDeploymentsClientTest extends GeneratedTest
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

    /** @return SaasDeploymentsClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new SaasDeploymentsClient($options);
    }

    /** @test */
    public function createReleaseTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $unitKind = 'unitKind-472552081';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new Release();
        $expectedResponse->setName($name);
        $expectedResponse->setUnitKind($unitKind);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $releaseId = 'releaseId-1517127597';
        $release = new Release();
        $releaseUnitKind = $gapicClient->unitKindName('[PROJECT]', '[LOCATION]', '[UNIT_KIND]');
        $release->setUnitKind($releaseUnitKind);
        $request = (new CreateReleaseRequest())
            ->setParent($formattedParent)
            ->setReleaseId($releaseId)
            ->setRelease($release);
        $response = $gapicClient->createRelease($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/CreateRelease',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getReleaseId();
        $this->assertProtobufEquals($releaseId, $actualValue);
        $actualValue = $actualRequestObject->getRelease();
        $this->assertProtobufEquals($release, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createReleaseExceptionTest()
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
        $releaseId = 'releaseId-1517127597';
        $release = new Release();
        $releaseUnitKind = $gapicClient->unitKindName('[PROJECT]', '[LOCATION]', '[UNIT_KIND]');
        $release->setUnitKind($releaseUnitKind);
        $request = (new CreateReleaseRequest())
            ->setParent($formattedParent)
            ->setReleaseId($releaseId)
            ->setRelease($release);
        try {
            $gapicClient->createRelease($request);
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
    public function createSaasTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $blueprintRepo = 'blueprintRepo1625230750';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new Saas();
        $expectedResponse->setName($name);
        $expectedResponse->setBlueprintRepo($blueprintRepo);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $saasId = 'saasId1853838010';
        $saas = new Saas();
        $request = (new CreateSaasRequest())
            ->setParent($formattedParent)
            ->setSaasId($saasId)
            ->setSaas($saas);
        $response = $gapicClient->createSaas($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/CreateSaas', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getSaasId();
        $this->assertProtobufEquals($saasId, $actualValue);
        $actualValue = $actualRequestObject->getSaas();
        $this->assertProtobufEquals($saas, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createSaasExceptionTest()
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
        $saasId = 'saasId1853838010';
        $saas = new Saas();
        $request = (new CreateSaasRequest())
            ->setParent($formattedParent)
            ->setSaasId($saasId)
            ->setSaas($saas);
        try {
            $gapicClient->createSaas($request);
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
    public function createTenantTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $consumerResource = 'consumerResource-748779977';
        $saas = 'saas3522304';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new Tenant();
        $expectedResponse->setName($name);
        $expectedResponse->setConsumerResource($consumerResource);
        $expectedResponse->setSaas($saas);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $tenantId = 'tenantId-1852780336';
        $tenant = new Tenant();
        $tenantSaas = $gapicClient->saasName('[PROJECT]', '[LOCATION]', '[SAAS]');
        $tenant->setSaas($tenantSaas);
        $request = (new CreateTenantRequest())
            ->setParent($formattedParent)
            ->setTenantId($tenantId)
            ->setTenant($tenant);
        $response = $gapicClient->createTenant($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/CreateTenant',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getTenantId();
        $this->assertProtobufEquals($tenantId, $actualValue);
        $actualValue = $actualRequestObject->getTenant();
        $this->assertProtobufEquals($tenant, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createTenantExceptionTest()
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
        $tenantId = 'tenantId-1852780336';
        $tenant = new Tenant();
        $tenantSaas = $gapicClient->saasName('[PROJECT]', '[LOCATION]', '[SAAS]');
        $tenant->setSaas($tenantSaas);
        $request = (new CreateTenantRequest())
            ->setParent($formattedParent)
            ->setTenantId($tenantId)
            ->setTenant($tenant);
        try {
            $gapicClient->createTenant($request);
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
    public function createUnitTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $unitKind = 'unitKind-472552081';
        $release = 'release1090594823';
        $tenant = 'tenant-877336406';
        $application = 'application1554253136';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $satisfiesPzs = false;
        $satisfiesPzi = false;
        $expectedResponse = new Unit();
        $expectedResponse->setName($name);
        $expectedResponse->setUnitKind($unitKind);
        $expectedResponse->setRelease($release);
        $expectedResponse->setTenant($tenant);
        $expectedResponse->setApplication($application);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setSatisfiesPzs($satisfiesPzs);
        $expectedResponse->setSatisfiesPzi($satisfiesPzi);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $unitId = 'unitId-286525002';
        $unit = new Unit();
        $request = (new CreateUnitRequest())
            ->setParent($formattedParent)
            ->setUnitId($unitId)
            ->setUnit($unit);
        $response = $gapicClient->createUnit($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/CreateUnit', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getUnitId();
        $this->assertProtobufEquals($unitId, $actualValue);
        $actualValue = $actualRequestObject->getUnit();
        $this->assertProtobufEquals($unit, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createUnitExceptionTest()
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
        $unitId = 'unitId-286525002';
        $unit = new Unit();
        $request = (new CreateUnitRequest())
            ->setParent($formattedParent)
            ->setUnitId($unitId)
            ->setUnit($unit);
        try {
            $gapicClient->createUnit($request);
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
    public function createUnitKindTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $defaultRelease = 'defaultRelease1087296521';
        $saas = 'saas3522304';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new UnitKind();
        $expectedResponse->setName($name);
        $expectedResponse->setDefaultRelease($defaultRelease);
        $expectedResponse->setSaas($saas);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $unitKindId = 'unitKindId1103845867';
        $unitKind = new UnitKind();
        $unitKindSaas = $gapicClient->saasName('[PROJECT]', '[LOCATION]', '[SAAS]');
        $unitKind->setSaas($unitKindSaas);
        $request = (new CreateUnitKindRequest())
            ->setParent($formattedParent)
            ->setUnitKindId($unitKindId)
            ->setUnitKind($unitKind);
        $response = $gapicClient->createUnitKind($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/CreateUnitKind',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getUnitKindId();
        $this->assertProtobufEquals($unitKindId, $actualValue);
        $actualValue = $actualRequestObject->getUnitKind();
        $this->assertProtobufEquals($unitKind, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createUnitKindExceptionTest()
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
        $unitKindId = 'unitKindId1103845867';
        $unitKind = new UnitKind();
        $unitKindSaas = $gapicClient->saasName('[PROJECT]', '[LOCATION]', '[SAAS]');
        $unitKind->setSaas($unitKindSaas);
        $request = (new CreateUnitKindRequest())
            ->setParent($formattedParent)
            ->setUnitKindId($unitKindId)
            ->setUnitKind($unitKind);
        try {
            $gapicClient->createUnitKind($request);
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
    public function createUnitOperationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $unit = 'unit3594628';
        $parentUnitOperation = 'parentUnitOperation45174945';
        $rollout = 'rollout1377108401';
        $cancel = true;
        $engineState = 'engineState1194780756';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new UnitOperation();
        $expectedResponse->setName($name);
        $expectedResponse->setUnit($unit);
        $expectedResponse->setParentUnitOperation($parentUnitOperation);
        $expectedResponse->setRollout($rollout);
        $expectedResponse->setCancel($cancel);
        $expectedResponse->setEngineState($engineState);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $unitOperationId = 'unitOperationId1880520142';
        $unitOperation = new UnitOperation();
        $unitOperationUnit = $gapicClient->unitName('[PROJECT]', '[LOCATION]', '[UNIT]');
        $unitOperation->setUnit($unitOperationUnit);
        $request = (new CreateUnitOperationRequest())
            ->setParent($formattedParent)
            ->setUnitOperationId($unitOperationId)
            ->setUnitOperation($unitOperation);
        $response = $gapicClient->createUnitOperation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/CreateUnitOperation',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getUnitOperationId();
        $this->assertProtobufEquals($unitOperationId, $actualValue);
        $actualValue = $actualRequestObject->getUnitOperation();
        $this->assertProtobufEquals($unitOperation, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createUnitOperationExceptionTest()
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
        $unitOperationId = 'unitOperationId1880520142';
        $unitOperation = new UnitOperation();
        $unitOperationUnit = $gapicClient->unitName('[PROJECT]', '[LOCATION]', '[UNIT]');
        $unitOperation->setUnit($unitOperationUnit);
        $request = (new CreateUnitOperationRequest())
            ->setParent($formattedParent)
            ->setUnitOperationId($unitOperationId)
            ->setUnitOperation($unitOperation);
        try {
            $gapicClient->createUnitOperation($request);
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
    public function deleteReleaseTest()
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
        $formattedName = $gapicClient->releaseName('[PROJECT]', '[LOCATION]', '[RELEASE]');
        $request = (new DeleteReleaseRequest())->setName($formattedName);
        $gapicClient->deleteRelease($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/DeleteRelease',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteReleaseExceptionTest()
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
        $formattedName = $gapicClient->releaseName('[PROJECT]', '[LOCATION]', '[RELEASE]');
        $request = (new DeleteReleaseRequest())->setName($formattedName);
        try {
            $gapicClient->deleteRelease($request);
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
    public function deleteSaasTest()
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
        $formattedName = $gapicClient->saasName('[PROJECT]', '[LOCATION]', '[SAAS]');
        $request = (new DeleteSaasRequest())->setName($formattedName);
        $gapicClient->deleteSaas($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/DeleteSaas', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteSaasExceptionTest()
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
        $formattedName = $gapicClient->saasName('[PROJECT]', '[LOCATION]', '[SAAS]');
        $request = (new DeleteSaasRequest())->setName($formattedName);
        try {
            $gapicClient->deleteSaas($request);
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
    public function deleteTenantTest()
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
        $formattedName = $gapicClient->tenantName('[PROJECT]', '[LOCATION]', '[TENANT]');
        $request = (new DeleteTenantRequest())->setName($formattedName);
        $gapicClient->deleteTenant($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/DeleteTenant',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteTenantExceptionTest()
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
        $formattedName = $gapicClient->tenantName('[PROJECT]', '[LOCATION]', '[TENANT]');
        $request = (new DeleteTenantRequest())->setName($formattedName);
        try {
            $gapicClient->deleteTenant($request);
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
    public function deleteUnitTest()
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
        $formattedName = $gapicClient->unitName('[PROJECT]', '[LOCATION]', '[UNIT]');
        $request = (new DeleteUnitRequest())->setName($formattedName);
        $gapicClient->deleteUnit($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/DeleteUnit', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteUnitExceptionTest()
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
        $formattedName = $gapicClient->unitName('[PROJECT]', '[LOCATION]', '[UNIT]');
        $request = (new DeleteUnitRequest())->setName($formattedName);
        try {
            $gapicClient->deleteUnit($request);
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
    public function deleteUnitKindTest()
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
        $formattedName = $gapicClient->unitKindName('[PROJECT]', '[LOCATION]', '[UNIT_KIND]');
        $request = (new DeleteUnitKindRequest())->setName($formattedName);
        $gapicClient->deleteUnitKind($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/DeleteUnitKind',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteUnitKindExceptionTest()
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
        $formattedName = $gapicClient->unitKindName('[PROJECT]', '[LOCATION]', '[UNIT_KIND]');
        $request = (new DeleteUnitKindRequest())->setName($formattedName);
        try {
            $gapicClient->deleteUnitKind($request);
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
    public function deleteUnitOperationTest()
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
        $formattedName = $gapicClient->unitOperationName('[PROJECT]', '[LOCATION]', '[UNIT_OPERATION]');
        $request = (new DeleteUnitOperationRequest())->setName($formattedName);
        $gapicClient->deleteUnitOperation($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/DeleteUnitOperation',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteUnitOperationExceptionTest()
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
        $formattedName = $gapicClient->unitOperationName('[PROJECT]', '[LOCATION]', '[UNIT_OPERATION]');
        $request = (new DeleteUnitOperationRequest())->setName($formattedName);
        try {
            $gapicClient->deleteUnitOperation($request);
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
    public function getReleaseTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $unitKind = 'unitKind-472552081';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new Release();
        $expectedResponse->setName($name2);
        $expectedResponse->setUnitKind($unitKind);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->releaseName('[PROJECT]', '[LOCATION]', '[RELEASE]');
        $request = (new GetReleaseRequest())->setName($formattedName);
        $response = $gapicClient->getRelease($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/GetRelease', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getReleaseExceptionTest()
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
        $formattedName = $gapicClient->releaseName('[PROJECT]', '[LOCATION]', '[RELEASE]');
        $request = (new GetReleaseRequest())->setName($formattedName);
        try {
            $gapicClient->getRelease($request);
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
    public function getSaasTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $blueprintRepo = 'blueprintRepo1625230750';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new Saas();
        $expectedResponse->setName($name2);
        $expectedResponse->setBlueprintRepo($blueprintRepo);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->saasName('[PROJECT]', '[LOCATION]', '[SAAS]');
        $request = (new GetSaasRequest())->setName($formattedName);
        $response = $gapicClient->getSaas($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/GetSaas', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getSaasExceptionTest()
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
        $formattedName = $gapicClient->saasName('[PROJECT]', '[LOCATION]', '[SAAS]');
        $request = (new GetSaasRequest())->setName($formattedName);
        try {
            $gapicClient->getSaas($request);
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
    public function getTenantTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $consumerResource = 'consumerResource-748779977';
        $saas = 'saas3522304';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new Tenant();
        $expectedResponse->setName($name2);
        $expectedResponse->setConsumerResource($consumerResource);
        $expectedResponse->setSaas($saas);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->tenantName('[PROJECT]', '[LOCATION]', '[TENANT]');
        $request = (new GetTenantRequest())->setName($formattedName);
        $response = $gapicClient->getTenant($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/GetTenant', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTenantExceptionTest()
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
        $formattedName = $gapicClient->tenantName('[PROJECT]', '[LOCATION]', '[TENANT]');
        $request = (new GetTenantRequest())->setName($formattedName);
        try {
            $gapicClient->getTenant($request);
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
    public function getUnitTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $unitKind = 'unitKind-472552081';
        $release = 'release1090594823';
        $tenant = 'tenant-877336406';
        $application = 'application1554253136';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $satisfiesPzs = false;
        $satisfiesPzi = false;
        $expectedResponse = new Unit();
        $expectedResponse->setName($name2);
        $expectedResponse->setUnitKind($unitKind);
        $expectedResponse->setRelease($release);
        $expectedResponse->setTenant($tenant);
        $expectedResponse->setApplication($application);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setSatisfiesPzs($satisfiesPzs);
        $expectedResponse->setSatisfiesPzi($satisfiesPzi);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->unitName('[PROJECT]', '[LOCATION]', '[UNIT]');
        $request = (new GetUnitRequest())->setName($formattedName);
        $response = $gapicClient->getUnit($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/GetUnit', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getUnitExceptionTest()
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
        $formattedName = $gapicClient->unitName('[PROJECT]', '[LOCATION]', '[UNIT]');
        $request = (new GetUnitRequest())->setName($formattedName);
        try {
            $gapicClient->getUnit($request);
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
    public function getUnitKindTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $defaultRelease = 'defaultRelease1087296521';
        $saas = 'saas3522304';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new UnitKind();
        $expectedResponse->setName($name2);
        $expectedResponse->setDefaultRelease($defaultRelease);
        $expectedResponse->setSaas($saas);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->unitKindName('[PROJECT]', '[LOCATION]', '[UNIT_KIND]');
        $request = (new GetUnitKindRequest())->setName($formattedName);
        $response = $gapicClient->getUnitKind($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/GetUnitKind', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getUnitKindExceptionTest()
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
        $formattedName = $gapicClient->unitKindName('[PROJECT]', '[LOCATION]', '[UNIT_KIND]');
        $request = (new GetUnitKindRequest())->setName($formattedName);
        try {
            $gapicClient->getUnitKind($request);
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
    public function getUnitOperationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $unit = 'unit3594628';
        $parentUnitOperation = 'parentUnitOperation45174945';
        $rollout = 'rollout1377108401';
        $cancel = true;
        $engineState = 'engineState1194780756';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new UnitOperation();
        $expectedResponse->setName($name2);
        $expectedResponse->setUnit($unit);
        $expectedResponse->setParentUnitOperation($parentUnitOperation);
        $expectedResponse->setRollout($rollout);
        $expectedResponse->setCancel($cancel);
        $expectedResponse->setEngineState($engineState);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->unitOperationName('[PROJECT]', '[LOCATION]', '[UNIT_OPERATION]');
        $request = (new GetUnitOperationRequest())->setName($formattedName);
        $response = $gapicClient->getUnitOperation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/GetUnitOperation',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getUnitOperationExceptionTest()
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
        $formattedName = $gapicClient->unitOperationName('[PROJECT]', '[LOCATION]', '[UNIT_OPERATION]');
        $request = (new GetUnitOperationRequest())->setName($formattedName);
        try {
            $gapicClient->getUnitOperation($request);
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
    public function listReleasesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $releasesElement = new Release();
        $releases = [$releasesElement];
        $expectedResponse = new ListReleasesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setReleases($releases);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListReleasesRequest())->setParent($formattedParent);
        $response = $gapicClient->listReleases($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getReleases()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/ListReleases',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listReleasesExceptionTest()
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
        $request = (new ListReleasesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listReleases($request);
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
    public function listSaasTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $saasElement = new Saas();
        $saas = [$saasElement];
        $expectedResponse = new ListSaasResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSaas($saas);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListSaasRequest())->setParent($formattedParent);
        $response = $gapicClient->listSaas($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getSaas()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/ListSaas', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listSaasExceptionTest()
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
        $request = (new ListSaasRequest())->setParent($formattedParent);
        try {
            $gapicClient->listSaas($request);
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
    public function listTenantsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $tenantsElement = new Tenant();
        $tenants = [$tenantsElement];
        $expectedResponse = new ListTenantsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTenants($tenants);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListTenantsRequest())->setParent($formattedParent);
        $response = $gapicClient->listTenants($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTenants()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/ListTenants', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTenantsExceptionTest()
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
        $request = (new ListTenantsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listTenants($request);
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
    public function listUnitKindsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $unitKindsElement = new UnitKind();
        $unitKinds = [$unitKindsElement];
        $expectedResponse = new ListUnitKindsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setUnitKinds($unitKinds);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListUnitKindsRequest())->setParent($formattedParent);
        $response = $gapicClient->listUnitKinds($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getUnitKinds()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/ListUnitKinds',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listUnitKindsExceptionTest()
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
        $request = (new ListUnitKindsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listUnitKinds($request);
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
    public function listUnitOperationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $unitOperationsElement = new UnitOperation();
        $unitOperations = [$unitOperationsElement];
        $expectedResponse = new ListUnitOperationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setUnitOperations($unitOperations);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListUnitOperationsRequest())->setParent($formattedParent);
        $response = $gapicClient->listUnitOperations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getUnitOperations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/ListUnitOperations',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listUnitOperationsExceptionTest()
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
        $request = (new ListUnitOperationsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listUnitOperations($request);
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
    public function listUnitsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $unitsElement = new Unit();
        $units = [$unitsElement];
        $expectedResponse = new ListUnitsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setUnits($units);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListUnitsRequest())->setParent($formattedParent);
        $response = $gapicClient->listUnits($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getUnits()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/ListUnits', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listUnitsExceptionTest()
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
        $request = (new ListUnitsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listUnits($request);
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
    public function updateReleaseTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $unitKind = 'unitKind-472552081';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new Release();
        $expectedResponse->setName($name);
        $expectedResponse->setUnitKind($unitKind);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $release = new Release();
        $releaseUnitKind = $gapicClient->unitKindName('[PROJECT]', '[LOCATION]', '[UNIT_KIND]');
        $release->setUnitKind($releaseUnitKind);
        $request = (new UpdateReleaseRequest())->setRelease($release);
        $response = $gapicClient->updateRelease($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/UpdateRelease',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getRelease();
        $this->assertProtobufEquals($release, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateReleaseExceptionTest()
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
        $release = new Release();
        $releaseUnitKind = $gapicClient->unitKindName('[PROJECT]', '[LOCATION]', '[UNIT_KIND]');
        $release->setUnitKind($releaseUnitKind);
        $request = (new UpdateReleaseRequest())->setRelease($release);
        try {
            $gapicClient->updateRelease($request);
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
    public function updateSaasTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $blueprintRepo = 'blueprintRepo1625230750';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new Saas();
        $expectedResponse->setName($name);
        $expectedResponse->setBlueprintRepo($blueprintRepo);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $saas = new Saas();
        $request = (new UpdateSaasRequest())->setSaas($saas);
        $response = $gapicClient->updateSaas($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/UpdateSaas', $actualFuncCall);
        $actualValue = $actualRequestObject->getSaas();
        $this->assertProtobufEquals($saas, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateSaasExceptionTest()
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
        $saas = new Saas();
        $request = (new UpdateSaasRequest())->setSaas($saas);
        try {
            $gapicClient->updateSaas($request);
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
    public function updateTenantTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $consumerResource = 'consumerResource-748779977';
        $saas = 'saas3522304';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new Tenant();
        $expectedResponse->setName($name);
        $expectedResponse->setConsumerResource($consumerResource);
        $expectedResponse->setSaas($saas);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $tenant = new Tenant();
        $tenantSaas = $gapicClient->saasName('[PROJECT]', '[LOCATION]', '[SAAS]');
        $tenant->setSaas($tenantSaas);
        $request = (new UpdateTenantRequest())->setTenant($tenant);
        $response = $gapicClient->updateTenant($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/UpdateTenant',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getTenant();
        $this->assertProtobufEquals($tenant, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateTenantExceptionTest()
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
        $tenant = new Tenant();
        $tenantSaas = $gapicClient->saasName('[PROJECT]', '[LOCATION]', '[SAAS]');
        $tenant->setSaas($tenantSaas);
        $request = (new UpdateTenantRequest())->setTenant($tenant);
        try {
            $gapicClient->updateTenant($request);
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
    public function updateUnitTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $unitKind = 'unitKind-472552081';
        $release = 'release1090594823';
        $tenant = 'tenant-877336406';
        $application = 'application1554253136';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $satisfiesPzs = false;
        $satisfiesPzi = false;
        $expectedResponse = new Unit();
        $expectedResponse->setName($name);
        $expectedResponse->setUnitKind($unitKind);
        $expectedResponse->setRelease($release);
        $expectedResponse->setTenant($tenant);
        $expectedResponse->setApplication($application);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setSatisfiesPzs($satisfiesPzs);
        $expectedResponse->setSatisfiesPzi($satisfiesPzi);
        $transport->addResponse($expectedResponse);
        // Mock request
        $unit = new Unit();
        $request = (new UpdateUnitRequest())->setUnit($unit);
        $response = $gapicClient->updateUnit($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/UpdateUnit', $actualFuncCall);
        $actualValue = $actualRequestObject->getUnit();
        $this->assertProtobufEquals($unit, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateUnitExceptionTest()
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
        $unit = new Unit();
        $request = (new UpdateUnitRequest())->setUnit($unit);
        try {
            $gapicClient->updateUnit($request);
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
    public function updateUnitKindTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $defaultRelease = 'defaultRelease1087296521';
        $saas = 'saas3522304';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new UnitKind();
        $expectedResponse->setName($name);
        $expectedResponse->setDefaultRelease($defaultRelease);
        $expectedResponse->setSaas($saas);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $unitKind = new UnitKind();
        $unitKindSaas = $gapicClient->saasName('[PROJECT]', '[LOCATION]', '[SAAS]');
        $unitKind->setSaas($unitKindSaas);
        $request = (new UpdateUnitKindRequest())->setUnitKind($unitKind);
        $response = $gapicClient->updateUnitKind($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/UpdateUnitKind',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getUnitKind();
        $this->assertProtobufEquals($unitKind, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateUnitKindExceptionTest()
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
        $unitKind = new UnitKind();
        $unitKindSaas = $gapicClient->saasName('[PROJECT]', '[LOCATION]', '[SAAS]');
        $unitKind->setSaas($unitKindSaas);
        $request = (new UpdateUnitKindRequest())->setUnitKind($unitKind);
        try {
            $gapicClient->updateUnitKind($request);
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
    public function updateUnitOperationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $unit = 'unit3594628';
        $parentUnitOperation = 'parentUnitOperation45174945';
        $rollout = 'rollout1377108401';
        $cancel = true;
        $engineState = 'engineState1194780756';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new UnitOperation();
        $expectedResponse->setName($name);
        $expectedResponse->setUnit($unit);
        $expectedResponse->setParentUnitOperation($parentUnitOperation);
        $expectedResponse->setRollout($rollout);
        $expectedResponse->setCancel($cancel);
        $expectedResponse->setEngineState($engineState);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $unitOperation = new UnitOperation();
        $unitOperationUnit = $gapicClient->unitName('[PROJECT]', '[LOCATION]', '[UNIT]');
        $unitOperation->setUnit($unitOperationUnit);
        $request = (new UpdateUnitOperationRequest())->setUnitOperation($unitOperation);
        $response = $gapicClient->updateUnitOperation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/UpdateUnitOperation',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getUnitOperation();
        $this->assertProtobufEquals($unitOperation, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateUnitOperationExceptionTest()
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
        $unitOperation = new UnitOperation();
        $unitOperationUnit = $gapicClient->unitName('[PROJECT]', '[LOCATION]', '[UNIT]');
        $unitOperation->setUnit($unitOperationUnit);
        $request = (new UpdateUnitOperationRequest())->setUnitOperation($unitOperation);
        try {
            $gapicClient->updateUnitOperation($request);
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
    public function createReleaseAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $unitKind = 'unitKind-472552081';
        $uid = 'uid115792';
        $etag = 'etag3123477';
        $expectedResponse = new Release();
        $expectedResponse->setName($name);
        $expectedResponse->setUnitKind($unitKind);
        $expectedResponse->setUid($uid);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $releaseId = 'releaseId-1517127597';
        $release = new Release();
        $releaseUnitKind = $gapicClient->unitKindName('[PROJECT]', '[LOCATION]', '[UNIT_KIND]');
        $release->setUnitKind($releaseUnitKind);
        $request = (new CreateReleaseRequest())
            ->setParent($formattedParent)
            ->setReleaseId($releaseId)
            ->setRelease($release);
        $response = $gapicClient->createReleaseAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments/CreateRelease',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getReleaseId();
        $this->assertProtobufEquals($releaseId, $actualValue);
        $actualValue = $actualRequestObject->getRelease();
        $this->assertProtobufEquals($release, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
