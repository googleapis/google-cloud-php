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

use Prophecy\Argument;
use Google\Cloud\Firestore\WriteBatch;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Dev\Snippet\Parser\Snippet;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Firestore\Connection\ConnectionInterface;

/**
 * @group firestore
 * @group firestore-writebatch
 */
class WriteBatchTest extends SnippetTestCase
{
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
        $snippet = $this->snippetFromClass(WriteBatch::class);
        $res = $snippet->invoke('batch');
        $this->assertInstanceOf(WriteBatch::class, $res->returnVal());
    }

    public function testCreate()
    {
        $snippet = $this->snippetFromMethod(WriteBatch::class, 'create');
        $this->commitAndAssert($snippet, [
            [
                'updateMask' => ['name'],
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
                'updateMask' => ['name'],
                'currentDocument' => ['exists' => true],
                'update' => [
                    'name' => self::DOCUMENT,
                    'fields' => [
                        'name' => ['stringValue' => 'John']
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

    public function testVerify()
    {
        $snippet = $this->snippetFromMethod(WriteBatch::class, 'verify');
        $this->commitAndAssert($snippet, [
            [
                'verify' => self::DOCUMENT,
                'currentDocument' => ['exists' => true]
            ]
        ]);
    }

    public function testTransform()
    {
        $snippet = $this->snippetFromMethod(WriteBatch::class, 'transform');
        $snippet->addUse(WriteBatch::class);
        $this->commitAndAssert($snippet, [
            [
                'transform' => [
                    'document' => self::DOCUMENT,
                    'fieldTransforms' => [
                        [
                            'fieldPath' => 'lastLoginTime',
                            'setToServerValue' => WriteBatch::REQUEST_TIME
                        ]
                    ]
                ]
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

    public function testRollback()
    {
        $this->connection->rollback(Argument::any())
            ->shouldBeCalled();
        $this->batch->___setProperty('connection', $this->connection->reveal());
        $this->batch->___setProperty('transaction', 'foo');
        $snippet = $this->snippetFromMethod(WriteBatch::class, 'rollback');
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
