<?php
/*
 * Copyright 2017, Google LLC All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google LLC nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

namespace Google\ApiCore\Tests\Unit\LongRunning;

use Google\ApiCore\ApiException;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\LongRunning\ListOperationsResponse;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group long_running
 * @group grpc
 */
class OperationsClientTest extends GeneratedTest
{
    public function setUp($options = [])
    {
        $this->client = new MockOperationsClient();
    }

    /**
     * @test
     */
    public function getOperationTest()
    {
        $this->assertTrue($this->client->isExhausted());

        // Mock response
        $name2 = 'name2-1052831874';
        $done = true;
        $expectedResponse = new Operation();
        $expectedResponse->setName($name2);
        $expectedResponse->setDone($done);
        $this->client->addResponse($expectedResponse);

        // Mock request
        $name = 'name3373707';

        $response = $this->client->getOperation($name);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $this->client->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualFuncCall);

        $val = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $val);

        $this->assertTrue($this->client->isExhausted());
    }

    /**
     * @test
     */
    public function getOperationExceptionTest()
    {
        $this->assertTrue($this->client->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $this->client->addResponse(null, $status);

        // Mock request
        $name = 'name3373707';

        try {
            $this->client->getOperation($name);
            // If the $this->client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }

        // Call popReceivedCalls to ensure the stub is exhausted
        $this->client->popReceivedCalls();
        $this->assertTrue($this->client->isExhausted());
    }

    /**
     * @test
     */
    public function listOperationsTest()
    {
        $this->assertTrue($this->client->isExhausted());

        // Mock response
        $nextPageToken = '';
        $operationsElement = new Operation();
        $operations = [$operationsElement];
        $expectedResponse = new ListOperationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setOperations($operations);
        $this->client->addResponse($expectedResponse);

        // Mock request
        $name = 'name3373707';
        $filter = 'filter-1274492040';

        $response = $this->client->listOperations($name, $filter);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getOperations()[0], $resources[0]);

        $actualRequests = $this->client->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/ListOperations', $actualFuncCall);

        $actualName = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualName);
        $actualFilter = $actualRequestObject->getFilter();
        $this->assertProtobufEquals($filter, $actualFilter);
        $this->assertTrue($this->client->isExhausted());
    }

    /**
     * @test
     */
    public function listOperationsExceptionTest()
    {
        $this->assertTrue($this->client->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $this->client->addResponse(null, $status);

        // Mock request
        $name = 'name3373707';
        $filter = 'filter-1274492040';

        try {
            $this->client->listOperations($name, $filter);
            // If the $this->client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }

        // Call popReceivedCalls to ensure the stub is exhausted
        $this->client->popReceivedCalls();
        $this->assertTrue($this->client->isExhausted());
    }

    /**
     * @test
     */
    public function cancelOperationTest()
    {
        $this->assertTrue($this->client->isExhausted());

        // Mock response
        $expectedResponse = new GPBEmpty();
        $this->client->addResponse($expectedResponse);

        // Mock request
        $name = 'name3373707';

        $this->client->cancelOperation($name);
        $actualRequests = $this->client->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/CancelOperation', $actualFuncCall);

        $actualName = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualName);

        $this->assertTrue($this->client->isExhausted());
    }

    /**
     * @test
     */
    public function cancelOperationExceptionTest()
    {
        $this->assertTrue($this->client->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $this->client->addResponse(null, $status);

        // Mock request
        $name = 'name3373707';

        try {
            $this->client->cancelOperation($name);
            // If the $this->client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }

        // Call popReceivedCalls to ensure the stub is exhausted
        $this->client->popReceivedCalls();
        $this->assertTrue($this->client->isExhausted());
    }

    /**
     * @test
     */
    public function deleteOperationTest()
    {
        $this->assertTrue($this->client->isExhausted());

        // Mock response
        $expectedResponse = new GPBEmpty();
        $this->client->addResponse($expectedResponse);

        // Mock request
        $name = 'name3373707';

        $this->client->deleteOperation($name);
        $actualRequests = $this->client->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/DeleteOperation', $actualFuncCall);

        $actualName = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualName);

        $this->assertTrue($this->client->isExhausted());
    }

    /**
     * @test
     */
    public function deleteOperationExceptionTest()
    {
        $this->assertTrue($this->client->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $this->client->addResponse(null, $status);

        // Mock request
        $name = 'name3373707';

        try {
            $this->client->deleteOperation($name);
            // If the $this->client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }

        // Call popReceivedCalls to ensure the stub is exhausted
        $this->client->popReceivedCalls();
        $this->assertTrue($this->client->isExhausted());
    }
}

class MockOperationsClient extends OperationsClient
{
    protected $transport;

    public function __construct($args = [])
    {
        $args['transport'] = new MockTransport;
        $this->transport = $args['transport'];
        parent::__construct($args);
    }

    public function isExhausted()
    {
        return $this->transport->isExhausted();
    }

    public function addResponse($response, $status = null)
    {
        return $this->transport->addResponse($response, $status);
    }

    public function popReceivedCalls()
    {
        return $this->transport->popReceivedCalls();
    }
}

