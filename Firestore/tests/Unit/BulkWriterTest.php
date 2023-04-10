<?php
/**
 * Copyright 2022 Google Inc.
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
use Google\Cloud\Firestore\BulkWriter;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\V1\DocumentTransform\FieldTransform\ServerValue;
use Google\Cloud\Firestore\ValueMapper;
use Google\Rpc\Code;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group firestore
 * @group firestore-bulkwriter
 */
class BulkWriterTest extends TestCase
{
    use ProphecyTrait;

    const PROJECT = 'example_project';
    const DATABASE = '(default)';
    const DOCUMENT = 'projects/example_project/databases/(default)/documents/a/b';
    const TRANSACTION = 'foobar';

    private $connection;
    private $batch;

    public function setUp(): void
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->batch = TestHelpers::stub(BulkWriter::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            [],
        ]);
        // avoids sleep during unit tests
        $this->batch->setMaxRetryTimeInMs(0);
    }

    public function testBulkwriterOptionsInitialOpsPerSecond()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/Value for argument "initialOpsPerSecond" must be greater than 1/');
        new BulkWriter(
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            "TEST_DB",
            ['initialOpsPerSecond' => 0]
        );
    }

    public function testBulkwriterOptionsMaxOpsPerSecond()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/Value for argument "maxOpsPerSecond" must be greater than 1/');
        new BulkWriter(
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            "TEST_DB",
            ['maxOpsPerSecond' => 0]
        );
    }

    public function testBulkwriterOptions()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/\'maxOpsPerSecond\' cannot be less than \'initialOpsPerSecond\'/');
        new BulkWriter(
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            "TEST_DB",
            [
                'maxOpsPerSecond' => 2,
                'initialOpsPerSecond' => 3,
            ]
        );
    }

    /**
     * @dataProvider documents
     */
    public function testCreate($name, $ref)
    {
        $this->batch->create($ref, [
            'hello' => 'world',
        ]);

        $this->flushAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'currentDocument' => ['exists' => false],
                    'update' => [
                        'name' => $name,
                        'fields' => ['hello' => ['stringValue' => 'world']],
                    ],
                ],
            ],
            'labels' => [],
        ]);
    }

    /**
     * @dataProvider bulkDocuments
     */
    public function testCreateMultipleDocs($docs)
    {
        $this->connection->batchWrite(Argument::that(function ($arg) use ($docs) {
            if (count($arg['writes']) <= 0) {
                return false;
            }
            foreach ($arg['writes'] as $write) {
                if (!$write['currentDocument']) {
                    return false;
                }
                if ($docs[$write['update']['fields']['key']['integerValue']] !==
                    $write['update']['fields']['path']['stringValue']) {
                    return false;
                }
            }
            return true;
        }))
            ->shouldBeCalledTimes(3)
            ->willReturn(
                [
                    'writeResults' => array_fill(0, 20, []),
                    'status' => array_fill(0, 20, ['code' => Code::OK]),
                ]
            );

        foreach ($docs as $k => $v) {
            $this->batch->create($v, [
                'path' => $v,
                'key' => $k,
            ]);
        }
        $this->batch->flush();
    }

    /**
     * @dataProvider bulkDocuments
     */
    public function testFailuresAreRetriedTillMaxAttempts($docs)
    {
        $this->connection->batchWrite(Argument::that(function ($arg) use ($docs) {
            if (count($arg['writes']) <= 0) {
                return false;
            }
            foreach ($arg['writes'] as $write) {
                if (!$write['currentDocument']) {
                    return false;
                }
                if ($docs[$write['update']['fields']['key']['integerValue']] !==
                    $write['update']['fields']['path']['stringValue']) {
                    return false;
                }
            }
            return true;
        }))
            ->shouldBeCalledTimes(3)
            ->willReturn(
                [
                    'writeResults' => array_fill(0, 20, []),
                    'status' => array_fill(0, 20, ['code' => Code::OK]),
                ]
            );

        foreach ($docs as $k => $v) {
            $this->batch->create($v, [
                'path' => $v,
                'key' => $k,
            ]);
        }
        $this->batch->flush();
    }

    /**
     * @dataProvider bulkDocuments
     */
    public function testFlushReturnsAllResponses($docs)
    {
        $this->connection->batchWrite(Argument::that(function ($arg) use ($docs) {
            if (count($arg['writes']) <= 0) {
                return false;
            }
            foreach ($arg['writes'] as $write) {
                if (!$write['currentDocument']) {
                    return false;
                }
                if ($docs[$write['update']['fields']['key']['integerValue']] !==
                    $write['update']['fields']['path']['stringValue']) {
                    return false;
                }
            }
            return true;
        }))
            ->willReturn(
                [
                    'writeResults' => array_fill(0, 20, []),
                    'status' => array_fill(0, 20, ['code' => Code::OK]),
                ]
            );

        foreach ($docs as $k => $v) {
            $this->batch->create($v, [
                'path' => $v,
                'key' => $k,
            ]);
        }
        $response = $this->batch->flush(true);
        $this->assertIsArray($response);
        $this->assertEquals(count($docs), count($response['status']));
        for ($i = 0; $i < 50; $i++) {
            $this->assertEquals(Code::OK, $response['status'][$i]['code']);
        }
    }

    /**
     * @dataProvider bulkDocuments
     */
    public function testCloseReturnsAllResponses($docs)
    {
        $this->connection->batchWrite(Argument::that(function ($arg) use ($docs) {
            if (count($arg['writes']) <= 0) {
                return false;
            }
            foreach ($arg['writes'] as $write) {
                if (!$write['currentDocument']) {
                    return false;
                }
                if ($docs[$write['update']['fields']['key']['integerValue']] !==
                    $write['update']['fields']['path']['stringValue']) {
                    return false;
                }
            }
            return true;
        }))
            ->willReturn(
                [
                    'writeResults' => array_fill(0, 20, []),
                    'status' => array_fill(0, 20, ['code' => Code::OK]),
                ]
            );

        foreach ($docs as $k => $v) {
            $this->batch->create($v, [
                'path' => $v,
                'key' => $k,
            ]);
        }
        $response = $this->batch->close();
        $this->assertIsArray($response);
        $this->assertEquals(count($docs), count($response['status']));
        for ($i = 0; $i < 50; $i++) {
            $this->assertEquals(Code::OK, $response['status'][$i]['code']);
        }
    }

    /**
     * @dataProvider bulkDocuments
     */
    public function testFailuresAreRetriedInSubsequentBatches($docs)
    {
        $batchSize = 20;
        $successPerBatch = $batchSize * 3 / 4;
        $successfulDocs = [];
        $this->batch = TestHelpers::stub(BulkWriter::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            ['greedilySend' => false],
        ]);

        $this->connection->batchWrite(Argument::that(
            function ($arg) use ($docs, $successPerBatch, &$successfulDocs) {
                if (count($arg['writes']) <= 0) {
                    return false;
                }
                foreach ($arg['writes'] as $i => $write) {
                    if (!$write['currentDocument']) {
                        return false;
                    }
                    if ($docs[$write['update']['fields']['key']['integerValue']] !==
                        $write['update']['fields']['path']['stringValue']) {
                        return false;
                    }
                    if ($i < $successPerBatch) {
                        $successfulDocs[] = $write['update']['fields']['path']['stringValue'];
                    }
                }
                return true;
            }
        ))
            ->shouldBeCalledTimes(4)
            ->willReturn(
                [
                    'writeResults' => array_fill(0, $batchSize, []),
                    'status' => array_merge(
                        array_fill(0, $successPerBatch, [
                            'code' => Code::OK,
                        ]),
                        array_fill(0, $batchSize - $successPerBatch, [
                            'code' => Code::DATA_LOSS,
                        ])
                    ),
                ]
            );

        foreach ($docs as $k => $v) {
            $this->batch->create($v, [
                'key' => $k,
                'path' => $v,
            ]);
        }
        $this->batch->close();

        $this->assertEquals(count($docs), count($successfulDocs));
        for ($i = 0; $i < count($docs); $i++) {
            $this->assertContains($docs[$i], $successfulDocs);
        }
    }

    /**
     * @dataProvider documents
     */
    public function testUpdate($name, $ref)
    {
        $this->batch->update($ref, [
            [
                'path' => 'hello.world',
                'value' => 'world',
            ], [
                'path' => new FieldPath(['hello', 'house']),
                'value' => 'house',
            ],
        ]);

        $this->flushAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'updateMask' => [
                        'fieldPaths' => [
                            'hello.house',
                            'hello.world',
                        ],
                    ],
                    'currentDocument' => ['exists' => true],
                    'update' => [
                        'name' => $name,
                        'fields' => [
                            'hello' => [
                                'mapValue' => [
                                    'fields' => [
                                        'world' => [
                                            'stringValue' => 'world',
                                        ],
                                        'house' => [
                                            'stringValue' => 'house',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'labels' => [],
        ]);
    }

    /**
     * @dataProvider updateBadInput
     */
    public function testUpdateBadInput($data)
    {
        $this->expectException(InvalidArgumentException::class);

        $this->batch->update(self::DOCUMENT, $data);
    }

    public function updateBadInput()
    {
        return [
            [['foo' => 'bar']],
            [[['path' => 'foo']]],
            [[['value' => 'bar']]],
            [[[]]],
        ];
    }

    /**
     * @dataProvider documents
     */
    public function testUpdateSentinels($name, $ref)
    {
        $this->batch->update($ref, [
            ['path' => 'foo', 'value' => 'bar'],
            ['path' => 'hello', 'value' => FieldValue::deleteField()],
            ['path' => 'world', 'value' => FieldValue::serverTimestamp()],
            ['path' => 'arr', 'value' => FieldValue::arrayUnion(['a'])],
            ['path' => 'arr2', 'value' => FieldValue::arrayRemove(['b'])],
            ['path' => 'int', 'value' => FieldValue::increment(2)],
        ]);

        $this->flushAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'updateMask' => ['fieldPaths' => ['foo', 'hello']],
                    'currentDocument' => ['exists' => true],
                    'update' => [
                        'name' => $name,
                        'fields' => [
                            'foo' => ['stringValue' => 'bar'],
                        ],
                    ],
                ], [
                    'transform' => [
                        'document' => $name,
                        'fieldTransforms' => [
                            [
                                'fieldPath' => 'world',
                                'setToServerValue' => ServerValue::REQUEST_TIME,
                            ], [
                                'fieldPath' => 'arr',
                                'appendMissingElements' => [
                                    'values' => [
                                        [
                                            'stringValue' => 'a',
                                        ],
                                    ],
                                ],
                            ], [
                                'fieldPath' => 'arr2',
                                'removeAllFromArray' => [
                                    'values' => [
                                        [
                                            'stringValue' => 'b',
                                        ],
                                    ],
                                ],
                            ], [
                                'fieldPath' => 'int',
                                'increment' => [
                                    'integerValue' => 2,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'labels' => [],
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
            ['path' => 'foo', 'value' => $val],
        ]);

        $this->flushAndAssert(function ($arg) {
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
            [FieldValue::arrayRemove([])],
        ];
    }

    /**
     * @dataProvider documents
     */
    public function testSet($name, $ref)
    {
        $this->batch->set($ref, [
            'hello' => 'world',
        ]);

        $this->flushAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'update' => [
                        'name' => $name,
                        'fields' => ['hello' => ['stringValue' => 'world']],
                    ],
                ],
            ],
            'labels' => [],
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
            'emptiness' => [],
        ], ['merge' => true]);

        $this->flushAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'updateMask' => ['fieldPaths' => ['emptiness', 'foobar.foo', 'hello']],
                    'update' => [
                        'name' => $name,
                        'fields' => [
                            'hello' => ['stringValue' => 'world'],
                            'foobar' => ['mapValue' => ['fields' => ['foo' => ['stringValue' => 'bar']]]],
                            'emptiness' => ['arrayValue' => ['values' => []]],
                        ],
                    ],
                ],
            ],
            'labels' => [],
        ]);
    }

    /**
     * @dataProvider documents
     */
    public function testSetSentinels($name, $ref)
    {
        $this->batch->set($ref, [
            'world' => FieldValue::serverTimestamp(),
            'foo' => 'bar',
        ]);

        $this->flushAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'update' => [
                        'name' => $name,
                        'fields' => [
                            'foo' => [
                                'stringValue' => 'bar',
                            ],
                        ],
                    ],
                ], [
                    'transform' => [
                        'document' => $name,
                        'fieldTransforms' => [
                            [
                                'fieldPath' => 'world',
                                'setToServerValue' => ServerValue::REQUEST_TIME,
                            ],
                        ],
                    ],
                ],
            ],
            'labels' => [],
        ]);
    }

    public function testSentinelsInArray()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->batch->set('name', [
            'foo' => [
                FieldValue::serverTimestamp(),
            ],
        ]);

        $this->flushAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'update' => [
                        'name' => 'name',
                        'fields' => [
                            'foo' => [
                                'stringValue' => 'bar',
                            ],
                        ],
                    ],
                ], [
                    'transform' => [
                        'document' => 'name',
                        'fieldTransforms' => [
                            [
                                'fieldPath' => 'world',
                                'setToServerValue' => ServerValue::REQUEST_TIME,
                            ],
                        ],
                    ],
                ],
            ],
            'labels' => [],
        ]);
    }

    public function testSentinelsAfterArray()
    {
        $this->batch->set('name', [
            'foo' => [
                'a', 'b', 'c',
            ],
            'bar' => FieldValue::serverTimestamp(),
        ]);

        $this->flushAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'update' => [
                        'name' => 'name',
                        'fields' => [
                            'foo' => [
                                'arrayValue' => [
                                    'values' => [
                                        ['stringValue' => 'a'],
                                        ['stringValue' => 'b'],
                                        ['stringValue' => 'c'],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'transform' => [
                        'document' => 'name',
                        'fieldTransforms' => [
                            [
                                'fieldPath' => 'bar',
                                'setToServerValue' => 1,
                            ],
                        ],
                    ],
                ],
            ],
            'labels' => [],
        ]);
    }

    public function testSentinelsAfterArrayNested()
    {
        $this->batch->set('name', [
            'foo' => [
                'a' => [
                    'a', 'b', 'c',
                ],
                'b' => FieldValue::serverTimestamp(),
            ],
        ]);

        $this->flushAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'update' => [
                        'name' => 'name',
                        'fields' => [
                            'foo' => [
                                'mapValue' => [
                                    'fields' => [
                                        'a' => [
                                            'arrayValue' => [
                                                'values' => [
                                                    ['stringValue' => 'a'],
                                                    ['stringValue' => 'b'],
                                                    ['stringValue' => 'c'],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],

                        ],
                    ],
                ],
                [
                    'transform' => [
                        'document' => 'name',
                        'fieldTransforms' => [
                            [
                                'fieldPath' => 'foo.b',
                                'setToServerValue' => 1,
                            ],
                        ],
                    ],
                ],
            ],
            'labels' => [],
        ]);
    }

    public function testSentinelCannotContainSentinel()
    {
        $this->expectException(InvalidArgumentException::class);
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
        $this->expectException(InvalidArgumentException::class);
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

        $this->flushAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'delete' => $name,
                ],
            ],
            'labels' => [],
        ]);
    }

    /**
     * @dataProvider documents
     */
    public function testWriteUpdateTimePrecondition($name, $ref)
    {
        $ts = [
            'seconds' => 10000,
            'nanos' => 5,
        ];

        $this->batch->delete($ref, [
            'precondition' => [
                'updateTime' => new Timestamp(
                    \DateTimeImmutable::createFromFormat('U', (string) $ts['seconds']),
                    $ts['nanos']
                ),
            ],
        ]);

        $this->flushAndAssert([
            'database' => sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE),
            'writes' => [
                [
                    'delete' => $name,
                    'currentDocument' => [
                        'updateTime' => $ts,
                    ],
                ],
            ],
            'labels' => [],
        ]);
    }

    public function documents()
    {
        $ref = $this->prophesize(DocumentReference::class);
        $ref->name()->willReturn(self::DOCUMENT);
        $doc = $ref->reveal();

        return [
            [self::DOCUMENT, self::DOCUMENT],
            [self::DOCUMENT, $doc],
        ];
    }

    public function bulkDocuments()
    {
        $docs = [];
        for ($i = 0; $i < 50; $i++) {
            $docs[] = uniqid(self::DOCUMENT, true);
        }

        return [[$docs]];
    }

    public function testWriteUpdateTimePreconditionInvalidType()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->batch->delete(self::DOCUMENT, [
            'precondition' => [
                'updateTime' => 'foobar',
            ],
        ]);
    }

    public function testWritePreconditionMissingStuff()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->batch->delete(self::DOCUMENT, [
            'precondition' => ['foo' => 'bar'],
        ]);
    }

    public function testCreateAfterClosed()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/firestore: BulkWriter has been closed/');
        $this->connection->batchWrite(Argument::any())
            ->shouldNotBeCalled();
        $this->batch->close();
        $this->batch->create(self::DOCUMENT, [
            'hello' => 'world',
        ]);
    }

    public function testUpdateAfterClosed()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/firestore: BulkWriter has been closed/');
        $this->connection->batchWrite(Argument::any())
            ->shouldNotBeCalled();
        $this->batch->close();
        $this->batch->update(self::DOCUMENT, [
            [
                'path' => 'hello.world',
                'value' => 'world',
            ],
        ]);
    }

    public function testSetAfterClosed()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/firestore: BulkWriter has been closed/');
        $this->connection->batchWrite(Argument::any())
            ->shouldNotBeCalled();
        $this->batch->close();
        $this->batch->set(self::DOCUMENT, [
            'hello' => 'world',
        ]);
    }

    public function testDeleteAfterClosed()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/firestore: BulkWriter has been closed/');
        $this->connection->batchWrite(Argument::any())
            ->shouldNotBeCalled();
        $this->batch->close();
        $this->batch->delete(self::DOCUMENT);
    }

    public function testDuplicateCreate()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/firestore: bulkwriter: received duplicate mutations for path/');
        $this->connection->batchWrite(Argument::any())
            ->shouldNotBeCalled();
        $this->batch->create(self::DOCUMENT, [
            'hello' => 'world',
        ]);
        $this->batch->create(self::DOCUMENT, [
            'hello' => 'world',
        ]);
    }

    public function testDuplicateUpdate()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/firestore: bulkwriter: received duplicate mutations for path/');
        $this->connection->batchWrite(Argument::any())
            ->shouldNotBeCalled();
        $this->batch->update(self::DOCUMENT, [
            [
                'path' => 'hello.world',
                'value' => 'world',
            ],
        ]);
        $this->batch->update(self::DOCUMENT, [
            [
                'path' => 'hello.world',
                'value' => 'world',
            ],
        ]);
    }

    public function testDuplicateSet()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/firestore: bulkwriter: received duplicate mutations for path/');
        $this->connection->batchWrite(Argument::any())
            ->shouldNotBeCalled();
        $this->batch->set(self::DOCUMENT, [
            'hello' => 'world',
        ]);
        $this->batch->set(self::DOCUMENT, [
            'hello' => 'world',
        ]);
    }

    public function testDuplicateDelete()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/firestore: bulkwriter: received duplicate mutations for path/');
        $this->connection->batchWrite(Argument::any())
            ->shouldNotBeCalled();
        $this->batch->delete(self::DOCUMENT);
        $this->batch->delete(self::DOCUMENT);
    }

    public function testUpdateEmptyFails()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->batch->update(self::DOCUMENT, []);
    }

    private function flushAndAssert($assertion)
    {
        if (is_callable($assertion)) {
            $this->connection->batchWrite(Argument::that($assertion))
                ->shouldBeCalled()
                ->willReturn(
                    [
                        'writeResults' => [[]],
                        'status' => [
                            [
                                'code' => Code::OK,
                            ],
                        ],
                    ]
                );
        } elseif (is_array($assertion)) {
            $connectionResponse = [
                'writeResults' => [],
                'status' => [],
            ];
            for ($i = 0; $i < count($assertion); $i++) {
                $connectionResponse['writeResults'][] = [];
                $connectionResponse['status'][] = [
                    'code' => Code::OK,
                ];
            }
            $this->connection->batchWrite($assertion)
                ->shouldBeCalled()
                ->willReturn($connectionResponse);
        } else {
            throw new \Exception('bad assertion');
        }

        $this->batch->flush();
    }
}
