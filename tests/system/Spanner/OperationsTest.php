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
use Google\Cloud\Spanner\Timestamp;

/**
 * @group spanner
 */
class OperationsTest extends SpannerTestCase
{
    private $id = 12345;

    public function testInsert()
    {
        $db = self::$database;
        $res = $db->insert(self::TEST_TABLE_NAME, [
            'id' => $this->id,
            'name' => 'Bob',
            'birthday' => self::$client->date(new \DateTime('2000-01-01'))
        ]);

        $this->assertInstanceOf(Timestamp::class, $res);
    }

    /**
     * @depends testInsert
     */
    public function testExecute()
    {
        $db = self::$database;

        $row = $this->getRow();
        $this->assertEquals($this->id, $row['id']);
    }

    /**
     * @depends testInsert
     */
    public function testRead()
    {
        $db = self::$database;

        $keySet = self::$client->keySet([
            'keys' => [$this->id]
        ]);
        $columns = ['id', 'name'];

        $res = $db->read(self::TEST_TABLE_NAME, $keySet, $columns);
        $row = $res->rows()->current();
        $this->assertEquals($this->id, $row['id']);
    }

    /**
     * @depends testInsert
     */
    public function testUpdate()
    {
        $db = self::$database;
        $row = $this->getRow();
        $row['name'] = 'Doug';

        $db->update('Users', $row);

        $row = $this->getRow();
        $this->assertEquals('Doug', $row['name']);
    }

    /**
     * @depends testInsert
     */
    public function testInsertOrUpdate()
    {
        $db = self::$database;
        $db->insertOrUpdate('Users', [
            'id' => $this->id,
            'name' => 'Dave',
            'birthday' => new Date(new \DateTime('1990-01-01'))
        ]);

        $row = $this->getRow();
        $this->assertEquals('Dave', $row['name']);
    }

    /**
     * @depends testInsert
     */
    public function testReplace()
    {
        $db = self::$database;
        $db->replace('Users', [
            'id' => $this->id,
            'name' => 'John',
            'birthday' => new Date(new \DateTime('1990-01-01'))
        ]);

        $row = $this->getRow();
        $this->assertEquals('John', $row['name']);
    }

    /**
     * @depends testInsert
     */
    public function testDelete()
    {
        $db = self::$database;
        $keySet = self::$client->keySet([
            'keys' => [$this->id]
        ]);

        $db->delete(self::TEST_TABLE_NAME, $keySet);
        $this->assertNull($this->getRow());
    }

    private function getRow()
    {
        $db = self::$database;
        $res = $db->execute('SELECT * FROM '. self::TEST_TABLE_NAME .' WHERE id=@id', [
            'parameters' => [
                'id' => $this->id
            ]
        ]);

        return $res->rows()->current();
    }
}
