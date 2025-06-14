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
use Google\Cloud\Compute\V1\Client\ReservationSubBlocksClient;
use Google\Cloud\Compute\V1\GetReservationSubBlockRequest;
use Google\Cloud\Compute\V1\ListReservationSubBlocksRequest;
use Google\Cloud\Compute\V1\ReservationSubBlock;
use Google\Cloud\Compute\V1\ReservationSubBlocksGetResponse;
use Google\Cloud\Compute\V1\ReservationSubBlocksListResponse;
use Google\Rpc\Code;
use stdClass;

/**
 * @group compute
 *
 * @group gapic
 */
class ReservationSubBlocksClientTest extends GeneratedTest
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

    /** @return ReservationSubBlocksClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new ReservationSubBlocksClient($options);
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
        $expectedResponse = new ReservationSubBlocksGetResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $parentName = 'parentName1015022848';
        $project = 'project-309310695';
        $reservationSubBlock = 'reservationSubBlock22750491';
        $zone = 'zone3744684';
        $request = (new GetReservationSubBlockRequest())
            ->setParentName($parentName)
            ->setProject($project)
            ->setReservationSubBlock($reservationSubBlock)
            ->setZone($zone);
        $response = $gapicClient->get($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.ReservationSubBlocks/Get', $actualFuncCall);
        $actualValue = $actualRequestObject->getParentName();
        $this->assertProtobufEquals($parentName, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getReservationSubBlock();
        $this->assertProtobufEquals($reservationSubBlock, $actualValue);
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
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $parentName = 'parentName1015022848';
        $project = 'project-309310695';
        $reservationSubBlock = 'reservationSubBlock22750491';
        $zone = 'zone3744684';
        $request = (new GetReservationSubBlockRequest())
            ->setParentName($parentName)
            ->setProject($project)
            ->setReservationSubBlock($reservationSubBlock)
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
        $itemsElement = new ReservationSubBlock();
        $items = [
            $itemsElement,
        ];
        $expectedResponse = new ReservationSubBlocksListResponse();
        $expectedResponse->setId($id);
        $expectedResponse->setKind($kind);
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setItems($items);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parentName = 'parentName1015022848';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new ListReservationSubBlocksRequest())
            ->setParentName($parentName)
            ->setProject($project)
            ->setZone($zone);
        $response = $gapicClient->list($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getItems()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.ReservationSubBlocks/List', $actualFuncCall);
        $actualValue = $actualRequestObject->getParentName();
        $this->assertProtobufEquals($parentName, $actualValue);
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
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $parentName = 'parentName1015022848';
        $project = 'project-309310695';
        $zone = 'zone3744684';
        $request = (new ListReservationSubBlocksRequest())
            ->setParentName($parentName)
            ->setProject($project)
            ->setZone($zone);
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
    public function getAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ReservationSubBlocksGetResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $parentName = 'parentName1015022848';
        $project = 'project-309310695';
        $reservationSubBlock = 'reservationSubBlock22750491';
        $zone = 'zone3744684';
        $request = (new GetReservationSubBlockRequest())
            ->setParentName($parentName)
            ->setProject($project)
            ->setReservationSubBlock($reservationSubBlock)
            ->setZone($zone);
        $response = $gapicClient->getAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.ReservationSubBlocks/Get', $actualFuncCall);
        $actualValue = $actualRequestObject->getParentName();
        $this->assertProtobufEquals($parentName, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getReservationSubBlock();
        $this->assertProtobufEquals($reservationSubBlock, $actualValue);
        $actualValue = $actualRequestObject->getZone();
        $this->assertProtobufEquals($zone, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
