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

namespace Google\Cloud\Bigtable\Filter;

use Exception;
use Google\Cloud\Bigtable\Filter;
use Google\Cloud\Bigtable\V2\RowFilter;
use Google\Cloud\Bigtable\V2\RowFilter\Condition;

class ConditionFilter extends Filter
{
    /**
     * @var RowFilter
     */
    private $predicateFilter;
    /**
     * @var RowFilter
     */
    private $trueFilter = null;
    /**
     * @var RowFilter
     */
    private $falseFilter = null;

    /**
     * Constructs a ConditionFilter class.
     *
     * @param Filter $predicateFilter Predicate filter for the condition.
     * @throws Exception when $predicateFilter parameter is null.
     */
    public function __construct($predicateFilter)
    {
        if ($predicateFilter === null) {
            throw new Exception('Predicate filter can`t be null');
        }
        $this->predicateFilter = $predicateFilter->toProto();
    }

    /**
     * Adds true filter to the condition flter.
     *
     * @param Filter $trueFilter Filter to be evaluted when predicate evalutes to true.
     * @throws Exception when $trueFilter parameter is null.
     */
    public function then($trueFilter)
    {
        if ($trueFilter === null) {
            throw new Exception('True filter can`t be null');
        }
        $this->trueFilter = $trueFilter->toProto();
        return $this;
    }

    /**
     * Adds false filter to condition filter.
     *
     * @param Filter $falseFilter Filter to be evaluated when predicate evalutes to false.
     * @throws Exception when $falseFilter parameter is null.
     */
    public function otherwise($falseFilter)
    {
        if ($falseFilter === null) {
            throw new Exception('False filter can`t be null');
        }
        $this->falseFilter = $falseFilter->toProto();
        return $this;
    }

    public function toProto()
    {
        if ($this->trueFilter === null && $this->falseFilter === null) {
            throw new Exception('Either TrueFilter or FalseFilter should be provided');
        }
        $condition = new Condition();
        $condition->setPredicateFilter($this->predicateFilter);
        if ($this->trueFilter !== null) {
            $condition->setTrueFilter($this->trueFilter);
        }
        if ($this->falseFilter !== null) {
            $condition->setFalseFilter($this->falseFilter);
        }
        $rowFilter = new RowFilter();
        $rowFilter->setCondition($condition);
        return $rowFilter;
    }
}
