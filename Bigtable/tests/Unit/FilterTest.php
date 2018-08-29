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
use Google\Cloud\Bigtable\Filter\ChainFilter;
use Google\Cloud\Bigtable\Filter\ConditionFilter;
use Google\Cloud\Bigtable\Filter\FamilyFilter;
use Google\Cloud\Bigtable\Filter\InterleaveFilter;
use Google\Cloud\Bigtable\Filter\KeyFilter;
use Google\Cloud\Bigtable\Filter\LimitFilter;
use Google\Cloud\Bigtable\Filter\OffsetFilter;
use Google\Cloud\Bigtable\Filter\QualifierFilter;
use Google\Cloud\Bigtable\Filter\SimpleFilter;
use Google\Cloud\Bigtable\Filter\TimestampFilter;
use Google\Cloud\Bigtable\Filter\ValueFilter;
use Google\Cloud\Bigtable\V2\RowFilter;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @group bigtable
 * @group bigtabledata
 */
class FilterTest extends TestCase
{

    public function testChain()
    {
        $chainFilter = Filter::chain();
        $this->assertInstanceOf(ChainFilter::class, $chainFilter);
    }

    public function testInterleave()
    {
        $interleaveFilter = Filter::interleave();
        $this->assertInstanceOf(InterleaveFilter::class, $interleaveFilter);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Predicate filter can`t be null
     */
    public function testConditionShouldThrowOnNullPredicate()
    {
        Filter::condition(null);
    }

    public function testCondition()
    {
        $conditionFilter = Filter::condition(new SimpleFilter(new RowFilter));
        $this->assertInstanceOf(ConditionFilter::class, $conditionFilter);
    }

    public function testKey()
    {
        $keyFilter = Filter::key();
        $this->assertInstanceOf(KeyFilter::class, $keyFilter);
    }

    public function testFamily()
    {
        $familyFilter = Filter::family();
        $this->assertInstanceOf(FamilyFilter::class, $familyFilter);
    }

    public function testQualifier()
    {
        $qualifierFilter = Filter::qualifier();
        $this->assertInstanceOf(QualifierFilter::class, $qualifierFilter);
    }

    public function testTimestamp()
    {
        $timestampFilter = Filter::timestamp();
        $this->assertInstanceOf(TimestampFilter::class, $timestampFilter);
    }

    public function testValue()
    {
        $valueFilter = Filter::value();
        $this->assertInstanceOf(ValueFilter::class, $valueFilter);
    }

    public function testOffset()
    {
        $offsetFilter = Filter::offset();
        $this->assertInstanceOf(OffsetFilter::class, $offsetFilter);
    }

    public function testLimit()
    {
        $limitFilter = Filter::limit();
        $this->assertInstanceOf(LimitFilter::class, $limitFilter);
    }

    public function testPass()
    {
        $passFilter = Filter::pass();
        $this->assertInstanceOf(Filter::class, $passFilter);
        $rowFilter = new RowFilter();
        $rowFilter->setPassAllFilter(true);
        $this->assertEquals($rowFilter, $passFilter->toProto());
    }

    public function testBlock()
    {
        $blockFilter = Filter::block();
        $this->assertInstanceOf(Filter::class, $blockFilter);
        $rowFilter = new RowFilter();
        $rowFilter->setBlockAllFilter(true);
        $this->assertEquals($rowFilter, $blockFilter->toProto());
    }

    public function testSink()
    {
        $sinkFilter = Filter::sink();
        $this->assertInstanceOf(Filter::class, $sinkFilter);
        $rowFilter = new RowFilter();
        $rowFilter->setSink(true);
        $this->assertEquals($rowFilter, $sinkFilter->toProto());
    }

    public function testLable()
    {
        $labelFilter = Filter::label('l1');
        $this->assertInstanceOf(Filter::class, $labelFilter);
        $rowFilter = new RowFilter();
        $rowFilter->setApplyLabelTransformer('l1');
        $this->assertEquals($rowFilter, $labelFilter->toProto());
    }

    public function testEscapeLiteralValueShouldReturnNullOnNull()
    {
        $this->assertEquals(null, Filter::escapeLiteralValue(null));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Expect byte array or string
     */
    public function testEscapeLiteralValueShouldThrowIfNotByteArrayOrString()
    {
        Filter::escapeLiteralValue(new stdClass());
    }

    public function testEscapeLiteralValueAsciiChr()
    {
        $this->assertEquals('hi', Filter::escapeLiteralValue('hi'));
    }

    public function testEscapeLiteralValueWithEscapeChr()
    {
        $this->assertEquals('h\\.\\*i', Filter::escapeLiteralValue('h.*i'));
    }

    public function testEscapeLiteralValueWithByteArray()
    {
        $value = [ 0xe2, 0x80, 0xb3];
        $escapedValue = Filter::escapeLiteralValue($value);
        $expected = implode(array_map("chr", $value));
        $this->assertEquals($expected, $escapedValue);
    }
}
