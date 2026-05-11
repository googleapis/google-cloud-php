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

namespace Google\Ads\AdManager\Tests\Unit\V1\Client;

use Google\Ads\AdManager\V1\Client\RichMediaAdsCompanyServiceClient;
use Google\Ads\AdManager\V1\GetRichMediaAdsCompanyRequest;
use Google\Ads\AdManager\V1\ListRichMediaAdsCompaniesRequest;
use Google\Ads\AdManager\V1\ListRichMediaAdsCompaniesResponse;
use Google\Ads\AdManager\V1\RichMediaAdsCompany;
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
class RichMediaAdsCompanyServiceClientTest extends GeneratedTest
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

    /** @return RichMediaAdsCompanyServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new RichMediaAdsCompanyServiceClient($options);
    }

    /** @test */
    public function getRichMediaAdsCompanyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $policyUrl = 'policyUrl1593880802';
        $companyGvlId = 455823041;
        $expectedResponse = new RichMediaAdsCompany();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setPolicyUrl($policyUrl);
        $expectedResponse->setCompanyGvlId($companyGvlId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->richMediaAdsCompanyName('[NETWORK_CODE]', '[RICH_MEDIA_ADS_COMPANY]');
        $request = (new GetRichMediaAdsCompanyRequest())
            ->setName($formattedName);
        $response = $gapicClient->getRichMediaAdsCompany($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.RichMediaAdsCompanyService/GetRichMediaAdsCompany', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getRichMediaAdsCompanyExceptionTest()
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
        $formattedName = $gapicClient->richMediaAdsCompanyName('[NETWORK_CODE]', '[RICH_MEDIA_ADS_COMPANY]');
        $request = (new GetRichMediaAdsCompanyRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getRichMediaAdsCompany($request);
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
    public function listRichMediaAdsCompaniesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $richMediaAdsCompaniesElement = new RichMediaAdsCompany();
        $richMediaAdsCompanies = [
            $richMediaAdsCompaniesElement,
        ];
        $expectedResponse = new ListRichMediaAdsCompaniesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setRichMediaAdsCompanies($richMediaAdsCompanies);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListRichMediaAdsCompaniesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listRichMediaAdsCompanies($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getRichMediaAdsCompanies()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.RichMediaAdsCompanyService/ListRichMediaAdsCompanies', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listRichMediaAdsCompaniesExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListRichMediaAdsCompaniesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listRichMediaAdsCompanies($request);
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
    public function getRichMediaAdsCompanyAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $policyUrl = 'policyUrl1593880802';
        $companyGvlId = 455823041;
        $expectedResponse = new RichMediaAdsCompany();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setPolicyUrl($policyUrl);
        $expectedResponse->setCompanyGvlId($companyGvlId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->richMediaAdsCompanyName('[NETWORK_CODE]', '[RICH_MEDIA_ADS_COMPANY]');
        $request = (new GetRichMediaAdsCompanyRequest())
            ->setName($formattedName);
        $response = $gapicClient->getRichMediaAdsCompanyAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.RichMediaAdsCompanyService/GetRichMediaAdsCompany', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
