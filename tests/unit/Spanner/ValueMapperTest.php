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

namespace Google\Cloud\Tests\Unit\Spanner;

use Google\Cloud\Core\Int64;
use Google\Cloud\Spanner\Bytes;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Date;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\ValueMapper;
use Google\Cloud\Tests\GrpcTestTrait;

/**
 * @group spanner
 */
class ValueMapperTest extends \PHPUnit_Framework_TestCase
{
    use GrpcTestTrait;
    
    const FORMAT_TEST_VALUE = 'abc';

    private $mapper;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();
        $this->mapper = new ValueMapper(false);
    }

    public function testFormatParamsForExecuteSqlSimpleTypes()
    {
        $params = [
            'id' => 1,
            'name' => 'john',
            'pi' => 3.1515,
            'isCool' => false,
        ];

        $res = $this->mapper->formatParamsForExecuteSql($params);

        $this->assertEquals($params, $res['params']);
        $this->assertEquals(Database::TYPE_INT64, $res['paramTypes']['id']['code']);
        $this->assertEquals(Database::TYPE_STRING, $res['paramTypes']['name']['code']);
        $this->assertEquals(Database::TYPE_FLOAT64, $res['paramTypes']['pi']['code']);
        $this->assertEquals(Database::TYPE_BOOL, $res['paramTypes']['isCool']['code']);
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
     * @expectedException BadMethodCallException
     */
    public function testFormatParamsForExecuteSqlArrayInvalidAssoc()
    {
        $this->mapper->formatParamsForExecuteSql(['array' => [
            'foo' => 'bar'
        ]]);
    }

    /**
     * @expectedException BadMethodCallException
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

    public function testEncodeValuesAsSimpleType()
    {
        $dt = new \DateTime;

        $vals = [];
        $vals['bool'] = true;
        $vals['int'] = 555555;
        $vals['intObj'] = new Int64((string) $vals['int']);
        $vals['float'] = 3.1415;
        $vals['nan'] = NAN;
        $vals['inf'] = INF;
        $vals['timestamp'] = new Timestamp($dt);
        $vals['date'] = new Date($dt);
        $vals['string'] = 'foo';
        $vals['bytes'] = new Bytes('hello world');
        $vals['array'] = ['foo', 'bar'];

        $res = $this->mapper->encodeValuesAsSimpleType($vals);

        $this->assertTrue($res[0]);
        $this->assertEquals((string) $vals['int'], $res[1]);
        $this->assertEquals((string) $vals['int'], $res[2]);
        $this->assertEquals($vals['float'], $res[3]);
        $this->assertEquals('Infinity', $res[5]);
        $this->assertEquals($dt->format(Timestamp::FORMAT), $res[6]);
        $this->assertEquals($dt->format(Date::FORMAT), $res[7]);
        $this->assertEquals($vals['string'], $res[8]);
        $this->assertEquals(base64_encode('hello world'), $res[9]);
        $this->assertEquals($vals['array'], $res[10]);
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
        $this->assertEquals(false, $res['rowName']);
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
        $this->assertTrue($res['rowName'] > 0);
    }

    public function testDecodeValuesFloatNegativeInfinity()
    {
        $res = $this->mapper->decodeValues(
            $this->createField(Database::TYPE_FLOAT64),
            $this->createRow('-Infinity'),
            Result::RETURN_ASSOCIATIVE
        );

        $this->assertTrue(is_infinite($res['rowName']));
        $this->assertTrue($res['rowName'] < 0);
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
        $res = $this->mapper->decodeValues(
            $this->createField(Database::TYPE_TIMESTAMP),
            $this->createRow($dt->format(Timestamp::FORMAT)),
            Result::RETURN_ASSOCIATIVE
        );

        $this->assertInstanceOf(Timestamp::class, $res['rowName']);
        $this->assertEquals($dt->format(Timestamp::FORMAT), $res['rowName']->formatAsString());
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
