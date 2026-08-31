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

use Google\Ads\AdManager\V1\AudienceSegment;
use Google\Ads\AdManager\V1\BatchActivateAudienceSegmentsRequest;
use Google\Ads\AdManager\V1\BatchActivateAudienceSegmentsResponse;
use Google\Ads\AdManager\V1\BatchApproveAudienceSegmentsRequest;
use Google\Ads\AdManager\V1\BatchApproveAudienceSegmentsResponse;
use Google\Ads\AdManager\V1\BatchDeactivateAudienceSegmentsRequest;
use Google\Ads\AdManager\V1\BatchDeactivateAudienceSegmentsResponse;
use Google\Ads\AdManager\V1\BatchPopulateAudienceSegmentsRequest;
use Google\Ads\AdManager\V1\BatchPopulateAudienceSegmentsResponse;
use Google\Ads\AdManager\V1\BatchRejectAudienceSegmentsRequest;
use Google\Ads\AdManager\V1\BatchRejectAudienceSegmentsResponse;
use Google\Ads\AdManager\V1\Client\AudienceSegmentServiceClient;
use Google\Ads\AdManager\V1\GetAudienceSegmentRequest;
use Google\Ads\AdManager\V1\ListAudienceSegmentsRequest;
use Google\Ads\AdManager\V1\ListAudienceSegmentsResponse;
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
class AudienceSegmentServiceClientTest extends GeneratedTest
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

    /** @return AudienceSegmentServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AudienceSegmentServiceClient($options);
    }

    /** @test */
    public function batchActivateAudienceSegmentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $changeCount = 235488192;
        $expectedResponse = new BatchActivateAudienceSegmentsResponse();
        $expectedResponse->setChangeCount($changeCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [$gapicClient->audienceSegmentName('[NETWORK_CODE]', '[AUDIENCE_SEGMENT]')];
        $request = (new BatchActivateAudienceSegmentsRequest())->setParent($formattedParent)->setNames($formattedNames);
        $response = $gapicClient->batchActivateAudienceSegments($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.AudienceSegmentService/BatchActivateAudienceSegments',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchActivateAudienceSegmentsExceptionTest()
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
        $formattedNames = [$gapicClient->audienceSegmentName('[NETWORK_CODE]', '[AUDIENCE_SEGMENT]')];
        $request = (new BatchActivateAudienceSegmentsRequest())->setParent($formattedParent)->setNames($formattedNames);
        try {
            $gapicClient->batchActivateAudienceSegments($request);
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
    public function batchApproveAudienceSegmentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $changeCount = 235488192;
        $expectedResponse = new BatchApproveAudienceSegmentsResponse();
        $expectedResponse->setChangeCount($changeCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [$gapicClient->audienceSegmentName('[NETWORK_CODE]', '[AUDIENCE_SEGMENT]')];
        $request = (new BatchApproveAudienceSegmentsRequest())->setParent($formattedParent)->setNames($formattedNames);
        $response = $gapicClient->batchApproveAudienceSegments($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.AudienceSegmentService/BatchApproveAudienceSegments',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchApproveAudienceSegmentsExceptionTest()
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
        $formattedNames = [$gapicClient->audienceSegmentName('[NETWORK_CODE]', '[AUDIENCE_SEGMENT]')];
        $request = (new BatchApproveAudienceSegmentsRequest())->setParent($formattedParent)->setNames($formattedNames);
        try {
            $gapicClient->batchApproveAudienceSegments($request);
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
    public function batchDeactivateAudienceSegmentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $changeCount = 235488192;
        $expectedResponse = new BatchDeactivateAudienceSegmentsResponse();
        $expectedResponse->setChangeCount($changeCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [$gapicClient->audienceSegmentName('[NETWORK_CODE]', '[AUDIENCE_SEGMENT]')];
        $request = (new BatchDeactivateAudienceSegmentsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        $response = $gapicClient->batchDeactivateAudienceSegments($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.AudienceSegmentService/BatchDeactivateAudienceSegments',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchDeactivateAudienceSegmentsExceptionTest()
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
        $formattedNames = [$gapicClient->audienceSegmentName('[NETWORK_CODE]', '[AUDIENCE_SEGMENT]')];
        $request = (new BatchDeactivateAudienceSegmentsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        try {
            $gapicClient->batchDeactivateAudienceSegments($request);
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
    public function batchPopulateAudienceSegmentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $changeCount = 235488192;
        $expectedResponse = new BatchPopulateAudienceSegmentsResponse();
        $expectedResponse->setChangeCount($changeCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [$gapicClient->audienceSegmentName('[NETWORK_CODE]', '[AUDIENCE_SEGMENT]')];
        $request = (new BatchPopulateAudienceSegmentsRequest())->setParent($formattedParent)->setNames($formattedNames);
        $response = $gapicClient->batchPopulateAudienceSegments($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.AudienceSegmentService/BatchPopulateAudienceSegments',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchPopulateAudienceSegmentsExceptionTest()
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
        $formattedNames = [$gapicClient->audienceSegmentName('[NETWORK_CODE]', '[AUDIENCE_SEGMENT]')];
        $request = (new BatchPopulateAudienceSegmentsRequest())->setParent($formattedParent)->setNames($formattedNames);
        try {
            $gapicClient->batchPopulateAudienceSegments($request);
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
    public function batchRejectAudienceSegmentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $changeCount = 235488192;
        $expectedResponse = new BatchRejectAudienceSegmentsResponse();
        $expectedResponse->setChangeCount($changeCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [$gapicClient->audienceSegmentName('[NETWORK_CODE]', '[AUDIENCE_SEGMENT]')];
        $request = (new BatchRejectAudienceSegmentsRequest())->setParent($formattedParent)->setNames($formattedNames);
        $response = $gapicClient->batchRejectAudienceSegments($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.AudienceSegmentService/BatchRejectAudienceSegments',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchRejectAudienceSegmentsExceptionTest()
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
        $formattedNames = [$gapicClient->audienceSegmentName('[NETWORK_CODE]', '[AUDIENCE_SEGMENT]')];
        $request = (new BatchRejectAudienceSegmentsRequest())->setParent($formattedParent)->setNames($formattedNames);
        try {
            $gapicClient->batchRejectAudienceSegments($request);
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
    public function getAudienceSegmentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $sharedId = 1581568203;
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $size = 3530753;
        $mobileWebSize = 1281165047;
        $idfaSize = 582571914;
        $adIdSize = 1772250249;
        $ppidSize = 1292388699;
        $dataProviderDisplayName = 'dataProviderDisplayName-1756607327';
        $expectedResponse = new AudienceSegment();
        $expectedResponse->setName($name2);
        $expectedResponse->setSharedId($sharedId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setSize($size);
        $expectedResponse->setMobileWebSize($mobileWebSize);
        $expectedResponse->setIdfaSize($idfaSize);
        $expectedResponse->setAdIdSize($adIdSize);
        $expectedResponse->setPpidSize($ppidSize);
        $expectedResponse->setDataProviderDisplayName($dataProviderDisplayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->audienceSegmentName('[NETWORK_CODE]', '[AUDIENCE_SEGMENT]');
        $request = (new GetAudienceSegmentRequest())->setName($formattedName);
        $response = $gapicClient->getAudienceSegment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AudienceSegmentService/GetAudienceSegment', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAudienceSegmentExceptionTest()
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
        $formattedName = $gapicClient->audienceSegmentName('[NETWORK_CODE]', '[AUDIENCE_SEGMENT]');
        $request = (new GetAudienceSegmentRequest())->setName($formattedName);
        try {
            $gapicClient->getAudienceSegment($request);
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
    public function listAudienceSegmentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $audienceSegmentsElement = new AudienceSegment();
        $audienceSegments = [$audienceSegmentsElement];
        $expectedResponse = new ListAudienceSegmentsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setAudienceSegments($audienceSegments);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListAudienceSegmentsRequest())->setParent($formattedParent);
        $response = $gapicClient->listAudienceSegments($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAudienceSegments()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AudienceSegmentService/ListAudienceSegments', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAudienceSegmentsExceptionTest()
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
        $request = (new ListAudienceSegmentsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listAudienceSegments($request);
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
    public function batchActivateAudienceSegmentsAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $changeCount = 235488192;
        $expectedResponse = new BatchActivateAudienceSegmentsResponse();
        $expectedResponse->setChangeCount($changeCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [$gapicClient->audienceSegmentName('[NETWORK_CODE]', '[AUDIENCE_SEGMENT]')];
        $request = (new BatchActivateAudienceSegmentsRequest())->setParent($formattedParent)->setNames($formattedNames);
        $response = $gapicClient->batchActivateAudienceSegmentsAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.AudienceSegmentService/BatchActivateAudienceSegments',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
