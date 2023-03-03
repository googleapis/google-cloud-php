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

namespace Google\Cloud\Container\Tests\Unit\V1;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Container\V1\AddonsConfig;
use Google\Cloud\Container\V1\Cluster;
use Google\Cloud\Container\V1\ClusterManagerClient;
use Google\Cloud\Container\V1\ClusterUpdate;
use Google\Cloud\Container\V1\GetJSONWebKeysResponse;
use Google\Cloud\Container\V1\ListClustersResponse;
use Google\Cloud\Container\V1\ListNodePoolsResponse;
use Google\Cloud\Container\V1\ListOperationsResponse;
use Google\Cloud\Container\V1\ListUsableSubnetworksResponse;
use Google\Cloud\Container\V1\MaintenancePolicy;
use Google\Cloud\Container\V1\MasterAuth;
use Google\Cloud\Container\V1\NetworkPolicy;
use Google\Cloud\Container\V1\NodeManagement;
use Google\Cloud\Container\V1\NodePool;
use Google\Cloud\Container\V1\NodePoolAutoscaling;
use Google\Cloud\Container\V1\Operation;
use Google\Cloud\Container\V1\ServerConfig;
use Google\Cloud\Container\V1\SetMasterAuthRequest\Action;
use Google\Cloud\Container\V1\UsableSubnetwork;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group container
 *
 * @group gapic
 */
