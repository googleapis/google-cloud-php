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
 * A trait used to assist in the building of filters which utilize regular
 * expressions.
 *
 * @internal
 */
trait RegexTrait
{
    /**
     * @param string $value A regex value.
     * @param string $setter The name of the setter used to assign the provided
     *        regex to the RowFilter instance.
     * @return SimpleFilter
     */
    private function buildRegexFilter($value, $setter)
    {
        return new SimpleFilter(
            (new RowFilter)->$setter($value)
        );
    }

    /**
     * @param array|string $value
     * @return string
     * @throws \InvalidArgumentException When the provided value is not a string
     *         or array.
     */
    private function escapeLiteralValue($value)
    {
        if ($value === null) {
            return;
        }
        $nullBytes = unpack('C*', '\\x00');
        $byteValue = null;
        if (is_array($value)) {
            $byteValue = $value;
        } elseif (is_string($value)) {
            if (preg_match('//u', $value)) {
                $byteValue = unpack('C*', $value);
            } else {
                $byteValue = unpack('C*', utf8_encode($value));
            }
        } else {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expected byte array or string, instead got \'%s\'.',
                    gettype($value)
                )
            );
        }
        $quotedBytes = [];
        foreach ($byteValue as $byte) {
            if (($byte < ord('a') || $byte > ord('z'))
                && ($byte < ord('A') || $byte > ord('Z'))
                && ($byte < ord('0') || $byte > ord('9'))
                && $byte != ord('_')
                && ($byte & 128) == 0
            ) {
                if ($byte == 0) {
                    $quotedBytes = array_merge($quotedBytes, $nullBytes);
                    continue;
                }
                $quotedBytes[] = ord('\\');
            }
            $quotedBytes[] = $byte;
        }
        return implode(array_map('chr', $quotedBytes));
    }
}
