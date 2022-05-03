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

use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\FirestoreSessionHandler;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group firestore
 * @group firestore-session
 * @runTestsInSeparateProcesses
 */
class FirestoreSessionHandlerTest extends SnippetTestCase
{
    use ExpectException;
    use GrpcTestTrait;

    const TRANSACTION = 'transaction-id';

    private $connection;
    private $client;

    public static function set_up_before_class()
    {
        parent::set_up_before_class();

        // Since the tests in this class must run in isolation, they won't be
        // recognized as having been covered, and will cause a CI error.
        // We can call `snippetFromClass` in the parent process to mark the
        // snippets as having been covered.
        self::snippetFromClass(FirestoreSessionHandler::class);
        self::snippetFromClass(FirestoreSessionHandler::class, 1);
        self::snippetFromMethod(FirestoreClient::class, 'sessionHandler');
    }

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = TestHelpers::stub(FirestoreClient::class);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(FirestoreSessionHandler::class);
        $snippet->replace('$firestore = new FirestoreClient();', '');

        $this->connection->batchGetDocuments(Argument::withEntry('documents', Argument::type('array')))
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([
                'found' => [
                    [
                        'name' => '',
                        'fields' => []
                    ]
                ]
            ]));

        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'transaction' => self::TRANSACTION
            ]);

        $value = 'name|' . serialize('Bob');
        $this->connection->commit(Argument::allOf(
            Argument::that(function ($args) use ($value) {
                return strpos($args['writes'][0]['update']['name'], ':PHPSESSID') !== false
                    && $args['writes'][0]['update']['fields']['data']['stringValue'] === $value
                    && isset($args['writes'][0]['update']['fields']['t']['integerValue']);
            }),
            Argument::withEntry('transaction', self::TRANSACTION)
        ))->shouldBeCalled()->willReturn([
            'writeResults' => []
        ]);

        $this->client->___setProperty('connection', $this->connection->reveal());
        $snippet->addLocal('firestore', $this->client);

        $res = $snippet->invoke();
        session_write_close();

        $this->assertEquals('Bob', $res->output());
    }

    public function testSessionHandlerMethod()
    {
        $snippet = $this->snippetFromMethod(FirestoreClient::class, 'sessionHandler');

        $this->connection->batchGetDocuments(Argument::withEntry('documents', Argument::type('array')))
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([
                'found' => [
                    [
                        'name' => '',
                        'fields' => []
                    ]
                ]
            ]));

        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'transaction' => self::TRANSACTION
            ]);

        $value = 'name|' . serialize('Bob');
        $this->connection->commit(Argument::allOf(
            Argument::that(function ($args) use ($value) {
                return strpos($args['writes'][0]['update']['name'], ':PHPSESSID') !== false
                    && $args['writes'][0]['update']['fields']['data']['stringValue'] === $value
                    && isset($args['writes'][0]['update']['fields']['t']['integerValue']);
            }),
            Argument::withEntry('transaction', self::TRANSACTION)
        ))->shouldBeCalled()->willReturn([
            'writeResults' => []
        ]);

        $this->client->___setProperty('connection', $this->connection->reveal());
        $snippet->addLocal('firestore', $this->client);

        $res = $snippet->invoke();
        session_write_close();

        $this->assertEquals('Bob', $res->output());
    }

    public function testClassErrorHandler()
    {
        $this->expectException('\RuntimeException');

        $snippet = $this->snippetFromClass(FirestoreSessionHandler::class, 1);
        $snippet->replace('$firestore = new FirestoreClient();', '');

        $this->connection->batchGetDocuments(Argument::any())
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([
                'found' => [
                    [
                        'name' => '',
                        'fields' => []
                    ]
                ]
            ]));

        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'transaction' => self::TRANSACTION
            ]);

        $this->connection->commit(Argument::any())
            ->shouldBeCalled()
            ->will(function () {
                trigger_error('oops!', E_USER_WARNING);
            });

        $this->client->___setProperty('connection', $this->connection->reveal());
        $snippet->addLocal('firestore', $this->client);

        $res = $snippet->invoke();

        $this->assertEquals('Bob', $res->output());
    }
}
