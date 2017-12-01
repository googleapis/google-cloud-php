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

use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Firestore\WriteBatch;
use Google\Cloud\Firestore\V1beta1\DocumentTransform_FieldTransform_ServerValue;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group firestore
 * @group firestore-writebatch
 */
class WriteBatchTest extends TestCase
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
            [
                'path' => 'hello.world',
                'value' => 'world'
            ], [
                'path' => new FieldPath(['hello', 'house']),
                'value' => 'house'
            ]
        ]);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'updateMask' => [
                        'fieldPaths' => [
                            'hello.house',
                            'hello.world',
                        ]
                    ],
                    'currentDocument' => ['exists' => true],
                    'update' => [
                        'name' => self::DOCUMENT,
                        'fields' => [
                            'hello' => [
                                'mapValue' => [
                                    'fields' => [
                                        'world' => [
                                            'stringValue' => 'world'
                                        ],
                                        'house' => [
                                            'stringValue' => 'house'
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

    /**
     * @dataProvider updateBadInput
     * @expectedException InvalidArgumentException
     */
    public function testUpdateBadInput($data)
    {
        $this->batch->update(self::DOCUMENT, $data);
    }

    public function updateBadInput()
    {
        return [
            [['foo' => 'bar']],
            [[['path' => 'foo']]],
            [[['value' => 'bar']]],
            [[[]]]
        ];
    }

    public function testUpdateSentinels()
    {
        $this->batch->update(self::DOCUMENT, [
            ['path' => 'foo', 'value' =>  'bar'],
            ['path' => 'hello', 'value' =>  FieldValue::deleteField()],
            ['path' => 'world', 'value' =>  FieldValue::serverTimestamp()],
        ]);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'updateMask' => ['fieldPaths' => ['foo', 'hello']],
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
                    'updateMask' => ['fieldPaths' => ['hello']],
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
            'hello' => FieldValue::deleteField(),
            'world' => FieldValue::serverTimestamp()
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

    public function testWriteUpdateTimePrecondition()
    {
        $ts = [
            'seconds' => 10000,
            'nanos' => 5
        ];

        $this->batch->delete(self::DOCUMENT, [
            'precondition' => [
                'updateTime' => new Timestamp(\DateTimeImmutable::createFromFormat('U', (string) $ts['seconds']), $ts['nanos'])
            ]
        ]);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'delete' => self::DOCUMENT,
                    'currentDocument' => [
                        'updateTime' => $ts
                    ]
                ]
            ]
        ]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWriteUpdateTimePreconditionInvalidType()
    {
        $this->batch->delete(self::DOCUMENT, [
            'precondition' => [
                'updateTime' => 'foobar'
            ]
        ]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWritePreconditionMissingStuff()
    {
        $this->batch->delete(self::DOCUMENT, [
            'precondition' => ['foo' => 'bar']
        ]);
    }

    public function testCommitResponse()
    {
        $now = time();
        $nanos = 10;

        $timestamp = [
            'seconds' => $now,
            'nanos' => $nanos
        ];

        $tsObj = new Timestamp(\DateTimeImmutable::createFromFormat('U', (string) $now), $nanos);

        $this->connection->commit(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'commitTime' => $timestamp,
                'writeResults' => [
                    [
                        'updateTime' => $timestamp
                    ], [
                        'updateTime' => $timestamp
                    ]
                ]
            ]);

        $this->batch->___setProperty('connection', $this->connection->reveal());

        $res = $this->batch->commit();

        $this->assertEquals($tsObj, $res['commitTime']);
        $this->assertEquals($tsObj, $res['writeResults'][0]['updateTime']);
        $this->assertEquals($tsObj, $res['writeResults'][1]['updateTime']);
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

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetEmptyFails()
    {
        $this->batch->set(self::DOCUMENT, [], ['merge' => true]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testUpdateEmptyFails()
    {
        $this->batch->update(self::DOCUMENT, []);
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
