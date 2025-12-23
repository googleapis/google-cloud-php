<?php
/**
 * Copyright 2025 Google LLC
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
 * [UUID](https://cloud.google.com/spanner/docs/reference/standard-sql/data-types#uuid_type).
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient(['projectId' => 'my-project']);
 *
 * $uuid = $spanner->uuid('f47ac10b-58cc-4372-a567-0e02b2c3d479');
 * ```
 */
class Uuid implements ValueInterface
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value The UUID value.
     * @throws \InvalidArgumentException
     */
    public function __construct(string $value)
    {
        // Canonical UUID format: 8-4-4-4-12 hex digits
        $pattern = '/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$/';
        if (!preg_match($pattern, $value)) {
            throw new \InvalidArgumentException(
                'Invalid UUID format. Expected canonical hexadecimal format: xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'
            );
        }
        $this->value = strtolower($value);
    }

    /**
     * Get the underlying value.
     *
     * @return string
     */
    public function get(): string
    {
        return $this->value;
    }

    /**
     * Get the type.
     *
     * @return int
     */
    public function type(): int
    {
        return Database::TYPE_UUID;
    }

    /**
     * Format the value as a string.
     *
     * @return string
     */
    public function formatAsString(): string
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
