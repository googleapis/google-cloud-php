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

namespace Google\Analytics\Data\Tests\Unit\V1alpha\Client;

use Google\Analytics\Data\V1alpha\AudienceList;
use Google\Analytics\Data\V1alpha\Client\AlphaAnalyticsDataClient;
use Google\Analytics\Data\V1alpha\CreateAudienceListRequest;
use Google\Analytics\Data\V1alpha\CreateRecurringAudienceListRequest;
use Google\Analytics\Data\V1alpha\CreateReportTaskRequest;
use Google\Analytics\Data\V1alpha\GetAudienceListRequest;
use Google\Analytics\Data\V1alpha\GetRecurringAudienceListRequest;
use Google\Analytics\Data\V1alpha\GetReportTaskRequest;
use Google\Analytics\Data\V1alpha\ListAudienceListsRequest;
use Google\Analytics\Data\V1alpha\ListAudienceListsResponse;
use Google\Analytics\Data\V1alpha\ListRecurringAudienceListsRequest;
use Google\Analytics\Data\V1alpha\ListRecurringAudienceListsResponse;
use Google\Analytics\Data\V1alpha\ListReportTasksRequest;
use Google\Analytics\Data\V1alpha\ListReportTasksResponse;
use Google\Analytics\Data\V1alpha\QueryAudienceListRequest;
use Google\Analytics\Data\V1alpha\QueryAudienceListResponse;
use Google\Analytics\Data\V1alpha\QueryReportTaskRequest;
use Google\Analytics\Data\V1alpha\QueryReportTaskResponse;
use Google\Analytics\Data\V1alpha\RecurringAudienceList;
use Google\Analytics\Data\V1alpha\ReportTask;
use Google\Analytics\Data\V1alpha\RunFunnelReportRequest;
use Google\Analytics\Data\V1alpha\RunFunnelReportResponse;
use Google\Analytics\Data\V1alpha\SheetExportAudienceListRequest;
use Google\Analytics\Data\V1alpha\SheetExportAudienceListResponse;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Rpc\Code;
use stdClass;

/**
 * @group data
 *
 * @group gapic
 */
