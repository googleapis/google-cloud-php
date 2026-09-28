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

use Google\Cloud\Core\Exception\BadRequestException;
use Google\Cloud\Core\Testing\System\SystemTestCase;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\V1\ReadRequest\LockHint;
use Google\Cloud\Spanner\V1\ReadRequest\OrderBy;
use Google\Protobuf\Duration;

/**
 * @group spanner
 * @group spanner-snapshot
 */
class SnapshotTest extends SystemTestCase
{
    use SystemTestCaseTrait;

    const TABLE_NAME = 'Snapshots';

    

    /**
     * @beforeClass
     */
    public static function setUpTestFixtures(): void
    {
        self::setUpTestDatabase();
    }

    public function testSnapshotStrongRead()
    {
        $db = self::$database;

        $id = $this->randId();
        $row = [
            'id' => $id,
            'number' => 1
        ];

        $db->insert(self::TABLE_NAME, $row);

        $snapshot = $db->snapshot(['strong' => true, 'returnReadTimestamp' => true]);

        $newRow = $row;
        $newRow['number'] = 2;
        $db->replace(self::TABLE_NAME, $newRow);

        $res = $this->getRow($snapshot, $id);
        $this->assertEquals($res, $row);
        $this->assertInstanceOf(Timestamp::class, $snapshot->readTimestamp());
    }

    /**
     * covers 64
     * covers 69
     */
    public function testSnapshotExactTimestampRead()
    {
        $db = self::$database;

        $id = $this->randId();
        $row = [
            'id' => $id,
            'number' => 1
        ];

        $db->insert(self::TABLE_NAME, $row);
        sleep(1);
        $ts = new Timestamp(new \DateTimeImmutable());
        sleep(1);

        $newRow = $row;
        $newRow['number'] = 2;
        $db->replace(self::TABLE_NAME, $newRow);

        $snapshot = $db->snapshot([
            'readTimestamp' => $ts,
            'returnReadTimestamp' => true
        ]);

        $this->assertEquals($ts->get()->format('U'), $snapshot->readTimestamp()->get()->format('U'));

        $res = $this->getRow($snapshot, $id);
        $this->assertEquals($row, $res);
    }

    /**
     * covers 65
     */
    public function testSnapshotMinReadTimestamp()
    {
        $db = self::$database;

        $id = $this->randId();
        $row = [
            'id' => $id,
            'number' => 1
        ];

        $db->insert(self::TABLE_NAME, $row);
        sleep(1);
        $ts = new Timestamp(new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
        sleep(2);

        $newRow = $row;
        $newRow['number'] = 2;
        $db->replace(self::TABLE_NAME, $newRow);

        $snapshot = $db->snapshot([
            'minReadTimestamp' => $ts,
            'singleUse' => true
        ]);

        $res = $this->getRow($snapshot, $id);
        $this->assertEquals($res, $newRow);
    }

    /**
     * covers 66
     * covers 70
     */
    public function testSnapshotExactStaleness()
    {
        $db = self::$database;

        $id = $this->randId();
        $row = [
            'id' => $id,
            'number' => 1
        ];

        $db->insert(self::TABLE_NAME, $row);
        sleep(1);
        $ts = new Timestamp(new \DateTimeImmutable());
        sleep(1);

        $newRow = $row;
        $newRow['number'] = 2;
        $db->replace(self::TABLE_NAME, $newRow);

        $duration = new Duration(['seconds' => 1, 'nanos' => 0]);

        $snapshot = $db->snapshot([
            'exactStaleness' => $duration,
            'returnReadTimestamp' => true
        ]);

        $this->assertGreaterThan(
            $ts->get()->format('U.u'),
            $snapshot->readTimestamp()->get()->format('U.u')
        );

        $res = $this->getRow($snapshot, $id);
        $this->assertEquals($row, $res);
    }

    /**
     * covers 67
     */
    public function testSnapshotMaxStaleness()
    {
        $db = self::$database;

        $id = $this->randId();
        $row = [
            'id' => $id,
            'number' => 1
        ];

        $db->insert(self::TABLE_NAME, $row);
        sleep(1);
        $ts = new Timestamp(new \DateTimeImmutable());
        sleep(1);

        $newRow = $row;
        $newRow['number'] = 2;
        $db->replace(self::TABLE_NAME, $newRow);

        $duration = new Duration(['seconds' => 1, 'nanos' => 0]);

        $snapshot = $db->snapshot([
            'maxStaleness' => $duration,
            'returnReadTimestamp' => true,
            'singleUse' => true
        ]);

        $res = $this->getRow($snapshot, $id);
        $this->assertEquals($res, $newRow);
    }

    /**
     * covers 71
     */
    public function testSnapshotMinReadTimestampFails()
    {
        $this->expectException(\BadMethodCallException::class);

        $db = self::$database;

        $db->snapshot([
            'minReadTimestamp' => new Timestamp(new \DateTimeImmutable())
        ]);
    }

    /**
     * covers 72
     */
    public function testSnapshotMaxStalenessFails()
    {
        $this->expectException(\BadMethodCallException::class);

        $db = self::$database;

        $db->snapshot([
            'maxStaleness' => new Duration(['seconds' => 1, 'nanos' => 0])
        ]);
    }

    public function testOrderByInSnapshot()
    {
        $db = self::$database;

        $db->insertOrUpdateBatch(self::TABLE_NAME, [
            [
                'id' => self::randId(),
                'number' => 1
            ],
            [
                'id' => self::randId(),
                'number' => 2
            ]
        ]);

        $keySet = new KeySet([
            'all' => true
        ]);
        $cols = ['id', 'number'];
        $options = [
            'orderBy' => OrderBy::ORDER_BY_PRIMARY_KEY,
            'limit' => 2,
        ];

        $snapshot = $db->snapshot();
        $res = $snapshot->read(self::TABLE_NAME, $keySet, $cols, $options);
        $rows = iterator_to_array($res->rows());

        // Assert that the returned rows are sorted by the 'id' property.
        for ($i = 0; $i < count($rows) - 1; $i++) {
            $this->assertLessThanOrEqual(
                $rows[$i + 1]['id'],
                $rows[$i]['id'],
                'The array is not sorted by id in ascending order.'
            );
        }
    }

    public function testLockHintInSnapshotThrowsAnException()
    {
        $this->skipEmulatorTests();
        $this->expectException(BadRequestException::class);
        $db = self::$database;

        $keySet = new KeySet([
            'all' => true
        ]);
        $cols = ['id', 'number'];

        // LockHint is only for read-write transactions
        $options = [
            'lockHint' => LockHint::LOCK_HINT_EXCLUSIVE,
            'limit' => 2,
        ];

        $snapshot = $db->snapshot();
        $res = $snapshot->read(self::TABLE_NAME, $keySet, $cols, $options);
        $rows = iterator_to_array($res->rows());
    }

    private function getRow($client, $id)
    {
        $result = $client->execute('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id=@id', [
            'parameters' => [
                'id' => $id
            ]
        ]);

        return $result->rows()->current();
    }
}
