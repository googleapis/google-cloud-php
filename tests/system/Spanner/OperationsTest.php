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

use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Spanner\Date;
use Google\Cloud\Spanner\Timestamp;

/**
 * @group spanner
 */
class OperationsTest extends SpannerTestCase
{
    private static $id1;
    private static $id2;
    private static $name1;
    private static $name2;

    public static function setUpBeforeClass()
    {
        self::$id1 = rand(1000,9999);
        self::$id2 = rand(1,999);
        self::$name1 = uniqid(self::TESTING_PREFIX);
        self::$name2 = uniqid(self::TESTING_PREFIX);

        parent::setUpBeforeClass();

        self::$database->insert(self::TEST_TABLE_NAME, [
            'id' => self::$id1,
            'name' => self::$name1,
            'birthday' => new Date(new \DateTime('2000-01-01'))
        ]);
    }

    public function testInsert()
    {
        $db = self::$database;

        $res = $db->insert(self::TEST_TABLE_NAME, [
            'id' => self::$id2,
            'name' => self::$name2,
            'birthday' => new Date(new \DateTime('2000-01-01'))
        ]);

        $this->assertInstanceOf(Timestamp::class, $res);
    }

    public function testExecute()
    {
        $db = self::$database;

        $row = $this->getRow();
        $this->assertEquals(self::$id2, $row['id']);
    }

    public function testRead()
    {
        $db = self::$database;

        $keySet = self::$client->keySet([
            'keys' => [self::$id2]
        ]);
        $columns = ['id', 'name'];

        $res = $db->read(self::TEST_TABLE_NAME, $keySet, $columns);
        $row = $res->rows()->current();
        $this->assertEquals(self::$id2, $row['id']);
    }

    public function testUpdate()
    {
        $db = self::$database;
        $row = $this->getRow();
        $row['name'] = 'Doug';

        $db->update('Users', $row);

        $row = $this->getRow();
        $this->assertEquals('Doug', $row['name']);
    }

    public function testInsertOrUpdate()
    {
        $db = self::$database;
        $db->insertOrUpdate('Users', [
            'id' => self::$id2,
            'name' => 'Dave',
            'birthday' => new Date(new \DateTime('1990-01-01'))
        ]);

        $row = $this->getRow();
        $this->assertEquals('Dave', $row['name']);
    }

    public function testReplace()
    {
        $db = self::$database;
        $db->replace('Users', [
            'id' => self::$id2,
            'name' => 'John',
            'birthday' => new Date(new \DateTime('1990-01-01'))
        ]);

        $row = $this->getRow();
        $this->assertEquals('John', $row['name']);
    }

    public function testDelete()
    {
        $db = self::$database;
        $keySet = self::$client->keySet([
            'keys' => [self::$id2]
        ]);

        $db->delete(self::TEST_TABLE_NAME, $keySet);
        $this->assertNull($this->getRow());
    }

    public function testEmptyRead()
    {
        $db = self::$database;

        $keySet = self::$client->keySet(['keys' => [99999]]);

        $res = $db->read(self::TEST_TABLE_NAME, $keySet, ['id','name']);
        $this->assertEmpty(iterator_to_array($res->rows()));
    }

    public function testEmptyReadOnIndex()
    {
        $db = self::$database;

        $keySet = self::$client->keySet(['keys' => [99999]]);

        $res = $db->read(self::TEST_TABLE_NAME, $keySet, ['id','name'], [
            'index' => self::TEST_INDEX_NAME
        ]);

        $this->assertEmpty(iterator_to_array($res->rows()));
    }

    public function testReadSingleKeyFromIndex()
    {
        $db = self::$database;

        $keySet = self::$client->keySet(['keys' => [self::$name1]]);

        $res = $db->read(self::TEST_TABLE_NAME, $keySet, ['name'], [
            'index' => self::TEST_INDEX_NAME
        ]);

        $this->assertEquals(self::$name1, $res->rows()->current()['name']);
    }

    public function testReadNonExistentSingleKey()
    {
        $db = self::$database;

        $keySet = self::$client->keySet([
            'keys' => [99999]
        ]);

        $res = $db->read(self::TEST_TABLE_NAME, $keySet, ['id','name']);
        $this->assertEmpty(iterator_to_array($res->rows()));
    }

    public function testReadNonExistentSingleKeyFromIndex()
    {
        $db = self::$database;

        $keySet = self::$client->keySet(['keys' => ['foobar']]);

        $res = $db->read(self::TEST_TABLE_NAME, $keySet, ['name'], [
            'index' => self::TEST_INDEX_NAME
        ]);

        $this->assertEmpty(iterator_to_array($res->rows()));
    }

    private function getRow()
    {
        $db = self::$database;
        $res = $db->execute('SELECT * FROM '. self::TEST_TABLE_NAME .' WHERE id=@id', [
            'parameters' => [
                'id' => self::$id2
            ]
        ]);

        return $res->rows()->current();
    }
}
