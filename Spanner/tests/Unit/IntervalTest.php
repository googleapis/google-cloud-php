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

namespace Google\Cloud\Spanner\Tests\Unit;

use Google\Cloud\Spanner\Interval;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @group spanner
 * @group spanner-arraytype
 */
class IntervalTest extends TestCase
{
    /**
     * @dataProvider stringsToParseProvider
     */
    public function testParseString(string $intervalString, string $expected)
    {
        $interval = Interval::parse($intervalString);

        $this->assertEquals($interval->__toString(), $expected);
    }

    public function stringsToParseProvider()
    {
        return [
            ["P-0Y", "P0Y"],
            ["P0Y0M0DT0H0M0S", "P0Y"],
            ["P16M", "P1Y4M"],
            ["P2Y-2M", "P1Y10M"],
            ["P-1Y2M", "P-10M"],
            ["P372D", "P372D"],
            ["P-372D", "P-372D"],
            ["PT7200H", "PT7200H"],
            ["PT1H69M72S", "PT2H10M12S"],
            ["PT1H-5M-2S", "PT54M58S"],
            ["PT0.5S", "PT0.5S"],
            ["PT0.500S", "PT0.5S"],
            ["PT.5S", "PT0.5S"],
            ["P10000Y", "P10000Y"],
            ["P-10000Y", "P-10000Y"],
            ["P120000M", "P10000Y"],
            ["P-120000M", "P-10000Y"],
            ["P3660000D", "P3660000D"],
            ["P-3660000D", "P-3660000D"],
            ["PT316224000000S", "PT87840000H"],
            ["PT-316224000000S", "PT-87840000H"]
        ];
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testThrowsOnInvalidData(string $intervalString)
    {
        $this->expectException(InvalidArgumentException::class);

        Interval::parse($intervalString);
    }

    public function invalidDataProvider()
    {
        return [
            ["P0.5Y"],
            ["P0.5M"],
            ["P0.5D"],
            ["PT0.5H"],
            ["PT0.5M"],
            ["P5S"],
            ["P1Y3S"],
            ["P1YT3M1"],
            ["P1YT3M1.1.4S"],
            [""],
            ["P"],
            ["PT"],
            ["PTS"],
            ["PY"],
            ["PM"],
            ["PD"],
            ["PTH"],
            ["PTM"]
        ];
    }

    /**
     * @dataProvider outOfRangeValuesProvider
     */
    public function testOutOfRangeValues(string $intervalString)
    {
        $this->expectException(InvalidArgumentException::class);

        Interval::parse($intervalString);
    }

    public function outOfRangeValuesProvider()
    {
        return [
            ["P10001Y"],
            ["P-10001Y"],
            ["P120001M"],
            ["P-120001M"],
            ["P3660001D"],
            ["P-3660001D"]
        ];
    }
}
