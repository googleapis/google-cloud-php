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

namespace Google\Cloud\WebRisk\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\WebRisk\V1\Client\WebRiskServiceClient;
use Google\Cloud\WebRisk\V1\ComputeThreatListDiffRequest;
use Google\Cloud\WebRisk\V1\ComputeThreatListDiffRequest\Constraints;
use Google\Cloud\WebRisk\V1\ComputeThreatListDiffResponse;
use Google\Cloud\WebRisk\V1\CreateSubmissionRequest;
use Google\Cloud\WebRisk\V1\SearchHashesRequest;
use Google\Cloud\WebRisk\V1\SearchHashesResponse;
use Google\Cloud\WebRisk\V1\SearchUrisRequest;
use Google\Cloud\WebRisk\V1\SearchUrisResponse;
use Google\Cloud\WebRisk\V1\Submission;
use Google\Cloud\WebRisk\V1\SubmitUriRequest;
use Google\Cloud\WebRisk\V1\ThreatType;
use Google\LongRunning\Client\OperationsClient;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Rpc\Code;
use stdClass;

/**
 * @group webrisk
 *
 * @group gapic
 */
class WebRiskServiceClientTest extends GeneratedTest
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

    /** @return WebRiskServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new WebRiskServiceClient($options);
    }

    /** @test */
    public function computeThreatListDiffTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
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
        $request = (new ComputeThreatListDiffRequest())->setThreatType($threatType)->setConstraints($constraints);
        $response = $gapicClient->computeThreatListDiff($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.webrisk.v1.WebRiskService/ComputeThreatListDiff', $actualFuncCall);
        $actualValue = $actualRequestObject->getThreatType();
        $this->assertProtobufEquals($threatType, $actualValue);
        $actualValue = $actualRequestObject->getConstraints();
        $this->assertProtobufEquals($constraints, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function computeThreatListDiffExceptionTest()
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
        $threatType = ThreatType::THREAT_TYPE_UNSPECIFIED;
        $constraints = new Constraints();
        $request = (new ComputeThreatListDiffRequest())->setThreatType($threatType)->setConstraints($constraints);
        try {
            $gapicClient->computeThreatListDiff($request);
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
    public function createSubmissionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $uri = 'uri116076';
        $expectedResponse = new Submission();
        $expectedResponse->setUri($uri);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $submission = new Submission();
        $submissionUri = 'submissionUri-1560297856';
        $submission->setUri($submissionUri);
        $request = (new CreateSubmissionRequest())->setParent($formattedParent)->setSubmission($submission);
        $response = $gapicClient->createSubmission($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.webrisk.v1.WebRiskService/CreateSubmission', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getSubmission();
        $this->assertProtobufEquals($submission, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createSubmissionExceptionTest()
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
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $submission = new Submission();
        $submissionUri = 'submissionUri-1560297856';
        $submission->setUri($submissionUri);
        $request = (new CreateSubmissionRequest())->setParent($formattedParent)->setSubmission($submission);
        try {
            $gapicClient->createSubmission($request);
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
    public function searchHashesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new SearchHashesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $threatTypes = [];
        $request = (new SearchHashesRequest())->setThreatTypes($threatTypes);
        $response = $gapicClient->searchHashes($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.webrisk.v1.WebRiskService/SearchHashes', $actualFuncCall);
        $actualValue = $actualRequestObject->getThreatTypes();
        $this->assertProtobufEquals($threatTypes, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchHashesExceptionTest()
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
        $threatTypes = [];
        $request = (new SearchHashesRequest())->setThreatTypes($threatTypes);
        try {
            $gapicClient->searchHashes($request);
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
    public function searchUrisTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new SearchUrisResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $uri = 'uri116076';
        $threatTypes = [];
        $request = (new SearchUrisRequest())->setUri($uri)->setThreatTypes($threatTypes);
        $response = $gapicClient->searchUris($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.webrisk.v1.WebRiskService/SearchUris', $actualFuncCall);
        $actualValue = $actualRequestObject->getUri();
        $this->assertProtobufEquals($uri, $actualValue);
        $actualValue = $actualRequestObject->getThreatTypes();
        $this->assertProtobufEquals($threatTypes, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchUrisExceptionTest()
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
        $uri = 'uri116076';
        $threatTypes = [];
        $request = (new SearchUrisRequest())->setUri($uri)->setThreatTypes($threatTypes);
        try {
            $gapicClient->searchUris($request);
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
    public function submitUriTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/submitUriTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $uri = 'uri116076';
        $expectedResponse = new Submission();
        $expectedResponse->setUri($uri);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/submitUriTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $submission = new Submission();
        $submissionUri = 'submissionUri-1560297856';
        $submission->setUri($submissionUri);
        $request = (new SubmitUriRequest())->setParent($formattedParent)->setSubmission($submission);
        $response = $gapicClient->submitUri($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.webrisk.v1.WebRiskService/SubmitUri', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getSubmission();
        $this->assertProtobufEquals($submission, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/submitUriTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function submitUriExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/submitUriTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
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
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $submission = new Submission();
        $submissionUri = 'submissionUri-1560297856';
        $submission->setUri($submissionUri);
        $request = (new SubmitUriRequest())->setParent($formattedParent)->setSubmission($submission);
        $response = $gapicClient->submitUri($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/submitUriTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function computeThreatListDiffAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
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
        $request = (new ComputeThreatListDiffRequest())->setThreatType($threatType)->setConstraints($constraints);
        $response = $gapicClient->computeThreatListDiffAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.webrisk.v1.WebRiskService/ComputeThreatListDiff', $actualFuncCall);
        $actualValue = $actualRequestObject->getThreatType();
        $this->assertProtobufEquals($threatType, $actualValue);
        $actualValue = $actualRequestObject->getConstraints();
        $this->assertProtobufEquals($constraints, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
