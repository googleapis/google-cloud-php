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

namespace Google\Cloud\Chronicle\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Chronicle\V1\BulkCreateDataTableRowsRequest;
use Google\Cloud\Chronicle\V1\BulkCreateDataTableRowsResponse;
use Google\Cloud\Chronicle\V1\BulkGetDataTableRowsRequest;
use Google\Cloud\Chronicle\V1\BulkGetDataTableRowsResponse;
use Google\Cloud\Chronicle\V1\BulkReplaceDataTableRowsRequest;
use Google\Cloud\Chronicle\V1\BulkReplaceDataTableRowsResponse;
use Google\Cloud\Chronicle\V1\BulkUpdateDataTableRowsRequest;
use Google\Cloud\Chronicle\V1\BulkUpdateDataTableRowsResponse;
use Google\Cloud\Chronicle\V1\Client\DataTableServiceClient;
use Google\Cloud\Chronicle\V1\CreateDataTableRequest;
use Google\Cloud\Chronicle\V1\CreateDataTableRowRequest;
use Google\Cloud\Chronicle\V1\DataTable;
use Google\Cloud\Chronicle\V1\DataTableOperationErrors;
use Google\Cloud\Chronicle\V1\DataTableRow;
use Google\Cloud\Chronicle\V1\DeleteDataTableRequest;
use Google\Cloud\Chronicle\V1\DeleteDataTableRowRequest;
use Google\Cloud\Chronicle\V1\GetDataTableOperationErrorsRequest;
use Google\Cloud\Chronicle\V1\GetDataTableRequest;
use Google\Cloud\Chronicle\V1\GetDataTableRowRequest;
use Google\Cloud\Chronicle\V1\ListDataTableRowsRequest;
use Google\Cloud\Chronicle\V1\ListDataTableRowsResponse;
use Google\Cloud\Chronicle\V1\ListDataTablesRequest;
use Google\Cloud\Chronicle\V1\ListDataTablesResponse;
use Google\Cloud\Chronicle\V1\UpdateDataTableRequest;
use Google\Cloud\Chronicle\V1\UpdateDataTableRowRequest;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group chronicle
 *
 * @group gapic
 */
