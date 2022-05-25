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
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group bigtable
 * @group bigtabledata
 */
class ConditionFilterTest extends TestCase
{
    use ExpectException;

    private $conditionFilter;
    private $condition;

    public function set_up()
    {
        $this->conditionFilter = new ConditionFilter(Filter::pass());
        $this->condition = new Condition();
        $this->condition->setPredicateFilter(Filter::pass()->toProto());
    }

    /**
     * supply a filter through either
     * Google\Cloud\Bigtable\Filter\ConditionFilter:then()
     * or Google\Cloud\Bigtable\Filter\ConditionFilter:otherwise().
     */
    public function testPredicate()
    {
        $this->expectException('\RuntimeException');
        $this->expectExceptionMessage('In order to utilize a condition filter you must');

        $this->conditionFilter->toProto();
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
