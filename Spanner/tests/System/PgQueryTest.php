<?php
/**
 * Copyright 2022 Google Inc.
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
use Google\Cloud\Spanner\PgNumeric;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\RequestOptions\Priority;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group spanner
 * @group spanner-query
 * @group spanner-postgres
 */
class PgQueryTest extends SpannerPgTestCase
{
    use ExpectException;

    const TABLE_NAME = 'test';

    public static $timestampVal;

    public static function set_up_before_class()
    {
        parent::set_up_before_class();

        self::$database->updateDdl(
            'CREATE TABLE ' . self::TABLE_NAME . ' (
                id bigint NOT NULL,
                name varchar(1024),
                registered bool,
                age numeric,
                rating float,
                bytes_col bytea,
                created_at timestamptz,
                dt date,
                PRIMARY KEY (id)
            )'
        )->pollUntilComplete();

        self::$timestampVal = new Timestamp(new \DateTime);

        self::$database->insertOrUpdateBatch(self::TABLE_NAME, [
            [
                'id' => 1,
                'name' => 'Alice',
                'registered' => false,
                'rating' => 4.2,
                'age' => 22,
                'bytes_col' => new Bytes('hello'),
                'created_at' => self::$timestampVal,
                'dt' => '2020-01-01'
            ],
            [
                'id' => 2,
                'name' => 'Bruce',
                'registered' => false,
                'rating' => 5.0,
                'age' => 26,
                'created_at' => self::$timestampVal,
                'dt' => '2021-01-01'
            ]
        ]);
    }

    public function testSelect1()
    {
        $db = self::$database;

        $res = $db->execute('SELECT 1 AS foo');
        $row = $res->rows()->current();

        $this->assertEquals(1, $row['foo']);
    }

    public function testSelect1WithRequestOptions()
    {
        $db = self::$database;

        $res = $db->execute('SELECT 1 AS foo', [
            'requestOptions' => [
                'priority' => Priority::PRIORITY_LOW
            ]
        ]);
        $row = $res->rows()->current();

        $this->assertEquals(1, $row['foo']);
    }

    public function testInvalidQueryFails()
    {
        $this->expectException('Google\Cloud\Core\Exception\BadRequestException');

        $db = self::$database;

        $db->execute('badquery')->rows()->current();
    }

    public function testBindBoolParameter()
    {
        $db = self::$database;

        $res = $db->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE registered = $1', [
            'parameters' => [
                'p1' => false
            ]
        ]);

        $this->assertCount(2, iterator_to_array($res));
    }

    public function testBindBoolParameterNull()
    {
        // insert a value with a bool param binded to null
        self::$database->runTransaction(function (Transaction $t) {
            $t->executeUpdate(
                'INSERT INTO ' . self::TABLE_NAME . '(id, name, registered, rating, age) '
                . 'VALUES($1, $2, $3, $4, $5)',
                [
                    'parameters' => [
                        'p1' => 3,
                        'p2' => 'Rock',
                        'p3' => null,
                        'p4' => 5.0,
                        'p5' => 26
                    ],
                    'types' => [
                        'p3' => Database::TYPE_BOOL
                    ]
                ]
            );
            $t->commit();
        });

        $res = self::$database->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE registered IS NULL');

        $this->assertCount(1, iterator_to_array($res));
    }

    public function testBindInt64Parameter()
    {
        $db = self::$database;

        $res = $db->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = $1 OR id = $2', [
            'parameters' => [
                'p1' => 1,
                'p2' => 2
            ]
        ]);

        $this->assertCount(2, iterator_to_array($res));
    }

    public function testBindInt64ParameterWithInt64Class()
    {
        $db = self::$database;

        $res = $db->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = $1', [
            'parameters' => [
                'p1' => new Int64('1')
            ]
        ]);

        $this->assertCount(1, iterator_to_array($res));
    }

    public function testBindFloat64Parameter()
    {
        $db = self::$database;

        $res = $db->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE rating = $1', [
            'parameters' => [
                'p1' => 5.0
            ]
        ]);

        $this->assertCount(2, iterator_to_array($res));
    }

    public function testBindFloat64ParameterNull()
    {
        // insert a value with a float param binded to null
        self::$database->runTransaction(function (Transaction $t) {
            $t->executeUpdate(
                'INSERT INTO ' . self::TABLE_NAME . '(id, name, registered, rating, age) '
                . 'VALUES($1, $2, $3, $4, $5)',
                [
                    'parameters' => [
                        'p1' => 5,
                        'p2' => 'Vince',
                        'p3' => true,
                        'p4' => null,
                        'p5' => 26
                    ],
                    'types' => [
                        'p4' => Database::TYPE_FLOAT64
                    ]
                ]
            );
            $t->commit();
        });

        $res = self::$database->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE rating IS NULL');

        $this->assertCount(1, iterator_to_array($res));
    }

    public function testBindStringParameter()
    {
        $res = self::$database->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE name = $1', [
            'parameters' => [
                'p1' => 'Alice'
            ]
        ]);

        $this->assertCount(1, iterator_to_array($res));
    }

    public function testBindStringParameterNull()
    {
        // insert a value with a string param binded to null
        self::$database->runTransaction(function (Transaction $t) {
            $t->executeUpdate(
                'INSERT INTO ' . self::TABLE_NAME . '(id, name, registered, rating, age) '
                . 'VALUES($1, $2, $3, $4, $5)',
                [
                    'parameters' => [
                        'p1' => 6,
                        'p2' => null,
                        'p3' => true,
                        'p4' => 5.0,
                        'p5' => 27
                    ],
                    'types' => [
                        'p2' => Database::TYPE_STRING
                    ]
                ]
            );
            $t->commit();
        });

        $res = self::$database->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE name IS NULL');

        $this->assertCount(1, iterator_to_array($res));
    }

    public function testBindPgNumericParameter()
    {
        $str = '22';
        $val = new PgNumeric($str);

        // try to fetch the value
        $res = self::$database->execute('SELECT age FROM test WHERE age = $1', [
            'parameters' => [
                'p1' => $val
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertInstanceOf(PgNumeric::class, $row['age']);
        $this->assertEquals($str, $val->formatAsString());
        $this->assertEquals($str, (string)$val->get());
    }

    public function testBindPgNumericParameterNull()
    {
        $val = null;

        // insert a value with a pg numeric param binded to null
        self::$database->runTransaction(function (Transaction $t) {
            $t->executeUpdate(
                'INSERT INTO ' . self::TABLE_NAME . '(id, name, registered, rating, age) '
                . 'VALUES($1, $2, $3, $4, $5)',
                [
                    'parameters' => [
                        'p1' => 7,
                        'p2' => 'Stefan',
                        'p3' => true,
                        'p4' => 5.0,
                        'p5' => null
                    ],
                    'types' => [
                        'p5' => Database::TYPE_PG_NUMERIC
                    ]
                ]
            );
            $t->commit();
        });

        $res = self::$database->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE age IS NULL');

        $this->assertCount(1, iterator_to_array($res));
    }

    public function testBindBytesParameter()
    {
        $str = 'hello';
        $bytes = new Bytes($str);
        $res = self::$database->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE bytes_col = $1', [
            'parameters' => [
                'p1' => $bytes
            ]
        ]);

        $row = $res->rows()->current();
        $this->assertInstanceOf(Bytes::class, $row['bytes_col']);
        $this->assertEquals($str, base64_decode($bytes->formatAsString()));
        $this->assertEquals($str, (string)$bytes->get());
    }

    public function testBindBytesParameterNull()
    {
        // insert a value with a bytes param binded to null
        self::$database->runTransaction(function (Transaction $t) {
            $t->executeUpdate(
                'INSERT INTO ' . self::TABLE_NAME . '(id, name, registered, rating, age, bytes_col) '
                . 'VALUES($1, $2, $3, $4, $5, $6)',
                [
                    'parameters' => [
                        'p1' => 8,
                        'p2' => 'Sheena',
                        'p3' => true,
                        'p4' => 5.0,
                        'p5' => 30,
                        'p6' => null
                    ],
                    'types' => [
                        'p6' => Database::TYPE_BYTES
                    ]
                ]
            );
            $t->commit();
        });

        $res = self::$database->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE bytes_col IS NULL');

        $this->assertCount(6, iterator_to_array($res));
    }

    public function testBindTimestampParameter()
    {
        $res = self::$database->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE created_at = $1', [
            'parameters' => [
                'p1' => self::$timestampVal
            ]
        ]);

        $this->assertCount(2, iterator_to_array($res));

        $row = $res->rows()->current();
        $this->assertInstanceOf(Timestamp::class, $row['created_at']);
        $this->assertEquals(self::$timestampVal->get()->format('r'), $row['created_at']->get()->format('r'));
    }

    public function testBindTimestampParameterNull()
    {
        // insert a value with a timestamp param binded to null
        self::$database->runTransaction(function (Transaction $t) {
            $t->executeUpdate(
                'INSERT INTO ' . self::TABLE_NAME . '(id, name, registered, rating, age, created_at) '
                . 'VALUES($1, $2, $3, $4, $5, $6)',
                [
                    'parameters' => [
                        'p1' => 9,
                        'p2' => 'Kamal',
                        'p3' => true,
                        'p4' => 5.0,
                        'p5' => 30,
                        'p6' => null
                    ],
                    'types' => [
                        'p6' => Database::TYPE_TIMESTAMP
                    ]
                ]
            );
            $t->commit();
        });

        $res = self::$database->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE bytes_col IS NULL');

        $this->assertCount(7, iterator_to_array($res));
    }

    public function testBindDateParameter()
    {
        $res = self::$database->execute("SELECT * FROM " . self::TABLE_NAME . " WHERE dt BETWEEN $1 AND $2", [
            'parameters' => [
                'p1' => new Date(new \DateTime('2020-01-01')),
                'p2' => new Date(new \DateTime('2021-01-01'))
            ]
        ]);

        $this->assertCount(2, iterator_to_array($res));

        $row = $res->rows()->current();
        $this->assertInstanceOf(Date::class, $row['dt']);
        $this->assertEquals('2020-01-01', $row['dt']->get()->format('Y-m-d'));
    }

    public function testBindDateParameterNull()
    {
        $res = self::$database->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE dt IS NULL');
        $currentNullCount = count(iterator_to_array($res));

        // insert a value with a date param binded to null
        self::$database->runTransaction(function (Transaction $t) {
            $t->executeUpdate(
                'INSERT INTO ' . self::TABLE_NAME . '(id, name, registered, rating, age, dt) '
                . 'VALUES($1, $2, $3, $4, $5, $6)',
                [
                    'parameters' => [
                        'p1' => 10,
                        'p2' => 'Raja',
                        'p3' => true,
                        'p4' => 5.0,
                        'p5' => 30,
                        'p6' => null
                    ],
                    'types' => [
                        'p6' => Database::TYPE_DATE
                    ]
                ]
            );
            $t->commit();
        });

        $res = self::$database->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE dt IS NULL');

        // the new null count should have been incremented by 1
        $this->assertCount($currentNullCount + 1, iterator_to_array($res));
    }

    public function arrayTypesProvider()
    {
        return [
            // boolean
            [[true,true,false]],

            // int64
            [[5,4,3,2,1]],

            // float64
            [[3.14, 4.13, 1.43]],

            // string
            [['hello','world','google','cloud']],

            // bytes
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

            // timestamp
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

            // date
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
            // pg_numeric
            [
                [
                    new PgNumeric('0.98765432187347'),
                    new PgNumeric('98765432187347'),
                    new PgNumeric('123456789033928239823.123456789433434344334')
                ],
                ['0.98765432187347', '98765432187347', '123456789033928239823.123456789433434344334'],
                PgNumeric::class,
                function (array $res) {
                    foreach ($res as $idx => $val) {
                        $res[$idx] = $val->get();
                    }

                    return $res;
                }
            ]
        ];
    }

    /**
     * @dataProvider arrayTypesProvider
     */
    public function testBindArrayOfType($value, $result = null, $resultType = null, callable $filter = null)
    {
        if (!$filter) {
            $filter = function ($val) {
                return $val;
            };
        }

        $db = self::$database;

        $res = $db->execute('SELECT $1 as foo', [
            'parameters' => [
                'p1' => $value
            ]
        ]);

        $row = $res->rows()->current();
        $param = $filter($row['foo']);

        if ($resultType) {
            $this->assertContainsOnlyInstancesOf($resultType, $row['foo']);
        }

        $this->assertEquals($param, $result ?: $value);
    }

    public function arrayTypesEmptyProvider()
    {
        return [
            [Database::TYPE_BOOL],
            [Database::TYPE_INT64],
            [Database::TYPE_FLOAT64],
            [Database::TYPE_STRING],
            [Database::TYPE_BYTES],
            [Database::TYPE_TIMESTAMP],
            [Database::TYPE_DATE],
            [Database::TYPE_PG_NUMERIC],
        ];
    }

    /**
     * @dataProvider arrayTypesEmptyProvider
     */
    public function testBindEmptyArrayOfType($type)
    {
        $db = self::$database;

        $res = $db->execute('SELECT $1 as foo', [
            'parameters' => [
                'p1' => []
            ],
            'types' => [
                'p1' => new ArrayType($type)
            ]
        ]);

        $row = $res->rows()->current();

        $this->assertEmpty($row['foo']);
    }

    public function arrayTypesNullProvider()
    {
        return [
            [Database::TYPE_BOOL],
            [Database::TYPE_INT64],
            [Database::TYPE_FLOAT64],
            [Database::TYPE_STRING],
            [Database::TYPE_BYTES],
            [Database::TYPE_TIMESTAMP],
            [Database::TYPE_DATE],
            [Database::TYPE_PG_NUMERIC],
        ];
    }

    /**
     * @dataProvider arrayTypesNullProvider
     */
    public function testBindNullArrayOfType($type)
    {
        $db = self::$database;

        $res = $db->execute('SELECT $1 as foo', [
            'parameters' => [
                'p1' => null
            ],
            'types' => [
                'p1' => new ArrayType($type)
            ]
        ]);

        $row = $res->rows()->current();

        $this->assertNull($row['foo']);
    }
}
