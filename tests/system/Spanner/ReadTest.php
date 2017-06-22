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

use Google\Cloud\Core\Int64;
use Google\Cloud\Spanner\Bytes;
use Google\Cloud\Spanner\KeyRange;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\ValueMapper;

/**
 * @group spanner
 * @group spanner-read
 */
class ReadTest extends SpannerTestCase
{
    const READ_TABLE_NAME = 'Reads';
    const RANGES_TABLE_NAME = 'Ranges';

    private static $dataset;

    public static function setupBeforeClass()
    {
        parent::setupBeforeClass();

        $db = self::$database;
        $db->updateDdlBatch([
            'CREATE TABLE '. self::READ_TABLE_NAME .' (
                id INT64 NOT NULL,
                val STRING(MAX) NOT NULL,
            ) PRIMARY KEY (id)',
            'CREATE TABLE '. self::RANGES_TABLE_NAME .' (
                id INT64 NOT NULL,
                val STRING(MAX) NOT NULL,
            ) PRIMARY KEY (id, val)'
        ])->pollUntilComplete();

        self::$dataset = self::generateDataset(20, true);
        $db->insertBatch(self::RANGES_TABLE_NAME, self::$dataset);
    }

    /**
     * covers 12
     */
    public function testReadPoint()
    {
        $dataset = $this->generateDataset();

        $db = self::$database;
        $db->insertBatch(self::READ_TABLE_NAME, $dataset);

        $indexes = array_rand($dataset, 4);
        $points = [];
        $keys = [];
        array_walk($indexes, function ($index) use ($dataset, &$points, &$keys) {
            $points[] = $dataset[$index];
            $keys[] = $dataset[$index]['id'];
        });

        $keyset = new KeySet(['keys' => $keys]);

        $res = $db->read(self::READ_TABLE_NAME, $keyset, array_keys($dataset[0]));
        $rows = $res->rows();
        foreach ($rows as $index => $row) {
            $this->assertTrue(in_array($row, $dataset));
            $this->assertTrue(in_array($row, $points));
        }
    }

    /**
     * covers 8
     */
    public function testRangeReadSingleKeyOpen()
    {
        $db = self::$database;

        $range = new KeyRange([
            'start' => self::$dataset[0],
            'end' => self::$dataset[10],
        ]);

        $keyset = new KeySet(['ranges' => [$range]]);

        $res = $db->read(self::RANGES_TABLE_NAME, $keyset, array_keys(self::$dataset[0]));
        $rows = iterator_to_array($res->rows());
        $this->assertFalse(in_array(self::$dataset[0], $rows));
        $this->assertFalse(in_array(self::$dataset[10], $rows));
    }

    /**
     * covers 8
     */
    public function testRangeReadSingleKeyClosed()
    {
        $db = self::$database;

        $range = new KeyRange([
            'start' => self::$dataset[0],
            'end' => self::$dataset[10],
            'startType' => KeyRange::TYPE_CLOSED,
            'endType' => KeyRange::TYPE_CLOSED,
        ]);

        $keyset = new KeySet(['ranges' => [$range]]);

        $res = $db->read(self::RANGES_TABLE_NAME, $keyset, array_keys(self::$dataset[0]));
        $rows = iterator_to_array($res->rows());
        $this->assertTrue(in_array(self::$dataset[0], $rows));
        $this->assertTrue(in_array(self::$dataset[10], $rows));
    }

    /**
     * covers 8
     */
    public function testRangeReadSingleKeyOpenClosed()
    {
        $db = self::$database;

        $range = new KeyRange([
            'start' => self::$dataset[0],
            'end' => self::$dataset[10],
            'endType' => KeyRange::TYPE_CLOSED
        ]);

        $keyset = new KeySet(['ranges' => [$range]]);

        $res = $db->read(self::RANGES_TABLE_NAME, $keyset, array_keys(self::$dataset[0]));
        $rows = iterator_to_array($res->rows());
        $this->assertFalse(in_array(self::$dataset[0], $rows));
        $this->assertTrue(in_array(self::$dataset[10], $rows));
    }

    /**
     * covers 8
     */
    public function testRangeReadSingleKeyClosedOpen()
    {
        $db = self::$database;

        $range = new KeyRange([
            'start' => self::$dataset[0],
            'startType' => KeyRange::TYPE_CLOSED,
            'end' => self::$dataset[10],
        ]);

        $keyset = new KeySet(['ranges' => [$range]]);

        $res = $db->read(self::RANGES_TABLE_NAME, $keyset, array_keys(self::$dataset[0]));
        $rows = iterator_to_array($res->rows());
        $this->assertTrue(in_array(self::$dataset[0], $rows));
        $this->assertFalse(in_array(self::$dataset[10], $rows));
    }

    /**
     * covers 8
     */
    public function testRangeReadPartialKeyOpen()
    {
        $db = self::$database;

        $range = new KeyRange([
            'start' => [self::$dataset[0]['id']],
            'end' => [self::$dataset[10]['id']],
        ]);

        $keyset = new KeySet(['ranges' => [$range]]);

        $res = $db->read(self::RANGES_TABLE_NAME, $keyset, array_keys(self::$dataset[0]));
        $rows = iterator_to_array($res->rows());
        $this->assertFalse(in_array(self::$dataset[0], $rows));
        $this->assertFalse(in_array(self::$dataset[10], $rows));
    }

    /**
     * covers 8
     */
    public function testRangeReadPartialKeyClosed()
    {
        $db = self::$database;

        $range = new KeyRange([
            'start' => [self::$dataset[0]['id']],
            'end' => [self::$dataset[10]['id']],
            'startType' => KeyRange::TYPE_CLOSED,
            'endType' => KeyRange::TYPE_CLOSED,
        ]);

        $keyset = new KeySet(['ranges' => [$range]]);

        $res = $db->read(self::RANGES_TABLE_NAME, $keyset, array_keys(self::$dataset[0]));
        $rows = iterator_to_array($res->rows());
        $this->assertTrue(in_array(self::$dataset[0], $rows));
        $this->assertTrue(in_array(self::$dataset[10], $rows));
    }



    private static function generateDataset($count = 20, $ordered = false)
    {
        $dataset = [];
        for ($i = 0; $i < $count; $i++) {
            $id = ($ordered) ? $i : self::randId();
            $dataset[] = [
                'id' => $id,
                'val' => uniqid(self::TESTING_PREFIX)
            ];
        }

        return $dataset;
    }
}
