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

namespace Google\Cloud\Firestore\Tests\Unit\V1beta1;

use Google\Cloud\Firestore\V1beta1\FirestoreClient;
use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\ServerStream;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Firestore\V1beta1\BatchGetDocumentsResponse;
use Google\Cloud\Firestore\V1beta1\BeginTransactionResponse;
use Google\Cloud\Firestore\V1beta1\CommitResponse;
use Google\Cloud\Firestore\V1beta1\Document;
use Google\Cloud\Firestore\V1beta1\DocumentMask;
use Google\Cloud\Firestore\V1beta1\ListCollectionIdsResponse;
use Google\Cloud\Firestore\V1beta1\ListDocumentsResponse;
use Google\Cloud\Firestore\V1beta1\ListenRequest;
use Google\Cloud\Firestore\V1beta1\ListenResponse;
use Google\Cloud\Firestore\V1beta1\RunQueryResponse;
use Google\Cloud\Firestore\V1beta1\Write;
use Google\Cloud\Firestore\V1beta1\WriteRequest;
use Google\Cloud\Firestore\V1beta1\WriteResponse;
use Google\Protobuf\Any;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group firestore
 * @group gapic
 */
class FirestoreClientTest extends GeneratedTest
{
    /**
     * @return TransportInterface
     */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /**
     * @return FirestoreClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->getMockBuilder(CredentialsWrapper::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        return new FirestoreClient($options);
    }

    /**
     * @test
     */
    public function getDocumentTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new Document();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');

        $response = $client->getDocument($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.firestore.v1beta1.Firestore/GetDocument', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getDocumentExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $formattedName = $client->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');

        try {
            $client->getDocument($formattedName);
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
    public function listDocumentsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $nextPageToken = '';
        $documentsElement = new Document();
        $documents = [$documentsElement];
        $expectedResponse = new ListDocumentsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDocuments($documents);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedParent = $client->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');
        $collectionId = 'collectionId-821242276';

        $response = $client->listDocuments($formattedParent, $collectionId);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDocuments()[0], $resources[0]);

        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.firestore.v1beta1.Firestore/ListDocuments', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCollectionId();

