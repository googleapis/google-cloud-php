<?php
/*
 * Copyright 2023 Google LLC
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

namespace Google\Cloud\BinaryAuthorization\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\BinaryAuthorization\V1\Client\ValidationHelperV1Client;
use Google\Cloud\BinaryAuthorization\V1\ValidateAttestationOccurrenceRequest;
use Google\Cloud\BinaryAuthorization\V1\ValidateAttestationOccurrenceResponse;
use Google\Rpc\Code;
use Grafeas\V1\AttestationOccurrence;
use stdClass;

/**
 * @group binaryauthorization
 *
 * @group gapic
 */
class ValidationHelperV1ClientTest extends GeneratedTest
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

    /** @return ValidationHelperV1Client */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new ValidationHelperV1Client($options);
    }

    /** @test */
    public function validateAttestationOccurrenceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $denialReason = 'denialReason-884241828';
        $expectedResponse = new ValidateAttestationOccurrenceResponse();
        $expectedResponse->setDenialReason($denialReason);
        $transport->addResponse($expectedResponse);
        // Mock request
        $attestor = 'attestor542920680';
        $attestation = new AttestationOccurrence();
        $occurrenceNote = 'occurrenceNote1860303264';
        $occurrenceResourceUri = 'occurrenceResourceUri334806377';
        $request = (new ValidateAttestationOccurrenceRequest())
            ->setAttestor($attestor)
            ->setAttestation($attestation)
            ->setOccurrenceNote($occurrenceNote)
            ->setOccurrenceResourceUri($occurrenceResourceUri);
        $response = $gapicClient->validateAttestationOccurrence($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.binaryauthorization.v1.ValidationHelperV1/ValidateAttestationOccurrence', $actualFuncCall);
        $actualValue = $actualRequestObject->getAttestor();
        $this->assertProtobufEquals($attestor, $actualValue);
        $actualValue = $actualRequestObject->getAttestation();
        $this->assertProtobufEquals($attestation, $actualValue);
        $actualValue = $actualRequestObject->getOccurrenceNote();
        $this->assertProtobufEquals($occurrenceNote, $actualValue);
        $actualValue = $actualRequestObject->getOccurrenceResourceUri();
        $this->assertProtobufEquals($occurrenceResourceUri, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function validateAttestationOccurrenceExceptionTest()
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
        $attestor = 'attestor542920680';
        $attestation = new AttestationOccurrence();
        $occurrenceNote = 'occurrenceNote1860303264';
        $occurrenceResourceUri = 'occurrenceResourceUri334806377';
        $request = (new ValidateAttestationOccurrenceRequest())
            ->setAttestor($attestor)
            ->setAttestation($attestation)
            ->setOccurrenceNote($occurrenceNote)
            ->setOccurrenceResourceUri($occurrenceResourceUri);
        try {
            $gapicClient->validateAttestationOccurrence($request);
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
    public function validateAttestationOccurrenceAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $denialReason = 'denialReason-884241828';
        $expectedResponse = new ValidateAttestationOccurrenceResponse();
        $expectedResponse->setDenialReason($denialReason);
        $transport->addResponse($expectedResponse);
        // Mock request
        $attestor = 'attestor542920680';
        $attestation = new AttestationOccurrence();
        $occurrenceNote = 'occurrenceNote1860303264';
        $occurrenceResourceUri = 'occurrenceResourceUri334806377';
        $request = (new ValidateAttestationOccurrenceRequest())
            ->setAttestor($attestor)
            ->setAttestation($attestation)
            ->setOccurrenceNote($occurrenceNote)
            ->setOccurrenceResourceUri($occurrenceResourceUri);
        $response = $gapicClient->validateAttestationOccurrenceAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.binaryauthorization.v1.ValidationHelperV1/ValidateAttestationOccurrence', $actualFuncCall);
        $actualValue = $actualRequestObject->getAttestor();
        $this->assertProtobufEquals($attestor, $actualValue);
        $actualValue = $actualRequestObject->getAttestation();
        $this->assertProtobufEquals($attestation, $actualValue);
        $actualValue = $actualRequestObject->getOccurrenceNote();
        $this->assertProtobufEquals($occurrenceNote, $actualValue);
        $actualValue = $actualRequestObject->getOccurrenceResourceUri();
        $this->assertProtobufEquals($occurrenceResourceUri, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
