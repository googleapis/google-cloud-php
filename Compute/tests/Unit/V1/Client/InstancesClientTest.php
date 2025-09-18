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
use Google\Cloud\Compute\V1\AccessConfig;
use Google\Cloud\Compute\V1\AddAccessConfigInstanceRequest;
use Google\Cloud\Compute\V1\AddNetworkInterfaceInstanceRequest;
use Google\Cloud\Compute\V1\AddResourcePoliciesInstanceRequest;
use Google\Cloud\Compute\V1\AggregatedListInstancesRequest;
use Google\Cloud\Compute\V1\AttachDiskInstanceRequest;
use Google\Cloud\Compute\V1\AttachedDisk;
use Google\Cloud\Compute\V1\BulkInsertInstanceRequest;
use Google\Cloud\Compute\V1\BulkInsertInstanceResource;
use Google\Cloud\Compute\V1\Client\InstancesClient;
use Google\Cloud\Compute\V1\Client\ZoneOperationsClient;
use Google\Cloud\Compute\V1\DeleteAccessConfigInstanceRequest;
use Google\Cloud\Compute\V1\DeleteInstanceRequest;
use Google\Cloud\Compute\V1\DeleteNetworkInterfaceInstanceRequest;
use Google\Cloud\Compute\V1\DetachDiskInstanceRequest;
use Google\Cloud\Compute\V1\DisplayDevice;
use Google\Cloud\Compute\V1\GetEffectiveFirewallsInstanceRequest;
use Google\Cloud\Compute\V1\GetGuestAttributesInstanceRequest;
use Google\Cloud\Compute\V1\GetIamPolicyInstanceRequest;
use Google\Cloud\Compute\V1\GetInstanceRequest;
use Google\Cloud\Compute\V1\GetScreenshotInstanceRequest;
use Google\Cloud\Compute\V1\GetSerialPortOutputInstanceRequest;
use Google\Cloud\Compute\V1\GetShieldedInstanceIdentityInstanceRequest;
use Google\Cloud\Compute\V1\GetZoneOperationRequest;
use Google\Cloud\Compute\V1\GuestAttributes;
use Google\Cloud\Compute\V1\InsertInstanceRequest;
use Google\Cloud\Compute\V1\Instance;
use Google\Cloud\Compute\V1\InstanceAggregatedList;
use Google\Cloud\Compute\V1\InstanceList;
use Google\Cloud\Compute\V1\InstanceListReferrers;
use Google\Cloud\Compute\V1\InstancesAddResourcePoliciesRequest;
use Google\Cloud\Compute\V1\InstancesGetEffectiveFirewallsResponse;
use Google\Cloud\Compute\V1\InstancesRemoveResourcePoliciesRequest;
use Google\Cloud\Compute\V1\InstancesReportHostAsFaultyRequest;
use Google\Cloud\Compute\V1\InstancesScopedList;
use Google\Cloud\Compute\V1\InstancesSetLabelsRequest;
use Google\Cloud\Compute\V1\InstancesSetMachineResourcesRequest;
use Google\Cloud\Compute\V1\InstancesSetMachineTypeRequest;
use Google\Cloud\Compute\V1\InstancesSetMinCpuPlatformRequest;
use Google\Cloud\Compute\V1\InstancesSetNameRequest;
use Google\Cloud\Compute\V1\InstancesSetSecurityPolicyRequest;
use Google\Cloud\Compute\V1\InstancesSetServiceAccountRequest;
use Google\Cloud\Compute\V1\InstancesStartWithEncryptionKeyRequest;
use Google\Cloud\Compute\V1\ListInstancesRequest;
use Google\Cloud\Compute\V1\ListReferrersInstancesRequest;
use Google\Cloud\Compute\V1\Metadata;
use Google\Cloud\Compute\V1\NetworkInterface;
use Google\Cloud\Compute\V1\Operation;
use Google\Cloud\Compute\V1\Operation\Status;
use Google\Cloud\Compute\V1\PerformMaintenanceInstanceRequest;
use Google\Cloud\Compute\V1\Policy;
use Google\Cloud\Compute\V1\Reference;
use Google\Cloud\Compute\V1\RemoveResourcePoliciesInstanceRequest;
use Google\Cloud\Compute\V1\ReportHostAsFaultyInstanceRequest;
use Google\Cloud\Compute\V1\ResetInstanceRequest;
use Google\Cloud\Compute\V1\ResumeInstanceRequest;
use Google\Cloud\Compute\V1\Scheduling;
use Google\Cloud\Compute\V1\Screenshot;
use Google\Cloud\Compute\V1\SendDiagnosticInterruptInstanceRequest;
use Google\Cloud\Compute\V1\SendDiagnosticInterruptInstanceResponse;
use Google\Cloud\Compute\V1\SerialPortOutput;
use Google\Cloud\Compute\V1\SetDeletionProtectionInstanceRequest;
use Google\Cloud\Compute\V1\SetDiskAutoDeleteInstanceRequest;
use Google\Cloud\Compute\V1\SetIamPolicyInstanceRequest;
use Google\Cloud\Compute\V1\SetLabelsInstanceRequest;
use Google\Cloud\Compute\V1\SetMachineResourcesInstanceRequest;
use Google\Cloud\Compute\V1\SetMachineTypeInstanceRequest;
use Google\Cloud\Compute\V1\SetMetadataInstanceRequest;
use Google\Cloud\Compute\V1\SetMinCpuPlatformInstanceRequest;
use Google\Cloud\Compute\V1\SetNameInstanceRequest;
use Google\Cloud\Compute\V1\SetSchedulingInstanceRequest;
use Google\Cloud\Compute\V1\SetSecurityPolicyInstanceRequest;
use Google\Cloud\Compute\V1\SetServiceAccountInstanceRequest;
use Google\Cloud\Compute\V1\SetShieldedInstanceIntegrityPolicyInstanceRequest;
use Google\Cloud\Compute\V1\SetTagsInstanceRequest;
use Google\Cloud\Compute\V1\ShieldedInstanceConfig;
use Google\Cloud\Compute\V1\ShieldedInstanceIdentity;
use Google\Cloud\Compute\V1\ShieldedInstanceIntegrityPolicy;
use Google\Cloud\Compute\V1\SimulateMaintenanceEventInstanceRequest;
use Google\Cloud\Compute\V1\StartInstanceRequest;
use Google\Cloud\Compute\V1\StartWithEncryptionKeyInstanceRequest;
use Google\Cloud\Compute\V1\StopInstanceRequest;
use Google\Cloud\Compute\V1\SuspendInstanceRequest;
use Google\Cloud\Compute\V1\Tags;
use Google\Cloud\Compute\V1\TestIamPermissionsInstanceRequest;
use Google\Cloud\Compute\V1\TestPermissionsRequest;
use Google\Cloud\Compute\V1\TestPermissionsResponse;
use Google\Cloud\Compute\V1\UpdateAccessConfigInstanceRequest;
use Google\Cloud\Compute\V1\UpdateDisplayDeviceInstanceRequest;
use Google\Cloud\Compute\V1\UpdateInstanceRequest;
use Google\Cloud\Compute\V1\UpdateNetworkInterfaceInstanceRequest;
use Google\Cloud\Compute\V1\UpdateShieldedInstanceConfigInstanceRequest;
use Google\Cloud\Compute\V1\ZoneSetPolicyRequest;
use Google\Rpc\Code;
use stdClass;

