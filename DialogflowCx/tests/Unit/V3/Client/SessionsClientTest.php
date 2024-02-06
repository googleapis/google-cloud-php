<?php
/*
 * Copyright 2023 Google LLC
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

namespace Google\Cloud\Dialogflow\Cx\Tests\Unit\V3\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Dialogflow\Cx\V3\AnswerFeedback;
use Google\Cloud\Dialogflow\Cx\V3\Client\SessionsClient;
use Google\Cloud\Dialogflow\Cx\V3\DetectIntentRequest;
use Google\Cloud\Dialogflow\Cx\V3\DetectIntentResponse;
use Google\Cloud\Dialogflow\Cx\V3\FulfillIntentRequest;
use Google\Cloud\Dialogflow\Cx\V3\FulfillIntentResponse;
use Google\Cloud\Dialogflow\Cx\V3\MatchIntentRequest;
use Google\Cloud\Dialogflow\Cx\V3\MatchIntentResponse;
use Google\Cloud\Dialogflow\Cx\V3\QueryInput;
use Google\Cloud\Dialogflow\Cx\V3\StreamingDetectIntentRequest;
use Google\Cloud\Dialogflow\Cx\V3\StreamingDetectIntentResponse;
use Google\Cloud\Dialogflow\Cx\V3\SubmitAnswerFeedbackRequest;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\Rpc\Code;
use stdClass;

/**
 * @group cx
 *
 * @group gapic
 */
