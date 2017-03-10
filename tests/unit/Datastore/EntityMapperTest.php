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

namespace Google\Cloud\Tests\Unit\Datastore;

use Google\Cloud\Datastore\Blob;
use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\GeoPoint;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Core\Int64;

/**
 * @group datastore
 */
class EntityMapperTest extends \PHPUnit_Framework_TestCase
{
    const DATE_FORMAT = 'Y-m-d\TH:i:s.uP';

    private $mapper;

    public function setUp()
    {
        $this->mapper = new EntityMapper('foo', true, false);
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

        $res = $this->mapper->responseToEntityProperties($data)['properties'];

        $this->assertEquals('bar', $res['foo']);
        $this->assertEquals(1.1, $res['dubs']);
    }

    public function testResponseToPropertiesNullValue()
    {
        $data = [
            'foo' => [
                'meaning' => 1,
                'nullValue' => null
            ]
        ];

        $res = $this->mapper->responseToEntityProperties($data)['properties'];

        $this->assertNull($res['foo']);
    }

    public function testResponesToPropertiesBooleanValue()
    {
        $data = [
            'foo' => [
                'booleanValue' => true
            ]
        ];

        $res = $this->mapper->responseToEntityProperties($data)['properties'];

        $this->assertTrue($res['foo']);
    }

    public function testResponseToPropertiesDoubleValue()
    {
        $data = [
            'foo' => [
                'doubleValue' => 1.1
            ]
        ];

        $res = $this->mapper->responseToEntityProperties($data)['properties'];

        $this->assertEquals(1.1, $res['foo']);
    }

    public function testResponseToPropertiesTimestampValue()
    {
        $date = new \DateTimeImmutable;

        $data = [
            'foo' => [
                'timestampValue' => $date->format(self::DATE_FORMAT)
            ]
        ];

        $res = $this->mapper->responseToEntityProperties($data)['properties'];

        $this->assertInstanceOf(\DateTimeImmutable::class, $res['foo']);
        $this->assertEquals($date->format('c'), $res['foo']->format('c'));
    }

    public function testResponseToPropertiesKeyValue()
    {
        $path = [
            ['kind' => 'Kind', 'name' => 'Name']
        ];

        $data = [
            'foo' => [
                'keyValue' => (new Key('foo', [
                    'path' => $path
                ]))->keyObject()
            ]
        ];

        $res = $this->mapper->responseToEntityProperties($data)['properties'];

        $this->assertInstanceOf(Key::class, $res['foo']);
        $this->assertEquals($path, $res['foo']->path());
    }

    public function testResponseToPropertiesBlobValue()
    {
        $data = [
            'foo' => [
                'blobValue' => base64_encode('hello world')
            ]
        ];

        $res = $this->mapper->responseToEntityProperties($data)['properties'];

        $this->assertInstanceOf(Blob::class, $res['foo']);
        $this->assertEquals('hello world', (string)$res['foo']);
    }

    public function testResponseToPropertiesGeoPoint()
    {
        $point = [
            'latitude' => 1,
            'longitude' => -1
        ];

        $data = [
            'foo' => [
                'geoPointValue' => $point
            ]
        ];

        $res = $this->mapper->responseToEntityProperties($data)['properties'];

        $this->assertInstanceOf(GeoPoint::class, $res['foo']);
        $this->assertEquals($point, $res['foo']->point());
    }

    public function testResponseToPropertiesEntityValue()
    {
        $data = [
            'foo' => [
                'entityValue' => [
                    'properties' => [
                        'bar' => [
                            'stringValue' => 'baz'
                        ]
                    ]
                ]
            ]
        ];

        $res = $this->mapper->responseToEntityProperties($data)['properties'];

        $this->assertEquals('baz', $res['foo']['bar']);
    }

    public function testResponseToPropertiesArrayValue()
    {
        $arr = [
            ['stringValue' => 'a'],
            ['stringValue' => 'b'],
            ['stringValue' => 'c']
        ];

        $data = [
            'foo' => [
                'arrayValue' => [
                    'values' => $arr
                ]
            ]
        ];

        $res = $this->mapper->responseToEntityProperties($data)['properties'];

        $this->assertEquals(['a','b','c'], $res['foo']);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testResponseToPropertiesNoValuePresent()
    {
        $data = [
            'foo' => [
                'meaning' => 1
            ]
        ];

        $res = $this->mapper->responseToEntityProperties($data)['properties'];
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

        $res = $this->mapper->responseToEntityProperties($data)['excludes'];

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
        $val = (new \DateTime())->format(self::DATE_FORMAT);

        $res = $this->mapper->convertValue($type, $val);
        $this->assertEquals($val, $res->format(self::DATE_FORMAT));
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

    /**
     * @expectedException RuntimeException
     */
    public function testConvertValueInvalidType()
    {
        $type = 'fooBarValue';
        $val = 'nothanks';
        $this->mapper->convertValue($type, $val);
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

    public function testEmptyArrayValue()
    {
        $type = 'arrayValue';
        $val = [];

        $res = $this->mapper->convertValue($type, $val);
        $this->assertTrue(is_array($res));
        $this->assertEquals([], $res);
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

        $mapper = new EntityMapper('foo', false, false);
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
        $mapper = new EntityMapper('foo', false, false);

        $res = $mapper->valueObject(new Blob('hello world'));

        $this->assertEquals('hello world', $res['blobValue']);
    }

    public function testObjectPropertyDateTime()
    {
        $dateTime = new \DateTimeImmutable;
        $res = $this->mapper->valueObject($dateTime);

        $this->assertEquals($dateTime->format(self::DATE_FORMAT), $res['timestampValue']);
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

    public function testIncomingEntityWithMeaning()
    {
        $data = [
            'foo' => [
                'stringValue' => 'bar',
                'meaning' => 10
            ]
        ];

        $props = $this->mapper->responseToEntityProperties($data)['properties'];
        $this->assertEquals(['foo' => 'bar'], $props);

        $meanings = $this->mapper->responseToEntityProperties($data)['meanings'];
        $this->assertEquals(['foo' => 10], $meanings);
    }

    public function testObjectToRequestWithMeaning()
    {
        $key = new Key('project', ['path' => [['kind' => 'Kind', 'name' => 'Name']]]);

        $e = new Entity($key, [
            'foo' => 'bar'
        ], [
            'meanings' => [
                'foo' => 10
            ]
        ]);

        $res = $this->mapper->objectToRequest($e);
        $this->assertEquals('bar', $res['properties']['foo']['stringValue']);
        $this->assertEquals(10, $res['properties']['foo']['meaning']);
    }

    public function testReturnsInt64AsObject()
    {
        $int = '914241242';
        $mapper = new EntityMapper('foo', true, true);
        $res = $mapper->convertValue('integerValue', $int);

        $this->assertInstanceOf(Int64::class, $res);
        $this->assertEquals($int, $res->get());
    }

    public function testObjectPropertyInt64()
    {
        $int = '123239';
        $int64 = new Int64($int);
        $res = $this->mapper->objectProperty($int64);

        $this->assertEquals([
            'integerValue' => $int64->get()
        ], $res);
    }
}
