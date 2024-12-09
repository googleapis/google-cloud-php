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

namespace Google\Cloud\Bigtable\Tests\Unit\V2\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\ServerStream;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Bigtable\V2\CheckAndMutateRowRequest;
use Google\Cloud\Bigtable\V2\CheckAndMutateRowResponse;
use Google\Cloud\Bigtable\V2\Client\BigtableClient;
use Google\Cloud\Bigtable\V2\ExecuteQueryRequest;
use Google\Cloud\Bigtable\V2\ExecuteQueryResponse;
use Google\Cloud\Bigtable\V2\GenerateInitialChangeStreamPartitionsRequest;
use Google\Cloud\Bigtable\V2\GenerateInitialChangeStreamPartitionsResponse;
use Google\Cloud\Bigtable\V2\MutateRowRequest;
use Google\Cloud\Bigtable\V2\MutateRowResponse;
use Google\Cloud\Bigtable\V2\MutateRowsRequest;
use Google\Cloud\Bigtable\V2\MutateRowsResponse;
use Google\Cloud\Bigtable\V2\PingAndWarmRequest;
use Google\Cloud\Bigtable\V2\PingAndWarmResponse;
use Google\Cloud\Bigtable\V2\ReadChangeStreamRequest;
use Google\Cloud\Bigtable\V2\ReadChangeStreamResponse;
use Google\Cloud\Bigtable\V2\ReadModifyWriteRowRequest;
use Google\Cloud\Bigtable\V2\ReadModifyWriteRowResponse;
use Google\Cloud\Bigtable\V2\ReadRowsRequest;
use Google\Cloud\Bigtable\V2\ReadRowsResponse;
use Google\Cloud\Bigtable\V2\SampleRowKeysRequest;
use Google\Cloud\Bigtable\V2\SampleRowKeysResponse;
use Google\Cloud\Bigtable\V2\Value;
use Google\Rpc\Code;
use stdClass;

/**
 * @group bigtable
 *
 * @group gapic
 */
