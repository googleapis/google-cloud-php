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

namespace Google\Cloud\Compute\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Compute\V1\AbandonInstancesRegionInstanceGroupManagerRequest;
use Google\Cloud\Compute\V1\ApplyUpdatesToInstancesRegionInstanceGroupManagerRequest;
use Google\Cloud\Compute\V1\Client\RegionInstanceGroupManagersClient;
use Google\Cloud\Compute\V1\Client\RegionOperationsClient;
use Google\Cloud\Compute\V1\CreateInstancesRegionInstanceGroupManagerRequest;
use Google\Cloud\Compute\V1\DeleteInstancesRegionInstanceGroupManagerRequest;
use Google\Cloud\Compute\V1\DeletePerInstanceConfigsRegionInstanceGroupManagerRequest;
use Google\Cloud\Compute\V1\DeleteRegionInstanceGroupManagerRequest;
use Google\Cloud\Compute\V1\GetRegionInstanceGroupManagerRequest;
use Google\Cloud\Compute\V1\GetRegionOperationRequest;
use Google\Cloud\Compute\V1\InsertRegionInstanceGroupManagerRequest;
use Google\Cloud\Compute\V1\InstanceGroupManager;
use Google\Cloud\Compute\V1\InstanceManagedByIgmError;
use Google\Cloud\Compute\V1\ListErrorsRegionInstanceGroupManagersRequest;
use Google\Cloud\Compute\V1\ListManagedInstancesRegionInstanceGroupManagersRequest;
use Google\Cloud\Compute\V1\ListPerInstanceConfigsRegionInstanceGroupManagersRequest;
use Google\Cloud\Compute\V1\ListRegionInstanceGroupManagersRequest;
use Google\Cloud\Compute\V1\ManagedInstance;
use Google\Cloud\Compute\V1\Operation;
use Google\Cloud\Compute\V1\Operation\Status;
use Google\Cloud\Compute\V1\PatchPerInstanceConfigsRegionInstanceGroupManagerRequest;
use Google\Cloud\Compute\V1\PatchRegionInstanceGroupManagerRequest;
use Google\Cloud\Compute\V1\PerInstanceConfig;
use Google\Cloud\Compute\V1\RecreateInstancesRegionInstanceGroupManagerRequest;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagerDeleteInstanceConfigReq;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagerList;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagerPatchInstanceConfigReq;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagerUpdateInstanceConfigReq;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagersAbandonInstancesRequest;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagersApplyUpdatesRequest;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagersCreateInstancesRequest;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagersDeleteInstancesRequest;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagersListErrorsResponse;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagersListInstanceConfigsResp;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagersListInstancesResponse;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagersRecreateRequest;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagersResumeInstancesRequest;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagersSetTargetPoolsRequest;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagersSetTemplateRequest;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagersStartInstancesRequest;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagersStopInstancesRequest;
use Google\Cloud\Compute\V1\RegionInstanceGroupManagersSuspendInstancesRequest;
use Google\Cloud\Compute\V1\ResizeRegionInstanceGroupManagerRequest;
use Google\Cloud\Compute\V1\ResumeInstancesRegionInstanceGroupManagerRequest;
use Google\Cloud\Compute\V1\SetInstanceTemplateRegionInstanceGroupManagerRequest;
use Google\Cloud\Compute\V1\SetTargetPoolsRegionInstanceGroupManagerRequest;
use Google\Cloud\Compute\V1\StartInstancesRegionInstanceGroupManagerRequest;
use Google\Cloud\Compute\V1\StopInstancesRegionInstanceGroupManagerRequest;
use Google\Cloud\Compute\V1\SuspendInstancesRegionInstanceGroupManagerRequest;
use Google\Cloud\Compute\V1\UpdatePerInstanceConfigsRegionInstanceGroupManagerRequest;
use Google\Rpc\Code;
use stdClass;

/**
 * @group compute
 *
 * @group gapic
 */
