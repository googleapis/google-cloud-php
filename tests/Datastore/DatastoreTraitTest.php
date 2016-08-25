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

namespace Google\Cloud\Tests\Datastore;

use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\DatastoreTrait;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Transaction;

/**
 * @group datastore
 */
class DatastoreTraitTest extends \PHPUnit_Framework_TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new DatastoreTraitStub;
    }

    public function testPartitionId()
    {
        $res = $this->stub->call('partitionId', [
            'foo', 'bar'
        ]);

        $this->assertTrue(is_array($res));
        $this->assertEquals('foo', $res['projectId']);
        $this->assertEquals('bar', $res['namespaceId']);
    }

    public function testValueObjectBool()
    {
        $bool = $this->stub->call('valueObject', [
            true
        ]);

        $this->assertTrue($bool['booleanValue']);
    }

    public function testValueObjectInt()
    {
        $int = $this->stub->call('valueObject', [
            1
        ]);

        $this->assertEquals(1, $int['integerValue']);
    }

    public function testValueObjectDouble()
    {
        $double = $this->stub->call('valueObject', [
            1.1
        ]);

        $this->assertEquals(1.1, $double['doubleValue']);
    }

    public function testValueObjectString()
    {
        $string = $this->stub->call('valueObject', [
            'foo'
        ]);

        $this->assertEquals('foo', $string['stringValue']);
    }

    public function testValueObjectArray()
    {
        $array = $this->stub->call('valueObject', [
            [ 'bar', 1 ]
        ]);

        $this->assertEquals('bar', $array['arrayValue']['values'][0]['stringValue']);
        $this->assertEquals(1, $array['arrayValue']['values'][1]['integerValue']);
    }

    public function testValueObjectNull()
    {
        $null = $this->stub->call('valueObject', [
            null
        ]);

        $this->assertNull($null['nullValue']);
    }

    public function testValueExcludeFromIndexes()
    {
        $res = $this->stub->call('valueObject', [
            'hello', false, true
        ]);

        $this->assertTrue($res['excludeFromIndexes']);

        $res = $this->stub->call('valueObject', [
            'hello', false, false
        ]);

        $this->assertFalse(isset($res['excludeFromIndexes']));
    }

    public function testObjectPropertyDateTime()
    {
        $res = $this->stub->call('valueObject', [
            new \DateTimeImmutable
        ]);

        $this->assertEquals((new \DateTimeImmutable())->format(\DateTime::RFC3339), $res['timestampValue']);
    }

    public function testObjectPropertyKey()
    {
        $key = $this->prophesize(Key::class);
        $key->keyObject()->willReturn('foo');

        $res = $this->stub->call('valueObject', [
            $key->reveal()
        ]);

        $this->assertEquals($res['keyValue'], 'foo');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testObjectInvalidType()
    {
        $this->stub->call('valueObject', [
            $this
        ]);
    }
}

class DatastoreTraitStub
{
    use DatastoreTrait;

    public function call($fn, array $args)
    {
        return call_user_func_array([$this, $fn], $args);
    }
}
