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
use Google\Cloud\Compute\V1\Disk;
use Google\Cloud\Compute\V1\DiskList;
use Google\Cloud\Compute\V1\Operation;
use Google\Cloud\Compute\V1\Policy;
use Google\Cloud\Compute\V1\RegionDisksAddResourcePoliciesRequest;
use Google\Cloud\Compute\V1\RegionDisksClient;
use Google\Cloud\Compute\V1\RegionDisksRemoveResourcePoliciesRequest;
use Google\Cloud\Compute\V1\RegionDisksResizeRequest;
use Google\Cloud\Compute\V1\RegionSetLabelsRequest;
use Google\Cloud\Compute\V1\RegionSetPolicyRequest;
use Google\Cloud\Compute\V1\Snapshot;
use Google\Cloud\Compute\V1\TestPermissionsRequest;
use Google\Cloud\Compute\V1\TestPermissionsResponse;
use Google\Rpc\Code;
use stdClass;

/**
 * @group compute
 *
 * @group gapic
 */
class RegionDisksClientTest extends GeneratedTest
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
     * @return RegionDisksClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new RegionDisksClient($options);
    }

    /**
     * @test
     */
    public function addResourcePoliciesTest()
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
        $disk = 'disk3083677';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionDisksAddResourcePoliciesRequestResource = new RegionDisksAddResourcePoliciesRequest();
        $response = $client->addResourcePolicies($disk, $project, $region, $regionDisksAddResourcePoliciesRequestResource);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionDisks/AddResourcePolicies', $actualFuncCall);
        $actualValue = $actualRequestObject->getDisk();
        $this->assertProtobufEquals($disk, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualRequestObject->getRegionDisksAddResourcePoliciesRequestResource();
        $this->assertProtobufEquals($regionDisksAddResourcePoliciesRequestResource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function addResourcePoliciesExceptionTest()
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
        $disk = 'disk3083677';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionDisksAddResourcePoliciesRequestResource = new RegionDisksAddResourcePoliciesRequest();
        try {
            $client->addResourcePolicies($disk, $project, $region, $regionDisksAddResourcePoliciesRequestResource);
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
    public function createSnapshotTest()
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
        $disk = 'disk3083677';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $snapshotResource = new Snapshot();
        $response = $client->createSnapshot($disk, $project, $region, $snapshotResource);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionDisks/CreateSnapshot', $actualFuncCall);
        $actualValue = $actualRequestObject->getDisk();
        $this->assertProtobufEquals($disk, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualRequestObject->getSnapshotResource();
        $this->assertProtobufEquals($snapshotResource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function createSnapshotExceptionTest()
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
        $disk = 'disk3083677';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $snapshotResource = new Snapshot();
        try {
            $client->createSnapshot($disk, $project, $region, $snapshotResource);
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
        $disk = 'disk3083677';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $response = $client->delete($disk, $project, $region);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionDisks/Delete', $actualFuncCall);
        $actualValue = $actualRequestObject->getDisk();
        $this->assertProtobufEquals($disk, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
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
        $disk = 'disk3083677';
        $project = 'project-309310695';
        $region = 'region-934795532';
        try {
            $client->delete($disk, $project, $region);
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
        $labelFingerprint = 'labelFingerprint714995737';
        $lastAttachTimestamp = 'lastAttachTimestamp-2105323995';
        $lastDetachTimestamp = 'lastDetachTimestamp-480399885';
        $locationHint = 'locationHint-1796964143';
        $name = 'name3373707';
        $options = 'options-1249474914';
        $physicalBlockSizeBytes = 1190604793;
        $provisionedIops = 1260510932;
        $region2 = 'region2-690338393';
        $satisfiesPzs = false;
        $selfLink = 'selfLink-1691268851';
        $sizeGb = 2105542105;
        $sourceDisk = 'sourceDisk-85117119';
        $sourceDiskId = 'sourceDiskId-1693292839';
        $sourceImage = 'sourceImage1661056055';
        $sourceImageId = 'sourceImageId-2092155357';
        $sourceSnapshot = 'sourceSnapshot-947679896';
        $sourceSnapshotId = 'sourceSnapshotId-1511650478';
        $sourceStorageObject = 'sourceStorageObject-303818201';
        $type = 'type3575610';
        $zone = 'zone3744684';
        $expectedResponse = new Disk();
        $expectedResponse->setCreationTimestamp($creationTimestamp);
        $expectedResponse->setDescription($description);
        $expectedResponse->setId($id);
        $expectedResponse->setKind($kind);
        $expectedResponse->setLabelFingerprint($labelFingerprint);
        $expectedResponse->setLastAttachTimestamp($lastAttachTimestamp);
        $expectedResponse->setLastDetachTimestamp($lastDetachTimestamp);
        $expectedResponse->setLocationHint($locationHint);
        $expectedResponse->setName($name);
        $expectedResponse->setOptions($options);
        $expectedResponse->setPhysicalBlockSizeBytes($physicalBlockSizeBytes);
        $expectedResponse->setProvisionedIops($provisionedIops);
        $expectedResponse->setRegion($region2);
        $expectedResponse->setSatisfiesPzs($satisfiesPzs);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setSizeGb($sizeGb);
        $expectedResponse->setSourceDisk($sourceDisk);
        $expectedResponse->setSourceDiskId($sourceDiskId);
        $expectedResponse->setSourceImage($sourceImage);
        $expectedResponse->setSourceImageId($sourceImageId);
        $expectedResponse->setSourceSnapshot($sourceSnapshot);
        $expectedResponse->setSourceSnapshotId($sourceSnapshotId);
        $expectedResponse->setSourceStorageObject($sourceStorageObject);
        $expectedResponse->setType($type);
        $expectedResponse->setZone($zone);
        $transport->addResponse($expectedResponse);
        // Mock request
        $disk = 'disk3083677';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $response = $client->get($disk, $project, $region);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionDisks/Get', $actualFuncCall);
        $actualValue = $actualRequestObject->getDisk();
        $this->assertProtobufEquals($disk, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
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
        $disk = 'disk3083677';
        $project = 'project-309310695';
        $region = 'region-934795532';
        try {
            $client->get($disk, $project, $region);
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
    public function getIamPolicyTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $region = 'region-934795532';
        $resource = 'resource-341064690';
        $response = $client->getIamPolicy($project, $region, $resource);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionDisks/GetIamPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getIamPolicyExceptionTest()
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
        $resource = 'resource-341064690';
        try {
            $client->getIamPolicy($project, $region, $resource);
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
        $diskResource = new Disk();
        $project = 'project-309310695';
        $region = 'region-934795532';
        $response = $client->insert($diskResource, $project, $region);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionDisks/Insert', $actualFuncCall);
        $actualValue = $actualRequestObject->getDiskResource();
        $this->assertProtobufEquals($diskResource, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
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
        $diskResource = new Disk();
        $project = 'project-309310695';
        $region = 'region-934795532';
        try {
            $client->insert($diskResource, $project, $region);
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
        $itemsElement = new Disk();
        $items = [
            $itemsElement,
        ];
        $expectedResponse = new DiskList();
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
        $this->assertSame('/google.cloud.compute.v1.RegionDisks/List', $actualFuncCall);
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

    /**
     * @test
     */
    public function removeResourcePoliciesTest()
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
        $disk = 'disk3083677';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionDisksRemoveResourcePoliciesRequestResource = new RegionDisksRemoveResourcePoliciesRequest();
        $response = $client->removeResourcePolicies($disk, $project, $region, $regionDisksRemoveResourcePoliciesRequestResource);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionDisks/RemoveResourcePolicies', $actualFuncCall);
        $actualValue = $actualRequestObject->getDisk();
        $this->assertProtobufEquals($disk, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualRequestObject->getRegionDisksRemoveResourcePoliciesRequestResource();
        $this->assertProtobufEquals($regionDisksRemoveResourcePoliciesRequestResource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function removeResourcePoliciesExceptionTest()
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
        $disk = 'disk3083677';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionDisksRemoveResourcePoliciesRequestResource = new RegionDisksRemoveResourcePoliciesRequest();
        try {
            $client->removeResourcePolicies($disk, $project, $region, $regionDisksRemoveResourcePoliciesRequestResource);
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
    public function resizeTest()
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
        $disk = 'disk3083677';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionDisksResizeRequestResource = new RegionDisksResizeRequest();
        $response = $client->resize($disk, $project, $region, $regionDisksResizeRequestResource);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionDisks/Resize', $actualFuncCall);
        $actualValue = $actualRequestObject->getDisk();
        $this->assertProtobufEquals($disk, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualRequestObject->getRegionDisksResizeRequestResource();
        $this->assertProtobufEquals($regionDisksResizeRequestResource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function resizeExceptionTest()
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
        $disk = 'disk3083677';
        $project = 'project-309310695';
        $region = 'region-934795532';
        $regionDisksResizeRequestResource = new RegionDisksResizeRequest();
        try {
            $client->resize($disk, $project, $region, $regionDisksResizeRequestResource);
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
    public function setIamPolicyTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $region = 'region-934795532';
        $regionSetPolicyRequestResource = new RegionSetPolicyRequest();
        $resource = 'resource-341064690';
        $response = $client->setIamPolicy($project, $region, $regionSetPolicyRequestResource, $resource);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionDisks/SetIamPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualRequestObject->getRegionSetPolicyRequestResource();
        $this->assertProtobufEquals($regionSetPolicyRequestResource, $actualValue);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function setIamPolicyExceptionTest()
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
        $regionSetPolicyRequestResource = new RegionSetPolicyRequest();
        $resource = 'resource-341064690';
        try {
            $client->setIamPolicy($project, $region, $regionSetPolicyRequestResource, $resource);
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
        $regionSetLabelsRequestResource = new RegionSetLabelsRequest();
        $resource = 'resource-341064690';
        $response = $client->setLabels($project, $region, $regionSetLabelsRequestResource, $resource);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionDisks/SetLabels', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualRequestObject->getRegionSetLabelsRequestResource();
        $this->assertProtobufEquals($regionSetLabelsRequestResource, $actualValue);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function setLabelsExceptionTest()
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
        $regionSetLabelsRequestResource = new RegionSetLabelsRequest();
        $resource = 'resource-341064690';
        try {
            $client->setLabels($project, $region, $regionSetLabelsRequestResource, $resource);
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
    public function testIamPermissionsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new TestPermissionsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $region = 'region-934795532';
        $resource = 'resource-341064690';
        $testPermissionsRequestResource = new TestPermissionsRequest();
        $response = $client->testIamPermissions($project, $region, $resource, $testPermissionsRequestResource);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.RegionDisks/TestIamPermissions', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $actualValue = $actualRequestObject->getTestPermissionsRequestResource();
        $this->assertProtobufEquals($testPermissionsRequestResource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function testIamPermissionsExceptionTest()
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
        $resource = 'resource-341064690';
        $testPermissionsRequestResource = new TestPermissionsRequest();
        try {
            $client->testIamPermissions($project, $region, $resource, $testPermissionsRequestResource);
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
