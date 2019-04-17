<?php
/**
 * Copyright 2019 Google LLC
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
 * @group datastore-query-pagination
 */
class QueryResultPaginationTest extends DatastoreTestCase
{
    private static $expectedTotal = 610;
    private static $kind;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        self::$kind = uniqid(self::TESTING_PREFIX);

        $client = self::$restClient;
        // seed a large set.
        $set = [];
        for ($i = 0; $i < self::$expectedTotal; $i++) {
            $set[] = $client->entity(self::$kind, [
                'a' => rand(1, 10)
            ]);

            if (count($set) === 100) {
                $client->insertBatch($set);
                $set = [];
            }
        }

        if ($set) {
            $client->insertBatch($set);
        }
    }

    public static function tearDownAfterClass()
    {
        $client = self::$restClient;
        $query = $client->query()->kind(self::$kind);
        $set = [];
        foreach ($client->runQuery($query) as $entity) {
            $set[] = $entity->key();

            if (count($set) === 100) {
                $client->deleteBatch($set);
                $set = [];
            }
        }
    }

    /**
     * @dataProvider clientProvider
     */
    public function testGqlQueryPagination(DatastoreClient $client)
    {
        $q = $client->gqlQuery('SELECT * FROM ' . self::$kind);

        $res = $client->runQuery($q);

        $count = count(iterator_to_array($res));

        $this->assertEquals(self::$expectedTotal, $count);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testQueryPagination(DatastoreClient $client)
    {
        $q = $client->query()->kind(self::$kind);

        $res = $client->runQuery($q);

        $count = count(iterator_to_array($res));

        $this->assertEquals(self::$expectedTotal, $count);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testGqlQueryPaginationByPage(DatastoreClient $client)
    {
        $q = $client->gqlQuery('SELECT * FROM ' . self::$kind);

        $res = $client->runQuery($q);

        $count = count(iterator_to_array($res->iterateByPage()));

        $this->assertGreaterThan(1, $count);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testQueryPaginationByPage(DatastoreClient $client)
    {
        $q = $client->query()->kind(self::$kind);

        $res = $client->runQuery($q);

        $count = count(iterator_to_array($res->iterateByPage()));

        $this->assertGreaterThan(1, $count);
    }
}
