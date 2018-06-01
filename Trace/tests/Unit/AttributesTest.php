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

use Google\Cloud\Trace\Attributes;
use PHPUnit\Framework\TestCase;

/**
 * @group trace
 */
class AttributesTest extends TestCase
{
    public function testArrayAccess()
    {
        $attributes = new Attributes();
        $this->assertArrayNotHasKey('foo', $attributes);
        $attributes['foo'] = 'bar';
        $this->assertArrayHasKey('foo', $attributes);
        $this->assertEquals('bar', $attributes['foo']);
        $this->assertArrayHasKey('foo', $attributes);
        unset($attributes['foo']);
        $this->assertArrayNotHasKey('foo', $attributes);
    }

    public function testSerializeBoolean()
    {
        $attributes = new Attributes();
        $attributes['foo'] = true;
        $attributes['bar'] = false;
        $json = $attributes->info();
        $this->assertArrayHasKey('attributeMap', $json);
        $data = $json['attributeMap'];

        $this->assertArrayHasKey('foo', $data);
        $this->assertEquals(['boolValue' => true], $data['foo']);

        $this->assertArrayHasKey('bar', $data);
        $this->assertEquals(['boolValue' => false], $data['bar']);
    }

    public function testSerializeInteger()
    {
        $attributes = new Attributes();
        $attributes['foo'] = 123;
        $json = $attributes->info();
        $this->assertArrayHasKey('attributeMap', $json);
        $data = $json['attributeMap'];

        $this->assertArrayHasKey('foo', $data);
        $this->assertEquals(['intValue' => 123], $data['foo']);
    }


    public function testSerializeString()
    {
        $attributes = new Attributes();
        $attributes['foo'] = 'some string';
        $json = $attributes->info();

        $this->assertArrayHasKey('attributeMap', $json);
        $data = $json['attributeMap'];

        $this->assertArrayHasKey('foo', $data);
        $this->assertEquals(['stringValue' => ['value' => 'some string']], $data['foo']);
    }
}
