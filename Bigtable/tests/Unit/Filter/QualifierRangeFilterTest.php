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
use Google\Cloud\Bigtable\Filter\QualifierRangeFilter;
use Google\Cloud\Bigtable\V2\ColumnRange;
use Google\Cloud\Bigtable\V2\RowFilter;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class QualifierRangeFilterTest extends TestCase
{
    const FAMILY_NAME = 'cf1';

    private $qualifierRangeFilter;

    public function set_up()
    {
        $this->qualifierRangeFilter = Filter::qualifier()->rangeWithInFamily(self::FAMILY_NAME);
    }

    public function testClass()
    {
        $this->assertInstanceOf(QualifierRangeFilter::class, $this->qualifierRangeFilter);
    }

    public function testToProto()
    {
        $columnRange = new ColumnRange();
        $columnRange->setFamilyName(self::FAMILY_NAME);
        $rowFilter = new RowFilter();
        $rowFilter->setColumnRangeFilter($columnRange);
        $this->assertEquals($rowFilter, $this->qualifierRangeFilter->toProto());
    }

    public function testToProtoClosedRange()
    {
        $this->qualifierRangeFilter->startClosed('sqc1')->endClosed('eqc1');
        $columnRange = new ColumnRange();
        $columnRange->setFamilyName(self::FAMILY_NAME);
        $columnRange->setStartQualifierClosed('sqc1');
        $columnRange->setEndQualifierClosed('eqc1');
        $rowFilter = new RowFilter();
        $rowFilter->setColumnRangeFilter($columnRange);
        $this->assertEquals($rowFilter, $this->qualifierRangeFilter->toProto());
    }

    public function testToProtoOpenRange()
    {
        $this->qualifierRangeFilter->startOpen('sqo1')->endOpen('eqo1');
        $columnRange = new ColumnRange();
        $columnRange->setFamilyName(self::FAMILY_NAME);
        $columnRange->setStartQualifierOpen('sqo1');
        $columnRange->setEndQualifierOpen('eqo1');
        $rowFilter = new RowFilter();
        $rowFilter->setColumnRangeFilter($columnRange);
        $this->assertEquals($rowFilter, $this->qualifierRangeFilter->toProto());
    }
}
