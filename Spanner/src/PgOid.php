<?php
/**
 * Copyright 2023 Google LLC
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
 * [PG OID](https://cloud.google.com/spanner/docs/reference/postgresql/data-types) for the
 * Postgres Dialect database.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 * $pgOid = $spanner->pgOid('123');
 * ```
 */
class PgOid implements ValueInterface, TypeAnnotationInterface
{
    /**
     * @var string|null
     */
    private ?string $value;

    /**
     * @param string|null $value The OID value.
     */
    public function __construct(?string $value)
    {
        $this->value = $value;
    }

    /**
     * Get the underlying value.
     *
     * @return string|null
     */
    public function get(): ?string
    {
        return $this->value;
    }

    /**
     * Get the type.
     *
     * @access private
     * @return int
     */
    public function type(): int
    {
        return ValueMapper::TYPE_INT64;
    }

    /**
     * Get the type annotation code.
     * This is to be used along type, to differentiate the value from TypeCode::INT64.
     *
     * @access private
     * @return int
     */
    public function typeAnnotation(): int
    {
        return TypeAnnotationCode::PG_OID;
    }

    /**
     * Format the value as a string.
     *
     * @return string
     */
    public function formatAsString(): ?string
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
