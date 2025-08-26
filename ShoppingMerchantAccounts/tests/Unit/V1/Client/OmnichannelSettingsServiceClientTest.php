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

namespace Google\Shopping\Merchant\Accounts\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\FieldMask;
use Google\Rpc\Code;
use Google\Shopping\Merchant\Accounts\V1\Client\OmnichannelSettingsServiceClient;
use Google\Shopping\Merchant\Accounts\V1\CreateOmnichannelSettingRequest;
use Google\Shopping\Merchant\Accounts\V1\GetOmnichannelSettingRequest;
use Google\Shopping\Merchant\Accounts\V1\ListOmnichannelSettingsRequest;
use Google\Shopping\Merchant\Accounts\V1\ListOmnichannelSettingsResponse;
use Google\Shopping\Merchant\Accounts\V1\OmnichannelSetting;
use Google\Shopping\Merchant\Accounts\V1\OmnichannelSetting\LsfType;
use Google\Shopping\Merchant\Accounts\V1\RequestInventoryVerificationRequest;
use Google\Shopping\Merchant\Accounts\V1\RequestInventoryVerificationResponse;
use Google\Shopping\Merchant\Accounts\V1\UpdateOmnichannelSettingRequest;
use stdClass;

/**
 * @group accounts
 *
 * @group gapic
 */
