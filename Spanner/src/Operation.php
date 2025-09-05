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

use Google\ApiCore\Options\CallOptions;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\RequestProcessorTrait;
use Google\Cloud\Spanner\Batch\QueryPartition;
use Google\Cloud\Spanner\Batch\ReadPartition;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\V1\BeginTransactionRequest;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\CommitRequest;
use Google\Cloud\Spanner\V1\CreateSessionRequest;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlRequest;
use Google\Cloud\Spanner\V1\ExecuteSqlRequest;
use Google\Cloud\Spanner\V1\PartitionOptions;
use Google\Cloud\Spanner\V1\PartitionQueryRequest;
use Google\Cloud\Spanner\V1\PartitionReadRequest;
use Google\Cloud\Spanner\V1\ReadRequest;
use Google\Cloud\Spanner\V1\RequestOptions;
use Google\Cloud\Spanner\V1\RollbackRequest;
use Google\Cloud\Spanner\V1\TransactionOptions;
use Google\Cloud\Spanner\V1\TransactionOptions\ReadWrite;
use Google\Cloud\Spanner\V1\TransactionSelector;
use Google\Cloud\Spanner\V1\Type;
use Google\Rpc\Code;
use GPBMetadata\Google\Protobuf\Struct;
use InvalidArgumentException;

/**
 * Common interface for running operations against Cloud Spanner. This class is
 * intended for internal use by the client library only. Implementors should
 * access these operations via {@see \Google\Cloud\Spanner\Database} or
 * {@see \Google\Cloud\Spanner\Transaction}.
 *
 * Usage examples may be found in classes making use of this class:
 * * {@see \Google\Cloud\Spanner\Database}
 * * {@see \Google\Cloud\Spanner\Transaction}
 */
class Operation
{
    use ApiHelperTrait;
    use RequestProcessorTrait;
    use MutationTrait;

    const OP_INSERT = 'insert';
    const OP_UPDATE = 'update';
    const OP_INSERT_OR_UPDATE = 'insertOrUpdate';
    const OP_REPLACE = 'replace';
    const OP_DELETE = 'delete';

    private ValueMapper $mapper;
    private bool $routeToLeader;
    private array $defaultQueryOptions;

    /**
     * @param SpannerClient $spannerClient The Spanner client used to make requests.
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param array $options {
     *     Configuration options.
     *
     *     @type bool $routeToLeader Enable/disable Leader Aware Routing.
     *         **Defaults to** `true` (enabled).
     *     @type array $defaultQueryOptions
     *     @type bool $returnInt64AsObject If true, 64 bit integers will be
     *        returned as a {@see \Google\Cloud\Core\Int64} object for 32 bit
     *        platform compatibility.
     * }
     */
    public function __construct(
        private SpannerClient $spannerClient,
        private Serializer $serializer,
        array $options = []
    ) {
        $options = $this->validateOptions(
            $options,
            ['returnInt64AsObject', 'routeToLeader', 'defaultQueryOptions']
        );
        $this->mapper = new ValueMapper($options['returnInt64AsObject'] ?? false);
        $this->routeToLeader = $options['routeToLeader'] ?? true;
        $this->defaultQueryOptions = $options['defaultQueryOptions'] ?? [];
    }

    /**
     * Commit all enqueued mutations.
     *
     * @codingStandardsIgnoreStart
     * @param Session $session The session ID to use for the commit.
     * @param array $mutations A list of mutations to apply.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $transactionId The ID of the transaction.
     *     @type bool $returnCommitStats If true, return the full response.
     *           **Defaults to** `false`.
     *     @type Duration $maxCommitDelay The amount of latency this request
     *           is willing to incur in order to improve throughput.
     *           **Defaults to** null.
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     * }
     * @return Timestamp The commit Timestamp.
     */
    public function commit(Session $session, array $mutations, array $options = []): Timestamp
    {
        return $this->commitWithResponse($session, $mutations, $options)[0];
    }

