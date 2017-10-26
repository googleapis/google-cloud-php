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

namespace Google\Cloud\Tests\System\Datastore;

/**
 * @group datastore
 * @group datastore-transaction
 */
class RunTransactionTest extends DatastoreTestCase
{
    public function testRunTransactions()
    {
        $kind = 'Person';
        $key1 = self::$client->key($kind, 'Frank');
        $key2 = self::$client->key($kind, 'Greg');
        $key2->ancestorKey($key1);
        $data = ['lastName' => 'Smith'];
        $newLastName = 'NotSmith';
        $entity1 = self::$client->entity($key1, $data);
        $entity2 = self::$client->entity($key2, $data);

        $transaction = self::$client->transaction();
        $transaction->insert($entity1);
        $transaction->upsert($entity2);
        $transaction->commit();

        self::$localDeletionQueue->add($key1);
        self::$localDeletionQueue->add($key2);

        // transaction with query
        $transaction2 = self::$client->transaction();
        $query = self::$client->query()
            ->kind($kind)
            ->hasAncestor($key1);
        $results = iterator_to_array($transaction2->runQuery($query));
        $results[1]['lastName'] = $newLastName;
        $transaction2->update($results[1]);
        $transaction2->commit();

        $this->assertEquals(2, count($results));

        // transaction with lookup
        $transaction3 = self::$client->transaction();
        $result = $transaction3->lookup($key2);
        $transaction3->rollback();

        $this->assertEquals($newLastName, $result['lastName']);
    }

    public function testTransactionCallable()
    {
        $kind = 'Person';
        $user1 = self::$client->key($kind);
        $user2 = self::$client->key($kind);

        self::$localDeletionQueue->add($user1);
        self::$localDeletionQueue->add($user2);

        $e1 = self::$client->entity($user1, [
            'balance' => 500
        ]);
        $e2 = self::$client->entity($user2, [
            'balance' => 500
        ]);

        self::$client->runTransaction(function ($t) use ($e1, $e2) {
            $t->insertBatch([$e1, $e2]);
        });

        $transfer = 100;
        self::$client->runTransaction(function ($t) use ($transfer, $user1, $user2) {
            $from = $t->lookup($user1);
            $to = $t->lookup($user2);

            $from['balance'] = $from['balance'] - $transfer;
            $to['balance'] = $to['balance'] + $transfer;

            $t->updateBatch([$from, $to]);
        });

        $e1 = self::$client->lookup($user1);
        $e2 = self::$client->lookup($user2);

        $this->assertEquals(400, $e1['balance']);
        $this->assertEquals(600, $e2['balance']);
    }

    /**
     * @group rb
     */
    public function testTransactionCallableRollback()
    {
        $kind = 'Person';
        $user1 = self::$client->key($kind);
        $user2 = self::$client->key($kind);

        self::$localDeletionQueue->add($user1);
        self::$localDeletionQueue->add($user2);

        $e1 = self::$client->entity($user1, [
            'balance' => 500
        ]);
        $e2 = self::$client->entity($user2, [
            'balance' => 500
        ]);

        self::$client->runTransaction(function ($t) use ($e1, $e2) {
            $t->insertBatch([$e1, $e2]);
        });

        $transfer = 100;
        try {
            self::$client->runTransaction(function ($t) use ($transfer, $user1, $user2) {
                var_dump('run');
                throw new \Exception('');
            });
        } catch (\Exception $e) {}

        $e1 = self::$client->lookup($user1);
        $e2 = self::$client->lookup($user2);

        $this->assertEquals(500, $e1['balance']);
        $this->assertEquals(500, $e2['balance']);
    }
}
