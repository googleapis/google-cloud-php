<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Datastore;

use Google\Cloud\Datastore\Query\QueryInterface;

/**
 * A Datastore Read-Only Transaction.
 *
 * Read-only transactions cannot be committed and cannot modify server state.
 * It remains best practice to roll back read-only transactions when you are
 * finished using them.
 *
 * Example:
 * ```
 * use Google\Cloud\Datastore\DatastoreClient;
 *
 * $datastore = new DatastoreClient();
 * $transaction = $datastore->readOnlyTransaction();
 * ```
 */
class ReadOnlyTransaction
{
    /**
     * @var Operation
     */
    protected $operation;

    /**
     * @var string
     */
    protected $projectId;

    /**
     * @var string
     */
    protected $transactionId;

    /**
     * @var bool
     */
    protected $closed = false;

    /**
     * Create a Transaction
     *
     * @param Operation $operation Class that handles shared API interaction.
     * @param string $projectId The Google Cloud Platform project ID.
     * @param string $transactionId The transaction to run mutations in.
     */
    public function __construct(
        Operation $operation,
        $projectId,
        $transactionId
    ) {
        $this->operation = $operation;
        $this->projectId = $projectId;
        $this->transactionId = $transactionId;
    }

    /**
     * Retrieve an entity from the datastore inside a transaction
     *
     * Example:
     * ```
     * $key = $datastore->key('Person', 'Bob');
     *
     * $entity = $transaction->lookup($key);
     * if (!is_null($entity)) {
     *     echo $entity['firstName']; // 'Bob'
     * }
     * ```
     *
     * @param Key $key $key The identifier to use to locate a desired entity.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $className The name of the class to return results as.
     *           Must be a subclass of {@see Google\Cloud\Datastore\Entity}.
     *           If not set, {@see Google\Cloud\Datastore\Entity} will be used.
     * }
     * @return Entity|null
     * @throws \RuntimeException If the transaction is already committed or rolled back.
     */
    public function lookup(Key $key, array $options = [])
    {
        $res = $this->lookupBatch([$key], $options);

        return (isset($res['found'][0]))
            ? $res['found'][0]
            : null;
    }

    /**
     * Get multiple entities inside a transaction
     *
     * Example:
     * ```
     * $keys = [
     *     $datastore->key('Person', 'Bob'),
     *     $datastore->key('Person', 'John')
     * ];
     *
     * $entities = $transaction->lookupBatch($keys);
     *
     * foreach ($entities['found'] as $entity) {
     *     echo $entity['firstName'] . PHP_EOL;
     * }
     * ```
     *
     * @param Key[] $key The identifiers to look up.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string|array $className If a string, the name of the class to return results as.
     *           Must be a subclass of {@see Google\Cloud\Datastore\Entity}.
     *           If not set, {@see Google\Cloud\Datastore\Entity} will be used.
     *           If an array is given, it must be an associative array, where
     *           the key is a Kind and the value is the name of a subclass of
     *           {@see Google\Cloud\Datastore\Entity}.
     *     @type bool $sort If set to true, results in each set will be sorted
     *           to match the order given in $keys. **Defaults to** `false`.
     * }
     * @return array Returns an array with keys [`found`, `missing`, and `deferred`].
     *         Members of `found` will be instance of
     *         {@see Google\Cloud\Datastore\Entity}. Members of `missing` and
     *         `deferred` will be instance of {@see Google\Cloud\Datastore\Key}.
     * @throws \RuntimeException If the transaction is already committed or rolled back.
     */
    public function lookupBatch(array $keys, array $options = [])
    {
        return $this->operation->lookup($keys, $options + [
            'transaction' => $this->transactionId
        ]);
    }

    /**
     * Run a query and return entities inside a Transaction
     *
     * Example:
     * ```
     * $result = $transaction->runQuery($query);
     *
     * foreach ($result as $entity) {
     *     echo $entity['firstName'];
     * }
     * ```
     *
     * @param QueryInterface $query The query object.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $className The name of the class to return results as.
     *           Must be a subclass of {@see Google\Cloud\Datastore\Entity}.
     *           If not set, {@see Google\Cloud\Datastore\Entity} will be used.
     * }
     * @return EntityIterator<Google\Cloud\Datastore\Entity>
     * @throws \RuntimeException If the transaction is already committed or rolled back.
     */
    public function runQuery(QueryInterface $query, array $options = [])
    {
        return $this->operation->runQuery($query, $options + [
            'transaction' => $this->transactionId
        ]);
    }

    /**
     * Get the current Transaction ID.
     *
     * @return string
     * @access private
     */
    public function id()
    {
        return $this->transactionId;
    }

    /**
     * Roll back a Transaction
     *
     * Example:
     * ```
     * $transaction->rollback();
     * ```
     *
     * @return void
     * @throws \RuntimeException If the transaction is already committed or rolled back.
     */
    public function rollback()
    {
        $this->closed = true;
        return $this->operation->rollback($this->transactionId);
    }

    /**
     * If true, the transaction has been committed or rolled back, and further
     * operations are not permitted.
     *
     * @return bool
     * @access private
     */
    public function closed()
    {
        return $this->closed;
    }
}
