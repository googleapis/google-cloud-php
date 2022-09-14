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

use Google\Cloud\Bigtable\Filter;
use Google\Cloud\Bigtable\Filter\Builder\LimitFilter;
use Google\Cloud\Bigtable\V2\RowFilter;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class LimitFilterTest extends TestCase
{
    private $limitFilter;

    public function set_up()
    {
        $this->limitFilter = Filter::limit();
    }

    public function testCellsPerRow()
    {
        $filter = $this->limitFilter->cellsPerRow(5);
        $rowFilter = new RowFilter();
        $rowFilter->setCellsPerRowLimitFilter(5);
        $this->assertEquals($rowFilter, $filter->toProto());
    }

    public function testCellsPerColumn()
    {
        $filter = $this->limitFilter->cellsPerColumn(5);
        $rowFilter = new RowFilter();
        $rowFilter->setCellsPerColumnLimitFilter(5);
        $this->assertEquals($rowFilter, $filter->toProto());
    }
}
