<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Spanner;

use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use RuntimeException;

/**
 * Manages interaction with Google Cloud Spanner inside a Transaction.
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 * $spanner = $cloud->spanner();
 *
 * $database = $spanner->connect('my-instance', 'my-database');
 * $transaction = $database->readWriteTransaction();
 * ```
 */
class Transaction
{
    const STATE_ACTIVE = 0;
    const STATE_ROLLED_BACK = 1;
    const STATE_COMMITTED = 2;

    /**
     * @var Operation
     */
    private $operation;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var string
     */
    private $context;

    /**
     * @var string
     */
    private $transactionId;

    /**
     * @var Timestamp
     */
    private $readTimestamp;

    /**
     * @var array
     */
    private $mutations = [];

    /**
     * @var int
     */
    private $state = self::STATE_ACTIVE;

    /**
     * @param Operation $operation The Operation instance.
     * @param Session $session The session to use for spanner interactions.
     * @param string $context The Transaction context.
     * @param string $transactionId The Transaction ID.
     * @param Timestamp $readTimestamp [optional] The read timestamp.
     */
    public function __construct(
        Operation $operation,
        Session $session,
        $context,
        $transactionId,
        Timestamp $readTimestamp = null
    ) {
        $this->operation = $operation;
        $this->session = $session;
        $this->context = $context;
        $this->transactionId = $transactionId;
        $this->readTimestamp = $readTimestamp;
    }

    /**
     * Enqueue an insert mutation.
     *
     * Example:
     * ```
     * $transaction->insert('Posts', [
     *     'ID' => 10,
     *     'title' => 'My New Post',
     *     'content' => 'Hello World'
     * ]);
     * ```
     *
     * @param string $table The table to insert into.
     * @param array $data The data to insert.
     * @return Transaction The transaction, to enable method chaining.
     */
    public function insert($table, array $data)
    {
        return $this->insertBatch($table, [$data]);
    }

    /**
     * Enqueue one or more insert mutations.
     *
     * Example:
     * ```
     * $transaction->insertBatch('Posts', [
     *     [
     *         'ID' => 10,
     *         'title' => 'My New Post',
     *         'content' => 'Hello World'
     *     ]
     * ]);
     * ```
     *
     * @param string $table The table to insert into.
     * @param array $dataSet The data to insert.
     * @return Transaction The transaction, to enable method chaining.
     */
    public function insertBatch($table, array $dataSet)
    {
        $this->enqueue(Operation::OP_INSERT, $table, $dataSet);

        return $this;
    }

    /**
     * Enqueue an update mutation.
     *
     * Example:
     * ```
     * $transaction->update('Posts', [
     *     'ID' => 10,
     *     'title' => 'My New Post [Updated!]',
     *     'content' => 'Modified Content'
     * ]);
     * ```
     *
     * @param string $table The table to update.
     * @param array $data The data to update.
     * @return Transaction The transaction, to enable method chaining.
     */
    public function update($table, array $data)
    {
        return $this->updateBatch($table, [$data]);
    }

    /**
     * Enqueue one or more update mutations.
     *
     * Example:
     * ```
     * $transaction->updateBatch('Posts', [
     *     [
     *         'ID' => 10,
     *         'title' => 'My New Post [Updated!]',
     *         'content' => 'Modified Content'
     *     ]
     * ]);
     * ```
     *
     * @param string $table The table to update.
     * @param array $dataSet The data to update.
     * @return Transaction The transaction, to enable method chaining.
     */
    public function updateBatch($table, array $dataSet)
    {
        $this->enqueue(Operation::OP_UPDATE, $table, $dataSet);

        return $this;
    }

    /**
     * Enqueue an insert or update mutation.
     *
     * Example:
     * ```
     * $transaction->insertOrUpdate('Posts', [
     *     'ID' => 10,
     *     'title' => 'My New Post',
     *     'content' => 'Hello World'
     * ]);
     * ```
     *
     * @param string $table The table to insert into or update.
     * @param array $data The data to insert or update.
     * @return Transaction The transaction, to enable method chaining.
     */
    public function insertOrUpdate($table, array $data)
    {
        return $this->insertOrUpdateBatch($table, [$data]);
    }

    /**
     * Enqueue one or more insert or update mutations.
     *
     * Example:
     * ```
     * $transaction->insertOrUpdateBatch('Posts', [
     *     [
     *         'ID' => 10,
     *         'title' => 'My New Post',
     *         'content' => 'Hello World'
     *     ]
     * ]);
     * ```
     *
     * @param string $table The table to insert into or update.
     * @param array $dataSet The data to insert or update.
     * @return Transaction The transaction, to enable method chaining.
     */
    public function insertOrUpdateBatch($table, array $dataSet)
    {
        $this->enqueue(Operation::OP_INSERT_OR_UPDATE, $table, $dataSet);

        return $this;
    }

    /**
     * Enqueue an replace mutation.
     *
     * Example:
     * ```
     * $transaction->replace('Posts', [
     *     'ID' => 10,
     *     'title' => 'My New Post [Replaced]',
     *     'content' => 'Hello Moon'
     * ]);
     * ```
     *
     * @param string $table The table to replace into.
     * @param array $data The data to replace.
     * @return Transaction The transaction, to enable method chaining.
     */
    public function replace($table, array $data)
    {
        return $this->replaceBatch($table, [$data]);
    }

