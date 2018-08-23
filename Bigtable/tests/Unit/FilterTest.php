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

namespace Google\Cloud\Bigtable\Tests\Unit;

use Google\Cloud\Bigtable\Filter;
use Google\Cloud\Bigtable\V2\ColumnRange;
use Google\Cloud\Bigtable\V2\RowFilter;
use Google\Cloud\Bigtable\V2\RowFilter\Chain;
use Google\Cloud\Bigtable\V2\RowFilter\Condition;
use Google\Cloud\Bigtable\V2\RowFilter\Interleave;
use Google\Cloud\Bigtable\V2\TimestampRange;
use Google\Cloud\Bigtable\V2\ValueRange;
use PHPUnit\Framework\TestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class FilterTest extends TestCase
{
    private $filter;

    public function setUp()
    {
        $this->filter = Filter::filter();
    }

    public function testFilter()
    {
        $this->assertInstanceOf(Filter::class, $this->filter);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage There are not filters added
     */
    public function testGetOnEmptyFilterShouldThrow()
    {
        $this->filter->get();
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage There are multiple filter. Forgot to call chain or interleave?
     */
    public function testGetWithMoreThanOneFilterWithoutChainOrInterlaveShouldThrow()
    {
        $this->filter->sink()->stripValueTransformer()->get();
    }

    public function testGet()
    {
        $filter = $this->filter->sink()->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
    }

    public function testSinkShouldReturnThis()
    {
        $filter = $this->filter->sink();
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testSinkFilter()
    {
        $rowFilter = new RowFilter;
        $rowFilter->setSink(true);
        $filter = $this->filter->sink()->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testPassAllFilterShouldReturnThis()
    {
        $filter = $this->filter->passAllFilter();
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testPassAllFilter()
    {
        $rowFilter = new RowFilter;
        $rowFilter->setPassAllFilter(true);
        $filter = $this->filter->passAllFilter()->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testBlockAllFilterShouldReturnThis()
    {
        $filter = $this->filter->blockAllFilter();
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testBlockAllFilter()
    {
        $rowFilter = new RowFilter;
        $rowFilter->setBlockAllFilter(true);
        $filter = $this->filter->blockAllFilter()->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testRowKeyFilterShouldReturnThis()
    {
        $filter = $this->filter->rowKey('r1');
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testRowKeyFilter()
    {
        $rowFilter = new RowFilter;
        $rowFilter->setRowKeyRegexFilter('r1');
        $filter = $this->filter->rowKey('r1')->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testRowSampleFilterShouldReturnThis()
    {
        $filter = $this->filter->rowSampleFilter(2.1);
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testRowSampleFilter()
    {
        $rowFilter = new RowFilter;
        $rowFilter->setRowSampleFilter(2.1);
        $filter = $this->filter->rowSampleFilter(2.1)->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testFamilyNameShouldReturnThis()
    {
        $filter = $this->filter->familyName('cf1');
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testFamilyName()
    {
        $rowFilter = new RowFilter;
        $rowFilter->setFamilyNameRegexFilter('cf1');
        $filter = $this->filter->familyName('cf1')->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testColumnRangeShouldReturnThis()
    {
        $filter = $this->filter->columnRange('cf1', 'cq1', 'cq2');
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testColumnRangeOpenStartEnd()
    {
        $columnRange = new ColumnRange;
        $columnRange->setFamilyName('cf1');
        $columnRange->setStartQualifierOpen('cq1');
        $columnRange->setEndQualifierOpen('cq2');
        $rowFilter = new RowFilter;
        $rowFilter->setColumnRangeFilter($columnRange);
        $filter = $this->filter->columnRange('cf1', 'cq1', 'cq2')->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testColumnRangeClosedStartEnd()
    {
        $columnRange = new ColumnRange;
        $columnRange->setFamilyName('cf1');
        $columnRange->setStartQualifierClosed('cq1');
        $columnRange->setEndQualifierClosed('cq2');
        $rowFilter = new RowFilter;
        $rowFilter->setColumnRangeFilter($columnRange);
        $filter = $this->filter->columnRange('cf1', 'cq1', 'cq2', true, true)->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testColumnRangeOpenStartClosedEnd()
    {
        $columnRange = new ColumnRange;
        $columnRange->setFamilyName('cf1');
        $columnRange->setStartQualifierOpen('cq1');
        $columnRange->setEndQualifierClosed('cq2');
        $rowFilter = new RowFilter;
        $rowFilter->setColumnRangeFilter($columnRange);
        $filter = $this->filter->columnRange('cf1', 'cq1', 'cq2', false, true)->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testColumnRangeClosedStartOpenEnd()
    {
        $columnRange = new ColumnRange;
        $columnRange->setFamilyName('cf1');
        $columnRange->setStartQualifierClosed('cq1');
        $columnRange->setEndQualifierOpen('cq2');
        $rowFilter = new RowFilter;
        $rowFilter->setColumnRangeFilter($columnRange);
        $filter = $this->filter->columnRange('cf1', 'cq1', 'cq2', true)->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testTimestampRangeShouldReturnThis()
    {
        $filter = $this->filter->timestampRange(500, 800);
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testTimestampRange()
    {
        $timestampRange = new TimestampRange;
        $timestampRange->setStartTimestampMicros(500);
        $timestampRange->setEndTimestampMicros(800);
        $rowFilter = new RowFilter;
        $rowFilter->setTimestampRangeFilter($timestampRange);
        $filter = $this->filter->timestampRange(500, 800)->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testValueRangeShouldReturnThis()
    {
        $filter = $this->filter->valueRange('v1', 'v2');
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testValueRangeOpenStartEnd()
    {
        $valueRange = new ValueRange;
        $valueRange->setStartValueOpen('v1');
        $valueRange->setEndValueOpen('v2');
        $rowFilter = new RowFilter;
        $rowFilter->setValueRangeFilter($valueRange);
        $filter = $this->filter->valueRange('v1', 'v2')->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testValueRangeClosedStartEnd()
    {
        $valueRange = new ValueRange;
        $valueRange->setStartValueClosed('v1');
        $valueRange->setEndValueClosed('v2');
        $rowFilter = new RowFilter;
        $rowFilter->setValueRangeFilter($valueRange);
        $filter = $this->filter->valueRange('v1', 'v2', true, true)->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testValueRangeOpenStartClosedEnd()
    {
        $valueRange = new ValueRange;
        $valueRange->setStartValueOpen('v1');
        $valueRange->setEndValueClosed('v2');
        $rowFilter = new RowFilter;
        $rowFilter->setValueRangeFilter($valueRange);
        $filter = $this->filter->valueRange('v1', 'v2', false, true)->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testValueRangeClosedStartOpenEnd()
    {
        $valueRange = new ValueRange;
        $valueRange->setStartValueClosed('v1');
        $valueRange->setEndValueOpen('v2');
        $rowFilter = new RowFilter;
        $rowFilter->setValueRangeFilter($valueRange);
        $filter = $this->filter->valueRange('v1', 'v2', true)->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testCellsPerRowOffsetShouldReturnThis()
    {
        $filter = $this->filter->cellsPerRowOffset(3);
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testCellsPerRowOffset()
    {
        $rowFilter = new RowFilter;
        $rowFilter->setCellsPerRowOffsetFilter(3);
        $filter = $this->filter->cellsPerRowOffset(3)->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testCellsPerRowLimitShouldReturnThis()
    {
        $filter = $this->filter->cellsPerRowLimit(2);
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testCellsPerRowLimit()
    {
        $rowFilter = new RowFilter;
        $rowFilter->setCellsPerRowLimitFilter(2);
        $filter = $this->filter->cellsPerRowLimit(2)->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testCellsPerColumnLimitShouldReturnThis()
    {
        $filter = $this->filter->cellsPerColumnLimit(5);
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testCellsPerColumnLimit()
    {
        $rowFilter = new RowFilter;
        $rowFilter->setCellsPerColumnLimitFilter(5);
        $filter = $this->filter->cellsPerColumnLimit(5)->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testStripValueTransformerShouldReturnThis()
    {
        $filter = $this->filter->stripValueTransformer();
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testStripValueTransformer()
    {
        $rowFilter = new RowFilter;
        $rowFilter->setStripValueTransformer(true);
        $filter = $this->filter->stripValueTransformer()->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testApplyLabelTransformerShouldReturnThis()
    {
        $filter = $this->filter->applyLabelTransformer('t1');
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testApplyLabelTransformer()
    {
        $rowFilter = new RowFilter;
        $rowFilter->setApplyLabelTransformer('t1');
        $filter = $this->filter->applyLabelTransformer('t1')->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testConditionShouldReturnThis()
    {
        $filter = $this->filter->condition(
            Filter::filter()->sink()->get(),
            Filter::filter()->sink()->get(),
            Filter::filter()->sink()->get()
        );
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testCondition()
    {
        $predicateRowFilter = new RowFilter;
        $predicateRowFilter->setPassAllFilter(true);
        $trueRowFilter = new RowFilter;
        $trueRowFilter->setBlockAllFilter(true);
        $falseRowFilter = new RowFilter;
        $falseRowFilter->setStripValueTransformer(true);
        $condition = new Condition;
        $condition->setPredicateFilter($predicateRowFilter);
        $condition->setTrueFilter($trueRowFilter);
        $condition->setFalseFilter($falseRowFilter);
        $rowFilter = new RowFilter;
        $rowFilter->setCondition($condition);

        $filter = $this->filter->condition(
            Filter::filter()->passAllFilter()->get(),
            Filter::filter()->blockAllFilter()->get(),
            Filter::filter()->stripValueTransformer()->get()
        )->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testChainShouldReturnThisWithZeroFilter()
    {
        $filter = $this->filter->chain();
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testChainShouldReturnThisWithTwoFilter()
    {
        $filter = $this->filter->sink()->stripValueTransformer()->chain();
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testChainWithOneFilter()
    {
        $rowFilter = new RowFilter;
        $rowFilter->setSink(true);
        $filter = $this->filter->sink()->chain()->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testChainWithTwoFilter()
    {
        $chainFilter1 = new RowFilter;
        $chainFilter1->setSink(true);
        $chainFilter2 = new RowFilter;
        $chainFilter2->setStripValueTransformer(true);
        $chain = new Chain;
        $chain->setFilters([$chainFilter1, $chainFilter2]);
        $rowFilter = new RowFilter;
        $rowFilter->setChain($chain);

        $filter = $this->filter->sink()->stripValueTransformer()->chain()->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testInterleaveShouldReturnThisWithZeroFilter()
    {
        $filter = $this->filter->interleave();
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testInterleaveShouldReturnThisWithTwoFilter()
    {
        $filter = $this->filter->sink()->stripValueTransformer()->interleave();
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testInterleaveWithOneFilter()
    {
        $rowFilter = new RowFilter;
        $rowFilter->setSink(true);
        $filter = $this->filter->sink()->interleave()->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testInterleaveWithTwoFilter()
    {
        $interleaveFilter1 = new RowFilter;
        $interleaveFilter1->setSink(true);
        $interleaveFilter2 = new RowFilter;
        $interleaveFilter2->setStripValueTransformer(true);
        $interleave = new Interleave;
        $interleave->setFilters([$interleaveFilter1, $interleaveFilter2]);
        $rowFilter = new RowFilter;
        $rowFilter->setInterleave($interleave);

        $filter = $this->filter->sink()->stripValueTransformer()->interleave()->get();
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }

    public function testAddFiltersShouldReturnThis()
    {
        $filter = $this->filter->addFilters([Filter::filter()->sink()->get()]);
        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertEquals($this->filter, $filter);
    }

    public function testAddFilterShouldAddToExistingFilter()
    {
        $filter = $this->filter->sink()->addFilters([Filter::filter()->passAllFilter()->get()])->chain()->get();
        $chainFilter1 = new RowFilter;
        $chainFilter1->setSink(true);
        $chainFilter2 = new RowFilter;
        $chainFilter2->setPassAllFilter(true);
        $chain = new Chain;
        $chain->setFilters([$chainFilter1, $chainFilter2]);
        $rowFilter = new RowFilter;
        $rowFilter->setChain($chain);
        $this->assertInstanceOf(RowFilter::class, $filter);
        $this->assertEquals($rowFilter, $filter);
    }
}
