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

use Google\ApiCore\ValidationException;
use Google\Cloud\Core\Exception\AbortedException;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\LongRunning\LROTrait;
use Google\Cloud\Core\Retry;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\Database\State;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseDialect;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Connection\IamDatabase;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\SpannerClient as GapicSpannerClient;
use Google\Cloud\Spanner\V1\TypeCode;

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

    const STATE_CREATING = State::CREATING;
    const STATE_READY = State::READY;
    const STATE_READY_OPTIMIZING = State::READY_OPTIMIZING;
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
    const TYPE_NUMERIC = TypeCode::NUMERIC;
    const TYPE_PG_NUMERIC = 'pgNumeric';
    const TYPE_PG_JSONB = 'pgJsonb';
    const TYPE_JSON = TypeCode::JSON;

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
     * @var Iam|null
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
     * @param array $lroCallables
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
        $returnInt64AsObject = false,
        array $info = []
    ) {
        $this->connection = $connection;
        $this->instance = $instance;
        $this->projectId = $projectId;
        $this->name = $this->fullyQualifiedDatabaseName($name);
        $this->sessionPool = $sessionPool;
        $this->operation = new Operation($connection, $returnInt64AsObject);
        $this->info = $info;

        if ($this->sessionPool) {
            $this->sessionPool->setDatabase($this);
        }

        $this->setLroProperties($lroConnection, $lroCallables, $this->name);
    }

    /**
     * Return the database state.
     *
     * When databases are created or restored, they may take some time before
     * they are ready for use. This method allows for checking whether a
     * database is ready. Note that this value is cached within the class instance,
     * so if you are polling it, first call {@see Google\Cloud\Spanner\Database::reload()}
     * to refresh the cached value.
     *
     * Example:
     * ```
     * if ($database->state() === Database::STATE_READY) {
     *     echo 'Database is ready!';
     * }
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return int|null
     */
    public function state(array $options = [])
    {
        $info = $this->info($options);

        return (isset($info['state']))
            ? $info['state']
            : null;
    }

    /**
     * List completed and pending backups belonging to this database.
     *
     * Example:
     * ```
     * $backups = $database->backups();
     * ```
     *
     * @param array $options [optional] {
     *     Configuration options.
     *     @type string $filter The standard list filter.
     *           **NOTE**: This method always sets the database filter as a name of this database.
     *           User may provide additional filter expressions which would be appended in the form of
     *           "(database:<databaseName>) AND (<additional filter expression from user>)"
     *     @type int $pageSize Maximum number of results to return per request.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     *
     * @return ItemIterator<Backup>
     */
    public function backups(array $options = [])
    {
        $filter = "database:" . $this->name();

        if (isset($options['filter'])) {
            $filter = sprintf('(%1$s) AND (%2$s)', $filter, $this->pluck('filter', $options));
        }

        return $this->instance->backups([
            'filter' => $filter
        ] + $options);
    }

    /**
     * Create a backup for this database.
     *
     * Example:
     * ```
     * $operation = $database->createBackup('my-backup', new \DateTime('+7 hours'));
     * ```
     *
     * @param string $name The backup name.
     * @param \DateTimeInterface $expireTime ​The expiration time of the backup,
     *        with microseconds granularity that must be at least 6 hours and
     *        at most 366 days. Once the expireTime has passed, the backup is
     *        eligible to be automatically deleted by Cloud Spanner.
     * @param array $options [optional] Configuration options.
     *
     * @return LongRunningOperation<Backup>
     */
    public function createBackup($name, \DateTimeInterface $expireTime, array $options = [])
    {
        $backup = $this->instance->backup($name);
        return $backup->create($this->name(), $expireTime, $options);
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
        $statements = $this->pluck('statements', $options, false) ?: [];
        $dialect = isset($options['databaseDialect']) ? $options['databaseDialect'] : null;

        $createStatement = $this->getCreateDbStatement($dialect);

        $operation = $this->connection->createDatabase([
            'instance' => $this->instance->name(),
            'createStatement' => $createStatement,
            'extraStatements' => $statements
        ] + $options);

        return $this->resumeOperation($operation['name'], $operation);
    }

    /**
     * Restores to this database from a backup.
     *
     * **NOTE**: A restore operation can only be made to a non-existing database.
     *
     * Example:
     * ```
     * $operation = $database->restore($backup);
     * ```
     *
     * @param Backup|string $backup The backup to restore, given as a Backup instance or a string of the form
     *        `projects/<project>/instances/<instance>/backups/<backup>`.
     * @param array $options [optional] Configuration options.
     *
     * @return LongRunningOperation<Database>
     */
    public function restore($backup, array $options = [])
    {
        return $this->instance->createDatabaseFromBackup($this->name, $backup, $options);
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
     * Please note that after a database is dropped, all sessions attached to it
     * will be invalid and unusable. Calls to this method will clear any session
     * pool attached to this database class instance and delete any sessions
     * attached to the database class instance.
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

        if ($this->sessionPool) {
            $this->sessionPool->clear();
        }

        if ($this->session) {
            $this->session->delete($options);
            $this->session = null;
        }
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
     *     @type array $sessionOptions Session configuration and request options.
     *           Session labels may be applied using the `labels` key.
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

        $session = $this->selectSession(
            SessionPoolInterface::CONTEXT_READ,
            $this->pluck('sessionOptions', $options, false) ?: []
        );

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
     *     @type array $sessionOptions Session configuration and request options.
     *           Session labels may be applied using the `labels` key.
     *     @type string $tag A transaction tag. Requests made using this transaction will
     *           use this as the transaction tag.
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

        $session = $this->selectSession(
            SessionPoolInterface::CONTEXT_READWRITE,
            $this->pluck('sessionOptions', $options, false) ?: []
        );

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
     * use Google\Cloud\Spanner\Timestamp;
     *
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
     *         $user['lastLoginTime'] = new Timestamp(new \DateTime);
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
     *     @type array $sessionOptions Session configuration and request options.
     *           Session labels may be applied using the `labels` key.
     *     @type string $tag A transaction tag. Requests made using this transaction will
     *           use this as the transaction tag.
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

        $session = $this->selectSession(
            SessionPoolInterface::CONTEXT_READWRITE,
            $this->pluck('sessionOptions', $options, false) ?: []
        );

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

            return $e->getRetryDelay();
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
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use
     *         transactions.
     * }
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
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use
     *         transactions.
     * }
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
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use
     *         transactions.
     * }
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
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use
     *         transactions.
     * }
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
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use
     *         transactions.
     * }
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
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use
     *         transactions.
     * }
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
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use
     *         transactions.
     * }
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
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use
     *         transactions.
     * }
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
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use
     *         transactions.
     * }
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
     * Google Cloud PHP will infer parameter types for all primitive types and
     * all values implementing {@see Google\Cloud\Spanner\ValueInterface}, with
     * the exception of `null`. Non-associative arrays will be interpreted as
     * a Spanner ARRAY type, and must contain only a single type of value.
     * Associative arrays or values of type {@see Google\Cloud\Spanner\StructValue}
     * will be interpreted as Spanner STRUCT type. Structs MUST always explicitly
     * define their field types.
     *
     * In any case where the value of a parameter may be `null`, you MUST
     * explicitly define the parameter's type.
     *
     * With the exception of arrays and structs, types are defined using a type
     * constant defined on {@see Google\Cloud\Spanner\Database}. Examples include
     * but are not limited to `Database::TYPE_STRING` and `Database::TYPE_INT64`.
     *
     * Arrays, when explicitly typing, should use an instance of
     * {@see Google\Cloud\Spanner\ArrayType} to declare their type and the types
     * of any values contained within the array elements.
     *
     * Structs must always declare their type using an instance of
     * {@see Google\Cloud\Spanner\StructType}. Struct values may be expressed as
     * an associative array, however if the struct contains any unnamed fields,
     * or any fields with duplicate names, the struct must be expressed using an
     * instance of {@see Google\Cloud\Spanner\StructValue}. Struct value types
     * may be inferred with the same caveats as top-level parameters (in other
     * words, so long as they are not nullable and do not contain nested structs).
     *
     * Example:
     * ```
     * $result = $database->execute('SELECT * FROM Posts WHERE ID = @postId', [
     *     'parameters' => [
     *         'postId' => 1337
     *     ]
     * ]);
     *
     * $firstRow = $result->rows()->current();
     * ```
     *
     * ```
     * // Parameters which may be null must include an expected parameter type.
     * use Google\Cloud\Spanner\Database;
     * use Google\Cloud\Spanner\Timestamp;
     *
     * $values = [
     *     new Timestamp(new \DateTimeImmutable),
     *     null
     * ];
     *
     * $result = $database->execute('SELECT @timestamp as timestamp', [
     *     'parameters' => [
     *         'timestamp' => array_rand($values)
     *     ],
     *     'types' => [
     *         'timestamp' => Database::TYPE_TIMESTAMP
     *     ]
     * ]);
     *
     * $timestamp = $result->rows()->current()['timestamp'];
     * ```
     *
     * ```
     * // Array parameters which may be null or empty must include the array value type.
     * use Google\Cloud\Spanner\ArrayType;
     * use Google\Cloud\Spanner\Database;
     *
     * $result = $database->execute('SELECT @emptyArrayOfIntegers as numbers', [
     *     'parameters' => [
     *         'emptyArrayOfIntegers' => []
     *     ],
     *     'types' => [
     *         'emptyArrayOfIntegers' => new ArrayType(Database::TYPE_INT64)
     *     ]
     * ]);
     *
     * $row = $result->rows()->current();
     * $emptyArray = $row['numbers'];
     * ```
     *
     * ```
     * // Struct parameters provide a type definition. Fields within a Struct may
     * // be inferred following the same rules as top-level parameters. Any
     * // nested structs must be an instance of `Google\Cloud\Spanner\StructType`,
     * // and any values which could be of type `null` must explicitly specify
     * // their type.
     * use Google\Cloud\Spanner\Database;
     * use Google\Cloud\Spanner\StructType;
     *
     * $result = $database->execute('SELECT @userStruct.firstName, @userStruct.lastName', [
     *     'parameters' => [
     *         'userStruct' => [
     *             'firstName' => 'John',
     *             'lastName' => 'Testuser'
     *         ]
     *     ],
     *     'types' => [
     *         'userStruct' => (new StructType())
     *             ->add('firstName', Database::TYPE_STRING)
     *             ->add('lastName', Database::TYPE_STRING)
     *     ]
     * ]);
     *
     * $row = $result->rows()->current();
     * $fullName = $row['firstName'] . ' ' . $row['lastName']; // `John Testuser`
     * ```
     *
     * ```
     * // If a struct contains unnamed fields, or multiple fields with the same
     * // name, it must be defined using {@see Google\Cloud\Spanner\StructValue}.
     * use Google\Cloud\Spanner\Database;
     * use Google\Cloud\Spanner\Result;
     * use Google\Cloud\Spanner\StructValue;
     * use Google\Cloud\Spanner\StructType;
     *
     * $res = $database->execute('SELECT * FROM UNNEST(ARRAY(SELECT @structParam))', [
     *     'parameters' => [
     *         'structParam' => (new StructValue)
     *             ->add('foo', 'bar')
     *             ->add('foo', 2)
     *             ->addUnnamed('this field is unnamed')
     *     ],
     *     'types' => [
     *         'structParam' => (new StructType)
     *             ->add('foo', Database::TYPE_STRING)
     *             ->add('foo', Database::TYPE_INT64)
     *             ->addUnnamed(Database::TYPE_STRING)
     *     ]
     * ])->rows(Result::RETURN_NAME_VALUE_PAIR)->current();
     *
     * echo $res[0]['name'] . ': ' . $res[0]['value'] . PHP_EOL; // "foo: bar"
     * echo $res[1]['name'] . ': ' . $res[1]['value'] . PHP_EOL; // "foo: 2"
     * echo $res[2]['name'] . ': ' . $res[2]['value'] . PHP_EOL; // "2: this field is unnamed"
     * ```
     *
     * ```
     * // Execute a read and return a new Snapshot for further reads.
     * use Google\Cloud\Spanner\Session\SessionPoolInterface;
     *
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
     * use Google\Cloud\Spanner\Session\SessionPoolInterface;
     *
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
     *           declarations are required in the case of struct parameters,
     *           or when a null value exists as a parameter.
     *           Accepted values for primitive types are defined as constants on
     *           {@see Google\Cloud\Spanner\Database}, and are as follows:
     *           `Database::TYPE_BOOL`, `Database::TYPE_INT64`,
     *           `Database::TYPE_FLOAT64`, `Database::TYPE_TIMESTAMP`,
     *           `Database::TYPE_DATE`, `Database::TYPE_STRING`,
     *           `Database::TYPE_BYTES`. If the value is an array, use
     *           {@see Google\Cloud\Spanner\ArrayType} to declare the array
     *           parameter types. Likewise, for structs, use
     *           {@see Google\Cloud\Spanner\StructType}.
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
     *     @type array $sessionOptions Session configuration and request options.
     *           Session labels may be applied using the `labels` key.
     *     @type array $queryOptions Query optimizer configuration.
     *     @type string $queryOptions.optimizerVersion An option to control the
     *           selection of optimizer version. This parameter allows
     *           individual queries to pick different query optimizer versions.
     *           Specifying "latest" as a value instructs Cloud Spanner to use
     *           the latest supported query optimizer version. If not specified,
     *           Cloud Spanner uses optimizer version set at the client level
     *           options or set by the `SPANNER_OPTIMIZER_VERSION` environment
     *           variable. Any other positive integer (from the list of supported
     *           optimizer versions) overrides the default optimizer version for
     *           query execution. Executing a SQL statement with an invalid
     *           optimizer version will fail with a syntax error
     *           (`INVALID_ARGUMENT`) status.
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for read-only
     *         transactions.
     * }
     * @codingStandardsIgnoreEnd
     * @return Result
     */
    public function execute($sql, array $options = [])
    {
        unset($options['requestOptions']['transactionTag']);
        $session = $this->pluck('session', $options, false)
            ?: $this->selectSession(
                SessionPoolInterface::CONTEXT_READ,
                $this->pluck('sessionOptions', $options, false) ?: []
            );

        list(
            $options['transaction'],
            $options['transactionContext']
        ) = $this->transactionSelector($options);

        try {
            return $this->operation->execute($session, $sql, $options);
        } finally {
            $session->setExpiration();
        }
    }

    /**
     * Execute a partitioned DML update.
     *
     * Returns the lower bound of rows modified by the DML statement.
     *
     * **PLEASE NOTE** Most use cases for DML are better served by using
     * {@see Google\Cloud\Spanner\Transaction::executeUpdate()}. Please read and
     * understand the documentation for partitioned DML before implementing it
     * in your application.
     *
     * Data Manipulation Language (DML) allows you to execute statements which
     * modify the state of the database (i.e. inserting, updating or deleting
     * rows).
     *
     * To execute a SELECT statement, use
     * {@see Google\Cloud\Spanner\Database::execute()}.
     *
     * The method will block until the update is complete. Running a DML
     * statement with this method does not offer exactly once semantics, and
     * therefore the DML statement should be idempotent. The DML statement must
     * be fully-partitionable. Specifically, the statement must be expressible
     * as the union of many statements which each access only a single row of
     * the table. Partitioned DML partitions the key space and runs the DML
     * statement over each partition in parallel using separate, internal
     * transactions that commit independently.
     *
     * Partitioned DML is good fit for large, database-wide, operations that are
     * idempotent. Partitioned DML enables large-scale changes without running
     * into transaction size limits or accidentally locking the entire table in
     * one large transaction. Smaller scoped statements, such as an OLTP
     * workload, should prefer using
     * {@see Google\Cloud\Spanner\Transaction::executeUpdate()}.
     *
     * * The DML statement must be fully-partitionable. Specifically, the
     *   statement must be expressible as the union of many statements which
     *   each access only a single row of the table.
     * * The statement is not applied atomically to all rows of the table.
     *   Rather, the statement is applied atomically to partitions of the table,
     *   in independent internal transactions. Secondary index rows are updated
     *   atomically with the base table rows.
     * * Partitioned DML does not guarantee exactly-once execution semantics
     *   against a partition. The statement will be applied at least once to
     *   each partition. It is strongly recommended that the DML statement
     *   should be idempotent to avoid unexpected results. For instance, it is
     *   potentially dangerous to run a statement such as
     *   `UPDATE table SET column = column + 1` as it could be run multiple
     *   times against some rows.
     * * The partitions are committed automatically - there is no support for
     *   Commit or Rollback. If the call returns an error, or if the client
     *   issuing the DML statement dies, it is possible that some rows had the
     *   statement executed on them successfully. It is also possible that the
     *   statement was never executed against other rows.
     * * If any error is encountered during the execution of the partitioned
     *   DML operation (for instance, a UNIQUE INDEX violation, division by
     *   zero, or a value that cannot be stored due to schema constraints), then
     *   the operation is stopped at that point and an error is returned. It is
     *   possible that at this point, some partitions have been committed (or
     *   even committed multiple times), and other partitions have not been run
     *   at all.
     *
     * Given the above, Partitioned DML is good fit for large, database-wide,
     * operations that are idempotent, such as deleting old rows from a very
     * large table.
     *
     * Please refer to the TransactionOptions documentation referenced below in
     * order to fully understand the semantics and intended use case for
     * partitioned DML updates.
     *
     * Example:
     * ```
     * use Google\Cloud\Spanner\Date;
     *
     * $deactivatedUserCount = $database->executePartitionedUpdate(
     *     'UPDATE Users u SET u.activeSubscription = false, u.subscriptionEndDate = @date ' .
     *     'WHERE TIMESTAMP_DIFF(CURRENT_TIMESTAMP(), u.lastBillDate, DAY) > 365',
     *     [
     *         'parameters' => [
     *             'date' => new Date(new \DateTime)
     *         ]
     *     ]
     * );
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#google.spanner.v1.TransactionOptions TransactionOptions
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.ExecuteSqlRequest ExecuteSqlRequest
     * @codingStandardsIgnoreEnd
     *
     * @param string $statement The DML statement to execute.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type array $parameters A key/value array of Query Parameters, where
     *           the key is represented in the statement prefixed by a `@`
     *           symbol.
     *     @type array $types A key/value array of Query Parameter types.
     *           Generally, Google Cloud PHP can infer types. Explicit type
     *           declarations are required in the case of struct parameters,
     *           or when a null value exists as a parameter.
     *           Accepted values for primitive types are defined as constants on
     *           {@see Google\Cloud\Spanner\Database}, and are as follows:
     *           `Database::TYPE_BOOL`, `Database::TYPE_INT64`,
     *           `Database::TYPE_FLOAT64`, `Database::TYPE_TIMESTAMP`,
     *           `Database::TYPE_DATE`, `Database::TYPE_STRING`,
     *           `Database::TYPE_BYTES`. If the value is an array, use
     *           {@see Google\Cloud\Spanner\ArrayType} to declare the array
     *           parameter types. Likewise, for structs, use
     *           {@see Google\Cloud\Spanner\StructType}.
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for partitioned DML.
     * }
     * @return int The number of rows modified.
     */
    public function executePartitionedUpdate($statement, array $options = [])
    {
        unset($options['requestOptions']['transactionTag']);
        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READWRITE);

        $transaction = $this->operation->transaction($session, [
            'transactionOptions' => [
                'partitionedDml' => []
            ]
        ]);

        try {
            return $this->operation->executeUpdate($session, $transaction, $statement, [
                'statsItem' => 'rowCountLowerBound'
            ] + $options);
        } finally {
            $session->setExpiration();
        }
    }

    /**
     * Lookup rows in a table.
     *
     * Example:
     * ```
     * use Google\Cloud\Spanner\KeySet;
     *
     * $keySet = new KeySet([
     *     'keys' => [1337]
     * ]);
     *
     * $columns = ['ID', 'title', 'content'];
     *
     * $result = $database->read('Posts', $keySet, $columns);
     *
     * $firstRow = $result->rows()->current();
     * ```
     *
     * ```
     * // Execute a read and return a new Snapshot for further reads.
     * use Google\Cloud\Spanner\KeySet;
     * use Google\Cloud\Spanner\Session\SessionPoolInterface;
     *
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
     * use Google\Cloud\Spanner\KeySet;
     * use Google\Cloud\Spanner\Session\SessionPoolInterface;
     *
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
     *     @type array $sessionOptions Session configuration and request options.
     *           Session labels may be applied using the `labels` key.
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for read-only transactions.
     * }
     * @codingStandardsIgnoreEnd
     * @return Result
     */
    public function read($table, KeySet $keySet, array $columns, array $options = [])
    {
        unset($options['requestOptions']['transactionTag']);
        $session = $this->selectSession(
            SessionPoolInterface::CONTEXT_READ,
            $this->pluck('sessionOptions', $options, false) ?: []
        );

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
        //@codingStandardsIgnoreStart
        //@codeCoverageIgnoreStart
        } catch (\Exception $ex) {}
        //@codeCoverageIgnoreEnd
        //@codingStandardsIgnoreStart
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
        return $this->operation->createSession($this->name, $options);
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
     * @param string $sessionName The session's name.
     * @return Session
     */
    public function session($sessionName)
    {
        return $this->operation->session($sessionName);
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
     * Returns the underlying connection.
     *
     * @access private
     * @return ConnectionInterface
     * @experimental
     */
    public function connection()
    {
        return $this->connection;
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
            'session' => $this->session,
        ];
    }

    /**
     * If no session is already associated with the database use the session
     * pool implementation to retrieve a session one - otherwise create on
     * demand.
     *
     * @param string $context [optional] The session context. **Defaults to**
     *        `r` (READ).
     * @param array $options [optional] Configuration options.
     * @return Session
     */
    private function selectSession($context = SessionPoolInterface::CONTEXT_READ, array $options = [])
    {
        if ($this->session) {
            return $this->session;
        }

        if ($this->sessionPool) {
            return $this->session = $this->sessionPool->acquire($context);
        }

        return $this->session = $this->operation->createSession($this->name, $options);
    }

    /**
     * Common method to run mutations within a single-use transaction.
     *
     * @param array $mutations A list of mutations to execute.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use transactions.
     * }
     * @return Timestamp The commit timestamp.
     */
    private function commitInSingleUseTransaction(array $mutations, array $options = [])
    {
        unset($options['requestOptions']['transactionTag']);
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
        $instance = InstanceAdminClient::parseName($this->instance->name())['instance'];

        try {
            return GapicSpannerClient::databaseName(
                $this->projectId,
                $instance,
                $name
            );
        //@codeCoverageIgnoreStart
        } catch (ValidationException $e) {
            return $name;
        }
        //@codeCoverageIgnoreEnd
    }

    /**
     * Returns the 'CREATE DATABASE' statement as per the given database dialect
     * 
     * @param string $dialect The dialect of the database to be created
     * @return string The specific 'CREATE DATABASE' statement
     */
    private function getCreateDbStatement($dialect)
    {
        $databaseId = DatabaseAdminClient::parseName($this->name())['database'];

        if ($dialect === DatabaseDialect::POSTGRESQL) {
            return sprintf('CREATE DATABASE "%s"', $databaseId);
        }

        return sprintf('CREATE DATABASE `%s`', $databaseId);
    }
}
