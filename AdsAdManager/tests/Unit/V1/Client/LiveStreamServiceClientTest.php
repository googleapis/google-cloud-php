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

use Google\Ads\AdManager\V1\BatchActivateLiveStreamsRequest;
use Google\Ads\AdManager\V1\BatchActivateLiveStreamsResponse;
use Google\Ads\AdManager\V1\BatchArchiveLiveStreamsRequest;
use Google\Ads\AdManager\V1\BatchArchiveLiveStreamsResponse;
use Google\Ads\AdManager\V1\BatchCreateLiveStreamsRequest;
use Google\Ads\AdManager\V1\BatchCreateLiveStreamsResponse;
use Google\Ads\AdManager\V1\BatchPauseAdsLiveStreamsRequest;
use Google\Ads\AdManager\V1\BatchPauseAdsLiveStreamsResponse;
use Google\Ads\AdManager\V1\BatchPauseLiveStreamsRequest;
use Google\Ads\AdManager\V1\BatchPauseLiveStreamsResponse;
use Google\Ads\AdManager\V1\BatchRefreshMasterPlaylistsRequest;
use Google\Ads\AdManager\V1\BatchRefreshMasterPlaylistsResponse;
use Google\Ads\AdManager\V1\BatchUpdateLiveStreamsRequest;
use Google\Ads\AdManager\V1\BatchUpdateLiveStreamsResponse;
use Google\Ads\AdManager\V1\Client\LiveStreamServiceClient;
use Google\Ads\AdManager\V1\CreateLiveStreamRequest;
use Google\Ads\AdManager\V1\GetLiveStreamRequest;
use Google\Ads\AdManager\V1\ListLiveStreamsRequest;
use Google\Ads\AdManager\V1\ListLiveStreamsResponse;
use Google\Ads\AdManager\V1\LiveStream;
use Google\Ads\AdManager\V1\UpdateLiveStreamRequest;
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
class LiveStreamServiceClientTest extends GeneratedTest
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

    /** @return LiveStreamServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new LiveStreamServiceClient($options);
    }

    /** @test */
    public function batchActivateLiveStreamsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchActivateLiveStreamsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [$gapicClient->liveStreamName('[NETWORK_CODE]', '[LIVE_STREAM]')];
        $request = (new BatchActivateLiveStreamsRequest())->setParent($formattedParent)->setNames($formattedNames);
        $response = $gapicClient->batchActivateLiveStreams($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.LiveStreamService/BatchActivateLiveStreams', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchActivateLiveStreamsExceptionTest()
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
        $formattedNames = [$gapicClient->liveStreamName('[NETWORK_CODE]', '[LIVE_STREAM]')];
        $request = (new BatchActivateLiveStreamsRequest())->setParent($formattedParent)->setNames($formattedNames);
        try {
            $gapicClient->batchActivateLiveStreams($request);
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
    public function batchArchiveLiveStreamsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchArchiveLiveStreamsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [$gapicClient->liveStreamName('[NETWORK_CODE]', '[LIVE_STREAM]')];
        $request = (new BatchArchiveLiveStreamsRequest())->setParent($formattedParent)->setNames($formattedNames);
        $response = $gapicClient->batchArchiveLiveStreams($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.LiveStreamService/BatchArchiveLiveStreams', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchArchiveLiveStreamsExceptionTest()
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
        $formattedNames = [$gapicClient->liveStreamName('[NETWORK_CODE]', '[LIVE_STREAM]')];
        $request = (new BatchArchiveLiveStreamsRequest())->setParent($formattedParent)->setNames($formattedNames);
        try {
            $gapicClient->batchArchiveLiveStreams($request);
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
    public function batchCreateLiveStreamsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCreateLiveStreamsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchCreateLiveStreamsRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchCreateLiveStreams($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.LiveStreamService/BatchCreateLiveStreams', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchCreateLiveStreamsExceptionTest()
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
        $requests = [];
        $request = (new BatchCreateLiveStreamsRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->batchCreateLiveStreams($request);
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
    public function batchPauseAdsLiveStreamsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchPauseAdsLiveStreamsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [$gapicClient->liveStreamName('[NETWORK_CODE]', '[LIVE_STREAM]')];
        $request = (new BatchPauseAdsLiveStreamsRequest())->setParent($formattedParent)->setNames($formattedNames);
        $response = $gapicClient->batchPauseAdsLiveStreams($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.LiveStreamService/BatchPauseAdsLiveStreams', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchPauseAdsLiveStreamsExceptionTest()
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
        $formattedNames = [$gapicClient->liveStreamName('[NETWORK_CODE]', '[LIVE_STREAM]')];
        $request = (new BatchPauseAdsLiveStreamsRequest())->setParent($formattedParent)->setNames($formattedNames);
        try {
            $gapicClient->batchPauseAdsLiveStreams($request);
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
    public function batchPauseLiveStreamsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchPauseLiveStreamsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [$gapicClient->liveStreamName('[NETWORK_CODE]', '[LIVE_STREAM]')];
        $request = (new BatchPauseLiveStreamsRequest())->setParent($formattedParent)->setNames($formattedNames);
        $response = $gapicClient->batchPauseLiveStreams($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.LiveStreamService/BatchPauseLiveStreams', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchPauseLiveStreamsExceptionTest()
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
        $formattedNames = [$gapicClient->liveStreamName('[NETWORK_CODE]', '[LIVE_STREAM]')];
        $request = (new BatchPauseLiveStreamsRequest())->setParent($formattedParent)->setNames($formattedNames);
        try {
            $gapicClient->batchPauseLiveStreams($request);
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
    public function batchRefreshMasterPlaylistsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchRefreshMasterPlaylistsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [$gapicClient->liveStreamName('[NETWORK_CODE]', '[LIVE_STREAM]')];
        $request = (new BatchRefreshMasterPlaylistsRequest())->setParent($formattedParent)->setNames($formattedNames);
        $response = $gapicClient->batchRefreshMasterPlaylists($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.LiveStreamService/BatchRefreshMasterPlaylists', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchRefreshMasterPlaylistsExceptionTest()
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
        $formattedNames = [$gapicClient->liveStreamName('[NETWORK_CODE]', '[LIVE_STREAM]')];
        $request = (new BatchRefreshMasterPlaylistsRequest())->setParent($formattedParent)->setNames($formattedNames);
        try {
            $gapicClient->batchRefreshMasterPlaylists($request);
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
    public function batchUpdateLiveStreamsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchUpdateLiveStreamsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchUpdateLiveStreamsRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchUpdateLiveStreams($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.LiveStreamService/BatchUpdateLiveStreams', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchUpdateLiveStreamsExceptionTest()
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
        $requests = [];
        $request = (new BatchUpdateLiveStreamsRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->batchUpdateLiveStreams($request);
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
    public function createLiveStreamTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $endTimeUnlimited = false;
        $assetKey = 'assetKey1315618960';
        $enableDaiAuthenticationKeys = true;
        $enableMaxFillerDuration = true;
        $enableDurationlessAdBreaks = true;
        $adMediaDeliveryConfig = 'adMediaDeliveryConfig-808941450';
        $allowlistedIpsEnabled = false;
        $relativePlaylistDeliveryEnabled = true;
        $prefetchEnabled = false;
        $forcedCueInEnabled = false;
        $shortSegmentDroppingEnabled = true;
        $customAssetKey = 'customAssetKey-2017235646';
        $adBreakMarkupTypesEnabled = true;
        $earlyBreakNotificationMultiBreakSchedulingEnabled = true;
        $effectiveAssetKey = 'effectiveAssetKey-999079944';
        $expectedResponse = new LiveStream();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEndTimeUnlimited($endTimeUnlimited);
        $expectedResponse->setAssetKey($assetKey);
        $expectedResponse->setEnableDaiAuthenticationKeys($enableDaiAuthenticationKeys);
        $expectedResponse->setEnableMaxFillerDuration($enableMaxFillerDuration);
        $expectedResponse->setEnableDurationlessAdBreaks($enableDurationlessAdBreaks);
        $expectedResponse->setAdMediaDeliveryConfig($adMediaDeliveryConfig);
        $expectedResponse->setAllowlistedIpsEnabled($allowlistedIpsEnabled);
        $expectedResponse->setRelativePlaylistDeliveryEnabled($relativePlaylistDeliveryEnabled);
        $expectedResponse->setPrefetchEnabled($prefetchEnabled);
        $expectedResponse->setForcedCueInEnabled($forcedCueInEnabled);
        $expectedResponse->setShortSegmentDroppingEnabled($shortSegmentDroppingEnabled);
        $expectedResponse->setCustomAssetKey($customAssetKey);
        $expectedResponse->setAdBreakMarkupTypesEnabled($adBreakMarkupTypesEnabled);
        $expectedResponse->setEarlyBreakNotificationMultiBreakSchedulingEnabled(
            $earlyBreakNotificationMultiBreakSchedulingEnabled
        );
        $expectedResponse->setEffectiveAssetKey($effectiveAssetKey);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $liveStream = new LiveStream();
        $liveStreamDisplayName = 'liveStreamDisplayName-1723890879';
        $liveStream->setDisplayName($liveStreamDisplayName);
        $liveStreamContentUrls = [];
        $liveStream->setContentUrls($liveStreamContentUrls);
        $liveStreamAdTags = [];
        $liveStream->setAdTags($liveStreamAdTags);
        $request = (new CreateLiveStreamRequest())->setParent($formattedParent)->setLiveStream($liveStream);
        $response = $gapicClient->createLiveStream($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.LiveStreamService/CreateLiveStream', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getLiveStream();
        $this->assertProtobufEquals($liveStream, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createLiveStreamExceptionTest()
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
        $liveStream = new LiveStream();
        $liveStreamDisplayName = 'liveStreamDisplayName-1723890879';
        $liveStream->setDisplayName($liveStreamDisplayName);
        $liveStreamContentUrls = [];
        $liveStream->setContentUrls($liveStreamContentUrls);
        $liveStreamAdTags = [];
        $liveStream->setAdTags($liveStreamAdTags);
        $request = (new CreateLiveStreamRequest())->setParent($formattedParent)->setLiveStream($liveStream);
        try {
            $gapicClient->createLiveStream($request);
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
    public function getLiveStreamTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $endTimeUnlimited = false;
        $assetKey = 'assetKey1315618960';
        $enableDaiAuthenticationKeys = true;
        $enableMaxFillerDuration = true;
        $enableDurationlessAdBreaks = true;
        $adMediaDeliveryConfig = 'adMediaDeliveryConfig-808941450';
        $allowlistedIpsEnabled = false;
        $relativePlaylistDeliveryEnabled = true;
        $prefetchEnabled = false;
        $forcedCueInEnabled = false;
        $shortSegmentDroppingEnabled = true;
        $customAssetKey = 'customAssetKey-2017235646';
        $adBreakMarkupTypesEnabled = true;
        $earlyBreakNotificationMultiBreakSchedulingEnabled = true;
        $effectiveAssetKey = 'effectiveAssetKey-999079944';
        $expectedResponse = new LiveStream();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEndTimeUnlimited($endTimeUnlimited);
        $expectedResponse->setAssetKey($assetKey);
        $expectedResponse->setEnableDaiAuthenticationKeys($enableDaiAuthenticationKeys);
        $expectedResponse->setEnableMaxFillerDuration($enableMaxFillerDuration);
        $expectedResponse->setEnableDurationlessAdBreaks($enableDurationlessAdBreaks);
        $expectedResponse->setAdMediaDeliveryConfig($adMediaDeliveryConfig);
        $expectedResponse->setAllowlistedIpsEnabled($allowlistedIpsEnabled);
        $expectedResponse->setRelativePlaylistDeliveryEnabled($relativePlaylistDeliveryEnabled);
        $expectedResponse->setPrefetchEnabled($prefetchEnabled);
        $expectedResponse->setForcedCueInEnabled($forcedCueInEnabled);
        $expectedResponse->setShortSegmentDroppingEnabled($shortSegmentDroppingEnabled);
        $expectedResponse->setCustomAssetKey($customAssetKey);
        $expectedResponse->setAdBreakMarkupTypesEnabled($adBreakMarkupTypesEnabled);
        $expectedResponse->setEarlyBreakNotificationMultiBreakSchedulingEnabled(
            $earlyBreakNotificationMultiBreakSchedulingEnabled
        );
        $expectedResponse->setEffectiveAssetKey($effectiveAssetKey);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->liveStreamName('[NETWORK_CODE]', '[LIVE_STREAM]');
        $request = (new GetLiveStreamRequest())->setName($formattedName);
        $response = $gapicClient->getLiveStream($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.LiveStreamService/GetLiveStream', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getLiveStreamExceptionTest()
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
        $formattedName = $gapicClient->liveStreamName('[NETWORK_CODE]', '[LIVE_STREAM]');
        $request = (new GetLiveStreamRequest())->setName($formattedName);
        try {
            $gapicClient->getLiveStream($request);
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
    public function listLiveStreamsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $liveStreamsElement = new LiveStream();
        $liveStreams = [$liveStreamsElement];
        $expectedResponse = new ListLiveStreamsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setLiveStreams($liveStreams);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListLiveStreamsRequest())->setParent($formattedParent);
        $response = $gapicClient->listLiveStreams($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getLiveStreams()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.LiveStreamService/ListLiveStreams', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listLiveStreamsExceptionTest()
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
        $request = (new ListLiveStreamsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listLiveStreams($request);
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
    public function updateLiveStreamTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $endTimeUnlimited = false;
        $assetKey = 'assetKey1315618960';
        $enableDaiAuthenticationKeys = true;
        $enableMaxFillerDuration = true;
        $enableDurationlessAdBreaks = true;
        $adMediaDeliveryConfig = 'adMediaDeliveryConfig-808941450';
        $allowlistedIpsEnabled = false;
        $relativePlaylistDeliveryEnabled = true;
        $prefetchEnabled = false;
        $forcedCueInEnabled = false;
        $shortSegmentDroppingEnabled = true;
        $customAssetKey = 'customAssetKey-2017235646';
        $adBreakMarkupTypesEnabled = true;
        $earlyBreakNotificationMultiBreakSchedulingEnabled = true;
        $effectiveAssetKey = 'effectiveAssetKey-999079944';
        $expectedResponse = new LiveStream();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEndTimeUnlimited($endTimeUnlimited);
        $expectedResponse->setAssetKey($assetKey);
        $expectedResponse->setEnableDaiAuthenticationKeys($enableDaiAuthenticationKeys);
        $expectedResponse->setEnableMaxFillerDuration($enableMaxFillerDuration);
        $expectedResponse->setEnableDurationlessAdBreaks($enableDurationlessAdBreaks);
        $expectedResponse->setAdMediaDeliveryConfig($adMediaDeliveryConfig);
        $expectedResponse->setAllowlistedIpsEnabled($allowlistedIpsEnabled);
        $expectedResponse->setRelativePlaylistDeliveryEnabled($relativePlaylistDeliveryEnabled);
        $expectedResponse->setPrefetchEnabled($prefetchEnabled);
        $expectedResponse->setForcedCueInEnabled($forcedCueInEnabled);
        $expectedResponse->setShortSegmentDroppingEnabled($shortSegmentDroppingEnabled);
        $expectedResponse->setCustomAssetKey($customAssetKey);
        $expectedResponse->setAdBreakMarkupTypesEnabled($adBreakMarkupTypesEnabled);
        $expectedResponse->setEarlyBreakNotificationMultiBreakSchedulingEnabled(
            $earlyBreakNotificationMultiBreakSchedulingEnabled
        );
        $expectedResponse->setEffectiveAssetKey($effectiveAssetKey);
        $transport->addResponse($expectedResponse);
        // Mock request
        $liveStream = new LiveStream();
        $liveStreamDisplayName = 'liveStreamDisplayName-1723890879';
        $liveStream->setDisplayName($liveStreamDisplayName);
        $liveStreamContentUrls = [];
        $liveStream->setContentUrls($liveStreamContentUrls);
        $liveStreamAdTags = [];
        $liveStream->setAdTags($liveStreamAdTags);
        $request = (new UpdateLiveStreamRequest())->setLiveStream($liveStream);
        $response = $gapicClient->updateLiveStream($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.LiveStreamService/UpdateLiveStream', $actualFuncCall);
        $actualValue = $actualRequestObject->getLiveStream();
        $this->assertProtobufEquals($liveStream, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateLiveStreamExceptionTest()
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
        $liveStream = new LiveStream();
        $liveStreamDisplayName = 'liveStreamDisplayName-1723890879';
        $liveStream->setDisplayName($liveStreamDisplayName);
        $liveStreamContentUrls = [];
        $liveStream->setContentUrls($liveStreamContentUrls);
        $liveStreamAdTags = [];
        $liveStream->setAdTags($liveStreamAdTags);
        $request = (new UpdateLiveStreamRequest())->setLiveStream($liveStream);
        try {
            $gapicClient->updateLiveStream($request);
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
    public function batchActivateLiveStreamsAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchActivateLiveStreamsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [$gapicClient->liveStreamName('[NETWORK_CODE]', '[LIVE_STREAM]')];
        $request = (new BatchActivateLiveStreamsRequest())->setParent($formattedParent)->setNames($formattedNames);
        $response = $gapicClient->batchActivateLiveStreamsAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.LiveStreamService/BatchActivateLiveStreams', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