    /**
     * @internal
     *
     * Commit all enqueued mutations.
     *
     * @codingStandardsIgnoreStart
     * @param Session $session The session ID to use for the commit.
     * @param array $mutations A list of mutations to apply.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $transactionId The ID of the transaction.
     *     @type bool $returnCommitStats If true, return the full response.
     *           **Defaults to** `false`.
     *     @type Duration $maxCommitDelay The amount of latency this request
     *           is willing to incur in order to improve throughput.
     *           **Defaults to** null.
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     * }
     * @return array An array containing {@see \Google\Cloud\Spanner\Timestamp}
     *               at index 0 and the commit response as an array at index 1.
     */
    public function commitWithResponse(Session $session, array $mutations, array $options = []): array
    {
        $options += [
            'session' => $session->name(),
            'mutations' => $this->serializeMutations($mutations),
        ];
        [$commitRequest, $singleUse, $callOptions] = $this->validateOptions(
            $options,
            new CommitRequest(),
            ['singleUse'], // Internal flag, need to unset before passing to serializer
            CallOptions::class
        );

        // Configure Single Use Transaction options
        // @TODO: Find out why we do this
        if ($commitRequest->hasSingleUseTransaction()) {
            // This will clear any Transaction ID (because its a oneof)
            $commitRequest->setSingleUseTransaction(
                (new TransactionOptions())->setReadWrite(new ReadWrite())
            );
        }

        $response = $this->spannerClient->commit($commitRequest, $callOptions + [
            'resource-prefix' => $this->getDatabaseNameFromSession($session),
            'route-to-leader' => $this->routeToLeader
        ]);
        $timestamp = $response->getCommitTimestamp();

        return [
            new Timestamp(
                $this->createDateTimeFromSeconds($timestamp->getSeconds()),
                $timestamp->getNanos()
            ),
            $this->handleResponse($response)
        ];
    }

    /**
     * Rollback a Transaction.
     *
     * @param Session $session The session to use for the rollback.
     *        Note that the session MUST be the same one in which the
     *        transaction was created.
     * @param string $transactionId The transaction to roll back.
     * @param array $options [optional] Configuration Options.
     * @return void
     * @throws InvalidArgumentException If the transaction is not yet initialized.
     */
    public function rollback(
        Session $session,
        string|null $transactionId,
        array $options = []
    ): void {
        if (empty($transactionId)) {
            throw new InvalidArgumentException('Rollback failed: Transaction not initiated.');
        }

        [$callOptions, $unusedOptions] = $this->validateOptions(
            $options,
            CallOptions::class,
            ['transactionOptions']
        );
        $rollbackRequest = (new RollbackRequest())
            ->setSession($session->name())
            ->setTransactionId($transactionId);

        $this->spannerClient->rollback($rollbackRequest, $callOptions + [
            'resource-prefix' => $this->getDatabaseNameFromSession($session),
            'route-to-leader' => $this->routeToLeader
        ]);
    }

    /**
     * Run a query.
     *
     * @param Session $session The session to use to execute the SQL.
     * @param string $sql The query string.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *     @type array $transaction Transaction selector options.
     *     @type array $transaction.begin The begin transaction options.
     *           [Refer](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#transactionoptions)
     *     @type array $directedReadOptions Directed read options.
     *           {@see \Google\Cloud\Spanner\V1\DirectedReadOptions}
     *           If using the `replicaSelection::type` setting, utilize the constants available in
     *           {@see \Google\Cloud\Spanner\V1\DirectedReadOptions\ReplicaSelection\Type} to set a value.
     * }
     * @return Result
     */
    public function execute(Session $session, string $sql, array $options = []): Result
    {
        $options += $this->mapper->formatParamsForExecuteSql(
            $options['parameters'] ?? [],
            $options['types'] ?? []
        );

        $options = $this->formatSqlParams($options);
        $options['transaction'] = $this->createTransactionSelector($options);
        $options['queryOptions'] = $this->createQueryOptions($options);

        [$executeSqlRequest, $callOptions, $miscOptions, $rtl] = $this->validateOptions(
            $options,
            new ExecuteSqlRequest(),
            CallOptions::class,
            ['parameters', 'types', 'transactionContext'],
            ['route-to-leader']
        );
        $executeSqlRequest->setSql($sql);
        $executeSqlRequest->setSession($session->name());

        // Spanner allows "route-to-leader" as a call option (See SpannerMiddleware)
        // @TODO potentially move to a `Spanner\CallOptions`
        $callOptions += $rtl;

        // Initially with begin, transactionId will be null.
        // Once transaction is generated, even in the case of stream failure,
        // transaction will be passed to this callable by the Result class.
        $call = function ($resumeToken = null, $transaction = null) use (
            $session,
            $sql,
            $executeSqlRequest,
            $callOptions
        ) {
            if ($transaction && !empty($transaction->id())) {
                $executeSqlRequest->setTransaction(new TransactionSelector(['id' => $transaction->id()]));
            }
            if ($resumeToken) {
                $executeSqlRequest->setResumeToken($resumeToken);
            }

            $databaseName = $this->getDatabaseNameFromSession($session);
            return $this->executeStreamingSql($databaseName, $executeSqlRequest, $callOptions);
        };
        return new Result($this, $session, $call, $miscOptions['transactionContext'] ?? null, $this->mapper);
    }

