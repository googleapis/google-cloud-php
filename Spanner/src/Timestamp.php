<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

use Google\Cloud\Core\Timestamp as CoreTimestamp;

/**
 * Represents a value with a data type of
 * [Timestamp](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#google.spanner.v1.TypeCode).
 *
 * Nanosecond precision is preserved by passing nanoseconds as a separate
 * argument to the constructor. If nanoseconds are given, any subsecond
 * precision in the timestamp will be overridden when encoding the timestamp
 * as a string.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 *
 * $timestamp = $spanner->timestamp(new \DateTime('2003-02-05 11:15:02.421827Z'));
 * ```
 *
 * ```
 * // Timestamps can be cast to strings.
 * echo (string) $timestamp;
 * ```
 */
class Timestamp extends CoreTimestamp implements ValueInterface
{
    /**
     * Get the type.
     *
     * Example:
     * ```
     * $type = $timestamp->type();
     * ```
     *
     * @return int
     */
    public function type()
    {
        return Database::TYPE_TIMESTAMP;
    }
}
