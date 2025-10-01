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

namespace Google\Cloud\Datastore\Tests\Snippet\Query;

use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Query\AggregationQuery;
use Google\Cloud\Datastore\Query\AggregationQueryResult;
use Google\Cloud\Datastore\Tests\Unit\ProtoEncodeTrait;
use Google\Cloud\Datastore\V1\Client\DatastoreClient as GapicDatastoreClient;
use Google\Cloud\Datastore\V1\RunAggregationQueryRequest;
use Google\Cloud\Datastore\V1\RunAggregationQueryResponse;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group datastore
 */
class AggregationQueryTest extends SnippetTestCase
{
    use ProphecyTrait;
    use ProtoEncodeTrait;

    private $datastore;
    private $gapicClient;
    private $operation;

    public function setUp(): void
    {
        $mapper = new EntityMapper('my-awesome-project', true, false);
        $this->gapicClient = $this->prophesize(GapicDatastoreClient::class);
        $this->datastore = new DatastoreClient([
            'datastoreClient' => $this->gapicClient->reveal()
        ]);
    }

    public function testClass()
    {
        $this->gapicClient->runAggregationQuery(Argument::type(RunAggregationQueryRequest::class), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(RunAggregationQueryResponse::class, [
                'batch' => [
                    'aggregationResults' => [
                        [
                            'aggregateProperties' => [
                                'total' => [
                                    'integerValue' => 200
                                ],
                            ]
                        ]
                    ],
                    'readTime' => (new \DateTime())->format('Y-m-d\TH:i:s') .'.000001Z'
                ]
            ]));

        $snippet = $this->snippetFromClass(AggregationQuery::class);
        $snippet->replace('$datastore = new DatastoreClient();', '');
        $snippet->addLocal('datastore', $this->datastore);

        $res = $snippet->invoke(['query', 'res']);
        $this->assertEquals('200', trim($res->output()));
        $this->assertInstanceOf(AggregationQueryResult::class, $res->returnVal()[1]);
    }

    public function testClassWithOverAggregation()
    {
        $this->gapicClient->runAggregationQuery(Argument::type(RunAggregationQueryRequest::class), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(RunAggregationQueryResponse::class, [
                'batch' => [
                    'aggregationResults' => [
                        [
                            'aggregateProperties' => [
                                'total_upto_100' => [
                                    'integerValue' => 100
                                ],
                            ]
                        ]
                    ],
                    'readTime' => (new \DateTime())->format('Y-m-d\TH:i:s') .'.000001Z'
                ]
            ]));

        $snippet = $this->snippetFromClass(AggregationQuery::class, 1);
        $snippet->replace('$datastore = new DatastoreClient();', '');
        $snippet->addLocal('datastore', $this->datastore);

        $res = $snippet->invoke(['query', 'res']);
        $this->assertEquals('100', trim($res->output()));
        $this->assertInstanceOf(AggregationQueryResult::class, $res->returnVal()[1]);
    }
}
