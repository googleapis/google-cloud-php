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

/**
 * Internal
 */
class IntervalParsingState
{
    public array $afterP;
    public array $afterY;
    public array $afterMonth;
    public array $afterD;

    public array $afterT;
    public array $afterH;
    public array $afterMins;

    /// The index where we'll start to parse next.
    public int $start = 0;

    /// True if we are parsing the time part.
    public bool $isTime = false;

    /// True if we are at a possible terminal state.
    public bool $mayBeTerminal = false;

    /// True if we are a state that must be terminal.
    public bool $isTerminal = false;

    /// True if the provided fractional digits is less or equal to 9.
    public bool $isValidResolution = false;

    /// The delimeters that are allowed next.
    public array|null $nextAllowed;

    // The values we have parsed so far.
    public int $years = 0;
    public int $months = 0;
    public int $days = 0;
    public int $hours = 0;
    public float $minutes = 0;
    public float $seconds = 0;
    public bool $yearsSet = false;
    public bool $monthsSet = false;
    public bool $daysSet = false;

    public function __construct()
    {
        // PHP does not have a Set structure. We are doing this to simulate it
        $this->afterP = array_fill_keys(['Y', 'M', 'D', 'T'], true);
        $this->afterY = array_fill_keys(['M', 'D', 'T'], true);
        $this->afterMonth = array_fill_keys(['D', 'T'], true);
        $this->afterD = array_fill_keys(['T'], true);
        $this->afterT = array_fill_keys(['H', 'M', 'S'], true);
        $this->afterH = array_fill_keys(['M', 'S'], true);
        $this->afterMins = array_fill_keys(['S'], true);
        $this->nextAllowed = array_fill_keys(['P'], true);
    }

    /**
     * Returns the index of the first occurrence of needles on the string
     */
    public static function indexOfAny(string $text, array $nextAllowed, int $start = 0): int
    {
        $splitString = str_split($text);
        foreach (array_splice($splitString, $start) as $index => $letter) {
            if (array_key_exists($letter, $nextAllowed)) {
                return $index + $start;
            }
        }

        return -1;
    }
}
