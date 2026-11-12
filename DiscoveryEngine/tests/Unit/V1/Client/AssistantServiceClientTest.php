<?php
/*
 * Copyright 2026 Google LLC
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

namespace Google\Cloud\DiscoveryEngine\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\ServerStream;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\DiscoveryEngine\V1\Assistant;
use Google\Cloud\DiscoveryEngine\V1\Client\AssistantServiceClient;
use Google\Cloud\DiscoveryEngine\V1\CreateAssistantRequest;
use Google\Cloud\DiscoveryEngine\V1\DeleteAssistantRequest;
use Google\Cloud\DiscoveryEngine\V1\GetAssistantRequest;
use Google\Cloud\DiscoveryEngine\V1\ListAssistantsRequest;
use Google\Cloud\DiscoveryEngine\V1\ListAssistantsResponse;
use Google\Cloud\DiscoveryEngine\V1\StreamAssistRequest;
use Google\Cloud\DiscoveryEngine\V1\StreamAssistResponse;
use Google\Cloud\DiscoveryEngine\V1\UpdateAssistantRequest;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group discoveryengine
 *
 * @group gapic
 */
class AssistantServiceClientTest extends GeneratedTest
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

    /** @return AssistantServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AssistantServiceClient($options);
    }

    /** @test */
    public function createAssistantTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $defaultWebGroundingToggleOff = false;
        $expectedResponse = new Assistant();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDefaultWebGroundingToggleOff($defaultWebGroundingToggleOff);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->engineName('[PROJECT]', '[LOCATION]', '[COLLECTION]', '[ENGINE]');
        $assistant = new Assistant();
        $assistantDisplayName = 'assistantDisplayName-294767441';
        $assistant->setDisplayName($assistantDisplayName);
        $assistantId = 'assistantId-1470125540';
        $request = (new CreateAssistantRequest())
            ->setParent($formattedParent)
            ->setAssistant($assistant)
            ->setAssistantId($assistantId);
        $response = $gapicClient->createAssistant($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.AssistantService/CreateAssistant', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAssistant();
        $this->assertProtobufEquals($assistant, $actualValue);
        $actualValue = $actualRequestObject->getAssistantId();
        $this->assertProtobufEquals($assistantId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createAssistantExceptionTest()
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
        $formattedParent = $gapicClient->engineName('[PROJECT]', '[LOCATION]', '[COLLECTION]', '[ENGINE]');
        $assistant = new Assistant();
        $assistantDisplayName = 'assistantDisplayName-294767441';
        $assistant->setDisplayName($assistantDisplayName);
        $assistantId = 'assistantId-1470125540';
        $request = (new CreateAssistantRequest())
            ->setParent($formattedParent)
            ->setAssistant($assistant)
            ->setAssistantId($assistantId);
        try {
            $gapicClient->createAssistant($request);
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
    public function deleteAssistantTest()
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
        $formattedName = $gapicClient->assistantName(
            '[PROJECT]',
            '[LOCATION]',
            '[COLLECTION]',
            '[ENGINE]',
            '[ASSISTANT]'
        );
        $request = (new DeleteAssistantRequest())->setName($formattedName);
        $gapicClient->deleteAssistant($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.AssistantService/DeleteAssistant', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteAssistantExceptionTest()
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
        $formattedName = $gapicClient->assistantName(
            '[PROJECT]',
            '[LOCATION]',
            '[COLLECTION]',
            '[ENGINE]',
            '[ASSISTANT]'
        );
        $request = (new DeleteAssistantRequest())->setName($formattedName);
        try {
            $gapicClient->deleteAssistant($request);
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
    public function getAssistantTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $defaultWebGroundingToggleOff = false;
        $expectedResponse = new Assistant();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDefaultWebGroundingToggleOff($defaultWebGroundingToggleOff);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->assistantName(
            '[PROJECT]',
            '[LOCATION]',
            '[COLLECTION]',
            '[ENGINE]',
            '[ASSISTANT]'
        );
        $request = (new GetAssistantRequest())->setName($formattedName);
        $response = $gapicClient->getAssistant($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.AssistantService/GetAssistant', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAssistantExceptionTest()
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
        $formattedName = $gapicClient->assistantName(
            '[PROJECT]',
            '[LOCATION]',
            '[COLLECTION]',
            '[ENGINE]',
            '[ASSISTANT]'
        );
        $request = (new GetAssistantRequest())->setName($formattedName);
        try {
            $gapicClient->getAssistant($request);
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
    public function listAssistantsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $assistantsElement = new Assistant();
        $assistants = [$assistantsElement];
        $expectedResponse = new ListAssistantsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAssistants($assistants);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->engineName('[PROJECT]', '[LOCATION]', '[COLLECTION]', '[ENGINE]');
        $request = (new ListAssistantsRequest())->setParent($formattedParent);
        $response = $gapicClient->listAssistants($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAssistants()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.AssistantService/ListAssistants', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAssistantsExceptionTest()
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
        $formattedParent = $gapicClient->engineName('[PROJECT]', '[LOCATION]', '[COLLECTION]', '[ENGINE]');
        $request = (new ListAssistantsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listAssistants($request);
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
    public function streamAssistTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $assistToken = 'assistToken-1521980253';
        $expectedResponse = new StreamAssistResponse();
        $expectedResponse->setAssistToken($assistToken);
        $transport->addResponse($expectedResponse);
        $assistToken2 = 'assistToken21960827798';
        $expectedResponse2 = new StreamAssistResponse();
        $expectedResponse2->setAssistToken($assistToken2);
        $transport->addResponse($expectedResponse2);
        $assistToken3 = 'assistToken31960827799';
        $expectedResponse3 = new StreamAssistResponse();
        $expectedResponse3->setAssistToken($assistToken3);
        $transport->addResponse($expectedResponse3);
        // Mock request
        $formattedName = $gapicClient->assistantName(
            '[PROJECT]',
            '[LOCATION]',
            '[COLLECTION]',
            '[ENGINE]',
            '[ASSISTANT]'
        );
        $request = (new StreamAssistRequest())->setName($formattedName);
        $serverStream = $gapicClient->streamAssist($request);
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
        $this->assertSame('/google.cloud.discoveryengine.v1.AssistantService/StreamAssist', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function streamAssistExceptionTest()
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
        $formattedName = $gapicClient->assistantName(
            '[PROJECT]',
            '[LOCATION]',
            '[COLLECTION]',
            '[ENGINE]',
            '[ASSISTANT]'
        );
        $request = (new StreamAssistRequest())->setName($formattedName);
        $serverStream = $gapicClient->streamAssist($request);
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

    /** @test */
    public function updateAssistantTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $defaultWebGroundingToggleOff = false;
        $expectedResponse = new Assistant();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDefaultWebGroundingToggleOff($defaultWebGroundingToggleOff);
        $transport->addResponse($expectedResponse);
        // Mock request
        $assistant = new Assistant();
        $assistantDisplayName = 'assistantDisplayName-294767441';
        $assistant->setDisplayName($assistantDisplayName);
        $request = (new UpdateAssistantRequest())->setAssistant($assistant);
        $response = $gapicClient->updateAssistant($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.AssistantService/UpdateAssistant', $actualFuncCall);
        $actualValue = $actualRequestObject->getAssistant();
        $this->assertProtobufEquals($assistant, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateAssistantExceptionTest()
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
        $assistant = new Assistant();
        $assistantDisplayName = 'assistantDisplayName-294767441';
        $assistant->setDisplayName($assistantDisplayName);
        $request = (new UpdateAssistantRequest())->setAssistant($assistant);
        try {
            $gapicClient->updateAssistant($request);
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
    public function createAssistantAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $defaultWebGroundingToggleOff = false;
        $expectedResponse = new Assistant();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDefaultWebGroundingToggleOff($defaultWebGroundingToggleOff);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->engineName('[PROJECT]', '[LOCATION]', '[COLLECTION]', '[ENGINE]');
        $assistant = new Assistant();
        $assistantDisplayName = 'assistantDisplayName-294767441';
        $assistant->setDisplayName($assistantDisplayName);
        $assistantId = 'assistantId-1470125540';
        $request = (new CreateAssistantRequest())
            ->setParent($formattedParent)
            ->setAssistant($assistant)
            ->setAssistantId($assistantId);
        $response = $gapicClient->createAssistantAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.AssistantService/CreateAssistant', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAssistant();
        $this->assertProtobufEquals($assistant, $actualValue);
        $actualValue = $actualRequestObject->getAssistantId();
        $this->assertProtobufEquals($assistantId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
