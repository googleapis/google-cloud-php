<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Core\Tests\Unit;

use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\TimeTrait;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 * @group core-timestamp
 */
class TimestampTest extends TestCase
{
    use TimeTrait;

    private $dt;
    private $ts;

    public function setUp()
    {
        $this->dt = new \DateTime();
        $this->ts = new Timestamp($this->dt);
    }

    public function testGet()
    {
        $this->assertEquals($this->dt, $this->ts->get());
    }

    public function testFormatAsString()
    {
        $this->assertEquals(
            (new \DateTime($this->dt->format(Timestamp::FORMAT)))->format('U'),
            (new \DateTime($this->ts->formatAsString()))->format('U')
        );
    }

    public function testCast()
    {
        $this->assertEquals(
            (new \DateTime($this->dt->format(Timestamp::FORMAT)))->format('U'),
            (new \DateTime((string)$this->ts))->format('U')
        );
    }

    /**
     * @dataProvider timestampStrings
     */
    public function testCreateFromStringTimestampStrings($timestampStr, $expected)
    {
        $time = $this->parseTimeString($timestampStr);
        $timestamp = new Timestamp($time[0], $time[1]);

        $this->assertEquals($expected, $timestamp->formatAsString());
    }

    /**
     * @dataProvider timestampStrings
     */
    public function testCreateFromStringTimestampStringsLocale($timestampStr, $expected)
    {
        setlocale(LC_ALL, 'fr_FR.UTF-8');

        try {
            $time = $this->parseTimeString($timestampStr);
            $timestamp = new Timestamp($time[0], $time[1]);

            $this->assertEquals($expected, $timestamp->formatAsString());
        } finally {
            setlocale(LC_ALL, null);
        }
    }

    public function timestampStrings()
    {
        $today = (new \DateTime)->format('Y-m-d\TH:i:s');
        return [
            [$today . 'Z',              $today . '.000000Z'],
            [$today . '.300000000Z',    $today . '.300000Z'],
            [$today . '.000000003Z',    $today . '.000000003Z'],
            [$today . '.000000000Z',    $today . '.000000Z'],
            [$today . '.0Z',            $today . '.000000Z'],
            [$today . '.1234Z',         $today . '.123400Z'],
            [$today . '.004Z',          $today . '.004000Z'],
            [$today . '.020001000Z',    $today . '.020001Z'],
        ];
    }

    /**
     * @dataProvider timestampNanos
     */
    public function testNanosFromApi(Timestamp $timestamp, $expected)
    {
        $this->assertEquals($expected, $timestamp->formatAsString());
    }

    /**
     * @dataProvider timestampNanos
     */
    public function testNanosFromApiLocale(Timestamp $timestamp, $expected)
    {
        setlocale(LC_ALL, 'fr_FR.UTF-8');
        try {
            $this->assertEquals($expected, $timestamp->formatAsString());
        } finally {
            setlocale(LC_ALL, null);
        }
    }

    public function timestampNanos()
    {
        $dt = new \DateTime;
        $today = $dt->format('Y-m-d\TH:i:s');
        return [
            [new Timestamp($dt, 1),             $today . '.000000001Z'],
            [new Timestamp($dt, 1000),          $today . '.000001Z'],
            [new Timestamp($dt, 100),           $today . '.000000100Z'],
            [new Timestamp($dt, 100000001),     $today . '.100000001Z']
        ];
    }

    /**
     * @dataProvider timestampArrays
     */
    public function testCreateFromStringArrays(array $input)
    {
        $timestamp = new Timestamp(
            $this->createDateTimeFromSeconds($input['seconds']),
            $input['nanos']
        );

        $this->assertEquals($input['seconds'], $timestamp->get()->format('U'));
        $this->assertEquals($input['nanos'], $timestamp->nanoSeconds());
    }

    /**
     * @dataProvider timestampArrays
     */
    public function testCreateFromStringArraysLocale(array $input)
    {
        setlocale(LC_ALL, 'fr_FR.UTF-8');
        try {
            $timestamp = new Timestamp(
                $this->createDateTimeFromSeconds($input['seconds']),
                $input['nanos']
            );

            $this->assertEquals($input['seconds'], $timestamp->get()->format('U'));
            $this->assertEquals($input['nanos'], $timestamp->nanoSeconds());
        } finally {
            setlocale(LC_ALL, null);
        }
    }

    public function timestampArrays()
    {
        return [
            [
                ['seconds' => time(), 'nanos' => 3],
                ['seconds' => time(), 'nanos' => 3000000000],
                ['seconds' => time(), 'nanos' => 3000000001],
                ['seconds' => time(), 'nanos' => 9999999999]
            ]
        ];
    }
}
