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

namespace Google\Cloud\Dialogflow\Tests\Unit\V2\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Dialogflow\V2\AnalyzeContentRequest;
use Google\Cloud\Dialogflow\V2\AnalyzeContentResponse;
use Google\Cloud\Dialogflow\V2\Client\ParticipantsClient;
use Google\Cloud\Dialogflow\V2\CreateParticipantRequest;
use Google\Cloud\Dialogflow\V2\GetParticipantRequest;
use Google\Cloud\Dialogflow\V2\ListParticipantsRequest;
use Google\Cloud\Dialogflow\V2\ListParticipantsResponse;
use Google\Cloud\Dialogflow\V2\Participant;
use Google\Cloud\Dialogflow\V2\StreamingAnalyzeContentRequest;
use Google\Cloud\Dialogflow\V2\StreamingAnalyzeContentResponse;
use Google\Cloud\Dialogflow\V2\SuggestArticlesRequest;
use Google\Cloud\Dialogflow\V2\SuggestArticlesResponse;
use Google\Cloud\Dialogflow\V2\SuggestFaqAnswersRequest;
use Google\Cloud\Dialogflow\V2\SuggestFaqAnswersResponse;
use Google\Cloud\Dialogflow\V2\SuggestSmartRepliesRequest;
use Google\Cloud\Dialogflow\V2\SuggestSmartRepliesResponse;
use Google\Cloud\Dialogflow\V2\UpdateParticipantRequest;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\Protobuf\FieldMask;
use Google\Rpc\Code;
use stdClass;

/**
 * @group dialogflow
 *
 * @group gapic
 */
