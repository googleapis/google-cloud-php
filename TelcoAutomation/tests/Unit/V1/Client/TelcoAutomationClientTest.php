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

namespace Google\Cloud\TelcoAutomation\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\Cloud\TelcoAutomation\V1\ApplyDeploymentRequest;
use Google\Cloud\TelcoAutomation\V1\ApplyHydratedDeploymentRequest;
use Google\Cloud\TelcoAutomation\V1\ApproveBlueprintRequest;
use Google\Cloud\TelcoAutomation\V1\Blueprint;
use Google\Cloud\TelcoAutomation\V1\Client\TelcoAutomationClient;
use Google\Cloud\TelcoAutomation\V1\ComputeDeploymentStatusRequest;
use Google\Cloud\TelcoAutomation\V1\ComputeDeploymentStatusResponse;
use Google\Cloud\TelcoAutomation\V1\CreateBlueprintRequest;
use Google\Cloud\TelcoAutomation\V1\CreateDeploymentRequest;
use Google\Cloud\TelcoAutomation\V1\CreateEdgeSlmRequest;
use Google\Cloud\TelcoAutomation\V1\CreateOrchestrationClusterRequest;
use Google\Cloud\TelcoAutomation\V1\DeleteBlueprintRequest;
use Google\Cloud\TelcoAutomation\V1\DeleteEdgeSlmRequest;
use Google\Cloud\TelcoAutomation\V1\DeleteOrchestrationClusterRequest;
use Google\Cloud\TelcoAutomation\V1\Deployment;
use Google\Cloud\TelcoAutomation\V1\DiscardBlueprintChangesRequest;
use Google\Cloud\TelcoAutomation\V1\DiscardBlueprintChangesResponse;
use Google\Cloud\TelcoAutomation\V1\DiscardDeploymentChangesRequest;
use Google\Cloud\TelcoAutomation\V1\DiscardDeploymentChangesResponse;
use Google\Cloud\TelcoAutomation\V1\EdgeSlm;
use Google\Cloud\TelcoAutomation\V1\GetBlueprintRequest;
use Google\Cloud\TelcoAutomation\V1\GetDeploymentRequest;
use Google\Cloud\TelcoAutomation\V1\GetEdgeSlmRequest;
use Google\Cloud\TelcoAutomation\V1\GetHydratedDeploymentRequest;
use Google\Cloud\TelcoAutomation\V1\GetOrchestrationClusterRequest;
use Google\Cloud\TelcoAutomation\V1\GetPublicBlueprintRequest;
use Google\Cloud\TelcoAutomation\V1\HydratedDeployment;
use Google\Cloud\TelcoAutomation\V1\ListBlueprintRevisionsRequest;
use Google\Cloud\TelcoAutomation\V1\ListBlueprintRevisionsResponse;
use Google\Cloud\TelcoAutomation\V1\ListBlueprintsRequest;
use Google\Cloud\TelcoAutomation\V1\ListBlueprintsResponse;
use Google\Cloud\TelcoAutomation\V1\ListDeploymentRevisionsRequest;
use Google\Cloud\TelcoAutomation\V1\ListDeploymentRevisionsResponse;
use Google\Cloud\TelcoAutomation\V1\ListDeploymentsRequest;
use Google\Cloud\TelcoAutomation\V1\ListDeploymentsResponse;
use Google\Cloud\TelcoAutomation\V1\ListEdgeSlmsRequest;
use Google\Cloud\TelcoAutomation\V1\ListEdgeSlmsResponse;
use Google\Cloud\TelcoAutomation\V1\ListHydratedDeploymentsRequest;
use Google\Cloud\TelcoAutomation\V1\ListHydratedDeploymentsResponse;
use Google\Cloud\TelcoAutomation\V1\ListOrchestrationClustersRequest;
use Google\Cloud\TelcoAutomation\V1\ListOrchestrationClustersResponse;
use Google\Cloud\TelcoAutomation\V1\ListPublicBlueprintsRequest;
use Google\Cloud\TelcoAutomation\V1\ListPublicBlueprintsResponse;
use Google\Cloud\TelcoAutomation\V1\OrchestrationCluster;
use Google\Cloud\TelcoAutomation\V1\ProposeBlueprintRequest;
use Google\Cloud\TelcoAutomation\V1\PublicBlueprint;
use Google\Cloud\TelcoAutomation\V1\RejectBlueprintRequest;
use Google\Cloud\TelcoAutomation\V1\RemoveDeploymentRequest;
use Google\Cloud\TelcoAutomation\V1\RollbackDeploymentRequest;
use Google\Cloud\TelcoAutomation\V1\SearchBlueprintRevisionsRequest;
use Google\Cloud\TelcoAutomation\V1\SearchBlueprintRevisionsResponse;
use Google\Cloud\TelcoAutomation\V1\SearchDeploymentRevisionsRequest;
use Google\Cloud\TelcoAutomation\V1\SearchDeploymentRevisionsResponse;
use Google\Cloud\TelcoAutomation\V1\UpdateBlueprintRequest;
use Google\Cloud\TelcoAutomation\V1\UpdateDeploymentRequest;
use Google\Cloud\TelcoAutomation\V1\UpdateHydratedDeploymentRequest;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group telcoautomation
 *
 * @group gapic
 */
