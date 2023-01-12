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

namespace Google\Cloud\Bigtable\Tests\Unit\Filter\Builder;

use Google\Cloud\Bigtable\Filter\Builder\KeyFilter;
use Google\Cloud\Bigtable\Filter\SimpleFilter;
use Google\Cloud\Bigtable\V2\RowFilter;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group bigtable
 * @group bigtabledata
 */
class KeyFilterTest extends TestCase
{
    use ExpectException;

    private $keyFilter;

    public function set_up()
    {
        $this->keyFilter = new KeyFilter;
    }

    public function testRegex()
    {
        $filter = $this->keyFilter->regex('v1');
        $this->assertInstanceOf(SimpleFilter::class, $filter);
        $rowFilter = new RowFilter();
        $rowFilter->setRowKeyRegexFilter('v1');
        $this->assertEquals($rowFilter, $filter->toProto());
    }

    public function testExactMatch()
    {
        $filter = $this->keyFilter->exactMatch('v1');
        $this->assertInstanceOf(SimpleFilter::class, $filter);
        $rowFilter = new RowFilter();
        $rowFilter->setRowKeyRegexFilter('v1');
        $this->assertEquals($rowFilter, $filter->toProto());
    }

    public function testSampleShouldThrowOnLessThanZero()
    {
        $this->expectException('\InvalidArgumentException');
        $this->expectExceptionMessage('Probability must be positive');

        $this->keyFilter->sample(-1);
    }

    public function testSampleShouldThrowOnGreaterThanOne()
    {
        $this->expectException('\InvalidArgumentException');
        $this->expectExceptionMessage('Probability must be less than 1.0');

        $this->keyFilter->sample(1.1);
    }

    public function testSample()
    {
        $filter = $this->keyFilter->sample(0.9);
        $this->assertInstanceOf(SimpleFilter::class, $filter);
        $rowFilter = new RowFilter();
        $rowFilter->setRowSampleFilter(0.9);
        $this->assertEquals($rowFilter, $filter->toProto());
    }
}
