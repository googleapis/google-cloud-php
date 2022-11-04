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
use Google\Cloud\Bigtable\Filter\Builder\TimestampFilter;
use Google\Cloud\Bigtable\V2\ColumnRange;
use Google\Cloud\Bigtable\V2\RowFilter;
use Google\Cloud\Bigtable\V2\TimestampRange;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class TimestampFilterTest extends SnippetTestCase
{
    private $builder;

    public function set_up()
    {
        $this->builder = Filter::timestamp();
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(TimestampFilter::class);
        $res = $snippet->invoke('builder');
        $this->assertInstanceOf(TimestampFilter::class, $res->returnVal());
    }

    public function testRange()
    {
        $snippet = $this->snippetFromMethod(TimestampFilter::class, 'range');
        $snippet->addLocal('builder', $this->builder);
        $res = $snippet->invoke('timestampRangeFilter');
        $rowFilter = (new RowFilter)->setTimestampRangeFilter(
            (new TimestampRange)
                ->setStartTimestampMicros(1536766964380000)
                ->setEndTimestampMicros(1536766964383000)
        );
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }
}