    /**
     * Execute a DML statement and return an affected row count.
     *
     * @param Session $session The session in which the update operation should be executed.
     * @param Transaction $transaction The transaction in which the operation should be executed.
     * @param string $sql The SQL string to execute.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *     @type array $transaction Transaction selector options.
     *     @type array $transaction.begin The begin transaction options.
     *           [Refer](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#transactionoptions)
     * }
     * @return int
     * @throws InvalidArgumentException If the SQL string isn't an update operation.
     */
    public function executeUpdate(
        Session $session,
        Transaction $transaction,
        string $sql,
        array $options = []
    ): int {

        if (!isset($options['transaction']['begin'])) {
            $options['transaction'] = ['id' => $transaction->id()];
        }
        $statsItem = $options['statsItem'] ?? 'rowCountExact';
        unset($options['statsItem']);

        $res = $this->execute($session, $sql, $options);

        if (empty($transaction->id()) && $res->transaction()) {
            $transaction->setId($res->transaction()->id());
        }

        // Iterate through the result to ensure we have query statistics available.
        iterator_to_array($res->rows());

        $stats = $res->stats();
        if (!$stats) {
            throw new InvalidArgumentException(
                'Partitioned DML response missing stats, possible due to non-DML statement as input.'
            );
        }

        return $stats[$statsItem];
    }

    /**
     * Execute multiple DML statements.
     *
     * For detailed usage instructions, see
     * {@see \Google\Cloud\Spanner\Transaction::executeUpdateBatch()}.
     *
     * @param Session $session The session in which the update operation should
     *        be executed.
     * @param Transaction $transaction The transaction in which the operation
     *        should be executed.
     * @param array[] $statements A list of DML statements to run. Each statement
     *        must contain a `sql` key, where the value is a DML string. If the
     *        DML contains placeholders, values are provided as a key/value array
     *        in key `parameters`. If parameter types are required, they must be
     *        provided in key `paramTypes`. Generally, Google Cloud PHP can
     *        infer types. Explicit type declarations are required in the case
     *        of struct parameters, or when a null value exists as a parameter.
     *        Accepted values for primitive types are defined as constants on
     *        {@see \Google\Cloud\Spanner\Database}, and are as follows:
     *        `Database::TYPE_BOOL`, `Database::TYPE_INT64`,
     *        `Database::TYPE_FLOAT64`, `Database::TYPE_TIMESTAMP`,
     *        `Database::TYPE_DATE`, `Database::TYPE_STRING`,
     *        `Database::TYPE_BYTES`. If the value is an array, use
     *        {@see \Google\Cloud\Spanner\ArrayType} to declare the array
     *        parameter types. Likewise, for structs, use
     *        {@see \Google\Cloud\Spanner\StructType}.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *     @type array $transaction Transaction selector options.
     *     @type array $transaction.begin The begin transaction options.
     *           [Refer](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#transactionoptions)
     * }
     * @return BatchDmlResult
     * @throws InvalidArgumentException If any statement is missing the `sql` key.
     */
    public function executeUpdateBatch(
        Session $session,
        Transaction $transaction,
        array $statements,
        array $options = []
    ): BatchDmlResult {
        $options += [
            'session' => $session->name(),
            'statements' => $this->formatStatements($statements),
        ];
        $options['transaction'] = $this->createTransactionSelector($options, $transaction->id());

        [$dmlRequest, $callOptions] = $this->validateOptions(
            $options,
            new ExecuteBatchDmlRequest(),
            CallOptions::class
        );

        $response = $this->spannerClient->executeBatchDml($dmlRequest, $callOptions + [
            'resource-prefix' => $this->getDatabaseNameFromSession($session),
            'route-to-leader' => $this->routeToLeader
        ]);
        $res = $this->handleResponse($response);

        if (empty($transaction->id())) {
            // Get the transaction from array of ResultSets.
            // ResultSet contains transaction in the metadata.
            // @see https://cloud.google.com/spanner/docs/reference/rest/v1/ResultSet
            $transaction->setId($res['resultSets'][0]['metadata']['transaction']['id'] ?? null);
        }

        $errorStatement = null;
        if (isset($res['status']) && $res['status']['code'] !== Code::OK) {
            $errIndex = count($res['resultSets']);
            $errorStatement = $statements[$errIndex];
        }

        return new BatchDmlResult($res, $errorStatement);
    }

