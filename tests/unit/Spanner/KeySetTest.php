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

namespace Google\Cloud\Tests\Spanner;

use Google\Cloud\Spanner\KeyRange;
use Google\Cloud\Spanner\KeySet;

/**
 * @group spanner
 */
class KeySetTest extends \PHPUnit_Framework_TestCase
{
    public function testAddRange()
    {
        $set = new KeySet;
        $range = new KeyRange(['setStartOpen' => 'foo']);

        $set->addRange($range);

        $this->assertEquals($range->keyRangeObject(), $set->keySetObject()['ranges'][0]);
    }

    public function testSetRanges()
    {
        $set = new KeySet;

        $ranges = [
            new KeyRange(['setStartOpen' => 'foo']),
            new KeyRange(['setStartOpen' => 'bar']),
        ];

        $set->setRanges($ranges);

        $expected = [];
        foreach ($ranges as $r) {
            $expected[] = $r->keyRangeObject();
        }

        $this->assertEquals($expected, $set->keySetObject()['ranges']);
    }

    public function testAddKey()
    {
        $set = new KeySet;

        $key = 'key';

        $set->addKey($key);

        $this->assertEquals($key, $set->keySetObject()['keys'][0]);
    }

    public function testSetKeys()
    {
        $set = new KeySet;

        $keys = ['key1','key2'];

        $set->setKeys($keys);

        $this->assertEquals($keys, $set->keySetObject()['keys']);
    }

    public function testSetAll()
    {
        $set = new KeySet;

        $set->setAll(true);
        $this->assertTrue($set->keySetObject()['all']);

        $set->setAll(false);
        $this->assertFalse($set->keySetObject()['all']);
    }
}
