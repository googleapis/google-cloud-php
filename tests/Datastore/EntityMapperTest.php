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

use Google\Cloud\Datastore\Blob;
use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\GeoPoint;
use Google\Cloud\Datastore\Key;

/**
 * @group datastore
 */
class EntityMapperTest extends \PHPUnit_Framework_TestCase
{
    private $mapper;

    public function setUp()
    {
        $this->mapper = new EntityMapper('foo', true);
    }

    public function testResponseToProperties()
    {
        $data = [
            'foo' => [
                'meaning' => 1,
                'stringValue' => 'bar'
            ],
            'dubs' => [
                'doubleValue' => 1.1,
                'meaning' => 2
            ]
        ];

        $res = $this->mapper->responseToProperties($data);

        $this->assertEquals('bar', $res['foo']);
        $this->assertEquals(1.1, $res['dubs']);
    }

    public function testResponseToExcludedProperties()
    {
        $data = [
            'foo' => [
                'stringValue' => 'bar',
                'excludeFromIndexes' => true
            ],
            'dubs' => [
                'doubleValue' => 1.1
            ]
        ];

        $res = $this->mapper->responseToExcludeFromIndexes($data);

        $res = $this->assertEquals(['foo'], $res);
    }

    public function testObjectToRequest()
    {
        $key = new Key('foo', [
            'path' => [['kind' => 'kind', 'id' => '2']]
        ]);

        $entity = new Entity($key, [
            'key' => 'val'
        ]);

        $res = $this->mapper->objectToRequest($entity);
        $this->assertEquals($key, $res['key']);
        $this->assertEquals('val', $res['properties']['key']['stringValue']);
    }

    public function testConvertValueTimestamp()
    {
        $type = 'timestampValue';
        $val = (new \DateTime())->format(\DateTime::RFC3339);

        $res = $this->mapper->convertValue($type, $val);
        $this->assertEquals($val, $res->format(\DateTime::RFC3339));
    }

    public function testConvertValueKey()
    {
        $type = 'keyValue';
        $val = [
            'partitionId' => [
                'namespaceId' => 'bar'
            ],
            'path' => [['kind' => 'kind', 'id' => '2']]
        ];

        $res = $this->mapper->convertValue($type, $val);
        $this->assertInstanceOf(Key::class, $res);

        $arr = $res->keyObject();
        $this->assertEquals('bar', $arr['partitionId']['namespaceId']);
        $this->assertEquals([['kind' => 'kind', 'id' => '2']], $arr['path']);
    }

    public function testConvertValueGeo()
    {
        $type = 'geoPointValue';
        $val = [
            'latitude' => 0.1,
            'longitude' => 1.0
        ];

        $res = $this->mapper->convertValue($type, $val);
        $this->assertInstanceOf(GeoPoint::class, $res);
        $this->assertEquals($val, $res->point());
    }

    public function testConvertValueEntityWithKey()
    {
        $type = 'entityValue';
        $val = [
            'key' => [
                'partitionId' => [
                    'namespaceId' => 'bar'
                ],
                'path' => [['kind' => 'kind', 'id' => '2']]
            ],
            'properties' => [
                'prop' => [
                    'stringValue' => 'test'
                ]
            ]
        ];

        $res = $this->mapper->convertValue($type, $val);
        $this->assertInstanceOf(Entity::class, $res);
        $this->assertInstanceOf(Key::class, $res->key());

        $key = $res->key()->keyObject();
        $this->assertEquals('bar', $key['partitionId']['namespaceId']);
        $this->assertEquals([['kind' => 'kind', 'id' => '2']], $key['path']);

        $this->assertEquals('test', $res['prop']);
    }

    public function testConvertValueEntityWithIncompleteKey()
    {
        $type = 'entityValue';
        $val = [
            'key' => [
                'partitionId' => [
                    'namespaceId' => 'bar'
                ],
                'path' => [['kind' => 'kind']]
            ],
            'properties' => [
                'prop' => [
                    'stringValue' => 'test'
                ]
            ]
        ];

        $res = $this->mapper->convertValue($type, $val);
        $this->assertInstanceOf(Entity::class, $res);
        $this->assertInstanceOf(Key::class, $res->key());

        $key = $res->key()->keyObject();
        $this->assertEquals('bar', $key['partitionId']['namespaceId']);
        $this->assertEquals([['kind' => 'kind']], $key['path']);

        $this->assertEquals('test', $res['prop']);
    }

    public function testConvertValueEntityWithoutKey()
    {
        $type = 'entityValue';
        $val = [
            'properties' => [
                'prop' => [
                    'stringValue' => 'test'
                ]
            ]
        ];

        $res = $this->mapper->convertValue($type, $val);
        $this->assertTrue(is_array($res));
        $this->assertEquals('test', $res['prop']);
    }

    public function testConvertValueDouble()
    {
        $type = 'doubleValue';
        $val = 1.1;

        $res = $this->mapper->convertValue($type, $val);
        $this->assertTrue(is_float($res));
        $this->assertEquals(1.1, $res);
    }

    public function testConvertValueDoubleWithCast()
    {
        $type = 'doubleValue';
        $val = 1;

        $res = $this->mapper->convertValue($type, $val);
        $this->assertTrue(is_float($res));
        $this->assertEquals((float)1, $res);
    }

