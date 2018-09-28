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
 * A builder used to configure row key related filters.
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable\Filter;
 *
 * $builder = Filter::key();
 * ```
 */
class KeyFilter
{
    use RegexTrait;

    /**
     * @var string
     */
    private static $regexSetter = 'setRowKeyRegexFilter';

    /**
     * Matches only cells from rows whose keys satisfy the given
     * [RE2 regex](https://github.com/google/re2/wiki/Syntax). In other words,
     * passes through the entire row when the key matches, and otherwise
     * produces an empty row. Note that, since row keys can contain arbitrary
     * bytes, the `\C` escape sequence must be used if a true wildcard is
     * desired. The `.` character will not match the new line character `\n`,
     * which may be present in a binary key.
     *
     * Example:
     * ```
     * $keyFilter = $builder->regex('prefix.*');
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
     * Matches only cells from rows whose keys equal the value. In other words,
     * passes through the entire row when the key matches, and otherwise
     * produces an empty row.
     *
     * Example:
     * ```
     * $keyFilter = $builder->exactMatch('r1');
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
     * Matches all cells from a row with `probability`, and matches no cells
     * from the row with probability 1-`probability`.
     *
     * Example:
     * ```
     * $keyFilter = $builder->sample(.7);
     * ```
     *
     * @param float $probability The probability to filter by. Must be within
     *        the range [0, 1], end points excluded.
     * @return SimpleFilter
     * @throws \InvalidArgumentException When the probability does not fall
     *         within the acceptable range.
     */
    public function sample($probability)
    {
        if ($probability < 0) {
            throw new \InvalidArgumentException('Probability must be positive');
        }
        if ($probability >= 1.0) {
            throw new \InvalidArgumentException('Probability must be less than 1.0');
        }

        return new SimpleFilter(
            (new RowFilter)->setRowSampleFilter($probability)
        );
    }
}