class ClusterManagerClientTest extends GeneratedTest
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

    /** @return ClusterManagerClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new ClusterManagerClient($options);
    }

    /** @test */
    public function cancelOperationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $gapicClient->cancelOperation();
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/CancelOperation', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function cancelOperationExceptionTest()
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
            $gapicClient->cancelOperation();
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
    public function completeIPRotationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->completeIPRotation();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/CompleteIPRotation', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function completeIPRotationExceptionTest()
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
            $gapicClient->completeIPRotation();
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
    public function completeNodePoolUpgradeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $gapicClient->completeNodePoolUpgrade();
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/CompleteNodePoolUpgrade', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function completeNodePoolUpgradeExceptionTest()
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
            $gapicClient->completeNodePoolUpgrade();
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
    public function createClusterTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
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
        $response = $gapicClient->createCluster($cluster);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/CreateCluster', $actualFuncCall);
        $actualValue = $actualRequestObject->getCluster();
        $this->assertProtobufEquals($cluster, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createClusterExceptionTest()
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
        $cluster = new Cluster();
        try {
            $gapicClient->createCluster($cluster);
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
    public function createNodePoolTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name);
        $expectedResponse->setZone($zone2);
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
        $response = $gapicClient->createNodePool($nodePool);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/CreateNodePool', $actualFuncCall);
        $actualValue = $actualRequestObject->getNodePool();
        $this->assertProtobufEquals($nodePool, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createNodePoolExceptionTest()
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
        $nodePool = new NodePool();
        try {
            $gapicClient->createNodePool($nodePool);
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
    public function deleteClusterTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->deleteCluster();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/DeleteCluster', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteClusterExceptionTest()
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
            $gapicClient->deleteCluster();
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
    public function deleteNodePoolTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->deleteNodePool();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/DeleteNodePool', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteNodePoolExceptionTest()
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
            $gapicClient->deleteNodePool();
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
    public function getClusterTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
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
        $location = 'location1901043637';
        $enableTpu = false;
        $tpuIpv4CidrBlock = 'tpuIpv4CidrBlock1137906646';
        $id = 'id3355';
        $etag = 'etag3123477';
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
        $expectedResponse->setLocation($location);
        $expectedResponse->setEnableTpu($enableTpu);
        $expectedResponse->setTpuIpv4CidrBlock($tpuIpv4CidrBlock);
        $expectedResponse->setId($id);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->getCluster();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/GetCluster', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getClusterExceptionTest()
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
            $gapicClient->getCluster();
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
    public function getJSONWebKeysTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GetJSONWebKeysResponse();
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->getJSONWebKeys();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/GetJSONWebKeys', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getJSONWebKeysExceptionTest()
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
            $gapicClient->getJSONWebKeys();
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
    public function getNodePoolTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $initialNodeCount = 1682564205;
        $selfLink = 'selfLink-1691268851';
        $version = 'version351608024';
        $statusMessage = 'statusMessage-239442758';
        $podIpv4CidrSize = 1098768716;
        $etag = 'etag3123477';
        $expectedResponse = new NodePool();
        $expectedResponse->setName($name2);
        $expectedResponse->setInitialNodeCount($initialNodeCount);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setVersion($version);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setPodIpv4CidrSize($podIpv4CidrSize);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->getNodePool();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/GetNodePool', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getNodePoolExceptionTest()
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
            $gapicClient->getNodePool();
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
    public function getOperationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->getOperation();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/GetOperation', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getOperationExceptionTest()
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
            $gapicClient->getOperation();
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
    public function getServerConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $defaultClusterVersion = 'defaultClusterVersion111003029';
        $defaultImageType = 'defaultImageType-918225828';
        $expectedResponse = new ServerConfig();
        $expectedResponse->setDefaultClusterVersion($defaultClusterVersion);
        $expectedResponse->setDefaultImageType($defaultImageType);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->getServerConfig();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/GetServerConfig', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getServerConfigExceptionTest()
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
            $gapicClient->getServerConfig();
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
    public function listClustersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ListClustersResponse();
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->listClusters();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/ListClusters', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listClustersExceptionTest()
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
            $gapicClient->listClusters();
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
    public function listNodePoolsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ListNodePoolsResponse();
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->listNodePools();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/ListNodePools', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listNodePoolsExceptionTest()
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
            $gapicClient->listNodePools();
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
    public function listOperationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ListOperationsResponse();
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->listOperations();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/ListOperations', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listOperationsExceptionTest()
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
            $gapicClient->listOperations();
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
    public function listUsableSubnetworksTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $subnetworksElement = new UsableSubnetwork();
        $subnetworks = [
            $subnetworksElement,
        ];
        $expectedResponse = new ListUsableSubnetworksResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSubnetworks($subnetworks);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->listUsableSubnetworks();
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getSubnetworks()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/ListUsableSubnetworks', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listUsableSubnetworksExceptionTest()
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
            $gapicClient->listUsableSubnetworks();
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
    public function rollbackNodePoolUpgradeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->rollbackNodePoolUpgrade();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/RollbackNodePoolUpgrade', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function rollbackNodePoolUpgradeExceptionTest()
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
            $gapicClient->rollbackNodePoolUpgrade();
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
    public function setAddonsConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
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
        $response = $gapicClient->setAddonsConfig($addonsConfig);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetAddonsConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getAddonsConfig();
        $this->assertProtobufEquals($addonsConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function setAddonsConfigExceptionTest()
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
        $addonsConfig = new AddonsConfig();
        try {
            $gapicClient->setAddonsConfig($addonsConfig);
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
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);
        // Mock request
        $resourceLabelsValue = 'resourceLabelsValue-1244473404';
        $resourceLabels = [
            'resourceLabelsKey' => $resourceLabelsValue,
        ];
        $labelFingerprint = 'labelFingerprint714995737';
        $response = $gapicClient->setLabels($resourceLabels, $labelFingerprint);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetLabels', $actualFuncCall);
        $actualValue = $actualRequestObject->getResourceLabels();
        $this->assertProtobufEquals($resourceLabels, $actualValue);
        $actualValue = $actualRequestObject->getLabelFingerprint();
        $this->assertProtobufEquals($labelFingerprint, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function setLabelsExceptionTest()
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
        $resourceLabelsValue = 'resourceLabelsValue-1244473404';
        $resourceLabels = [
            'resourceLabelsKey' => $resourceLabelsValue,
        ];
        $labelFingerprint = 'labelFingerprint714995737';
        try {
            $gapicClient->setLabels($resourceLabels, $labelFingerprint);
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
    public function setLegacyAbacTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
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
        $response = $gapicClient->setLegacyAbac($enabled);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetLegacyAbac', $actualFuncCall);
        $actualValue = $actualRequestObject->getEnabled();
        $this->assertProtobufEquals($enabled, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function setLegacyAbacExceptionTest()
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
        $enabled = false;
        try {
            $gapicClient->setLegacyAbac($enabled);
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
    public function setLocationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
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
        $response = $gapicClient->setLocations($locations);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetLocations', $actualFuncCall);
        $actualValue = $actualRequestObject->getLocations();
        $this->assertProtobufEquals($locations, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function setLocationsExceptionTest()
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
        $locations = [];
        try {
            $gapicClient->setLocations($locations);
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
    public function setLoggingServiceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
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
        $response = $gapicClient->setLoggingService($loggingService);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetLoggingService', $actualFuncCall);
        $actualValue = $actualRequestObject->getLoggingService();
        $this->assertProtobufEquals($loggingService, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function setLoggingServiceExceptionTest()
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
        $loggingService = 'loggingService-1700501035';
        try {
            $gapicClient->setLoggingService($loggingService);
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
    public function setMaintenancePolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);
        // Mock request
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $maintenancePolicy = new MaintenancePolicy();
        $response = $gapicClient->setMaintenancePolicy($projectId, $zone, $clusterId, $maintenancePolicy);
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

    /** @test */
    public function setMaintenancePolicyExceptionTest()
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
        $projectId = 'projectId-1969970175';
        $zone = 'zone3744684';
        $clusterId = 'clusterId240280960';
        $maintenancePolicy = new MaintenancePolicy();
        try {
            $gapicClient->setMaintenancePolicy($projectId, $zone, $clusterId, $maintenancePolicy);
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
    public function setMasterAuthTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);
        // Mock request
        $action = Action::UNKNOWN;
        $update = new MasterAuth();
        $response = $gapicClient->setMasterAuth($action, $update);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetMasterAuth', $actualFuncCall);
        $actualValue = $actualRequestObject->getAction();
        $this->assertProtobufEquals($action, $actualValue);
        $actualValue = $actualRequestObject->getUpdate();
        $this->assertProtobufEquals($update, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function setMasterAuthExceptionTest()
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
        $action = Action::UNKNOWN;
        $update = new MasterAuth();
        try {
            $gapicClient->setMasterAuth($action, $update);
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
    public function setMonitoringServiceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
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
        $response = $gapicClient->setMonitoringService($monitoringService);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetMonitoringService', $actualFuncCall);
        $actualValue = $actualRequestObject->getMonitoringService();
        $this->assertProtobufEquals($monitoringService, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function setMonitoringServiceExceptionTest()
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
        $monitoringService = 'monitoringService1469270462';
        try {
            $gapicClient->setMonitoringService($monitoringService);
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
    public function setNetworkPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
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
        $response = $gapicClient->setNetworkPolicy($networkPolicy);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetNetworkPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getNetworkPolicy();
        $this->assertProtobufEquals($networkPolicy, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function setNetworkPolicyExceptionTest()
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
        $networkPolicy = new NetworkPolicy();
        try {
            $gapicClient->setNetworkPolicy($networkPolicy);
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
    public function setNodePoolAutoscalingTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
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
        $response = $gapicClient->setNodePoolAutoscaling($autoscaling);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetNodePoolAutoscaling', $actualFuncCall);
        $actualValue = $actualRequestObject->getAutoscaling();
        $this->assertProtobufEquals($autoscaling, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function setNodePoolAutoscalingExceptionTest()
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
        $autoscaling = new NodePoolAutoscaling();
        try {
            $gapicClient->setNodePoolAutoscaling($autoscaling);
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
    public function setNodePoolManagementTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
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
        $response = $gapicClient->setNodePoolManagement($management);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetNodePoolManagement', $actualFuncCall);
        $actualValue = $actualRequestObject->getManagement();
        $this->assertProtobufEquals($management, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function setNodePoolManagementExceptionTest()
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
        $management = new NodeManagement();
        try {
            $gapicClient->setNodePoolManagement($management);
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
    public function setNodePoolSizeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
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
        $response = $gapicClient->setNodePoolSize($nodeCount);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/SetNodePoolSize', $actualFuncCall);
        $actualValue = $actualRequestObject->getNodeCount();
        $this->assertProtobufEquals($nodeCount, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function setNodePoolSizeExceptionTest()
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
        $nodeCount = 1539922066;
        try {
            $gapicClient->setNodePoolSize($nodeCount);
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
    public function startIPRotationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
        $expectedResponse->setDetail($detail);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setLocation($location);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setEndTime($endTime);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->startIPRotation();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/StartIPRotation', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function startIPRotationExceptionTest()
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
            $gapicClient->startIPRotation();
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
    public function updateClusterTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
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
        $response = $gapicClient->updateCluster($update);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/UpdateCluster', $actualFuncCall);
        $actualValue = $actualRequestObject->getUpdate();
        $this->assertProtobufEquals($update, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateClusterExceptionTest()
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
        $update = new ClusterUpdate();
        try {
            $gapicClient->updateCluster($update);
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
    public function updateMasterTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
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
        $response = $gapicClient->updateMaster($masterVersion);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/UpdateMaster', $actualFuncCall);
        $actualValue = $actualRequestObject->getMasterVersion();
        $this->assertProtobufEquals($masterVersion, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateMasterExceptionTest()
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
        $masterVersion = 'masterVersion-2139460613';
        try {
            $gapicClient->updateMaster($masterVersion);
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
    public function updateNodePoolTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $zone2 = 'zone2-696322977';
        $detail = 'detail-1335224239';
        $statusMessage = 'statusMessage-239442758';
        $selfLink = 'selfLink-1691268851';
        $targetLink = 'targetLink-2084812312';
        $location = 'location1901043637';
        $startTime = 'startTime-1573145462';
        $endTime = 'endTime1725551537';
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setZone($zone2);
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
        $response = $gapicClient->updateNodePool($nodeVersion, $imageType);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.container.v1.ClusterManager/UpdateNodePool', $actualFuncCall);
        $actualValue = $actualRequestObject->getNodeVersion();
        $this->assertProtobufEquals($nodeVersion, $actualValue);
        $actualValue = $actualRequestObject->getImageType();
        $this->assertProtobufEquals($imageType, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateNodePoolExceptionTest()
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
        $nodeVersion = 'nodeVersion1790136219';
        $imageType = 'imageType-1442758754';
        try {
            $gapicClient->updateNodePool($nodeVersion, $imageType);
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
