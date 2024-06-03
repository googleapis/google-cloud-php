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

namespace Google\Shopping\Css\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use Google\Shopping\Css\V1\AccountLabel;
use Google\Shopping\Css\V1\Client\AccountLabelsServiceClient;
use Google\Shopping\Css\V1\CreateAccountLabelRequest;
use Google\Shopping\Css\V1\DeleteAccountLabelRequest;
use Google\Shopping\Css\V1\ListAccountLabelsRequest;
use Google\Shopping\Css\V1\ListAccountLabelsResponse;
use Google\Shopping\Css\V1\UpdateAccountLabelRequest;
use stdClass;

/**
 * @group css
 *
 * @group gapic
 */
class AccountLabelsServiceClientTest extends GeneratedTest
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

    /** @return AccountLabelsServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AccountLabelsServiceClient($options);
    }

    /** @test */
    public function createAccountLabelTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $labelId = 1959256506;
        $accountId = 803333011;
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new AccountLabel();
        $expectedResponse->setName($name);
        $expectedResponse->setLabelId($labelId);
        $expectedResponse->setAccountId($accountId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $accountLabel = new AccountLabel();
        $request = (new CreateAccountLabelRequest())
            ->setParent($formattedParent)
            ->setAccountLabel($accountLabel);
        $response = $gapicClient->createAccountLabel($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.css.v1.AccountLabelsService/CreateAccountLabel', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAccountLabel();
        $this->assertProtobufEquals($accountLabel, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createAccountLabelExceptionTest()
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
        $accountLabel = new AccountLabel();
        $request = (new CreateAccountLabelRequest())
            ->setParent($formattedParent)
            ->setAccountLabel($accountLabel);
        try {
            $gapicClient->createAccountLabel($request);
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
    public function deleteAccountLabelTest()
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
        $formattedName = $gapicClient->accountLabelName('[ACCOUNT]', '[LABEL]');
        $request = (new DeleteAccountLabelRequest())
            ->setName($formattedName);
        $gapicClient->deleteAccountLabel($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.css.v1.AccountLabelsService/DeleteAccountLabel', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteAccountLabelExceptionTest()
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
        $formattedName = $gapicClient->accountLabelName('[ACCOUNT]', '[LABEL]');
        $request = (new DeleteAccountLabelRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteAccountLabel($request);
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
    public function listAccountLabelsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $accountLabelsElement = new AccountLabel();
        $accountLabels = [
            $accountLabelsElement,
        ];
        $expectedResponse = new ListAccountLabelsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAccountLabels($accountLabels);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $request = (new ListAccountLabelsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listAccountLabels($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAccountLabels()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.css.v1.AccountLabelsService/ListAccountLabels', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAccountLabelsExceptionTest()
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
        $request = (new ListAccountLabelsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listAccountLabels($request);
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
    public function updateAccountLabelTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $labelId = 1959256506;
        $accountId = 803333011;
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new AccountLabel();
        $expectedResponse->setName($name);
        $expectedResponse->setLabelId($labelId);
        $expectedResponse->setAccountId($accountId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $accountLabel = new AccountLabel();
        $request = (new UpdateAccountLabelRequest())
            ->setAccountLabel($accountLabel);
        $response = $gapicClient->updateAccountLabel($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.css.v1.AccountLabelsService/UpdateAccountLabel', $actualFuncCall);
        $actualValue = $actualRequestObject->getAccountLabel();
        $this->assertProtobufEquals($accountLabel, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateAccountLabelExceptionTest()
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
        $accountLabel = new AccountLabel();
        $request = (new UpdateAccountLabelRequest())
            ->setAccountLabel($accountLabel);
        try {
            $gapicClient->updateAccountLabel($request);
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
    public function createAccountLabelAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $labelId = 1959256506;
        $accountId = 803333011;
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new AccountLabel();
        $expectedResponse->setName($name);
        $expectedResponse->setLabelId($labelId);
        $expectedResponse->setAccountId($accountId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $accountLabel = new AccountLabel();
        $request = (new CreateAccountLabelRequest())
            ->setParent($formattedParent)
            ->setAccountLabel($accountLabel);
        $response = $gapicClient->createAccountLabelAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.css.v1.AccountLabelsService/CreateAccountLabel', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAccountLabel();
        $this->assertProtobufEquals($accountLabel, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
