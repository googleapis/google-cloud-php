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
use Google\Cloud\Compute\V1\CalendarModeAdviceRequest;
use Google\Cloud\Compute\V1\CalendarModeAdviceResponse;
use Google\Cloud\Compute\V1\CalendarModeAdviceRpcRequest;
use Google\Cloud\Compute\V1\Client\AdviceClient;
use Google\Rpc\Code;
use stdClass;

/**
 * @group compute
 *
 * @group gapic
 */
class AdviceClientTest extends GeneratedTest
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

    /** @return AdviceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AdviceClient($options);
    }

    /** @test */
    public function calendarModeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new CalendarModeAdviceResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $calendarModeAdviceRequestResource = new CalendarModeAdviceRequest();
        $project = 'project-309310695';
        $region = 'region-934795532';
        $request = (new CalendarModeAdviceRpcRequest())
            ->setCalendarModeAdviceRequestResource($calendarModeAdviceRequestResource)
            ->setProject($project)
            ->setRegion($region);
        $response = $gapicClient->calendarMode($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Advice/CalendarMode', $actualFuncCall);
        $actualValue = $actualRequestObject->getCalendarModeAdviceRequestResource();
        $this->assertProtobufEquals($calendarModeAdviceRequestResource, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function calendarModeExceptionTest()
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
        $calendarModeAdviceRequestResource = new CalendarModeAdviceRequest();
        $project = 'project-309310695';
        $region = 'region-934795532';
        $request = (new CalendarModeAdviceRpcRequest())
            ->setCalendarModeAdviceRequestResource($calendarModeAdviceRequestResource)
            ->setProject($project)
            ->setRegion($region);
        try {
            $gapicClient->calendarMode($request);
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
    public function calendarModeAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new CalendarModeAdviceResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $calendarModeAdviceRequestResource = new CalendarModeAdviceRequest();
        $project = 'project-309310695';
        $region = 'region-934795532';
        $request = (new CalendarModeAdviceRpcRequest())
            ->setCalendarModeAdviceRequestResource($calendarModeAdviceRequestResource)
            ->setProject($project)
            ->setRegion($region);
        $response = $gapicClient->calendarModeAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Advice/CalendarMode', $actualFuncCall);
        $actualValue = $actualRequestObject->getCalendarModeAdviceRequestResource();
        $this->assertProtobufEquals($calendarModeAdviceRequestResource, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getRegion();
        $this->assertProtobufEquals($region, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
