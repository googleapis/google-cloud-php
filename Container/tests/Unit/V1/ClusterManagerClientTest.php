<?php
/*
 * Copyright 2018 Google LLC
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

namespace Google\Cloud\Container\Tests\Unit\V1;

use Google\Cloud\Container\V1\ClusterManagerClient;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Container\V1\AddonsConfig;
use Google\Cloud\Container\V1\Cluster;
use Google\Cloud\Container\V1\ClusterUpdate;
use Google\Cloud\Container\V1\ListClustersResponse;
use Google\Cloud\Container\V1\ListNodePoolsResponse;
use Google\Cloud\Container\V1\ListOperationsResponse;
use Google\Cloud\Container\V1\MaintenancePolicy;
use Google\Cloud\Container\V1\MasterAuth;
use Google\Cloud\Container\V1\NetworkPolicy;
use Google\Cloud\Container\V1\NodeManagement;
use Google\Cloud\Container\V1\NodePool;
use Google\Cloud\Container\V1\NodePoolAutoscaling;
use Google\Cloud\Container\V1\Operation;
use Google\Cloud\Container\V1\ServerConfig;
use Google\Cloud\Container\V1\SetMasterAuthRequest_Action;
use Google\Protobuf\Any;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group container
 * @group grpc
 */
class ClusterManagerClientTest extends GeneratedTest
{
    /**
     * @return TransportInterface
     */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /**
     * @return ClusterManagerClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->getMockBuilder(CredentialsWrapper::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        return new ClusterManagerClient($options);
    }

    /**
     * @test
     */
    public function listClustersTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new ListClustersResponse();
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';

        $response = $client->listClusters($projectId, $zone);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/ListClusters', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listClustersExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';

