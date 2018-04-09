<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Core;

/**
 * Represents a Timestamp value.
 *
 * Nanosecond precision is preserved by passing nanoseconds as a separate
 * argument to the constructor. If nanoseconds are given, any subsecond
 * precision in the timestamp will be overridden when encoding the timestamp
 * as a string.
 *
 * Example:
 * ```
 * use Google\Cloud\Core\Timestamp;
 *
 * $timestamp = new Timestamp(new \DateTime('2003-02-05 11:15:02.421827Z'));
 * ```
 *
 * ```
 * // Timestamps can be cast to strings.
 * echo (string) $timestamp;
 * ```
 */
class Timestamp
{
    const FORMAT = 'Y-m-d\TH:i:s.u\Z';
    const FORMAT_INTERPOLATE = 'Y-m-d\TH:i:s.%\s\Z';
    const PRECISION_MICROSECOND = 6;
    const PRECISION_NANOSECOND = 9;

    /**
     * @var \DateTimeInterface
     */
    private $value;

    /**
     * @var int
     */
    private $nanoSeconds;

    /**
     * @var bool
     */
    private $fromDt = false;

    /**
     * @param \DateTimeInterface $value The timestamp value.
     * @param int $nanoSeconds [optional] The number of nanoseconds in the
     *        timestamp. If omitted, subsecond precision will be obtained from
     *        the instance of `\DateTimeInterface` provided in the first
     *        argument. If provided, any precision in `$value` below seconds
     *        will be disregarded.
     */
    public function __construct(\DateTimeInterface $value, $nanoSeconds = null)
    {
        $this->value = $value;

        if ($nanoSeconds !== null) {
            $this->nanoSeconds = (int) $nanoSeconds;
        } else {
            $this->nanoSeconds = (int) $value->format('u') * 1000;
            $this->fromDt = true;
        }
    }

    /**
     * Convert a Timestamp string into a Google Cloud PHP object.
     *
     * Example:
     * ```
     * use Google\Cloud\Core\Timestamp;
     *
     * $timeString = '2018-01-01T23:59:59.000000Z';
     * $timestamp = Timestamp::createFromString($timeString);
     * ```
     *
     * @param string $timestamp A string representation of a point in time.
     * @return Timestamp
     */
    public static function createFromString($timestamp)
    {
        $nanoRegex = '/(?:(\.\d{1,9})Z)|(?:Z)/';

        $matches = [];
        preg_match($nanoRegex, $timestamp, $matches);
        $timestamp = preg_replace($nanoRegex, '.000000Z', $timestamp);

        $dt = \DateTimeImmutable::createFromFormat(static::FORMAT, str_replace('..', '.', $timestamp));

        $nanos = isset($matches[1])
            ? $matches[1] * 1000000000
            : 0;

        return new static($dt, $nanos);
    }

    /**
     * Convert a Timestamp array into a Google Cloud PHP object.
     *
     * Example:
     * ```
     * use Google\Cloud\Core\Timestamp;
     *
     * $timeArray = [
     *     'seconds' => time(),
     *     'nanos' => 0
     * ];
     * $timestamp = Timestamp::createFromArray($timeArray);
     * ```
     *
     * @param array $timestamp An array representation of a point in time.
     * @return Timestamp
     */
    public static function createFromArray(array $timestamp)
    {
        $timestamp += [
            'seconds' => 0,
            'nanos' => 0
        ];

        $dt = \DateTimeImmutable::createFromFormat('U', (string) $timestamp['seconds']);
        $nanos = $timestamp['nanos'];

        return new static($dt, $nanos);
    }

    /**
     * Get the underlying `\DateTimeInterface` implementation.
     *
     * Please note that if you provided nanoseconds when creating the timestamp,
     * they will not be included in this value.
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
     * Return the number of nanoseconds.
     *
     * Example:
     * ```
     * $nanos = $timestamp->nanoSeconds();
     * ```
     *
     * @return int
     */
    public function nanoSeconds()
    {
        return $this->nanoSeconds;
    }

    /**
     * Format the value as a string.
     *
     * Example:
     * ```
     * $value = $timestamp->formatAsString();
     * ```
     *
     * @param int $precision [optional] The maximum precision of the subsecond
     *        portion of the timestamp string. If nanoseconds were not provided
     *        as a separate constructor argument, this option will be
     *        disregarded. **Defaults to `6` (microsecond precision).
     * @return string
     */
    public function formatAsString($precision = self::PRECISION_MICROSECOND)
    {
        $ns = str_pad((string) $this->nanoSeconds, 9, '0', STR_PAD_LEFT) ?: '0';

        // If nanoseconds were obtained from the datetime object, always use μs.
        // PHP datetime only supports micros, so further precision is unnecessary.
        //
        // If nanos were provided separately, we can still safely trim to
        // microsecond precision if the last three digits are zero.
        //
        // Either of these cases take precedent over the user input.
        if ($this->fromDt) {
            $precision = self::PRECISION_MICROSECOND;
        } elseif ((string) substr($ns, strlen($ns) - 3, strlen($ns)) !== '000') {
            $precision = self::PRECISION_NANOSECOND;
        }

        return sprintf(
            $this->value->format(self::FORMAT_INTERPOLATE),
            substr($ns, 0, (int) $precision)
        );
    }

    /**
     * Set the timezone of the underlying DateTime.
     *
     * Example:
     * ```
     * $timestamp->setTimeZone(new \DateTimeZone('America/New_York'));
     * ```
     *
     * @param \DateTimeZone $timezone The timezone to use.
     * @return Timestamp
     */
    public function setTimezone(\DateTimeZone $timezone)
    {
        // use assignment to update possible DateTimeImmutable.
        $this->value = $this->value->setTimezone($timezone);
        return $this;
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

    /**
     * Format a timestamp for the API with nanosecond precision.
     *
     * @return array
     */
    public function formatForApi()
    {
        return [
            'seconds' => (int)$this->value->format('U'),
            'nanos' => (int)$this->nanoSeconds
        ];
    }
}