class OmnichannelSettingsServiceClientTest extends GeneratedTest
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

    /** @return OmnichannelSettingsServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new OmnichannelSettingsServiceClient($options);
    }

    /** @test */
    public function createOmnichannelSettingTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $regionCode = 'regionCode-1566082984';
        $expectedResponse = new OmnichannelSetting();
        $expectedResponse->setName($name);
        $expectedResponse->setRegionCode($regionCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $omnichannelSetting = new OmnichannelSetting();
        $omnichannelSettingRegionCode = 'omnichannelSettingRegionCode-1450008633';
        $omnichannelSetting->setRegionCode($omnichannelSettingRegionCode);
        $omnichannelSettingLsfType = LsfType::LSF_TYPE_UNSPECIFIED;
        $omnichannelSetting->setLsfType($omnichannelSettingLsfType);
        $request = (new CreateOmnichannelSettingRequest())
            ->setParent($formattedParent)
            ->setOmnichannelSetting($omnichannelSetting);
        $response = $gapicClient->createOmnichannelSetting($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1.OmnichannelSettingsService/CreateOmnichannelSetting',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getOmnichannelSetting();
        $this->assertProtobufEquals($omnichannelSetting, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createOmnichannelSettingExceptionTest()
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
        $omnichannelSetting = new OmnichannelSetting();
        $omnichannelSettingRegionCode = 'omnichannelSettingRegionCode-1450008633';
        $omnichannelSetting->setRegionCode($omnichannelSettingRegionCode);
        $omnichannelSettingLsfType = LsfType::LSF_TYPE_UNSPECIFIED;
        $omnichannelSetting->setLsfType($omnichannelSettingLsfType);
        $request = (new CreateOmnichannelSettingRequest())
            ->setParent($formattedParent)
            ->setOmnichannelSetting($omnichannelSetting);
        try {
            $gapicClient->createOmnichannelSetting($request);
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
    public function getOmnichannelSettingTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $regionCode = 'regionCode-1566082984';
        $expectedResponse = new OmnichannelSetting();
        $expectedResponse->setName($name2);
        $expectedResponse->setRegionCode($regionCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->omnichannelSettingName('[ACCOUNT]', '[OMNICHANNEL_SETTING]');
        $request = (new GetOmnichannelSettingRequest())->setName($formattedName);
        $response = $gapicClient->getOmnichannelSetting($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1.OmnichannelSettingsService/GetOmnichannelSetting',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getOmnichannelSettingExceptionTest()
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
        $formattedName = $gapicClient->omnichannelSettingName('[ACCOUNT]', '[OMNICHANNEL_SETTING]');
        $request = (new GetOmnichannelSettingRequest())->setName($formattedName);
        try {
            $gapicClient->getOmnichannelSetting($request);
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
    public function listOmnichannelSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $omnichannelSettingsElement = new OmnichannelSetting();
        $omnichannelSettings = [$omnichannelSettingsElement];
        $expectedResponse = new ListOmnichannelSettingsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setOmnichannelSettings($omnichannelSettings);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $request = (new ListOmnichannelSettingsRequest())->setParent($formattedParent);
        $response = $gapicClient->listOmnichannelSettings($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getOmnichannelSettings()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1.OmnichannelSettingsService/ListOmnichannelSettings',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listOmnichannelSettingsExceptionTest()
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
        $request = (new ListOmnichannelSettingsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listOmnichannelSettings($request);
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
    public function requestInventoryVerificationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new RequestInventoryVerificationResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->omnichannelSettingName('[ACCOUNT]', '[OMNICHANNEL_SETTING]');
        $request = (new RequestInventoryVerificationRequest())->setName($formattedName);
        $response = $gapicClient->requestInventoryVerification($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1.OmnichannelSettingsService/RequestInventoryVerification',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function requestInventoryVerificationExceptionTest()
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
        $formattedName = $gapicClient->omnichannelSettingName('[ACCOUNT]', '[OMNICHANNEL_SETTING]');
        $request = (new RequestInventoryVerificationRequest())->setName($formattedName);
        try {
            $gapicClient->requestInventoryVerification($request);
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
    public function updateOmnichannelSettingTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $regionCode = 'regionCode-1566082984';
        $expectedResponse = new OmnichannelSetting();
        $expectedResponse->setName($name);
        $expectedResponse->setRegionCode($regionCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $omnichannelSetting = new OmnichannelSetting();
        $omnichannelSettingRegionCode = 'omnichannelSettingRegionCode-1450008633';
        $omnichannelSetting->setRegionCode($omnichannelSettingRegionCode);
        $omnichannelSettingLsfType = LsfType::LSF_TYPE_UNSPECIFIED;
        $omnichannelSetting->setLsfType($omnichannelSettingLsfType);
        $updateMask = new FieldMask();
        $request = (new UpdateOmnichannelSettingRequest())
            ->setOmnichannelSetting($omnichannelSetting)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateOmnichannelSetting($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1.OmnichannelSettingsService/UpdateOmnichannelSetting',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getOmnichannelSetting();
        $this->assertProtobufEquals($omnichannelSetting, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateOmnichannelSettingExceptionTest()
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
        $omnichannelSetting = new OmnichannelSetting();
        $omnichannelSettingRegionCode = 'omnichannelSettingRegionCode-1450008633';
        $omnichannelSetting->setRegionCode($omnichannelSettingRegionCode);
        $omnichannelSettingLsfType = LsfType::LSF_TYPE_UNSPECIFIED;
        $omnichannelSetting->setLsfType($omnichannelSettingLsfType);
        $updateMask = new FieldMask();
        $request = (new UpdateOmnichannelSettingRequest())
            ->setOmnichannelSetting($omnichannelSetting)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateOmnichannelSetting($request);
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
    public function createOmnichannelSettingAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $regionCode = 'regionCode-1566082984';
        $expectedResponse = new OmnichannelSetting();
        $expectedResponse->setName($name);
        $expectedResponse->setRegionCode($regionCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $omnichannelSetting = new OmnichannelSetting();
        $omnichannelSettingRegionCode = 'omnichannelSettingRegionCode-1450008633';
        $omnichannelSetting->setRegionCode($omnichannelSettingRegionCode);
        $omnichannelSettingLsfType = LsfType::LSF_TYPE_UNSPECIFIED;
        $omnichannelSetting->setLsfType($omnichannelSettingLsfType);
        $request = (new CreateOmnichannelSettingRequest())
            ->setParent($formattedParent)
            ->setOmnichannelSetting($omnichannelSetting);
        $response = $gapicClient->createOmnichannelSettingAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1.OmnichannelSettingsService/CreateOmnichannelSetting',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getOmnichannelSetting();
        $this->assertProtobufEquals($omnichannelSetting, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
