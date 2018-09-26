<?php
/**
 * Copyright 2018, Google LLC All rights reserved.
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

namespace Google\Cloud\Bigtable\Tests\Snippet;

use Google\Cloud\Bigtable\DataClient;
use Google\Cloud\Bigtable\Filter;
use Google\Cloud\Bigtable\Filter\ChainFilter;
use Google\Cloud\Bigtable\Filter\ConditionFilter;
use Google\Cloud\Bigtable\Filter\InterleaveFilter;
use Google\Cloud\Bigtable\Filter\SimpleFilter;
use Google\Cloud\Bigtable\Filter\TimestampRangeFilter;
use Google\Cloud\Bigtable\Filter\ValueRangeFilter;
use Google\Cloud\Bigtable\V2\RowFilter;
use Google\Cloud\Bigtable\V2\RowFilter\Condition;
use Google\Cloud\Bigtable\V2\RowFilter\Chain;
use Google\Cloud\Bigtable\V2\RowFilter\Interleave;
use Google\Cloud\Bigtable\V2\TimestampRange;
use Google\Cloud\Bigtable\V2\ValueRange;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class FilterTest extends SnippetTestCase
{
    public function testClass()
    {
        $expectedRows = [
            'cf1' => [
                'cq1' => [[
                    'value' => 'value1',
                    'labels' => '',
                    'timeStamp' => 0
                ]]
            ]
        ];
        $dataClient = $this->prophesize(DataClient::class);
        $filter = Filter::chain()
            ->addFilter(Filter::qualifier()->regex('prefix.*'))
            ->addFilter(Filter::limit()->cellsPerRow(10));
        $dataClient->readRows(['filter' => $filter])
            ->shouldBeCalled()
            ->willReturn([$expectedRows]);

        $snippet = $this->snippetFromClass(Filter::class);
        $snippet->replace('$dataClient = new DataClient(\'my-instance\', \'my-table\');', '');
        $snippet->addLocal('dataClient', $dataClient->reveal());
        $res = $snippet->invoke('rows');
        $this->assertEquals(
            print_r($expectedRows, true),
            $res->output()
        );
    }

    public function testChain()
    {
        $snippet = $this->snippetFromMethod(Filter::class, 'chain');
        $res = $snippet->invoke('rowFilter');
        $rowFilter = (new RowFilter)
            ->setChain(
                (new Chain)->setFilters([
                    (new RowFilter)->setColumnQualifierRegexFilter('prefix.*'),
                    (new RowFilter)->setCellsPerRowLimitFilter(10)
                ])
            );
        $this->assertInstanceOf(ChainFilter::class, $res->returnVal());
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }

    public function testInterleave()
    {
        $snippet = $this->snippetFromMethod(Filter::class, 'interleave');
        $res = $snippet->invoke('rowFilter');
        $rowFilter = (new RowFilter)
            ->setInterleave(
                (new Interleave)->setFilters([
                    (new RowFilter)->setRowKeyRegexFilter('prefix.*'),
                    (new RowFilter)->setSink(true)
                ])
            );
        $this->assertInstanceOf(InterleaveFilter::class, $res->returnVal());
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }

    public function testCondition()
    {
        $snippet = $this->snippetFromMethod(Filter::class, 'condition');
        $res = $snippet->invoke('rowFilter');
        $condition = (new Condition)
            ->setPredicateFilter(
                (new RowFilter)->setRowKeyRegexFilter('prefix.*')
            )
            ->setTrueFilter(
                (new RowFilter)->setApplyLabelTransformer('hasPrefix')
            )
            ->setFalseFilter(
                (new RowFilter)->setStripValueTransformer(true)
            );
        $rowFilter = (new RowFilter)->setCondition($condition);
        $this->assertInstanceOf(ConditionFilter::class, $res->returnVal());
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }

    public function testKey()
    {
        $snippet = $this->snippetFromMethod(Filter::class, 'key');
        $res = $snippet->invoke('rowFilter');
        $rowFilter = (new RowFilter)->setRowKeyRegexFilter('prefix.*');
        $this->assertInstanceOf(SimpleFilter::class, $res->returnVal());
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }

    public function testFamily()
    {
        $snippet = $this->snippetFromMethod(Filter::class, 'family');
        $res = $snippet->invoke('rowFilter');
        $rowFilter = (new RowFilter)->setFamilyNameRegexFilter('prefix.*');
        $this->assertInstanceOf(SimpleFilter::class, $res->returnVal());
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }

    public function testQualifier()
    {
        $snippet = $this->snippetFromMethod(Filter::class, 'qualifier');
        $res = $snippet->invoke('rowFilter');
        $rowFilter = (new RowFilter)->setColumnQualifierRegexFilter('prefix.*');
        $this->assertInstanceOf(SimpleFilter::class, $res->returnVal());
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }

    public function testTimestamp()
    {
        $snippet = $this->snippetFromMethod(Filter::class, 'timestamp');
        $res = $snippet->invoke('rowFilter');
        $timestampRange = (new TimestampRange)
            ->setStartTimestampMicros(1536766964380000)
            ->setEndTimestampMicros(1536766964383000);
        $rowFilter = (new RowFilter)->setTimestampRangeFilter($timestampRange);
        $this->assertInstanceOf(TimestampRangeFilter::class, $res->returnVal());
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }

    public function testValue()
    {
        $snippet = $this->snippetFromMethod(Filter::class, 'value');
        $res = $snippet->invoke('rowFilter');
        $valueRange = (new ValueRange)
            ->setStartValueClosed('a')
            ->setEndValueOpen('z');
        $rowFilter = (new RowFilter)->setValueRangeFilter($valueRange);
        $this->assertInstanceOf(ValueRangeFilter::class, $res->returnVal());
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }

    public function testOffset()
    {
        $snippet = $this->snippetFromMethod(Filter::class, 'offset');
        $res = $snippet->invoke('rowFilter');
        $rowFilter = (new RowFilter)->setCellsPerRowOffsetFilter(1);
        $this->assertInstanceOf(SimpleFilter::class, $res->returnVal());
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }

    public function testLimit()
    {
        $snippet = $this->snippetFromMethod(Filter::class, 'limit');
        $res = $snippet->invoke('rowFilter');
        $rowFilter = (new RowFilter)->setCellsPerRowLimitFilter(1);
        $this->assertInstanceOf(SimpleFilter::class, $res->returnVal());
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }

    public function testPass()
    {
        $snippet = $this->snippetFromMethod(Filter::class, 'pass');
        $res = $snippet->invoke('rowFilter');
        $rowFilter = (new RowFilter)->setPassAllFilter(true);
        $this->assertInstanceOf(SimpleFilter::class, $res->returnVal());
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }

    public function testBlock()
    {
        $snippet = $this->snippetFromMethod(Filter::class, 'block');
        $res = $snippet->invoke('rowFilter');
        $rowFilter = (new RowFilter)->setBlockAllFilter(true);
        $this->assertInstanceOf(SimpleFilter::class, $res->returnVal());
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }

    public function testSink()
    {
        $snippet = $this->snippetFromMethod(Filter::class, 'sink');
        $res = $snippet->invoke('rowFilter');
        $rowFilter = (new RowFilter)->setSink(true);
        $this->assertInstanceOf(SimpleFilter::class, $res->returnVal());
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }

    public function testLabel()
    {
        $snippet = $this->snippetFromMethod(Filter::class, 'label');
        $res = $snippet->invoke('rowFilter');
        $rowFilter = (new RowFilter)->setApplyLabelTransformer('my-label');
        $this->assertInstanceOf(SimpleFilter::class, $res->returnVal());
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }
}
