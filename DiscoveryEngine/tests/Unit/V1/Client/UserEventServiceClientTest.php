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

namespace Google\Cloud\DiscoveryEngine\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Api\HttpBody;
use Google\Cloud\DiscoveryEngine\V1\Client\UserEventServiceClient;
use Google\Cloud\DiscoveryEngine\V1\CollectUserEventRequest;
use Google\Cloud\DiscoveryEngine\V1\ImportUserEventsRequest;
use Google\Cloud\DiscoveryEngine\V1\ImportUserEventsRequest\InlineSource;
use Google\Cloud\DiscoveryEngine\V1\ImportUserEventsResponse;
use Google\Cloud\DiscoveryEngine\V1\UserEvent;
use Google\Cloud\DiscoveryEngine\V1\WriteUserEventRequest;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Rpc\Code;
use stdClass;

/**
 * @group discoveryengine
 *
 * @group gapic
 */
class UserEventServiceClientTest extends GeneratedTest
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

    /** @return UserEventServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new UserEventServiceClient($options);
    }

    /** @test */
    public function collectUserEventTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $contentType = 'contentType831846208';
        $data = '-86';
        $expectedResponse = new HttpBody();
        $expectedResponse->setContentType($contentType);
        $expectedResponse->setData($data);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->dataStoreName('[PROJECT]', '[LOCATION]', '[DATA_STORE]');
        $userEvent = 'userEvent1921940774';
        $request = (new CollectUserEventRequest())
            ->setParent($formattedParent)
            ->setUserEvent($userEvent);
        $response = $gapicClient->collectUserEvent($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.UserEventService/CollectUserEvent', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getUserEvent();
        $this->assertProtobufEquals($userEvent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function collectUserEventExceptionTest()
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
        $formattedParent = $gapicClient->dataStoreName('[PROJECT]', '[LOCATION]', '[DATA_STORE]');
        $userEvent = 'userEvent1921940774';
        $request = (new CollectUserEventRequest())
            ->setParent($formattedParent)
            ->setUserEvent($userEvent);
        try {
            $gapicClient->collectUserEvent($request);
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
    public function importUserEventsTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/importUserEventsTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $joinedEventsCount = 720068705;
        $unjoinedEventsCount = 512159846;
        $expectedResponse = new ImportUserEventsResponse();
        $expectedResponse->setJoinedEventsCount($joinedEventsCount);
        $expectedResponse->setUnjoinedEventsCount($unjoinedEventsCount);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/importUserEventsTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $inlineSource = new InlineSource();
        $inlineSourceUserEvents = [];
        $inlineSource->setUserEvents($inlineSourceUserEvents);
        $formattedParent = $gapicClient->dataStoreName('[PROJECT]', '[LOCATION]', '[DATA_STORE]');
        $request = (new ImportUserEventsRequest())
            ->setInlineSource($inlineSource)
            ->setParent($formattedParent);
        $response = $gapicClient->importUserEvents($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.UserEventService/ImportUserEvents', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInlineSource();
        $this->assertProtobufEquals($inlineSource, $actualValue);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/importUserEventsTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function importUserEventsExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/importUserEventsTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $inlineSource = new InlineSource();
        $inlineSourceUserEvents = [];
        $inlineSource->setUserEvents($inlineSourceUserEvents);
        $formattedParent = $gapicClient->dataStoreName('[PROJECT]', '[LOCATION]', '[DATA_STORE]');
        $request = (new ImportUserEventsRequest())
            ->setInlineSource($inlineSource)
            ->setParent($formattedParent);
        $response = $gapicClient->importUserEvents($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/importUserEventsTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function writeUserEventTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $eventType = 'eventType984376767';
        $userPseudoId = 'userPseudoId-1850666040';
        $directUserRequest = false;
        $sessionId = 'sessionId1661853540';
        $attributionToken = 'attributionToken-729411015';
        $filter = 'filter-1274492040';
        $expectedResponse = new UserEvent();
        $expectedResponse->setEventType($eventType);
        $expectedResponse->setUserPseudoId($userPseudoId);
        $expectedResponse->setDirectUserRequest($directUserRequest);
        $expectedResponse->setSessionId($sessionId);
        $expectedResponse->setAttributionToken($attributionToken);
        $expectedResponse->setFilter($filter);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->dataStoreName('[PROJECT]', '[LOCATION]', '[DATA_STORE]');
        $userEvent = new UserEvent();
        $userEventEventType = 'userEventEventType341658661';
        $userEvent->setEventType($userEventEventType);
        $userEventUserPseudoId = 'userEventUserPseudoId-1929667693';
        $userEvent->setUserPseudoId($userEventUserPseudoId);
        $request = (new WriteUserEventRequest())
            ->setParent($formattedParent)
            ->setUserEvent($userEvent);
        $response = $gapicClient->writeUserEvent($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.UserEventService/WriteUserEvent', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getUserEvent();
        $this->assertProtobufEquals($userEvent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function writeUserEventExceptionTest()
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
        $formattedParent = $gapicClient->dataStoreName('[PROJECT]', '[LOCATION]', '[DATA_STORE]');
        $userEvent = new UserEvent();
        $userEventEventType = 'userEventEventType341658661';
        $userEvent->setEventType($userEventEventType);
        $userEventUserPseudoId = 'userEventUserPseudoId-1929667693';
        $userEvent->setUserPseudoId($userEventUserPseudoId);
        $request = (new WriteUserEventRequest())
            ->setParent($formattedParent)
            ->setUserEvent($userEvent);
        try {
            $gapicClient->writeUserEvent($request);
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
    public function collectUserEventAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $contentType = 'contentType831846208';
        $data = '-86';
        $expectedResponse = new HttpBody();
        $expectedResponse->setContentType($contentType);
        $expectedResponse->setData($data);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->dataStoreName('[PROJECT]', '[LOCATION]', '[DATA_STORE]');
        $userEvent = 'userEvent1921940774';
        $request = (new CollectUserEventRequest())
            ->setParent($formattedParent)
            ->setUserEvent($userEvent);
        $response = $gapicClient->collectUserEventAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.UserEventService/CollectUserEvent', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getUserEvent();
        $this->assertProtobufEquals($userEvent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
