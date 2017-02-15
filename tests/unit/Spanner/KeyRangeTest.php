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

/**
 * @group spanner
 */
class KeyRangeTest extends \PHPUnit_Framework_TestCase
{
    private $range;

    public function setUp()
    {
        $this->range = new KeyRange;
    }

    public function testGetters()
    {
        $range = new KeyRange([
            'startType' => KeyRange::TYPE_CLOSED,
            'start' => ['foo'],
            'endType' => KeyRange::TYPE_OPEN,
            'end' => ['bar']
        ]);

        $this->assertEquals(['foo'], $range->start());
        $this->assertEquals(['bar'], $range->end());
        $this->assertEquals(['start' => KeyRange::TYPE_CLOSED, 'end' => KeyRange::TYPE_OPEN], $range->types());
    }

    public function testSetStart()
    {
        $this->range->setStart(KeyRange::TYPE_OPEN, ['foo']);
        $this->assertEquals(['foo'], $this->range->start());
        $this->assertEquals(KeyRange::TYPE_OPEN, $this->range->types()['start']);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetStartInvalidType()
    {
        $this->range->setStart('foo', ['foo']);
    }

    public function testSetEnd()
    {
        $this->range->setEnd(KeyRange::TYPE_OPEN, ['foo']);
        $this->assertEquals(['foo'], $this->range->end());
        $this->assertEquals(KeyRange::TYPE_OPEN, $this->range->types()['end']);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetEndInvalidType()
    {
        $this->range->setEnd('foo', ['foo']);
    }

    public function testKeyRangeObject()
    {
        $this->range->setStart(KeyRange::TYPE_OPEN, ['foo']);
        $this->range->setEnd(KeyRange::TYPE_CLOSED, ['bar']);

        $res = $this->range->keyRangeObject();

        $this->assertEquals(['startOpen' => ['foo'], 'endClosed' => ['bar']], $res);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testKeyRangeObjectBadRange()
    {
        $this->range->keyRangeObject();
    }
}
