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

namespace Google\Cloud\Datastore\Tests\Snippet\Query;

use Google\Cloud\Core\Testing\Snippet\Parser\Snippet;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Datastore\Connection\ConnectionInterface;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\EntityIterator;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Query\GqlQuery;
use Prophecy\Argument;

/**
 * @group datastore
 */
class GqlQueryTest extends SnippetTestCase
{
    private $datastore;
    private $connection;
    private $operation;

    public function set_up()
    {
        $this->datastore = TestHelpers::stub(DatastoreClient::class, [], ['operation']);
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->operation = TestHelpers::stub(Operation::class, [
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

        $this->datastore->___setProperty('operation', $this->operation);

        $snippet = $this->snippetFromClass(GqlQuery::class);
        $snippet->replace('$datastore = new DatastoreClient();', '');
        $snippet->addLocal('datastore', $this->datastore);

        $res = $snippet->invoke(['query', 'res']);
        $this->assertEquals('Google', trim($res->output()));
        $this->assertInstanceOf(EntityIterator::class, $res->returnVal()[1]);
    }

    /**
     * @dataProvider provideBindings
     */
    public function testGqlQueryBindings(Snippet $snippet)
    {
        $snippet->addLocal('datastore', $this->datastore);

        $res = $snippet->invoke('query');
        $this->assertInstanceOf(GqlQuery::class, $res->returnVal());

        $obj = $res->returnVal()->queryObject();
        $this->assertEquals('Google', $obj['namedBindings']['companyName']['value']['stringValue']);
    }

    /**
     * @dataProvider providePositionalBindings
     */
    public function testPositionalBindings(Snippet $snippet)
    {
        $snippet->addLocal('datastore', $this->datastore);

        $res = $snippet->invoke('query');
        $this->assertInstanceOf(GqlQuery::class, $res->returnVal());

        $obj = $res->returnVal()->queryObject();
        $this->assertFalse($obj['allowLiterals']);
        $this->assertEquals('Google', $obj['positionalBindings'][0]['value']['stringValue']);
    }

    /**
     * @dataProvider provideLiterals
     */
    public function testLiterals(Snippet $snippet)
    {
        $snippet->addLocal('datastore', $this->datastore);

        $res = $snippet->invoke('query');
        $this->assertInstanceOf(GqlQuery::class, $res->returnVal());

        $obj = $res->returnVal()->queryObject();
        $this->assertTrue($obj['allowLiterals']);
    }

    /**
     * @dataProvider provideCursor
     */
    public function testCursor(Snippet $snippet)
    {
        $cursor = 'helloworld';
        $snippet->addLocal('datastore', $this->datastore);
        $snippet->addLocal('cursorValue', $cursor);

        $res = $snippet->invoke('query');
        $this->assertInstanceOf(GqlQuery::class, $res->returnVal());

        $obj = $res->returnVal()->queryObject();
        $this->assertEquals($cursor, $obj['namedBindings']['offset']['cursor']);
    }

    public function provideBindings()
    {
        return $this->provideSnippets('bindings');
    }

    public function providePositionalBindings()
    {
        return $this->provideSnippets('pos_bindings');
    }

    public function provideLiterals()
    {
        return $this->provideSnippets('literals');
    }

    public function provideCursor()
    {
        return $this->provideSnippets('cursor');
    }

    private function provideSnippets($name)
    {
        parent::set_up_before_class();

        return [
            [$this->snippetFromMethod(DatastoreClient::class, 'gqlQuery', $name)],
            [$this->snippetFromClass(GqlQuery::class, $name)]
        ];
    }
}
