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

namespace Google\Cloud\Datastore\Tests\Unit;

use Google\Cloud\Datastore\EntityIterator;
use Google\Cloud\Datastore\EntityPageIterator;
use Google\Cloud\Datastore\V1\ExplainMetrics;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group datastore
 */
class EntityIteratorTest extends TestCase
{
    use ProphecyTrait;

    public function testGetsMoreResultsType()
    {
        $moreResultsType = 'NOT_FINISHED';
        $pageIterator = $this->prophesize(EntityPageIterator::class);
        $pageIterator->moreResultsType()
            ->willReturn($moreResultsType)
            ->shouldBeCalledTimes(1);

        $items = new EntityIterator($pageIterator->reveal());

        $this->assertEquals($moreResultsType, $items->moreResultsType());
    }

    public function testGetExplainMetrics()
    {
        $explainMetrics = [
            'planSummary' => [
                'indexesUsed' => [
                    [
                        'fields' => [
                            'query_scope' => 'Collection group',
                            'properties' => '(done ASC, __name__ ASC)'
                        ]
                    ]
                ]
            ]
        ];

        $pageIterator = $this->prophesize(EntityPageIterator::class);
        $pageIterator->getExplainMetrics()
            ->willReturn($explainMetrics)
            ->shouldBeCalledTimes(1);
        $pageIterator->current()
            ->shouldBeCalledTimes(1);
        $pageIterator->nextResultToken()
            ->willReturn(null)
            ->shouldBeCalled(1);

        $response = new EntityIterator($pageIterator->reveal());

        $expectedMetrics = new ExplainMetrics();
        $expectedMetrics->mergeFromJsonString(json_encode($explainMetrics));
        $metrics = $response->getExplainMetrics();
        $this->assertInstanceOf(ExplainMetrics::class, $metrics);
        $this->assertEquals($expectedMetrics, $metrics);
    }
}
