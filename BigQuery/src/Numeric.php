<?php
/**
 * Copyright 2018 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
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
 * [Numeric](https://cloud.google.com/bigquery/docs/reference/standard-sql/data-types#numeric_type).
 *
 * It supports a fixed 38 decimal digits of precision and 9 decimal digits of scale, and values
 * are in the range of -99999999999999999999999999999.999999999 to
 * 99999999999999999999999999999.999999999.
 *
 * Example:
 * ```
 * use Google\Cloud\BigQuery\BigQueryClient;
 *
 * $bigQuery = new BigQueryClient();
 *
 * $numeric = $bigQuery->numeric('99999999999999999999999999999999999999.999999999');
 * ```
 */
class Numeric implements ValueInterface
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
        // 38 or less decimal digits (or none)
        // optional period and 9 or less digits of scale
        $pattern = '/^-?([0-9]{1,38})?(\.([0-9]{1,9})?)?$/';
        if (! preg_match($pattern, $value)) {
            throw new \InvalidArgumentException(
                'Numeric type only allows fixed 38 decimal digits and 9 decimal digits of scale.'
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
        return ValueMapper::TYPE_NUMERIC;
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
