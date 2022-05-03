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

namespace Google\Cloud\Datastore\Tests\Snippet;

use Google\Cloud\Core\Testing\DatastoreOperationRefreshTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Datastore\Connection\ConnectionInterface;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\DatastoreSessionHandler;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group datastore
 * @group datastore-session
 * @runTestsInSeparateProcesses
 */
class DatastoreSessionHandlerTest extends SnippetTestCase
{
    use ExpectException;
    use DatastoreOperationRefreshTrait;

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
        self::snippetFromClass(DatastoreSessionHandler::class);
        self::snippetFromClass(DatastoreSessionHandler::class, 1);
    }

    public function set_up()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = TestHelpers::stub(DatastoreClient::class, [], [
            'operation',
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(DatastoreSessionHandler::class);
        $snippet->replace('$datastore = new DatastoreClient();', '');

        $this->connection->lookup(Argument::allOf(
            Argument::withEntry('transaction', self::TRANSACTION),
            Argument::that(function ($args) {
                return $args['keys'][0]['partitionId']['namespaceId'] === 'sessions'
                 && $args['keys'][0]['path'][0]['kind'] === 'PHPSESSID'
                 && isset($args['keys'][0]['path'][0]['name']);
            })
        ))->shouldBeCalled()->willReturn([]);

        $this->connection->beginTransaction(Argument::withEntry(
            'transactionOptions',
            ['readWrite' => (object) []]
        ))->shouldBeCalled()->willReturn([
            'transaction' => self::TRANSACTION,
        ]);

        $this->connection->commit(Argument::allOf(
            Argument::withEntry('transaction', self::TRANSACTION),
            Argument::withEntry('mode', 'TRANSACTIONAL'),
            Argument::that(function ($args) {
                $value = 'name|'.serialize('Bob');

                return $args['mutations'][0]['upsert']['key']['partitionId']['namespaceId'] === 'sessions'
                    && $args['mutations'][0]['upsert']['key']['path'][0]['kind'] === 'PHPSESSID'
                    && isset($args['mutations'][0]['upsert']['key']['path'][0]['name'])
                    && $args['mutations'][0]['upsert']['properties']['data']['stringValue'] === $value
                    && isset($args['mutations'][0]['upsert']['properties']['t']);
            })
        ))->shouldBeCalled()->willReturn([]);

        $this->refreshOperation($this->client, $this->connection->reveal());
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke();
        session_write_close();

        $this->assertEquals('Bob', $res->output());
    }

    public function testClassErrorHandler()
    {
        $this->expectException('\RuntimeException');

        $snippet = $this->snippetFromClass(DatastoreSessionHandler::class, 1);
        $snippet->replace('$datastore = new DatastoreClient();', '');

        $this->connection->lookup(Argument::allOf(
            Argument::withEntry('transaction', self::TRANSACTION),
            Argument::that(function ($args) {
                return $args['keys'][0]['partitionId']['namespaceId'] === 'sessions'
                 && $args['keys'][0]['path'][0]['kind'] === 'PHPSESSID'
                 && isset($args['keys'][0]['path'][0]['name']);
            })
        ))->shouldBeCalled()->willReturn([]);

        $this->connection->beginTransaction(Argument::withEntry(
            'transactionOptions',
            ['readWrite' => (object) []]
        ))->shouldBeCalled()->willReturn([
            'transaction' => self::TRANSACTION,
        ]);

        $this->connection->commit(Argument::any())
            ->shouldBeCalled()
            ->will(function () {
                trigger_error('oops!', E_USER_WARNING);
            });

        $this->refreshOperation($this->client, $this->connection->reveal());
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke();
        session_write_close();

        $this->assertEquals('Bob', $res->output());
    }
}
