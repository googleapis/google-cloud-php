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

use Google\Cloud\Exception\NotFoundException;
use Google\Cloud\Iam\Iam;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Connection\IamDatabase;
use Google\Cloud\Spanner\Session\SessionPoolInterface;

/**
 * Represents a Google Cloud Spanner Database
 *
 * Example:
 * ```
 * $database = $instance->database('my-database');
 * ```
 */
class Database
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var Instance
     */
    private $instance;

    /**
     * @var SessionPoolInterface
     */
    private $sessionPool;

    /**
     * @var Operation
     */
    private $operation;

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Iam
     */
    private $iam;

    /**
     * Create an object representing a Database.
     *
     * @param ConnectionInterface $connection The connection to the
     *        Google Cloud Spanner Admin API.
     * @param Instance $instance The instance in which the database exists.
     * @param SessionPoolInterface The session pool implementation.
     * @param string $projectId The project ID.
     * @param string $name The database name.
     * @param array $info [optional] A representation of the database object.
     */
    public function __construct(
        ConnectionInterface $connection,
        Instance $instance,
        SessionPoolInterface $sessionPool,
        $projectId,
        $name
    ) {
        $this->connection = $connection;
        $this->instance = $instance;
        $this->sessionPool = $sessionPool;
        $this->projectId = $projectId;
        $this->name = $name;

        $this->operation = new Operation($connection, $instance, $this);
        $this->iam = new Iam(
            new IamDatabase($this->connection),
            $this->fullyQualifiedDatabaseName()
        );
    }

    /**
     * Return the simple database name.
     *
     * Example:
     * ```
     * $name = $database->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Check if the database exists.
     *
     * This method sends a service request.
     *
     * Example:
     * ```
     * if ($database->exists()) {
     *     echo 'The database exists!';
     * }
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return bool
     */
    public function exists(array $options = [])
    {
        try {
            $this->connection->getDatabaseDDL($options + [
                'name' => $this->fullyQualifiedDatabaseName()
            ]);
        } catch (NotFoundException $e) {
            return false;
        }

        return true;
    }

    /**
     * Update the Database.
     *
     * Example:
     * ```
     * $database->update([
     *     'CREATE TABLE Users (
     *         id INT64 NOT NULL,
     *         name STRING(100) NOT NULL
     *         password STRING(100) NOT NULL
     *     )'
     * ]);
     * ```
     *
     * @param string|array $statements One or more DDL statements to execute.
     * @param array $options [optional] Configuration options.
     * @return <something>
     */
    public function updateDdl($statements, array $options = [])
    {
        $options += [
            'operationId' => null
        ];

        if (!is_array($statements)) {
            $statements = [$statements];
        }

        return $this->connection->updateDatabase($options + [
            'name' => $this->fullyQualifiedDatabaseName(),
            'statements' => $statements,
        ]);
    }

    /**
     * Drop the database.
     *
     * Example:
     * ```
     * $database->drop();
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return void
     */
    public function drop(array $options = [])
    {
        return $this->connection->dropDatabase($options + [
            'name' => $this->fullyQualifiedDatabaseName()
        ]);
    }

    /**
     * Get a list of all database DDL statements.
     *
     * Example:
     * ```
     * $statements = $database->ddl();
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function ddl(array $options = [])
    {
        $ddl = $this->connection->getDatabaseDDL($options + [
            'name' => $this->fullyQualifiedDatabaseName()
        ]);

        if (isset($ddl['statements'])) {
            return $ddl['statements'];
        }

        return [];
    }

    /**
     * Manage the database IAM policy
     *
     * Example:
     * ```
     * $iam = $database->iam();
     * ```
     *
     * @return Iam
     */
    public function iam()
    {
        return $this->iam;
    }

    /**
     * Create a Read Only transaction
     *
     * @codingStandardsIgnoreStart
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type array $transactionOptions [TransactionOptions](https://cloud.google.com/spanner/reference/rest/v1/TransactionOptions).
     * }
     * @codingStandardsIgnoreEnd
     * @return Transaction
     */
    public function readOnlyTransaction(array $options = [])
    {
        $options += [
            'transactionOptions' => []
        ];

        if (empty($options['transactionOptions'])) {
            $options['transactionOptions']['strong'] = true;
        }

        $options['readOnly'] = $options['transactionOptions'];

        return $this->transaction(SessionPoolInterface::CONTEXT_READ, $options);
    }

    /**
     * Create a Read/Write transaction
     *
     * @param array $options [optional] Configuration Options
     * @return Transaction
     */
    public function lockingTransaction(array $options = [])
    {
        $options['readWrite'] = [];

        return $this->transaction(SessionPoolInterface::CONTEXT_READWRITE, $options);
    }

    /**
     * Insert a row.
     *
     * @param string $table The table to mutate.
     * @param array $data The row data to insert.
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function insert($table, array $data, array $options = [])
    {
        return $this->insertBatch($table, [$data], $options);
    }

    /**
     * Insert multiple rows.
     *
     * @param string $table The table to mutate.
     * @param array $dataSet The row data to insert.
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function insertBatch($table, array $dataSet, array $options = [])
    {
        $mutations = [];
        foreach ($dataSet as $data) {
            $mutations[] = $this->operation->mutation(Operation::OP_INSERT, $table, $data);
        }

        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READWRITE);

        return $this->operation->commit($session, $mutations, $options);
    }

    /**
     * Update a row.
     *
     * @param string $table The table to mutate.
     * @param array $data The row data to update.
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function update($table, array $data, array $options = [])
    {
        return $this->updateBatch($table, [$data], $options);
    }

    /**
     * Update multiple rows.
     *
     * @param string $table The table to mutate.
     * @param array $dataSet The row data to update.
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function updateBatch($table, array $dataSet, array $options = [])
    {
        $mutations = [];
        foreach ($dataSet as $data) {
            $mutations[] = $this->operation->mutation(Operation::OP_UPDATE, $table, $data);
        }

        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READWRITE);

        return $this->operation->commit($session, $mutations, $options);
    }

    /**
     * Insert or update a row.
     *
     * @param string $table The table to mutate.
     * @param array $data The row data to insert or update.
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function insertOrUpdate($table, array $data, array $options = [])
    {
        return $this->insertOrUpdateBatch($table, [$data], $options);
    }

    /**
     * Insert or update multiple rows.
     *
     * @param string $table The table to mutate.
     * @param array $dataSet The row data to insert or update.
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function insertOrUpdateBatch($table, array $dataSet, array $options = [])
    {
        $mutations = [];
        foreach ($dataSet as $data) {
            $mutations[] = $this->operation->mutation(Operation::OP_INSERT_OR_UPDATE, $table, $data);
        }

        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READWRITE);

        return $this->operation->commit($session, $mutations, $options);
    }

    /**
     * Replace a row.
     *
     * @param string $table The table to mutate.
     * @param array $data The row data to replace.
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function replace($table, array $data, array $options = [])
    {
        return $this->replaceBatch($table, [$data], $options);
    }

    /**
     * Replace multiple rows.
     *
     * @param string $table The table to mutate.
     * @param array $dataSet The row data to replace.
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function replaceBatch($table, array $dataSet, array $options = [])
    {
        $mutations = [];
        foreach ($dataSet as $data) {
            $mutations[] = $this->operation->mutation(Operation::OP_REPLACE, $table, $data);
        }

        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READWRITE);

        return $this->operation->commit($session, $mutations, $options);
    }

    /**
     * Delete a row.
     *
     * @param string $table The table to mutate.
     * @param array $key The key to use to identify the row or rows to delete.
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function delete($table, array $key, array $options = [])
    {
        return $this->deleteBatch($table, [$key], $options);
    }

    /**
     * Delete multiple rows.
     *
     * @param string $table The table to mutate.
     * @param array $keySets The keys to use to identify the row or rows to delete.
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function deleteBatch($table, array $keySets, array $options = [])
    {
        $mutations = [];
        foreach ($keySets as $keySet) {
            $mutations[] = $this->operation->deleteMutation($table, $keySet);
        }

        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READWRITE);

        return $this->operation->commit($session, $mutations, $options);
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
        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READ);

        return $this->operation->execute($session, $sql, $options);
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
        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READ);

        return $this->operation->read($session, $table, $options);
    }

    /**
     * Create a transaction with a given context.
     *
     * @param string $context The context of the new transaction.
     * @param array $options [optional] Configuration options.
     * @return Transaction
     */
    private function transaction($context, array $options = [])
    {
        $options += [
            'transactionOptions' => []
        ];

        $session = $this->selectSession($context);

        // make a service call here.
        $res = $this->connection->beginTransaction($options + [
            'session' => $session->name(),
            'context' => $context,
        ]);

        return new Transaction($this->operation, $session, $context, $res);
    }

    /**
     * Retrieve a session from the session pool.
     *
     * @param string $context The session context.
     * @return Session
     */
    private function selectSession($context = SessionPoolInterface::CONTEXT_READ) {
        return $this->sessionPool->session(
            $this->instance->name(),
            $this->name,
            $context
        );
    }

    /**
     * Convert the simple database name to a fully qualified name.
     *
     * @return string
     */
    private function fullyQualifiedDatabaseName()
    {
        return DatabaseAdminClient::formatDatabaseName(
            $this->projectId,
            $this->instance->name(),
            $this->name
        );
    }

    /**
     * Represent the class in a more readable and digestable fashion.
     *
     * @access private
     * @codeCoverageIgnore
     */
    public function __debugInfo()
    {
        return [
            'connection' => get_class($this->connection),
            'projectId' => $this->projectId,
            'name' => $this->name
        ];
    }
}
