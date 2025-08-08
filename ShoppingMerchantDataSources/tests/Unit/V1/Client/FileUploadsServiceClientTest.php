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

namespace Google\Shopping\Merchant\DataSources\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Rpc\Code;
use Google\Shopping\Merchant\DataSources\V1\Client\FileUploadsServiceClient;
use Google\Shopping\Merchant\DataSources\V1\FileUpload;
use Google\Shopping\Merchant\DataSources\V1\GetFileUploadRequest;
use stdClass;

/**
 * @group datasources
 *
 * @group gapic
 */
class FileUploadsServiceClientTest extends GeneratedTest
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

    /** @return FileUploadsServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new FileUploadsServiceClient($options);
    }

    /** @test */
    public function getFileUploadTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $dataSourceId = 1015796374;
        $itemsTotal = 384543227;
        $itemsCreated = 1985498473;
        $itemsUpdated = 722513724;
        $expectedResponse = new FileUpload();
        $expectedResponse->setName($name2);
        $expectedResponse->setDataSourceId($dataSourceId);
        $expectedResponse->setItemsTotal($itemsTotal);
        $expectedResponse->setItemsCreated($itemsCreated);
        $expectedResponse->setItemsUpdated($itemsUpdated);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->fileUploadName('[ACCOUNT]', '[DATASOURCE]', '[FILEUPLOAD]');
        $request = (new GetFileUploadRequest())->setName($formattedName);
        $response = $gapicClient->getFileUpload($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.datasources.v1.FileUploadsService/GetFileUpload', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getFileUploadExceptionTest()
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
        $formattedName = $gapicClient->fileUploadName('[ACCOUNT]', '[DATASOURCE]', '[FILEUPLOAD]');
        $request = (new GetFileUploadRequest())->setName($formattedName);
        try {
            $gapicClient->getFileUpload($request);
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
    public function getFileUploadAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $dataSourceId = 1015796374;
        $itemsTotal = 384543227;
        $itemsCreated = 1985498473;
        $itemsUpdated = 722513724;
        $expectedResponse = new FileUpload();
        $expectedResponse->setName($name2);
        $expectedResponse->setDataSourceId($dataSourceId);
        $expectedResponse->setItemsTotal($itemsTotal);
        $expectedResponse->setItemsCreated($itemsCreated);
        $expectedResponse->setItemsUpdated($itemsUpdated);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->fileUploadName('[ACCOUNT]', '[DATASOURCE]', '[FILEUPLOAD]');
        $request = (new GetFileUploadRequest())->setName($formattedName);
        $response = $gapicClient->getFileUploadAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.datasources.v1.FileUploadsService/GetFileUpload', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
