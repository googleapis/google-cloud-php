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

use Google\Cloud\Bigtable\V2\RowFilter;
use Google\Cloud\Bigtable\V2\RowFilter\Condition;

/**
 * Evaluates one of two filters, depending on the outcome of the predicate
 * filter.
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable\Filter;
 *
 * $conditionFilter = Filter::condition(Filter::key()->regex('prefix.*'));
 * ```
 */
class ConditionFilter implements FilterInterface
{
    /**
     * @var RowFilter
     */
    private $predicateFilter;

    /**
     * @var RowFilter|null
     */
    private $trueFilter = null;

    /**
     * @var RowFilter|null
     */
    private $falseFilter = null;

    /**
     * @param FilterInterface $predicateFilter A predicate filter.
     */
    public function __construct(FilterInterface $predicateFilter)
    {
        $this->predicateFilter = $predicateFilter->toProto();
    }

    /**
     * Adds a true filter to the condition filter. This filter will be applied
     * if the predicate filter returns any results.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\Filter;
     *
     * $conditionFilter->then(
     *     Filter::label('hasPrefix')
     * );
     * ```
     *
     * @param FilterInterface $trueFilter A filter to be evaluted when the
     *        predicate evalutes to true.
     * @return ConditionFilter
     */
    public function then(FilterInterface $trueFilter)
    {
        $this->trueFilter = $trueFilter->toProto();
        return $this;
    }

    /**
     * Adds a false filter to condition filter. This filter will be applied if
     * the predicate filter does not return results.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\Filter;
     *
     * $conditionFilter->otherwise(
     *     Filter::value()->strip()
     * );
     * ```
     *
     * @param FilterInterface $falseFilter A filter to be evaluated when the
     *        predicate evalutes to false.
     * @return ConditionFilter
     */
    public function otherwise(FilterInterface $falseFilter)
    {
        $this->falseFilter = $falseFilter->toProto();
        return $this;
    }

    /**
     * Get the proto representation of the filter.
     *
     * @internal
     * @access private
     * @return RowFilter
     * @throws \RuntimeException
     */
    public function toProto()
    {
        if ($this->trueFilter === null && $this->falseFilter === null) {
            throw new \RuntimeException(
                sprintf(
                    'In order to utilize a condition filter you must supply a filter through either %s:%s or %s:%s.',
                    self::class,
                    'then()',
                    self::class,
                    'otherwise()'
                )
            );
        }
        $condition = (new Condition)
            ->setPredicateFilter($this->predicateFilter);
        if ($this->trueFilter) {
            $condition->setTrueFilter($this->trueFilter);
        }
        if ($this->falseFilter) {
            $condition->setFalseFilter($this->falseFilter);
        }
        return (new RowFilter)
            ->setCondition($condition);
    }
}
