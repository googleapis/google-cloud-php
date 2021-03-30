<?php
/**
 * Copyright 2021 Google LLC
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

namespace Google\Cloud\BigQuery;

/**
 * Represents a value with a data type of
 * [BIGNUMERIC](https://cloud.google.com/bigquery/docs/reference/standard-sql/data-types#numeric_type).
 *
 * It supports 76.76 (the 77th digit is partial) decimal digits of precision
 * and 38 decimal digits of scale. Values are in the range of
 * -5.7896044618658097711785492504343953926634992332820282019728792003956564819968E+38
 * to 5.7896044618658097711785492504343953926634992332820282019728792003956564819967E+38.
 *
 * Example:
 * ```
 * use Google\Cloud\BigQuery\BigQueryClient;
 *
 * $bigQuery = new BigQueryClient();
 *
 * $bigNumeric = $bigQuery->bigNumeric('999999999999999999999999999999999999999999999.99999999999999');
 * ```
 */
class BigNumeric implements ValueInterface
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string|int|float $value The NUMERIC value.
     * @throws \InvalidArgumentException
     */
    public function __construct($value)
    {
        $value = (string) $value;
        // allow minus sign at the beginning
        // 77 or less decimal digits (or none)
        // optional period and 38 or less digits of scale
        $pattern = '/^-?([0-9]{1,77})?(\.([0-9]{1,38})?)?$/';
        if (! preg_match($pattern, $value)) {
            throw new \InvalidArgumentException(
                'BigNumeric type only allows fixed 77 decimal digits and 38 decimal digits of scale.'
            );
        }
        $this->value = $value;
    }

    /**
     * Get the underlying value.
     *
     * @return string
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * Get the type.
     *
     * @return string
     */
    public function type()
    {
        return ValueMapper::TYPE_BIGNUMERIC;
    }

    /**
     * Format the value as a string.
     *
     * @return string
     */
    public function formatAsString()
    {
        return $this->value;
    }

    /**
     * Format the value as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }
}
