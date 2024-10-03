<?php
/*
 * Copyright 2024 Google LLC
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

namespace Google\Cloud\Run\Tests\Unit\V2\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Run\V2\Client\BuildsClient;
use Google\Cloud\Run\V2\StorageSource;
use Google\Cloud\Run\V2\SubmitBuildRequest;
use Google\Cloud\Run\V2\SubmitBuildResponse;
use Google\Rpc\Code;
use stdClass;

/**
 * @group run
 *
 * @group gapic
 */
class BuildsClientTest extends GeneratedTest
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

    /** @return BuildsClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new BuildsClient($options);
    }

    /** @test */
    public function submitBuildTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $baseImageUri = 'baseImageUri2088954010';
        $baseImageWarning = 'baseImageWarning-2033873974';
        $expectedResponse = new SubmitBuildResponse();
        $expectedResponse->setBaseImageUri($baseImageUri);
        $expectedResponse->setBaseImageWarning($baseImageWarning);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $storageSource = new StorageSource();
        $storageSourceBucket = 'storageSourceBucket608605184';
        $storageSource->setBucket($storageSourceBucket);
        $storageSourceObject = 'storageSourceObject963439957';
        $storageSource->setObject($storageSourceObject);
        $imageUri = 'imageUri-877823864';
        $request = (new SubmitBuildRequest())
            ->setParent($parent)
            ->setStorageSource($storageSource)
            ->setImageUri($imageUri);
        $response = $gapicClient->submitBuild($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.run.v2.Builds/SubmitBuild', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getStorageSource();
        $this->assertProtobufEquals($storageSource, $actualValue);
        $actualValue = $actualRequestObject->getImageUri();
        $this->assertProtobufEquals($imageUri, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function submitBuildExceptionTest()
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
        $parent = 'parent-995424086';
        $storageSource = new StorageSource();
        $storageSourceBucket = 'storageSourceBucket608605184';
        $storageSource->setBucket($storageSourceBucket);
        $storageSourceObject = 'storageSourceObject963439957';
        $storageSource->setObject($storageSourceObject);
        $imageUri = 'imageUri-877823864';
        $request = (new SubmitBuildRequest())
            ->setParent($parent)
            ->setStorageSource($storageSource)
            ->setImageUri($imageUri);
        try {
            $gapicClient->submitBuild($request);
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
    public function submitBuildAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $baseImageUri = 'baseImageUri2088954010';
        $baseImageWarning = 'baseImageWarning-2033873974';
        $expectedResponse = new SubmitBuildResponse();
        $expectedResponse->setBaseImageUri($baseImageUri);
        $expectedResponse->setBaseImageWarning($baseImageWarning);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $storageSource = new StorageSource();
        $storageSourceBucket = 'storageSourceBucket608605184';
        $storageSource->setBucket($storageSourceBucket);
        $storageSourceObject = 'storageSourceObject963439957';
        $storageSource->setObject($storageSourceObject);
        $imageUri = 'imageUri-877823864';
        $request = (new SubmitBuildRequest())
            ->setParent($parent)
            ->setStorageSource($storageSource)
            ->setImageUri($imageUri);
        $response = $gapicClient->submitBuildAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.run.v2.Builds/SubmitBuild', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getStorageSource();
        $this->assertProtobufEquals($storageSource, $actualValue);
        $actualValue = $actualRequestObject->getImageUri();
        $this->assertProtobufEquals($imageUri, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
