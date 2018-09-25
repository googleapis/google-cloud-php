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

namespace Google\Cloud\Bigtable\Filter\Builder;

use Google\Cloud\Bigtable\Filter\SimpleFilter;
use Google\Cloud\Bigtable\V2\RowFilter;

/**
 * A builder used to configure offset based filters.
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable\Filter;
 *
 * $builder = Filter::offset();
 * ```
 */
class OffsetFilter
{
    /**
     * Skips the first N cells of each row, matching all subsequent cells. If
     * duplicate cells are present, as is possible when using an
     * {@see Google\Cloud\Bigtable\Filter\InterleaveFilter}, each copy of the
     * cell is counted separately.
     *
     * Example:
     * ```
     * $limitFilter = $builder->cellsPerRow(2);
     * ```
     *
     * @param int $count The count to offset by.
     * @return SimpleFilter
     */
    public function cellsPerRow($count)
    {
        return new SimpleFilter(
            (new RowFilter)->setCellsPerRowOffsetFilter($count)
        );
    }
}
