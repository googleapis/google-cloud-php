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

namespace Google\Cloud\Firestore\Tests\Snippet;

use Google\Cloud\Core\Testing\ArrayHasSameValuesToken;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\Parser\Snippet;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Firestore\QuerySnapshot;
use Google\Cloud\Firestore\V1\StructuredQuery\Direction;
use Google\Cloud\Firestore\ValueMapper;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group firestore
 * @group firestore-query
 */
class QueryTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;

    const QUERY_PARENT = 'projects/example_project/databases/(default)/documents';
    const COLLECTION = 'a';
    const NAME = 'projects/example_project/databases/(default)/documents/a/b';

    private $connection;

    public function setUp(): void
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function testClass()
    {
        $this->checkAndSkipGrpcTests();

        $snippet = $this->snippetFromClass(Query::class);
        $res = $snippet->invoke('query');
        $this->assertInstanceOf(Query::class, $res->returnVal());
    }

    public function testDocuments()
    {
        $query = TestHelpers::stub(Query::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            self::QUERY_PARENT,
            [
                'from' => [
                    [
                        'collectionId' => self::COLLECTION,
                    ]
                ]
            ]
        ]);

        $this->connection->runQuery(Argument::any())
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([]));

        $query->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Query::class, 'documents');
        $snippet->addLocal('query', $query);
        $res = $snippet->invoke('result');
        $this->assertInstanceOf(QuerySnapshot::class, $res->returnVal());
    }

    public function testSelect()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'select');
        $this->runAndAssert($snippet, 'select', [
            'fields' => [['fieldPath' => 'firstName']]
        ]);
    }

    public function testWhere()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'where');
        $this->runAndAssert($snippet, 'where', [
            'fieldFilter' => [
                'field' => [
                    'fieldPath' => 'firstName'
                ],
                'op' => Query::OP_EQUAL,
                'value' => [
                    'stringValue' => 'John'
                ]
            ]
        ]);
    }

    public function testWhereNaN()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'where', 1);
        $this->runAndAssert($snippet, 'where', [
            'unaryFilter' => [
                'field' => [
                    'fieldPath' => 'coolnessPercentage'
                ],
                'op' => Query::OP_NAN,
            ]
        ]);
    }

    public function testWhereArrayContains()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'where', 2);
        $this->runAndAssert($snippet, 'where', [
            'fieldFilter' => [
                'field' => [
                    'fieldPath' => 'friends'
                ],
                'op' => Query::OP_ARRAY_CONTAINS,
                'value' => [
                    'arrayValue' => [
                        'values' => [
                            [
                                'stringValue' => 'Steve'
                            ], [
                                'stringValue' => 'Sarah'
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testOrderBy()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'orderBy');
        $this->runAndAssert($snippet, 'orderBy', [
            [
                'field' => [
                    'fieldPath' => 'firstName'
                ],
                'direction' => Query::DIR_DESCENDING
            ]
        ]);
    }

    public function testLimit()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'limit');
        $this->runAndAssert($snippet, 'limit', 10);
    }

    public function testLimitToLast()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'limitToLast');
        $this->runAndAssertArray($snippet, [
            'limit' => 10,
            'orderBy' => [
                [
                    'field' => [
                        'fieldPath' => 'firstName'
                    ],
                    'direction' => Direction::ASCENDING
                ]
            ]
        ]);
    }

    public function testOffset()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'offset');
        $this->runAndAssert($snippet, 'offset', 10);
    }

    /**
     * @dataProvider cursors
     */
    public function testCursors($method, $key, $before, $value)
    {
        $cursor = ['foo' => 'bar'];
        $snippet = $this->snippetFromMethod(Query::class, $method);
        $snippet->setLine(1, '');
        $snippet->addLocal('cursor', $cursor);

        $cursorArr = [
            'values' => [
                ['integerValue' => $value]
            ]
        ];

        if ($before) {
            $cursorArr['before'] = $before;
        }

        $this->runAndAssertArray($snippet, [
            $key => $cursorArr,
            'orderBy' => [
                [
                    'field' => [
                        'fieldPath' => 'age'
                    ],
                    'direction' => Query::DIR_ASCENDING
                ]
            ]
        ]);
    }

    public function cursors()
    {
        return [
            ['startAt', 'startAt', true, 18],
            ['startAfter', 'startAt', false, 17],
            ['endBefore', 'endAt', true, 18],
            ['endAt', 'endAt', false, 17]
        ];
    }

    private function runAndAssert(Snippet $snippet, $key, $argument)
    {
        return $this->runAndAssertArray($snippet, [$key => $argument]);
    }

    private function runAndAssertArray(Snippet $snippet, array $query, $allDescendants = false)
    {
        $from = [
            [
                'collectionId' => self::COLLECTION,
                'allDescendants' => $allDescendants
            ]
        ];

        $q = TestHelpers::stub(Query::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            self::QUERY_PARENT,
            [
                'from' => $from
            ]
        ]);

        $this->connection->runQuery(new ArrayHasSameValuesToken([
            'parent' => self::QUERY_PARENT,
            'retries' => 0,
            'structuredQuery' => [
                'from' => $from
            ] + $query
        ]))->shouldBeCalled()->willReturn(new \ArrayIterator([[]]));

        $q->___setProperty('connection', $this->connection->reveal());
        $snippet->addLocal('query', $q);

        $res = $snippet->invoke('query');
        $res->returnVal()->documents(['maxRetries' => 0]);
        $this->assertInstanceOf(Query::class, $res->returnVal());
    }
}
