<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Tests\Unit\Firestore;

use Prophecy\Argument;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\WriteBatch;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Firestore\V1beta1\DocumentTransform_FieldTransform_ServerValue;

/**
 * @group firestore
 * @group firestore-writebatch
 */
class WriteBatchTest extends \PHPUnit_Framework_TestCase
{
    const PROJECT = 'example_project';
    const DATABASE = '(default)';
    const DOCUMENT = 'projects/example_project/databases/(default)/documents/a/b';
    const TRANSACTION = 'foobar';

    private $connection;
    private $batch;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->batch = \Google\Cloud\Dev\stub(WriteBatch::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE)
        ], ['connection', 'transaction']);
    }

    public function testCreate()
    {
        $this->batch->create(self::DOCUMENT, [
            'hello' => 'world'
        ]);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'updateMask' => ['hello'],
                    'currentDocument' => ['exists' => false],
                    'update' => [
                        'name' => self::DOCUMENT,
                        'fields' => ['hello' => ['stringValue' => 'world']]
                    ]
                ]
            ]
        ]);
    }

    public function testUpdate()
    {
        $this->batch->update(self::DOCUMENT, [
            'hello' => 'world'
        ]);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'updateMask' => ['hello'],
                    'currentDocument' => ['exists' => true],
                    'update' => [
                        'name' => self::DOCUMENT,
                        'fields' => ['hello' => ['stringValue' => 'world']]
                    ]
                ]
            ]
        ]);
    }

    public function testUpdateFieldPaths()
    {
        $this->batch->update(self::DOCUMENT, [
            'hello.world' => 'world'
        ]);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'updateMask' => ['hello.world'],
                    'currentDocument' => ['exists' => true],
                    'update' => [
                        'name' => self::DOCUMENT,
                        'fields' => [
                            'hello' => [
                                'mapValue' => [
                                    'fields' => [
                                        'world' => [
                                            'stringValue' => 'world'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testUpdateSentinels()
    {
        $this->batch->update(self::DOCUMENT, [
            'foo' => 'bar',
            'hello' => FirestoreClient::DELETE_FIELD,
            'world' => FirestoreClient::SERVER_TIMESTAMP
        ]);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'updateMask' => ['foo', 'hello'],
                    'currentDocument' => ['exists' => true],
                    'update' => [
                        'name' => self::DOCUMENT,
                        'fields' => [
                            'foo' => ['stringValue' => 'bar']
                        ]
                    ]
                ], [
                    'transform' => [
                        'document' => self::DOCUMENT,
                        'fieldTransforms' => [
                            [
                                'fieldPath' => 'world',
                                'setToServerValue' => DocumentTransform_FieldTransform_ServerValue::REQUEST_TIME
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testUpdatePreviousTransform()
    {
        $this->batch->update(self::DOCUMENT, [
            'world' => FirestoreClient::SERVER_TIMESTAMP
        ]);

        $this->batch->update(self::DOCUMENT, [
            'hello' => FirestoreClient::DELETE_FIELD,
        ]);
    }

    public function testSet()
    {
        $this->batch->set(self::DOCUMENT, [
            'hello' => 'world'
        ]);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'update' => [
                        'name' => self::DOCUMENT,
                        'fields' => ['hello' => ['stringValue' => 'world']]
                    ]
                ]
            ]
        ]);
    }

    public function testSetMerge()
    {
        $this->batch->set(self::DOCUMENT, [
            'hello' => 'world'
        ], ['merge' => true]);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'updateMask' => ['hello'],
                    'update' => [
                        'name' => self::DOCUMENT,
                        'fields' => ['hello' => ['stringValue' => 'world']]
                    ]
                ]
            ]
        ]);
    }

    public function testSetSentinels()
    {
        $this->batch->set(self::DOCUMENT, [
            'hello' => FirestoreClient::DELETE_FIELD,
            'world' => FirestoreClient::SERVER_TIMESTAMP
        ]);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'transform' => [
                        'document' => self::DOCUMENT,
                        'fieldTransforms' => [
                            [
                                'fieldPath' => 'world',
                                'setToServerValue' => DocumentTransform_FieldTransform_ServerValue::REQUEST_TIME
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testSetPreviousTransform()
    {
        $this->batch->set(self::DOCUMENT, [
            'world' => FirestoreClient::SERVER_TIMESTAMP
        ]);

        $this->batch->set(self::DOCUMENT, [
            'hello' => FirestoreClient::DELETE_FIELD,
        ]);
    }

    public function testDelete()
    {
        $this->batch->delete(self::DOCUMENT);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'delete' => self::DOCUMENT
                ]
            ]
        ]);
    }

    public function testVerify()
    {
        $this->batch->verify(self::DOCUMENT, [
            'precondition' => [
                'exists' => true
            ]
        ]);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'verify' => self::DOCUMENT,
                    'currentDocument' => [
                        'exists' => true
                    ]
                ]
            ]
        ]);
    }

    public function testVerifyUpdateTime()
    {
        $now = time();
        $ts = new Timestamp(\DateTimeImmutable::createFromFormat('U', $now), 10);
        $this->batch->verify(self::DOCUMENT, [
            'precondition' => [
                'updateTime' => $ts
            ]
        ]);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'verify' => self::DOCUMENT,
                    'currentDocument' => [
                        'updateTime' => [
                            'seconds' => $now,
                            'nanos' => 10
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testVerifyUpdateTimeInvalidArgument()
    {
        $this->batch->verify(self::DOCUMENT, [
            'precondition' => [
                'updateTime' => 'hello'
            ]
        ]);

        $this->commitAndAssert([]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testVerifyInvalidPrecondition()
    {
        $this->batch->verify(self::DOCUMENT, [
            'precondition' => [
                'foo' => 'bar'
            ]
        ]);

        $this->commitAndAssert([]);
    }

    public function testCommitResponse()
    {
        $now = time();
        $nanos = 10;

        $timestamp = [
            'seconds' => $now,
            'nanos' => $nanos
        ];

        $tsObj = new Timestamp(\DateTimeImmutable::createFromFormat('U', $now), $nanos);

        $this->connection->commit(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'commitTime' => $timestamp,
                'writeResults' => [
                    [
                        'updateTime' => $timestamp
                    ]
                ]
            ]);

        $this->batch->___setProperty('connection', $this->connection->reveal());

        $res = $this->batch->commit();

        $this->assertEquals($tsObj, $res['commitTime']);
        $this->assertEquals($tsObj, $res['writeResults'][0]['updateTime']);
    }

    public function testCommitWithTransaction()
    {
        $this->connection->commit(Argument::withEntry('transaction', self::TRANSACTION))
            ->shouldBeCalled();

        $this->batch->___setProperty('connection', $this->connection->reveal());
        $this->batch->___setProperty('transaction', self::TRANSACTION);

        $this->batch->commit();
    }

    public function testRollback()
    {
        $this->connection->rollback([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'transaction' => self::TRANSACTION
        ]);

        $this->batch->___setProperty('connection', $this->connection->reveal());
        $this->batch->___setProperty('transaction', self::TRANSACTION);

        $this->batch->rollback();
    }

    /**
     * @expectedException RuntimeException
     */
    public function testRollbackFailsWithoutTransaction()
    {
        $this->batch->rollback();
    }

    private function commitAndAssert($assertion)
    {
        if (is_callable($assertion)) {
            $this->connection->commit(Argument::that($assertion))
                ->shouldBeCalled();
        } elseif (is_array($assertion)) {
            $this->connection->commit($assertion)->shouldBeCalled();
        } else {
            throw new \Exception('bad assertion');
        }

        $this->batch->___setProperty('connection', $this->connection->reveal());

        $this->batch->commit();
    }
}
