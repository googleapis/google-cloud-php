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

namespace Google\Cloud\Trace\Tests\Unit;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Trace\Attributes;
use Google\Cloud\Trace\AttributeTrait;
use PHPUnit\Framework\TestCase;

/**
 * @group trace
 */
class AttributeTraitTest extends TestCase
{
    public function testDefaultsAttributesToNull()
    {
        $obj = TestHelpers::impl(AttributeTrait::class);
        $this->assertNull($obj->___getProperty('attributes'));
    }

    public function testAddAttribute()
    {
        $obj = TestHelpers::impl(AttributeTrait::class);
        $obj->addAttribute('foo', 'bar');
        $attributes = $obj->___getProperty('attributes');
        $this->assertInstanceOf(Attributes::class, $attributes);
        $this->assertEquals('bar', $attributes['foo']);
    }

    public function testAddAttributes()
    {
        $obj = TestHelpers::impl(AttributeTrait::class);
        $obj->addAttributes(['foo' => 'bar', 'asdf' => 'qwer']);
        $attributes = $obj->___getProperty('attributes');
        $this->assertInstanceOf(Attributes::class, $attributes);
        $this->assertEquals('bar', $attributes['foo']);
        $this->assertEquals('qwer', $attributes['asdf']);
    }
}
