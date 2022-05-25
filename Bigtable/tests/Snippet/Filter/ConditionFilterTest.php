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
use Google\Cloud\Bigtable\Filter\ConditionFilter;
use Google\Cloud\Bigtable\V2\RowFilter;
use Google\Cloud\Bigtable\V2\RowFilter\Condition;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class ConditionFilterTest extends SnippetTestCase
{
    private $conditionFilter;

    public function set_up()
    {
        $this->conditionFilter = Filter::condition(Filter::key()->regex('prefix.*'));
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(ConditionFilter::class);
        $res = $snippet->invoke('conditionFilter');
        $this->assertInstanceOf(ConditionFilter::class, $res->returnVal());
    }

    public function testThen()
    {
        $snippet = $this->snippetFromMethod(ConditionFilter::class, 'then');
        $snippet->addLocal('conditionFilter', $this->conditionFilter);
        $res = $snippet->invoke('conditionFilter');
        $rowFilter = (new RowFilter)
            ->setCondition(
                (new Condition)
                    ->setPredicateFilter(
                        (new RowFilter)->setRowKeyRegexFilter('prefix.*')
                    )
                    ->setTrueFilter(
                        (new RowFilter)->setApplyLabelTransformer('hasPrefix')
                    )
            );
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }

    public function testOtherwise()
    {
        $snippet = $this->snippetFromMethod(ConditionFilter::class, 'otherwise');
        $snippet->addLocal('conditionFilter', $this->conditionFilter);
        $res = $snippet->invoke('conditionFilter');
        $rowFilter = (new RowFilter)
            ->setCondition(
                (new Condition)
                    ->setPredicateFilter(
                        (new RowFilter)->setRowKeyRegexFilter('prefix.*')
                    )
                    ->setFalseFilter(
                        (new RowFilter)->setStripValueTransformer(true)
                    )
            );
        $this->assertEquals($rowFilter, $res->returnVal()->toProto());
    }
}
