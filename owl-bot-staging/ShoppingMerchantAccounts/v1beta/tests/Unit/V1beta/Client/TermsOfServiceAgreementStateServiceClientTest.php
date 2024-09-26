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
use Google\Rpc\Code;
use Google\Shopping\Merchant\Accounts\V1beta\Client\TermsOfServiceAgreementStateServiceClient;
use Google\Shopping\Merchant\Accounts\V1beta\GetTermsOfServiceAgreementStateRequest;
use Google\Shopping\Merchant\Accounts\V1beta\RetrieveForApplicationTermsOfServiceAgreementStateRequest;
use Google\Shopping\Merchant\Accounts\V1beta\TermsOfServiceAgreementState;
use stdClass;

/**
 * @group accounts
 *
 * @group gapic
 */
class TermsOfServiceAgreementStateServiceClientTest extends GeneratedTest
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

    /** @return TermsOfServiceAgreementStateServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new TermsOfServiceAgreementStateServiceClient($options);
    }

    /** @test */
    public function getTermsOfServiceAgreementStateTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $regionCode = 'regionCode-1566082984';
        $expectedResponse = new TermsOfServiceAgreementState();
        $expectedResponse->setName($name2);
        $expectedResponse->setRegionCode($regionCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->termsOfServiceAgreementStateName('[ACCOUNT]', '[IDENTIFIER]');
        $request = (new GetTermsOfServiceAgreementStateRequest())
            ->setName($formattedName);
        $response = $gapicClient->getTermsOfServiceAgreementState($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1beta.TermsOfServiceAgreementStateService/GetTermsOfServiceAgreementState', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTermsOfServiceAgreementStateExceptionTest()
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
        $formattedName = $gapicClient->termsOfServiceAgreementStateName('[ACCOUNT]', '[IDENTIFIER]');
        $request = (new GetTermsOfServiceAgreementStateRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getTermsOfServiceAgreementState($request);
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
    public function retrieveForApplicationTermsOfServiceAgreementStateTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $regionCode = 'regionCode-1566082984';
        $expectedResponse = new TermsOfServiceAgreementState();
        $expectedResponse->setName($name);
        $expectedResponse->setRegionCode($regionCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $request = (new RetrieveForApplicationTermsOfServiceAgreementStateRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->retrieveForApplicationTermsOfServiceAgreementState($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1beta.TermsOfServiceAgreementStateService/RetrieveForApplicationTermsOfServiceAgreementState', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function retrieveForApplicationTermsOfServiceAgreementStateExceptionTest()
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
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $request = (new RetrieveForApplicationTermsOfServiceAgreementStateRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->retrieveForApplicationTermsOfServiceAgreementState($request);
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
    public function getTermsOfServiceAgreementStateAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $regionCode = 'regionCode-1566082984';
        $expectedResponse = new TermsOfServiceAgreementState();
        $expectedResponse->setName($name2);
        $expectedResponse->setRegionCode($regionCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->termsOfServiceAgreementStateName('[ACCOUNT]', '[IDENTIFIER]');
        $request = (new GetTermsOfServiceAgreementStateRequest())
            ->setName($formattedName);
        $response = $gapicClient->getTermsOfServiceAgreementStateAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1beta.TermsOfServiceAgreementStateService/GetTermsOfServiceAgreementState', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