        $this->assertProtobufEquals($collectionId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listDocumentsExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $formattedParent = $client->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');
        $collectionId = 'collectionId-821242276';

        try {
            $client->listDocuments($formattedParent, $collectionId);
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
    public function createDocumentTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $expectedResponse = new Document();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedParent = $client->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');
        $collectionId = 'collectionId-821242276';
        $documentId = 'documentId506676927';
        $document = new Document();

        $response = $client->createDocument($formattedParent, $collectionId, $documentId, $document);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.firestore.v1beta1.Firestore/CreateDocument', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCollectionId();

        $this->assertProtobufEquals($collectionId, $actualValue);
        $actualValue = $actualRequestObject->getDocumentId();

        $this->assertProtobufEquals($documentId, $actualValue);
        $actualValue = $actualRequestObject->getDocument();

        $this->assertProtobufEquals($document, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function createDocumentExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $formattedParent = $client->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');
        $collectionId = 'collectionId-821242276';
        $documentId = 'documentId506676927';
        $document = new Document();

        try {
            $client->createDocument($formattedParent, $collectionId, $documentId, $document);
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
    public function updateDocumentTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $name = 'name3373707';
        $expectedResponse = new Document();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);

        // Mock request
        $document = new Document();
        $updateMask = new DocumentMask();

        $response = $client->updateDocument($document, $updateMask);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.firestore.v1beta1.Firestore/UpdateDocument', $actualFuncCall);

        $actualValue = $actualRequestObject->getDocument();

        $this->assertProtobufEquals($document, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();

        $this->assertProtobufEquals($updateMask, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function updateDocumentExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $document = new Document();
        $updateMask = new DocumentMask();

        try {
            $client->updateDocument($document, $updateMask);
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
    public function deleteDocumentTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedName = $client->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');

        $client->deleteDocument($formattedName);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.firestore.v1beta1.Firestore/DeleteDocument', $actualFuncCall);

        $actualValue = $actualRequestObject->getName();

        $this->assertProtobufEquals($formattedName, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteDocumentExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $formattedName = $client->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');

        try {
            $client->deleteDocument($formattedName);
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
    public function batchGetDocumentsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $missing = 'missing1069449574';
        $transaction = '-34';
        $expectedResponse = new BatchGetDocumentsResponse();
        $expectedResponse->setMissing($missing);
        $expectedResponse->setTransaction($transaction);
        $transport->addResponse($expectedResponse);
        $missing2 = 'missing21243859865';
        $transaction2 = '17';
        $expectedResponse2 = new BatchGetDocumentsResponse();
        $expectedResponse2->setMissing($missing2);
        $expectedResponse2->setTransaction($transaction2);
        $transport->addResponse($expectedResponse2);
        $missing3 = 'missing31243859866';
        $transaction3 = '18';
        $expectedResponse3 = new BatchGetDocumentsResponse();
        $expectedResponse3->setMissing($missing3);
        $expectedResponse3->setTransaction($transaction3);
        $transport->addResponse($expectedResponse3);

        // Mock request
        $formattedDatabase = $client->databaseRootName('[PROJECT]', '[DATABASE]');
        $documents = [];

        $serverStream = $client->batchGetDocuments($formattedDatabase, $documents);
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
        $this->assertSame('/google.firestore.v1beta1.Firestore/BatchGetDocuments', $actualFuncCall);

        $actualValue = $actualRequestObject->getDatabase();

        $this->assertProtobufEquals($formattedDatabase, $actualValue);
        $actualValue = $actualRequestObject->getDocuments();

        $this->assertProtobufEquals($documents, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function batchGetDocumentsExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

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
        $formattedDatabase = $client->databaseRootName('[PROJECT]', '[DATABASE]');
        $documents = [];

        $serverStream = $client->batchGetDocuments($formattedDatabase, $documents);
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

    /**
     * @test
     */
    public function beginTransactionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $transaction = '-34';
        $expectedResponse = new BeginTransactionResponse();
        $expectedResponse->setTransaction($transaction);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedDatabase = $client->databaseRootName('[PROJECT]', '[DATABASE]');

        $response = $client->beginTransaction($formattedDatabase);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.firestore.v1beta1.Firestore/BeginTransaction', $actualFuncCall);

        $actualValue = $actualRequestObject->getDatabase();

        $this->assertProtobufEquals($formattedDatabase, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function beginTransactionExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $formattedDatabase = $client->databaseRootName('[PROJECT]', '[DATABASE]');

        try {
            $client->beginTransaction($formattedDatabase);
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
    public function commitTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new CommitResponse();
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedDatabase = $client->databaseRootName('[PROJECT]', '[DATABASE]');
        $writes = [];

        $response = $client->commit($formattedDatabase, $writes);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.firestore.v1beta1.Firestore/Commit', $actualFuncCall);

        $actualValue = $actualRequestObject->getDatabase();

        $this->assertProtobufEquals($formattedDatabase, $actualValue);
        $actualValue = $actualRequestObject->getWrites();

        $this->assertProtobufEquals($writes, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function commitExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $formattedDatabase = $client->databaseRootName('[PROJECT]', '[DATABASE]');
        $writes = [];

        try {
            $client->commit($formattedDatabase, $writes);
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
    public function rollbackTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedDatabase = $client->databaseRootName('[PROJECT]', '[DATABASE]');
        $transaction = '-34';

        $client->rollback($formattedDatabase, $transaction);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.firestore.v1beta1.Firestore/Rollback', $actualFuncCall);

        $actualValue = $actualRequestObject->getDatabase();

        $this->assertProtobufEquals($formattedDatabase, $actualValue);
        $actualValue = $actualRequestObject->getTransaction();

        $this->assertProtobufEquals($transaction, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function rollbackExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $formattedDatabase = $client->databaseRootName('[PROJECT]', '[DATABASE]');
        $transaction = '-34';

        try {
            $client->rollback($formattedDatabase, $transaction);
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
    public function runQueryTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $transaction = '-34';
        $skippedResults = 880286183;
        $expectedResponse = new RunQueryResponse();
        $expectedResponse->setTransaction($transaction);
        $expectedResponse->setSkippedResults($skippedResults);
        $transport->addResponse($expectedResponse);
        $transaction2 = '17';
        $skippedResults2 = 153532454;
        $expectedResponse2 = new RunQueryResponse();
        $expectedResponse2->setTransaction($transaction2);
        $expectedResponse2->setSkippedResults($skippedResults2);
        $transport->addResponse($expectedResponse2);
        $transaction3 = '18';
        $skippedResults3 = 153532453;
        $expectedResponse3 = new RunQueryResponse();
        $expectedResponse3->setTransaction($transaction3);
        $expectedResponse3->setSkippedResults($skippedResults3);
        $transport->addResponse($expectedResponse3);

        // Mock request
        $formattedParent = $client->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');

        $serverStream = $client->runQuery($formattedParent);
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
        $this->assertSame('/google.firestore.v1beta1.Firestore/RunQuery', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function runQueryExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

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
        $formattedParent = $client->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');

        $serverStream = $client->runQuery($formattedParent);
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

    /**
     * @test
     */
    public function writeTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $streamId = 'streamId-315624902';
        $streamToken = '122';
        $expectedResponse = new WriteResponse();
        $expectedResponse->setStreamId($streamId);
        $expectedResponse->setStreamToken($streamToken);
        $transport->addResponse($expectedResponse);
        $streamId2 = 'streamId21627150189';
        $streamToken2 = '-83';
        $expectedResponse2 = new WriteResponse();
        $expectedResponse2->setStreamId($streamId2);
        $expectedResponse2->setStreamToken($streamToken2);
        $transport->addResponse($expectedResponse2);
        $streamId3 = 'streamId31627150190';
        $streamToken3 = '-82';
        $expectedResponse3 = new WriteResponse();
        $expectedResponse3->setStreamId($streamId3);
        $expectedResponse3->setStreamToken($streamToken3);
        $transport->addResponse($expectedResponse3);

        // Mock request
        $formattedDatabase = $client->databaseRootName('[PROJECT]', '[DATABASE]');
        $request = new WriteRequest();
        $request->setDatabase($formattedDatabase);
        $formattedDatabase2 = $client->databaseRootName('[PROJECT]', '[DATABASE]');
        $request2 = new WriteRequest();
        $request2->setDatabase($formattedDatabase2);
        $formattedDatabase3 = $client->databaseRootName('[PROJECT]', '[DATABASE]');
        $request3 = new WriteRequest();
        $request3->setDatabase($formattedDatabase3);

        $bidi = $client->write();
        $this->assertInstanceOf(BidiStream::class, $bidi);

        $bidi->write($request);
        $responses = [];
        $responses[] = $bidi->read();

        $bidi->writeAll([$request2, $request3]);
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
        $this->assertSame('/google.firestore.v1beta1.Firestore/Write', $streamFuncCall);
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

    /**
     * @test
     */
    public function writeExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

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

        $bidi = $client->write();
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

    /**
     * @test
     */
    public function listenTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new ListenResponse();
        $transport->addResponse($expectedResponse);
        $expectedResponse2 = new ListenResponse();
        $transport->addResponse($expectedResponse2);
        $expectedResponse3 = new ListenResponse();
        $transport->addResponse($expectedResponse3);

        // Mock request
        $formattedDatabase = $client->databaseRootName('[PROJECT]', '[DATABASE]');
        $request = new ListenRequest();
        $request->setDatabase($formattedDatabase);
        $formattedDatabase2 = $client->databaseRootName('[PROJECT]', '[DATABASE]');
        $request2 = new ListenRequest();
        $request2->setDatabase($formattedDatabase2);
        $formattedDatabase3 = $client->databaseRootName('[PROJECT]', '[DATABASE]');
        $request3 = new ListenRequest();
        $request3->setDatabase($formattedDatabase3);

        $bidi = $client->listen();
        $this->assertInstanceOf(BidiStream::class, $bidi);

        $bidi->write($request);
        $responses = [];
        $responses[] = $bidi->read();

        $bidi->writeAll([$request2, $request3]);
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
        $this->assertSame('/google.firestore.v1beta1.Firestore/Listen', $streamFuncCall);
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

    /**
     * @test
     */
    public function listenExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

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

        $bidi = $client->listen();
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

    /**
     * @test
     */
    public function listCollectionIdsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $nextPageToken = '';
        $collectionIdsElement = 'collectionIdsElement1368994900';
        $collectionIds = [$collectionIdsElement];
        $expectedResponse = new ListCollectionIdsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCollectionIds($collectionIds);
        $transport->addResponse($expectedResponse);

        // Mock request
        $formattedParent = $client->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');

        $response = $client->listCollectionIds($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCollectionIds()[0], $resources[0]);

        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.firestore.v1beta1.Firestore/ListCollectionIds', $actualFuncCall);

        $actualValue = $actualRequestObject->getParent();

        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listCollectionIdsExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $formattedParent = $client->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');

        try {
            $client->listCollectionIds($formattedParent);
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
