<?php
/*
 * Copyright 2021 Google LLC
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

namespace Google\Cloud\Compute\Tests\Unit\V1;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;

use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Compute\V1\Operation;
use Google\Cloud\Compute\V1\TargetVpnGateway;
use Google\Cloud\Compute\V1\TargetVpnGatewayAggregatedList;
use Google\Cloud\Compute\V1\TargetVpnGatewayList;
use Google\Cloud\Compute\V1\TargetVpnGatewaysClient;
use Google\Cloud\Compute\V1\TargetVpnGatewaysScopedList;
use Google\Rpc\Code;
use stdClass;

/**
 * @group compute
 *
 * @group gapic
 */
class TargetVpnGatewaysClientTest extends GeneratedTest
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
     * @return TargetVpnGatewaysClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new TargetVpnGatewaysClient($options);
    }

    /**
     * @test
     */
    public function aggregatedListTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $id = 'id3355';
        $kind = 'kind3292052';
        $nextPageToken = '';
        $selfLink = 'selfLink-1691268851';
        $items = [
            'itemsKey' => new TargetVpnGatewaysScopedList(),
        ];
        $expectedResponse = new TargetVpnGatewayAggregatedList();
        $expectedResponse->setId($id);
        $expectedResponse->setKind($kind);
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setItems($items);
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $response = $client->aggregatedList($project);
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
        $this->assertSame('/google.cloud.compute.v1.TargetVpnGateways/AggregatedList', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function aggregatedListExceptionTest()
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
        $project = 'project-309310695';
        try {
            $client->aggregatedList($project);
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
    public function deleteTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $clientOperationId = 'clientOperationId-239630617';
        $creationTimestamp = 'creationTimestamp567396278';
        $description = 'description-1724546052';
        $endTime = 'endTime1725551537';
        $httpErrorMessage = 'httpErrorMessage1276263769';
        $httpErrorStatusCode = 1386087020;
        $id = 3355;
        $insertTime = 'insertTime-103148397';
        $kind = 'kind3292052';
        $name = 'name3373707';
        $operationGroupId = 'operationGroupId40171187';
        $operationType = 'operationType-1432962286';
        $progress = 1001078227;
        $region2 = 'region2-690338393';
        $selfLink = 'selfLink-1691268851';
        $startTime = 'startTime-1573145462';
        $statusMessage = 'statusMessage-239442758';
        $targetId = 815576439;
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $zone = 'zone3744684';
        $expectedResponse = new Operation();
        $expectedResponse->setClientOperationId($clientOperationId);
        $expectedResponse->setCreationTimestamp($creationTimestamp);
        $expectedResponse->setDescription($description);
        $expectedResponse->setEndTime($endTime);
        $expectedResponse->setHttpErrorMessage($httpErrorMessage);
        $expectedResponse->setHttpErrorStatusCode($httpErrorStatusCode);
        $expectedResponse->setId($id);
        $expectedResponse->setInsertTime($insertTime);
        $expectedResponse->setKind($kind);
        $expectedResponse->setName($name);
        $expectedResponse->setOperationGroupId($operationGroupId);
        $expectedResponse->setOperationType($operationType);
        $expectedResponse->setProgress($progress);
        $expectedResponse->setRegion($region2);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setZone($zone);
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $region = 'region-934795532';
        $targetVpnGateway = 'targetVpnGateway-4358069';
        $response = $client->delete($project, $region, $targetVpnGateway);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.TargetVpnGateways/Delete', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualRequestObject->getTargetVpnGateway();
        $this->assertProtobufEquals($targetVpnGateway, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteExceptionTest()
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
        $project = 'project-309310695';
        $region = 'region-934795532';
        $targetVpnGateway = 'targetVpnGateway-4358069';
        try {
            $client->delete($project, $region, $targetVpnGateway);
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
    public function getTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $creationTimestamp = 'creationTimestamp567396278';
        $description = 'description-1724546052';
        $id = 3355;
        $kind = 'kind3292052';
        $name = 'name3373707';
        $network = 'network1843485230';
        $region2 = 'region2-690338393';
        $selfLink = 'selfLink-1691268851';
        $expectedResponse = new TargetVpnGateway();
        $expectedResponse->setCreationTimestamp($creationTimestamp);
        $expectedResponse->setDescription($description);
        $expectedResponse->setId($id);
        $expectedResponse->setKind($kind);
        $expectedResponse->setName($name);
        $expectedResponse->setNetwork($network);
        $expectedResponse->setRegion($region2);
        $expectedResponse->setSelfLink($selfLink);
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $region = 'region-934795532';
        $targetVpnGateway = 'targetVpnGateway-4358069';
        $response = $client->get($project, $region, $targetVpnGateway);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.TargetVpnGateways/Get', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualRequestObject->getTargetVpnGateway();
        $this->assertProtobufEquals($targetVpnGateway, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getExceptionTest()
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
        $project = 'project-309310695';
        $region = 'region-934795532';
        $targetVpnGateway = 'targetVpnGateway-4358069';
        try {
            $client->get($project, $region, $targetVpnGateway);
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
    public function insertTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $clientOperationId = 'clientOperationId-239630617';
        $creationTimestamp = 'creationTimestamp567396278';
        $description = 'description-1724546052';
        $endTime = 'endTime1725551537';
        $httpErrorMessage = 'httpErrorMessage1276263769';
        $httpErrorStatusCode = 1386087020;
        $id = 3355;
        $insertTime = 'insertTime-103148397';
        $kind = 'kind3292052';
        $name = 'name3373707';
        $operationGroupId = 'operationGroupId40171187';
        $operationType = 'operationType-1432962286';
        $progress = 1001078227;
        $region2 = 'region2-690338393';
        $selfLink = 'selfLink-1691268851';
        $startTime = 'startTime-1573145462';
        $statusMessage = 'statusMessage-239442758';
        $targetId = 815576439;
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $zone = 'zone3744684';
        $expectedResponse = new Operation();
        $expectedResponse->setClientOperationId($clientOperationId);
        $expectedResponse->setCreationTimestamp($creationTimestamp);
        $expectedResponse->setDescription($description);
        $expectedResponse->setEndTime($endTime);
        $expectedResponse->setHttpErrorMessage($httpErrorMessage);
        $expectedResponse->setHttpErrorStatusCode($httpErrorStatusCode);
        $expectedResponse->setId($id);
        $expectedResponse->setInsertTime($insertTime);
        $expectedResponse->setKind($kind);
        $expectedResponse->setName($name);
        $expectedResponse->setOperationGroupId($operationGroupId);
        $expectedResponse->setOperationType($operationType);
        $expectedResponse->setProgress($progress);
        $expectedResponse->setRegion($region2);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setZone($zone);
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $region = 'region-934795532';
        $targetVpnGatewayResource = new TargetVpnGateway();
        $response = $client->insert($project, $region, $targetVpnGatewayResource);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.TargetVpnGateways/Insert', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualRequestObject->getTargetVpnGatewayResource();
        $this->assertProtobufEquals($targetVpnGatewayResource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function insertExceptionTest()
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
        $project = 'project-309310695';
        $region = 'region-934795532';
        $targetVpnGatewayResource = new TargetVpnGateway();
        try {
            $client->insert($project, $region, $targetVpnGatewayResource);
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
    public function listTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $id = 'id3355';
        $kind = 'kind3292052';
        $nextPageToken = '';
        $selfLink = 'selfLink-1691268851';
        $itemsElement = new TargetVpnGateway();
        $items = [
            $itemsElement,
        ];
        $expectedResponse = new TargetVpnGatewayList();
        $expectedResponse->setId($id);
        $expectedResponse->setKind($kind);
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setItems($items);
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $region = 'region-934795532';
        $response = $client->list($project, $region);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getItems()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.TargetVpnGateways/List', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listExceptionTest()
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
        $project = 'project-309310695';
        $region = 'region-934795532';
        try {
            $client->list($project, $region);
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
