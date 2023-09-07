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

namespace Google\Cloud\Monitoring\Tests\Unit\V3\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Monitoring\V3\Client\SnoozeServiceClient;
use Google\Cloud\Monitoring\V3\CreateSnoozeRequest;
use Google\Cloud\Monitoring\V3\GetSnoozeRequest;
use Google\Cloud\Monitoring\V3\ListSnoozesRequest;
use Google\Cloud\Monitoring\V3\ListSnoozesResponse;
use Google\Cloud\Monitoring\V3\Snooze;
use Google\Cloud\Monitoring\V3\Snooze\Criteria;
use Google\Cloud\Monitoring\V3\TimeInterval;
use Google\Cloud\Monitoring\V3\UpdateSnoozeRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Code;
use stdClass;

/**
 * @group monitoring
 *
 * @group gapic
 */
class SnoozeServiceClientTest extends GeneratedTest
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

    /** @return SnoozeServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new SnoozeServiceClient($options);
    }

    /** @test */
    public function createSnoozeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $expectedResponse = new Snooze();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->workspaceName('[PROJECT]');
        $snooze = new Snooze();
        $snoozeName = 'snoozeName1119820177';
        $snooze->setName($snoozeName);
        $snoozeCriteria = new Criteria();
        $snooze->setCriteria($snoozeCriteria);
        $snoozeInterval = new TimeInterval();
        $snooze->setInterval($snoozeInterval);
        $snoozeDisplayName = 'snoozeDisplayName-1956223833';
        $snooze->setDisplayName($snoozeDisplayName);
        $request = (new CreateSnoozeRequest())
            ->setParent($formattedParent)
            ->setSnooze($snooze);
        $response = $gapicClient->createSnooze($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.monitoring.v3.SnoozeService/CreateSnooze', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getSnooze();
        $this->assertProtobufEquals($snooze, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createSnoozeExceptionTest()
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
        $formattedParent = $gapicClient->workspaceName('[PROJECT]');
        $snooze = new Snooze();
        $snoozeName = 'snoozeName1119820177';
        $snooze->setName($snoozeName);
        $snoozeCriteria = new Criteria();
        $snooze->setCriteria($snoozeCriteria);
        $snoozeInterval = new TimeInterval();
        $snooze->setInterval($snoozeInterval);
        $snoozeDisplayName = 'snoozeDisplayName-1956223833';
        $snooze->setDisplayName($snoozeDisplayName);
        $request = (new CreateSnoozeRequest())
            ->setParent($formattedParent)
            ->setSnooze($snooze);
        try {
            $gapicClient->createSnooze($request);
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
    public function getSnoozeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $expectedResponse = new Snooze();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->snoozeName('[PROJECT]', '[SNOOZE]');
        $request = (new GetSnoozeRequest())
            ->setName($formattedName);
        $response = $gapicClient->getSnooze($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.monitoring.v3.SnoozeService/GetSnooze', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getSnoozeExceptionTest()
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
        $formattedName = $gapicClient->snoozeName('[PROJECT]', '[SNOOZE]');
        $request = (new GetSnoozeRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getSnooze($request);
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
    public function listSnoozesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $snoozesElement = new Snooze();
        $snoozes = [
            $snoozesElement,
        ];
        $expectedResponse = new ListSnoozesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSnoozes($snoozes);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->workspaceName('[PROJECT]');
        $request = (new ListSnoozesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listSnoozes($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getSnoozes()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.monitoring.v3.SnoozeService/ListSnoozes', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listSnoozesExceptionTest()
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
        $formattedParent = $gapicClient->workspaceName('[PROJECT]');
        $request = (new ListSnoozesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listSnoozes($request);
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
    public function updateSnoozeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $expectedResponse = new Snooze();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $snooze = new Snooze();
        $snoozeName = 'snoozeName1119820177';
        $snooze->setName($snoozeName);
        $snoozeCriteria = new Criteria();
        $snooze->setCriteria($snoozeCriteria);
        $snoozeInterval = new TimeInterval();
        $snooze->setInterval($snoozeInterval);
        $snoozeDisplayName = 'snoozeDisplayName-1956223833';
        $snooze->setDisplayName($snoozeDisplayName);
        $updateMask = new FieldMask();
        $request = (new UpdateSnoozeRequest())
            ->setSnooze($snooze)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateSnooze($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.monitoring.v3.SnoozeService/UpdateSnooze', $actualFuncCall);
        $actualValue = $actualRequestObject->getSnooze();
        $this->assertProtobufEquals($snooze, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateSnoozeExceptionTest()
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
        $snooze = new Snooze();
        $snoozeName = 'snoozeName1119820177';
        $snooze->setName($snoozeName);
        $snoozeCriteria = new Criteria();
        $snooze->setCriteria($snoozeCriteria);
        $snoozeInterval = new TimeInterval();
        $snooze->setInterval($snoozeInterval);
        $snoozeDisplayName = 'snoozeDisplayName-1956223833';
        $snooze->setDisplayName($snoozeDisplayName);
        $updateMask = new FieldMask();
        $request = (new UpdateSnoozeRequest())
            ->setSnooze($snooze)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateSnooze($request);
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
    public function createSnoozeAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $expectedResponse = new Snooze();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->workspaceName('[PROJECT]');
        $snooze = new Snooze();
        $snoozeName = 'snoozeName1119820177';
        $snooze->setName($snoozeName);
        $snoozeCriteria = new Criteria();
        $snooze->setCriteria($snoozeCriteria);
        $snoozeInterval = new TimeInterval();
        $snooze->setInterval($snoozeInterval);
        $snoozeDisplayName = 'snoozeDisplayName-1956223833';
        $snooze->setDisplayName($snoozeDisplayName);
        $request = (new CreateSnoozeRequest())
            ->setParent($formattedParent)
            ->setSnooze($snooze);
        $response = $gapicClient->createSnoozeAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.monitoring.v3.SnoozeService/CreateSnooze', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getSnooze();
        $this->assertProtobufEquals($snooze, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
