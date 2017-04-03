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
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Query\GqlQuery;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Prophecy\Argument;

/**
 * @group datastore
 */
class GqlQueryTest extends SnippetTestCase
{
    private $datastore;
    private $connection;
    private $operation;

    public function setUp()
    {
        $this->datastore = new DatastoreClient;
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->operation = \Google\Cloud\Dev\Stub(Operation::class, [
            $this->connection->reveal(),
            'my-awesome-project',
            '',
            new EntityMapper('my-awesome-project', true, false)
        ]);
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
                    ]
                ]
            ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromClass(GqlQuery::class);
        $snippet->addLocal('operation', $this->operation);
        $snippet->insertAfterLine(3, '$reflection = new \ReflectionClass($datastore);
            $property = $reflection->getProperty(\'operation\');
            $property->setAccessible(true);
            $property->setValue($datastore, $operation);
            $property->setAccessible(false);'
        );

        $res = $snippet->invoke(['query', 'res']);
        $this->assertEquals('Google', $res->output());
        $this->assertInstanceOf(EntityIterator::class, $res->returnVal()[1]);
        $this->assertTrue(array_key_exists('namedBindings', $res->returnVal()[0]->queryObject()));
    }

    public function testClassPositionalBindings()
    {
        $snippet = $this->snippetFromClass(GqlQuery::class, 1);
        $snippet->addLocal('datastore', $this->datastore);

        $res = $snippet->invoke('query');
        $this->assertInstanceOf(GqlQuery::class, $res->returnVal());
        $this->assertTrue(array_key_exists('positionalBindings', $res->returnVal()->queryObject()));
    }

    public function testClassLiterals()
    {
        $snippet = $this->snippetFromClass(GqlQuery::class, 2);
        $snippet->addLocal('datastore', $this->datastore);

        $res = $snippet->invoke('query');
        $this->assertInstanceOf(GqlQuery::class, $res->returnVal());
        $this->assertFalse(array_key_exists('positionalBindings', $res->returnVal()->queryObject()));
        $this->assertFalse(array_key_exists('namedBindings', $res->returnVal()->queryObject()));
        $this->assertTrue($res->returnVal()->queryObject()['allowLiterals']);
    }
}
