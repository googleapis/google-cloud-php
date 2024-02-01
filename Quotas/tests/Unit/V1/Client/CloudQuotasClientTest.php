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

namespace Google\Cloud\CloudQuotas\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\CloudQuotas\V1\Client\CloudQuotasClient;
use Google\Cloud\CloudQuotas\V1\CreateQuotaPreferenceRequest;
use Google\Cloud\CloudQuotas\V1\GetQuotaInfoRequest;
use Google\Cloud\CloudQuotas\V1\GetQuotaPreferenceRequest;
use Google\Cloud\CloudQuotas\V1\ListQuotaInfosRequest;
use Google\Cloud\CloudQuotas\V1\ListQuotaInfosResponse;
use Google\Cloud\CloudQuotas\V1\ListQuotaPreferencesRequest;
use Google\Cloud\CloudQuotas\V1\ListQuotaPreferencesResponse;
use Google\Cloud\CloudQuotas\V1\QuotaInfo;
use Google\Cloud\CloudQuotas\V1\QuotaPreference;
use Google\Cloud\CloudQuotas\V1\UpdateQuotaPreferenceRequest;
use Google\Rpc\Code;
use stdClass;

/**
 * @group cloudquotas
 *
 * @group gapic
 */
class CloudQuotasClientTest extends GeneratedTest
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

    /** @return CloudQuotasClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new CloudQuotasClient($options);
    }

    /** @test */
    public function createQuotaPreferenceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $etag = 'etag3123477';
        $service = 'service1984153269';
        $quotaId = 'quotaId-879230910';
        $reconciling = false;
        $justification = 'justification1864993522';
        $contactEmail = 'contactEmail947010237';
        $expectedResponse = new QuotaPreference();
        $expectedResponse->setName($name);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setService($service);
        $expectedResponse->setQuotaId($quotaId);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setJustification($justification);
        $expectedResponse->setContactEmail($contactEmail);
        $transport->addResponse($expectedResponse);
        $request = new CreateQuotaPreferenceRequest();
        $response = $gapicClient->createQuotaPreference($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.api.cloudquotas.v1.CloudQuotas/CreateQuotaPreference', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createQuotaPreferenceExceptionTest()
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
        $request = new CreateQuotaPreferenceRequest();
        try {
            $gapicClient->createQuotaPreference($request);
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
    public function getQuotaInfoTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $quotaId = 'quotaId-879230910';
        $metric = 'metric-1077545552';
        $service = 'service1984153269';
        $isPrecise = true;
        $refreshInterval = 'refreshInterval1816824233';
        $metricDisplayName = 'metricDisplayName900625943';
        $quotaDisplayName = 'quotaDisplayName-1616924081';
        $metricUnit = 'metricUnit-1737381197';
        $isFixed = false;
        $isConcurrent = true;
        $serviceRequestQuotaUri = 'serviceRequestQuotaUri-773207445';
        $expectedResponse = new QuotaInfo();
        $expectedResponse->setName($name2);
        $expectedResponse->setQuotaId($quotaId);
        $expectedResponse->setMetric($metric);
        $expectedResponse->setService($service);
        $expectedResponse->setIsPrecise($isPrecise);
        $expectedResponse->setRefreshInterval($refreshInterval);
        $expectedResponse->setMetricDisplayName($metricDisplayName);
        $expectedResponse->setQuotaDisplayName($quotaDisplayName);
        $expectedResponse->setMetricUnit($metricUnit);
        $expectedResponse->setIsFixed($isFixed);
        $expectedResponse->setIsConcurrent($isConcurrent);
        $expectedResponse->setServiceRequestQuotaUri($serviceRequestQuotaUri);
        $transport->addResponse($expectedResponse);
        $request = new GetQuotaInfoRequest();
        $response = $gapicClient->getQuotaInfo($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.api.cloudquotas.v1.CloudQuotas/GetQuotaInfo', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getQuotaInfoExceptionTest()
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
        $request = new GetQuotaInfoRequest();
        try {
            $gapicClient->getQuotaInfo($request);
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
    public function getQuotaPreferenceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $etag = 'etag3123477';
        $service = 'service1984153269';
        $quotaId = 'quotaId-879230910';
        $reconciling = false;
        $justification = 'justification1864993522';
        $contactEmail = 'contactEmail947010237';
        $expectedResponse = new QuotaPreference();
        $expectedResponse->setName($name2);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setService($service);
        $expectedResponse->setQuotaId($quotaId);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setJustification($justification);
        $expectedResponse->setContactEmail($contactEmail);
        $transport->addResponse($expectedResponse);
        $request = new GetQuotaPreferenceRequest();
        $response = $gapicClient->getQuotaPreference($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.api.cloudquotas.v1.CloudQuotas/GetQuotaPreference', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getQuotaPreferenceExceptionTest()
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
        $request = new GetQuotaPreferenceRequest();
        try {
            $gapicClient->getQuotaPreference($request);
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
    public function listQuotaInfosTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $quotaInfosElement = new QuotaInfo();
        $quotaInfos = [$quotaInfosElement];
        $expectedResponse = new ListQuotaInfosResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setQuotaInfos($quotaInfos);
        $transport->addResponse($expectedResponse);
        $request = new ListQuotaInfosRequest();
        $response = $gapicClient->listQuotaInfos($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getQuotaInfos()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.api.cloudquotas.v1.CloudQuotas/ListQuotaInfos', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listQuotaInfosExceptionTest()
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
        $request = new ListQuotaInfosRequest();
        try {
            $gapicClient->listQuotaInfos($request);
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
    public function listQuotaPreferencesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $quotaPreferencesElement = new QuotaPreference();
        $quotaPreferences = [$quotaPreferencesElement];
        $expectedResponse = new ListQuotaPreferencesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setQuotaPreferences($quotaPreferences);
        $transport->addResponse($expectedResponse);
        $request = new ListQuotaPreferencesRequest();
        $response = $gapicClient->listQuotaPreferences($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getQuotaPreferences()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.api.cloudquotas.v1.CloudQuotas/ListQuotaPreferences', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listQuotaPreferencesExceptionTest()
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
        $request = new ListQuotaPreferencesRequest();
        try {
            $gapicClient->listQuotaPreferences($request);
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
    public function updateQuotaPreferenceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $etag = 'etag3123477';
        $service = 'service1984153269';
        $quotaId = 'quotaId-879230910';
        $reconciling = false;
        $justification = 'justification1864993522';
        $contactEmail = 'contactEmail947010237';
        $expectedResponse = new QuotaPreference();
        $expectedResponse->setName($name);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setService($service);
        $expectedResponse->setQuotaId($quotaId);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setJustification($justification);
        $expectedResponse->setContactEmail($contactEmail);
        $transport->addResponse($expectedResponse);
        $request = new UpdateQuotaPreferenceRequest();
        $response = $gapicClient->updateQuotaPreference($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.api.cloudquotas.v1.CloudQuotas/UpdateQuotaPreference', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateQuotaPreferenceExceptionTest()
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
        $request = new UpdateQuotaPreferenceRequest();
        try {
            $gapicClient->updateQuotaPreference($request);
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
    public function createQuotaPreferenceAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $etag = 'etag3123477';
        $service = 'service1984153269';
        $quotaId = 'quotaId-879230910';
        $reconciling = false;
        $justification = 'justification1864993522';
        $contactEmail = 'contactEmail947010237';
        $expectedResponse = new QuotaPreference();
        $expectedResponse->setName($name);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setService($service);
        $expectedResponse->setQuotaId($quotaId);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setJustification($justification);
        $expectedResponse->setContactEmail($contactEmail);
        $transport->addResponse($expectedResponse);
        $request = new CreateQuotaPreferenceRequest();
        $response = $gapicClient->createQuotaPreferenceAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.api.cloudquotas.v1.CloudQuotas/CreateQuotaPreference', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }
}
