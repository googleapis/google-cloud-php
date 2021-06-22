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

namespace Google\Cloud\Spanner\Tests\System;

use Google\Cloud\Core\Int64;
use Google\Cloud\Spanner\ArrayType;
use Google\Cloud\Spanner\Bytes;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Date;
use Google\Cloud\Spanner\Numeric;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\StructType;
use Google\Cloud\Spanner\StructValue;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\V1\RequestOptions\Priority;

/**
 * @group spanner
 * @group spanner-query
 */
class QueryTest extends SpannerTestCase
{
    /**
     * covers 19
     */
    public function testSelect1()
    {
        $db = self::$database;

        $res = $db->execute('SELECT 1');
        $row = $res->rows()->current();

        $this->assertEquals(1, $row[0]);
    }

    public function testSelect1WithRequestOptions()
    {
        $db = self::$database;

        $res = $db->execute('SELECT 1', [
            'requestOptions' => [
                'priority' => Priority::PRIORITY_LOW
            ]
        ]);
        $row = $res->rows()->current();

        $this->assertEquals(1, $row[0]);
    }

    /**
     * covers 20
     * @expectedException Google\Cloud\Core\Exception\BadRequestException
     */
    public function testInvalidQueryFails()
    {
        $db = self::$database;

        $db->execute('badquery')->rows()->current();
    }
    /**
     * covers 21
     */
    public function testQueryReturnsArrayStruct()
    {
        $db = self::$database;

        $res = $db->execute('SELECT ARRAY(SELECT STRUCT(1, 2))');
        $row = $res->rows()->current();
        $this->assertEquals($row[0][0], [1,2]);
    }

    /**
     * covers 22
     */
    public function testQueryReturnsEmptyArrayStruct()
    {
        $db = self::$database;

        $res = $db->execute('SELECT ARRAY(SELECT STRUCT())');
        $row = $res->rows()->current();
        $this->assertEquals($row[0], [[]]);
    }

    /**
     * covers 23
     */
    public function testBindBoolParameter()
    {
        $db = self::$database;

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => true
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertTrue($row['foo']);
    }

    /**
     * covers 24
     */
    public function testBindBoolParameterNull()
    {
        $db = self::$database;

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => null
            ],
            'types' => [
                'param' => Database::TYPE_BOOL
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertNull($row['foo']);
    }

    /**
     * covers 25
     */
    public function testBindInt64Parameter()
    {
        $db = self::$database;

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => 1337
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertEquals(1337, $row['foo']);
    }

    /**
     * covers 25
     */
    public function testBindInt64ParameterWithInt64Class()
    {
        $db = self::$database;

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => new Int64('1337')
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertEquals(1337, $row['foo']);
    }

    /**
     * covers 26
     */
    public function testBindNullIntParameter()
    {
        $db = self::$database;

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => null
            ],
            'types' => [
                'param' => Database::TYPE_INT64
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertNull($row['foo']);
    }

    /**
     * covers 27
     */
    public function testBindFloat64Parameter()
    {
        $db = self::$database;

        $pi = 3.1415;
        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => $pi
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertEquals($pi, $row['foo']);
    }

    /**
     * covers 28
     */
    public function testBindFloat64ParameterNull()
    {
        $db = self::$database;

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => null
            ],
            'types' => [
                'param' => Database::TYPE_FLOAT64
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertNull($row['foo']);
    }

    /**
     * covers 29
     */
    public function testBindStringParameter()
    {
        $db = self::$database;

        $str = 'hello world';
        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => $str
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertEquals($str, $row['foo']);
    }

    /**
     * covers 30
     */
    public function testBindStringParameterNull()
    {
        $db = self::$database;

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => null
            ],
            'types' => [
                'param' => Database::TYPE_STRING
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertNull($row['foo']);
    }

    public function testBindNumericParameter()
    {
        $this->skipEmulatorTests();
        $db = self::$database;

        $str = '0.987654321';
        $numeric = new Numeric($str);
        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => $numeric
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertInstanceOf(Numeric::class, $row['foo']);
        $this->assertEquals($str, $numeric->formatAsString());
        $this->assertEquals($str, (string)$numeric->get());
    }

