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

namespace Google\Cloud\Spanner\Tests\Unit;

use Google\Cloud\Spanner\KeyRange;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group spanner
 */
class KeyRangeTest extends TestCase
{
    use ExpectException;
    use GrpcTestTrait;

    private $range;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $this->range = new KeyRange;
    }

    public function testConstructWithScalars()
    {
        $range = new KeyRange([
            'start' => 'foo',
            'end' => 'bar'
        ]);

        $this->assertEquals(['foo'], $range->start());
        $this->assertEquals(['bar'], $range->end());
    }

    public function testPrefixMatch()
    {
        $key = ['foo'];

        $range = new KeyRange([
            'start' => $key,
            'end' => $key,
            'startType' => KeyRange::TYPE_CLOSED,
            'endType' => KeyRange::TYPE_CLOSED,
        ]);

        $prefixRange = KeyRange::prefixMatch($key);

        $this->assertEquals($range, $prefixRange);
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
        $this->assertEquals(['start' => 'startClosed', 'end' => 'endOpen'], $range->types());
    }

    public function testSetStart()
    {
        $this->range->setStart(KeyRange::TYPE_OPEN, ['foo']);
        $this->assertEquals(['foo'], $this->range->start());
        $this->assertEquals('startOpen', $this->range->types()['start']);
    }

    public function testSetStartInvalidType()
    {
        $this->expectException('InvalidArgumentException');

        $this->range->setStart('foo', ['foo']);
    }

    public function testSetEnd()
    {
        $this->range->setEnd(KeyRange::TYPE_OPEN, ['foo']);
        $this->assertEquals(['foo'], $this->range->end());
        $this->assertEquals('endOpen', $this->range->types()['end']);
    }

    public function testSetEndInvalidType()
    {
        $this->expectException('InvalidArgumentException');

        $this->range->setEnd('foo', ['foo']);
    }

    public function testKeyRangeObject()
    {
        $this->range->setStart(KeyRange::TYPE_OPEN, ['foo']);
        $this->range->setEnd(KeyRange::TYPE_CLOSED, ['bar']);

        $res = $this->range->keyRangeObject();

        $this->assertEquals(['startOpen' => ['foo'], 'endClosed' => ['bar']], $res);
    }

    public function testKeyRangeObjectBadRange()
    {
        $this->expectException('BadMethodCallException');

        $this->range->keyRangeObject();
    }

    /**
     * @dataProvider fromArray
     */
    public function testFromArray($startType, $endType)
    {
        $this->range->setStart($startType, ['foo']);
        $this->range->setEnd($endType, ['bar']);

        $res = $this->range->keyRangeObject();

        $range2 = KeyRange::fromArray($res);
        $obj = $range2->keyRangeObject();

        $this->assertEquals($res, $obj);
        $this->assertEquals(['foo'], $obj[($startType === KeyRange::TYPE_OPEN) ? 'startOpen' : 'startClosed']);
        $this->assertEquals(['bar'], $obj[($endType === KeyRange::TYPE_OPEN) ? 'endOpen' : 'endClosed']);
    }

    public function fromArray()
    {
        return [
            [KeyRange::TYPE_OPEN, KeyRange::TYPE_CLOSED],
            [KeyRange::TYPE_CLOSED, KeyRange::TYPE_OPEN]
        ];
    }
}
