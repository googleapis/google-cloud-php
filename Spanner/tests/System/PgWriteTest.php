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

use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Spanner\Bytes;
use Google\Cloud\Spanner\CommitTimestamp;
use Google\Cloud\Spanner\Date;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\PgNumeric;
use Google\Rpc\Code;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group spanner
 * @group spanner-write
 * @group spanner-postgres
 */
class PgWriteTest extends SpannerPgTestCase
{
    use ExpectException;
    use TimeTrait;

    const TABLE_NAME = 'Writes';
    const COMMIT_TIMESTAMP_TABLE_NAME = 'CommitTimestamps';

    public static function set_up_before_class()
    {
        parent::set_up_before_class();

        self::$database->updateDdlBatch([
            'CREATE TABLE ' . self::TABLE_NAME . ' (
                id bigint NOT NULL,
                boolfield boolean,
                bytesfield bytea,
                datefield date,
                floatfield float,
                intfield bigint,
                stringfield varchar(1024),
                timestampfield timestamptz,
                pgnumericfield numeric,
                arrayfield bigint[],
                arrayboolfield boolean[],
                arrayfloatfield float[],
                arraystringfield varchar(1024)[],
                arraybytesfield bytea[],
                arraytimestampfield timestamptz[],
                arraydatefield date[],
                arraypgnumericfield numeric[],
                PRIMARY KEY (id)
            )',
            'CREATE TABLE ' . self::COMMIT_TIMESTAMP_TABLE_NAME . ' (
                id bigint NOT NULL,
                commitTimestamp SPANNER.COMMIT_TIMESTAMP NOT NULL,
                PRIMARY KEY (id, commitTimestamp)
            )'
        ])->pollUntilComplete();
    }

    public function fieldValueProvider()
    {
        return [
            [$this->randId(), 'boolfield', false],
            [$this->randId(), 'boolfield', true],
            [$this->randId(), 'floatfield', 3.1415],
            [$this->randId(), 'floatfield', INF],
            [$this->randId(), 'floatfield', -INF],
            [$this->randId(), 'datefield', new Date(new \DateTime('1981-01-20'))],
            [$this->randId(), 'intfield', 787878787],
            [$this->randId(), 'stringfield', 'foo bar'],
            [$this->randId(), 'timestampfield', new Timestamp(new \DateTime)],
            [$this->randId(), 'pgnumericfield', new PgNumeric('0.123456789')]
        ];
    }

    /**
     * @dataProvider fieldValueProvider
     */
    public function testWriteAndReadBackValue($id, $field, $value)
    {
        $db = self::$database;

        $db->insert(self::TABLE_NAME, [
            'id' => $id,
            $field => $value
        ]);

        // test result from read
        $keyset = new KeySet(['keys' => [$id]]);
        $read = $db->read(self::TABLE_NAME, $keyset, [$field]);
        $row = $read->rows()->current();

        if ($value instanceof Timestamp) {
            $this->assertEquals($value->formatAsString(), $row[$field]->formatAsString());
        } else {
            $this->assertEquals($value, $row[$field]);
        }

        // test result from executeSql
        $exec = $db->execute(sprintf('SELECT %s FROM %s WHERE id = $1', $field, self::TABLE_NAME), [
            'parameters' => [
                'p1' => $id
            ]
        ]);

        $row = $exec->rows()->current();
        if ($value instanceof Timestamp) {
            $this->assertEquals($value->formatAsString(), $row[$field]->formatAsString());
        } else {
            $this->assertEquals($value, $row[$field]);
        }
    }

    public function testWriteAndReadBackBytes()
    {
        $id = $this->randId();
        $field = 'bytesfield';
        $value = new Bytes('hello world');

        $db = self::$database;

        $db->insert(self::TABLE_NAME, [
            'id' => $id,
            $field => $value
        ]);

        $keyset = new KeySet(['keys' => [$id]]);
        $read = $db->read(self::TABLE_NAME, $keyset, [$field]);
        $row = $read->rows()->current();

        $this->assertEquals($value->formatAsString(), $row[$field]->formatAsString());

        $exec = $db->execute(sprintf('SELECT %s FROM %s WHERE id = $1', $field, self::TABLE_NAME), [
            'parameters' => [
                'p1' => $id
            ]
        ]);

        $row = $exec->rows()->current();
        $this->assertEquals($value->formatAsString(), $row[$field]->formatAsString());
    }

    public function testWriteAndReadBackNaN()
    {
        $id = $this->randId();
        $field = 'floatfield';
        $value = NAN;

        $db = self::$database;

        $db->insert(self::TABLE_NAME, [
            'id' => $id,
            $field => $value
        ]);

        $keyset = new KeySet(['keys' => [$id]]);
        $read = $db->read(self::TABLE_NAME, $keyset, [$field]);
        $row = $read->rows()->current();

        $this->assertTrue(is_nan($row[$field]));

        $exec = $db->execute(sprintf('SELECT %s FROM %s WHERE id = $1', $field, self::TABLE_NAME), [
            'parameters' => [
                'p1' => $id
            ]
        ]);

        $row = $exec->rows()->current();
        $this->assertTrue(is_nan($row[$field]));
    }

    public function nullFieldValueProvider()
    {
        $provider = $this->fieldValueProvider();
        $provider[] = [$this->randId(), 'bytesfield'];

        return $provider;
    }

    /**
     * @dataProvider nullFieldValueProvider
     */
    public function testWriteAndReadBackNullValue($id, $field)
    {
        $db = self::$database;

        $db->insert(self::TABLE_NAME, [
            'id' => $id,
            $field => null
        ]);

        // test result from read
        $keyset = new KeySet(['keys' => [$id]]);
        $read = $db->read(self::TABLE_NAME, $keyset, [$field]);
        $row = $read->rows()->current();
        $this->assertNull($row[$field]);

        // test result from executeSql
        $exec = $db->execute(sprintf('SELECT %s FROM %s WHERE id = $1', $field, self::TABLE_NAME), [
            'parameters' => [
                'p1' => $id
            ]
        ]);

        $row = $exec->rows()->current();
        $this->assertNull($row[$field]);
    }

    public function arrayFieldValueProvider()
    {
        return [
            [$this->randId(), 'arrayfield', []],
            [$this->randId(), 'arrayfield', [1,2,null,4,5]],
            [$this->randId(), 'arrayfield', null],
            [$this->randId(), 'arrayboolfield', [true,false]],
            [$this->randId(), 'arrayboolfield', []],
            [$this->randId(), 'arrayboolfield', [true, false, null, false]],
            [$this->randId(), 'arrayboolfield', null],
            [$this->randId(), 'arrayfloatfield', [1.1, 1.2, 1.3]],
            [$this->randId(), 'arrayfloatfield', []],
            [$this->randId(), 'arrayfloatfield', [1.1, null, 1.3]],
            [$this->randId(), 'arrayfloatfield', null],
            [$this->randId(), 'arraystringfield', ['foo','bar','baz']],
            [$this->randId(), 'arraystringfield', []],
            [$this->randId(), 'arraystringfield', ['foo',null,'baz']],
            [$this->randId(), 'arraystringfield', null],
            [$this->randId(), 'arraybytesfield', []],
            [$this->randId(), 'arraybytesfield', null],
            [$this->randId(), 'arraytimestampfield', []],
            [$this->randId(), 'arraytimestampfield', null],
            [$this->randId(), 'arraydatefield', []],
            [$this->randId(), 'arraydatefield', null],
            [$this->randId(), 'arraypgnumericfield', []],
            [$this->randId(), 'arraypgnumericfield', null],
        ];
    }

    /**
     * @dataProvider arrayFieldValueProvider
     */
    public function testWriteAndReadBackArrayValue($id, $field, $value)
    {
        $db = self::$database;

        $db->insert(self::TABLE_NAME, [
            'id' => $id,
            $field => $value
        ]);

        // test result from read
        $keyset = new KeySet(['keys' => [$id]]);
        $read = $db->read(self::TABLE_NAME, $keyset, [$field]);
        $row = $read->rows()->current();

        $this->assertEquals($value, $row[$field]);

        // test result from executeSql
        $exec = $db->execute(sprintf('SELECT %s FROM %s WHERE id = $1', $field, self::TABLE_NAME), [
            'parameters' => [
                'p1' => $id
            ]
        ]);

        $row = $exec->rows()->current();

        if ($value instanceof Bytes) {
            $this->assertEquals($value->formatAsString(), $row[$field]->formatAsString());
        } else {
            $this->assertEquals($value, $row[$field]);
        }
    }

    public function arrayFieldComplexValueProvider()
    {
        return [
            [$this->randId(), 'arraybytesfield', [new Bytes('foo'),null,new Bytes('baz')]],
            [$this->randId(), 'arraytimestampfield', [new Timestamp(new \DateTime),null,new Timestamp(new \DateTime)]],
            [$this->randId(), 'arraydatefield', [new Date(new \DateTime),null,new Date(new \DateTime)]],
            [$this->randId(), 'arraypgnumericfield', [new PgNumeric("0.12345"),null,new PgNumeric("12345")]],
        ];
    }

    /**
     * @dataProvider arrayFieldComplexValueProvider
     */
    public function testWriteAndReadBackArrayComplexValue($id, $field, $value)
    {
        $db = self::$database;

        $db->insert(self::TABLE_NAME, [
            'id' => $id,
            $field => $value
        ]);

        // test result from read
        $keyset = new KeySet(['keys' => [$id]]);
        $read = $db->read(self::TABLE_NAME, $keyset, [$field]);

        // test result from executeSql
        $exec = $db->execute(sprintf('SELECT %s FROM %s WHERE id = $1', $field, self::TABLE_NAME), [
            'parameters' => [
                'p1' => $id
            ]
        ]);

        $row1 = $read->rows()->current();
        $row2 = $exec->rows()->current();

        foreach ($row2[$field] as $item) {
            if (is_null($item)) {
                continue;
            }

            $this->assertInstanceOf(get_class($value[0]), $item);
        }
    }

    public function testWriteToNonExistentTableFails()
    {
        $this->expectException('Google\Cloud\Core\Exception\NotFoundException');

        $db = self::$database;

        $db->insert(uniqid(self::TESTING_PREFIX), ['foo' => 'bar']);
    }

    public function testWriteToNonExistentColumnFails()
    {
        $this->expectException('Google\Cloud\Core\Exception\NotFoundException');

        $db = self::$database;

        $db->insert(self::TABLE_NAME, [uniqid(self::TESTING_PREFIX) => 'bar']);
    }

    public function testWriteIncorrectTypeToColumn()
    {
        $this->expectException('Google\Cloud\Core\Exception\FailedPreconditionException');

        $db = self::$database;

        $db->insert(self::TABLE_NAME, [
            'id' => $this->randId(),
            'boolfield' => 'bar'
        ]);
    }

    /**
     * @dataProvider randomBytesProvider
     * covers 88
     */
    public function testWriteAndReadBackRandomBytes($id, $bytes)
    {
        $db = self::$database;

        $db->insert(self::TABLE_NAME, [
            'id' => $id,
            'bytesfield' => $bytes
        ]);

        $res = $db->execute('SELECT bytesfield FROM ' . self::TABLE_NAME . ' WHERE id = $1', [
            'parameters' => [
                'p1' => $id
            ]
        ])->rows()->current()['bytesfield'];

        $this->assertEquals((string) $res->get(), (string) $bytes->get());
    }

    public function randomBytesProvider()
    {
        if (version_compare(phpversion(), 7) === -1) {
            $this->markTestSkipped('This test can only be run on php 7+');
        }

        return [
            [$this->randId(), new Bytes(base64_encode(random_bytes(rand(100, 9999))))],
            [$this->randId(), new Bytes(base64_encode(random_bytes(rand(100, 9999))))],
            [$this->randId(), new Bytes(base64_encode(random_bytes(rand(100, 9999))))],
            [$this->randId(), new Bytes(base64_encode(random_bytes(rand(100, 9999))))],
            [$this->randId(), new Bytes(base64_encode(random_bytes(rand(100, 9999))))],
        ];
    }

    /**
     * @dataProvider randomNumericProvider
     */
    public function testWriteAndReadBackRandomNumeric($id, $numeric)
    {
        $db = self::$database;

        $db->insert(self::TABLE_NAME, [
            'id' => $id,
            'pgnumericfield' => $numeric
        ]);

        $res = $db->execute('SELECT pgnumericfield FROM ' . self::TABLE_NAME . ' WHERE id = $1', [
            'parameters' => [
                'p1' => $id
            ]
        ])->rows()->current()['pgnumericfield'];

        $this->assertEquals((string) $res->get(), (string) $numeric->get());
    }

    public function randomNumericProvider()
    {
        if (version_compare(phpversion(), 7) === -1) {
            $this->markTestSkipped('This test can only be run on php 7+');
        }

        return [
            [$this->randId(), new PgNumeric((string)rand(100, 9999))],
            [$this->randId(), new PgNumeric((string)rand(100, 9999))],
            [$this->randId(), new PgNumeric((string)rand(100, 9999))],
            [$this->randId(), new PgNumeric((string)rand(100, 9999))],
            [$this->randId(), new PgNumeric((string)rand(100, 9999))],
        ];
    }

    /**
     * @group spanner-committimestamp
     */
    public function testCommitTimestamp()
    {
        $id = $this->randId();
        $ts = self::$database->insert(self::COMMIT_TIMESTAMP_TABLE_NAME, [
            'id' => $id,
            'committimestamp' => new CommitTimestamp
        ]);

        $res = self::$database->execute('SELECT * FROM ' . self::COMMIT_TIMESTAMP_TABLE_NAME . ' WHERE id = $1', [
            'parameters' => [
                'p1' => $id
            ]
        ])->rows()->current()['committimestamp'];

        $this->assertEquals($ts->formatAsString(), $res->formatAsString());
    }

    public function testSetFieldToNull()
    {
        $id = $this->randId();
        $str = base64_encode(random_bytes(rand(1, 100)));
        $row = self::$database->insert(self::TABLE_NAME, [
            'id' => $id,
            'stringfield' => $str
        ]);

        self::$database->update(self::TABLE_NAME, [
            'id' => $id,
            'stringfield' => null
        ]);

        $res = self::$database->execute(
            'SELECT stringfield FROM ' . self::TABLE_NAME . ' WHERE id = $1',
            [
                'parameters' => [
                    'p1' => $id
                ]
            ]
        );

        $this->assertNull($res->rows()->current()['stringfield']);
    }

    /**
     * @group spanner-timestampprecision
     * @dataProvider timestamps
     */
    public function testTimestampPrecision($timestamp)
    {
        $id = $this->randId();

        $row = self::$database->insert(self::TABLE_NAME, [
            'id' => $id,
            'timestampfield' => $timestamp
        ]);

        $res = self::$database->execute('SELECT timestampfield FROM ' . self::TABLE_NAME . ' WHERE id = $1', [
            'parameters' => [
                'p1' => $id
            ]
        ])->rows()->current()['timestampfield'];

        // update and read back (what should be the same) value.
        self::$database->update(self::TABLE_NAME, [
            'id' => $id,
            'timestampfield' => $res
        ]);

        $res2 = self::$database->execute('SELECT timestampfield FROM ' . self::TABLE_NAME . ' WHERE id = $1', [
            'parameters' => [
                'p1' => $id
            ]
        ])->rows()->current()['timestampfield'];

        $this->assertEquals($timestamp->get()->format('U'), $res->get()->format('U'));
        $this->assertEquals($timestamp->nanoSeconds(), $res->nanoSeconds());
        $this->assertEquals($timestamp->formatAsString(), $res->formatAsString());

        $this->assertEquals($timestamp->get()->format('U'), $res2->get()->format('U'));
        $this->assertEquals($timestamp->nanoSeconds(), $res2->nanoSeconds());
        $this->assertEquals($timestamp->formatAsString(), $res2->formatAsString());
    }

    /**
     * @group spanner-timestampprecision
     * @dataProvider timestamps
     */
    public function testTimestampPrecisionLocale($timestamp)
    {
        setlocale(LC_ALL, 'fr_FR.UTF-8');
        try {
            $id = $this->randId();

            $row = self::$database->insert(self::TABLE_NAME, [
                'id' => $id,
                'timestampfield' => $timestamp
            ]);

            $res = self::$database->execute('SELECT timestampfield FROM ' . self::TABLE_NAME . ' WHERE id = $1', [
                'parameters' => [
                    'p1' => $id
                ]
            ])->rows()->current()['timestampfield'];

            // update and read back (what should be the same) value.
            self::$database->update(self::TABLE_NAME, [
                'id' => $id,
                'timestampfield' => $res
            ]);

            $res2 = self::$database->execute('SELECT timestampfield FROM ' . self::TABLE_NAME . ' WHERE id = $1', [
                'parameters' => [
                    'p1' => $id
                ]
            ])->rows()->current()['timestampfield'];

            $this->assertEquals($timestamp->get()->format('U'), $res->get()->format('U'));
            $this->assertEquals($timestamp->nanoSeconds(), $res->nanoSeconds());
            $this->assertEquals($timestamp->formatAsString(), $res->formatAsString());

            $this->assertEquals($timestamp->get()->format('U'), $res2->get()->format('U'));
            $this->assertEquals($timestamp->nanoSeconds(), $res2->nanoSeconds());
            $this->assertEquals($timestamp->formatAsString(), $res2->formatAsString());
        } finally {
            setlocale(LC_ALL, null);
        }
    }

    public function timestamps()
    {
        $today = new \DateTime;
        $str = $today->format('Y-m-d\TH:i:s');

        $todayLowMs = \DateTime::createFromFormat('U.u', time() . '.012345');

        $r = new \ReflectionClass(Timestamp::class);
        return [
            [new Timestamp($today)],
            [new Timestamp($todayLowMs)],
            [new Timestamp($today, 0)],
            [new Timestamp($today, 1)],
            [new Timestamp($today, 000000001)],
            [$r->newInstanceArgs($this->parseTimeString($str . '.100000000Z'))],
            [$r->newInstanceArgs($this->parseTimeString($str . '.000000001Z'))],
            [$r->newInstanceArgs($this->parseTimeString($str . '.101999119Z'))],
        ];
    }

    /**
     * @group spanner-write-dml
     */
    public function testExecuteUpdate()
    {
        $id = $this->randId();
        $randStr = base64_encode(random_bytes(500));

        $db = self::$database;
        $db->runTransaction(function ($t) use ($id, $randStr) {
                $count = $t->executeUpdate(
                    'INSERT INTO ' . self::TABLE_NAME . ' (id, stringfield) VALUES ($1, $2)',
                    [
                        'parameters' => [
                            'p1' => $id,
                            'p2' => $randStr
                        ]
                    ]
                );

                $this->assertEquals(1, $count);

            $row = $t->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = $1', [
                'parameters' => [
                    'p1' => $id
                ]
            ])->rows()->current();

            $this->assertEquals($randStr, $row['stringfield']);

            $t->commit();
        });
    }

    /**
     * @group spanner-write-dml
     */
    public function testExecuteSqlDml()
    {
        $id = $this->randId();
        $randStr = base64_encode(random_bytes(500));

        $db = self::$database;
        $db->runTransaction(function ($t) use ($id, $randStr) {
            $res = $t->execute('INSERT INTO ' . self::TABLE_NAME . ' (id, stringfield) VALUES ($1, $2)', [
                'parameters' => [
                    'p1' => $id,
                    'p2' => $randStr
                ]
            ]);

            iterator_to_array($res);

            $this->assertEquals(1, $res->stats()['rowCountExact']);

            $row = $t->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = $1', [
                'parameters' => [
                    'p1' => $id
                ]
            ])->rows()->current();

            $this->assertEquals($randStr, $row['stringfield']);

            $t->commit();
        });
    }

    /**
     * @group spanner-write-dml
     */
    public function testExecuteUpdateTransaction()
    {
        $id = $this->randId();
        $randStr = base64_encode(random_bytes(500));

        $db = self::$database;
        $db->runTransaction(function ($t) use ($id, $randStr) {
            $count = $t->executeUpdate('INSERT INTO ' . self::TABLE_NAME . ' (id, stringfield) VALUES ($1, $2)', [
                'parameters' => [
                    'p1' => $id,
                    'p2' => $randStr
                ]
            ]);

            $this->assertEquals(1, $count);

            $row = $t->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = $1', [
                'parameters' => [
                    'p1' => $id
                ]
            ])->rows()->current();

            $this->assertEquals($randStr, $row['stringfield']);

            $t->commit();
        });

        $row = $db->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = $1', [
            'parameters' => [
                'p1' => $id
            ]
        ])->rows()->current();

        $this->assertEquals($randStr, $row['stringfield']);
    }

    /**
     * @group spanner-write-dml
     */
    public function testExecuteUpdateTransactionRollback()
    {
        $id = $this->randId();
        $randStr = base64_encode(random_bytes(500));

        $db = self::$database;
        $db->runTransaction(function ($t) use ($id, $randStr) {
            $count = $t->executeUpdate('INSERT INTO ' . self::TABLE_NAME . ' (id, stringfield) VALUES ($1, $2)', [
                'parameters' => [
                    'p1' => $id,
                    'p2' => $randStr
                ]
            ]);

            $this->assertEquals(1, $count);

            $row = $t->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = $1', [
                'parameters' => [
                    'p1' => $id
                ]
            ])->rows()->current();

            $this->assertEquals($randStr, $row['stringfield']);

            $t->rollback();
        });

        $row = $db->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = $1', [
            'parameters' => [
                'p1' => $id
            ]
        ])->rows()->current();

        $this->assertNull($row);
    }

    /**
     * @group spanner-write-dml
     */
    public function testExecuteUpdateTransactionMixed()
    {
        $id = $this->randId();
        $id2 = $this->randId();
        $randStr = base64_encode(random_bytes(500));

        $db = self::$database;
        $db->runTransaction(function ($t) use ($id, $id2, $randStr) {
            $count = $t->executeUpdate('INSERT INTO ' . self::TABLE_NAME . ' (id, stringfield) VALUES ($1, $2)', [
                'parameters' => [
                    'p1' => $id,
                    'p2' => $randStr
                ]
            ]);

            $this->assertEquals(1, $count);

            $t->insert(self::TABLE_NAME, [
                'id' => $id2,
                'stringfield' => $randStr
            ]);

            $t->commit();
        });

        $rows = iterator_to_array($db->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = $1 OR id = $2', [
            'parameters' => [
                'p1' => $id,
                'p2' => $id2
            ]
        ]));

        $this->assertCount(2, $rows);
    }

    /**
     * @group spanner-write-dml
     */
    public function testExecuteUpdateMultipleStatements()
    {
        $id = $this->randId();
        $id2 = $this->randId();
        $randStr = base64_encode(random_bytes(500));
        $randStr2 = base64_encode(random_bytes(500));

        $db = self::$database;
        $db->runTransaction(function ($t) use ($id, $id2, $randStr, $randStr2) {
            $count = $t->executeUpdate('INSERT INTO ' . self::TABLE_NAME . ' (id, stringfield) VALUES ($1, $2)', [
                'parameters' => [
                    'p1' => $id,
                    'p2' => $randStr
                ]
            ]);

            $this->assertEquals(1, $count);

            $count = $t->executeUpdate('UPDATE ' . self::TABLE_NAME . ' SET stringfield = $1 WHERE id = $2', [
                'parameters' => [
                    'p1' => $randStr2,
                    'p2' => $id
                ]
            ]);

            $this->assertEquals(1, $count);

            $t->commit();
        });

        $query = 'SELECT stringfield FROM ' . self::TABLE_NAME . ' WHERE id = $1 OR id = $2';

        $row = iterator_to_array($db->execute($query, [
            'parameters' => [
                'p1' => $id,
                'p2' => $id2
            ]
        ]))[0];

        $this->assertEquals($randStr2, $row['stringfield']);
    }

    /**
     * @group spanner-write-dml
     * @group spanner-write-pdml
     */
    public function testPdml()
    {
        $id = $this->randId();
        $randStr = base64_encode(random_bytes(500));
        $randStr2 = base64_encode(random_bytes(500));
        $db = self::$database;

        $db->insert(self::TABLE_NAME, [
            'id' => $id,
            'stringfield' => $randStr
        ]);

        $count = $db->executePartitionedUpdate(
            'UPDATE ' . self::TABLE_NAME . ' SET stringfield = $1 WHERE id = $2',
            [
                'parameters' => [
                    'p1' => $randStr2,
                    'p2' => $id
                ]
            ]
        );

        $this->assertEquals(1, $count);

        $row = $db->execute('SELECT stringfield FROM ' . self::TABLE_NAME . ' WHERE id = $1', [
            'parameters' => [
                'p1' => $id
            ]
        ])->rows()->current();
        $this->assertEquals($randStr2, $row['stringfield']);
    }

    /**
     * Run batchUpdate with a single statement. Verify that the result list size
     * is one, and the entry in the list contains the correct row count.
     *
     * @group spanner-write-batch-dml
     */
    public function testExecuteUpdateBatchSingleStatement()
    {
        $id = $this->randId();
        $randStr = base64_encode(random_bytes(500));

        $db = self::$database;
        $res = $db->runTransaction(function ($t) use ($id, $randStr) {
            $res = $t->executeUpdateBatch([
                [
                    'sql' => 'INSERT INTO ' . self::TABLE_NAME . ' (id, stringfield) VALUES ($1, $2)',
                    'parameters' => [
                        'p1' => $id,
                        'p2' => $randStr
                    ]
                ]
            ]);

            $t->commit();

            return $res;
        });

        $this->assertEquals([1], $res->rowCounts());
    }

    /**
     * Run batchUpdate with no statement, expect an error to be returned, with
     * an empty result list.
     *
     * @group spanner-write-batch-dml
     */
    public function testExecuteUpdateBatchNoStatementsThrowsException()
    {
        $this->expectException('Google\Cloud\Core\Exception\BadRequestException');

        $db = self::$database;
        $res = $db->runTransaction(function ($t) {
            $res = $t->executeUpdateBatch([]);

            $t->commit();

            return $res;
        });
    }

    /**
     * Run batchUpdate with multiple statements that depend on each other (for
     * example, self incrementing a integer column). Verify the correct row
     * counts are returned in the result list.
     *
     * @group spanner-write-batch-dml
     */
    public function testExecuteUpdateBatchDependentStatements()
    {
        $id = $this->randId();

        $db = self::$database;
        $res = $db->runTransaction(function ($t) {
            $id = $this->randId();
            $res = $t->executeUpdateBatch([
                [
                    'sql' => 'INSERT INTO ' . self::TABLE_NAME . ' (id, intfield) VALUES ($1, $2)',
                    'parameters' => [
                        'p1' => $id,
                        'p2' => 0
                    ]
                ], [
                    'sql' => 'UPDATE ' . self::TABLE_NAME . ' SET intfield = intfield+1 WHERE id = $1',
                    'parameters' => [
                        'p1' => $id
                    ]
                ]
            ]);

            $t->commit();

            return $res;
        });

        $this->assertEquals([1, 1], $res->rowCounts());
    }

    /**
     * Run executeUpdate first, and batchUpdate next, within the same
     * transaction, and make the statements passed into batchUpdate depend on
     * the statement run in executeUpdate. Verify that the correct row counts
     * are returned in the result list.
     *
     * @group spanner-write-batch-dml
     */
    public function testExecuteUpdateBatchSingleUpdateThenBatchUpdate()
    {
        $db = self::$database;
        $res = $db->runTransaction(function ($t) {
            $id = $this->randId();

            $t->executeUpdate('INSERT INTO ' . self::TABLE_NAME . ' (id, intfield) VALUES ($1, $2)', [
                'parameters' => [
                    'p1' => $id,
                    'p2' => 0
                ]
            ]);

            $res = $t->executeUpdateBatch([
                [
                    'sql' => 'UPDATE ' . self::TABLE_NAME . ' SET intfield = intfield+1 WHERE id = $1',
                    'parameters' => [
                        'p1' => $id
                    ]
                ]
            ]);

            $t->commit();

            return $res;
        });

        $this->assertEquals([1], $res->rowCounts());
    }

    /**
     * Run batchUpdate first, and executeUpdate next, within the same
     * transaction, and make the statements passed into executeUpdate depend on
     * the statement run in batchUpdate. Verify that the correct row counts
     * are returned in the result list.
     *
     * @group spanner-write-batch-dml
     */
    public function testExecuteUpdateBatchThenSingleUpdate()
    {
        $db = self::$database;
        $res = $db->runTransaction(function ($t) {
            $id = $this->randId();

            $res = $t->executeUpdateBatch([
                [
                    'sql' => 'INSERT INTO ' . self::TABLE_NAME . ' (id, intfield) VALUES ($1, $2)',
                    'parameters' => [
                        'p1' => $id,
                        'p2' => 0
                    ]
                ]
            ]);

            $res = $t->executeUpdate('UPDATE ' . self::TABLE_NAME . ' SET intfield = intfield+1 WHERE id = $1', [
                'parameters' => [
                    'p1' => $id,
                ]
            ]);

            $t->commit();

            return $res;
        });

        $this->assertEquals(1, $res);
    }

    /**
     * Run batchUpdate with an error (e.g. a syntax error) in the i’th statement
     * (the index here starts from 1). Verify:
     * - The returned size of the result list equals i - 1;
     * - Each row count in the list matches the expected update count for
     *   statement  [1, i - 1].
     * - The returned status in the response matches the expected error.
     *
     * @group spanner-write-batch-dml
     */
    public function testExecuteUpdateBatchError()
    {
        $db = self::$database;
        $id = $this->randId();

        $statements = [
            [
                'sql' => 'INSERT INTO ' . self::TABLE_NAME . ' (id, intfield) VALUES ($1, $2)',
                'parameters' => [
                    'p1' => $id,
                    'p2' => 0
                ]
            ], [
                'sql' => 'UPDATE ' . self::TABLE_NAME . ' SET intfield = intfield+1 WHERE id = $1',
                'parameters' => [
                    'p1' => $id
                ]
            ], [
                'sql' => 'UPDATE ' . self::TABLE_NAME . ' SET intfield = intfield+1 WHERE id = $1'
            ]
        ];

        $res = $db->runTransaction(function ($t) use ($statements) {
            $res = $t->executeUpdateBatch($statements);

            $t->commit();

            return $res;
        });

        $this->assertEquals([1, 1], $res->rowCounts());
        $this->assertEquals(Code::INVALID_ARGUMENT, $res->error()['status']['code']);
        $this->assertEquals($statements[2], $res->error()['statement']);
    }

    /**
     * Run batchUpdate with two different errors in the i’th statement and
     * i+1’th statement. Verify:
     * - The returned size of the result list equals i - 1;
     * - Each row count in the array matches the expected update count for
     *   statement [1, i - 1].
     * The returned status in the response matches the expected error of
     *   statement i.
     *
     * @group spanner-write-batch-dml
     */
    public function testExecuteUpdateBatchMultipleErrors()
    {
        $db = self::$database;
        $id = $this->randId();

        $statements = [
            [
                'sql' => 'INSERT INTO ' . self::TABLE_NAME . ' (id, intfield) VALUES ($1, $2)',
                'parameters' => [
                    'p1' => $id,
                    'p2' => 0
                ]
            ], [
                'sql' => 'UPDATE ' . self::TABLE_NAME . ' SET intfield = intfield+1 WHERE id = $1',
                'parameters' => [
                    'p1' => $id
                ]
            ], [
                'sql' => 'UPDATE ' . self::TABLE_NAME . ' SET intfield = intfield+1 WHERE id = $1'
            ], [
                'sql' => 'UPDATE ' . self::TABLE_NAME . ' SET intfield = intfield+1 WHERE id = $2'
            ]
        ];

        $res = $db->runTransaction(function ($t) use ($statements) {
            $res = $t->executeUpdateBatch($statements);

            $t->commit();

            return $res;
        });

        $this->assertEquals([1, 1], $res->rowCounts());
        $this->assertEquals(Code::INVALID_ARGUMENT, $res->error()['status']['code']);
        $this->assertEquals($statements[2], $res->error()['statement']);
    }
}
