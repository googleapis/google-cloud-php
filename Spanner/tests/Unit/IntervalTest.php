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
            ['P-0Y', 'P0Y'],
            ['P0Y0M0DT0H0M0S', 'P0Y'],
            ['P16M', 'P1Y4M'],
            ['P2Y-2M', 'P1Y10M'],
            ['P-1Y2M', 'P-10M'],
            ['P372D', 'P372D'],
            ['P-372D', 'P-372D'],
            ['PT7200H', 'PT7200H'],
            ['PT1H69M72S', 'PT2H10M12S'],
            ['PT1H-5M-2S', 'PT54M58S'],
            ['PT0.5S', 'PT0.5S'],
            ['PT0.500S', 'PT0.5S'],
            ['PT.5S', 'PT0.5S'],
            ['P10000Y', 'P10000Y'],
            ['P-10000Y', 'P-10000Y'],
            ['P120000M', 'P10000Y'],
            ['P-120000M', 'P-10000Y'],
            ['P3660000D', 'P3660000D'],
            ['P-3660000D', 'P-3660000D'],
            ['PT316224000000S', 'PT87840000H'],
            ['PT-316224000000S', 'PT-87840000H'],
            ['P1Y2M3DT12H12M6.789000123S', 'P1Y2M3DT12H12M6.789000123S'],
            ['P1Y2M3DT13H-48M6S', 'P1Y2M3DT12H12M6S'],
            ['P1Y2M3D', 'P1Y2M3D'],
            ['P1Y2M', 'P1Y2M'],
            ['P1Y', 'P1Y'],
            ['P2M', 'P2M'],
            ['P3D', 'P3D'],
            ['PT4H25M6.7890001S', 'PT4H25M6.7890001S'],
            ['PT4H25M6S', 'PT4H25M6S'],
            ['PT4H30S', 'PT4H30S'],
            ['PT4H1M', 'PT4H1M'],
            ['PT5M', 'PT5M'],
            ['PT6.789S', 'PT6.789S'],
            ['PT0.123S', 'PT0.123S'],
            ['PT.000000123S', 'PT0.000000123S'],
            ['P0Y', 'P0Y'],
            ['P-1Y-2M-3DT-12H-12M-6.789000123S', 'P-1Y-2M-3DT-12H-12M-6.789000123S'],
            ['P1Y-2M3DT13H-51M6.789S', 'P10M3DT12H9M6.789S'],
            ['P-1Y2M-3DT-13H49M-6.789S', 'P-10M-3DT-12H-11M-6.789S'],
            ['P1Y2M3DT-4H25M-6.7890001S', 'P1Y2M3DT-3H-35M-6.7890001S'],
            ['PT100H100M100.5S', 'PT101H41M40.5S'],
            ['P0Y', 'P0Y'],
            ['PT12H30M1S', 'PT12H30M1S'],
            ['P1Y2M3D', 'P1Y2M3D'],
            ['P1Y2M3DT12H30M', 'P1Y2M3DT12H30M'],
            ['PT0.123456789S', 'PT0.123456789S'],
            ['PT1H0.5S', 'PT1H0.5S'],
            ['P1Y2M3DT12H30M1.23456789S', 'P1Y2M3DT12H30M1.23456789S'],
            ['P1Y2M3DT12H30M1,23456789S', 'P1Y2M3DT12H30M1.23456789S'],
            ['P-1Y2M3DT12H-30M1.234S', 'P-10M3DT11H30M1.234S'],
            ['P1Y-2M3DT-12H30M-1.234S', 'P10M3DT-11H-30M-1.234S'],
            ['PT1.234000S', 'PT1.234S'],
            ['PT1.000S', 'PT1S'],
            ['PT87840000H', 'PT87840000H'],
            ['PT-87840000H', 'PT-87840000H'],
            ['P2Y1M15DT87839999H59M59.999999999S', 'P2Y1M15DT87839999H59M59.999934464S'],
            ['P2Y1M15DT-87839999H-59M-59.999999999S', 'P2Y1M15DT-87839999H-59M-59.999934464S']
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
            ['P0.5Y'],
            ['P0.5M'],
            ['P0.5D'],
            ['PT0.5H'],
            ['PT0.5M'],
            ['P5S'],
            ['P1Y3S'],
            ['P1YT3M1'],
            ['P1YT3M1.1.4S'],
            [''],
            ['P'],
            ['PT'],
            ['PTS'],
            ['PY'],
            ['PM'],
            ['PD'],
            ['PTH'],
            ['PTM'],
            ['invalid'],
            ['P'],
            ['PT'],
            ['P1YM'],
            ['P1Y2M3D4H5M6S'],
            ['P1Y2M3DT4H5M6.S'],
            ['P1Y2M3DT4H5M6.789SS'],
            ['P1Y2M3DT4H5M6.'],
            ['P1Y2M3DT4H5M6.ABC'],
            ['P1Y2M3'],
            ['P1Y2M3DT'],
            ['PGARBAGET1H'],
            ['PT1H-'],
            ['P1Y2M3DT4H5M6.789123456789'],
            ['P1Y2M3DT4H5M6.123.456S'],
            ['P1Y2M3DT4H5M6.,789S'],
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
            ['P10001Y'],
            ['P-10001Y'],
            ['P120001M'],
            ['P-120001M'],
            ['P3660001D'],
            ['P-3660001D']
        ];
    }
}
