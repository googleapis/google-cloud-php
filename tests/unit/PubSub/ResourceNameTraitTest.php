<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Tests\Unit\PubSub;

use Google\Cloud\PubSub\ResourceNameTrait;

/**
 * @group pubsub
 */
class ResourceNameTraitTest extends \PHPUnit_Framework_TestCase
{
    private $trait;

    public function setUp()
    {
        $this->trait = new ResourceNameTraitStub;
    }

    public function testPluckProjectId()
    {
        $res = $this->trait->call('pluckName', [
            'project',
            'projects/foo'
        ]);

        $this->assertEquals('foo', $res);
    }

    public function testPluckTopicName()
    {
        $res = $this->trait->call('pluckName', [
            'topic',
            'projects/foo/topics/bar'
        ]);

        $this->assertEquals('bar', $res);
    }

    public function testPluckSubscriptionName()
    {
        $res = $this->trait->call('pluckName', [
            'subscription',
            'projects/foo/subscriptions/bar'
        ]);

        $this->assertEquals('bar', $res);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPluckNameInvalidFormat()
    {
        $this->trait->call('pluckName', ['lame', 'bar']);
    }

    public function testFormatProjectId()
    {
        $res = $this->trait->call('formatName', ['project', 'foo']);

        $this->assertEquals('projects/foo', $res);
    }

    public function testFormatTopicName()
    {
        $res = $this->trait->call('formatName', ['topic', 'foo', 'my-project']);

        $this->assertEquals('projects/my-project/topics/foo', $res);
    }

    public function testFormatSubscriptionName()
    {
        $res = $this->trait->call('formatName', ['subscription', 'foo', 'my-project']);

        $this->assertEquals('projects/my-project/subscriptions/foo', $res);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFormatNameInvalidType()
    {
        $this->trait->call('formatName', ['lame', 'foo']);
    }

    public function testIsFullyQualifiedProjectId()
    {
        $this->assertTrue($this->trait->call('isFullyQualifiedName', [
            'project',
            'projects/foo'
        ]));

        $this->assertFalse($this->trait->call('isFullyQualifiedName', [
            'project',
            'foo'
        ]));
    }

    public function testIsFullyQualifiedTopicName()
    {
        $this->assertTrue($this->trait->call('isFullyQualifiedName', [
            'topic',
            'projects/foo/topics/bar'
        ]));

        $this->assertFalse($this->trait->call('isFullyQualifiedName', [
            'topic',
            'foo'
        ]));
    }

    public function testIsFullyQualifiedSubscriptionName()
    {
        $this->assertTrue($this->trait->call('isFullyQualifiedName', [
            'subscription',
            'projects/foo/subscriptions/bar'
        ]));

        $this->assertFalse($this->trait->call('isFullyQualifiedName', [
            'subscription',
            'foo'
        ]));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIsFullyQualifiedNameInvalidType()
    {
        $this->trait->call('isFullyQualifiedName', ['lame', 'foo']);
    }
}

class ResourceNameTraitStub
{
    use ResourceNameTrait;

    public function call($method, array $args)
    {
        return call_user_func_array([$this, $method], $args);
    }
}
