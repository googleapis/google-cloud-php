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

namespace Google\Cloud\Bigtable\Tests\Snippet;

use Google\Cloud\Bigtable\Filter;
use Google\Cloud\Bigtable\V2\RowFilter;
use Google\Cloud\Bigtable\V2\RowFilter\Chain;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class FilterTest extends SnippetTestCase
{
    public function testFilter()
    {
        $snippet = $this->snippetFromClass(Filter::class);
        $res = $snippet->invoke('rowFilter');
        $cellsPerRowFilter = new RowFilter();
        $cellsPerRowFilter->setCellsPerRowLimitFilter(10);
        $qualifierFilter = new RowFilter();
        $qualifierFilter->setColumnQualifierRegexFilter('prefix.*');
        $chainFilter = new Chain();
        $chainFilter->setFilters([$qualifierFilter, $cellsPerRowFilter]);
        $rowFilter = new RowFilter();
        $rowFilter->setChain($chainFilter);
        $this->assertEquals($rowFilter, $res->returnVal());
    }
}
