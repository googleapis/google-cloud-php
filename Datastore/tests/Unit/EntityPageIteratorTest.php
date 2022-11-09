<?php
/**
 * Copyright 2017 Google Inc.
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

use Google\Cloud\Datastore\EntityPageIterator;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIsType;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group datastore
 */
class EntityPageIteratorTest extends TestCase
{
    use AssertIsType;

    private static $moreResultsType = 'NOT_FINISHED';
    private static $items = ['a', 'b', 'c'];

    public function testGetsMoreResultsType()
    {
        $pages = new EntityPageIterator(
            function ($item) {
                return $item;
            },
            [$this, 'theCall'],
            ['test' => 'call']
        );

        $pagesArray = iterator_to_array($pages);

        $this->assertOverPages($pages);
    }

    public function testCurrentSetsQueryIntegerLimits()
    {
        $pages = new EntityPageIterator(
            function ($item) {
                return $item;
            },
            [$this, 'theCall'],
            [
                'test' => 'call',
                'query' => ['limit' => 1000],
            ]
        );

        $pagesArray = iterator_to_array($pages);

        $this->assertOverPages($pages, 1000);
    }

    public function testCurrentSetsQueryArrayLimits()
    {

        $pages = new EntityPageIterator(
            function ($item) {
                return $item;
            },
            [$this, 'theCall'],
            [
                'test' => 'call',
                'query' => ['limit' => ['value' => 1100]],
            ]
        );

        $this->assertOverPages($pages, 1100);
    }

    private function assertOverPages($pages, $expectedLimit = 0)
    {
        $pagesArray = iterator_to_array($pages);

        $reflection = new \ReflectionClass($pages);
        $configProp = $reflection->getProperty('config');
        $configProp->setAccessible(true);
        $configs = $configProp->getValue($pages);

        $this->assertIsArray($configs);
        $this->assertArrayHasKey('resultLimit', $configs);
        $this->assertEquals(
            $expectedLimit,
            $configs['resultLimit'],
            "resultLimit assertion failed."
        );

        $this->assertEquals(self::$moreResultsType, $pages->moreResultsType());
        $this->assertEquals(self::$items, $pagesArray[0]);
    }

    public function theCall(array $options)
    {
        return [
            'batch' => [
                'moreResults' => self::$moreResultsType,
            ],
            'items' => self::$items,
        ] + $options;
    }
}
