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

use Google\Cloud\ArrayTrait;
use Google\Cloud\Exception\AbortedException;
use Google\Cloud\Exception\NotFoundException;
use Google\Cloud\Iam\Iam;
use Google\Cloud\LongRunning\LROTrait;
use Google\Cloud\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Retry;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Connection\IamDatabase;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\V1\SpannerClient as GrpcSpannerClient;

/**
 * Represents a Google Cloud Spanner Database
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 * $spanner = $cloud->spanner();
 *
 * $database = $spanner->connect('my-instance', 'my-database');
 * ```
 *
 * ```
 * // Databases can also be connected to via an Instance.
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 * $spanner = $cloud->spanner();
 *
 * $instance = $spanner->instance('my-instance');
 * $database = $instance->database('my-database');
 * ```
 *
 * @method lro() {
 *     @param string $operationName The name of the Operation to resume.
 *     @return LongRunningOperation
 *
 *     Example:
 *     ```
 *     $operation = $database->lro($operationName);
 *     ```
 * }
 */
class Database
{
    use ArrayTrait;
    use LROTrait;
    use TransactionConfigurationTrait;

    const MAX_RETRIES = 3;

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
     * @var LongRunningConnectionInterface
     */
    private $lroConnection;

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
     * @param SessionPoolInterface $sessionPool The session pool implementation.
     * @param LongRunningConnectionInterface $lroConnection An implementation
     *        mapping to methods which handle LRO resolution in the service.
     * @param string $projectId The project ID.
     * @param string $name The database name.
     * @param bool $returnInt64AsObject If true, 64 bit integers will be
     *        returned as a {@see Google\Cloud\Int64} object for 32 bit platform
     *        compatibility. **Defaults to** false.
     */
    public function __construct(
        ConnectionInterface $connection,
        Instance $instance,
        SessionPoolInterface $sessionPool,
        LongRunningConnectionInterface $lroConnection,
        array $lroCallables,
        $projectId,
        $name,
        $returnInt64AsObject = false
    ) {
        $this->connection = $connection;
        $this->instance = $instance;
        $this->sessionPool = $sessionPool;
        $this->lroConnection = $lroConnection;
        $this->lroCallables = $lroCallables;
        $this->projectId = $projectId;
        $this->name = $name;

        $this->operation = new Operation($connection, $returnInt64AsObject);
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
            $this->ddl($options);
        } catch (NotFoundException $e) {
            return false;
        }

        return true;
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
        $operation = $this->connection->updateDatabase($options + [
            'name' => $this->fullyQualifiedDatabaseName(),
            'statements' => $statements,
        ]);

