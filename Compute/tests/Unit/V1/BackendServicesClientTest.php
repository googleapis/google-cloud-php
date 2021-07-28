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
use Google\Cloud\Compute\V1\BackendService;
use Google\Cloud\Compute\V1\BackendServiceAggregatedList;
use Google\Cloud\Compute\V1\BackendServiceGroupHealth;
use Google\Cloud\Compute\V1\BackendServiceList;
use Google\Cloud\Compute\V1\BackendServicesClient;
use Google\Cloud\Compute\V1\BackendServicesScopedList;
use Google\Cloud\Compute\V1\Operation;
use Google\Cloud\Compute\V1\ResourceGroupReference;
use Google\Cloud\Compute\V1\SecurityPolicyReference;
use Google\Cloud\Compute\V1\SignedUrlKey;
use Google\Rpc\Code;
use stdClass;

/**
 * @group compute
 *
 * @group gapic
 */
class BackendServicesClientTest extends GeneratedTest
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
     * @return BackendServicesClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new BackendServicesClient($options);
    }

    /**
     * @test
     */
    public function addSignedUrlKeyTest()
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
        $region = 'region-934795532';
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
        $expectedResponse->setRegion($region);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setZone($zone);
        $transport->addResponse($expectedResponse);
        // Mock request
        $backendService = 'backendService306946058';
        $project = 'project-309310695';
        $signedUrlKeyResource = new SignedUrlKey();
        $response = $client->addSignedUrlKey($backendService, $project, $signedUrlKeyResource);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.BackendServices/AddSignedUrlKey', $actualFuncCall);
        $actualValue = $actualRequestObject->getBackendService();
        $this->assertProtobufEquals($backendService, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getSignedUrlKeyResource();
        $this->assertProtobufEquals($signedUrlKeyResource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function addSignedUrlKeyExceptionTest()
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
        $backendService = 'backendService306946058';
        $project = 'project-309310695';
        $signedUrlKeyResource = new SignedUrlKey();
        try {
            $client->addSignedUrlKey($backendService, $project, $signedUrlKeyResource);
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
            'itemsKey' => new BackendServicesScopedList(),
        ];
        $expectedResponse = new BackendServiceAggregatedList();
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
        $this->assertSame('/google.cloud.compute.v1.BackendServices/AggregatedList', $actualFuncCall);
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
        $region = 'region-934795532';
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
        $expectedResponse->setRegion($region);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setZone($zone);
        $transport->addResponse($expectedResponse);
        // Mock request
        $backendService = 'backendService306946058';
        $project = 'project-309310695';
        $response = $client->delete($backendService, $project);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.BackendServices/Delete', $actualFuncCall);
        $actualValue = $actualRequestObject->getBackendService();
        $this->assertProtobufEquals($backendService, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
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
        $backendService = 'backendService306946058';
        $project = 'project-309310695';
        try {
            $client->delete($backendService, $project);
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
    public function deleteSignedUrlKeyTest()
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
        $region = 'region-934795532';
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
        $expectedResponse->setRegion($region);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setZone($zone);
        $transport->addResponse($expectedResponse);
        // Mock request
        $backendService = 'backendService306946058';
        $keyName = 'keyName500938859';
        $project = 'project-309310695';
        $response = $client->deleteSignedUrlKey($backendService, $keyName, $project);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.BackendServices/DeleteSignedUrlKey', $actualFuncCall);
        $actualValue = $actualRequestObject->getBackendService();
        $this->assertProtobufEquals($backendService, $actualValue);
        $actualValue = $actualRequestObject->getKeyName();
        $this->assertProtobufEquals($keyName, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteSignedUrlKeyExceptionTest()
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
        $backendService = 'backendService306946058';
        $keyName = 'keyName500938859';
        $project = 'project-309310695';
        try {
            $client->deleteSignedUrlKey($backendService, $keyName, $project);
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
        $affinityCookieTtlSec = 1777486694;
        $creationTimestamp = 'creationTimestamp567396278';
        $description = 'description-1724546052';
        $enableCDN = false;
        $fingerprint = 'fingerprint-1375934236';
        $id = 3355;
        $kind = 'kind3292052';
        $name = 'name3373707';
        $network = 'network1843485230';
        $port = 3446913;
        $portName = 'portName1115276169';
        $region = 'region-934795532';
        $securityPolicy = 'securityPolicy1781695249';
        $selfLink = 'selfLink-1691268851';
        $timeoutSec = 2067488653;
        $expectedResponse = new BackendService();
        $expectedResponse->setAffinityCookieTtlSec($affinityCookieTtlSec);
        $expectedResponse->setCreationTimestamp($creationTimestamp);
        $expectedResponse->setDescription($description);
        $expectedResponse->setEnableCDN($enableCDN);
        $expectedResponse->setFingerprint($fingerprint);
        $expectedResponse->setId($id);
        $expectedResponse->setKind($kind);
        $expectedResponse->setName($name);
        $expectedResponse->setNetwork($network);
        $expectedResponse->setPort($port);
        $expectedResponse->setPortName($portName);
        $expectedResponse->setRegion($region);
        $expectedResponse->setSecurityPolicy($securityPolicy);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTimeoutSec($timeoutSec);
        $transport->addResponse($expectedResponse);
        // Mock request
        $backendService = 'backendService306946058';
        $project = 'project-309310695';
        $response = $client->get($backendService, $project);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.BackendServices/Get', $actualFuncCall);
        $actualValue = $actualRequestObject->getBackendService();
        $this->assertProtobufEquals($backendService, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
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
        $backendService = 'backendService306946058';
        $project = 'project-309310695';
        try {
            $client->get($backendService, $project);
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
    public function getHealthTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $expectedResponse = new BackendServiceGroupHealth();
        $expectedResponse->setKind($kind);
        $transport->addResponse($expectedResponse);
        // Mock request
        $backendService = 'backendService306946058';
        $project = 'project-309310695';
        $resourceGroupReferenceResource = new ResourceGroupReference();
        $response = $client->getHealth($backendService, $project, $resourceGroupReferenceResource);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.BackendServices/GetHealth', $actualFuncCall);
        $actualValue = $actualRequestObject->getBackendService();
        $this->assertProtobufEquals($backendService, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getResourceGroupReferenceResource();
        $this->assertProtobufEquals($resourceGroupReferenceResource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getHealthExceptionTest()
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
        $backendService = 'backendService306946058';
        $project = 'project-309310695';
        $resourceGroupReferenceResource = new ResourceGroupReference();
        try {
            $client->getHealth($backendService, $project, $resourceGroupReferenceResource);
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
        $region = 'region-934795532';
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
        $expectedResponse->setRegion($region);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setZone($zone);
        $transport->addResponse($expectedResponse);
        // Mock request
        $backendServiceResource = new BackendService();
        $project = 'project-309310695';
        $response = $client->insert($backendServiceResource, $project);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.BackendServices/Insert', $actualFuncCall);
        $actualValue = $actualRequestObject->getBackendServiceResource();
        $this->assertProtobufEquals($backendServiceResource, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
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
        $backendServiceResource = new BackendService();
        $project = 'project-309310695';
        try {
            $client->insert($backendServiceResource, $project);
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
        $itemsElement = new BackendService();
        $items = [
            $itemsElement,
        ];
        $expectedResponse = new BackendServiceList();
        $expectedResponse->setId($id);
        $expectedResponse->setKind($kind);
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setItems($items);
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $response = $client->list($project);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getItems()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.BackendServices/List', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
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
        try {
            $client->list($project);
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
    public function patchTest()
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
        $region = 'region-934795532';
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
        $expectedResponse->setRegion($region);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setZone($zone);
        $transport->addResponse($expectedResponse);
        // Mock request
        $backendService = 'backendService306946058';
        $backendServiceResource = new BackendService();
        $project = 'project-309310695';
        $response = $client->patch($backendService, $backendServiceResource, $project);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.BackendServices/Patch', $actualFuncCall);
        $actualValue = $actualRequestObject->getBackendService();
        $this->assertProtobufEquals($backendService, $actualValue);
        $actualValue = $actualRequestObject->getBackendServiceResource();
        $this->assertProtobufEquals($backendServiceResource, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function patchExceptionTest()
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
        $backendService = 'backendService306946058';
        $backendServiceResource = new BackendService();
        $project = 'project-309310695';
        try {
            $client->patch($backendService, $backendServiceResource, $project);
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
    public function setSecurityPolicyTest()
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
        $region = 'region-934795532';
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
        $expectedResponse->setRegion($region);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setZone($zone);
        $transport->addResponse($expectedResponse);
        // Mock request
        $backendService = 'backendService306946058';
        $project = 'project-309310695';
        $securityPolicyReferenceResource = new SecurityPolicyReference();
        $response = $client->setSecurityPolicy($backendService, $project, $securityPolicyReferenceResource);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.BackendServices/SetSecurityPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getBackendService();
        $this->assertProtobufEquals($backendService, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getSecurityPolicyReferenceResource();
        $this->assertProtobufEquals($securityPolicyReferenceResource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function setSecurityPolicyExceptionTest()
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
        $backendService = 'backendService306946058';
        $project = 'project-309310695';
        $securityPolicyReferenceResource = new SecurityPolicyReference();
        try {
            $client->setSecurityPolicy($backendService, $project, $securityPolicyReferenceResource);
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
    public function updateTest()
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
        $region = 'region-934795532';
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
        $expectedResponse->setRegion($region);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setStartTime($startTime);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setZone($zone);
        $transport->addResponse($expectedResponse);
        // Mock request
        $backendService = 'backendService306946058';
        $backendServiceResource = new BackendService();
        $project = 'project-309310695';
        $response = $client->update($backendService, $backendServiceResource, $project);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.BackendServices/Update', $actualFuncCall);
        $actualValue = $actualRequestObject->getBackendService();
        $this->assertProtobufEquals($backendService, $actualValue);
        $actualValue = $actualRequestObject->getBackendServiceResource();
        $this->assertProtobufEquals($backendServiceResource, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function updateExceptionTest()
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
        $backendService = 'backendService306946058';
        $backendServiceResource = new BackendService();
        $project = 'project-309310695';
        try {
            $client->update($backendService, $backendServiceResource, $project);
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
