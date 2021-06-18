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

namespace Google\Cloud\ApigeeConnect\Tests\Unit\V1;

use Google\ApiCore\ApiException;

use Google\ApiCore\BidiStream;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;

use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\ApigeeConnect\V1\EgressRequest;
use Google\Cloud\ApigeeConnect\V1\EgressResponse;
use Google\Cloud\ApigeeConnect\V1\TetherClient;
use Google\Rpc\Code;
use stdClass;

/**
 * @group apigeeconnect
 *
 * @group gapic
 */
class TetherClientTest extends GeneratedTest
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
     * @return TetherClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new TetherClient($options);
    }

    /**
     * @test
     */
    public function egressTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $id = 'id3355';
        $project = 'project-309310695';
        $traceId = 'traceId1270300245';
        $expectedResponse = new EgressRequest();
        $expectedResponse->setId($id);
        $expectedResponse->setProject($project);
        $expectedResponse->setTraceId($traceId);
        $transport->addResponse($expectedResponse);
        $id2 = 'id23227150';
        $project2 = 'project2-894831476';
        $traceId2 = 'traceId2987826376';
        $expectedResponse2 = new EgressRequest();
        $expectedResponse2->setId($id2);
        $expectedResponse2->setProject($project2);
        $expectedResponse2->setTraceId($traceId2);
        $transport->addResponse($expectedResponse2);
        $id3 = 'id33227151';
        $project3 = 'project3-894831475';
        $traceId3 = 'traceId3987826377';
        $expectedResponse3 = new EgressRequest();
        $expectedResponse3->setId($id3);
        $expectedResponse3->setProject($project3);
        $expectedResponse3->setTraceId($traceId3);
        $transport->addResponse($expectedResponse3);
        // Mock request
        $request = new EgressResponse();
        $request2 = new EgressResponse();
        $request3 = new EgressResponse();
        $bidi = $client->egress();
        $this->assertInstanceOf(BidiStream::class, $bidi);
        $bidi->write($request);
        $responses = [];
        $responses[] = $bidi->read();
        $bidi->writeAll([
            $request2,
            $request3,
        ]);
        foreach ($bidi->closeWriteAndReadAll() as $response) {
            $responses[] = $response;
        }

        $expectedResponses = [];
        $expectedResponses[] = $expectedResponse;
        $expectedResponses[] = $expectedResponse2;
        $expectedResponses[] = $expectedResponse3;
        $this->assertEquals($expectedResponses, $responses);
        $createStreamRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($createStreamRequests));
        $streamFuncCall = $createStreamRequests[0]->getFuncCall();
        $streamRequestObject = $createStreamRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.apigeeconnect.v1.Tether/Egress', $streamFuncCall);
        $this->assertNull($streamRequestObject);
        $callObjects = $transport->popCallObjects();
        $this->assertSame(1, count($callObjects));
        $bidiCall = $callObjects[0];
        $writeRequests = $bidiCall->popReceivedCalls();
        $expectedRequests = [];
        $expectedRequests[] = $request;
        $expectedRequests[] = $request2;
        $expectedRequests[] = $request3;
        $this->assertEquals($expectedRequests, $writeRequests);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function egressExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->setStreamingStatus($status);
        $this->assertTrue($transport->isExhausted());
        $bidi = $client->egress();
        $results = $bidi->closeWriteAndReadAll();
        try {
            iterator_to_array($results);
            // If the close stream method call did not throw, fail the test
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
