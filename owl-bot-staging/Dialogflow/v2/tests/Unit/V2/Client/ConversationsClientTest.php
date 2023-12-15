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
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Dialogflow\V2\Client\ConversationsClient;
use Google\Cloud\Dialogflow\V2\CompleteConversationRequest;
use Google\Cloud\Dialogflow\V2\Conversation;
use Google\Cloud\Dialogflow\V2\ConversationProfile;
use Google\Cloud\Dialogflow\V2\CreateConversationRequest;
use Google\Cloud\Dialogflow\V2\GenerateStatelessSummaryRequest;
use Google\Cloud\Dialogflow\V2\GenerateStatelessSummaryRequest\MinimalConversation;
use Google\Cloud\Dialogflow\V2\GenerateStatelessSummaryResponse;
use Google\Cloud\Dialogflow\V2\GetConversationRequest;
use Google\Cloud\Dialogflow\V2\ListConversationsRequest;
use Google\Cloud\Dialogflow\V2\ListConversationsResponse;
use Google\Cloud\Dialogflow\V2\ListMessagesRequest;
use Google\Cloud\Dialogflow\V2\ListMessagesResponse;
use Google\Cloud\Dialogflow\V2\Message;
use Google\Cloud\Dialogflow\V2\SearchKnowledgeRequest;
use Google\Cloud\Dialogflow\V2\SearchKnowledgeResponse;
use Google\Cloud\Dialogflow\V2\SuggestConversationSummaryRequest;
use Google\Cloud\Dialogflow\V2\SuggestConversationSummaryResponse;
use Google\Cloud\Dialogflow\V2\TextInput;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\Rpc\Code;
use stdClass;

/**
 * @group dialogflow
 *
 * @group gapic
 */
