<?php
/*
 * Copyright 2018 Google LLC
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

namespace Google\Cloud\BigQuery\DataTransfer\Tests\Unit\V1;

use Google\ApiCore\ApiException;

use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;

use Google\Cloud\BigQuery\DataTransfer\V1\CheckValidCredsResponse;
use Google\Cloud\BigQuery\DataTransfer\V1\DataSource;
use Google\Cloud\BigQuery\DataTransfer\V1\DataTransferServiceClient;
use Google\Cloud\BigQuery\DataTransfer\V1\ListDataSourcesResponse;
use Google\Cloud\BigQuery\DataTransfer\V1\ListTransferConfigsResponse;
use Google\Cloud\BigQuery\DataTransfer\V1\ListTransferLogsResponse;
use Google\Cloud\BigQuery\DataTransfer\V1\ListTransferRunsResponse;
use Google\Cloud\BigQuery\DataTransfer\V1\ScheduleTransferRunsResponse;
use Google\Cloud\BigQuery\DataTransfer\V1\StartManualTransferRunsResponse;
use Google\Cloud\BigQuery\DataTransfer\V1\TransferConfig;
use Google\Cloud\BigQuery\DataTransfer\V1\TransferMessage;
use Google\Cloud\BigQuery\DataTransfer\V1\TransferRun;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Protobuf\Timestamp;
use Google\Rpc\Code;
use stdClass;

/**
 * @group bigquerydatatransfer
 *
 * @group gapic
 */
class DataTransferServiceClientTest extends GeneratedTest
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
     * @return DataTransferServiceClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new DataTransferServiceClient($options);
    }

    /**
     * @test
     */
    public function checkValidCredsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $hasValidCreds = false;
        $expectedResponse = new CheckValidCredsResponse();
        $expectedResponse->setHasValidCreds($hasValidCreds);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->dataSourceName('[PROJECT]', '[DATA_SOURCE]');
        $response = $client->checkValidCreds($formattedName);
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

    /**
     * @test
     */
    public function checkValidCredsExceptionTest()
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
        $formattedName = $client->dataSourceName('[PROJECT]', '[DATA_SOURCE]');
        try {
            $client->checkValidCreds($formattedName);
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
    public function createTransferConfigTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->projectName('[PROJECT]');
        $transferConfig = new TransferConfig();
        $response = $client->createTransferConfig($formattedParent, $transferConfig);
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

    /**
     * @test
     */
    public function createTransferConfigExceptionTest()
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
        $formattedParent = $client->projectName('[PROJECT]');
        $transferConfig = new TransferConfig();
        try {
            $client->createTransferConfig($formattedParent, $transferConfig);
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
    public function deleteTransferConfigTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->transferConfigName('[PROJECT]', '[TRANSFER_CONFIG]');
        $client->deleteTransferConfig($formattedName);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.datatransfer.v1.DataTransferService/DeleteTransferConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteTransferConfigExceptionTest()
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
        $formattedName = $client->transferConfigName('[PROJECT]', '[TRANSFER_CONFIG]');
        try {
            $client->deleteTransferConfig($formattedName);
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
    public function deleteTransferRunTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->runName('[PROJECT]', '[TRANSFER_CONFIG]', '[RUN]');
        $client->deleteTransferRun($formattedName);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.datatransfer.v1.DataTransferService/DeleteTransferRun', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteTransferRunExceptionTest()
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
        $formattedName = $client->runName('[PROJECT]', '[TRANSFER_CONFIG]', '[RUN]');
        try {
            $client->deleteTransferRun($formattedName);
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
    public function getDataSourceTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->dataSourceName('[PROJECT]', '[DATA_SOURCE]');
        $response = $client->getDataSource($formattedName);
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

    /**
     * @test
     */
    public function getDataSourceExceptionTest()
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
        $formattedName = $client->dataSourceName('[PROJECT]', '[DATA_SOURCE]');
        try {
            $client->getDataSource($formattedName);
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
    public function getTransferConfigTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->transferConfigName('[PROJECT]', '[TRANSFER_CONFIG]');
        $response = $client->getTransferConfig($formattedName);
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

    /**
     * @test
     */
    public function getTransferConfigExceptionTest()
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
        $formattedName = $client->transferConfigName('[PROJECT]', '[TRANSFER_CONFIG]');
        try {
            $client->getTransferConfig($formattedName);
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
    public function getTransferRunTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->runName('[PROJECT]', '[TRANSFER_CONFIG]', '[RUN]');
        $response = $client->getTransferRun($formattedName);
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

    /**
     * @test
     */
    public function getTransferRunExceptionTest()
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
        $formattedName = $client->runName('[PROJECT]', '[TRANSFER_CONFIG]', '[RUN]');
        try {
            $client->getTransferRun($formattedName);
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
    public function listDataSourcesTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->projectName('[PROJECT]');
        $response = $client->listDataSources($formattedParent);
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

    /**
     * @test
     */
    public function listDataSourcesExceptionTest()
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
        $formattedParent = $client->projectName('[PROJECT]');
        try {
            $client->listDataSources($formattedParent);
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
    public function listTransferConfigsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->projectName('[PROJECT]');
        $response = $client->listTransferConfigs($formattedParent);
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

    /**
     * @test
     */
    public function listTransferConfigsExceptionTest()
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
        $formattedParent = $client->projectName('[PROJECT]');
        try {
            $client->listTransferConfigs($formattedParent);
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
    public function listTransferLogsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->runName('[PROJECT]', '[TRANSFER_CONFIG]', '[RUN]');
        $response = $client->listTransferLogs($formattedParent);
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

    /**
     * @test
     */
    public function listTransferLogsExceptionTest()
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
        $formattedParent = $client->runName('[PROJECT]', '[TRANSFER_CONFIG]', '[RUN]');
        try {
            $client->listTransferLogs($formattedParent);
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
    public function listTransferRunsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->transferConfigName('[PROJECT]', '[TRANSFER_CONFIG]');
        $response = $client->listTransferRuns($formattedParent);
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

    /**
     * @test
     */
    public function listTransferRunsExceptionTest()
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
        $formattedParent = $client->transferConfigName('[PROJECT]', '[TRANSFER_CONFIG]');
        try {
            $client->listTransferRuns($formattedParent);
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
    public function scheduleTransferRunsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ScheduleTransferRunsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->transferConfigName('[PROJECT]', '[TRANSFER_CONFIG]');
        $startTime = new Timestamp();
        $endTime = new Timestamp();
        $response = $client->scheduleTransferRuns($formattedParent, $startTime, $endTime);
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

    /**
     * @test
     */
    public function scheduleTransferRunsExceptionTest()
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
        $formattedParent = $client->transferConfigName('[PROJECT]', '[TRANSFER_CONFIG]');
        $startTime = new Timestamp();
        $endTime = new Timestamp();
        try {
            $client->scheduleTransferRuns($formattedParent, $startTime, $endTime);
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
    public function startManualTransferRunsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new StartManualTransferRunsResponse();
        $transport->addResponse($expectedResponse);
        $response = $client->startManualTransferRuns();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.datatransfer.v1.DataTransferService/StartManualTransferRuns', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function startManualTransferRunsExceptionTest()
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
        try {
            $client->startManualTransferRuns();
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
    public function updateTransferConfigTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $response = $client->updateTransferConfig($transferConfig, $updateMask);
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

    /**
     * @test
     */
    public function updateTransferConfigExceptionTest()
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
        $transferConfig = new TransferConfig();
        $updateMask = new FieldMask();
        try {
            $client->updateTransferConfig($transferConfig, $updateMask);
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
