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
use Google\Cloud\Bigtable\Filter\ValueRangeFilter;
use Google\Cloud\Bigtable\V2\RowFilter;

/**
 * A builder used to configure value based filters.
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable\Filter;
 *
 * $builder = Filter::value();
 * ```
 */
class ValueFilter
{
    use RegexTrait;

    /**
     * @var string
     */
    private static $regexSetter = 'setValueRegexFilter';

    /**
     * Matches only cells with values that satisfy the given
     * [RE2 regex](https://github.com/google/re2/wiki/Syntax). Note that, since
     * cell values can contain arbitrary bytes, the `\C` escape sequence must be
     * used if a true wildcard is desired. The `.` character will not match the
     * new line character `\n`, which may be present in a binary value.
     *
     * Example:
     * ```
     * $valueFilter = $builder->regex('prefix.*');
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
     * Matches only cells with values that match the given value.
     *
     * Example:
     * ```
     * $valueFilter = $builder->exactMatch('value1');
     * ```
     *
     * @param string $value An exact value to match.
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
     * Returns a builder used to configure value range filters.
     *
     * Example:
     * ```
     * $valueFilter = $builder->range()
     *     ->of('value1', 'value10');
     * ```
     *
     * @return ValueRangeFilter
     */
    public function range()
    {
        return new ValueRangeFilter();
    }

    /**
     * Replaces each cell's value with an empty string.
     *
     * @return SimpleFilter
     */
    public function strip()
    {
        return new SimpleFilter(
            (new RowFilter)->setStripValueTransformer(true)
        );
    }
}
