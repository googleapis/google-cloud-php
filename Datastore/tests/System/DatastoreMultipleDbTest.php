<?php
/**
 * Copyright 2022 Google LLC.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Datastore\Tests\System;

use Google\Cloud\Datastore\DatastoreClient;

/**
 * @group datastore
 * @group datastore-multipledb
 * @group datastore-query
 */
class DatastoreMultipleDbTest extends DatastoreMultipleDbTestCase
{
    private static $ancestor;
    private static $kind = 'Kingdom';
    private static $data = [
        [
            'knownDances' => 1,
            'name' => 'Anand Estate',
        ],
        [
            'knownDances' => 2,
            'name' => 'Shaffer City',
        ],
        [
            'knownDances' => 5,
            'name' => 'Supplee Castle',
        ],
        [
            'knownDances' => 10,
            'name' => 'Dhingra Assets',
        ],
    ];

    public static function set_up_before_class()
    {
        parent::set_up_multi_db_before_class();
        self::$ancestor = self::$restMultiDbClient->key(self::$kind, 'V_A');
        $key1 = self::$restMultiDbClient->key(self::$kind, 'B_S');
        $key1->ancestorKey(self::$ancestor);
        $key2 = self::$restMultiDbClient->key(self::$kind, 'D_S');
        $key2->ancestorKey(self::$ancestor);
        $key3 = self::$restMultiDbClient->key(self::$kind, 'S_D');

        self::$restMultiDbClient->insertBatch([
            self::$restMultiDbClient->entity(self::$ancestor, self::$data[0]),
            self::$restMultiDbClient->entity($key1, self::$data[1]),
            self::$restMultiDbClient->entity($key2, self::$data[2]),
            self::$restMultiDbClient->entity($key3, self::$data[3]),
        ]);

        // on rare occasions the queries below are returning no results when
        // triggered immediately after an insert operation. the sleep here
        // is intended to help alleviate this issue.
        sleep(1);

        self::$localDeletionQueue->add(self::$ancestor);
        self::$localDeletionQueue->add($key1);
        self::$localDeletionQueue->add($key2);
        self::$localDeletionQueue->add($key3);
    }

    public static function tear_down_after_class()
    {
        self::tearDownFixtures();
    }

    /**
     * @dataProvider multiDbClientProvider
     */
    public function testQueryMultipleDbClients(DatastoreClient $client)
    {
        $query = $client->query()
            ->kind(self::$kind)
            ->order('knownDances');

        $results = iterator_to_array($client->runQuery($query));

        $this->assertEquals(self::$data[0], $results[0]->get());
        $this->assertEquals(self::$data[1], $results[1]->get());
        $this->assertEquals(self::$data[2], $results[2]->get());
        $this->assertEquals(self::$data[3], $results[3]->get());
        $this->assertCount(4, $results);
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testQueryDefaultDbClients(DatastoreClient $client)
    {
        $query = $client->query()
            ->kind(self::$kind)
            ->order('knownDances');

        $results = iterator_to_array($client->runQuery($query));

        $this->assertCount(0, $results);
    }
}
