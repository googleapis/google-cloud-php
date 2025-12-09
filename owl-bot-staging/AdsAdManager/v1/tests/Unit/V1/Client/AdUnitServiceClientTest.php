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

use Google\Ads\AdManager\V1\AdUnit;
use Google\Ads\AdManager\V1\AdUnitSize;
use Google\Ads\AdManager\V1\BatchActivateAdUnitsRequest;
use Google\Ads\AdManager\V1\BatchActivateAdUnitsResponse;
use Google\Ads\AdManager\V1\BatchArchiveAdUnitsRequest;
use Google\Ads\AdManager\V1\BatchArchiveAdUnitsResponse;
use Google\Ads\AdManager\V1\BatchCreateAdUnitsRequest;
use Google\Ads\AdManager\V1\BatchCreateAdUnitsResponse;
use Google\Ads\AdManager\V1\BatchDeactivateAdUnitsRequest;
use Google\Ads\AdManager\V1\BatchDeactivateAdUnitsResponse;
use Google\Ads\AdManager\V1\BatchUpdateAdUnitsRequest;
use Google\Ads\AdManager\V1\BatchUpdateAdUnitsResponse;
use Google\Ads\AdManager\V1\Client\AdUnitServiceClient;
use Google\Ads\AdManager\V1\CreateAdUnitRequest;
use Google\Ads\AdManager\V1\GetAdUnitRequest;
use Google\Ads\AdManager\V1\ListAdUnitSizesRequest;
use Google\Ads\AdManager\V1\ListAdUnitSizesResponse;
use Google\Ads\AdManager\V1\ListAdUnitsRequest;
use Google\Ads\AdManager\V1\ListAdUnitsResponse;
use Google\Ads\AdManager\V1\UpdateAdUnitRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\FieldMask;
use Google\Rpc\Code;
use stdClass;

/**
 * @group admanager
 *
 * @group gapic
 */
