<?php
/**
 * Copyright 2023 Google Inc.
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

namespace Google\Cloud\Firestore\Tests\Unit;

use Google\Cloud\Firestore\Aggregate;
use PHPUnit\Framework\TestCase;

/**
 * @group firestore
 * @group firestore-query
 */
class AggregateTest extends TestCase
{
    /**
     * @dataProvider aggregationTypes
     */
    public function testAggregationType($type, $arg, $expected)
    {
        $expectedQuery = [
            $type => $expected
        ];

        $aggregate = $arg ? Aggregate::$type($arg) : Aggregate::$type();

        $this->assertEquals($expectedQuery, $aggregate->getProps());
    }

    /**
     * @dataProvider aggregationTypes
     */
    public function testAlias($type, $arg, $expected)
    {
        $alias = uniqid();
        $expectedQuery = [
            $type => $expected,
            'alias' => $alias
        ];

        $aggregate = $arg ? Aggregate::$type($arg) : Aggregate::$type();
        $aggregate->alias($alias);

        $this->assertEquals($expectedQuery, $aggregate->getProps());
    }

    public function aggregationTypes()
    {
        return [
            ['count', null, []],
            ['sum', 'testField', ['field' => ['fieldPath' => 'testField']]],
            ['avg', 'testField', ['field' => ['fieldPath' => 'testField']]]
        ];
    }
}
