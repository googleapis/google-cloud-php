<?php
/**
 * Copyright 2019 Google LLC.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Firestore\Tests\Snippet;

use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\FirestoreTestHelperTrait;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\FirestoreSessionHandler;
use Google\Cloud\Firestore\V1\BatchGetDocumentsRequest;
use Google\Cloud\Firestore\V1\BeginTransactionRequest;
use Google\Cloud\Firestore\V1\Client\FirestoreClient as V1FirestoreClient;
use Google\Cloud\Firestore\V1\CommitRequest;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group firestore
 * @group firestore-session
 * @runTestsInSeparateProcesses
 */
class FirestoreSessionHandlerTest extends SnippetTestCase
{
    use FirestoreTestHelperTrait;
    use GrpcTestTrait;
    use ProphecyTrait;

    const TRANSACTION = 'transaction-id';

    private $connection;
    private $requestHandler;
    private $serializer;
    private $client;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        // Since the tests in this class must run in isolation, they won't be
        // recognized as having been covered, and will cause a CI error.
        // We can call `snippetFromClass` in the parent process to mark the
        // snippets as having been covered.
        self::snippetFromClass(FirestoreSessionHandler::class);
        self::snippetFromClass(FirestoreSessionHandler::class, 1);
        self::snippetFromMethod(FirestoreClient::class, 'sessionHandler');
    }

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->requestHandler = $this->prophesize(RequestHandler::class);
        $this->serializer = $this->getSerializer();
        $this->client = TestHelpers::stub(FirestoreClient::class, [], [
            'connection',
            'requestHandler'
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(FirestoreSessionHandler::class);
        $snippet->replace('$firestore = new FirestoreClient();', '');

        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'batchGetDocuments',
            Argument::type(BatchGetDocumentsRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(new \ArrayIterator([
            'found' => [
                [
                    'name' => '',
                    'fields' => []
                ]
            ]
        ]));

        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'beginTransaction',
            Argument::type(BeginTransactionRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([
            'transaction' => self::TRANSACTION
        ]);

        $value = 'name|' . serialize('Bob');
        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'commit',
            Argument::that(function ($req) use ($value) {
                $data = $this->getSerializer()->encodeMessage($req);
                return strpos($data['writes'][0]['update']['name'], ':PHPSESSID') !== false
                    && $data['writes'][0]['update']['fields']['data']['stringValue'] === $value
                    && isset($data['writes'][0]['update']['fields']['t']['integerValue'])
                    && $data['transaction'] == self::TRANSACTION;
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([
            'writeResults' => []
        ]);

        $this->client->___setProperty('connection', $this->connection->reveal());
        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());
        $snippet->addLocal('firestore', $this->client);

        $res = $snippet->invoke();
        session_write_close();

        $this->assertEquals('Bob', $res->output());
    }

    public function testSessionHandlerMethod()
    {
        $snippet = $this->snippetFromMethod(FirestoreClient::class, 'sessionHandler');

        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'batchGetDocuments',
            Argument::type(BatchGetDocumentsRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(new \ArrayIterator([
            'found' => [
                [
                    'name' => '',
                    'fields' => []
                ]
            ]
        ]));

        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'beginTransaction',
            Argument::type(BeginTransactionRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([
            'transaction' => self::TRANSACTION
        ]);

        $value = 'name|' . serialize('Bob');
        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'commit',
            Argument::that(function ($req) use ($value) {
                $data = $this->getSerializer()->encodeMessage($req);
                return strpos($data['writes'][0]['update']['name'], ':PHPSESSID') !== false
                    && $data['writes'][0]['update']['fields']['data']['stringValue'] === $value
                    && isset($data['writes'][0]['update']['fields']['t']['integerValue'])
                    && $data['transaction'] == self::TRANSACTION;
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([
            'writeResults' => []
        ]);

        $this->client->___setProperty('connection', $this->connection->reveal());
        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());
        $snippet->addLocal('firestore', $this->client);

        $res = $snippet->invoke();
        session_write_close();

        $this->assertEquals('Bob', $res->output());
    }

    public function testClassErrorHandler()
    {
        $this->expectException(\RuntimeException::class);

        $snippet = $this->snippetFromClass(FirestoreSessionHandler::class, 1);
        $snippet->replace('$firestore = new FirestoreClient();', '');

        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'batchGetDocuments',
            Argument::type(BatchGetDocumentsRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(new \ArrayIterator([
            'found' => [
                [
                    'name' => '',
                    'fields' => []
                ]
            ]
        ]));

        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'beginTransaction',
            Argument::type(BeginTransactionRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([
            'transaction' => self::TRANSACTION
        ]);

        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'commit',
            Argument::type(CommitRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->will(function () {
            trigger_error('oops!', E_USER_WARNING);
        });

        $this->client->___setProperty('connection', $this->connection->reveal());
        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());
        $snippet->addLocal('firestore', $this->client);

        $res = $snippet->invoke();

        $this->assertEquals('Bob', $res->output());
    }
}
