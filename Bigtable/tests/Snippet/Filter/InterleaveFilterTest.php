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

namespace Google\Cloud\Bigtable\Tests\Snippet\Filter;

use Google\Cloud\Bigtable\Filter;
use Google\Cloud\Bigtable\Filter\InterleaveFilter;
use Google\Cloud\Bigtable\V2\RowFilter;
use Google\Cloud\Bigtable\V2\RowFilter\Interleave;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class InterleaveFilterTest extends SnippetTestCase
{
    private $interleaveFilter;

    public function set_up()
    {
        $this->interleaveFilter = Filter::interleave();
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(InterleaveFilter::class);
        $res = $snippet->invoke('interleaveFilter');
        $this->assertInstanceOf(InterleaveFilter::class, $res->returnVal());
    }

    public function testAddFilter()
    {
        $snippet = $this->snippetFromMethod(InterleaveFilter::class, 'addFilter');
        $snippet->addLocal('interleaveFilter', $this->interleaveFilter);
        $res = $snippet->invoke('interleaveFilter');
        $rowFilter = (new RowFilter)
            ->setInterleave((new Interleave)->setFilters([(new RowFilter)->setRowKeyRegexFilter('prefix.*')]));
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }
}
