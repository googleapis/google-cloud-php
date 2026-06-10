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

namespace Google\Cloud\Chronicle\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Chronicle\V1\Client\FeaturedContentNativeDashboardServiceClient;
use Google\Cloud\Chronicle\V1\FeaturedContentNativeDashboard;
use Google\Cloud\Chronicle\V1\GetFeaturedContentNativeDashboardRequest;
use Google\Cloud\Chronicle\V1\InstallFeaturedContentNativeDashboardRequest;
use Google\Cloud\Chronicle\V1\InstallFeaturedContentNativeDashboardResponse;
use Google\Cloud\Chronicle\V1\ListFeaturedContentNativeDashboardsRequest;
use Google\Cloud\Chronicle\V1\ListFeaturedContentNativeDashboardsResponse;
use Google\Rpc\Code;
use stdClass;

/**
 * @group chronicle
 *
 * @group gapic
 */
class FeaturedContentNativeDashboardServiceClientTest extends GeneratedTest
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

    /** @return FeaturedContentNativeDashboardServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new FeaturedContentNativeDashboardServiceClient($options);
    }

    /** @test */
    public function getFeaturedContentNativeDashboardTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new FeaturedContentNativeDashboard();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->featuredContentNativeDashboardName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[FEATURED_CONTENT_NATIVE_DASHBOARD]'
        );
        $request = (new GetFeaturedContentNativeDashboardRequest())->setName($formattedName);
        $response = $gapicClient->getFeaturedContentNativeDashboard($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.chronicle.v1.FeaturedContentNativeDashboardService/GetFeaturedContentNativeDashboard',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getFeaturedContentNativeDashboardExceptionTest()
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
        $formattedName = $gapicClient->featuredContentNativeDashboardName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[FEATURED_CONTENT_NATIVE_DASHBOARD]'
        );
        $request = (new GetFeaturedContentNativeDashboardRequest())->setName($formattedName);
        try {
            $gapicClient->getFeaturedContentNativeDashboard($request);
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
    public function installFeaturedContentNativeDashboardTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nativeDashboard = 'nativeDashboard-671726484';
        $expectedResponse = new InstallFeaturedContentNativeDashboardResponse();
        $expectedResponse->setNativeDashboard($nativeDashboard);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->featuredContentNativeDashboardName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[FEATURED_CONTENT_NATIVE_DASHBOARD]'
        );
        $request = (new InstallFeaturedContentNativeDashboardRequest())->setName($formattedName);
        $response = $gapicClient->installFeaturedContentNativeDashboard($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.chronicle.v1.FeaturedContentNativeDashboardService/InstallFeaturedContentNativeDashboard',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function installFeaturedContentNativeDashboardExceptionTest()
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
        $formattedName = $gapicClient->featuredContentNativeDashboardName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[FEATURED_CONTENT_NATIVE_DASHBOARD]'
        );
        $request = (new InstallFeaturedContentNativeDashboardRequest())->setName($formattedName);
        try {
            $gapicClient->installFeaturedContentNativeDashboard($request);
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
    public function listFeaturedContentNativeDashboardsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $featuredContentNativeDashboardsElement = new FeaturedContentNativeDashboard();
        $featuredContentNativeDashboards = [$featuredContentNativeDashboardsElement];
        $expectedResponse = new ListFeaturedContentNativeDashboardsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setFeaturedContentNativeDashboards($featuredContentNativeDashboards);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->contentHubName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new ListFeaturedContentNativeDashboardsRequest())->setParent($formattedParent);
        $response = $gapicClient->listFeaturedContentNativeDashboards($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getFeaturedContentNativeDashboards()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.chronicle.v1.FeaturedContentNativeDashboardService/ListFeaturedContentNativeDashboards',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listFeaturedContentNativeDashboardsExceptionTest()
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
        $formattedParent = $gapicClient->contentHubName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new ListFeaturedContentNativeDashboardsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listFeaturedContentNativeDashboards($request);
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
    public function getFeaturedContentNativeDashboardAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new FeaturedContentNativeDashboard();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->featuredContentNativeDashboardName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[FEATURED_CONTENT_NATIVE_DASHBOARD]'
        );
        $request = (new GetFeaturedContentNativeDashboardRequest())->setName($formattedName);
        $response = $gapicClient->getFeaturedContentNativeDashboardAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.chronicle.v1.FeaturedContentNativeDashboardService/GetFeaturedContentNativeDashboard',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