    /**
     * Enqueue one or more replace mutations.
     *
     * Example:
     * ```
     * $transaction->replaceBatch('Posts', [
     *     [
     *         'ID' => 10,
     *         'title' => 'My New Post [Replaced]',
     *         'content' => 'Hello Moon'
     *     ]
     * ]);
     * ```
     *
     * @param string $table The table to replace into.
     * @param array $dataSet The data to replace.
     * @return Transaction The transaction, to enable method chaining.
     */
    public function replaceBatch($table, array $dataSet)
    {
        $this->enqueue(Operation::OP_REPLACE, $table, $dataSet);

        return $this;
    }

    /**
     * Enqueue an delete mutation.
     *
     * Example:
     * ```
     * $keySet = $spanner->keySet([
     *     'keys' => [10]
     * ]);
     *
     * $transaction->delete('Posts', $keySet);
     * ```
     *
     * @param string $table The table to mutate.
     * @param KeySet $keySet The KeySet to identify rows to delete.
     * @return Transaction The transaction, to enable method chaining.
     */
    public function delete($table, KeySet $keySet)
    {
        $this->enqueue(Operation::OP_DELETE, $table, [$keySet]);

        return $this;
    }

    /**
     * Run a query.
     *
     * Example:
     * ```
     * $result = $transaction->execute(
     *     'SELECT * FROM Users WHERE id = @userId',
     *     [
     *          'parameters' => [
     *              'userId' => 1
     *          ]
     *     ]
     * );
     * ```
     * @param string $sql The query string to execute.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $parameters A key/value array of Query Parameters, where
     *           the key is represented in the query string prefixed by a `@`
     *           symbol.
     * }
     * @return Result
     */
    public function execute($sql, array $options = [])
    {
        return $this->operation->execute($this->session, $sql, [
            'transactionId' => $this->transactionId
        ] + $options);
    }

    /**
     * Lookup rows in a table.
     *
     * Note that if no KeySet is specified, all rows in a table will be
     * returned.
     *
     * Example:
     * ```
     * $keySet = $spanner->keySet([
     *     'keys' => [10]
     * ]);
     *
     * $result = $database->read('Posts', [
     *     'keySet' => $keySet
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @param string $table The table name.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $index The name of an index on the table.
     *     @type array $columns A list of column names to be returned.
     *     @type KeySet $keySet A KeySet, defining which rows to return.
     *     @type int $offset The number of rows to offset results by.
     *     @type int $limit The number of results to return.
     * }
     * @codingStandardsIgnoreEnd
     */
    public function read($table, array $options = [])
    {
        return $this->operation->read($this->session, $table, [
            'transactionId' => $this->transactionId
        ] + $options);
    }

    /**
     * Roll back a transaction.
     *
     * Rolls back a transaction, releasing any locks it holds. It is a good idea
     * to call this for any transaction that includes one or more Read or
     * ExecuteSql requests and ultimately decides not to commit.
     *
     * This closes the transaction, preventing any future API calls inside it.
     *
     * Rollback will NOT error if the transaction is not found or was already aborted.
     *
     * Example:
     * ```
     * $transaction->rollback();
     * ```
     *
     * @param array $options [optional] Configuration Options.
     * @return void
     */
    public function rollback(array $options = [])
    {
        if ($this->state !== self::STATE_ACTIVE) {
            throw new \RuntimeException('The transaction cannot be rolled back because it is not active');
        }

        $this->state = self::STATE_ROLLED_BACK;

        return $this->operation->rollback($this->session, $this, $options);
    }

    public function commit()
    {
        if ($this->state !== self::STATE_ACTIVE) {
            throw new \RuntimeException('The transaction cannot be committed because it is not active');
        }

        $this->state = self::STATE_COMMITTED;

        return $this->operation->commit($this->session, $this);
    }

    /**
     * Retrieve the Read Timestamp.
     *
     * For snapshot read-only transactions, the read timestamp chosen for the
     * transaction.
     *
     * Example:
     * ```
     * $timestamp = $transaction->readTimestamp();
     * ```
     *
     * @return Timestamp
     */
    public function readTimestamp()
    {
        return $this->readTimestamp;
    }

    /**
     * Retrieve the Transaction ID.
     *
     * Example:
     * ```
     * $id = $transaction->id();
     * ```
     *
     * @return string
     */
    public function id()
    {
        return $this->transactionId;
    }

    /**
     * Retrieve the Transaction Context
     *
     * Example:
     * ```
     * $context = $transaction->context();
     * ```
     *
     * @return string
     */
    public function context()
    {
        return $this->context;
    }

    /**
     * Retrieve the Transaction State.
     *
     * Will be one of `Transaction::STATE_ACTIVE`,
     * `Transaction::STATE_COMMITTED`, or `Transaction::STATE_ROLLED_BACK`.
     *
     * Example:
     * ```
     * $state = $transaction->state();
     * ```
     *
     * @return int
     */
    public function state()
    {
        return $this->state;
    }

    /**
     * Retrieve a list of formatted mutations.
     *
     * @return array
     */
    public function mutations()
    {
        return $this->mutations;
    }

    /**
     * Format, validate and enqueue mutations in the transaction.
     *
     * @param string $op The operation type.
     * @param string $table The table name
     * @param array $dataSet the mutations to enqueue
     * @return void
     */
    private function enqueue($op, $table, array $dataSet)
    {
        if ($this->context !== SessionPoolInterface::CONTEXT_READWRITE) {
            throw new RuntimeException(
                'Cannot perform mutations in a Read-Only Transaction'
            );
        }

        foreach ($dataSet as $data) {
            if ($op === Operation::OP_DELETE) {
                $this->mutations[] = $this->operation->deleteMutation($table, $data);
            } else {
                $this->mutations[] = $this->operation->mutation($op, $table, $data);
            }
        }
    }
}