    /**
     * Lookup rows in a database.
     *
     * @param Session $session The session in which to read data.
     * @param string $table The table name.
     * @param KeySet $keySet The KeySet to select rows.
     * @param array $columns A list of column names to return.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $index The name of an index on the table.
     *     @type int $offset The number of rows to offset results by.
     *     @type int $limit The number of results to return.
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *     @type array $transaction Transaction selector options.
     *     @type array $transaction.begin The begin transaction options.
     *           [Refer](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#transactionoptions)
     *     @type array $directedReadOptions Directed read options.
     *           {@see \Google\Cloud\Spanner\V1\DirectedReadOptions}
     *           If using the `replicaSelection::type` setting, utilize the constants available in
     *           {@see \Google\Cloud\Spanner\V1\DirectedReadOptions\ReplicaSelection\Type} to set a value.
     * }
     * @return Result
     */
    public function read(
        Session $session,
        $table,
        KeySet $keySet,
        array $columns,
        array $options = []
    ): Result {
        $options['transaction'] = $this->createTransactionSelector($options);
        $options['keySet'] = $this->flattenKeySet($keySet);

        [$readRequest, $callOptions, $context, $rtl] = $this->validateOptions(
            $options,
            new ReadRequest(),
            CallOptions::class,
            ['transactionContext'],
            ['route-to-leader']
        );

        // Spanner allows "route-to-leader" as a call option {@see Middleware\SpannerMiddleware}
        $callOptions += $rtl;

        $call = function ($resumeToken = null, $transaction = null) use (
            $table,
            $session,
            $columns,
            $readRequest,
            $callOptions
        ) {
            if ($transaction && !empty($transaction->id())) {
                $readRequest->setTransaction(new TransactionSelector(['id' => $transaction->id()]));
            }
            if ($resumeToken) {
                $readRequest->setResumeToken($resumeToken);
            }

            $readRequest
                ->setTable($table)
                ->setSession($session->name())
                ->setColumns($columns);

            // return the generator
            return $this->streamingRead(
                $this->getDatabaseNameFromSession($session),
                $readRequest,
                $callOptions
            );
        };

        return new Result($this, $session, $call, $context['transactionContext'] ?? null, $this->mapper);
    }

    /**
     * Create a read/write transaction.
     *
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.BeginTransactionRequest BeginTransactionRequest
     *
     * @param Session $session The session to start the transaction in.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type bool $singleUse If true, a Transaction ID will not be allocated
     *           up front. Instead, the transaction will be considered
     *           "single-use", and may be used for only a single operation.
     *           **Defaults to** `false`.
     *     @type bool $isRetry If true, the resulting transaction will indicate
     *           that it is the result of a retry operation. **Defaults to**
     *           `false`.
     *     @type array $begin The begin transaction options.
     *           [Refer](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#transactionoptions)
     *     @type array $requestOptions
     *     @type array $transactionOptions
     *     @type string $tag
     * }
     * @return Transaction
     */
    public function transaction(Session $session, array $options = []): Transaction
    {
        [$options, $beginTransaction, $transactionSelector, $callOptions] = $this->validateOptions(
            $options,
            ['tag', 'isRetry', 'transactionOptions', 'singleUse'], // "singleUse" is an internal flag
            new BeginTransactionRequest(),
            new TransactionSelector(),
            CallOptions::class,
        );
        $transactionTag = $options['tag'] ?? null;
        $isRetry = $options['isRetry'] ?? false;
        // transaction options may be passed in as a message or array
        // TODO: only allow messages
        $transactionOptions = null;
        if (isset($options['transactionOptions'])) {
            $transactionOptions = is_array($options['transactionOptions'])
                ? $this->serializer->decodeMessage(
                    new TransactionOptions(),
                    $this->formatTransactionOptions($options['transactionOptions'])
                )
                : $options['transactionOptions'];
        }
        $res = [];
        if (empty($options['singleUse']) && (
            !$transactionSelector->hasBegin()
            || $transactionOptions?->hasPartitionedDml()
        )) {
            if (!$beginTransaction->hasRequestOptions()) {
                $beginTransaction->setRequestOptions(new RequestOptions());
            }
            if ($transactionTag) {
                $beginTransaction->getRequestOptions()->setTransactionTag($transactionTag);
            }
            if ($transactionOptions) {
                $beginTransaction->setOptions($transactionOptions);
            }

            $res = $this->beginTransaction($session, $beginTransaction, $callOptions);
        }

        $options = array_filter([
            'isRetry' => $isRetry,
            'tag' => $transactionTag,
            'begin' => $transactionSelector->getBegin(),
            'singleUse' => $options['singleUse'] ?? null,
            'requestOptions' => $beginTransaction->getRequestOptions(),
            'transactionOptions' => $transactionOptions,
        ]);
        return new Transaction(
            $this,
            $session,
            $res['id'] ?? null,
            $options,
            $this->mapper
        );
    }

