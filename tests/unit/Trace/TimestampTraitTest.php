<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Tests\Unit\Trace;

use Google\Cloud\Trace\TimestampTrait;
use PHPUnit\Framework\TestCase;

/**
 * @group trace
 */
class TimestampTraitTest extends TestCase
{
    const EXPECTED_TIMESTAMP_FORMAT = '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}\.\d{9}Z$/';

    /**
     * @dataProvider timestampCases
     */
    public function testFormatDate($expected, $input)
    {
        $obj = new TestTimestampClass();
        $obj->setTime($input);
        $this->assertRegExp(self::EXPECTED_TIMESTAMP_FORMAT, $obj->time());
        if ($expected) {
            $this->assertEquals($expected, $obj->time());
        }
    }

    public function timestampCases()
    {
        return [
            [false, new \DateTime()],
            [false, microtime(true)],
            ['2017-11-28T23:06:59.000000000Z', 1511910419],
            [false, null]
        ];
    }
}

class TestTimestampClass
{
    use TimestampTrait;

    private $time;

    public function setTime($time)
    {
        $this->time = $this->formatDate($time);
    }

    public function time()
    {
        return $this->time;
    }
}
