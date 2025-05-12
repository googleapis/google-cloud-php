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
use Google\Cloud\Spanner\Session\SessionCache;
use Google\Cloud\Spanner\V1\BeginTransactionRequest;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\CommitRequest;
use Google\Cloud\Spanner\V1\CommitResponse;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlRequest;
use Google\Cloud\Spanner\V1\ExecuteSqlRequest;
use Google\Cloud\Spanner\V1\PartitionQueryRequest;
use Google\Cloud\Spanner\V1\PartitionReadRequest;
use Google\Cloud\Spanner\V1\ReadRequest;
use Google\Cloud\Spanner\V1\RollbackRequest;
use Google\Cloud\Spanner\V1\Transaction as TransactionProto;
use Google\Cloud\Spanner\V1\Type;
use Google\Cloud\Spanner\V1\TransactionSelector;
use Google\Protobuf\Duration;
use Google\Rpc\Code;
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
     * @internal
     *
     * Commit all enqueued mutations.
     *
     * @codingStandardsIgnoreStart
     * @param SessionCache $session The session ID to use for the commit.
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
     *     @type MultiplexedSessionPrecommitToken $precommitToken the precommit token with the
     *         highest sequence number received in this transaction attempt.
     * }
     * @return CommitResponse
     */
    public function commit(SessionCache $session, array $mutations, array $options = []): CommitResponse
    {
        [$commitRequest, $_singleUse, $callOptions] = $this->validateOptions(
            $options,
            CommitRequest::class,
            ['singleUse'], // Internal flag, need to unset before passing to serializer
            CallOptions::class
        );

        $mutations = $this->serializeMutations($mutations);
        $commitRequest += [
            'session' => $session->name(),
            'mutations' => $mutations
        ];

        // Configure Single Use Transaction options
        // @TODO: Find out why we do this
        if (isset($commitRequest['singleUseTransaction'])) {
            $commitRequest['singleUseTransaction'] = ['readWrite' => []];
            // CommitRequest ignores singleUseTransaction if the transactionId is set
            unset($commitRequest['transactionId']);
        }

        $request = $this->serializer->decodeMessage(new CommitRequest(), $commitRequest);

        do {
            $precommitToken = null;
            $response = $this->spannerClient->commit($request, $callOptions + [
                'resource-prefix' => $this->getDatabaseNameFromSession($session),
                'route-to-leader' => $this->routeToLeader
            ]);
            if ($precommitToken = $response->getPrecommitToken()) {
                $request->setPrecommitToken($precommitToken);
            }
        } while ($precommitToken); // if a precommit token exists in the response, retry the request

        return $response;
    }

    /**
     * Rollback a Transaction.
     *
     * @param SessionCache $session The session to use for the rollback.
     *        Note that the session MUST be the same one in which the
     *        transaction was created.
     * @param string $transactionId The transaction to roll back.
     * @param array $options [optional] Configuration Options.
     * @return void
     * @throws InvalidArgumentException If the transaction is not yet initialized.
     */
    public function rollback(
        SessionCache $session,
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
        $rollbackRequest = [
            'session' => $session->name(),
            'transactionId' => $transactionId
        ];

        $request = $this->serializer->decodeMessage(new RollbackRequest(), $rollbackRequest);
        $this->spannerClient->rollback($request, $callOptions + [
            'resource-prefix' => $this->getDatabaseNameFromSession($session),
            'route-to-leader' => $this->routeToLeader
        ]);
    }

    /**
     * Run a query.
     *
     * @param SessionCache $session The session to use to execute the SQL.
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
    public function execute(SessionCache $session, string $sql, array $options = []): Result
    {
        [$executeSqlRequest, $callOptions, $options, $rtl] = $this->validateOptions(
            $options,
            ExecuteSqlRequest::class,
            CallOptions::class,
            ['parameters', 'types', 'transactionContext'],
            ['route-to-leader']
        );

        // Spanner allows "route-to-leader" as a call option (See SpannerMiddleware)
        $callOptions += $rtl;

        $executeSqlRequest += $this->mapper->formatParamsForExecuteSql(
            $options['parameters'] ?? [],
            $options['types'] ?? []
        );

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
                $executeSqlRequest['transaction'] = ['id' => $transaction->id()];
            }
            if ($resumeToken) {
                $executeSqlRequest['resumeToken'] = $resumeToken;
            }

            $databaseName = $this->getDatabaseNameFromSession($session);

            return $this->executeStreamingSql($databaseName, [
                'sql' => $sql,
                'session' => $session->name(),
            ] + $executeSqlRequest, $callOptions);
        };
        return new Result($this, $session, $call, $options['transactionContext'] ?? null, $this->mapper);
    }

    /**
     * Execute a DML statement and return an affected row count.
     *
     * @param SessionCache $session The session in which the update operation should be executed.
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
        SessionCache $session,
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
     * @param SessionCache $session The session in which the update operation should
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
        SessionCache $session,
        Transaction $transaction,
        array $statements,
        array $options = []
    ): BatchDmlResult {
        [$dmlRequest, $callOptions] = $this->validateOptions(
            $options,
            ExecuteBatchDmlRequest::class,
            CallOptions::class
        );

        $dmlRequest['transaction'] = $this->createTransactionSelector($dmlRequest, $transaction->id());
        $dmlRequest += [
            'session' => $session->name(),
            'statements' => $this->formatStatements($statements)
        ];

        $request = $this->serializer->decodeMessage(new ExecuteBatchDmlRequest(), $dmlRequest);
        $response = $this->spannerClient->executeBatchDml($request, $callOptions + [
            'resource-prefix' => $this->getDatabaseNameFromSession($session),
            'route-to-leader' => $this->routeToLeader
        ]);
        if ($precommitToken = $response->getPrecommitToken()) {
            $transaction->setPrecommitToken($precommitToken);
        }
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
     * @param SessionCache $session The session in which to read data.
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
        SessionCache $session,
        $table,
        KeySet $keySet,
        array $columns,
        array $options = []
    ): Result {
        [$readRequest, $callOptions, $context, $rtl] = $this->validateOptions(
            $options,
            ReadRequest::class,
            CallOptions::class,
            ['transactionContext'],
            ['route-to-leader']
        );

        // Spanner allows "route-to-leader" as a call option (See SpannerMiddleware)
        $callOptions += $rtl;

        $call = function ($resumeToken = null, $transaction = null) use (
            $table,
            $session,
            $columns,
            $keySet,
            $readRequest,
            $callOptions
        ) {
            if ($transaction && !empty($transaction->id())) {
                $readRequest['transaction'] = ['id' => $transaction->id()];
            }
            if ($resumeToken) {
                $readRequest['resumeToken'] = $resumeToken;
            }

            return $this->streamingRead([
                'table' => $table,
                'session' => $session->name(),
                'columns' => $columns,
                'keySet' => $this->flattenKeySet($keySet),
                'database' => $this->getDatabaseNameFromSession($session)
            ] + $readRequest, $callOptions);
        };

        return new Result($this, $session, $call, $context['transactionContext'] ?? null, $this->mapper);
    }

    /**
     * Create a read/write transaction.
     *
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.BeginTransactionRequest BeginTransactionRequest
     *
     * @param SessionCache $session The session to start the transaction in.
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
     *     @type string $tag
     * }
     * @return Transaction
     */
    public function transaction(SessionCache $session, array $options = []): Transaction
    {
        [$beginTransaction, $transactionSelector, $callOptions, $misc] = $this->validateOptions(
            $options,
            BeginTransactionRequest::class,
            TransactionSelector::class,
            CallOptions::class,
            ['tag', 'isRetry', 'transactionOptions']
        );

        $id = null;
        $precommitToken = null;
        $transactionTag = $misc['tag'] ?? null;
        // Do not execute beginTransaction for single use or inline begin transactions
        // @TODO: Figure out why we check for `transactionOptions.partitionedDml`
        if (empty($transactionSelector['singleUse']) && (
            !isset($transactionSelector['begin'])
            || isset($misc['transactionOptions']['partitionedDml'])
        )) {
            $beginTransaction += ['requestOptions' => []];
            if ($transactionTag) {
                $beginTransaction['requestOptions']['transactionTag'] = $transactionTag;
            }
            if (isset($misc['transactionOptions'])) {
                $beginTransaction['options'] = $this->formatTransactionOptions($misc['transactionOptions']);
            }

            // Execute the beginTransaction RPC
            $transactionProto = $this->beginTransaction($session, $beginTransaction, $callOptions);
            $id = $transactionProto->getId();
            $precommitToken = $transactionProto->getPrecommitToken();
        }

        $transaction = new Transaction(
            $this,
            $session,
            $id,
            $beginTransaction + $transactionSelector + $options,
            $this->mapper,
        );

        if ($precommitToken) {
            $transaction->setPrecommitToken($precommitToken);
        }

        return $transaction;
    }

    /**
     * Create a read-only snapshot transaction.
     *
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.BeginTransactionRequest BeginTransactionRequest
     *
     * @param SessionCache $session The session to start the snapshot in.
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
     * }
     * @return TransactionalReadInterface
     */
    public function snapshot(SessionCache $session, array $options = []): TransactionalReadInterface
    {
        [$beginTransaction, $callOptions, $misc] = $this->validateOptions(
            $options,
            BeginTransactionRequest::class,
            CallOptions::class,
            ['singleUse', 'className', 'transactionOptions']
        );

        if (isset($misc['transactionOptions'])) {
            $beginTransaction['options'] = $this->formatTransactionOptions($misc['transactionOptions']);
        }

        $res = [];
        if (false === ($misc['singleUse'] ?? false)) {
            $transactionProto = $this->beginTransaction($session, $beginTransaction, $callOptions);
            $res = $this->handleResponse($transactionProto);
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
     * Begin a partitioned SQL query.
     *
     * @param SessionCache $session The session to run in.
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
        SessionCache $session,
        string $transactionId,
        string $sql,
        array $options = []
    ): array {
        // Split all the options into their respective categories
        [$paramsAndTypes, $partitionOptions, $partitionQuery, $executeSql, $callOptions] = $this->validateOptions(
            $options,
            ['parameters', 'types'],
            ['partitionSizeBytes', 'maxPartitions'],
            PartitionQueryRequest::class,
            ExecuteSqlRequest::class,
            CallOptions::class
        );
        // format "parameters" and "types" into "params" and "paramTypes"
        $partitionQuery += $this->formatPartitionQueryOptions($paramsAndTypes);

        $partitionQuery['transaction'] = $this->createTransactionSelector($partitionQuery, $transactionId);
        $partitionQuery += [
            'session' => $session->name(),
            'sql' => $sql,
            'partitionOptions' => $partitionOptions,
        ];

        $request = $this->serializer->decodeMessage(new PartitionQueryRequest(), $partitionQuery);

        $response = $this->spannerClient->partitionQuery($request, $callOptions + [
            'resource-prefix' => $this->getDatabaseNameFromSession($session),
            'route-to-leader' => $this->routeToLeader
        ]);
        $res = $this->handleResponse($response);

        $partitions = [];
        foreach ($res['partitions'] as $partition) {
            $partitions[] = new QueryPartition(
                $partition['partitionToken'],
                $sql,
                $options
            );
        }

        return $partitions;
    }

    /**
     * Begin a partitioned read.
     *
     * @param SessionCache $session The session to run in.
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
        SessionCache $session,
        string $transactionId,
        string $table,
        KeySet $keySet,
        array $columns,
        array $options = []
    ): array {
        // Split all the options into their respective categories.
        // $readRequest is unused, but the options are valid because they're passed in to the
        // constructor of ReadPartition.
        [$partitionOptions, $partitionRead, $readRequest, $callOptions] = $this->validateOptions(
            $options,
            ['partitionSizeBytes', 'maxPartitions'],
            PartitionReadRequest::class,
            ReadRequest::class,
            CallOptions::class
        );

        $partitionRead['transaction'] = $this->createTransactionSelector($partitionRead, $transactionId);
        $partitionRead += [
            'session' => $session->name(),
            'table' => $table,
            'columns' => $columns,
            'keySet' => $this->flattenKeySet($keySet),
            'partitionOptions' => $partitionOptions,
        ];

        $request = $this->serializer->decodeMessage(new PartitionReadRequest(), $partitionRead);

        $response = $this->spannerClient->partitionRead($request, $callOptions + [
            'resource-prefix' => $this->getDatabaseNameFromSession($session),
            'route-to-leader' => $this->routeToLeader
        ]);
        $res = $this->handleResponse($response);

        $partitions = [];
        foreach ($res['partitions'] as $partition) {
            $partitions[] = new ReadPartition(
                $partition['partitionToken'],
                $table,
                $keySet,
                $columns,
                $options
            );
        }

        return $partitions;
    }

    /**
     * Execute a service call to begin a transaction or snapshot.
     *
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.BeginTransactionRequest BeginTransactionRequest
     *
     * @param SessionCache $session The session to start the snapshot in.
     * @param array $options [optional] Configuration options.
     *
     * @return TransactionProto
     */
    private function beginTransaction(SessionCache $session, array $beginTransaction, array $callOptions): TransactionProto
    {
        $routeToLeader = $this->routeToLeader && (
            isset($beginTransaction['options']['readWrite'])
            || isset($beginTransaction['options']['partitionedDml'])
        );

        $beginTransaction += ['session' => $session->name()];
        $request = $this->serializer->decodeMessage(new BeginTransactionRequest(), $beginTransaction);
        return $this->spannerClient->beginTransaction($request, $callOptions + [
            'resource-prefix' => $this->getDatabaseNameFromSession($session),
            'route-to-leader' => $routeToLeader,
        ]);
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

    private function getDatabaseNameFromSession(SessionCache $session): string
    {
        $sessionName = $session->name();
        $parts = SpannerClient::parseName($sessionName);
        return SpannerClient::databaseName($parts['project'], $parts['instance'], $parts['database']);
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
        if (isset($transactionOptions['readOnly'])) {
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
     * @param array $args
     * @return \Generator
     */
    private function executeStreamingSql(string $databaseName, array $executeSql, array $callOptions): \Generator
    {
        $executeSql = $this->formatSqlParams($executeSql);
        $executeSql['transaction'] = $this->createTransactionSelector($executeSql);
        $executeSql['queryOptions'] = $this->createQueryOptions($executeSql);
        if (!$this->routeToLeader) {
            unset($callOptions['route-to-leader']);
        }
        $request = $this->serializer->decodeMessage(new ExecuteSqlRequest(), $executeSql);

        $response = $this->spannerClient->executeStreamingSql($request, $callOptions + [
            'resource-prefix' => $databaseName,
        ]);
        return $this->handleResponse($response);
    }

    /**
     * @param array $args
     * @return \Generator
     */
    private function streamingRead(array $args, array $callOptions): \Generator
    {
        $args['transaction'] = $this->createTransactionSelector($args);
        if (!$this->routeToLeader) {
            unset($callOptions['route-to-leader']);
        }

        $databaseName = $this->pluck('database', $args);

        $request = $this->serializer->decodeMessage(new ReadRequest(), $args);

        $response = $this->spannerClient->streamingRead($request, $callOptions + [
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
