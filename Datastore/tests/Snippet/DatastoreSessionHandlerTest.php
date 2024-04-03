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

use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\DatastoreOperationRefreshTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\DatastoreSessionHandler;
use Google\Cloud\Datastore\V1\Client\DatastoreClient as V1DatastoreClient;
use Google\Cloud\Datastore\V1\CommitRequest\Mode;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group datastore
 * @group datastore-session
 * @runTestsInSeparateProcesses
 */
class DatastoreSessionHandlerTest extends SnippetTestCase
{
    use DatastoreOperationRefreshTrait;
    use ProphecyTrait;
    use ApiHelperTrait;

    const TRANSACTION = 'transaction-id';
    const PROJECT = 'example-project';

    private $client;
    private $requestHandler;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        // Since the tests in this class must run in isolation, they won't be
        // recognized as having been covered, and will cause a CI error.
        // We can call `snippetFromClass` in the parent process to mark the
        // snippets as having been covered.
        self::snippetFromClass(DatastoreSessionHandler::class);
        self::snippetFromClass(DatastoreSessionHandler::class, 1);
    }

    public function setUp(): void
    {
        $this->client = TestHelpers::stub(DatastoreClient::class, [], [
            'operation',
        ]);
        $this->requestHandler = $this->prophesize(RequestHandler::class);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(DatastoreSessionHandler::class);
        $snippet->replace('$datastore = new DatastoreClient();', '');

        $this->mockSendRequest(
            'lookup',
            [
                'keys' => [
                    [
                        'partitionId' => ['namespaceId' => 'sessions'],
                        'path' => [
                            ['kind' => 'PHPSESSID']
                        ]
                    ]
                ],
                'readOptions' => ['transaction' => self::TRANSACTION]
            ],
            [],
            0
        );

        $this->mockSendRequest(
            'beginTransaction',
            ['transactionOptions' => ['readWrite' => []]],
            ['transaction' => self::TRANSACTION]
        );

        $this->mockSendRequest(
            'commit',
            [
                'transaction' => self::TRANSACTION,
                'mode' => Mode::TRANSACTIONAL,
                'mutations' => [['upsert' => [
                    'key' => [
                        'path' => [['kind' => 'PHPSESSID']],
                        'partitionId' => ['namespaceId' => 'sessions']
                    ],
                    'properties' => ['data' => ['stringValue' => 'name|'.serialize('Bob')]]
                ]]]
            ],
            [],
            0
        );

        $this->refreshOperation($this->client, $this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke();
        session_write_close();

        $this->assertEquals('Bob', $res->output());
    }

    public function testClassErrorHandler()
    {
        $this->expectException(\RuntimeException::class);

        $snippet = $this->snippetFromClass(DatastoreSessionHandler::class, 1);
        $snippet->replace('$datastore = new DatastoreClient();', '');

        $this->mockSendRequest(
            'lookup',
            [
                'keys' => [
                    [
                        'partitionId' => ['namespaceId' => 'sessions'],
                        'path' => [
                            ['kind' => 'PHPSESSID']
                        ]
                    ]
                ],
                'readOptions' => ['transaction' => self::TRANSACTION]
            ],
            [],
            0
        );

        $this->mockSendRequest(
            'beginTransaction',
            ['transactionOptions' => ['readWrite' => []]],
            ['transaction' => self::TRANSACTION]
        );

        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'commit',
            Argument::cetera()
        )->shouldBeCalled()->will(fn () => trigger_error('oops!', E_USER_WARNING));


        $this->refreshOperation($this->client, $this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke();
        session_write_close();

        $this->assertEquals('Bob', $res->output());
    }
}
