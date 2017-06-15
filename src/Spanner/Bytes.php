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

use GuzzleHttp\Psr7;
use Psr\Http\Message\StreamInterface;

/**
 * Represents a value with a data type of
 * [bytes](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#google.spanner.v1.TypeCode).
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 *
 * $bytes = $spanner->bytes('hello world');
 * ```
 *
 * ```
 * // Byte instances can be cast to base64-encoded strings.
 * echo (string) $bytes;
 * ```
 */
class Bytes implements ValueInterface
{
    /**
     * @var string|resource|StreamInterface
     */
    private $value;

    /**
     * @param string|resource|StreamInterface $value The bytes value.
     */
    public function __construct($value)
    {
        $this->value = Psr7\stream_for($value);
    }

    /**
     * Get the bytes as a stream.
     *
     * Example:
     * ```
     * $stream = $bytes->get();
     * ```
     *
     * @return StreamInterface
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * Get the type.
     *
     * Example:
     * ```
     * echo $bytes->type();
     * ```
     *
     * @return string
     */
    public function type()
    {
        return Database::TYPE_BYTES;
    }

    /**
     * Format the value as a string.
     *
     * Example:
     * ```
     * echo $bytes->formatAsString();
     * ```
     *
     * @return string
     */
    public function formatAsString()
    {
        return base64_encode((string) $this->value);
    }

    /**
     * Format the value as a string.
     *
     * @return string
     * @access private
     */
    public function __toString()
    {
        return $this->formatAsString();
    }
}
