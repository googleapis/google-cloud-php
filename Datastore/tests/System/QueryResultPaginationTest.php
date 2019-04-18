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
use Google\Cloud\Datastore\Query\QueryInterface;

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

        $this->assertQueryCount(self::$expectedTotal, $client, $q);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testQueryPagination(DatastoreClient $client)
    {
        $q = $client->query()->kind(self::$kind);

        $this->assertQueryCount(self::$expectedTotal, $client, $q);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testGqlQueryPaginationByPage(DatastoreClient $client)
    {
        $q = $client->gqlQuery('SELECT * FROM ' . self::$kind);

        $this->assertQueryPageCount(self::$expectedTotal, $client, $q);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testQueryPaginationByPage(DatastoreClient $client)
    {
        $q = $client->query()->kind(self::$kind);

        $this->assertQueryPageCount(self::$expectedTotal, $client, $q);
    }

    private function assertQueryCount($expected, DatastoreClient $client, QueryInterface $query)
    {
        $res = $client->runQuery($query);

        $count = count(iterator_to_array($res));

        $this->assertEquals($expected, $count);
    }

    private function assertQueryPageCount($expected, DatastoreClient $client, QueryInterface $query)
    {
        $res = $client->runQuery($query);

        $pages = 0;
        $totalRows = 0;
        foreach ($res->iterateByPage() as $page) {
            $totalRows += count($page);
            $pages++;
        }

        $this->assertGreaterThan(1, $pages);
        $this->assertEquals($expected, $totalRows);
    }
}
