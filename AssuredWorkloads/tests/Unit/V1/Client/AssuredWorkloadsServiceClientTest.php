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

namespace Google\Cloud\AssuredWorkloads\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\AssuredWorkloads\V1\AcknowledgeViolationRequest;
use Google\Cloud\AssuredWorkloads\V1\AcknowledgeViolationResponse;
use Google\Cloud\AssuredWorkloads\V1\Client\AssuredWorkloadsServiceClient;
use Google\Cloud\AssuredWorkloads\V1\CreateWorkloadRequest;
use Google\Cloud\AssuredWorkloads\V1\DeleteWorkloadRequest;
use Google\Cloud\AssuredWorkloads\V1\GetViolationRequest;
use Google\Cloud\AssuredWorkloads\V1\GetWorkloadRequest;
use Google\Cloud\AssuredWorkloads\V1\ListViolationsRequest;
use Google\Cloud\AssuredWorkloads\V1\ListViolationsResponse;
use Google\Cloud\AssuredWorkloads\V1\ListWorkloadsRequest;
use Google\Cloud\AssuredWorkloads\V1\ListWorkloadsResponse;
use Google\Cloud\AssuredWorkloads\V1\RestrictAllowedResourcesRequest;
use Google\Cloud\AssuredWorkloads\V1\RestrictAllowedResourcesRequest\RestrictionType;
use Google\Cloud\AssuredWorkloads\V1\RestrictAllowedResourcesResponse;
use Google\Cloud\AssuredWorkloads\V1\UpdateWorkloadRequest;
use Google\Cloud\AssuredWorkloads\V1\Violation;
use Google\Cloud\AssuredWorkloads\V1\Workload;
use Google\Cloud\AssuredWorkloads\V1\Workload\ComplianceRegime;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group assuredworkloads
 *
 * @group gapic
 */
