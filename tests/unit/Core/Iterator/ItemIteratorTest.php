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

namespace Google\Cloud\Tests\Unit\Core\Iterator;

use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;

/**
 * @group core
 */
class ItemIteratorTest extends \PHPUnit_Framework_TestCase
{
    public function testIteratesData()
    {
        $page1 = ['a', 'b', 'c'];
        $page2 = ['d', 'e', 'f'];
        $pageIterator = $this->prophesize(PageIterator::class);
        $pageIterator->rewind()
            ->willReturn(null)
            ->shouldBeCalledTimes(1);
        $pageIterator->nextResultToken()
            ->willReturn('abc', null)
            ->shouldBeCalledTimes(2);
        $pageIterator->current()
            ->willReturn($page1)
            ->shouldBeCalledTimes(19);
        $pageIterator->next()
            ->will(function () use ($page2) {
                $this->current()->willReturn($page2);
            })
            ->shouldBeCalledTimes(1);

        $items = new ItemIterator($pageIterator->reveal());

        $actualItems = [];
        foreach ($items as $key => $item) {
            $actualItems[] = $item;
        }

        $this->assertEquals(array_merge($page1, $page2), $actualItems);
    }

    public function testGetsNextResultToken()
    {
        $nextResultToken = 'abc';
        $pageIterator = $this->prophesize(PageIterator::class);
        $pageIterator->nextResultToken()
            ->willReturn($nextResultToken)
            ->shouldBeCalledTimes(1);

        $items = new ItemIterator($pageIterator->reveal());

        $this->assertEquals($nextResultToken, $items->nextResultToken());
    }

    public function testGetsPageIterator()
    {
        $pageIterator = $this->prophesize(PageIterator::class);

        $items = new ItemIterator($pageIterator->reveal());

        $this->assertInstanceOf(PageIterator::class, $items->iterateByPage());
    }
}
