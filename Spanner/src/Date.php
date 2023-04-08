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
 * [Date](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#google.spanner.v1.TypeCode).
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 *
 * $date = $spanner->date(new \DateTimeImmutable('1995-02-04'));
 * ```
 *
 * ```
 * // Date objects can be cast to strings for easy display.
 * echo (string) $date;
 * ```
 */
class Date implements ValueInterface
{
    const FORMAT = 'Y-m-d';

    /**
     * @var \DateTimeInterface
     */
    protected $value;

    /**
     * @param \DateTimeInterface $value The date value.
     */
    public function __construct(\DateTimeInterface $value)
    {
        $this->value = $value;
    }

    /**
     * Create a Date from integer or string values.
     *
     * Example:
     * ```
     * $date = Date::createFromValues(1995, 02, 04);
     * ```
     *
     * @param int|string $year The year.
     * @param int|string $month The month (as a number).
     * @param int|string $day The day of the month.
     * @return Date
     */
    public static function createFromValues($year, $month, $day)
    {
        $value = sprintf('%s-%s-%s', $year, $month, $day);
        $dt = \DateTimeImmutable::createFromFormat(self::FORMAT, $value);

        return new static($dt);
    }

    /**
     * Get the underlying `\DateTimeInterface` implementation.
     *
     * Example:
     * ```
     * $dateTime = $date->get();
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
     * echo $date->type();
     * ```
     *
     * @return int
     */
    public function type()
    {
        return Database::TYPE_DATE;
    }

    /**
     * Format the value as a string.
     *
     * Example:
     * ```
     * echo $date->formatAsString();
     * ```
     *
     * @return string
     */
    public function formatAsString()
    {
        return $this->value->format(self::FORMAT);
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
