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

namespace Google\Cloud\Datastore\Tests\Unit;

use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Key;
use GuzzleHttp\Psr7\Stream;
use PHPUnit\Framework\TestCase;

/**
 * @group datastore
 */
class EntityTest extends TestCase
{
    private $key;
    private $mapper;

    public function setUp()
    {
        $this->key = new Key('foo', ['path' => [
            ['kind' => 'kind', 'name' => 'name']
        ]]);

        $this->mapper = new EntityMapper('foo', true, false);
    }

    public function testCreateEntity()
    {
        $entity = new Entity($this->key, [
            'foo' => "bar"
        ]);

        $this->assertEquals('bar', $entity['foo']);

        $entity['test'] = 'val';

        $this->assertEquals('val', $entity['test']);

        $this->assertNull($entity['doesntExist']);

        $this->assertArrayNotHasKey('doesntExist', $entity);
        $this->assertArrayHasKey('test', $entity);

        unset($entity['test']);
        $this->assertArrayNotHasKey('test', $entity);

        $entity->magicProperty = 'magic value';
        $this->assertEquals('magic value', $entity->magicProperty);

        $this->assertNull($entity->nonExistentMagicProperty);
        $this->assertObjectNotHasAttribute('nonExistentMagicProperty', $entity);

        $this->assertTrue(isset($entity->magicProperty));

        unset($entity->magicProperty);
        $this->assertObjectNotHasAttribute('magicProperty', $entity);
    }

    public function testGet()
    {
        $data = ['foo' => 'bar'];

        $entity = new Entity($this->key, $data);
        $this->assertEquals($data, $entity->get());
    }

    public function testSet()
    {
        $data = ['foo' => 'bar'];

        $entity = new Entity($this->key);
        $entity->set($data);
        $this->assertEquals($data, $entity->get());
    }

    public function testKey()
    {
        $entity = new Entity($this->key);
        $this->assertEquals($this->key, $entity->key());
    }

    public function testExclude()
    {
        $entity = new Entity($this->key);
        $this->assertEquals([], $entity->excludedProperties());

        $props = ['foo','bar'];
        $entity->setExcludeFromIndexes($props);
        $this->assertEquals($props, $entity->excludedProperties());
    }

    /**
     * @dataProvider options
     */
    public function testOptionGetters($method, $unsetValue = null, $name = null)
    {
        $name = $name ?: $method;

        $entity = new Entity($this->key);
        $this->assertEquals($unsetValue, $entity->$method());

        $entity = new Entity($this->key, [], [
            $name => 'foo'
        ]);

        $this->assertEquals('foo', $entity->$method());
    }

    public function options()
    {
        return [
            ['cursor'],
            ['baseVersion'],
            ['populatedByService', false],
            ['excludedProperties', [], 'excludeFromIndexes'],
            ['meanings', []]
        ];
    }
}