class ParticipantsClientTest extends GeneratedTest
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

    /** @return ParticipantsClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new ParticipantsClient($options);
    }

    /** @test */
    public function analyzeContentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $replyText = 'replyText-549180062';
        $expectedResponse = new AnalyzeContentResponse();
        $expectedResponse->setReplyText($replyText);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParticipant = $gapicClient->participantName('[PROJECT]', '[CONVERSATION]', '[PARTICIPANT]');
        $request = (new AnalyzeContentRequest())
            ->setParticipant($formattedParticipant);
        $response = $gapicClient->analyzeContent($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.v2.Participants/AnalyzeContent', $actualFuncCall);
        $actualValue = $actualRequestObject->getParticipant();
        $this->assertProtobufEquals($formattedParticipant, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function analyzeContentExceptionTest()
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
        $formattedParticipant = $gapicClient->participantName('[PROJECT]', '[CONVERSATION]', '[PARTICIPANT]');
        $request = (new AnalyzeContentRequest())
            ->setParticipant($formattedParticipant);
        try {
            $gapicClient->analyzeContent($request);
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
    public function createParticipantTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $sipRecordingMediaLabel = 'sipRecordingMediaLabel-1522741274';
        $obfuscatedExternalUserId = 'obfuscatedExternalUserId-263618122';
        $expectedResponse = new Participant();
        $expectedResponse->setName($name);
        $expectedResponse->setSipRecordingMediaLabel($sipRecordingMediaLabel);
        $expectedResponse->setObfuscatedExternalUserId($obfuscatedExternalUserId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->conversationName('[PROJECT]', '[CONVERSATION]');
        $participant = new Participant();
        $request = (new CreateParticipantRequest())
            ->setParent($formattedParent)
            ->setParticipant($participant);
        $response = $gapicClient->createParticipant($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.v2.Participants/CreateParticipant', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getParticipant();
        $this->assertProtobufEquals($participant, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createParticipantExceptionTest()
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
        $formattedParent = $gapicClient->conversationName('[PROJECT]', '[CONVERSATION]');
        $participant = new Participant();
        $request = (new CreateParticipantRequest())
            ->setParent($formattedParent)
            ->setParticipant($participant);
        try {
            $gapicClient->createParticipant($request);
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
    public function getParticipantTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $sipRecordingMediaLabel = 'sipRecordingMediaLabel-1522741274';
        $obfuscatedExternalUserId = 'obfuscatedExternalUserId-263618122';
        $expectedResponse = new Participant();
        $expectedResponse->setName($name2);
        $expectedResponse->setSipRecordingMediaLabel($sipRecordingMediaLabel);
        $expectedResponse->setObfuscatedExternalUserId($obfuscatedExternalUserId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->participantName('[PROJECT]', '[CONVERSATION]', '[PARTICIPANT]');
        $request = (new GetParticipantRequest())
            ->setName($formattedName);
        $response = $gapicClient->getParticipant($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.v2.Participants/GetParticipant', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getParticipantExceptionTest()
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
        $formattedName = $gapicClient->participantName('[PROJECT]', '[CONVERSATION]', '[PARTICIPANT]');
        $request = (new GetParticipantRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getParticipant($request);
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
    public function listParticipantsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $participantsElement = new Participant();
        $participants = [
            $participantsElement,
        ];
        $expectedResponse = new ListParticipantsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setParticipants($participants);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->conversationName('[PROJECT]', '[CONVERSATION]');
        $request = (new ListParticipantsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listParticipants($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getParticipants()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.v2.Participants/ListParticipants', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listParticipantsExceptionTest()
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
        $formattedParent = $gapicClient->conversationName('[PROJECT]', '[CONVERSATION]');
        $request = (new ListParticipantsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listParticipants($request);
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
    public function streamingAnalyzeContentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $replyText = 'replyText-549180062';
        $expectedResponse = new StreamingAnalyzeContentResponse();
        $expectedResponse->setReplyText($replyText);
        $transport->addResponse($expectedResponse);
        $replyText2 = 'replyText2518940821';
        $expectedResponse2 = new StreamingAnalyzeContentResponse();
        $expectedResponse2->setReplyText($replyText2);
        $transport->addResponse($expectedResponse2);
        $replyText3 = 'replyText3518940822';
        $expectedResponse3 = new StreamingAnalyzeContentResponse();
        $expectedResponse3->setReplyText($replyText3);
        $transport->addResponse($expectedResponse3);
        // Mock request
        $formattedParticipant = $gapicClient->participantName('[PROJECT]', '[CONVERSATION]', '[PARTICIPANT]');
        $request = new StreamingAnalyzeContentRequest();
        $request->setParticipant($formattedParticipant);
        $formattedParticipant2 = $gapicClient->participantName('[PROJECT]', '[CONVERSATION]', '[PARTICIPANT]');
        $request2 = new StreamingAnalyzeContentRequest();
        $request2->setParticipant($formattedParticipant2);
        $formattedParticipant3 = $gapicClient->participantName('[PROJECT]', '[CONVERSATION]', '[PARTICIPANT]');
        $request3 = new StreamingAnalyzeContentRequest();
        $request3->setParticipant($formattedParticipant3);
        $bidi = $gapicClient->streamingAnalyzeContent();
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
        $this->assertSame('/google.cloud.dialogflow.v2.Participants/StreamingAnalyzeContent', $streamFuncCall);
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
    public function streamingAnalyzeContentExceptionTest()
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
        $bidi = $gapicClient->streamingAnalyzeContent();
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
    public function suggestArticlesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $latestMessage2 = 'latestMessage2-440913086';
        $contextSize2 = 397491196;
        $expectedResponse = new SuggestArticlesResponse();
        $expectedResponse->setLatestMessage($latestMessage2);
        $expectedResponse->setContextSize($contextSize2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->participantName('[PROJECT]', '[CONVERSATION]', '[PARTICIPANT]');
        $request = (new SuggestArticlesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->suggestArticles($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.v2.Participants/SuggestArticles', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function suggestArticlesExceptionTest()
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
        $formattedParent = $gapicClient->participantName('[PROJECT]', '[CONVERSATION]', '[PARTICIPANT]');
        $request = (new SuggestArticlesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->suggestArticles($request);
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
    public function suggestFaqAnswersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $latestMessage2 = 'latestMessage2-440913086';
        $contextSize2 = 397491196;
        $expectedResponse = new SuggestFaqAnswersResponse();
        $expectedResponse->setLatestMessage($latestMessage2);
        $expectedResponse->setContextSize($contextSize2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->participantName('[PROJECT]', '[CONVERSATION]', '[PARTICIPANT]');
        $request = (new SuggestFaqAnswersRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->suggestFaqAnswers($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.v2.Participants/SuggestFaqAnswers', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function suggestFaqAnswersExceptionTest()
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
        $formattedParent = $gapicClient->participantName('[PROJECT]', '[CONVERSATION]', '[PARTICIPANT]');
        $request = (new SuggestFaqAnswersRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->suggestFaqAnswers($request);
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
    public function suggestSmartRepliesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $latestMessage2 = 'latestMessage2-440913086';
        $contextSize2 = 397491196;
        $expectedResponse = new SuggestSmartRepliesResponse();
        $expectedResponse->setLatestMessage($latestMessage2);
        $expectedResponse->setContextSize($contextSize2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->participantName('[PROJECT]', '[CONVERSATION]', '[PARTICIPANT]');
        $request = (new SuggestSmartRepliesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->suggestSmartReplies($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.v2.Participants/SuggestSmartReplies', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function suggestSmartRepliesExceptionTest()
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
        $formattedParent = $gapicClient->participantName('[PROJECT]', '[CONVERSATION]', '[PARTICIPANT]');
        $request = (new SuggestSmartRepliesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->suggestSmartReplies($request);
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
    public function updateParticipantTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $sipRecordingMediaLabel = 'sipRecordingMediaLabel-1522741274';
        $obfuscatedExternalUserId = 'obfuscatedExternalUserId-263618122';
        $expectedResponse = new Participant();
        $expectedResponse->setName($name);
        $expectedResponse->setSipRecordingMediaLabel($sipRecordingMediaLabel);
        $expectedResponse->setObfuscatedExternalUserId($obfuscatedExternalUserId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $participant = new Participant();
        $updateMask = new FieldMask();
        $request = (new UpdateParticipantRequest())
            ->setParticipant($participant)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateParticipant($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.v2.Participants/UpdateParticipant', $actualFuncCall);
        $actualValue = $actualRequestObject->getParticipant();
        $this->assertProtobufEquals($participant, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateParticipantExceptionTest()
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
        $participant = new Participant();
        $updateMask = new FieldMask();
        $request = (new UpdateParticipantRequest())
            ->setParticipant($participant)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateParticipant($request);
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
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
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
        $locations = [
            $locationsElement,
        ];
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
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
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
    public function analyzeContentAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $replyText = 'replyText-549180062';
        $expectedResponse = new AnalyzeContentResponse();
        $expectedResponse->setReplyText($replyText);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParticipant = $gapicClient->participantName('[PROJECT]', '[CONVERSATION]', '[PARTICIPANT]');
        $request = (new AnalyzeContentRequest())
            ->setParticipant($formattedParticipant);
        $response = $gapicClient->analyzeContentAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.v2.Participants/AnalyzeContent', $actualFuncCall);
        $actualValue = $actualRequestObject->getParticipant();
        $this->assertProtobufEquals($formattedParticipant, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
