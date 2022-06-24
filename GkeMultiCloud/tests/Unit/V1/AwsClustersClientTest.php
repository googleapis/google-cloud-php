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
use Google\Cloud\GkeMultiCloud\V1\AwsAuthorization;
use Google\Cloud\GkeMultiCloud\V1\AwsCluster;

use Google\Cloud\GkeMultiCloud\V1\AwsClusterNetworking;
use Google\Cloud\GkeMultiCloud\V1\AwsClustersClient;
use Google\Cloud\GkeMultiCloud\V1\AwsConfigEncryption;
use Google\Cloud\GkeMultiCloud\V1\AwsControlPlane;
use Google\Cloud\GkeMultiCloud\V1\AwsDatabaseEncryption;
use Google\Cloud\GkeMultiCloud\V1\AwsNodeConfig;
use Google\Cloud\GkeMultiCloud\V1\AwsNodePool;
use Google\Cloud\GkeMultiCloud\V1\AwsNodePoolAutoscaling;
use Google\Cloud\GkeMultiCloud\V1\AwsServerConfig;
use Google\Cloud\GkeMultiCloud\V1\AwsServicesAuthentication;
use Google\Cloud\GkeMultiCloud\V1\GenerateAwsAccessTokenResponse;
use Google\Cloud\GkeMultiCloud\V1\ListAwsClustersResponse;
use Google\Cloud\GkeMultiCloud\V1\ListAwsNodePoolsResponse;
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
class AwsClustersClientTest extends GeneratedTest
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
     * @return AwsClustersClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AwsClustersClient($options);
    }

    /**
     * @test
     */
    public function createAwsClusterTest()
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
        $incompleteOperation->setName('operations/createAwsClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $description = 'description-1724546052';
        $awsRegion = 'awsRegion-1887255946';
        $endpoint = 'endpoint1741102485';
        $uid = 'uid115792';
        $reconciling = false;
        $etag = 'etag3123477';
        $clusterCaCertificate = 'clusterCaCertificate1324742683';
        $expectedResponse = new AwsCluster();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setAwsRegion($awsRegion);
        $expectedResponse->setEndpoint($endpoint);
        $expectedResponse->setUid($uid);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setClusterCaCertificate($clusterCaCertificate);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createAwsClusterTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $awsCluster = new AwsCluster();
        $awsClusterNetworking = new AwsClusterNetworking();
        $networkingVpcId = 'networkingVpcId-1154507440';
        $awsClusterNetworking->setVpcId($networkingVpcId);
        $networkingPodAddressCidrBlocks = [];
        $awsClusterNetworking->setPodAddressCidrBlocks($networkingPodAddressCidrBlocks);
        $networkingServiceAddressCidrBlocks = [];
        $awsClusterNetworking->setServiceAddressCidrBlocks($networkingServiceAddressCidrBlocks);
        $awsCluster->setNetworking($awsClusterNetworking);
        $awsClusterAwsRegion = 'awsClusterAwsRegion574122132';
        $awsCluster->setAwsRegion($awsClusterAwsRegion);
        $awsClusterControlPlane = new AwsControlPlane();
        $controlPlaneVersion = 'controlPlaneVersion648040665';
        $awsClusterControlPlane->setVersion($controlPlaneVersion);
        $controlPlaneSubnetIds = [];
        $awsClusterControlPlane->setSubnetIds($controlPlaneSubnetIds);
        $controlPlaneIamInstanceProfile = 'controlPlaneIamInstanceProfile1905273246';
        $awsClusterControlPlane->setIamInstanceProfile($controlPlaneIamInstanceProfile);
        $controlPlaneDatabaseEncryption = new AwsDatabaseEncryption();
        $databaseEncryptionKmsKeyArn = 'databaseEncryptionKmsKeyArn1858324593';
        $controlPlaneDatabaseEncryption->setKmsKeyArn($databaseEncryptionKmsKeyArn);
        $awsClusterControlPlane->setDatabaseEncryption($controlPlaneDatabaseEncryption);
        $controlPlaneAwsServicesAuthentication = new AwsServicesAuthentication();
        $awsServicesAuthenticationRoleArn = 'awsServicesAuthenticationRoleArn1905212596';
        $controlPlaneAwsServicesAuthentication->setRoleArn($awsServicesAuthenticationRoleArn);
        $awsClusterControlPlane->setAwsServicesAuthentication($controlPlaneAwsServicesAuthentication);
        $controlPlaneConfigEncryption = new AwsConfigEncryption();
        $configEncryptionKmsKeyArn = 'configEncryptionKmsKeyArn-992257206';
        $controlPlaneConfigEncryption->setKmsKeyArn($configEncryptionKmsKeyArn);
        $awsClusterControlPlane->setConfigEncryption($controlPlaneConfigEncryption);
        $awsCluster->setControlPlane($awsClusterControlPlane);
        $awsClusterAuthorization = new AwsAuthorization();
        $authorizationAdminUsers = [];
        $awsClusterAuthorization->setAdminUsers($authorizationAdminUsers);
        $awsCluster->setAuthorization($awsClusterAuthorization);
        $awsClusterId = 'awsClusterId938438658';
        $response = $client->createAwsCluster($formattedParent, $awsCluster, $awsClusterId);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AwsClusters/CreateAwsCluster', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getAwsCluster();
        $this->assertProtobufEquals($awsCluster, $actualValue);
        $actualValue = $actualApiRequestObject->getAwsClusterId();
        $this->assertProtobufEquals($awsClusterId, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createAwsClusterTest');
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
    public function createAwsClusterExceptionTest()
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
        $incompleteOperation->setName('operations/createAwsClusterTest');
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
        $awsCluster = new AwsCluster();
        $awsClusterNetworking = new AwsClusterNetworking();
        $networkingVpcId = 'networkingVpcId-1154507440';
        $awsClusterNetworking->setVpcId($networkingVpcId);
        $networkingPodAddressCidrBlocks = [];
        $awsClusterNetworking->setPodAddressCidrBlocks($networkingPodAddressCidrBlocks);
        $networkingServiceAddressCidrBlocks = [];
        $awsClusterNetworking->setServiceAddressCidrBlocks($networkingServiceAddressCidrBlocks);
        $awsCluster->setNetworking($awsClusterNetworking);
        $awsClusterAwsRegion = 'awsClusterAwsRegion574122132';
        $awsCluster->setAwsRegion($awsClusterAwsRegion);
        $awsClusterControlPlane = new AwsControlPlane();
        $controlPlaneVersion = 'controlPlaneVersion648040665';
        $awsClusterControlPlane->setVersion($controlPlaneVersion);
        $controlPlaneSubnetIds = [];
        $awsClusterControlPlane->setSubnetIds($controlPlaneSubnetIds);
        $controlPlaneIamInstanceProfile = 'controlPlaneIamInstanceProfile1905273246';
        $awsClusterControlPlane->setIamInstanceProfile($controlPlaneIamInstanceProfile);
        $controlPlaneDatabaseEncryption = new AwsDatabaseEncryption();
        $databaseEncryptionKmsKeyArn = 'databaseEncryptionKmsKeyArn1858324593';
        $controlPlaneDatabaseEncryption->setKmsKeyArn($databaseEncryptionKmsKeyArn);
        $awsClusterControlPlane->setDatabaseEncryption($controlPlaneDatabaseEncryption);
        $controlPlaneAwsServicesAuthentication = new AwsServicesAuthentication();
        $awsServicesAuthenticationRoleArn = 'awsServicesAuthenticationRoleArn1905212596';
        $controlPlaneAwsServicesAuthentication->setRoleArn($awsServicesAuthenticationRoleArn);
        $awsClusterControlPlane->setAwsServicesAuthentication($controlPlaneAwsServicesAuthentication);
        $controlPlaneConfigEncryption = new AwsConfigEncryption();
        $configEncryptionKmsKeyArn = 'configEncryptionKmsKeyArn-992257206';
        $controlPlaneConfigEncryption->setKmsKeyArn($configEncryptionKmsKeyArn);
        $awsClusterControlPlane->setConfigEncryption($controlPlaneConfigEncryption);
        $awsCluster->setControlPlane($awsClusterControlPlane);
        $awsClusterAuthorization = new AwsAuthorization();
        $authorizationAdminUsers = [];
        $awsClusterAuthorization->setAdminUsers($authorizationAdminUsers);
        $awsCluster->setAuthorization($awsClusterAuthorization);
        $awsClusterId = 'awsClusterId938438658';
        $response = $client->createAwsCluster($formattedParent, $awsCluster, $awsClusterId);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createAwsClusterTest');
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
    public function createAwsNodePoolTest()
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
        $incompleteOperation->setName('operations/createAwsNodePoolTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $version = 'version351608024';
        $subnetId = 'subnetId373593405';
        $uid = 'uid115792';
        $reconciling = false;
        $etag = 'etag3123477';
        $expectedResponse = new AwsNodePool();
        $expectedResponse->setName($name);
        $expectedResponse->setVersion($version);
        $expectedResponse->setSubnetId($subnetId);
        $expectedResponse->setUid($uid);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setEtag($etag);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createAwsNodePoolTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $client->awsClusterName('[PROJECT]', '[LOCATION]', '[AWS_CLUSTER]');
        $awsNodePool = new AwsNodePool();
        $awsNodePoolVersion = 'awsNodePoolVersion-617231107';
        $awsNodePool->setVersion($awsNodePoolVersion);
        $awsNodePoolConfig = new AwsNodeConfig();
        $configIamInstanceProfile = 'configIamInstanceProfile805825313';
        $awsNodePoolConfig->setIamInstanceProfile($configIamInstanceProfile);
        $configConfigEncryption = new AwsConfigEncryption();
        $configEncryptionKmsKeyArn = 'configEncryptionKmsKeyArn-992257206';
        $configConfigEncryption->setKmsKeyArn($configEncryptionKmsKeyArn);
        $awsNodePoolConfig->setConfigEncryption($configConfigEncryption);
        $awsNodePool->setConfig($awsNodePoolConfig);
        $awsNodePoolAutoscaling = new AwsNodePoolAutoscaling();
        $autoscalingMinNodeCount = 1464441581;
        $awsNodePoolAutoscaling->setMinNodeCount($autoscalingMinNodeCount);
        $autoscalingMaxNodeCount = 1938867647;
        $awsNodePoolAutoscaling->setMaxNodeCount($autoscalingMaxNodeCount);
        $awsNodePool->setAutoscaling($awsNodePoolAutoscaling);
        $awsNodePoolSubnetId = 'awsNodePoolSubnetId-2035401261';
        $awsNodePool->setSubnetId($awsNodePoolSubnetId);
        $awsNodePoolMaxPodsConstraint = new MaxPodsConstraint();
        $maxPodsConstraintMaxPodsPerNode = 1072618940;
        $awsNodePoolMaxPodsConstraint->setMaxPodsPerNode($maxPodsConstraintMaxPodsPerNode);
        $awsNodePool->setMaxPodsConstraint($awsNodePoolMaxPodsConstraint);
        $awsNodePoolId = 'awsNodePoolId1958033635';
        $response = $client->createAwsNodePool($formattedParent, $awsNodePool, $awsNodePoolId);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AwsClusters/CreateAwsNodePool', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getAwsNodePool();
        $this->assertProtobufEquals($awsNodePool, $actualValue);
        $actualValue = $actualApiRequestObject->getAwsNodePoolId();
        $this->assertProtobufEquals($awsNodePoolId, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createAwsNodePoolTest');
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
    public function createAwsNodePoolExceptionTest()
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
        $incompleteOperation->setName('operations/createAwsNodePoolTest');
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
        $formattedParent = $client->awsClusterName('[PROJECT]', '[LOCATION]', '[AWS_CLUSTER]');
        $awsNodePool = new AwsNodePool();
        $awsNodePoolVersion = 'awsNodePoolVersion-617231107';
        $awsNodePool->setVersion($awsNodePoolVersion);
        $awsNodePoolConfig = new AwsNodeConfig();
        $configIamInstanceProfile = 'configIamInstanceProfile805825313';
        $awsNodePoolConfig->setIamInstanceProfile($configIamInstanceProfile);
        $configConfigEncryption = new AwsConfigEncryption();
        $configEncryptionKmsKeyArn = 'configEncryptionKmsKeyArn-992257206';
        $configConfigEncryption->setKmsKeyArn($configEncryptionKmsKeyArn);
        $awsNodePoolConfig->setConfigEncryption($configConfigEncryption);
        $awsNodePool->setConfig($awsNodePoolConfig);
        $awsNodePoolAutoscaling = new AwsNodePoolAutoscaling();
        $autoscalingMinNodeCount = 1464441581;
        $awsNodePoolAutoscaling->setMinNodeCount($autoscalingMinNodeCount);
        $autoscalingMaxNodeCount = 1938867647;
        $awsNodePoolAutoscaling->setMaxNodeCount($autoscalingMaxNodeCount);
        $awsNodePool->setAutoscaling($awsNodePoolAutoscaling);
        $awsNodePoolSubnetId = 'awsNodePoolSubnetId-2035401261';
        $awsNodePool->setSubnetId($awsNodePoolSubnetId);
        $awsNodePoolMaxPodsConstraint = new MaxPodsConstraint();
        $maxPodsConstraintMaxPodsPerNode = 1072618940;
        $awsNodePoolMaxPodsConstraint->setMaxPodsPerNode($maxPodsConstraintMaxPodsPerNode);
        $awsNodePool->setMaxPodsConstraint($awsNodePoolMaxPodsConstraint);
        $awsNodePoolId = 'awsNodePoolId1958033635';
        $response = $client->createAwsNodePool($formattedParent, $awsNodePool, $awsNodePoolId);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createAwsNodePoolTest');
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
    public function deleteAwsClusterTest()
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
        $incompleteOperation->setName('operations/deleteAwsClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteAwsClusterTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $client->awsClusterName('[PROJECT]', '[LOCATION]', '[AWS_CLUSTER]');
        $response = $client->deleteAwsCluster($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AwsClusters/DeleteAwsCluster', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteAwsClusterTest');
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
    public function deleteAwsClusterExceptionTest()
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
        $incompleteOperation->setName('operations/deleteAwsClusterTest');
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
        $formattedName = $client->awsClusterName('[PROJECT]', '[LOCATION]', '[AWS_CLUSTER]');
        $response = $client->deleteAwsCluster($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteAwsClusterTest');
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
    public function deleteAwsNodePoolTest()
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
        $incompleteOperation->setName('operations/deleteAwsNodePoolTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteAwsNodePoolTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $client->awsNodePoolName('[PROJECT]', '[LOCATION]', '[AWS_CLUSTER]', '[AWS_NODE_POOL]');
        $response = $client->deleteAwsNodePool($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AwsClusters/DeleteAwsNodePool', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteAwsNodePoolTest');
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
    public function deleteAwsNodePoolExceptionTest()
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
        $incompleteOperation->setName('operations/deleteAwsNodePoolTest');
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
        $formattedName = $client->awsNodePoolName('[PROJECT]', '[LOCATION]', '[AWS_CLUSTER]', '[AWS_NODE_POOL]');
        $response = $client->deleteAwsNodePool($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteAwsNodePoolTest');
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
    public function generateAwsAccessTokenTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $accessToken = 'accessToken-1938933922';
        $expectedResponse = new GenerateAwsAccessTokenResponse();
        $expectedResponse->setAccessToken($accessToken);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedAwsCluster = $client->awsClusterName('[PROJECT]', '[LOCATION]', '[AWS_CLUSTER]');
        $response = $client->generateAwsAccessToken($formattedAwsCluster);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AwsClusters/GenerateAwsAccessToken', $actualFuncCall);
        $actualValue = $actualRequestObject->getAwsCluster();
        $this->assertProtobufEquals($formattedAwsCluster, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function generateAwsAccessTokenExceptionTest()
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
        $formattedAwsCluster = $client->awsClusterName('[PROJECT]', '[LOCATION]', '[AWS_CLUSTER]');
        try {
            $client->generateAwsAccessToken($formattedAwsCluster);
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
    public function getAwsClusterTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $awsRegion = 'awsRegion-1887255946';
        $endpoint = 'endpoint1741102485';
        $uid = 'uid115792';
        $reconciling = false;
        $etag = 'etag3123477';
        $clusterCaCertificate = 'clusterCaCertificate1324742683';
        $expectedResponse = new AwsCluster();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setAwsRegion($awsRegion);
        $expectedResponse->setEndpoint($endpoint);
        $expectedResponse->setUid($uid);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setClusterCaCertificate($clusterCaCertificate);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->awsClusterName('[PROJECT]', '[LOCATION]', '[AWS_CLUSTER]');
        $response = $client->getAwsCluster($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AwsClusters/GetAwsCluster', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getAwsClusterExceptionTest()
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
        $formattedName = $client->awsClusterName('[PROJECT]', '[LOCATION]', '[AWS_CLUSTER]');
        try {
            $client->getAwsCluster($formattedName);
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
    public function getAwsNodePoolTest()
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
        $expectedResponse = new AwsNodePool();
        $expectedResponse->setName($name2);
        $expectedResponse->setVersion($version);
        $expectedResponse->setSubnetId($subnetId);
        $expectedResponse->setUid($uid);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->awsNodePoolName('[PROJECT]', '[LOCATION]', '[AWS_CLUSTER]', '[AWS_NODE_POOL]');
        $response = $client->getAwsNodePool($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AwsClusters/GetAwsNodePool', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getAwsNodePoolExceptionTest()
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
        $formattedName = $client->awsNodePoolName('[PROJECT]', '[LOCATION]', '[AWS_CLUSTER]', '[AWS_NODE_POOL]');
        try {
            $client->getAwsNodePool($formattedName);
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
    public function getAwsServerConfigTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new AwsServerConfig();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->awsServerConfigName('[PROJECT]', '[LOCATION]');
        $response = $client->getAwsServerConfig($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AwsClusters/GetAwsServerConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getAwsServerConfigExceptionTest()
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
        $formattedName = $client->awsServerConfigName('[PROJECT]', '[LOCATION]');
        try {
            $client->getAwsServerConfig($formattedName);
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
    public function listAwsClustersTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $awsClustersElement = new AwsCluster();
        $awsClusters = [
            $awsClustersElement,
        ];
        $expectedResponse = new ListAwsClustersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAwsClusters($awsClusters);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $response = $client->listAwsClusters($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAwsClusters()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AwsClusters/ListAwsClusters', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listAwsClustersExceptionTest()
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
            $client->listAwsClusters($formattedParent);
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
    public function listAwsNodePoolsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $awsNodePoolsElement = new AwsNodePool();
        $awsNodePools = [
            $awsNodePoolsElement,
        ];
        $expectedResponse = new ListAwsNodePoolsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAwsNodePools($awsNodePools);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->awsClusterName('[PROJECT]', '[LOCATION]', '[AWS_CLUSTER]');
        $response = $client->listAwsNodePools($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAwsNodePools()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AwsClusters/ListAwsNodePools', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listAwsNodePoolsExceptionTest()
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
        $formattedParent = $client->awsClusterName('[PROJECT]', '[LOCATION]', '[AWS_CLUSTER]');
        try {
            $client->listAwsNodePools($formattedParent);
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
    public function updateAwsClusterTest()
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
        $incompleteOperation->setName('operations/updateAwsClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $description = 'description-1724546052';
        $awsRegion = 'awsRegion-1887255946';
        $endpoint = 'endpoint1741102485';
        $uid = 'uid115792';
        $reconciling = false;
        $etag = 'etag3123477';
        $clusterCaCertificate = 'clusterCaCertificate1324742683';
        $expectedResponse = new AwsCluster();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setAwsRegion($awsRegion);
        $expectedResponse->setEndpoint($endpoint);
        $expectedResponse->setUid($uid);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setClusterCaCertificate($clusterCaCertificate);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/updateAwsClusterTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $awsCluster = new AwsCluster();
        $awsClusterNetworking = new AwsClusterNetworking();
        $networkingVpcId = 'networkingVpcId-1154507440';
        $awsClusterNetworking->setVpcId($networkingVpcId);
        $networkingPodAddressCidrBlocks = [];
        $awsClusterNetworking->setPodAddressCidrBlocks($networkingPodAddressCidrBlocks);
        $networkingServiceAddressCidrBlocks = [];
        $awsClusterNetworking->setServiceAddressCidrBlocks($networkingServiceAddressCidrBlocks);
        $awsCluster->setNetworking($awsClusterNetworking);
        $awsClusterAwsRegion = 'awsClusterAwsRegion574122132';
        $awsCluster->setAwsRegion($awsClusterAwsRegion);
        $awsClusterControlPlane = new AwsControlPlane();
        $controlPlaneVersion = 'controlPlaneVersion648040665';
        $awsClusterControlPlane->setVersion($controlPlaneVersion);
        $controlPlaneSubnetIds = [];
        $awsClusterControlPlane->setSubnetIds($controlPlaneSubnetIds);
        $controlPlaneIamInstanceProfile = 'controlPlaneIamInstanceProfile1905273246';
        $awsClusterControlPlane->setIamInstanceProfile($controlPlaneIamInstanceProfile);
        $controlPlaneDatabaseEncryption = new AwsDatabaseEncryption();
        $databaseEncryptionKmsKeyArn = 'databaseEncryptionKmsKeyArn1858324593';
        $controlPlaneDatabaseEncryption->setKmsKeyArn($databaseEncryptionKmsKeyArn);
        $awsClusterControlPlane->setDatabaseEncryption($controlPlaneDatabaseEncryption);
        $controlPlaneAwsServicesAuthentication = new AwsServicesAuthentication();
        $awsServicesAuthenticationRoleArn = 'awsServicesAuthenticationRoleArn1905212596';
        $controlPlaneAwsServicesAuthentication->setRoleArn($awsServicesAuthenticationRoleArn);
        $awsClusterControlPlane->setAwsServicesAuthentication($controlPlaneAwsServicesAuthentication);
        $controlPlaneConfigEncryption = new AwsConfigEncryption();
        $configEncryptionKmsKeyArn = 'configEncryptionKmsKeyArn-992257206';
        $controlPlaneConfigEncryption->setKmsKeyArn($configEncryptionKmsKeyArn);
        $awsClusterControlPlane->setConfigEncryption($controlPlaneConfigEncryption);
        $awsCluster->setControlPlane($awsClusterControlPlane);
        $awsClusterAuthorization = new AwsAuthorization();
        $authorizationAdminUsers = [];
        $awsClusterAuthorization->setAdminUsers($authorizationAdminUsers);
        $awsCluster->setAuthorization($awsClusterAuthorization);
        $updateMask = new FieldMask();
        $response = $client->updateAwsCluster($awsCluster, $updateMask);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AwsClusters/UpdateAwsCluster', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getAwsCluster();
        $this->assertProtobufEquals($awsCluster, $actualValue);
        $actualValue = $actualApiRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateAwsClusterTest');
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
    public function updateAwsClusterExceptionTest()
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
        $incompleteOperation->setName('operations/updateAwsClusterTest');
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
        $awsCluster = new AwsCluster();
        $awsClusterNetworking = new AwsClusterNetworking();
        $networkingVpcId = 'networkingVpcId-1154507440';
        $awsClusterNetworking->setVpcId($networkingVpcId);
        $networkingPodAddressCidrBlocks = [];
        $awsClusterNetworking->setPodAddressCidrBlocks($networkingPodAddressCidrBlocks);
        $networkingServiceAddressCidrBlocks = [];
        $awsClusterNetworking->setServiceAddressCidrBlocks($networkingServiceAddressCidrBlocks);
        $awsCluster->setNetworking($awsClusterNetworking);
        $awsClusterAwsRegion = 'awsClusterAwsRegion574122132';
        $awsCluster->setAwsRegion($awsClusterAwsRegion);
        $awsClusterControlPlane = new AwsControlPlane();
        $controlPlaneVersion = 'controlPlaneVersion648040665';
        $awsClusterControlPlane->setVersion($controlPlaneVersion);
        $controlPlaneSubnetIds = [];
        $awsClusterControlPlane->setSubnetIds($controlPlaneSubnetIds);
        $controlPlaneIamInstanceProfile = 'controlPlaneIamInstanceProfile1905273246';
        $awsClusterControlPlane->setIamInstanceProfile($controlPlaneIamInstanceProfile);
        $controlPlaneDatabaseEncryption = new AwsDatabaseEncryption();
        $databaseEncryptionKmsKeyArn = 'databaseEncryptionKmsKeyArn1858324593';
        $controlPlaneDatabaseEncryption->setKmsKeyArn($databaseEncryptionKmsKeyArn);
        $awsClusterControlPlane->setDatabaseEncryption($controlPlaneDatabaseEncryption);
        $controlPlaneAwsServicesAuthentication = new AwsServicesAuthentication();
        $awsServicesAuthenticationRoleArn = 'awsServicesAuthenticationRoleArn1905212596';
        $controlPlaneAwsServicesAuthentication->setRoleArn($awsServicesAuthenticationRoleArn);
        $awsClusterControlPlane->setAwsServicesAuthentication($controlPlaneAwsServicesAuthentication);
        $controlPlaneConfigEncryption = new AwsConfigEncryption();
        $configEncryptionKmsKeyArn = 'configEncryptionKmsKeyArn-992257206';
        $controlPlaneConfigEncryption->setKmsKeyArn($configEncryptionKmsKeyArn);
        $awsClusterControlPlane->setConfigEncryption($controlPlaneConfigEncryption);
        $awsCluster->setControlPlane($awsClusterControlPlane);
        $awsClusterAuthorization = new AwsAuthorization();
        $authorizationAdminUsers = [];
        $awsClusterAuthorization->setAdminUsers($authorizationAdminUsers);
        $awsCluster->setAuthorization($awsClusterAuthorization);
        $updateMask = new FieldMask();
        $response = $client->updateAwsCluster($awsCluster, $updateMask);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateAwsClusterTest');
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
    public function updateAwsNodePoolTest()
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
        $incompleteOperation->setName('operations/updateAwsNodePoolTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $version = 'version351608024';
        $subnetId = 'subnetId373593405';
        $uid = 'uid115792';
        $reconciling = false;
        $etag = 'etag3123477';
        $expectedResponse = new AwsNodePool();
        $expectedResponse->setName($name);
        $expectedResponse->setVersion($version);
        $expectedResponse->setSubnetId($subnetId);
        $expectedResponse->setUid($uid);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setEtag($etag);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/updateAwsNodePoolTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $awsNodePool = new AwsNodePool();
        $awsNodePoolVersion = 'awsNodePoolVersion-617231107';
        $awsNodePool->setVersion($awsNodePoolVersion);
        $awsNodePoolConfig = new AwsNodeConfig();
        $configIamInstanceProfile = 'configIamInstanceProfile805825313';
        $awsNodePoolConfig->setIamInstanceProfile($configIamInstanceProfile);
        $configConfigEncryption = new AwsConfigEncryption();
        $configEncryptionKmsKeyArn = 'configEncryptionKmsKeyArn-992257206';
        $configConfigEncryption->setKmsKeyArn($configEncryptionKmsKeyArn);
        $awsNodePoolConfig->setConfigEncryption($configConfigEncryption);
        $awsNodePool->setConfig($awsNodePoolConfig);
        $awsNodePoolAutoscaling = new AwsNodePoolAutoscaling();
        $autoscalingMinNodeCount = 1464441581;
        $awsNodePoolAutoscaling->setMinNodeCount($autoscalingMinNodeCount);
        $autoscalingMaxNodeCount = 1938867647;
        $awsNodePoolAutoscaling->setMaxNodeCount($autoscalingMaxNodeCount);
        $awsNodePool->setAutoscaling($awsNodePoolAutoscaling);
        $awsNodePoolSubnetId = 'awsNodePoolSubnetId-2035401261';
        $awsNodePool->setSubnetId($awsNodePoolSubnetId);
        $awsNodePoolMaxPodsConstraint = new MaxPodsConstraint();
        $maxPodsConstraintMaxPodsPerNode = 1072618940;
        $awsNodePoolMaxPodsConstraint->setMaxPodsPerNode($maxPodsConstraintMaxPodsPerNode);
        $awsNodePool->setMaxPodsConstraint($awsNodePoolMaxPodsConstraint);
        $updateMask = new FieldMask();
        $response = $client->updateAwsNodePool($awsNodePool, $updateMask);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AwsClusters/UpdateAwsNodePool', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getAwsNodePool();
        $this->assertProtobufEquals($awsNodePool, $actualValue);
        $actualValue = $actualApiRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateAwsNodePoolTest');
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
    public function updateAwsNodePoolExceptionTest()
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
        $incompleteOperation->setName('operations/updateAwsNodePoolTest');
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
        $awsNodePool = new AwsNodePool();
        $awsNodePoolVersion = 'awsNodePoolVersion-617231107';
        $awsNodePool->setVersion($awsNodePoolVersion);
        $awsNodePoolConfig = new AwsNodeConfig();
        $configIamInstanceProfile = 'configIamInstanceProfile805825313';
        $awsNodePoolConfig->setIamInstanceProfile($configIamInstanceProfile);
        $configConfigEncryption = new AwsConfigEncryption();
        $configEncryptionKmsKeyArn = 'configEncryptionKmsKeyArn-992257206';
        $configConfigEncryption->setKmsKeyArn($configEncryptionKmsKeyArn);
        $awsNodePoolConfig->setConfigEncryption($configConfigEncryption);
        $awsNodePool->setConfig($awsNodePoolConfig);
        $awsNodePoolAutoscaling = new AwsNodePoolAutoscaling();
        $autoscalingMinNodeCount = 1464441581;
        $awsNodePoolAutoscaling->setMinNodeCount($autoscalingMinNodeCount);
        $autoscalingMaxNodeCount = 1938867647;
        $awsNodePoolAutoscaling->setMaxNodeCount($autoscalingMaxNodeCount);
        $awsNodePool->setAutoscaling($awsNodePoolAutoscaling);
        $awsNodePoolSubnetId = 'awsNodePoolSubnetId-2035401261';
        $awsNodePool->setSubnetId($awsNodePoolSubnetId);
        $awsNodePoolMaxPodsConstraint = new MaxPodsConstraint();
        $maxPodsConstraintMaxPodsPerNode = 1072618940;
        $awsNodePoolMaxPodsConstraint->setMaxPodsPerNode($maxPodsConstraintMaxPodsPerNode);
        $awsNodePool->setMaxPodsConstraint($awsNodePoolMaxPodsConstraint);
        $updateMask = new FieldMask();
        $response = $client->updateAwsNodePool($awsNodePool, $updateMask);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateAwsNodePoolTest');
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