/**
 * @group compute
 *
 * @group gapic
 */
class InstancesClientTest extends GeneratedTest
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

    /** @return InstancesClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new InstancesClient($options);
    }

    /** @test */
    public function addAccessConfigTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/addAccessConfigTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/addAccessConfigTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $accessConfigResource = new AccessConfig();
        $instance = 'instance555127957';
        $networkInterface = 'networkInterface902258792';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new AddAccessConfigInstanceRequest())
            ->setAccessConfigResource($accessConfigResource)
            ->setInstance($instance)
            ->setNetworkInterface($networkInterface)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->addAccessConfig($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/AddAccessConfig', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getAccessConfigResource();
        $this->assertProtobufEquals($accessConfigResource, $actualValue);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getNetworkInterface();
        $this->assertProtobufEquals($networkInterface, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function addAccessConfigExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/addAccessConfigExceptionTest');
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
        $accessConfigResource = new AccessConfig();
        $instance = 'instance555127957';
        $networkInterface = 'networkInterface902258792';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new AddAccessConfigInstanceRequest())
            ->setAccessConfigResource($accessConfigResource)
            ->setInstance($instance)
            ->setNetworkInterface($networkInterface)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->addAccessConfig($request);
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
    public function addNetworkInterfaceTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/addNetworkInterfaceTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/addNetworkInterfaceTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $networkInterfaceResource = new NetworkInterface();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new AddNetworkInterfaceInstanceRequest())
            ->setInstance($instance)
            ->setNetworkInterfaceResource($networkInterfaceResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->addNetworkInterface($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/AddNetworkInterface', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getNetworkInterfaceResource();
        $this->assertProtobufEquals($networkInterfaceResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function addNetworkInterfaceExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/addNetworkInterfaceExceptionTest');
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
        $instance = 'instance555127957';
        $networkInterfaceResource = new NetworkInterface();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new AddNetworkInterfaceInstanceRequest())
            ->setInstance($instance)
            ->setNetworkInterfaceResource($networkInterfaceResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->addNetworkInterface($request);
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
    public function addResourcePoliciesTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/addResourcePoliciesTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/addResourcePoliciesTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $instancesAddResourcePoliciesRequestResource = new InstancesAddResourcePoliciesRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new AddResourcePoliciesInstanceRequest())
            ->setInstance($instance)
            ->setInstancesAddResourcePoliciesRequestResource($instancesAddResourcePoliciesRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->addResourcePolicies($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/AddResourcePolicies', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getInstancesAddResourcePoliciesRequestResource();
        $this->assertProtobufEquals($instancesAddResourcePoliciesRequestResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function addResourcePoliciesExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/addResourcePoliciesExceptionTest');
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
        $instance = 'instance555127957';
        $instancesAddResourcePoliciesRequestResource = new InstancesAddResourcePoliciesRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new AddResourcePoliciesInstanceRequest())
            ->setInstance($instance)
            ->setInstancesAddResourcePoliciesRequestResource($instancesAddResourcePoliciesRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->addResourcePolicies($request);
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
    public function aggregatedListTest()
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
        $items = [
            'itemsKey' => new InstancesScopedList(),
        ];
        $expectedResponse = new InstanceAggregatedList();
        $expectedResponse->setId($id);
        $expectedResponse->setKind($kind);
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setItems($items);
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $request = (new AggregatedListInstancesRequest())
            ->setProject($project);
        $response = $gapicClient->aggregatedList($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertArrayHasKey('itemsKey', $expectedResponse->getItems());
        $this->assertArrayHasKey('itemsKey', $resources);
        $this->assertEquals($expectedResponse->getItems()['itemsKey'], $resources['itemsKey']);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/AggregatedList', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function aggregatedListExceptionTest()
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
        $request = (new AggregatedListInstancesRequest())
            ->setProject($project);
        try {
            $gapicClient->aggregatedList($request);
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
    public function attachDiskTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/attachDiskTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/attachDiskTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $attachedDiskResource = new AttachedDisk();
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new AttachDiskInstanceRequest())
            ->setAttachedDiskResource($attachedDiskResource)
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->attachDisk($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/AttachDisk', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getAttachedDiskResource();
        $this->assertProtobufEquals($attachedDiskResource, $actualValue);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function attachDiskExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/attachDiskExceptionTest');
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
        $attachedDiskResource = new AttachedDisk();
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new AttachDiskInstanceRequest())
            ->setAttachedDiskResource($attachedDiskResource)
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->attachDisk($request);
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
    public function bulkInsertTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/bulkInsertTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/bulkInsertTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $bulkInsertInstanceResourceResource = new BulkInsertInstanceResource();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new BulkInsertInstanceRequest())
            ->setBulkInsertInstanceResourceResource($bulkInsertInstanceResourceResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->bulkInsert($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/BulkInsert', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getBulkInsertInstanceResourceResource();
        $this->assertProtobufEquals($bulkInsertInstanceResourceResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function bulkInsertExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/bulkInsertExceptionTest');
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
        $bulkInsertInstanceResourceResource = new BulkInsertInstanceResource();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new BulkInsertInstanceRequest())
            ->setBulkInsertInstanceResourceResource($bulkInsertInstanceResourceResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->bulkInsert($request);
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
        $operationsClient = new ZoneOperationsClient([
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new DeleteInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->delete($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/Delete', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function deleteExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new DeleteInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
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
    public function deleteAccessConfigTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/deleteAccessConfigTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/deleteAccessConfigTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $accessConfig = 'accessConfig-464014723';
        $instance = 'instance555127957';
        $networkInterface = 'networkInterface902258792';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new DeleteAccessConfigInstanceRequest())
            ->setAccessConfig($accessConfig)
            ->setInstance($instance)
            ->setNetworkInterface($networkInterface)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->deleteAccessConfig($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/DeleteAccessConfig', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getAccessConfig();
        $this->assertProtobufEquals($accessConfig, $actualValue);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getNetworkInterface();
        $this->assertProtobufEquals($networkInterface, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function deleteAccessConfigExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/deleteAccessConfigExceptionTest');
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
        $accessConfig = 'accessConfig-464014723';
        $instance = 'instance555127957';
        $networkInterface = 'networkInterface902258792';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new DeleteAccessConfigInstanceRequest())
            ->setAccessConfig($accessConfig)
            ->setInstance($instance)
            ->setNetworkInterface($networkInterface)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->deleteAccessConfig($request);
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
    public function deleteNetworkInterfaceTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/deleteNetworkInterfaceTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/deleteNetworkInterfaceTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $networkInterfaceName = 'networkInterfaceName-692399102';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new DeleteNetworkInterfaceInstanceRequest())
            ->setInstance($instance)
            ->setNetworkInterfaceName($networkInterfaceName)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->deleteNetworkInterface($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/DeleteNetworkInterface', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getNetworkInterfaceName();
        $this->assertProtobufEquals($networkInterfaceName, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function deleteNetworkInterfaceExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/deleteNetworkInterfaceExceptionTest');
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
        $instance = 'instance555127957';
        $networkInterfaceName = 'networkInterfaceName-692399102';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new DeleteNetworkInterfaceInstanceRequest())
            ->setInstance($instance)
            ->setNetworkInterfaceName($networkInterfaceName)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->deleteNetworkInterface($request);
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
    public function detachDiskTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/detachDiskTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/detachDiskTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $deviceName = 'deviceName-1543071020';
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new DetachDiskInstanceRequest())
            ->setDeviceName($deviceName)
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->detachDisk($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/DetachDisk', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getDeviceName();
        $this->assertProtobufEquals($deviceName, $actualValue);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function detachDiskExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/detachDiskExceptionTest');
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
        $deviceName = 'deviceName-1543071020';
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new DetachDiskInstanceRequest())
            ->setDeviceName($deviceName)
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->detachDisk($request);
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
        $canIpForward = true;
        $cpuPlatform = 'cpuPlatform947156266';
        $creationTimestamp = 'creationTimestamp567396278';
        $deletionProtection = true;
        $description = 'description-1724546052';
        $fingerprint = 'fingerprint-1375934236';
        $hostname = 'hostname-299803597';
        $id = 3355;
        $keyRevocationActionType = 'keyRevocationActionType-1374671262';
        $kind = 'kind3292052';
        $labelFingerprint = 'labelFingerprint714995737';
        $lastStartTimestamp = 'lastStartTimestamp-629911088';
        $lastStopTimestamp = 'lastStopTimestamp-1197789726';
        $lastSuspendedTimestamp = 'lastSuspendedTimestamp893146249';
        $machineType = 'machineType1838323762';
        $minCpuPlatform = 'minCpuPlatform-1367699977';
        $name = 'name3373707';
        $privateIpv6GoogleAccess = 'privateIpv6GoogleAccess1122018830';
        $satisfiesPzi = false;
        $satisfiesPzs = false;
        $selfLink = 'selfLink-1691268851';
        $sourceMachineImage = 'sourceMachineImage-1051972033';
        $startRestricted = true;
        $status = 'status-892481550';
        $statusMessage = 'statusMessage-239442758';
        $zone2 = 'zone2-696322977';
        $expectedResponse = new Instance();
        $expectedResponse->setCanIpForward($canIpForward);
        $expectedResponse->setCpuPlatform($cpuPlatform);
        $expectedResponse->setCreationTimestamp($creationTimestamp);
        $expectedResponse->setDeletionProtection($deletionProtection);
        $expectedResponse->setDescription($description);
        $expectedResponse->setFingerprint($fingerprint);
        $expectedResponse->setHostname($hostname);
        $expectedResponse->setId($id);
        $expectedResponse->setKeyRevocationActionType($keyRevocationActionType);
        $expectedResponse->setKind($kind);
        $expectedResponse->setLabelFingerprint($labelFingerprint);
        $expectedResponse->setLastStartTimestamp($lastStartTimestamp);
        $expectedResponse->setLastStopTimestamp($lastStopTimestamp);
        $expectedResponse->setLastSuspendedTimestamp($lastSuspendedTimestamp);
        $expectedResponse->setMachineType($machineType);
        $expectedResponse->setMinCpuPlatform($minCpuPlatform);
        $expectedResponse->setName($name);
        $expectedResponse->setPrivateIpv6GoogleAccess($privateIpv6GoogleAccess);
        $expectedResponse->setSatisfiesPzi($satisfiesPzi);
        $expectedResponse->setSatisfiesPzs($satisfiesPzs);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setSourceMachineImage($sourceMachineImage);
        $expectedResponse->setStartRestricted($startRestricted);
        $expectedResponse->setStatus($status);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setZone($zone2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new GetInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->get($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/Get', $actualFuncCall);
        $actualValue = $actualRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new GetInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
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
    public function getEffectiveFirewallsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new InstancesGetEffectiveFirewallsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $instance = 'instance555127957';
        $networkInterface = 'networkInterface902258792';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new GetEffectiveFirewallsInstanceRequest())
            ->setInstance($instance)
            ->setNetworkInterface($networkInterface)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->getEffectiveFirewalls($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/GetEffectiveFirewalls', $actualFuncCall);
        $actualValue = $actualRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualRequestObject->getNetworkInterface();
        $this->assertProtobufEquals($networkInterface, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getEffectiveFirewallsExceptionTest()
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
        $instance = 'instance555127957';
        $networkInterface = 'networkInterface902258792';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new GetEffectiveFirewallsInstanceRequest())
            ->setInstance($instance)
            ->setNetworkInterface($networkInterface)
            ->setProject($project)
            ->setZone($zone);
        try {
            $gapicClient->getEffectiveFirewalls($request);
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
    public function getGuestAttributesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $queryPath2 = 'queryPath21491922415';
        $selfLink = 'selfLink-1691268851';
        $variableKey2 = 'variableKey2-1496058161';
        $variableValue = 'variableValue-1486030354';
        $expectedResponse = new GuestAttributes();
        $expectedResponse->setKind($kind);
        $expectedResponse->setQueryPath($queryPath2);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setVariableKey($variableKey2);
        $expectedResponse->setVariableValue($variableValue);
        $transport->addResponse($expectedResponse);
        // Mock request
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new GetGuestAttributesInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->getGuestAttributes($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/GetGuestAttributes', $actualFuncCall);
        $actualValue = $actualRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getGuestAttributesExceptionTest()
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new GetGuestAttributesInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        try {
            $gapicClient->getGuestAttributes($request);
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
        $etag = 'etag3123477';
        $iamOwned = false;
        $version = 351608024;
        $expectedResponse = new Policy();
        $expectedResponse->setEtag($etag);
        $expectedResponse->setIamOwned($iamOwned);
        $expectedResponse->setVersion($version);
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $resource = 'resource-341064690';
        $zone = 'zone3744684';
        $request = (new GetIamPolicyInstanceRequest())
            ->setProject($project)
            ->setResource($resource)
            ->setZone($zone);
        $response = $gapicClient->getIamPolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/GetIamPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $actualValue = $actualRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
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
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $project = 'project-309310695';
        $resource = 'resource-341064690';
        $zone = 'zone3744684';
        $request = (new GetIamPolicyInstanceRequest())
            ->setProject($project)
            ->setResource($resource)
            ->setZone($zone);
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
    public function getScreenshotTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $contents = 'contents-567321830';
        $kind = 'kind3292052';
        $expectedResponse = new Screenshot();
        $expectedResponse->setContents($contents);
        $expectedResponse->setKind($kind);
        $transport->addResponse($expectedResponse);
        // Mock request
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new GetScreenshotInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->getScreenshot($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/GetScreenshot', $actualFuncCall);
        $actualValue = $actualRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getScreenshotExceptionTest()
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new GetScreenshotInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        try {
            $gapicClient->getScreenshot($request);
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
    public function getSerialPortOutputTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $contents = 'contents-567321830';
        $kind = 'kind3292052';
        $next = 3377907;
        $selfLink = 'selfLink-1691268851';
        $start2 = 1897185387;
        $expectedResponse = new SerialPortOutput();
        $expectedResponse->setContents($contents);
        $expectedResponse->setKind($kind);
        $expectedResponse->setNext($next);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setStart($start2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new GetSerialPortOutputInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->getSerialPortOutput($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/GetSerialPortOutput', $actualFuncCall);
        $actualValue = $actualRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getSerialPortOutputExceptionTest()
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new GetSerialPortOutputInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        try {
            $gapicClient->getSerialPortOutput($request);
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
    public function getShieldedInstanceIdentityTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $expectedResponse = new ShieldedInstanceIdentity();
        $expectedResponse->setKind($kind);
        $transport->addResponse($expectedResponse);
        // Mock request
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new GetShieldedInstanceIdentityInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->getShieldedInstanceIdentity($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/GetShieldedInstanceIdentity', $actualFuncCall);
        $actualValue = $actualRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getShieldedInstanceIdentityExceptionTest()
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new GetShieldedInstanceIdentityInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        try {
            $gapicClient->getShieldedInstanceIdentity($request);
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
        $operationsClient = new ZoneOperationsClient([
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
        $instanceResource = new Instance();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new InsertInstanceRequest())
            ->setInstanceResource($instanceResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->insert($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/Insert', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstanceResource();
        $this->assertProtobufEquals($instanceResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function insertExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $instanceResource = new Instance();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new InsertInstanceRequest())
            ->setInstanceResource($instanceResource)
            ->setProject($project)
            ->setZone($zone);
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
        $itemsElement = new Instance();
        $items = [
            $itemsElement,
        ];
        $expectedResponse = new InstanceList();
        $expectedResponse->setId($id);
        $expectedResponse->setKind($kind);
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setItems($items);
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new ListInstancesRequest())
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->list($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getItems()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/List', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
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
        $zone = 'zone3744684';
        $request = (new ListInstancesRequest())
            ->setProject($project)
            ->setZone($zone);
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
    public function listReferrersTest()
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
        $itemsElement = new Reference();
        $items = [
            $itemsElement,
        ];
        $expectedResponse = new InstanceListReferrers();
        $expectedResponse->setId($id);
        $expectedResponse->setKind($kind);
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setItems($items);
        $transport->addResponse($expectedResponse);
        // Mock request
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new ListReferrersInstancesRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->listReferrers($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getItems()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/ListReferrers', $actualFuncCall);
        $actualValue = $actualRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listReferrersExceptionTest()
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new ListReferrersInstancesRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        try {
            $gapicClient->listReferrers($request);
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
    public function performMaintenanceTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/performMaintenanceTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/performMaintenanceTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new PerformMaintenanceInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->performMaintenance($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/PerformMaintenance', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function performMaintenanceExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/performMaintenanceExceptionTest');
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new PerformMaintenanceInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->performMaintenance($request);
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
    public function removeResourcePoliciesTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/removeResourcePoliciesTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/removeResourcePoliciesTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $instancesRemoveResourcePoliciesRequestResource = new InstancesRemoveResourcePoliciesRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new RemoveResourcePoliciesInstanceRequest())
            ->setInstance($instance)
            ->setInstancesRemoveResourcePoliciesRequestResource($instancesRemoveResourcePoliciesRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->removeResourcePolicies($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/RemoveResourcePolicies', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getInstancesRemoveResourcePoliciesRequestResource();
        $this->assertProtobufEquals($instancesRemoveResourcePoliciesRequestResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function removeResourcePoliciesExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/removeResourcePoliciesExceptionTest');
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
        $instance = 'instance555127957';
        $instancesRemoveResourcePoliciesRequestResource = new InstancesRemoveResourcePoliciesRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new RemoveResourcePoliciesInstanceRequest())
            ->setInstance($instance)
            ->setInstancesRemoveResourcePoliciesRequestResource($instancesRemoveResourcePoliciesRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->removeResourcePolicies($request);
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
    public function reportHostAsFaultyTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/reportHostAsFaultyTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/reportHostAsFaultyTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $instancesReportHostAsFaultyRequestResource = new InstancesReportHostAsFaultyRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new ReportHostAsFaultyInstanceRequest())
            ->setInstance($instance)
            ->setInstancesReportHostAsFaultyRequestResource($instancesReportHostAsFaultyRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->reportHostAsFaulty($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/ReportHostAsFaulty', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getInstancesReportHostAsFaultyRequestResource();
        $this->assertProtobufEquals($instancesReportHostAsFaultyRequestResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function reportHostAsFaultyExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/reportHostAsFaultyExceptionTest');
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
        $instance = 'instance555127957';
        $instancesReportHostAsFaultyRequestResource = new InstancesReportHostAsFaultyRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new ReportHostAsFaultyInstanceRequest())
            ->setInstance($instance)
            ->setInstancesReportHostAsFaultyRequestResource($instancesReportHostAsFaultyRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->reportHostAsFaulty($request);
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
    public function resetTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/resetTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/resetTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new ResetInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->reset($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/Reset', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function resetExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/resetExceptionTest');
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new ResetInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->reset($request);
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
    public function resumeTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/resumeTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/resumeTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new ResumeInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->resume($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/Resume', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function resumeExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/resumeExceptionTest');
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new ResumeInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->resume($request);
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
    public function sendDiagnosticInterruptTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new SendDiagnosticInterruptInstanceResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SendDiagnosticInterruptInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->sendDiagnosticInterrupt($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/SendDiagnosticInterrupt', $actualFuncCall);
        $actualValue = $actualRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function sendDiagnosticInterruptExceptionTest()
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SendDiagnosticInterruptInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        try {
            $gapicClient->sendDiagnosticInterrupt($request);
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
    public function setDeletionProtectionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setDeletionProtectionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/setDeletionProtectionTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $project = 'project-309310695';
        $resource = 'resource-341064690';
        $zone = 'zone3744684';
        $request = (new SetDeletionProtectionInstanceRequest())
            ->setProject($project)
            ->setResource($resource)
            ->setZone($zone);
        $response = $gapicClient->setDeletionProtection($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/SetDeletionProtection', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function setDeletionProtectionExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setDeletionProtectionExceptionTest');
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
        $project = 'project-309310695';
        $resource = 'resource-341064690';
        $zone = 'zone3744684';
        $request = (new SetDeletionProtectionInstanceRequest())
            ->setProject($project)
            ->setResource($resource)
            ->setZone($zone);
        $response = $gapicClient->setDeletionProtection($request);
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
    public function setDiskAutoDeleteTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setDiskAutoDeleteTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/setDiskAutoDeleteTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $autoDelete = false;
        $deviceName = 'deviceName-1543071020';
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SetDiskAutoDeleteInstanceRequest())
            ->setAutoDelete($autoDelete)
            ->setDeviceName($deviceName)
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->setDiskAutoDelete($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/SetDiskAutoDelete', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getAutoDelete();
        $this->assertProtobufEquals($autoDelete, $actualValue);
        $actualValue = $actualApiRequestObject->getDeviceName();
        $this->assertProtobufEquals($deviceName, $actualValue);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function setDiskAutoDeleteExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setDiskAutoDeleteExceptionTest');
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
        $autoDelete = false;
        $deviceName = 'deviceName-1543071020';
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SetDiskAutoDeleteInstanceRequest())
            ->setAutoDelete($autoDelete)
            ->setDeviceName($deviceName)
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->setDiskAutoDelete($request);
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
    public function setIamPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $etag = 'etag3123477';
        $iamOwned = false;
        $version = 351608024;
        $expectedResponse = new Policy();
        $expectedResponse->setEtag($etag);
        $expectedResponse->setIamOwned($iamOwned);
        $expectedResponse->setVersion($version);
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $resource = 'resource-341064690';
        $zone = 'zone3744684';
        $zoneSetPolicyRequestResource = new ZoneSetPolicyRequest();
        $request = (new SetIamPolicyInstanceRequest())
            ->setProject($project)
            ->setResource($resource)
            ->setZone($zone)
            ->setZoneSetPolicyRequestResource($zoneSetPolicyRequestResource);
        $response = $gapicClient->setIamPolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/SetIamPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $actualValue = $actualRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getZoneSetPolicyRequestResource();
        $this->assertProtobufEquals($zoneSetPolicyRequestResource, $actualValue);
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
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $project = 'project-309310695';
        $resource = 'resource-341064690';
        $zone = 'zone3744684';
        $zoneSetPolicyRequestResource = new ZoneSetPolicyRequest();
        $request = (new SetIamPolicyInstanceRequest())
            ->setProject($project)
            ->setResource($resource)
            ->setZone($zone)
            ->setZoneSetPolicyRequestResource($zoneSetPolicyRequestResource);
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
    public function setLabelsTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setLabelsTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/setLabelsTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $instancesSetLabelsRequestResource = new InstancesSetLabelsRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SetLabelsInstanceRequest())
            ->setInstance($instance)
            ->setInstancesSetLabelsRequestResource($instancesSetLabelsRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->setLabels($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/SetLabels', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getInstancesSetLabelsRequestResource();
        $this->assertProtobufEquals($instancesSetLabelsRequestResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function setLabelsExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setLabelsExceptionTest');
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
        $instance = 'instance555127957';
        $instancesSetLabelsRequestResource = new InstancesSetLabelsRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SetLabelsInstanceRequest())
            ->setInstance($instance)
            ->setInstancesSetLabelsRequestResource($instancesSetLabelsRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->setLabels($request);
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
    public function setMachineResourcesTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setMachineResourcesTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/setMachineResourcesTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $instancesSetMachineResourcesRequestResource = new InstancesSetMachineResourcesRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SetMachineResourcesInstanceRequest())
            ->setInstance($instance)
            ->setInstancesSetMachineResourcesRequestResource($instancesSetMachineResourcesRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->setMachineResources($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/SetMachineResources', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getInstancesSetMachineResourcesRequestResource();
        $this->assertProtobufEquals($instancesSetMachineResourcesRequestResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function setMachineResourcesExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setMachineResourcesExceptionTest');
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
        $instance = 'instance555127957';
        $instancesSetMachineResourcesRequestResource = new InstancesSetMachineResourcesRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SetMachineResourcesInstanceRequest())
            ->setInstance($instance)
            ->setInstancesSetMachineResourcesRequestResource($instancesSetMachineResourcesRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->setMachineResources($request);
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
    public function setMachineTypeTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setMachineTypeTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/setMachineTypeTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $instancesSetMachineTypeRequestResource = new InstancesSetMachineTypeRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SetMachineTypeInstanceRequest())
            ->setInstance($instance)
            ->setInstancesSetMachineTypeRequestResource($instancesSetMachineTypeRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->setMachineType($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/SetMachineType', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getInstancesSetMachineTypeRequestResource();
        $this->assertProtobufEquals($instancesSetMachineTypeRequestResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function setMachineTypeExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setMachineTypeExceptionTest');
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
        $instance = 'instance555127957';
        $instancesSetMachineTypeRequestResource = new InstancesSetMachineTypeRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SetMachineTypeInstanceRequest())
            ->setInstance($instance)
            ->setInstancesSetMachineTypeRequestResource($instancesSetMachineTypeRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->setMachineType($request);
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
    public function setMetadataTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setMetadataTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/setMetadataTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $metadataResource = new Metadata();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SetMetadataInstanceRequest())
            ->setInstance($instance)
            ->setMetadataResource($metadataResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->setMetadata($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/SetMetadata', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getMetadataResource();
        $this->assertProtobufEquals($metadataResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function setMetadataExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setMetadataExceptionTest');
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
        $instance = 'instance555127957';
        $metadataResource = new Metadata();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SetMetadataInstanceRequest())
            ->setInstance($instance)
            ->setMetadataResource($metadataResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->setMetadata($request);
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
    public function setMinCpuPlatformTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setMinCpuPlatformTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/setMinCpuPlatformTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $instancesSetMinCpuPlatformRequestResource = new InstancesSetMinCpuPlatformRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SetMinCpuPlatformInstanceRequest())
            ->setInstance($instance)
            ->setInstancesSetMinCpuPlatformRequestResource($instancesSetMinCpuPlatformRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->setMinCpuPlatform($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/SetMinCpuPlatform', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getInstancesSetMinCpuPlatformRequestResource();
        $this->assertProtobufEquals($instancesSetMinCpuPlatformRequestResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function setMinCpuPlatformExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setMinCpuPlatformExceptionTest');
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
        $instance = 'instance555127957';
        $instancesSetMinCpuPlatformRequestResource = new InstancesSetMinCpuPlatformRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SetMinCpuPlatformInstanceRequest())
            ->setInstance($instance)
            ->setInstancesSetMinCpuPlatformRequestResource($instancesSetMinCpuPlatformRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->setMinCpuPlatform($request);
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
    public function setNameTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setNameTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/setNameTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $instancesSetNameRequestResource = new InstancesSetNameRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SetNameInstanceRequest())
            ->setInstance($instance)
            ->setInstancesSetNameRequestResource($instancesSetNameRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->setName($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/SetName', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getInstancesSetNameRequestResource();
        $this->assertProtobufEquals($instancesSetNameRequestResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function setNameExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setNameExceptionTest');
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
        $instance = 'instance555127957';
        $instancesSetNameRequestResource = new InstancesSetNameRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SetNameInstanceRequest())
            ->setInstance($instance)
            ->setInstancesSetNameRequestResource($instancesSetNameRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->setName($request);
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
    public function setSchedulingTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setSchedulingTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/setSchedulingTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $schedulingResource = new Scheduling();
        $zone = 'zone3744684';
        $request = (new SetSchedulingInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setSchedulingResource($schedulingResource)
            ->setZone($zone);
        $response = $gapicClient->setScheduling($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/SetScheduling', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getSchedulingResource();
        $this->assertProtobufEquals($schedulingResource, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function setSchedulingExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setSchedulingExceptionTest');
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $schedulingResource = new Scheduling();
        $zone = 'zone3744684';
        $request = (new SetSchedulingInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setSchedulingResource($schedulingResource)
            ->setZone($zone);
        $response = $gapicClient->setScheduling($request);
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
    public function setSecurityPolicyTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setSecurityPolicyTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/setSecurityPolicyTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $instancesSetSecurityPolicyRequestResource = new InstancesSetSecurityPolicyRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SetSecurityPolicyInstanceRequest())
            ->setInstance($instance)
            ->setInstancesSetSecurityPolicyRequestResource($instancesSetSecurityPolicyRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->setSecurityPolicy($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/SetSecurityPolicy', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getInstancesSetSecurityPolicyRequestResource();
        $this->assertProtobufEquals($instancesSetSecurityPolicyRequestResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function setSecurityPolicyExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setSecurityPolicyExceptionTest');
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
        $instance = 'instance555127957';
        $instancesSetSecurityPolicyRequestResource = new InstancesSetSecurityPolicyRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SetSecurityPolicyInstanceRequest())
            ->setInstance($instance)
            ->setInstancesSetSecurityPolicyRequestResource($instancesSetSecurityPolicyRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->setSecurityPolicy($request);
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
    public function setServiceAccountTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setServiceAccountTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/setServiceAccountTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $instancesSetServiceAccountRequestResource = new InstancesSetServiceAccountRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SetServiceAccountInstanceRequest())
            ->setInstance($instance)
            ->setInstancesSetServiceAccountRequestResource($instancesSetServiceAccountRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->setServiceAccount($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/SetServiceAccount', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getInstancesSetServiceAccountRequestResource();
        $this->assertProtobufEquals($instancesSetServiceAccountRequestResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function setServiceAccountExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setServiceAccountExceptionTest');
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
        $instance = 'instance555127957';
        $instancesSetServiceAccountRequestResource = new InstancesSetServiceAccountRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SetServiceAccountInstanceRequest())
            ->setInstance($instance)
            ->setInstancesSetServiceAccountRequestResource($instancesSetServiceAccountRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->setServiceAccount($request);
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
    public function setShieldedInstanceIntegrityPolicyTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setShieldedInstanceIntegrityPolicyTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/setShieldedInstanceIntegrityPolicyTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $shieldedInstanceIntegrityPolicyResource = new ShieldedInstanceIntegrityPolicy();
        $zone = 'zone3744684';
        $request = (new SetShieldedInstanceIntegrityPolicyInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setShieldedInstanceIntegrityPolicyResource($shieldedInstanceIntegrityPolicyResource)
            ->setZone($zone);
        $response = $gapicClient->setShieldedInstanceIntegrityPolicy($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/SetShieldedInstanceIntegrityPolicy', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getShieldedInstanceIntegrityPolicyResource();
        $this->assertProtobufEquals($shieldedInstanceIntegrityPolicyResource, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function setShieldedInstanceIntegrityPolicyExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setShieldedInstanceIntegrityPolicyExceptionTest');
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $shieldedInstanceIntegrityPolicyResource = new ShieldedInstanceIntegrityPolicy();
        $zone = 'zone3744684';
        $request = (new SetShieldedInstanceIntegrityPolicyInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setShieldedInstanceIntegrityPolicyResource($shieldedInstanceIntegrityPolicyResource)
            ->setZone($zone);
        $response = $gapicClient->setShieldedInstanceIntegrityPolicy($request);
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
    public function setTagsTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setTagsTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/setTagsTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $tagsResource = new Tags();
        $zone = 'zone3744684';
        $request = (new SetTagsInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setTagsResource($tagsResource)
            ->setZone($zone);
        $response = $gapicClient->setTags($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/SetTags', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getTagsResource();
        $this->assertProtobufEquals($tagsResource, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function setTagsExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/setTagsExceptionTest');
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $tagsResource = new Tags();
        $zone = 'zone3744684';
        $request = (new SetTagsInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setTagsResource($tagsResource)
            ->setZone($zone);
        $response = $gapicClient->setTags($request);
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
    public function simulateMaintenanceEventTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/simulateMaintenanceEventTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/simulateMaintenanceEventTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SimulateMaintenanceEventInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->simulateMaintenanceEvent($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/SimulateMaintenanceEvent', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function simulateMaintenanceEventExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/simulateMaintenanceEventExceptionTest');
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SimulateMaintenanceEventInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->simulateMaintenanceEvent($request);
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
    public function startTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/startTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/startTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new StartInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->start($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/Start', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function startExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/startExceptionTest');
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new StartInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->start($request);
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
    public function startWithEncryptionKeyTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/startWithEncryptionKeyTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/startWithEncryptionKeyTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $instancesStartWithEncryptionKeyRequestResource = new InstancesStartWithEncryptionKeyRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new StartWithEncryptionKeyInstanceRequest())
            ->setInstance($instance)
            ->setInstancesStartWithEncryptionKeyRequestResource($instancesStartWithEncryptionKeyRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->startWithEncryptionKey($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/StartWithEncryptionKey', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getInstancesStartWithEncryptionKeyRequestResource();
        $this->assertProtobufEquals($instancesStartWithEncryptionKeyRequestResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function startWithEncryptionKeyExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/startWithEncryptionKeyExceptionTest');
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
        $instance = 'instance555127957';
        $instancesStartWithEncryptionKeyRequestResource = new InstancesStartWithEncryptionKeyRequest();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new StartWithEncryptionKeyInstanceRequest())
            ->setInstance($instance)
            ->setInstancesStartWithEncryptionKeyRequestResource($instancesStartWithEncryptionKeyRequestResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->startWithEncryptionKey($request);
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
    public function stopTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/stopTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/stopTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new StopInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->stop($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/Stop', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function stopExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/stopExceptionTest');
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new StopInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->stop($request);
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
    public function suspendTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/suspendTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/suspendTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SuspendInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->suspend($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/Suspend', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function suspendExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/suspendExceptionTest');
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new SuspendInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->suspend($request);
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
    public function testIamPermissionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new TestPermissionsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $resource = 'resource-341064690';
        $testPermissionsRequestResource = new TestPermissionsRequest();
        $zone = 'zone3744684';
        $request = (new TestIamPermissionsInstanceRequest())
            ->setProject($project)
            ->setResource($resource)
            ->setTestPermissionsRequestResource($testPermissionsRequestResource)
            ->setZone($zone);
        $response = $gapicClient->testIamPermissions($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/TestIamPermissions', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $actualValue = $actualRequestObject->getTestPermissionsRequestResource();
        $this->assertProtobufEquals($testPermissionsRequestResource, $actualValue);
        $actualValue = $actualRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
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
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $project = 'project-309310695';
        $resource = 'resource-341064690';
        $testPermissionsRequestResource = new TestPermissionsRequest();
        $zone = 'zone3744684';
        $request = (new TestIamPermissionsInstanceRequest())
            ->setProject($project)
            ->setResource($resource)
            ->setTestPermissionsRequestResource($testPermissionsRequestResource)
            ->setZone($zone);
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
    public function updateTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/updateTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/updateTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $instanceResource = new Instance();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new UpdateInstanceRequest())
            ->setInstance($instance)
            ->setInstanceResource($instanceResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->update($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/Update', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getInstanceResource();
        $this->assertProtobufEquals($instanceResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function updateExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/updateExceptionTest');
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
        $instance = 'instance555127957';
        $instanceResource = new Instance();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new UpdateInstanceRequest())
            ->setInstance($instance)
            ->setInstanceResource($instanceResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->update($request);
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
    public function updateAccessConfigTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/updateAccessConfigTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/updateAccessConfigTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $accessConfigResource = new AccessConfig();
        $instance = 'instance555127957';
        $networkInterface = 'networkInterface902258792';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new UpdateAccessConfigInstanceRequest())
            ->setAccessConfigResource($accessConfigResource)
            ->setInstance($instance)
            ->setNetworkInterface($networkInterface)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->updateAccessConfig($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/UpdateAccessConfig', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getAccessConfigResource();
        $this->assertProtobufEquals($accessConfigResource, $actualValue);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getNetworkInterface();
        $this->assertProtobufEquals($networkInterface, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function updateAccessConfigExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/updateAccessConfigExceptionTest');
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
        $accessConfigResource = new AccessConfig();
        $instance = 'instance555127957';
        $networkInterface = 'networkInterface902258792';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new UpdateAccessConfigInstanceRequest())
            ->setAccessConfigResource($accessConfigResource)
            ->setInstance($instance)
            ->setNetworkInterface($networkInterface)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->updateAccessConfig($request);
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
    public function updateDisplayDeviceTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/updateDisplayDeviceTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/updateDisplayDeviceTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $displayDeviceResource = new DisplayDevice();
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new UpdateDisplayDeviceInstanceRequest())
            ->setDisplayDeviceResource($displayDeviceResource)
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->updateDisplayDevice($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/UpdateDisplayDevice', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getDisplayDeviceResource();
        $this->assertProtobufEquals($displayDeviceResource, $actualValue);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function updateDisplayDeviceExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/updateDisplayDeviceExceptionTest');
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
        $displayDeviceResource = new DisplayDevice();
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new UpdateDisplayDeviceInstanceRequest())
            ->setDisplayDeviceResource($displayDeviceResource)
            ->setInstance($instance)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->updateDisplayDevice($request);
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
    public function updateNetworkInterfaceTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/updateNetworkInterfaceTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/updateNetworkInterfaceTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $networkInterface = 'networkInterface902258792';
        $networkInterfaceResource = new NetworkInterface();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new UpdateNetworkInterfaceInstanceRequest())
            ->setInstance($instance)
            ->setNetworkInterface($networkInterface)
            ->setNetworkInterfaceResource($networkInterfaceResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->updateNetworkInterface($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/UpdateNetworkInterface', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getNetworkInterface();
        $this->assertProtobufEquals($networkInterface, $actualValue);
        $actualValue = $actualApiRequestObject->getNetworkInterfaceResource();
        $this->assertProtobufEquals($networkInterfaceResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function updateNetworkInterfaceExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/updateNetworkInterfaceExceptionTest');
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
        $instance = 'instance555127957';
        $networkInterface = 'networkInterface902258792';
        $networkInterfaceResource = new NetworkInterface();
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new UpdateNetworkInterfaceInstanceRequest())
            ->setInstance($instance)
            ->setNetworkInterface($networkInterface)
            ->setNetworkInterfaceResource($networkInterfaceResource)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->updateNetworkInterface($request);
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
    public function updateShieldedInstanceConfigTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/updateShieldedInstanceConfigTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/updateShieldedInstanceConfigTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $shieldedInstanceConfigResource = new ShieldedInstanceConfig();
        $zone = 'zone3744684';
        $request = (new UpdateShieldedInstanceConfigInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setShieldedInstanceConfigResource($shieldedInstanceConfigResource)
            ->setZone($zone);
        $response = $gapicClient->updateShieldedInstanceConfig($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/UpdateShieldedInstanceConfig', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getShieldedInstanceConfigResource();
        $this->assertProtobufEquals($shieldedInstanceConfigResource, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function updateShieldedInstanceConfigExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/updateShieldedInstanceConfigExceptionTest');
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
        $instance = 'instance555127957';
        $project = 'project-309310695';
        $shieldedInstanceConfigResource = new ShieldedInstanceConfig();
        $zone = 'zone3744684';
        $request = (new UpdateShieldedInstanceConfigInstanceRequest())
            ->setInstance($instance)
            ->setProject($project)
            ->setShieldedInstanceConfigResource($shieldedInstanceConfigResource)
            ->setZone($zone);
        $response = $gapicClient->updateShieldedInstanceConfig($request);
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
    public function addAccessConfigAsyncTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new ZoneOperationsClient([
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
        $incompleteOperation->setName('customOperations/addAccessConfigAsyncTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/addAccessConfigAsyncTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $accessConfigResource = new AccessConfig();
        $instance = 'instance555127957';
        $networkInterface = 'networkInterface902258792';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new AddAccessConfigInstanceRequest())
            ->setAccessConfigResource($accessConfigResource)
            ->setInstance($instance)
            ->setNetworkInterface($networkInterface)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->addAccessConfig($request);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Instances/AddAccessConfig', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getAccessConfigResource();
        $this->assertProtobufEquals($accessConfigResource, $actualValue);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $actualValue = $actualApiRequestObject->getNetworkInterface();
        $this->assertProtobufEquals($networkInterface, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $expectedOperationsRequestObject = new GetZoneOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $expectedOperationsRequestObject->setZone($zone);
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
        $this->assertSame('/google.cloud.compute.v1.ZoneOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }
}
