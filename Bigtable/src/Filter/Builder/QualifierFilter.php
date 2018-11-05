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

use Google\Cloud\Bigtable\Filter\QualifierRangeFilter;
use Google\Cloud\Bigtable\Filter\SimpleFilter;
use Google\Cloud\Bigtable\V2\RowFilter;

/**
 * A builder used to configure qualifier based filters.
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable\Filter;
 *
 * $builder = Filter::qualifier();
 * ```
 */
class QualifierFilter
{
    use RegexTrait;

    /**
     * @var string
     */
    private static $regexSetter = 'setColumnQualifierRegexFilter';

    /**
     * Matches only cells from columns whose qualifiers satisfy the given
     * [RE2 regex](https://github.com/google/re2/wiki/Syntax). Note that, since
     * column qualifiers can contain arbitrary bytes, the `\C` escape sequence
     * must be used if a true wildcard is desired. The `.` character will not
     * match the new line character `\n`, which may be present in a binary
     * qualifier.
     *
     * Example:
     * ```
     * $qualifierFilter = $builder->regex('prefix.*');
     * ```
     *
     * @param string $value A regex value.
     * @return SimpleFilter
     */
    public function regex($value)
    {
        return $this->buildRegexFilter($value, self::$regexSetter);
    }

    /**
     * Matches only cells from rows whose keys equal the value. In other words, passes through the
     * entire row when the key matches, and otherwise produces an empty row.
     *
     * Example:
     * ```
     * $qualifierFilter = $builder->exactMatch('cq1');
     * ```
     *
     * @param string $value An exact value.
     * @return SimpleFilter
     * @throws \InvalidArgumentException When the provided value is not an array
     *         or string.
     */
    public function exactMatch($value)
    {
        return $this->buildRegexFilter(
            $this->escapeLiteralValue($value),
            self::$regexSetter
        );
    }

    /**
     * Returns a builder used to configure qualifier range filters.
     *
     * Example:
     * ```
     * $qualifierFilter = $builder->rangeWithinFamily('cf1')
     *     ->of('cq1', 'cq10');
     * ```
     *
     * @param string $family The family name to search within.
     * @return QualifierRangeFilter
     */
    public function rangeWithinFamily($family)
    {
        return new QualifierRangeFilter($family);
    }
}
