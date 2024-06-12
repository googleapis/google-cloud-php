<?php
/**
 * Copyright 2023 Google Inc.
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

use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\FirestoreTestHelperTrait;
use Google\Cloud\Firestore\V1\Client\FirestoreClient as V1FirestoreClient;
use Google\Cloud\Firestore\V1\StructuredQuery\FieldFilter\Operator as FieldFilterOperator;
use Google\Cloud\Firestore\Filter;
use Google\Cloud\Firestore\V1\StructuredQuery\CompositeFilter\Operator;
use Prophecy\PhpUnit\ProphecyTrait;
use Google\Cloud\Firestore\Query;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\Snippet\Parser\Snippet;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Firestore\ValueMapper;
use Prophecy\Argument;

/**
 * @group firestore
 * @group firestore-filter
 */
class FilterTest extends SnippetTestCase
{
    use FirestoreTestHelperTrait;
    use ProphecyTrait;

    public const COLLECTION = 'a';
    public const QUERY_PARENT = 'projects/example_project/databases/(default)/documents';

    private $requestHandler;
    private $serializer;

    public function setUp(): void
    {
        $this->requestHandler = $this->prophesize(RequestHandler::class);
        $this->serializer = $this->getSerializer();
    }

    public function testFilterClass()
    {
        $snippet = $this->snippetFromClass(Filter::class);

        $this->runAndAssert($snippet, 'where', [
            'compositeFilter' => [
                'op' => Operator::PBOR,
                'filters' => [
                    [
                        'fieldFilter' => [
                            'field' => [
                                'fieldPath' => 'firstName'
                            ],
                            'op' => FieldFilterOperator::EQUAL,
                            'value' => [
                                'stringValue' => 'John'
                            ]
                        ]
                    ],
                    [
                        'fieldFilter' => [
                            'field' => [
                                'fieldPath' => 'firstName'
                            ],
                            'op' => FieldFilterOperator::EQUAL,
                            'value' => [
                                'stringValue' => 'Monica'
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testFieldFilter()
    {
        $snippet = $this->snippetFromMethod(Filter::class, 'field');

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

    public function testCompositeFilterAnd()
    {
        $snippet = $this->snippetFromMethod(Filter::class, 'and');

        $this->runAndAssert($snippet, 'where', [
            'compositeFilter' => [
                'op' => Operator::PBAND,
                'filters' => [
                    [
                        'fieldFilter' => [
                            'field' => [
                                'fieldPath' => 'firstName'
                            ],
                            'op' => FieldFilterOperator::EQUAL,
                            'value' => [
                                'stringValue' => 'John'
                            ]
                        ]
                    ],
                    [
                        'fieldFilter' => [
                            'field' => [
                                'fieldPath' => 'age'
                            ],
                            'op' => FieldFilterOperator::GREATER_THAN,
                            'value' => [
                                'stringValue' => '25'
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testCompositeFilterOr()
    {
        $snippet = $this->snippetFromMethod(Filter::class, 'or');

        $this->runAndAssert($snippet, 'where', [
            'compositeFilter' => [
                'op' => Operator::PBOR,
                'filters' => [
                    [
                        'fieldFilter' => [
                            'field' => [
                                'fieldPath' => 'firstName'
                            ],
                            'op' => FieldFilterOperator::EQUAL,
                            'value' => [
                                'stringValue' => 'John'
                            ]
                        ]
                    ],
                    [
                        'fieldFilter' => [
                            'field' => [
                                'fieldPath' => 'firstName'
                            ],
                            'op' => FieldFilterOperator::EQUAL,
                            'value' => [
                                'stringValue' => 'Monica'
                            ]
                        ]
                    ]
                ]
            ]
        ]);
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
            $this->requestHandler->reveal(),
            $this->serializer,
            new ValueMapper(
                $this->requestHandler->reveal(),
                $this->serializer,
                false
            ),
            self::QUERY_PARENT,
            [
                'from' => $from
            ]
        ], ['requestHandler']);

        $this->requestHandler->sendRequest(
            V1FirestoreClient::class,
            'runQuery',
            Argument::that(function ($req) use ($query, $from) {
                $data = $this->getSerializer()->encodeMessage($req);
                return $data['parent'] == self::QUERY_PARENT
                    && array_replace_recursive($data['structuredQuery'], ['from' => $from] + $query)
                        == $data['structuredQuery'];
            }),
            Argument::withEntry('retrySettings', ['maxRetries' => 0])
        )->shouldBeCalled()->willReturn(new \ArrayIterator([[]]));

        $q->___setProperty('requestHandler', $this->requestHandler->reveal());
        $snippet->addLocal('query', $q);

        $res = $snippet->invoke('result');
        $res->returnVal()->documents(['maxRetries' => 0]);
        $this->assertInstanceOf(Query::class, $res->returnVal());
    }
}
