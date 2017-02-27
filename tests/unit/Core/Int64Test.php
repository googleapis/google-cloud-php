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

namespace Google\Cloud\Tests\Unit\Core;

use Google\Cloud\Core\Int64;

/**
 * @group core
 */
class Int64Test extends \PHPUnit_Framework_TestCase
{
    public function testGetsValue()
    {
        $int = '123';
        $int64 = new Int64($int);

        $this->assertEquals($int, $int64->get());
    }

    public function testToString()
    {
        $int = '123';
        $int64 = new Int64($int);

        $this->assertEquals($int, (string) $int64);
    }
}
