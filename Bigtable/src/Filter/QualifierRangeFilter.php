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
use Google\Cloud\Bigtable\V2\ColumnRange;
use Google\Cloud\Bigtable\V2\RowFilter;

/**
 * Matches only cells from columns within the given range.
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable\Filter;
 *
 * $rangeFilter = Filter::qualifier()
 *     ->rangeWithinFamily('cf1');
 * ```
 */
class QualifierRangeFilter extends Range implements FilterInterface
{
    /**
     * @var string
     */
    private $family;

    /**
     * @param string $family The family name to search within.
     */
    public function __construct($family)
    {
        parent::__construct();
        $this->family = $family;
    }

    /**
     * Get the proto representation of the filter.
     *
     * @internal
     * @access private
     * @return RowFilter
     */
    public function toProto()
    {
        $columnRange = new ColumnRange();
        $columnRange->setFamilyName($this->family);

        switch ($this->getStartBound()) {
            case Range::BOUND_TYPE_CLOSED:
                $columnRange->setStartQualifierClosed($this->getStart());
                break;
            case Range::BOUND_TYPE_OPEN:
                $columnRange->setStartQualifierOpen($this->getStart());
                break;
            case Range::BOUND_TYPE_UNBOUNDED:
                break;
        }
        switch ($this->getEndBound()) {
            case Range::BOUND_TYPE_CLOSED:
                $columnRange->setEndQualifierClosed($this->getEnd());
                break;
            case Range::BOUND_TYPE_OPEN:
                $columnRange->setEndQualifierOpen($this->getEnd());
                break;
            case Range::BOUND_TYPE_UNBOUNDED:
                break;
        }
        $rowFilter = new RowFilter();
        $rowFilter->setColumnRangeFilter($columnRange);
        return $rowFilter;
    }
}
