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

namespace Google\Cloud\Tests\System\Spanner;

use Google\Cloud\Spanner\Bytes;
use Google\Cloud\Spanner\KeySet;

/**
 * @group spanner
 * @group spanner-large-read
 */
class LargeReadTest extends SpannerTestCase
{
    private static $tableName;
    private static $row = [];

    private static $data = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
    private static $str = '';
    const NUM = 40000;

    public static function setupBeforeClass()
    {
        parent::setupBeforeClass();

        self::$tableName = uniqid(self::TESTING_PREFIX);

        $str = '';
        foreach (self::$data as $letter) {
            $str .= str_repeat($letter, self::NUM);
        }

        self::$str = $str;

        $db = self::$database;

        $db->updateDdl(sprintf(
            'CREATE TABLE %s (
                id INT64 NOT NULL,
                stringColumn STRING(MAX) NOT NULL,
                bytesColumn BYTES(MAX) NOT NULL,
                stringArrayColumn ARRAY<STRING(MAX)> NOT NULL,
                bytesArrayColumn ARRAY<BYTES(MAX)> NOT NULL
            ) PRIMARY KEY (id)',
            self::$tableName
        ))->pollUntilComplete();

        self::seedTable();
    }

    private static function seedTable()
    {
        $str = self::randomString();
        self::$row = [
            'stringColumn' => $str,
            'bytesColumn' => self::randomBytes($str),
            'stringArrayColumn' => self::randomArrayOfStrings(),
            'bytesArrayColumn' => self::randomArrayOfBytes($str),
        ];

        for ($i=0; $i < 10; $i++) {
            self::$database->insert(self::$tableName, self::$row + ['id' => self::randId()], [
                'timeoutMillis' => 50000
            ]);
        }
    }

    /**
     * covers 118
     */
    public function testLargeRead()
    {
        $db = self::$database;

        $keyset = new KeySet(['all' => true]);
        $read = $db->read(self::$tableName, $keyset, array_keys(self::$row));

        foreach ($read->rows() as $row) {
            $this->runAssertionsOnRow($row);
        }
    }

    /**
     * covers 119
     */
    public function testLargeExecute()
    {
        $db = self::$database;

        $execute = $db->execute('SELECT * FROM ' . self::$tableName);

        foreach ($execute->rows() as $row) {
            $this->runAssertionsOnRow($row);
        }
    }

    private function runAssertionsOnRow(array $row)
    {
        $this->assertEquals(self::$str, $row['stringColumn']);
        $this->assertEquals(self::$str, base64_decode((string) $row['bytesColumn']));

        foreach ($row['stringArrayColumn'] as $str) {
            $this->assertEquals(self::$str, $str);
        }

        foreach ($row['bytesArrayColumn'] as $bytes) {
            $this->assertEquals(self::$str, base64_decode((string) $bytes));
        }
    }

    private static function randomString()
    {
        return self::$str;
    }

    private static function randomBytes(&$str)
    {
        return new Bytes($str);
    }

    private static function randomArrayOfStrings()
    {
        $res = [];
        for ($i=0; $i <= rand(1,4); $i++) {
            $res[] = self::randomString();
        }

        return $res;
    }

    private static function randomArrayOfBytes(&$str)
    {
        $res = [];
        for ($i=0; $i <= rand(1,4); $i++) {
            $res[] = self::randomBytes($str);
        }

        return $res;
    }
}
