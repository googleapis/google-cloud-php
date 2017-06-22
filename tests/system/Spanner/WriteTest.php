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

namespace Google\Cloud\Tests\System\Spanner;

use Google\Cloud\Spanner\Bytes;
use Google\Cloud\Spanner\Date;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Timestamp;

/**
 * @group spanner
 * @group spanner-write
 */
class WriteTest extends SpannerTestCase
{
    const TABLE_NAME = 'Writes';

    public static function setupBeforeClass()
    {
        parent::setUpBeforeClass();

        self::$database->updateDdl(
            'CREATE TABLE '. self::TABLE_NAME .' (
                id INT64 NOT NULL,
                arrayField ARRAY<INT64>,
                arrayBoolField ARRAY<BOOL>,
                arrayFloatField ARRAY<FLOAT64>,
                arrayStringField ARRAY<STRING(MAX)>,
                arrayBytesField ARRAY<BYTES(MAX)>,
                arrayTimestampField ARRAY<TIMESTAMP>,
                arrayDateField ARRAY<DATE>,
                boolField BOOL,
                bytesField BYTES(MAX),
                dateField DATE,
                floatField FLOAT64,
                intField INT64,
                stringField STRING(MAX),
                timestampField TIMESTAMP
            ) PRIMARY KEY (id)'
        )->pollUntilComplete();
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
            [$this->randId(), 'timestampField', new Timestamp(new \DateTime)]
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
        $this->assertEquals($value, $row[$field]);

        // test result from executeSql
        $exec = $db->execute(sprintf('SELECT %s FROM %s WHERE id = @id', $field, self::TABLE_NAME), [
            'parameters' => [
                'id' => $id
            ]
        ]);

        $row = $exec->rows()->current();
        $this->assertEquals($value, $row[$field]);
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
            if (is_null($item)) continue;

            $this->assertInstanceOf(get_class($value[0]), $item);
        }
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\NotFoundException
     */
    public function testWriteToNonExistentTableFails()
    {
        $db = self::$database;

        $db->insert(uniqid(self::TESTING_PREFIX), ['foo' => 'bar']);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\NotFoundException
     */
    public function testWriteToNonExistentColumnFails()
    {
        $db = self::$database;

        $db->insert(self::TABLE_NAME, [uniqid(self::TESTING_PREFIX) => 'bar']);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\FailedPreconditionException
     */
    public function testWriteIncorrectTypeToColumn()
    {
        $db = self::$database;

        $db->insert(self::TABLE_NAME, [
            'id' => $this->randId(),
            'boolField' => 'bar'
        ]);
    }
}
