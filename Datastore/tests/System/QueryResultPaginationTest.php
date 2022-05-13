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
    private static $parentKey;
    private static $testKind;

    public static function set_up_before_class()
    {
        parent::set_up_before_class();
        static $setUp = false;
        if ($setUp) {
            return;
        }

        $ancestorKind = uniqid(self::TESTING_PREFIX);

        $client = self::$restClient;
        self::$parentKey = $client->key($ancestorKind, uniqid('pagination-'));
        self::$testKind = uniqid('test-kind-');

        // seed a large set.
        $set = [];
        for ($i = 0; $i < self::$expectedTotal; $i++) {
            $key = $client->key(self::$testKind, uniqid('name-'));
            $key->ancestorKey(self::$parentKey);

            $set[] = $client->entity($key, [
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

        $setUp = true;
    }

    public static function tear_down_after_class()
    {
        self::set_up_before_class();

        $client = self::$restClient;
        $q = $client->query()
            ->hasAncestor(self::$parentKey)
            ->kind(self::$testKind);

        $set = [];
        foreach ($client->runQuery($q) as $entity) {
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
        $q = $client->gqlQuery(sprintf(
            'SELECT * FROM `%s`',
            self::$testKind
        ));

        $this->assertQueryCount(self::$expectedTotal, $client, $q);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testQueryPagination(DatastoreClient $client)
    {
        $q = $client->query()
            ->hasAncestor(self::$parentKey)
            ->kind(self::$testKind);

        $this->assertQueryCount(self::$expectedTotal, $client, $q);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testGqlQueryPaginationByPage(DatastoreClient $client)
    {
        $end = self::$parentKey->pathEnd();
        $parentKind = $end['kind'];
        $parentId = self::$parentKey->pathEndIdentifier();

        $queryString = sprintf(
            'SELECT * FROM `%s` WHERE __key__ HAS ANCESTOR KEY(`%s`, "%s")',
            self::$testKind,
            $parentKind,
            $parentId
        );
        $q = $client->gqlQuery($queryString, [
            'allowLiterals' => true
        ]);

        $this->assertQueryPageCount(self::$expectedTotal, $client, $q);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testQueryPaginationByPage(DatastoreClient $client)
    {
        $q = $client->query()->kind(self::$testKind);

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
