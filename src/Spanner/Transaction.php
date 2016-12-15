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
 * Enabled interaction with Google Cloud Spanner inside a Transaction.
 */
class Transaction
{
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
     * @var string
     */
    private $readTimestamp;

    /**
     * @var array
     */
    private $mutations = [];

    /**
     * @param Operation $operation The Operation instance.
     * @param Session $session The session to use for spanner interactions.
     * @param string $context The Transaction context.
     * @param array $transaction Transaction details.
     */
    public function __construct(
        Operation $operation,
        Session $session,
        $context,
        array $transaction
    ) {
        $this->operation = $operation;
        $this->session = $session;
        $this->context = $context;
        $this->transactionId = $transaction['id'];
        $this->readTimestamp = (isset($transaction['readTimestamp']))
            ? $transaction['readTimestamp']
            : null;
    }

    /**
     * Enqueue an insert mutation.
     *
     * @param string $table The table to insert into.
     * @param array $data The data to insert.
     * @return void
     */
    public function insert($table, array $data)
    {
        if ($this->context !== SessionPoolInterface::CONTEXT_READWRITE) {
            throw new RuntimeException(
                'Cannot perform mutations in a Read-Only Transaction'
            );
        }

        $this->mutations[] = $this->operation->mutation(Operation::OP_INSERT, $table, $data);
    }

    /**
     * Enqueue an update mutation.
     *
     * @param string $table The table to update.
     * @param array $data The data to update.
     * @return void
     */
    public function update($table, array $data)
    {
        if ($this->context !== SessionPoolInterface::CONTEXT_READWRITE) {
            throw new RuntimeException(
                'Cannot perform mutations in a Read-Only Transaction'
            );
        }

        $this->mutations[] = $this->operation->mutation(Operation::OP_UPDATE, $table, $data);
    }

    /**
     * Enqueue an insert or update mutation.
     *
     * @param string $table The table to insert into or update.
     * @param array $data The data to insert or update.
     * @return void
     */
    public function insertOrUpdate($table, array $data)
    {
        if ($this->context !== SessionPoolInterface::CONTEXT_READWRITE) {
            throw new RuntimeException(
                'Cannot perform mutations in a Read-Only Transaction'
            );
        }

        $this->mutations[] = $this->operation->mutation(Operation::OP_INSERT_OR_UPDATE, $table, $data);
    }

    /**
     * Enqueue an replace mutation.
     *
     * @param string $table The table to replace into.
     * @param array $data The data to replace.
     * @return void
     */
    public function replace($table, array $data)
    {
        if ($this->context !== SessionPoolInterface::CONTEXT_READWRITE) {
            throw new RuntimeException(
                'Cannot perform mutations in a Read-Only Transaction'
            );
        }

        $this->mutations[] = $this->operation->mutation(Operation::OP_REPLACE, $table, $data);
    }

    /**
     * Enqueue an delete mutation.
     *
     * @param string $table The table to delete from.
     * @param array $key The key of the record to be deleted.
     * @return void
     */
    public function delete($table, array $key)
    {
        if ($this->context !== SessionPoolInterface::CONTEXT_READWRITE) {
            throw new RuntimeException(
                'Cannot perform mutations in a Read-Only Transaction'
            );
        }

        $this->mutations[] = $this->operation->deleteMutation($table, $data);
    }

    /**
     * Run a query.
     *
     * @param string $sql The query string to execute.
     * @param array $options [optional] Configuration options.
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
     * @todo is returning everything a reasonable default?
     *
     * @param string $table The table name.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $index The name of an index on the table.
     *     @type array $columns A list of column names to be returned.
     *     @type array $keySet A [KeySet](https://cloud.google.com/spanner/reference/rest/v1/KeySet).
     *     @type int $offset The number of rows to offset results by.
     *     @type int $limit The number of results to return.
     * }
     */
    public function read($table, array $options = [])
    {
        return $this->operation->read($this->session, $table, [
            'transactionId' => $this->transactionId
        ] + $options);
    }

    /**
     * Commit all mutations in a transaction.
     *
     * This closes the transaction, preventing any future API calls inside it.
     *
     * @codingStandardsIgnoreStart
     * @param array $options [optional] Configuration Options.
     * @return array [Response Body](https://cloud.google.com/spanner/reference/rest/v1/projects.instances.databases.sessions/commit#response-body).
     * @codingStandardsIgnoreEnd
     */
    public function commit(array $options = [])
    {
        if ($this->context !== SessionPoolInterface::CONTEXT_READWRITE) {
            throw new RuntimeException('Cannot commit in a Read-Only Transaction');
        }

        return $this->operation->commit($this->session, $this->mutations, [
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
     * @param array $options [optional] Configuration Options.
     * @return void
     */
    public function rollback(array $options = [])
    {
        return $this->operation->rollback($this->session, $this->transactionId, $options);
    }
}
