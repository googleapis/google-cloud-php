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
use Google\Cloud\Firestore\Query;
use Google\Cloud\Tests\GrpcTestTrait;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Firestore\QuerySnapshot;
use Google\Cloud\Dev\Snippet\Parser\Snippet;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\V1beta1\StructuredQuery_CompositeFilter_Operator;

/**
 * @group firestore
 * @group firestore-query
 */
class QueryTest extends SnippetTestCase
{
    use GrpcTestTrait;

    const NAME = 'projects/example_project/databases/(default)/documents/a/b';

    private $connection;
    private $query;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->query = \Google\Cloud\Dev\stub(Query::class, [
            $this->connection->reveal(),
            new ValueMapper($this->connection->reveal(), false),
            self::NAME,
            ['from' => self::NAME]
        ]);
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
        $this->connection->runQuery(Argument::any())
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([]));

        $this->query->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Query::class, 'documents');
        $snippet->addLocal('query', $this->query);
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
            'compositeFilter' => [
                'op' => StructuredQuery_CompositeFilter_Operator::PBAND,
                'filters' => [
                    [
                        'fieldFilter' => [
                            'field' => [
                                'fieldPath' => 'firstName'
                            ],
                            'op' => Query::OP_EQUAL,
                            'value' => [
                                'stringValue' => 'John'
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testWhereNaN()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'where', 1);
        $this->runAndAssert($snippet, 'where', [
            'compositeFilter' => [
                'op' => StructuredQuery_CompositeFilter_Operator::PBAND,
                'filters' => [
                    [
                        'unaryFilter' => [
                            'field' => [
                                'fieldPath' => 'coolnessPercentage'
                            ],
                            'op' => Query::OP_NAN,
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
        $this->runAndAssert($snippet, 'limit', [
            'value' => 10
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
        $this->runAndAssertArray($snippet, [
            $key => [
                'before' => $before,
                'values' => [
                    ['integerValue' => $value]
                ]
            ],
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

    private function runAndAssertArray(Snippet $snippet, array $query)
    {
        $this->connection->runQuery([
            'parent' => self::NAME,
            'retries' => 0,
            'structuredQuery' => array_filter([
                'from' => self::NAME,
            ]) + $query
        ])->shouldBeCalled()->willReturn(new \ArrayIterator([[]]));

        $this->query->___setProperty('connection', $this->connection->reveal());
        $snippet->addLocal('query', $this->query);
        $res = $snippet->invoke('query');
        $res->returnVal()->documents(['retries' => 0]);
        $this->assertInstanceOf(Query::class, $res->returnVal());
    }
}
