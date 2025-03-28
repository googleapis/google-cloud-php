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

namespace Google\Ads\AdManager\Tests\Unit\V1\Client;

use Google\Ads\AdManager\V1\Client\ReportServiceClient;
use Google\Ads\AdManager\V1\CreateReportRequest;
use Google\Ads\AdManager\V1\FetchReportResultRowsRequest;
use Google\Ads\AdManager\V1\FetchReportResultRowsResponse;
use Google\Ads\AdManager\V1\GetReportRequest;
use Google\Ads\AdManager\V1\ListReportsRequest;
use Google\Ads\AdManager\V1\ListReportsResponse;
use Google\Ads\AdManager\V1\Report;
use Google\Ads\AdManager\V1\ReportDefinition;
use Google\Ads\AdManager\V1\Report\DateRange;
use Google\Ads\AdManager\V1\Report\ReportType;
use Google\Ads\AdManager\V1\RunReportRequest;
use Google\Ads\AdManager\V1\RunReportResponse;
use Google\Ads\AdManager\V1\UpdateReportRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\LongRunning\Client\OperationsClient;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\FieldMask;
use Google\Rpc\Code;
use stdClass;

/**
 * @group admanager
 *
 * @group gapic
 */
class ReportServiceClientTest extends GeneratedTest
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

    /** @return ReportServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new ReportServiceClient($options);
    }

    /** @test */
    public function createReportTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $reportId = 353329146;
        $displayName = 'displayName1615086568';
        $locale = 'locale-1097462182';
        $expectedResponse = new Report();
        $expectedResponse->setName($name);
        $expectedResponse->setReportId($reportId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLocale($locale);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $report = new Report();
        $reportReportDefinition = new ReportDefinition();
        $reportDefinitionDimensions = [];
        $reportReportDefinition->setDimensions($reportDefinitionDimensions);
        $reportDefinitionMetrics = [];
        $reportReportDefinition->setMetrics($reportDefinitionMetrics);
        $reportDefinitionDateRange = new DateRange();
        $reportReportDefinition->setDateRange($reportDefinitionDateRange);
        $reportDefinitionReportType = ReportType::REPORT_TYPE_UNSPECIFIED;
        $reportReportDefinition->setReportType($reportDefinitionReportType);
        $report->setReportDefinition($reportReportDefinition);
        $request = (new CreateReportRequest())->setParent($formattedParent)->setReport($report);
        $response = $gapicClient->createReport($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ReportService/CreateReport', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getReport();
        $this->assertProtobufEquals($report, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createReportExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $report = new Report();
        $reportReportDefinition = new ReportDefinition();
        $reportDefinitionDimensions = [];
        $reportReportDefinition->setDimensions($reportDefinitionDimensions);
        $reportDefinitionMetrics = [];
        $reportReportDefinition->setMetrics($reportDefinitionMetrics);
        $reportDefinitionDateRange = new DateRange();
        $reportReportDefinition->setDateRange($reportDefinitionDateRange);
        $reportDefinitionReportType = ReportType::REPORT_TYPE_UNSPECIFIED;
        $reportReportDefinition->setReportType($reportDefinitionReportType);
        $report->setReportDefinition($reportReportDefinition);
        $request = (new CreateReportRequest())->setParent($formattedParent)->setReport($report);
        try {
            $gapicClient->createReport($request);
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
    public function fetchReportResultRowsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $totalRowCount = 1810281263;
        $nextPageToken = 'nextPageToken-1530815211';
        $expectedResponse = new FetchReportResultRowsResponse();
        $expectedResponse->setTotalRowCount($totalRowCount);
        $expectedResponse->setNextPageToken($nextPageToken);
        $transport->addResponse($expectedResponse);
        $request = new FetchReportResultRowsRequest();
        $response = $gapicClient->fetchReportResultRows($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ReportService/FetchReportResultRows', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function fetchReportResultRowsExceptionTest()
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
        $request = new FetchReportResultRowsRequest();
        try {
            $gapicClient->fetchReportResultRows($request);
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
    public function getReportTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $reportId = 353329146;
        $displayName = 'displayName1615086568';
        $locale = 'locale-1097462182';
        $expectedResponse = new Report();
        $expectedResponse->setName($name2);
        $expectedResponse->setReportId($reportId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLocale($locale);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->reportName('[NETWORK_CODE]', '[REPORT]');
        $request = (new GetReportRequest())->setName($formattedName);
        $response = $gapicClient->getReport($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ReportService/GetReport', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getReportExceptionTest()
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
        $formattedName = $gapicClient->reportName('[NETWORK_CODE]', '[REPORT]');
        $request = (new GetReportRequest())->setName($formattedName);
        try {
            $gapicClient->getReport($request);
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
    public function listReportsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $reportsElement = new Report();
        $reports = [$reportsElement];
        $expectedResponse = new ListReportsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setReports($reports);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListReportsRequest())->setParent($formattedParent);
        $response = $gapicClient->listReports($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getReports()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ReportService/ListReports', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listReportsExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListReportsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listReports($request);
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
    public function runReportTest()
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
        $incompleteOperation->setName('operations/runReportTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $reportResult = 'reportResult-778769016';
        $expectedResponse = new RunReportResponse();
        $expectedResponse->setReportResult($reportResult);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/runReportTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->reportName('[NETWORK_CODE]', '[REPORT]');
        $request = (new RunReportRequest())->setName($formattedName);
        $response = $gapicClient->runReport($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ReportService/RunReport', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/runReportTest');
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
    public function runReportExceptionTest()
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
        $incompleteOperation->setName('operations/runReportTest');
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
        $formattedName = $gapicClient->reportName('[NETWORK_CODE]', '[REPORT]');
        $request = (new RunReportRequest())->setName($formattedName);
        $response = $gapicClient->runReport($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/runReportTest');
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
    public function updateReportTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $reportId = 353329146;
        $displayName = 'displayName1615086568';
        $locale = 'locale-1097462182';
        $expectedResponse = new Report();
        $expectedResponse->setName($name);
        $expectedResponse->setReportId($reportId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLocale($locale);
        $transport->addResponse($expectedResponse);
        // Mock request
        $report = new Report();
        $reportReportDefinition = new ReportDefinition();
        $reportDefinitionDimensions = [];
        $reportReportDefinition->setDimensions($reportDefinitionDimensions);
        $reportDefinitionMetrics = [];
        $reportReportDefinition->setMetrics($reportDefinitionMetrics);
        $reportDefinitionDateRange = new DateRange();
        $reportReportDefinition->setDateRange($reportDefinitionDateRange);
        $reportDefinitionReportType = ReportType::REPORT_TYPE_UNSPECIFIED;
        $reportReportDefinition->setReportType($reportDefinitionReportType);
        $report->setReportDefinition($reportReportDefinition);
        $updateMask = new FieldMask();
        $request = (new UpdateReportRequest())->setReport($report)->setUpdateMask($updateMask);
        $response = $gapicClient->updateReport($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ReportService/UpdateReport', $actualFuncCall);
        $actualValue = $actualRequestObject->getReport();
        $this->assertProtobufEquals($report, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateReportExceptionTest()
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
        $report = new Report();
        $reportReportDefinition = new ReportDefinition();
        $reportDefinitionDimensions = [];
        $reportReportDefinition->setDimensions($reportDefinitionDimensions);
        $reportDefinitionMetrics = [];
        $reportReportDefinition->setMetrics($reportDefinitionMetrics);
        $reportDefinitionDateRange = new DateRange();
        $reportReportDefinition->setDateRange($reportDefinitionDateRange);
        $reportDefinitionReportType = ReportType::REPORT_TYPE_UNSPECIFIED;
        $reportReportDefinition->setReportType($reportDefinitionReportType);
        $report->setReportDefinition($reportReportDefinition);
        $updateMask = new FieldMask();
        $request = (new UpdateReportRequest())->setReport($report)->setUpdateMask($updateMask);
        try {
            $gapicClient->updateReport($request);
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
    public function createReportAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $reportId = 353329146;
        $displayName = 'displayName1615086568';
        $locale = 'locale-1097462182';
        $expectedResponse = new Report();
        $expectedResponse->setName($name);
        $expectedResponse->setReportId($reportId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLocale($locale);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $report = new Report();
        $reportReportDefinition = new ReportDefinition();
        $reportDefinitionDimensions = [];
        $reportReportDefinition->setDimensions($reportDefinitionDimensions);
        $reportDefinitionMetrics = [];
        $reportReportDefinition->setMetrics($reportDefinitionMetrics);
        $reportDefinitionDateRange = new DateRange();
        $reportReportDefinition->setDateRange($reportDefinitionDateRange);
        $reportDefinitionReportType = ReportType::REPORT_TYPE_UNSPECIFIED;
        $reportReportDefinition->setReportType($reportDefinitionReportType);
        $report->setReportDefinition($reportReportDefinition);
        $request = (new CreateReportRequest())->setParent($formattedParent)->setReport($report);
        $response = $gapicClient->createReportAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ReportService/CreateReport', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getReport();
        $this->assertProtobufEquals($report, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
