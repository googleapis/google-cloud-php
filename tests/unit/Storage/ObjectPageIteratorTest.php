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

namespace Google\Cloud\Tests\Unit\Storage;

use Google\Cloud\Storage\ObjectPageIterator;

/**
 * @group storage
 */
class ObjectPageIteratorTest extends \PHPUnit_Framework_TestCase
{
    private static $prefixes = ['test/', 'test1/'];
    private static $items = ['a', 'b', 'c'];

    public function testGetsPrefixes()
    {
        $pages = new ObjectPageIterator(
            function ($item) {
                return $item;
            },
            [$this, 'theCall'],
            ['test' => 'call']
        );

        $pagesArray = iterator_to_array($pages);

        $this->assertEquals(self::$prefixes, $pages->prefixes());
        $this->assertEquals(self::$items, $pagesArray[0]);
    }

    public function theCall(array $options)
    {
        return [
            'prefixes' => self::$prefixes,
            'items' => self::$items
        ];
    }
}
