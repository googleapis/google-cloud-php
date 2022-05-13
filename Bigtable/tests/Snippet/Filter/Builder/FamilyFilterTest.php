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
use Google\Cloud\Bigtable\Filter\Builder\FamilyFilter;
use Google\Cloud\Bigtable\V2\RowFilter;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class FamilyFilterTest extends SnippetTestCase
{
    private $builder;

    public function set_up()
    {
        $this->builder = Filter::family();
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(FamilyFilter::class);
        $res = $snippet->invoke('builder');
        $this->assertInstanceOf(FamilyFilter::class, $res->returnVal());
    }

    public function testRegex()
    {
        $snippet = $this->snippetFromMethod(FamilyFilter::class, 'regex');
        $snippet->addLocal('builder', $this->builder);
        $res = $snippet->invoke('familyFilter');
        $rowFilter = (new RowFilter)->setFamilyNameRegexFilter('prefix.*');
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }

    public function testExactMatch()
    {
        $snippet = $this->snippetFromMethod(FamilyFilter::class, 'exactMatch');
        $snippet->addLocal('builder', $this->builder);
        $res = $snippet->invoke('familyFilter');
        $rowFilter = (new RowFilter)->setFamilyNameRegexFilter('cf1');
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }
}
