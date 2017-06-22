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

namespace Google\Cloud\Tests\Unit\Spanner;

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
        $range = $this->prophesize(KeyRange::class);
        $range->keyRangeObject()->willReturn('foo');

        $set->addRange($range->reveal());

        $this->assertEquals('foo', $set->keySetObject()['ranges'][0]);
    }

    public function testSetRanges()
    {
        $set = new KeySet;

        $range1 = $this->prophesize(KeyRange::class);
        $range1->keyRangeObject()->willReturn('foo');

        $range2 = $this->prophesize(KeyRange::class);
        $range2->keyRangeObject()->willReturn('bar');

        $ranges = [
            $range1->reveal(),
            $range2->reveal()
        ];

        $set->setRanges($ranges);

        $this->assertEquals('foo', $set->keySetObject()['ranges'][0]);
        $this->assertEquals('bar', $set->keySetObject()['ranges'][1]);
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

    public function testSetMatchAll()
    {
        $set = new KeySet;

        $set->setMatchAll(true);
        $this->assertTrue($set->keySetObject()['all']);

        $set->setMatchAll(false);
        $this->assertFalse(isset($set->keySetObject()['all']));
    }

    public function testRanges()
    {
        $set = new KeySet;
        $range = $this->prophesize(KeyRange::class)->reveal();

        $set->addRange($range);
        $this->assertEquals($range, $set->ranges()[0]);
    }

    public function testKeys()
    {
        $set = new KeySet;
        $key = 'foo';
        $set->addKey($key);

        $this->assertEquals($key, $set->keys()[0]);
    }

    public function testMatchAll()
    {
        $set = new KeySet();
        $this->assertFalse($set->matchAll());

        $set->setMatchAll(true);
        $this->assertTrue($set->matchAll());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidKeys()
    {
        new KeySet(['keys' => 'foo']);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidAll()
    {
        new KeySet(['all' => 1]);
    }
}
