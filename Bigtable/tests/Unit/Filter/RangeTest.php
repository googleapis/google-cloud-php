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

namespace Google\Cloud\Bigtable\Tests\Unit\Filter;

use Google\Cloud\Bigtable\Filter\Range;
use Google\Cloud\Core\Testing\TestHelpers;
use PHPUnit\Framework\TestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class RangeTest extends TestCase
{
    private $range;

    public function setUp()
    {
        $this->range = TestHelpers::stub(Range::class);
    }

    public function testClass()
    {
        $this->assertInstanceOf(Range::class, $this->range);
        $this->assertEquals(Range::BOUND_TYPE_UNBOUNDED, $this->range->getStartBound());
        $this->assertEquals(Range::BOUND_TYPE_UNBOUNDED, $this->range->getEndBound());
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Start is unbounded
     */
    public function testGetStartShouldThrow()
    {
        $this->range->getStart();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage End is unbounded
     */
    public function testGetEndShouldThrow()
    {
        $this->range->getEnd();
    }

    public function testStartUnbounded()
    {
        $range = $this->range->startUnbounded();
        $this->assertEquals($this->range, $range);
        $this->assertEquals(Range::BOUND_TYPE_UNBOUNDED, $this->range->getStartBound());
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Start is unbounded
     */
    public function testStartUnboundedShouldThrowOnGetStart()
    {
        $this->range->startUnbounded()->getStart();
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage startOpen accepts only string or numeric types.
     */
    public function testStartOpenShouldThrow()
    {
        $this->range->startOpen(null);
    }

    public function testStartOpen()
    {
        $range = $this->range->startOpen('so1');
        $this->assertEquals($this->range, $range);
        $this->assertEquals(Range::BOUND_TYPE_OPEN, $range->getStartBound());
        $this->assertEquals('so1', $range->getStart());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage startClosed accepts only string or numeric types.
     */
    public function testStartClosedShouldThrow()
    {
        $this->range->startClosed(null);
    }

    public function testStartClosed()
    {
        $range = $this->range->startClosed('sc1');
        $this->assertEquals($this->range, $range);
        $this->assertEquals(Range::BOUND_TYPE_CLOSED, $range->getStartBound());
        $this->assertEquals('sc1', $range->getStart());
    }

    public function testEndUnbounded()
    {
        $range = $this->range->endUnbounded();
        $this->assertEquals($this->range, $range);
        $this->assertEquals(Range::BOUND_TYPE_UNBOUNDED, $range->getEndBound());
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage End is unbounded
     */
    public function testEndUnboundedShouldThrow()
    {
        $this->range->endUnbounded()->getEnd();
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage endOpen accepts only string or numeric types.
     */
    public function testEndOpenShouldThrow()
    {
        $this->range->endOpen(null);
    }

    public function testEndOpen()
    {
        $range = $this->range->endOpen('eo1');
        $this->assertEquals($this->range, $range);
        $this->assertEquals(Range::BOUND_TYPE_OPEN, $range->getEndBound());
        $this->assertEquals('eo1', $range->getEnd());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage endClosed accepts only string or numeric types.
     */
    public function testEndClosedShouldThrow()
    {
        $this->range->endClosed(null);
    }

    public function testEndClosed()
    {
        $range = $this->range->endClosed('ec1');
        $this->assertEquals($this->range, $range);
        $this->assertEquals(Range::BOUND_TYPE_CLOSED, $range->getEndBound());
        $this->assertEquals('ec1', $range->getEnd());
    }

    public function testOf()
    {
        $range = $this->range->of('sc1', 'eo1');
        $this->assertEquals($this->range, $range);
        $this->assertEquals(Range::BOUND_TYPE_CLOSED, $range->getStartBound());
        $this->assertEquals(Range::BOUND_TYPE_OPEN, $range->getEndBound());
    }
}
