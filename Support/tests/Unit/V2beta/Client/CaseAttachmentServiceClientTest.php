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

namespace Google\Cloud\Support\Tests\Unit\V2beta\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Support\V2beta\Attachment;
use Google\Cloud\Support\V2beta\Client\CaseAttachmentServiceClient;
use Google\Cloud\Support\V2beta\GetAttachmentRequest;
use Google\Cloud\Support\V2beta\ListAttachmentsRequest;
use Google\Cloud\Support\V2beta\ListAttachmentsResponse;
use Google\Rpc\Code;
use stdClass;

/**
 * @group support
 *
 * @group gapic
 */
class CaseAttachmentServiceClientTest extends GeneratedTest
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

    /** @return CaseAttachmentServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new CaseAttachmentServiceClient($options);
    }

    /** @test */
    public function getAttachmentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $filename = 'filename-734768633';
        $mimeType = 'mimeType-196041627';
        $sizeBytes = 1796325715;
        $expectedResponse = new Attachment();
        $expectedResponse->setName($name2);
        $expectedResponse->setFilename($filename);
        $expectedResponse->setMimeType($mimeType);
        $expectedResponse->setSizeBytes($sizeBytes);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->attachmentName('[ORGANIZATION]', '[CASE]', '[ATTACHMENT_ID]');
        $request = (new GetAttachmentRequest())->setName($formattedName);
        $response = $gapicClient->getAttachment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.support.v2beta.CaseAttachmentService/GetAttachment', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAttachmentExceptionTest()
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
        $formattedName = $gapicClient->attachmentName('[ORGANIZATION]', '[CASE]', '[ATTACHMENT_ID]');
        $request = (new GetAttachmentRequest())->setName($formattedName);
        try {
            $gapicClient->getAttachment($request);
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
    public function listAttachmentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $attachmentsElement = new Attachment();
        $attachments = [$attachmentsElement];
        $expectedResponse = new ListAttachmentsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAttachments($attachments);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->caseName('[ORGANIZATION]', '[CASE]');
        $request = (new ListAttachmentsRequest())->setParent($formattedParent);
        $response = $gapicClient->listAttachments($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAttachments()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.support.v2beta.CaseAttachmentService/ListAttachments', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAttachmentsExceptionTest()
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
        $formattedParent = $gapicClient->caseName('[ORGANIZATION]', '[CASE]');
        $request = (new ListAttachmentsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listAttachments($request);
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
    public function getAttachmentAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $filename = 'filename-734768633';
        $mimeType = 'mimeType-196041627';
        $sizeBytes = 1796325715;
        $expectedResponse = new Attachment();
        $expectedResponse->setName($name2);
        $expectedResponse->setFilename($filename);
        $expectedResponse->setMimeType($mimeType);
        $expectedResponse->setSizeBytes($sizeBytes);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->attachmentName('[ORGANIZATION]', '[CASE]', '[ATTACHMENT_ID]');
        $request = (new GetAttachmentRequest())->setName($formattedName);
        $response = $gapicClient->getAttachmentAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.support.v2beta.CaseAttachmentService/GetAttachment', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
