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

namespace Google\Cloud\Dialogflow\Tests\Unit\V2;

use Google\ApiCore\ApiException;

use Google\ApiCore\BidiStream;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;

use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Dialogflow\V2\DetectIntentResponse;
use Google\Cloud\Dialogflow\V2\QueryInput;
use Google\Cloud\Dialogflow\V2\SessionsClient;
use Google\Cloud\Dialogflow\V2\StreamingDetectIntentRequest;
use Google\Cloud\Dialogflow\V2\StreamingDetectIntentResponse;
use Google\Rpc\Code;
use stdClass;

/**
 * @group dialogflow
 *
 * @group gapic
 */
class SessionsClientTest extends GeneratedTest
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
     * @return SessionsClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new SessionsClient($options);
    }

    /**
     * @test
     */
    public function detectIntentTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $responseId = 'responseId1847552473';
        $outputAudio = '24';
        $expectedResponse = new DetectIntentResponse();
        $expectedResponse->setResponseId($responseId);
        $expectedResponse->setOutputAudio($outputAudio);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedSession = $client->sessionName('[PROJECT]', '[SESSION]');
        $queryInput = new QueryInput();
        $response = $client->detectIntent($formattedSession, $queryInput);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.v2.Sessions/DetectIntent', $actualFuncCall);
        $actualValue = $actualRequestObject->getSession();
        $this->assertProtobufEquals($formattedSession, $actualValue);
        $actualValue = $actualRequestObject->getQueryInput();
        $this->assertProtobufEquals($queryInput, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function detectIntentExceptionTest()
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
        $formattedSession = $client->sessionName('[PROJECT]', '[SESSION]');
        $queryInput = new QueryInput();
        try {
            $client->detectIntent($formattedSession, $queryInput);
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
    public function streamingDetectIntentTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $responseId = 'responseId1847552473';
        $outputAudio = '24';
        $expectedResponse = new StreamingDetectIntentResponse();
        $expectedResponse->setResponseId($responseId);
        $expectedResponse->setOutputAudio($outputAudio);
        $transport->addResponse($expectedResponse);
        $responseId2 = 'responseId21676436300';
        $outputAudio2 = '-53';
        $expectedResponse2 = new StreamingDetectIntentResponse();
        $expectedResponse2->setResponseId($responseId2);
        $expectedResponse2->setOutputAudio($outputAudio2);
        $transport->addResponse($expectedResponse2);
        $responseId3 = 'responseId31676436301';
        $outputAudio3 = '-52';
        $expectedResponse3 = new StreamingDetectIntentResponse();
        $expectedResponse3->setResponseId($responseId3);
        $expectedResponse3->setOutputAudio($outputAudio3);
        $transport->addResponse($expectedResponse3);
        // Mock request
        $formattedSession = $client->sessionName('[PROJECT]', '[SESSION]');
        $queryInput = new QueryInput();
        $request = new StreamingDetectIntentRequest();
        $request->setSession($formattedSession);
        $request->setQueryInput($queryInput);
        $formattedSession2 = $client->sessionName('[PROJECT]', '[SESSION]');
        $queryInput2 = new QueryInput();
        $request2 = new StreamingDetectIntentRequest();
        $request2->setSession($formattedSession2);
        $request2->setQueryInput($queryInput2);
        $formattedSession3 = $client->sessionName('[PROJECT]', '[SESSION]');
        $queryInput3 = new QueryInput();
        $request3 = new StreamingDetectIntentRequest();
        $request3->setSession($formattedSession3);
        $request3->setQueryInput($queryInput3);
        $bidi = $client->streamingDetectIntent();
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
        $this->assertSame('/google.cloud.dialogflow.v2.Sessions/StreamingDetectIntent', $streamFuncCall);
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
    public function streamingDetectIntentExceptionTest()
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
        $bidi = $client->streamingDetectIntent();
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
