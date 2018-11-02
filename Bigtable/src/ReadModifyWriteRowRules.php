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

namespace Google\Cloud\Bigtable;

use Google\Cloud\Bigtable\V2\ReadModifyWriteRule;

/**
 * This is a builder class which builds read/modify/write rules specifying how
 * the specified rows contents are to be transformed into writes. Entries are
 * applied in order, meaning that earlier rules will affect the results of later
 * ones. This is intended to be used in combination with
 * {@see Google\Cloud\Bigtable\Table::readModifyWriteRow()}.
 */
class ReadModifyWriteRowRules
{
    /**
     * @var ReadModifyWriteRule[]
     */
    private $rules = [];

    /**
     * Appends the value to the existing value of the cell. If targeted cell is unset,
     * it will be treated as containing the empty string.
     *
     * @param string $familyName Family name of the row.
     * @param string $qualifier Column qualifier of the row.
     * @param string $value Value of the Column qualifier.
     *
     * @return ReadModifyWriteRowRules returns current ReadModifyWriteRowRules object.
     */
    public function append($familyName, $qualifier, $value)
    {
        $this->rules[] = (new ReadModifyWriteRule)
            ->setFamilyName($familyName)
            ->setColumnQualifier($qualifier)
            ->setAppendValue($value);
        return $this;
    }

    /**
     * Adds `amount` to the existing value. If the targeted cell is unset, it will be treated
     * as containing a zero. Otherwise, the targeted cell must containt an 8-byte value (interpreted
     * as a 64-bit big-endian signed integer), or the entire request will fail.
     *
     * @param string $familyName Family name of the row.
     * @param string $qualifier Column qualifier of the row.
     * @param int $amount Amount to add to value of column qualifier.
     *
     * @return ReadModifyWriteRowRules returns current ReadModifyWriteRowRules object.
     */
    public function increment($familyName, $qualifier, $amount)
    {
        $this->rules[] = (new ReadModifyWriteRule)
            ->setFamilyName($familyName)
            ->setColumnQualifier($qualifier)
            ->setIncrementAmount($amount);
        return $this;
    }

    /**
     * Returns proto representation of ReadModifyWriteRule.
     *
     * @internal
     * @access private
     * @return ReadModifyWriteRule[] Returns array of ReadModifyWriteRule rules.
     */
    public function toProto()
    {
        return $this->rules;
    }
}