        try {
            $client->listClusters($projectId, $zone);
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
    public function getClusterTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $initialNodeCount = 1682564205;
        $loggingService = 'loggingService-1700501035';
        $monitoringService = 'monitoringService1469270462';
        $network = 'network1843485230';
        $clusterIpv4Cidr = 'clusterIpv4Cidr-141875831';
        $subnetwork = 'subnetwork-1302785042';
        $enableKubernetesAlpha = false;
        $labelFingerprint = 'labelFingerprint714995737';
        $selfLink = 'selfLink-1691268851';
        $zone2 = 'zone2-696322977';
        $endpoint = 'endpoint1741102485';
        $initialClusterVersion = 'initialClusterVersion-276373352';
        $currentMasterVersion = 'currentMasterVersion-920953983';
        $currentNodeVersion = 'currentNodeVersion-407476063';
        $createTime = 'createTime-493574096';
        $statusMessage = 'statusMessage-239442758';
        $nodeIpv4CidrSize = 1181176815;
        $servicesIpv4Cidr = 'servicesIpv4Cidr1966438125';
        $currentNodeCount = 178977560;
        $expireTime = 'expireTime-96179731';
        $expectedResponse = new Cluster();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setInitialNodeCount($initialNodeCount);
        $expectedResponse->setLoggingService($loggingService);
        $expectedResponse->setMonitoringService($monitoringService);
        $expectedResponse->setNetwork($network);
        $expectedResponse->setClusterIpv4Cidr($clusterIpv4Cidr);
        $expectedResponse->setSubnetwork($subnetwork);
        $expectedResponse->setEnableKubernetesAlpha($enableKubernetesAlpha);
        $expectedResponse->setLabelFingerprint($labelFingerprint);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setEndpoint($endpoint);
        $expectedResponse->setInitialClusterVersion($initialClusterVersion);
        $expectedResponse->setCurrentMasterVersion($currentMasterVersion);
        $expectedResponse->setCurrentNodeVersion($currentNodeVersion);
        $expectedResponse->setCreateTime($createTime);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setNodeIpv4CidrSize($nodeIpv4CidrSize);
        $expectedResponse->setServicesIpv4Cidr($servicesIpv4Cidr);
        $expectedResponse->setCurrentNodeCount($currentNodeCount);
        $expectedResponse->setExpireTime($expireTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';

        $response = $client->getCluster($projectId, $zone, $clusterId);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/GetCluster', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getClusterExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';

        try {
            $client->getCluster($projectId, $zone, $clusterId);
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
    public function createClusterTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $cluster = new Cluster();

        $response = $client->createCluster($projectId, $zone, $cluster);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/CreateCluster', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getCluster();

        $this->assertProtobufEquals($cluster, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function createClusterExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $cluster = new Cluster();

        try {
            $client->createCluster($projectId, $zone, $cluster);
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
    public function updateClusterTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $update = new ClusterUpdate();

        $response = $client->updateCluster($projectId, $zone, $clusterId, $update);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/UpdateCluster', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);
        $actualValue = $actualRequestObject->getUpdate();

        $this->assertProtobufEquals($update, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function updateClusterExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $update = new ClusterUpdate();

        try {
            $client->updateCluster($projectId, $zone, $clusterId, $update);
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
    public function updateNodePoolTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $nodePoolId = 'nodePoolId1043384033';
        $nodeVersion = 'nodeVersion1790136219';
        $imageType = 'imageType-1442758754';

        $response = $client->updateNodePool($projectId, $zone, $clusterId, $nodePoolId, $nodeVersion, $imageType);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/UpdateNodePool', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);
        $actualValue = $actualRequestObject->getNodePoolId();

        $this->assertProtobufEquals($nodePoolId, $actualValue);
        $actualValue = $actualRequestObject->getNodeVersion();

        $this->assertProtobufEquals($nodeVersion, $actualValue);
        $actualValue = $actualRequestObject->getImageType();

        $this->assertProtobufEquals($imageType, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function updateNodePoolExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $nodePoolId = 'nodePoolId1043384033';
        $nodeVersion = 'nodeVersion1790136219';
        $imageType = 'imageType-1442758754';

        try {
            $client->updateNodePool($projectId, $zone, $clusterId, $nodePoolId, $nodeVersion, $imageType);
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
    public function setNodePoolAutoscalingTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $nodePoolId = 'nodePoolId1043384033';
        $autoscaling = new NodePoolAutoscaling();

        $response = $client->setNodePoolAutoscaling($projectId, $zone, $clusterId, $nodePoolId, $autoscaling);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetNodePoolAutoscaling', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);
        $actualValue = $actualRequestObject->getNodePoolId();

        $this->assertProtobufEquals($nodePoolId, $actualValue);
        $actualValue = $actualRequestObject->getAutoscaling();

        $this->assertProtobufEquals($autoscaling, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function setNodePoolAutoscalingExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $nodePoolId = 'nodePoolId1043384033';
        $autoscaling = new NodePoolAutoscaling();

        try {
            $client->setNodePoolAutoscaling($projectId, $zone, $clusterId, $nodePoolId, $autoscaling);
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
    public function setLoggingServiceTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $loggingService = 'loggingService-1700501035';

        $response = $client->setLoggingService($projectId, $zone, $clusterId, $loggingService);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetLoggingService', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);
        $actualValue = $actualRequestObject->getLoggingService();

        $this->assertProtobufEquals($loggingService, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function setLoggingServiceExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $loggingService = 'loggingService-1700501035';

        try {
            $client->setLoggingService($projectId, $zone, $clusterId, $loggingService);
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
    public function setMonitoringServiceTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $monitoringService = 'monitoringService1469270462';

        $response = $client->setMonitoringService($projectId, $zone, $clusterId, $monitoringService);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetMonitoringService', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);
        $actualValue = $actualRequestObject->getMonitoringService();

        $this->assertProtobufEquals($monitoringService, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function setMonitoringServiceExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $monitoringService = 'monitoringService1469270462';

        try {
            $client->setMonitoringService($projectId, $zone, $clusterId, $monitoringService);
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
    public function setAddonsConfigTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $addonsConfig = new AddonsConfig();

        $response = $client->setAddonsConfig($projectId, $zone, $clusterId, $addonsConfig);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetAddonsConfig', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);
        $actualValue = $actualRequestObject->getAddonsConfig();

        $this->assertProtobufEquals($addonsConfig, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function setAddonsConfigExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $addonsConfig = new AddonsConfig();

        try {
            $client->setAddonsConfig($projectId, $zone, $clusterId, $addonsConfig);
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
    public function setLocationsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $locations = [];

        $response = $client->setLocations($projectId, $zone, $clusterId, $locations);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetLocations', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);
        $actualValue = $actualRequestObject->getLocations();

        $this->assertProtobufEquals($locations, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function setLocationsExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $locations = [];

        try {
            $client->setLocations($projectId, $zone, $clusterId, $locations);
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
    public function updateMasterTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $masterVersion = 'masterVersion-2139460613';

        $response = $client->updateMaster($projectId, $zone, $clusterId, $masterVersion);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/UpdateMaster', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);
        $actualValue = $actualRequestObject->getMasterVersion();

        $this->assertProtobufEquals($masterVersion, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function updateMasterExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $masterVersion = 'masterVersion-2139460613';

        try {
            $client->updateMaster($projectId, $zone, $clusterId, $masterVersion);
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
    public function setMasterAuthTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $action = SetMasterAuthRequest_Action::UNKNOWN;
        $update = new MasterAuth();

        $response = $client->setMasterAuth($projectId, $zone, $clusterId, $action, $update);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetMasterAuth', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);
        $actualValue = $actualRequestObject->getAction();

        $this->assertProtobufEquals($action, $actualValue);
        $actualValue = $actualRequestObject->getUpdate();

        $this->assertProtobufEquals($update, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function setMasterAuthExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $action = SetMasterAuthRequest_Action::UNKNOWN;
        $update = new MasterAuth();

        try {
            $client->setMasterAuth($projectId, $zone, $clusterId, $action, $update);
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
    public function deleteClusterTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';

        $response = $client->deleteCluster($projectId, $zone, $clusterId);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/DeleteCluster', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteClusterExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';

        try {
            $client->deleteCluster($projectId, $zone, $clusterId);
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
    public function listOperationsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new ListOperationsResponse();
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';

        $response = $client->listOperations($projectId, $zone);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/ListOperations', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listOperationsExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';

        try {
            $client->listOperations($projectId, $zone);
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
    public function getOperationTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $operationId = 'operationId-274116877';

        $response = $client->getOperation($projectId, $zone, $operationId);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/GetOperation', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getOperationId();

        $this->assertProtobufEquals($operationId, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getOperationExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $operationId = 'operationId-274116877';

        try {
            $client->getOperation($projectId, $zone, $operationId);
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
    public function cancelOperationTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $operationId = 'operationId-274116877';

        $client->cancelOperation($projectId, $zone, $operationId);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/CancelOperation', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getOperationId();

        $this->assertProtobufEquals($operationId, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function cancelOperationExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $operationId = 'operationId-274116877';

        try {
            $client->cancelOperation($projectId, $zone, $operationId);
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
    public function getServerConfigTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $defaultClusterVersion = 'defaultClusterVersion111003029';
        $defaultImageType = 'defaultImageType-918225828';
        $expectedResponse = new ServerConfig();
        $expectedResponse->setDefaultClusterVersion($defaultClusterVersion);
        $expectedResponse->setDefaultImageType($defaultImageType);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';

        $response = $client->getServerConfig($projectId, $zone);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/GetServerConfig', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getServerConfigExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';

        try {
            $client->getServerConfig($projectId, $zone);
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
    public function listNodePoolsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new ListNodePoolsResponse();
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';

        $response = $client->listNodePools($projectId, $zone, $clusterId);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/ListNodePools', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listNodePoolsExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';

        try {
            $client->listNodePools($projectId, $zone, $clusterId);
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
    public function getNodePoolTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $initialNodeCount = 1682564205;
        $selfLink = 'selfLink-1691268851';
        $version = 'version351608024';
        $statusMessage = 'statusMessage-239442758';
        $expectedResponse = new NodePool();
        $expectedResponse->setName($name);
        $expectedResponse->setInitialNodeCount($initialNodeCount);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setVersion($version);
        $expectedResponse->setStatusMessage($statusMessage);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $nodePoolId = 'nodePoolId1043384033';

        $response = $client->getNodePool($projectId, $zone, $clusterId, $nodePoolId);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/GetNodePool', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);
        $actualValue = $actualRequestObject->getNodePoolId();

        $this->assertProtobufEquals($nodePoolId, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getNodePoolExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $nodePoolId = 'nodePoolId1043384033';

        try {
            $client->getNodePool($projectId, $zone, $clusterId, $nodePoolId);
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
    public function createNodePoolTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $nodePool = new NodePool();

        $response = $client->createNodePool($projectId, $zone, $clusterId, $nodePool);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/CreateNodePool', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);
        $actualValue = $actualRequestObject->getNodePool();

        $this->assertProtobufEquals($nodePool, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function createNodePoolExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $nodePool = new NodePool();

        try {
            $client->createNodePool($projectId, $zone, $clusterId, $nodePool);
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
    public function deleteNodePoolTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $nodePoolId = 'nodePoolId1043384033';

        $response = $client->deleteNodePool($projectId, $zone, $clusterId, $nodePoolId);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/DeleteNodePool', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);
        $actualValue = $actualRequestObject->getNodePoolId();

        $this->assertProtobufEquals($nodePoolId, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteNodePoolExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $nodePoolId = 'nodePoolId1043384033';

        try {
            $client->deleteNodePool($projectId, $zone, $clusterId, $nodePoolId);
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
    public function rollbackNodePoolUpgradeTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $nodePoolId = 'nodePoolId1043384033';

        $response = $client->rollbackNodePoolUpgrade($projectId, $zone, $clusterId, $nodePoolId);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/RollbackNodePoolUpgrade', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);
        $actualValue = $actualRequestObject->getNodePoolId();

        $this->assertProtobufEquals($nodePoolId, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function rollbackNodePoolUpgradeExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $nodePoolId = 'nodePoolId1043384033';

        try {
            $client->rollbackNodePoolUpgrade($projectId, $zone, $clusterId, $nodePoolId);
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
    public function setNodePoolManagementTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $nodePoolId = 'nodePoolId1043384033';
        $management = new NodeManagement();

        $response = $client->setNodePoolManagement($projectId, $zone, $clusterId, $nodePoolId, $management);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetNodePoolManagement', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);
        $actualValue = $actualRequestObject->getNodePoolId();

        $this->assertProtobufEquals($nodePoolId, $actualValue);
        $actualValue = $actualRequestObject->getManagement();

        $this->assertProtobufEquals($management, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function setNodePoolManagementExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $nodePoolId = 'nodePoolId1043384033';
        $management = new NodeManagement();

        try {
            $client->setNodePoolManagement($projectId, $zone, $clusterId, $nodePoolId, $management);
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
    public function setLabelsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $resourceLabels = [];
        $labelFingerprint = 'labelFingerprint714995737';

        $response = $client->setLabels($projectId, $zone, $clusterId, $resourceLabels, $labelFingerprint);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetLabels', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);
        $actualValue = $actualRequestObject->getResourceLabels();

        $this->assertProtobufEquals($resourceLabels, $actualValue);
        $actualValue = $actualRequestObject->getLabelFingerprint();

        $this->assertProtobufEquals($labelFingerprint, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function setLabelsExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $resourceLabels = [];
        $labelFingerprint = 'labelFingerprint714995737';

        try {
            $client->setLabels($projectId, $zone, $clusterId, $resourceLabels, $labelFingerprint);
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
    public function setLegacyAbacTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $enabled = false;

        $response = $client->setLegacyAbac($projectId, $zone, $clusterId, $enabled);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetLegacyAbac', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);
        $actualValue = $actualRequestObject->getEnabled();

        $this->assertProtobufEquals($enabled, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function setLegacyAbacExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $enabled = false;

        try {
            $client->setLegacyAbac($projectId, $zone, $clusterId, $enabled);
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
    public function startIPRotationTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';

        $response = $client->startIPRotation($projectId, $zone, $clusterId);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/StartIPRotation', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function startIPRotationExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';

        try {
            $client->startIPRotation($projectId, $zone, $clusterId);
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
    public function completeIPRotationTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';

        $response = $client->completeIPRotation($projectId, $zone, $clusterId);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/CompleteIPRotation', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function completeIPRotationExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';

        try {
            $client->completeIPRotation($projectId, $zone, $clusterId);
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
    public function setNodePoolSizeTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $nodePoolId = 'nodePoolId1043384033';
        $nodeCount = 1539922066;

        $response = $client->setNodePoolSize($projectId, $zone, $clusterId, $nodePoolId, $nodeCount);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetNodePoolSize', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);
        $actualValue = $actualRequestObject->getNodePoolId();

        $this->assertProtobufEquals($nodePoolId, $actualValue);
        $actualValue = $actualRequestObject->getNodeCount();

        $this->assertProtobufEquals($nodeCount, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function setNodePoolSizeExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $nodePoolId = 'nodePoolId1043384033';
        $nodeCount = 1539922066;

        try {
            $client->setNodePoolSize($projectId, $zone, $clusterId, $nodePoolId, $nodeCount);
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
    public function setNetworkPolicyTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $networkPolicy = new NetworkPolicy();

        $response = $client->setNetworkPolicy($projectId, $zone, $clusterId, $networkPolicy);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetNetworkPolicy', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);
        $actualValue = $actualRequestObject->getNetworkPolicy();

        $this->assertProtobufEquals($networkPolicy, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function setNetworkPolicyExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $networkPolicy = new NetworkPolicy();

        try {
            $client->setNetworkPolicy($projectId, $zone, $clusterId, $networkPolicy);
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
    public function setMaintenancePolicyTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $maintenancePolicy = new MaintenancePolicy();

        $response = $client->setMaintenancePolicy($projectId, $zone, $clusterId, $maintenancePolicy);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetMaintenancePolicy', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getZone();

        $this->assertProtobufEquals($zone, $actualValue);
        $actualValue = $actualRequestObject->getClusterId();

        $this->assertProtobufEquals($clusterId, $actualValue);
        $actualValue = $actualRequestObject->getMaintenancePolicy();

        $this->assertProtobufEquals($maintenancePolicy, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function setMaintenancePolicyExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $maintenancePolicy = new MaintenancePolicy();

        try {
            $client->setMaintenancePolicy($projectId, $zone, $clusterId, $maintenancePolicy);
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
}