class AlphaAnalyticsDataClientTest extends GeneratedTest
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

    /** @return AlphaAnalyticsDataClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AlphaAnalyticsDataClient($options);
    }

    /** @test */
    public function createAudienceListTest()
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
        $incompleteOperation->setName('operations/createAudienceListTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $audience = 'audience975628804';
        $audienceDisplayName = 'audienceDisplayName406858307';
        $creationQuotaTokensCharged = 1232901266;
        $rowCount = 1340416618;
        $errorMessage = 'errorMessage-1938755376';
        $percentageCompleted = -1.29204764E8;
        $recurringAudienceList = 'recurringAudienceList2056789015';
        $expectedResponse = new AudienceList();
        $expectedResponse->setName($name);
        $expectedResponse->setAudience($audience);
        $expectedResponse->setAudienceDisplayName($audienceDisplayName);
        $expectedResponse->setCreationQuotaTokensCharged($creationQuotaTokensCharged);
        $expectedResponse->setRowCount($rowCount);
        $expectedResponse->setErrorMessage($errorMessage);
        $expectedResponse->setPercentageCompleted($percentageCompleted);
        $expectedResponse->setRecurringAudienceList($recurringAudienceList);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createAudienceListTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $audienceList = new AudienceList();
        $audienceListAudience = 'audienceListAudience867162342';
        $audienceList->setAudience($audienceListAudience);
        $audienceListDimensions = [];
        $audienceList->setDimensions($audienceListDimensions);
        $request = (new CreateAudienceListRequest())
            ->setParent($formattedParent)
            ->setAudienceList($audienceList);
        $response = $gapicClient->createAudienceList($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.data.v1alpha.AlphaAnalyticsData/CreateAudienceList', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getAudienceList();
        $this->assertProtobufEquals($audienceList, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createAudienceListTest');
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
    public function createAudienceListExceptionTest()
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
        $incompleteOperation->setName('operations/createAudienceListTest');
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
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $audienceList = new AudienceList();
        $audienceListAudience = 'audienceListAudience867162342';
        $audienceList->setAudience($audienceListAudience);
        $audienceListDimensions = [];
        $audienceList->setDimensions($audienceListDimensions);
        $request = (new CreateAudienceListRequest())
            ->setParent($formattedParent)
            ->setAudienceList($audienceList);
        $response = $gapicClient->createAudienceList($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createAudienceListTest');
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
    public function createRecurringAudienceListTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $audience = 'audience975628804';
        $audienceDisplayName = 'audienceDisplayName406858307';
        $activeDaysRemaining = 1427137945;
        $expectedResponse = new RecurringAudienceList();
        $expectedResponse->setName($name);
        $expectedResponse->setAudience($audience);
        $expectedResponse->setAudienceDisplayName($audienceDisplayName);
        $expectedResponse->setActiveDaysRemaining($activeDaysRemaining);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $recurringAudienceList = new RecurringAudienceList();
        $recurringAudienceListAudience = 'recurringAudienceListAudience230288227';
        $recurringAudienceList->setAudience($recurringAudienceListAudience);
        $recurringAudienceListDimensions = [];
        $recurringAudienceList->setDimensions($recurringAudienceListDimensions);
        $request = (new CreateRecurringAudienceListRequest())
            ->setParent($formattedParent)
            ->setRecurringAudienceList($recurringAudienceList);
        $response = $gapicClient->createRecurringAudienceList($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.data.v1alpha.AlphaAnalyticsData/CreateRecurringAudienceList', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRecurringAudienceList();
        $this->assertProtobufEquals($recurringAudienceList, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createRecurringAudienceListExceptionTest()
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
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $recurringAudienceList = new RecurringAudienceList();
        $recurringAudienceListAudience = 'recurringAudienceListAudience230288227';
        $recurringAudienceList->setAudience($recurringAudienceListAudience);
        $recurringAudienceListDimensions = [];
        $recurringAudienceList->setDimensions($recurringAudienceListDimensions);
        $request = (new CreateRecurringAudienceListRequest())
            ->setParent($formattedParent)
            ->setRecurringAudienceList($recurringAudienceList);
        try {
            $gapicClient->createRecurringAudienceList($request);
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
    public function createReportTaskTest()
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
        $incompleteOperation->setName('operations/createReportTaskTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $expectedResponse = new ReportTask();
        $expectedResponse->setName($name);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createReportTaskTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $reportTask = new ReportTask();
        $request = (new CreateReportTaskRequest())
            ->setParent($formattedParent)
            ->setReportTask($reportTask);
        $response = $gapicClient->createReportTask($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.data.v1alpha.AlphaAnalyticsData/CreateReportTask', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getReportTask();
        $this->assertProtobufEquals($reportTask, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createReportTaskTest');
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
    public function createReportTaskExceptionTest()
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
        $incompleteOperation->setName('operations/createReportTaskTest');
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
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $reportTask = new ReportTask();
        $request = (new CreateReportTaskRequest())
            ->setParent($formattedParent)
            ->setReportTask($reportTask);
        $response = $gapicClient->createReportTask($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createReportTaskTest');
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
    public function getAudienceListTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $audience = 'audience975628804';
        $audienceDisplayName = 'audienceDisplayName406858307';
        $creationQuotaTokensCharged = 1232901266;
        $rowCount = 1340416618;
        $errorMessage = 'errorMessage-1938755376';
        $percentageCompleted = -1.29204764E8;
        $recurringAudienceList = 'recurringAudienceList2056789015';
        $expectedResponse = new AudienceList();
        $expectedResponse->setName($name2);
        $expectedResponse->setAudience($audience);
        $expectedResponse->setAudienceDisplayName($audienceDisplayName);
        $expectedResponse->setCreationQuotaTokensCharged($creationQuotaTokensCharged);
        $expectedResponse->setRowCount($rowCount);
        $expectedResponse->setErrorMessage($errorMessage);
        $expectedResponse->setPercentageCompleted($percentageCompleted);
        $expectedResponse->setRecurringAudienceList($recurringAudienceList);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->audienceListName('[PROPERTY]', '[AUDIENCE_LIST]');
        $request = (new GetAudienceListRequest())
            ->setName($formattedName);
        $response = $gapicClient->getAudienceList($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.data.v1alpha.AlphaAnalyticsData/GetAudienceList', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAudienceListExceptionTest()
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
        $formattedName = $gapicClient->audienceListName('[PROPERTY]', '[AUDIENCE_LIST]');
        $request = (new GetAudienceListRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getAudienceList($request);
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
    public function getRecurringAudienceListTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $audience = 'audience975628804';
        $audienceDisplayName = 'audienceDisplayName406858307';
        $activeDaysRemaining = 1427137945;
        $expectedResponse = new RecurringAudienceList();
        $expectedResponse->setName($name2);
        $expectedResponse->setAudience($audience);
        $expectedResponse->setAudienceDisplayName($audienceDisplayName);
        $expectedResponse->setActiveDaysRemaining($activeDaysRemaining);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->recurringAudienceListName('[PROPERTY]', '[RECURRING_AUDIENCE_LIST]');
        $request = (new GetRecurringAudienceListRequest())
            ->setName($formattedName);
        $response = $gapicClient->getRecurringAudienceList($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.data.v1alpha.AlphaAnalyticsData/GetRecurringAudienceList', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getRecurringAudienceListExceptionTest()
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
        $formattedName = $gapicClient->recurringAudienceListName('[PROPERTY]', '[RECURRING_AUDIENCE_LIST]');
        $request = (new GetRecurringAudienceListRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getRecurringAudienceList($request);
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
    public function getReportTaskTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new ReportTask();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->reportTaskName('[PROPERTY]', '[REPORT_TASK]');
        $request = (new GetReportTaskRequest())
            ->setName($formattedName);
        $response = $gapicClient->getReportTask($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.data.v1alpha.AlphaAnalyticsData/GetReportTask', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getReportTaskExceptionTest()
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
        $formattedName = $gapicClient->reportTaskName('[PROPERTY]', '[REPORT_TASK]');
        $request = (new GetReportTaskRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getReportTask($request);
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
    public function listAudienceListsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $audienceListsElement = new AudienceList();
        $audienceLists = [
            $audienceListsElement,
        ];
        $expectedResponse = new ListAudienceListsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAudienceLists($audienceLists);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new ListAudienceListsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listAudienceLists($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAudienceLists()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.data.v1alpha.AlphaAnalyticsData/ListAudienceLists', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAudienceListsExceptionTest()
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
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new ListAudienceListsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listAudienceLists($request);
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
    public function listRecurringAudienceListsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $recurringAudienceListsElement = new RecurringAudienceList();
        $recurringAudienceLists = [
            $recurringAudienceListsElement,
        ];
        $expectedResponse = new ListRecurringAudienceListsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setRecurringAudienceLists($recurringAudienceLists);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new ListRecurringAudienceListsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listRecurringAudienceLists($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getRecurringAudienceLists()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.data.v1alpha.AlphaAnalyticsData/ListRecurringAudienceLists', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listRecurringAudienceListsExceptionTest()
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
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new ListRecurringAudienceListsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listRecurringAudienceLists($request);
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
    public function listReportTasksTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $reportTasksElement = new ReportTask();
        $reportTasks = [
            $reportTasksElement,
        ];
        $expectedResponse = new ListReportTasksResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setReportTasks($reportTasks);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new ListReportTasksRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listReportTasks($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getReportTasks()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.data.v1alpha.AlphaAnalyticsData/ListReportTasks', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listReportTasksExceptionTest()
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
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $request = (new ListReportTasksRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listReportTasks($request);
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
    public function queryAudienceListTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $rowCount = 1340416618;
        $expectedResponse = new QueryAudienceListResponse();
        $expectedResponse->setRowCount($rowCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $request = (new QueryAudienceListRequest())
            ->setName($name);
        $response = $gapicClient->queryAudienceList($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.data.v1alpha.AlphaAnalyticsData/QueryAudienceList', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function queryAudienceListExceptionTest()
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
        $request = (new QueryAudienceListRequest())
            ->setName($name);
        try {
            $gapicClient->queryAudienceList($request);
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
    public function queryReportTaskTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $rowCount = 1340416618;
        $expectedResponse = new QueryReportTaskResponse();
        $expectedResponse->setRowCount($rowCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $request = (new QueryReportTaskRequest())
            ->setName($name);
        $response = $gapicClient->queryReportTask($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.data.v1alpha.AlphaAnalyticsData/QueryReportTask', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function queryReportTaskExceptionTest()
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
        $request = (new QueryReportTaskRequest())
            ->setName($name);
        try {
            $gapicClient->queryReportTask($request);
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
    public function runFunnelReportTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $expectedResponse = new RunFunnelReportResponse();
        $expectedResponse->setKind($kind);
        $transport->addResponse($expectedResponse);
        $request = new RunFunnelReportRequest();
        $response = $gapicClient->runFunnelReport($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.data.v1alpha.AlphaAnalyticsData/RunFunnelReport', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function runFunnelReportExceptionTest()
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
        $request = new RunFunnelReportRequest();
        try {
            $gapicClient->runFunnelReport($request);
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
    public function sheetExportAudienceListTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $spreadsheetUri = 'spreadsheetUri-1521055111';
        $spreadsheetId = 'spreadsheetId1336406638';
        $rowCount = 1340416618;
        $expectedResponse = new SheetExportAudienceListResponse();
        $expectedResponse->setSpreadsheetUri($spreadsheetUri);
        $expectedResponse->setSpreadsheetId($spreadsheetId);
        $expectedResponse->setRowCount($rowCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->audienceListName('[PROPERTY]', '[AUDIENCE_LIST]');
        $request = (new SheetExportAudienceListRequest())
            ->setName($formattedName);
        $response = $gapicClient->sheetExportAudienceList($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.data.v1alpha.AlphaAnalyticsData/SheetExportAudienceList', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function sheetExportAudienceListExceptionTest()
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
        $formattedName = $gapicClient->audienceListName('[PROPERTY]', '[AUDIENCE_LIST]');
        $request = (new SheetExportAudienceListRequest())
            ->setName($formattedName);
        try {
            $gapicClient->sheetExportAudienceList($request);
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
    public function createAudienceListAsyncTest()
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
        $incompleteOperation->setName('operations/createAudienceListTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $audience = 'audience975628804';
        $audienceDisplayName = 'audienceDisplayName406858307';
        $creationQuotaTokensCharged = 1232901266;
        $rowCount = 1340416618;
        $errorMessage = 'errorMessage-1938755376';
        $percentageCompleted = -1.29204764E8;
        $recurringAudienceList = 'recurringAudienceList2056789015';
        $expectedResponse = new AudienceList();
        $expectedResponse->setName($name);
        $expectedResponse->setAudience($audience);
        $expectedResponse->setAudienceDisplayName($audienceDisplayName);
        $expectedResponse->setCreationQuotaTokensCharged($creationQuotaTokensCharged);
        $expectedResponse->setRowCount($rowCount);
        $expectedResponse->setErrorMessage($errorMessage);
        $expectedResponse->setPercentageCompleted($percentageCompleted);
        $expectedResponse->setRecurringAudienceList($recurringAudienceList);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createAudienceListTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->propertyName('[PROPERTY]');
        $audienceList = new AudienceList();
        $audienceListAudience = 'audienceListAudience867162342';
        $audienceList->setAudience($audienceListAudience);
        $audienceListDimensions = [];
        $audienceList->setDimensions($audienceListDimensions);
        $request = (new CreateAudienceListRequest())
            ->setParent($formattedParent)
            ->setAudienceList($audienceList);
        $response = $gapicClient->createAudienceListAsync($request)->wait();
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.analytics.data.v1alpha.AlphaAnalyticsData/CreateAudienceList', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getAudienceList();
        $this->assertProtobufEquals($audienceList, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createAudienceListTest');
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
}
