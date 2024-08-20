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

namespace Google\Cloud\GkeConnect\Gateway\Tests\Unit\V1beta1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\GkeConnect\Gateway\V1beta1\Client\GatewayControlClient;
use Google\Cloud\GkeConnect\Gateway\V1beta1\GenerateCredentialsRequest;
use Google\Cloud\GkeConnect\Gateway\V1beta1\GenerateCredentialsResponse;
use Google\Rpc\Code;
use stdClass;

/**
 * @group gateway
 *
 * @group gapic
 */
class GatewayControlClientTest extends GeneratedTest
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

    /** @return GatewayControlClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new GatewayControlClient($options);
    }

    /** @test */
    public function generateCredentialsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kubeconfig = '-81';
        $endpoint = 'endpoint1741102485';
        $expectedResponse = new GenerateCredentialsResponse();
        $expectedResponse->setKubeconfig($kubeconfig);
        $expectedResponse->setEndpoint($endpoint);
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $request = (new GenerateCredentialsRequest())
            ->setName($name);
        $response = $gapicClient->generateCredentials($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkeconnect.gateway.v1beta1.GatewayControl/GenerateCredentials', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function generateCredentialsExceptionTest()
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
        $name = 'name3373707';
        $request = (new GenerateCredentialsRequest())
            ->setName($name);
        try {
            $gapicClient->generateCredentials($request);
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
    public function generateCredentialsAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kubeconfig = '-81';
        $endpoint = 'endpoint1741102485';
        $expectedResponse = new GenerateCredentialsResponse();
        $expectedResponse->setKubeconfig($kubeconfig);
        $expectedResponse->setEndpoint($endpoint);
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $request = (new GenerateCredentialsRequest())
            ->setName($name);
        $response = $gapicClient->generateCredentialsAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkeconnect.gateway.v1beta1.GatewayControl/GenerateCredentials', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
