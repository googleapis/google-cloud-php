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

use Google\ApiCore\Serializer;
use Google\Cloud\Core\ApiHelperTrait;
use Google\ApiCore\ArrayTrait;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Core\ValidateTrait;
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
use Google\Cloud\Spanner\V1\PartitionQueryRequest;
use Google\Cloud\Spanner\V1\PartitionReadRequest;
use Google\Cloud\Spanner\V1\ReadRequest;
use Google\Cloud\Spanner\V1\RollbackRequest;
use Google\Cloud\Spanner\V1\Type;
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
    use ArrayTrait;
    use RequestTrait;
    use RequestProcessorTrait;
    use MutationTrait;
    use TimeTrait;
    use ValidateTrait;

    const OP_INSERT = 'insert';
    const OP_UPDATE = 'update';
    const OP_INSERT_OR_UPDATE = 'insertOrUpdate';
    const OP_REPLACE = 'replace';
    const OP_DELETE = 'delete';

    /**
     * @var ValueMapper
     */
    private $mapper;

    /**
     * @var bool
     */
    private $routeToLeader;

    /**
     * @var array
     */
    private $defaultQueryOptions;

    /**
     * @param SpannerClient $spannerClient The Spanner client used to make requests.
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param bool $returnInt64AsObject If true, 64 bit integers will be
     *        returned as a {@see \Google\Cloud\Core\Int64} object for 32 bit
     *        platform compatibility.
     * @param array $config [optional] {
     *     Configuration options.
     *
     *     @type bool $routeToLeader Enable/disable Leader Aware Routing.
     *         **Defaults to** `true` (enabled).
     *     @type array $defaultQueryOptions
     * }
     */
    public function __construct(
        private SpannerClient $spannerClient,
        private Serializer $serializer,
        bool $returnInt64AsObject,
        $config = []
    ) {
        $this->mapper = new ValueMapper($returnInt64AsObject);
        $this->routeToLeader = $this->pluck('routeToLeader', $config, false) ?: true;
        $this->defaultQueryOptions =
            $this->pluck('defaultQueryOptions', $config, false) ?: [];
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
    public function commit(Session $session, array $mutations, array $options = [])
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
    public function commitWithResponse(Session $session, array $mutations, array $options = [])
    {
        list($data, $callOptions) = $this->splitOptionalArgs($options);
        $mutations = $this->serializeMutations($mutations);
        $data += [
            'transactionId' => null,
            'session' => $session->name(),
            'mutations' => $mutations
        ];
        $data = $this->formatSingleUseTransactionOptions($data);

        $request = $this->serializer->decodeMessage(new CommitRequest(), $data);
        $callOptions = $this->addResourcePrefixHeader($callOptions, $this->getDatabaseNameFromSession($session));
        $callOptions = $this->addLarHeader($callOptions, $this->routeToLeader);

        $response = $this->spannerClient->commit($request, $callOptions);
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
    public function rollback(Session $session, $transactionId, array $options = [])
    {
        if (empty($transactionId)) {
            throw new InvalidArgumentException('Rollback failed: Transaction not initiated.');
        }

        list($data, $callOptions) = $this->splitOptionalArgs($options);
        $data = [
            'session' => $session->name(),
            'transactionId' => $transactionId
        ];

        $request = $this->serializer->decodeMessage(new RollbackRequest(), $data);
        $callOptions = $this->addResourcePrefixHeader($callOptions, $this->getDatabaseNameFromSession($session));
        $callOptions = $this->addLarHeader($callOptions, $this->routeToLeader);

        $this->spannerClient->rollback($request, $callOptions);
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
    public function execute(Session $session, $sql, array $options = [])
    {
        $options += [
            'parameters' => [],
            'types' => [],
            'transactionContext' => null
        ];

        $parameters = $this->pluck('parameters', $options);
        $types = $this->pluck('types', $options);
        $options += $this->mapper->formatParamsForExecuteSql($parameters, $types);

        $context = $this->pluck('transactionContext', $options);

        // Initially with begin, transactionId will be null.
        // Once transaction is generated, even in the case of stream failure,
        // transaction will be passed to this callable by the Result class.
        $call = function ($resumeToken = null, $transaction = null) use (
            $session,
            $sql,
            $options
        ) {
            if ($transaction && !empty($transaction->id())) {
                $options['transaction'] = ['id' => $transaction->id()];
            }
            if ($resumeToken) {
                $options['resumeToken'] = $resumeToken;
            }

            return $this->executeStreamingSql([
                'sql' => $sql,
                'session' => $session->name(),
                'database' => $this->getDatabaseNameFromSession($session)
            ] + $options);
        };

        return new Result($this, $session, $call, $context, $this->mapper);
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
        $sql,
        array $options = []
    ) {
        if (!isset($options['transaction']['begin'])) {
            $options['transaction'] = ['id' => $transaction->id()];
        }
        $statsItem = $this->pluck('statsItem', $options, false);
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

        $statsItem = $statsItem ?: 'rowCountExact';

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
    ) {
        list($data, $callOptions) = $this->splitOptionalArgs($options);
        $data['transaction'] = $this->createTransactionSelector($data, $transaction->id());
        $data += [
            'session' => $session->name(),
            'statements' => $this->formatStatements($statements)
        ];

        $request = $this->serializer->decodeMessage(new ExecuteBatchDmlRequest(), $data);
        $callOptions = $this->addResourcePrefixHeader($callOptions, $this->getDatabaseNameFromSession($session));
        $callOptions = $this->addLarHeader($callOptions, $this->routeToLeader);

        $response = $this->spannerClient->executeBatchDml($request, $callOptions);
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
    ) {
        $context = $this->pluck('transactionContext', $options, false);

        $call = function ($resumeToken = null, $transaction = null) use (
            $table,
            $session,
            $columns,
            $keySet,
            $options
        ) {
            if ($transaction && !empty($transaction->id())) {
                $options['transaction'] = ['id' => $transaction->id()];
            }
            if ($resumeToken) {
                $options['resumeToken'] = $resumeToken;
            }

            return $this->streamingRead([
                'table' => $table,
                'session' => $session->name(),
                'columns' => $columns,
                'keySet' => $this->flattenKeySet($keySet),
                'database' => $this->getDatabaseNameFromSession($session)
            ] + $options);
        };

        return new Result($this, $session, $call, $context, $this->mapper);
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
     * }
     * @return Transaction
     */
    public function transaction(Session $session, array $options = [])
    {
        $options += [
            'singleUse' => false,
            'requestOptions' => []
        ];
        $isRetry = $this->pluck('isRetry', $options, false) ?: false;
        $transactionTag = $this->pluck('tag', $options, false);

        if (isset($transactionTag)) {
            $options['requestOptions']['transactionTag'] = $transactionTag;
        }

        if (!$options['singleUse'] && (!isset($options['begin']) ||
            isset($options['transactionOptions']['partitionedDml']))
        ) {
            // Single use transactions never calls the beginTransaction API.
            // The `singleUse` key creates issue with serializer as BeginTransactionRequest
            // does not have this attribute.
            unset($options['singleUse']);
            $res = $this->beginTransaction($session, $options);
        } else {
            $res = [];
        }

        return $this->createTransaction(
            $session,
            $res,
            [
                'tag' => $transactionTag,
                'isRetry' => $isRetry,
                'transactionOptions' => $options
            ]
        );
    }

    /**
     * Create a Transaction instance from a response object.
     *
     * @param Session $session The session the transaction belongs to.
     * @param array $res [optional] The createTransaction response.
     * @param array $options [optional] Options for the transaction object.
     *     @type array $begin The begin transaction options.
     *           [Refer](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#transactionoptions)
     * @return Transaction
     */
    public function createTransaction(Session $session, array $res = [], array $options = [])
    {
        $res += [
            'id' => null
        ];
        $options += [
            'tag' => null,
            'transactionOptions' => null
        ];

        $options['isRetry'] = $options['isRetry'] ?? false;

        return new Transaction(
            $this,
            $session,
            $res['id'],
            $options['isRetry'],
            $options['tag'],
            $options['transactionOptions'],
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
     * }
     * @return mixed
     */
    public function snapshot(Session $session, array $options = [])
    {
        $options += [
            'singleUse' => false,
            'className' => Snapshot::class
        ];
        $className = $this->pluck('className', $options);

        if (!$options['singleUse']) {
            // Single use transactions never calls the beginTransaction API.
            // The `singleUse` key creates issue with serializer as BeginTransactionRequest
            // does not have this attribute.
            unset($options['singleUse']);
            $res = $this->beginTransaction($session, $options);
        } else {
            $res = [];
        }

        return $this->createSnapshot(
            $session,
            $res + $options,
            $className
        );
    }

    /**
     * Create a Snapshot instance from a response object.
     *
     * @param Session $session The session the snapshot belongs to.
     * @param array $res [optional] The createTransaction response.
     * @param string $className [optional] The class to instantiate with a
     *        snapshot. **Defaults to** `Google\Cloud\Spanner\Snapshot`.
     * @return mixed
     */
    public function createSnapshot(Session $session, array $res = [], $className = Snapshot::class)
    {
        $res += [
            'id' => null,
            'readTimestamp' => null
        ];

        if ($res['readTimestamp']) {
            if (!($res['readTimestamp'] instanceof Timestamp)) {
                $time = $this->parseTimeString($res['readTimestamp']);
                $res['readTimestamp'] = new Timestamp($time[0], $time[1]);
            }
        }

        return new $className($this, $session, $res);
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
    public function createSession($databaseName, array $options = [])
    {
        list($data, $callOptions) = $this->splitOptionalArgs($options);
        $data = [
            'database' => $databaseName,
            'session' => [
                'labels' => $this->pluck('labels', $options, false) ?: [],
                'creator_role' => $this->pluck('creator_role', $options, false) ?: ''
        ]];

        $request = $this->serializer->decodeMessage(new CreateSessionRequest(), $data);

        $callOptions = $this->addResourcePrefixHeader($callOptions, $databaseName);
        $callOptions = $this->addLarHeader($callOptions, $this->routeToLeader);

        $response = $this->spannerClient->createSession($request, $callOptions);
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
    public function session($sessionName)
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
    public function partitionQuery(Session $session, $transactionId, $sql, array $options = [])
    {
        // cache this to pass to the partition instance.
        $originalOptions = $options;
        list($data, $callOptions) = $this->splitOptionalArgs($options);

        $data = $this->formatPartitionQueryOptions($data);
        $data += [
            'transaction' => $this->createTransactionSelector($data, $transactionId),
            'session' => $session->name(),
            'sql' => $sql,
            'partitionOptions' => $this->partitionOptions($data)
        ];

        $request = $this->serializer->decodeMessage(new PartitionQueryRequest(), $data);
        $callOptions = $this->addResourcePrefixHeader($callOptions, $this->getDatabaseNameFromSession($session));
        $callOptions = $this->addLarHeader($callOptions, $this->routeToLeader);

        $response = $this->spannerClient->partitionQuery($request, $callOptions);
        $res = $this->handleResponse($response);

        $partitions = [];
        foreach ($res['partitions'] as $partition) {
            $partitions[] = new QueryPartition(
                $partition['partitionToken'],
                $sql,
                $originalOptions
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
        $transactionId,
        $table,
        KeySet $keySet,
        array $columns,
        array $options = []
    ) {
        // cache this to pass to the partition instance.
        $originalOptions = $options;
        list($data, $callOptions) = $this->splitOptionalArgs($options);
        $data += [
            'transaction' => $this->createTransactionSelector($data, $transactionId),
            'session' => $session->name(),
            'table' => $table,
            'columns' => $columns,
            'keySet' => $this->formatKeySet($this->flattenKeySet($keySet)),
            'partitionOptions' => $this->partitionOptions($data)
        ];

        $request = $this->serializer->decodeMessage(new PartitionReadRequest(), $data);
        $callOptions = $this->addResourcePrefixHeader($callOptions, $this->getDatabaseNameFromSession($session));
        $callOptions = $this->addLarHeader($callOptions, $this->routeToLeader);

        $response = $this->spannerClient->partitionRead($request, $callOptions);
        $res = $this->handleResponse($response);

        $partitions = [];
        foreach ($res['partitions'] as $partition) {
            $partitions[] = new ReadPartition(
                $partition['partitionToken'],
                $table,
                $keySet,
                $columns,
                $originalOptions
            );
        }

        return $partitions;
    }

    /**
     * Normalize options for partition configuration.
     *
     * @param array $options
     * @return array
     */
    private function partitionOptions(array &$options)
    {
        return array_filter([
            'partitionSizeBytes' => $this->pluck('partitionSizeBytes', $options, false),
            'maxPartitions' => $this->pluck('maxPartitions', $options, false)
        ]);
    }

    /**
     * Execute a service call to begin a transaction or snapshot.
     *
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.BeginTransactionRequest BeginTransactionRequest
     *
     * @param Session $session The session to start the snapshot in.
     * @param array $options [optional] Configuration options.
     *
     * @return array
     */
    private function beginTransaction(Session $session, array $options = [])
    {
        list($data, $callOptions) = $this->splitOptionalArgs($options);
        $transactionOptions = $this->formatTransactionOptions(
            $this->pluck('transactionOptions', $data, false) ?: []
        );
        if (isset($transactionOptions['readWrite'])
            || isset($transactionOptions['partitionedDml'])) {
            $callOptions = $this->addLarHeader($callOptions, $this->routeToLeader);
        }
        $data += [
            'session' => $session->name(),
            'options' => $transactionOptions
        ];

        $request = $this->serializer->decodeMessage(new BeginTransactionRequest(), $data);
        $callOptions = $this->addResourcePrefixHeader($callOptions, $this->getDatabaseNameFromSession($session));

        $response = $this->spannerClient->beginTransaction($request, $callOptions);
        return $this->handleResponse($response);
    }

    /**
     * Convert a KeySet object to an API-ready array.
     *
     * @param KeySet $keySet The keySet object.
     * @return array [KeySet](https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#keyset)
     */
    private function flattenKeySet(KeySet $keySet)
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

    private function getDatabaseNameFromSession(Session $session)
    {
        return $session->info()['databaseName'];
    }

    /**
     * Serialize the mutations.
     *
     * @param array $mutations
     * @return array
     */
    private function serializeMutations(array $mutations)
    {
        $serializedMutations = [];
        if (is_array($mutations)) {
            foreach ($mutations as $mutation) {
                $type = array_keys($mutation)[0];
                $data = $mutation[$type];

                switch ($type) {
                    case Operation::OP_DELETE:
                        if (isset($data['keySet'])) {
                            $data['keySet'] = $this->formatKeySet($data['keySet']);
                        }
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
     * @param array $keySet
     * @return array Formatted keyset
     */
    private function formatKeySet(array $keySet)
    {
        $keys = $this->pluck('keys', $keySet, false);
        if ($keys) {
            $keySet['keys'] = array_map(
                fn ($key) => $this->formatListForApi((array) $key),
                $keys
            );
        }

        if (isset($keySet['ranges'])) {
            $keySet['ranges'] = array_map(function ($rangeItem) {
                return array_map([$this, 'formatListForApi'], $rangeItem);
            }, $keySet['ranges']);

            if (empty($keySet['ranges'])) {
                unset($keySet['ranges']);
            }
        }

        return $keySet;
    }

    /**
     * Format statements.
     *
     * @param array $statements
     * @return array
     */
    private function formatStatements(array $statements)
    {
        $result = [];
        foreach ($statements as $statement) {
            if (!isset($statement['sql'])) {
                throw new InvalidArgumentException('Each statement must contain a SQL key.');
            }

            $parameters = $this->pluck('parameters', $statement, false) ?: [];
            $types = $this->pluck('types', $statement, false) ?: [];
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
    private function formatSqlParams(array $args)
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
     * @param ?string $transactionId
     *
     * @return array
     */
    private function createTransactionSelector(array &$args, ?string $transactionId = null)
    {
        $transactionSelector = [];
        if (isset($args['transaction'])) {
            $transactionSelector = $this->pluck('transaction', $args);

            if (isset($transactionSelector['singleUse'])) {
                $transactionSelector['singleUse'] =
                    $this->formatTransactionOptions($transactionSelector['singleUse']);
            }

            if (isset($transactionSelector['begin'])) {
                $transactionSelector['begin'] =
                    $this->formatTransactionOptions($transactionSelector['begin']);
            }
        } elseif ($transactionId) {
            $transactionSelector = ['id' => $transactionId];
        }

        return $transactionSelector;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private function createQueryOptions(array $args)
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
    private function formatTransactionOptions(array $transactionOptions)
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
    private function executeStreamingSql(array $args)
    {
        list($data, $callOptions) = $this->splitOptionalArgs($args);
        $data = $this->formatSqlParams($data);
        $data['transaction'] = $this->createTransactionSelector($data);
        $data['queryOptions'] = $this->createQueryOptions($data);
        $callOptions = $this->conditionallyUnsetLarHeader($callOptions, $this->routeToLeader);
        $databaseName = $this->pluck('database', $data);

        $request = $this->serializer->decodeMessage(new ExecuteSqlRequest(), $data);
        $callOptions = $this->addResourcePrefixHeader($callOptions, $databaseName);

        $response = $this->spannerClient->executeStreamingSql($request, $callOptions);
        return $this->handleResponse($response);
    }

    /**
     * @param array $args
     * @return \Generator
     */
    private function streamingRead(array $args)
    {
        list($data, $callOptions) = $this->splitOptionalArgs($args);
        $data['keySet']= $this->formatKeySet($this->pluck('keySet', $data));
        $data['transaction'] = $this->createTransactionSelector($data);
        $callOptions = $this->conditionallyUnsetLarHeader($callOptions, $this->routeToLeader);
        $databaseName = $this->pluck('database', $data);

        $request = $this->serializer->decodeMessage(new ReadRequest(), $data);
        $callOptions = $this->addResourcePrefixHeader($callOptions, $databaseName);

        $response = $this->spannerClient->streamingRead($request, $callOptions);
        return $this->handleResponse($response);
    }

    /**
     * @param array $args
     * @return array
     */
    private function formatSingleUseTransactionOptions(array $args)
    {
        // Internal flag, need to unset before passing to serializer
        unset($args['singleUse']);
        if (isset($args['singleUseTransaction'])) {
            $args['singleUseTransaction'] = ['readWrite' => []];
            // request ignores singleUseTransaction even if the transactionId is set to null
            unset($args['transactionId']);
        }
        return $args;
    }

    /**
     * @param array $args
     * @param string $transactionId
     *
     * @return array
     */
    private function formatPartitionQueryOptions(array $args)
    {
        $parameters = $this->pluck('parameters', $args, false) ?: [];
        $types = $this->pluck('types', $args, false) ?: [];
        $args += $this->mapper->formatParamsForExecuteSql($parameters, $types);
        $args = $this->formatSqlParams($args);
        return $args;
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
