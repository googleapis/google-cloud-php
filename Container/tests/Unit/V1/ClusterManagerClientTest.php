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
use Google\Cloud\Container\V1beta1\AddonsConfig;
use Google\Cloud\Container\V1beta1\Cluster;
use Google\Cloud\Container\V1beta1\ClusterUpdate;
use Google\Cloud\Container\V1beta1\ListClustersResponse;
use Google\Cloud\Container\V1beta1\ListLocationsResponse;
use Google\Cloud\Container\V1beta1\ListNodePoolsResponse;
use Google\Cloud\Container\V1beta1\ListOperationsResponse;
use Google\Cloud\Container\V1beta1\ListUsableSubnetworksResponse;
use Google\Cloud\Container\V1beta1\MaintenancePolicy;
use Google\Cloud\Container\V1beta1\MasterAuth;
use Google\Cloud\Container\V1beta1\NetworkPolicy;
use Google\Cloud\Container\V1beta1\NodeManagement;
use Google\Cloud\Container\V1beta1\NodePool;
use Google\Cloud\Container\V1beta1\NodePoolAutoscaling;
use Google\Cloud\Container\V1beta1\Operation;
use Google\Cloud\Container\V1beta1\ServerConfig;
use Google\Cloud\Container\V1beta1\SetMasterAuthRequest_Action;
use Google\Cloud\Container\V1beta1\UsableSubnetwork;
use Google\Protobuf\Any;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group container
 * @group gapic
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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');

        $response = $client->listClusters($formattedParent);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/ListClusters', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);

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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');

        try {
            $client->listClusters($formattedParent);
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
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $initialNodeCount = 1682564205;
        $loggingService = 'loggingService-1700501035';
        $monitoringService = 'monitoringService1469270462';
        $network = 'network1843485230';
        $clusterIpv4Cidr = 'clusterIpv4Cidr-141875831';
        $subnetwork = 'subnetwork-1302785042';
        $enableKubernetesAlpha = false;
        $labelFingerprint = 'labelFingerprint714995737';
        $privateCluster = true;
        $masterIpv4CidrBlock = 'masterIpv4CidrBlock-97940801';
        $selfLink = 'selfLink-1691268851';
        $zone = 'zone3744684';
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
        $location = 'location1901043637';
        $enableTpu = false;
        $tpuIpv4CidrBlock = 'tpuIpv4CidrBlock1137906646';
        $expectedResponse = new Cluster();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setInitialNodeCount($initialNodeCount);
        $expectedResponse->setLoggingService($loggingService);
        $expectedResponse->setMonitoringService($monitoringService);
        $expectedResponse->setNetwork($network);
        $expectedResponse->setClusterIpv4Cidr($clusterIpv4Cidr);
        $expectedResponse->setSubnetwork($subnetwork);
        $expectedResponse->setEnableKubernetesAlpha($enableKubernetesAlpha);
        $expectedResponse->setLabelFingerprint($labelFingerprint);
        $expectedResponse->setPrivateCluster($privateCluster);
        $expectedResponse->setMasterIpv4CidrBlock($masterIpv4CidrBlock);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setZone($zone);
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
        $expectedResponse->setLocation($location);
        $expectedResponse->setEnableTpu($enableTpu);
        $expectedResponse->setTpuIpv4CidrBlock($tpuIpv4CidrBlock);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        $response = $client->getCluster($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/GetCluster', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        try {
            $client->getCluster($formattedName);
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
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $cluster = new Cluster();
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');

        $response = $client->createCluster($cluster, $formattedParent);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/CreateCluster', $actualFuncCall);

        $actualValue = $actualRequestObject->getCluster();

        $this->assertProtobufEquals($cluster, $actualValue);
        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);

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
        $cluster = new Cluster();
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');

        try {
            $client->createCluster($cluster, $formattedParent);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $update = new ClusterUpdate();
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        $response = $client->updateCluster($update, $formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/UpdateCluster', $actualFuncCall);

        $actualValue = $actualRequestObject->getUpdate();

        $this->assertProtobufEquals($update, $actualValue);
        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $update = new ClusterUpdate();
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        try {
            $client->updateCluster($update, $formattedName);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $nodeVersion = 'nodeVersion1790136219';
        $imageType = 'imageType-1442758754';
        $formattedName = $client->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');

        $response = $client->updateNodePool($nodeVersion, $imageType, $formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/UpdateNodePool', $actualFuncCall);

        $actualValue = $actualRequestObject->getNodeVersion();

        $this->assertProtobufEquals($nodeVersion, $actualValue);
        $actualValue = $actualRequestObject->getImageType();

        $this->assertProtobufEquals($imageType, $actualValue);
        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $nodeVersion = 'nodeVersion1790136219';
        $imageType = 'imageType-1442758754';
        $formattedName = $client->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');

        try {
            $client->updateNodePool($nodeVersion, $imageType, $formattedName);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $autoscaling = new NodePoolAutoscaling();
        $formattedName = $client->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');

        $response = $client->setNodePoolAutoscaling($autoscaling, $formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/SetNodePoolAutoscaling', $actualFuncCall);

        $actualValue = $actualRequestObject->getAutoscaling();

        $this->assertProtobufEquals($autoscaling, $actualValue);
        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $autoscaling = new NodePoolAutoscaling();
        $formattedName = $client->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');

        try {
            $client->setNodePoolAutoscaling($autoscaling, $formattedName);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $loggingService = 'loggingService-1700501035';
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        $response = $client->setLoggingService($loggingService, $formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/SetLoggingService', $actualFuncCall);

        $actualValue = $actualRequestObject->getLoggingService();

        $this->assertProtobufEquals($loggingService, $actualValue);
        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $loggingService = 'loggingService-1700501035';
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        try {
            $client->setLoggingService($loggingService, $formattedName);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $monitoringService = 'monitoringService1469270462';
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        $response = $client->setMonitoringService($monitoringService, $formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/SetMonitoringService', $actualFuncCall);

        $actualValue = $actualRequestObject->getMonitoringService();

        $this->assertProtobufEquals($monitoringService, $actualValue);
        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $monitoringService = 'monitoringService1469270462';
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        try {
            $client->setMonitoringService($monitoringService, $formattedName);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $addonsConfig = new AddonsConfig();
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        $response = $client->setAddonsConfig($addonsConfig, $formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/SetAddonsConfig', $actualFuncCall);

        $actualValue = $actualRequestObject->getAddonsConfig();

        $this->assertProtobufEquals($addonsConfig, $actualValue);
        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $addonsConfig = new AddonsConfig();
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        try {
            $client->setAddonsConfig($addonsConfig, $formattedName);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $locations = [];
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        $response = $client->setLocations($locations, $formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/SetLocations', $actualFuncCall);

        $actualValue = $actualRequestObject->getLocations();

        $this->assertProtobufEquals($locations, $actualValue);
        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $locations = [];
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        try {
            $client->setLocations($locations, $formattedName);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $masterVersion = 'masterVersion-2139460613';
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        $response = $client->updateMaster($masterVersion, $formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/UpdateMaster', $actualFuncCall);

        $actualValue = $actualRequestObject->getMasterVersion();

        $this->assertProtobufEquals($masterVersion, $actualValue);
        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $masterVersion = 'masterVersion-2139460613';
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        try {
            $client->updateMaster($masterVersion, $formattedName);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $action = SetMasterAuthRequest_Action::UNKNOWN;
        $update = new MasterAuth();
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        $response = $client->setMasterAuth($action, $update, $formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/SetMasterAuth', $actualFuncCall);

        $actualValue = $actualRequestObject->getAction();

        $this->assertProtobufEquals($action, $actualValue);
        $actualValue = $actualRequestObject->getUpdate();

        $this->assertProtobufEquals($update, $actualValue);
        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $action = SetMasterAuthRequest_Action::UNKNOWN;
        $update = new MasterAuth();
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        try {
            $client->setMasterAuth($action, $update, $formattedName);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        $response = $client->deleteCluster($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/DeleteCluster', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        try {
            $client->deleteCluster($formattedName);
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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');

        $response = $client->listOperations($formattedParent);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/ListOperations', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);

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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');

        try {
            $client->listOperations($formattedParent);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->operationName('[PROJECT]', '[LOCATION]', '[OPERATION]');

        $response = $client->getOperation($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/GetOperation', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $formattedName = $client->operationName('[PROJECT]', '[LOCATION]', '[OPERATION]');

        try {
            $client->getOperation($formattedName);
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
        $formattedName = $client->operationName('[PROJECT]', '[LOCATION]', '[OPERATION]');

        $client->cancelOperation($formattedName);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/CancelOperation', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $formattedName = $client->operationName('[PROJECT]', '[LOCATION]', '[OPERATION]');

        try {
            $client->cancelOperation($formattedName);
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
        $formattedName = $client->locationName('[PROJECT]', '[LOCATION]');

        $response = $client->getServerConfig($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/GetServerConfig', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $formattedName = $client->locationName('[PROJECT]', '[LOCATION]');

        try {
            $client->getServerConfig($formattedName);
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
        $formattedParent = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        $response = $client->listNodePools($formattedParent);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/ListNodePools', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);

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
        $formattedParent = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        try {
            $client->listNodePools($formattedParent);
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
        $name2 = 'name2-1052831874';
        $initialNodeCount = 1682564205;
        $selfLink = 'selfLink-1691268851';
        $version = 'version351608024';
        $statusMessage = 'statusMessage-239442758';
        $expectedResponse = new NodePool();
        $expectedResponse->setName($name2);
        $expectedResponse->setInitialNodeCount($initialNodeCount);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setVersion($version);
        $expectedResponse->setStatusMessage($statusMessage);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');

        $response = $client->getNodePool($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/GetNodePool', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $formattedName = $client->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');

        try {
            $client->getNodePool($formattedName);
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
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $nodePool = new NodePool();
        $formattedParent = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        $response = $client->createNodePool($nodePool, $formattedParent);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/CreateNodePool', $actualFuncCall);

        $actualValue = $actualRequestObject->getNodePool();

        $this->assertProtobufEquals($nodePool, $actualValue);
        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);

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
        $nodePool = new NodePool();
        $formattedParent = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        try {
            $client->createNodePool($nodePool, $formattedParent);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');

        $response = $client->deleteNodePool($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/DeleteNodePool', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $formattedName = $client->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');

        try {
            $client->deleteNodePool($formattedName);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');

        $response = $client->rollbackNodePoolUpgrade($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/RollbackNodePoolUpgrade', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $formattedName = $client->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');

        try {
            $client->rollbackNodePoolUpgrade($formattedName);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $management = new NodeManagement();
        $formattedName = $client->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');

        $response = $client->setNodePoolManagement($management, $formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/SetNodePoolManagement', $actualFuncCall);

        $actualValue = $actualRequestObject->getManagement();

        $this->assertProtobufEquals($management, $actualValue);
        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $management = new NodeManagement();
        $formattedName = $client->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');

        try {
            $client->setNodePoolManagement($management, $formattedName);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $resourceLabels = [];
        $labelFingerprint = 'labelFingerprint714995737';
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        $response = $client->setLabels($resourceLabels, $labelFingerprint, $formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/SetLabels', $actualFuncCall);

        $actualValue = $actualRequestObject->getResourceLabels();

        $this->assertProtobufEquals($resourceLabels, $actualValue);
        $actualValue = $actualRequestObject->getLabelFingerprint();

        $this->assertProtobufEquals($labelFingerprint, $actualValue);
        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $resourceLabels = [];
        $labelFingerprint = 'labelFingerprint714995737';
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        try {
            $client->setLabels($resourceLabels, $labelFingerprint, $formattedName);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $enabled = false;
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        $response = $client->setLegacyAbac($enabled, $formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/SetLegacyAbac', $actualFuncCall);

        $actualValue = $actualRequestObject->getEnabled();

        $this->assertProtobufEquals($enabled, $actualValue);
        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $enabled = false;
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        try {
            $client->setLegacyAbac($enabled, $formattedName);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
        $rotateCredentials = true;

        $response = $client->startIPRotation($formattedName, $rotateCredentials);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/StartIPRotation', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getRotateCredentials();

        $this->assertProtobufEquals($rotateCredentials, $actualValue);

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
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
        $rotateCredentials = true;

        try {
            $client->startIPRotation($formattedName, $rotateCredentials);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        $response = $client->completeIPRotation($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/CompleteIPRotation', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        try {
            $client->completeIPRotation($formattedName);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $nodeCount = 1539922066;
        $formattedName = $client->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');

        $response = $client->setNodePoolSize($nodeCount, $formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/SetNodePoolSize', $actualFuncCall);

        $actualValue = $actualRequestObject->getNodeCount();

        $this->assertProtobufEquals($nodeCount, $actualValue);
        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $nodeCount = 1539922066;
        $formattedName = $client->nodePoolName('[PROJECT]', '[LOCATION]', '[CLUSTER]', '[NODE_POOL]');

        try {
            $client->setNodePoolSize($nodeCount, $formattedName);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $networkPolicy = new NetworkPolicy();
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        $response = $client->setNetworkPolicy($networkPolicy, $formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/SetNetworkPolicy', $actualFuncCall);

        $actualValue = $actualRequestObject->getNetworkPolicy();

        $this->assertProtobufEquals($networkPolicy, $actualValue);
        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $networkPolicy = new NetworkPolicy();
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        try {
            $client->setNetworkPolicy($networkPolicy, $formattedName);
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
        $name2 = 'name2-1052831874';
        $zone = 'zone3744684';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);

        // Mock request
        $maintenancePolicy = new MaintenancePolicy();
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        $response = $client->setMaintenancePolicy($maintenancePolicy, $formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/SetMaintenancePolicy', $actualFuncCall);

        $actualValue = $actualRequestObject->getMaintenancePolicy();

        $this->assertProtobufEquals($maintenancePolicy, $actualValue);
        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

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
        $maintenancePolicy = new MaintenancePolicy();
        $formattedName = $client->clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

        try {
            $client->setMaintenancePolicy($maintenancePolicy, $formattedName);
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
    public function listUsableSubnetworksTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $nextPageToken = '';
        $subnetworksElement = new UsableSubnetwork();
        $subnetworks = [$subnetworksElement];
        $expectedResponse = new ListUsableSubnetworksResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSubnetworks($subnetworks);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedParent = $client->projectName('[PROJECT]');
        $filter = 'filter-1274492040';

        $response = $client->listUsableSubnetworks($formattedParent, $filter);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getSubnetworks()[0], $resources[0]);

        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/ListUsableSubnetworks', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getFilter();

        $this->assertProtobufEquals($filter, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listUsableSubnetworksExceptionTest()
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
        $formattedParent = $client->projectName('[PROJECT]');
        $filter = 'filter-1274492040';

        try {
            $client->listUsableSubnetworks($formattedParent, $filter);
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
    public function listLocationsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $nextPageToken = 'nextPageToken-1530815211';
        $expectedResponse = new ListLocationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedParent = $client->projectName('[PROJECT]');

        $response = $client->listLocations($formattedParent);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1beta1.ClusterManager/ListLocations', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listLocationsExceptionTest()
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
        $formattedParent = $client->projectName('[PROJECT]');

        try {
            $client->listLocations($formattedParent);
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
