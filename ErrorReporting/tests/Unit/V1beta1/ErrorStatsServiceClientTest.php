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

namespace Google\Cloud\ErrorReporting\Tests\Unit\V1beta1;

use Google\Cloud\ErrorReporting\V1beta1\ErrorStatsServiceClient;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\ErrorReporting\V1beta1\DeleteEventsResponse;
use Google\Cloud\ErrorReporting\V1beta1\ErrorEvent;
use Google\Cloud\ErrorReporting\V1beta1\ErrorGroupStats;
use Google\Cloud\ErrorReporting\V1beta1\ListEventsResponse;
use Google\Cloud\ErrorReporting\V1beta1\ListGroupStatsResponse;
use Google\Cloud\ErrorReporting\V1beta1\QueryTimeRange;
use Google\Protobuf\Any;
use Google\Rpc\Code;
use stdClass;

/**
 * @group error-reporting
 * @group grpc
 */
class ErrorStatsServiceClientTest extends GeneratedTest
{
    /**
     * @return TransportInterface
     */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /**
     * @return ErrorStatsServiceClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->getMockBuilder(CredentialsWrapper::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        return new ErrorStatsServiceClient($options);
    }

    /**
     * @test
     */
    public function listGroupStatsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $nextPageToken = '';
        $errorGroupStatsElement = new ErrorGroupStats();
        $errorGroupStats = [$errorGroupStatsElement];
        $expectedResponse = new ListGroupStatsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setErrorGroupStats($errorGroupStats);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedProjectName = $client->projectName('[PROJECT]');
        $timeRange = new QueryTimeRange();

        $response = $client->listGroupStats($formattedProjectName, $timeRange);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getErrorGroupStats()[0], $resources[0]);

        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.devtools.clouderrorreporting.v1beta1.ErrorStatsService/ListGroupStats', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectName();

        $this->assertProtobufEquals($formattedProjectName, $actualValue);
        $actualValue = $actualRequestObject->getTimeRange();

        $this->assertProtobufEquals($timeRange, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listGroupStatsExceptionTest()
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
        $formattedProjectName = $client->projectName('[PROJECT]');
        $timeRange = new QueryTimeRange();

        try {
            $client->listGroupStats($formattedProjectName, $timeRange);
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
    public function listEventsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $nextPageToken = '';
        $errorEventsElement = new ErrorEvent();
        $errorEvents = [$errorEventsElement];
        $expectedResponse = new ListEventsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setErrorEvents($errorEvents);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedProjectName = $client->projectName('[PROJECT]');
        $groupId = 'groupId506361563';

        $response = $client->listEvents($formattedProjectName, $groupId);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getErrorEvents()[0], $resources[0]);

        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.devtools.clouderrorreporting.v1beta1.ErrorStatsService/ListEvents', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectName();

        $this->assertProtobufEquals($formattedProjectName, $actualValue);
        $actualValue = $actualRequestObject->getGroupId();

        $this->assertProtobufEquals($groupId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listEventsExceptionTest()
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
        $formattedProjectName = $client->projectName('[PROJECT]');
        $groupId = 'groupId506361563';

        try {
            $client->listEvents($formattedProjectName, $groupId);
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
    public function deleteEventsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new DeleteEventsResponse();
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedProjectName = $client->projectName('[PROJECT]');

        $response = $client->deleteEvents($formattedProjectName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.devtools.clouderrorreporting.v1beta1.ErrorStatsService/DeleteEvents', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectName();

        $this->assertProtobufEquals($formattedProjectName, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteEventsExceptionTest()
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
        $formattedProjectName = $client->projectName('[PROJECT]');

        try {
            $client->deleteEvents($formattedProjectName);
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