class AssuredWorkloadsServiceClientTest extends GeneratedTest
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

    /** @return AssuredWorkloadsServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AssuredWorkloadsServiceClient($options);
    }

    /** @test */
    public function acknowledgeViolationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new AcknowledgeViolationResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $comment = 'comment950398559';
        $request = (new AcknowledgeViolationRequest())
            ->setName($name)
            ->setComment($comment);
        $response = $gapicClient->acknowledgeViolation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.assuredworkloads.v1.AssuredWorkloadsService/AcknowledgeViolation', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualRequestObject->getComment();
        $this->assertProtobufEquals($comment, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function acknowledgeViolationExceptionTest()
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
        $comment = 'comment950398559';
        $request = (new AcknowledgeViolationRequest())
            ->setName($name)
            ->setComment($comment);
        try {
            $gapicClient->acknowledgeViolation($request);
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
    public function createWorkloadTest()
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
        $incompleteOperation->setName('operations/createWorkloadTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $billingAccount = 'billingAccount-545871767';
        $etag = 'etag3123477';
        $provisionedResourcesParent = 'provisionedResourcesParent-158134097';
        $enableSovereignControls = false;
        $expectedResponse = new Workload();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setBillingAccount($billingAccount);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setProvisionedResourcesParent($provisionedResourcesParent);
        $expectedResponse->setEnableSovereignControls($enableSovereignControls);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createWorkloadTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[ORGANIZATION]', '[LOCATION]');
        $workload = new Workload();
        $workloadDisplayName = 'workloadDisplayName191619702';
        $workload->setDisplayName($workloadDisplayName);
        $workloadComplianceRegime = ComplianceRegime::COMPLIANCE_REGIME_UNSPECIFIED;
        $workload->setComplianceRegime($workloadComplianceRegime);
        $request = (new CreateWorkloadRequest())
            ->setParent($formattedParent)
            ->setWorkload($workload);
        $response = $gapicClient->createWorkload($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.assuredworkloads.v1.AssuredWorkloadsService/CreateWorkload', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getWorkload();
        $this->assertProtobufEquals($workload, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createWorkloadTest');
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
    public function createWorkloadExceptionTest()
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
        $incompleteOperation->setName('operations/createWorkloadTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->locationName('[ORGANIZATION]', '[LOCATION]');
        $workload = new Workload();
        $workloadDisplayName = 'workloadDisplayName191619702';
        $workload->setDisplayName($workloadDisplayName);
        $workloadComplianceRegime = ComplianceRegime::COMPLIANCE_REGIME_UNSPECIFIED;
        $workload->setComplianceRegime($workloadComplianceRegime);
        $request = (new CreateWorkloadRequest())
            ->setParent($formattedParent)
            ->setWorkload($workload);
        $response = $gapicClient->createWorkload($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createWorkloadTest');
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
    public function deleteWorkloadTest()
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
        $formattedName = $gapicClient->workloadName('[ORGANIZATION]', '[LOCATION]', '[WORKLOAD]');
        $request = (new DeleteWorkloadRequest())
            ->setName($formattedName);
        $gapicClient->deleteWorkload($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.assuredworkloads.v1.AssuredWorkloadsService/DeleteWorkload', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteWorkloadExceptionTest()
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
        $formattedName = $gapicClient->workloadName('[ORGANIZATION]', '[LOCATION]', '[WORKLOAD]');
        $request = (new DeleteWorkloadRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteWorkload($request);
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
    public function getViolationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $category = 'category50511102';
        $orgPolicyConstraint = 'orgPolicyConstraint139795055';
        $auditLogLink = 'auditLogLink-657658887';
        $nonCompliantOrgPolicy = 'nonCompliantOrgPolicy-1555127741';
        $acknowledged = true;
        $exceptionAuditLogLink = 'exceptionAuditLogLink1901265385';
        $expectedResponse = new Violation();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setCategory($category);
        $expectedResponse->setOrgPolicyConstraint($orgPolicyConstraint);
        $expectedResponse->setAuditLogLink($auditLogLink);
        $expectedResponse->setNonCompliantOrgPolicy($nonCompliantOrgPolicy);
        $expectedResponse->setAcknowledged($acknowledged);
        $expectedResponse->setExceptionAuditLogLink($exceptionAuditLogLink);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->violationName('[ORGANIZATION]', '[LOCATION]', '[WORKLOAD]', '[VIOLATION]');
        $request = (new GetViolationRequest())
            ->setName($formattedName);
        $response = $gapicClient->getViolation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.assuredworkloads.v1.AssuredWorkloadsService/GetViolation', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getViolationExceptionTest()
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
        $formattedName = $gapicClient->violationName('[ORGANIZATION]', '[LOCATION]', '[WORKLOAD]', '[VIOLATION]');
        $request = (new GetViolationRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getViolation($request);
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
    public function getWorkloadTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $billingAccount = 'billingAccount-545871767';
        $etag = 'etag3123477';
        $provisionedResourcesParent = 'provisionedResourcesParent-158134097';
        $enableSovereignControls = false;
        $expectedResponse = new Workload();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setBillingAccount($billingAccount);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setProvisionedResourcesParent($provisionedResourcesParent);
        $expectedResponse->setEnableSovereignControls($enableSovereignControls);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->workloadName('[ORGANIZATION]', '[LOCATION]', '[WORKLOAD]');
        $request = (new GetWorkloadRequest())
            ->setName($formattedName);
        $response = $gapicClient->getWorkload($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.assuredworkloads.v1.AssuredWorkloadsService/GetWorkload', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getWorkloadExceptionTest()
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
        $formattedName = $gapicClient->workloadName('[ORGANIZATION]', '[LOCATION]', '[WORKLOAD]');
        $request = (new GetWorkloadRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getWorkload($request);
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
    public function listViolationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $violationsElement = new Violation();
        $violations = [
            $violationsElement,
        ];
        $expectedResponse = new ListViolationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setViolations($violations);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->workloadName('[ORGANIZATION]', '[LOCATION]', '[WORKLOAD]');
        $request = (new ListViolationsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listViolations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getViolations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.assuredworkloads.v1.AssuredWorkloadsService/ListViolations', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listViolationsExceptionTest()
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
        $formattedParent = $gapicClient->workloadName('[ORGANIZATION]', '[LOCATION]', '[WORKLOAD]');
        $request = (new ListViolationsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listViolations($request);
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
    public function listWorkloadsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $workloadsElement = new Workload();
        $workloads = [
            $workloadsElement,
        ];
        $expectedResponse = new ListWorkloadsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setWorkloads($workloads);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[ORGANIZATION]', '[LOCATION]');
        $request = (new ListWorkloadsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listWorkloads($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getWorkloads()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.assuredworkloads.v1.AssuredWorkloadsService/ListWorkloads', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listWorkloadsExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[ORGANIZATION]', '[LOCATION]');
        $request = (new ListWorkloadsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listWorkloads($request);
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
    public function restrictAllowedResourcesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new RestrictAllowedResourcesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $restrictionType = RestrictionType::RESTRICTION_TYPE_UNSPECIFIED;
        $request = (new RestrictAllowedResourcesRequest())
            ->setName($name)
            ->setRestrictionType($restrictionType);
        $response = $gapicClient->restrictAllowedResources($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.assuredworkloads.v1.AssuredWorkloadsService/RestrictAllowedResources', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualRequestObject->getRestrictionType();
        $this->assertProtobufEquals($restrictionType, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function restrictAllowedResourcesExceptionTest()
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
        $restrictionType = RestrictionType::RESTRICTION_TYPE_UNSPECIFIED;
        $request = (new RestrictAllowedResourcesRequest())
            ->setName($name)
            ->setRestrictionType($restrictionType);
        try {
            $gapicClient->restrictAllowedResources($request);
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
    public function updateWorkloadTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $billingAccount = 'billingAccount-545871767';
        $etag = 'etag3123477';
        $provisionedResourcesParent = 'provisionedResourcesParent-158134097';
        $enableSovereignControls = false;
        $expectedResponse = new Workload();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setBillingAccount($billingAccount);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setProvisionedResourcesParent($provisionedResourcesParent);
        $expectedResponse->setEnableSovereignControls($enableSovereignControls);
        $transport->addResponse($expectedResponse);
        // Mock request
        $workload = new Workload();
        $workloadDisplayName = 'workloadDisplayName191619702';
        $workload->setDisplayName($workloadDisplayName);
        $workloadComplianceRegime = ComplianceRegime::COMPLIANCE_REGIME_UNSPECIFIED;
        $workload->setComplianceRegime($workloadComplianceRegime);
        $updateMask = new FieldMask();
        $request = (new UpdateWorkloadRequest())
            ->setWorkload($workload)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateWorkload($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.assuredworkloads.v1.AssuredWorkloadsService/UpdateWorkload', $actualFuncCall);
        $actualValue = $actualRequestObject->getWorkload();
        $this->assertProtobufEquals($workload, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateWorkloadExceptionTest()
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
        $workload = new Workload();
        $workloadDisplayName = 'workloadDisplayName191619702';
        $workload->setDisplayName($workloadDisplayName);
        $workloadComplianceRegime = ComplianceRegime::COMPLIANCE_REGIME_UNSPECIFIED;
        $workload->setComplianceRegime($workloadComplianceRegime);
        $updateMask = new FieldMask();
        $request = (new UpdateWorkloadRequest())
            ->setWorkload($workload)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateWorkload($request);
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
    public function acknowledgeViolationAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new AcknowledgeViolationResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $comment = 'comment950398559';
        $request = (new AcknowledgeViolationRequest())
            ->setName($name)
            ->setComment($comment);
        $response = $gapicClient->acknowledgeViolationAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.assuredworkloads.v1.AssuredWorkloadsService/AcknowledgeViolation', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualRequestObject->getComment();
        $this->assertProtobufEquals($comment, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
