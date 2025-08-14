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
use Google\Rpc\Code;
use Google\Shopping\Merchant\Accounts\V1\Client\LfpProvidersServiceClient;
use Google\Shopping\Merchant\Accounts\V1\FindLfpProvidersRequest;
use Google\Shopping\Merchant\Accounts\V1\FindLfpProvidersResponse;
use Google\Shopping\Merchant\Accounts\V1\LfpProvider;
use Google\Shopping\Merchant\Accounts\V1\LinkLfpProviderRequest;
use Google\Shopping\Merchant\Accounts\V1\LinkLfpProviderResponse;
use stdClass;

/**
 * @group accounts
 *
 * @group gapic
 */
class LfpProvidersServiceClientTest extends GeneratedTest
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

    /** @return LfpProvidersServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new LfpProvidersServiceClient($options);
    }

    /** @test */
    public function findLfpProvidersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $lfpProvidersElement = new LfpProvider();
        $lfpProviders = [$lfpProvidersElement];
        $expectedResponse = new FindLfpProvidersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setLfpProviders($lfpProviders);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->omnichannelSettingName('[ACCOUNT]', '[OMNICHANNEL_SETTING]');
        $request = (new FindLfpProvidersRequest())->setParent($formattedParent);
        $response = $gapicClient->findLfpProviders($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getLfpProviders()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1.LfpProvidersService/FindLfpProviders',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function findLfpProvidersExceptionTest()
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
        $formattedParent = $gapicClient->omnichannelSettingName('[ACCOUNT]', '[OMNICHANNEL_SETTING]');
        $request = (new FindLfpProvidersRequest())->setParent($formattedParent);
        try {
            $gapicClient->findLfpProviders($request);
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
    public function linkLfpProviderTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new LinkLfpProviderResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->lfpProviderName('[ACCOUNT]', '[OMNICHANNEL_SETTING]', '[LFP_PROVIDER]');
        $externalAccountId = 'externalAccountId-1800056479';
        $request = (new LinkLfpProviderRequest())->setName($formattedName)->setExternalAccountId($externalAccountId);
        $response = $gapicClient->linkLfpProvider($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1.LfpProvidersService/LinkLfpProvider', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getExternalAccountId();
        $this->assertProtobufEquals($externalAccountId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function linkLfpProviderExceptionTest()
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
        $formattedName = $gapicClient->lfpProviderName('[ACCOUNT]', '[OMNICHANNEL_SETTING]', '[LFP_PROVIDER]');
        $externalAccountId = 'externalAccountId-1800056479';
        $request = (new LinkLfpProviderRequest())->setName($formattedName)->setExternalAccountId($externalAccountId);
        try {
            $gapicClient->linkLfpProvider($request);
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
    public function findLfpProvidersAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $lfpProvidersElement = new LfpProvider();
        $lfpProviders = [$lfpProvidersElement];
        $expectedResponse = new FindLfpProvidersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setLfpProviders($lfpProviders);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->omnichannelSettingName('[ACCOUNT]', '[OMNICHANNEL_SETTING]');
        $request = (new FindLfpProvidersRequest())->setParent($formattedParent);
        $response = $gapicClient->findLfpProvidersAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getLfpProviders()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.accounts.v1.LfpProvidersService/FindLfpProviders',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
