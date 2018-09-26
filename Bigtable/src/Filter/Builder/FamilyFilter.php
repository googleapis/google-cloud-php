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
 * A builder used to configure column family filters.
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable\Filter;
 *
 * $builder = Filter::family();
 * ```
 */
class FamilyFilter
{
    use RegexTrait;

    /**
     * @var string
     */
    private static $regexSetter = 'setFamilyNameRegexFilter';

    /**
     * Matches only cells from columns whose families satisfy the given
     * [RE2 regex](https://github.com/google/re2/wiki/Syntax).
     * For technical reasons, the regex must not contain the `:` character, even
     * if it is not being used as literal. Note that, since column families
     * cannot contain the new line character `\n`, it is sufficient to use `.`
     * as a full wildcard when matching column family names.
     *
     * Example:
     * ```
     * $familyFilter = $builder->regex('prefix.*');
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
     * Matches only cells from columns whose families match the value.
     *
     * Example:
     * ```
     * $familyFilter = $builder->exactMatch('cf1');
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
}
