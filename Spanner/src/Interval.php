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

use Google\Cloud\Spanner\IntervalParsingState as SpannerIntervalParsingState;
use IntervalParsingState;
use InvalidArgumentException;
use Kreait\Firebase\Exception\Messaging\InvalidArgument;

 class Interval
 {
    private const NANOSECONDSINASECOND = 1000000000;
    private const NANOSECONDSINAMINUTE = Interval::NANOSECONDSINASECOND * 60;
    private const NANOSECONDSINANHOUR = Interval::NANOSECONDSINAMINUTE * 60;
    private const NANOSECONDSINADAY = Interval::NANOSECONDSINANHOUR * 24;
    private const NANOSECONDSINAMONTH = Interval::NANOSECONDSINADAY * 30;
    private const NANOSECONDSINAYEAR = Interval::NANOSECONDSINAMONTH * 12;
    private const NANOSECONDSINAMILLISECOND = 1000000;
    private const NANOSECONDSINAMICROSECOND = 1000;
    private const MAXMONTHS = 120000;
    private const MINMONTHS = -Interval::MAXMONTHS;
    private const MAXDAYS = 3660000;
    private const MINDAYS = -Interval::MAXDAYS;
    private const MAXNANOSECONDS = 316224000000000000000;
    private const MINNANOSECONDS = -316224000000000000000;

    private int $months;
    private int $days;
    private float $nanoseconds;
    private string|null $stringRepresentation = null;

    public function __construct(int $months, int $days, float $nanoseconds)
    {
        if ($months > Interval::MAXMONTHS || $months < Interval::MINMONTHS) {
            throw new InvalidArgumentException('The interval type supports a range from ' . Interval::MAXMONTHS . 'to ' . Interval::MINMONTHS . 'months');
        }
        $this->months = $months;

        if ($days > Interval::MAXDAYS || $days < Interval::MINDAYS) {
            throw new InvalidArgumentException('The interval type supports a range from ' . Interval::MAXDAYS . 'to ' . Interval::MINDAYS . 'days');
        }
        $this->days = $days;

        if ($nanoseconds > Interval::MAXNANOSECONDS || $nanoseconds < Interval::MINNANOSECONDS) {
            throw new InvalidArgumentException('The interval type supports a range from ' . Interval::MAXNANOSECONDS . 'to ' . Interval::MINNANOSECONDS . 'nanoseconds');
        }
        $this->nanoseconds = $nanoseconds;
    }

    public static function parse(string $text) : Interval
    {
        if (empty($text))
        {
            throw new InvalidArgumentException("The given interval is empty.");
        }

        $state = new SpannerIntervalParsingState();
        $end = -1;

        $isValidResolution = function() use ($state, $end, $text) {
            $splitText = substr($state->start, $end - $state->start);
            $splitText = str_replace($splitText, ',', '.');
            $splitText = explode('.', $splitText);

            // If we have an int number, it is valid
            if (count($splitText) < 2)
            {
                return true;
            }

            // If we have more than 9 digits after the decimal, it is not valid
            if (strlen($splitText[1]) > 9)
            {
                return false;
            }

            return true;
        };

        do
        {
            $end = $state->IndexofAny($text, $state->nextAllowed, $state->start); //$text.(state.NextAllowed, state.Start);

            // We couldn't find any of the allowed characters of which we needed to find one.
            if ($end === -1)
            {
                throw new InvalidArgumentException('Unsupported format');
            }
            // P[n]Y[n]M[n]DT[n]H[n]M[n[.fraction]]S
            switch ($text[$end])
            {
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
                    $state->years = Interval::parseInt(substr($text, $state->start, $end - $state->start));
                    $state->nextAllowed = $state->afterY;
                    break;
                case 'M':
                    if (!$state->isTime) {
                        $state->mayBeTerminal = true;
                        $state->isTerminal = false;
                        $state->isValidResolution = true;
                        $state->months = Interval::parseInt(substr($text, $state->start, $end - $state->start));
                        $state->nextAllowed = $state->afterMonth;
                    } else {
                        $state->mayBeTerminal = true;
                        $state->isTerminal = false;
                        $state->isValidResolution = true;
                        $state->minutes = Interval::parseInt(substr($text, $state->start, $end - $state->start));
                        $state->nextAllowed = $state->afterMins;
                    }
                    break;
                case 'D':
                    $state->mayBeTerminal = true;
                    $state->isTerminal = false;
                    $state->isValidResolution = true;
                    $state->days = Interval::parseInt(substr($text, $state->start, $end - $state->start));
                    $state->nextAllowed = $state->afterD;
                    break;
                case 'T':
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
                    $state->hours = Interval::parseInt(substr($text, $state->start, $end - $state->start));
                    $state->nextAllowed = $state->afterH;
                    break;
                case 'S':
                    $state->mayBeTerminal = true;
                    $state->isTerminal = true;
                    $state->isValidResolution = $isValidResolution();
                    $state->seconds = Interval::parseFloat(substr($text, $state->start, $end - $state->start));
                    $state->nextAllowed = null;
                    break;
                default:
                    throw new InvalidArgumentException('Invalid format');
            }

            $state->start = $end + 1;

        } while ($state->start < strlen($text) && !$state->isTerminal);

        // We are at a terminal state but we haven't parsed the whole string yet.
        if ($state->isTerminal && $state->start < strlen($text))
        {
            throw new InvalidArgumentException("The interval given is not in the correct format.");
        }

        // We parsed the whole string but we ended up at a state that's not terminal.
        if (!$state->mayBeTerminal)
        {
            throw new InvalidArgumentException("The interval given is not in the correct format.");
        }

        // We do not have a valid precision for the fractional seconds
        if (!$state->isValidResolution)
        {
            throw new InvalidArgumentException('Invalid interval');
        }

        $totalMonths = Interval::yearsToMonths($state->years) + $state->months;
        $totalNanoseconds = Interval::hoursToNanoseconds($state->hours) + Interval::minutesToNanoseconds($state->minutes) + Interval::SecondsToNanoseconds($state->seconds);

        return new Interval($totalMonths, $state->days, $totalNanoseconds);
    }

    public function __toString() : string
    {
        // I consider that the string conversion is a bit heavy, memoizing it might be useful
        if (is_null($this->stringRepresentation)) {
            $this->stringRepresentation = Interval::intervalToString();
        }

        return $this->stringRepresentation;
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
    public static function fromMonthsDaysNanos(int $months, int $days, float $nanoseconds) : Interval
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
    public static function fromMonths(int $months) : Interval
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
    public static function fromDays(int $days) : Interval
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
    public static function fromSeconds(float $seconds) : Interval
    {
        return new Interval(0, 0, $seconds * Interval::NANOSECONDSINASECOND);
    }

    /**
     * Creates an Interval from the milliseconds given.
     *
     * @param float $milliseconds
     *
     * @return Interval
     */
    public static function fromMilliseconds(float $milliseconds) : Interval
    {
        return new Interval(0, 0, $milliseconds * Interval::NANOSECONDSINAMILLISECOND);
    }

    /**
     * Creates an Interval from the microseconds given.
     *
     * @param float $microseconds
     *
     * @return Interval
     */
    public static function fromMicroseconds(float $microseconds) : Interval
    {
        return new Interval(0, 0, $microseconds * Interval::NANOSECONDSINAMICROSECOND);
    }

    /**
     * Creates an Interval from the nanoseconds given.
     *
     * @param float $nanoseconds
     *
     * @return Interval
     */
    public static function fromNanoseconds(float $nanoseconds) : Interval
    {
        return new Interval(0, 0, $nanoseconds);
    }

    private function intervalToString() : string
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
        $hours = (int) ($remainingNanoseconds / Interval::NANOSECONDSINANHOUR);
        $remainingNanoseconds = fmod($remainingNanoseconds, Interval::NANOSECONDSINANHOUR);
        $minutes = (int) ($remainingNanoseconds / Interval::NANOSECONDSINAMINUTE);
        $remainingNanoseconds = fmod($remainingNanoseconds, Interval::NANOSECONDSINAMINUTE);
        $seconds = $remainingNanoseconds / Interval::NANOSECONDSINASECOND;

        $intervalString = "P";

        if ($years != 0)
        {
            $intervalString .= "{$years}Y";
        }

        if ($months != 0)
        {
            $intervalString .= "{$months}M";
        }

        if ($days != 0)
        {
            $intervalString .= "{$days}D";
        }

        if ($hours != 0 || $minutes != 0 || $seconds != 0)
        {
            $intervalString .= "T";

            if ($hours != 0)
            {
                $intervalString .= "{$hours}H";
            }

            if ($minutes != 0)
            {
                $intervalString .= "{$minutes}M";
            }

            if ($seconds != 0)
            {
                $intervalString .= "{$seconds}S";
            }
        }

        if ($intervalString == "P")
        {
            return "P0Y";
        }

        return $intervalString;
    }

    private static function yearsToMonths(int $years) : int
    {
        return $years * 12;
    }

    private static function hoursTonanoseconds(int $hours) : float
    {
        return $hours * Interval::NANOSECONDSINANHOUR;
    }

    private static function minutesToNanoseconds(int $minutes) : float
    {
        return $minutes * Interval::NANOSECONDSINAMINUTE;
    }

    private static function secondsToNanoseconds(float $seconds) : float
    {
        return $seconds * Interval::NANOSECONDSINASECOND;
    }

    private static function parseInt(string $valueString) : int
    {
        if (str_contains($valueString, '.') || !is_numeric($valueString)) {
            throw new InvalidArgumentException("Invalid format");
        }
        return intval($valueString);
    }

    private static function parseFloat(string $valueString) : float
    {
        if (!is_numeric($valueString)) {
            throw new InvalidArgumentException("Invalid format");
        }
        return floatval($valueString);
    }
 }