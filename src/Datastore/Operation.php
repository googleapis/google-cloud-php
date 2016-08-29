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

use Google\Cloud\Datastore\Connection\ConnectionInterface;

/**
 * Construct complex operations and commit them at the same time.
 *
 * Operations allow you to create complex sets of multiple mutations and run
 * them as a single operation against the Cloud Datastore API. In most cases,
 * operations should be run in a {@see Google\Cloud\Datastore\Transaction}.
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder;
 * $datastore = $cloud->datatore();
 *
 * $operation = $datastore->operation();
 * ```
 *
 * ```
 * // Start an operation with a transaction
 * $transaction = $datastore->beginTransaction();
 *
 * $operation = $datastore->operation([
 *     'transaction' => $transaction
 * ]);
 * ```
 *
 * ```
 * // Start an operation with a new transaction
 * $operation = $datastore->operation([
 *     'runInTransaction' => true
 * ]);
 */
class Operation
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * @var array
     */
    private $mutations = [];

    /**
     * Create an operation
     *
     * @param ConnectionInterface $connection A connection to Google Cloud Platform's Datastore API
     * @param string $projectId The Google Cloud Platform project ID
     * @param Transaction $transaction The transaction to run mutations in
     */
    public function __construct(
        ConnectionInterface $connection,
        $projectId,
        Transaction $transaction = null
    ) {
        $this->connection = $connection;
        $this->projectId = $projectId;
        $this->transaction = $transaction;
    }

    /**
     * Get the transaction
     *
     * Example:
     * ```
     * echo $operation->transaction()->id();
     * ```
     *
     * @return Transaction
     */
    public function transaction()
    {
        return $this->transaction;
    }

    /**
     * Insert an entity
     *
     * No service requests are run when this method is called.
     * Use {@see Google\Cloud\Datastore\Operation::commit()} to commit changes.
     *
     * Example:
     * ```
     * $key = $datastore->key('person', 'Bob');
     * $entity = $datastore->entity($key, ['firstName' => 'Bob']);
     *
     * $operation->insert($entity);
     * ```
     *
     * @param Entity $entity The entity to insert
     * @return void
     */
    public function insert(Entity $entity)
    {
        return $this->insertBatch([$entity]);
    }

    /**
     * Insert multiple entities
     *
     * No service requests are run when this method is called.
     * Use {@see Google\Cloud\Datastore\Operation::commit()} to commit changes.
     *
     * Example:
     * ```
     * $keys = $datastore->keys(['kind' => 'person'], [
     *     'allocateIds' => true,
     *     'number' => 2
     * ]);
     *
     * $entities = [
     *     $datastore->entity($key[0], ['firstName' => 'Bob']),
     *     $datastore->entity($key[1], ['firstName' => 'John'])
     * ];
     *
     * $operation->insertBatch($entities);
     * ```
     *
     * @param Entity[] $entities The entities to insert
     * @return void
     */
    public function insertBatch(array $entities)
    {
        $this->addMutations('insert', $entities, Entity::class);
    }

    /**
     * Update an entity
     *
     * No service requests are run when this method is called.
     * Use {@see Google\Cloud\Datastore\Operation::commit()} to commit changes.
     *
     * Example:
     * ```
     * $entity['firstName'] = 'Bob';
     *
     * $operation->update($entity);
     * ```
     *
     * @param Entity $entity The entity to update
     * @return void
     */
    public function update(Entity $entity)
    {
        return $this->updateBatch([$entity]);
    }

    /**
     * Update multiple entities
     *
     * No service requests are run when this method is called.
     * Use {@see Google\Cloud\Datastore\Operation::commit()} to commit changes.
     *
     * Example:
     * ```
     * $entities[0]['firstName'] = 'Bob';
     * $entities[1]['firstName'] = 'John';
     *
     * $operation->updateBatch($entities);
     * ```
     *
     * @param Entity[] $entities The entities to update
     * @return void
     */
    public function updateBatch(array $entities)
    {
        $this->addMutations('update', $entities, Entity::class);
    }

    /**
     * Upsert an entity
     *
     * No service requests are run when this method is called.
     * Use {@see Google\Cloud\Datastore\Operation::commit()} to commit changes.
     *
     * Upsert will create a record if one does not already exist, or overwrite
     * existing record if one already exists.
     *
     * Example:
     * ```
     * $key = $datastore->key('person', 'Bob');
     * $entity = $datastore->entity($key, ['firstName' => 'Bob']);
     *
     * $operation->upsert($entity);
     * ```
     *
     * @param Entity $entity The entity to upsert
     * @return void
     */
    public function upsert(Entity $entity)
    {
        return $this->upsertBatch([$entity]);
    }

    /**
     * Upsert multiple entities
     *
     * No service requests are run when this method is called.
     * Use {@see Google\Cloud\Datastore\Operation::commit()} to commit changes.
     *
     * Upsert will create a record if one does not already exist, or overwrite
     * existing record if one already exists.
     *
     * Example:
     * ```
     * $keys = $datastore->keys(['kind' => 'person'], [
     *     'allocateIds' => true,
     *     'number' => 2
     * ]);
     *
     * $entities = [
     *     $datastore->entity($key[0], ['firstName' => 'Bob']),
     *     $datastore->entity($key[1], ['firstName' => 'John'])
     * ];
     *
     * $operation->upsertBatch($entities);
     * ```
     *
     * @param Entity[] $entities The entities to upsert
     * @return void
     */
    public function upsertBatch(array $entities)
    {
        $this->addMutations('upsert', $entities, Entity::class);
    }

    /**
     * Delete a record
     *
     * No service requests are run when this method is called.
     * Use {@see Google\Cloud\Datastore\Operation::commit()} to commit changes.
     *
     * Example:
     * ```
     * $key = $datastore->key('person', 'Bob');
     *
     * $operation->delete($key);
     * ```
     *
     * @param Key $key The key to delete
     * @return void
     */
    public function delete(Key $key)
    {
        return $this->deleteBatch([$key]);
    }

    /**
     * Delete multiple records
     *
     * No service requests are run when this method is called.
     * Use {@see Google\Cloud\Datastore\Operation::commit()} to commit changes.
     *
     * Example:
     * ```
     * $keys = [
     *     $datastore->key('person', 'Bob'),
     *     $datastore->key('person', 'John')
     * ];
     *
     * $operation->deleteBatch($keys);
     * ```
     *
     * @param Key[] $keys The keys to delete
     * @return void
     */
    public function deleteBatch(array $keys)
    {
        $this->addMutations('delete', $keys, Key::class);
    }

    /**
     * Commit all mutations
     *
     * Calling this method will end the operation (and close the transaction,
     * if one is specified).
     *
     * Example:
     * ```
     * $operation->commit()
     * ```
     *
     * @param array $options Configuration Options
     * @return array
     */
    public function commit(array $options = [])
    {
        if ($this->transaction) {
            $options['transaction'] = $this->transaction->id();
        }

        $res = $this->connection->commit($options + $this->operationObject() + [
            'projectId' => $this->projectId
        ]);

        $this->mutations = [];

        return $res;
    }

    /**
     * Create the service object
     *
     * @access private
     * @return array
     */
    public function operationObject()
    {
        return [
            'mode' => ($this->transaction) ? 'TRANSACTIONAL' : 'NON_TRANSACTIONAL',
            'mutations' => $this->mutations
        ];
    }

    /**
     * Add a mutation to the set
     *
     * @param string $operation
     * @param array $input
     * @param string $type
     * @param callable $additionalCheck
     * @return void
     */
    private function addMutations(
        $operation,
        array $input,
        $type,
        callable $additionalCheck = null
    ) {
        $this->validateBatch($input, $type, $additionalCheck);

        $mutations = array_map(function ($element) use ($type, $operation) {
            return [
                $operation => $element
            ];
        }, $input);

        $this->mutations = array_merge($this->mutations, $mutations);
    }

    /**
     * Check that each member of $input is of type $type
     *
     * @param array $input
     * @param string $type
     * @return void
     * @throws InvalidArgumentException
     */
    private function validateBatch(array $input, $type)
    {
        array_map(function ($element) use ($type) {
            if (!($element instanceof $type)) {
                throw new InvalidArgumentException(sprintf(
                    'Each member of input array must be an instance of %s',
                    $type
                ));
            }
        }, $input);
    }

    /**
     * Present a nicer debug result to people using php 5.6 or greater.
     * @return array
     * @codeCoverageIgnore
     * @access private
     */
    public function __debugInfo()
    {
        return [
            'transaction' => $this->transaction,
            'projectId' => $this->projectId,
            'connection' => get_class($this->connection),
            'mutations' => $this->mutations
        ];
    }
}
