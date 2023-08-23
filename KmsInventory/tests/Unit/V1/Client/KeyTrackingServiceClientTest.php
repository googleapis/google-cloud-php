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

namespace Google\Cloud\Kms\Inventory\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Kms\Inventory\V1\Client\KeyTrackingServiceClient;
use Google\Cloud\Kms\Inventory\V1\GetProtectedResourcesSummaryRequest;
use Google\Cloud\Kms\Inventory\V1\ProtectedResource;
use Google\Cloud\Kms\Inventory\V1\ProtectedResourcesSummary;
use Google\Cloud\Kms\Inventory\V1\SearchProtectedResourcesRequest;
use Google\Cloud\Kms\Inventory\V1\SearchProtectedResourcesResponse;
use Google\Rpc\Code;
use stdClass;

/**
 * @group inventory
 *
 * @group gapic
 */
class KeyTrackingServiceClientTest extends GeneratedTest
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

    /** @return KeyTrackingServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new KeyTrackingServiceClient($options);
    }

    /** @test */
    public function getProtectedResourcesSummaryTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $resourceCount = 287552926;
        $projectCount = 953448343;
        $expectedResponse = new ProtectedResourcesSummary();
        $expectedResponse->setName($name2);
        $expectedResponse->setResourceCount($resourceCount);
        $expectedResponse->setProjectCount($projectCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->protectedResourcesSummaryName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
        $request = (new GetProtectedResourcesSummaryRequest())
            ->setName($formattedName);
        $response = $gapicClient->getProtectedResourcesSummary($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.inventory.v1.KeyTrackingService/GetProtectedResourcesSummary', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getProtectedResourcesSummaryExceptionTest()
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
        $formattedName = $gapicClient->protectedResourcesSummaryName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
        $request = (new GetProtectedResourcesSummaryRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getProtectedResourcesSummary($request);
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
    public function searchProtectedResourcesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $protectedResourcesElement = new ProtectedResource();
        $protectedResources = [
            $protectedResourcesElement,
        ];
        $expectedResponse = new SearchProtectedResourcesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setProtectedResources($protectedResources);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedScope = $gapicClient->organizationName('[ORGANIZATION]');
        $cryptoKey = 'cryptoKey-1992067615';
        $request = (new SearchProtectedResourcesRequest())
            ->setScope($formattedScope)
            ->setCryptoKey($cryptoKey);
        $response = $gapicClient->searchProtectedResources($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getProtectedResources()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.inventory.v1.KeyTrackingService/SearchProtectedResources', $actualFuncCall);
        $actualValue = $actualRequestObject->getScope();
        $this->assertProtobufEquals($formattedScope, $actualValue);
        $actualValue = $actualRequestObject->getCryptoKey();
        $this->assertProtobufEquals($cryptoKey, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchProtectedResourcesExceptionTest()
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
        $formattedScope = $gapicClient->organizationName('[ORGANIZATION]');
        $cryptoKey = 'cryptoKey-1992067615';
        $request = (new SearchProtectedResourcesRequest())
            ->setScope($formattedScope)
            ->setCryptoKey($cryptoKey);
        try {
            $gapicClient->searchProtectedResources($request);
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
    public function getProtectedResourcesSummaryAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $resourceCount = 287552926;
        $projectCount = 953448343;
        $expectedResponse = new ProtectedResourcesSummary();
        $expectedResponse->setName($name2);
        $expectedResponse->setResourceCount($resourceCount);
        $expectedResponse->setProjectCount($projectCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->protectedResourcesSummaryName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
        $request = (new GetProtectedResourcesSummaryRequest())
            ->setName($formattedName);
        $response = $gapicClient->getProtectedResourcesSummaryAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.kms.inventory.v1.KeyTrackingService/GetProtectedResourcesSummary', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
