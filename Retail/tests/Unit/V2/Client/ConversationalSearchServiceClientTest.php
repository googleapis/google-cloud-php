<?php
/*
 * Copyright 2025 Google LLC
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

namespace Google\Cloud\Retail\Tests\Unit\V2\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\ServerStream;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Retail\V2\Client\ConversationalSearchServiceClient;
use Google\Cloud\Retail\V2\ConversationalSearchRequest;
use Google\Cloud\Retail\V2\ConversationalSearchResponse;
use Google\Rpc\Code;
use stdClass;

/**
 * @group retail
 *
 * @group gapic
 */
class ConversationalSearchServiceClientTest extends GeneratedTest
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

    /** @return ConversationalSearchServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new ConversationalSearchServiceClient($options);
    }

    /** @test */
    public function conversationalSearchTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $conversationalTextResponse = 'conversationalTextResponse1342353538';
        $conversationId2 = 'conversationId2757232714';
        $expectedResponse = new ConversationalSearchResponse();
        $expectedResponse->setConversationalTextResponse($conversationalTextResponse);
        $expectedResponse->setConversationId($conversationId2);
        $transport->addResponse($expectedResponse);
        $conversationalTextResponse2 = 'conversationalTextResponse21511564213';
        $conversationId3 = 'conversationId3757232715';
        $expectedResponse2 = new ConversationalSearchResponse();
        $expectedResponse2->setConversationalTextResponse($conversationalTextResponse2);
        $expectedResponse2->setConversationId($conversationId3);
        $transport->addResponse($expectedResponse2);
        $conversationalTextResponse3 = 'conversationalTextResponse31511564214';
        $conversationId4 = 'conversationId4757232716';
        $expectedResponse3 = new ConversationalSearchResponse();
        $expectedResponse3->setConversationalTextResponse($conversationalTextResponse3);
        $expectedResponse3->setConversationId($conversationId4);
        $transport->addResponse($expectedResponse3);
        // Mock request
        $placement = 'placement1792938725';
        $formattedBranch = $gapicClient->branchName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[BRANCH]');
        $visitorId = 'visitorId-1832599924';
        $request = (new ConversationalSearchRequest())
            ->setPlacement($placement)
            ->setBranch($formattedBranch)
            ->setVisitorId($visitorId);
        $serverStream = $gapicClient->conversationalSearch($request);
        $this->assertInstanceOf(ServerStream::class, $serverStream);
        $responses = iterator_to_array($serverStream->readAll());
        $expectedResponses = [];
        $expectedResponses[] = $expectedResponse;
        $expectedResponses[] = $expectedResponse2;
        $expectedResponses[] = $expectedResponse3;
        $this->assertEquals($expectedResponses, $responses);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.ConversationalSearchService/ConversationalSearch', $actualFuncCall);
        $actualValue = $actualRequestObject->getPlacement();
        $this->assertProtobufEquals($placement, $actualValue);
        $actualValue = $actualRequestObject->getBranch();
        $this->assertProtobufEquals($formattedBranch, $actualValue);
        $actualValue = $actualRequestObject->getVisitorId();
        $this->assertProtobufEquals($visitorId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function conversationalSearchExceptionTest()
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
        // Mock request
        $placement = 'placement1792938725';
        $formattedBranch = $gapicClient->branchName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[BRANCH]');
        $visitorId = 'visitorId-1832599924';
        $request = (new ConversationalSearchRequest())
            ->setPlacement($placement)
            ->setBranch($formattedBranch)
            ->setVisitorId($visitorId);
        $serverStream = $gapicClient->conversationalSearch($request);
        $results = $serverStream->readAll();
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
