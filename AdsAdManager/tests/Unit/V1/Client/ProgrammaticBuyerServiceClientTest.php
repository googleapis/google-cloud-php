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

namespace Google\Ads\AdManager\Tests\Unit\V1\Client;

use Google\Ads\AdManager\V1\Client\ProgrammaticBuyerServiceClient;
use Google\Ads\AdManager\V1\GetProgrammaticBuyerRequest;
use Google\Ads\AdManager\V1\ListProgrammaticBuyersRequest;
use Google\Ads\AdManager\V1\ListProgrammaticBuyersResponse;
use Google\Ads\AdManager\V1\ProgrammaticBuyer;
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
class ProgrammaticBuyerServiceClientTest extends GeneratedTest
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

    /** @return ProgrammaticBuyerServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new ProgrammaticBuyerServiceClient($options);
    }

    /** @test */
    public function getProgrammaticBuyerTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $buyerAccountId = 994282887;
        $displayName = 'displayName1615086568';
        $parentAccountId = 325829854;
        $partnerClientId = 'partnerClientId667444056';
        $agency = false;
        $preferredDealsEnabled = false;
        $programmaticGuaranteedEnabled = false;
        $expectedResponse = new ProgrammaticBuyer();
        $expectedResponse->setName($name2);
        $expectedResponse->setBuyerAccountId($buyerAccountId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setParentAccountId($parentAccountId);
        $expectedResponse->setPartnerClientId($partnerClientId);
        $expectedResponse->setAgency($agency);
        $expectedResponse->setPreferredDealsEnabled($preferredDealsEnabled);
        $expectedResponse->setProgrammaticGuaranteedEnabled($programmaticGuaranteedEnabled);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->programmaticBuyerName('[NETWORK_CODE]', '[PROGRAMMATIC_BUYER]');
        $request = (new GetProgrammaticBuyerRequest())->setName($formattedName);
        $response = $gapicClient->getProgrammaticBuyer($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ProgrammaticBuyerService/GetProgrammaticBuyer', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getProgrammaticBuyerExceptionTest()
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
        $formattedName = $gapicClient->programmaticBuyerName('[NETWORK_CODE]', '[PROGRAMMATIC_BUYER]');
        $request = (new GetProgrammaticBuyerRequest())->setName($formattedName);
        try {
            $gapicClient->getProgrammaticBuyer($request);
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
    public function listProgrammaticBuyersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $programmaticBuyersElement = new ProgrammaticBuyer();
        $programmaticBuyers = [$programmaticBuyersElement];
        $expectedResponse = new ListProgrammaticBuyersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setProgrammaticBuyers($programmaticBuyers);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListProgrammaticBuyersRequest())->setParent($formattedParent);
        $response = $gapicClient->listProgrammaticBuyers($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getProgrammaticBuyers()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ProgrammaticBuyerService/ListProgrammaticBuyers', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listProgrammaticBuyersExceptionTest()
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
        $request = (new ListProgrammaticBuyersRequest())->setParent($formattedParent);
        try {
            $gapicClient->listProgrammaticBuyers($request);
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
    public function getProgrammaticBuyerAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $buyerAccountId = 994282887;
        $displayName = 'displayName1615086568';
        $parentAccountId = 325829854;
        $partnerClientId = 'partnerClientId667444056';
        $agency = false;
        $preferredDealsEnabled = false;
        $programmaticGuaranteedEnabled = false;
        $expectedResponse = new ProgrammaticBuyer();
        $expectedResponse->setName($name2);
        $expectedResponse->setBuyerAccountId($buyerAccountId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setParentAccountId($parentAccountId);
        $expectedResponse->setPartnerClientId($partnerClientId);
        $expectedResponse->setAgency($agency);
        $expectedResponse->setPreferredDealsEnabled($preferredDealsEnabled);
        $expectedResponse->setProgrammaticGuaranteedEnabled($programmaticGuaranteedEnabled);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->programmaticBuyerName('[NETWORK_CODE]', '[PROGRAMMATIC_BUYER]');
        $request = (new GetProgrammaticBuyerRequest())->setName($formattedName);
        $response = $gapicClient->getProgrammaticBuyerAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ProgrammaticBuyerService/GetProgrammaticBuyer', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
