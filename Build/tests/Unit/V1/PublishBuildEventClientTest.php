<?php
/*
 * Copyright 2022 Google LLC
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

namespace Google\Cloud\Build\Tests\Unit\V1;

use Google\ApiCore\ApiException;

use Google\ApiCore\BidiStream;

use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;

use Google\Cloud\Build\V1\OrderedBuildEvent;

use Google\Cloud\Build\V1\PublishBuildEventClient;
use Google\Cloud\Build\V1\PublishBuildToolEventStreamRequest;
use Google\Cloud\Build\V1\PublishBuildToolEventStreamResponse;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group build
 *
 * @group gapic
 */
class PublishBuildEventClientTest extends GeneratedTest
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
     * @return PublishBuildEventClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new PublishBuildEventClient($options);
    }

    /**
     * @test
     */
    public function publishBuildToolEventStreamTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $sequenceNumber = 1309190777;
        $expectedResponse = new PublishBuildToolEventStreamResponse();
        $expectedResponse->setSequenceNumber($sequenceNumber);
        $transport->addResponse($expectedResponse);
        $sequenceNumber2 = 293084026;
        $expectedResponse2 = new PublishBuildToolEventStreamResponse();
        $expectedResponse2->setSequenceNumber($sequenceNumber2);
        $transport->addResponse($expectedResponse2);
        $sequenceNumber3 = 293084027;
        $expectedResponse3 = new PublishBuildToolEventStreamResponse();
        $expectedResponse3->setSequenceNumber($sequenceNumber3);
        $transport->addResponse($expectedResponse3);
        // Mock request
        $orderedBuildEvent = new OrderedBuildEvent();
        $projectId = 'projectId-1969970175';
        $request = new PublishBuildToolEventStreamRequest();
        $request->setOrderedBuildEvent($orderedBuildEvent);
        $request->setProjectId($projectId);
        $orderedBuildEvent2 = new OrderedBuildEvent();
        $projectId2 = 'projectId2939242356';
        $request2 = new PublishBuildToolEventStreamRequest();
        $request2->setOrderedBuildEvent($orderedBuildEvent2);
        $request2->setProjectId($projectId2);
        $orderedBuildEvent3 = new OrderedBuildEvent();
        $projectId3 = 'projectId3939242357';
        $request3 = new PublishBuildToolEventStreamRequest();
        $request3->setOrderedBuildEvent($orderedBuildEvent3);
        $request3->setProjectId($projectId3);
        $bidi = $gapicClient->publishBuildToolEventStream();
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
        $this->assertSame('/google.devtools.build.v1.PublishBuildEvent/PublishBuildToolEventStream', $streamFuncCall);
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
    public function publishBuildToolEventStreamExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
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
        $bidi = $gapicClient->publishBuildToolEventStream();
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

    /**
     * @test
     */
    public function publishLifecycleEventTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $buildEvent = new OrderedBuildEvent();
        $projectId = 'projectId-1969970175';
        $gapicClient->publishLifecycleEvent($buildEvent, $projectId);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.devtools.build.v1.PublishBuildEvent/PublishLifecycleEvent', $actualFuncCall);
        $actualValue = $actualRequestObject->getBuildEvent();
        $this->assertProtobufEquals($buildEvent, $actualValue);
        $actualValue = $actualRequestObject->getProjectId();
        $this->assertProtobufEquals($projectId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function publishLifecycleEventExceptionTest()
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
        $buildEvent = new OrderedBuildEvent();
        $projectId = 'projectId-1969970175';
        try {
            $gapicClient->publishLifecycleEvent($buildEvent, $projectId);
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
}
