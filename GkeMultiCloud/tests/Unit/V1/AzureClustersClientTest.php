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

namespace Google\Cloud\GkeMultiCloud\Tests\Unit\V1;

use Google\ApiCore\ApiException;

use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\Testing\GeneratedTest;

use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\GkeMultiCloud\V1\AzureAuthorization;
use Google\Cloud\GkeMultiCloud\V1\AzureClient;

use Google\Cloud\GkeMultiCloud\V1\AzureCluster;
use Google\Cloud\GkeMultiCloud\V1\AzureClusterNetworking;
use Google\Cloud\GkeMultiCloud\V1\AzureClustersClient;
use Google\Cloud\GkeMultiCloud\V1\AzureControlPlane;
use Google\Cloud\GkeMultiCloud\V1\AzureNodeConfig;
use Google\Cloud\GkeMultiCloud\V1\AzureNodePool;
use Google\Cloud\GkeMultiCloud\V1\AzureNodePoolAutoscaling;
use Google\Cloud\GkeMultiCloud\V1\AzureServerConfig;
use Google\Cloud\GkeMultiCloud\V1\AzureSshConfig;
use Google\Cloud\GkeMultiCloud\V1\GenerateAzureAccessTokenResponse;
use Google\Cloud\GkeMultiCloud\V1\ListAzureClientsResponse;
use Google\Cloud\GkeMultiCloud\V1\ListAzureClustersResponse;
use Google\Cloud\GkeMultiCloud\V1\ListAzureNodePoolsResponse;
use Google\Cloud\GkeMultiCloud\V1\MaxPodsConstraint;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group gkemulticloud
 *
 * @group gapic
 */
