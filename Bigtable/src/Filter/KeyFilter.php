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
use Google\Cloud\Bigtable\Filter;
use Google\Cloud\Bigtable\Filter\SimpleFilter;
use Google\Cloud\Bigtable\V2\RowFilter;

/**
 * Construts RowKey related filters.
 */
class KeyFilter
{
    /**
     * @codingStandardsIgnoreStart
     * Matches only cells from rows whose keys satisfy the given [RE2 regex](https://github.com/google/re2/wiki/Syntax).
     * In other words, passes through the entire row when the key matches, and otherwise produces and empty row. Note that, since row keys
     * can contain arbitrary bytes, the `\C` espace sequence must be used if a true wildcard is desired. The `.` character will not match
     * the new line character `\n`, which may be present in a binary key.
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
        return $this->toFilter(Filter::escapeLiteralValue($value));
    }

    /**
     * Matches all cells from a row with `probability`, and matches no cells from the row with
     * probability 1-`probability`.
     *
     * @param double $probability sample size
     * @throws Exception
     */
    public function sample($probability)
    {
        if ($probability < 0) {
            throw new Exception('Probability must be positive');
        }
        if ($probability >= 1.0) {
            throw new Exception('Probability must be less than 1.0');
        }
        $rowFilter = new RowFilter();
        $rowFilter->setRowSampleFilter($probability);
        return new SimpleFilter($rowFilter);
    }

    private function toFilter($value)
    {
        if ($value === null) {
            throw new Exception('Value can`t be null');
        }
        $rowFilter = new RowFilter();
        $rowFilter->setRowKeyRegexFilter($value);
        return new SimpleFilter($rowFilter);
    }
}
