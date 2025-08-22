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

use Google\Ads\AdManager\V1\AdBreak;
use Google\Ads\AdManager\V1\Client\AdBreakServiceClient;
use Google\Ads\AdManager\V1\CreateAdBreakRequest;
use Google\Ads\AdManager\V1\DeleteAdBreakRequest;
use Google\Ads\AdManager\V1\GetAdBreakRequest;
use Google\Ads\AdManager\V1\ListAdBreaksRequest;
use Google\Ads\AdManager\V1\ListAdBreaksResponse;
use Google\Ads\AdManager\V1\UpdateAdBreakRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\Duration;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group admanager
 *
 * @group gapic
 */
class AdBreakServiceClientTest extends GeneratedTest
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

    /** @return AdBreakServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AdBreakServiceClient($options);
    }

    /** @test */
    public function createAdBreakTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $adBreakId = 'adBreakId-514252553';
        $assetKey = 'assetKey1315618960';
        $customAssetKey = 'customAssetKey-2017235646';
        $breakSequence = 1853489407;
        $podTemplateName = 'podTemplateName-120206666';
        $customParams = 'customParams1065802260';
        $scte35CueOut = 'scte35CueOut1064400035';
        $expectedResponse = new AdBreak();
        $expectedResponse->setName($name);
        $expectedResponse->setAdBreakId($adBreakId);
        $expectedResponse->setAssetKey($assetKey);
        $expectedResponse->setCustomAssetKey($customAssetKey);
        $expectedResponse->setBreakSequence($breakSequence);
        $expectedResponse->setPodTemplateName($podTemplateName);
        $expectedResponse->setCustomParams($customParams);
        $expectedResponse->setScte35CueOut($scte35CueOut);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->liveStreamEventName('[NETWORK_CODE]', '[LIVE_STREAM_EVENT]');
        $adBreak = new AdBreak();
        $adBreakDuration = new Duration();
        $adBreak->setDuration($adBreakDuration);
        $request = (new CreateAdBreakRequest())->setParent($formattedParent)->setAdBreak($adBreak);
        $response = $gapicClient->createAdBreak($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdBreakService/CreateAdBreak', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAdBreak();
        $this->assertProtobufEquals($adBreak, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createAdBreakExceptionTest()
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
        $formattedParent = $gapicClient->liveStreamEventName('[NETWORK_CODE]', '[LIVE_STREAM_EVENT]');
        $adBreak = new AdBreak();
        $adBreakDuration = new Duration();
        $adBreak->setDuration($adBreakDuration);
        $request = (new CreateAdBreakRequest())->setParent($formattedParent)->setAdBreak($adBreak);
        try {
            $gapicClient->createAdBreak($request);
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
    public function deleteAdBreakTest()
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
        $formattedName = $gapicClient->adBreakName('[NETWORK_CODE]', '[ASSET_KEY]', '[AD_BREAK]');
        $request = (new DeleteAdBreakRequest())->setName($formattedName);
        $gapicClient->deleteAdBreak($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdBreakService/DeleteAdBreak', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteAdBreakExceptionTest()
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
        $formattedName = $gapicClient->adBreakName('[NETWORK_CODE]', '[ASSET_KEY]', '[AD_BREAK]');
        $request = (new DeleteAdBreakRequest())->setName($formattedName);
        try {
            $gapicClient->deleteAdBreak($request);
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
    public function getAdBreakTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $adBreakId = 'adBreakId-514252553';
        $assetKey = 'assetKey1315618960';
        $customAssetKey = 'customAssetKey-2017235646';
        $breakSequence = 1853489407;
        $podTemplateName = 'podTemplateName-120206666';
        $customParams = 'customParams1065802260';
        $scte35CueOut = 'scte35CueOut1064400035';
        $expectedResponse = new AdBreak();
        $expectedResponse->setName($name2);
        $expectedResponse->setAdBreakId($adBreakId);
        $expectedResponse->setAssetKey($assetKey);
        $expectedResponse->setCustomAssetKey($customAssetKey);
        $expectedResponse->setBreakSequence($breakSequence);
        $expectedResponse->setPodTemplateName($podTemplateName);
        $expectedResponse->setCustomParams($customParams);
        $expectedResponse->setScte35CueOut($scte35CueOut);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->adBreakName('[NETWORK_CODE]', '[ASSET_KEY]', '[AD_BREAK]');
        $request = (new GetAdBreakRequest())->setName($formattedName);
        $response = $gapicClient->getAdBreak($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdBreakService/GetAdBreak', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAdBreakExceptionTest()
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
        $formattedName = $gapicClient->adBreakName('[NETWORK_CODE]', '[ASSET_KEY]', '[AD_BREAK]');
        $request = (new GetAdBreakRequest())->setName($formattedName);
        try {
            $gapicClient->getAdBreak($request);
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
    public function listAdBreaksTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $adBreaksElement = new AdBreak();
        $adBreaks = [$adBreaksElement];
        $expectedResponse = new ListAdBreaksResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setAdBreaks($adBreaks);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->liveStreamEventName('[NETWORK_CODE]', '[LIVE_STREAM_EVENT]');
        $request = (new ListAdBreaksRequest())->setParent($formattedParent);
        $response = $gapicClient->listAdBreaks($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAdBreaks()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdBreakService/ListAdBreaks', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAdBreaksExceptionTest()
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
        $formattedParent = $gapicClient->liveStreamEventName('[NETWORK_CODE]', '[LIVE_STREAM_EVENT]');
        $request = (new ListAdBreaksRequest())->setParent($formattedParent);
        try {
            $gapicClient->listAdBreaks($request);
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
    public function updateAdBreakTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $adBreakId = 'adBreakId-514252553';
        $assetKey = 'assetKey1315618960';
        $customAssetKey = 'customAssetKey-2017235646';
        $breakSequence = 1853489407;
        $podTemplateName = 'podTemplateName-120206666';
        $customParams = 'customParams1065802260';
        $scte35CueOut = 'scte35CueOut1064400035';
        $expectedResponse = new AdBreak();
        $expectedResponse->setName($name);
        $expectedResponse->setAdBreakId($adBreakId);
        $expectedResponse->setAssetKey($assetKey);
        $expectedResponse->setCustomAssetKey($customAssetKey);
        $expectedResponse->setBreakSequence($breakSequence);
        $expectedResponse->setPodTemplateName($podTemplateName);
        $expectedResponse->setCustomParams($customParams);
        $expectedResponse->setScte35CueOut($scte35CueOut);
        $transport->addResponse($expectedResponse);
        // Mock request
        $adBreak = new AdBreak();
        $adBreakDuration = new Duration();
        $adBreak->setDuration($adBreakDuration);
        $updateMask = new FieldMask();
        $request = (new UpdateAdBreakRequest())->setAdBreak($adBreak)->setUpdateMask($updateMask);
        $response = $gapicClient->updateAdBreak($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdBreakService/UpdateAdBreak', $actualFuncCall);
        $actualValue = $actualRequestObject->getAdBreak();
        $this->assertProtobufEquals($adBreak, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateAdBreakExceptionTest()
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
        $adBreak = new AdBreak();
        $adBreakDuration = new Duration();
        $adBreak->setDuration($adBreakDuration);
        $updateMask = new FieldMask();
        $request = (new UpdateAdBreakRequest())->setAdBreak($adBreak)->setUpdateMask($updateMask);
        try {
            $gapicClient->updateAdBreak($request);
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
    public function createAdBreakAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $adBreakId = 'adBreakId-514252553';
        $assetKey = 'assetKey1315618960';
        $customAssetKey = 'customAssetKey-2017235646';
        $breakSequence = 1853489407;
        $podTemplateName = 'podTemplateName-120206666';
        $customParams = 'customParams1065802260';
        $scte35CueOut = 'scte35CueOut1064400035';
        $expectedResponse = new AdBreak();
        $expectedResponse->setName($name);
        $expectedResponse->setAdBreakId($adBreakId);
        $expectedResponse->setAssetKey($assetKey);
        $expectedResponse->setCustomAssetKey($customAssetKey);
        $expectedResponse->setBreakSequence($breakSequence);
        $expectedResponse->setPodTemplateName($podTemplateName);
        $expectedResponse->setCustomParams($customParams);
        $expectedResponse->setScte35CueOut($scte35CueOut);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->liveStreamEventName('[NETWORK_CODE]', '[LIVE_STREAM_EVENT]');
        $adBreak = new AdBreak();
        $adBreakDuration = new Duration();
        $adBreak->setDuration($adBreakDuration);
        $request = (new CreateAdBreakRequest())->setParent($formattedParent)->setAdBreak($adBreak);
        $response = $gapicClient->createAdBreakAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdBreakService/CreateAdBreak', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAdBreak();
        $this->assertProtobufEquals($adBreak, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
