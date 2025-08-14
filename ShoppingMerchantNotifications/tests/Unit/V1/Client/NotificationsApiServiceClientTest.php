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

namespace Google\Shopping\Merchant\Notifications\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use Google\Shopping\Merchant\Notifications\V1\Client\NotificationsApiServiceClient;
use Google\Shopping\Merchant\Notifications\V1\CreateNotificationSubscriptionRequest;
use Google\Shopping\Merchant\Notifications\V1\DeleteNotificationSubscriptionRequest;
use Google\Shopping\Merchant\Notifications\V1\GetNotificationSubscriptionHealthMetricsRequest;
use Google\Shopping\Merchant\Notifications\V1\GetNotificationSubscriptionRequest;
use Google\Shopping\Merchant\Notifications\V1\ListNotificationSubscriptionsRequest;
use Google\Shopping\Merchant\Notifications\V1\ListNotificationSubscriptionsResponse;
use Google\Shopping\Merchant\Notifications\V1\NotificationSubscription;
use Google\Shopping\Merchant\Notifications\V1\NotificationSubscriptionHealthMetrics;
use Google\Shopping\Merchant\Notifications\V1\UpdateNotificationSubscriptionRequest;
use stdClass;

/**
 * @group notifications
 *
 * @group gapic
 */
class NotificationsApiServiceClientTest extends GeneratedTest
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

    /** @return NotificationsApiServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new NotificationsApiServiceClient($options);
    }

    /** @test */
    public function createNotificationSubscriptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $allManagedAccounts = true;
        $name = 'name3373707';
        $callBackUri = 'callBackUri-1975013675';
        $expectedResponse = new NotificationSubscription();
        $expectedResponse->setAllManagedAccounts($allManagedAccounts);
        $expectedResponse->setName($name);
        $expectedResponse->setCallBackUri($callBackUri);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $notificationSubscription = new NotificationSubscription();
        $request = (new CreateNotificationSubscriptionRequest())
            ->setParent($formattedParent)
            ->setNotificationSubscription($notificationSubscription);
        $response = $gapicClient->createNotificationSubscription($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.notifications.v1.NotificationsApiService/CreateNotificationSubscription',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNotificationSubscription();
        $this->assertProtobufEquals($notificationSubscription, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createNotificationSubscriptionExceptionTest()
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
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $notificationSubscription = new NotificationSubscription();
        $request = (new CreateNotificationSubscriptionRequest())
            ->setParent($formattedParent)
            ->setNotificationSubscription($notificationSubscription);
        try {
            $gapicClient->createNotificationSubscription($request);
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
    public function deleteNotificationSubscriptionTest()
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
        $formattedName = $gapicClient->notificationSubscriptionName('[ACCOUNT]', '[NOTIFICATION_SUBSCRIPTION]');
        $request = (new DeleteNotificationSubscriptionRequest())->setName($formattedName);
        $gapicClient->deleteNotificationSubscription($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.notifications.v1.NotificationsApiService/DeleteNotificationSubscription',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteNotificationSubscriptionExceptionTest()
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
        $formattedName = $gapicClient->notificationSubscriptionName('[ACCOUNT]', '[NOTIFICATION_SUBSCRIPTION]');
        $request = (new DeleteNotificationSubscriptionRequest())->setName($formattedName);
        try {
            $gapicClient->deleteNotificationSubscription($request);
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
    public function getNotificationSubscriptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $allManagedAccounts = true;
        $name2 = 'name2-1052831874';
        $callBackUri = 'callBackUri-1975013675';
        $expectedResponse = new NotificationSubscription();
        $expectedResponse->setAllManagedAccounts($allManagedAccounts);
        $expectedResponse->setName($name2);
        $expectedResponse->setCallBackUri($callBackUri);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->notificationSubscriptionName('[ACCOUNT]', '[NOTIFICATION_SUBSCRIPTION]');
        $request = (new GetNotificationSubscriptionRequest())->setName($formattedName);
        $response = $gapicClient->getNotificationSubscription($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.notifications.v1.NotificationsApiService/GetNotificationSubscription',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getNotificationSubscriptionExceptionTest()
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
        $formattedName = $gapicClient->notificationSubscriptionName('[ACCOUNT]', '[NOTIFICATION_SUBSCRIPTION]');
        $request = (new GetNotificationSubscriptionRequest())->setName($formattedName);
        try {
            $gapicClient->getNotificationSubscription($request);
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
    public function getNotificationSubscriptionHealthMetricsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $acknowledgedMessagesCount = 1331941427;
        $undeliveredMessagesCount = 1001002256;
        $oldestUnacknowledgedMessageWaitingTime = 2012289131;
        $expectedResponse = new NotificationSubscriptionHealthMetrics();
        $expectedResponse->setName($name2);
        $expectedResponse->setAcknowledgedMessagesCount($acknowledgedMessagesCount);
        $expectedResponse->setUndeliveredMessagesCount($undeliveredMessagesCount);
        $expectedResponse->setOldestUnacknowledgedMessageWaitingTime($oldestUnacknowledgedMessageWaitingTime);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->notificationSubscriptionHealthMetricsName(
            '[ACCOUNT]',
            '[NOTIFICATION_SUBSCRIPTION]'
        );
        $request = (new GetNotificationSubscriptionHealthMetricsRequest())->setName($formattedName);
        $response = $gapicClient->getNotificationSubscriptionHealthMetrics($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.notifications.v1.NotificationsApiService/GetNotificationSubscriptionHealthMetrics',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getNotificationSubscriptionHealthMetricsExceptionTest()
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
        $formattedName = $gapicClient->notificationSubscriptionHealthMetricsName(
            '[ACCOUNT]',
            '[NOTIFICATION_SUBSCRIPTION]'
        );
        $request = (new GetNotificationSubscriptionHealthMetricsRequest())->setName($formattedName);
        try {
            $gapicClient->getNotificationSubscriptionHealthMetrics($request);
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
    public function listNotificationSubscriptionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $notificationSubscriptionsElement = new NotificationSubscription();
        $notificationSubscriptions = [$notificationSubscriptionsElement];
        $expectedResponse = new ListNotificationSubscriptionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setNotificationSubscriptions($notificationSubscriptions);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $request = (new ListNotificationSubscriptionsRequest())->setParent($formattedParent);
        $response = $gapicClient->listNotificationSubscriptions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getNotificationSubscriptions()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.notifications.v1.NotificationsApiService/ListNotificationSubscriptions',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listNotificationSubscriptionsExceptionTest()
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
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $request = (new ListNotificationSubscriptionsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listNotificationSubscriptions($request);
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
    public function updateNotificationSubscriptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $allManagedAccounts = true;
        $name = 'name3373707';
        $callBackUri = 'callBackUri-1975013675';
        $expectedResponse = new NotificationSubscription();
        $expectedResponse->setAllManagedAccounts($allManagedAccounts);
        $expectedResponse->setName($name);
        $expectedResponse->setCallBackUri($callBackUri);
        $transport->addResponse($expectedResponse);
        // Mock request
        $notificationSubscription = new NotificationSubscription();
        $request = (new UpdateNotificationSubscriptionRequest())->setNotificationSubscription(
            $notificationSubscription
        );
        $response = $gapicClient->updateNotificationSubscription($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.notifications.v1.NotificationsApiService/UpdateNotificationSubscription',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getNotificationSubscription();
        $this->assertProtobufEquals($notificationSubscription, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateNotificationSubscriptionExceptionTest()
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
        $notificationSubscription = new NotificationSubscription();
        $request = (new UpdateNotificationSubscriptionRequest())->setNotificationSubscription(
            $notificationSubscription
        );
        try {
            $gapicClient->updateNotificationSubscription($request);
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
    public function createNotificationSubscriptionAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $allManagedAccounts = true;
        $name = 'name3373707';
        $callBackUri = 'callBackUri-1975013675';
        $expectedResponse = new NotificationSubscription();
        $expectedResponse->setAllManagedAccounts($allManagedAccounts);
        $expectedResponse->setName($name);
        $expectedResponse->setCallBackUri($callBackUri);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $notificationSubscription = new NotificationSubscription();
        $request = (new CreateNotificationSubscriptionRequest())
            ->setParent($formattedParent)
            ->setNotificationSubscription($notificationSubscription);
        $response = $gapicClient->createNotificationSubscriptionAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.notifications.v1.NotificationsApiService/CreateNotificationSubscription',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNotificationSubscription();
        $this->assertProtobufEquals($notificationSubscription, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
