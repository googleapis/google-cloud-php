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

namespace Google\Cloud\Datastore;

/**
 * Represents a Transaction
 *
 * A transaction is a set of Datastore operations on one or more entities. Each
 * transaction is guaranteed to be atomic, which means that transactions are
 * never partially applied. Either all of the operations in the transaction are
 * applied, or none of them are applied.
 *
 * It is highly recommended that users read and understand the underlying
 * concepts in [Transactions](https://cloud.google.com/datastore/docs/concepts/transactions)
 * before beginning.
 *
 * Mutations (i.e. insert, update and delete) are not executed immediately.
 * Calls to those methods (and their batch equivalents) will enqueue a new
 * mutation. Calling {@see Google\Cloud\Datastore\Transaction::commit()} will
 * execute all the mutations in the order they were enqueued, and end the
 * transaction.
 *
 * Lookups and queries can be run in a transaction, so long as they are run
 * prior to committing or rolling back the transaction.
 *
 * Transactions are an **optional** feature of Google Cloud Datastore. Queries,
 * lookups and mutations can be executed outside of a Transaction from
 * {@see Google\Cloud\Datastore\DatastoreClient}.
 *
 * Example:
 * ```
 * use Google\Cloud\Datastore\DatastoreClient;
 *
 * $datastore = new DatastoreClient();
 *
 * $transaction = $datastore->transaction();
 * ```
 *
 * @see https://cloud.google.com/datastore/docs/concepts/transactions Transactions
 */
class Transaction
{
    use TransactionTrait;

    /**
     * @var array
     */
    private $mutations = [];

    /**
     * Insert an entity.
     *
     * Changes are not immediately committed to Cloud Datastore when calling
     * this method. Use {@see Google\Cloud\Datastore\Transaction::commit()} to
     * commit changes and end the transaction.
     *
     * If entities with incomplete keys are provided, this method will immediately
     * trigger a service call to allocate IDs to the entities.
     *
     * Example:
     * ```
     * $key = $datastore->key('Person', 'Bob');
     * $entity = $datastore->entity($key, ['firstName' => 'Bob']);
     *
     * $transaction->insert($entity);
     * $transaction->commit();
     * ```
     *
     * @param EntityInterface $entity The entity to insert.
     * @return Transaction
     */
    public function insert(EntityInterface $entity)
    {
        return $this->insertBatch([$entity]);
    }

    /**
     * Insert multiple entities.
     *
     * Changes are not immediately committed to Cloud Datastore when calling
     * this method. Use {@see Google\Cloud\Datastore\Transaction::commit()} to
     * commit changes and end the transaction.
     *
     * If entities with incomplete keys are provided, this method will immediately
     * trigger a service call to allocate IDs to the entities.
     *
     * Example:
     * ```
     * $entities = [
     *     $datastore->entity('Person', ['firstName' => 'Bob']),
     *     $datastore->entity('Person', ['firstName' => 'John'])
     * ];
     *
     * $transaction->insertBatch($entities);
     * $transaction->commit();
     * ```
     *
     * @param EntityInterface[] $entities The entities to insert.
     * @return Transaction
     */
    public function insertBatch(array $entities)
    {
        $entities = $this->operation->allocateIdsToEntities($entities);
        foreach ($entities as $entity) {
            $this->mutations[] = $this->operation->mutation('insert', $entity, Entity::class);
        }

        return $this;
    }

    /**
     * Update an entity.
     *
     * Changes are not immediately committed to Cloud Datastore when calling
     * this method. Use {@see Google\Cloud\Datastore\Transaction::commit()} to
     * commit changes and end the transaction.
     *
     * Example:
     * ```
     * $entity['firstName'] = 'Bob';
     *
     * $transaction->update($entity);
     * $transaction->commit();
     * ```
     *
     * @param EntityInterface $entity The entity to update.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type bool $allowOverwrite Entities must be updated as an entire
     *           resource. Patch operations are not supported. Because entities
     *           can be created manually, or obtained by a lookup or query, it
     *           is possible to accidentally overwrite an existing record with a
     *           new one when manually creating an entity. To provide additional
     *           safety, this flag must be set to `true` in order to update a
     *           record when the entity provided was not obtained through a
     *           lookup or query. **Defaults to** `false`.
     * }
     * @return Transaction
     */
    public function update(EntityInterface $entity, array $options = [])
    {
        $options += [
            'allowOverwrite' => false
        ];

        return $this->updateBatch([$entity], $options);
    }

