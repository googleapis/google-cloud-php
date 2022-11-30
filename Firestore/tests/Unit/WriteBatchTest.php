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

namespace Google\Cloud\Firestore\Tests\Unit;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\V1\DocumentTransform\FieldTransform\ServerValue;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Firestore\WriteBatch;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches;

/**
 * @group firestore
 * @group firestore-writebatch
 */
class WriteBatchTest extends TestCase
{
    use ExpectException;
    use ExpectExceptionMessageMatches;

    const PROJECT = 'example_project';
    const DATABASE = '(default)';
    const DOCUMENT = 'projects/example_project/databases/(default)/documents/a/b';
    const TRANSACTION = 'foobar';

    private $connection;
    private $batch;

    public function set_up()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->batch = TestHelpers::stub(WriteBatch::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE)
        ], ['connection', 'transaction']);
    }

    /**
     * @dataProvider documents
     */
    public function testCreate($name, $ref)
    {
        $this->batch->create($ref, [
            'hello' => 'world'
        ]);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'currentDocument' => ['exists' => false],
                    'update' => [
                        'name' => $name,
                        'fields' => ['hello' => ['stringValue' => 'world']]
                    ]
                ]
            ]
        ]);
    }

    /**
     * @dataProvider documents
     */
    public function testUpdate($name, $ref)
    {
        $this->batch->update($ref, [
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
                        'name' => $name,
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
     */
    public function testUpdateBadInput($data)
    {
        $this->expectException('InvalidArgumentException');

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

    /**
     * @dataProvider documents
     */
    public function testUpdateSentinels($name, $ref)
    {
        $this->batch->update($ref, [
            ['path' => 'foo', 'value' =>  'bar'],
            ['path' => 'hello', 'value' =>  FieldValue::deleteField()],
            ['path' => 'world', 'value' =>  FieldValue::serverTimestamp()],
            ['path' => 'arr', 'value' => FieldValue::arrayUnion(['a'])],
            ['path' => 'arr2', 'value' => FieldValue::arrayRemove(['b'])],
            ['path' => 'int', 'value' => FieldValue::increment(2)],
        ]);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'updateMask' => ['fieldPaths' => ['foo', 'hello']],
                    'currentDocument' => ['exists' => true],
                    'update' => [
                        'name' => $name,
                        'fields' => [
                            'foo' => ['stringValue' => 'bar']
                        ]
                    ]
                ], [
                    'transform' => [
                        'document' => $name,
                        'fieldTransforms' => [
                            [
                                'fieldPath' => 'world',
                                'setToServerValue' => ServerValue::REQUEST_TIME
                            ], [
                                'fieldPath' => 'arr',
                                'appendMissingElements' => [
                                    'values' => [
                                        [
                                            'stringValue' => 'a'
                                        ]
                                    ]
                                ]
                            ], [
                                'fieldPath' => 'arr2',
                                'removeAllFromArray' => [
                                    'values' => [
                                        [
                                            'stringValue' => 'b'
                                        ]
                                    ]
                                ]
                            ], [
                                'fieldPath' => 'int',
                                'increment' => [
                                    'integerValue' => 2
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * @dataProvider noUpdateSentinels
     */
    public function testSentinelsOmitUpdateWrite($val)
    {
        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::DOCUMENT);

        $this->batch->update($ref->reveal(), [
            ['path' => 'foo', 'value' =>  $val],
        ]);

        $this->commitAndAssert(function ($arg) {
            if (count($arg['writes']) > 1) {
                return false;
            }

            if (!isset($arg['writes'][0]['transform']['fieldTransforms'][0])) {
                return false;
            }

            return $arg['writes'][0]['transform']['fieldTransforms'][0]['fieldPath'] === 'foo';
        });
    }

    public function noUpdateSentinels()
    {
        return [
            [FieldValue::serverTimestamp()],
            [FieldValue::arrayUnion([])],
            [FieldValue::arrayRemove([])]
        ];
    }

    /**
     * @dataProvider documents
     */
    public function testSet($name, $ref)
    {
        $this->batch->set($ref, [
            'hello' => 'world'
        ]);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'update' => [
                        'name' => $name,
                        'fields' => ['hello' => ['stringValue' => 'world']]
                    ]
                ]
            ]
        ]);
    }

    /**
     * @dataProvider documents
     */
    public function testSetMerge($name, $ref)
    {
        $this->batch->set($ref, [
            'hello' => 'world',
            'foobar' => ['foo' => 'bar'],
            'emptiness' => []
        ], ['merge' => true]);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'updateMask' => ['fieldPaths' => ['emptiness', 'foobar.foo', 'hello']],
                    'update' => [
                        'name' => $name,
                        'fields' => [
                            'hello' => ['stringValue' => 'world'],
                            'foobar' => ['mapValue' => ['fields' => ['foo' => ['stringValue' => 'bar']]]],
                            'emptiness' => ['arrayValue' => ['values' => []]]
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * @dataProvider documents
     */
    public function testSetSentinels($name, $ref)
    {
        $this->batch->set($ref, [
            'world' => FieldValue::serverTimestamp(),
            'foo' => 'bar'
        ]);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'update' => [
                        'name' => $name,
                        'fields' => [
                            'foo' => [
                                'stringValue' => 'bar'
                            ]
                        ]
                    ]
                ], [
                    'transform' => [
                        'document' => $name,
                        'fieldTransforms' => [
                            [
                                'fieldPath' => 'world',
                                'setToServerValue' => ServerValue::REQUEST_TIME
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testSentinelsInArray()
    {
        $this->expectException('InvalidArgumentException');

        $this->batch->set('name', [
            'foo' => [
                FieldValue::serverTimestamp()
            ]
        ]);
    }

    public function testSentinelsAfterArray()
    {
        $ret = $this->batch->set('name', [
            'foo' => [
                'a', 'b', 'c'
            ],
            'bar' => FieldValue::serverTimestamp()
        ]);

        $this->assertInstanceOf(\Google\Cloud\Firestore\BulkWriter::class, $ret);
    }

    public function testSentinelsAfterArrayNested()
    {
        $ret = $this->batch->set('name', [
            'foo' => [
                'a' => [
                    'a', 'b', 'c',
                ],
                'b' => FieldValue::serverTimestamp()
            ]
        ]);

        $this->assertInstanceOf(\Google\Cloud\Firestore\BulkWriter::class, $ret);
    }

    public function testSentinelCannotContainSentinel()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessageMatches('/Document transforms cannot contain/');
        $this->batch->set('name', [
            'foo' => FieldValue::arrayRemove([FieldValue::arrayUnion([])])
        ]);
    }

    /**
     * @dataProvider documents
     */
    public function testSetSentinelsDeleteRequiresMerge($name, $ref)
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Delete cannot appear in data unless `$options[\'merge\']` is set.');

        $this->batch->set($ref, [
            'hello' => FieldValue::deleteField(),
        ]);
    }

    /**
     * @dataProvider documents
     */
    public function testDelete($name, $ref)
    {
        $this->batch->delete($ref);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'delete' => $name
                ]
            ]
        ]);
    }

    /**
     * @dataProvider documents
     */
    public function testWriteUpdateTimePrecondition($name, $ref)
    {
        $ts = [
            'seconds' => 10000,
            'nanos' => 5
        ];

        $this->batch->delete($ref, [
            'precondition' => [
                'updateTime' => new Timestamp(
                    \DateTimeImmutable::createFromFormat('U', (string) $ts['seconds']),
                    $ts['nanos']
                )
            ]
        ]);

        $this->commitAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'delete' => $name,
                    'currentDocument' => [
                        'updateTime' => $ts
                    ]
                ]
            ]
        ]);
    }

    public function documents()
    {
        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::DOCUMENT);
        $doc = $ref->reveal();

        return [
            [self::DOCUMENT, self::DOCUMENT],
            [self::DOCUMENT, $doc]
        ];
    }

    public function testWriteUpdateTimePreconditionInvalidType()
    {
        $this->expectException('InvalidArgumentException');

        $this->batch->delete(self::DOCUMENT, [
            'precondition' => [
                'updateTime' => 'foobar'
            ]
        ]);
    }

    public function testWritePreconditionMissingStuff()
    {
        $this->expectException('InvalidArgumentException');

        $this->batch->delete(self::DOCUMENT, [
            'precondition' => ['foo' => 'bar']
        ]);
    }

    public function testCommitResponse()
    {
        $now = time();
        $nanos = 10;

        $timestamp = new Timestamp(\DateTimeImmutable::createFromFormat('U', (string) $now), $nanos);

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

        $this->assertEquals($timestamp, $res['commitTime']);
        $this->assertEquals($timestamp, $res['writeResults'][0]['updateTime']);
        $this->assertEquals($timestamp, $res['writeResults'][1]['updateTime']);
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
        ])->shouldBeCalled();

        $this->batch->___setProperty('connection', $this->connection->reveal());
        $this->batch->___setProperty('transaction', self::TRANSACTION);

        $this->batch->rollback();
    }

    public function testRollbackFailsWithoutTransaction()
    {
        $this->expectException('RuntimeException');

        $this->batch->rollback();
    }

    public function testUpdateEmptyFails()
    {
        $this->expectException('InvalidArgumentException');

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