    public function testConvertValueInteger()
    {
        $type = 'integerValue';
        $val = 1;

        $res = $this->mapper->convertValue($type, $val);
        $this->assertEquals(1, $res);
    }

    public function testConvertValueBlob()
    {
        $type = 'blobValue';
        $val = base64_encode('hello world');

        $res = $this->mapper->convertValue($type, $val);
        $this->assertInstanceOf(Blob::class, $res);

        $this->assertEquals('hello world', (string)$res);
    }

    public function testConvertValueBlobNotEncoded()
    {
        $type = 'blobValue';
        $val = 'hello world';

        $res = $this->mapper->convertValue($type, $val);
        $this->assertInstanceOf(Blob::class, $res);

        $this->assertEquals('hello world', (string)$res);
    }

    public function testArrayValue()
    {
        $type = 'arrayValue';
        $val = [
            'values' => [
                ['stringValue' => 'foo'],
                ['stringValue' => 'bar']
            ]
        ];

        $res = $this->mapper->convertValue($type, $val);
        $this->assertTrue(is_array($res));
        $this->assertEquals(['foo', 'bar'], $res);
    }


    public function testValueObjectBool()
    {
        $bool = $this->mapper->valueObject(true);

        $this->assertTrue($bool['booleanValue']);
    }

    public function testValueObjectInt()
    {
        $int = $this->mapper->valueObject(1);

        $this->assertEquals(1, $int['integerValue']);
    }

    public function testValueObjectDouble()
    {
        $double = $this->mapper->valueObject(1.1);

        $this->assertEquals(1.1, $double['doubleValue']);
    }

    public function testValueObjectString()
    {
        $string = $this->mapper->valueObject('foo');

        $this->assertEquals('foo', $string['stringValue']);
    }

    public function testValueObjectArrayEntityValue()
    {
        $entity = $this->mapper->valueObject([
            'key1' => 'val1',
            'key2' => 'val2'
        ]);

        $this->assertEquals('entityValue', key($entity));
        $this->assertEquals('val1', $entity['entityValue']['properties']['key1']['stringValue']);
        $this->assertEquals('val2', $entity['entityValue']['properties']['key2']['stringValue']);
    }

    public function testValueObjectArrayArrayValue()
    {
        $array = $this->mapper->valueObject([ 'bar', 1 ]);

        $this->assertEquals('bar', $array['arrayValue']['values'][0]['stringValue']);
        $this->assertEquals(1, $array['arrayValue']['values'][1]['integerValue']);
    }

    public function testValueObjectNull()
    {
        $null = $this->mapper->valueObject(null);

        $this->assertNull($null['nullValue']);
    }

    public function testValueObjectResource()
    {
        $string = 'test data';

        $stream = fopen('php://memory','r+');
        fwrite($stream, $string);
        rewind($stream);

        $res = $this->mapper->valueObject($stream);

        $this->assertEquals(base64_encode($string), $res['blobValue']);
    }

    public function testValueObjectResourceNotEncoded()
    {
        $string = 'test data';

        $stream = fopen('php://memory','r+');
        fwrite($stream, $string);
        rewind($stream);

        $mapper = new EntityMapper('foo', false);
        $res = $mapper->valueObject($stream);

        $this->assertEquals($string, $res['blobValue']);
    }

    public function testValueExcludeFromIndexes()
    {
        $res = $this->mapper->valueObject('hello', true);

        $this->assertTrue($res['excludeFromIndexes']);

        $res = $this->mapper->valueObject('hello', false);

        $this->assertFalse(isset($res['excludeFromIndexes']));
    }

    public function testObjectPropertyBlob()
    {
        $res = $this->mapper->valueObject(new Blob('hello world'));

        $this->assertEquals('hello world', base64_decode($res['blobValue']));
    }

    public function testObjectPropertyBlobNotEncoded()
    {
        $mapper = new EntityMapper('foo', false);

        $res = $mapper->valueObject(new Blob('hello world'));

        $this->assertEquals('hello world', $res['blobValue']);
    }

    public function testObjectPropertyDateTime()
    {
        $res = $this->mapper->valueObject(new \DateTimeImmutable);

        $this->assertEquals((new \DateTimeImmutable())->format(\DateTime::RFC3339), $res['timestampValue']);
    }

    public function testObjectPropertyKey()
    {
        $key = $this->prophesize(Key::class);
        $key->keyObject()->willReturn('foo');

        $res = $this->mapper->valueObject($key->reveal());

        $this->assertEquals($res['keyValue'], 'foo');
    }

    public function testObjectPropertyGeoPoint()
    {
        $point = new GeoPoint(1.0, 0.1);
        $res = $this->mapper->objectProperty($point);

        $this->assertEquals([
            'geoPointValue' => $point->point()
        ], $res);
    }

    public function testObjectPropertyEntity()
    {
        $key = new Key('foo', ['path' => [['kind' => 'kind', 'id' => 'id']]]);
        $entity = new Entity($key, [
            'key' => 'val'
        ]);

        $res = $this->mapper->objectProperty($entity);
        $this->assertEquals('val', $res['entityValue']['properties']['key']['stringValue']);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testObjectPropertyInvalidType()
    {
        $this->mapper->valueObject($this);
    }
}