    /**
     * Create a read-only snapshot transaction.
     *
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.BeginTransactionRequest BeginTransactionRequest
     *
     * @param Session $session The session to start the snapshot in.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type bool $singleUse If true, a Transaction ID will not be allocated
     *           up front. Instead, the transaction will be considered
     *           "single-use", and may be used for only a single operation.
     *           **Defaults to** `false`.
     *     @type string $className If set, an instance of the given class will
     *           be instantiated. This setting is intended for internal use.
     *           **Defaults to** `Google\Cloud\Spanner\Snapshot`.
     *     @type array|TransactionOptions $transactionOptions
     * }
     * @return TransactionalReadInterface
     */
    public function snapshot(Session $session, array $options = []): TransactionalReadInterface
    {
        [$beginTransaction, $callOptions, $misc] = $this->validateOptions(
            $options,
            new BeginTransactionRequest(),
            CallOptions::class,
            ['singleUse', 'className', 'transactionOptions']
        );
        if (isset($misc['transactionOptions'])) {
            $transactionOptions = is_array($misc['transactionOptions'])
                ? $this->serializer->decodeMessage(
                    new TransactionOptions(),
                    $this->formatTransactionOptions($misc['transactionOptions'])
                )
                : $misc['transactionOptions'];
            $beginTransaction->setOptions($transactionOptions);
            $options['transactionOptions'] = $transactionOptions;
        }

        $res = [];
        if (false === ($misc['singleUse'] ?? false)) {
            $res = $this->beginTransaction($session, $beginTransaction, $callOptions);
        }

        $snapshotClass = $misc['className'] ?? Snapshot::class;
        if (isset($res['readTimestamp'])) {
            if (!($res['readTimestamp'] instanceof Timestamp)) {
                $time = $this->parseTimeString($res['readTimestamp']);
                $res['readTimestamp'] = new Timestamp($time[0], $time[1]);
            }
        }

        return new $snapshotClass($this, $session, $res + $options);
    }

    /**
     * Create a new session.
     *
     * Sessions are handled behind the scenes and this method does not need to
     * be called directly.
     *
     * @param string $databaseName The database name
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $labels Labels to be applied to each session created in
     *           the pool. Label keys must be between 1 and 63 characters long
     *           and must conform to the following regular expression:
     *           `[a-z]([-a-z0-9]*[a-z0-9])?`. Label values must be between 0
     *           and 63 characters long and must conform to the regular
     *           expression `([a-z]([-a-z0-9]*[a-z0-9])?)?`. No more than 64
     *           labels can be associated with a given session. See
     *           https://goo.gl/xmQnxf for more information on and examples of
     *           labels.
     *     @type string $creator_role The user created database role which creates the session.
     * }
     * @return Session
     */
    public function createSession(string $databaseName, array $options = []): Session
    {
        [$options, $callOptions] = $this->validateOptions(
            $options,
            ['labels', 'creator_role'],
            CallOptions::class
        );
        $createSession = [
            'database' => $databaseName,
            'session' => [
                'labels' => $options['labels'] ?? [],
                'creator_role' => $options['creator_role'] ?? ''
        ]];

        $request = $this->serializer->decodeMessage(new CreateSessionRequest(), $createSession);

        $response = $this->spannerClient->createSession($request, $callOptions + [
            'resource-prefix' => $databaseName,
            'route-to-leader' => $this->routeToLeader
        ]);
        $res = $this->handleResponse($response);

        return $this->session($res['name']);
    }

    /**
     * Lazily instantiates a session. There are no network requests made at this
     * point. To see the operations that can be performed on a session please
     * see {@see \Google\Cloud\Spanner\Session\Session}.
     *
     * Sessions are handled behind the scenes and this method does not need to
     * be called directly.
     *
     * @param string $sessionName The session's name.
     * @return Session
     */
    public function session(string $sessionName): Session
    {
        $sessionNameComponents = SpannerClient::parseName($sessionName);
        return new Session(
            $this->spannerClient,
            $this->serializer,
            $sessionNameComponents['project'],
            $sessionNameComponents['instance'],
            $sessionNameComponents['database'],
            $sessionNameComponents['session'],
            ['routeToLeader' => $this->routeToLeader]
        );
    }