class AdUnitServiceClientTest extends GeneratedTest
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

    /** @return AdUnitServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AdUnitServiceClient($options);
    }

    /** @test */
    public function batchActivateAdUnitsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchActivateAdUnitsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [
            $gapicClient->adUnitName('[NETWORK_CODE]', '[AD_UNIT]'),
        ];
        $request = (new BatchActivateAdUnitsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        $response = $gapicClient->batchActivateAdUnits($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdUnitService/BatchActivateAdUnits', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchActivateAdUnitsExceptionTest()
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
        $formattedNames = [
            $gapicClient->adUnitName('[NETWORK_CODE]', '[AD_UNIT]'),
        ];
        $request = (new BatchActivateAdUnitsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        try {
            $gapicClient->batchActivateAdUnits($request);
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
    public function batchArchiveAdUnitsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchArchiveAdUnitsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [
            $gapicClient->adUnitName('[NETWORK_CODE]', '[AD_UNIT]'),
        ];
        $request = (new BatchArchiveAdUnitsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        $response = $gapicClient->batchArchiveAdUnits($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdUnitService/BatchArchiveAdUnits', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchArchiveAdUnitsExceptionTest()
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
        $formattedNames = [
            $gapicClient->adUnitName('[NETWORK_CODE]', '[AD_UNIT]'),
        ];
        $request = (new BatchArchiveAdUnitsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        try {
            $gapicClient->batchArchiveAdUnits($request);
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
    public function batchCreateAdUnitsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCreateAdUnitsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchCreateAdUnitsRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        $response = $gapicClient->batchCreateAdUnits($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdUnitService/BatchCreateAdUnits', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchCreateAdUnitsExceptionTest()
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
        $requests = [];
        $request = (new BatchCreateAdUnitsRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        try {
            $gapicClient->batchCreateAdUnits($request);
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
    public function batchDeactivateAdUnitsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchDeactivateAdUnitsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [
            $gapicClient->adUnitName('[NETWORK_CODE]', '[AD_UNIT]'),
        ];
        $request = (new BatchDeactivateAdUnitsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        $response = $gapicClient->batchDeactivateAdUnits($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdUnitService/BatchDeactivateAdUnits', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchDeactivateAdUnitsExceptionTest()
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
        $formattedNames = [
            $gapicClient->adUnitName('[NETWORK_CODE]', '[AD_UNIT]'),
        ];
        $request = (new BatchDeactivateAdUnitsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        try {
            $gapicClient->batchDeactivateAdUnits($request);
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
    public function batchUpdateAdUnitsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchUpdateAdUnitsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchUpdateAdUnitsRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        $response = $gapicClient->batchUpdateAdUnits($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdUnitService/BatchUpdateAdUnits', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchUpdateAdUnitsExceptionTest()
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
        $requests = [];
        $request = (new BatchUpdateAdUnitsRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        try {
            $gapicClient->batchUpdateAdUnits($request);
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
    public function createAdUnitTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $adUnitId = 167061094;
        $parentAdUnit = 'parentAdUnit-898168437';
        $displayName = 'displayName1615086568';
        $adUnitCode = 'adUnitCode-1632086356';
        $description = 'description-1724546052';
        $explicitlyTargeted = true;
        $hasChildren = true;
        $externalSetTopBoxChannelId = 'externalSetTopBoxChannelId-1727346970';
        $appliedAdsenseEnabled = false;
        $effectiveAdsenseEnabled = false;
        $expectedResponse = new AdUnit();
        $expectedResponse->setName($name);
        $expectedResponse->setAdUnitId($adUnitId);
        $expectedResponse->setParentAdUnit($parentAdUnit);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setAdUnitCode($adUnitCode);
        $expectedResponse->setDescription($description);
        $expectedResponse->setExplicitlyTargeted($explicitlyTargeted);
        $expectedResponse->setHasChildren($hasChildren);
        $expectedResponse->setExternalSetTopBoxChannelId($externalSetTopBoxChannelId);
        $expectedResponse->setAppliedAdsenseEnabled($appliedAdsenseEnabled);
        $expectedResponse->setEffectiveAdsenseEnabled($effectiveAdsenseEnabled);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $adUnit = new AdUnit();
        $adUnitParentAdUnit = $gapicClient->adUnitName('[NETWORK_CODE]', '[AD_UNIT]');
        $adUnit->setParentAdUnit($adUnitParentAdUnit);
        $adUnitDisplayName = 'adUnitDisplayName-1437545562';
        $adUnit->setDisplayName($adUnitDisplayName);
        $request = (new CreateAdUnitRequest())
            ->setParent($formattedParent)
            ->setAdUnit($adUnit);
        $response = $gapicClient->createAdUnit($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdUnitService/CreateAdUnit', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAdUnit();
        $this->assertProtobufEquals($adUnit, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createAdUnitExceptionTest()
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
        $adUnit = new AdUnit();
        $adUnitParentAdUnit = $gapicClient->adUnitName('[NETWORK_CODE]', '[AD_UNIT]');
        $adUnit->setParentAdUnit($adUnitParentAdUnit);
        $adUnitDisplayName = 'adUnitDisplayName-1437545562';
        $adUnit->setDisplayName($adUnitDisplayName);
        $request = (new CreateAdUnitRequest())
            ->setParent($formattedParent)
            ->setAdUnit($adUnit);
        try {
            $gapicClient->createAdUnit($request);
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
    public function getAdUnitTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $adUnitId = 167061094;
        $parentAdUnit = 'parentAdUnit-898168437';
        $displayName = 'displayName1615086568';
        $adUnitCode = 'adUnitCode-1632086356';
        $description = 'description-1724546052';
        $explicitlyTargeted = true;
        $hasChildren = true;
        $externalSetTopBoxChannelId = 'externalSetTopBoxChannelId-1727346970';
        $appliedAdsenseEnabled = false;
        $effectiveAdsenseEnabled = false;
        $expectedResponse = new AdUnit();
        $expectedResponse->setName($name2);
        $expectedResponse->setAdUnitId($adUnitId);
        $expectedResponse->setParentAdUnit($parentAdUnit);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setAdUnitCode($adUnitCode);
        $expectedResponse->setDescription($description);
        $expectedResponse->setExplicitlyTargeted($explicitlyTargeted);
        $expectedResponse->setHasChildren($hasChildren);
        $expectedResponse->setExternalSetTopBoxChannelId($externalSetTopBoxChannelId);
        $expectedResponse->setAppliedAdsenseEnabled($appliedAdsenseEnabled);
        $expectedResponse->setEffectiveAdsenseEnabled($effectiveAdsenseEnabled);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->adUnitName('[NETWORK_CODE]', '[AD_UNIT]');
        $request = (new GetAdUnitRequest())
            ->setName($formattedName);
        $response = $gapicClient->getAdUnit($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdUnitService/GetAdUnit', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAdUnitExceptionTest()
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
        $formattedName = $gapicClient->adUnitName('[NETWORK_CODE]', '[AD_UNIT]');
        $request = (new GetAdUnitRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getAdUnit($request);
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
    public function listAdUnitSizesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $adUnitSizesElement = new AdUnitSize();
        $adUnitSizes = [
            $adUnitSizesElement,
        ];
        $expectedResponse = new ListAdUnitSizesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setAdUnitSizes($adUnitSizes);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListAdUnitSizesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listAdUnitSizes($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAdUnitSizes()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdUnitService/ListAdUnitSizes', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAdUnitSizesExceptionTest()
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
        $request = (new ListAdUnitSizesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listAdUnitSizes($request);
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
    public function listAdUnitsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $adUnitsElement = new AdUnit();
        $adUnits = [
            $adUnitsElement,
        ];
        $expectedResponse = new ListAdUnitsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setAdUnits($adUnits);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListAdUnitsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listAdUnits($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAdUnits()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdUnitService/ListAdUnits', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAdUnitsExceptionTest()
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
        $request = (new ListAdUnitsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listAdUnits($request);
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
    public function updateAdUnitTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $adUnitId = 167061094;
        $parentAdUnit = 'parentAdUnit-898168437';
        $displayName = 'displayName1615086568';
        $adUnitCode = 'adUnitCode-1632086356';
        $description = 'description-1724546052';
        $explicitlyTargeted = true;
        $hasChildren = true;
        $externalSetTopBoxChannelId = 'externalSetTopBoxChannelId-1727346970';
        $appliedAdsenseEnabled = false;
        $effectiveAdsenseEnabled = false;
        $expectedResponse = new AdUnit();
        $expectedResponse->setName($name);
        $expectedResponse->setAdUnitId($adUnitId);
        $expectedResponse->setParentAdUnit($parentAdUnit);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setAdUnitCode($adUnitCode);
        $expectedResponse->setDescription($description);
        $expectedResponse->setExplicitlyTargeted($explicitlyTargeted);
        $expectedResponse->setHasChildren($hasChildren);
        $expectedResponse->setExternalSetTopBoxChannelId($externalSetTopBoxChannelId);
        $expectedResponse->setAppliedAdsenseEnabled($appliedAdsenseEnabled);
        $expectedResponse->setEffectiveAdsenseEnabled($effectiveAdsenseEnabled);
        $transport->addResponse($expectedResponse);
        // Mock request
        $adUnit = new AdUnit();
        $adUnitParentAdUnit = $gapicClient->adUnitName('[NETWORK_CODE]', '[AD_UNIT]');
        $adUnit->setParentAdUnit($adUnitParentAdUnit);
        $adUnitDisplayName = 'adUnitDisplayName-1437545562';
        $adUnit->setDisplayName($adUnitDisplayName);
        $updateMask = new FieldMask();
        $request = (new UpdateAdUnitRequest())
            ->setAdUnit($adUnit)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateAdUnit($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdUnitService/UpdateAdUnit', $actualFuncCall);
        $actualValue = $actualRequestObject->getAdUnit();
        $this->assertProtobufEquals($adUnit, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateAdUnitExceptionTest()
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
        $adUnit = new AdUnit();
        $adUnitParentAdUnit = $gapicClient->adUnitName('[NETWORK_CODE]', '[AD_UNIT]');
        $adUnit->setParentAdUnit($adUnitParentAdUnit);
        $adUnitDisplayName = 'adUnitDisplayName-1437545562';
        $adUnit->setDisplayName($adUnitDisplayName);
        $updateMask = new FieldMask();
        $request = (new UpdateAdUnitRequest())
            ->setAdUnit($adUnit)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateAdUnit($request);
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
    public function batchActivateAdUnitsAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchActivateAdUnitsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [
            $gapicClient->adUnitName('[NETWORK_CODE]', '[AD_UNIT]'),
        ];
        $request = (new BatchActivateAdUnitsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        $response = $gapicClient->batchActivateAdUnitsAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdUnitService/BatchActivateAdUnits', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
