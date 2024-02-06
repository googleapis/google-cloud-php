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

namespace Google\Cloud\BigQuery\DataTransfer\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\BigQuery\DataTransfer\V1\CheckValidCredsRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\CheckValidCredsResponse;
use Google\Cloud\BigQuery\DataTransfer\V1\Client\DataTransferServiceClient;
use Google\Cloud\BigQuery\DataTransfer\V1\CreateTransferConfigRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\DataSource;
use Google\Cloud\BigQuery\DataTransfer\V1\DeleteTransferConfigRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\DeleteTransferRunRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\EnrollDataSourcesRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\GetDataSourceRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\GetTransferConfigRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\GetTransferRunRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\ListDataSourcesRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\ListDataSourcesResponse;
use Google\Cloud\BigQuery\DataTransfer\V1\ListTransferConfigsRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\ListTransferConfigsResponse;
use Google\Cloud\BigQuery\DataTransfer\V1\ListTransferLogsRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\ListTransferLogsResponse;
use Google\Cloud\BigQuery\DataTransfer\V1\ListTransferRunsRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\ListTransferRunsResponse;
use Google\Cloud\BigQuery\DataTransfer\V1\ScheduleTransferRunsRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\ScheduleTransferRunsResponse;
use Google\Cloud\BigQuery\DataTransfer\V1\StartManualTransferRunsRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\StartManualTransferRunsResponse;
use Google\Cloud\BigQuery\DataTransfer\V1\TransferConfig;
use Google\Cloud\BigQuery\DataTransfer\V1\TransferMessage;
use Google\Cloud\BigQuery\DataTransfer\V1\TransferRun;
use Google\Cloud\BigQuery\DataTransfer\V1\UpdateTransferConfigRequest;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Protobuf\Timestamp;
use Google\Rpc\Code;
use stdClass;

/**
 * @group datatransfer
 *
 * @group gapic
 */
