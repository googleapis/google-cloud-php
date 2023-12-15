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
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\DiscoveryEngine\V1\Client\SearchServiceClient;
use Google\Cloud\DiscoveryEngine\V1\SearchRequest;
use Google\Cloud\DiscoveryEngine\V1\SearchResponse;
use Google\Cloud\DiscoveryEngine\V1\SearchResponse\SearchResult;
use Google\Rpc\Code;
use stdClass;

/**
 * @group discoveryengine
 *
 * @group gapic
 */
class SearchServiceClientTest extends GeneratedTest
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

    /** @return SearchServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new SearchServiceClient($options);
    }

    /** @test */
    public function searchTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $totalSize = 705419236;
        $attributionToken = 'attributionToken-729411015';
        $redirectUri = 'redirectUri951230089';
        $nextPageToken = '';
        $correctedQuery = 'correctedQuery107869074';
        $resultsElement = new SearchResult();
        $results = [$resultsElement];
        $expectedResponse = new SearchResponse();
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setAttributionToken($attributionToken);
        $expectedResponse->setRedirectUri($redirectUri);
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCorrectedQuery($correctedQuery);
        $expectedResponse->setResults($results);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedServingConfig = $gapicClient->servingConfigName(
            '[PROJECT]',
            '[LOCATION]',
            '[DATA_STORE]',
            '[SERVING_CONFIG]'
        );
        $request = (new SearchRequest())->setServingConfig($formattedServingConfig);
        $response = $gapicClient->search($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getResults()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.SearchService/Search', $actualFuncCall);
        $actualValue = $actualRequestObject->getServingConfig();
        $this->assertProtobufEquals($formattedServingConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchExceptionTest()
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
        $formattedServingConfig = $gapicClient->servingConfigName(
            '[PROJECT]',
            '[LOCATION]',
            '[DATA_STORE]',
            '[SERVING_CONFIG]'
        );
        $request = (new SearchRequest())->setServingConfig($formattedServingConfig);
        try {
            $gapicClient->search($request);
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
    public function searchAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $totalSize = 705419236;
        $attributionToken = 'attributionToken-729411015';
        $redirectUri = 'redirectUri951230089';
        $nextPageToken = '';
        $correctedQuery = 'correctedQuery107869074';
        $resultsElement = new SearchResult();
        $results = [$resultsElement];
        $expectedResponse = new SearchResponse();
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setAttributionToken($attributionToken);
        $expectedResponse->setRedirectUri($redirectUri);
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCorrectedQuery($correctedQuery);
        $expectedResponse->setResults($results);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedServingConfig = $gapicClient->servingConfigName(
            '[PROJECT]',
            '[LOCATION]',
            '[DATA_STORE]',
            '[SERVING_CONFIG]'
        );
        $request = (new SearchRequest())->setServingConfig($formattedServingConfig);
        $response = $gapicClient->searchAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getResults()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.SearchService/Search', $actualFuncCall);
        $actualValue = $actualRequestObject->getServingConfig();
        $this->assertProtobufEquals($formattedServingConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
