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

use Google\Cloud\ErrorReporting\V1beta1\ReportErrorsServiceClient;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\ErrorReporting\V1beta1\ReportErrorEventResponse;
use Google\Cloud\ErrorReporting\V1beta1\ReportedErrorEvent;
use Google\Protobuf\Any;
use Google\Rpc\Code;
use stdClass;

/**
 * @group error-reporting
 * @group gapic
 */
class ReportErrorsServiceClientTest extends GeneratedTest
{
    /**
     * @return TransportInterface
     */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /**
     * @return ReportErrorsServiceClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->getMockBuilder(CredentialsWrapper::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        return new ReportErrorsServiceClient($options);
    }

    /**
     * @test
     */
    public function reportErrorEventTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new ReportErrorEventResponse();
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedProjectName = $client->projectName('[PROJECT]');
        $event = new ReportedErrorEvent();

        $response = $client->reportErrorEvent($formattedProjectName, $event);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.devtools.clouderrorreporting.v1beta1.ReportErrorsService/ReportErrorEvent', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectName();

        $this->assertProtobufEquals($formattedProjectName, $actualValue);
        $actualValue = $actualRequestObject->getEvent();

        $this->assertProtobufEquals($event, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function reportErrorEventExceptionTest()
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
        $event = new ReportedErrorEvent();

        try {
            $client->reportErrorEvent($formattedProjectName, $event);
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
