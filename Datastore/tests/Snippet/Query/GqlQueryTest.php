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
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\EntityIterator;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Query\GqlQuery;
use Google\Cloud\Datastore\Tests\Unit\ProtoEncodeTrait;
use Google\Cloud\Datastore\V1\Client\DatastoreClient as GapicDatastoreClient;
use Google\Cloud\Datastore\V1\RunQueryRequest;
use Google\Cloud\Datastore\V1\RunQueryResponse;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group datastore
 */
class GqlQueryTest extends SnippetTestCase
{
    use ProphecyTrait;
    use ProtoEncodeTrait;

    private $datastore;
    private $gapicClient;

    public function setUp(): void
    {
        $this->gapicClient = $this->prophesize(GapicDatastoreClient::class);
        $this->datastore = new DatastoreClient([
            'datastoreClient' => $this->gapicClient->reveal()
        ]);
    }

    public function testClass()
    {
        $this->gapicClient->runQuery(Argument::type(RunQueryRequest::class), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(RunQueryResponse::class, [
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
            ]));

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
        parent::setUpBeforeClass();

        return [
            [$this->snippetFromMethod(DatastoreClient::class, 'gqlQuery', $name)],
            [$this->snippetFromClass(GqlQuery::class, $name)]
        ];
    }
}
