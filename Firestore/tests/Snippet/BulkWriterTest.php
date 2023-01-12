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

namespace Google\Cloud\Firestore\Tests\Snippet;

use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\Parser\Snippet;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Firestore\BulkWriter;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\V1\DocumentTransform\FieldTransform\ServerValue;
use Google\Cloud\Firestore\ValueMapper;
use Google\Rpc\Code;
use Prophecy\Argument;

/**
 * @group firestore
 * @group firestore-bulkwriter
 */
class BulkWriterTest extends SnippetTestCase
{
    use GrpcTestTrait;

    const DATABASE = 'projects/example_project/databases/(default)';
    const DOCUMENT = 'projects/example_project/databases/(default)/documents/a/b';

    private $connection;
    private $batch;

    public function set_up()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->batch = TestHelpers::stub(BulkWriter::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            self::DATABASE,
            [],
        ]);
    }

    public function testClass()
    {
        $this->checkAndSkipGrpcTests();

        $snippet = $this->snippetFromClass(BulkWriter::class);
        $res = $snippet->invoke('batch');
        $this->assertInstanceOf(BulkWriter::class, $res->returnVal());
    }

    public function testCreate()
    {
        $snippet = $this->snippetFromMethod(BulkWriter::class, 'create');
        $this->flushAndAssert($snippet, [
            [
                'currentDocument' => ['exists' => false],
                'update' => [
                    'name' => self::DOCUMENT,
                    'fields' => [
                        'name' => ['stringValue' => 'John'],
                    ],
                ],
            ],
        ]);
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(BulkWriter::class, 'update');
        $this->flushAndAssert($snippet, [
            [
                'updateMask' => [
                    'fieldPaths' => [
                        'country',
                        'cryptoCurrencies.bitcoin',
                        'cryptoCurrencies.ethereum',
                        'cryptoCurrencies.litecoin',
                        'name',
                    ],
                ],
                'currentDocument' => ['exists' => true],
                'update' => [
                    'name' => self::DOCUMENT,
                    'fields' => [
                        'name' => ['stringValue' => 'John'],
                        'country' => ['stringValue' => 'USA'],
                        'cryptoCurrencies' => [
                            'mapValue' => [
                                'fields' => [
                                    'bitcoin' => [
                                        'doubleValue' => 0.5,
                                    ],
                                    'ethereum' => [
                                        'integerValue' => 10,
                                    ],
                                    'litecoin' => [
                                        'doubleValue' => 5.51,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function testUpdateSentinels()
    {
        $snippet = $this->snippetFromMethod(BulkWriter::class, 'update', 1);
        $this->flushAndAssert($snippet, [
            [
                'updateMask' => [
                    'fieldPaths' => [
                        'country',
                    ],
                ],
                'currentDocument' => ['exists' => true],
                'update' => [
                    'name' => self::DOCUMENT,
                ],
            ], [
                'transform' => [
                    'document' => self::DOCUMENT,
                    'fieldTransforms' => [
                        [
                            'fieldPath' => 'lastLogin',
                            'setToServerValue' => ServerValue::REQUEST_TIME,
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function testUpdateSpecialChars()
    {
        $snippet = $this->snippetFromMethod(BulkWriter::class, 'update', 2);
        $this->flushAndAssert($snippet, [
            [
                'updateMask' => [
                    'fieldPaths' => [
                        'cryptoCurrencies.`big$$$coin`',
                    ],
                ],
                'currentDocument' => ['exists' => true],
                'update' => [
                    'name' => self::DOCUMENT,
                    'fields' => [
                        'cryptoCurrencies' => [
                            'mapValue' => [
                                'fields' => [
                                    'big$$$coin' => [
                                        'doubleValue' => 5.51,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function testSet()
    {
        $snippet = $this->snippetFromMethod(BulkWriter::class, 'set');
        $this->flushAndAssert($snippet, [
            [
                'update' => [
                    'name' => self::DOCUMENT,
                    'fields' => [
                        'name' => ['stringValue' => 'John'],
                    ],
                ],
            ],
        ]);
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(BulkWriter::class, 'delete');
        $this->flushAndAssert($snippet, [
            [
                'delete' => self::DOCUMENT,
            ],
        ]);
    }

    public function testFlush()
    {
        $this->connection->batchWrite(Argument::any())
            ->shouldNotBeCalled();
        $this->batch->___setProperty('connection', $this->connection->reveal());
        $snippet = $this->snippetFromMethod(BulkWriter::class, 'flush');
        $snippet->addLocal('batch', $this->batch);
        $snippet->invoke();
    }

    public function flushAndAssert(Snippet $snippet, $assertion)
    {
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
        $this->connection->batchWrite([
            'database' => self::DATABASE,
            'writes' => $assertion,
            'labels' => [],
        ])->shouldBeCalled()
            ->willReturn($connectionResponse);

        $snippet->addLocal('batch', $this->batch);
        $snippet->addLocal('documentName', self::DOCUMENT);
        $snippet->invoke();

        $this->batch->flush();
    }
}
