<?php
/**
 * Copyright 2018 Google Inc.
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
 * Helper methods for formatting and converting Timestamps.
 */
trait TimeTrait
{
    /**
     * Parse a Timestamp string and return a DateTimeImmutable instance and nanoseconds as an integer.
     *
     * @param string $timestamp A string representation of a timestamp, encoded
     *        in RFC 3339 format (YYYY-MM-DDTHH-MM-SS.000000[000]TZ).
     * @return array [\DateTimeImmutable, integer]
     * @throws \InvalidArgumentException If the timestamp string is in an unrecognized format.
     */
    private function parseTimeString($timestamp)
    {
        $nanoRegex = '/\d{4}-\d{1,2}-\d{1,2}T\d{1,2}\:\d{1,2}\:\d{1,2}(?:\.(\d{1,}))?/';

        preg_match($nanoRegex, $timestamp, $matches);
        $subSeconds = isset($matches[1])
            ? $matches[1]
            : '0';

        $timestamp = str_replace('.'. $subSeconds, '.' . substr($subSeconds, 0, 6), $timestamp);

        $template = isset($matches[1])
            ? Timestamp::FORMAT
            : Timestamp::FORMAT_NO_MS;

        $dt = \DateTimeImmutable::createFromFormat($template, str_replace('..', '.', $timestamp));
        if (!$dt) {
            throw new \InvalidArgumentException(sprintf(
                'Could not create a DateTime instance from given timestamp %s.',
                $timestamp
            ));
        }

        $nanos = (int) str_pad($subSeconds, 9, '0', STR_PAD_RIGHT);

        return [$dt, $nanos];
    }

    /**
     * Create a DateTimeImmutable instance from a UNIX timestamp (i.e. seconds since epoch).
     *
     * @param int $seconds The unix timestamp.
     * @return \DateTimeImmutable
     */
    private function createDateTimeFromSeconds($seconds)
    {
        return \DateTimeImmutable::createFromFormat(
            'U',
            (string) $seconds,
            new \DateTimeZone('UTC')
        );
    }

    /**
     * Create a Timestamp string in an API-compatible format.
     *
     * @param \DateTimeInterface $dateTime The date time object.
     * @param int $ns The number of nanoseconds.
     * @return string
     */
    private function formatTimeAsString(\DateTimeInterface $dateTime, $ns)
    {
        $ns = (string) $ns;
        $ns = str_pad($ns, 9, '0', STR_PAD_LEFT) ?: '0';
        if (substr($ns, 6, 3) === '000') {
            $ns = substr($ns, 0, 6);
        }

        $dateTime = $dateTime->setTimeZone(new \DateTimeZone('UTC'));
        $timestamp = sprintf(
            $dateTime->format(Timestamp::FORMAT_INTERPOLATE),
            $ns
        );

        return $timestamp;
    }

    /**
     * Format a timestamp for the API with nanosecond precision.
     *
     * @return array
     */
    private function formatTimeAsArray(\DateTimeInterface $value, $nanoSeconds)
    {
        return [
            'seconds' => (int) $value->format('U'),
            'nanos' => (int) $nanoSeconds
        ];
    }
}