class DataTableServiceClientTest extends GeneratedTest
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

    /** @return DataTableServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new DataTableServiceClient($options);
    }

    /** @test */
    public function bulkCreateDataTableRowsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BulkCreateDataTableRowsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->dataTableName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DATA_TABLE]');
        $requests = [];
        $request = (new BulkCreateDataTableRowsRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->bulkCreateDataTableRows($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataTableService/BulkCreateDataTableRows', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function bulkCreateDataTableRowsExceptionTest()
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
        $formattedParent = $gapicClient->dataTableName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DATA_TABLE]');
        $requests = [];
        $request = (new BulkCreateDataTableRowsRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->bulkCreateDataTableRows($request);
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
    public function bulkGetDataTableRowsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BulkGetDataTableRowsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->dataTableName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DATA_TABLE]');
        $requests = [];
        $request = (new BulkGetDataTableRowsRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->bulkGetDataTableRows($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataTableService/BulkGetDataTableRows', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function bulkGetDataTableRowsExceptionTest()
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
        $formattedParent = $gapicClient->dataTableName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DATA_TABLE]');
        $requests = [];
        $request = (new BulkGetDataTableRowsRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->bulkGetDataTableRows($request);
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
    public function bulkReplaceDataTableRowsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BulkReplaceDataTableRowsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->dataTableName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DATA_TABLE]');
        $requests = [];
        $request = (new BulkReplaceDataTableRowsRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->bulkReplaceDataTableRows($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataTableService/BulkReplaceDataTableRows', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function bulkReplaceDataTableRowsExceptionTest()
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
        $formattedParent = $gapicClient->dataTableName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DATA_TABLE]');
        $requests = [];
        $request = (new BulkReplaceDataTableRowsRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->bulkReplaceDataTableRows($request);
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
    public function bulkUpdateDataTableRowsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BulkUpdateDataTableRowsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->dataTableName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DATA_TABLE]');
        $requests = [];
        $request = (new BulkUpdateDataTableRowsRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->bulkUpdateDataTableRows($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataTableService/BulkUpdateDataTableRows', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function bulkUpdateDataTableRowsExceptionTest()
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
        $formattedParent = $gapicClient->dataTableName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DATA_TABLE]');
        $requests = [];
        $request = (new BulkUpdateDataTableRowsRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->bulkUpdateDataTableRows($request);
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
    public function createDataTableTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $dataTableUuid = 'dataTableUuid-1818199743';
        $ruleAssociationsCount = 1522562875;
        $rowTimeToLive = 'rowTimeToLive1109069571';
        $approximateRowCount = 297926913;
        $expectedResponse = new DataTable();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDataTableUuid($dataTableUuid);
        $expectedResponse->setRuleAssociationsCount($ruleAssociationsCount);
        $expectedResponse->setRowTimeToLive($rowTimeToLive);
        $expectedResponse->setApproximateRowCount($approximateRowCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $dataTable = new DataTable();
        $dataTableDescription = 'dataTableDescription924959512';
        $dataTable->setDescription($dataTableDescription);
        $dataTableId = 'dataTableId-319210463';
        $request = (new CreateDataTableRequest())
            ->setParent($formattedParent)
            ->setDataTable($dataTable)
            ->setDataTableId($dataTableId);
        $response = $gapicClient->createDataTable($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataTableService/CreateDataTable', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getDataTable();
        $this->assertProtobufEquals($dataTable, $actualValue);
        $actualValue = $actualRequestObject->getDataTableId();
        $this->assertProtobufEquals($dataTableId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createDataTableExceptionTest()
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
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $dataTable = new DataTable();
        $dataTableDescription = 'dataTableDescription924959512';
        $dataTable->setDescription($dataTableDescription);
        $dataTableId = 'dataTableId-319210463';
        $request = (new CreateDataTableRequest())
            ->setParent($formattedParent)
            ->setDataTable($dataTable)
            ->setDataTableId($dataTableId);
        try {
            $gapicClient->createDataTable($request);
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
    public function createDataTableRowTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $rowTimeToLive = 'rowTimeToLive1109069571';
        $expectedResponse = new DataTableRow();
        $expectedResponse->setName($name);
        $expectedResponse->setRowTimeToLive($rowTimeToLive);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->dataTableName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DATA_TABLE]');
        $dataTableRow = new DataTableRow();
        $dataTableRowValues = [];
        $dataTableRow->setValues($dataTableRowValues);
        $request = (new CreateDataTableRowRequest())->setParent($formattedParent)->setDataTableRow($dataTableRow);
        $response = $gapicClient->createDataTableRow($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataTableService/CreateDataTableRow', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getDataTableRow();
        $this->assertProtobufEquals($dataTableRow, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createDataTableRowExceptionTest()
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
        $formattedParent = $gapicClient->dataTableName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DATA_TABLE]');
        $dataTableRow = new DataTableRow();
        $dataTableRowValues = [];
        $dataTableRow->setValues($dataTableRowValues);
        $request = (new CreateDataTableRowRequest())->setParent($formattedParent)->setDataTableRow($dataTableRow);
        try {
            $gapicClient->createDataTableRow($request);
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
    public function deleteDataTableTest()
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
        $formattedName = $gapicClient->dataTableName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DATA_TABLE]');
        $request = (new DeleteDataTableRequest())->setName($formattedName);
        $gapicClient->deleteDataTable($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataTableService/DeleteDataTable', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteDataTableExceptionTest()
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
        $formattedName = $gapicClient->dataTableName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DATA_TABLE]');
        $request = (new DeleteDataTableRequest())->setName($formattedName);
        try {
            $gapicClient->deleteDataTable($request);
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
    public function deleteDataTableRowTest()
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
        $formattedName = $gapicClient->dataTableRowName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[DATA_TABLE]',
            '[DATA_TABLE_ROW]'
        );
        $request = (new DeleteDataTableRowRequest())->setName($formattedName);
        $gapicClient->deleteDataTableRow($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataTableService/DeleteDataTableRow', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteDataTableRowExceptionTest()
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
        $formattedName = $gapicClient->dataTableRowName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[DATA_TABLE]',
            '[DATA_TABLE_ROW]'
        );
        $request = (new DeleteDataTableRowRequest())->setName($formattedName);
        try {
            $gapicClient->deleteDataTableRow($request);
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
    public function getDataTableTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $dataTableUuid = 'dataTableUuid-1818199743';
        $ruleAssociationsCount = 1522562875;
        $rowTimeToLive = 'rowTimeToLive1109069571';
        $approximateRowCount = 297926913;
        $expectedResponse = new DataTable();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDataTableUuid($dataTableUuid);
        $expectedResponse->setRuleAssociationsCount($ruleAssociationsCount);
        $expectedResponse->setRowTimeToLive($rowTimeToLive);
        $expectedResponse->setApproximateRowCount($approximateRowCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->dataTableName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DATA_TABLE]');
        $request = (new GetDataTableRequest())->setName($formattedName);
        $response = $gapicClient->getDataTable($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataTableService/GetDataTable', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDataTableExceptionTest()
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
        $formattedName = $gapicClient->dataTableName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DATA_TABLE]');
        $request = (new GetDataTableRequest())->setName($formattedName);
        try {
            $gapicClient->getDataTable($request);
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
    public function getDataTableOperationErrorsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new DataTableOperationErrors();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->dataTableOperationErrorsName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[DATA_TABLE_OPERATION_ERRORS]'
        );
        $request = (new GetDataTableOperationErrorsRequest())->setName($formattedName);
        $response = $gapicClient->getDataTableOperationErrors($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataTableService/GetDataTableOperationErrors', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDataTableOperationErrorsExceptionTest()
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
        $formattedName = $gapicClient->dataTableOperationErrorsName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[DATA_TABLE_OPERATION_ERRORS]'
        );
        $request = (new GetDataTableOperationErrorsRequest())->setName($formattedName);
        try {
            $gapicClient->getDataTableOperationErrors($request);
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
    public function getDataTableRowTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $rowTimeToLive = 'rowTimeToLive1109069571';
        $expectedResponse = new DataTableRow();
        $expectedResponse->setName($name2);
        $expectedResponse->setRowTimeToLive($rowTimeToLive);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->dataTableRowName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[DATA_TABLE]',
            '[DATA_TABLE_ROW]'
        );
        $request = (new GetDataTableRowRequest())->setName($formattedName);
        $response = $gapicClient->getDataTableRow($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataTableService/GetDataTableRow', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDataTableRowExceptionTest()
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
        $formattedName = $gapicClient->dataTableRowName(
            '[PROJECT]',
            '[LOCATION]',
            '[INSTANCE]',
            '[DATA_TABLE]',
            '[DATA_TABLE_ROW]'
        );
        $request = (new GetDataTableRowRequest())->setName($formattedName);
        try {
            $gapicClient->getDataTableRow($request);
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
    public function listDataTableRowsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $dataTableRowsElement = new DataTableRow();
        $dataTableRows = [$dataTableRowsElement];
        $expectedResponse = new ListDataTableRowsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDataTableRows($dataTableRows);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->dataTableName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DATA_TABLE]');
        $request = (new ListDataTableRowsRequest())->setParent($formattedParent);
        $response = $gapicClient->listDataTableRows($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDataTableRows()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataTableService/ListDataTableRows', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDataTableRowsExceptionTest()
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
        $formattedParent = $gapicClient->dataTableName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DATA_TABLE]');
        $request = (new ListDataTableRowsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listDataTableRows($request);
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
    public function listDataTablesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $dataTablesElement = new DataTable();
        $dataTables = [$dataTablesElement];
        $expectedResponse = new ListDataTablesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDataTables($dataTables);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new ListDataTablesRequest())->setParent($formattedParent);
        $response = $gapicClient->listDataTables($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDataTables()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataTableService/ListDataTables', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDataTablesExceptionTest()
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
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new ListDataTablesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listDataTables($request);
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
    public function updateDataTableTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $dataTableUuid = 'dataTableUuid-1818199743';
        $ruleAssociationsCount = 1522562875;
        $rowTimeToLive = 'rowTimeToLive1109069571';
        $approximateRowCount = 297926913;
        $expectedResponse = new DataTable();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDataTableUuid($dataTableUuid);
        $expectedResponse->setRuleAssociationsCount($ruleAssociationsCount);
        $expectedResponse->setRowTimeToLive($rowTimeToLive);
        $expectedResponse->setApproximateRowCount($approximateRowCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $dataTable = new DataTable();
        $dataTableDescription = 'dataTableDescription924959512';
        $dataTable->setDescription($dataTableDescription);
        $request = (new UpdateDataTableRequest())->setDataTable($dataTable);
        $response = $gapicClient->updateDataTable($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataTableService/UpdateDataTable', $actualFuncCall);
        $actualValue = $actualRequestObject->getDataTable();
        $this->assertProtobufEquals($dataTable, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateDataTableExceptionTest()
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
        $dataTable = new DataTable();
        $dataTableDescription = 'dataTableDescription924959512';
        $dataTable->setDescription($dataTableDescription);
        $request = (new UpdateDataTableRequest())->setDataTable($dataTable);
        try {
            $gapicClient->updateDataTable($request);
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
    public function updateDataTableRowTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $rowTimeToLive = 'rowTimeToLive1109069571';
        $expectedResponse = new DataTableRow();
        $expectedResponse->setName($name);
        $expectedResponse->setRowTimeToLive($rowTimeToLive);
        $transport->addResponse($expectedResponse);
        // Mock request
        $dataTableRow = new DataTableRow();
        $dataTableRowValues = [];
        $dataTableRow->setValues($dataTableRowValues);
        $request = (new UpdateDataTableRowRequest())->setDataTableRow($dataTableRow);
        $response = $gapicClient->updateDataTableRow($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataTableService/UpdateDataTableRow', $actualFuncCall);
        $actualValue = $actualRequestObject->getDataTableRow();
        $this->assertProtobufEquals($dataTableRow, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateDataTableRowExceptionTest()
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
        $dataTableRow = new DataTableRow();
        $dataTableRowValues = [];
        $dataTableRow->setValues($dataTableRowValues);
        $request = (new UpdateDataTableRowRequest())->setDataTableRow($dataTableRow);
        try {
            $gapicClient->updateDataTableRow($request);
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
    public function bulkCreateDataTableRowsAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BulkCreateDataTableRowsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->dataTableName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DATA_TABLE]');
        $requests = [];
        $request = (new BulkCreateDataTableRowsRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->bulkCreateDataTableRowsAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DataTableService/BulkCreateDataTableRows', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
