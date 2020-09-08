<?php
/**
 * Copyright 2020 Google LLC
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

namespace Google\Cloud\Spanner;

/**
 * Represents a value with a data type of
 * [Numeric](https://cloud.google.com/spanner/docs/data-types#numeric_type).
 *
 * It supports a fixed 38 decimal digits of precision and 9 decimal digits of scale, and values
 * are in the range of -99999999999999999999999999999.999999999 to
 * 99999999999999999999999999999.999999999.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 *
 * $numeric = $spanner->numeric('99999999999999999999999999999999999999.999999999');
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
        /**
         * This type supports fixed 38 digits of precision and 9 digits of scale.
         * This number can be optionally prefixed with a plus or minus sign.
         */
        $decimalPattern = '/^[-+]?([0-9]{1,38})?(\.([0-9]{1,9})?)?$/';
        $scientificPattern = '/^[0-9]\.[0-9]{1,37}[Ee][-+][0-9]{1,2}$/';
        if (!preg_match($decimalPattern, $value) && !preg_match($scientificPattern, $value)) {
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
