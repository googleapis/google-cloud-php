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

namespace Google\Ads\DataManager\Tests\Unit\V1\Client;

use Google\Ads\DataManager\V1\Baseline;
use Google\Ads\DataManager\V1\Client\MarketingDataInsightsServiceClient;
use Google\Ads\DataManager\V1\RetrieveInsightsRequest;
use Google\Ads\DataManager\V1\RetrieveInsightsResponse;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Rpc\Code;
use stdClass;

/**
 * @group datamanager
 *
 * @group gapic
 */
class MarketingDataInsightsServiceClientTest extends GeneratedTest
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

    /** @return MarketingDataInsightsServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new MarketingDataInsightsServiceClient($options);
    }

    /** @test */
    public function retrieveInsightsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new RetrieveInsightsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $baseline = new Baseline();
        $userListId = 'userListId1707617256';
        $request = (new RetrieveInsightsRequest())
            ->setParent($parent)
            ->setBaseline($baseline)
            ->setUserListId($userListId);
        $response = $gapicClient->retrieveInsights($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.MarketingDataInsightsService/RetrieveInsights', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getBaseline();
        $this->assertProtobufEquals($baseline, $actualValue);
        $actualValue = $actualRequestObject->getUserListId();
        $this->assertProtobufEquals($userListId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function retrieveInsightsExceptionTest()
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
        $parent = 'parent-995424086';
        $baseline = new Baseline();
        $userListId = 'userListId1707617256';
        $request = (new RetrieveInsightsRequest())
            ->setParent($parent)
            ->setBaseline($baseline)
            ->setUserListId($userListId);
        try {
            $gapicClient->retrieveInsights($request);
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
    public function retrieveInsightsAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new RetrieveInsightsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $baseline = new Baseline();
        $userListId = 'userListId1707617256';
        $request = (new RetrieveInsightsRequest())
            ->setParent($parent)
            ->setBaseline($baseline)
            ->setUserListId($userListId);
        $response = $gapicClient->retrieveInsightsAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.datamanager.v1.MarketingDataInsightsService/RetrieveInsights', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getBaseline();
        $this->assertProtobufEquals($baseline, $actualValue);
        $actualValue = $actualRequestObject->getUserListId();
        $this->assertProtobufEquals($userListId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
