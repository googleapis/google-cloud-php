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

namespace Google\Cloud\CloudQuotas\Tests\Unit\V1beta\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\CloudQuotas\V1beta\Client\QuotaAdjusterSettingsManagerClient;
use Google\Cloud\CloudQuotas\V1beta\GetQuotaAdjusterSettingsRequest;
use Google\Cloud\CloudQuotas\V1beta\QuotaAdjusterSettings;
use Google\Cloud\CloudQuotas\V1beta\QuotaAdjusterSettings\Enablement;
use Google\Cloud\CloudQuotas\V1beta\UpdateQuotaAdjusterSettingsRequest;
use Google\Rpc\Code;
use stdClass;

/**
 * @group cloudquotas
 *
 * @group gapic
 */
class QuotaAdjusterSettingsManagerClientTest extends GeneratedTest
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

    /** @return QuotaAdjusterSettingsManagerClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new QuotaAdjusterSettingsManagerClient($options);
    }

    /** @test */
    public function getQuotaAdjusterSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $etag = 'etag3123477';
        $expectedResponse = new QuotaAdjusterSettings();
        $expectedResponse->setName($name2);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->quotaAdjusterSettingsName('[PROJECT]', '[LOCATION]');
        $request = (new GetQuotaAdjusterSettingsRequest())->setName($formattedName);
        $response = $gapicClient->getQuotaAdjusterSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.api.cloudquotas.v1beta.QuotaAdjusterSettingsManager/GetQuotaAdjusterSettings',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getQuotaAdjusterSettingsExceptionTest()
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
        $formattedName = $gapicClient->quotaAdjusterSettingsName('[PROJECT]', '[LOCATION]');
        $request = (new GetQuotaAdjusterSettingsRequest())->setName($formattedName);
        try {
            $gapicClient->getQuotaAdjusterSettings($request);
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
    public function updateQuotaAdjusterSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $etag = 'etag3123477';
        $expectedResponse = new QuotaAdjusterSettings();
        $expectedResponse->setName($name);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $quotaAdjusterSettings = new QuotaAdjusterSettings();
        $quotaAdjusterSettingsEnablement = Enablement::ENABLEMENT_UNSPECIFIED;
        $quotaAdjusterSettings->setEnablement($quotaAdjusterSettingsEnablement);
        $request = (new UpdateQuotaAdjusterSettingsRequest())->setQuotaAdjusterSettings($quotaAdjusterSettings);
        $response = $gapicClient->updateQuotaAdjusterSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.api.cloudquotas.v1beta.QuotaAdjusterSettingsManager/UpdateQuotaAdjusterSettings',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getQuotaAdjusterSettings();
        $this->assertProtobufEquals($quotaAdjusterSettings, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateQuotaAdjusterSettingsExceptionTest()
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
        $quotaAdjusterSettings = new QuotaAdjusterSettings();
        $quotaAdjusterSettingsEnablement = Enablement::ENABLEMENT_UNSPECIFIED;
        $quotaAdjusterSettings->setEnablement($quotaAdjusterSettingsEnablement);
        $request = (new UpdateQuotaAdjusterSettingsRequest())->setQuotaAdjusterSettings($quotaAdjusterSettings);
        try {
            $gapicClient->updateQuotaAdjusterSettings($request);
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
    public function getQuotaAdjusterSettingsAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $etag = 'etag3123477';
        $expectedResponse = new QuotaAdjusterSettings();
        $expectedResponse->setName($name2);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->quotaAdjusterSettingsName('[PROJECT]', '[LOCATION]');
        $request = (new GetQuotaAdjusterSettingsRequest())->setName($formattedName);
        $response = $gapicClient->getQuotaAdjusterSettingsAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.api.cloudquotas.v1beta.QuotaAdjusterSettingsManager/GetQuotaAdjusterSettings',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
