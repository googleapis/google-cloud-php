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

use Google\Cloud\Core\Timestamp;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Query\Aggregation;

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
            ->hasAncestor($key1)
            ->filter('lastName', '=', 'Smith');
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
    public function testRunAggregationQueryWithTransactions(DatastoreClient $client)
    {
        $this->skipEmulatorTests();
        $kind = 'Person';
        $testId = rand(1, 999999);
        $key1 = $client->key($kind, $testId);
        $data = ['lastName' => 'Smith'];
        $newLastName = 'NotSmith';
        $entity1 = $client->entity($key1, $data);

        $transaction = $client->transaction();
        $transaction->insert($entity1);
        $transaction->commit();

        self::$localDeletionQueue->add($key1);

        // validate default DB should not have data
        $defaultDbClient = current(self::defaultDbClientProvider())[0];
        $this->assertOtherDbEntities($defaultDbClient, $kind, $testId, 0);

        // transaction with query
        $transaction2 = $client->transaction();
        $query = $client->query()
            ->kind($kind)
            ->hasAncestor($key1)
            ->filter('lastName', '=', 'Smith');
        $results = iterator_to_array($transaction2->runQuery($query));

        $this->assertAggregationQueryResult($transaction2, $query, 1);

        $results[0]['lastName'] = $newLastName;
        $transaction2->update($results[0]);
        $transaction2->commit();

        $this->assertCount(1, $results);

        // read transaction with aggregation query
        $transaction3 = $client->readOnlyTransaction();
        $query = $client->query()
            ->kind($kind)
            ->hasAncestor($key1)
            ->filter('lastName', '=', 'Smith');
        $this->assertAggregationQueryResult($transaction3, $query, 0);
    }

    /**
     * @dataProvider defaultDbClientProvider
     */
    public function testTransactionWithReadTime(DatastoreClient $client)
    {
        $this->skipEmulatorTests();
        $kind = 'NewPerson';
        $lastName = 'Geller';
        $newLastName = 'Bing';
        $ancKey = $client->key($kind, rand(1, 999999));
        $key = $client->key($kind, time());
        $key->ancestorKey($ancKey);
        $data = ['lastName' => $lastName];
        $ancPerson = $client->entity($ancKey, $data);
        $person = $client->entity($key, $data);
        $client->insert($ancPerson);
        $client->upsert($person);
        self::$localDeletionQueue->add($ancKey);
        self::$localDeletionQueue->add($key);

        sleep(2);

        $time = new Timestamp(new \DateTime());

        sleep(2);

        $transaction = $client->transaction();
        $person = $transaction->lookup($key);
        $person['lastName'] = $newLastName;
        $transaction->update($person);
        $transaction->commit();

        sleep(2);

        $query = $client->query()
            ->kind($kind)
            ->filter('__key__', '=', $key)
            ->hasAncestor($ancKey);
        $result = $client->runQuery($query);
        $personListEntities = iterator_to_array($result);
        // Person lastName should be the lastName AFTER update
        $this->assertEquals($personListEntities[0]['lastName'], $newLastName);

        $transaction2 = $client->readOnlyTransaction(
            ['transactionOptions' => ['readTime' => $time]]
        );
        // runQuery function: Person lastName should be the lastName BEFORE update
        $persons = $transaction2->runQuery($query);
        $personListEntities = iterator_to_array($persons);
        $this->assertEquals($personListEntities[0]['lastName'], $lastName);

        // lookUp function: Person lastName should be the lastName BEFORE update
        $person = $transaction2->lookup($key);
        $this->assertEquals($person['lastName'], $lastName);

        $person = $transaction2->lookupBatch([$key]);
        $this->assertEquals($person['found'][0]['lastName'], $lastName);
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

    private function assertAggregationQueryResult($transaction, $query, $expectedAggregationCount)
    {
        $aggregationQuery = $query->aggregation(Aggregation::count()->alias('total'));
        $results = $transaction->runAggregationQuery($aggregationQuery);
        $this->assertEquals($expectedAggregationCount, $results->get('total'));
    }
}
