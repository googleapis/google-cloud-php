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

namespace Google\Cloud\Spanner\Tests\System;

use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Spanner\Bytes;
use Google\Cloud\Spanner\CommitTimestamp;
use Google\Cloud\Spanner\Date;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Numeric;
use Google\Rpc\Code;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group spanner
 * @group spanner-write
 */
class WriteTest extends SpannerTestCase
{
    use ExpectException;
    use TimeTrait;

    const TABLE_NAME = 'Writes';
    const COMMIT_TIMESTAMP_TABLE_NAME = 'CommitTimestamps';

    public static function set_up_before_class()
    {
        self::skipEmulatorTests();
        parent::set_up_before_class();

        self::$database->updateDdlBatch([
            'CREATE TABLE ' . self::TABLE_NAME . ' (
                id INT64 NOT NULL,
                arrayField ARRAY<INT64>,
                arrayBoolField ARRAY<BOOL>,
                arrayFloatField ARRAY<FLOAT64>,
                arrayStringField ARRAY<STRING(MAX)>,
                arrayBytesField ARRAY<BYTES(MAX)>,
                arrayTimestampField ARRAY<TIMESTAMP>,
                arrayDateField ARRAY<DATE>,
                arrayNumericField ARRAY<NUMERIC>,
                boolField BOOL,
                bytesField BYTES(MAX),
                dateField DATE,
                floatField FLOAT64,
                intField INT64,
                stringField STRING(MAX),
                timestampField TIMESTAMP,
                numericField NUMERIC
            ) PRIMARY KEY (id)',
            'CREATE TABLE ' . self::COMMIT_TIMESTAMP_TABLE_NAME . ' (
                id INT64 NOT NULL,
                commitTimestamp TIMESTAMP NOT NULL OPTIONS
                    (allow_commit_timestamp=true)
            ) PRIMARY KEY (id, commitTimestamp DESC)'
        ])->pollUntilComplete();
    }

    public function fieldValueProvider()
    {
        return [
            [$this->randId(), 'boolField', false],
            [$this->randId(), 'boolField', true],
            [$this->randId(), 'arrayField', [1,2,3,4,5]],
            [$this->randId(), 'dateField', new Date(new \DateTime('1981-01-20'))],
            [$this->randId(), 'floatField', 3.1415],
            [$this->randId(), 'floatField', INF],
            [$this->randId(), 'floatField', -INF],
            [$this->randId(), 'intField', 787878787],
            [$this->randId(), 'stringField', 'foo bar'],
            [$this->randId(), 'timestampField', new Timestamp(new \DateTime)],
            [$this->randId(), 'numericField', new Numeric('0.123456789')]
        ];
    }

    /**
     * @dataProvider fieldValueProvider
     * covers 78
     * covers 80
     * covers 82
     * covers 84
     * covers 85
     * covers 90
     * covers 92
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
        $exec = $db->execute(sprintf('SELECT %s FROM %s WHERE id = @id', $field, self::TABLE_NAME), [
            'parameters' => [
                'id' => $id
            ]
        ]);

        $row = $exec->rows()->current();
        if ($value instanceof Timestamp) {
            $this->assertEquals($value->formatAsString(), $row[$field]->formatAsString());
        } else {
            $this->assertEquals($value, $row[$field]);
        }
    }

    /**
     * covers 87
     */
    public function testWriteAndReadBackBytes()
    {
        $id = $this->randId();
        $field = 'bytesField';
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

        $exec = $db->execute(sprintf('SELECT %s FROM %s WHERE id = @id', $field, self::TABLE_NAME), [
            'parameters' => [
                'id' => $id
            ]
        ]);

        $row = $exec->rows()->current();
        $this->assertEquals($value->formatAsString(), $row[$field]->formatAsString());
    }

    /**
     * covers 84
     */
    public function testWriteAndReadBackNaN()
    {
        $id = $this->randId();
        $field = 'floatField';
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

        $exec = $db->execute(sprintf('SELECT %s FROM %s WHERE id = @id', $field, self::TABLE_NAME), [
            'parameters' => [
                'id' => $id
            ]
        ]);

        $row = $exec->rows()->current();
        $this->assertTrue(is_nan($row[$field]));
    }

    public function nullFieldValueProvider()
    {
        $provider = $this->fieldValueProvider();
        $provider[] = [$this->randId(), 'bytesField'];

        return $provider;
    }

    /**
     * @dataProvider nullFieldValueProvider
     * covers 79
     * covers 81
     * covers 83
     * covers 86
     * covers 89
     * covers 91
     * covers 93
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
        $exec = $db->execute(sprintf('SELECT %s FROM %s WHERE id = @id', $field, self::TABLE_NAME), [
            'parameters' => [
                'id' => $id
            ]
        ]);

        $row = $exec->rows()->current();
        $this->assertNull($row[$field]);
    }

    public function arrayFieldValueProvider()
    {
        return [
            [$this->randId(), 'arrayField', []],
            [$this->randId(), 'arrayField', [1,2,null,4,5]],
            [$this->randId(), 'arrayField', null],
            [$this->randId(), 'arrayBoolField', [true,false]],
            [$this->randId(), 'arrayBoolField', []],
            [$this->randId(), 'arrayBoolField', [true, false, null, false]],
            [$this->randId(), 'arrayBoolField', null],
            [$this->randId(), 'arrayFloatField', [1.1, 1.2, 1.3]],
            [$this->randId(), 'arrayFloatField', []],
            [$this->randId(), 'arrayFloatField', [1.1, null, 1.3]],
            [$this->randId(), 'arrayFloatField', null],
            [$this->randId(), 'arrayStringField', ['foo','bar','baz']],
            [$this->randId(), 'arrayStringField', []],
            [$this->randId(), 'arrayStringField', ['foo',null,'baz']],
            [$this->randId(), 'arrayStringField', null],
            [$this->randId(), 'arrayBytesField', []],
            [$this->randId(), 'arrayBytesField', null],
            [$this->randId(), 'arrayTimestampField', []],
            [$this->randId(), 'arrayTimestampField', null],
            [$this->randId(), 'arrayDateField', []],
            [$this->randId(), 'arrayDateField', null],
            [$this->randId(), 'arrayNumericField', []],
            [$this->randId(), 'arrayNumericField', null],
        ];
    }

    /**
     * @dataProvider arrayFieldValueProvider
     * covers 94
     * covers 95
     * covers 96
     * covers 97
     * covers 98
     * covers 99
     * covers 100
     * covers 101
     * covers 102
     * covers 103
     * covers 104
     * covers 105
     * covers 106
     * covers 107
     * covers 108
     * covers 109
     * covers 110
     * covers 111
     * covers 112
     * covers 113
     * covers 114
     */
    public function testWriteAndReadBackFancyArrayValue($id, $field, $value)
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
        $exec = $db->execute(sprintf('SELECT %s FROM %s WHERE id = @id', $field, self::TABLE_NAME), [
            'parameters' => [
                'id' => $id
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
            [$this->randId(), 'arrayBytesField', [new Bytes('foo'),null,new Bytes('baz')]],
            [$this->randId(), 'arrayTimestampField', [new Timestamp(new \DateTime),null,new Timestamp(new \DateTime)]],
            [$this->randId(), 'arrayDateField', [new Date(new \DateTime),null,new Date(new \DateTime)]],
            [$this->randId(), 'arrayNumericField', [new Numeric("0.12345"),null,new NUMERIC("12345")]],
        ];
    }

    /**
     * @dataProvider arrayFieldComplexValueProvider
     */
    public function testWriteAndReadBackFancyArrayComplexValue($id, $field, $value)
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
        $exec = $db->execute(sprintf('SELECT %s FROM %s WHERE id = @id', $field, self::TABLE_NAME), [
            'parameters' => [
                'id' => $id
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
            'boolField' => 'bar'
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
            'bytesField' => $bytes
        ]);

        $res = $db->execute('SELECT bytesField FROM ' . self::TABLE_NAME . ' WHERE id = @id', [
            'parameters' => [
                'id' => $id
            ]
        ])->rows()->current()['bytesField'];

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
            'numericField' => $numeric
        ]);

        $res = $db->execute('SELECT numericField FROM ' . self::TABLE_NAME . ' WHERE id = @id', [
            'parameters' => [
                'id' => $id
            ]
        ])->rows()->current()['numericField'];

        $this->assertEquals((string) $res->get(), (string) $numeric->get());
    }

    public function randomNumericProvider()
    {
        if (version_compare(phpversion(), 7) === -1) {
            $this->markTestSkipped('This test can only be run on php 7+');
        }

        return [
            [$this->randId(), new Numeric((string)rand(100, 9999))],
            [$this->randId(), new Numeric((string)rand(100, 9999))],
            [$this->randId(), new Numeric((string)rand(100, 9999))],
            [$this->randId(), new Numeric((string)rand(100, 9999))],
            [$this->randId(), new Numeric((string)rand(100, 9999))],
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
            'commitTimestamp' => new CommitTimestamp
        ]);

        $res = self::$database->execute('SELECT * FROM ' . self::COMMIT_TIMESTAMP_TABLE_NAME . ' WHERE id = @id', [
            'parameters' => [
                'id' => $id
            ]
        ])->rows()->current()['commitTimestamp'];

        $this->assertEquals($ts->formatAsString(), $res->formatAsString());
    }

    public function testSetFieldToNull()
    {
        $id = $this->randId();
        $str = base64_encode(random_bytes(rand(100, 9999)));
        $row = self::$database->insert(self::TABLE_NAME, [
            'id' => $id,
            'stringField' => $str
        ]);

        self::$database->update(self::TABLE_NAME, [
            'id' => $id,
            'stringField' => null
        ]);

        $res = self::$database->execute(
            'SELECT stringField FROM ' . self::TABLE_NAME . ' WHERE id = @id',
            [
                'parameters' => [
                    'id' => $id
                ]
            ]
        );

        $this->assertNull($res->rows()->current()['stringField']);
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
            'timestampField' => $timestamp
        ]);

        $res = self::$database->execute('SELECT timestampField FROM ' . self::TABLE_NAME . ' WHERE id = @id', [
            'parameters' => [
                'id' => $id
            ]
        ])->rows()->current()['timestampField'];

        // update and read back (what should be the same) value.
        self::$database->update(self::TABLE_NAME, [
            'id' => $id,
            'timestampField' => $res
        ]);

        $res2 = self::$database->execute('SELECT timestampField FROM ' . self::TABLE_NAME . ' WHERE id = @id', [
            'parameters' => [
                'id' => $id
            ]
        ])->rows()->current()['timestampField'];

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
                'timestampField' => $timestamp
            ]);

            $res = self::$database->execute('SELECT timestampField FROM ' . self::TABLE_NAME . ' WHERE id = @id', [
                'parameters' => [
                    'id' => $id
                ]
            ])->rows()->current()['timestampField'];

            // update and read back (what should be the same) value.
            self::$database->update(self::TABLE_NAME, [
                'id' => $id,
                'timestampField' => $res
            ]);

            $res2 = self::$database->execute('SELECT timestampField FROM ' . self::TABLE_NAME . ' WHERE id = @id', [
                'parameters' => [
                    'id' => $id
                ]
            ])->rows()->current()['timestampField'];

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
                    'INSERT INTO ' . self::TABLE_NAME . ' (id, stringField) VALUES (@id, @string)',
                    [
                        'parameters' => [
                            'id' => $id,
                            'string' => $randStr
                        ]
                    ]
                );

                $this->assertEquals(1, $count);

            $row = $t->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = @id', [
                'parameters' => [
                    'id' => $id
                ]
            ])->rows()->current();

            $this->assertEquals($randStr, $row['stringField']);

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
            $res = $t->execute('INSERT INTO ' . self::TABLE_NAME . ' (id, stringField) VALUES (@id, @string)', [
                'parameters' => [
                    'id' => $id,
                    'string' => $randStr
                ]
            ]);

            iterator_to_array($res);

            $this->assertEquals(1, $res->stats()['rowCountExact']);

            $row = $t->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = @id', [
                'parameters' => [
                    'id' => $id
                ]
            ])->rows()->current();

            $this->assertEquals($randStr, $row['stringField']);

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
            $count = $t->executeUpdate('INSERT INTO ' . self::TABLE_NAME . ' (id, stringField) VALUES (@id, @string)', [
                'parameters' => [
                    'id' => $id,
                    'string' => $randStr
                ]
            ]);

            $this->assertEquals(1, $count);

            $row = $t->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = @id', [
                'parameters' => [
                    'id' => $id
                ]
            ])->rows()->current();

            $this->assertEquals($randStr, $row['stringField']);

            $t->commit();
        });

        $row = $db->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = @id', [
            'parameters' => [
                'id' => $id
            ]
        ])->rows()->current();

        $this->assertEquals($randStr, $row['stringField']);
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
            $count = $t->executeUpdate('INSERT INTO ' . self::TABLE_NAME . ' (id, stringField) VALUES (@id, @string)', [
                'parameters' => [
                    'id' => $id,
                    'string' => $randStr
                ]
            ]);

            $this->assertEquals(1, $count);

            $row = $t->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = @id', [
                'parameters' => [
                    'id' => $id
                ]
            ])->rows()->current();

            $this->assertEquals($randStr, $row['stringField']);

            $t->rollback();
        });

        $row = $db->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = @id', [
            'parameters' => [
                'id' => $id
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
            $count = $t->executeUpdate('INSERT INTO ' . self::TABLE_NAME . ' (id, stringField) VALUES (@id, @string)', [
                'parameters' => [
                    'id' => $id,
                    'string' => $randStr
                ]
            ]);

            $this->assertEquals(1, $count);

            $t->insert(self::TABLE_NAME, [
                'id' => $id2,
                'stringField' => $randStr
            ]);

            $t->commit();
        });

        $rows = iterator_to_array($db->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = @id OR id = @id2', [
            'parameters' => [
                'id' => $id,
                'id2' => $id2
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
            $count = $t->executeUpdate('INSERT INTO ' . self::TABLE_NAME . ' (id, stringField) VALUES (@id, @string)', [
                'parameters' => [
                    'id' => $id,
                    'string' => $randStr
                ]
            ]);

            $this->assertEquals(1, $count);

            $count = $t->executeUpdate('UPDATE ' . self::TABLE_NAME . ' SET stringField = @string WHERE id = @id', [
                'parameters' => [
                    'id' => $id,
                    'string' => $randStr2
                ]
            ]);

            $this->assertEquals(1, $count);

            $t->commit();
        });

        $row = iterator_to_array($db->execute('SELECT stringField FROM ' . self::TABLE_NAME . ' WHERE id = @id', [
            'parameters' => [
                'id' => $id,
                'id2' => $id2
            ]
        ]))[0];

        $this->assertEquals($randStr2, $row['stringField']);
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
            'stringField' => $randStr
        ]);

        $count = $db->executePartitionedUpdate(
            'UPDATE ' . self::TABLE_NAME . ' SET stringField = @string WHERE id = @id',
            [
                'parameters' => [
                    'id' => $id,
                    'string' => $randStr2
                ]
            ]
        );

        $this->assertEquals(1, $count);

        $row = $db->execute('SELECT stringField FROM ' . self::TABLE_NAME . ' WHERE id = @id', [
            'parameters' => [
                'id' => $id
            ]
        ])->rows()->current();
        $this->assertEquals($randStr2, $row['stringField']);
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
                    'sql' => 'INSERT INTO ' . self::TABLE_NAME . ' (id, stringField) VALUES (@id, @string)',
                    'parameters' => [
                        'id' => $id,
                        'string' => $randStr
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
                    'sql' => 'INSERT INTO ' . self::TABLE_NAME . ' (id, intField) VALUES (@id, @int)',
                    'parameters' => [
                        'id' => $id,
                        'int' => 0
                    ]
                ], [
                    'sql' => 'UPDATE ' . self::TABLE_NAME . ' SET intField = intField+1 WHERE id = @id',
                    'parameters' => [
                        'id' => $id
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

            $t->executeUpdate('INSERT INTO ' . self::TABLE_NAME . ' (id, intField) VALUES (@id, @int)', [
                'parameters' => [
                    'id' => $id,
                    'int' => 0
                ]
            ]);

            $res = $t->executeUpdateBatch([
                [
                    'sql' => 'UPDATE ' . self::TABLE_NAME . ' SET intField = intField+1 WHERE id = @id',
                    'parameters' => [
                        'id' => $id
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
                    'sql' => 'INSERT INTO ' . self::TABLE_NAME . ' (id, intField) VALUES (@id, @int)',
                    'parameters' => [
                        'id' => $id,
                        'int' => 0
                    ]
                ]
            ]);

            $res = $t->executeUpdate('UPDATE ' . self::TABLE_NAME . ' SET intField = intField+1 WHERE id = @id', [
                'parameters' => [
                    'id' => $id,
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
                'sql' => 'INSERT INTO ' . self::TABLE_NAME . ' (id, intField) VALUES (@id, @int)',
                'parameters' => [
                    'id' => $id,
                    'int' => 0
                ]
            ], [
                'sql' => 'UPDATE ' . self::TABLE_NAME . ' SET intField = intField+1 WHERE id = @id',
                'parameters' => [
                    'id' => $id
                ]
            ], [
                'sql' => 'UPDATE ' . self::TABLE_NAME . ' SET intField = intField+1 WHERE id = @id'
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
                'sql' => 'INSERT INTO ' . self::TABLE_NAME . ' (id, intField) VALUES (@id, @int)',
                'parameters' => [
                    'id' => $id,
                    'int' => 0
                ]
            ], [
                'sql' => 'UPDATE ' . self::TABLE_NAME . ' SET intField = intField+1 WHERE id = @id',
                'parameters' => [
                    'id' => $id
                ]
            ], [
                'sql' => 'UPDATE ' . self::TABLE_NAME . ' SET intField = intField+1 WHERE id = @id'
            ], [
                'sql' => 'UPDATE ' . self::TABLE_NAME . ' SET intField = intField+1 WHERE id = @id'
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
