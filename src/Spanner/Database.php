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

use Google\Cloud\Core\Exception\AbortedException;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\LongRunning\LROTrait;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Retry;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Connection\IamDatabase;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\SpannerClient as GapicSpannerClient;
use Google\GAX\ValidationException;
use Google\Spanner\V1\TypeCode;

/**
 * Represents a Cloud Spanner Database.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 *
 * $database = $spanner->connect('my-instance', 'my-database');
 * ```
 *
 * ```
 * // Databases can also be connected to via an Instance.
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 *
 * $instance = $spanner->instance('my-instance');
 * $database = $instance->database('my-database');
 * ```
 *
 * @method resumeOperation() {
 *     Resume a Long Running Operation
 *
 *     Example:
 *     ```
 *     $operation = $database->resumeOperation($operationName);
 *     ```
 *
 *     @param string $operationName The Long Running Operation name.
 *     @param array $info [optional] The operation data.
 *     @return LongRunningOperation
 * }
 * @method longRunningOperations() {
 *     List long running operations.
 *
 *     Example:
 *     ```
 *     $operations = $database->longRunningOperations();
 *     ```
 *
 *     @param array $options [optional] {
 *         Configuration Options.
 *
 *         @type string $name The name of the operation collection.
 *         @type string $filter The standard list filter.
 *         @type int $pageSize Maximum number of results to return per
 *               request.
 *         @type int $resultLimit Limit the number of results returned in total.
 *               **Defaults to** `0` (return all results).
 *         @type string $pageToken A previously-returned page token used to
 *               resume the loading of results from a specific point.
 *     }
 *     @return ItemIterator<InstanceConfiguration>
 * }
 */
class Database
{
    use LROTrait;
    use TransactionConfigurationTrait;

    const MAX_RETRIES = 10;

    const TYPE_BOOL = TypeCode::BOOL;
    const TYPE_INT64 = TypeCode::INT64;
    const TYPE_FLOAT64 = TypeCode::FLOAT64;
    const TYPE_TIMESTAMP = TypeCode::TIMESTAMP;
    const TYPE_DATE = TypeCode::DATE;
    const TYPE_STRING = TypeCode::STRING;
    const TYPE_BYTES = TypeCode::BYTES;
    const TYPE_ARRAY = TypeCode::PBARRAY;
    const TYPE_STRUCT = TypeCode::STRUCT;

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var Instance
     */
    private $instance;

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
     * @var array
     */
    private $info;

    /**
     * @var Iam
     */
    private $iam;

    /**
     * @var Session|null
     */
    private $session;

    /**
     * @var SessionPoolInterface|null
     */
    private $sessionPool;

    /**
     * @var bool
     */
    private $isRunningTransaction = false;

    /**
     * Create an object representing a Database.
     *
     * @param ConnectionInterface $connection The connection to the
     *        Cloud Spanner Admin API.
     * @param Instance $instance The instance in which the database exists.
     * @param LongRunningConnectionInterface $lroConnection An implementation
     *        mapping to methods which handle LRO resolution in the service.
     * @param string $projectId The project ID.
     * @param string $name The database name or ID.
     * @param SessionPoolInterface $sessionPool [optional] The session pool
     *        implementation.
     * @param bool $returnInt64AsObject [optional If true, 64 bit integers will
     *        be returned as a {@see Google\Cloud\Core\Int64} object for 32 bit
     *        platform compatibility. **Defaults to** false.
     */
    public function __construct(
        ConnectionInterface $connection,
        Instance $instance,
        LongRunningConnectionInterface $lroConnection,
        array $lroCallables,
        $projectId,
        $name,
        SessionPoolInterface $sessionPool = null,
        $returnInt64AsObject = false
    ) {
        $this->connection = $connection;
        $this->instance = $instance;
        $this->projectId = $projectId;
        $this->name = $this->fullyQualifiedDatabaseName($name);
        $this->sessionPool = $sessionPool;
        $this->operation = new Operation($connection, $returnInt64AsObject);

        if ($this->sessionPool) {
            $this->sessionPool->setDatabase($this);
        }

        $this->setLroProperties($lroConnection, $lroCallables, $this->name);
    }

    /**
     * Return the fully-qualified database name.
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
     * Get the database info
     *
     * Example:
     * ```
     * $info = $database->info();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.admin.database.v1#google.spanner.admin.database.v1.Database Database
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function info(array $options = [])
    {
        return $this->info ?: $this->reload($options);
    }

    /**
     * Reload the database info from the Cloud Spanner API.
     *
     * Example:
     * ```
     * $info = $database->reload();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.admin.database.v1#google.spanner.admin.database.v1.Database Database
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function reload(array $options = [])
    {
        return $this->info = $this->connection->getDatabase([
            'name' => $this->name
        ] + $options);
    }

    /**
     * Check if the database exists.
     *
     * This method sends a service request.
     *
     * **NOTE**: Requires `https://www.googleapis.com/auth/spanner.admin` scope.
     *
     * Example:
     * ```
     * if ($database->exists()) {
     *     echo 'Database exists!';
     * }
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return bool
     */
    public function exists(array $options = [])
    {
        try {
            $this->reload($options);
        } catch (NotFoundException $e) {
            return false;
        }

        return true;
    }

