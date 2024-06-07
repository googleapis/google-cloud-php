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

use Google\Cloud\Core\Exception\DeadlineExceededException;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Spanner\KeyRange;
use Google\Cloud\Spanner\KeySet;

/**
 * @group spanner
 * @group spanner-read
 * @group spanner-postgres
 */
class PgReadTest extends SpannerPgTestCase
{
    private static $readTableName;
    private static $rangeTableName;
    private static $indexes = [];
    private static $dataset;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$readTableName = "read_table";
        self::$rangeTableName = "range_table";

        $create = 'CREATE TABLE %s (
            id bigint NOT NULL,
            val varchar(1024) NOT NULL,
            PRIMARY KEY (id)
        )';

        $idx = 'CREATE UNIQUE INDEX %s ON %s (%s)';

        $stmts = [];
        foreach ([self::$readTableName, self::$rangeTableName] as $table) {
            $index1 = ['table' => $table, 'name' => uniqid(self::TESTING_PREFIX), 'type' => 'simple'];
            $index2 = ['table' => $table, 'name' => uniqid(self::TESTING_PREFIX), 'type' => 'complex'];

            $stmts[] = sprintf($create, $table);
            $stmts[] = sprintf($idx, $index1['name'], $table, 'id');
            $stmts[] = sprintf($idx, $index2['name'], $table, 'id, val');

            self::$indexes[] = $index1;
            self::$indexes[] = $index2;
        }

        $db = self::$database;
        $db->updateDdlBatch($stmts)->pollUntilComplete();

        self::$dataset = self::generateDataset(20, true);
        $db->insertBatch(self::$rangeTableName, self::$dataset);
    }

    public function testRangeReadSingleKeyOpen()
    {
        $db = self::$database;

        $range = new KeyRange([
            'start' => self::$dataset[0]['id'],
            'end' => self::$dataset[10]['id'],
        ]);

        $keyset = new KeySet(['ranges' => [$range]]);

        $res = $db->read(self::$rangeTableName, $keyset, array_keys(self::$dataset[0]));
        $rows = iterator_to_array($res->rows());
        $this->assertNotContains(self::$dataset[0], $rows);
        $this->assertNotContains(self::$dataset[10], $rows);
    }

    public function testRangeReadSingleKeyClosed()
    {
        $db = self::$database;

        $range = new KeyRange([
            'start' => self::$dataset[0]['id'],
            'end' => self::$dataset[10]['id'],
            'startType' => KeyRange::TYPE_CLOSED,
            'endType' => KeyRange::TYPE_CLOSED,
        ]);

        $keyset = new KeySet(['ranges' => [$range]]);

        $res = $db->read(self::$rangeTableName, $keyset, array_keys(self::$dataset[0]));
        $rows = iterator_to_array($res->rows());
        $this->assertContains(self::$dataset[0], $rows);
        $this->assertContains(self::$dataset[10], $rows);
    }

    public function testRangeReadSingleKeyOpenClosed()
    {
        $db = self::$database;

        $range = new KeyRange([
            'start' => self::$dataset[0]['id'],
            'end' => self::$dataset[10]['id'],
            'endType' => KeyRange::TYPE_CLOSED
        ]);

        $keyset = new KeySet(['ranges' => [$range]]);

        $res = $db->read(self::$rangeTableName, $keyset, array_keys(self::$dataset[0]));
        $rows = iterator_to_array($res->rows());
        $this->assertNotContains(self::$dataset[0], $rows);
        $this->assertContains(self::$dataset[10], $rows);
    }

    public function testRangeReadSingleKeyClosedOpen()
    {
        $db = self::$database;

        $range = new KeyRange([
            'start' => self::$dataset[0]['id'],
            'end' => self::$dataset[10]['id'],
            'startType' => KeyRange::TYPE_CLOSED,
        ]);

        $keyset = new KeySet(['ranges' => [$range]]);

        $res = $db->read(self::$rangeTableName, $keyset, array_keys(self::$dataset[0]));
        $rows = iterator_to_array($res->rows());
        $this->assertContains(self::$dataset[0], $rows);
        $this->assertNotContains(self::$dataset[10], $rows);
    }

    public function testRangeReadPartialKeyOpen()
    {
        $db = self::$database;

        $range = new KeyRange([
            'start' => [self::$dataset[0]['id']],
            'end' => [self::$dataset[10]['id']],
        ]);

        $keyset = new KeySet(['ranges' => [$range]]);

        $res = $db->read(self::$rangeTableName, $keyset, array_keys(self::$dataset[0]));
        $rows = iterator_to_array($res->rows());
        $this->assertNotContains(self::$dataset[0], $rows);
        $this->assertNotContains(self::$dataset[10], $rows);
    }

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

        $res = $db->read(self::$rangeTableName, $keyset, array_keys(self::$dataset[0]));
        $rows = iterator_to_array($res->rows());
        $this->assertContains(self::$dataset[0], $rows);
        $this->assertContains(self::$dataset[10], $rows);
    }

    public function testRangeReadIndexSingleKeyOpen()
    {
        $db = self::$database;

        $range = new KeyRange([
            'start' => self::$dataset[0],
            'end' => self::$dataset[10],
        ]);

        $keyset = new KeySet(['ranges' => [$range]]);

        $res = $db->read(self::$rangeTableName, $keyset, array_keys(self::$dataset[0]), [
            'index' => $this->getIndexName(self::$rangeTableName, 'complex')
        ]);
        $rows = iterator_to_array($res->rows());
        $this->assertNotContains(self::$dataset[0], $rows);
        $this->assertNotContains(self::$dataset[10], $rows);
    }

    public function testRangeReadIndexSingleKeyClosed()
    {
        $db = self::$database;

        $range = new KeyRange([
            'start' => self::$dataset[0],
            'end' => self::$dataset[10],
            'startType' => KeyRange::TYPE_CLOSED,
            'endType' => KeyRange::TYPE_CLOSED,
        ]);

        $keyset = new KeySet(['ranges' => [$range]]);

        $res = $db->read(self::$rangeTableName, $keyset, array_keys(self::$dataset[0]), [
            'index' => $this->getIndexName(self::$rangeTableName, 'complex')
        ]);
        $rows = iterator_to_array($res->rows());
        $this->assertContains(self::$dataset[0], $rows);
        $this->assertContains(self::$dataset[10], $rows);
    }

    public function testRangeReadIndexSingleKeyOpenClosed()
    {
        $db = self::$database;

        $range = new KeyRange([
            'start' => self::$dataset[0],
            'end' => self::$dataset[10],
            'endType' => KeyRange::TYPE_CLOSED
        ]);

        $keyset = new KeySet(['ranges' => [$range]]);

        $res = $db->read(self::$rangeTableName, $keyset, array_keys(self::$dataset[0]), [
            'index' => $this->getIndexName(self::$rangeTableName, 'complex')
        ]);
        $rows = iterator_to_array($res->rows());
        $this->assertNotContains(self::$dataset[0], $rows);
        $this->assertContains(self::$dataset[10], $rows);
    }

    public function testRangeReadIndexSingleKeyClosedOpen()
    {
        $db = self::$database;

        $range = new KeyRange([
            'start' => self::$dataset[0],
            'startType' => KeyRange::TYPE_CLOSED,
            'end' => self::$dataset[10],
        ]);

        $keyset = new KeySet(['ranges' => [$range]]);

        $res = $db->read(self::$rangeTableName, $keyset, array_keys(self::$dataset[0]), [
            'index' => $this->getIndexName(self::$rangeTableName, 'complex')
        ]);
        $rows = iterator_to_array($res->rows());
        $this->assertContains(self::$dataset[0], $rows);
        $this->assertNotContains(self::$dataset[10], $rows);
    }

    public function testRangeReadIndexPartialKeyOpen()
    {
        $db = self::$database;

        $range = new KeyRange([
            'start' => [self::$dataset[0]['id']],
            'end' => [self::$dataset[10]['id']],
        ]);

        $keyset = new KeySet(['ranges' => [$range]]);

        $res = $db->read(self::$rangeTableName, $keyset, array_keys(self::$dataset[0]), [
            'index' => $this->getIndexName(self::$rangeTableName, 'complex')
        ]);
        $rows = iterator_to_array($res->rows());
        $this->assertNotContains(self::$dataset[0], $rows);
        $this->assertNotContains(self::$dataset[10], $rows);
    }

    public function testRangeReadIndexPartialKeyClosed()
    {
        $db = self::$database;

        $range = new KeyRange([
            'start' => [self::$dataset[0]['id']],
            'end' => [self::$dataset[10]['id']],
            'startType' => KeyRange::TYPE_CLOSED,
            'endType' => KeyRange::TYPE_CLOSED,
        ]);

        $keyset = new KeySet(['ranges' => [$range]]);

        $res = $db->read(self::$rangeTableName, $keyset, array_keys(self::$dataset[0]), [
            'index' => $this->getIndexName(self::$rangeTableName, 'complex')
        ]);
        $rows = iterator_to_array($res->rows());
        $this->assertContains(self::$dataset[0], $rows);
        $this->assertContains(self::$dataset[10], $rows);
    }

    public function testReadWithLimit()
    {
        $db = self::$database;

        $res = function ($limit) use ($db) {
            $keyset = new KeySet(['all' => true]);
            return $db->read(self::$rangeTableName, $keyset, array_keys(self::$dataset[0]), [
                'limit' => $limit
            ])->rows();
        };

        $limitCount = count(iterator_to_array($res(10)));
        $unlimitCount = count(iterator_to_array($res(0)));

        $this->assertEquals(10, $limitCount);
        $this->assertNotEquals($limitCount, $unlimitCount);
    }

    public function testReadOverIndexWithLimit()
    {
        $db = self::$database;

        $res = function ($limit) use ($db) {
            $keyset = new KeySet(['all' => true]);
            return $db->read(self::$rangeTableName, $keyset, array_keys(self::$dataset[0]), [
                'limit' => $limit,
                'index' => $this->getIndexName(self::$rangeTableName, 'complex')
            ])->rows();
        };

        $limitCount = count(iterator_to_array($res(10)));
        $unlimitCount = count(iterator_to_array($res(0)));

        $this->assertEquals(10, $limitCount);
        $this->assertNotEquals($limitCount, $unlimitCount);
    }

    public function testReadPoint()
    {
        $dataset = $this->generateDataset();

        $db = self::$database;
        $db->insertBatch(self::$readTableName, $dataset);

        $indexes = array_rand($dataset, 4);
        $points = [];
        $keys = [];
        array_walk($indexes, function ($index) use ($dataset, &$points, &$keys) {
            $points[] = $dataset[$index];
            $keys[] = $dataset[$index]['id'];
        });

        $keyset = new KeySet(['keys' => $keys]);

        $res = $db->read(self::$readTableName, $keyset, array_keys($dataset[0]));
        $rows = $res->rows();
        foreach ($rows as $index => $row) {
            $this->assertContains($row, $dataset);
            $this->assertContains($row, $points);
        }
    }

    public function testReadPointOverIndex()
    {
        $dataset = $this->generateDataset();

        $db = self::$database;
        $db->insertBatch(self::$readTableName, $dataset);

        $indexes = array_rand($dataset, 4);
        $points = [];
        $keys = [];
        array_walk($indexes, function ($index) use ($dataset, &$points, &$keys) {
            $points[] = $dataset[$index];
            $keys[] = array_values($dataset[$index]);
        });

        $keyset = new KeySet(['keys' => $keys]);

        $res = $db->read(self::$readTableName, $keyset, array_keys($dataset[0]), [
            'index' => $this->getIndexName(self::$readTableName, 'complex')
        ]);
        $rows = $res->rows();
        foreach ($rows as $index => $row) {
            $this->assertContains($row, $dataset);
            $this->assertContains($row, $points);
        }
    }

    public function testReadInvalidDatabase()
    {
        $this->expectException(NotFoundException::class);

        $db = self::$client->connect('google-cloud-php-system-tests', uniqid(self::TESTING_PREFIX));
        $keyset = new KeySet(['all' => true]);

        $db->read(self::TEST_TABLE_NAME, $keyset, [])->rows()->current();
    }

    public function testReadInvalidTable()
    {
        $this->expectException(NotFoundException::class);

        $db = self::$database;
        $keyset = new KeySet(['all' => true]);

        $db->read('ThisIsntARealTable', $keyset, ['id'])->rows()->current();
    }

    public function testReadInvalidColumn()
    {
        $this->expectException(NotFoundException::class);

        $db = self::$database;
        $keyset = new KeySet(['all' => true]);

        $db->read(self::TEST_TABLE_NAME, $keyset, [uniqid('id')])->rows()->current();
    }

    public function testReadFailsOnDeadlineExceeded()
    {
        $this->expectException(DeadlineExceededException::class);

        $this->skipEmulatorTests();
        $db = self::$database;
        $keyset = new KeySet(['all' => true]);

        $db->read(self::TEST_TABLE_NAME, $keyset, [uniqid('id')], [
            'timeoutMillis' => 1
        ])->rows()->current();
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

    private function getIndexName($table, $type)
    {
        $res = array_filter(self::$indexes, function ($index) use ($table, $type) {
            return $index['table'] === $table && $index['type'] === $type;
        });

        if (!$res) {
            throw new \RuntimeException('index not found');
        }

        return current($res)['name'];
    }
}
