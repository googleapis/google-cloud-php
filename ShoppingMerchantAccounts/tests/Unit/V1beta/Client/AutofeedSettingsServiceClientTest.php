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

namespace Google\Shopping\Merchant\Accounts\Tests\Unit\V1beta\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\FieldMask;
use Google\Rpc\Code;
use Google\Shopping\Merchant\Accounts\V1beta\AutofeedSettings;
use Google\Shopping\Merchant\Accounts\V1beta\Client\AutofeedSettingsServiceClient;
use Google\Shopping\Merchant\Accounts\V1beta\GetAutofeedSettingsRequest;
use Google\Shopping\Merchant\Accounts\V1beta\UpdateAutofeedSettingsRequest;
use stdClass;

/**
 * @group accounts
 *
 * @group gapic
 */
class AutofeedSettingsServiceClientTest extends GeneratedTest
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

    /** @return AutofeedSettingsServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AutofeedSettingsServiceClient($options);
    }

    /** @test */
    public function getAutofeedSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $enableProducts = true;
        $eligible = false;
        $expectedResponse = new AutofeedSettings();
        $expectedResponse->setName($name2);
        $expectedResponse->setEnableProducts($enableProducts);
        $expectedResponse->setEligible($eligible);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->autofeedSettingsName('[ACCOUNT]');
        $request = (new GetAutofeedSettingsRequest())->setName($formattedName);
        $response = $gapicClient->getAutofeedSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1beta.AutofeedSettingsService/GetAutofeedSettings',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAutofeedSettingsExceptionTest()
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
        $formattedName = $gapicClient->autofeedSettingsName('[ACCOUNT]');
        $request = (new GetAutofeedSettingsRequest())->setName($formattedName);
        try {
            $gapicClient->getAutofeedSettings($request);
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
    public function updateAutofeedSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $enableProducts = true;
        $eligible = false;
        $expectedResponse = new AutofeedSettings();
        $expectedResponse->setName($name);
        $expectedResponse->setEnableProducts($enableProducts);
        $expectedResponse->setEligible($eligible);
        $transport->addResponse($expectedResponse);
        // Mock request
        $autofeedSettings = new AutofeedSettings();
        $autofeedSettingsEnableProducts = false;
        $autofeedSettings->setEnableProducts($autofeedSettingsEnableProducts);
        $updateMask = new FieldMask();
        $request = (new UpdateAutofeedSettingsRequest())
            ->setAutofeedSettings($autofeedSettings)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateAutofeedSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1beta.AutofeedSettingsService/UpdateAutofeedSettings',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getAutofeedSettings();
        $this->assertProtobufEquals($autofeedSettings, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateAutofeedSettingsExceptionTest()
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
        $autofeedSettings = new AutofeedSettings();
        $autofeedSettingsEnableProducts = false;
        $autofeedSettings->setEnableProducts($autofeedSettingsEnableProducts);
        $updateMask = new FieldMask();
        $request = (new UpdateAutofeedSettingsRequest())
            ->setAutofeedSettings($autofeedSettings)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateAutofeedSettings($request);
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
    public function getAutofeedSettingsAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $enableProducts = true;
        $eligible = false;
        $expectedResponse = new AutofeedSettings();
        $expectedResponse->setName($name2);
        $expectedResponse->setEnableProducts($enableProducts);
        $expectedResponse->setEligible($eligible);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->autofeedSettingsName('[ACCOUNT]');
        $request = (new GetAutofeedSettingsRequest())->setName($formattedName);
        $response = $gapicClient->getAutofeedSettingsAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1beta.AutofeedSettingsService/GetAutofeedSettings',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
