<?php
/*
 * Copyright 2024 Google LLC
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

namespace Google\Ads\AdManager\Tests\Unit\V1\Client;

use Google\Ads\AdManager\V1\Client\TaxonomyCategoryServiceClient;
use Google\Ads\AdManager\V1\GetTaxonomyCategoryRequest;
use Google\Ads\AdManager\V1\ListTaxonomyCategoriesRequest;
use Google\Ads\AdManager\V1\ListTaxonomyCategoriesResponse;
use Google\Ads\AdManager\V1\TaxonomyCategory;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Rpc\Code;
use stdClass;

/**
 * @group admanager
 *
 * @group gapic
 */
class TaxonomyCategoryServiceClientTest extends GeneratedTest
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

    /** @return TaxonomyCategoryServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new TaxonomyCategoryServiceClient($options);
    }

    /** @test */
    public function getTaxonomyCategoryTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $taxonomyCategoryId = 28298254;
        $displayName = 'displayName1615086568';
        $groupingOnly = true;
        $parentTaxonomyCategoryId = 1790260093;
        $expectedResponse = new TaxonomyCategory();
        $expectedResponse->setName($name2);
        $expectedResponse->setTaxonomyCategoryId($taxonomyCategoryId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setGroupingOnly($groupingOnly);
        $expectedResponse->setParentTaxonomyCategoryId($parentTaxonomyCategoryId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->taxonomyCategoryName('[NETWORK_CODE]', '[TAXONOMY_CATEGORY]');
        $request = (new GetTaxonomyCategoryRequest())->setName($formattedName);
        $response = $gapicClient->getTaxonomyCategory($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.TaxonomyCategoryService/GetTaxonomyCategory', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTaxonomyCategoryExceptionTest()
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
        $formattedName = $gapicClient->taxonomyCategoryName('[NETWORK_CODE]', '[TAXONOMY_CATEGORY]');
        $request = (new GetTaxonomyCategoryRequest())->setName($formattedName);
        try {
            $gapicClient->getTaxonomyCategory($request);
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
    public function listTaxonomyCategoriesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $taxonomyCategoriesElement = new TaxonomyCategory();
        $taxonomyCategories = [$taxonomyCategoriesElement];
        $expectedResponse = new ListTaxonomyCategoriesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setTaxonomyCategories($taxonomyCategories);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListTaxonomyCategoriesRequest())->setParent($formattedParent);
        $response = $gapicClient->listTaxonomyCategories($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTaxonomyCategories()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.TaxonomyCategoryService/ListTaxonomyCategories', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTaxonomyCategoriesExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListTaxonomyCategoriesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listTaxonomyCategories($request);
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
    public function getTaxonomyCategoryAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $taxonomyCategoryId = 28298254;
        $displayName = 'displayName1615086568';
        $groupingOnly = true;
        $parentTaxonomyCategoryId = 1790260093;
        $expectedResponse = new TaxonomyCategory();
        $expectedResponse->setName($name2);
        $expectedResponse->setTaxonomyCategoryId($taxonomyCategoryId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setGroupingOnly($groupingOnly);
        $expectedResponse->setParentTaxonomyCategoryId($parentTaxonomyCategoryId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->taxonomyCategoryName('[NETWORK_CODE]', '[TAXONOMY_CATEGORY]');
        $request = (new GetTaxonomyCategoryRequest())->setName($formattedName);
        $response = $gapicClient->getTaxonomyCategoryAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.TaxonomyCategoryService/GetTaxonomyCategory', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