class TelcoAutomationClientTest extends GeneratedTest
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

    /** @return TelcoAutomationClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new TelcoAutomationClient($options);
    }

    /** @test */
    public function applyDeploymentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $revisionId = 'revisionId513861631';
        $sourceBlueprintRevision = 'sourceBlueprintRevision-1372328277';
        $displayName = 'displayName1615086568';
        $repository = 'repository1950800714';
        $sourceProvider = 'sourceProvider2074918293';
        $workloadCluster = 'workloadCluster531492146';
        $rollbackSupport = true;
        $expectedResponse = new Deployment();
        $expectedResponse->setName($name2);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setSourceBlueprintRevision($sourceBlueprintRevision);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setRepository($repository);
        $expectedResponse->setSourceProvider($sourceProvider);
        $expectedResponse->setWorkloadCluster($workloadCluster);
        $expectedResponse->setRollbackSupport($rollbackSupport);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->deploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]'
        );
        $request = (new ApplyDeploymentRequest())->setName($formattedName);
        $response = $gapicClient->applyDeployment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/ApplyDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function applyDeploymentExceptionTest()
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
        $formattedName = $gapicClient->deploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]'
        );
        $request = (new ApplyDeploymentRequest())->setName($formattedName);
        try {
            $gapicClient->applyDeployment($request);
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
    public function applyHydratedDeploymentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $workloadCluster = 'workloadCluster531492146';
        $expectedResponse = new HydratedDeployment();
        $expectedResponse->setName($name2);
        $expectedResponse->setWorkloadCluster($workloadCluster);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->hydratedDeploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]',
            '[HYDRATED_DEPLOYMENT]'
        );
        $request = (new ApplyHydratedDeploymentRequest())->setName($formattedName);
        $response = $gapicClient->applyHydratedDeployment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/ApplyHydratedDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function applyHydratedDeploymentExceptionTest()
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
        $formattedName = $gapicClient->hydratedDeploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]',
            '[HYDRATED_DEPLOYMENT]'
        );
        $request = (new ApplyHydratedDeploymentRequest())->setName($formattedName);
        try {
            $gapicClient->applyHydratedDeployment($request);
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
    public function approveBlueprintTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $revisionId = 'revisionId513861631';
        $sourceBlueprint = 'sourceBlueprint-1884166289';
        $displayName = 'displayName1615086568';
        $repository = 'repository1950800714';
        $sourceProvider = 'sourceProvider2074918293';
        $rollbackSupport = true;
        $expectedResponse = new Blueprint();
        $expectedResponse->setName($name2);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setSourceBlueprint($sourceBlueprint);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setRepository($repository);
        $expectedResponse->setSourceProvider($sourceProvider);
        $expectedResponse->setRollbackSupport($rollbackSupport);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->blueprintName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[BLUEPRINT]'
        );
        $request = (new ApproveBlueprintRequest())->setName($formattedName);
        $response = $gapicClient->approveBlueprint($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/ApproveBlueprint', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function approveBlueprintExceptionTest()
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
        $formattedName = $gapicClient->blueprintName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[BLUEPRINT]'
        );
        $request = (new ApproveBlueprintRequest())->setName($formattedName);
        try {
            $gapicClient->approveBlueprint($request);
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
    public function computeDeploymentStatusTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new ComputeDeploymentStatusResponse();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->deploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]'
        );
        $request = (new ComputeDeploymentStatusRequest())->setName($formattedName);
        $response = $gapicClient->computeDeploymentStatus($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/ComputeDeploymentStatus', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function computeDeploymentStatusExceptionTest()
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
        $formattedName = $gapicClient->deploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]'
        );
        $request = (new ComputeDeploymentStatusRequest())->setName($formattedName);
        try {
            $gapicClient->computeDeploymentStatus($request);
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
    public function createBlueprintTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $revisionId = 'revisionId513861631';
        $sourceBlueprint = 'sourceBlueprint-1884166289';
        $displayName = 'displayName1615086568';
        $repository = 'repository1950800714';
        $sourceProvider = 'sourceProvider2074918293';
        $rollbackSupport = true;
        $expectedResponse = new Blueprint();
        $expectedResponse->setName($name);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setSourceBlueprint($sourceBlueprint);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setRepository($repository);
        $expectedResponse->setSourceProvider($sourceProvider);
        $expectedResponse->setRollbackSupport($rollbackSupport);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->orchestrationClusterName('[PROJECT]', '[LOCATION]', '[ORCHESTRATION_CLUSTER]');
        $blueprint = new Blueprint();
        $blueprintSourceBlueprint = 'blueprintSourceBlueprint115443109';
        $blueprint->setSourceBlueprint($blueprintSourceBlueprint);
        $request = (new CreateBlueprintRequest())->setParent($formattedParent)->setBlueprint($blueprint);
        $response = $gapicClient->createBlueprint($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/CreateBlueprint', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getBlueprint();
        $this->assertProtobufEquals($blueprint, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createBlueprintExceptionTest()
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
        $formattedParent = $gapicClient->orchestrationClusterName('[PROJECT]', '[LOCATION]', '[ORCHESTRATION_CLUSTER]');
        $blueprint = new Blueprint();
        $blueprintSourceBlueprint = 'blueprintSourceBlueprint115443109';
        $blueprint->setSourceBlueprint($blueprintSourceBlueprint);
        $request = (new CreateBlueprintRequest())->setParent($formattedParent)->setBlueprint($blueprint);
        try {
            $gapicClient->createBlueprint($request);
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
    public function createDeploymentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $revisionId = 'revisionId513861631';
        $sourceBlueprintRevision = 'sourceBlueprintRevision-1372328277';
        $displayName = 'displayName1615086568';
        $repository = 'repository1950800714';
        $sourceProvider = 'sourceProvider2074918293';
        $workloadCluster = 'workloadCluster531492146';
        $rollbackSupport = true;
        $expectedResponse = new Deployment();
        $expectedResponse->setName($name);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setSourceBlueprintRevision($sourceBlueprintRevision);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setRepository($repository);
        $expectedResponse->setSourceProvider($sourceProvider);
        $expectedResponse->setWorkloadCluster($workloadCluster);
        $expectedResponse->setRollbackSupport($rollbackSupport);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->orchestrationClusterName('[PROJECT]', '[LOCATION]', '[ORCHESTRATION_CLUSTER]');
        $deployment = new Deployment();
        $deploymentSourceBlueprintRevision = 'deploymentSourceBlueprintRevision-1529084882';
        $deployment->setSourceBlueprintRevision($deploymentSourceBlueprintRevision);
        $request = (new CreateDeploymentRequest())->setParent($formattedParent)->setDeployment($deployment);
        $response = $gapicClient->createDeployment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/CreateDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getDeployment();
        $this->assertProtobufEquals($deployment, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createDeploymentExceptionTest()
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
        $formattedParent = $gapicClient->orchestrationClusterName('[PROJECT]', '[LOCATION]', '[ORCHESTRATION_CLUSTER]');
        $deployment = new Deployment();
        $deploymentSourceBlueprintRevision = 'deploymentSourceBlueprintRevision-1529084882';
        $deployment->setSourceBlueprintRevision($deploymentSourceBlueprintRevision);
        $request = (new CreateDeploymentRequest())->setParent($formattedParent)->setDeployment($deployment);
        try {
            $gapicClient->createDeployment($request);
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
    public function createEdgeSlmTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/createEdgeSlmTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $orchestrationCluster = 'orchestrationCluster-1006439940';
        $tnaVersion = 'tnaVersion1050832320';
        $expectedResponse = new EdgeSlm();
        $expectedResponse->setName($name);
        $expectedResponse->setOrchestrationCluster($orchestrationCluster);
        $expectedResponse->setTnaVersion($tnaVersion);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createEdgeSlmTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $edgeSlmId = 'edgeSlmId974932168';
        $edgeSlm = new EdgeSlm();
        $request = (new CreateEdgeSlmRequest())
            ->setParent($formattedParent)
            ->setEdgeSlmId($edgeSlmId)
            ->setEdgeSlm($edgeSlm);
        $response = $gapicClient->createEdgeSlm($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/CreateEdgeSlm', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getEdgeSlmId();
        $this->assertProtobufEquals($edgeSlmId, $actualValue);
        $actualValue = $actualApiRequestObject->getEdgeSlm();
        $this->assertProtobufEquals($edgeSlm, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createEdgeSlmTest');
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

    /** @test */
    public function createEdgeSlmExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/createEdgeSlmTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
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
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $edgeSlmId = 'edgeSlmId974932168';
        $edgeSlm = new EdgeSlm();
        $request = (new CreateEdgeSlmRequest())
            ->setParent($formattedParent)
            ->setEdgeSlmId($edgeSlmId)
            ->setEdgeSlm($edgeSlm);
        $response = $gapicClient->createEdgeSlm($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createEdgeSlmTest');
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

    /** @test */
    public function createOrchestrationClusterTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/createOrchestrationClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $tnaVersion = 'tnaVersion1050832320';
        $expectedResponse = new OrchestrationCluster();
        $expectedResponse->setName($name);
        $expectedResponse->setTnaVersion($tnaVersion);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createOrchestrationClusterTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $orchestrationClusterId = 'orchestrationClusterId314535486';
        $orchestrationCluster = new OrchestrationCluster();
        $request = (new CreateOrchestrationClusterRequest())
            ->setParent($formattedParent)
            ->setOrchestrationClusterId($orchestrationClusterId)
            ->setOrchestrationCluster($orchestrationCluster);
        $response = $gapicClient->createOrchestrationCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.telcoautomation.v1.TelcoAutomation/CreateOrchestrationCluster',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getOrchestrationClusterId();
        $this->assertProtobufEquals($orchestrationClusterId, $actualValue);
        $actualValue = $actualApiRequestObject->getOrchestrationCluster();
        $this->assertProtobufEquals($orchestrationCluster, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createOrchestrationClusterTest');
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

    /** @test */
    public function createOrchestrationClusterExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/createOrchestrationClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
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
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $orchestrationClusterId = 'orchestrationClusterId314535486';
        $orchestrationCluster = new OrchestrationCluster();
        $request = (new CreateOrchestrationClusterRequest())
            ->setParent($formattedParent)
            ->setOrchestrationClusterId($orchestrationClusterId)
            ->setOrchestrationCluster($orchestrationCluster);
        $response = $gapicClient->createOrchestrationCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createOrchestrationClusterTest');
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

    /** @test */
    public function deleteBlueprintTest()
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
        $formattedName = $gapicClient->blueprintName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[BLUEPRINT]'
        );
        $request = (new DeleteBlueprintRequest())->setName($formattedName);
        $gapicClient->deleteBlueprint($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/DeleteBlueprint', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteBlueprintExceptionTest()
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
        $formattedName = $gapicClient->blueprintName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[BLUEPRINT]'
        );
        $request = (new DeleteBlueprintRequest())->setName($formattedName);
        try {
            $gapicClient->deleteBlueprint($request);
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
    public function deleteEdgeSlmTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/deleteEdgeSlmTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteEdgeSlmTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->edgeSlmName('[PROJECT]', '[LOCATION]', '[EDGE_SLM]');
        $request = (new DeleteEdgeSlmRequest())->setName($formattedName);
        $response = $gapicClient->deleteEdgeSlm($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/DeleteEdgeSlm', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteEdgeSlmTest');
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

    /** @test */
    public function deleteEdgeSlmExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/deleteEdgeSlmTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
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
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->edgeSlmName('[PROJECT]', '[LOCATION]', '[EDGE_SLM]');
        $request = (new DeleteEdgeSlmRequest())->setName($formattedName);
        $response = $gapicClient->deleteEdgeSlm($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteEdgeSlmTest');
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

    /** @test */
    public function deleteOrchestrationClusterTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/deleteOrchestrationClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteOrchestrationClusterTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->orchestrationClusterName('[PROJECT]', '[LOCATION]', '[ORCHESTRATION_CLUSTER]');
        $request = (new DeleteOrchestrationClusterRequest())->setName($formattedName);
        $response = $gapicClient->deleteOrchestrationCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.telcoautomation.v1.TelcoAutomation/DeleteOrchestrationCluster',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteOrchestrationClusterTest');
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

    /** @test */
    public function deleteOrchestrationClusterExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/deleteOrchestrationClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
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
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->orchestrationClusterName('[PROJECT]', '[LOCATION]', '[ORCHESTRATION_CLUSTER]');
        $request = (new DeleteOrchestrationClusterRequest())->setName($formattedName);
        $response = $gapicClient->deleteOrchestrationCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteOrchestrationClusterTest');
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

    /** @test */
    public function discardBlueprintChangesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new DiscardBlueprintChangesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->blueprintName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[BLUEPRINT]'
        );
        $request = (new DiscardBlueprintChangesRequest())->setName($formattedName);
        $response = $gapicClient->discardBlueprintChanges($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/DiscardBlueprintChanges', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function discardBlueprintChangesExceptionTest()
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
        $formattedName = $gapicClient->blueprintName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[BLUEPRINT]'
        );
        $request = (new DiscardBlueprintChangesRequest())->setName($formattedName);
        try {
            $gapicClient->discardBlueprintChanges($request);
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
    public function discardDeploymentChangesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new DiscardDeploymentChangesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->deploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]'
        );
        $request = (new DiscardDeploymentChangesRequest())->setName($formattedName);
        $response = $gapicClient->discardDeploymentChanges($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/DiscardDeploymentChanges', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function discardDeploymentChangesExceptionTest()
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
        $formattedName = $gapicClient->deploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]'
        );
        $request = (new DiscardDeploymentChangesRequest())->setName($formattedName);
        try {
            $gapicClient->discardDeploymentChanges($request);
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
    public function getBlueprintTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $revisionId = 'revisionId513861631';
        $sourceBlueprint = 'sourceBlueprint-1884166289';
        $displayName = 'displayName1615086568';
        $repository = 'repository1950800714';
        $sourceProvider = 'sourceProvider2074918293';
        $rollbackSupport = true;
        $expectedResponse = new Blueprint();
        $expectedResponse->setName($name2);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setSourceBlueprint($sourceBlueprint);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setRepository($repository);
        $expectedResponse->setSourceProvider($sourceProvider);
        $expectedResponse->setRollbackSupport($rollbackSupport);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->blueprintName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[BLUEPRINT]'
        );
        $request = (new GetBlueprintRequest())->setName($formattedName);
        $response = $gapicClient->getBlueprint($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/GetBlueprint', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getBlueprintExceptionTest()
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
        $formattedName = $gapicClient->blueprintName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[BLUEPRINT]'
        );
        $request = (new GetBlueprintRequest())->setName($formattedName);
        try {
            $gapicClient->getBlueprint($request);
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
    public function getDeploymentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $revisionId = 'revisionId513861631';
        $sourceBlueprintRevision = 'sourceBlueprintRevision-1372328277';
        $displayName = 'displayName1615086568';
        $repository = 'repository1950800714';
        $sourceProvider = 'sourceProvider2074918293';
        $workloadCluster = 'workloadCluster531492146';
        $rollbackSupport = true;
        $expectedResponse = new Deployment();
        $expectedResponse->setName($name2);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setSourceBlueprintRevision($sourceBlueprintRevision);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setRepository($repository);
        $expectedResponse->setSourceProvider($sourceProvider);
        $expectedResponse->setWorkloadCluster($workloadCluster);
        $expectedResponse->setRollbackSupport($rollbackSupport);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->deploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]'
        );
        $request = (new GetDeploymentRequest())->setName($formattedName);
        $response = $gapicClient->getDeployment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/GetDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDeploymentExceptionTest()
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
        $formattedName = $gapicClient->deploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]'
        );
        $request = (new GetDeploymentRequest())->setName($formattedName);
        try {
            $gapicClient->getDeployment($request);
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
    public function getEdgeSlmTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $orchestrationCluster = 'orchestrationCluster-1006439940';
        $tnaVersion = 'tnaVersion1050832320';
        $expectedResponse = new EdgeSlm();
        $expectedResponse->setName($name2);
        $expectedResponse->setOrchestrationCluster($orchestrationCluster);
        $expectedResponse->setTnaVersion($tnaVersion);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->edgeSlmName('[PROJECT]', '[LOCATION]', '[EDGE_SLM]');
        $request = (new GetEdgeSlmRequest())->setName($formattedName);
        $response = $gapicClient->getEdgeSlm($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/GetEdgeSlm', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getEdgeSlmExceptionTest()
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
        $formattedName = $gapicClient->edgeSlmName('[PROJECT]', '[LOCATION]', '[EDGE_SLM]');
        $request = (new GetEdgeSlmRequest())->setName($formattedName);
        try {
            $gapicClient->getEdgeSlm($request);
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
    public function getHydratedDeploymentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $workloadCluster = 'workloadCluster531492146';
        $expectedResponse = new HydratedDeployment();
        $expectedResponse->setName($name2);
        $expectedResponse->setWorkloadCluster($workloadCluster);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->hydratedDeploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]',
            '[HYDRATED_DEPLOYMENT]'
        );
        $request = (new GetHydratedDeploymentRequest())->setName($formattedName);
        $response = $gapicClient->getHydratedDeployment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/GetHydratedDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getHydratedDeploymentExceptionTest()
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
        $formattedName = $gapicClient->hydratedDeploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]',
            '[HYDRATED_DEPLOYMENT]'
        );
        $request = (new GetHydratedDeploymentRequest())->setName($formattedName);
        try {
            $gapicClient->getHydratedDeployment($request);
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
    public function getOrchestrationClusterTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $tnaVersion = 'tnaVersion1050832320';
        $expectedResponse = new OrchestrationCluster();
        $expectedResponse->setName($name2);
        $expectedResponse->setTnaVersion($tnaVersion);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->orchestrationClusterName('[PROJECT]', '[LOCATION]', '[ORCHESTRATION_CLUSTER]');
        $request = (new GetOrchestrationClusterRequest())->setName($formattedName);
        $response = $gapicClient->getOrchestrationCluster($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/GetOrchestrationCluster', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getOrchestrationClusterExceptionTest()
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
        $formattedName = $gapicClient->orchestrationClusterName('[PROJECT]', '[LOCATION]', '[ORCHESTRATION_CLUSTER]');
        $request = (new GetOrchestrationClusterRequest())->setName($formattedName);
        try {
            $gapicClient->getOrchestrationCluster($request);
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
    public function getPublicBlueprintTest()
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
        $sourceProvider = 'sourceProvider2074918293';
        $rollbackSupport = true;
        $expectedResponse = new PublicBlueprint();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setSourceProvider($sourceProvider);
        $expectedResponse->setRollbackSupport($rollbackSupport);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->publicBlueprintName('[PROJECT]', '[LOCATION]', '[PUBLIC_LUEPRINT]');
        $request = (new GetPublicBlueprintRequest())->setName($formattedName);
        $response = $gapicClient->getPublicBlueprint($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/GetPublicBlueprint', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getPublicBlueprintExceptionTest()
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
        $formattedName = $gapicClient->publicBlueprintName('[PROJECT]', '[LOCATION]', '[PUBLIC_LUEPRINT]');
        $request = (new GetPublicBlueprintRequest())->setName($formattedName);
        try {
            $gapicClient->getPublicBlueprint($request);
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
    public function listBlueprintRevisionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $blueprintsElement = new Blueprint();
        $blueprints = [$blueprintsElement];
        $expectedResponse = new ListBlueprintRevisionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setBlueprints($blueprints);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->blueprintName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[BLUEPRINT]'
        );
        $request = (new ListBlueprintRevisionsRequest())->setName($formattedName);
        $response = $gapicClient->listBlueprintRevisions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getBlueprints()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/ListBlueprintRevisions', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listBlueprintRevisionsExceptionTest()
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
        $formattedName = $gapicClient->blueprintName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[BLUEPRINT]'
        );
        $request = (new ListBlueprintRevisionsRequest())->setName($formattedName);
        try {
            $gapicClient->listBlueprintRevisions($request);
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
    public function listBlueprintsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $blueprintsElement = new Blueprint();
        $blueprints = [$blueprintsElement];
        $expectedResponse = new ListBlueprintsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setBlueprints($blueprints);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->orchestrationClusterName('[PROJECT]', '[LOCATION]', '[ORCHESTRATION_CLUSTER]');
        $request = (new ListBlueprintsRequest())->setParent($formattedParent);
        $response = $gapicClient->listBlueprints($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getBlueprints()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/ListBlueprints', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listBlueprintsExceptionTest()
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
        $formattedParent = $gapicClient->orchestrationClusterName('[PROJECT]', '[LOCATION]', '[ORCHESTRATION_CLUSTER]');
        $request = (new ListBlueprintsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listBlueprints($request);
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
    public function listDeploymentRevisionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $deploymentsElement = new Deployment();
        $deployments = [$deploymentsElement];
        $expectedResponse = new ListDeploymentRevisionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDeployments($deployments);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->deploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]'
        );
        $request = (new ListDeploymentRevisionsRequest())->setName($formattedName);
        $response = $gapicClient->listDeploymentRevisions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDeployments()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/ListDeploymentRevisions', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDeploymentRevisionsExceptionTest()
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
        $formattedName = $gapicClient->deploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]'
        );
        $request = (new ListDeploymentRevisionsRequest())->setName($formattedName);
        try {
            $gapicClient->listDeploymentRevisions($request);
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
    public function listDeploymentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $deploymentsElement = new Deployment();
        $deployments = [$deploymentsElement];
        $expectedResponse = new ListDeploymentsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDeployments($deployments);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->orchestrationClusterName('[PROJECT]', '[LOCATION]', '[ORCHESTRATION_CLUSTER]');
        $request = (new ListDeploymentsRequest())->setParent($formattedParent);
        $response = $gapicClient->listDeployments($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDeployments()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/ListDeployments', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDeploymentsExceptionTest()
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
        $formattedParent = $gapicClient->orchestrationClusterName('[PROJECT]', '[LOCATION]', '[ORCHESTRATION_CLUSTER]');
        $request = (new ListDeploymentsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listDeployments($request);
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
    public function listEdgeSlmsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $edgeSlmsElement = new EdgeSlm();
        $edgeSlms = [$edgeSlmsElement];
        $expectedResponse = new ListEdgeSlmsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setEdgeSlms($edgeSlms);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListEdgeSlmsRequest())->setParent($formattedParent);
        $response = $gapicClient->listEdgeSlms($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getEdgeSlms()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/ListEdgeSlms', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listEdgeSlmsExceptionTest()
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
        $request = (new ListEdgeSlmsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listEdgeSlms($request);
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
    public function listHydratedDeploymentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $hydratedDeploymentsElement = new HydratedDeployment();
        $hydratedDeployments = [$hydratedDeploymentsElement];
        $expectedResponse = new ListHydratedDeploymentsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setHydratedDeployments($hydratedDeployments);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->deploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]'
        );
        $request = (new ListHydratedDeploymentsRequest())->setParent($formattedParent);
        $response = $gapicClient->listHydratedDeployments($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getHydratedDeployments()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/ListHydratedDeployments', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listHydratedDeploymentsExceptionTest()
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
        $formattedParent = $gapicClient->deploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]'
        );
        $request = (new ListHydratedDeploymentsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listHydratedDeployments($request);
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
    public function listOrchestrationClustersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $orchestrationClustersElement = new OrchestrationCluster();
        $orchestrationClusters = [$orchestrationClustersElement];
        $expectedResponse = new ListOrchestrationClustersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setOrchestrationClusters($orchestrationClusters);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListOrchestrationClustersRequest())->setParent($formattedParent);
        $response = $gapicClient->listOrchestrationClusters($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getOrchestrationClusters()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.telcoautomation.v1.TelcoAutomation/ListOrchestrationClusters',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listOrchestrationClustersExceptionTest()
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
        $request = (new ListOrchestrationClustersRequest())->setParent($formattedParent);
        try {
            $gapicClient->listOrchestrationClusters($request);
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
    public function listPublicBlueprintsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $publicBlueprintsElement = new PublicBlueprint();
        $publicBlueprints = [$publicBlueprintsElement];
        $expectedResponse = new ListPublicBlueprintsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setPublicBlueprints($publicBlueprints);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListPublicBlueprintsRequest())->setParent($formattedParent);
        $response = $gapicClient->listPublicBlueprints($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getPublicBlueprints()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/ListPublicBlueprints', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listPublicBlueprintsExceptionTest()
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
        $request = (new ListPublicBlueprintsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listPublicBlueprints($request);
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
    public function proposeBlueprintTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $revisionId = 'revisionId513861631';
        $sourceBlueprint = 'sourceBlueprint-1884166289';
        $displayName = 'displayName1615086568';
        $repository = 'repository1950800714';
        $sourceProvider = 'sourceProvider2074918293';
        $rollbackSupport = true;
        $expectedResponse = new Blueprint();
        $expectedResponse->setName($name2);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setSourceBlueprint($sourceBlueprint);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setRepository($repository);
        $expectedResponse->setSourceProvider($sourceProvider);
        $expectedResponse->setRollbackSupport($rollbackSupport);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->blueprintName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[BLUEPRINT]'
        );
        $request = (new ProposeBlueprintRequest())->setName($formattedName);
        $response = $gapicClient->proposeBlueprint($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/ProposeBlueprint', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function proposeBlueprintExceptionTest()
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
        $formattedName = $gapicClient->blueprintName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[BLUEPRINT]'
        );
        $request = (new ProposeBlueprintRequest())->setName($formattedName);
        try {
            $gapicClient->proposeBlueprint($request);
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
    public function rejectBlueprintTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $revisionId = 'revisionId513861631';
        $sourceBlueprint = 'sourceBlueprint-1884166289';
        $displayName = 'displayName1615086568';
        $repository = 'repository1950800714';
        $sourceProvider = 'sourceProvider2074918293';
        $rollbackSupport = true;
        $expectedResponse = new Blueprint();
        $expectedResponse->setName($name2);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setSourceBlueprint($sourceBlueprint);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setRepository($repository);
        $expectedResponse->setSourceProvider($sourceProvider);
        $expectedResponse->setRollbackSupport($rollbackSupport);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->blueprintName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[BLUEPRINT]'
        );
        $request = (new RejectBlueprintRequest())->setName($formattedName);
        $response = $gapicClient->rejectBlueprint($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/RejectBlueprint', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function rejectBlueprintExceptionTest()
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
        $formattedName = $gapicClient->blueprintName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[BLUEPRINT]'
        );
        $request = (new RejectBlueprintRequest())->setName($formattedName);
        try {
            $gapicClient->rejectBlueprint($request);
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
    public function removeDeploymentTest()
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
        $formattedName = $gapicClient->deploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]'
        );
        $request = (new RemoveDeploymentRequest())->setName($formattedName);
        $gapicClient->removeDeployment($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/RemoveDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function removeDeploymentExceptionTest()
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
        $formattedName = $gapicClient->deploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]'
        );
        $request = (new RemoveDeploymentRequest())->setName($formattedName);
        try {
            $gapicClient->removeDeployment($request);
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
    public function rollbackDeploymentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $revisionId2 = 'revisionId2-100208654';
        $sourceBlueprintRevision = 'sourceBlueprintRevision-1372328277';
        $displayName = 'displayName1615086568';
        $repository = 'repository1950800714';
        $sourceProvider = 'sourceProvider2074918293';
        $workloadCluster = 'workloadCluster531492146';
        $rollbackSupport = true;
        $expectedResponse = new Deployment();
        $expectedResponse->setName($name2);
        $expectedResponse->setRevisionId($revisionId2);
        $expectedResponse->setSourceBlueprintRevision($sourceBlueprintRevision);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setRepository($repository);
        $expectedResponse->setSourceProvider($sourceProvider);
        $expectedResponse->setWorkloadCluster($workloadCluster);
        $expectedResponse->setRollbackSupport($rollbackSupport);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->deploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]'
        );
        $revisionId = 'revisionId513861631';
        $request = (new RollbackDeploymentRequest())->setName($formattedName)->setRevisionId($revisionId);
        $response = $gapicClient->rollbackDeployment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/RollbackDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getRevisionId();
        $this->assertProtobufEquals($revisionId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function rollbackDeploymentExceptionTest()
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
        $formattedName = $gapicClient->deploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]'
        );
        $revisionId = 'revisionId513861631';
        $request = (new RollbackDeploymentRequest())->setName($formattedName)->setRevisionId($revisionId);
        try {
            $gapicClient->rollbackDeployment($request);
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
    public function searchBlueprintRevisionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $blueprintsElement = new Blueprint();
        $blueprints = [$blueprintsElement];
        $expectedResponse = new SearchBlueprintRevisionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setBlueprints($blueprints);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->orchestrationClusterName('[PROJECT]', '[LOCATION]', '[ORCHESTRATION_CLUSTER]');
        $query = 'query107944136';
        $request = (new SearchBlueprintRevisionsRequest())->setParent($formattedParent)->setQuery($query);
        $response = $gapicClient->searchBlueprintRevisions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getBlueprints()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/SearchBlueprintRevisions', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getQuery();
        $this->assertProtobufEquals($query, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchBlueprintRevisionsExceptionTest()
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
        $formattedParent = $gapicClient->orchestrationClusterName('[PROJECT]', '[LOCATION]', '[ORCHESTRATION_CLUSTER]');
        $query = 'query107944136';
        $request = (new SearchBlueprintRevisionsRequest())->setParent($formattedParent)->setQuery($query);
        try {
            $gapicClient->searchBlueprintRevisions($request);
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
    public function searchDeploymentRevisionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $deploymentsElement = new Deployment();
        $deployments = [$deploymentsElement];
        $expectedResponse = new SearchDeploymentRevisionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDeployments($deployments);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->orchestrationClusterName('[PROJECT]', '[LOCATION]', '[ORCHESTRATION_CLUSTER]');
        $query = 'query107944136';
        $request = (new SearchDeploymentRevisionsRequest())->setParent($formattedParent)->setQuery($query);
        $response = $gapicClient->searchDeploymentRevisions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDeployments()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.telcoautomation.v1.TelcoAutomation/SearchDeploymentRevisions',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getQuery();
        $this->assertProtobufEquals($query, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchDeploymentRevisionsExceptionTest()
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
        $formattedParent = $gapicClient->orchestrationClusterName('[PROJECT]', '[LOCATION]', '[ORCHESTRATION_CLUSTER]');
        $query = 'query107944136';
        $request = (new SearchDeploymentRevisionsRequest())->setParent($formattedParent)->setQuery($query);
        try {
            $gapicClient->searchDeploymentRevisions($request);
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
    public function updateBlueprintTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $revisionId = 'revisionId513861631';
        $sourceBlueprint = 'sourceBlueprint-1884166289';
        $displayName = 'displayName1615086568';
        $repository = 'repository1950800714';
        $sourceProvider = 'sourceProvider2074918293';
        $rollbackSupport = true;
        $expectedResponse = new Blueprint();
        $expectedResponse->setName($name);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setSourceBlueprint($sourceBlueprint);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setRepository($repository);
        $expectedResponse->setSourceProvider($sourceProvider);
        $expectedResponse->setRollbackSupport($rollbackSupport);
        $transport->addResponse($expectedResponse);
        // Mock request
        $blueprint = new Blueprint();
        $blueprintSourceBlueprint = 'blueprintSourceBlueprint115443109';
        $blueprint->setSourceBlueprint($blueprintSourceBlueprint);
        $updateMask = new FieldMask();
        $request = (new UpdateBlueprintRequest())->setBlueprint($blueprint)->setUpdateMask($updateMask);
        $response = $gapicClient->updateBlueprint($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/UpdateBlueprint', $actualFuncCall);
        $actualValue = $actualRequestObject->getBlueprint();
        $this->assertProtobufEquals($blueprint, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateBlueprintExceptionTest()
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
        $blueprint = new Blueprint();
        $blueprintSourceBlueprint = 'blueprintSourceBlueprint115443109';
        $blueprint->setSourceBlueprint($blueprintSourceBlueprint);
        $updateMask = new FieldMask();
        $request = (new UpdateBlueprintRequest())->setBlueprint($blueprint)->setUpdateMask($updateMask);
        try {
            $gapicClient->updateBlueprint($request);
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
    public function updateDeploymentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $revisionId = 'revisionId513861631';
        $sourceBlueprintRevision = 'sourceBlueprintRevision-1372328277';
        $displayName = 'displayName1615086568';
        $repository = 'repository1950800714';
        $sourceProvider = 'sourceProvider2074918293';
        $workloadCluster = 'workloadCluster531492146';
        $rollbackSupport = true;
        $expectedResponse = new Deployment();
        $expectedResponse->setName($name);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setSourceBlueprintRevision($sourceBlueprintRevision);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setRepository($repository);
        $expectedResponse->setSourceProvider($sourceProvider);
        $expectedResponse->setWorkloadCluster($workloadCluster);
        $expectedResponse->setRollbackSupport($rollbackSupport);
        $transport->addResponse($expectedResponse);
        // Mock request
        $deployment = new Deployment();
        $deploymentSourceBlueprintRevision = 'deploymentSourceBlueprintRevision-1529084882';
        $deployment->setSourceBlueprintRevision($deploymentSourceBlueprintRevision);
        $updateMask = new FieldMask();
        $request = (new UpdateDeploymentRequest())->setDeployment($deployment)->setUpdateMask($updateMask);
        $response = $gapicClient->updateDeployment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/UpdateDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getDeployment();
        $this->assertProtobufEquals($deployment, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateDeploymentExceptionTest()
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
        $deployment = new Deployment();
        $deploymentSourceBlueprintRevision = 'deploymentSourceBlueprintRevision-1529084882';
        $deployment->setSourceBlueprintRevision($deploymentSourceBlueprintRevision);
        $updateMask = new FieldMask();
        $request = (new UpdateDeploymentRequest())->setDeployment($deployment)->setUpdateMask($updateMask);
        try {
            $gapicClient->updateDeployment($request);
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
    public function updateHydratedDeploymentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $workloadCluster = 'workloadCluster531492146';
        $expectedResponse = new HydratedDeployment();
        $expectedResponse->setName($name);
        $expectedResponse->setWorkloadCluster($workloadCluster);
        $transport->addResponse($expectedResponse);
        // Mock request
        $hydratedDeployment = new HydratedDeployment();
        $updateMask = new FieldMask();
        $request = (new UpdateHydratedDeploymentRequest())
            ->setHydratedDeployment($hydratedDeployment)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateHydratedDeployment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/UpdateHydratedDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getHydratedDeployment();
        $this->assertProtobufEquals($hydratedDeployment, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateHydratedDeploymentExceptionTest()
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
        $hydratedDeployment = new HydratedDeployment();
        $updateMask = new FieldMask();
        $request = (new UpdateHydratedDeploymentRequest())
            ->setHydratedDeployment($hydratedDeployment)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateHydratedDeployment($request);
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
    public function applyDeploymentAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $revisionId = 'revisionId513861631';
        $sourceBlueprintRevision = 'sourceBlueprintRevision-1372328277';
        $displayName = 'displayName1615086568';
        $repository = 'repository1950800714';
        $sourceProvider = 'sourceProvider2074918293';
        $workloadCluster = 'workloadCluster531492146';
        $rollbackSupport = true;
        $expectedResponse = new Deployment();
        $expectedResponse->setName($name2);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setSourceBlueprintRevision($sourceBlueprintRevision);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setRepository($repository);
        $expectedResponse->setSourceProvider($sourceProvider);
        $expectedResponse->setWorkloadCluster($workloadCluster);
        $expectedResponse->setRollbackSupport($rollbackSupport);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->deploymentName(
            '[PROJECT]',
            '[LOCATION]',
            '[ORCHESTRATION_CLUSTER]',
            '[DEPLOYMENT]'
        );
        $request = (new ApplyDeploymentRequest())->setName($formattedName);
        $response = $gapicClient->applyDeploymentAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.telcoautomation.v1.TelcoAutomation/ApplyDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
