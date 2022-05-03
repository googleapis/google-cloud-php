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

use Google\Cloud\Bigtable\Filter;
use Google\Cloud\Bigtable\Filter\ValueRangeFilter;
use Google\Cloud\Bigtable\V2\ValueRange;
use Google\Cloud\Bigtable\V2\RowFilter;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class ValueRangeFilterTest extends TestCase
{
    private $valueRangeFilter;

    public function set_up()
    {
        $this->valueRangeFilter = new ValueRangeFilter();
    }

    public function testToProto()
    {
        $valueRange = new ValueRange();
        $rowFilter = new RowFilter();
        $rowFilter->setValueRangeFilter($valueRange);
        $this->assertEquals($rowFilter, $this->valueRangeFilter->toProto());
    }

    public function testToProtoClosedRange()
    {
        $this->valueRangeFilter->startClosed('svc1')->endClosed('evc1');
        $valueRange = new ValueRange();
        $valueRange->setStartValueClosed('svc1');
        $valueRange->setEndValueClosed('evc1');
        $rowFilter = new RowFilter();
        $rowFilter->setValueRangeFilter($valueRange);
        $this->assertEquals($rowFilter, $this->valueRangeFilter->toProto());
    }

    public function testToProtoOpenRange()
    {
        $this->valueRangeFilter->startOpen('svo1')->endOpen('evo1');
        $valueRange = new ValueRange();
        $valueRange->setStartValueOpen('svo1');
        $valueRange->setEndValueOpen('evo1');
        $rowFilter = new RowFilter();
        $rowFilter->setValueRangeFilter($valueRange);
        $this->assertEquals($rowFilter, $this->valueRangeFilter->toProto());
    }
}
