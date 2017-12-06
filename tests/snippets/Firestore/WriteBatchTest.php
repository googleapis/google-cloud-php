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

namespace Google\Cloud\Tests\Snippets\Firestore;

use Google\Cloud\Dev\Snippet\Parser\Snippet;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Firestore\WriteBatch;
use Google\Cloud\Tests\GrpcTestTrait;
use Google\Cloud\Firestore\V1beta1\DocumentTransform_FieldTransform_ServerValue;
use Prophecy\Argument;

/**
 * @group firestore
 * @group firestore-writebatch
 */
class WriteBatchTest extends SnippetTestCase
{
    use GrpcTestTrait;

    const DATABASE = 'projects/example_project/databases/(default)';
    const DOCUMENT = 'projects/example_project/databases/(default)/documents/a/b';

    private $connection;
    private $batch;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->batch = \Google\Cloud\Dev\stub(WriteBatch::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            self::DATABASE
        ], ['connection', 'transaction']);
    }

    public function testClass()
    {
        $this->checkAndSkipGrpcTests();

        $snippet = $this->snippetFromClass(WriteBatch::class);
        $res = $snippet->invoke('batch');
        $this->assertInstanceOf(WriteBatch::class, $res->returnVal());
    }

    public function testCreate()
    {
        $snippet = $this->snippetFromMethod(WriteBatch::class, 'create');
        $this->commitAndAssert($snippet, [
            [
                'currentDocument' => ['exists' => false],
                'update' => [
                    'name' => self::DOCUMENT,
                    'fields' => [
                        'name' => ['stringValue' => 'John']
                    ]
                ]
            ]
        ]);
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(WriteBatch::class, 'update');
        $this->commitAndAssert($snippet, [
            [
                'updateMask' => [
                    'fieldPaths' => [
                        'country',
                        'cryptoCurrencies.bitcoin',
                        'cryptoCurrencies.ethereum',
                        'cryptoCurrencies.litecoin',
                        'name',
                    ]
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
                                        'integerValue' => 10
                                    ],
                                    'litecoin' => [
                                        'doubleValue' => 5.51
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
        $snippet = $this->snippetFromMethod(WriteBatch::class, 'update', 1);
        $this->commitAndAssert($snippet, [
            [
                'updateMask' => [
                    'fieldPaths' => [
                        'country'
                    ]
                ],
                'currentDocument' => ['exists' => true],
                'update' => [
                    'name' => self::DOCUMENT,
                    'fields' => []
                ]
            ], [
                'transform' => [
                    'document' => self::DOCUMENT,
                    'fieldTransforms' => [
                        [
                            'fieldPath' => 'lastLogin',
                            'setToServerValue' => DocumentTransform_FieldTransform_ServerValue::REQUEST_TIME
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testUpdateSpecialChars()
    {
        $snippet = $this->snippetFromMethod(WriteBatch::class, 'update', 2);
        $this->commitAndAssert($snippet, [
            [
                'updateMask' => [
                    'fieldPaths' => [
                        'cryptoCurrencies.`big$$$coin`'
                    ]
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
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testSet()
    {
        $snippet = $this->snippetFromMethod(WriteBatch::class, 'set');
        $this->commitAndAssert($snippet, [
            [
                'update' => [
                    'name' => self::DOCUMENT,
                    'fields' => [
                        'name' => ['stringValue' => 'John']
                    ]
                ]
            ]
        ]);
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(WriteBatch::class, 'delete');
        $this->commitAndAssert($snippet, [
            [
                'delete' => self::DOCUMENT
            ]
        ]);
    }

    public function testCommit()
    {
        $this->connection->commit(Argument::any())
            ->shouldBeCalled();
        $this->batch->___setProperty('connection', $this->connection->reveal());
        $snippet = $this->snippetFromMethod(WriteBatch::class, 'commit');
        $snippet->addLocal('batch', $this->batch);
        $snippet->invoke();
    }

    public function commitAndAssert(Snippet $snippet, $assertion)
    {
        $this->connection->commit([
            'database' => self::DATABASE,
            'writes' => $assertion
        ])->shouldBeCalled();
        $this->batch->___setProperty('connection', $this->connection->reveal());

        $snippet->addLocal('batch', $this->batch);
        $snippet->addLocal('documentName', self::DOCUMENT);
        $snippet->invoke();

        $this->batch->commit();
    }
}
