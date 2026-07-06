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

namespace Google\Cloud\Support\Tests\Unit\V2\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Support\V2\Client\SupportEventSubscriptionServiceClient;
use Google\Cloud\Support\V2\CreateSupportEventSubscriptionRequest;
use Google\Cloud\Support\V2\DeleteSupportEventSubscriptionRequest;
use Google\Cloud\Support\V2\GetSupportEventSubscriptionRequest;
use Google\Cloud\Support\V2\ListSupportEventSubscriptionsRequest;
use Google\Cloud\Support\V2\ListSupportEventSubscriptionsResponse;
use Google\Cloud\Support\V2\SupportEventSubscription;
use Google\Cloud\Support\V2\UndeleteSupportEventSubscriptionRequest;
use Google\Cloud\Support\V2\UpdateSupportEventSubscriptionRequest;
use Google\Rpc\Code;
use stdClass;

/**
 * @group support
 *
 * @group gapic
 */
class SupportEventSubscriptionServiceClientTest extends GeneratedTest
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

    /** @return SupportEventSubscriptionServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new SupportEventSubscriptionServiceClient($options);
    }

    /** @test */
    public function createSupportEventSubscriptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $pubSubTopic = 'pubSubTopic-2117200978';
        $expectedResponse = new SupportEventSubscription();
        $expectedResponse->setName($name);
        $expectedResponse->setPubSubTopic($pubSubTopic);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $supportEventSubscription = new SupportEventSubscription();
        $supportEventSubscriptionPubSubTopic = 'supportEventSubscriptionPubSubTopic-1272370428';
        $supportEventSubscription->setPubSubTopic($supportEventSubscriptionPubSubTopic);
        $request = (new CreateSupportEventSubscriptionRequest())
            ->setParent($formattedParent)
            ->setSupportEventSubscription($supportEventSubscription);
        $response = $gapicClient->createSupportEventSubscription($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.support.v2.SupportEventSubscriptionService/CreateSupportEventSubscription',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getSupportEventSubscription();
        $this->assertProtobufEquals($supportEventSubscription, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createSupportEventSubscriptionExceptionTest()
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
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $supportEventSubscription = new SupportEventSubscription();
        $supportEventSubscriptionPubSubTopic = 'supportEventSubscriptionPubSubTopic-1272370428';
        $supportEventSubscription->setPubSubTopic($supportEventSubscriptionPubSubTopic);
        $request = (new CreateSupportEventSubscriptionRequest())
            ->setParent($formattedParent)
            ->setSupportEventSubscription($supportEventSubscription);
        try {
            $gapicClient->createSupportEventSubscription($request);
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
    public function deleteSupportEventSubscriptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $pubSubTopic = 'pubSubTopic-2117200978';
        $expectedResponse = new SupportEventSubscription();
        $expectedResponse->setName($name2);
        $expectedResponse->setPubSubTopic($pubSubTopic);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->supportEventSubscriptionName('[ORGANIZATION]', '[SUPPORT_EVENT_SUBSCRIPTION]');
        $request = (new DeleteSupportEventSubscriptionRequest())->setName($formattedName);
        $response = $gapicClient->deleteSupportEventSubscription($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.support.v2.SupportEventSubscriptionService/DeleteSupportEventSubscription',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteSupportEventSubscriptionExceptionTest()
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
        $formattedName = $gapicClient->supportEventSubscriptionName('[ORGANIZATION]', '[SUPPORT_EVENT_SUBSCRIPTION]');
        $request = (new DeleteSupportEventSubscriptionRequest())->setName($formattedName);
        try {
            $gapicClient->deleteSupportEventSubscription($request);
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
    public function getSupportEventSubscriptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $pubSubTopic = 'pubSubTopic-2117200978';
        $expectedResponse = new SupportEventSubscription();
        $expectedResponse->setName($name2);
        $expectedResponse->setPubSubTopic($pubSubTopic);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->supportEventSubscriptionName('[ORGANIZATION]', '[SUPPORT_EVENT_SUBSCRIPTION]');
        $request = (new GetSupportEventSubscriptionRequest())->setName($formattedName);
        $response = $gapicClient->getSupportEventSubscription($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.support.v2.SupportEventSubscriptionService/GetSupportEventSubscription',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getSupportEventSubscriptionExceptionTest()
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
        $formattedName = $gapicClient->supportEventSubscriptionName('[ORGANIZATION]', '[SUPPORT_EVENT_SUBSCRIPTION]');
        $request = (new GetSupportEventSubscriptionRequest())->setName($formattedName);
        try {
            $gapicClient->getSupportEventSubscription($request);
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
    public function listSupportEventSubscriptionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $supportEventSubscriptionsElement = new SupportEventSubscription();
        $supportEventSubscriptions = [$supportEventSubscriptionsElement];
        $expectedResponse = new ListSupportEventSubscriptionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSupportEventSubscriptions($supportEventSubscriptions);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $request = (new ListSupportEventSubscriptionsRequest())->setParent($formattedParent);
        $response = $gapicClient->listSupportEventSubscriptions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getSupportEventSubscriptions()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.support.v2.SupportEventSubscriptionService/ListSupportEventSubscriptions',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listSupportEventSubscriptionsExceptionTest()
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
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $request = (new ListSupportEventSubscriptionsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listSupportEventSubscriptions($request);
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
    public function undeleteSupportEventSubscriptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $pubSubTopic = 'pubSubTopic-2117200978';
        $expectedResponse = new SupportEventSubscription();
        $expectedResponse->setName($name2);
        $expectedResponse->setPubSubTopic($pubSubTopic);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->supportEventSubscriptionName('[ORGANIZATION]', '[SUPPORT_EVENT_SUBSCRIPTION]');
        $request = (new UndeleteSupportEventSubscriptionRequest())->setName($formattedName);
        $response = $gapicClient->undeleteSupportEventSubscription($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.support.v2.SupportEventSubscriptionService/UndeleteSupportEventSubscription',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function undeleteSupportEventSubscriptionExceptionTest()
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
        $formattedName = $gapicClient->supportEventSubscriptionName('[ORGANIZATION]', '[SUPPORT_EVENT_SUBSCRIPTION]');
        $request = (new UndeleteSupportEventSubscriptionRequest())->setName($formattedName);
        try {
            $gapicClient->undeleteSupportEventSubscription($request);
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
    public function updateSupportEventSubscriptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $pubSubTopic = 'pubSubTopic-2117200978';
        $expectedResponse = new SupportEventSubscription();
        $expectedResponse->setName($name);
        $expectedResponse->setPubSubTopic($pubSubTopic);
        $transport->addResponse($expectedResponse);
        // Mock request
        $supportEventSubscription = new SupportEventSubscription();
        $supportEventSubscriptionPubSubTopic = 'supportEventSubscriptionPubSubTopic-1272370428';
        $supportEventSubscription->setPubSubTopic($supportEventSubscriptionPubSubTopic);
        $request = (new UpdateSupportEventSubscriptionRequest())->setSupportEventSubscription(
            $supportEventSubscription
        );
        $response = $gapicClient->updateSupportEventSubscription($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.support.v2.SupportEventSubscriptionService/UpdateSupportEventSubscription',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getSupportEventSubscription();
        $this->assertProtobufEquals($supportEventSubscription, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateSupportEventSubscriptionExceptionTest()
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
        $supportEventSubscription = new SupportEventSubscription();
        $supportEventSubscriptionPubSubTopic = 'supportEventSubscriptionPubSubTopic-1272370428';
        $supportEventSubscription->setPubSubTopic($supportEventSubscriptionPubSubTopic);
        $request = (new UpdateSupportEventSubscriptionRequest())->setSupportEventSubscription(
            $supportEventSubscription
        );
        try {
            $gapicClient->updateSupportEventSubscription($request);
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
    public function createSupportEventSubscriptionAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $pubSubTopic = 'pubSubTopic-2117200978';
        $expectedResponse = new SupportEventSubscription();
        $expectedResponse->setName($name);
        $expectedResponse->setPubSubTopic($pubSubTopic);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $supportEventSubscription = new SupportEventSubscription();
        $supportEventSubscriptionPubSubTopic = 'supportEventSubscriptionPubSubTopic-1272370428';
        $supportEventSubscription->setPubSubTopic($supportEventSubscriptionPubSubTopic);
        $request = (new CreateSupportEventSubscriptionRequest())
            ->setParent($formattedParent)
            ->setSupportEventSubscription($supportEventSubscription);
        $response = $gapicClient->createSupportEventSubscriptionAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.support.v2.SupportEventSubscriptionService/CreateSupportEventSubscription',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getSupportEventSubscription();
        $this->assertProtobufEquals($supportEventSubscription, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
