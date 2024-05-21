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

namespace Google\Cloud\Security\PublicCA\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Security\PublicCA\V1\Client\PublicCertificateAuthorityServiceClient;
use Google\Cloud\Security\PublicCA\V1\CreateExternalAccountKeyRequest;
use Google\Cloud\Security\PublicCA\V1\ExternalAccountKey;
use Google\Rpc\Code;
use stdClass;

/**
 * @group publicca
 *
 * @group gapic
 */
class PublicCertificateAuthorityServiceClientTest extends GeneratedTest
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

    /** @return PublicCertificateAuthorityServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new PublicCertificateAuthorityServiceClient($options);
    }

    /** @test */
    public function createExternalAccountKeyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $keyId = 'keyId-1134673157';
        $b64MacKey = '-48';
        $expectedResponse = new ExternalAccountKey();
        $expectedResponse->setName($name);
        $expectedResponse->setKeyId($keyId);
        $expectedResponse->setB64MacKey($b64MacKey);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $externalAccountKey = new ExternalAccountKey();
        $request = (new CreateExternalAccountKeyRequest())
            ->setParent($formattedParent)
            ->setExternalAccountKey($externalAccountKey);
        $response = $gapicClient->createExternalAccountKey($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.publicca.v1.PublicCertificateAuthorityService/CreateExternalAccountKey', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getExternalAccountKey();
        $this->assertProtobufEquals($externalAccountKey, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createExternalAccountKeyExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $externalAccountKey = new ExternalAccountKey();
        $request = (new CreateExternalAccountKeyRequest())
            ->setParent($formattedParent)
            ->setExternalAccountKey($externalAccountKey);
        try {
            $gapicClient->createExternalAccountKey($request);
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
    public function createExternalAccountKeyAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $keyId = 'keyId-1134673157';
        $b64MacKey = '-48';
        $expectedResponse = new ExternalAccountKey();
        $expectedResponse->setName($name);
        $expectedResponse->setKeyId($keyId);
        $expectedResponse->setB64MacKey($b64MacKey);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $externalAccountKey = new ExternalAccountKey();
        $request = (new CreateExternalAccountKeyRequest())
            ->setParent($formattedParent)
            ->setExternalAccountKey($externalAccountKey);
        $response = $gapicClient->createExternalAccountKeyAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.security.publicca.v1.PublicCertificateAuthorityService/CreateExternalAccountKey', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getExternalAccountKey();
        $this->assertProtobufEquals($externalAccountKey, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
