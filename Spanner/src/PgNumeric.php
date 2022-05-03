<?php
/**
 * Copyright 2022 Google LLC
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

use Google\Cloud\Spanner\V1\TypeAnnotationCode;

/**
 * Represents a value with a data type of
 * [PG Numeric](https://cloud.google.com/spanner/docs/reference/postgresql/data-types) for the
 * Postgres Dialect database.
 *
 * It supports a value precision of up to 131072 digits before the decimal point
 * and up to 16383 digits after the decimal point.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 *
 * $pgNumeric = $spanner->pgNumeric('99999999999999999999999999999999999999.000000999999999');
 * ```
 */
class PgNumeric implements ValueInterface, TypeAnnotationInterface
{
    /**
     * @var string|null
     */
    private $value;

    /**
     * @param string|int|float|null $value The PG_NUMERIC value.
     */
    public function __construct($value)
    {
        // null shouldn't be casted to an empty string
        $value = is_null($value) ? $value : (string) $value;
        $this->value = $value;
    }

    /**
     * Get the underlying value.
     *
     * @return string|null
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * Get the type.
     *
     * @access private
     * @return int
     */
    public function type()
    {
        return ValueMapper::TYPE_NUMERIC;
    }

    /**
     * Get the type annotation code.
     * This is to be used along type, to differentiate the value from TypeCode::NUMERIC.
     *
     * @access private
     * @return int
     */
    public function typeAnnotation()
    {
        return TypeAnnotationCode::PG_NUMERIC;
    }

    /**
     * Format the value as a string.
     *
     * @return string
     */
    public function formatAsString()
    {
        return (string) $this->value;
    }

    /**
     * Format the value as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value;
    }
}
