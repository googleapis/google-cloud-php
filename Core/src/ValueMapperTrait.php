<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Core;

/**
 * Provides common value mapping methods.
 */
trait ValueMapperTrait
{
    /**
     * Convert a timestamp (represented as a string or an array) to a Timestamp
     * class with nanosecond support.
     *
     * @deprecated Use {@see Google\Cloud\Core\Timestamp::createFromString()}
     *             or {@see Google\Cloud\Core\Timestamp::createFromArray()}
     *             instead.
     *
     * @param string|array $timestamp The timestamp as a string or an array.
     * @param string $returnType The type to create and return. Any object used
     *        must provide a constructor compatible with {@see Google\Cloud\Core\Timestamp}.
     *        **Defaults to** `Google\Cloud\Core\Timestamp`.
     * @return mixed
     */
    public function createTimestampWithNanos($timestamp, $returnType = Timestamp::class)
    {
        if (is_array($timestamp)) {
            return $returnType::createFromArray($timestamp);
        } else {
            return $returnType::createFromString($timestamp);
        }
    }
}