class SessionsClientTest extends GeneratedTest
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

    /** @return SessionsClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new SessionsClient($options);
    }

    /** @test */
    public function detectIntentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $responseId = 'responseId1847552473';
        $outputAudio = '24';
        $allowCancellation = false;
        $expectedResponse = new DetectIntentResponse();
        $expectedResponse->setResponseId($responseId);
        $expectedResponse->setOutputAudio($outputAudio);
        $expectedResponse->setAllowCancellation($allowCancellation);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedSession = $gapicClient->sessionName('[PROJECT]', '[LOCATION]', '[AGENT]', '[SESSION]');
        $queryInput = new QueryInput();
        $queryInputLanguageCode = 'queryInputLanguageCode478766695';
        $queryInput->setLanguageCode($queryInputLanguageCode);
        $request = (new DetectIntentRequest())->setSession($formattedSession)->setQueryInput($queryInput);
        $response = $gapicClient->detectIntent($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.cx.v3.Sessions/DetectIntent', $actualFuncCall);
        $actualValue = $actualRequestObject->getSession();
        $this->assertProtobufEquals($formattedSession, $actualValue);
        $actualValue = $actualRequestObject->getQueryInput();
        $this->assertProtobufEquals($queryInput, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function detectIntentExceptionTest()
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
        $formattedSession = $gapicClient->sessionName('[PROJECT]', '[LOCATION]', '[AGENT]', '[SESSION]');
        $queryInput = new QueryInput();
        $queryInputLanguageCode = 'queryInputLanguageCode478766695';
        $queryInput->setLanguageCode($queryInputLanguageCode);
        $request = (new DetectIntentRequest())->setSession($formattedSession)->setQueryInput($queryInput);
        try {
            $gapicClient->detectIntent($request);
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
    public function fulfillIntentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $responseId = 'responseId1847552473';
        $outputAudio = '24';
        $expectedResponse = new FulfillIntentResponse();
        $expectedResponse->setResponseId($responseId);
        $expectedResponse->setOutputAudio($outputAudio);
        $transport->addResponse($expectedResponse);
        $request = new FulfillIntentRequest();
        $response = $gapicClient->fulfillIntent($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.cx.v3.Sessions/FulfillIntent', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function fulfillIntentExceptionTest()
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
        $request = new FulfillIntentRequest();
        try {
            $gapicClient->fulfillIntent($request);
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
    public function matchIntentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $text = 'text3556653';
        $expectedResponse = new MatchIntentResponse();
        $expectedResponse->setText($text);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedSession = $gapicClient->sessionName('[PROJECT]', '[LOCATION]', '[AGENT]', '[SESSION]');
        $queryInput = new QueryInput();
        $queryInputLanguageCode = 'queryInputLanguageCode478766695';
        $queryInput->setLanguageCode($queryInputLanguageCode);
        $request = (new MatchIntentRequest())->setSession($formattedSession)->setQueryInput($queryInput);
        $response = $gapicClient->matchIntent($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.cx.v3.Sessions/MatchIntent', $actualFuncCall);
        $actualValue = $actualRequestObject->getSession();
        $this->assertProtobufEquals($formattedSession, $actualValue);
        $actualValue = $actualRequestObject->getQueryInput();
        $this->assertProtobufEquals($queryInput, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function matchIntentExceptionTest()
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
        $formattedSession = $gapicClient->sessionName('[PROJECT]', '[LOCATION]', '[AGENT]', '[SESSION]');
        $queryInput = new QueryInput();
        $queryInputLanguageCode = 'queryInputLanguageCode478766695';
        $queryInput->setLanguageCode($queryInputLanguageCode);
        $request = (new MatchIntentRequest())->setSession($formattedSession)->setQueryInput($queryInput);
        try {
            $gapicClient->matchIntent($request);
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
    public function streamingDetectIntentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new StreamingDetectIntentResponse();
        $transport->addResponse($expectedResponse);
        $expectedResponse2 = new StreamingDetectIntentResponse();
        $transport->addResponse($expectedResponse2);
        $expectedResponse3 = new StreamingDetectIntentResponse();
        $transport->addResponse($expectedResponse3);
        // Mock request
        $queryInput = new QueryInput();
        $queryInputLanguageCode = 'queryInputLanguageCode478766695';
        $queryInput->setLanguageCode($queryInputLanguageCode);
        $request = new StreamingDetectIntentRequest();
        $request->setQueryInput($queryInput);
        $queryInput2 = new QueryInput();
        $queryInputLanguageCode = 'queryInputLanguageCode478766695';
        $queryInput2->setLanguageCode($queryInputLanguageCode);
        $request2 = new StreamingDetectIntentRequest();
        $request2->setQueryInput($queryInput2);
        $queryInput3 = new QueryInput();
        $queryInputLanguageCode = 'queryInputLanguageCode478766695';
        $queryInput3->setLanguageCode($queryInputLanguageCode);
        $request3 = new StreamingDetectIntentRequest();
        $request3->setQueryInput($queryInput3);
        $bidi = $gapicClient->streamingDetectIntent();
        $this->assertInstanceOf(BidiStream::class, $bidi);
        $bidi->write($request);
        $responses = [];
        $responses[] = $bidi->read();
        $bidi->writeAll([$request2, $request3]);
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
        $this->assertSame('/google.cloud.dialogflow.cx.v3.Sessions/StreamingDetectIntent', $streamFuncCall);
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

    /** @test */
    public function streamingDetectIntentExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
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
        $transport->setStreamingStatus($status);
        $this->assertTrue($transport->isExhausted());
        $bidi = $gapicClient->streamingDetectIntent();
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

    /** @test */
    public function submitAnswerFeedbackTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $customRating = 'customRating1123127851';
        $expectedResponse = new AnswerFeedback();
        $expectedResponse->setCustomRating($customRating);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedSession = $gapicClient->sessionName('[PROJECT]', '[LOCATION]', '[AGENT]', '[SESSION]');
        $responseId = 'responseId1847552473';
        $answerFeedback = new AnswerFeedback();
        $request = (new SubmitAnswerFeedbackRequest())
            ->setSession($formattedSession)
            ->setResponseId($responseId)
            ->setAnswerFeedback($answerFeedback);
        $response = $gapicClient->submitAnswerFeedback($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.cx.v3.Sessions/SubmitAnswerFeedback', $actualFuncCall);
        $actualValue = $actualRequestObject->getSession();
        $this->assertProtobufEquals($formattedSession, $actualValue);
        $actualValue = $actualRequestObject->getResponseId();
        $this->assertProtobufEquals($responseId, $actualValue);
        $actualValue = $actualRequestObject->getAnswerFeedback();
        $this->assertProtobufEquals($answerFeedback, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function submitAnswerFeedbackExceptionTest()
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
        $formattedSession = $gapicClient->sessionName('[PROJECT]', '[LOCATION]', '[AGENT]', '[SESSION]');
        $responseId = 'responseId1847552473';
        $answerFeedback = new AnswerFeedback();
        $request = (new SubmitAnswerFeedbackRequest())
            ->setSession($formattedSession)
            ->setResponseId($responseId)
            ->setAnswerFeedback($answerFeedback);
        try {
            $gapicClient->submitAnswerFeedback($request);
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
    public function getLocationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $locationId = 'locationId552319461';
        $displayName = 'displayName1615086568';
        $expectedResponse = new Location();
        $expectedResponse->setName($name2);
        $expectedResponse->setLocationId($locationId);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        $request = new GetLocationRequest();
        $response = $gapicClient->getLocation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.location.Locations/GetLocation', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getLocationExceptionTest()
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
        $request = new GetLocationRequest();
        try {
            $gapicClient->getLocation($request);
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
    public function listLocationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $locationsElement = new Location();
        $locations = [$locationsElement];
        $expectedResponse = new ListLocationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setLocations($locations);
        $transport->addResponse($expectedResponse);
        $request = new ListLocationsRequest();
        $response = $gapicClient->listLocations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getLocations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.location.Locations/ListLocations', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listLocationsExceptionTest()
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
        $request = new ListLocationsRequest();
        try {
            $gapicClient->listLocations($request);
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
    public function detectIntentAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $responseId = 'responseId1847552473';
        $outputAudio = '24';
        $allowCancellation = false;
        $expectedResponse = new DetectIntentResponse();
        $expectedResponse->setResponseId($responseId);
        $expectedResponse->setOutputAudio($outputAudio);
        $expectedResponse->setAllowCancellation($allowCancellation);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedSession = $gapicClient->sessionName('[PROJECT]', '[LOCATION]', '[AGENT]', '[SESSION]');
        $queryInput = new QueryInput();
        $queryInputLanguageCode = 'queryInputLanguageCode478766695';
        $queryInput->setLanguageCode($queryInputLanguageCode);
        $request = (new DetectIntentRequest())->setSession($formattedSession)->setQueryInput($queryInput);
        $response = $gapicClient->detectIntentAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.cx.v3.Sessions/DetectIntent', $actualFuncCall);
        $actualValue = $actualRequestObject->getSession();
        $this->assertProtobufEquals($formattedSession, $actualValue);
        $actualValue = $actualRequestObject->getQueryInput();
        $this->assertProtobufEquals($queryInput, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
