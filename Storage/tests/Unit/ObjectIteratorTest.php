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

namespace Google\Cloud\Storage\Tests\Unit;

use Google\Cloud\Storage\ObjectIterator;
use Google\Cloud\Storage\ObjectPageIterator;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group storage
 */
class ObjectIteratorTest extends TestCase
{
    use ProphecyTrait;

    public function testGetsPrefixes()
    {
        $prefixes = ['test/', 'test1/'];
        $pageIterator = $this->prophesize(ObjectPageIterator::class);
        $pageIterator->prefixes()
            ->willReturn($prefixes)
            ->shouldBeCalledTimes(1);

        $items = new ObjectIterator($pageIterator->reveal());

        $this->assertEquals($prefixes, $items->prefixes());
    }
}