    /**
     * Update multiple entities.
     *
     * Changes are not immediately committed to Cloud Datastore when calling
     * this method. Use {@see Google\Cloud\Datastore\Transaction::commit()} to
     * commit changes and end the transaction.
     *
     * Example:
     * ```
     * $entities[0]['firstName'] = 'Bob';
     * $entities[1]['firstName'] = 'John';
     *
     * $transaction->updateBatch($entities);
     * $transaction->commit();
     * ```
     *
     * @param EntityInterface[] $entities The entities to update.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type bool $allowOverwrite Entities must be updated as an entire
     *           resource. Patch operations are not supported. Because entities
     *           can be created manually, or obtained by a lookup or query, it
     *           is possible to accidentally overwrite an existing record with a
     *           new one when manually creating an entity. To provide additional
     *           safety, this flag must be set to `true` in order to update a
     *           record when the entity provided was not obtained through a
     *           lookup or query. **Defaults to** `false`.
     * }
     * @return Transaction
     */
    public function updateBatch(array $entities, array $options = [])
    {
        $options += [
            'allowOverwrite' => false
        ];

        $this->operation->checkOverwrite($entities, $options['allowOverwrite']);
        foreach ($entities as $entity) {
            $this->mutations[] = $this->operation->mutation('update', $entity, Entity::class);
        }

        return $this;
    }

    /**
     * Upsert an entity.
     *
     * Changes are not immediately committed to Cloud Datastore when calling
     * this method. Use {@see Google\Cloud\Datastore\Transaction::commit()} to
     * commit changes and end the transaction.
     *
     * Upsert will create a record if one does not already exist, or overwrite
     * existing record if one already exists.
     *
     * If entities with incomplete keys are provided, this method will immediately
     * trigger a service call to allocate IDs to the entities.
     *
     * Example:
     * ```
     * $key = $datastore->key('Person', 'Bob');
     * $entity = $datastore->entity($key, ['firstName' => 'Bob']);
     *
     * $transaction->upsert($entity);
     * $transaction->commit();
     * ```
     *
     * @param EntityInterface $entity The entity to upsert.
     * @return Transaction
     */
    public function upsert(EntityInterface $entity)
    {
        return $this->upsertBatch([$entity]);
    }

    /**
     * Upsert multiple entities.
     *
     * Changes are not immediately committed to Cloud Datastore when calling
     * this method. Use {@see Google\Cloud\Datastore\Transaction::commit()} to
     * commit changes and end the transaction.
     *
     * Upsert will create a record if one does not already exist, or overwrite
     * existing record if one already exists.
     *
     * If entities with incomplete keys are provided, this method will immediately
     * trigger a service call to allocate IDs to the entities.
     *
     * Example:
     * ```
     * $keys = [
     *     $datastore->key('Person', 'Bob'),
     *     $datastore->key('Person', 'John')
     * ];
     *
     * $entities = [
     *     $datastore->entity($keys[0], ['firstName' => 'Bob']),
     *     $datastore->entity($keys[1], ['firstName' => 'John'])
     * ];
     *
     * $transaction->upsertBatch($entities);
     * $transaction->commit();
     * ```
     *
     * @param EntityInterface[] $entities The entities to upsert.
     * @return Transaction
     */
    public function upsertBatch(array $entities)
    {
        $entities = $this->operation->allocateIdsToEntities($entities);
        foreach ($entities as $entity) {
            $this->mutations[] = $this->operation->mutation('upsert', $entity, Entity::class);
        }

        return $this;
    }

    /**
     * Delete a record.
     *
     * Changes are not immediately committed to Cloud Datastore when calling
     * this method. Use {@see Google\Cloud\Datastore\Transaction::commit()} to
     * commit changes and end the transaction.
     *
     * Example:
     * ```
     * $key = $datastore->key('Person', 'Bob');
     *
     * $transaction->delete($key);
     * $transaction->commit();
     * ```
     *
     * @param Key $key The key to delete
     * @return Transaction
     */
    public function delete(Key $key)
    {
        return $this->deleteBatch([$key]);
    }

    /**
     * Delete multiple records.
     *
     * Changes are not immediately committed to Cloud Datastore when calling
     * this method. Use {@see Google\Cloud\Datastore\Transaction::commit()} to
     * commit changes and end the transaction.
     *
     * Example:
     * ```
     * $keys = [
     *     $datastore->key('Person', 'Bob'),
     *     $datastore->key('Person', 'John')
     * ];
     *
     * $transaction->deleteBatch($keys);
     * $transaction->commit();
     * ```
     *
     * @param Key[] $keys The keys to delete.
     * @return Transaction
     */
    public function deleteBatch(array $keys)
    {
        foreach ($keys as $key) {
            $this->mutations[] = $this->operation->mutation('delete', $key, Key::class);
        }

        return $this;
    }

    /**
     * Commit all mutations.
     *
     * Calling this method will end the operation (and close the transaction,
     * if one is specified).
     *
     * Example:
     * ```
     * $transaction->commit();
     * ```
     *
     * @see https://cloud.google.com/datastore/docs/reference/rest/v1/projects/commit Commit API documentation
     *
     * @param array $options [optional] Configuration Options.
     * @return array [Response Body](https://cloud.google.com/datastore/reference/rest/v1/projects/commit#response-body)
     */
    public function commit(array $options = [])
    {
        $options['transaction'] = $this->transactionId;

        return $this->operation->commit($this->mutations, $options);
    }
}
