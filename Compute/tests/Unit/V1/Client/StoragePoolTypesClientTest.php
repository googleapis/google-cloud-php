<?php
/*
 * Copyright 2025 Google LLC
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
use Google\Cloud\Compute\V1\AggregatedListStoragePoolTypesRequest;
use Google\Cloud\Compute\V1\Client\StoragePoolTypesClient;
use Google\Cloud\Compute\V1\GetStoragePoolTypeRequest;
use Google\Cloud\Compute\V1\ListStoragePoolTypesRequest;
use Google\Cloud\Compute\V1\StoragePoolType;
use Google\Cloud\Compute\V1\StoragePoolTypeAggregatedList;
use Google\Cloud\Compute\V1\StoragePoolTypeList;
use Google\Cloud\Compute\V1\StoragePoolTypesScopedList;
use Google\Rpc\Code;
use stdClass;

/**
 * @group compute
 *
 * @group gapic
 */
class StoragePoolTypesClientTest extends GeneratedTest
{
    /** @return TransportInterface */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /** @return CredentialsWrapper */
    private function createCredentials()
    {
        return $this->getMockBuilder(CredentialsWrapper::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /** @return StoragePoolTypesClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new StoragePoolTypesClient($options);
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
            'itemsKey' => new StoragePoolTypesScopedList(),
        ];
        $expectedResponse = new StoragePoolTypeAggregatedList();
        $expectedResponse->setId($id);
        $expectedResponse->setKind($kind);
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setItems($items);
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $request = (new AggregatedListStoragePoolTypesRequest())->setProject($project);
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
        $this->assertSame('/google.cloud.compute.v1.StoragePoolTypes/AggregatedList', $actualFuncCall);
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
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $project = 'project-309310695';
        $request = (new AggregatedListStoragePoolTypesRequest())->setProject($project);
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
    public function getTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $creationTimestamp = 'creationTimestamp567396278';
        $description = 'description-1724546052';
        $id = 3355;
        $kind = 'kind3292052';
        $maxPoolProvisionedCapacityGb = 1255880909;
        $maxPoolProvisionedIops = 1095342084;
        $maxPoolProvisionedThroughput = 1302669885;
        $minPoolProvisionedCapacityGb = 345848161;
        $minPoolProvisionedIops = 1194139030;
        $minPoolProvisionedThroughput = 1242850773;
        $minSizeGb = 1459020012;
        $name = 'name3373707';
        $selfLink = 'selfLink-1691268851';
        $selfLinkWithId = 'selfLinkWithId-1029220862';
        $zone2 = 'zone2-696322977';
        $expectedResponse = new StoragePoolType();
        $expectedResponse->setCreationTimestamp($creationTimestamp);
        $expectedResponse->setDescription($description);
        $expectedResponse->setId($id);
        $expectedResponse->setKind($kind);
        $expectedResponse->setMaxPoolProvisionedCapacityGb($maxPoolProvisionedCapacityGb);
        $expectedResponse->setMaxPoolProvisionedIops($maxPoolProvisionedIops);
        $expectedResponse->setMaxPoolProvisionedThroughput($maxPoolProvisionedThroughput);
        $expectedResponse->setMinPoolProvisionedCapacityGb($minPoolProvisionedCapacityGb);
        $expectedResponse->setMinPoolProvisionedIops($minPoolProvisionedIops);
        $expectedResponse->setMinPoolProvisionedThroughput($minPoolProvisionedThroughput);
        $expectedResponse->setMinSizeGb($minSizeGb);
        $expectedResponse->setName($name);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setSelfLinkWithId($selfLinkWithId);
        $expectedResponse->setZone($zone2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $storagePoolType = 'storagePoolType1896612025';
        $zone = 'zone3744684';
        $request = (new GetStoragePoolTypeRequest())
            ->setProject($project)
            ->setStoragePoolType($storagePoolType)
            ->setZone($zone);
        $response = $gapicClient->get($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.StoragePoolTypes/Get', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getStoragePoolType();
        $this->assertProtobufEquals($storagePoolType, $actualValue);
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
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $project = 'project-309310695';
        $storagePoolType = 'storagePoolType1896612025';
        $zone = 'zone3744684';
        $request = (new GetStoragePoolTypeRequest())
            ->setProject($project)
            ->setStoragePoolType($storagePoolType)
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
        $itemsElement = new StoragePoolType();
        $items = [$itemsElement];
        $expectedResponse = new StoragePoolTypeList();
        $expectedResponse->setId($id);
        $expectedResponse->setKind($kind);
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setItems($items);
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new ListStoragePoolTypesRequest())->setProject($project)->setZone($zone);
        $response = $gapicClient->list($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getItems()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.StoragePoolTypes/List', $actualFuncCall);
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
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new ListStoragePoolTypesRequest())->setProject($project)->setZone($zone);
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
    public function aggregatedListAsyncTest()
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
            'itemsKey' => new StoragePoolTypesScopedList(),
        ];
        $expectedResponse = new StoragePoolTypeAggregatedList();
        $expectedResponse->setId($id);
        $expectedResponse->setKind($kind);
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setItems($items);
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $request = (new AggregatedListStoragePoolTypesRequest())->setProject($project);
        $response = $gapicClient->aggregatedListAsync($request)->wait();
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
        $this->assertSame('/google.cloud.compute.v1.StoragePoolTypes/AggregatedList', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
