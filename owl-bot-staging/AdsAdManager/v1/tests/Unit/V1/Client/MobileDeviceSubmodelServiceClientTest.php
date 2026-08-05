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

use Google\Ads\AdManager\V1\Client\MobileDeviceSubmodelServiceClient;
use Google\Ads\AdManager\V1\GetMobileDeviceSubmodelRequest;
use Google\Ads\AdManager\V1\ListMobileDeviceSubmodelsRequest;
use Google\Ads\AdManager\V1\ListMobileDeviceSubmodelsResponse;
use Google\Ads\AdManager\V1\MobileDeviceSubmodel;
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
class MobileDeviceSubmodelServiceClientTest extends GeneratedTest
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

    /** @return MobileDeviceSubmodelServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new MobileDeviceSubmodelServiceClient($options);
    }

    /** @test */
    public function getMobileDeviceSubmodelTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $mobileDevice = 'mobileDevice-267587437';
        $expectedResponse = new MobileDeviceSubmodel();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setMobileDevice($mobileDevice);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->mobileDeviceSubmodelName('[NETWORK_CODE]', '[MOBILE_DEVICE_SUBMODEL]');
        $request = (new GetMobileDeviceSubmodelRequest())
            ->setName($formattedName);
        $response = $gapicClient->getMobileDeviceSubmodel($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.MobileDeviceSubmodelService/GetMobileDeviceSubmodel', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getMobileDeviceSubmodelExceptionTest()
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
        $formattedName = $gapicClient->mobileDeviceSubmodelName('[NETWORK_CODE]', '[MOBILE_DEVICE_SUBMODEL]');
        $request = (new GetMobileDeviceSubmodelRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getMobileDeviceSubmodel($request);
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
    public function listMobileDeviceSubmodelsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $mobileDeviceSubmodelsElement = new MobileDeviceSubmodel();
        $mobileDeviceSubmodels = [
            $mobileDeviceSubmodelsElement,
        ];
        $expectedResponse = new ListMobileDeviceSubmodelsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setMobileDeviceSubmodels($mobileDeviceSubmodels);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListMobileDeviceSubmodelsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listMobileDeviceSubmodels($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getMobileDeviceSubmodels()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.MobileDeviceSubmodelService/ListMobileDeviceSubmodels', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listMobileDeviceSubmodelsExceptionTest()
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
        $request = (new ListMobileDeviceSubmodelsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listMobileDeviceSubmodels($request);
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
    public function getMobileDeviceSubmodelAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $mobileDevice = 'mobileDevice-267587437';
        $expectedResponse = new MobileDeviceSubmodel();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setMobileDevice($mobileDevice);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->mobileDeviceSubmodelName('[NETWORK_CODE]', '[MOBILE_DEVICE_SUBMODEL]');
        $request = (new GetMobileDeviceSubmodelRequest())
            ->setName($formattedName);
        $response = $gapicClient->getMobileDeviceSubmodelAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.MobileDeviceSubmodelService/GetMobileDeviceSubmodel', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