class DataTransferServiceClientTest extends GeneratedTest
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

    /** @return DataTransferServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new DataTransferServiceClient($options);
    }

    /** @test */
    public function checkValidCredsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $hasValidCreds = false;
        $expectedResponse = new CheckValidCredsResponse();
        $expectedResponse->setHasValidCreds($hasValidCreds);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->dataSourceName('[PROJECT]', '[DATA_SOURCE]');
        $request = (new CheckValidCredsRequest())
            ->setName($formattedName);
        $response = $gapicClient->checkValidCreds($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.datatransfer.v1.DataTransferService/CheckValidCreds', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function checkValidCredsExceptionTest()
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
        $formattedName = $gapicClient->dataSourceName('[PROJECT]', '[DATA_SOURCE]');
        $request = (new CheckValidCredsRequest())
            ->setName($formattedName);
        try {
            $gapicClient->checkValidCreds($request);
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
    public function createTransferConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $destinationDatasetId = 'destinationDatasetId1541564179';
        $displayName = 'displayName1615086568';
        $dataSourceId = 'dataSourceId-1015796374';
        $schedule = 'schedule-697920873';
        $dataRefreshWindowDays = 327632845;
        $disabled = true;
        $userId = 147132913;
        $datasetRegion = 'datasetRegion959248539';
        $notificationPubsubTopic = 'notificationPubsubTopic1794281191';
        $expectedResponse = new TransferConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setDestinationDatasetId($destinationDatasetId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDataSourceId($dataSourceId);
        $expectedResponse->setSchedule($schedule);
        $expectedResponse->setDataRefreshWindowDays($dataRefreshWindowDays);
        $expectedResponse->setDisabled($disabled);
        $expectedResponse->setUserId($userId);
        $expectedResponse->setDatasetRegion($datasetRegion);
        $expectedResponse->setNotificationPubsubTopic($notificationPubsubTopic);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $transferConfig = new TransferConfig();
        $request = (new CreateTransferConfigRequest())
            ->setParent($formattedParent)
            ->setTransferConfig($transferConfig);
        $response = $gapicClient->createTransferConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.datatransfer.v1.DataTransferService/CreateTransferConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getTransferConfig();
        $this->assertProtobufEquals($transferConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createTransferConfigExceptionTest()
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
        $transferConfig = new TransferConfig();
        $request = (new CreateTransferConfigRequest())
            ->setParent($formattedParent)
            ->setTransferConfig($transferConfig);
        try {
            $gapicClient->createTransferConfig($request);
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
    public function deleteTransferConfigTest()
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
        $formattedName = $gapicClient->transferConfigName('[PROJECT]', '[TRANSFER_CONFIG]');
        $request = (new DeleteTransferConfigRequest())
            ->setName($formattedName);
        $gapicClient->deleteTransferConfig($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.datatransfer.v1.DataTransferService/DeleteTransferConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteTransferConfigExceptionTest()
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
        $formattedName = $gapicClient->transferConfigName('[PROJECT]', '[TRANSFER_CONFIG]');
        $request = (new DeleteTransferConfigRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteTransferConfig($request);
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
    public function deleteTransferRunTest()
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
        $formattedName = $gapicClient->runName('[PROJECT]', '[TRANSFER_CONFIG]', '[RUN]');
        $request = (new DeleteTransferRunRequest())
            ->setName($formattedName);
        $gapicClient->deleteTransferRun($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.datatransfer.v1.DataTransferService/DeleteTransferRun', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteTransferRunExceptionTest()
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
        $formattedName = $gapicClient->runName('[PROJECT]', '[TRANSFER_CONFIG]', '[RUN]');
        $request = (new DeleteTransferRunRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteTransferRun($request);
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
    public function enrollDataSourcesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new EnrollDataSourcesRequest();
        $gapicClient->enrollDataSources($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.datatransfer.v1.DataTransferService/EnrollDataSources', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function enrollDataSourcesExceptionTest()
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
        $request = new EnrollDataSourcesRequest();
        try {
            $gapicClient->enrollDataSources($request);
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
    public function getDataSourceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $dataSourceId = 'dataSourceId-1015796374';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $clientId = 'clientId-1904089585';
        $supportsMultipleTransfers = true;
        $updateDeadlineSeconds = 991471694;
        $defaultSchedule = 'defaultSchedule-800168235';
        $supportsCustomSchedule = true;
        $helpUrl = 'helpUrl-789431439';
        $defaultDataRefreshWindowDays = 1804935157;
        $manualRunsDisabled = true;
        $expectedResponse = new DataSource();
        $expectedResponse->setName($name2);
        $expectedResponse->setDataSourceId($dataSourceId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setClientId($clientId);
        $expectedResponse->setSupportsMultipleTransfers($supportsMultipleTransfers);
        $expectedResponse->setUpdateDeadlineSeconds($updateDeadlineSeconds);
        $expectedResponse->setDefaultSchedule($defaultSchedule);
        $expectedResponse->setSupportsCustomSchedule($supportsCustomSchedule);
        $expectedResponse->setHelpUrl($helpUrl);
        $expectedResponse->setDefaultDataRefreshWindowDays($defaultDataRefreshWindowDays);
        $expectedResponse->setManualRunsDisabled($manualRunsDisabled);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->dataSourceName('[PROJECT]', '[DATA_SOURCE]');
        $request = (new GetDataSourceRequest())
            ->setName($formattedName);
        $response = $gapicClient->getDataSource($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.datatransfer.v1.DataTransferService/GetDataSource', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDataSourceExceptionTest()
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
        $formattedName = $gapicClient->dataSourceName('[PROJECT]', '[DATA_SOURCE]');
        $request = (new GetDataSourceRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getDataSource($request);
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
    public function getTransferConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $destinationDatasetId = 'destinationDatasetId1541564179';
        $displayName = 'displayName1615086568';
        $dataSourceId = 'dataSourceId-1015796374';
        $schedule = 'schedule-697920873';
        $dataRefreshWindowDays = 327632845;
        $disabled = true;
        $userId = 147132913;
        $datasetRegion = 'datasetRegion959248539';
        $notificationPubsubTopic = 'notificationPubsubTopic1794281191';
        $expectedResponse = new TransferConfig();
        $expectedResponse->setName($name2);
        $expectedResponse->setDestinationDatasetId($destinationDatasetId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDataSourceId($dataSourceId);
        $expectedResponse->setSchedule($schedule);
        $expectedResponse->setDataRefreshWindowDays($dataRefreshWindowDays);
        $expectedResponse->setDisabled($disabled);
        $expectedResponse->setUserId($userId);
        $expectedResponse->setDatasetRegion($datasetRegion);
        $expectedResponse->setNotificationPubsubTopic($notificationPubsubTopic);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->transferConfigName('[PROJECT]', '[TRANSFER_CONFIG]');
        $request = (new GetTransferConfigRequest())
            ->setName($formattedName);
        $response = $gapicClient->getTransferConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.datatransfer.v1.DataTransferService/GetTransferConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTransferConfigExceptionTest()
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
        $formattedName = $gapicClient->transferConfigName('[PROJECT]', '[TRANSFER_CONFIG]');
        $request = (new GetTransferConfigRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getTransferConfig($request);
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
    public function getTransferRunTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $destinationDatasetId = 'destinationDatasetId1541564179';
        $dataSourceId = 'dataSourceId-1015796374';
        $userId = 147132913;
        $schedule = 'schedule-697920873';
        $notificationPubsubTopic = 'notificationPubsubTopic1794281191';
        $expectedResponse = new TransferRun();
        $expectedResponse->setName($name2);
        $expectedResponse->setDestinationDatasetId($destinationDatasetId);
        $expectedResponse->setDataSourceId($dataSourceId);
        $expectedResponse->setUserId($userId);
        $expectedResponse->setSchedule($schedule);
        $expectedResponse->setNotificationPubsubTopic($notificationPubsubTopic);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->runName('[PROJECT]', '[TRANSFER_CONFIG]', '[RUN]');
        $request = (new GetTransferRunRequest())
            ->setName($formattedName);
        $response = $gapicClient->getTransferRun($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.datatransfer.v1.DataTransferService/GetTransferRun', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTransferRunExceptionTest()
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
        $formattedName = $gapicClient->runName('[PROJECT]', '[TRANSFER_CONFIG]', '[RUN]');
        $request = (new GetTransferRunRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getTransferRun($request);
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
    public function listDataSourcesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $dataSourcesElement = new DataSource();
        $dataSources = [
            $dataSourcesElement,
        ];
        $expectedResponse = new ListDataSourcesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDataSources($dataSources);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListDataSourcesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listDataSources($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDataSources()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.datatransfer.v1.DataTransferService/ListDataSources', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDataSourcesExceptionTest()
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
        $request = (new ListDataSourcesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listDataSources($request);
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
    public function listTransferConfigsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $transferConfigsElement = new TransferConfig();
        $transferConfigs = [
            $transferConfigsElement,
        ];
        $expectedResponse = new ListTransferConfigsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTransferConfigs($transferConfigs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListTransferConfigsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listTransferConfigs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTransferConfigs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.datatransfer.v1.DataTransferService/ListTransferConfigs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTransferConfigsExceptionTest()
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
        $request = (new ListTransferConfigsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listTransferConfigs($request);
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
    public function listTransferLogsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $transferMessagesElement = new TransferMessage();
        $transferMessages = [
            $transferMessagesElement,
        ];
        $expectedResponse = new ListTransferLogsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTransferMessages($transferMessages);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->runName('[PROJECT]', '[TRANSFER_CONFIG]', '[RUN]');
        $request = (new ListTransferLogsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listTransferLogs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTransferMessages()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.datatransfer.v1.DataTransferService/ListTransferLogs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTransferLogsExceptionTest()
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
        $formattedParent = $gapicClient->runName('[PROJECT]', '[TRANSFER_CONFIG]', '[RUN]');
        $request = (new ListTransferLogsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listTransferLogs($request);
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
    public function listTransferRunsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $transferRunsElement = new TransferRun();
        $transferRuns = [
            $transferRunsElement,
        ];
        $expectedResponse = new ListTransferRunsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTransferRuns($transferRuns);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->transferConfigName('[PROJECT]', '[TRANSFER_CONFIG]');
        $request = (new ListTransferRunsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listTransferRuns($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTransferRuns()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.datatransfer.v1.DataTransferService/ListTransferRuns', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTransferRunsExceptionTest()
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
        $formattedParent = $gapicClient->transferConfigName('[PROJECT]', '[TRANSFER_CONFIG]');
        $request = (new ListTransferRunsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listTransferRuns($request);
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
    public function scheduleTransferRunsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ScheduleTransferRunsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->transferConfigName('[PROJECT]', '[TRANSFER_CONFIG]');
        $startTime = new Timestamp();
        $endTime = new Timestamp();
        $request = (new ScheduleTransferRunsRequest())
            ->setParent($formattedParent)
            ->setStartTime($startTime)
            ->setEndTime($endTime);
        $response = $gapicClient->scheduleTransferRuns($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.datatransfer.v1.DataTransferService/ScheduleTransferRuns', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getStartTime();
        $this->assertProtobufEquals($startTime, $actualValue);
        $actualValue = $actualRequestObject->getEndTime();
        $this->assertProtobufEquals($endTime, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function scheduleTransferRunsExceptionTest()
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
        $formattedParent = $gapicClient->transferConfigName('[PROJECT]', '[TRANSFER_CONFIG]');
        $startTime = new Timestamp();
        $endTime = new Timestamp();
        $request = (new ScheduleTransferRunsRequest())
            ->setParent($formattedParent)
            ->setStartTime($startTime)
            ->setEndTime($endTime);
        try {
            $gapicClient->scheduleTransferRuns($request);
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
    public function startManualTransferRunsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new StartManualTransferRunsResponse();
        $transport->addResponse($expectedResponse);
        $request = new StartManualTransferRunsRequest();
        $response = $gapicClient->startManualTransferRuns($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.datatransfer.v1.DataTransferService/StartManualTransferRuns', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function startManualTransferRunsExceptionTest()
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
        $request = new StartManualTransferRunsRequest();
        try {
            $gapicClient->startManualTransferRuns($request);
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
    public function updateTransferConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $destinationDatasetId = 'destinationDatasetId1541564179';
        $displayName = 'displayName1615086568';
        $dataSourceId = 'dataSourceId-1015796374';
        $schedule = 'schedule-697920873';
        $dataRefreshWindowDays = 327632845;
        $disabled = true;
        $userId = 147132913;
        $datasetRegion = 'datasetRegion959248539';
        $notificationPubsubTopic = 'notificationPubsubTopic1794281191';
        $expectedResponse = new TransferConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setDestinationDatasetId($destinationDatasetId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDataSourceId($dataSourceId);
        $expectedResponse->setSchedule($schedule);
        $expectedResponse->setDataRefreshWindowDays($dataRefreshWindowDays);
        $expectedResponse->setDisabled($disabled);
        $expectedResponse->setUserId($userId);
        $expectedResponse->setDatasetRegion($datasetRegion);
        $expectedResponse->setNotificationPubsubTopic($notificationPubsubTopic);
        $transport->addResponse($expectedResponse);
        // Mock request
        $transferConfig = new TransferConfig();
        $updateMask = new FieldMask();
        $request = (new UpdateTransferConfigRequest())
            ->setTransferConfig($transferConfig)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateTransferConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.datatransfer.v1.DataTransferService/UpdateTransferConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getTransferConfig();
        $this->assertProtobufEquals($transferConfig, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateTransferConfigExceptionTest()
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
        $transferConfig = new TransferConfig();
        $updateMask = new FieldMask();
        $request = (new UpdateTransferConfigRequest())
            ->setTransferConfig($transferConfig)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateTransferConfig($request);
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
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
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
        $locations = [
            $locationsElement,
        ];
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
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
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
    public function checkValidCredsAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $hasValidCreds = false;
        $expectedResponse = new CheckValidCredsResponse();
        $expectedResponse->setHasValidCreds($hasValidCreds);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->dataSourceName('[PROJECT]', '[DATA_SOURCE]');
        $request = (new CheckValidCredsRequest())
            ->setName($formattedName);
        $response = $gapicClient->checkValidCredsAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.datatransfer.v1.DataTransferService/CheckValidCreds', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
