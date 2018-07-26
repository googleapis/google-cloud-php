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

namespace Google\Cloud\Spanner\Tests\Snippet;

use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\SpannerOperationRefreshTrait;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Batch\BatchSnapshot;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\Gapic\SpannerGapicClient;
use Prophecy\Argument;

/**
 * Much of the execute and read tests are duplicated, and often fall out of sync
 * with each other. By grouping those tests together using providers, this test
 * case aims to highlight cases where tests are not synced and make it easier to
 * solve those mistakes.
 *
 * @group spanner
 * @group spanner-transactionalread
 */
class TransactionalReadMethodsTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use SpannerOperationRefreshTrait;

    const PROJECT = 'my-awesome-project';
    const DATABASE = 'my-database';
    const INSTANCE = 'my-instance';
    const TRANSACTION = 'my-transaction';
    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';

    private $connection;
    private $session;
    private $operation;

    private $database;
    private $transaction;
    private $snapshot;

    public function setUp()
    {
        parent::setUpBeforeClass();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->session = $this->prophesize(Session::class);
        $this->operation = $this->prophesize(Operation::class);
    }

    public function clientAndSnippetExecute()
    {
        return [
            ['database', $this->setupDatabase(), $this->snippetFromMethod(Database::class, 'execute')],
            ['transaction', $this->setupTransaction(), $this->snippetFromMethod(Transaction::class, 'execute')],
            ['transaction', $this->setupSnapshot(), $this->snippetFromMethod(Snapshot::class, 'execute')],
            ['transaction', $this->setupBatch(), $this->snippetFromMethod(BatchSnapshot::class, 'execute')],
        ];
    }

    /**
     * @dataProvider clientAndSnippetExecute
     */
    public function testExecute($localName, $client, $snippet)
    {
        $this->checkAndSkipGrpcTests();

        $this->connection->executeStreamingSql(Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator([
                'metadata' => [
                    'rowType' => [
                        'fields' => [
                            [
                                'name' => 'loginCount',
                                'type' => [
                                    'code' => Database::TYPE_INT64
                                ]
                            ]
                        ]
                    ]
                ],
                'values' => [0]
            ]));

        $this->refreshOperation($client, $this->connection->reveal());

        $snippet->addLocal($localName, $client);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
    }

    public function clientAndSnippetExecuteParameterType()
    {
        return [
            ['database', $this->setupDatabase(), $this->snippetFromMethod(Database::class, 'execute', 1)],
            ['transaction', $this->setupTransaction(), $this->snippetFromMethod(Transaction::class, 'execute', 1)],
            ['transaction', $this->setupSnapshot(), $this->snippetFromMethod(Snapshot::class, 'execute', 1)],
            ['transaction', $this->setupBatch(), $this->snippetFromMethod(BatchSnapshot::class, 'execute', 1)],
        ];
    }

    /**
     * @dataProvider clientAndSnippetExecuteParameterType
     */
    public function testExecuteWithParameterType($localName, $client, $snippet)
    {
        $this->checkAndSkipGrpcTests();

        $this->connection->executeStreamingSql(Argument::that(function ($arg) {
            if (!isset($arg['params'])) {
                return false;
            }

            if (!isset($arg['paramTypes'])) {
                return false;
            }

            if ($arg['paramTypes']['timestamp']['code'] !== Database::TYPE_TIMESTAMP) {
                return false;
            }

            return true;
        }))->shouldBeCalled()->willReturn($this->resultGenerator([
            'metadata' => [
                'rowType' => [
                    'fields' => [
                        [
                            'name' => 'timestamp',
                            'type' => [
                                'code' => Database::TYPE_TIMESTAMP
                            ]
                        ]
                    ]
                ]
            ],
            'values' => [null]
        ]));

        $this->refreshOperation($client, $this->connection->reveal());

        $snippet->addLocal($localName, $client);

        $res = $snippet->invoke('timestamp');
        $this->assertNull($res->returnVal());
    }

    public function clientAndSnippetExecuteEmptyArray()
    {
        return [
            ['database', $this->setupDatabase(), $this->snippetFromMethod(Database::class, 'execute', 2)],
            ['transaction', $this->setupTransaction(), $this->snippetFromMethod(Transaction::class, 'execute', 2)],
            ['transaction', $this->setupSnapshot(), $this->snippetFromMethod(Snapshot::class, 'execute', 2)],
            ['transaction', $this->setupBatch(), $this->snippetFromMethod(BatchSnapshot::class, 'execute', 2)],
        ];
    }

    /**
     * @dataProvider clientAndSnippetExecuteEmptyArray
     */
    public function testExecuteWithEmptyArray($localName, $client, $snippet)
    {
        $this->checkAndSkipGrpcTests();

        $this->connection->executeStreamingSql(Argument::that(function ($arg) {
            if (!isset($arg['params'])) {
                return false;
            }

            if (!isset($arg['paramTypes'])) {
                return false;
            }

            if ($arg['paramTypes']['emptyArrayOfIntegers']['code'] !== Database::TYPE_ARRAY) {
                return false;
            }

            if ($arg['paramTypes']['emptyArrayOfIntegers']['arrayElementType']['code'] !== Database::TYPE_INT64) {
                return false;
            }

            return true;
        }))->shouldBeCalled()->willReturn($this->resultGenerator([
            'metadata' => [
                'rowType' => [
                    'fields' => [
                        [
                            'name' => 'numbers',
                            'type' => [
                                'code' => Database::TYPE_ARRAY,
                                'arrayElementType' => [
                                    'code' => Database::TYPE_INT64
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'values' => [[]]
        ]));

        $this->refreshOperation($client, $this->connection->reveal());

        $snippet->addLocal($localName, $client);

        $res = $snippet->invoke('emptyArray');
        $this->assertEmpty($res->returnVal());
    }

    public function clientAndSnippetExecuteStruct()
    {
        return [
            ['database', $this->setupDatabase(), $this->snippetFromMethod(Database::class, 'execute', 3)],
            ['transaction', $this->setupTransaction(), $this->snippetFromMethod(Transaction::class, 'execute', 3)],
            ['transaction', $this->setupSnapshot(), $this->snippetFromMethod(Snapshot::class, 'execute', 3)],
            ['transaction', $this->setupBatch(), $this->snippetFromMethod(BatchSnapshot::class, 'execute', 3)],
        ];
    }

    /**
     * @dataProvider clientAndSnippetExecuteStruct
     */
    public function testExecuteStruct($localName, $client, $snippet)
    {
        $this->checkAndSkipGrpcTests();

        $fields = [
            [
                'name' => 'firstName',
                'type' => [
                    'code' => Database::TYPE_STRING
                ]
            ], [
                'name' => 'lastName',
                'type' => [
                    'code' => Database::TYPE_STRING
                ]
            ]
        ];

        $values = [
            'John',
            'Testuser'
        ];

        $this->connection->executeStreamingSql(Argument::allOf(
            Argument::withEntry('sql', 'SELECT @userStruct.firstName, @userStruct.lastName'),
            Argument::withEntry('params', [
                'userStruct' => $values
            ]),
            Argument::withEntry('paramTypes', [
                'userStruct' => [
                    'code' => Database::TYPE_STRUCT,
                    'structType' => [
                        'fields' => $fields
                    ]
                ]
            ])
        ))->shouldBeCalled()->willReturn($this->resultGenerator([
            'metadata' => [
                'rowType' => [
                    'fields' => $fields
                ]
            ],
            'values' => $values
        ]));

        $this->refreshOperation($client, $this->connection->reveal());

        $snippet->addLocal($localName, $client);

        $res = $snippet->invoke('fullName');
        $this->assertEquals('John Testuser', $res->returnVal());
    }

    public function clientAndSnippetExecuteDuplicateAndUnnamedFields()
    {
        return [
            ['database', $this->setupDatabase(), $this->snippetFromMethod(Database::class, 'execute', 4)],
            ['transaction', $this->setupTransaction(), $this->snippetFromMethod(Transaction::class, 'execute', 4)],
            ['transaction', $this->setupSnapshot(), $this->snippetFromMethod(Snapshot::class, 'execute', 4)],
            ['transaction', $this->setupBatch(), $this->snippetFromMethod(BatchSnapshot::class, 'execute', 4)],
        ];
    }

    /**
     * @dataProvider clientAndSnippetExecuteDuplicateAndUnnamedFields
     */
    public function testExecuteStructDuplicateAndUnnamedFields($localName, $client, $snippet)
    {
        $this->checkAndSkipGrpcTests();

        $fields = [
            [
                'name' => 'foo',
                'type' => [
                    'code' => Database::TYPE_STRING
                ]
            ], [
                'name' => 'foo',
                'type' => [
                    'code' => Database::TYPE_INT64
                ]
            ], [
                'type' => [
                    'code' => Database::TYPE_STRING
                ]
            ]
        ];

        $values = [
            'bar',
            2,
            'this field is unnamed'
        ];

        $this->connection->executeStreamingSql(Argument::allOf(
            Argument::withEntry('sql', 'SELECT * FROM UNNEST(ARRAY(SELECT @structParam))'),
            Argument::withEntry('params', [
                'structParam' => $values
            ]),
            Argument::withEntry('paramTypes', [
                'structParam' => [
                    'code' => Database::TYPE_STRUCT,
                    'structType' => [
                        'fields' => $fields
                    ]
                ]
            ])
        ))->shouldBeCalled()->willReturn($this->resultGenerator([
            'metadata' => [
                'rowType' => [
                    'fields' => $fields
                ]
            ],
            'values' => $values
        ]));

        $this->refreshOperation($client, $this->connection->reveal());

        $snippet->addLocal($localName, $client);

        $res = explode(PHP_EOL, $snippet->invoke()->output());
        $this->assertEquals('foo: bar', $res[0]);
        $this->assertEquals('foo: 2', $res[1]);
        $this->assertEquals('2: this field is unnamed', $res[2]);
    }

    public function clientAndSnippetRead()
    {
        return [
            ['database', $this->setupDatabase(), $this->snippetFromMethod(Database::class, 'read')],
            ['transaction', $this->setupTransaction(), $this->snippetFromMethod(Transaction::class, 'read')],
            ['transaction', $this->setupSnapshot(), $this->snippetFromMethod(Snapshot::class, 'read')],
            ['transaction', $this->setupBatch(), $this->snippetFromMethod(BatchSnapshot::class, 'read')],
        ];
    }

    /**
     * @dataProvider clientAndSnippetRead
     */
    public function testRead($localName, $client, $snippet)
    {
        $this->checkAndSkipGrpcTests();

        $this->connection->streamingRead(Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator([
                'metadata' => [
                    'rowType' => [
                        'fields' => [
                            [
                                'name' => 'loginCount',
                                'type' => [
                                    'code' => Database::TYPE_INT64
                                ]
                            ]
                        ]
                    ]
                ],
                'rows' => [0]
            ]));

        $this->refreshOperation($client, $this->connection->reveal());

        $snippet->addLocal($localName, $client);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
    }

    private function setupDatabase()
    {
        $this->setUp();

        $instance = $this->prophesize(Instance::class);
        $instance->name()->willReturn(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE));

        $sessionPool = $this->prophesize(SessionPoolInterface::class);
        $sessionPool->acquire(Argument::any())
            ->willReturn($this->session->reveal());
        $sessionPool->setDatabase(Argument::any())
            ->willReturn(null);

        return \Google\Cloud\Core\Testing\TestHelpers::stub(Database::class, [
            $this->connection->reveal(),
            $instance->reveal(),
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT,
            self::DATABASE,
            $sessionPool->reveal()
        ], ['operation']);
    }

    private function setupTransaction()
    {
        $this->setUp();

        return \Google\Cloud\Core\Testing\TestHelpers::stub(Transaction::class, [
            $this->operation->reveal(),
            $this->session->reveal(),
            self::TRANSACTION
        ], ['operation']);
    }

    private function setupSnapshot()
    {
        $this->setUp();

        return \Google\Cloud\Core\Testing\TestHelpers::stub(Snapshot::class, [
            $this->operation->reveal(),
            $this->session->reveal(),
            [
                'id' => self::TRANSACTION,
                'readTimestamp' => new Timestamp(new \DateTime)
            ]
        ], ['operation']);
    }

    private function setupBatch()
    {
        $sessData = SpannerGapicClient::parseName(self::SESSION, 'session');
        $this->session->name()->willReturn(self::SESSION);
        $this->session->info()->willReturn($sessData + [
            'name' => self::SESSION
        ]);

        return \Google\Cloud\Core\Testing\TestHelpers::stub(BatchSnapshot::class, [
            new Operation($this->connection->reveal(), false),
            $this->session->reveal(),
            [
                'id' => self::TRANSACTION,
                'readTimestamp' => new Timestamp(\DateTime::createFromFormat('U', (string) time()))
            ]
        ], ['operation', 'session']);
    }

    private function resultGenerator(array $data)
    {
        yield $data;
    }
}