class RegionInstanceGroupManagersClientTest extends GeneratedTest
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

    /** @return RegionInstanceGroupManagersClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new RegionInstanceGroupManagersClient($options);
    }

    /** @test */
    public function abandonInstancesTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/abandonInstancesTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/abandonInstancesTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersAbandonInstancesRequestResource = new RegionInstanceGroupManagersAbandonInstancesRequest();
        $request = (new AbandonInstancesRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersAbandonInstancesRequestResource($regionInstanceGroupManagersAbandonInstancesRequestResource);
        $response = $gapicClient->abandonInstances($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/AbandonInstances', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualApiRequestObject->getRegionInstanceGroupManagersAbandonInstancesRequestResource();
        $this->assertProtobufEquals($regionInstanceGroupManagersAbandonInstancesRequestResource, $actualValue);
        $expectedOperationsRequestObject = new GetRegionOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setRegion($region);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function abandonInstancesExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/abandonInstancesExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersAbandonInstancesRequestResource = new RegionInstanceGroupManagersAbandonInstancesRequest();
        $request = (new AbandonInstancesRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersAbandonInstancesRequestResource($regionInstanceGroupManagersAbandonInstancesRequestResource);
        $response = $gapicClient->abandonInstances($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
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
    public function applyUpdatesToInstancesTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/applyUpdatesToInstancesTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/applyUpdatesToInstancesTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersApplyUpdatesRequestResource = new RegionInstanceGroupManagersApplyUpdatesRequest();
        $request = (new ApplyUpdatesToInstancesRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersApplyUpdatesRequestResource($regionInstanceGroupManagersApplyUpdatesRequestResource);
        $response = $gapicClient->applyUpdatesToInstances($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/ApplyUpdatesToInstances', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualApiRequestObject->getRegionInstanceGroupManagersApplyUpdatesRequestResource();
        $this->assertProtobufEquals($regionInstanceGroupManagersApplyUpdatesRequestResource, $actualValue);
        $expectedOperationsRequestObject = new GetRegionOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setRegion($region);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function applyUpdatesToInstancesExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/applyUpdatesToInstancesExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersApplyUpdatesRequestResource = new RegionInstanceGroupManagersApplyUpdatesRequest();
        $request = (new ApplyUpdatesToInstancesRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersApplyUpdatesRequestResource($regionInstanceGroupManagersApplyUpdatesRequestResource);
        $response = $gapicClient->applyUpdatesToInstances($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
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
    public function createInstancesTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/createInstancesTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/createInstancesTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersCreateInstancesRequestResource = new RegionInstanceGroupManagersCreateInstancesRequest();
        $request = (new CreateInstancesRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersCreateInstancesRequestResource($regionInstanceGroupManagersCreateInstancesRequestResource);
        $response = $gapicClient->createInstances($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/CreateInstances', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualApiRequestObject->getRegionInstanceGroupManagersCreateInstancesRequestResource();
        $this->assertProtobufEquals($regionInstanceGroupManagersCreateInstancesRequestResource, $actualValue);
        $expectedOperationsRequestObject = new GetRegionOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setRegion($region);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function createInstancesExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/createInstancesExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersCreateInstancesRequestResource = new RegionInstanceGroupManagersCreateInstancesRequest();
        $request = (new CreateInstancesRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersCreateInstancesRequestResource($regionInstanceGroupManagersCreateInstancesRequestResource);
        $response = $gapicClient->createInstances($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
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
    public function deleteTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/deleteTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/deleteTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $request = (new DeleteRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region);
        $response = $gapicClient->delete($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/Delete', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $expectedOperationsRequestObject = new GetRegionOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setRegion($region);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function deleteExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/deleteExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $request = (new DeleteRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region);
        $response = $gapicClient->delete($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
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
    public function deleteInstancesTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/deleteInstancesTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/deleteInstancesTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersDeleteInstancesRequestResource = new RegionInstanceGroupManagersDeleteInstancesRequest();
        $request = (new DeleteInstancesRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersDeleteInstancesRequestResource($regionInstanceGroupManagersDeleteInstancesRequestResource);
        $response = $gapicClient->deleteInstances($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/DeleteInstances', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualApiRequestObject->getRegionInstanceGroupManagersDeleteInstancesRequestResource();
        $this->assertProtobufEquals($regionInstanceGroupManagersDeleteInstancesRequestResource, $actualValue);
        $expectedOperationsRequestObject = new GetRegionOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setRegion($region);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function deleteInstancesExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/deleteInstancesExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersDeleteInstancesRequestResource = new RegionInstanceGroupManagersDeleteInstancesRequest();
        $request = (new DeleteInstancesRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersDeleteInstancesRequestResource($regionInstanceGroupManagersDeleteInstancesRequestResource);
        $response = $gapicClient->deleteInstances($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
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
    public function deletePerInstanceConfigsTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/deletePerInstanceConfigsTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/deletePerInstanceConfigsTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagerDeleteInstanceConfigReqResource = new RegionInstanceGroupManagerDeleteInstanceConfigReq();
        $request = (new DeletePerInstanceConfigsRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagerDeleteInstanceConfigReqResource($regionInstanceGroupManagerDeleteInstanceConfigReqResource);
        $response = $gapicClient->deletePerInstanceConfigs($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/DeletePerInstanceConfigs', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualApiRequestObject->getRegionInstanceGroupManagerDeleteInstanceConfigReqResource();
        $this->assertProtobufEquals($regionInstanceGroupManagerDeleteInstanceConfigReqResource, $actualValue);
        $expectedOperationsRequestObject = new GetRegionOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setRegion($region);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function deletePerInstanceConfigsExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/deletePerInstanceConfigsExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagerDeleteInstanceConfigReqResource = new RegionInstanceGroupManagerDeleteInstanceConfigReq();
        $request = (new DeletePerInstanceConfigsRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagerDeleteInstanceConfigReqResource($regionInstanceGroupManagerDeleteInstanceConfigReqResource);
        $response = $gapicClient->deletePerInstanceConfigs($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
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
    public function getTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $baseInstanceName = 'baseInstanceName389106439';
        $creationTimestamp = 'creationTimestamp567396278';
        $description = 'description-1724546052';
        $fingerprint = 'fingerprint-1375934236';
        $id = 3355;
        $instanceGroup = 'instanceGroup81095253';
        $instanceTemplate = 'instanceTemplate309248228';
        $kind = 'kind3292052';
        $listManagedInstancesResults = 'listManagedInstancesResults832918068';
        $name = 'name3373707';
        $region2 = 'region2-690338393';
        $satisfiesPzi = false;
        $satisfiesPzs = false;
        $selfLink = 'selfLink-1691268851';
        $targetSize = 2084603409;
        $targetStoppedSize = 1613032225;
        $targetSuspendedSize = 765655981;
        $zone = 'zone3744684';
        $expectedResponse = new InstanceGroupManager();
        $expectedResponse->setBaseInstanceName($baseInstanceName);
        $expectedResponse->setCreationTimestamp($creationTimestamp);
        $expectedResponse->setDescription($description);
        $expectedResponse->setFingerprint($fingerprint);
        $expectedResponse->setId($id);
        $expectedResponse->setInstanceGroup($instanceGroup);
        $expectedResponse->setInstanceTemplate($instanceTemplate);
        $expectedResponse->setKind($kind);
        $expectedResponse->setListManagedInstancesResults($listManagedInstancesResults);
        $expectedResponse->setName($name);
        $expectedResponse->setRegion($region2);
        $expectedResponse->setSatisfiesPzi($satisfiesPzi);
        $expectedResponse->setSatisfiesPzs($satisfiesPzs);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetSize($targetSize);
        $expectedResponse->setTargetStoppedSize($targetStoppedSize);
        $expectedResponse->setTargetSuspendedSize($targetSuspendedSize);
        $expectedResponse->setZone($zone);
        $transport->addResponse($expectedResponse);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $request = (new GetRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region);
        $response = $gapicClient->get($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/Get', $actualFuncCall);
        $actualValue = $actualRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getExceptionTest()
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $request = (new GetRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region);
        try {
            $gapicClient->get($request);
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
    public function insertTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/insertTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/insertTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instanceGroupManagerResource = new InstanceGroupManager();
        $project = 'project-309310695';
        $region = 'region-934795532';
        $request = (new InsertRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManagerResource($instanceGroupManagerResource)
            ->setProject($project)
            ->setRegion($region);
        $response = $gapicClient->insert($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/Insert', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceGroupManagerResource();
        $this->assertProtobufEquals($instanceGroupManagerResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $expectedOperationsRequestObject = new GetRegionOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setRegion($region);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function insertExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/insertExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
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
        $instanceGroupManagerResource = new InstanceGroupManager();
        $project = 'project-309310695';
        $region = 'region-934795532';
        $request = (new InsertRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManagerResource($instanceGroupManagerResource)
            ->setProject($project)
            ->setRegion($region);
        $response = $gapicClient->insert($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
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
    public function listTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $id = 'id3355';
        $kind = 'kind3292052';
        $nextPageToken = '';
        $selfLink = 'selfLink-1691268851';
        $itemsElement = new InstanceGroupManager();
        $items = [
            $itemsElement,
        ];
        $expectedResponse = new RegionInstanceGroupManagerList();
        $expectedResponse->setId($id);
        $expectedResponse->setKind($kind);
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setItems($items);
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $region = 'region-934795532';
        $request = (new ListRegionInstanceGroupManagersRequest())
            ->setProject($project)
            ->setRegion($region);
        $response = $gapicClient->list($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getItems()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/List', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listExceptionTest()
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
        $project = 'project-309310695';
        $region = 'region-934795532';
        $request = (new ListRegionInstanceGroupManagersRequest())
            ->setProject($project)
            ->setRegion($region);
        try {
            $gapicClient->list($request);
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
    public function listErrorsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $itemsElement = new InstanceManagedByIgmError();
        $items = [
            $itemsElement,
        ];
        $expectedResponse = new RegionInstanceGroupManagersListErrorsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setItems($items);
        $transport->addResponse($expectedResponse);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $request = (new ListErrorsRegionInstanceGroupManagersRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region);
        $response = $gapicClient->listErrors($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getItems()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/ListErrors', $actualFuncCall);
        $actualValue = $actualRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listErrorsExceptionTest()
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $request = (new ListErrorsRegionInstanceGroupManagersRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region);
        try {
            $gapicClient->listErrors($request);
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
    public function listManagedInstancesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $managedInstancesElement = new ManagedInstance();
        $managedInstances = [
            $managedInstancesElement,
        ];
        $expectedResponse = new RegionInstanceGroupManagersListInstancesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setManagedInstances($managedInstances);
        $transport->addResponse($expectedResponse);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $request = (new ListManagedInstancesRegionInstanceGroupManagersRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region);
        $response = $gapicClient->listManagedInstances($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getManagedInstances()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/ListManagedInstances', $actualFuncCall);
        $actualValue = $actualRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listManagedInstancesExceptionTest()
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $request = (new ListManagedInstancesRegionInstanceGroupManagersRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region);
        try {
            $gapicClient->listManagedInstances($request);
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
    public function listPerInstanceConfigsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $itemsElement = new PerInstanceConfig();
        $items = [
            $itemsElement,
        ];
        $expectedResponse = new RegionInstanceGroupManagersListInstanceConfigsResp();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setItems($items);
        $transport->addResponse($expectedResponse);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $request = (new ListPerInstanceConfigsRegionInstanceGroupManagersRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region);
        $response = $gapicClient->listPerInstanceConfigs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getItems()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/ListPerInstanceConfigs', $actualFuncCall);
        $actualValue = $actualRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listPerInstanceConfigsExceptionTest()
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $request = (new ListPerInstanceConfigsRegionInstanceGroupManagersRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region);
        try {
            $gapicClient->listPerInstanceConfigs($request);
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
    public function patchTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/patchTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/patchTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $instanceGroupManagerResource = new InstanceGroupManager();
        $project = 'project-309310695';
        $region = 'region-934795532';
        $request = (new PatchRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setInstanceGroupManagerResource($instanceGroupManagerResource)
            ->setProject($project)
            ->setRegion($region);
        $response = $gapicClient->patch($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/Patch', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualApiRequestObject->getInstanceGroupManagerResource();
        $this->assertProtobufEquals($instanceGroupManagerResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $expectedOperationsRequestObject = new GetRegionOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setRegion($region);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function patchExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/patchExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $instanceGroupManagerResource = new InstanceGroupManager();
        $project = 'project-309310695';
        $region = 'region-934795532';
        $request = (new PatchRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setInstanceGroupManagerResource($instanceGroupManagerResource)
            ->setProject($project)
            ->setRegion($region);
        $response = $gapicClient->patch($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
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
    public function patchPerInstanceConfigsTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/patchPerInstanceConfigsTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/patchPerInstanceConfigsTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagerPatchInstanceConfigReqResource = new RegionInstanceGroupManagerPatchInstanceConfigReq();
        $request = (new PatchPerInstanceConfigsRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagerPatchInstanceConfigReqResource($regionInstanceGroupManagerPatchInstanceConfigReqResource);
        $response = $gapicClient->patchPerInstanceConfigs($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/PatchPerInstanceConfigs', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualApiRequestObject->getRegionInstanceGroupManagerPatchInstanceConfigReqResource();
        $this->assertProtobufEquals($regionInstanceGroupManagerPatchInstanceConfigReqResource, $actualValue);
        $expectedOperationsRequestObject = new GetRegionOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setRegion($region);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function patchPerInstanceConfigsExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/patchPerInstanceConfigsExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagerPatchInstanceConfigReqResource = new RegionInstanceGroupManagerPatchInstanceConfigReq();
        $request = (new PatchPerInstanceConfigsRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagerPatchInstanceConfigReqResource($regionInstanceGroupManagerPatchInstanceConfigReqResource);
        $response = $gapicClient->patchPerInstanceConfigs($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
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
    public function recreateInstancesTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/recreateInstancesTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/recreateInstancesTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersRecreateRequestResource = new RegionInstanceGroupManagersRecreateRequest();
        $request = (new RecreateInstancesRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersRecreateRequestResource($regionInstanceGroupManagersRecreateRequestResource);
        $response = $gapicClient->recreateInstances($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/RecreateInstances', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualApiRequestObject->getRegionInstanceGroupManagersRecreateRequestResource();
        $this->assertProtobufEquals($regionInstanceGroupManagersRecreateRequestResource, $actualValue);
        $expectedOperationsRequestObject = new GetRegionOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setRegion($region);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function recreateInstancesExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/recreateInstancesExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersRecreateRequestResource = new RegionInstanceGroupManagersRecreateRequest();
        $request = (new RecreateInstancesRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersRecreateRequestResource($regionInstanceGroupManagersRecreateRequestResource);
        $response = $gapicClient->recreateInstances($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
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
    public function resizeTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/resizeTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/resizeTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $size = 3530753;
        $request = (new ResizeRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setSize($size);
        $response = $gapicClient->resize($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/Resize', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualApiRequestObject->getSize();
        $this->assertProtobufEquals($size, $actualValue);
        $expectedOperationsRequestObject = new GetRegionOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setRegion($region);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function resizeExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/resizeExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $size = 3530753;
        $request = (new ResizeRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setSize($size);
        $response = $gapicClient->resize($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
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
    public function resumeInstancesTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/resumeInstancesTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/resumeInstancesTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersResumeInstancesRequestResource = new RegionInstanceGroupManagersResumeInstancesRequest();
        $request = (new ResumeInstancesRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersResumeInstancesRequestResource($regionInstanceGroupManagersResumeInstancesRequestResource);
        $response = $gapicClient->resumeInstances($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/ResumeInstances', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualApiRequestObject->getRegionInstanceGroupManagersResumeInstancesRequestResource();
        $this->assertProtobufEquals($regionInstanceGroupManagersResumeInstancesRequestResource, $actualValue);
        $expectedOperationsRequestObject = new GetRegionOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setRegion($region);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function resumeInstancesExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/resumeInstancesExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersResumeInstancesRequestResource = new RegionInstanceGroupManagersResumeInstancesRequest();
        $request = (new ResumeInstancesRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersResumeInstancesRequestResource($regionInstanceGroupManagersResumeInstancesRequestResource);
        $response = $gapicClient->resumeInstances($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
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
    public function setInstanceTemplateTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/setInstanceTemplateTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/setInstanceTemplateTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersSetTemplateRequestResource = new RegionInstanceGroupManagersSetTemplateRequest();
        $request = (new SetInstanceTemplateRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersSetTemplateRequestResource($regionInstanceGroupManagersSetTemplateRequestResource);
        $response = $gapicClient->setInstanceTemplate($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/SetInstanceTemplate', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualApiRequestObject->getRegionInstanceGroupManagersSetTemplateRequestResource();
        $this->assertProtobufEquals($regionInstanceGroupManagersSetTemplateRequestResource, $actualValue);
        $expectedOperationsRequestObject = new GetRegionOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setRegion($region);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function setInstanceTemplateExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/setInstanceTemplateExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersSetTemplateRequestResource = new RegionInstanceGroupManagersSetTemplateRequest();
        $request = (new SetInstanceTemplateRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersSetTemplateRequestResource($regionInstanceGroupManagersSetTemplateRequestResource);
        $response = $gapicClient->setInstanceTemplate($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
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
    public function setTargetPoolsTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/setTargetPoolsTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/setTargetPoolsTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersSetTargetPoolsRequestResource = new RegionInstanceGroupManagersSetTargetPoolsRequest();
        $request = (new SetTargetPoolsRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersSetTargetPoolsRequestResource($regionInstanceGroupManagersSetTargetPoolsRequestResource);
        $response = $gapicClient->setTargetPools($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/SetTargetPools', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualApiRequestObject->getRegionInstanceGroupManagersSetTargetPoolsRequestResource();
        $this->assertProtobufEquals($regionInstanceGroupManagersSetTargetPoolsRequestResource, $actualValue);
        $expectedOperationsRequestObject = new GetRegionOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setRegion($region);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function setTargetPoolsExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/setTargetPoolsExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersSetTargetPoolsRequestResource = new RegionInstanceGroupManagersSetTargetPoolsRequest();
        $request = (new SetTargetPoolsRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersSetTargetPoolsRequestResource($regionInstanceGroupManagersSetTargetPoolsRequestResource);
        $response = $gapicClient->setTargetPools($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
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
    public function startInstancesTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/startInstancesTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/startInstancesTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersStartInstancesRequestResource = new RegionInstanceGroupManagersStartInstancesRequest();
        $request = (new StartInstancesRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersStartInstancesRequestResource($regionInstanceGroupManagersStartInstancesRequestResource);
        $response = $gapicClient->startInstances($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/StartInstances', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualApiRequestObject->getRegionInstanceGroupManagersStartInstancesRequestResource();
        $this->assertProtobufEquals($regionInstanceGroupManagersStartInstancesRequestResource, $actualValue);
        $expectedOperationsRequestObject = new GetRegionOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setRegion($region);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function startInstancesExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/startInstancesExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersStartInstancesRequestResource = new RegionInstanceGroupManagersStartInstancesRequest();
        $request = (new StartInstancesRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersStartInstancesRequestResource($regionInstanceGroupManagersStartInstancesRequestResource);
        $response = $gapicClient->startInstances($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
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
    public function stopInstancesTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/stopInstancesTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/stopInstancesTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersStopInstancesRequestResource = new RegionInstanceGroupManagersStopInstancesRequest();
        $request = (new StopInstancesRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersStopInstancesRequestResource($regionInstanceGroupManagersStopInstancesRequestResource);
        $response = $gapicClient->stopInstances($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/StopInstances', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualApiRequestObject->getRegionInstanceGroupManagersStopInstancesRequestResource();
        $this->assertProtobufEquals($regionInstanceGroupManagersStopInstancesRequestResource, $actualValue);
        $expectedOperationsRequestObject = new GetRegionOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setRegion($region);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function stopInstancesExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/stopInstancesExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersStopInstancesRequestResource = new RegionInstanceGroupManagersStopInstancesRequest();
        $request = (new StopInstancesRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersStopInstancesRequestResource($regionInstanceGroupManagersStopInstancesRequestResource);
        $response = $gapicClient->stopInstances($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
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
    public function suspendInstancesTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/suspendInstancesTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/suspendInstancesTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersSuspendInstancesRequestResource = new RegionInstanceGroupManagersSuspendInstancesRequest();
        $request = (new SuspendInstancesRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersSuspendInstancesRequestResource($regionInstanceGroupManagersSuspendInstancesRequestResource);
        $response = $gapicClient->suspendInstances($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/SuspendInstances', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualApiRequestObject->getRegionInstanceGroupManagersSuspendInstancesRequestResource();
        $this->assertProtobufEquals($regionInstanceGroupManagersSuspendInstancesRequestResource, $actualValue);
        $expectedOperationsRequestObject = new GetRegionOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setRegion($region);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function suspendInstancesExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/suspendInstancesExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersSuspendInstancesRequestResource = new RegionInstanceGroupManagersSuspendInstancesRequest();
        $request = (new SuspendInstancesRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersSuspendInstancesRequestResource($regionInstanceGroupManagersSuspendInstancesRequestResource);
        $response = $gapicClient->suspendInstances($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
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
    public function updatePerInstanceConfigsTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/updatePerInstanceConfigsTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/updatePerInstanceConfigsTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagerUpdateInstanceConfigReqResource = new RegionInstanceGroupManagerUpdateInstanceConfigReq();
        $request = (new UpdatePerInstanceConfigsRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagerUpdateInstanceConfigReqResource($regionInstanceGroupManagerUpdateInstanceConfigReqResource);
        $response = $gapicClient->updatePerInstanceConfigs($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/UpdatePerInstanceConfigs', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualApiRequestObject->getRegionInstanceGroupManagerUpdateInstanceConfigReqResource();
        $this->assertProtobufEquals($regionInstanceGroupManagerUpdateInstanceConfigReqResource, $actualValue);
        $expectedOperationsRequestObject = new GetRegionOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setRegion($region);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function updatePerInstanceConfigsExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/updatePerInstanceConfigsExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
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
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagerUpdateInstanceConfigReqResource = new RegionInstanceGroupManagerUpdateInstanceConfigReq();
        $request = (new UpdatePerInstanceConfigsRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagerUpdateInstanceConfigReqResource($regionInstanceGroupManagerUpdateInstanceConfigReqResource);
        $response = $gapicClient->updatePerInstanceConfigs($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
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
    public function abandonInstancesAsyncTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new RegionOperationsClient([
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
        $incompleteOperation->setName('customOperations/abandonInstancesAsyncTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/abandonInstancesAsyncTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instanceGroupManager = 'instanceGroupManager-1361249341';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionInstanceGroupManagersAbandonInstancesRequestResource = new RegionInstanceGroupManagersAbandonInstancesRequest();
        $request = (new AbandonInstancesRegionInstanceGroupManagerRequest())
            ->setInstanceGroupManager($instanceGroupManager)
            ->setProject($project)
            ->setRegion($region)
            ->setRegionInstanceGroupManagersAbandonInstancesRequestResource($regionInstanceGroupManagersAbandonInstancesRequestResource);
        $response = $gapicClient->abandonInstances($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionInstanceGroupManagers/AbandonInstances', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceGroupManager();
        $this->assertProtobufEquals($instanceGroupManager, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualApiRequestObject->getRegionInstanceGroupManagersAbandonInstancesRequestResource();
        $this->assertProtobufEquals($regionInstanceGroupManagersAbandonInstancesRequestResource, $actualValue);
        $expectedOperationsRequestObject = new GetRegionOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setRegion($region);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }
}
