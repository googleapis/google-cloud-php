<?php
/**
 * Copyright 2025 Google Inc.
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

namespace Google\Cloud\Spanner;

use InvalidArgumentException;

class Interval
{
    private const NANOSECONDS_IN_A_SECOND = 1000000000;
    private const NANOSECONDS_IN_A_MINUTE = Interval::NANOSECONDS_IN_A_SECOND * 60;
    private const NANOSECONDS_IN_AN_HOUR = Interval::NANOSECONDS_IN_A_MINUTE * 60;
    private const NANOSECONDS_IN_A_MILLISECOND = 1000000;
    private const NANOSECONDS_IN_A_MICROSECOND = 1000;
    private const MAX_MONTHS = 120000;
    private const MIN_MONTHS = -Interval::MAX_MONTHS;
    private const MAX_DAYS = 3660000;
    private const MIN_DAYS = -Interval::MAX_DAYS;
    private const MAX_NANOSECONDS = 316224000000000000000;
    private const MIN_NANOSECONDS = -316224000000000000000;

    private int $months;
    private int $days;
    private float $nanoseconds;

    private function __construct(int $months, int $days, float $nanoseconds)
    {
        if ($months > Interval::MAX_MONTHS || $months < Interval::MIN_MONTHS) {
            throw new InvalidArgumentException(
                sprintf(
                    'The interval type supports a range from %s to %s months',
                    Interval::MAX_MONTHS,
                    Interval::MIN_MONTHS
                )
            );
        }
        $this->months = $months;

        if ($days > Interval::MAX_DAYS || $days < Interval::MIN_DAYS) {
            throw new InvalidArgumentException(
                sprintf(
                    'The interval type supports a range from %s to %s days',
                    Interval::MAX_DAYS,
                    Interval::MIN_DAYS
                )
            );
        }
        $this->days = $days;

        if ($nanoseconds > Interval::MAX_NANOSECONDS || $nanoseconds < Interval::MIN_NANOSECONDS) {
            throw new InvalidArgumentException(
                sprintf(
                    'The interval type supports a range from %s to %s nanoseconds',
                    Interval::MAX_NANOSECONDS,
                    Interval::MIN_NANOSECONDS
                )
            );
        }
        $this->nanoseconds = $nanoseconds;
    }

    /**
     * Parses an ISO8601 duration string into an Interval type.
     * The format for the string should be in the format:
     * `P[n]Y[n]M[n]DT[n]H[n]M[n[.fraction]]S`
     * where `n` is an integer.
     *
     * @param string $text The ISO8601 duration string
     *
     * @return Interval
     */
    public static function parse(string $text): Interval
    {
        if (empty($text)) {
            throw new InvalidArgumentException('The given interval is empty.');
        }

        // Interval also accepts decimals delimited with a coma instead of a period.
        $text = str_replace(',', '.', $text);

        $state = new IntervalParsingState();
        $end = -1;

        do {
            $end = $state->indexofAny($text, $state->nextAllowed, $state->start);

            // We couldn't find any of the allowed characters of which we needed to find one.
            if ($end === -1) {
                throw new InvalidArgumentException('Unsupported format');
            }

            // P[n]Y[n]M[n]DT[n]H[n]M[n[.fraction]]S
            switch ($text[$end]) {
                case 'P':
                    $state->mayBeTerminal = false;
                    $state->isTerminal = false;
                    $state->isTime = false;
                    $state->isValidResolution = true;
                    $state->nextAllowed = $state->afterP;
                    break;
                case 'Y':
                    $state->mayBeTerminal = true;
                    $state->isTerminal = false;
                    $state->isValidResolution = true;
                    $state->years = Interval::parseInt(
                        substr($text, $state->start, $end - $state->start)
                    );
                    $state->nextAllowed = $state->afterY;
                    $state->yearsSet = true;
                    break;
                case 'M':
                    if (!$state->isTime) {
                        $state->mayBeTerminal = true;
                        $state->isTerminal = false;
                        $state->isValidResolution = true;
                        $state->months = Interval::parseInt(
                            substr($text, $state->start, $end - $state->start)
                        );
                        $state->nextAllowed = $state->afterMonth;
                        $state->monthsSet = true;
                    } else {
                        $state->mayBeTerminal = true;
                        $state->isTerminal = false;
                        $state->isValidResolution = true;
                        $state->minutes = Interval::parseInt(
                            substr($text, $state->start, $end - $state->start)
                        );
                        $state->nextAllowed = $state->afterMins;
                    }
                    break;
                case 'D':
                    $state->mayBeTerminal = true;
                    $state->isTerminal = false;
                    $state->isValidResolution = true;
                    $state->days = Interval::parseInt(
                        substr($text, $state->start, $end - $state->start)
                    );
                    $state->nextAllowed = $state->afterD;
                    $state->daysSet = true;
                    break;
                case 'T':
                    if ($state->yearsSet == 0 &&
                        $state->monthsSet == 0 &&
                        $state->daysSet == 0 &&
                        $end != 1
                    ) {
                        // This means that there was just garbage before the T and we ignored it
                        // and should be invalid.
                        // If any of the state->set is false, it means that T should be after P
                        // eg: ["PGARBAGET1H"] or ["P-T1H]
                        throw new InvalidArgumentException('Invalid format');
                    }
                    $state->mayBeTerminal = false;
                    $state->isTerminal = false;
                    $state->isTime = true;
                    $state->isValidResolution = true;
                    $state->nextAllowed = $state->afterT;
                    break;
                case 'H':
                    $state->mayBeTerminal = true;
                    $state->isTerminal = false;
                    $state->isValidResolution = true;
                    $state->hours = Interval::parseInt(
                        substr($text, $state->start, $end - $state->start)
                    );
                    $state->nextAllowed = $state->afterH;
                    break;
                case 'S':
                    $state->mayBeTerminal = true;
                    $state->isTerminal = true;
                    $state->isValidResolution = Interval::isValidResolution(
                        substr($text, $state->start, $end - $state->start)
                    );
                    $state->seconds = Interval::parseFloat(
                        substr($text, $state->start, $end - $state->start)
                    );
                    $state->nextAllowed = null;
                    break;
                default:
                    throw new InvalidArgumentException('Invalid format');
            }

            $state->start = $end + 1;
        } while ($state->start < strlen($text) && !$state->isTerminal);

        // We are at a terminal state but we haven't parsed the whole string yet.
        if ($state->isTerminal && $state->start < strlen($text)) {
            throw new InvalidArgumentException('The interval given is not in the correct format.');
        }

        // We parsed the whole string but we ended up at a state that's not terminal.
        if (!$state->mayBeTerminal) {
            throw new InvalidArgumentException('The interval given is not in the correct format.');
        }

        // We do not have a valid precision for the fractional seconds
        if (!$state->isValidResolution) {
            throw new InvalidArgumentException('The interval class only supports a resolution up to nanoseconds');
        }

        $totalMonths = Interval::yearsToMonths($state->years) + $state->months;
        $totalNanoseconds = Interval::hoursToNanoseconds($state->hours) +
            Interval::minutesToNanoseconds($state->minutes) +
            Interval::SecondsToNanoseconds($state->seconds);

        return new Interval($totalMonths, $state->days, $totalNanoseconds);
    }

    public function __toString(): string
    {
        return Interval::intervalToString();
    }

    /**
     * Creates an Interval from months, days and nanoseconds given.
     *
     * @param int $months
     * @param int $days
     * @param float $nanoseconds
     *
     * @return Interval
     */
    public static function fromMonthsDaysNanos(int $months, int $days, float $nanoseconds): Interval
    {
        return new Interval($months, $days, $nanoseconds);
    }

    /**
     * Creates an Interval from the months given.
     *
     * @param int $months
     *
     * @return Interval
     */
    public static function fromMonths(int $months): Interval
    {
        return new Interval($months, 0, 0);
    }

    /**
     * Creates an Interval from the days given.
     *
     * @param int $days
     *
     * @return Interval
     */
    public static function fromDays(int $days): Interval
    {
        return new Interval(0, $days, 0);
    }

    /**
     * Creates an Interval from the seconds given.
     *
     * @param float $seconds
     *
     * @return Interval
     */
    public static function fromSeconds(float $seconds): Interval
    {
        return new Interval(0, 0, $seconds * Interval::NANOSECONDS_IN_A_SECOND);
    }

    /**
     * Creates an Interval from the milliseconds given.
     *
     * @param float $milliseconds
     *
     * @return Interval
     */
    public static function fromMilliseconds(float $milliseconds): Interval
    {
        return new Interval(0, 0, $milliseconds * Interval::NANOSECONDS_IN_A_MILLISECOND);
    }

    /**
     * Creates an Interval from the microseconds given.
     *
     * @param float $microseconds
     *
     * @return Interval
     */
    public static function fromMicroseconds(float $microseconds): Interval
    {
        return new Interval(0, 0, $microseconds * Interval::NANOSECONDS_IN_A_MICROSECOND);
    }

    /**
     * Creates an Interval from the nanoseconds given.
     *
     * @param float $nanoseconds
     *
     * @return Interval
     */
    public static function fromNanoseconds(float $nanoseconds): Interval
    {
        return new Interval(0, 0, $nanoseconds);
    }

    private function intervalToString(): string
    {
        $years = 0;
        $months = 0;
        $days = $this->days;
        $hours = 0;
        $minutes = 0;
        $seconds = 0;
        $remainingNanoseconds = $this->nanoseconds;

        $years = (int) ($this->months / 12);
        $months = $this->months % 12;
        $hours = (int) ($remainingNanoseconds / Interval::NANOSECONDS_IN_AN_HOUR);
        $remainingNanoseconds = fmod($remainingNanoseconds, Interval::NANOSECONDS_IN_AN_HOUR);
        $minutes = (int) ($remainingNanoseconds / Interval::NANOSECONDS_IN_A_MINUTE);
        $remainingNanoseconds = fmod($remainingNanoseconds, Interval::NANOSECONDS_IN_A_MINUTE);
        $seconds = $remainingNanoseconds / Interval::NANOSECONDS_IN_A_SECOND;

        $intervalString = 'P';

        if ($years != 0) {
            $intervalString .= "{$years}Y";
        }

        if ($months != 0) {
            $intervalString .= "{$months}M";
        }

        if ($days != 0) {
            $intervalString .= "{$days}D";
        }

        if ($hours != 0 || $minutes != 0 || $seconds != 0) {
            $intervalString .= 'T';

            if ($hours != 0) {
                $intervalString .= "{$hours}H";
            }

            if ($minutes != 0) {
                $intervalString .= "{$minutes}M";
            }

            if ($seconds != 0) {
                $digits = Interval::secondsToString($seconds);
                $intervalString .= "{$digits}S";
            }
        }

        if ($intervalString == 'P') {
            return 'P0Y';
        }

        return $intervalString;
    }

    private static function secondsToString(int|float $number): string
    {
        if (filter_var($number, FILTER_VALIDATE_INT)) {
            return sprintf('%d', $number);
        }

        return rtrim(sprintf('%.9F', $number), '0');
    }

    private static function yearsToMonths(int $years): int
    {
        return $years * 12;
    }

    private static function hoursToNanoseconds(int $hours): float
    {
        return $hours * Interval::NANOSECONDS_IN_AN_HOUR;
    }

    private static function minutesToNanoseconds(int $minutes): float
    {
        return $minutes * Interval::NANOSECONDS_IN_A_MINUTE;
    }

    private static function secondsToNanoseconds(float $seconds): float
    {
        return $seconds * Interval::NANOSECONDS_IN_A_SECOND;
    }

    private static function parseInt(string $valueString): int
    {
        if (str_contains($valueString, '.') || !is_numeric($valueString)) {
            throw new InvalidArgumentException('Invalid format');
        }
        return intval($valueString);
    }

    private static function parseFloat(string $valueString): float
    {
        if (!is_numeric($valueString)) {
            throw new InvalidArgumentException('Invalid format');
        }
        if ($valueString[-1] == '.') {
            throw new InvalidArgumentException('Invalid format');
        }

        return floatval($valueString);
    }

    private static function isValidResolution(string $textValue): bool
    {
        $splitText = explode('.', $textValue);

        // If we have an int number, it is valid
        if (count($splitText) < 2) {
            return true;
        }

        // If we have more than 9 digits after the decimal, it is not valid
        if (strlen($splitText[1]) > 9) {
            return false;
        }

        return true;
    }
}
