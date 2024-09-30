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
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use Google\Shopping\Merchant\Accounts\V1beta\AcceptTermsOfServiceRequest;
use Google\Shopping\Merchant\Accounts\V1beta\Client\TermsOfServiceServiceClient;
use Google\Shopping\Merchant\Accounts\V1beta\GetTermsOfServiceRequest;
use Google\Shopping\Merchant\Accounts\V1beta\RetrieveLatestTermsOfServiceRequest;
use Google\Shopping\Merchant\Accounts\V1beta\TermsOfService;
use Google\Shopping\Merchant\Accounts\V1beta\TermsOfServiceKind;
use stdClass;

/**
 * @group accounts
 *
 * @group gapic
 */
class TermsOfServiceServiceClientTest extends GeneratedTest
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

    /** @return TermsOfServiceServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new TermsOfServiceServiceClient($options);
    }

    /** @test */
    public function acceptTermsOfServiceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->termsOfServiceName('[VERSION]');
        $formattedAccount = $gapicClient->accountName('[ACCOUNT]');
        $regionCode = 'regionCode-1566082984';
        $request = (new AcceptTermsOfServiceRequest())
            ->setName($formattedName)
            ->setAccount($formattedAccount)
            ->setRegionCode($regionCode);
        $gapicClient->acceptTermsOfService($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1beta.TermsOfServiceService/AcceptTermsOfService', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getAccount();
        $this->assertProtobufEquals($formattedAccount, $actualValue);
        $actualValue = $actualRequestObject->getRegionCode();
        $this->assertProtobufEquals($regionCode, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function acceptTermsOfServiceExceptionTest()
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
        $formattedName = $gapicClient->termsOfServiceName('[VERSION]');
        $formattedAccount = $gapicClient->accountName('[ACCOUNT]');
        $regionCode = 'regionCode-1566082984';
        $request = (new AcceptTermsOfServiceRequest())
            ->setName($formattedName)
            ->setAccount($formattedAccount)
            ->setRegionCode($regionCode);
        try {
            $gapicClient->acceptTermsOfService($request);
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
    public function getTermsOfServiceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $regionCode = 'regionCode-1566082984';
        $fileUri = 'fileUri-735196119';
        $external = false;
        $expectedResponse = new TermsOfService();
        $expectedResponse->setName($name2);
        $expectedResponse->setRegionCode($regionCode);
        $expectedResponse->setFileUri($fileUri);
        $expectedResponse->setExternal($external);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->termsOfServiceName('[VERSION]');
        $request = (new GetTermsOfServiceRequest())
            ->setName($formattedName);
        $response = $gapicClient->getTermsOfService($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1beta.TermsOfServiceService/GetTermsOfService', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTermsOfServiceExceptionTest()
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
        $formattedName = $gapicClient->termsOfServiceName('[VERSION]');
        $request = (new GetTermsOfServiceRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getTermsOfService($request);
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
    public function retrieveLatestTermsOfServiceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $regionCode2 = 'regionCode2-1767191029';
        $fileUri = 'fileUri-735196119';
        $external = false;
        $expectedResponse = new TermsOfService();
        $expectedResponse->setName($name);
        $expectedResponse->setRegionCode($regionCode2);
        $expectedResponse->setFileUri($fileUri);
        $expectedResponse->setExternal($external);
        $transport->addResponse($expectedResponse);
        // Mock request
        $regionCode = 'regionCode-1566082984';
        $kind = TermsOfServiceKind::TERMS_OF_SERVICE_KIND_UNSPECIFIED;
        $request = (new RetrieveLatestTermsOfServiceRequest())
            ->setRegionCode($regionCode)
            ->setKind($kind);
        $response = $gapicClient->retrieveLatestTermsOfService($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1beta.TermsOfServiceService/RetrieveLatestTermsOfService', $actualFuncCall);
        $actualValue = $actualRequestObject->getRegionCode();
        $this->assertProtobufEquals($regionCode, $actualValue);
        $actualValue = $actualRequestObject->getKind();
        $this->assertProtobufEquals($kind, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function retrieveLatestTermsOfServiceExceptionTest()
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
        $regionCode = 'regionCode-1566082984';
        $kind = TermsOfServiceKind::TERMS_OF_SERVICE_KIND_UNSPECIFIED;
        $request = (new RetrieveLatestTermsOfServiceRequest())
            ->setRegionCode($regionCode)
            ->setKind($kind);
        try {
            $gapicClient->retrieveLatestTermsOfService($request);
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
    public function acceptTermsOfServiceAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->termsOfServiceName('[VERSION]');
        $formattedAccount = $gapicClient->accountName('[ACCOUNT]');
        $regionCode = 'regionCode-1566082984';
        $request = (new AcceptTermsOfServiceRequest())
            ->setName($formattedName)
            ->setAccount($formattedAccount)
            ->setRegionCode($regionCode);
        $gapicClient->acceptTermsOfServiceAsync($request)->wait();
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1beta.TermsOfServiceService/AcceptTermsOfService', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getAccount();
        $this->assertProtobufEquals($formattedAccount, $actualValue);
        $actualValue = $actualRequestObject->getRegionCode();
        $this->assertProtobufEquals($regionCode, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
