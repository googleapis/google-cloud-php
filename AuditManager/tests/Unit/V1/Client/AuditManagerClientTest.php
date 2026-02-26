<?php
/*
 * Copyright 2026 Google LLC
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

namespace Google\Cloud\AuditManager\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\AuditManager\V1\AuditReport;
use Google\Cloud\AuditManager\V1\AuditScopeReport;
use Google\Cloud\AuditManager\V1\Client\AuditManagerClient;
use Google\Cloud\AuditManager\V1\Control;
use Google\Cloud\AuditManager\V1\EnrollResourceRequest;
use Google\Cloud\AuditManager\V1\Enrollment;
use Google\Cloud\AuditManager\V1\GenerateAuditReportRequest;
use Google\Cloud\AuditManager\V1\GenerateAuditReportRequest\AuditReportFormat;
use Google\Cloud\AuditManager\V1\GenerateAuditScopeReportRequest;
use Google\Cloud\AuditManager\V1\GenerateAuditScopeReportRequest\AuditScopeReportFormat;
use Google\Cloud\AuditManager\V1\GetAuditReportRequest;
use Google\Cloud\AuditManager\V1\GetResourceEnrollmentStatusRequest;
use Google\Cloud\AuditManager\V1\ListAuditReportsRequest;
use Google\Cloud\AuditManager\V1\ListAuditReportsResponse;
use Google\Cloud\AuditManager\V1\ListControlsRequest;
use Google\Cloud\AuditManager\V1\ListControlsResponse;
use Google\Cloud\AuditManager\V1\ListResourceEnrollmentStatusesRequest;
use Google\Cloud\AuditManager\V1\ListResourceEnrollmentStatusesResponse;
use Google\Cloud\AuditManager\V1\ResourceEnrollmentStatus;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\LongRunning\Client\OperationsClient;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Rpc\Code;
use stdClass;

/**
 * @group auditmanager
 *
 * @group gapic
 */