    /**
     * Begin a partitioned SQL query.
     *
     * @param Session $session The session to run in.
     * @param string $transactionId The transaction to run in.
     * @param string $sql The query string to execute.
     * @param array $options {
     *     Configuration Options
     *
     *     @type int $maxPartitions The desired maximum number of partitions to
     *           return. For example, this may be set to the number of workers
     *           available. The maximum value is currently 200,000. This is only
     *           a hint. The actual number of partitions returned may be smaller
     *           than this maximum count request. **Defaults to** `10000`.
     *     @type int $partitionSizeBytes The desired data size for each
     *           partition generated. This is only a hint. The actual size of
     *           each partition may be smaller or larger than this size request.
     *           **Defaults to** `1000000000` (i.e. 1 GiB).
     *     @type array $parameters A key/value array of Query Parameters, where
     *           the key is represented in the query string prefixed by a `@`
     *           symbol.
     *     @type array $types A key/value array of Query Parameter types.
     *           Generally, Google Cloud PHP can infer types. Explicit type
     *           definitions are only necessary for null parameter values.
     *           Accepted values are defined as constants on
     *           {@see \Google\Cloud\Spanner\ValueMapper}, and are as follows:
     *           `Database::TYPE_BOOL`, `Database::TYPE_INT64`,
     *           `Database::TYPE_FLOAT64`, `Database::TYPE_TIMESTAMP`,
     *           `Database::TYPE_DATE`, `Database::TYPE_STRING`,
     *           `Database::TYPE_BYTES`, `Database::TYPE_ARRAY` and
     *           `Database::TYPE_STRUCT`. If the parameter type is an array,
     *           the type should be given as an array, where the first element
     *           is `Database::TYPE_ARRAY` and the second element is the
     *           array type, for instance `[Database::TYPE_ARRAY, Database::TYPE_INT64]`.
     * }
     * @return QueryPartition[]
     */
    public function partitionQuery(
        Session $session,
        string $transactionId,
        string $sql,
        array $options = []
    ): array {
        $options += $this->formatPartitionQueryOptions([
            'parameters' => $options['parameters'] ?? null,
            'types' => $options['types'] ?? null,
        ]);
        $options['transaction'] = $this->createTransactionSelector($options, $transactionId);

        // Split all the options into their respective categories
        [$_paramsAndTypes, $partitionOptions, $partitionQuery, $_executeSql, $callOptions] = $this->validateOptions(
            $options,
            ['parameters', 'types'], // handled above, but define them here as well (so they're validated)
            new PartitionOptions(),
            new PartitionQueryRequest(),
            new ExecuteSqlRequest(), // these options are unused in this method, but are passed to QueryPartition
            CallOptions::class
        );

        $partitionQuery
            ->setSession($session->name())
            ->setSql($sql)
            ->setPartitionOptions($partitionOptions);

        $response = $this->spannerClient->partitionQuery($partitionQuery, $callOptions + [
            'resource-prefix' => $this->getDatabaseNameFromSession($session),
            'route-to-leader' => $this->routeToLeader
        ]);
        $res = $this->handleResponse($response);

        $partitions = [];
        $queryPartitionOptions = $this->pluckArray(['parameters', 'types', 'maxPartitions', 'partitionSizeBytes'], $options);
        foreach ($res['partitions'] as $partition) {
            $partitions[] = new QueryPartition(
                $partition['partitionToken'],
                $sql,
                $queryPartitionOptions
            );
        }

        return $partitions;
    }

