<?php
/**
 * Copyright 2018, Google LLC All rights reserved.
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

namespace Google\Cloud\Bigtable\Tests\Unit;

use Google\Cloud\Bigtable\DataUtil;
use PHPUnit\Framework\TestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class DataUtilTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected argument to be of type int, instead got
     */
    public function testIntToByteStringWithString()
    {
        DataUtil::intToByteString('abc');
    }

    public function testIntToByteString()
    {
        $expected = hex2bin("0000000000000002");
        $this->assertEquals($expected, DataUtil::intToByteString(2));
    }

    public function testByteStringToInt()
    {
        $value = DataUtil::byteStringToInt(DataUtil::intToByteString(2));
        $this->assertEquals(2, $value);
    }
}
