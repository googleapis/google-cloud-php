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
use Google\Cloud\Bigtable\Filter\Builder\KeyFilter;
use Google\Cloud\Bigtable\V2\RowFilter;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class KeyFilterTest extends SnippetTestCase
{
    private $builder;

    public function set_up()
    {
        $this->builder = Filter::key();
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(KeyFilter::class);
        $res = $snippet->invoke('builder');
        $this->assertInstanceOf(KeyFilter::class, $res->returnVal());
    }

    public function testRegex()
    {
        $snippet = $this->snippetFromMethod(KeyFilter::class, 'regex');
        $snippet->addLocal('builder', $this->builder);
        $res = $snippet->invoke('keyFilter');
        $rowFilter = (new RowFilter)->setRowKeyRegexFilter('prefix.*');
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }

    public function testExactMatch()
    {
        $snippet = $this->snippetFromMethod(KeyFilter::class, 'exactMatch');
        $snippet->addLocal('builder', $this->builder);
        $res = $snippet->invoke('keyFilter');
        $rowFilter = (new RowFilter)->setRowKeyRegexFilter('r1');
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }

    public function testSample()
    {
        $snippet = $this->snippetFromMethod(KeyFilter::class, 'sample');
        $snippet->addLocal('builder', $this->builder);
        $res = $snippet->invoke('keyFilter');
        $rowFilter = (new RowFilter)->setRowSampleFilter(.7);
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }
}
