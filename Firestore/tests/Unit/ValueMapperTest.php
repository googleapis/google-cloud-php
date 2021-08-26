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

namespace Google\Cloud\Firestore\Tests\Unit;

use Google\Cloud\Core\Blob;
use Google\Cloud\Core\GeoPoint;
use Google\Cloud\Core\Int64;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\ValueMapper;
use Google\Protobuf\NullValue;
use PHPUnit\Framework\TestCase;

/**
 * @group firestore
 * @group firestore-valuemapper
 */
class ValueMapperTest extends TestCase
{
    use TimeTrait;

    private $connection;
    private $mapper;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->mapper = TestHelpers::stub(ValueMapper::class, [
            $this->connection->reveal(),
            false
        ], ['connection', 'returnInt64AsObject']);
    }

    /**
     * @dataProvider encodedValues
     */
    public function testDecodeValues($value, callable $assertion)
    {
        $val = $this->mapper->decodeValues(['val' => $value])['val'];
        $assertion($val);
    }

    public function encodedValues()
    {
        $now = time();

        return [
            [
                ['stringValue' => 'foobar'],
                function ($val) {
                    $this->assertEquals('foobar', $val);
                }
            ], [
                ['nullValue' => NullValue::NULL_VALUE],
                function ($val) {
                    $this->assertNull($val);
                }
            ], [
                ['booleanValue' => true],
                function ($val) {
                    $this->assertTrue($val);
                }
            ], [
                ['booleanValue' => false],
                function ($val) {
                    $this->assertFalse($val);
                }
            ], [
                ['doubleValue' => 3.1415],
                function ($val) {
                    $this->assertEquals(3.1415, $val);
                }
            ], [
                ['bytesValue' => 'foobar'],
                function ($val) {
                    $this->assertInstanceOf(Blob::class, $val);
                    $this->assertEquals('foobar', (string) $val);
                }
            ], [
                ['integerValue' => 15],
                function ($val) {
                    $this->assertEquals(15, $val);
                }
            ], [
                ['timestampValue' => new Timestamp($this->createDateTimeFromSeconds($now), 10)],
                function ($val) use ($now) {
                    $this->assertInstanceOf(Timestamp::class, $val);
                    $ts = new Timestamp(\DateTimeImmutable::createFromFormat('U', (string) $now), 10);
                    $this->assertEquals($ts, $val);
                }
            ], [
                ['geoPointValue' => ['latitude' => 100.01, 'longitude' => 500.5]],
                function ($val) {
                    $this->assertInstanceOf(GeoPoint::class, $val);
                    $this->assertEquals(100.01, $val->latitude());
                    $this->assertEquals(500.5, $val->longitude());
                }
            ], [
                [
                    'arrayValue' => [
                        'values' => [
                            ['stringValue' => 'foo'],
                            ['stringValue' => 'bar'],
                        ]
                    ]
                ],
                function ($val) {
                    $this->assertEquals(['foo','bar'], $val);
                }
            ], [
                [
                    'mapValue' => [
                        'fields' => [
                            'foo' => [
                                'stringValue' => 'bar'
                            ],
                            'hello' => [
                                'stringValue' => 'world'
                            ]
                        ]
                    ]
                ],
                function ($val) {
                    $this->assertEquals('bar', $val['foo']);
                    $this->assertEquals('world', $val['hello']);
                }
            ], [
                [
                    'mapValue' => [
                        'fields' => []
                    ]
                ],
                function ($val) {
                    $this->assertEquals($val, new \stdClass());
                }
            ], [
                ['referenceValue' => 'projects/example_project/databases/(default)/documents/a/b'],
                function ($val) {
                    $this->assertInstanceOf(DocumentReference::class, $val);
                    $this->assertInstanceOf(CollectionReference::class, $val->parent());
                    $this->assertEquals('projects/example_project/databases/(default)/documents/a/b', $val->name());
                    $this->assertEquals(
                        'projects/example_project/databases/(default)/documents/a',
                        $val->parent()->name()
                    );
                }
            ]
        ];
    }

    public function testDecodeValuesIntAsObject()
    {
        $val = ['integerValue' => 15];

        $this->mapper->___setProperty('returnInt64AsObject', true);

        $res = $this->mapper->decodeValues(['val' => $val]);
        $this->assertInstanceOf(Int64::class, $res['val']);
        $this->assertEquals(15, $res['val']->get());
    }

    /**
     * @expectedException RuntimeException
     */
    public function testDecodeValuesInvalidValue()
    {
        $val = ['fooValue' => 15];
        $res = $this->mapper->decodeValues(['val' => $val]);
    }

    /**
     * @dataProvider decodedValues
     */
    public function testEncodeValues($val, callable $assertion)
    {
        $res = $this->mapper->encodeValues(['foo' => $val]);
        $assertion($res['foo']);
    }

    public function decodedValues()
    {
        $stream = fopen('php://memory', 'r+');
        fwrite($stream, 'hello');
        rewind($stream);

        $blobValue = 'hello world';
        $blob = new Blob($blobValue);

        $datetime = \DateTimeImmutable::createFromFormat('U.u', (string) microtime(true));
        $timestamp = new Timestamp($datetime);
        $now = (string) $datetime->format('U');
        $nanos = (int) $datetime->format('u') * 1000;

        $lat = 100.01;
        $lng = 100.25;
        $geo = new GeoPoint($lat, $lng);

        $docName = 'projects/foo/databases/bar/documents/a/b';
        $document = $this->prophesize(DocumentReference::class);
        $document->name()->willReturn($docName);

        return [
            [
                true,
                function ($val) {
                    $this->assertTrue($val['booleanValue']);
                }
            ], [
                false,
                function ($val) {
                    $this->assertFalse($val['booleanValue']);
                }
            ], [
                5,
                function ($val) {
                    $this->assertEquals(5, $val['integerValue']);
                }
            ], [
                3.1415,
                function ($val) {
                    $this->assertEquals(3.1415, $val['doubleValue']);
                }
            ], [
                'hello',
                function ($val) {
                    $this->assertEquals('hello', $val['stringValue']);
                }
            ], [
                $stream,
                function ($val) {
                    $this->assertEquals('hello', $val['bytesValue']);
                }
            ], [
                null,
                function ($val) {
                    $this->assertEquals(NullValue::NULL_VALUE, $val['nullValue']);
                }
            ], [
                ['a','b'],
                function ($val) {
                    $expected = [
                        'arrayValue' => [
                            'values' => [
                                [
                                    'stringValue' => 'a',
                                ], [
                                    'stringValue' => 'b'
                                ]
                            ]
                        ]
                    ];

                    $this->assertEquals($expected, $val);
                }
            ], [
                ['a' => 'b', 'c' => 'd'],
                function ($val) {
                    $expected = [
                        'mapValue' => [
                            'fields' => [
                                'a' => [
                                    'stringValue' => 'b'
                                ],
                                'c' => [
                                    'stringValue' => 'd'
                                ]
                            ]
                        ]
                    ];

                    $this->assertEquals($expected, $val);
                }
            ], [
                (object) ['a' => 'b', 'c' => 'd'],
                function ($val) {
                    $expected = [
                        'mapValue' => [
                            'fields' => [
                                'a' => [
                                    'stringValue' => 'b'
                                ],
                                'c' => [
                                    'stringValue' => 'd'
                                ]
                            ]
                        ]
                    ];

                    $this->assertEquals($expected, $val);
                }
            ], [
                $blob,
                function ($val) use ($blobValue) {
                    $this->assertEquals($blobValue, $val['bytesValue']);
                }
            ], [
                $datetime,
                function ($val) use ($now, $nanos) {
                    $this->assertEquals([
                        'seconds' => $now,
                        'nanos' => $nanos
                    ], $val['timestampValue']);
                }
            ], [
                $timestamp,
                function ($val) use ($now, $nanos) {
                    $this->assertEquals([
                        'seconds' => $now,
                        'nanos' => $nanos
                    ], $val['timestampValue']);
                }
            ], [
                $geo,
                function ($val) use ($lat, $lng) {
                    $this->assertEquals([
                        'longitude' => $lng,
                        'latitude' => $lat,
                    ], $val['geoPointValue']);
                }
            ], [
                $document->reveal(),
                function ($val) use ($docName) {
                    $this->assertEquals($docName, $val['referenceValue']);
                }
            ], [
                [],
                function ($val) {
                    $this->assertEquals(['values' => []], $val['arrayValue']);
                }
            ],  [
                (object) [],
                function ($val) {
                    $this->assertEquals(['fields' => []], $val['mapValue']);
                }
            ],
        ];
    }

    /**
     * @expectedException RuntimeException
     */
    public function testEncodeValuesInvalidObject()
    {
        $this->mapper->encodeValues(['val' => $this]);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testEncodeValuesInvalidArray()
    {
        $this->mapper->encodeValues(['val' => [
            ['a']
        ]]);
    }

    public function multiValues()
    {
        return [
            [[]],
            [['foo', 'bar']],
            [[['foo'], ['bar', 'baz'], 'qux']],
        ];
    }

    /**
     * @dataProvider multiValues
     * @param array $values
     */
    public function testEncodeValidMultiValues($values)
    {
        $encoded = $this->mapper->encodeMultiValue($values);
        $decoded = $this->mapper->decodeValues(['key' => $encoded]);
        $this->assertEquals($values, $decoded['key']);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testEncodeInvalidMultiValue()
    {
        $this->mapper->encodeMultiValue([[['foo']]]);
    }
}
