<?php
/**
 * Copyright 2023 Google LLC
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

use Google\Cloud\Core\JsonTrait;
use JsonSerializable;

/**
 * Represents a value with a data type of
 * [JSON](https://cloud.google.com/bigquery/docs/reference/standard-sql/data-types#json_type).
 *
 *
 * Example:
 * ```
 * use Google\Cloud\BigQuery\BigQueryClient;
 *
 * $bigQuery = new BigQueryClient();
 * $json = $bigQuery->json('{}');
 * ```
 */
class Json implements ValueInterface
{
    use JsonTrait;

    /**
     * @var string|null
     */
    private $value;

    /**
     * @param string|JsonSerializable|int|null $value The JSON string value.
     * @throws \InvalidArgumentException
     */
    public function __construct($value)
    {
        // null shouldn't be casted to an empty string
        if (!is_null($value)) {
            if (is_array($value) || $value instanceof JsonSerializable || is_resource($value)) {
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
        return ValueMapper::TYPE_JSON;
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
