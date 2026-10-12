<?php
/**
 * Copyright 2023 Google LLC
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

namespace Google\Cloud\Datastore\Tests\Unit\Query;

use Google\Cloud\Datastore\Query\Filter;
use Google\Cloud\Datastore\V1\CompositeFilter\Operator;
use Google\Cloud\Datastore\V1\PropertyFilter\Operator as PropertyFilterOperator;
use PHPUnit\Framework\TestCase;

/**
 * @group datastore
 * @group datastore-query
 */
class FilterTest extends TestCase
{
    /**
     * @dataProvider getCompositeFilterCases
     */
    public function testCompositeFilterMethods(string $methodName, int $mappedOperator, array $filters)
    {
        $filter = Filter::$methodName($filters);

        $this->assertArrayHasKey('compositeFilter', $filter);
        $compositeFilter = $filter['compositeFilter'];

        $this->assertEquals($compositeFilter['filters'], $filters);

        $this->assertEquals($compositeFilter['op'], $mappedOperator);
    }

    /**
     * @dataProvider getWhereCases
     */
    public function testWhere($value)
    {
        $filter = Filter::where('foo', '>', $value);
        $this->assertArrayHasKey('propertyFilter', $filter);
        $propertyFilter = $filter['propertyFilter'];

        $this->assertEquals($propertyFilter['property'], 'foo');
        $this->assertEquals(PropertyFilterOperator::GREATER_THAN, $propertyFilter['op']);
        $this->assertEquals($propertyFilter['value'], $value);
    }

    public function getWhereCases()
    {
        $cases = [
            // Since $operator can be (=, <, >, <=, >=, !=), so string should be
            // accepted.
            ['value'],
            // Also, $operator can be ('IN', 'NOT IN'), so array should also be
            // allowed as value.
            [['value']]
        ];
        return $cases;
    }

    public function getCompositeFilterCases()
    {
        $cases = [
            ['and', Operator::PBAND, [['foo' => 'bar1'], ['foo' => 'bar2']]],
            ['or', Operator::PBOR, [['foo' => 'bar1'], ['foo' => 'bar2']]]
        ];
        return $cases;
    }
}
