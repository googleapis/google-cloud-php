<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Tests\Snippets\Datastore\Query;

use Google\Cloud\Datastore\Connection\ConnectionInterface;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\EntityIterator;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Query\Query;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Prophecy\Argument;

/**
 * @group datastore
 */
class QueryTest extends SnippetTestCase
{
    private $datastore;
    private $connection;
    private $operation;
    private $query;

    public function setUp()
    {
        $mapper = new EntityMapper('my-awesome-project', true, false);

        $this->datastore = new DatastoreClient;
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->operation = \Google\Cloud\Dev\stub(Operation::class, [
            $this->connection->reveal(),
            'my-awesome-project',
            '',
            $mapper
        ]);

        $this->query = new Query($mapper);
    }

    public function testClass()
    {
        $this->connection->runQuery(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'batch' => [
                    'entityResults' => [
                        [
                            'entity' => [
                                'key' => [
                                    'path' => []
                                ],
                                'properties' => [
                                    'companyName' => [
                                        'stringValue' => 'Google'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'moreResults' => 'no'
                ]
            ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromClass(Query::class);
        $snippet->addLocal('operation', $this->operation);
        $snippet->insertAfterLine(3, '$reflection = new \ReflectionClass($datastore);
            $property = $reflection->getProperty(\'operation\');
            $property->setAccessible(true);
            $property->setValue($datastore, $operation);
            $property->setAccessible(false);'
        );

        $res = $snippet->invoke('res');
        $this->assertEquals('Google', $res->output());
        $this->assertInstanceOf(EntityIterator::class, $res->returnVal());
    }

    public function testClassQueryObject()
    {
        $snippet = $this->snippetFromClass(Query::class, 1);
        $snippet->addLocal('datastore', $this->datastore);

        $res = $snippet->invoke('query');
        $this->assertInstanceOf(Query::class, $res->returnVal());
    }

    public function testProjection()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'projection');
        $snippet->addLocal('query', $this->query);

        $snippet->invoke();
        $this->assertEquals([
            ['property' => $this->propertyName('firstName')],
            ['property' => $this->propertyName('lastName')]
        ], $this->query->queryObject()['projection']);
    }

    public function testKeysOnly()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'keysOnly');
        $snippet->addLocal('query', $this->query);

        $res = $snippet->invoke();
        $this->assertEquals([
            ['property' => $this->propertyName('__key__')],
        ], $this->query->queryObject()['projection']);
    }

    public function testKind()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'kind');
        $snippet->addLocal('query', $this->query);

        $snippet->invoke();

        $this->assertEquals($this->propertyName('Person'), $this->query->queryObject()['kind'][0]);
    }

    public function testFilter()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'filter');
        $snippet->addLocal('query', $this->query);

        $snippet->invoke();

        $this->assertEquals(2, count($this->query->queryObject()['filter']['compositeFilter']['filters']));
    }

    public function testHasAncestor()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'hasAncestor');
        $snippet->addLocal('datastore', $this->datastore);
        $snippet->addLocal('query', $this->query);

        $snippet->invoke();

        $this->assertEquals('__key__', $this->query->queryObject()['filter']['compositeFilter']['filters'][0]['propertyFilter']['property']['name']);
    }

    public function testHasAncestorWithType()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'hasAncestor', 1);
        $snippet->addLocal('datastore', $this->datastore);
        $snippet->addLocal('query', $this->query);
        $snippet->addUse(Key::class);

        $snippet->invoke();

        $this->assertEquals('__key__', $this->query->queryObject()['filter']['compositeFilter']['filters'][0]['propertyFilter']['property']['name']);
    }

    public function testOrder()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'order');
        $snippet->addLocal('query', $this->query);
        $snippet->addUse(Query::class);

        $snippet->invoke();

        $this->assertEquals('birthDate', $this->query->queryObject()['order'][0]['property']['name']);
        $this->assertEquals('DESCENDING', $this->query->queryObject()['order'][0]['direction']);
    }

    public function testDistinctOn()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'distinctOn');
        $snippet->addLocal('query', $this->query);

        $snippet->invoke();

        $this->assertEquals('lastName', $this->query->queryObject()['distinctOn'][0]['name']);
    }

    public function testStart()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'start');
        $snippet->addLocal('query', $this->query);
        $snippet->addLocal('lastResultCursor', 1);

        $snippet->invoke();

        $this->assertEquals(1, $this->query->queryObject()['startCursor']);
    }

    public function testEnd()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'end');
        $snippet->addLocal('query', $this->query);
        $snippet->addLocal('lastResultCursor', 1);

        $snippet->invoke();

        $this->assertEquals(1, $this->query->queryObject()['endCursor']);
    }

    public function testOffset()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'offset');
        $snippet->addLocal('query', $this->query);

        $snippet->invoke();

        $this->assertEquals(2, $this->query->queryObject()['offset']);
    }

    public function testLimit()
    {
        $snippet = $this->snippetFromMethod(Query::class, 'limit');
        $snippet->addLocal('query', $this->query);

        $snippet->invoke();

        $this->assertEquals(50, $this->query->queryObject()['limit']);
    }

    // ***** HELPERS

    private function propertyName($property)
    {
        return [
            'name' => $property
        ];
    }
}
