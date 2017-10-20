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
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Dev\Snippet\Parser\Snippet;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Firestore\V1beta1\StructuredQuery_CompositeFilter_Operator;

/**
 * @group firestore
 * @group firestore-query
 */
class QueryTest extends SnippetTestCase
{
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
        $snippet = $this->snippetFromClass(Query::class);
        $res = $snippet->invoke('query');
        $this->assertInstanceOf(Query::class, $res->returnVal());
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
                'op' => StructuredQuery_CompositeFilter_Operator::AND,
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
    public function testCursors($method, $key, $before)
    {
        $cursor = ['foo' => 'bar'];
        $snippet = $this->snippetFromMethod(Query::class, $method);
        $snippet->addLocal('cursor', $cursor);
        $this->runAndAssert($snippet, $key, [
            'before' => $before,
            'values' => [
                'foo' => [
                    'stringValue' => 'bar'
                ]
            ]
        ]);
    }

    public function cursors()
    {
        return [
            ['startAt', 'startAt', true],
            ['startAfter', 'startAt', false],
            ['endBefore', 'endAt', true],
            ['endAt', 'endAt', false]
        ];
    }

    public function testClearQuery()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'clearQuery');
        $this->runAndAssert($snippet, '', null);
    }

    private function runAndAssert(Snippet $snippet, $key, $argument)
    {
        $this->connection->runQuery([
            'parent' => self::NAME,
            'transaction' => null,
            'structuredQuery' => array_filter([
                'from' => self::NAME,
                $key => $argument
            ])
        ])->shouldBeCalled()->willReturn(new \ArrayIterator([[]]));

        $this->query->___setProperty('connection', $this->connection->reveal());
        $snippet->addLocal('query', $this->query);
        $res = $snippet->invoke('query');
        $res->returnVal()->snapshot()->rows()->current();
        $this->assertInstanceOf(Query::class, $res->returnVal());
    }
}