    /**
     * Begin a partitioned read.
     *
     * @param Session $session The session to run in.
     * @param string $transactionId The transaction to run in.
     * @param string $table The table name.
     * @param KeySet $keySet The KeySet to select rows.
     * @param array $columns A list of column names to return.
     * @param array $options {
     *     Configuration Options
     *
     *     @type int $maxPartitions The desired maximum number of partitions to
     *           return. For example, this may be set to the number of workers
     *           available. The maximum value is currently 200,000. This is only
     *           a hint. The actual number of partitions returned may be smaller
     *           than this maximum count request. **Defaults to** `10000`.
     *     @type int $partitionSizeBytes The desired data size for each
     *           partition generated. This is only a hint. The actual size of
     *           each partition may be smaller or larger than this size request.
     *           **Defaults to** `1000000000` (i.e. 1 GiB).
     *     @type string $index The name of an index on the table.
     * }
     * @return ReadPartition[]
     */
    public function partitionRead(
        Session $session,
        string $transactionId,
        string $table,
        KeySet $keySet,
        array $columns,
        array $options = []
    ): array {
        $options['transaction'] = $this->createTransactionSelector($options, $transactionId);
        $options['columns'] = $columns;
        $options['keySet'] = $this->flattenKeySet($keySet);

        // Split all the options into their respective categories.
        // $readRequest is unused, but the options are valid because they're passed in to the
        // constructor of ReadPartition.
        [$partitionOptions, $partitionRead, $_readRequest, $callOptions] = $this->validateOptions(
            $options,
            new PartitionOptions(),
            new PartitionReadRequest(),
            new ReadRequest(), // these options are unused in this method, but are passed to ReadPartition
            CallOptions::class
        );

        $partitionRead->setSession($session->name());
        $partitionRead->setTable($table);
        $partitionRead->setPartitionOptions($partitionOptions);

        $response = $this->spannerClient->partitionRead($partitionRead, $callOptions + [
            'resource-prefix' => $this->getDatabaseNameFromSession($session),
            'route-to-leader' => $this->routeToLeader
        ]);
        $res = $this->handleResponse($response);

        $partitions = [];
        $readPartitionOptions = $this->pluckArray(['index', 'maxPartitions', 'partitionSizeBytes'], $options);
        foreach ($res['partitions'] as $partition) {
            $partitions[] = new ReadPartition(
                $partition['partitionToken'],
                $table,
                $keySet,
                $columns,
                $readPartitionOptions
            );
        }

        return $partitions;
    }

    /**
     * Execute a service call to begin a transaction or snapshot.
     *
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.BeginTransactionRequest BeginTransactionRequest
     *
     * @param Session $session The session to start the snapshot in.
     * @param BeginTransactionRequest $beginTransaction
     * @param array $callOptions
     *
     * @return array
     */
    private function beginTransaction(Session $session, BeginTransactionRequest $beginTransaction, array $callOptions): array
    {
        $routeToLeader = $this->routeToLeader && (
            $beginTransaction->getOptions()?->hasReadWrite()
            || $beginTransaction->getOptions()?->hasPartitionedDml()
        );

        if (!$beginTransaction->getSession()) {
            $beginTransaction->setSession($session->name());
        }

        $response = $this->spannerClient->beginTransaction($beginTransaction, $callOptions + [
            'resource-prefix' => $this->getDatabaseNameFromSession($session),
            'route-to-leader' => $routeToLeader,
        ]);
        return $this->handleResponse($response);
    }

    /**
     * Convert a KeySet object to an API-ready array.
     *
     * @param KeySet $keySet The keySet object.
     * @return array [KeySet](https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#keyset)
     */
    private function flattenKeySet(KeySet $keySet): array
    {
        $keys = $keySet->keySetObject();

        if (!empty($keys['ranges'])) {
            foreach ($keys['ranges'] as $index => $range) {
                foreach ($range as $type => $rangeKeys) {
                    $range[$type] = $this->mapper->encodeValuesAsSimpleType($rangeKeys);
                }

                $keys['ranges'][$index] = $range;
            }
        }

        if (!empty($keys['keys'])) {
            $keys['keys'] = $this->mapper->encodeValuesAsSimpleType($keys['keys'], true);
        }

        return $this->arrayFilterRemoveNull($keys);
    }

    private function getDatabaseNameFromSession(Session $session): string
    {
        return $session->info()['databaseName'];
    }

    /**
     * Serialize the mutations.
     *
     * @param array $mutations
     * @return array
     */
    private function serializeMutations(array $mutations): array
    {
        $serializedMutations = [];
        if (is_array($mutations)) {
            foreach ($mutations as $mutation) {
                $type = array_keys($mutation)[0];
                $data = $mutation[$type];

                switch ($type) {
                    case Operation::OP_DELETE:
                        // if (isset($data['keySet'])) {
                        //     $data['keySet'] = $this->formatKeySet($data['keySet']);
                        // }
                        break;
                    default:
                        $modifiedData = array_map([$this, 'formatValueForApi'], $data['values']);
                        $data['values'] = [['values' => $modifiedData]];

                        break;
                }

                $serializedMutations[] = [$type => $data];
            }
        }

        return $serializedMutations;
    }