    /**
     * Create a new Cloud Spanner database.
     *
     * Example:
     * ```
     * $operation = $database->create();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.admin.database.v1#createdatabaserequest CreateDatabaseRequest
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string[] $statements Additional DDL statements.
     * }
     * @return LongRunningOperation<Database>
     */
    public function create(array $options = [])
    {
        $options += [
            'statements' => [],
        ];

        $statement = sprintf('CREATE DATABASE `%s`', DatabaseAdminClient::parseDatabaseFromDatabaseName($this->name));

        $operation = $this->connection->createDatabase([
            'instance' => $this->instance->name(),
            'createStatement' => $statement,
            'extraStatements' => $options['statements']
        ]);

        return $this->resumeOperation($operation['name'], $operation);
    }

    /**
     * Update the Database schema by running a SQL statement.
     *
     * **NOTE**: Requires `https://www.googleapis.com/auth/spanner.admin` scope.
     *
     * Example:
     * ```
     * $database->updateDdl(
     *     'CREATE TABLE Users (
     *         id INT64 NOT NULL,
     *         name STRING(100) NOT NULL
     *         password STRING(100) NOT NULL
     *     )'
     * );
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/docs/data-definition-language Data Definition Language
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.admin.database.v1#google.spanner.admin.database.v1.UpdateDatabaseDdlRequest UpdateDDLRequest
     * @codingStandardsIgnoreEnd
     *
     * @param string $statement A DDL statements to run against a database.
     * @param array $options [optional] Configuration options.
     * @return LongRunningOperation
     */
    public function updateDdl($statement, array $options = [])
    {
        return $this->updateDdlBatch([$statement], $options);
    }

    /**
     * Update the Database schema by running a set of SQL statements.
     *
     * **NOTE**: Requires `https://www.googleapis.com/auth/spanner.admin` scope.
     *
     * Example:
     * ```
     * $database->updateDdlBatch([
     *     'CREATE TABLE Users (
     *         id INT64 NOT NULL,
     *         name STRING(100) NOT NULL,
     *         password STRING(100) NOT NULL
     *     ) PRIMARY KEY (id)',
     *     'CREATE TABLE Posts (
     *         id INT64 NOT NULL,
     *         title STRING(100) NOT NULL,
     *         content STRING(MAX) NOT NULL
     *     ) PRIMARY KEY(id)'
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/docs/data-definition-language Data Definition Language
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.admin.database.v1#google.spanner.admin.database.v1.UpdateDatabaseDdlRequest UpdateDDLRequest
     * @codingStandardsIgnoreEnd
     *
     * @param string[] $statements A list of DDL statements to run against a database.
     * @param array $options [optional] Configuration options.
     * @return LongRunningOperation
     */
    public function updateDdlBatch(array $statements, array $options = [])
    {
        $operation = $this->connection->updateDatabaseDdl($options + [
            'name' => $this->name,
            'statements' => $statements,
        ]);

        return $this->resumeOperation($operation['name'], $operation);
    }

    /**
     * Drop the database.
     *
     * **NOTE**: Requires `https://www.googleapis.com/auth/spanner.admin` scope.
     *
     * Example:
     * ```
     * $database->drop();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.admin.database.v1#google.spanner.admin.database.v1.DropDatabaseRequest DropDatabaseRequest
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration options.
     * @return void
     */
    public function drop(array $options = [])
    {
        $this->connection->dropDatabase($options + [
            'name' => $this->name
        ]);
    }

