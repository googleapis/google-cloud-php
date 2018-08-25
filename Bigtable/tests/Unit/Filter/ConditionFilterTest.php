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

namespace Google\Cloud\Bigtable\Tests\Unit\Filter;

use Google\Cloud\Bigtable\Filter;
use Google\Cloud\Bigtable\Filter\ConditionFilter;
use Google\Cloud\Bigtable\V2\RowFilter;
use Google\Cloud\Bigtable\V2\RowFilter\Condition;
use PHPUnit\Framework\TestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class ConditionFilterTest extends TestCase
{
    private $conditionFilter;
    private $condition;

    public function setUp()
    {
        $this->conditionFilter = Filter::condition(Filter::pass());
        $this->condition = new Condition();
        $this->condition->setPredicateFilter(Filter::pass()->toProto());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Either TrueFilter or FalseFilter should be provided
     */
    public function testPredicate()
    {
        $this->conditionFilter->toProto();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage True filter can`t be null
     */
    public function testThenShouldThrowOnNull()
    {
        $this->conditionFilter->then(null);
    }

    public function testThen()
    {
        $conditionFilter = $this->conditionFilter->then(Filter::block());
        $this->assertEquals($this->conditionFilter, $conditionFilter);
        $this->condition->setTrueFilter(Filter::block()->toProto());
        $rowFilter = new RowFilter();
        $rowFilter->setCondition($this->condition);
        $this->assertEquals($rowFilter, $this->conditionFilter->toProto());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage False filter can`t be null
     */
    public function testOtherwiseShouldThrowOnNull()
    {
        $this->conditionFilter->otherwise(null);
    }

    public function testOtherwise()
    {
        $conditionFilter = $this->conditionFilter->otherwise(Filter::block());
        $this->assertEquals($this->conditionFilter, $conditionFilter);
        $this->condition->setFalseFilter(Filter::block()->toProto());
        $rowFilter = new RowFilter();
        $rowFilter->setCondition($this->condition);
        $this->assertEquals($rowFilter, $this->conditionFilter->toProto());
    }
}