class BigtableClientTest extends GeneratedTest
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

    /** @return BigtableClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new BigtableClient($options);
    }

    /** @test */
    public function checkAndMutateRowTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $predicateMatched = true;
        $expectedResponse = new CheckAndMutateRowResponse();
        $expectedResponse->setPredicateMatched($predicateMatched);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedTableName = $gapicClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
        $rowKey = '122';
        $request = (new CheckAndMutateRowRequest())
            ->setTableName($formattedTableName)
            ->setRowKey($rowKey);
        $response = $gapicClient->checkAndMutateRow($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.bigtable.v2.Bigtable/CheckAndMutateRow', $actualFuncCall);
        $actualValue = $actualRequestObject->getTableName();
        $this->assertProtobufEquals($formattedTableName, $actualValue);
        $actualValue = $actualRequestObject->getRowKey();
        $this->assertProtobufEquals($rowKey, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function checkAndMutateRowExceptionTest()
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
        $formattedTableName = $gapicClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
        $rowKey = '122';
        $request = (new CheckAndMutateRowRequest())
            ->setTableName($formattedTableName)
            ->setRowKey($rowKey);
        try {
            $gapicClient->checkAndMutateRow($request);
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
    public function executeQueryTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ExecuteQueryResponse();
        $transport->addResponse($expectedResponse);
        $expectedResponse2 = new ExecuteQueryResponse();
        $transport->addResponse($expectedResponse2);
        $expectedResponse3 = new ExecuteQueryResponse();
        $transport->addResponse($expectedResponse3);
        // Mock request
        $formattedInstanceName = $gapicClient->instanceName('[PROJECT]', '[INSTANCE]');
        $query = 'query107944136';
        $paramsValue = new Value();
        $params = [
            'paramsKey' => $paramsValue,
        ];
        $request = (new ExecuteQueryRequest())
            ->setInstanceName($formattedInstanceName)
            ->setQuery($query)
            ->setParams($params);
        $serverStream = $gapicClient->executeQuery($request);
        $this->assertInstanceOf(ServerStream::class, $serverStream);
        $responses = iterator_to_array($serverStream->readAll());
        $expectedResponses = [];
        $expectedResponses[] = $expectedResponse;
        $expectedResponses[] = $expectedResponse2;
        $expectedResponses[] = $expectedResponse3;
        $this->assertEquals($expectedResponses, $responses);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.bigtable.v2.Bigtable/ExecuteQuery', $actualFuncCall);
        $actualValue = $actualRequestObject->getInstanceName();
        $this->assertProtobufEquals($formattedInstanceName, $actualValue);
        $actualValue = $actualRequestObject->getQuery();
        $this->assertProtobufEquals($query, $actualValue);
        $actualValue = $actualRequestObject->getParams();
        $this->assertProtobufEquals($params, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function executeQueryExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->setStreamingStatus($status);
        $this->assertTrue($transport->isExhausted());
        // Mock request
        $formattedInstanceName = $gapicClient->instanceName('[PROJECT]', '[INSTANCE]');
        $query = 'query107944136';
        $paramsValue = new Value();
        $params = [
            'paramsKey' => $paramsValue,
        ];
        $request = (new ExecuteQueryRequest())
            ->setInstanceName($formattedInstanceName)
            ->setQuery($query)
            ->setParams($params);
        $serverStream = $gapicClient->executeQuery($request);
        $results = $serverStream->readAll();
        try {
            iterator_to_array($results);
            // If the close stream method call did not throw, fail the test
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
    public function generateInitialChangeStreamPartitionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GenerateInitialChangeStreamPartitionsResponse();
        $transport->addResponse($expectedResponse);
        $expectedResponse2 = new GenerateInitialChangeStreamPartitionsResponse();
        $transport->addResponse($expectedResponse2);
        $expectedResponse3 = new GenerateInitialChangeStreamPartitionsResponse();
        $transport->addResponse($expectedResponse3);
        // Mock request
        $formattedTableName = $gapicClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
        $request = (new GenerateInitialChangeStreamPartitionsRequest())
            ->setTableName($formattedTableName);
        $serverStream = $gapicClient->generateInitialChangeStreamPartitions($request);
        $this->assertInstanceOf(ServerStream::class, $serverStream);
        $responses = iterator_to_array($serverStream->readAll());
        $expectedResponses = [];
        $expectedResponses[] = $expectedResponse;
        $expectedResponses[] = $expectedResponse2;
        $expectedResponses[] = $expectedResponse3;
        $this->assertEquals($expectedResponses, $responses);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.bigtable.v2.Bigtable/GenerateInitialChangeStreamPartitions', $actualFuncCall);
        $actualValue = $actualRequestObject->getTableName();
        $this->assertProtobufEquals($formattedTableName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function generateInitialChangeStreamPartitionsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->setStreamingStatus($status);
        $this->assertTrue($transport->isExhausted());
        // Mock request
        $formattedTableName = $gapicClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
        $request = (new GenerateInitialChangeStreamPartitionsRequest())
            ->setTableName($formattedTableName);
        $serverStream = $gapicClient->generateInitialChangeStreamPartitions($request);
        $results = $serverStream->readAll();
        try {
            iterator_to_array($results);
            // If the close stream method call did not throw, fail the test
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
    public function mutateRowTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new MutateRowResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedTableName = $gapicClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
        $rowKey = '122';
        $mutations = [];
        $request = (new MutateRowRequest())
            ->setTableName($formattedTableName)
            ->setRowKey($rowKey)
            ->setMutations($mutations);
        $response = $gapicClient->mutateRow($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.bigtable.v2.Bigtable/MutateRow', $actualFuncCall);
        $actualValue = $actualRequestObject->getTableName();
        $this->assertProtobufEquals($formattedTableName, $actualValue);
        $actualValue = $actualRequestObject->getRowKey();
        $this->assertProtobufEquals($rowKey, $actualValue);
        $actualValue = $actualRequestObject->getMutations();
        $this->assertProtobufEquals($mutations, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function mutateRowExceptionTest()
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
        $formattedTableName = $gapicClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
        $rowKey = '122';
        $mutations = [];
        $request = (new MutateRowRequest())
            ->setTableName($formattedTableName)
            ->setRowKey($rowKey)
            ->setMutations($mutations);
        try {
            $gapicClient->mutateRow($request);
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
    public function mutateRowsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new MutateRowsResponse();
        $transport->addResponse($expectedResponse);
        $expectedResponse2 = new MutateRowsResponse();
        $transport->addResponse($expectedResponse2);
        $expectedResponse3 = new MutateRowsResponse();
        $transport->addResponse($expectedResponse3);
        // Mock request
        $formattedTableName = $gapicClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
        $entries = [];
        $request = (new MutateRowsRequest())
            ->setTableName($formattedTableName)
            ->setEntries($entries);
        $serverStream = $gapicClient->mutateRows($request);
        $this->assertInstanceOf(ServerStream::class, $serverStream);
        $responses = iterator_to_array($serverStream->readAll());
        $expectedResponses = [];
        $expectedResponses[] = $expectedResponse;
        $expectedResponses[] = $expectedResponse2;
        $expectedResponses[] = $expectedResponse3;
        $this->assertEquals($expectedResponses, $responses);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.bigtable.v2.Bigtable/MutateRows', $actualFuncCall);
        $actualValue = $actualRequestObject->getTableName();
        $this->assertProtobufEquals($formattedTableName, $actualValue);
        $actualValue = $actualRequestObject->getEntries();
        $this->assertProtobufEquals($entries, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function mutateRowsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->setStreamingStatus($status);
        $this->assertTrue($transport->isExhausted());
        // Mock request
        $formattedTableName = $gapicClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
        $entries = [];
        $request = (new MutateRowsRequest())
            ->setTableName($formattedTableName)
            ->setEntries($entries);
        $serverStream = $gapicClient->mutateRows($request);
        $results = $serverStream->readAll();
        try {
            iterator_to_array($results);
            // If the close stream method call did not throw, fail the test
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
    public function pingAndWarmTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new PingAndWarmResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->instanceName('[PROJECT]', '[INSTANCE]');
        $request = (new PingAndWarmRequest())
            ->setName($formattedName);
        $response = $gapicClient->pingAndWarm($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.bigtable.v2.Bigtable/PingAndWarm', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function pingAndWarmExceptionTest()
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
        $formattedName = $gapicClient->instanceName('[PROJECT]', '[INSTANCE]');
        $request = (new PingAndWarmRequest())
            ->setName($formattedName);
        try {
            $gapicClient->pingAndWarm($request);
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
    public function readChangeStreamTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ReadChangeStreamResponse();
        $transport->addResponse($expectedResponse);
        $expectedResponse2 = new ReadChangeStreamResponse();
        $transport->addResponse($expectedResponse2);
        $expectedResponse3 = new ReadChangeStreamResponse();
        $transport->addResponse($expectedResponse3);
        // Mock request
        $formattedTableName = $gapicClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
        $request = (new ReadChangeStreamRequest())
            ->setTableName($formattedTableName);
        $serverStream = $gapicClient->readChangeStream($request);
        $this->assertInstanceOf(ServerStream::class, $serverStream);
        $responses = iterator_to_array($serverStream->readAll());
        $expectedResponses = [];
        $expectedResponses[] = $expectedResponse;
        $expectedResponses[] = $expectedResponse2;
        $expectedResponses[] = $expectedResponse3;
        $this->assertEquals($expectedResponses, $responses);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.bigtable.v2.Bigtable/ReadChangeStream', $actualFuncCall);
        $actualValue = $actualRequestObject->getTableName();
        $this->assertProtobufEquals($formattedTableName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function readChangeStreamExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->setStreamingStatus($status);
        $this->assertTrue($transport->isExhausted());
        // Mock request
        $formattedTableName = $gapicClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
        $request = (new ReadChangeStreamRequest())
            ->setTableName($formattedTableName);
        $serverStream = $gapicClient->readChangeStream($request);
        $results = $serverStream->readAll();
        try {
            iterator_to_array($results);
            // If the close stream method call did not throw, fail the test
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
    public function readModifyWriteRowTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ReadModifyWriteRowResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedTableName = $gapicClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
        $rowKey = '122';
        $rules = [];
        $request = (new ReadModifyWriteRowRequest())
            ->setTableName($formattedTableName)
            ->setRowKey($rowKey)
            ->setRules($rules);
        $response = $gapicClient->readModifyWriteRow($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.bigtable.v2.Bigtable/ReadModifyWriteRow', $actualFuncCall);
        $actualValue = $actualRequestObject->getTableName();
        $this->assertProtobufEquals($formattedTableName, $actualValue);
        $actualValue = $actualRequestObject->getRowKey();
        $this->assertProtobufEquals($rowKey, $actualValue);
        $actualValue = $actualRequestObject->getRules();
        $this->assertProtobufEquals($rules, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function readModifyWriteRowExceptionTest()
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
        $formattedTableName = $gapicClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
        $rowKey = '122';
        $rules = [];
        $request = (new ReadModifyWriteRowRequest())
            ->setTableName($formattedTableName)
            ->setRowKey($rowKey)
            ->setRules($rules);
        try {
            $gapicClient->readModifyWriteRow($request);
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
    public function readRowsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $lastScannedRowKey = '-126';
        $expectedResponse = new ReadRowsResponse();
        $expectedResponse->setLastScannedRowKey($lastScannedRowKey);
        $transport->addResponse($expectedResponse);
        $lastScannedRowKey2 = '-75';
        $expectedResponse2 = new ReadRowsResponse();
        $expectedResponse2->setLastScannedRowKey($lastScannedRowKey2);
        $transport->addResponse($expectedResponse2);
        $lastScannedRowKey3 = '-74';
        $expectedResponse3 = new ReadRowsResponse();
        $expectedResponse3->setLastScannedRowKey($lastScannedRowKey3);
        $transport->addResponse($expectedResponse3);
        // Mock request
        $formattedTableName = $gapicClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
        $request = (new ReadRowsRequest())
            ->setTableName($formattedTableName);
        $serverStream = $gapicClient->readRows($request);
        $this->assertInstanceOf(ServerStream::class, $serverStream);
        $responses = iterator_to_array($serverStream->readAll());
        $expectedResponses = [];
        $expectedResponses[] = $expectedResponse;
        $expectedResponses[] = $expectedResponse2;
        $expectedResponses[] = $expectedResponse3;
        $this->assertEquals($expectedResponses, $responses);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.bigtable.v2.Bigtable/ReadRows', $actualFuncCall);
        $actualValue = $actualRequestObject->getTableName();
        $this->assertProtobufEquals($formattedTableName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function readRowsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->setStreamingStatus($status);
        $this->assertTrue($transport->isExhausted());
        // Mock request
        $formattedTableName = $gapicClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
        $request = (new ReadRowsRequest())
            ->setTableName($formattedTableName);
        $serverStream = $gapicClient->readRows($request);
        $results = $serverStream->readAll();
        try {
            iterator_to_array($results);
            // If the close stream method call did not throw, fail the test
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
    public function sampleRowKeysTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $rowKey = '122';
        $offsetBytes = 889884095;
        $expectedResponse = new SampleRowKeysResponse();
        $expectedResponse->setRowKey($rowKey);
        $expectedResponse->setOffsetBytes($offsetBytes);
        $transport->addResponse($expectedResponse);
        $rowKey2 = '-83';
        $offsetBytes2 = 480126386;
        $expectedResponse2 = new SampleRowKeysResponse();
        $expectedResponse2->setRowKey($rowKey2);
        $expectedResponse2->setOffsetBytes($offsetBytes2);
        $transport->addResponse($expectedResponse2);
        $rowKey3 = '-82';
        $offsetBytes3 = 480126387;
        $expectedResponse3 = new SampleRowKeysResponse();
        $expectedResponse3->setRowKey($rowKey3);
        $expectedResponse3->setOffsetBytes($offsetBytes3);
        $transport->addResponse($expectedResponse3);
        // Mock request
        $formattedTableName = $gapicClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
        $request = (new SampleRowKeysRequest())
            ->setTableName($formattedTableName);
        $serverStream = $gapicClient->sampleRowKeys($request);
        $this->assertInstanceOf(ServerStream::class, $serverStream);
        $responses = iterator_to_array($serverStream->readAll());
        $expectedResponses = [];
        $expectedResponses[] = $expectedResponse;
        $expectedResponses[] = $expectedResponse2;
        $expectedResponses[] = $expectedResponse3;
        $this->assertEquals($expectedResponses, $responses);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.bigtable.v2.Bigtable/SampleRowKeys', $actualFuncCall);
        $actualValue = $actualRequestObject->getTableName();
        $this->assertProtobufEquals($formattedTableName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function sampleRowKeysExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->setStreamingStatus($status);
        $this->assertTrue($transport->isExhausted());
        // Mock request
        $formattedTableName = $gapicClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
        $request = (new SampleRowKeysRequest())
            ->setTableName($formattedTableName);
        $serverStream = $gapicClient->sampleRowKeys($request);
        $results = $serverStream->readAll();
        try {
            iterator_to_array($results);
            // If the close stream method call did not throw, fail the test
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
    public function checkAndMutateRowAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $predicateMatched = true;
        $expectedResponse = new CheckAndMutateRowResponse();
        $expectedResponse->setPredicateMatched($predicateMatched);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedTableName = $gapicClient->tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');
        $rowKey = '122';
        $request = (new CheckAndMutateRowRequest())
            ->setTableName($formattedTableName)
            ->setRowKey($rowKey);
        $response = $gapicClient->checkAndMutateRowAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.bigtable.v2.Bigtable/CheckAndMutateRow', $actualFuncCall);
        $actualValue = $actualRequestObject->getTableName();
        $this->assertProtobufEquals($formattedTableName, $actualValue);
        $actualValue = $actualRequestObject->getRowKey();
        $this->assertProtobufEquals($rowKey, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