    /**
     * Format statements.
     *
     * @param array $statements
     * @return array
     */
    private function formatStatements(array $statements): array
    {
        $result = [];
        foreach ($statements as $statement) {
            if (!isset($statement['sql'])) {
                throw new InvalidArgumentException('Each statement must contain a SQL key.');
            }

            $parameters = $statement['parameters'] ?? [];
            $types = $statement['types'] ?? [];
            $mappedStatement = [
                'sql' => $statement['sql']
            ] + $this->mapper->formatParamsForExecuteSql($parameters, $types);

            $result[] = $this->formatSqlParams($mappedStatement);
        }
        return $result;
    }

    /**
     * @param array $args
     * @return array
     */
    private function formatSqlParams(array $args): array
    {
        $params = $this->pluck('params', $args);
        if ($params) {
            $modifiedParams = array_map([$this, 'formatValueForApi'], $params);
            $args['params'] = ['fields' => $modifiedParams];
        }

        return $args;
    }

    /**
     * @param array $args
     * @param string|null $transactionId
     *
     * @return array
     */
    private function createTransactionSelector(
        array $args,
        string|null $transactionId = null
    ): array {
        if (isset($args['transaction'])) {
            $transactionSelector = $args['transaction'];

            if (isset($transactionSelector['singleUse'])) {
                $transactionSelector['singleUse'] =
                    $this->formatTransactionOptions($transactionSelector['singleUse']);
            }

            if (isset($transactionSelector['begin'])) {
                $transactionSelector['begin'] =
                    $this->formatTransactionOptions($transactionSelector['begin']);
            }
            return $transactionSelector;
        }

        if ($transactionId) {
            return ['id' => $transactionId];
        }

        return [];
    }

    /**
     * @param array $args
     *
     * @return array
     */
    private function createQueryOptions(array $args): array
    {
        $queryOptions = $this->pluck('queryOptions', $args, false) ?: [];
        // Query options precedence is query-level, then environment-level, then client-level.
        $envQueryOptimizerVersion = getenv('SPANNER_OPTIMIZER_VERSION');
        $envQueryOptimizerStatisticsPackage = getenv('SPANNER_OPTIMIZER_STATISTICS_PACKAGE');
        if (!empty($envQueryOptimizerVersion)) {
            $queryOptions += ['optimizerVersion' => $envQueryOptimizerVersion];
        }
        if (!empty($envQueryOptimizerStatisticsPackage)) {
            $queryOptions += ['optimizerStatisticsPackage' => $envQueryOptimizerStatisticsPackage];
        }
        $queryOptions += $this->defaultQueryOptions ?: [];

        return $queryOptions;
    }

    /**
     * @param array $transactionOptions
     * @return array
     */
    private function formatTransactionOptions(array $transactionOptions): array
    {
        // sometimes readOnly is a PBReadOnly message instance
        if (isset($transactionOptions['readOnly']) && is_array($transactionOptions['readOnly'])) {
            $ro = $transactionOptions['readOnly'];
            if (isset($ro['minReadTimestamp'])) {
                $ro['minReadTimestamp'] = $this->formatTimestampForApi($ro['minReadTimestamp']);
            }

            if (isset($ro['readTimestamp'])) {
                $ro['readTimestamp'] = $this->formatTimestampForApi($ro['readTimestamp']);
            }

            $transactionOptions['readOnly'] = $ro;
        }

        return $transactionOptions;
    }

    /**
     * @param string $databaseName
     * @param ExecuteSqlRequest $executeSqlRequest
     * @param array $callOptions
     * @return \Generator
     */
    private function executeStreamingSql(string $databaseName, ExecuteSqlRequest $executeSqlRequest, array $callOptions): \Generator
    {
        if (!$this->routeToLeader) {
            unset($callOptions['route-to-leader']);
        }

        $response = $this->spannerClient->executeStreamingSql($executeSqlRequest, $callOptions + [
            'resource-prefix' => $databaseName,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * @param string $databaseName
     * @param ReadRequest $readRequest
     * @param array $callOptions
     * @return \Generator
     */
    private function streamingRead(string $databaseName, ReadRequest $readRequest, array $callOptions): \Generator
    {
        if (!$this->routeToLeader) {
            unset($callOptions['route-to-leader']);
        }

        $response = $this->spannerClient->streamingRead($readRequest, $callOptions + [
            'resource-prefix' => $databaseName,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * @param array $args
     *
     * @return array{params: array, paramTypes: array}
     */
    private function formatPartitionQueryOptions(array $args): array
    {
        $parameters = $args['parameters'] ?? [];
        $types = $args['types'] ?? [];

        $paramsAndParamTypes = $this->mapper->formatParamsForExecuteSql($parameters, $types);
        return $this->formatSqlParams($paramsAndParamTypes);
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
        ];
    }
}
