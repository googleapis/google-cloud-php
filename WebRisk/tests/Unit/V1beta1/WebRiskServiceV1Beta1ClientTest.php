<?php
/*
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\WebRisk\Tests\Unit\V1beta1;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;

use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\WebRisk\V1beta1\ComputeThreatListDiffRequest\Constraints;
use Google\Cloud\WebRisk\V1beta1\ComputeThreatListDiffResponse;
use Google\Cloud\WebRisk\V1beta1\SearchHashesResponse;
use Google\Cloud\WebRisk\V1beta1\SearchUrisResponse;
use Google\Cloud\WebRisk\V1beta1\ThreatType;
use Google\Cloud\WebRisk\V1beta1\WebRiskServiceV1Beta1Client;
use Google\Rpc\Code;
use stdClass;

/**
 * @group webrisk
 *
 * @group gapic
 */
class WebRiskServiceV1Beta1ClientTest extends GeneratedTest
{
    /**
     * @return TransportInterface
     */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /**
     * @return CredentialsWrapper
     */
    private function createCredentials()
    {
        return $this->getMockBuilder(CredentialsWrapper::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * @return WebRiskServiceV1Beta1Client
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new WebRiskServiceV1Beta1Client($options);
    }

    /**
     * @test
     */
    public function computeThreatListDiffTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $newVersionToken = '115';
        $expectedResponse = new ComputeThreatListDiffResponse();
        $expectedResponse->setNewVersionToken($newVersionToken);
        $transport->addResponse($expectedResponse);
        // Mock request
        $threatType = ThreatType::THREAT_TYPE_UNSPECIFIED;
        $constraints = new Constraints();
        $response = $client->computeThreatListDiff($threatType, $constraints);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.webrisk.v1beta1.WebRiskServiceV1Beta1/ComputeThreatListDiff', $actualFuncCall);
        $actualValue = $actualRequestObject->getThreatType();
        $this->assertProtobufEquals($threatType, $actualValue);
        $actualValue = $actualRequestObject->getConstraints();
        $this->assertProtobufEquals($constraints, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function computeThreatListDiffExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $threatType = ThreatType::THREAT_TYPE_UNSPECIFIED;
        $constraints = new Constraints();
        try {
            $client->computeThreatListDiff($threatType, $constraints);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function searchHashesTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new SearchHashesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $threatTypes = [];
        $response = $client->searchHashes($threatTypes);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.webrisk.v1beta1.WebRiskServiceV1Beta1/SearchHashes', $actualFuncCall);
        $actualValue = $actualRequestObject->getThreatTypes();
        $this->assertProtobufEquals($threatTypes, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function searchHashesExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $threatTypes = [];
        try {
            $client->searchHashes($threatTypes);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function searchUrisTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new SearchUrisResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $uri = 'uri116076';
        $threatTypes = [];
        $response = $client->searchUris($uri, $threatTypes);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.webrisk.v1beta1.WebRiskServiceV1Beta1/SearchUris', $actualFuncCall);
        $actualValue = $actualRequestObject->getUri();
        $this->assertProtobufEquals($uri, $actualValue);
        $actualValue = $actualRequestObject->getThreatTypes();
        $this->assertProtobufEquals($threatTypes, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function searchUrisExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $uri = 'uri116076';
        $threatTypes = [];
        try {
            $client->searchUris($uri, $threatTypes);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }
}
