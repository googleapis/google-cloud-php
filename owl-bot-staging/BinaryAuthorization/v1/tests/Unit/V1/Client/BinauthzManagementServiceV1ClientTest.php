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
use Google\Cloud\BinaryAuthorization\V1\AdmissionRule;
use Google\Cloud\BinaryAuthorization\V1\AdmissionRule\EnforcementMode;
use Google\Cloud\BinaryAuthorization\V1\AdmissionRule\EvaluationMode;
use Google\Cloud\BinaryAuthorization\V1\Attestor;
use Google\Cloud\BinaryAuthorization\V1\Client\BinauthzManagementServiceV1Client;
use Google\Cloud\BinaryAuthorization\V1\CreateAttestorRequest;
use Google\Cloud\BinaryAuthorization\V1\DeleteAttestorRequest;
use Google\Cloud\BinaryAuthorization\V1\GetAttestorRequest;
use Google\Cloud\BinaryAuthorization\V1\GetPolicyRequest;
use Google\Cloud\BinaryAuthorization\V1\ListAttestorsRequest;
use Google\Cloud\BinaryAuthorization\V1\ListAttestorsResponse;
use Google\Cloud\BinaryAuthorization\V1\Policy;
use Google\Cloud\BinaryAuthorization\V1\UpdateAttestorRequest;
use Google\Cloud\BinaryAuthorization\V1\UpdatePolicyRequest;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group binaryauthorization
 *
 * @group gapic
 */