class AuditManagerClientTest extends GeneratedTest
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

    /** @return AuditManagerClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AuditManagerClient($options);
    }

    /** @test */
    public function enrollResourceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new Enrollment();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $scope = 'scope109264468';
        $destinations = [];
        $request = (new EnrollResourceRequest())->setScope($scope)->setDestinations($destinations);
        $response = $gapicClient->enrollResource($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.auditmanager.v1.AuditManager/EnrollResource', $actualFuncCall);
        $actualValue = $actualRequestObject->getScope();
        $this->assertProtobufEquals($scope, $actualValue);
        $actualValue = $actualRequestObject->getDestinations();
        $this->assertProtobufEquals($destinations, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function enrollResourceExceptionTest()
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
        $scope = 'scope109264468';
        $destinations = [];
        $request = (new EnrollResourceRequest())->setScope($scope)->setDestinations($destinations);
        try {
            $gapicClient->enrollResource($request);
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
    public function generateAuditReportTest()
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
        $incompleteOperation->setName('operations/generateAuditReportTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $operationId = 'operationId-274116877';
        $complianceStandard2 = 'complianceStandard2-1079015980';
        $scope2 = 'scope21923941639';
        $complianceFramework2 = 'complianceFramework2-1333971955';
        $scopeId = 'scopeId-487349530';
        $expectedResponse = new AuditReport();
        $expectedResponse->setName($name);
        $expectedResponse->setOperationId($operationId);
        $expectedResponse->setComplianceStandard($complianceStandard2);
        $expectedResponse->setScope($scope2);
        $expectedResponse->setComplianceFramework($complianceFramework2);
        $expectedResponse->setScopeId($scopeId);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/generateAuditReportTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $scope = 'scope109264468';
        $complianceStandard = 'complianceStandard1339657825';
        $reportFormat = AuditReportFormat::AUDIT_REPORT_FORMAT_UNSPECIFIED;
        $complianceFramework = 'complianceFramework1384085210';
        $request = (new GenerateAuditReportRequest())
            ->setScope($scope)
            ->setComplianceStandard($complianceStandard)
            ->setReportFormat($reportFormat)
            ->setComplianceFramework($complianceFramework);
        $response = $gapicClient->generateAuditReport($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.auditmanager.v1.AuditManager/GenerateAuditReport', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getScope();
        $this->assertProtobufEquals($scope, $actualValue);
        $actualValue = $actualApiRequestObject->getComplianceStandard();
        $this->assertProtobufEquals($complianceStandard, $actualValue);
        $actualValue = $actualApiRequestObject->getReportFormat();
        $this->assertProtobufEquals($reportFormat, $actualValue);
        $actualValue = $actualApiRequestObject->getComplianceFramework();
        $this->assertProtobufEquals($complianceFramework, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/generateAuditReportTest');
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
    public function generateAuditReportExceptionTest()
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
        $incompleteOperation->setName('operations/generateAuditReportTest');
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
        $scope = 'scope109264468';
        $complianceStandard = 'complianceStandard1339657825';
        $reportFormat = AuditReportFormat::AUDIT_REPORT_FORMAT_UNSPECIFIED;
        $complianceFramework = 'complianceFramework1384085210';
        $request = (new GenerateAuditReportRequest())
            ->setScope($scope)
            ->setComplianceStandard($complianceStandard)
            ->setReportFormat($reportFormat)
            ->setComplianceFramework($complianceFramework);
        $response = $gapicClient->generateAuditReport($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/generateAuditReportTest');
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
    public function generateAuditScopeReportTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $scopeReportContents = '-38';
        $name = 'name3373707';
        $expectedResponse = new AuditScopeReport();
        $expectedResponse->setScopeReportContents($scopeReportContents);
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $scope = 'scope109264468';
        $complianceStandard = 'complianceStandard1339657825';
        $reportFormat = AuditScopeReportFormat::AUDIT_SCOPE_REPORT_FORMAT_UNSPECIFIED;
        $complianceFramework = 'complianceFramework1384085210';
        $request = (new GenerateAuditScopeReportRequest())
            ->setScope($scope)
            ->setComplianceStandard($complianceStandard)
            ->setReportFormat($reportFormat)
            ->setComplianceFramework($complianceFramework);
        $response = $gapicClient->generateAuditScopeReport($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.auditmanager.v1.AuditManager/GenerateAuditScopeReport', $actualFuncCall);
        $actualValue = $actualRequestObject->getScope();
        $this->assertProtobufEquals($scope, $actualValue);
        $actualValue = $actualRequestObject->getComplianceStandard();
        $this->assertProtobufEquals($complianceStandard, $actualValue);
        $actualValue = $actualRequestObject->getReportFormat();
        $this->assertProtobufEquals($reportFormat, $actualValue);
        $actualValue = $actualRequestObject->getComplianceFramework();
        $this->assertProtobufEquals($complianceFramework, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function generateAuditScopeReportExceptionTest()
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
        $scope = 'scope109264468';
        $complianceStandard = 'complianceStandard1339657825';
        $reportFormat = AuditScopeReportFormat::AUDIT_SCOPE_REPORT_FORMAT_UNSPECIFIED;
        $complianceFramework = 'complianceFramework1384085210';
        $request = (new GenerateAuditScopeReportRequest())
            ->setScope($scope)
            ->setComplianceStandard($complianceStandard)
            ->setReportFormat($reportFormat)
            ->setComplianceFramework($complianceFramework);
        try {
            $gapicClient->generateAuditScopeReport($request);
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
    public function getAuditReportTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $operationId = 'operationId-274116877';
        $complianceStandard = 'complianceStandard1339657825';
        $scope = 'scope109264468';
        $complianceFramework = 'complianceFramework1384085210';
        $scopeId = 'scopeId-487349530';
        $expectedResponse = new AuditReport();
        $expectedResponse->setName($name2);
        $expectedResponse->setOperationId($operationId);
        $expectedResponse->setComplianceStandard($complianceStandard);
        $expectedResponse->setScope($scope);
        $expectedResponse->setComplianceFramework($complianceFramework);
        $expectedResponse->setScopeId($scopeId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->auditReportName('[PROJECT]', '[LOCATION]', '[AUDIT_REPORT]');
        $request = (new GetAuditReportRequest())->setName($formattedName);
        $response = $gapicClient->getAuditReport($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.auditmanager.v1.AuditManager/GetAuditReport', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAuditReportExceptionTest()
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
        $formattedName = $gapicClient->auditReportName('[PROJECT]', '[LOCATION]', '[AUDIT_REPORT]');
        $request = (new GetAuditReportRequest())->setName($formattedName);
        try {
            $gapicClient->getAuditReport($request);
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
    public function getResourceEnrollmentStatusTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $enrolled = false;
        $displayName = 'displayName1615086568';
        $expectedResponse = new ResourceEnrollmentStatus();
        $expectedResponse->setName($name2);
        $expectedResponse->setEnrolled($enrolled);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->resourceEnrollmentStatusName(
            '[FOLDER]',
            '[LOCATION]',
            '[RESOURCE_ENROLLMENT_STATUS]'
        );
        $request = (new GetResourceEnrollmentStatusRequest())->setName($formattedName);
        $response = $gapicClient->getResourceEnrollmentStatus($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.auditmanager.v1.AuditManager/GetResourceEnrollmentStatus', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getResourceEnrollmentStatusExceptionTest()
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
        $formattedName = $gapicClient->resourceEnrollmentStatusName(
            '[FOLDER]',
            '[LOCATION]',
            '[RESOURCE_ENROLLMENT_STATUS]'
        );
        $request = (new GetResourceEnrollmentStatusRequest())->setName($formattedName);
        try {
            $gapicClient->getResourceEnrollmentStatus($request);
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
    public function listAuditReportsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $auditReportsElement = new AuditReport();
        $auditReports = [$auditReportsElement];
        $expectedResponse = new ListAuditReportsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAuditReports($auditReports);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->folderLocationName('[FOLDER]', '[LOCATION]');
        $request = (new ListAuditReportsRequest())->setParent($formattedParent);
        $response = $gapicClient->listAuditReports($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAuditReports()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.auditmanager.v1.AuditManager/ListAuditReports', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAuditReportsExceptionTest()
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
        $formattedParent = $gapicClient->folderLocationName('[FOLDER]', '[LOCATION]');
        $request = (new ListAuditReportsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listAuditReports($request);
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
    public function listControlsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $controlsElement = new Control();
        $controls = [$controlsElement];
        $expectedResponse = new ListControlsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setControls($controls);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->standardName('[PROJECT]', '[LOCATION]', '[STANDARD]');
        $request = (new ListControlsRequest())->setParent($formattedParent);
        $response = $gapicClient->listControls($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getControls()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.auditmanager.v1.AuditManager/ListControls', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listControlsExceptionTest()
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
        $formattedParent = $gapicClient->standardName('[PROJECT]', '[LOCATION]', '[STANDARD]');
        $request = (new ListControlsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listControls($request);
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
    public function listResourceEnrollmentStatusesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $resourceEnrollmentStatusesElement = new ResourceEnrollmentStatus();
        $resourceEnrollmentStatuses = [$resourceEnrollmentStatusesElement];
        $expectedResponse = new ListResourceEnrollmentStatusesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setResourceEnrollmentStatuses($resourceEnrollmentStatuses);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->enrollmentStatusScopeName('[FOLDER]', '[LOCATION]');
        $request = (new ListResourceEnrollmentStatusesRequest())->setParent($formattedParent);
        $response = $gapicClient->listResourceEnrollmentStatuses($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getResourceEnrollmentStatuses()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.auditmanager.v1.AuditManager/ListResourceEnrollmentStatuses', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listResourceEnrollmentStatusesExceptionTest()
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
        $formattedParent = $gapicClient->enrollmentStatusScopeName('[FOLDER]', '[LOCATION]');
        $request = (new ListResourceEnrollmentStatusesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listResourceEnrollmentStatuses($request);
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
    public function getLocationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $locationId = 'locationId552319461';
        $displayName = 'displayName1615086568';
        $expectedResponse = new Location();
        $expectedResponse->setName($name2);
        $expectedResponse->setLocationId($locationId);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        $request = new GetLocationRequest();
        $response = $gapicClient->getLocation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.location.Locations/GetLocation', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getLocationExceptionTest()
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
        $request = new GetLocationRequest();
        try {
            $gapicClient->getLocation($request);
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
    public function listLocationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $locationsElement = new Location();
        $locations = [$locationsElement];
        $expectedResponse = new ListLocationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setLocations($locations);
        $transport->addResponse($expectedResponse);
        $request = new ListLocationsRequest();
        $response = $gapicClient->listLocations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getLocations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.location.Locations/ListLocations', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listLocationsExceptionTest()
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
        $request = new ListLocationsRequest();
        try {
            $gapicClient->listLocations($request);
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
    public function enrollResourceAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new Enrollment();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $scope = 'scope109264468';
        $destinations = [];
        $request = (new EnrollResourceRequest())->setScope($scope)->setDestinations($destinations);
        $response = $gapicClient->enrollResourceAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.auditmanager.v1.AuditManager/EnrollResource', $actualFuncCall);
        $actualValue = $actualRequestObject->getScope();
        $this->assertProtobufEquals($scope, $actualValue);
        $actualValue = $actualRequestObject->getDestinations();
        $this->assertProtobufEquals($destinations, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
