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

use Google\Cloud\Spanner\Duration;
use Google\Cloud\Spanner\Timestamp;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group spanner
 * @group spanner-snapshot
 */
class SnapshotTest extends SpannerTestCase
{
    use ExpectException;

    const TABLE_NAME = 'Snapshots';

    private static $tableName;

    public static function set_up_before_class()
    {
        parent::set_up_before_class();

        self::$tableName = uniqid(self::TABLE_NAME);

        self::$database->updateDdl(
            'CREATE TABLE ' . self::$tableName . ' (
                id INT64 NOT NULL,
                number INT64 NOT NULL
            ) PRIMARY KEY (id)'
        )->pollUntilComplete();
    }

    /**
     * covers 63
     * covers 68
     */
    public function testSnapshotStrongRead()
    {
        $db = self::$database;

        $id = $this->randId();
        $row = [
            'id' => $id,
            'number' => 1
        ];

        $db->insert(self::$tableName, $row);

        $snapshot = $db->snapshot(['strong' => true, 'returnReadTimestamp' => true]);

        $newRow = $row;
        $newRow['number'] = 2;
        $db->replace(self::$tableName, $newRow);

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

        $db->insert(self::$tableName, $row);
        sleep(1);
        $ts = new Timestamp(new \DateTimeImmutable);
        sleep(1);

        $newRow = $row;
        $newRow['number'] = 2;
        $db->replace(self::$tableName, $newRow);

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

        $db->insert(self::$tableName, $row);
        sleep(1);
        $ts = new Timestamp(new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
        sleep(2);

        $newRow = $row;
        $newRow['number'] = 2;
        $db->replace(self::$tableName, $newRow);

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

        $db->insert(self::$tableName, $row);
        sleep(1);
        $ts = new Timestamp(new \DateTimeImmutable);
        sleep(1);

        $newRow = $row;
        $newRow['number'] = 2;
        $db->replace(self::$tableName, $newRow);

        $duration = new Duration(1);

        $snapshot = $db->snapshot([
            'exactStaleness' => $duration,
            'returnReadTimestamp' => true
        ]);

        $this->assertGreaterThan($ts->get()->format('U.u'), $snapshot->readTimestamp()->get()->format('U.u'));

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

        $db->insert(self::$tableName, $row);
        sleep(1);
        $ts = new Timestamp(new \DateTimeImmutable);
        sleep(1);

        $newRow = $row;
        $newRow['number'] = 2;
        $db->replace(self::$tableName, $newRow);

        $duration = new Duration(1);

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
        $this->expectException('\BadMethodCallException');

        $db = self::$database;

        $db->snapshot([
            'minReadTimestamp' => new Timestamp(new \DateTimeImmutable)
        ]);
    }

    /**
     * covers 72
     */
    public function testSnapshotMaxStalenessFails()
    {
        $this->expectException('\BadMethodCallException');

        $db = self::$database;

        $db->snapshot([
            'maxStaleness' => new Duration(1)
        ]);
    }

    private function getRow($client, $id)
    {
        $result = $client->execute('SELECT * FROM ' . self::$tableName . ' WHERE id=@id', [
            'parameters' => [
                'id' => $id
            ]
        ]);

        return $result->rows()->current();
    }
}
