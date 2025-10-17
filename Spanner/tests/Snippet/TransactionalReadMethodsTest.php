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
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Batch\BatchSnapshot;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Serializer;
use Google\Cloud\Spanner\Session\SessionCache;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\ExecuteSqlRequest;
use Google\Cloud\Spanner\V1\PartialResultSet;
use Google\Cloud\Spanner\V1\ReadRequest;
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
class TransactionalReadMethodsTest extends SnippetTestCase
{
    const DATABASE = 'my-database';
    const INSTANCE = 'my-instance';
    const TRANSACTION = 'my-transaction';
    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';

    use GrpcTestTrait;
    use ProphecyTrait;
    use ResultGeneratorTrait;

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
        $this->session = $this->prophesize(SessionCache::class);
        $this->session->name()->willReturn(self::SESSION);
        $this->spannerClient = $this->prophesize(SpannerClient::class);
        $this->operation = new Operation(
            $this->spannerClient->reveal(),
            $this->serializer
        );
        $this->databaseAdminClient = $this->prophesize(DatabaseAdminClient::class);
    }

    public function clientAndSnippet()
    {
        return [
            ['database', Database::class],
            ['transaction', Transaction::class],
            ['transaction', Snapshot::class],
            ['transaction', BatchSnapshot::class],
        ];
    }

    /**
     * @dataProvider clientAndSnippet
     */
    public function testExecute($localName, $clientClass)
    {
        $this->checkAndSkipGrpcTests();

        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream([
                [
                    'name' => 'loginCount',
                    'type' => Database::TYPE_INT64,
                    'value' => 0
                ]
            ]));

        $client = $this->createClientForClass($clientClass);

        $snippet = $this->snippetFromMethod($clientClass, 'execute');
        $snippet->addLocal($localName, $client);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
    }

    /**
     * @dataProvider clientAndSnippet
     */
    public function testExecuteWithParameterType($localName, $clientClass)
    {
        $this->checkAndSkipGrpcTests();

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertTrue(isset($message['params']));
                $this->assertTrue(isset($message['paramTypes']));
                $this->assertEquals(
                    $message['paramTypes']['timestamp']['code'],
                    Database::TYPE_TIMESTAMP
                );
                return true;
            }),
            Argument::type('array')
        )->willReturn(
            $this->resultGeneratorStream([
                [
                    'name' => 'timestamp',
                    'type' => Database::TYPE_TIMESTAMP,
                    'value' => null,
                ],
            ])
        );

        $client = $this->createClientForClass($clientClass);
        $snippet = $this->snippetFromMethod($clientClass, 'execute', 1);
        $snippet->addLocal($localName, $client);

        $res = $snippet->invoke('timestamp');
        $this->assertEquals('', $res->returnVal());
    }

    /**
     * @dataProvider clientAndSnippet
     */
    public function testExecuteWithEmptyArray($localName, $clientClass)
    {
        $this->checkAndSkipGrpcTests();

        $snippet = $this->snippetFromMethod($clientClass, 'execute', 2);
        $client = $this->createClientForClass($clientClass);

        $partialResultSet = $this->serializer->decodeMessage(
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
                'values' => [
                    ['listValue' => []]
                ]
            ]
        );

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($args) {
                $message = $this->serializer->encodeMessage($args);
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
            ->willReturn($this->resultGeneratorStream([$partialResultSet]));

        $snippet->addLocal($localName, $client);

        $res = $snippet->invoke('emptyArray');
        $this->assertEmpty($res->returnVal());
    }

    /**
     * @dataProvider clientAndSnippet
     */
    public function testExecuteStruct($localName, $clientClass)
    {
        $this->checkAndSkipGrpcTests();

        $snippet = $this->snippetFromMethod($clientClass, 'execute', 3);
        $client = $this->createClientForClass($clientClass);

        $rows = [
            [
                'name' => 'firstName',
                'type' => Database::TYPE_STRING,
                'value' => 'John'
            ], [
                'name' => 'lastName',
                'type' => Database::TYPE_STRING,
                'value' => 'Testuser',
            ]
        ];

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($args) use ($rows) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['sql'], 'SELECT @userStruct.firstName, @userStruct.lastName');
                $this->assertEquals(
                    $message['params']['userStruct'],
                    array_map(fn ($row) => $row['value'], $rows)
                );
                $this->assertEquals(
                    $message['paramTypes']['userStruct']['structType']['fields'][0]['name'],
                    $rows[0]['name']
                );
                $this->assertEquals(
                    $message['paramTypes']['userStruct']['structType']['fields'][1]['name'],
                    $rows[1]['name']
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->wilLReturn($this->resultGeneratorStream($rows));

        $snippet->addLocal($localName, $client);

        $res = $snippet->invoke('fullName');
        $this->assertEquals('John Testuser', $res->returnVal());
    }

    /**
     * @dataProvider clientAndSnippet
     */
    public function testExecuteStructDuplicateAndUnnamedFields($localName, $clientClass)
    {
        $this->checkAndSkipGrpcTests();

        $snippet = $this->snippetFromMethod($clientClass, 'execute', 4);
        $client = $this->createClientForClass($clientClass);

        $rows = [
            [
                'name' => 'foo',
                'type' => Database::TYPE_STRING,
                'value' => 'bar'
            ], [
                'name' => 'foo',
                'type' => Database::TYPE_INT64,
                'value' => 2
            ], [
                'name' => '',
                'type' => Database::TYPE_STRING,
                'value' => 'this field is unnamed'
            ]
        ];

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($args) use ($rows) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['sql'],
                    'SELECT * FROM UNNEST(ARRAY(SELECT @structParam))'
                );
                $this->assertEquals(
                    $message['params']['structParam'],
                    array_map(fn ($v) => $v['value'], $rows)
                );
                $this->assertEquals(
                    $message['paramTypes']['structParam']['structType']['fields'][0]['name'],
                    $rows[0]['name']
                );
                return true;
            }),
            Argument::type('array')
        )->willReturn($this->resultGeneratorStream($rows));

        $snippet->addLocal($localName, $client);

        $res = explode(PHP_EOL, $snippet->invoke()->output());
        $this->assertEquals('foo: bar', $res[0]);
        $this->assertEquals('foo: 2', $res[1]);
        $this->assertEquals('2: this field is unnamed', $res[2]);
    }

    /**
     * @dataProvider clientAndSnippet
     */
    public function testRead($localName, $clientClass)
    {
        $this->checkAndSkipGrpcTests();

        $snippet = $this->snippetFromMethod($clientClass, 'read');
        $client = $this->createClientForClass($clientClass);

        $this->spannerClient->streamingRead(
            Argument::type(ReadRequest::class),
            Argument::type('array')
        )->willReturn($this->resultGeneratorStream([
            [
                'name' => 'loginCount',
                'type' => Database::TYPE_INT64,
                'value' => 0,
            ]
        ]));

        $snippet->addLocal($localName, $client);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
    }

    private function setupDatabase()
    {
        $instance = $this->prophesize(Instance::class);
        $instance->name()->willReturn(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE));
        $instance->directedReadOptions()->willReturn([]);

        $session = $this->prophesize(SessionCache::class);
        $session->name()->willReturn(self::SESSION);

        return new Database(
            $this->spannerClient->reveal(),
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            $instance->reveal(),
            self::PROJECT,
            self::DATABASE,
            $session->reveal(),
        );
    }

    private function setupTransaction()
    {
        return new Transaction(
            $this->operation,
            $this->session->reveal(),
            self::TRANSACTION
        );
    }

    private function setupSnapshot()
    {
        return new Snapshot(
            $this->operation,
            $this->session->reveal(),
            [
                'id' => self::TRANSACTION,
                'readTimestamp' => new Timestamp(new \DateTime())
            ]
        );
    }

    private function setupBatch()
    {
        return new BatchSnapshot(
            new Operation($this->spannerClient->reveal(), $this->serializer),
            $this->session->reveal(),
            [
                'id' => self::TRANSACTION,
                'readTimestamp' => new Timestamp(\DateTime::createFromFormat('U', (string) time()))
            ]
        );
    }

    private function createClientForClass(string $clientClass)
    {
        return match ($clientClass) {
            Database::class => $this->setupDatabase(),
            Transaction::class => $this->setupTransaction(),
            Snapshot::class => $this->setupSnapshot(),
            BatchSnapshot::class => $this->setupBatch(),
        };
    }
}
