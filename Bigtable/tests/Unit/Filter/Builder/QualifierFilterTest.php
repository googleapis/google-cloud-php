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

use Google\Cloud\Bigtable\Filter\Builder\QualifierFilter;
use Google\Cloud\Bigtable\Filter\QualifierRangeFilter;
use Google\Cloud\Bigtable\Filter\SimpleFilter;
use Google\Cloud\Bigtable\V2\RowFilter;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class QualifierFilterTest extends TestCase
{
    private $qualifierFilter;

    public function set_up()
    {
        $this->qualifierFilter = new QualifierFilter;
    }

    public function testRegex()
    {
        $filter = $this->qualifierFilter->regex('v1');
        $this->assertInstanceOf(SimpleFilter::class, $filter);
        $rowFilter = new RowFilter();
        $rowFilter->setColumnQualifierRegexFilter('v1');
        $this->assertEquals($rowFilter, $filter->toProto());
    }

    public function testExactMatch()
    {
        $filter = $this->qualifierFilter->exactMatch('v1');
        $this->assertInstanceOf(SimpleFilter::class, $filter);
        $rowFilter = new RowFilter();
        $rowFilter->setColumnQualifierRegexFilter('v1');
        $this->assertEquals($rowFilter, $filter->toProto());
    }

    public function testRangeWithinFamily()
    {
        $this->assertInstanceOf(
            QualifierRangeFilter::class,
            $this->qualifierFilter->rangeWithinFamily('cf1')
        );
    }
}