    /**
     * Get a list of all database DDL statements.
     *
     * **NOTE**: Requires `https://www.googleapis.com/auth/spanner.admin` scope.
     *
     * Example:
     * ```
     * $statements = $database->ddl();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.admin.database.v1#getdatabaseddlrequest GetDatabaseDdlRequest
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function ddl(array $options = [])
    {
        $ddl = $this->connection->getDatabaseDDL($options + [
            'name' => $this->name
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
        if (!$this->iam) {
            $this->iam = new Iam(
                new IamDatabase($this->connection),
                $this->name
            );
        }

        return $this->iam;
    }

    /**
     * Create a snapshot to read from a database at a point in time.
     *
     * If no configuration options are provided, transaction will be opened with
     * strong consistency.
     *
     * Snapshots are executed behind the scenes using a Read-Only Transaction.
     *
     * Example:
     * ```
     * $snapshot = $database->snapshot();
     * ```
     *
     * ```
     * // Take a shapshot with a returned timestamp.
     * $snapshot = $database->snapshot([
     *     'returnReadTimestamp' => true
     * ]);
     *
     * $timestamp = $snapshot->readTimestamp();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.BeginTransactionRequest BeginTransactionRequest
     * @see https://cloud.google.com/spanner/docs/transactions Transactions
     *
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     See [ReadOnly](https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.TransactionOptions.ReadOnly)
     *     for detailed description of available options.
     *
     *     Please note that only one of `$strong`, `$readTimestamp` or
     *     `$exactStaleness` may be set in a request.
     *
     *     @type bool $returnReadTimestamp If true, the Cloud Spanner-selected
     *           read timestamp is included in the Transaction message that
     *           describes the transaction.
     *     @type bool $strong Read at a timestamp where all previously committed
     *           transactions are visible.
     *     @type Timestamp $readTimestamp Executes all reads at the given
     *           timestamp.
     *     @type Duration $exactStaleness Represents a number of seconds. Executes
     *           all reads at a timestamp that is $exactStaleness old.
     *     @type Timestamp $minReadTimestamp Executes all reads at a
     *           timestamp >= min_read_timestamp. Only available when
     *           `$options.singleUse` is true.
     *     @type Duration $maxStaleness Read data at a timestamp >= NOW - max_staleness
     *           seconds. Guarantees that all writes that have committed more
     *           than the specified number of seconds ago are visible. Only
     *           available when `$options.singleUse` is true.
     *     @type bool $singleUse If true, a Transaction ID will not be allocated
     *           up front. Instead, the transaction will be considered
     *           "single-use", and may be used for only a single operation.
     *           **Defaults to** `false`.
     * }
     * @return Snapshot
     * @throws \BadMethodCallException If attempting to call this method within
     *         an existing transaction.
     * @codingStandardsIgnoreEnd
     */
    public function snapshot(array $options = [])
    {
        if ($this->isRunningTransaction) {
            throw new \BadMethodCallException('Nested transactions are not supported by this client.');
        }

        $options += [
            'singleUse' => false
        ];

        $options['transactionOptions'] = $this->configureSnapshotOptions($options);

        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READ);

