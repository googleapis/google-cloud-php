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

/**
 * @group spanner
 */
class SnapshotTest extends SpannerTestCase
{
    private $id;

    public function setUp()
    {
        $this->id = rand(1,99999);
    }

    public function testSnapshot()
    {
        $db = self::$database;

        $db->insert('Users', [
            'id' => $this->id,
            'name' => 'John',
            'birthday' => new Date(new \DateTime('1990-01-01'))
        ]);

        $snapshot = $db->snapshot();
        $row = $this->getRow($snapshot);
        $this->assertEquals('John', $row['name']);
    }

    private function getRow($client)
    {
        $result = $client->execute('SELECT * FROM Users WHERE id=@id', [
            'parameters' => [
                'id' => $this->id
            ]
        ]);

        return $result->rows()->current();
    }
}
