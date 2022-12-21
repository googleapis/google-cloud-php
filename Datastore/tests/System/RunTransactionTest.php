<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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
 * @group datastore-transaction
 * @group datastore-multipledb
 */
class RunTransactionTest extends DatastoreMultipleDbTestCase
{
    protected function tearDown(): void
    {
        self::tearDownFixtures();
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testRunTransactions(DatastoreClient $client)
    {
        $kind = 'Person';
        $testId = rand(1, 999999);
        $key1 = $client->key($kind, $testId);
        $key2 = $client->key($kind, rand(1, 999999));
        $key2->ancestorKey($key1);
        $data = ['lastName' => 'Smith'];
        $newLastName = 'NotSmith';
        $entity1 = $client->entity($key1, $data);
        $entity2 = $client->entity($key2, $data);

        $transaction = $client->transaction();
        $transaction->insert($entity1);
        $transaction->upsert($entity2);
        $transaction->commit();

        self::$localDeletionQueue->add($key1);
        self::$localDeletionQueue->add($key2);

        // validate other DB should not have data
        $defaultDbClient = current(self::multiDbClientProvider())[0];
        $this->assertOtherDbEntities($defaultDbClient, $kind, $testId, 0);

        // transaction with query
        $transaction2 = $client->transaction();
        $query = $client->query()
            ->kind($kind)
            ->hasAncestor($key1);
        $results = iterator_to_array($transaction2->runQuery($query));
        $results[1]['lastName'] = $newLastName;
        $transaction2->update($results[1]);
        $transaction2->commit();

        $this->assertCount(2, $results);

        // transaction with lookup
        $transaction3 = $client->transaction();
        $result = $transaction3->lookup($key2);
        $transaction3->rollback();

        $this->assertEquals($newLastName, $result['lastName']);
    }

    /**
     * @dataProvider multiDbClientProvider
     */
    public function testRunMultipleDbTransactions(DatastoreClient $client)
    {
        $kind = 'Person';
        $testId = rand(1, 999999);
        $key1 = $client->key($kind, $testId);
        $key2 = $client->key($kind, rand(1, 999999));
        $key2->ancestorKey($key1);
        $data = ['lastName' => 'Smith'];
        $newLastName = 'NotSmith';
        $entity1 = $client->entity($key1, $data);
        $entity2 = $client->entity($key2, $data);

        $transaction = $client->transaction();
        $transaction->insert($entity1);
        $transaction->upsert($entity2);
        $transaction->commit();

        self::$localDeletionQueue->add($key1);
        self::$localDeletionQueue->add($key2);

        // validate default DB should not have data
        $defaultDbClient = current(self::defaultDbClientProvider())[0];
        $this->assertOtherDbEntities($defaultDbClient, $kind, $testId, 0);

        // transaction with query
        $transaction2 = $client->transaction();
        $query = $client->query()
            ->kind($kind)
            ->hasAncestor($key1);
        $results = iterator_to_array($transaction2->runQuery($query));
        $results[1]['lastName'] = $newLastName;
        $transaction2->update($results[1]);
        $transaction2->commit();

        $this->assertCount(2, $results);

        // transaction with lookup
        $transaction3 = $client->transaction();
        $result = $transaction3->lookup($key2);
        $transaction3->rollback();

        $this->assertEquals($newLastName, $result['lastName']);
    }

    private function assertOtherDbEntities($client, $kind, $id, $expectedCount)
    {
        $key = $client->key($kind, $id);
        $query = $client->query()
            ->kind($kind)
            ->hasAncestor($key);

        $results = iterator_to_array($client->runQuery($query));

        $this->assertCount($expectedCount, $results);
    }
}
