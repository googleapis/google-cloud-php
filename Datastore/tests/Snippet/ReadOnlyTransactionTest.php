<?php
/**
 * Copyright 2018 Google Inc.
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
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Query\QueryInterface;
use Google\Cloud\Datastore\ReadOnlyTransaction;
use Google\Cloud\Datastore\Tests\Unit\ProtoEncodeTrait;
use Google\Cloud\Datastore\V1\BeginTransactionResponse;
use Google\Cloud\Datastore\V1\Client\DatastoreClient as GapicDatastoreClient;
use Google\Cloud\Datastore\V1\LookupRequest;
use Google\Cloud\Datastore\V1\LookupResponse;
use Google\Cloud\Datastore\V1\RollbackRequest;
use Google\Cloud\Datastore\V1\RunQueryRequest;
use Google\Cloud\Datastore\V1\RunQueryResponse;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group datastore
 */
class ReadOnlyTransactionTest extends SnippetTestCase
{
    use DatastoreOperationRefreshTrait;
    use ProphecyTrait;
    use ProtoEncodeTrait;

    const PROJECT = 'my-awesome-project';
    const TRANSACTION = 'transaction-id';

    private $gapicClient;
    private $transaction;
    private $client;
    private $key;

    public function setUp(): void
    {
        $this->gapicClient = $this->prophesize(GapicDatastoreClient::class);

        $this->client = new DatastoreClient([
            'projectId' => self::PROJECT,
            'datastoreClient' => $this->gapicClient->reveal()
        ]);

        $this->key = new Key('my-awesome-project', [
            [
                'path' => [
                    ['kind' => 'Person', 'name' => 'Bob']
                ]
            ]
        ]);
    }

    public function testClass()
    {
        $this->gapicClient->beginTransaction(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(BeginTransactionResponse::class, [
                'transaction' => base64_encode('foo')
            ]));

        $snippet = $this->snippetFromClass(ReadOnlyTransaction::class);
        $snippet->setLine(2, '');
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke('transaction');
        $this->assertInstanceOf(ReadOnlyTransaction::class, $res->returnVal());
    }

    public function testClassRollback()
    {
        $this->gapicClient->beginTransaction(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(BeginTransactionResponse::class, [
                'transaction' => base64_encode('foo')
            ]));
        $this->gapicClient->lookup(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(LookupResponse::class, []));
        $this->gapicClient->rollback(Argument::any(), Argument::any())
            ->shouldBeCalled();

        $snippet = $this->snippetFromClass(ReadOnlyTransaction::class, 1);

        $transaction = $this->client->readOnlyTransaction();

        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $transaction);

        $snippet->invoke('userData');
    }

    public function testLookup()
    {
        $this->gapicClient->beginTransaction(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(BeginTransactionResponse::class, [
                'transaction' => base64_encode(self::TRANSACTION)
            ]));

        $snippet = $this->snippetFromMethod(ReadOnlyTransaction::class, 'lookup');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->client->readOnlyTransaction());

        $this->gapicClient->lookup(Argument::that(function (LookupRequest $request) {
            $this->assertEquals(self::TRANSACTION, $request->getReadOptions()->getTransaction());
            return true;
        }), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(LookupResponse::class, [
                'found' => [
                    [
                        'entity' => [
                            'key' => [
                                'path' => [
                                    ['kind' => 'Person', 'name' => 'Bob']
                                ]
                            ],
                            'properties' => [
                                'firstName' => [
                                    'stringValue' => 'Bob'
                                ]
                            ]
                        ]
                    ]
                ]
            ]));

        $res = $snippet->invoke();
        $this->assertEquals('Bob', $res->output());
    }

    public function testLookupBatch()
    {
        $this->gapicClient->beginTransaction(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(BeginTransactionResponse::class, [
                'transaction' => base64_encode(self::TRANSACTION)
            ]));

        $snippet = $this->snippetFromMethod(ReadOnlyTransaction::class, 'lookupBatch');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->client->readOnlyTransaction());

        $this->gapicClient->lookup(Argument::that(function (LookupRequest $request) {
            $this->assertEquals(self::TRANSACTION, $request->getReadOptions()->getTransaction());
            return true;
        }), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(LookupResponse::class, [
                'found' => [
                    [
                        'entity' => [
                            'key' => [
                                'path' => [
                                    ['kind' => 'Person', 'name' => 'Bob']
                                ]
                            ],
                            'properties' => [
                                'firstName' => [
                                    'stringValue' => 'Bob'
                                ]
                            ]
                        ]
                    ],
                    [
                        'entity' => [
                            'key' => [
                                'path' => [
                                    ['kind' => 'Person', 'name' => 'John']
                                ]
                            ],
                            'properties' => [
                                'firstName' => [
                                    'stringValue' => 'John'
                                ]
                            ]
                        ]
                    ]
                ]
            ]));

        $res = $snippet->invoke();
        $this->assertEquals("Bob", explode("\n", $res->output())[0]);
        $this->assertEquals("John", explode("\n", $res->output())[1]);
    }

    public function testRunQuery()
    {
        $this->gapicClient->beginTransaction(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(BeginTransactionResponse::class, [
                'transaction' => base64_encode(self::TRANSACTION)
            ]));

        $snippet = $this->snippetFromMethod(ReadOnlyTransaction::class, 'runQuery');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->client->readOnlyTransaction());

        $query = $this->prophesize(QueryInterface::class);
        $query->queryObject()->willReturn([]);
        $query->queryKey()->willReturn('query');
        $query->canPaginate()->willReturn(false);
        $snippet->addLocal('query', $query->reveal());

        $this->gapicClient->runQuery(Argument::that(function (RunQueryRequest $request) {
            $this->assertEquals(self::TRANSACTION, $request->getReadOptions()->getTransaction());
            return true;
        }), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(RunQueryResponse::class, [
                'batch' => [
                    'entityResults' => [
                        [
                            'entity' => [
                                'key' => [
                                    'path' => [
                                        ['kind' => 'Person', 'name' => 'Bob']
                                    ]
                                ],
                                'properties' => [
                                    'firstName' => [
                                        'stringValue' => 'Bob'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]));

        $res = $snippet->invoke('result');
        $this->assertEquals('Bob', $res->output());
    }

    public function testRollback()
    {
        $this->gapicClient->beginTransaction(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(BeginTransactionResponse::class, [
                'transaction' => base64_encode(self::TRANSACTION)
            ]));

        $snippet = $this->snippetFromMethod(ReadOnlyTransaction::class, 'rollback');
        $snippet->addLocal('transaction', $this->client->readOnlyTransaction());

        $this->gapicClient->rollback(Argument::type(RollbackRequest::class), Argument::any())
            ->shouldBeCalled();

        $snippet->invoke();
    }
}
