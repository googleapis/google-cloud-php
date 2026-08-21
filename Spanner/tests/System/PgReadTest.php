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
use Google\Cloud\Core\Testing\System\SystemTestCase;
use Google\Cloud\Spanner\KeyRange;
use Google\Cloud\Spanner\KeySet;

/**
 * @group spanner
 * @group spanner-read
 * @group spanner-postgres
 */
class PgReadTest extends SystemTestCase
{
    const READ_TABLE_NAME = 'PgReadTable';
    const RANGE_TABLE_NAME = 'PgRangeTable';
    use PgSystemTestCaseTrait;

    
    
    private static $indexes = [];
    private static $dataset;

    /**
     * @beforeClass
     */
    public static function setUpTestFixtures(): void
    {
        self::setUpTestDatabase();

        $db = self::$database;
        $db->delete(self::READ_TABLE_NAME, new KeySet(['all' => true]));
        $db->delete(self::RANGE_TABLE_NAME, new KeySet(['all' => true]));

        self::$dataset = self::generateDataset(20, true);
        $db->insertOrUpdateBatch(self::RANGE_TABLE_NAME, self::$dataset);
    }

    public function testRangeReadSingleKeyOpen()
    {
        $db = self::$database;

        $range = new KeyRange([
            'start' => self::$dataset[0]['id'],
            'end' => self::$dataset[10]['id'],
        ]);

        $keyset = new KeySet(['ranges' => [$range]]);

        $res = $db->read(self::RANGE_TABLE_NAME, $keyset, array_keys(self::$dataset[0]));
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

        $res = $db->read(self::RANGE_TABLE_NAME, $keyset, array_keys(self::$dataset[0]));
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

        $res = $db->read(self::RANGE_TABLE_NAME, $keyset, array_keys(self::$dataset[0]));
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

        $res = $db->read(self::RANGE_TABLE_NAME, $keyset, array_keys(self::$dataset[0]));
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

        $res = $db->read(self::RANGE_TABLE_NAME, $keyset, array_keys(self::$dataset[0]));
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

        $res = $db->read(self::RANGE_TABLE_NAME, $keyset, array_keys(self::$dataset[0]));
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

        $res = $db->read(self::RANGE_TABLE_NAME, $keyset, array_keys(self::$dataset[0]), [
            'index' => $this->getIndexName(self::RANGE_TABLE_NAME, 'complex')
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

        $res = $db->read(self::RANGE_TABLE_NAME, $keyset, array_keys(self::$dataset[0]), [
            'index' => $this->getIndexName(self::RANGE_TABLE_NAME, 'complex')
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

        $res = $db->read(self::RANGE_TABLE_NAME, $keyset, array_keys(self::$dataset[0]), [
            'index' => $this->getIndexName(self::RANGE_TABLE_NAME, 'complex')
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

        $res = $db->read(self::RANGE_TABLE_NAME, $keyset, array_keys(self::$dataset[0]), [
            'index' => $this->getIndexName(self::RANGE_TABLE_NAME, 'complex')
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

        $res = $db->read(self::RANGE_TABLE_NAME, $keyset, array_keys(self::$dataset[0]), [
            'index' => $this->getIndexName(self::RANGE_TABLE_NAME, 'complex')
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

        $res = $db->read(self::RANGE_TABLE_NAME, $keyset, array_keys(self::$dataset[0]), [
            'index' => $this->getIndexName(self::RANGE_TABLE_NAME, 'complex')
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
            return $db->read(self::RANGE_TABLE_NAME, $keyset, array_keys(self::$dataset[0]), [
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
            return $db->read(self::RANGE_TABLE_NAME, $keyset, array_keys(self::$dataset[0]), [
                'limit' => $limit,
                'index' => $this->getIndexName(self::RANGE_TABLE_NAME, 'complex')
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
        $db->insertOrUpdateBatch(self::READ_TABLE_NAME, $dataset);

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
            $this->assertContains($row, $dataset);
            $this->assertContains($row, $points);
        }
    }

    public function testReadPointOverIndex()
    {
        $dataset = $this->generateDataset();

        $db = self::$database;
        $db->insertOrUpdateBatch(self::READ_TABLE_NAME, $dataset);

        $indexes = array_rand($dataset, 4);
        $points = [];
        $keys = [];
        array_walk($indexes, function ($index) use ($dataset, &$points, &$keys) {
            $points[] = $dataset[$index];
            $keys[] = array_values($dataset[$index]);
        });

        $keyset = new KeySet(['keys' => $keys]);

        $res = $db->read(self::READ_TABLE_NAME, $keyset, array_keys($dataset[0]), [
            'index' => $this->getIndexName(self::READ_TABLE_NAME, 'complex')
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

        // The equiavalent test for the GSQL dialect is also skipped.
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
        return $type === 'simple' ? $table . '_Idx1' : $table . '_Idx2';
    }
}
