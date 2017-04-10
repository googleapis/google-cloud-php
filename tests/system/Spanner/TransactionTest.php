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

use Google\Cloud\Spanner\Date;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Timestamp;

/**
 * @group spannerz
 */
class TransactionTest extends SpannerTestCase
{
    private static $row = [];

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        self::$row = [
            'id' => rand(1000,9999),
            'name' => uniqid(self::TESTING_PREFIX),
            'birthday' => new Date(new \DateTime('2000-01-01'))
        ];
        echo 'inserting row'.PHP_EOL;
        self::$database->insert(self::TEST_TABLE_NAME, self::$row);
    }

    public function testRunTransaction()
    {
        $db = self::$database;

        $db->runTransaction(function ($t) {
            $id = rand(1,346464);
            $t->insert(self::TEST_TABLE_NAME, [
                'id' => $id,
                'name' => uniqid(self::TESTING_PREFIX),
                'birthday' => new Date(new \DateTime)
            ]);

            $t->commit();
        });

        $db->runTransaction(function ($t) {
            $t->rollback();
        });
    }

    public function testStrongRead()
    {
        $db = self::$database;

        $snapshot = $db->snapshot([
            'strong' => true,
            'returnReadTimestamp' => true
        ]);

        list($keySet, $cols) = $this->readArgs();
        $res = $snapshot->read(self::TEST_TABLE_NAME, $keySet, $cols);

        $row = $res->rows()->current();

        $this->assertEquals(self::$row, $row);
        $this->assertInstanceOf(Timestamp::class, $snapshot->readTimestamp());
    }

    public function testExactTimestampRead()
    {
        $db = self::$database;

        $ts = new Timestamp(new \DateTimeImmutable);

        $row = $db->execute('SELECT * FROM '. self::TEST_TABLE_NAME .' WHERE id = @id', [
            'parameters' => ['id' => self::$row['id']]
        ])->rows()->current();
        $row['name'] = uniqid(self::TESTING_PREFIX);

        $db->update(self::TEST_TABLE_NAME, $row);
        sleep(10);

        $snapshot = $db->snapshot([
            'returnReadTimestamp' => true,
            'readTimestamp' => $ts
        ]);

        list($keySet, $cols) = $this->readArgs();

        echo "Cached row data (should match snapshot result)".PHP_EOL;
        print_r(self::$row);

        $res = $snapshot->read(self::TEST_TABLE_NAME, $keySet, $cols)->rows();
        echo PHP_EOL."Snapshot Result". PHP_EOL;
        print_r(iterator_to_array($res));

        echo PHP_EOL."Database Result". PHP_EOL;
        print_r(iterator_to_array($db->read(self::TEST_TABLE_NAME, $keySet, $cols)->rows()));
        exit;
        $row = $res->current();

        $this->assertEquals($ts->get(), $snapshot->readTimestamp()->get());
        $this->assertEquals($row, self::$row);

        // Reset to previous state.
        $db->update(self::TEST_TABLE_NAME, self::$row);
    }

    private function readArgs()
    {
        return [
            new KeySet([
                'keys' => [self::$row['id']]
            ]),
            array_keys(self::$row)
        ];
    }
}
