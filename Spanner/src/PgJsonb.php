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

use Google\Cloud\Core\JsonTrait;
use Google\Cloud\Spanner\V1\TypeAnnotationCode;
use JsonSerializable;

/**
 * Represents a value with a data type of
 * [PG JSONB](https://cloud.google.com/spanner/docs/reference/postgresql/data-types) for the
 * Postgres Dialect database.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient(['projectId' => 'my-project']);
 * $pgJsonb = $spanner->pgJsonb('{}');
 * ```
 */
class PgJsonb implements ValueInterface, TypeAnnotationInterface
{
    use JsonTrait;

    private string|null $value;

    public function __construct(string|array|JsonSerializable|null $value)
    {
        // null shouldn't be casted to an empty string
        if (!is_null($value)) {
            if (is_array($value) || $value instanceof JsonSerializable) {
                $value = self::jsonEncode($value);
            } else {
                $value = (string) $value;
            }
        }
        $this->value = $value;
    }

    /**
     * Get the underlying value.
     *
     * @return string|null
     */
    public function get(): string|null
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
        return ValueMapper::TYPE_JSON;
    }

    /**
     * Get the type annotation code.
     * This is to be used along type, to differentiate the value from TypeCode::JSON.
     *
     * @access private
     * @return int
     */
    public function typeAnnotation(): int
    {
        return TypeAnnotationCode::PG_JSONB;
    }

    /**
     * Format the value as a string.
     *
     * @return string
     */
    public function formatAsString(): string
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
