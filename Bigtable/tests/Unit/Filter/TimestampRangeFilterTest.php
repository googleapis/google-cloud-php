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

use Google\Cloud\Bigtable\Filter\TimestampRangeFilter;
use Google\Cloud\Bigtable\V2\TimestampRange;
use Google\Cloud\Bigtable\V2\RowFilter;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class TimestampRangeFilterTest extends TestCase
{
    private $timestampRangeFilter;

    public function set_up()
    {
        $this->timestampRangeFilter = new TimestampRangeFilter();
    }

    public function testToProto()
    {
        $timestampRange = new TimestampRange();
        $rowFilter = new RowFilter();
        $rowFilter->setTimestampRangeFilter($timestampRange);
        $this->assertEquals($rowFilter, $this->timestampRangeFilter->toProto());
    }

    public function testToProtoOpenRange()
    {
        $this->timestampRangeFilter->startOpen(1)->endOpen(5);
        $timestampRange = new TimestampRange();
        $timestampRange->setStartTimestampMicros(2);
        $timestampRange->setEndTimestampMicros(5);
        $rowFilter = new RowFilter();
        $rowFilter->setTimestampRangeFilter($timestampRange);
        $this->assertEquals($rowFilter, $this->timestampRangeFilter->toProto());
    }

    public function testToProtoClosedRange()
    {
        $this->timestampRangeFilter->startClosed(1)->endClosed(5);
        $timestampRange = new TimestampRange();
        $timestampRange->setStartTimestampMicros(1);
        $timestampRange->setEndTimestampMicros(6);
        $rowFilter = new RowFilter();
        $rowFilter->setTimestampRangeFilter($timestampRange);
        $this->assertEquals($rowFilter, $this->timestampRangeFilter->toProto());
    }
}