class AzureClustersClientTest extends GeneratedTest
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
     * @return AzureClustersClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AzureClustersClient($options);
    }

    /**
     * @test
     */
    public function createAzureClientTest()
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
        $incompleteOperation->setName('operations/createAzureClientTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $tenantId = 'tenantId-1852780336';
        $applicationId = 'applicationId-1287148950';
        $pemCertificate = 'pemCertificate1234463984';
        $uid = 'uid115792';
        $expectedResponse = new AzureClient();
        $expectedResponse->setName($name);
        $expectedResponse->setTenantId($tenantId);
        $expectedResponse->setApplicationId($applicationId);
        $expectedResponse->setPemCertificate($pemCertificate);
        $expectedResponse->setUid($uid);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createAzureClientTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $azureClient = new AzureClient();
        $azureClientTenantId = 'azureClientTenantId-567307073';
        $azureClient->setTenantId($azureClientTenantId);
        $azureClientApplicationId = 'azureClientApplicationId264838513';
        $azureClient->setApplicationId($azureClientApplicationId);
        $azureClientId = 'azureClientId315645023';
        $response = $client->createAzureClient($formattedParent, $azureClient, $azureClientId);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AzureClusters/CreateAzureClient', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getAzureClient();
        $this->assertProtobufEquals($azureClient, $actualValue);
        $actualValue = $actualApiRequestObject->getAzureClientId();
        $this->assertProtobufEquals($azureClientId, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createAzureClientTest');
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
    public function createAzureClientExceptionTest()
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
        $incompleteOperation->setName('operations/createAzureClientTest');
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
        $azureClient = new AzureClient();
        $azureClientTenantId = 'azureClientTenantId-567307073';
        $azureClient->setTenantId($azureClientTenantId);
        $azureClientApplicationId = 'azureClientApplicationId264838513';
        $azureClient->setApplicationId($azureClientApplicationId);
        $azureClientId = 'azureClientId315645023';
        $response = $client->createAzureClient($formattedParent, $azureClient, $azureClientId);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createAzureClientTest');
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
    public function createAzureClusterTest()
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
        $incompleteOperation->setName('operations/createAzureClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $description = 'description-1724546052';
        $azureRegion = 'azureRegion-253373788';
        $resourceGroupId = 'resourceGroupId-1092054036';
        $azureClient = 'azureClient-676290693';
        $endpoint = 'endpoint1741102485';
        $uid = 'uid115792';
        $reconciling = false;
        $etag = 'etag3123477';
        $clusterCaCertificate = 'clusterCaCertificate1324742683';
        $expectedResponse = new AzureCluster();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setAzureRegion($azureRegion);
        $expectedResponse->setResourceGroupId($resourceGroupId);
        $expectedResponse->setAzureClient($azureClient);
        $expectedResponse->setEndpoint($endpoint);
        $expectedResponse->setUid($uid);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setClusterCaCertificate($clusterCaCertificate);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createAzureClusterTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $azureCluster = new AzureCluster();
        $azureClusterAzureRegion = 'azureClusterAzureRegion-1036501768';
        $azureCluster->setAzureRegion($azureClusterAzureRegion);
        $azureClusterResourceGroupId = 'azureClusterResourceGroupId-1683734495';
        $azureCluster->setResourceGroupId($azureClusterResourceGroupId);
        $azureClusterAzureClient = 'azureClusterAzureClient-1459418673';
        $azureCluster->setAzureClient($azureClusterAzureClient);
        $azureClusterNetworking = new AzureClusterNetworking();
        $networkingVirtualNetworkId = 'networkingVirtualNetworkId-516550606';
        $azureClusterNetworking->setVirtualNetworkId($networkingVirtualNetworkId);
        $networkingPodAddressCidrBlocks = [];
        $azureClusterNetworking->setPodAddressCidrBlocks($networkingPodAddressCidrBlocks);
        $networkingServiceAddressCidrBlocks = [];
        $azureClusterNetworking->setServiceAddressCidrBlocks($networkingServiceAddressCidrBlocks);
        $azureCluster->setNetworking($azureClusterNetworking);
        $azureClusterControlPlane = new AzureControlPlane();
        $controlPlaneVersion = 'controlPlaneVersion648040665';
        $azureClusterControlPlane->setVersion($controlPlaneVersion);
        $controlPlaneSshConfig = new AzureSshConfig();
        $sshConfigAuthorizedKey = 'sshConfigAuthorizedKey1626409850';
        $controlPlaneSshConfig->setAuthorizedKey($sshConfigAuthorizedKey);
        $azureClusterControlPlane->setSshConfig($controlPlaneSshConfig);
        $azureCluster->setControlPlane($azureClusterControlPlane);
        $azureClusterAuthorization = new AzureAuthorization();
        $authorizationAdminUsers = [];
        $azureClusterAuthorization->setAdminUsers($authorizationAdminUsers);
        $azureCluster->setAuthorization($azureClusterAuthorization);
        $azureClusterId = 'azureClusterId332577072';
        $response = $client->createAzureCluster($formattedParent, $azureCluster, $azureClusterId);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AzureClusters/CreateAzureCluster', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getAzureCluster();
        $this->assertProtobufEquals($azureCluster, $actualValue);
        $actualValue = $actualApiRequestObject->getAzureClusterId();
        $this->assertProtobufEquals($azureClusterId, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createAzureClusterTest');
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
    public function createAzureClusterExceptionTest()
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
        $incompleteOperation->setName('operations/createAzureClusterTest');
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
        $azureCluster = new AzureCluster();
        $azureClusterAzureRegion = 'azureClusterAzureRegion-1036501768';
        $azureCluster->setAzureRegion($azureClusterAzureRegion);
        $azureClusterResourceGroupId = 'azureClusterResourceGroupId-1683734495';
        $azureCluster->setResourceGroupId($azureClusterResourceGroupId);
        $azureClusterAzureClient = 'azureClusterAzureClient-1459418673';
        $azureCluster->setAzureClient($azureClusterAzureClient);
        $azureClusterNetworking = new AzureClusterNetworking();
        $networkingVirtualNetworkId = 'networkingVirtualNetworkId-516550606';
        $azureClusterNetworking->setVirtualNetworkId($networkingVirtualNetworkId);
        $networkingPodAddressCidrBlocks = [];
        $azureClusterNetworking->setPodAddressCidrBlocks($networkingPodAddressCidrBlocks);
        $networkingServiceAddressCidrBlocks = [];
        $azureClusterNetworking->setServiceAddressCidrBlocks($networkingServiceAddressCidrBlocks);
        $azureCluster->setNetworking($azureClusterNetworking);
        $azureClusterControlPlane = new AzureControlPlane();
        $controlPlaneVersion = 'controlPlaneVersion648040665';
        $azureClusterControlPlane->setVersion($controlPlaneVersion);
        $controlPlaneSshConfig = new AzureSshConfig();
        $sshConfigAuthorizedKey = 'sshConfigAuthorizedKey1626409850';
        $controlPlaneSshConfig->setAuthorizedKey($sshConfigAuthorizedKey);
        $azureClusterControlPlane->setSshConfig($controlPlaneSshConfig);
        $azureCluster->setControlPlane($azureClusterControlPlane);
        $azureClusterAuthorization = new AzureAuthorization();
        $authorizationAdminUsers = [];
        $azureClusterAuthorization->setAdminUsers($authorizationAdminUsers);
        $azureCluster->setAuthorization($azureClusterAuthorization);
        $azureClusterId = 'azureClusterId332577072';
        $response = $client->createAzureCluster($formattedParent, $azureCluster, $azureClusterId);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createAzureClusterTest');
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
    public function createAzureNodePoolTest()
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
        $incompleteOperation->setName('operations/createAzureNodePoolTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $version = 'version351608024';
        $subnetId = 'subnetId373593405';
        $uid = 'uid115792';
        $reconciling = false;
        $etag = 'etag3123477';
        $azureAvailabilityZone = 'azureAvailabilityZone541920864';
        $expectedResponse = new AzureNodePool();
        $expectedResponse->setName($name);
        $expectedResponse->setVersion($version);
        $expectedResponse->setSubnetId($subnetId);
        $expectedResponse->setUid($uid);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setAzureAvailabilityZone($azureAvailabilityZone);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createAzureNodePoolTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $client->azureClusterName('[PROJECT]', '[LOCATION]', '[AZURE_CLUSTER]');
        $azureNodePool = new AzureNodePool();
        $azureNodePoolVersion = 'azureNodePoolVersion349490987';
        $azureNodePool->setVersion($azureNodePoolVersion);
        $azureNodePoolConfig = new AzureNodeConfig();
        $configSshConfig = new AzureSshConfig();
        $sshConfigAuthorizedKey = 'sshConfigAuthorizedKey1626409850';
        $configSshConfig->setAuthorizedKey($sshConfigAuthorizedKey);
        $azureNodePoolConfig->setSshConfig($configSshConfig);
        $azureNodePool->setConfig($azureNodePoolConfig);
        $azureNodePoolSubnetId = 'azureNodePoolSubnetId-2131787419';
        $azureNodePool->setSubnetId($azureNodePoolSubnetId);
        $azureNodePoolAutoscaling = new AzureNodePoolAutoscaling();
        $autoscalingMinNodeCount = 1464441581;
        $azureNodePoolAutoscaling->setMinNodeCount($autoscalingMinNodeCount);
        $autoscalingMaxNodeCount = 1938867647;
        $azureNodePoolAutoscaling->setMaxNodeCount($autoscalingMaxNodeCount);
        $azureNodePool->setAutoscaling($azureNodePoolAutoscaling);
        $azureNodePoolMaxPodsConstraint = new MaxPodsConstraint();
        $maxPodsConstraintMaxPodsPerNode = 1072618940;
        $azureNodePoolMaxPodsConstraint->setMaxPodsPerNode($maxPodsConstraintMaxPodsPerNode);
        $azureNodePool->setMaxPodsConstraint($azureNodePoolMaxPodsConstraint);
        $azureNodePoolId = 'azureNodePoolId-454365551';
        $response = $client->createAzureNodePool($formattedParent, $azureNodePool, $azureNodePoolId);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AzureClusters/CreateAzureNodePool', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getAzureNodePool();
        $this->assertProtobufEquals($azureNodePool, $actualValue);
        $actualValue = $actualApiRequestObject->getAzureNodePoolId();
        $this->assertProtobufEquals($azureNodePoolId, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createAzureNodePoolTest');
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
    public function createAzureNodePoolExceptionTest()
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
        $incompleteOperation->setName('operations/createAzureNodePoolTest');
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
        $formattedParent = $client->azureClusterName('[PROJECT]', '[LOCATION]', '[AZURE_CLUSTER]');
        $azureNodePool = new AzureNodePool();
        $azureNodePoolVersion = 'azureNodePoolVersion349490987';
        $azureNodePool->setVersion($azureNodePoolVersion);
        $azureNodePoolConfig = new AzureNodeConfig();
        $configSshConfig = new AzureSshConfig();
        $sshConfigAuthorizedKey = 'sshConfigAuthorizedKey1626409850';
        $configSshConfig->setAuthorizedKey($sshConfigAuthorizedKey);
        $azureNodePoolConfig->setSshConfig($configSshConfig);
        $azureNodePool->setConfig($azureNodePoolConfig);
        $azureNodePoolSubnetId = 'azureNodePoolSubnetId-2131787419';
        $azureNodePool->setSubnetId($azureNodePoolSubnetId);
        $azureNodePoolAutoscaling = new AzureNodePoolAutoscaling();
        $autoscalingMinNodeCount = 1464441581;
        $azureNodePoolAutoscaling->setMinNodeCount($autoscalingMinNodeCount);
        $autoscalingMaxNodeCount = 1938867647;
        $azureNodePoolAutoscaling->setMaxNodeCount($autoscalingMaxNodeCount);
        $azureNodePool->setAutoscaling($azureNodePoolAutoscaling);
        $azureNodePoolMaxPodsConstraint = new MaxPodsConstraint();
        $maxPodsConstraintMaxPodsPerNode = 1072618940;
        $azureNodePoolMaxPodsConstraint->setMaxPodsPerNode($maxPodsConstraintMaxPodsPerNode);
        $azureNodePool->setMaxPodsConstraint($azureNodePoolMaxPodsConstraint);
        $azureNodePoolId = 'azureNodePoolId-454365551';
        $response = $client->createAzureNodePool($formattedParent, $azureNodePool, $azureNodePoolId);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createAzureNodePoolTest');
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
    public function deleteAzureClientTest()
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
        $incompleteOperation->setName('operations/deleteAzureClientTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteAzureClientTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $client->azureClientName('[PROJECT]', '[LOCATION]', '[AZURE_CLIENT]');
        $response = $client->deleteAzureClient($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AzureClusters/DeleteAzureClient', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteAzureClientTest');
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
    public function deleteAzureClientExceptionTest()
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
        $incompleteOperation->setName('operations/deleteAzureClientTest');
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
        $formattedName = $client->azureClientName('[PROJECT]', '[LOCATION]', '[AZURE_CLIENT]');
        $response = $client->deleteAzureClient($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteAzureClientTest');
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
    public function deleteAzureClusterTest()
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
        $incompleteOperation->setName('operations/deleteAzureClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteAzureClusterTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $client->azureClusterName('[PROJECT]', '[LOCATION]', '[AZURE_CLUSTER]');
        $response = $client->deleteAzureCluster($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AzureClusters/DeleteAzureCluster', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteAzureClusterTest');
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
    public function deleteAzureClusterExceptionTest()
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
        $incompleteOperation->setName('operations/deleteAzureClusterTest');
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
        $formattedName = $client->azureClusterName('[PROJECT]', '[LOCATION]', '[AZURE_CLUSTER]');
        $response = $client->deleteAzureCluster($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteAzureClusterTest');
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
    public function deleteAzureNodePoolTest()
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
        $incompleteOperation->setName('operations/deleteAzureNodePoolTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteAzureNodePoolTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $client->azureNodePoolName('[PROJECT]', '[LOCATION]', '[AZURE_CLUSTER]', '[AZURE_NODE_POOL]');
        $response = $client->deleteAzureNodePool($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AzureClusters/DeleteAzureNodePool', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteAzureNodePoolTest');
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
    public function deleteAzureNodePoolExceptionTest()
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
        $incompleteOperation->setName('operations/deleteAzureNodePoolTest');
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
        $formattedName = $client->azureNodePoolName('[PROJECT]', '[LOCATION]', '[AZURE_CLUSTER]', '[AZURE_NODE_POOL]');
        $response = $client->deleteAzureNodePool($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteAzureNodePoolTest');
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
    public function generateAzureAccessTokenTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $accessToken = 'accessToken-1938933922';
        $expectedResponse = new GenerateAzureAccessTokenResponse();
        $expectedResponse->setAccessToken($accessToken);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedAzureCluster = $client->azureClusterName('[PROJECT]', '[LOCATION]', '[AZURE_CLUSTER]');
        $response = $client->generateAzureAccessToken($formattedAzureCluster);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AzureClusters/GenerateAzureAccessToken', $actualFuncCall);
        $actualValue = $actualRequestObject->getAzureCluster();
        $this->assertProtobufEquals($formattedAzureCluster, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function generateAzureAccessTokenExceptionTest()
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
        $formattedAzureCluster = $client->azureClusterName('[PROJECT]', '[LOCATION]', '[AZURE_CLUSTER]');
        try {
            $client->generateAzureAccessToken($formattedAzureCluster);
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
    public function getAzureClientTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $tenantId = 'tenantId-1852780336';
        $applicationId = 'applicationId-1287148950';
        $pemCertificate = 'pemCertificate1234463984';
        $uid = 'uid115792';
        $expectedResponse = new AzureClient();
        $expectedResponse->setName($name2);
        $expectedResponse->setTenantId($tenantId);
        $expectedResponse->setApplicationId($applicationId);
        $expectedResponse->setPemCertificate($pemCertificate);
        $expectedResponse->setUid($uid);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->azureClientName('[PROJECT]', '[LOCATION]', '[AZURE_CLIENT]');
        $response = $client->getAzureClient($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AzureClusters/GetAzureClient', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getAzureClientExceptionTest()
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
        $formattedName = $client->azureClientName('[PROJECT]', '[LOCATION]', '[AZURE_CLIENT]');
        try {
            $client->getAzureClient($formattedName);
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
    public function getAzureClusterTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $azureRegion = 'azureRegion-253373788';
        $resourceGroupId = 'resourceGroupId-1092054036';
        $azureClient = 'azureClient-676290693';
        $endpoint = 'endpoint1741102485';
        $uid = 'uid115792';
        $reconciling = false;
        $etag = 'etag3123477';
        $clusterCaCertificate = 'clusterCaCertificate1324742683';
        $expectedResponse = new AzureCluster();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setAzureRegion($azureRegion);
        $expectedResponse->setResourceGroupId($resourceGroupId);
        $expectedResponse->setAzureClient($azureClient);
        $expectedResponse->setEndpoint($endpoint);
        $expectedResponse->setUid($uid);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setClusterCaCertificate($clusterCaCertificate);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->azureClusterName('[PROJECT]', '[LOCATION]', '[AZURE_CLUSTER]');
        $response = $client->getAzureCluster($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AzureClusters/GetAzureCluster', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getAzureClusterExceptionTest()
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
        $formattedName = $client->azureClusterName('[PROJECT]', '[LOCATION]', '[AZURE_CLUSTER]');
        try {
            $client->getAzureCluster($formattedName);
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
    public function getAzureNodePoolTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $version = 'version351608024';
        $subnetId = 'subnetId373593405';
        $uid = 'uid115792';
        $reconciling = false;
        $etag = 'etag3123477';
        $azureAvailabilityZone = 'azureAvailabilityZone541920864';
        $expectedResponse = new AzureNodePool();
        $expectedResponse->setName($name2);
        $expectedResponse->setVersion($version);
        $expectedResponse->setSubnetId($subnetId);
        $expectedResponse->setUid($uid);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setAzureAvailabilityZone($azureAvailabilityZone);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->azureNodePoolName('[PROJECT]', '[LOCATION]', '[AZURE_CLUSTER]', '[AZURE_NODE_POOL]');
        $response = $client->getAzureNodePool($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AzureClusters/GetAzureNodePool', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getAzureNodePoolExceptionTest()
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
        $formattedName = $client->azureNodePoolName('[PROJECT]', '[LOCATION]', '[AZURE_CLUSTER]', '[AZURE_NODE_POOL]');
        try {
            $client->getAzureNodePool($formattedName);
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
    public function getAzureServerConfigTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new AzureServerConfig();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->azureServerConfigName('[PROJECT]', '[LOCATION]');
        $response = $client->getAzureServerConfig($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AzureClusters/GetAzureServerConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getAzureServerConfigExceptionTest()
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
        $formattedName = $client->azureServerConfigName('[PROJECT]', '[LOCATION]');
        try {
            $client->getAzureServerConfig($formattedName);
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
    public function listAzureClientsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $azureClientsElement = new AzureClient();
        $azureClients = [
            $azureClientsElement,
        ];
        $expectedResponse = new ListAzureClientsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAzureClients($azureClients);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $response = $client->listAzureClients($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAzureClients()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AzureClusters/ListAzureClients', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listAzureClientsExceptionTest()
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
            $client->listAzureClients($formattedParent);
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
    public function listAzureClustersTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $azureClustersElement = new AzureCluster();
        $azureClusters = [
            $azureClustersElement,
        ];
        $expectedResponse = new ListAzureClustersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAzureClusters($azureClusters);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $response = $client->listAzureClusters($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAzureClusters()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AzureClusters/ListAzureClusters', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listAzureClustersExceptionTest()
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
            $client->listAzureClusters($formattedParent);
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
    public function listAzureNodePoolsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $azureNodePoolsElement = new AzureNodePool();
        $azureNodePools = [
            $azureNodePoolsElement,
        ];
        $expectedResponse = new ListAzureNodePoolsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAzureNodePools($azureNodePools);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->azureClusterName('[PROJECT]', '[LOCATION]', '[AZURE_CLUSTER]');
        $response = $client->listAzureNodePools($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAzureNodePools()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AzureClusters/ListAzureNodePools', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listAzureNodePoolsExceptionTest()
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
        $formattedParent = $client->azureClusterName('[PROJECT]', '[LOCATION]', '[AZURE_CLUSTER]');
        try {
            $client->listAzureNodePools($formattedParent);
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
    public function updateAzureClusterTest()
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
        $incompleteOperation->setName('operations/updateAzureClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $description = 'description-1724546052';
        $azureRegion = 'azureRegion-253373788';
        $resourceGroupId = 'resourceGroupId-1092054036';
        $azureClient = 'azureClient-676290693';
        $endpoint = 'endpoint1741102485';
        $uid = 'uid115792';
        $reconciling = false;
        $etag = 'etag3123477';
        $clusterCaCertificate = 'clusterCaCertificate1324742683';
        $expectedResponse = new AzureCluster();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setAzureRegion($azureRegion);
        $expectedResponse->setResourceGroupId($resourceGroupId);
        $expectedResponse->setAzureClient($azureClient);
        $expectedResponse->setEndpoint($endpoint);
        $expectedResponse->setUid($uid);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setClusterCaCertificate($clusterCaCertificate);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/updateAzureClusterTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $azureCluster = new AzureCluster();
        $azureClusterAzureRegion = 'azureClusterAzureRegion-1036501768';
        $azureCluster->setAzureRegion($azureClusterAzureRegion);
        $azureClusterResourceGroupId = 'azureClusterResourceGroupId-1683734495';
        $azureCluster->setResourceGroupId($azureClusterResourceGroupId);
        $azureClusterAzureClient = 'azureClusterAzureClient-1459418673';
        $azureCluster->setAzureClient($azureClusterAzureClient);
        $azureClusterNetworking = new AzureClusterNetworking();
        $networkingVirtualNetworkId = 'networkingVirtualNetworkId-516550606';
        $azureClusterNetworking->setVirtualNetworkId($networkingVirtualNetworkId);
        $networkingPodAddressCidrBlocks = [];
        $azureClusterNetworking->setPodAddressCidrBlocks($networkingPodAddressCidrBlocks);
        $networkingServiceAddressCidrBlocks = [];
        $azureClusterNetworking->setServiceAddressCidrBlocks($networkingServiceAddressCidrBlocks);
        $azureCluster->setNetworking($azureClusterNetworking);
        $azureClusterControlPlane = new AzureControlPlane();
        $controlPlaneVersion = 'controlPlaneVersion648040665';
        $azureClusterControlPlane->setVersion($controlPlaneVersion);
        $controlPlaneSshConfig = new AzureSshConfig();
        $sshConfigAuthorizedKey = 'sshConfigAuthorizedKey1626409850';
        $controlPlaneSshConfig->setAuthorizedKey($sshConfigAuthorizedKey);
        $azureClusterControlPlane->setSshConfig($controlPlaneSshConfig);
        $azureCluster->setControlPlane($azureClusterControlPlane);
        $azureClusterAuthorization = new AzureAuthorization();
        $authorizationAdminUsers = [];
        $azureClusterAuthorization->setAdminUsers($authorizationAdminUsers);
        $azureCluster->setAuthorization($azureClusterAuthorization);
        $updateMask = new FieldMask();
        $response = $client->updateAzureCluster($azureCluster, $updateMask);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AzureClusters/UpdateAzureCluster', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getAzureCluster();
        $this->assertProtobufEquals($azureCluster, $actualValue);
        $actualValue = $actualApiRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateAzureClusterTest');
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
    public function updateAzureClusterExceptionTest()
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
        $incompleteOperation->setName('operations/updateAzureClusterTest');
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
        $azureCluster = new AzureCluster();
        $azureClusterAzureRegion = 'azureClusterAzureRegion-1036501768';
        $azureCluster->setAzureRegion($azureClusterAzureRegion);
        $azureClusterResourceGroupId = 'azureClusterResourceGroupId-1683734495';
        $azureCluster->setResourceGroupId($azureClusterResourceGroupId);
        $azureClusterAzureClient = 'azureClusterAzureClient-1459418673';
        $azureCluster->setAzureClient($azureClusterAzureClient);
        $azureClusterNetworking = new AzureClusterNetworking();
        $networkingVirtualNetworkId = 'networkingVirtualNetworkId-516550606';
        $azureClusterNetworking->setVirtualNetworkId($networkingVirtualNetworkId);
        $networkingPodAddressCidrBlocks = [];
        $azureClusterNetworking->setPodAddressCidrBlocks($networkingPodAddressCidrBlocks);
        $networkingServiceAddressCidrBlocks = [];
        $azureClusterNetworking->setServiceAddressCidrBlocks($networkingServiceAddressCidrBlocks);
        $azureCluster->setNetworking($azureClusterNetworking);
        $azureClusterControlPlane = new AzureControlPlane();
        $controlPlaneVersion = 'controlPlaneVersion648040665';
        $azureClusterControlPlane->setVersion($controlPlaneVersion);
        $controlPlaneSshConfig = new AzureSshConfig();
        $sshConfigAuthorizedKey = 'sshConfigAuthorizedKey1626409850';
        $controlPlaneSshConfig->setAuthorizedKey($sshConfigAuthorizedKey);
        $azureClusterControlPlane->setSshConfig($controlPlaneSshConfig);
        $azureCluster->setControlPlane($azureClusterControlPlane);
        $azureClusterAuthorization = new AzureAuthorization();
        $authorizationAdminUsers = [];
        $azureClusterAuthorization->setAdminUsers($authorizationAdminUsers);
        $azureCluster->setAuthorization($azureClusterAuthorization);
        $updateMask = new FieldMask();
        $response = $client->updateAzureCluster($azureCluster, $updateMask);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateAzureClusterTest');
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
    public function updateAzureNodePoolTest()
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
        $incompleteOperation->setName('operations/updateAzureNodePoolTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $version = 'version351608024';
        $subnetId = 'subnetId373593405';
        $uid = 'uid115792';
        $reconciling = false;
        $etag = 'etag3123477';
        $azureAvailabilityZone = 'azureAvailabilityZone541920864';
        $expectedResponse = new AzureNodePool();
        $expectedResponse->setName($name);
        $expectedResponse->setVersion($version);
        $expectedResponse->setSubnetId($subnetId);
        $expectedResponse->setUid($uid);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setAzureAvailabilityZone($azureAvailabilityZone);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/updateAzureNodePoolTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $azureNodePool = new AzureNodePool();
        $azureNodePoolVersion = 'azureNodePoolVersion349490987';
        $azureNodePool->setVersion($azureNodePoolVersion);
        $azureNodePoolConfig = new AzureNodeConfig();
        $configSshConfig = new AzureSshConfig();
        $sshConfigAuthorizedKey = 'sshConfigAuthorizedKey1626409850';
        $configSshConfig->setAuthorizedKey($sshConfigAuthorizedKey);
        $azureNodePoolConfig->setSshConfig($configSshConfig);
        $azureNodePool->setConfig($azureNodePoolConfig);
        $azureNodePoolSubnetId = 'azureNodePoolSubnetId-2131787419';
        $azureNodePool->setSubnetId($azureNodePoolSubnetId);
        $azureNodePoolAutoscaling = new AzureNodePoolAutoscaling();
        $autoscalingMinNodeCount = 1464441581;
        $azureNodePoolAutoscaling->setMinNodeCount($autoscalingMinNodeCount);
        $autoscalingMaxNodeCount = 1938867647;
        $azureNodePoolAutoscaling->setMaxNodeCount($autoscalingMaxNodeCount);
        $azureNodePool->setAutoscaling($azureNodePoolAutoscaling);
        $azureNodePoolMaxPodsConstraint = new MaxPodsConstraint();
        $maxPodsConstraintMaxPodsPerNode = 1072618940;
        $azureNodePoolMaxPodsConstraint->setMaxPodsPerNode($maxPodsConstraintMaxPodsPerNode);
        $azureNodePool->setMaxPodsConstraint($azureNodePoolMaxPodsConstraint);
        $updateMask = new FieldMask();
        $response = $client->updateAzureNodePool($azureNodePool, $updateMask);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AzureClusters/UpdateAzureNodePool', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getAzureNodePool();
        $this->assertProtobufEquals($azureNodePool, $actualValue);
        $actualValue = $actualApiRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateAzureNodePoolTest');
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
    public function updateAzureNodePoolExceptionTest()
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
        $incompleteOperation->setName('operations/updateAzureNodePoolTest');
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
        $azureNodePool = new AzureNodePool();
        $azureNodePoolVersion = 'azureNodePoolVersion349490987';
        $azureNodePool->setVersion($azureNodePoolVersion);
        $azureNodePoolConfig = new AzureNodeConfig();
        $configSshConfig = new AzureSshConfig();
        $sshConfigAuthorizedKey = 'sshConfigAuthorizedKey1626409850';
        $configSshConfig->setAuthorizedKey($sshConfigAuthorizedKey);
        $azureNodePoolConfig->setSshConfig($configSshConfig);
        $azureNodePool->setConfig($azureNodePoolConfig);
        $azureNodePoolSubnetId = 'azureNodePoolSubnetId-2131787419';
        $azureNodePool->setSubnetId($azureNodePoolSubnetId);
        $azureNodePoolAutoscaling = new AzureNodePoolAutoscaling();
        $autoscalingMinNodeCount = 1464441581;
        $azureNodePoolAutoscaling->setMinNodeCount($autoscalingMinNodeCount);
        $autoscalingMaxNodeCount = 1938867647;
        $azureNodePoolAutoscaling->setMaxNodeCount($autoscalingMaxNodeCount);
        $azureNodePool->setAutoscaling($azureNodePoolAutoscaling);
        $azureNodePoolMaxPodsConstraint = new MaxPodsConstraint();
        $maxPodsConstraintMaxPodsPerNode = 1072618940;
        $azureNodePoolMaxPodsConstraint->setMaxPodsPerNode($maxPodsConstraintMaxPodsPerNode);
        $azureNodePool->setMaxPodsConstraint($azureNodePoolMaxPodsConstraint);
        $updateMask = new FieldMask();
        $response = $client->updateAzureNodePool($azureNodePool, $updateMask);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateAzureNodePoolTest');
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
