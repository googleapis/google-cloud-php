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
use Google\Cloud\Compute\V1\DeprecationStatus;
use Google\Cloud\Compute\V1\GetGlobalOperationRequest;
use Google\Cloud\Compute\V1\GlobalOperationsClient;
use Google\Cloud\Compute\V1\GlobalSetLabelsRequest;
use Google\Cloud\Compute\V1\GlobalSetPolicyRequest;
use Google\Cloud\Compute\V1\Image;
use Google\Cloud\Compute\V1\ImageList;
use Google\Cloud\Compute\V1\ImagesClient;
use Google\Cloud\Compute\V1\Operation;
use Google\Cloud\Compute\V1\Operation\Status;
use Google\Cloud\Compute\V1\Policy;
use Google\Cloud\Compute\V1\TestPermissionsRequest;
use Google\Cloud\Compute\V1\TestPermissionsResponse;
use Google\Rpc\Code;
use stdClass;

/**
 * @group compute
 *
 * @group gapic
 */
class ImagesClientTest extends GeneratedTest
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
     * @return ImagesClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new ImagesClient($options);
    }

    /**
     * @test
     */
    public function deleteTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new GlobalOperationsClient([
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
        $incompleteOperation->setName('customOperations/deleteTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/deleteTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $image = 'image100313435';
        $project = 'project-309310695';
        $response = $client->delete($image, $project);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Images/Delete', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getImage();
        $this->assertProtobufEquals($image, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $expectedOperationsRequestObject = new GetGlobalOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
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
        $this->assertSame('/google.cloud.compute.v1.GlobalOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new GlobalOperationsClient([
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
        $image = 'image100313435';
        $project = 'project-309310695';
        $response = $client->delete($image, $project);
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

    /**
     * @test
     */
    public function deprecateTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new GlobalOperationsClient([
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
        $incompleteOperation->setName('customOperations/deprecateTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/deprecateTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $deprecationStatusResource = new DeprecationStatus();
        $image = 'image100313435';
        $project = 'project-309310695';
        $response = $client->deprecate($deprecationStatusResource, $image, $project);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Images/Deprecate', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getDeprecationStatusResource();
        $this->assertProtobufEquals($deprecationStatusResource, $actualValue);
        $actualValue = $actualApiRequestObject->getImage();
        $this->assertProtobufEquals($image, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $expectedOperationsRequestObject = new GetGlobalOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
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
        $this->assertSame('/google.cloud.compute.v1.GlobalOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function deprecateExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new GlobalOperationsClient([
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
        $incompleteOperation->setName('customOperations/deprecateExceptionTest');
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
        $deprecationStatusResource = new DeprecationStatus();
        $image = 'image100313435';
        $project = 'project-309310695';
        $response = $client->deprecate($deprecationStatusResource, $image, $project);
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
        $archiveSizeBytes = 1766390198;
        $creationTimestamp = 'creationTimestamp567396278';
        $description = 'description-1724546052';
        $diskSizeGb = 757478089;
        $family = 'family-1281860764';
        $id = 3355;
        $kind = 'kind3292052';
        $labelFingerprint = 'labelFingerprint714995737';
        $name = 'name3373707';
        $satisfiesPzs = false;
        $selfLink = 'selfLink-1691268851';
        $sourceDisk = 'sourceDisk-85117119';
        $sourceDiskId = 'sourceDiskId-1693292839';
        $sourceImage = 'sourceImage1661056055';
        $sourceImageId = 'sourceImageId-2092155357';
        $sourceSnapshot = 'sourceSnapshot-947679896';
        $sourceSnapshotId = 'sourceSnapshotId-1511650478';
        $expectedResponse = new Image();
        $expectedResponse->setArchiveSizeBytes($archiveSizeBytes);
        $expectedResponse->setCreationTimestamp($creationTimestamp);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDiskSizeGb($diskSizeGb);
        $expectedResponse->setFamily($family);
        $expectedResponse->setId($id);
        $expectedResponse->setKind($kind);
        $expectedResponse->setLabelFingerprint($labelFingerprint);
        $expectedResponse->setName($name);
        $expectedResponse->setSatisfiesPzs($satisfiesPzs);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setSourceDisk($sourceDisk);
        $expectedResponse->setSourceDiskId($sourceDiskId);
        $expectedResponse->setSourceImage($sourceImage);
        $expectedResponse->setSourceImageId($sourceImageId);
        $expectedResponse->setSourceSnapshot($sourceSnapshot);
        $expectedResponse->setSourceSnapshotId($sourceSnapshotId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $image = 'image100313435';
        $project = 'project-309310695';
        $response = $client->get($image, $project);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Images/Get', $actualFuncCall);
        $actualValue = $actualRequestObject->getImage();
        $this->assertProtobufEquals($image, $actualValue);
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
        $image = 'image100313435';
        $project = 'project-309310695';
        try {
            $client->get($image, $project);
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
    public function getFromFamilyTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $archiveSizeBytes = 1766390198;
        $creationTimestamp = 'creationTimestamp567396278';
        $description = 'description-1724546052';
        $diskSizeGb = 757478089;
        $family2 = 'family2787422743';
        $id = 3355;
        $kind = 'kind3292052';
        $labelFingerprint = 'labelFingerprint714995737';
        $name = 'name3373707';
        $satisfiesPzs = false;
        $selfLink = 'selfLink-1691268851';
        $sourceDisk = 'sourceDisk-85117119';
        $sourceDiskId = 'sourceDiskId-1693292839';
        $sourceImage = 'sourceImage1661056055';
        $sourceImageId = 'sourceImageId-2092155357';
        $sourceSnapshot = 'sourceSnapshot-947679896';
        $sourceSnapshotId = 'sourceSnapshotId-1511650478';
        $expectedResponse = new Image();
        $expectedResponse->setArchiveSizeBytes($archiveSizeBytes);
        $expectedResponse->setCreationTimestamp($creationTimestamp);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDiskSizeGb($diskSizeGb);
        $expectedResponse->setFamily($family2);
        $expectedResponse->setId($id);
        $expectedResponse->setKind($kind);
        $expectedResponse->setLabelFingerprint($labelFingerprint);
        $expectedResponse->setName($name);
        $expectedResponse->setSatisfiesPzs($satisfiesPzs);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setSourceDisk($sourceDisk);
        $expectedResponse->setSourceDiskId($sourceDiskId);
        $expectedResponse->setSourceImage($sourceImage);
        $expectedResponse->setSourceImageId($sourceImageId);
        $expectedResponse->setSourceSnapshot($sourceSnapshot);
        $expectedResponse->setSourceSnapshotId($sourceSnapshotId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $family = 'family-1281860764';
        $project = 'project-309310695';
        $response = $client->getFromFamily($family, $project);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Images/GetFromFamily', $actualFuncCall);
        $actualValue = $actualRequestObject->getFamily();
        $this->assertProtobufEquals($family, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getFromFamilyExceptionTest()
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
        $family = 'family-1281860764';
        $project = 'project-309310695';
        try {
            $client->getFromFamily($family, $project);
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
        $resource = 'resource-341064690';
        $response = $client->getIamPolicy($project, $resource);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Images/GetIamPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
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
        $resource = 'resource-341064690';
        try {
            $client->getIamPolicy($project, $resource);
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
        $operationsTransport = $this->createTransport();
        $operationsClient = new GlobalOperationsClient([
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
        $incompleteOperation->setName('customOperations/insertTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/insertTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $imageResource = new Image();
        $project = 'project-309310695';
        $response = $client->insert($imageResource, $project);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Images/Insert', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getImageResource();
        $this->assertProtobufEquals($imageResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $expectedOperationsRequestObject = new GetGlobalOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
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
        $this->assertSame('/google.cloud.compute.v1.GlobalOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function insertExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new GlobalOperationsClient([
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
        $imageResource = new Image();
        $project = 'project-309310695';
        $response = $client->insert($imageResource, $project);
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
        $itemsElement = new Image();
        $items = [
            $itemsElement,
        ];
        $expectedResponse = new ImageList();
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
        $this->assertSame('/google.cloud.compute.v1.Images/List', $actualFuncCall);
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
        $operationsTransport = $this->createTransport();
        $operationsClient = new GlobalOperationsClient([
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
        $incompleteOperation->setName('customOperations/patchTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/patchTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $image = 'image100313435';
        $imageResource = new Image();
        $project = 'project-309310695';
        $response = $client->patch($image, $imageResource, $project);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Images/Patch', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getImage();
        $this->assertProtobufEquals($image, $actualValue);
        $actualValue = $actualApiRequestObject->getImageResource();
        $this->assertProtobufEquals($imageResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $expectedOperationsRequestObject = new GetGlobalOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
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
        $this->assertSame('/google.cloud.compute.v1.GlobalOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function patchExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new GlobalOperationsClient([
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
        $image = 'image100313435';
        $imageResource = new Image();
        $project = 'project-309310695';
        $response = $client->patch($image, $imageResource, $project);
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
        $globalSetPolicyRequestResource = new GlobalSetPolicyRequest();
        $project = 'project-309310695';
        $resource = 'resource-341064690';
        $response = $client->setIamPolicy($globalSetPolicyRequestResource, $project, $resource);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Images/SetIamPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getGlobalSetPolicyRequestResource();
        $this->assertProtobufEquals($globalSetPolicyRequestResource, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
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
        $globalSetPolicyRequestResource = new GlobalSetPolicyRequest();
        $project = 'project-309310695';
        $resource = 'resource-341064690';
        try {
            $client->setIamPolicy($globalSetPolicyRequestResource, $project, $resource);
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
        $operationsTransport = $this->createTransport();
        $operationsClient = new GlobalOperationsClient([
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
        $incompleteOperation->setName('customOperations/setLabelsTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/setLabelsTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $globalSetLabelsRequestResource = new GlobalSetLabelsRequest();
        $project = 'project-309310695';
        $resource = 'resource-341064690';
        $response = $client->setLabels($globalSetLabelsRequestResource, $project, $resource);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Images/SetLabels', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getGlobalSetLabelsRequestResource();
        $this->assertProtobufEquals($globalSetLabelsRequestResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualApiRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $expectedOperationsRequestObject = new GetGlobalOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
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
        $this->assertSame('/google.cloud.compute.v1.GlobalOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function setLabelsExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new GlobalOperationsClient([
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
        $globalSetLabelsRequestResource = new GlobalSetLabelsRequest();
        $project = 'project-309310695';
        $resource = 'resource-341064690';
        $response = $client->setLabels($globalSetLabelsRequestResource, $project, $resource);
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
        $resource = 'resource-341064690';
        $testPermissionsRequestResource = new TestPermissionsRequest();
        $response = $client->testIamPermissions($project, $resource, $testPermissionsRequestResource);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Images/TestIamPermissions', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
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
        $resource = 'resource-341064690';
        $testPermissionsRequestResource = new TestPermissionsRequest();
        try {
            $client->testIamPermissions($project, $resource, $testPermissionsRequestResource);
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
