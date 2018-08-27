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
use Google\Cloud\Bigtable\Filter\QualifierRangeFilter;
use Google\Cloud\Bigtable\Filter\SimpleFilter;
use Google\Cloud\Bigtable\V2\RowFilter;

class QualifierFilter
{
    /**
     * @codingStandardsIgnoreStart
     * Matches only cells from columns whose qualifiers satisfy the given [RE2 regex](https://github.com/google/re2/wiki/Syntax).
     * Note that, since column qualifiers can contain arbitrary bytes, the `\C` escape sequence must be used if a true
     * wildcard is desired. The `.` character will not match the new line character `\n`, which may be present in a binary qualifier.
     *
     * @param string $value regex value.
     * @throws Exception
     * @codingStandardsIgnoreEnd
     */
    public function regex($value)
    {
        return $this->toFilter($value);
    }

    /**
     * Matches only cells from rows whose keys equal the value. In other words, passes through the
     * entire row when the key matches, and otherwise produces an empty row.
     *
     * @param string $value exact value
     * @throws Exception
     */
    public function exactMatch($value)
    {
        return $this->toFilter($value);
    }

    /**
     * Construct a {@see QualifierRangeFilter} that can create a {@see Google\Cloud\Bigtable\V2\ColumnRange} oriented
     * {@see Filter}.
     * @param string $family Family name.
     * @return QualifierRangeFilter
     */
    public function rangeWithInFamily($family)
    {
        return new QualifierRangeFilter($family);
    }

    private function toFilter($value)
    {
        if ($value === null) {
            throw new Exception('Value can`t be null');
        }
        $rowFilter = new RowFilter();
        $rowFilter->setColumnQualifierRegexFilter($value);
        return new SimpleFilter($rowFilter);
    }
}
