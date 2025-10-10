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
     *        in RFC 3339 format (YYYY-MM-DDTHH:MM:SS.000000[000]TZ).
     * @return array [\DateTimeImmutable, int]
     * @throws \Exception If the timestamp string is in an unrecognized format.
     */
    private function parseTimeString($timestamp)
    {
        $nanoRegex = '/\d{4}-\d{1,2}-\d{1,2}T\d{1,2}\:\d{1,2}\:\d{1,2}(?:\.(\d{1,}))?/';

        preg_match($nanoRegex, $timestamp, $matches);
        $subSeconds = $matches[1] ?? '0';

        if (strlen($subSeconds) > 6) {
            $timestamp = str_replace('.' . $subSeconds, '.' . substr($subSeconds, 0, 6), $timestamp);
        }

        $dt = new \DateTimeImmutable($timestamp);

        $nanos = $this->convertFractionToNanoSeconds($subSeconds);

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
     * @param int|null $ns The number of nanoseconds. If null, subseconds from
     *        $dateTime will be used instead.
     * @return string
     */
    private function formatTimeAsString(\DateTimeInterface $dateTime, $ns)
    {
        if (!$dateTime instanceof \DateTimeImmutable) {
            $dateTime = clone $dateTime;
        }
        $dateTime = $dateTime->setTimeZone(new \DateTimeZone('UTC'));
        if ($ns === null) {
            return $dateTime->format(Timestamp::FORMAT);
        }

        return sprintf(
            $dateTime->format(Timestamp::FORMAT_INTERPOLATE),
            $this->convertNanoSecondsToFraction($ns)
        );
    }

    /**
     * Format a timestamp for the API with nanosecond precision.
     *
     * @param \DateTimeInterface $dateTime The date time object.
     * @param int|null $ns The number of nanoseconds. If null, subseconds from
     *        $dateTime will be used instead.
     * @return array
     */
    private function formatTimeAsArray(\DateTimeInterface $dateTime, $ns = null)
    {
        if ($ns === null) {
            $ns = $this->convertFractionToNanoSeconds($dateTime->format('u'));
        }
        return [
            'seconds' => (int) $dateTime->format('U'),
            'nanos' => (int) $ns
        ];
    }

    /**
     * Convert subseconds, expressed as a decimal to nanoseconds.
     *
     * @param int|string $subseconds Provide value as a whole number (i.e.
     *     provide 0.1 as 1).
     * @return int
     */
    private function convertFractionToNanoSeconds($subseconds)
    {
        return (int) str_pad($subseconds, 9, '0', STR_PAD_RIGHT);
    }

    /**
     * Convert nanoseconds to subseconds.
     *
     * Note that result should be used as a fraction of one second, but is
     * given as an integer.
     *
     * @param int|string $nanos
     * @param bool $rpad Whether to right-pad to 6 or 9 digits. **Defaults to**
     *     `true`.
     * @return string
     */
    private function convertNanoSecondsToFraction($nanos, $rpad = true)
    {
        $nanos = (string) $nanos;
        $res = str_pad($nanos, 9, '0', STR_PAD_LEFT);
        if (substr($res, 6, 3) === '000') {
            $res = substr($res, 0, 6);
        }

        if (!$rpad) {
            $res = rtrim($res, '0');
        }

        return $res;
    }
}