        return $this->lro($operation['name']);
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
            'name' => $this->fullyQualifiedDatabaseName()
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
     * }
     * @return Snapshot
     * @codingStandardsIgnoreEnd
     */
    public function snapshot(array $options = [])
    {
        // These are only available in single-use transactions.
        if (isset($options['maxStaleness']) || isset($options['minReadTimestamp'])) {
            throw new \BadMethodCallException(
                'maxStaleness and minReadTimestamp are only available in single-use transactions.'
            );
        }

        $transactionOptions = $this->configureSnapshotOptions($options);

        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READ);

        return $this->operation->snapshot($session, $transactionOptions);
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
     * {@see Google\Cloud\Exception\AbortedException} will be thrown. Any other
     * exception types will immediately bubble up and will interrupt the retry
     * operation.
     *
     * Please note that once a transaction reads data, it will lock the read
     * data, preventing other users from modifying that data. For this reason,
     * it is important that every transaction commits or rolls back as early as
     * possible. Do not hold transactions open longer than necessary.
     *
     * If you have an active transaction which was obtained from elsewhere, you
     * can provide it to this method and gain the benefits of managed retry by
     * setting `$options.transaction` to your {@see Google\Cloud\Spanner\Transaction}
     * instance. Please note that in this case, it is important that ALL reads
     * and mutations MUST be performed within the runTransaction callable.
     *
     * Example:
     * ```
     * $transaction = $database->runTransaction(function (Transaction $t) use ($userName, $password) {
     *     $user = $t->execute('SELECT * FROM Users WHERE Name = @name and PasswordHash = @password', [
     *         'parameters' => [
     *             'name' => $userName,
     *             'password' => password_hash($password)
     *         ]
     *     ])->firstRow();
     *
     *     if ($user) {
     *         grantAccess($user);
     *
     *         $user['loginCount'] = $user['loginCount'] + 1;
     *         $t->update('Users', $user);
     *     } else {
     *         $t->rollback();
     *     }
     *
     *     $t->commit();
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
     *           operation before failing. **Defaults to ** `3`.
     *     @type Transaction $transaction If provided, the transaction will be
     *           passed to the callable instead of attempting to begin a new
     *           transaction.
     * }
     * @return mixed The return value of `$operation`.
     */
    public function runTransaction(callable $operation, array $options = [])
    {
        $options += [
            'maxRetries' => self::MAX_RETRIES,
            'transaction' => null
        ];

        // There isn't anything configurable here.
        $options['transactionOptions'] = $this->configureTransactionOptions();

        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READWRITE);

        $attempt = 0;
        $startTransactionFn = function ($session, $options) use ($options, &$attempt) {
            if ($attempt === 0 && $options['transaction'] instanceof Transaction) {
                $transaction = $options['transaction'];
            } else {
                $transaction = $this->operation->transaction($session, $options);
            }

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

        $commitFn = function($operation, $session, $options) use ($startTransactionFn) {
            $transaction = call_user_func_array($startTransactionFn, [
                $session,
                $options
            ]);

            return call_user_func($operation, $transaction);
        };

        $retry = new Retry($options['maxRetries'], $delayFn);
        return $retry->execute($commitFn, [$operation, $session, $options]);
    }

    /**
     * Create and return a new read/write Transaction.
     *
     * When manually using a Transaction, it is advised that retry logic be
     * implemented to reapply all operations when an instance of
     * {@see Google\Cloud\Exception\AbortedException} is thrown.
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
     * @param array $options [optional] Configuration Options.
     * @return Transaction
     */
    public function transaction(array $options = [])
    {
        // There isn't anything configurable here.
        $options['transactionOptions'] = [
            'readWrite' => []
        ];

        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READWRITE);
        return $this->operation->transaction($session, $options);
    }

    /**
     * Insert a row.
     *
     * Mutations are committed in a single-use transaction.
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
     * Example:
     * ```
     * $database->insert('Posts', [
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

        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READWRITE);

        $options['singleUseTransaction'] = $this->configureTransactionOptions();
        return $this->operation->commit($session, $mutations, $options);
    }

    /**
     * Update a row.
     *
     * Only data which you wish to update need be included. You must provide
     * enough information for the API to determine which row should be modified.
     * In most cases, this means providing values for the Primary Key fields.
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
     * Only data which you wish to update need be included. You must provide
     * enough information for the API to determine which row should be modified.
     * In most cases, this means providing values for the Primary Key fields.
     *
     * Mutations are committed in a single-use transaction.
     *
     * Example:
     * ```
     * $database->update('Posts', [
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

        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READWRITE);

        $options['singleUseTransaction'] = $this->configureTransactionOptions();
        return $this->operation->commit($session, $mutations, $options);
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

        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READWRITE);

        $options['singleUseTransaction'] = $this->configureTransactionOptions();
        return $this->operation->commit($session, $mutations, $options);
    }

    /**
     * Replace a row.
     *
     * Provide data for the entire row. Google Cloud Spanner will attempt to
     * find a record matching the Primary Key, and will replace the entire row.
     * If a matching row is not found, it will be inserted.
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
     * Provide data for the entire row. Google Cloud Spanner will attempt to
     * find a record matching the Primary Key, and will replace the entire row.
     * If a matching row is not found, it will be inserted.
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

        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READWRITE);

        $options['singleUseTransaction'] = $this->configureTransactionOptions();
        return $this->operation->commit($session, $mutations, $options);
    }

    /**
     * Delete one or more rows.
     *
     * Mutations are committed in a single-use transaction.
     *
     * Example:
     * ```
     * $keySet = $spanner->keySet([
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

        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READWRITE);

        $options['singleUseTransaction'] = $this->configureTransactionOptions();
        return $this->operation->commit($session, $mutations, $options);
    }

    /**
     * Run a query.
     *
     * Example:
     * ```
     * $result = $spanner->execute('SELECT * FROM Posts WHERE ID = @postId', [
     *     'parameters' => [
     *         'postId' => 1337
     *     ]
     * ]);
     * ```
     *
     * ```
     * // Execute a read and return a new Snapshot for further reads.
     * $result = $spanner->execute('SELECT * FROM Posts WHERE ID = @postId', [
     *      'parameters' => [
     *         'postId' => 1337
     *     ],
     *     'begin' => true
     * ]);
     *
     * $snapshot = $result->snapshot();
     * ```
     *
     * ```
     * // Execute a read and return a new Transaction for further reads and writes.
     * $result = $spanner->execute('SELECT * FROM Posts WHERE ID = @postId', [
     *      'parameters' => [
     *         'postId' => 1337
     *     ],
     *     'begin' => true,
     *     'transactionType' => SessionPoolInterface::CONTEXT_READWRITE
     * ]);
     *
     * $transaction = $result->transaction();
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
     *
     *     See [TransactionOptions](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#google.spanner.v1.TransactionOptions)
     *     for detailed description of available transaction options.
     *
     *     Please note that only one of `$strong`, `$minReadTimestamp`,
     *     `$maxStaleness`, `$readTimestamp` or `$exactStaleness` may be set in
     *     a request.
     *
     *     @type array $parameters A key/value array of Query Parameters, where
     *           the key is represented in the query string prefixed by a `@`
     *           symbol.
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
     *           is false, this option will be ignored. **Defaults to**
     *           `SessionPoolInterface::CONTEXT_READ`.
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

        return $this->operation->execute($session, $sql, $options);
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
     *     'keys' => [1337]
     * ]);
     *
     * $columns = ['ID', 'title', 'content'];
     *
     * $result = $database->read('Posts', $keySet, $columns);
     * ```
     *
     * ```
     * // Execute a read and return a new Snapshot for further reads.
     * $keySet = $spanner->keySet([
     *     'keys' => [1337]
     * ]);
     *
     * $columns = ['ID', 'title', 'content'];
     *
     * $result = $database->read('Posts', $keySet, $columns, [
     *     'begin' => true
     * ]);
     *
     * $snapshot = $result->snapshot();
     * ```
     *
     * ```
     * // Execute a read and return a new Transaction for further reads and writes.
     * $keySet = $spanner->keySet([
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
     *     @type int $offset The number of rows to offset results by.
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
     *           is false, this option will be ignored. **Defaults to**
     *           `SessionPoolInterface::CONTEXT_READ`.
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

        return $this->operation->read($session, $table, $keySet, $columns, $options);
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
        return GrpcSpannerClient::formatDatabaseName(
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
            'name' => $this->name,
            'instance' => $this->instance,
            'sessionPool' => $this->sessionPool,
            'returnInt64AsObject' => $this->returnInt64AsObject,
        ];
    }
}
