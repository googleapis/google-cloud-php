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

namespace Google\Cloud\Bigtable\Tests\Snippet\Filter\Builder;

use Google\Cloud\Bigtable\Filter;
use Google\Cloud\Bigtable\Filter\Builder\ValueFilter;
use Google\Cloud\Bigtable\V2\RowFilter;
use Google\Cloud\Bigtable\V2\ValueRange;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class ValueFilterTest extends SnippetTestCase
{
    private $builder;

    public function set_up()
    {
        $this->builder = Filter::value();
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(ValueFilter::class);
        $res = $snippet->invoke('builder');
        $this->assertInstanceOf(ValueFilter::class, $res->returnVal());
    }

    public function testRegex()
    {
        $snippet = $this->snippetFromMethod(ValueFilter::class, 'regex');
        $snippet->addLocal('builder', $this->builder);
        $res = $snippet->invoke('valueFilter');
        $rowFilter = (new RowFilter)->setValueRegexFilter('prefix.*');
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }

    public function testExactMatch()
    {
        $snippet = $this->snippetFromMethod(ValueFilter::class, 'exactMatch');
        $snippet->addLocal('builder', $this->builder);
        $res = $snippet->invoke('valueFilter');
        $rowFilter = (new RowFilter)->setValueRegexFilter('value1');
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }

    public function testRange()
    {
        $snippet = $this->snippetFromMethod(ValueFilter::class, 'range');
        $snippet->addLocal('builder', $this->builder);
        $res = $snippet->invoke('valueFilter');
        $rowFilter = (new RowFilter)->setValueRangeFilter(
            (new ValueRange)
                ->setStartValueClosed('value1')
                ->setEndValueOpen('value10')
        );
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }
}
