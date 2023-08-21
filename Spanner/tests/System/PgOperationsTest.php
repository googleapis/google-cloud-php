<?php
/**
 * Copyright 2023 Google Inc.
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

use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Spanner\Date;

/**
 * @group spanner
 * @group spanner-operations
 * @group spanner-postgres
 */
class PgOperationsTest extends SpannerPgTestCase
{
    use DatabaseRoleTrait;

    private static $row = [];

    private static $id;
    private static $isSetup = false;

    public static function setUpBeforeClass(): void
    {
        if (self::$isSetup) {
            return;
        }
        parent::setUpBeforeClass();

        self::$id = rand(1000, 9999);
        self::$row = [
            'id' => self::$id,
            'name' => uniqid(self::TESTING_PREFIX),
            'birthday' => new Date(new \DateTime('2000-01-01'))
        ];

        self::$database->insert(self::TEST_TABLE_NAME, self::$row);
        self::$isSetup = true;
    }

    /**
     * @dataProvider insertDbProvider
     */
    public function testInsertWithDbRole($db, $values, $expected)
    {
        // Emulator does not support FGAC
        $this->skipEmulatorTests();

        $error = null;

        try {
            $res = $db->insert(self::TEST_TABLE_NAME, $values);
        } catch (ServiceException $e) {
            $error = $e;
        }

        if ($expected === null) {
            $this->assertEquals($error, $expected);
        } else {
            $this->assertEquals($error->getServiceException()->getStatus(), $expected);
        }
    }

    /**
     * @dataProvider readDbProvider
     */
    public function testReadWithDbRole($db, $expected)
    {
        // Emulator does not support FGAC
        $this->skipEmulatorTests();

        $error = null;
        $keySet = self::$client->keySet([
            'keys' => [self::$id]
        ]);
        $columns = ['id', 'name', 'birthday'];

        try {
            $res = $db->read(self::TEST_TABLE_NAME, $keySet, $columns);
            $row = $res->rows()->current();
        } catch (ServiceException $e) {
            $error = $e;
        }

        if ($expected === null) {
            $this->assertEquals(self::$id, $row['id']);
        } else {
            $this->assertEquals($error->getServiceException()->getStatus(), $expected);
        }
    }
}
