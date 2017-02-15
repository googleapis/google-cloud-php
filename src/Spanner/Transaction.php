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
 * Transactions can be started via
 * {@see Google\Cloud\Spanner\Database::runTransaction()} (recommended) or via
 * {@see Google\Cloud\Spanner\Database::transaction()}. Transactions should
 * always call {@see Google\Cloud\Spanner\Transaction::commit()} or
 * {@see Google\Cloud\Spanner\Transaction::rollback()} to ensure that locks are
 * released in a timely manner.
 *
 * If you do not plan on performing any writes in your transaction, a
 * {@see Google\Cloud\Spanner\Snapshot} is a better solution which does not
 * require a commit or rollback and does not lock any data.
 *
 * Transactions may raise {@see Google\Cloud\Exception\AbortedException} errors
 * when the transaction cannot complete for any reason. In this case, the entire
 * operation (all reads and writes) should be reapplied atomically. Google Cloud
 * PHP handles this transparently when using
 * {@see Google\Cloud\Spanner\Database::runTransaction()}. In other cases, it is
 * highly recommended that applications implement their own retry logic.
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 * $spanner = $cloud->spanner();
 *
 * $database = $spanner->connect('my-instance', 'my-database');
 *
 * $database->runTransaction(function (Transaction $t) {
 *     // do stuff.
 *
 *     $t->commit();
 * });
 * ```
 *
 * ```
 * // Get a transaction to manage manually.
 * $transaction = $database->transaction();
 * ```
 */
class Transaction
{
    use TransactionReadTrait;

    const STATE_ACTIVE = 0;
    const STATE_ROLLED_BACK = 1;
    const STATE_COMMITTED = 2;

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
     * @param string $transactionId The Transaction ID.
     */
    public function __construct(
        Operation $operation,
        Session $session,
        $transactionId
    ) {
        $this->operation = $operation;
        $this->session = $session;
        $this->transactionId = $transactionId;
        $this->context = SessionPoolInterface::CONTEXT_READWRITE;
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

        return $this->operation->rollback($this->session, $this->transactionId, $options);
    }

    /**
     * Commit and end the transaction.
     *
     * It is advised that transactions be run inside
     * {@see Google\Cloud\Spanner\Database::runTransaction()} in order to take
     * advantage of automated transaction retry in case of a transaction aborted
     * error.
     *
     * Example:
     * ```
     * $transaction->commit();
     * ```
     *
     * @param array $options [optional] Configuration Options.
     * @return Timestamp The commit timestamp.
     * @throws \RuntimeException If the transaction is not active
     * @throws \AbortedException If the commit is aborted for any reason.
     */
    public function commit(array $options = [])
    {
        if ($this->state !== self::STATE_ACTIVE) {
            throw new \RuntimeException('The transaction cannot be committed because it is not active');
        }

        $this->state = self::STATE_COMMITTED;

        $options['transactionId'] = $this->transactionId;
        return $this->operation->commit($this->session, $this->mutations, $options);
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
     * Format, validate and enqueue mutations in the transaction.
     *
     * @param string $op The operation type.
     * @param string $table The table name
     * @param array $dataSet the mutations to enqueue
     * @return void
     */
    private function enqueue($op, $table, array $dataSet)
    {
        foreach ($dataSet as $data) {
            if ($op === Operation::OP_DELETE) {
                $this->mutations[] = $this->operation->deleteMutation($table, $data);
            } else {
                $this->mutations[] = $this->operation->mutation($op, $table, $data);
            }
        }
    }
}
