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

use Google\Cloud\Bigtable\Filter\Builder\Range;
use Google\Cloud\Bigtable\V2\RowFilter;
use Google\Cloud\Bigtable\V2\ValueRange;

/**
 * Matches only cells with values that fall within the given value range.
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable\Filter;
 *
 * $rangeFilter = Filter::value()
 *     ->range();
 * ```
 */
class ValueRangeFilter extends Range implements FilterInterface
{
    /**
     * Get the proto representation of the filter.
     *
     * @internal
     * @access private
     * @return RowFilter
     */
    public function toProto()
    {
        $valueRange = new ValueRange();

        switch ($this->getStartBound()) {
            case Range::BOUND_TYPE_CLOSED:
                $valueRange->setStartValueClosed($this->getStart());
                break;
            case Range::BOUND_TYPE_OPEN:
                $valueRange->setStartValueOpen($this->getStart());
                break;
            case Range::BOUND_TYPE_UNBOUNDED:
                break;
        }
        switch ($this->getEndBound()) {
            case Range::BOUND_TYPE_CLOSED:
                $valueRange->setEndValueClosed($this->getEnd());
                break;
            case Range::BOUND_TYPE_OPEN:
                $valueRange->setEndValueOpen($this->getEnd());
                break;
            case Range::BOUND_TYPE_UNBOUNDED:
                break;
        }
        $rowFilter = new RowFilter();
        $rowFilter->setValueRangeFilter($valueRange);
        return $rowFilter;
    }
}
