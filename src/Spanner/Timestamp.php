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
class Timestamp implements ValueInterface
{
    const FORMAT = 'Y-m-d\TH:i:s.u\Z';
    const FORMAT_INTERPOLATE = 'Y-m-d\TH:i:s.%\s\Z';

    /**
     * @var \DateTimeInterface
     */
    private $value;

    /**
     * @var int
     */
    private $nanoSeconds;

    /**
     * @param \DateTimeInterface $value The timestamp value.
     * @param int $nanoSeconds [optional] The number of nanoseconds in the timestamp.
     */
    public function __construct(\DateTimeInterface $value, $nanoSeconds = null)
    {
        $this->value = $value;
        $this->nanoSeconds = $nanoSeconds ?: (int) $this->value->format('u');
    }

    /**
     * Get the underlying `\DateTimeInterface` implementation.
     *
     * Please note that nanosecond precision is not present in this method.
     *
     * Example:
     * ```
     * $dateTime = $timestamp->get();
     * ```
     *
     * @return \DateTimeInterface
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
     * $type = $timestamp->type();
     * ```
     *
     * @return string
     */
    public function type()
    {
        return Database::TYPE_TIMESTAMP;
    }

    /**
     * Format the value as a string.
     *
     * This method retains nanosecond precision, if available.
     *
     * Example:
     * ```
     * $value = $timestamp->formatAsString();
     * ```
     *
     * @return string
     */
    public function formatAsString()
    {
        $this->value->setTimezone(new \DateTimeZone('UTC'));
        $ns = str_pad((string) $this->nanoSeconds, 6, '0', STR_PAD_LEFT);
        return sprintf($this->value->format(self::FORMAT_INTERPOLATE), $ns);
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
