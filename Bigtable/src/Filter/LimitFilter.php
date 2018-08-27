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

use Google\Cloud\Bigtable\Filter\SimpleFilter;
use Google\Cloud\Bigtable\V2\RowFilter;

class LimitFilter
{
    /**
     * Matches only the first N cells of each row. If duplicate cells are present, as is possible
     * when using an Interleave, each copy of the cell is counted separately.
     */
    public function cellsPerRow($count)
    {
        $rowFilter = new RowFilter();
        $rowFilter->setCellsPerRowLimitFilter($count);
        return new SimpleFilter($rowFilter);
    }

    /**
     * Matches only the most recent `count` cells within each column. For example, if count=2, this
     * filter would match column `foo:bar` at timestamps 10 and 9 skip all earlier cells in
     * `foo:bar`, and then begin matching again in column `foo:bar2`. If duplicate cells are
     * present, as is possible when using an {@see InterleaveFilter}, each copy of the cell is
     * counted separately.
     */
    public function cellsPerColumn($count)
    {
        $rowFilter = new RowFilter();
        $rowFilter->setCellsPerColumnLimitFilter($count);
        return new SimpleFilter($rowFilter);
    }
}