    public function testBindNumericParameterNull()
    {
        $this->skipEmulatorTests();
        $db = self::$database;

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => null
            ],
            'types' => [
                'param' => Database::TYPE_NUMERIC
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertNull($row['foo']);
    }

    /**
     * covers 31
     */
    public function testBindBytesParameter()
    {
        $db = self::$database;

        $str = 'hello world';
        $bytes = new Bytes($str);
        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => $bytes
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertInstanceOf(Bytes::class, $row['foo']);
        $this->assertEquals($str, base64_decode($bytes->formatAsString()));
        $this->assertEquals($str, (string)$bytes->get());
    }

    /**
     * covers 32
     */
    public function testBindBytesParameterNull()
    {
        $db = self::$database;

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => null
            ],
            'types' => [
                'param' => Database::TYPE_BYTES
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertNull($row['foo']);
    }

    /**
     * covers 33
     */
    public function testBindTimestampParameter()
    {
        $db = self::$database;

        $ts = new Timestamp(new \DateTimeImmutable('now', new \DateTimeZone('UTC')));

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => $ts
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertInstanceOf(Timestamp::class, $row['foo']);
        $this->assertEquals($ts->get()->format('r'), $row['foo']->get()->format('r'));
    }

    /**
     * covers 34
     */
    public function testBindTimestampParameterNull()
    {
        $db = self::$database;

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => null
            ],
            'types' => [
                'param' => Database::TYPE_TIMESTAMP
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertNull($row['foo']);
    }

    /**
     * covers 35
     */
    public function testBindDateParameter()
    {
        $db = self::$database;

        $ts = new Date(new \DateTimeImmutable);

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => $ts
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertInstanceOf(Date::class, $row['foo']);
        $this->assertEquals($ts->get()->format('Y-m-d'), $row['foo']->get()->format('Y-m-d'));
    }

    /**
     * covers 36
     */
    public function testBindDateParameterNull()
    {
        $db = self::$database;

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => null
            ],
            'types' => [
                'param' => Database::TYPE_DATE
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertNull($row['foo']);
    }

