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

use Closure;
use Google\ApiCore\ApiException;

use Google\ApiCore\RetrySettings;
use Google\ApiCore\ValidationException;
use Google\Cloud\Core\Exception\AbortedException;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\Iam\IamManager;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningClientConnection;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Retry;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\CreateDatabaseRequest;
use Google\Cloud\Spanner\Admin\Database\V1\Database\State;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseDialect;
use Google\Cloud\Spanner\Admin\Database\V1\DropDatabaseRequest;
use Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseDdlRequest;
use Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseRequest;
use Google\Cloud\Spanner\Admin\Database\V1\ListBackupOperationsRequest;
use Google\Cloud\Spanner\Admin\Database\V1\ListDatabaseOperationsRequest;
use Google\Cloud\Spanner\Admin\Database\V1\RestoreDatabaseRequest;
use Google\Cloud\Spanner\Admin\Database\V1\UpdateDatabaseDdlRequest;
use Google\Cloud\Spanner\Admin\Database\V1\UpdateDatabaseRequest;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\V1\BatchCreateSessionsRequest;
use Google\Cloud\Spanner\V1\BatchWriteRequest;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\DeleteSessionRequest;
use Google\Cloud\Spanner\V1\Mutation;
use Google\Cloud\Spanner\V1\Mutation\Delete;
use Google\Cloud\Spanner\V1\Mutation\Write;
use Google\Cloud\Spanner\V1\TypeCode;
use Google\LongRunning\ListOperationsRequest;
use Google\LongRunning\Operation as OperationProto;
use Google\Protobuf\Duration;
use Google\Protobuf\ListValue;
use Google\Protobuf\Struct;
use Google\Protobuf\Value;
use Google\Rpc\Code;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Represents a Cloud Spanner Database.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient(['projectId' => 'my-project']);
 *
 * $database = $spanner->connect('my-instance', 'my-database');
 * ```
 *
 * ```
 * // Databases can also be connected to via an Instance.
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient(['projectId' => 'my-project']);
 *
 * $instance = $spanner->instance('my-instance');
 * $database = $instance->database('my-database');
 * ```
 */
class Database
{
    use TransactionConfigurationTrait;
    use RequestTrait;

    const STATE_CREATING = State::CREATING;
    const STATE_READY = State::READY;
    const STATE_READY_OPTIMIZING = State::READY_OPTIMIZING;
    const MAX_RETRIES = 10;

    const TYPE_BOOL = TypeCode::BOOL;
    const TYPE_INT64 = TypeCode::INT64;
    const TYPE_FLOAT32 = TypeCode::FLOAT32;
    const TYPE_FLOAT64 = TypeCode::FLOAT64;
    const TYPE_TIMESTAMP = TypeCode::TIMESTAMP;
    const TYPE_DATE = TypeCode::DATE;
    const TYPE_STRING = TypeCode::STRING;
    const TYPE_BYTES = TypeCode::BYTES;
    const TYPE_ARRAY = TypeCode::PBARRAY;
    const TYPE_STRUCT = TypeCode::STRUCT;
    const TYPE_NUMERIC = TypeCode::NUMERIC;
    const TYPE_PROTO = TypeCode::PROTO;
    const TYPE_PG_NUMERIC = 'pgNumeric';
    const TYPE_PG_JSONB = 'pgJsonb';
    const TYPE_JSON = TypeCode::JSON;
    const TYPE_PG_OID = 'pgOid';
    const TYPE_INTERVAL = TypeCode::INTERVAL;

    /**
     * @var Operation
     */
    private $operation;

    /**
     * @var IamManager|null
     */
    private $iam;

    /**
     * @var Session|null
     */
    private $session;

    /**
     * @var bool
     */
    private bool $isRunningTransaction = false;

    /**
     * @var array
     */
    private array $directedReadOptions;

    /**
     * @var bool
     */
    private bool $routeToLeader;

    /**
     * @var array
     */
    private $defaultQueryOptions;

    private string $databaseRole;

    private bool $returnInt64AsObject;

    private ?SessionPoolInterface $sessionPool;

    private array $info;

    /**
     * @var array
     */
    private $mutationSetters = [
        'insert' => 'setInsert',
        'update' => 'setUpdate',
        'insertOrUpdate' => 'setInsertOrUpdate',
        'replace' => 'setReplace',
        'delete' => 'setDelete'
    ];

    /**
     * Create an object representing a Database.
     *
     * @internal Database is constructed by the {@see Instance} class.
     *
     * @param SpannerClient $spannerClient The Spanner client used to interact with the API.
     * @param DatabaseAdminClient $databaseAdminClient The database admin client used to interact with the API.
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param Instance $instance The instance in which the database exists.
     * @param string $projectId The project ID.
     * @param string $name The database name or ID.
     * @param string $options [Optional] {
     *     Database options.
     *
     *     @type bool $routeToLeader Enable/disable Leader Aware Routing.
     *         **Defaults to** `true` (enabled).
     *     @type array $defaultQueryOptions
     *     @type SessionPoolInterface $sessionPool The session pool
     *         implementation.
     *     @type bool $returnInt64AsObject If true, 64 bit integers will
     *         be returned as a {@see \Google\Cloud\Core\Int64} object for 32 bit
     *         platform compatibility. **Defaults to** false.
     *     @type string $databaseRole The user created database role which
     *         creates the session.
     *     @type array $database The database info.
     * }
     */
    public function __construct(
        private SpannerClient $spannerClient,
        private DatabaseAdminClient $databaseAdminClient,
        private Serializer $serializer,
        private Instance $instance,
        private string $projectId,
        private string $name,
        array $options = [],
    ) {
        $this->name = $this->fullyQualifiedDatabaseName($name);
        $this->routeToLeader = $options['routeToLeader'] ?? true;
        $this->defaultQueryOptions = $options['defaultQueryOptions'] ?? [];
        $this->databaseRole = $options['databaseRole'] ?? '';
        $this->returnInt64AsObject = $options['returnInt64AsObject'] ?? false;
        $this->sessionPool = $options['sessionPool'] ?? null;
        $this->info = $options['database'] ?? [];
        $this->operation = new Operation(
            $this->spannerClient,
            $serializer,
            [
                'routeToLeader' => $this->routeToLeader,
                'defaultQueryOptions' => $this->defaultQueryOptions,
                'returnInt64AsObject' => $this->returnInt64AsObject,
            ]
        );

        if ($this->sessionPool) {
            $this->sessionPool->setDatabase($this);
        }

        $this->directedReadOptions = $instance->directedReadOptions();
    }

    /**
     * Return the database state.
     *
     * When databases are created or restored, they may take some time before
     * they are ready for use. This method allows for checking whether a
     * database is ready. Note that this value is cached within the class instance,
     * so if you are polling it, first call {@see \Google\Cloud\Spanner\Database::reload()}
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
    public function state(array $options = []): ?int
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
    public function backups(array $options = []): ItemIterator
    {
        $filter = 'database:' . $this->name();

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
    public function createBackup(
        $name,
        \DateTimeInterface $expireTime,
        array $options = []
    ): LongRunningOperation {
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
    public function name(): string
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
    public function info(array $options = []): array
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
    public function reload(array $options = []): array
    {
        [$data, $callOptions] = $this->splitOptionalArgs($options);
        $data['name'] = $this->name;

        $request = $this->serializer->decodeMessage(new GetDatabaseRequest(), $data);

        $response = $this->databaseAdminClient->getDatabase($request, $callOptions + [
            'resource-prefix' => $this->name,
        ]);
        return $this->info = $this->handleResponse($response);
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
    public function exists(array $options = []): bool
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
     *     @type \Google\Protobuf\FileDescriptorSet|string $protoDescriptors The file
     *         descriptor set object to be used in the update, or alternatively, an absolute
     *         path to the generated file descriptor set. The descriptor set is only used
     *         during DDL statements, such as `CREATE PROTO BUNDLE`.
     * }
     * @return LongRunningOperation<Database>
     */
    public function create(array $options = []): LongRunningOperation
    {
        [$data, $callOptions] = $this->splitOptionalArgs($options);
        $dialect = $data['databaseDialect'] ?? DatabaseDialect::DATABASE_DIALECT_UNSPECIFIED;

        $data += [
            'parent' => $this->instance->name(),
            'createStatement' => $this->getCreateDbStatement($dialect),
            'extraStatements' => $this->pluck('statements', $data, false) ?: []
        ];

        $request = $this->serializer->decodeMessage(new CreateDatabaseRequest(), $data);
        $operation = $this->databaseAdminClient->createDatabase($request, $callOptions + [
            'resource-prefix' => $this->instance->name(),
        ]);
        return $this->operationFromOperationResponse($operation);
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
    public function restore($backup, array $options = []): LongRunningOperation
    {
        return $this->instance->createDatabaseFromBackup($this->name, $backup, $options);
    }

    /**
     * Update an existing Cloud Spanner database.
     *
     * Example:
     * ```
     * $operation = $database->updateDatabase(['enableDropProtection' => true]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.admin.database.v1#updatedatabaserequest UpdateDatabaseRequest
     * @codingStandardsIgnoreEnd
     *
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type bool $enableDropProtection If `true`, delete operations for Database
     *           and Instance will be blocked. **Defaults to** `false`.
     * }
     * @return LongRunningOperation<Database>
     */
    public function updateDatabase(array $options = []): LongRunningOperation
    {
        [$data, $callOptions] = $this->splitOptionalArgs($options);
        $fieldMask = [];

        if (isset($data['enableDropProtection'])) {
            $fieldMask[] = 'enable_drop_protection';
        }
        $data += [
            'updateMask' => ['paths' => $fieldMask],
            'database' => [
                'name' => $this->name,
                'enableDropProtection' =>
                    $this->pluck('enableDropProtection', $data, false) ?: false
            ]
        ];

        $request = $this->serializer->decodeMessage(new UpdateDatabaseRequest(), $data);

        $operation = $this->databaseAdminClient->updateDatabase($request, $callOptions + [
            'resource-prefix' => $this->name,
        ]);
        return $this->operationFromOperationResponse($operation);
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
     * @return LongRunningOperation<Database>
     */
    public function updateDdl($statement, array $options = []): LongRunningOperation
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
     * @return LongRunningOperation<void>
     */
    public function updateDdlBatch(array $statements, array $options = []): LongRunningOperation
    {
        [$data, $callOptions] = $this->splitOptionalArgs($options);
        $data += [
            'database' => $this->name,
            'statements' => $statements
        ];

        $request = $this->serializer->decodeMessage(new UpdateDatabaseDdlRequest(), $data);
        $operation = $this->databaseAdminClient->updateDatabaseDdl($request, $callOptions + [
            'resource-prefix' => $this->name
        ]);

        return $this->operationFromOperationResponse($operation);
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
    public function drop(array $options = []): void
    {
        [$data, $callOptions] = $this->splitOptionalArgs($options);
        $data['database'] = $this->name;

        $request = $this->serializer->decodeMessage(new DropDatabaseRequest(), $data);

        $this->databaseAdminClient->dropDatabase($request, $callOptions + [
            'resource-prefix' => $this->name
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
    public function ddl(array $options = []): array
    {
        [$data, $callOptions] = $this->splitOptionalArgs($options);
        $data['database'] = $this->name;

        $request = $this->serializer->decodeMessage(new GetDatabaseDdlRequest(), $data);

        $response = $this->databaseAdminClient->getDatabaseDdl($request, $callOptions + [
            'resource-prefix' => $this->name
        ]);
        $ddl = $this->handleResponse($response);

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
     * @return IamManager
     */
    public function iam()
    {
        if (!$this->iam) {
            $this->iam = new IamManager(
                new RequestHandler($this->serializer, [$this->databaseAdminClient]),
                $this->serializer,
                DatabaseAdminClient::class,
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
    public function snapshot(array $options = []): Snapshot
    {
        if ($this->isRunningTransaction) {
            throw new \BadMethodCallException('Nested transactions are not supported by this client.');
        }

        $options += [
            'singleUse' => false
        ];

        $options['transactionOptions'] = $this->configureReadOnlyTransactionOptions($options);

        // For backwards compatibility - remove all PBReadOnly fields
        // This was previously being done in configureReadOnlyTransactionOptions
        // @TODO: clean this up
        unset(
            $options['returnReadTimestamp'],
            $options['strong'],
            $options['readTimestamp'],
            $options['exactStaleness'],
            $options['minReadTimestamp'],
            $options['maxStaleness'],
        );

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
     * {@see \Google\Cloud\Core\Exception\AbortedException} is thrown.
     *
     * If you wish Google Cloud PHP to handle retry logic for you (recommended
     * for most cases), use {@see \Google\Cloud\Spanner\Database::runTransaction()}.
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
    public function transaction(array $options = []): Transaction
    {
        if ($this->isRunningTransaction) {
            throw new \BadMethodCallException('Nested transactions are not supported by this client.');
        }

        $options['transactionOptions'] = $this->configureReadWriteTransactionOptions();

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
     * {@see \Google\Cloud\Core\Exception\AbortedException} will be thrown. Any other
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
     * {@see \Google\Cloud\Spanner\Transaction::commit()} or
     * {@see \Google\Cloud\Spanner\Transaction::rollback()}, the transaction will
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
     *     @type RetrySettings|array $retrySettings {
     *           Retry configuration options. Currently, only the `maxRetries` option is supported.
     *
     *           @type int $maxRetries The maximum number of retry attempts before the operation fails.
     *                 Defaults to 10.
     *     }
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
        $options += ['retrySettings' => ['maxRetries' => self::MAX_RETRIES]];

        $retrySettings = $this->pluck('retrySettings', $options);
        if ($retrySettings instanceof RetrySettings) {
            $maxRetries = $retrySettings->getMaxRetries();
        } else {
            $maxRetries = $retrySettings['maxRetries'];
        }

        // There isn't anything configurable here.
        $options['transactionOptions'] = $this->configureReadWriteTransactionOptions(
            $options['transactionOptions'] ?? []
        );

        $session = $this->selectSession(
            SessionPoolInterface::CONTEXT_READWRITE,
            $this->pluck('sessionOptions', $options, false) ?: []
        );

        $attempt = 0;
        $startTransactionFn = function ($session, $options) use (&$attempt) {

            // Initial attempt requires to set `begin` options (ILB).
            if ($attempt === 0) {
                // Partitioned DML does not support ILB.
                if (!isset($options['transactionOptions']['partitionedDml'])) {
                    $options['begin'] = $options['transactionOptions'];
                }
            } else {
                $options['isRetry'] = true;
            }

            $transaction = $this->operation->transaction($session, $options);

            $attempt++;
            return $transaction;
        };

        $delayFn = function (\Exception $e) {
            if ($e instanceof AbortedException) {
                return $e->getRetryDelay();
            }
            if ($e instanceof ServiceException &&
                $e->getCode() === Code::INTERNAL &&
                strpos($e->getMessage(), 'RST_STREAM') !== false
            ) {
                return $e->getRetryDelay();
            }
            throw $e;
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

        $retry = new Retry($maxRetries, $delayFn);

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
     *         [RequestOptions](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use
     *         transactions.
     * }
     * @return Timestamp The commit Timestamp.
     */
    public function insert(string $table, array $data, array $options = []): Timestamp
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
     *         [RequestOptions](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use
     *         transactions.
     * }
     * @return Timestamp The commit Timestamp.
     */
    public function insertBatch(string $table, array $dataSet, array $options = []): Timestamp
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
     *         [RequestOptions](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use
     *         transactions.
     * }
     * @return Timestamp The commit Timestamp.
     */
    public function update(string $table, array $data, array $options = []): Timestamp
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
     *         [RequestOptions](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use
     *         transactions.
     * }
     * @return Timestamp The commit Timestamp.
     */
    public function updateBatch(string $table, array $dataSet, array $options = []): Timestamp
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
     *         [RequestOptions](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use
     *         transactions.
     * }
     * @return Timestamp The commit Timestamp.
     */
    public function insertOrUpdate(string $table, array $data, array $options = []): Timestamp
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
     *         [RequestOptions](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use
     *         transactions.
     * }
     * @return Timestamp The commit Timestamp.
     */
    public function insertOrUpdateBatch(string $table, array $dataSet, array $options = []): Timestamp
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
     *         [RequestOptions](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use
     *         transactions.
     * }
     * @return Timestamp The commit Timestamp.
     */
    public function replace(string $table, array $data, array $options = []): Timestamp
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
     *         [RequestOptions](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use
     *         transactions.
     * }
     * @return Timestamp The commit Timestamp.
     */
    public function replaceBatch($table, array $dataSet, array $options = []): Timestamp
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
     *         [RequestOptions](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use
     *         transactions.
     * }
     * @return Timestamp The commit Timestamp.
     */
    public function delete($table, KeySet $keySet, array $options = []): Timestamp
    {
        $mutations = [$this->operation->deleteMutation($table, $keySet)];

        return $this->commitInSingleUseTransaction($mutations, $options);
    }

    /**
     * Run a query.
     *
     * Google Cloud PHP will infer parameter types for all primitive types and
     * all values implementing {@see \Google\Cloud\Spanner\ValueInterface}, with
     * the exception of `null`. Non-associative arrays will be interpreted as
     * a Spanner ARRAY type, and must contain only a single type of value.
     * Associative arrays or values of type {@see \Google\Cloud\Spanner\StructValue}
     * will be interpreted as Spanner STRUCT type. Structs MUST always explicitly
     * define their field types.
     *
     * In any case where the value of a parameter may be `null`, you MUST
     * explicitly define the parameter's type.
     *
     * With the exception of arrays and structs, types are defined using a type
     * constant defined on {@see \Google\Cloud\Spanner\Database}. Examples include
     * but are not limited to `Database::TYPE_STRING` and `Database::TYPE_INT64`.
     *
     * Arrays, when explicitly typing, should use an instance of
     * {@see \Google\Cloud\Spanner\ArrayType} to declare their type and the types
     * of any values contained within the array elements.
     *
     * Structs must always declare their type using an instance of
     * {@see \Google\Cloud\Spanner\StructType}. Struct values may be expressed as
     * an associative array, however if the struct contains any unnamed fields,
     * or any fields with duplicate names, the struct must be expressed using an
     * instance of {@see \Google\Cloud\Spanner\StructValue}. Struct value types
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
     * // name, it must be defined using {@see \Google\Cloud\Spanner\StructValue}.
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
     *     'parameters' => [
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
     *     'parameters' => [
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
     *     See {@see V1\TransactionOptions\PBReadOnly} for detailed description of
     *     available transaction options. Please note that only one of
     *     `$strong`, `$minReadTimestamp`, `$maxStaleness`, `$readTimestamp` or
     *     `$exactStaleness` may be set in a request.
     *
     *     @type array $parameters A key/value array of Query Parameters, where
     *           the key is represented in the query string prefixed by a `@`
     *           symbol.
     *     @type array $types A key/value array of Query Parameter types.
     *           Generally, Google Cloud PHP can infer types. Explicit type
     *           declarations are required in the case of struct parameters,
     *           or when a null value exists as a parameter.
     *           Accepted values for primitive types are defined as constants on
     *           {@see \Google\Cloud\Spanner\Database}, and are as follows:
     *           `Database::TYPE_BOOL`, `Database::TYPE_INT64`,
     *           `Database::TYPE_FLOAT64`, `Database::TYPE_TIMESTAMP`,
     *           `Database::TYPE_DATE`, `Database::TYPE_STRING`,
     *           `Database::TYPE_BYTES`. If the value is an array, use
     *           {@see \Google\Cloud\Spanner\ArrayType} to declare the array
     *           parameter types. Likewise, for structs, use
     *           {@see \Google\Cloud\Spanner\StructType}.
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
     *           For more information on available options, please see
     *           [RequestOptions](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *           Please note, if using the `priority` setting you may utilize the constants available
     *           on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *           Please note, the `transactionTag` setting will be ignored as it is not supported for read-only
     *           transactions.
     *     @type array $directedReadOptions Directed read options.
     *           {@see \Google\Cloud\Spanner\V1\DirectedReadOptions}
     *           If using the `replicaSelection::type` setting, utilize the constants available in
     *           {@see \Google\Cloud\Spanner\V1\DirectedReadOptions\ReplicaSelection\Type} to set a value.
     * }
     * @codingStandardsIgnoreEnd
     * @return Result
     */
    public function execute($sql, array $options = []): Result
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

        $options['directedReadOptions'] = $this->configureDirectedReadOptions(
            $options,
            $this->directedReadOptions ?? []
        );

        try {
            // Unset the internal flag.
            unset($options['singleUse']);
            return $this->operation->execute($session, $sql, $options + [
                'route-to-leader' => $options['transactionContext'] === SessionPoolInterface::CONTEXT_READWRITE
            ]);
        } finally {
            $session->setExpiration();
        }
    }

    /**
     * Create a new {@see \Google\Cloud\Spanner\MutationGroup} object.
     *
     * @return MutationGroup
     */
    public function mutationGroup(): MutationGroup
    {
        return new MutationGroup($this->returnInt64AsObject);
    }

    /**
     * Batches the supplied mutation groups in a collection of efficient
     * transactions. All mutations in a group are committed atomically. However,
     * mutations across groups can be committed non-atomically in an unspecified
     * order and thus, they must be independent of each other. Partial failure is
     * possible, i.e., some groups may have been committed successfully, while
     * some may have failed. The results of individual batches are streamed into
     * the response as the batches are applied.
     *
     * BatchWrite requests are not replay protected, meaning that each mutation
     * group may be applied more than once. Replays of non-idempotent mutations
     * may have undesirable effects. For example, replays of an insert mutation
     * may produce an already exists error or if you use generated or commit
     * timestamp-based keys, it may result in additional rows being added to the
     * mutation's table. We recommend structuring your mutation groups to be
     * idempotent to avoid this issue.
     *
     * Sample code:
     * ```
     * ```
     *
     * @param array<MutationGroup> $mutationGroups Required. The groups of mutations to be applied.
     * @param array           $options   {
     *     Optional.
     *
     *     @type array $requestOptions
     *           Common options for this request.
     *     @type bool $excludeTxnFromChangeStreams
     *           Optional. When `exclude_txn_from_change_streams` is set to `true`:
     *           * Mutations from all transactions in this batch write operation will not
     *           be recorded in change streams with DDL option `allow_txn_exclusion=true`
     *           that are tracking columns modified by these transactions.
     *           * Mutations from all transactions in this batch write operation will be
     *           recorded in change streams with DDL option `allow_txn_exclusion=false or
     *           not set` that are tracking columns modified by these transactions.
     *
     *           When `exclude_txn_from_change_streams` is set to `false` or not set,
     *           mutations from all transactions in this batch write operation will be
     *           recorded in all change streams that are tracking columns modified by these
     *           transactions.
     * }
     *
     * @return \Generator {@see \Google\Cloud\Spanner\V1\BatchWriteResponse}
     *
     * @throws ApiException if the remote call fails
     */
    public function batchWrite(array $mutationGroups, array $options = []): \Generator
    {
        if ($this->isRunningTransaction) {
            throw new \BadMethodCallException('Nested transactions are not supported by this client.');
        }
        // Prevent nested transactions.
        $this->isRunningTransaction = true;
        $session = $this->selectSession(
            SessionPoolInterface::CONTEXT_READWRITE,
            $this->pluck('sessionOptions', $options, false) ?: []
        );

        $mutationGroups = array_map(fn ($x) => $x->toArray(), $mutationGroups);

        array_walk(
            $mutationGroups,
            fn (&$x) => $x['mutations'] = $this->parseMutations($x['mutations'])
        );

        try {
            [$data, $callOptions] = $this->splitOptionalArgs($options);
            $data += [
                'session' => $session->name(),
                'mutationGroups' => $mutationGroups
            ];

            $request = $this->serializer->decodeMessage(new BatchWriteRequest(), $data);

            $response = $this->spannerClient->batchWrite($request, $callOptions + [
                'resource-prefix' => $this->name,
                'route-to-leader' => $this->routeToLeader,
            ]);
            return $this->handleResponse($response);
        } finally {
            $this->isRunningTransaction = false;
            $session->setExpiration();
        }
    }

    /**
     * Execute a partitioned DML update.
     *
     * Returns the lower bound of rows modified by the DML statement.
     *
     * **PLEASE NOTE** Most use cases for DML are better served by using
     * {@see \Google\Cloud\Spanner\Transaction::executeUpdate()}. Please read and
     * understand the documentation for partitioned DML before implementing it
     * in your application.
     *
     * Data Manipulation Language (DML) allows you to execute statements which
     * modify the state of the database (i.e. inserting, updating or deleting
     * rows).
     *
     * To execute a SELECT statement, use
     * {@see \Google\Cloud\Spanner\Database::execute()}.
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
     * {@see \Google\Cloud\Spanner\Transaction::executeUpdate()}.
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
     *           {@see \Google\Cloud\Spanner\Database}, and are as follows:
     *           `Database::TYPE_BOOL`, `Database::TYPE_INT64`,
     *           `Database::TYPE_FLOAT64`, `Database::TYPE_TIMESTAMP`,
     *           `Database::TYPE_DATE`, `Database::TYPE_STRING`,
     *           `Database::TYPE_BYTES`. If the value is an array, use
     *           {@see \Google\Cloud\Spanner\ArrayType} to declare the array
     *           parameter types. Likewise, for structs, use
     *           {@see \Google\Cloud\Spanner\StructType}.
     *     @type array $requestOptions Request options.
     *           For more information on available options, please see
     *           [RequestOptions](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *           Please note, if using the `priority` setting you may utilize the constants available
     *           on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *           Please note, the `transactionTag` setting will be ignored as it is not supported for partitioned DML.
     *     @type array $transactionOptions Transaction options ({@see V1\TransactionOptions}).
     * }
     * @return int The number of rows modified.
     */
    public function executePartitionedUpdate($statement, array $options = []): int
    {
        unset($options['requestOptions']['transactionTag']);
        $session = $this->selectSession(SessionPoolInterface::CONTEXT_READWRITE);

        $beginTransactionOptions = [
            'transactionOptions' => [
                'partitionedDml' => [],
            ]
        ];
        if (isset($options['transactionOptions']['excludeTxnFromChangeStreams'])) {
            $beginTransactionOptions['transactionOptions']['excludeTxnFromChangeStreams'] =
                $options['transactionOptions']['excludeTxnFromChangeStreams'];
            unset($options['transactionOptions']);
        }
        $transaction = $this->operation->transaction($session, $beginTransactionOptions);

        try {
            return $this->operation->executeUpdate($session, $transaction, $statement, [
                'statsItem' => 'rowCountLowerBound',
                'route-to-leader' => true,
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
     *           For more information on available options, please see
     *           [RequestOptions](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *           Please note, if using the `priority` setting you may utilize the constants available
     *           on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *           Please note, the `transactionTag` setting will be ignored as it is not supported for read-only transactions.
     *     @type array $directedReadOptions Directed read options.
     *           {@see \Google\Cloud\Spanner\V1\DirectedReadOptions}
     *           If using the `replicaSelection::type` setting, utilize the constants available in
     *           {@see \Google\Cloud\Spanner\V1\DirectedReadOptions\ReplicaSelection\Type} to set a value.
     *     @type int $orderBy Set the OrderBy option for the ReadRequest.
     *           {@see \Google\Cloud\Spanner\V1\ReadRequest} and {@see \Google\Cloud\Spanner\V1\ReadRequest\OrderBy}
     *           for more information and available options.
     *     @type int $lockHint Set the LockHint option for the ReadRequest.
     *           {@see \Google\Cloud\Spanner\V1\ReadRequest} and {@see \Google\Cloud\Spanner\V1\ReadRequest\LockHint}
     *           for more information and available options.
     * }
     * @codingStandardsIgnoreEnd
     * @return Result
     */
    public function read($table, KeySet $keySet, array $columns, array $options = []): Result
    {
        unset($options['requestOptions']['transactionTag']);
        $session = $this->selectSession(
            SessionPoolInterface::CONTEXT_READ,
            $this->pluck('sessionOptions', $options, false) ?: []
        );

        list($transactionOptions, $context) = $this->transactionSelector($options);
        $options['transaction'] = $transactionOptions;
        $options['transactionContext'] = $context;

        $options['directedReadOptions'] = $this->configureDirectedReadOptions(
            $options,
            $this->directedReadOptions ?? []
        );

        try {
            // Unset the internal flag.
            unset($options['singleUse']);
            return $this->operation->read($session, $table, $keySet, $columns, $options + [
                'route-to-leader' => $context === SessionPoolInterface::CONTEXT_READ
            ]);
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
    public function sessionPool(): ?SessionPoolInterface
    {
        return $this->sessionPool;
    }

    /**
     * Closes the database connection by returning the active session back to
     * the session pool queue or by deleting the session if there is no pool
     * associated.
     *
     * It is highly important to ensure this is called as it is not always safe
     * to rely soley on {@see \Google\Cloud\Spanner\Database::__destruct()}.
     *
     * Example:
     * ```
     * $database->close();
     * ```
     */
    public function close(): void
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
        } catch (\Exception $ex) {
        }
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
    public function createSession(array $options = []): Session
    {
        return $this->operation->createSession($this->name, $options);
    }

    /**
     * Lazily instantiates a session. There are no network requests made at this
     * point. To see the operations that can be performed on a session please
     * see {@see \Google\Cloud\Spanner\Session\Session}.
     *
     * Sessions are handled behind the scenes and this method does not need to
     * be called directly.
     *
     * @access private
     * @param string $sessionName The session's name.
     * @return Session
     */
    public function session(string $sessionName): Session
    {
        return $this->operation->session($sessionName);
    }

    /**
     * Retrieves the database's identity.
     *
     * @access private
     * @return array
     */
    public function identity(): array
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
     * Creates a batch of sessions.
     *
     * @param array $options {
     *     @type array $sessionTemplate
     *     @type int $sessionCount
     * }
     */
    public function batchCreateSessions(array $options): array
    {
        [$data, $callOptions] = $this->splitOptionalArgs($options);
        $data['database'] = $this->name;

        $request = $this->serializer->decodeMessage(new BatchCreateSessionsRequest(), $data);
        $response = $this->spannerClient->batchCreateSessions($request, $callOptions + [
            'resource-prefix' => $this->name,
            'route-to-leader' => $this->routeToLeader
        ]);
        return $this->handleResponse($response);
    }

    /**
     * Delete session asynchronously.
     *
     * @access private
     * @param array $options {
     *     @type name The session name to be deleted
     * }
     * @return PromiseInterface<void>
     * @experimental
     */
    public function deleteSessionAsync(array $options): PromiseInterface
    {
        [$data, $callOptions] = $this->splitOptionalArgs($options);

        $request = $this->serializer->decodeMessage(new DeleteSessionRequest(), $data);
        return $this->spannerClient->deleteSessionAsync($request, $callOptions + [
            'resource-prefix' => $this->name
        ]);
    }

    /**
     * Lists backup operations.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     * }
     *
     * @return ItemIterator<LongRunningOperation>
     */
    public function backupOperations(array $options = []): ItemIterator
    {
        [$data, $callOptions] = $this->splitOptionalArgs($options);
        $request = $this->serializer->decodeMessage(new ListBackupOperationsRequest(), $data);
        $request->setParent($this->instance->name());

        return $this->buildLongRunningIterator(
            [$this->databaseAdminClient, 'listBackupOperations'],
            $request,
            $callOptions +  ['resource-prefix' => $this->name],
            $this->getResultMapper()
        );
    }

    /**
     * Create a database from a backup.
     *
     * @param string $name The database name.
     * @param Backup|string $backup The backup to restore, given
     *        as a Backup instance or a string of the form
     *        `projects/<project>/instances/<instance>/backups/<backup>`.
     * @param array $options [optional] Configuration options.
     *
     * @return LongRunningOperation
     */
    public function createDatabaseFromBackup($name, $backup, array $options = []): LongRunningOperation
    {
        [$data, $callOptions] = $this->splitOptionalArgs($options);
        $data += [
            'parent' => $this->instance->name(),
            'databaseId' => $this->databaseIdOnly($name),
            'backup' => $backup instanceof Backup ? $backup->name() : $backup
        ];

        $request = $this->serializer->decodeMessage(new RestoreDatabaseRequest(), $data);
        $operation = $this->databaseAdminClient->restoreDatabase($request, $callOptions + [
            'resource-prefix' => $this->name
        ]);

        return $this->operationFromOperationResponse($operation);
    }

    /**
     * Lists database operations.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     * }
     *
     * @return ItemIterator<LongRunningOperation>
     */
    public function databaseOperations(array $options = []): ItemIterator
    {
        [$data, $callOptions] = $this->splitOptionalArgs($options);
        $request = $this->serializer->decodeMessage(new ListDatabaseOperationsRequest(), $data);
        $request->setParent($this->instance->name());

        return $this->buildLongRunningIterator(
            [$this->databaseAdminClient, 'listDatabaseOperations'],
            $request,
            $callOptions + ['resource-prefix' => $this->name],
            $this->getResultMapper()
        );
    }

    /**
     * Resume a Long Running Operation
     *
     * Example:
     * ```
     * $operation = $database->resumeOperation($operationName);
     * ```
     *
     * @param string $operationName The Long Running Operation name.
     * @return LongRunningOperation
     */
    public function resumeOperation($operationName, array $options = []): LongRunningOperation
    {
        return new LongRunningOperation(
            new LongRunningClientConnection($this->databaseAdminClient, $this->serializer),
            $operationName,
            [
                [
                    'typeUrl' => 'type.googleapis.com/google.spanner.admin.database.v1.CreateDatabaseMetadata',
                    'callable' => $this->databaseResultFunction(),
                ],
                [
                    'typeUrl' => 'type.googleapis.com/google.spanner.admin.database.v1.RestoreDatabaseMetadata',
                    'callable' => $this->databaseResultFunction(),
                ]
            ],
            $options
        );
    }

    /**
     * List long running operations.
     *
     * Example:
     * ```
     * $operations = $database->longRunningOperations();
     * ```
     *
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $name The name of the operation collection.
     *     @type string $filter The standard list filter.
     *     @type int $pageSize Maximum number of results to return per
     *           request.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<LongRunningOperation>
     */
    public function longRunningOperations(array $options = []): ItemIterator
    {
        [$data, $callOptions] = $this->splitOptionalArgs($options);
        $request = $this->serializer->decodeMessage(new ListOperationsRequest(), $data);
        $request->setName($this->name . '/operations');

        return $this->buildLongRunningIterator(
            [$this->databaseAdminClient->getOperationsClient(), 'listOperations'],
            $request,
            $callOptions,
            $this->getResultMapper()
        );
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
    private function selectSession(
        $context = SessionPoolInterface::CONTEXT_READ,
        array $options = []
    ): Session {
        if ($this->session) {
            return $this->session;
        }

        if ($this->sessionPool) {
            return $this->session = $this->sessionPool->acquire($context);
        }

        if ($this->databaseRole !== null) {
            $options['creator_role'] = $this->databaseRole;
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
     *         [RequestOptions](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as it is not supported for single-use transactions.
     * }
     * @return Timestamp The commit timestamp.
     */
    private function commitInSingleUseTransaction(array $mutations, array $options = []): Timestamp
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
    private function fullyQualifiedDatabaseName($name): string
    {
        $instance = DatabaseAdminClient::parseName($this->instance->name())['instance'];

        try {
            return SpannerClient::databaseName(
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
     * @param int $dialect The dialect of the database to be created
     * @return string The specific 'CREATE DATABASE' statement
     */
    private function getCreateDbStatement(int $dialect): string
    {
        $databaseId = DatabaseAdminClient::parseName($this->name())['database'];

        if ($dialect === DatabaseDialect::POSTGRESQL) {
            return sprintf('CREATE DATABASE "%s"', $databaseId);
        }

        return sprintf('CREATE DATABASE `%s`', $databaseId);
    }

    /**
     * Extracts a database id from fully qualified name.
     *
     * @param string $name The database name or id.
     * @return string
     */
    private function databaseIdOnly(string $name): string
    {
        try {
            return DatabaseAdminClient::parseName($name)['database'];
        } catch (ValidationException $e) {
            return $name;
        }
    }

    private function parseMutations(array $rawMutations): array
    {
        if (!is_array($rawMutations)) {
            return [];
        }

        $mutations = [];
        foreach ($rawMutations as $mutation) {
            $type = array_keys($mutation)[0];
            $data = $mutation[$type];

            switch ($type) {
                case Operation::OP_DELETE:
                    $operation = $this->serializer->decodeMessage(
                        new Delete(),
                        $data
                    );
                    break;
                default:
                    $operation = new Write();
                    $operation->setTable($data['table']);
                    $operation->setColumns($data['columns']);

                    $modifiedData = [];
                    foreach ($data['values'] as $key => $param) {
                        $modifiedData[$key] = $this->fieldValue($param);
                    }

                    $list = new ListValue();
                    $list->setValues($modifiedData);
                    $values = [$list];
                    $operation->setValues($values);

                    break;
            }

            $setterName = $this->mutationSetters[$type];
            $mutation = new Mutation();
            $mutation->$setterName($operation);
            $mutations[] = $mutation;
        }
        return $mutations;
    }

    /**
     * @param mixed $param
     * @return Value
     */
    private function fieldValue($param): Value
    {
        $field = new Value();
        $value = $this->formatValueForApi($param);

        $setter = null;
        switch (array_keys($value)[0]) {
            case 'string_value':
                $setter = 'setStringValue';
                break;
            case 'number_value':
                $setter = 'setNumberValue';
                break;
            case 'bool_value':
                $setter = 'setBoolValue';
                break;
            case 'null_value':
                $setter = 'setNullValue';
                break;
            case 'struct_value':
                $setter = 'setStructValue';
                $modifiedParams = [];
                foreach ($param as $key => $value) {
                    $modifiedParams[$key] = $this->fieldValue($value);
                }
                $value = new Struct();
                $value->setFields($modifiedParams);

                break;
            case 'list_value':
                $setter = 'setListValue';
                $modifiedParams = [];
                foreach ($param as $item) {
                    $modifiedParams[] = $this->fieldValue($item);
                }
                $list = new ListValue();
                $list->setValues($modifiedParams);
                $value = $list;

                break;
        }

        $value = is_array($value) ? current($value) : $value;
        if ($setter) {
            $field->$setter($value);
        }

        return $field;
    }

    private function databaseResultFunction(): Closure
    {
        return function (array $database): self {
            $name = DatabaseAdminClient::parseName($database['name']);
            return $this->instance->database($name['database'], [
                'sessionPool' => $this->sessionPool,
                'database' => $database,
                'databaseRole' => $this->databaseRole,
            ]);
        };
    }

    private function getResultMapper()
    {
        return function (OperationProto $operation) {
            return $this->resumeOperation(
                $operation->getName(),
                $this->handleResponse($operation)
            );
        };
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
            'spannerClient' => get_class($this->spannerClient),
            'databaseAdminClient' => get_class($this->databaseAdminClient),
            'projectId' => $this->projectId,
            'name' => $this->name,
            'instance' => $this->instance,
            'sessionPool' => $this->sessionPool,
            'session' => $this->session,
        ];
    }
}