        try {
            return $this->operation->snapshot($session, $options);
        } finally {
            $session->setExpiration();
        }
    }

    /**
     * Create and return a new read/write Transaction.
     *
     * When manually using a Transaction, it is advised that retry logic be
     * implemented to reapply all operations when an instance of
     * {@see Google\Cloud\Core\Exception\AbortedException} is thrown.
     *
     * If you wish Google Cloud PHP to handle retry logic for you (recommended
     * for most cases), use {@see Google\Cloud\Spanner\Database::runTransaction()}.
     *
     * Please note that once a transaction reads data, it will lock the read
     * data, preventing other users from modifying that data. For this reason,
     * it is important that every transaction commits or rolls back as early as
     * possible. Do not hold transactions open longer than necessary.
     *
     * Example:
     * ```
     * $transaction = $database->transaction();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.BeginTransactionRequest BeginTransactionRequest
     * @see https://cloud.google.com/spanner/docs/transactions Transactions
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type bool $singleUse If true, a Transaction ID will not be allocated
     *           up front. Instead, the transaction will be considered
     *           "single-use", and may be used for only a single operation.
     *           **Defaults to** `false`.
     * }
     * @return Transaction
     * @throws \BadMethodCallException If attempting to call this method within
     *         an existing transaction.
     */
    public function transaction(array $options = [])
    {
        if ($this->isRunningTransaction) {
            throw new \BadMethodCallException('Nested transactions are not supported by this client.');
        }

        // There isn't anything configurable here.
        $options['transactionOptions'] = $this->configureTransactionOptions();

        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READWRITE);

        try {
            return $this->operation->transaction($session, $options);
        } finally {
            $session->setExpiration();
        }
    }

    /**
     * Execute Read/Write operations inside a Transaction.
     *
     * Using this method and providing a callable operation provides certain
     * benefits including automatic retry when a transaction fails. In case of a
     * failure, all transaction operations, including reads, are re-applied in a
     * new transaction.
     *
     * If a transaction exceeds the maximum number of retries,
     * {@see Google\Cloud\Core\Exception\AbortedException} will be thrown. Any other
     * exception types will immediately bubble up and will interrupt the retry
     * operation.
     *
     * Please note that once a transaction reads data, it will lock the read
     * data, preventing other users from modifying that data. For this reason,
     * it is important that every transaction commits or rolls back as early as
     * possible. Do not hold transactions open longer than necessary.
     *
     * Please also note that nested transactions are NOT supported by this client.
     * Attempting to call `runTransaction` inside a transaction callable will
     * raise a `BadMethodCallException`.
     *
     * If a callable finishes executing without invoking
     * {@see Google\Cloud\Spanner\Transaction::commit()} or
     * {@see Google\Cloud\Spanner\Transaction::rollback()}, the transaction will
     * automatically be rolled back and `\RuntimeException` thrown.
     *
     * Example:
     * ```
     * $transaction = $database->runTransaction(function (Transaction $t) use ($username, $password) {
     *     $rows = $t->execute('SELECT * FROM Users WHERE Name = @name and PasswordHash = @password', [
     *         'parameters' => [
     *             'name' => $username,
     *             'password' => password_hash($password, PASSWORD_DEFAULT)
     *         ]
     *     ])->rows();
     *     $user = $rows->current();
     *
     *     if ($user) {
     *         // Do something here to grant the user access.
     *         // Maybe set a cookie?
     *
     *         $user['loginCount'] = $user['loginCount'] + 1;
     *         $t->update('Users', $user);
     *
     *         $t->commit();
     *     } else {
     *         $t->rollback();
     *     }
     * });
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.BeginTransactionRequest BeginTransactionRequest
     * @see https://cloud.google.com/spanner/docs/transactions Transactions
     * @codingStandardsIgnoreEnd
     *
     * @param callable $operation The operations to run in the transaction.
     *        **Signature:** `function (Transaction $transaction)`.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type int $maxRetries The number of times to attempt to apply the
     *           operation before failing. **Defaults to ** `10`.
     *     @type bool $singleUse If true, a Transaction ID will not be allocated
     *           up front. Instead, the transaction will be considered
     *           "single-use", and may be used for only a single operation. Note
     *           that in a single-use transaction, only a single operation may
     *           be executed, and rollback is not available. **Defaults to**
     *           `false`.
     * }
     * @return mixed The return value of `$operation`.
     * @throws \RuntimeException If a transaction is not committed or rolled back.
     * @throws \BadMethodCallException If attempting to call this method within
     *         an existing transaction.
     */
    public function runTransaction(callable $operation, array $options = [])
    {
        if ($this->isRunningTransaction) {
            throw new \BadMethodCallException('Nested transactions are not supported by this client.');
        }

        $options += [
            'maxRetries' => self::MAX_RETRIES,
        ];

        // There isn't anything configurable here.
        $options['transactionOptions'] = $this->configureTransactionOptions();

        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READWRITE);

        $attempt = 0;
        $startTransactionFn = function ($session, $options) use (&$attempt) {
            if ($attempt > 0) {
                $options['isRetry'] = true;
            }

            $transaction = $this->operation->transaction($session, $options);

            $attempt++;
            return $transaction;
        };

        $delayFn = function (\Exception $e) {
            if (!($e instanceof AbortedException)) {
                throw $e;
            }

            $delay = $e->getRetryDelay();
            time_nanosleep($delay['seconds'], $delay['nanos']);
        };

        $transactionFn = function ($operation, $session, $options) use ($startTransactionFn) {
            $transaction = call_user_func_array($startTransactionFn, [
                $session,
                $options
            ]);

            // Prevent nested transactions.
            $this->isRunningTransaction = true;
            try {
                $res = call_user_func($operation, $transaction);
            } finally {
                $this->isRunningTransaction = false;
            }

            $active = $transaction->state() === Transaction::STATE_ACTIVE;
            $singleUse = $transaction->type() === Transaction::TYPE_SINGLE_USE;
            if ($active && !$singleUse) {
                $transaction->rollback($options);
                throw new \RuntimeException('Transactions must be rolled back or committed.');
            }

            return $res;
        };

        $retry = new Retry($options['maxRetries'], $delayFn);

        try {
            return $retry->execute($transactionFn, [$operation, $session, $options]);
        } finally {
            $session->setExpiration();
        }
    }

    /**
     * Insert a row.
     *
     * Mutations are committed in a single-use transaction.
     *
     * Since this method does not feature replay protection, it may attempt to
     * apply mutations more than once; if the mutations are not idempotent, this
     * may lead to a failure being reported when the mutation was previously
     * applied.
     *
     * Example:
     * ```
     * $database->insert('Posts', [
     *     'ID' => 1337,
     *     'postTitle' => 'Hello World!',
     *     'postContent' => 'Welcome to our site.'
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.CommitRequest CommitRequest
     * @codingStandardsIgnoreEnd
     *
     * @param string $table The table to mutate.
     * @param array $data The row data to insert.
     * @param array $options [optional] Configuration options.
     * @return Timestamp The commit Timestamp.
     */
    public function insert($table, array $data, array $options = [])
    {
        return $this->insertBatch($table, [$data], $options);
    }

    /**
     * Insert multiple rows.
     *
     * Mutations are committed in a single-use transaction.
     *
     * Since this method does not feature replay protection, it may attempt to
     * apply mutations more than once; if the mutations are not idempotent, this
     * may lead to a failure being reported when the mutation was previously
     * applied.
     *
     * Example:
     * ```
     * $database->insertBatch('Posts', [
     *     [
     *         'ID' => 1337,
     *         'postTitle' => 'Hello World!',
     *         'postContent' => 'Welcome to our site.'
     *     ], [
     *         'ID' => 1338,
     *         'postTitle' => 'Our History',
     *         'postContent' => 'Lots of people ask about where we got started.'
     *     ]
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.CommitRequest CommitRequest
     * @codingStandardsIgnoreEnd
     *
     * @param string $table The table to mutate.
     * @param array $dataSet The row data to insert.
     * @param array $options [optional] Configuration options.
     * @return Timestamp The commit Timestamp.
     */
    public function insertBatch($table, array $dataSet, array $options = [])
    {
        $mutations = [];
        foreach ($dataSet as $data) {
            $mutations[] = $this->operation->mutation(Operation::OP_INSERT, $table, $data);
        }

        return $this->commitInSingleUseTransaction($mutations, $options);
    }

    /**
     * Update a row.
     *
     * Only data which you wish to update need be included. The list of columns
     * must contain enough columns to allow Cloud Spanner to derive values for
     * all primary key columns in the row to be modified.
     *
     * Mutations are committed in a single-use transaction.
     *
     * Example:
     * ```
     * $database->update('Posts', [
     *     'ID' => 1337,
     *     'postContent' => 'Thanks for visiting our site!'
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.CommitRequest CommitRequest
     * @codingStandardsIgnoreEnd
     *
     * @param string $table The table to mutate.
     * @param array $data The row data to update.
     * @param array $options [optional] Configuration options.
     * @return Timestamp The commit Timestamp.
     */
    public function update($table, array $data, array $options = [])
    {
        return $this->updateBatch($table, [$data], $options);
    }

    /**
     * Update multiple rows.
     *
     * Only data which you wish to update need be included. The list of columns
     * must contain enough columns to allow Cloud Spanner to derive values for
     * all primary key columns in the row(s) to be modified.
     *
     * Mutations are committed in a single-use transaction.
     *
     * Example:
     * ```
     * $database->updateBatch('Posts', [
     *     [
     *         'ID' => 1337,
     *         'postContent' => 'Thanks for visiting our site!'
     *     ], [
     *         'ID' => 1338,
     *         'postContent' => 'A little bit about us!'
     *     ]
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.CommitRequest CommitRequest
     * @codingStandardsIgnoreEnd
     *
     * @param string $table The table to mutate.
     * @param array $dataSet The row data to update.
     * @param array $options [optional] Configuration options.
     * @return Timestamp The commit Timestamp.
     */
    public function updateBatch($table, array $dataSet, array $options = [])
    {
        $mutations = [];
        foreach ($dataSet as $data) {
            $mutations[] = $this->operation->mutation(Operation::OP_UPDATE, $table, $data);
        }

        return $this->commitInSingleUseTransaction($mutations, $options);
    }

    /**
     * Insert or update a row.
     *
     * If a row already exists (determined by comparing the Primary Key to
     * existing table data), the row will be updated. If not, it will be
     * created.
     *
     * Mutations are committed in a single-use transaction.
     *
     * Example:
     * ```
     * $database->insertOrUpdate('Posts', [
     *     'ID' => 1337,
     *     'postTitle' => 'Hello World!',
     *     'postContent' => 'Thanks for visiting our site!'
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.CommitRequest CommitRequest
     * @codingStandardsIgnoreEnd
     *
     * @param string $table The table to mutate.
     * @param array $data The row data to insert or update.
     * @param array $options [optional] Configuration options.
     * @return Timestamp The commit Timestamp.
     */
    public function insertOrUpdate($table, array $data, array $options = [])
    {
        return $this->insertOrUpdateBatch($table, [$data], $options);
    }

    /**
     * Insert or update multiple rows.
     *
     * If a row already exists (determined by comparing the Primary Key to
     * existing table data), the row will be updated. If not, it will be
     * created.
     *
     * Mutations are committed in a single-use transaction.
     *
     * Example:
     * ```
     * $database->insertOrUpdateBatch('Posts', [
     *     [
     *         'ID' => 1337,
     *         'postTitle' => 'Hello World!',
     *         'postContent' => 'Thanks for visiting our site!'
     *     ], [
     *         'ID' => 1338,
     *         'postTitle' => 'Our History',
     *         'postContent' => 'A little bit about us!'
     *     ]
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.CommitRequest CommitRequest
     * @codingStandardsIgnoreEnd
     *
     * @param string $table The table to mutate.
     * @param array $dataSet The row data to insert or update.
     * @param array $options [optional] Configuration options.
     * @return Timestamp The commit Timestamp.
     */
    public function insertOrUpdateBatch($table, array $dataSet, array $options = [])
    {
        $mutations = [];
        foreach ($dataSet as $data) {
            $mutations[] = $this->operation->mutation(Operation::OP_INSERT_OR_UPDATE, $table, $data);
        }

        return $this->commitInSingleUseTransaction($mutations, $options);
    }

    /**
     * Replace a row.
     *
     * Provide data for the entire row. Cloud Spanner will attempt to find a
     * record matching the Primary Key, and will replace the entire row. If a
     * matching row is not found, it will be inserted.
     *
     * Mutations are committed in a single-use transaction.
     *
     * Example:
     * ```
     * $database->replace('Posts', [
     *     'ID' => 1337,
     *     'postTitle' => 'Hello World!',
     *     'postContent' => 'Thanks for visiting our site!'
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.CommitRequest CommitRequest
     * @codingStandardsIgnoreEnd
     *
     * @param string $table The table to mutate.
     * @param array $data The row data to replace.
     * @param array $options [optional] Configuration options.
     * @return Timestamp The commit Timestamp.
     */
    public function replace($table, array $data, array $options = [])
    {
        return $this->replaceBatch($table, [$data], $options);
    }

    /**
     * Replace multiple rows.
     *
     * Provide data for the entire row. Cloud Spanner will attempt to find a
     * record matching the Primary Key, and will replace the entire row. If a
     * matching row is not found, it will be inserted.
     *
     * Mutations are committed in a single-use transaction.
     *
     * Example:
     * ```
     * $database->replaceBatch('Posts', [
     *     [
     *         'ID' => 1337,
     *         'postTitle' => 'Hello World!',
     *         'postContent' => 'Thanks for visiting our site!'
     *     ], [
     *         'ID' => 1338,
     *         'postTitle' => 'Our History',
     *         'postContent' => 'A little bit about us!'
     *     ]
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.CommitRequest CommitRequest
     * @codingStandardsIgnoreEnd
     *
     * @param string $table The table to mutate.
     * @param array $dataSet The row data to replace.
     * @param array $options [optional] Configuration options.
     * @return Timestamp The commit Timestamp.
     */
    public function replaceBatch($table, array $dataSet, array $options = [])
    {
        $mutations = [];
        foreach ($dataSet as $data) {
            $mutations[] = $this->operation->mutation(Operation::OP_REPLACE, $table, $data);
        }

        return $this->commitInSingleUseTransaction($mutations, $options);
    }

    /**
     * Delete one or more rows.
     *
     * Mutations are committed in a single-use transaction.
     *
     * Since this method does not feature replay protection, it may attempt to
     * apply mutations more than once; if the mutations are not idempotent, this
     * may lead to a failure being reported when the mutation was previously
     * applied.
     *
     * Example:
     * ```
     * $keySet = new KeySet([
     *     'keys' => [
     *         1337, 1338
     *     ]
     * ]);
     *
     * $database->delete('Posts', $keySet);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.CommitRequest CommitRequest
     * @codingStandardsIgnoreEnd
     *
     * @param string $table The table to mutate.
     * @param KeySet $keySet The KeySet to identify rows to delete.
     * @param array $options [optional] Configuration options.
     * @return Timestamp The commit Timestamp.
     */
    public function delete($table, KeySet $keySet, array $options = [])
    {
        $mutations = [$this->operation->deleteMutation($table, $keySet)];

        return $this->commitInSingleUseTransaction($mutations, $options);
    }

    /**
     * Run a query.
     *
     * Example:
     * ```
     * $result = $database->execute('SELECT * FROM Posts WHERE ID = @postId', [
     *     'parameters' => [
     *         'postId' => 1337
     *     ]
     * ]);
     *
     * $firstRow = $result
     *     ->rows()
     *     ->current();
     * ```
     *
     * ```
     * // Execute a read and return a new Snapshot for further reads.
     * $result = $database->execute('SELECT * FROM Posts WHERE ID = @postId', [
     *      'parameters' => [
     *         'postId' => 1337
     *     ],
     *     'begin' => true,
     *     'transactionType' => SessionPoolInterface::CONTEXT_READ
     * ]);
     *
     * $result->rows()->current();
     *
     * $snapshot = $result->snapshot();
     * ```
     *
     * ```
     * // Execute a read and return a new Transaction for further reads and writes.
     * $result = $database->execute('SELECT * FROM Posts WHERE ID = @postId', [
     *      'parameters' => [
     *         'postId' => 1337
     *     ],
     *     'begin' => true,
     *     'transactionType' => SessionPoolInterface::CONTEXT_READWRITE
     * ]);
     *
     * $result->rows()->current();
     *
     * $transaction = $result->transaction();
     * ```
     *
     * ```
     * // Parameters which may be null must include an expected parameter type.
     * $result = $database->execute('SELECT * FROM Posts WHERE lastModifiedTime = @timestamp', [
     *     'parameters' => [
     *         'timestamp' => $timestamp
     *     ],
     *     'types' => [
     *         'timestamp' => Database::TYPE_TIMESTAMP
     *     ]
     * ]);
     *
     * $neverEditedPosts = $result->rows();
     * ```
     *
     * ```
     * // Array parameters which may be null or empty must include the array value type.
     * $result = $database->execute('SELECT @emptyArrayOfIntegers as numbers', [
     *     'parameters' => [
     *         'emptyArrayOfIntegers' => []
     *     ],
     *     'types' => [
     *         'emptyArrayOfIntegers' => [Database::TYPE_ARRAY, Database::TYPE_INT64]
     *     ]
     * ]);
     *
     * $row = $result->rows()->current();
     * $emptyArray = $row['numbers'];
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.ExecuteSqlRequest ExecuteSqlRequest
     * @codingStandardsIgnoreEnd
     *
     * @codingStandardsIgnoreStart
     * @param string $sql The query string to execute.
     * @param array $options [optional] {
     *     Configuration Options.
     *     See [TransactionOptions](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#google.spanner.v1.TransactionOptions)
     *     for detailed description of available transaction options. Please
     *     note that only one of `$strong`, `$minReadTimestamp`,
     *     `$maxStaleness`, `$readTimestamp` or `$exactStaleness` may be set in
     *     a request.
     *
     *     @type array $parameters A key/value array of Query Parameters, where
     *           the key is represented in the query string prefixed by a `@`
     *           symbol.
     *     @type array $types A key/value array of Query Parameter types.
     *           Generally, Google Cloud PHP can infer types. Explicit type
     *           definitions are only necessary for null parameter values.
     *           Accepted values are defined as constants on
     *           {@see Google\Cloud\Spanner\ValueMapper}, and are as follows:
     *           `Database::TYPE_BOOL`, `Database::TYPE_INT64`,
     *           `Database::TYPE_FLOAT64`, `Database::TYPE_TIMESTAMP`,
     *           `Database::TYPE_DATE`, `Database::TYPE_STRING`,
     *           `Database::TYPE_BYTES`, `Database::TYPE_ARRAY` and
     *           `Database::TYPE_STRUCT`. If the parameter type is an array,
     *           the type should be given as an array, where the first element
     *           is `Database::TYPE_ARRAY` and the second element is the
     *           array type, for instance `[Database::TYPE_ARRAY, Database::TYPE_INT64]`.
     *     @type bool $returnReadTimestamp If true, the Cloud Spanner-selected
     *           read timestamp is included in the Transaction message that
     *           describes the transaction.
     *     @type bool $strong Read at a timestamp where all previously committed
     *           transactions are visible.
     *     @type Timestamp $minReadTimestamp Execute reads at a timestamp >= the
     *           given timestamp. Only available in single-use transactions.
     *     @type Duration $maxStaleness Read data at a timestamp >= NOW - the
     *           given timestamp. Only available in single-use transactions.
     *     @type Timestamp $readTimestamp Executes all reads at the given
     *           timestamp.
     *     @type Duration $exactStaleness Represents a number of seconds. Executes
     *           all reads at a timestamp that is $exactStaleness old.
     *     @type bool $begin If true, will begin a new transaction. If a
     *           read/write transaction is desired, set the value of
     *           $transactionType. If a transaction or snapshot is created, it
     *           will be returned as `$result->transaction()` or
     *           `$result->snapshot()`. **Defaults to** `false`.
     *     @type string $transactionType One of `SessionPoolInterface::CONTEXT_READ`
     *           or `SessionPoolInterface::CONTEXT_READWRITE`. If read/write is
     *           chosen, any snapshot options will be disregarded. If `$begin`
     *           is false, transaction type MUST be `SessionPoolInterface::CONTEXT_READ`.
     *           **Defaults to** `SessionPoolInterface::CONTEXT_READ`.
     * }
     * @codingStandardsIgnoreEnd
     * @return Result
     */
    public function execute($sql, array $options = [])
    {
        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READ);

        list($transactionOptions, $context) = $this->transactionSelector($options);
        $options['transaction'] = $transactionOptions;
        $options['transactionContext'] = $context;

        try {
            return $this->operation->execute($session, $sql, $options);
        } finally {
            $session->setExpiration();
        }
    }

    /**
     * Lookup rows in a table.
     *
     * Example:
     * ```
     * $keySet = new KeySet([
     *     'keys' => [1337]
     * ]);
     *
     * $columns = ['ID', 'title', 'content'];
     *
     * $result = $database->read('Posts', $keySet, $columns);
     *
     * $firstRow = $result
     *     ->rows()
     *     ->current();
     * ```
     *
     * ```
     * // Execute a read and return a new Snapshot for further reads.
     * $keySet = new KeySet([
     *     'keys' => [1337]
     * ]);
     *
     * $columns = ['ID', 'title', 'content'];
     *
     * $result = $database->read('Posts', $keySet, $columns, [
     *     'begin' => true,
     *     'transactionType' => SessionPoolInterface::CONTEXT_READ
     * ]);
     *
     * $result->rows()->current();
     *
     * $snapshot = $result->snapshot();
     * ```
     *
     * ```
     * // Execute a read and return a new Transaction for further reads and writes.
     * $keySet = new KeySet([
     *     'keys' => [1337]
     * ]);
     *
     * $columns = ['ID', 'title', 'content'];
     *
     * $result = $database->read('Posts', $keySet, $columns, [
     *     'begin' => true,
     *     'transactionType' => SessionPoolInterface::CONTEXT_READWRITE
     * ]);
     *
     * $result->rows()->current();
     *
     * $transaction = $result->transaction();
     * ```
     *
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.ReadRequest ReadRequest
     *
     * @codingStandardsIgnoreStart
     * @param string $table The table name.
     * @param KeySet $keySet The KeySet to select rows.
     * @param array $columns A list of column names to return.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     See [TransactionOptions](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#google.spanner.v1.TransactionOptions)
     *     for detailed description of available transaction options.
     *
     *     Please note that only one of `$strong`, `$minReadTimestamp`,
     *     `$maxStaleness`, `$readTimestamp` or `$exactStaleness` may be set in
     *     a request.
     *
     *     @type string $index The name of an index on the table.
     *     @type int $limit The number of results to return.
     *     @type bool $returnReadTimestamp If true, the Cloud Spanner-selected
     *           read timestamp is included in the Transaction message that
     *           describes the transaction.
     *     @type bool $strong Read at a timestamp where all previously committed
     *           transactions are visible.
     *     @type Timestamp $minReadTimestamp Execute reads at a timestamp >= the
     *           given timestamp. Only available in single-use transactions.
     *     @type Duration $maxStaleness Read data at a timestamp >= NOW - the
     *           given timestamp. Only available in single-use transactions.
     *     @type Timestamp $readTimestamp Executes all reads at the given
     *           timestamp.
     *     @type Duration $exactStaleness Represents a number of seconds. Executes
     *           all reads at a timestamp that is $exactStaleness old.
     *     @type bool $begin If true, will begin a new transaction. If a
     *           read/write transaction is desired, set the value of
     *           $transactionType. If a transaction or snapshot is created, it
     *           will be returned as `$result->transaction()` or
     *           `$result->snapshot()`. **Defaults to** `false`.
     *     @type string $transactionType One of `SessionPoolInterface::CONTEXT_READ`
     *           or `SessionPoolInterface::CONTEXT_READWRITE`. If read/write is
     *           chosen, any snapshot options will be disregarded. If `$begin`
     *           is false, transaction type MUST be `SessionPoolInterface::CONTEXT_READ`.
     *           **Defaults to** `SessionPoolInterface::CONTEXT_READ`.
     * }
     * @codingStandardsIgnoreEnd
     * @return Result
     */
    public function read($table, KeySet $keySet, array $columns, array $options = [])
    {
        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READ);

        list($transactionOptions, $context) = $this->transactionSelector($options);
        $options['transaction'] = $transactionOptions;
        $options['transactionContext'] = $context;

        try {
            return $this->operation->read($session, $table, $keySet, $columns, $options);
        } finally {
            $session->setExpiration();
        }
    }

    /**
     * Get the underlying session pool implementation.
     *
     * Example:
     * ```
     * $pool = $database->sessionPool();
     * ```
     *
     * @return SessionPoolInterface|null
     */
    public function sessionPool()
    {
        return $this->sessionPool;
    }

    /**
     * Closes the database connection by returning the active session back to
     * the session pool queue or by deleting the session if there is no pool
     * associated.
     *
     * It is highly important to ensure this is called as it is not always safe
     * to rely soley on {@see Google\Cloud\Spanner\Database::__destruct()}.
     *
     * Example:
     * ```
     * $database->close();
     * ```
     */
    public function close()
    {
        if ($this->session) {
            if ($this->sessionPool) {
                $this->sessionPool->release($this->session);
            } else {
                $this->session->delete();
            }

            $this->session = null;
        }
    }

    /**
     * Closes the database connection.
     */
    public function __destruct()
    {
        try {
            $this->close();
        } catch (\Exception $ex) {
        }
    }

    /**
     * Create a new session.
     *
     * Sessions are handled behind the scenes and this method does not need to
     * be called directly.
     *
     * @access private
     * @param array $options [optional] Configuration options.
     * @return Session
     */
    public function createSession(array $options = [])
    {
        $res = $this->connection->createSession($options + [
            'database' => $this->name
        ]);

        return $this->session($res['name']);
    }

    /**
     * Lazily instantiates a session. There are no network requests made at this
     * point. To see the operations that can be performed on a session please
     * see {@see Google\Cloud\Spanner\Session\Session}.
     *
     * Sessions are handled behind the scenes and this method does not need to
     * be called directly.
     *
     * @access private
     * @param string $name The session's name.
     * @return Session
     */
    public function session($name)
    {
        return new Session(
            $this->connection,
            $this->projectId,
            GapicSpannerClient::parseInstanceFromSessionName($name),
            GapicSpannerClient::parseDatabaseFromSessionName($name),
            GapicSpannerClient::parseSessionFromSessionName($name)
        );
    }

    /**
     * Retrieves the database's identity.
     *
     * @access private
     * @return array
     */
    public function identity()
    {
        $databaseParts = explode('/', $this->name);
        $instanceParts = explode('/', $this->instance->name());

        return [
            'projectId' => $this->projectId,
            'database' => end($databaseParts),
            'instance' => end($instanceParts),
        ];
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
            'name' => $this->name,
            'instance' => $this->instance,
            'sessionPool' => $this->sessionPool,
        ];
    }

    /**
     * If no session is already associated with the database use the session
     * pool implementation to retrieve a session one - otherwise create on
     * demand.
     *
     * @param string $context [optional] The session context. **Defaults to**
     *        `r` (READ).
     * @return Session
     */
    private function selectSession($context = SessionPoolInterface::CONTEXT_READ)
    {
        if ($this->session) {
            return $this->session;
        }

        if ($this->sessionPool) {
            return $this->session = $this->sessionPool->acquire($context);
        } else {
            return $this->session = $this->createSession();
        }
    }

    private function commitInSingleUseTransaction(array $mutations, array $options = [])
    {
        $options['mutations'] = $mutations;

        return $this->runTransaction(function (Transaction $t) use ($options) {
            return $t->commit($options);
        }, [
            'singleUse' => true
        ]);
    }

    /**
     * Convert the simple database name to a fully qualified name.
     *
     * @return string
     */
    private function fullyQualifiedDatabaseName($name)
    {
        $instance = InstanceAdminClient::parseInstanceFromInstanceName($this->instance->name());

        try {
            return GapicSpannerClient::formatDatabaseName(
                $this->projectId,
                $instance,
                $name
            );
        } catch (ValidationException $e) {
            return $name;
        }
    }
}