class ConversationsClientTest extends GeneratedTest
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

    /** @return ConversationsClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new ConversationsClient($options);
    }

    /** @test */
    public function completeConversationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $conversationProfile = 'conversationProfile-408626707';
        $expectedResponse = new Conversation();
        $expectedResponse->setName($name2);
        $expectedResponse->setConversationProfile($conversationProfile);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->conversationName('[PROJECT]', '[CONVERSATION]');
        $request = (new CompleteConversationRequest())
            ->setName($formattedName);
        $response = $gapicClient->completeConversation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.v2.Conversations/CompleteConversation', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function completeConversationExceptionTest()
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
        $formattedName = $gapicClient->conversationName('[PROJECT]', '[CONVERSATION]');
        $request = (new CompleteConversationRequest())
            ->setName($formattedName);
        try {
            $gapicClient->completeConversation($request);
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
    public function createConversationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $conversationProfile = 'conversationProfile-408626707';
        $expectedResponse = new Conversation();
        $expectedResponse->setName($name);
        $expectedResponse->setConversationProfile($conversationProfile);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $conversation = new Conversation();
        $conversationConversationProfile = $gapicClient->conversationProfileName('[PROJECT]', '[CONVERSATION_PROFILE]');
        $conversation->setConversationProfile($conversationConversationProfile);
        $request = (new CreateConversationRequest())
            ->setParent($formattedParent)
            ->setConversation($conversation);
        $response = $gapicClient->createConversation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.v2.Conversations/CreateConversation', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getConversation();
        $this->assertProtobufEquals($conversation, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createConversationExceptionTest()
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
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $conversation = new Conversation();
        $conversationConversationProfile = $gapicClient->conversationProfileName('[PROJECT]', '[CONVERSATION_PROFILE]');
        $conversation->setConversationProfile($conversationConversationProfile);
        $request = (new CreateConversationRequest())
            ->setParent($formattedParent)
            ->setConversation($conversation);
        try {
            $gapicClient->createConversation($request);
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
    public function generateStatelessSummaryTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $latestMessage2 = 'latestMessage2-440913086';
        $contextSize = 1116903569;
        $expectedResponse = new GenerateStatelessSummaryResponse();
        $expectedResponse->setLatestMessage($latestMessage2);
        $expectedResponse->setContextSize($contextSize);
        $transport->addResponse($expectedResponse);
        // Mock request
        $statelessConversation = new MinimalConversation();
        $statelessConversationMessages = [];
        $statelessConversation->setMessages($statelessConversationMessages);
        $statelessConversationParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $statelessConversation->setParent($statelessConversationParent);
        $conversationProfile = new ConversationProfile();
        $conversationProfileDisplayName = 'conversationProfileDisplayName-203415833';
        $conversationProfile->setDisplayName($conversationProfileDisplayName);
        $request = (new GenerateStatelessSummaryRequest())
            ->setStatelessConversation($statelessConversation)
            ->setConversationProfile($conversationProfile);
        $response = $gapicClient->generateStatelessSummary($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.v2.Conversations/GenerateStatelessSummary', $actualFuncCall);
        $actualValue = $actualRequestObject->getStatelessConversation();
        $this->assertProtobufEquals($statelessConversation, $actualValue);
        $actualValue = $actualRequestObject->getConversationProfile();
        $this->assertProtobufEquals($conversationProfile, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function generateStatelessSummaryExceptionTest()
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
        $statelessConversation = new MinimalConversation();
        $statelessConversationMessages = [];
        $statelessConversation->setMessages($statelessConversationMessages);
        $statelessConversationParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $statelessConversation->setParent($statelessConversationParent);
        $conversationProfile = new ConversationProfile();
        $conversationProfileDisplayName = 'conversationProfileDisplayName-203415833';
        $conversationProfile->setDisplayName($conversationProfileDisplayName);
        $request = (new GenerateStatelessSummaryRequest())
            ->setStatelessConversation($statelessConversation)
            ->setConversationProfile($conversationProfile);
        try {
            $gapicClient->generateStatelessSummary($request);
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
    public function getConversationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $conversationProfile = 'conversationProfile-408626707';
        $expectedResponse = new Conversation();
        $expectedResponse->setName($name2);
        $expectedResponse->setConversationProfile($conversationProfile);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->conversationName('[PROJECT]', '[CONVERSATION]');
        $request = (new GetConversationRequest())
            ->setName($formattedName);
        $response = $gapicClient->getConversation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.v2.Conversations/GetConversation', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getConversationExceptionTest()
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
        $formattedName = $gapicClient->conversationName('[PROJECT]', '[CONVERSATION]');
        $request = (new GetConversationRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getConversation($request);
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
    public function listConversationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $conversationsElement = new Conversation();
        $conversations = [
            $conversationsElement,
        ];
        $expectedResponse = new ListConversationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setConversations($conversations);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListConversationsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listConversations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getConversations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.v2.Conversations/ListConversations', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listConversationsExceptionTest()
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
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListConversationsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listConversations($request);
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
    public function listMessagesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $messagesElement = new Message();
        $messages = [
            $messagesElement,
        ];
        $expectedResponse = new ListMessagesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setMessages($messages);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->conversationName('[PROJECT]', '[CONVERSATION]');
        $request = (new ListMessagesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listMessages($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getMessages()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.v2.Conversations/ListMessages', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listMessagesExceptionTest()
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
        $request = (new ListMessagesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listMessages($request);
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
    public function searchKnowledgeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $rewrittenQuery = 'rewrittenQuery-1113584563';
        $expectedResponse = new SearchKnowledgeResponse();
        $expectedResponse->setRewrittenQuery($rewrittenQuery);
        $transport->addResponse($expectedResponse);
        // Mock request
        $query = new TextInput();
        $queryText = 'queryText-1806881259';
        $query->setText($queryText);
        $queryLanguageCode = 'queryLanguageCode66898509';
        $query->setLanguageCode($queryLanguageCode);
        $formattedConversationProfile = $gapicClient->conversationProfileName('[PROJECT]', '[CONVERSATION_PROFILE]');
        $request = (new SearchKnowledgeRequest())
            ->setQuery($query)
            ->setConversationProfile($formattedConversationProfile);
        $response = $gapicClient->searchKnowledge($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.v2.Conversations/SearchKnowledge', $actualFuncCall);
        $actualValue = $actualRequestObject->getQuery();
        $this->assertProtobufEquals($query, $actualValue);
        $actualValue = $actualRequestObject->getConversationProfile();
        $this->assertProtobufEquals($formattedConversationProfile, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchKnowledgeExceptionTest()
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
        $query = new TextInput();
        $queryText = 'queryText-1806881259';
        $query->setText($queryText);
        $queryLanguageCode = 'queryLanguageCode66898509';
        $query->setLanguageCode($queryLanguageCode);
        $formattedConversationProfile = $gapicClient->conversationProfileName('[PROJECT]', '[CONVERSATION_PROFILE]');
        $request = (new SearchKnowledgeRequest())
            ->setQuery($query)
            ->setConversationProfile($formattedConversationProfile);
        try {
            $gapicClient->searchKnowledge($request);
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
    public function suggestConversationSummaryTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $latestMessage2 = 'latestMessage2-440913086';
        $contextSize2 = 397491196;
        $expectedResponse = new SuggestConversationSummaryResponse();
        $expectedResponse->setLatestMessage($latestMessage2);
        $expectedResponse->setContextSize($contextSize2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedConversation = $gapicClient->conversationName('[PROJECT]', '[CONVERSATION]');
        $request = (new SuggestConversationSummaryRequest())
            ->setConversation($formattedConversation);
        $response = $gapicClient->suggestConversationSummary($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.v2.Conversations/SuggestConversationSummary', $actualFuncCall);
        $actualValue = $actualRequestObject->getConversation();
        $this->assertProtobufEquals($formattedConversation, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function suggestConversationSummaryExceptionTest()
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
        $formattedConversation = $gapicClient->conversationName('[PROJECT]', '[CONVERSATION]');
        $request = (new SuggestConversationSummaryRequest())
            ->setConversation($formattedConversation);
        try {
            $gapicClient->suggestConversationSummary($request);
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
    public function completeConversationAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $conversationProfile = 'conversationProfile-408626707';
        $expectedResponse = new Conversation();
        $expectedResponse->setName($name2);
        $expectedResponse->setConversationProfile($conversationProfile);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->conversationName('[PROJECT]', '[CONVERSATION]');
        $request = (new CompleteConversationRequest())
            ->setName($formattedName);
        $response = $gapicClient->completeConversationAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dialogflow.v2.Conversations/CompleteConversation', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
