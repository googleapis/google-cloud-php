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

namespace Google\Cloud\Debugger\Tests\Unit\V2;

use Google\ApiCore\ApiException;

use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;

use Google\Cloud\Debugger\V2\Breakpoint;
use Google\Cloud\Debugger\V2\Debugger2Client;
use Google\Cloud\Debugger\V2\GetBreakpointResponse;
use Google\Cloud\Debugger\V2\ListBreakpointsResponse;
use Google\Cloud\Debugger\V2\ListDebuggeesResponse;
use Google\Cloud\Debugger\V2\SetBreakpointResponse;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group debugger
 *
 * @group gapic
 */
class Debugger2ClientTest extends GeneratedTest
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
     * @return Debugger2Client
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new Debugger2Client($options);
    }

    /**
     * @test
     */
    public function deleteBreakpointTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $debuggeeId = 'debuggeeId-997255898';
        $breakpointId = 'breakpointId498424873';
        $clientVersion = 'clientVersion-1506231196';
        $client->deleteBreakpoint($debuggeeId, $breakpointId, $clientVersion);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.devtools.clouddebugger.v2.Debugger2/DeleteBreakpoint', $actualFuncCall);
        $actualValue = $actualRequestObject->getDebuggeeId();
        $this->assertProtobufEquals($debuggeeId, $actualValue);
        $actualValue = $actualRequestObject->getBreakpointId();
        $this->assertProtobufEquals($breakpointId, $actualValue);
        $actualValue = $actualRequestObject->getClientVersion();
        $this->assertProtobufEquals($clientVersion, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteBreakpointExceptionTest()
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
        $debuggeeId = 'debuggeeId-997255898';
        $breakpointId = 'breakpointId498424873';
        $clientVersion = 'clientVersion-1506231196';
        try {
            $client->deleteBreakpoint($debuggeeId, $breakpointId, $clientVersion);
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
    public function getBreakpointTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GetBreakpointResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $debuggeeId = 'debuggeeId-997255898';
        $breakpointId = 'breakpointId498424873';
        $clientVersion = 'clientVersion-1506231196';
        $response = $client->getBreakpoint($debuggeeId, $breakpointId, $clientVersion);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.devtools.clouddebugger.v2.Debugger2/GetBreakpoint', $actualFuncCall);
        $actualValue = $actualRequestObject->getDebuggeeId();
        $this->assertProtobufEquals($debuggeeId, $actualValue);
        $actualValue = $actualRequestObject->getBreakpointId();
        $this->assertProtobufEquals($breakpointId, $actualValue);
        $actualValue = $actualRequestObject->getClientVersion();
        $this->assertProtobufEquals($clientVersion, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getBreakpointExceptionTest()
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
        $debuggeeId = 'debuggeeId-997255898';
        $breakpointId = 'breakpointId498424873';
        $clientVersion = 'clientVersion-1506231196';
        try {
            $client->getBreakpoint($debuggeeId, $breakpointId, $clientVersion);
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
    public function listBreakpointsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextWaitToken = 'nextWaitToken1006864251';
        $expectedResponse = new ListBreakpointsResponse();
        $expectedResponse->setNextWaitToken($nextWaitToken);
        $transport->addResponse($expectedResponse);
        // Mock request
        $debuggeeId = 'debuggeeId-997255898';
        $clientVersion = 'clientVersion-1506231196';
        $response = $client->listBreakpoints($debuggeeId, $clientVersion);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.devtools.clouddebugger.v2.Debugger2/ListBreakpoints', $actualFuncCall);
        $actualValue = $actualRequestObject->getDebuggeeId();
        $this->assertProtobufEquals($debuggeeId, $actualValue);
        $actualValue = $actualRequestObject->getClientVersion();
        $this->assertProtobufEquals($clientVersion, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listBreakpointsExceptionTest()
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
        $debuggeeId = 'debuggeeId-997255898';
        $clientVersion = 'clientVersion-1506231196';
        try {
            $client->listBreakpoints($debuggeeId, $clientVersion);
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
    public function listDebuggeesTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ListDebuggeesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $clientVersion = 'clientVersion-1506231196';
        $response = $client->listDebuggees($project, $clientVersion);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.devtools.clouddebugger.v2.Debugger2/ListDebuggees', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $actualValue = $actualRequestObject->getClientVersion();
        $this->assertProtobufEquals($clientVersion, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listDebuggeesExceptionTest()
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
        $clientVersion = 'clientVersion-1506231196';
        try {
            $client->listDebuggees($project, $clientVersion);
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
    public function setBreakpointTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new SetBreakpointResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $debuggeeId = 'debuggeeId-997255898';
        $breakpoint = new Breakpoint();
        $clientVersion = 'clientVersion-1506231196';
        $response = $client->setBreakpoint($debuggeeId, $breakpoint, $clientVersion);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.devtools.clouddebugger.v2.Debugger2/SetBreakpoint', $actualFuncCall);
        $actualValue = $actualRequestObject->getDebuggeeId();
        $this->assertProtobufEquals($debuggeeId, $actualValue);
        $actualValue = $actualRequestObject->getBreakpoint();
        $this->assertProtobufEquals($breakpoint, $actualValue);
        $actualValue = $actualRequestObject->getClientVersion();
        $this->assertProtobufEquals($clientVersion, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function setBreakpointExceptionTest()
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
        $debuggeeId = 'debuggeeId-997255898';
        $breakpoint = new Breakpoint();
        $clientVersion = 'clientVersion-1506231196';
        try {
            $client->setBreakpoint($debuggeeId, $breakpoint, $clientVersion);
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
