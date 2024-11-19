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

use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Batch\BatchSnapshot;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\Serializer;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\ExecuteSqlRequest;
use Google\Cloud\Spanner\V1\ReadRequest;
use Google\Cloud\Spanner\V1\PartialResultSet;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * Much of the execute and read tests are duplicated, and often fall out of sync
 * with each other. By grouping those tests together using providers, this test
 * case aims to highlight cases where tests are not synced and make it easier to
 * solve those mistakes.
 *
 * @group spanner
 * @group spanner-transactionalread
 */
class TransactionalReadTraitTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;
    use ResultGeneratorTrait;

    const PROJECT = 'my-awesome-project';
    const DATABASE = 'my-database';
    const INSTANCE = 'my-instance';
    const TRANSACTION = 'my-transaction';
    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';

    private $spannerClient;
    private $databaseAdminClient;
    private $serializer;
    private $session;
    private $operation;

    private $database;
    private $transaction;
    private $snapshot;

    public function setUp(): void
    {
        parent::setUpBeforeClass();

        $this->serializer = new Serializer();
        $this->session = $this->prophesize(Session::class);
        $this->session->info()
            ->willReturn([
                'databaseName' => 'database'
            ]);
        $this->session->name()
            ->willReturn('sessionName');
        $this->session->setExpiration()
            ->willReturn();
        $this->operation = $this->prophesize(Operation::class);
        $this->spannerClient = $this->prophesize(SpannerClient::class);
        $this->databaseAdminClient = $this->prophesize(DatabaseAdminClient::class);
    }

    /**
     * @dataProvider clientAndSnippetExecute
     */
    public function testExecute($localName, $class)
    {
        $this->checkAndSkipGrpcTests();

        $snippet = $this->snippetFromMethod($class, 'execute');
        $client = $this->createClientForClass($class);

        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream([$this->serializer->decodeMessage(
                new PartialResultSet(),
                [
                    'metadata' => [
                        'rowType' => [
                            'fields' => [
                                [
                                    'name' => 'loginCount',
                                    'type' => ['code' => Database::TYPE_INT64]
                                ]
                            ]
                        ]
                    ],
                    'values' => [
                        ['numberValue' => 0]
                    ]
                ]
            )]));

        $snippet->addLocal($localName, $client);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
    }

    public function clientAndSnippetExecute()
    {
        return [
            ['database', Database::class],
            ['transaction', Transaction::class],
            ['transaction', Snapshot::class],
            ['transaction', BatchSnapshot::class],
        ];
    }

    /**
     * @dataProvider clientAndSnippetExecuteParameterType
     */
    public function testExecuteWithParameterType($localName, $class)
    {
        $this->checkAndSkipGrpcTests();

        $snippet = $this->snippetFromMethod($class, 'execute', 1);
        $client = $this->createClientForClass($class);

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertTrue(isset($message['params']));
                $this->assertTrue(isset($message['paramTypes']));
                $this->assertEquals(
                    $message['paramTypes']['timestamp']['code'],
                    Database::TYPE_TIMESTAMP
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream([$this->serializer->decodeMessage(
                new PartialResultSet(),
                [
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
                    'values' => [
                        ['nullValue' => 0]
                    ]
                ]
            )]));

        $snippet->addLocal($localName, $client);

        $res = $snippet->invoke('timestamp');
        $this->assertNull($res->returnVal());
    }

    public function clientAndSnippetExecuteParameterType()
    {
        return [
            ['database', Database::class],
            ['transaction', Transaction::class],
            ['transaction', Snapshot::class],
            ['transaction', BatchSnapshot::class],
        ];
    }

    /**
     * @dataProvider clientAndSnippetExecuteEmptyArray
     */
    public function testExecuteWithEmptyArray($localName, $class)
    {
        $this->checkAndSkipGrpcTests();

        $snippet = $this->snippetFromMethod($class, 'execute', 2);
        $client = $this->createClientForClass($class);

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertTrue(isset($message['params']));
                $this->assertTrue(isset($message['paramTypes']));
                $this->assertEquals(
                    $message['paramTypes']['emptyArrayOfIntegers']['code'],
                    Database::TYPE_ARRAY
                );
                $this->assertEquals(
                    $message['paramTypes']['emptyArrayOfIntegers']['arrayElementType']['code'],
                    Database::TYPE_INT64
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream([$this->serializer->decodeMessage(
                new PartialResultSet(),
                [
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
                ]
            )]));

        $snippet->addLocal($localName, $client);

        $res = $snippet->invoke('emptyArray');
        $this->assertEmpty($res->returnVal());
    }

    public function clientAndSnippetExecuteEmptyArray()
    {
        return [
            ['database', Database::class],
            ['transaction', Transaction::class],
            ['transaction', Snapshot::class],
            ['transaction', BatchSnapshot::class],
        ];
    }

    /**
     * @dataProvider clientAndSnippetExecuteStruct
     */
    public function testExecuteStruct($localName, $class)
    {
        $this->checkAndSkipGrpcTests();

        $snippet = $this->snippetFromMethod($class, 'execute', 3);
        $client = $this->createClientForClass($class);

        $fields = [
            [
                'name' => 'firstName',
                'type' => [
                    'code' => Database::TYPE_STRING,
                    'typeAnnotation' => 0,
                    'protoTypeFqn' => ''
                ]
            ], [
                'name' => 'lastName',
                'type' => [
                    'code' => Database::TYPE_STRING,
                    'typeAnnotation' => 0,
                    'protoTypeFqn' => ''
                ]
            ]
        ];

        $values = [
            'John',
            'Testuser'
        ];

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) use ($values, $fields) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($message['sql'], 'SELECT @userStruct.firstName, @userStruct.lastName');
                $this->assertEquals(
                    $message['params'],
                    ['userStruct' => $values]
                );
                $this->assertEquals(
                    $message['paramTypes']['userStruct']['structType']['fields'],
                    $fields
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream([$this->serializer->decodeMessage(
                new PartialResultSet(),
                [
                    'metadata' => [
                        'rowType' => [
                            'fields' => $fields
                        ]
                    ],
                    'values' => [
                        ['stringValue' => 'John'],
                        ['stringValue' => 'Testuser'],
                    ]
                ]
            )]));

        $snippet->addLocal($localName, $client);

        $res = $snippet->invoke('fullName');
        $this->assertEquals('John Testuser', $res->returnVal());
    }

    public function clientAndSnippetExecuteStruct()
    {
        return [
            ['database', Database::class],
            ['transaction', Transaction::class],
            ['transaction', Snapshot::class],
            ['transaction', BatchSnapshot::class],
        ];
    }

    /**
     * @dataProvider clientAndSnippetExecuteDuplicateAndUnnamedFields
     */
    public function testExecuteStructDuplicateAndUnnamedFields($localName, $class)
    {
        $this->checkAndSkipGrpcTests();

        $snippet = $this->snippetFromMethod($class, 'execute', 4);
        $client = $this->createClientForClass($class);

        $fields = [
            [
                'name' => 'foo',
                'type' => [
                    'code' => Database::TYPE_STRING,
                    'typeAnnotation' => 0,
                    'protoTypeFqn' => ''
                ]
            ], [
                'name' => 'foo',
                'type' => [
                    'code' => Database::TYPE_INT64,
                    'typeAnnotation' => 0,
                    'protoTypeFqn' => ''
                ]
            ], [
                'name' => '',
                'type' => [
                    'code' => Database::TYPE_STRING,
                    'typeAnnotation' => 0,
                    'protoTypeFqn' => ''
                ]
            ]
        ];

        $values = [
            'bar',
            2,
            'this field is unnamed'
        ];

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) use ($values, $fields) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['sql'],
                    'SELECT * FROM UNNEST(ARRAY(SELECT @structParam))'
                );
                $this->assertEquals($message['params'], ['structParam' => $values]);
                $this->assertEquals(
                    $message['paramTypes'],
                    [
                        'structParam' => [
                            'code' => Database::TYPE_STRUCT,
                            'structType' => [
                                'fields' => $fields
                            ],
                            'typeAnnotation' => 0,
                            'protoTypeFqn' => '',
                        ]
                    ]
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream([$this->serializer->decodeMessage(
                new PartialResultSet(),
                [
                    'metadata' => [
                        'rowType' => [
                            'fields' => $fields
                        ]
                    ],
                    'values' => [
                        ['stringValue' => 'bar'],
                        ['numberValue' => 2],
                        ['stringValue' => 'this field is unnamed']
                    ]
                ]
            )]));

        $snippet->addLocal($localName, $client);

        $res = explode(PHP_EOL, $snippet->invoke()->output());
        $this->assertEquals('foo: bar', $res[0]);
        $this->assertEquals('foo: 2', $res[1]);
        $this->assertEquals('2: this field is unnamed', $res[2]);
    }

    public function clientAndSnippetExecuteDuplicateAndUnnamedFields()
    {
        return [
            ['database', Database::class],
            ['transaction', Transaction::class],
            ['transaction', Snapshot::class],
            ['transaction', BatchSnapshot::class],
        ];
    }

    /**
     * @dataProvider clientAndSnippetRead
     */
    public function testRead($localName, $class)
    {
        $this->checkAndSkipGrpcTests();

        $snippet = $this->snippetFromMethod($class, 'read');
        $client = $this->createClientForClass($class);

        $this->spannerClient->streamingRead(
            Argument::type(ReadRequest::class),
            Argument::type('array')
        )
            ->willReturn($this->resultGeneratorStream([$this->serializer->decodeMessage(
                new PartialResultSet(),
                [
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
                    'values' => [
                        ['numberValue' => 0]
                    ]
                ]
            )]));

        $snippet->addLocal($localName, $client);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
    }

    public function clientAndSnippetRead()
    {
        return [
            ['database', Database::class],
            ['transaction', Transaction::class],
            ['transaction', Snapshot::class],
            ['transaction', BatchSnapshot::class],
        ];
    }

    private function createDatabase()
    {
        $instance = $this->prophesize(Instance::class);
        $instance->name()->willReturn(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE));
        $instance->directedReadOptions()->willReturn([]);

        $sessionPool = $this->prophesize(SessionPoolInterface::class);
        $sessionPool->acquire(Argument::any())
            ->willReturn($this->session->reveal());
        $sessionPool->setDatabase(Argument::any())
            ->willReturn(null);

        return new Database(
            $this->spannerClient->reveal(),
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            $instance->reveal(),
            self::PROJECT,
            self::DATABASE,
            $sessionPool->reveal()
        );
    }

    private function createTransaction()
    {
        $operation = new Operation(
            $this->spannerClient->reveal(),
            $this->serializer,
            true
        );

        return new Transaction(
            $operation,
            $this->session->reveal(),
            self::TRANSACTION
        );
    }

    private function createSnapshot()
    {
        $operation = new Operation(
            $this->spannerClient->reveal(),
            $this->serializer,
            true
        );

        return new Snapshot(
            $operation,
            $this->session->reveal(),
            [
                'id' => self::TRANSACTION,
                'readTimestamp' => new Timestamp(new \DateTime())
            ]
        );
    }

    private function createBatchSnapshot()
    {
        $sessData = SpannerClient::parseName(self::SESSION, 'session');
        $this->session->name()->willReturn(self::SESSION);
        $this->session->info()->willReturn($sessData + [
            'name' => self::SESSION,
            'databaseName' => SpannerClient::databaseName(
                self::PROJECT,
                self::INSTANCE,
                self::DATABASE
            )
        ]);

        return new BatchSnapshot(
            new Operation($this->spannerClient->reveal(), $this->serializer, false),
            $this->session->reveal(),
            [
                'id' => self::TRANSACTION,
                'readTimestamp' => new Timestamp(\DateTime::createFromFormat('U', (string) time()))
            ]
        );
    }

    private function createClientForClass($class)
    {
        return match($class) {
            Database::class => $this->createDatabase(),
            Transaction::class => $this->createTransaction(),
            Snapshot::class => $this->createSnapshot(),
            BatchSnapshot::class => $this->createBatchSnapshot(),
        };
    }
}
