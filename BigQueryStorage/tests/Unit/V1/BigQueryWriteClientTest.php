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

namespace Google\Cloud\BigQuery\Storage\Tests\Unit\V1;

use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\BigQuery\Storage\V1\AppendRowsRequest;
use Google\Cloud\BigQuery\Storage\V1\AppendRowsResponse;
use Google\Cloud\BigQuery\Storage\V1\BatchCommitWriteStreamsResponse;
use Google\Cloud\BigQuery\Storage\V1\BigQueryWriteClient;
use Google\Cloud\BigQuery\Storage\V1\FinalizeWriteStreamResponse;
use Google\Cloud\BigQuery\Storage\V1\FlushRowsResponse;
use Google\Cloud\BigQuery\Storage\V1\WriteStream;
use Google\Rpc\Code;
use stdClass;

/**
 * @group storage
 *
 * @group gapic
 */
class BigQueryWriteClientTest extends GeneratedTest
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

    /** @return BigQueryWriteClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new BigQueryWriteClient($options);
    }

    /** @test */
    public function appendRowsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $writeStream = 'writeStream-1431753760';
        $expectedResponse = new AppendRowsResponse();
        $expectedResponse->setWriteStream($writeStream);
        $transport->addResponse($expectedResponse);
        $writeStream2 = 'writeStream2-1525825645';
        $expectedResponse2 = new AppendRowsResponse();
        $expectedResponse2->setWriteStream($writeStream2);
        $transport->addResponse($expectedResponse2);
        $writeStream3 = 'writeStream3-1525825644';
        $expectedResponse3 = new AppendRowsResponse();
        $expectedResponse3->setWriteStream($writeStream3);
        $transport->addResponse($expectedResponse3);
        // Mock request
        $formattedWriteStream4 = $gapicClient->writeStreamName('[PROJECT]', '[DATASET]', '[TABLE]', '[STREAM]');
        $request = new AppendRowsRequest();
        $request->setWriteStream($formattedWriteStream4);
        $formattedWriteStream5 = $gapicClient->writeStreamName('[PROJECT]', '[DATASET]', '[TABLE]', '[STREAM]');
        $request2 = new AppendRowsRequest();
        $request2->setWriteStream($formattedWriteStream5);
        $formattedWriteStream6 = $gapicClient->writeStreamName('[PROJECT]', '[DATASET]', '[TABLE]', '[STREAM]');
        $request3 = new AppendRowsRequest();
        $request3->setWriteStream($formattedWriteStream6);
        $bidi = $gapicClient->appendRows();
        $this->assertInstanceOf(BidiStream::class, $bidi);
        $bidi->write($request);
        $responses = [];
        $responses[] = $bidi->read();
        $bidi->writeAll([
            $request2,
            $request3,
        ]);
        foreach ($bidi->closeWriteAndReadAll() as $response) {
            $responses[] = $response;
        }

        $expectedResponses = [];
        $expectedResponses[] = $expectedResponse;
        $expectedResponses[] = $expectedResponse2;
        $expectedResponses[] = $expectedResponse3;
        $this->assertEquals($expectedResponses, $responses);
        $createStreamRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($createStreamRequests));
        $streamFuncCall = $createStreamRequests[0]->getFuncCall();
        $streamRequestObject = $createStreamRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.storage.v1.BigQueryWrite/AppendRows', $streamFuncCall);
        $this->assertNull($streamRequestObject);
        $callObjects = $transport->popCallObjects();
        $this->assertSame(1, count($callObjects));
        $bidiCall = $callObjects[0];
        $writeRequests = $bidiCall->popReceivedCalls();
        $expectedRequests = [];
        $expectedRequests[] = $request;
        $expectedRequests[] = $request2;
        $expectedRequests[] = $request3;
        $this->assertEquals($expectedRequests, $writeRequests);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function appendRowsExceptionTest()
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
        $bidi = $gapicClient->appendRows();
        $results = $bidi->closeWriteAndReadAll();
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
    public function batchCommitWriteStreamsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCommitWriteStreamsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->tableName('[PROJECT]', '[DATASET]', '[TABLE]');
        $writeStreams = [];
        $response = $gapicClient->batchCommitWriteStreams($formattedParent, $writeStreams);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.storage.v1.BigQueryWrite/BatchCommitWriteStreams', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getWriteStreams();
        $this->assertProtobufEquals($writeStreams, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchCommitWriteStreamsExceptionTest()
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
        $formattedParent = $gapicClient->tableName('[PROJECT]', '[DATASET]', '[TABLE]');
        $writeStreams = [];
        try {
            $gapicClient->batchCommitWriteStreams($formattedParent, $writeStreams);
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
    public function createWriteStreamTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $location = 'location1901043637';
        $expectedResponse = new WriteStream();
        $expectedResponse->setName($name);
        $expectedResponse->setLocation($location);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->tableName('[PROJECT]', '[DATASET]', '[TABLE]');
        $writeStream = new WriteStream();
        $response = $gapicClient->createWriteStream($formattedParent, $writeStream);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.storage.v1.BigQueryWrite/CreateWriteStream', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getWriteStream();
        $this->assertProtobufEquals($writeStream, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createWriteStreamExceptionTest()
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
        $formattedParent = $gapicClient->tableName('[PROJECT]', '[DATASET]', '[TABLE]');
        $writeStream = new WriteStream();
        try {
            $gapicClient->createWriteStream($formattedParent, $writeStream);
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
    public function finalizeWriteStreamTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $rowCount = 1340416618;
        $expectedResponse = new FinalizeWriteStreamResponse();
        $expectedResponse->setRowCount($rowCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->writeStreamName('[PROJECT]', '[DATASET]', '[TABLE]', '[STREAM]');
        $response = $gapicClient->finalizeWriteStream($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.storage.v1.BigQueryWrite/FinalizeWriteStream', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function finalizeWriteStreamExceptionTest()
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
        $formattedName = $gapicClient->writeStreamName('[PROJECT]', '[DATASET]', '[TABLE]', '[STREAM]');
        try {
            $gapicClient->finalizeWriteStream($formattedName);
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
    public function flushRowsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $offset2 = 755984506;
        $expectedResponse = new FlushRowsResponse();
        $expectedResponse->setOffset($offset2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedWriteStream = $gapicClient->writeStreamName('[PROJECT]', '[DATASET]', '[TABLE]', '[STREAM]');
        $response = $gapicClient->flushRows($formattedWriteStream);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.storage.v1.BigQueryWrite/FlushRows', $actualFuncCall);
        $actualValue = $actualRequestObject->getWriteStream();
        $this->assertProtobufEquals($formattedWriteStream, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function flushRowsExceptionTest()
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
        $formattedWriteStream = $gapicClient->writeStreamName('[PROJECT]', '[DATASET]', '[TABLE]', '[STREAM]');
        try {
            $gapicClient->flushRows($formattedWriteStream);
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
    public function getWriteStreamTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $location = 'location1901043637';
        $expectedResponse = new WriteStream();
        $expectedResponse->setName($name2);
        $expectedResponse->setLocation($location);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->writeStreamName('[PROJECT]', '[DATASET]', '[TABLE]', '[STREAM]');
        $response = $gapicClient->getWriteStream($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.bigquery.storage.v1.BigQueryWrite/GetWriteStream', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getWriteStreamExceptionTest()
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
        $formattedName = $gapicClient->writeStreamName('[PROJECT]', '[DATASET]', '[TABLE]', '[STREAM]');
        try {
            $gapicClient->getWriteStream($formattedName);
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
}
