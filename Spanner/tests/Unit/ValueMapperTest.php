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

namespace Google\Cloud\Spanner\Tests\Unit;

use Google\Cloud\Core\Int64;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Spanner\ArrayType;
use Google\Cloud\Spanner\Bytes;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Date;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\StructType;
use Google\Cloud\Spanner\StructValue;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\ValueMapper;
use PHPUnit\Framework\TestCase;

/**
 * @group spanner
 * @group spanner-valuemapper
 */
class ValueMapperTest extends TestCase
{
    use GrpcTestTrait;

    const FORMAT_TEST_VALUE = 'abc';

    private $mapper;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();
        $this->mapper = new ValueMapper(false);
    }

    /**
     * @dataProvider simpleTypes
     */
    public function testFormatParamsForExecuteSqlSimpleTypes($value, $type)
    {
        $res = $this->mapper->formatParamsForExecuteSql(['param' => $value]);

        $this->assertEquals(['param' => $value], $res['params']);
        $this->assertEquals($type, $res['paramTypes']['param']['code']);
    }

    public function simpleTypes()
    {
        return [
            [1, Database::TYPE_INT64],
            ['john', Database::TYPE_STRING],
            [3.1415, Database::TYPE_FLOAT64],
            [false, Database::TYPE_BOOL]
        ];
    }

    public function testFormatParamsForExecuteSqlResource()
    {
        $c = 'hello world';

        $resource = fopen('php://temp', 'r+');
        fwrite($resource, $c);
        rewind($resource);

        $params = [
            'resource' => $resource
        ];

        $res = $this->mapper->formatParamsForExecuteSql($params);

        $this->assertEquals($c, base64_decode($res['params']['resource']));
        $this->assertEquals(Database::TYPE_BYTES, $res['paramTypes']['resource']['code']);
    }

    public function testFormatParamsForExecuteSqlArray()
    {
        $params = [
            'array' => ['foo', 'bar']
        ];

        $res = $this->mapper->formatParamsForExecuteSql($params);

        $this->assertEquals('foo', $res['params']['array'][0]);
        $this->assertEquals('bar', $res['params']['array'][1]);
        $this->assertEquals(Database::TYPE_ARRAY, $res['paramTypes']['array']['code']);
        $this->assertEquals(Database::TYPE_STRING, $res['paramTypes']['array']['arrayElementType']['code']);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFormatParamsForExecuteSqlInvalidTypes()
    {
        $this->mapper->formatParamsForExecuteSql(['array' => ['foo', 3.1515]]);
    }

    public function testFormatParamsForExecuteSqlInt64()
    {
        $val = '1234';
        $params = [
            'int' => new Int64($val)
        ];

        $res = $this->mapper->formatParamsForExecuteSql($params);

        $this->assertEquals($val, $res['params']['int']);
        $this->assertEquals(Database::TYPE_INT64, $res['paramTypes']['int']['code']);
    }

    public function testFormatParamsForExecuteSqlValueInterface()
    {
        $val = 'hello world';
        $params = [
            'bytes' => new Bytes($val)
        ];

        $res = $this->mapper->formatParamsForExecuteSql($params);
        $this->assertEquals($val, base64_decode($res['params']['bytes']));
        $this->assertEquals(Database::TYPE_BYTES, $res['paramTypes']['bytes']['code']);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFormatParamsForExecuteSqlInvalidObjectType()
    {
        $params = [
            'bad' => $this
        ];

        $this->mapper->formatParamsForExecuteSql($params);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testFormatParamsForExecuteSqlNullValueMissingType()
    {
        $params = [
            'null' => null
        ];

        $this->mapper->formatParamsForExecuteSql($params);
    }

    /**
     * @dataProvider arrayTypes
     */
    public function testFormatParamsForExecuteSqlArrayType($type)
    {
        $params = [
            'foo' => ['bar', 'str', null]
        ];

        $types = [
            'foo' => $type
        ];

        $res = $this->mapper->formatParamsForExecuteSql($params, $types);
        $this->assertEquals($params, $res['params']);
        $this->assertEquals([
            'code' => Database::TYPE_ARRAY,
            'arrayElementType' => [
                'code' => Database::TYPE_STRING
            ]
        ], $res['paramTypes']['foo']);
    }

    public function arrayTypes()
    {
        return [
            [[Database::TYPE_ARRAY, Database::TYPE_STRING]],
            [new ArrayType(Database::TYPE_STRING)]
        ];
    }

    public function testFormatParamsForExecuteSqlArrayTypeNestedStruct()
    {
        $params = [
            'foo' => [
                [
                    'hello' => 'bar'
                ], [
                    'hello' => 'baz'
                ]
            ]
        ];

        $types = [
            'foo' => new ArrayType((new StructType)->add('hello', Database::TYPE_STRING))
        ];

        $res = $this->mapper->formatParamsForExecuteSql($params, $types);
        $this->assertEquals([
            'foo' => [
                ['bar'],
                ['baz']
            ]
        ], $res['params']);

        $this->assertEquals([
            'foo' => [
                'code' => Database::TYPE_ARRAY,
                'arrayElementType' => [
                    'code' => Database::TYPE_STRUCT,
                    'structType' => [
                        'fields' => [
                            [
                                'name' => 'hello',
                                'type' => [
                                    'code' => Database::TYPE_STRING
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ], $res['paramTypes']);
    }

    public function testFormatParamsForExecuteSqlNullArray()
    {
        $params = [
            'foo' => null
        ];

        $types = [
            'foo' => new ArrayType(Database::TYPE_STRING)
        ];

        $res = $this->mapper->formatParamsForExecuteSql($params, $types);

        $this->assertNull($res['params']['foo']);

        $this->assertEquals([
            'foo' => [
                'code' => Database::TYPE_ARRAY,
                'arrayElementType' => [
                    'code' => Database::TYPE_STRING
                ]
            ]
        ], $res['paramTypes']);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Array data does not match given array parameter type.
     */
    public function testFormatParamsForExecuteSqlArrayMismatchedDefinition()
    {
        $params = [
            'foo' => [1,2,3]
        ];

        $types = [
            'foo' => new ArrayType(Database::TYPE_STRING)
        ];

        $this->mapper->formatParamsForExecuteSql($params, $types);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Array parameter types must be an instance of Google\Cloud\Spanner\ArrayType.
     */
    public function testFormatParamsForExecuteSqlArrayInvalidDefinition()
    {
        $params = [
            'foo' => ['bar']
        ];

        $types = [
            'foo' => Database::TYPE_ARRAY
        ];

        $this->mapper->formatParamsForExecuteSql($params, $types);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Array value must be an array or null.
     */
    public function testFormatParamsForExecuteSqlArrayInvalidValue()
    {
        $params = [
            'foo' => 'hello'
        ];

        $types = [
            'foo' => new ArrayType(Database::TYPE_STRING)
        ];

        $this->mapper->formatParamsForExecuteSql($params, $types);
    }

    public function testFormatParamsForExecuteSqlStruct()
    {
        $params = [
            'foo' => [
                'name' => 'steve',
                'age' => 39,
                'jobs' => [
                    'programmer',
                    'renaissance man'
                ]
            ]
        ];

        $types = [
            'foo' => (new StructType)
                ->add('name', Database::TYPE_STRING)
                ->add('age', Database::TYPE_INT64)
                ->add('jobs', new ArrayType(Database::TYPE_STRING))
        ];

        $res = $this->mapper->formatParamsForExecuteSql($params, $types);
        $this->assertEquals([
            'foo' => [
                'steve',
                39,
                [
                    'programmer',
                    'renaissance man'
                ]
            ]
        ], $res['params']);

        $this->assertEquals([
            'foo' => [
                'code' => Database::TYPE_STRUCT,
                'structType' => [
                    'fields' => [
                        [
                            'name' => 'name',
                            'type' => [
                                'code' => Database::TYPE_STRING
                            ]
                        ], [
                            'name' => 'age',
                            'type' => [
                                'code' => Database::TYPE_INT64
                            ]
                        ], [
                            'name' => 'jobs',
                            'type' => [
                                'code' => Database::TYPE_ARRAY,
                                'arrayElementType' => [
                                    'code' => Database::TYPE_STRING
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ], $res['paramTypes']);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Struct parameter types must be declared explicitly, and must be an instance of Google\Cloud\Spanner\StructType.
     */
    public function testFormatParamsForExecuteSqlStructInvalidDefinition()
    {
        $params = [
            'foo' => [
                'hello' => 'world'
            ]
        ];

        $types = [
            'foo' => Database::TYPE_STRUCT
        ];

        $this->mapper->formatParamsForExecuteSql($params, $types);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Struct value must be an array an instance of `Google\Cloud\Spanner\StructValue` or null.
     */
    public function testFormatParamsForExecuteSqlInvalidStructValue()
    {
        $params = [
            'foo' => 'bar'
        ];

        $types = [
            'foo' => new StructType
        ];

        $this->mapper->formatParamsForExecuteSql($params, $types);
    }

    public function testFormatParamsForExecuteSqlStructDuplicateFieldNames()
    {
        $params = [
            'foo' => (new StructValue)
                ->add('hello', 'world')
                ->add('hello', 10)
                ->add('hello', 'goodbye')
        ];

        $types = [
            'foo' => (new StructType)
                ->add('hello', Database::TYPE_STRING)
                ->add('hello', Database::TYPE_INT64)
                ->add('hello', Database::TYPE_STRING)
        ];

        $res = $this->mapper->formatParamsForExecuteSql($params, $types);
        $this->assertEquals([
            'foo' => [
                'world', 10, 'goodbye'
            ]
        ], $res['params']);

        $this->assertEquals([
            'foo' => [
                'code' => Database::TYPE_STRUCT,
                'structType' => [
                    'fields' => [
                        [
                            'name' => 'hello',
                            'type' => [
                                'code' => Database::TYPE_STRING
                            ]
                        ], [
                            'name' => 'hello',
                            'type' => [
                                'code' => Database::TYPE_INT64
                            ]
                        ], [
                            'name' => 'hello',
                            'type' => [
                                'code' => Database::TYPE_STRING
                            ]
                        ]
                    ]
                ]
            ]
        ], $res['paramTypes']);
    }

    public function testFormatParamsForExecuteSqlStructUnnamedFields()
    {
        $params = [
            'foo' => (new StructValue)
                ->addUnnamed('hello')
                ->addUnnamed(10)
                ->add('key', 'val')
                ->addUnnamed('goodbye')
        ];

        $types = [
            'foo' => (new StructType)
                ->add(null, Database::TYPE_STRING)
                ->addUnnamed(Database::TYPE_INT64)
                ->add('key', Database::TYPE_STRING)
                ->addUnnamed(Database::TYPE_STRING)
        ];

        $res = $this->mapper->formatParamsForExecuteSql($params, $types);

        $this->assertEquals([
            'foo' => [
                'hello', 10, 'val', 'goodbye'
            ]
        ], $res['params']);

        $this->assertEquals([
            'foo' => [
                'code' => Database::TYPE_STRUCT,
                'structType' => [
                    'fields' => [
                        [
                            'type' => [
                                'code' => Database::TYPE_STRING
                            ]
                        ], [
                            'type' => [
                                'code' => Database::TYPE_INT64
                            ]
                        ], [
                            'name' => 'key',
                            'type' => [
                                'code' => Database::TYPE_STRING
                            ]
                        ], [
                            'type' => [
                                'code' => Database::TYPE_STRING
                            ]
                        ]
                    ]
                ]
            ]
        ], $res['paramTypes']);
    }

    public function testFormatParamsForExecuteSqlInferredStructValueType()
    {
        $params = [
            'foo' => [
                'hello' => 'world',
                'foo' => 'bar',
                'num' => 10,
                'arr' => ['a', 'b']
            ]
        ];

        $types = [
            'foo' => (new StructType)
                ->add('hello', Database::TYPE_STRING)
                ->add('num', Database::TYPE_INT64)
        ];

        $res = $this->mapper->formatParamsForExecuteSql($params, $types);

        $this->assertEquals([
            'world', 'bar', 10, ['a', 'b']
        ], $res['params']['foo']);

        $this->assertEquals([
            [
                'name' => 'hello',
                'type' => ['code' => Database::TYPE_STRING]
            ], [
                'name' => 'foo',
                'type' => ['code' => Database::TYPE_STRING]
            ], [
                'name' => 'num',
                'type' => ['code' => Database::TYPE_INT64]
            ], [
                'name' => 'arr',
                'type' => [
                    'code' => Database::TYPE_ARRAY,
                    'arrayElementType' => [
                        'code' => Database::TYPE_STRING
                    ]
                ]
            ]
        ], $res['paramTypes']['foo']['structType']['fields']);
    }

    public function testFormatParamsForExecuteSqlInferredStructValueTypeWithUnnamed()
    {
        $params = [
            'foo' => (new StructValue)
                ->add('hello', 'world')
                ->addUnnamed('foo')
                ->add('num', 10)
        ];

        $types = [
            'foo' => (new StructType)
                ->add('hello', Database::TYPE_STRING)
                ->add('num', Database::TYPE_INT64)
        ];

        $res = $this->mapper->formatParamsForExecuteSql($params, $types);

        $this->assertEquals([
            'world', 'foo', 10
        ], $res['params']['foo']);

        $this->assertEquals([
            [
                'name' => 'hello',
                'type' => ['code' => Database::TYPE_STRING]
            ], [
                'type' => ['code' => Database::TYPE_STRING]
            ], [
                'name' => 'num',
                'type' => ['code' => Database::TYPE_INT64]
            ]
        ], $res['paramTypes']['foo']['structType']['fields']);
    }

    public function testFormatParamsForExecuteSqlStdClassValue()
    {
        $params = [
            'foo' => (object) [
                'hello' => 'world'
            ]
        ];

        $types = [
            'foo' => (new StructType)
                ->add('hello', Database::TYPE_STRING)
        ];

        $res = $this->mapper->formatParamsForExecuteSql($params, $types);

        $this->assertEquals([
            'foo' => ['world']
        ], $res['params']);

        $this->assertEquals([
            'foo' => [
                'code' => Database::TYPE_STRUCT,
                'structType' => [
                    'fields' => [
                        [
                            'name' => 'hello',
                            'type' => [
                                'code' => Database::TYPE_STRING
                            ]
                        ]
                    ]
                ]
            ]
        ], $res['paramTypes']);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Values of type `\stdClass` are interpreted as structs and must define their types.
     */
    public function testFormatParamsForExecuteSqlStdClassMissingDefinition()
    {
        $this->mapper->formatParamsForExecuteSql([
            'foo' => (object) ['foo' => 'bar']
        ]);
    }

    /**
     * @dataProvider simpleTypeValues
     * @group foo
     */
    public function testEncodeValuesAsSimpleType($value, $expected = null)
    {
        if ($expected === null) {
            $expected = $value;
        }

        $res = $this->mapper->encodeValuesAsSimpleType([$value]);
        $this->assertEquals($expected, $res[0]);
    }

    public function simpleTypeValues()
    {
        $dt = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $timestamp = new Timestamp($dt);

        return [
            [true],
            [55555, '55555'],
            [new Int64('55555'), '55555'],
            [3.1415],
            [NAN, 'NaN'],
            [INF, 'Infinity'],
            [-INF, '-Infinity'],
            [$timestamp, $dt->format(Timestamp::FORMAT)],
            [new Date($dt), $dt->format(Date::FORMAT)],
            ['foo'],
            [new Bytes('hello world'), base64_encode('hello world')],
            [['foo', 'bar']]
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDecodeValuesThrowsExceptionWithInvalidFormat()
    {
        $res = $this->mapper->decodeValues(
            $this->createField(Database::TYPE_STRING),
            $this->createRow(self::FORMAT_TEST_VALUE),
            'Not a real format'
        );
    }

    /**
     * @dataProvider formatProvider
     */
    public function testDecodeValuesReturnsVariedFormats($expectedOutput, $format)
    {
        $res = $this->mapper->decodeValues(
            $this->createField(Database::TYPE_STRING),
            $this->createRow(self::FORMAT_TEST_VALUE),
            $format
        );

        $this->assertEquals($expectedOutput, $res);
    }

    public function formatProvider()
    {
        return [
            [
                ['rowName' => self::FORMAT_TEST_VALUE],
                Result::RETURN_ASSOCIATIVE
            ],
            [
                [
                    [
                        'name' => 'rowName',
                        'value' => self::FORMAT_TEST_VALUE
                    ]
                ],
                Result::RETURN_NAME_VALUE_PAIR
            ],
            [
                [
                    0 => self::FORMAT_TEST_VALUE
                ],
                Result::RETURN_ZERO_INDEXED
            ],
        ];
    }

    public function testDecodeValuesBool()
    {
        $res = $this->mapper->decodeValues(
            $this->createField(Database::TYPE_BOOL),
            $this->createRow(false),
            Result::RETURN_ASSOCIATIVE
        );
        $this->assertFalse($res['rowName']);
    }

    public function testDecodeValuesInt()
    {
        $res = $this->mapper->decodeValues(
            $this->createField(Database::TYPE_INT64),
            $this->createRow('555'),
            Result::RETURN_ASSOCIATIVE
        );
        $this->assertEquals(555, $res['rowName']);
    }

    public function testDecodeValuesInt64Object()
    {
        $mapper = new ValueMapper(true);
        $res = $mapper->decodeValues(
            $this->createField(Database::TYPE_INT64),
            $this->createRow('555'),
            Result::RETURN_ASSOCIATIVE
        );
        $this->assertInstanceOf(Int64::class, $res['rowName']);
        $this->assertEquals('555', $res['rowName']->get());
    }

    public function testDecodeValuesFloat()
    {
        $res = $this->mapper->decodeValues(
            $this->createField(Database::TYPE_FLOAT64),
            $this->createRow(3.1415),
            Result::RETURN_ASSOCIATIVE
        );
        $this->assertEquals(3.1415, $res['rowName']);
    }

    public function testDecodeValuesFloatNaN()
    {
        $res = $this->mapper->decodeValues(
            $this->createField(Database::TYPE_FLOAT64),
            $this->createRow('NaN'),
            Result::RETURN_ASSOCIATIVE
        );
        $this->assertTrue(is_nan($res['rowName']));
    }

    public function testDecodeValuesFloatInfinity()
    {
        $res = $this->mapper->decodeValues(
            $this->createField(Database::TYPE_FLOAT64),
            $this->createRow('Infinity'),
            Result::RETURN_ASSOCIATIVE
        );

        $this->assertTrue(is_infinite($res['rowName']));
        $this->assertGreaterThan(0, $res['rowName']);
    }

    public function testDecodeValuesFloatNegativeInfinity()
    {
        $res = $this->mapper->decodeValues(
            $this->createField(Database::TYPE_FLOAT64),
            $this->createRow('-Infinity'),
            Result::RETURN_ASSOCIATIVE
        );

        $this->assertTrue(is_infinite($res['rowName']));
        $this->assertLessThan(0, $res['rowName']);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testDecodeValuesFloatError()
    {
        $res = $this->mapper->decodeValues(
            $this->createField(Database::TYPE_FLOAT64),
            $this->createRow('foo'),
            Result::RETURN_ASSOCIATIVE
        );
    }

    public function testDecodeValuesString()
    {
        $res = $this->mapper->decodeValues(
            $this->createField(Database::TYPE_STRING),
            $this->createRow('foo'),
            Result::RETURN_ASSOCIATIVE
        );
        $this->assertEquals('foo', $res['rowName']);
    }

    public function testDecodeValuesTimestamp()
    {
        $dt = new \DateTime;
        $str = $dt->format(Timestamp::FORMAT);

        $res = $this->mapper->decodeValues(
            $this->createField(Database::TYPE_TIMESTAMP),
            $this->createRow($str),
            Result::RETURN_ASSOCIATIVE
        );

        $this->assertInstanceOf(Timestamp::class, $res['rowName']);
        $this->assertEquals($str, $res['rowName']->formatAsString());
    }

    public function testDecodeValuesDate()
    {
        $dt = new \DateTime;
        $res = $this->mapper->decodeValues(
            $this->createField(Database::TYPE_DATE),
            $this->createRow($dt->format(Date::FORMAT)),
            Result::RETURN_ASSOCIATIVE
        );

        $this->assertInstanceOf(Date::class, $res['rowName']);
        $this->assertEquals($dt->format(Date::FORMAT), $res['rowName']->formatAsString());
    }

    public function testDecodeValuesBytes()
    {
        $res = $this->mapper->decodeValues(
            $this->createField(Database::TYPE_BYTES),
            $this->createRow(base64_encode('hello world')),
            Result::RETURN_ASSOCIATIVE
        );

        $this->assertInstanceOf(Bytes::class, $res['rowName']);
        $this->assertEquals('hello world', $res['rowName']->get());
    }

    public function testDecodeValuesArray()
    {
        $res = $this->mapper->decodeValues(
            $this->createField(Database::TYPE_ARRAY, 'arrayElementType', [
                'code' => Database::TYPE_STRING
            ]),
            $this->createRow(['foo', 'bar']),
            Result::RETURN_ASSOCIATIVE
        );

        $this->assertEquals('foo', $res['rowName'][0]);
        $this->assertEquals('bar', $res['rowName'][1]);
    }

    public function testDecodeValuesStruct()
    {
        $field = [
            'name' => 'structTest',
            'type' => [
                'code' => Database::TYPE_ARRAY,
                'arrayElementType' => [
                    'code' => Database::TYPE_STRUCT,
                    'structType' => [
                        'fields' => [
                            [
                                'name' => 'rowName',
                                'type' => [
                                    'code' => Database::TYPE_STRING
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $row = [
            [
                'Hello World'
            ]
        ];

        $res = $this->mapper->decodeValues(
            [$field],
            [$row],
            Result::RETURN_ASSOCIATIVE
        );

        $this->assertEquals('Hello World', $res['structTest'][0]['rowName']);
    }

    public function testDecodeValuesAnonymousField()
    {
        $fields = [
            [
                'name' => 'ID',
                'type' => [
                    'code' => Database::TYPE_INT64,
                ]
            ], [
                'type' => [
                    'code' => Database::TYPE_STRING
                ]
            ]
        ];

        $row = ['1337', 'John'];

        $res = $this->mapper->decodeValues($fields, $row, Result::RETURN_ASSOCIATIVE);

        $this->assertEquals('1337', $res['ID']);
        $this->assertEquals('John', $res[1]);
    }

    private function createField($code, $type = null, array $typeObj = [])
    {
        return [[
            'name' => 'rowName',
            'type' => array_filter([
                'code' => $code,
                $type => $typeObj
            ])
        ]];
    }

    private function createRow($val)
    {
        return [$val];
    }
}