    /**
     * covers 37
     * covers 40
     * covers 43
     * covers 46
     * covers 49
     * covers 52
     * covers 55
     * @dataProvider arrayTypes
     */
    public function testBindArrayOfType($value, $result = null, $resultType = null, callable $filter = null)
    {
        if ($resultType == Numeric::class) {
            $this->skipEmulatorTests();
        }

        if (!$filter) {
            $filter = function ($val) {
                return $val;
            };
        }

        $db = self::$database;

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => $value
            ]
        ]);

        $row = $res->rows()->current();
        $param = $filter($row['foo']);

        if ($resultType) {
            $this->assertContainsOnlyInstancesOf($resultType, $row['foo']);
        }

        $this->assertEquals($param, $result ?: $value);
    }

    /**
     * covers 41
     * covers 44
     * covers 47
     * covers 50
     * covers 53
     * covers 56
     * @dataProvider arrayTypesEmpty
     */
    public function testBindEmptyArrayOfTypeLegacy($type)
    {
        if ($type == Database::TYPE_NUMERIC) {
            $this->skipEmulatorTests();
        }

        $db = self::$database;

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => []
            ],
            'types' => [
                'param' => [Database::TYPE_ARRAY, $type]
            ]
        ]);

        $row = $res->rows()->current();

        $this->assertEmpty($row['foo']);
    }

    /**
     * covers 41
     * covers 44
     * covers 47
     * covers 50
     * covers 53
     * covers 56
     * @dataProvider arrayTypesEmpty
     */
    public function testBindEmptyArrayOfType($type)
    {
        if ($type == Database::TYPE_NUMERIC) {
            $this->skipEmulatorTests();
        }
        $db = self::$database;

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => []
            ],
            'types' => [
                'param' => new ArrayType($type)
            ]
        ]);

        $row = $res->rows()->current();

        $this->assertEmpty($row['foo']);
    }

    /**
     * covers 39
     * covers 42
     * covers 45
     * covers 48
     * covers 51
     * covers 54
     * covers 56
     * @dataProvider arrayTypesNull
     */
    public function testBindNullArrayOfTypeLegacy($type)
    {
        if ($type == Database::TYPE_NUMERIC) {
            $this->skipEmulatorTests();
        }

        $db = self::$database;

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => null
            ],
            'types' => [
                'param' => [Database::TYPE_ARRAY, $type]
            ]
        ]);

        $row = $res->rows()->current();

        $this->assertNull($row['foo']);
    }

    /**
     * covers 39
     * covers 42
     * covers 45
     * covers 48
     * covers 51
     * covers 54
     * covers 56
     * @dataProvider arrayTypesNull
     */
    public function testBindNullArrayOfType($type)
    {
        if ($type == Database::TYPE_NUMERIC) {
            $this->skipEmulatorTests();
        }

        $db = self::$database;

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => null
            ],
            'types' => [
                'param' => new ArrayType($type)
            ]
        ]);

        $row = $res->rows()->current();

        $this->assertNull($row['foo']);
    }

    /**
     * covers 58
     */
    public function testQueryInfinity()
    {
        $db = self::$database;

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => INF
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertEquals(INF, $row['foo']);
    }

    /**
     * covers 59
     */
    public function testQueryNegativeInfinity()
    {
        $db = self::$database;

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => -INF
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertEquals(-INF, $row['foo']);
    }

    /**
     * covers 60
     */
    public function testQueryNotANumber()
    {
        $db = self::$database;

        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => NAN
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertTrue(is_nan($row['foo']));
    }

    /**
     * covers 61
     */
    public function testQueryArrayOfSpecialFloatValues()
    {
        $db = self::$database;

        $vals = [INF, -INF, NAN];
        $res = $db->execute('SELECT @param as foo', [
            'parameters' => [
                'param' => $vals
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertEquals($vals[0], $row['foo'][0]);
        $this->assertEquals($vals[1], $row['foo'][1]);
        $this->assertTrue(is_nan($row['foo'][2]));
    }

    public function arrayTypes()
    {
        return [
            // boolean (covers 37)
            [[true,true,false]],

            // int64 (covers 40)
            [[5,4,3,2,1]],

            // float64 (covers 43)
            [[3.14, 4.13, 1.43]],

            // string (covers 46)
            [['hello','world','google','cloud']],

            // bytes (covers 49)
            [
                [new Bytes('hello'), new Bytes('world'), new Bytes('google'), new Bytes('cloud')],
                ['hello', 'world', 'google', 'cloud'],
                Bytes::class,
                function (array $res) {
                    foreach ($res as $idx => $val) {
                        $res[$idx] = (string) $val->get();
                    }

                    return $res;
                }
            ],

            // timestamp (covers 52)
            [
                [
                    new Timestamp(new \DateTime('2010-01-01')),
                    new Timestamp(new \DateTime('2011-01-01')),
                    new Timestamp(new \DateTime('2012-01-01'))
                ],
                ['2010-01-01', '2011-01-01', '2012-01-01'],
                Timestamp::class,
                function (array $res) {
                    foreach ($res as $idx => $val) {
                        $res[$idx] = $val->get()->format('Y-m-d');
                    }

                    return $res;
                }
            ],

            // date (covers 55)
            [
                [
                    new Date(new \DateTime('2010-01-01')),
                    new Date(new \DateTime('2011-01-01')),
                    new Date(new \DateTime('2012-01-01'))
                ],
                ['2010-01-01', '2011-01-01', '2012-01-01'],
                Date::class,
                function (array $res) {
                    foreach ($res as $idx => $val) {
                        $res[$idx] = $val->get()->format('Y-m-d');
                    }

                    return $res;
                }
            ],

            // numeric
            [
                [
                    new Numeric('0.987654321'),
                    new Numeric('123456789'),
                    new Numeric('1234567890.123456789')
                ],
                ['0.987654321', '123456789', '1234567890.123456789'],
                Numeric::class,
                function (array $res) {
                    foreach ($res as $idx => $val) {
                        $res[$idx] = $val->get();
                    }

                    return $res;
                }
            ]
        ];
    }

    public function arrayTypesEmpty()
    {
        return [
            [Database::TYPE_BOOL],
            [Database::TYPE_INT64],
            [Database::TYPE_FLOAT64],
            [Database::TYPE_STRING],
            [Database::TYPE_BYTES],
            [Database::TYPE_TIMESTAMP],
            [Database::TYPE_DATE],
            [Database::TYPE_NUMERIC],
        ];
    }

    public function arrayTypesNull()
    {
        return [
            [Database::TYPE_BOOL],
            [Database::TYPE_INT64],
            [Database::TYPE_FLOAT64],
            [Database::TYPE_STRING],
            [Database::TYPE_BYTES],
            [Database::TYPE_TIMESTAMP],
            [Database::TYPE_DATE],
            [Database::TYPE_NUMERIC],
        ];
    }

    /**
     * @group spanner-query-struct
     */
    public function testBindStructParameter()
    {
        $db = self::$database;

        $res = $db->execute('SELECT @structParam.userf, @p4', [
            'parameters' => [
                'structParam' => [
                    'userf' => 'bob',
                    'threadf' => 1
                ],
                'p4' => 10
            ],
            'types' => [
                'structParam' => (new StructType)
                    ->add('userf', Database::TYPE_STRING)
                    ->add('threadf', Database::TYPE_INT64)
            ]
        ]);

        $row = $res->rows()->current();

        $this->assertEquals('bob', $row['userf']);
        $this->assertEquals(10, $row[1]);
    }

    /**
     * @group spanner-query-struct
     */
    public function testBindNullStructParameter()
    {
        $db = self::$database;

        $res = $db->execute('SELECT @structParam.userf', [
            'parameters' => [
                'structParam' => null
            ],
            'types' => [
                'structParam' => (new StructType)
                    ->add('userf', Database::TYPE_STRING)
                    ->add('threadf', Database::TYPE_INT64)
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertNull($row['userf']);
    }

    /**
     * @group spanner-query-struct
     */
    public function testBindNestedStructParameter()
    {
        $db = self::$database;

        $res = $db->execute('SELECT @structParam.structf.nestedf', [
            'parameters' => [
                'structParam' => [
                    'structf' => [
                        'nestedf' => 'bob'
                    ]
                ]
            ],
            'types' => [
                'structParam' => (new StructType)
                    ->add(
                        'structf',
                        (new StructType)->add('nestedf', Database::TYPE_STRING)
                    )
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertEquals('bob', $row['nestedf']);
    }

    /**
     * @group spanner-query-struct
     */
    public function testBindNullNestedStructParameter()
    {
        $db = self::$database;

        $res = $db->execute('SELECT @structParam.structf.nestedf', [
            'parameters' => [
                'structParam' => null
            ],
            'types' => [
                'structParam' => (new StructType)
                    ->add(
                        'structf',
                        (new StructType)->add('nestedf', Database::TYPE_STRING)
                    )
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertNull($row['nestedf']);
    }

    /**
     * @group spanner-query-struct
     */
    public function testBindEmptyStructParameter()
    {
        $db = self::$database;
        $res = $db->execute('SELECT @structParam IS NULL', [
            'parameters' => [
                'structParam' => []
            ],
            'types' => [
                'structParam' => new StructType
            ]
        ]);

        $row = $res->rows()->current();

        $this->assertFalse($row[0]);
    }

    /**
     * @group spanner-query-struct
     */
    public function testBindStructNoFieldsParameter()
    {
        $db = self::$database;
        $res = $db->execute('SELECT @structParam IS NULL', [
            'parameters' => [
                'structParam' => null
            ],
            'types' => [
                'structParam' => new StructType
            ]
        ]);

        $row = $res->rows()->current();

        $this->assertTrue($row[0]);
    }

    /**
     * @group spanner-query-struct
     */
    public function testBindStructParameterNullFields()
    {
        $db = self::$database;
        $res = $db->execute('SELECT @structParam.f1', [
            'parameters' => [
                'structParam' => [
                    'f1' => null
                ]
            ],
            'types' => [
                'structParam' => (new StructType)
                    ->add('f1', Database::TYPE_INT64)
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertNull($row['f1']);
    }

    /**
     * @group spanner-query-struct
     */
    public function testBindStructParameterEqualityCheck()
    {
        $db = self::$database;
        $res = $db->execute('SELECT @structParam = STRUCT<threadf INT64, userf STRING>(1, "bob")', [
            'parameters' => [
                'structParam' => [
                    'threadf' => 1,
                    'userf' => 'bob',
                ]
            ],
            'types' => [
                'structParam' => (new StructType)
                    ->add('threadf', Database::TYPE_INT64)
                    ->add('userf', Database::TYPE_STRING)
            ]
        ]);

        $row = $res->rows()->current();
    }

    /**
     * @group spanner-query-struct
     */
    public function testBindStructParameterNullCheck()
    {
        $db = self::$database;
        $res = $db->execute('SELECT @structParam IS NULL', [
            'parameters' => [
                'structParam' => [
                    'userf' => 'bob',
                    'threadf' => 1
                ]
            ],
            'types' => [
                'structParam' => (new StructType)
                    ->add('userf', Database::TYPE_STRING)
                    ->add('threadf', Database::TYPE_INT64)
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertFalse($row[0]);
    }

    /**
     * @group spanner-query-struct
     */
    public function testBindArrayOfStructsParameter()
    {
        $db = self::$database;
        $res = $db->execute('SELECT a.threadid FROM UNNEST(@structParam.arraysf) a', [
            'parameters' => [
                'structParam' => [
                    'intf' => 10,
                    'arraysf' => [
                        [
                            'threadid' => 1
                        ]
                    ]
                ],
            ],
            'types' => [
                'structParam' => (new StructType)
                    ->add('arraysf', new ArrayType(
                        (new StructType)->add('threadid', Database::TYPE_INT64)
                    ))
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertEquals(1, $row['threadid']);
    }

    /**
     * @group spanner-query-struct
     */
    public function testBindArrayOfStructsNullParameter()
    {
        $db = self::$database;
        $res = $db->execute('SELECT a.threadid FROM UNNEST(@structParam.arraysf) a', [
            'parameters' => [
                'structParam' => [
                    'intf' => 10,
                    'arraysf' => null
                ],
            ],
            'types' => [
                'structParam' => (new StructType)
                    ->add('arraysf', new ArrayType(
                        (new StructType)->add('threadid', Database::TYPE_INT64)
                    ))
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertNull($row);
    }

    /**
     * @group spanner-query-struct
     */
    public function testBindNullArrayOfStructsParameter()
    {
        $db = self::$database;
        $res = $db->execute('SELECT a.threadid FROM UNNEST(@structParam.arraysf) a', [
            'parameters' => [
                'structParam' => null
            ],
            'types' => [
                'structParam' => (new StructType)
                    ->add('arraysf', new ArrayType(
                        (new StructType)->add('threadid', Database::TYPE_INT64)
                    ))
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertNull($row);
    }

    /**
     * @group spanner-query-struct
     */
    public function testBindArrayOfStructsDuplicateFieldName()
    {
        $db = self::$database;
        $res = $db->execute('SELECT * FROM UNNEST(ARRAY(SELECT @structParam))', [
            'parameters' => [
                'structParam' => (new StructValue)
                    ->add('hello', 'world')
                    ->add('foo', 'bar')
                    ->add('foo', 2)
            ],
            'types' => [
                'structParam' => (new StructType)
                    ->add('hello', Database::TYPE_STRING)
                    ->add('foo', Database::TYPE_STRING)
                    ->add('foo', Database::TYPE_INT64)
            ]
        ])->rows(Result::RETURN_NAME_VALUE_PAIR)->current();

        $this->assertEquals([
            'name' => 'hello',
            'value' => 'world'
        ], $res[0]);

        $this->assertEquals([
            'name' => 'foo',
            'value' => 'bar'
        ], $res[1]);

        $this->assertEquals([
            'name' => 'foo',
            'value' => 2
        ], $res[2]);
    }

    /**
     * @group spanner-query-struct
     */
    public function testBindStructWithMixedUnnamedParameters()
    {
        $db = self::$database;
        $res = $db->execute('SELECT * FROM UNNEST(ARRAY(SELECT @structParam))', [
            'parameters' => [
                'structParam' => (new StructValue)
                    ->addUnnamed(1)
                    ->add('f1', 2)
                    ->addUnnamed([
                        'a','b','c'
                    ])
            ],
            'types' => [
                'structParam' => (new StructType)
                    ->addUnnamed(Database::TYPE_INT64)
                    ->add('f1', Database::TYPE_INT64)
                    ->addUnnamed(new ArrayType(Database::TYPE_STRING))
            ]
        ])->rows()->current();

        $this->assertEquals(1, $res[0]);
        $this->assertEquals(2, $res['f1']);
        $this->assertEquals([
            'a','b','c'
        ], $res[2]);
    }

    /**
     * @group spanner-query-struct
     */
    public function testBindStructWithAllUnnamedParameters()
    {
        $db = self::$database;
        $res = $db->execute('SELECT * FROM UNNEST(ARRAY(SELECT @structParam))', [
            'parameters' => [
                'structParam' => (new StructValue)
                    ->addUnnamed(1)
                    ->addUnnamed('field')
                    ->addUnnamed([
                        'a','b','c'
                    ])
                    ->addUnnamed(false)
            ],
            'types' => [
                'structParam' => (new StructType)
                    ->addUnnamed(Database::TYPE_INT64)
                    ->addUnnamed(Database::TYPE_STRING)
                    ->addUnnamed(new ArrayType(Database::TYPE_STRING))
                    ->addUnnamed(Database::TYPE_BOOL)
            ]
        ])->rows()->current();

        $this->assertEquals(1, $res[0]);
        $this->assertEquals('field', $res[1]);
        $this->assertEquals([
            'a','b','c'
        ], $res[2]);
        $this->assertFalse($res[3]);
    }

    public function testBindStructInferredParameterTypes()
    {
        $values = [
            'arr' => ['a', 'b'],
            'str' => 'hello',
            'num' => 10,
        ];

        $db = self::$database;
        $res = $db->execute('SELECT * FROM UNNEST(ARRAY(SELECT @structParam))', [
            'parameters' => [
                'structParam' => $values
            ],
            'types' => [
                'structParam' => (new StructType)
                    ->add('str', Database::TYPE_STRING)
            ]
        ])->rows()->current();

        $this->assertEquals($values, $res);
    }

    public function testBindStructInferredParameterTypesWithUnnamed()
    {
        $values = [
            'arr' => ['a', 'b'],
            'str' => 'hello',
            'num' => 10,
        ];

        $db = self::$database;
        $res = $db->execute('SELECT * FROM UNNEST(ARRAY(SELECT @structParam))', [
            'parameters' => [
                'structParam' => (new StructValue)
                    ->add('arr', ['a', 'b'])
                    ->addUnnamed('hello')
                    ->addUnnamed(10)
                    ->add('str', 'world')
            ],
            'types' => [
                'structParam' => (new StructType)
                    ->add('str', Database::TYPE_STRING)
            ]
        ])->rows(Result::RETURN_NAME_VALUE_PAIR)->current();

        $this->assertEquals([
            [
                'name' => 'arr',
                'value' => ['a', 'b']
            ], [
                'name' => 1,
                'value' => 'hello',
            ], [
                'name' => 2,
                'value' => 10
            ], [
                'name' => 'str',
                'value' => 'world'
            ]
        ], $res);
    }
}