class BinauthzManagementServiceV1ClientTest extends GeneratedTest
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

    /** @return BinauthzManagementServiceV1Client */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new BinauthzManagementServiceV1Client($options);
    }

    /** @test */
    public function createAttestorTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $expectedResponse = new Attestor();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $attestorId = 'attestorId-696764206';
        $attestor = new Attestor();
        $attestorName = 'attestorName-125367661';
        $attestor->setName($attestorName);
        $request = (new CreateAttestorRequest())
            ->setParent($formattedParent)
            ->setAttestorId($attestorId)
            ->setAttestor($attestor);
        $response = $gapicClient->createAttestor($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.binaryauthorization.v1.BinauthzManagementServiceV1/CreateAttestor', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAttestorId();
        $this->assertProtobufEquals($attestorId, $actualValue);
        $actualValue = $actualRequestObject->getAttestor();
        $this->assertProtobufEquals($attestor, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createAttestorExceptionTest()
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
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $attestorId = 'attestorId-696764206';
        $attestor = new Attestor();
        $attestorName = 'attestorName-125367661';
        $attestor->setName($attestorName);
        $request = (new CreateAttestorRequest())
            ->setParent($formattedParent)
            ->setAttestorId($attestorId)
            ->setAttestor($attestor);
        try {
            $gapicClient->createAttestor($request);
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
    public function deleteAttestorTest()
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
        $formattedName = $gapicClient->attestorName('[PROJECT]', '[ATTESTOR]');
        $request = (new DeleteAttestorRequest())
            ->setName($formattedName);
        $gapicClient->deleteAttestor($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.binaryauthorization.v1.BinauthzManagementServiceV1/DeleteAttestor', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteAttestorExceptionTest()
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
        $formattedName = $gapicClient->attestorName('[PROJECT]', '[ATTESTOR]');
        $request = (new DeleteAttestorRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteAttestor($request);
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
    public function getAttestorTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $expectedResponse = new Attestor();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->attestorName('[PROJECT]', '[ATTESTOR]');
        $request = (new GetAttestorRequest())
            ->setName($formattedName);
        $response = $gapicClient->getAttestor($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.binaryauthorization.v1.BinauthzManagementServiceV1/GetAttestor', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAttestorExceptionTest()
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
        $formattedName = $gapicClient->attestorName('[PROJECT]', '[ATTESTOR]');
        $request = (new GetAttestorRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getAttestor($request);
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
    public function getPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $expectedResponse = new Policy();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->policyName('[PROJECT]');
        $request = (new GetPolicyRequest())
            ->setName($formattedName);
        $response = $gapicClient->getPolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.binaryauthorization.v1.BinauthzManagementServiceV1/GetPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getPolicyExceptionTest()
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
        $formattedName = $gapicClient->policyName('[PROJECT]');
        $request = (new GetPolicyRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getPolicy($request);
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
    public function listAttestorsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $attestorsElement = new Attestor();
        $attestors = [
            $attestorsElement,
        ];
        $expectedResponse = new ListAttestorsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAttestors($attestors);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListAttestorsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listAttestors($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAttestors()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.binaryauthorization.v1.BinauthzManagementServiceV1/ListAttestors', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAttestorsExceptionTest()
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
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListAttestorsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listAttestors($request);
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
    public function updateAttestorTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $expectedResponse = new Attestor();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $attestor = new Attestor();
        $attestorName = 'attestorName-125367661';
        $attestor->setName($attestorName);
        $request = (new UpdateAttestorRequest())
            ->setAttestor($attestor);
        $response = $gapicClient->updateAttestor($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.binaryauthorization.v1.BinauthzManagementServiceV1/UpdateAttestor', $actualFuncCall);
        $actualValue = $actualRequestObject->getAttestor();
        $this->assertProtobufEquals($attestor, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateAttestorExceptionTest()
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
        $attestor = new Attestor();
        $attestorName = 'attestorName-125367661';
        $attestor->setName($attestorName);
        $request = (new UpdateAttestorRequest())
            ->setAttestor($attestor);
        try {
            $gapicClient->updateAttestor($request);
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
    public function updatePolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $expectedResponse = new Policy();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $policy = new Policy();
        $policyDefaultAdmissionRule = new AdmissionRule();
        $defaultAdmissionRuleEvaluationMode = EvaluationMode::EVALUATION_MODE_UNSPECIFIED;
        $policyDefaultAdmissionRule->setEvaluationMode($defaultAdmissionRuleEvaluationMode);
        $defaultAdmissionRuleEnforcementMode = EnforcementMode::ENFORCEMENT_MODE_UNSPECIFIED;
        $policyDefaultAdmissionRule->setEnforcementMode($defaultAdmissionRuleEnforcementMode);
        $policy->setDefaultAdmissionRule($policyDefaultAdmissionRule);
        $request = (new UpdatePolicyRequest())
            ->setPolicy($policy);
        $response = $gapicClient->updatePolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.binaryauthorization.v1.BinauthzManagementServiceV1/UpdatePolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getPolicy();
        $this->assertProtobufEquals($policy, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updatePolicyExceptionTest()
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
        $policy = new Policy();
        $policyDefaultAdmissionRule = new AdmissionRule();
        $defaultAdmissionRuleEvaluationMode = EvaluationMode::EVALUATION_MODE_UNSPECIFIED;
        $policyDefaultAdmissionRule->setEvaluationMode($defaultAdmissionRuleEvaluationMode);
        $defaultAdmissionRuleEnforcementMode = EnforcementMode::ENFORCEMENT_MODE_UNSPECIFIED;
        $policyDefaultAdmissionRule->setEnforcementMode($defaultAdmissionRuleEnforcementMode);
        $policy->setDefaultAdmissionRule($policyDefaultAdmissionRule);
        $request = (new UpdatePolicyRequest())
            ->setPolicy($policy);
        try {
            $gapicClient->updatePolicy($request);
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
    public function createAttestorAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $expectedResponse = new Attestor();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $attestorId = 'attestorId-696764206';
        $attestor = new Attestor();
        $attestorName = 'attestorName-125367661';
        $attestor->setName($attestorName);
        $request = (new CreateAttestorRequest())
            ->setParent($formattedParent)
            ->setAttestorId($attestorId)
            ->setAttestor($attestor);
        $response = $gapicClient->createAttestorAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.binaryauthorization.v1.BinauthzManagementServiceV1/CreateAttestor', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAttestorId();
        $this->assertProtobufEquals($attestorId, $actualValue);
        $actualValue = $actualRequestObject->getAttestor();
        $this->assertProtobufEquals($attestor, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
