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

namespace Google\Cloud\Datastore\Tests\Unit;

use Google\Cloud\Datastore\Filter;
use Google\Cloud\Datastore\Query\Query;
use PHPUnit\Framework\TestCase;

/**
 * @group datastore
 * @group datastore-query
 */
class FilterTest extends TestCase
{
    private $operatorMap = [
        'equalTo' => Query::OP_EQUALS,
        'lessThan' => Query::OP_LESS_THAN,
        'lessThanOrEqualTo' => Query::OP_LESS_THAN_OR_EQUAL,
        'greaterThan' => Query::OP_GREATER_THAN,
        'greaterThanOrEqualTo' => Query::OP_GREATER_THAN_OR_EQUAL,
        'inArray' => Query::OP_IN,
        'notEqualTo' => Query::OP_NOT_EQUALS,
        'notInArray' => Query::OP_NOT_IN,
    ];
    /**
     * @dataProvider getNamedOperatorCases
     */
    public function testNamedOperatorMethods($methodName, array $arguments)
    {
        $filter = call_user_func_array([Filter::class, $methodName], $arguments);

        $this->checkPropertyFilter($filter, $methodName, $arguments);
    }

    /**
     * @dataProvider getCompositeFilterCases
     */
    public function testCompositeFilterMethods($methodName, $filters)
    {
        $filter = call_user_func_array([Filter::class, $methodName], [$filters]);

        $this->assertArrayHasKey('compositeFilter', $filter);
        $compositeFilter = $filter['compositeFilter'];

        $this->assertEquals($compositeFilter['filters'], $filters);
        $this->assertEquals($compositeFilter['op'], strtoupper($methodName));
    }

    public function testWhere()
    {
        $filter = Filter::where('foo', 'op', 'bar');
        $this->checkPropertyFilter($filter, 'where', ['foo', 'bar', 'op']);
    }

    private function getNamedOperatorCases()
    {
        $cases = [
            ['equalTo', ['foo', 'bar']],
            ['lessThan', ['foo', 'bar']],
            ['greaterThan', ['foo', 'bar']],
            ['lessThanOrEqualTo', ['foo', 'bar']],
            ['greaterThanOrEqualTo', ['foo', 'bar']],
            ['inArray', ['foo', ['bar']]],
            ['notEqualTo', ['foo', 'bar']],
            ['notInArray', ['foo', ['bar']]],
        ];
        return $cases;
    }

    private function getCompositeFilterCases()
    {
        $cases = [
            ['and', [['foo' => 'bar1'], ['foo' => 'bar2']]],
            ['or', [['foo' => 'bar1'], ['foo' => 'bar2']]]
        ];
        return $cases;
    }

    private function checkPropertyFilter($filter, $methodName, $arguments)
    {
        $this->assertArrayHasKey('propertyFilter', $filter);
        $propertyFilter = $filter['propertyFilter'];

        $this->assertEquals($propertyFilter['property'], $arguments[0]);
        $this->assertEquals($propertyFilter['value'], $arguments[1]);

        if ($methodName != 'where') {
            $this->assertEquals($propertyFilter['op'], $this->operatorMap[$methodName]);
        } else {
            $this->assertEquals($propertyFilter['op'], $arguments[2]);
        }
    }
}
