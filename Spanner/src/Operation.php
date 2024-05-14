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
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\ValidateTrait;
use Google\Cloud\Spanner\Batch\QueryPartition;
use Google\Cloud\Spanner\Batch\ReadPartition;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\V1\BeginTransactionRequest;
use Google\Cloud\Spanner\V1\Client\SpannerClient as GapicSpannerClient;
use Google\Cloud\Spanner\V1\CommitRequest;
use Google\Cloud\Spanner\V1\CreateSessionRequest;
use Google\Cloud\Spanner\V1\DeleteSessionRequest;
use Google\Cloud\Spanner\V1\DirectedReadOptions;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlRequest;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlRequest\Statement;
use Google\Cloud\Spanner\V1\ExecuteSqlRequest;
use Google\Cloud\Spanner\V1\ExecuteSqlRequest\QueryOptions;
use Google\Cloud\Spanner\V1\KeySet as GapicKeySet;
use Google\Cloud\Spanner\V1\Mutation;
use Google\Cloud\Spanner\V1\Mutation\Delete;
use Google\Cloud\Spanner\V1\Mutation\Write;
use Google\Cloud\Spanner\V1\PartitionOptions;
use Google\Cloud\Spanner\V1\ReadRequest;
use Google\Cloud\Spanner\V1\RequestOptions;
use Google\Cloud\Spanner\V1\RollbackRequest;
use Google\Cloud\Spanner\V1\Session as GapicSession;
use Google\Cloud\Spanner\V1\TransactionOptions;
use Google\Cloud\Spanner\V1\TransactionOptions\PartitionedDml;
use Google\Cloud\Spanner\V1\TransactionOptions\PBReadOnly;
use Google\Cloud\Spanner\V1\TransactionOptions\ReadWrite;
use Google\Cloud\Spanner\V1\TransactionSelector;
use Google\Cloud\Spanner\V1\Type;
use Google\Protobuf\ListValue;
use Google\Protobuf\Struct;
use Google\Protobuf\Value;
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
    use TimeTrait;
    use ValidateTrait;

    const OP_INSERT = 'insert';
    const OP_UPDATE = 'update';
    const OP_INSERT_OR_UPDATE = 'insertOrUpdate';
    const OP_REPLACE = 'replace';
    const OP_DELETE = 'delete';

    /**
     * @var RequestHandler
     */
    private $requestHandler;

    /**
     * @var Serializer
     */
    private Serializer $serializer;

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
     * @param RequestHandler The request handler that is responsible for sending a request
     * and serializing responses into relevant classes.
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
        RequestHandler $requestHandler,
        Serializer $serializer,
        bool $returnInt64AsObject,
        $config = []
    ) {
        $this->requestHandler = $requestHandler;
        $this->serializer = $serializer;
        $this->mapper = new ValueMapper($returnInt64AsObject);
        $this->routeToLeader = $this->pluck('routeToLeader', $config, false) ?? true;
        $this->defaultQueryOptions = $this->pluck('defaultQueryOptions', $config, false) ?: [];
    }

    /**
     * Create a formatted mutation.
     *
     * @param string $operation The operation type.
     * @param string $table The table name.
     * @param array $mutation The mutation data, represented as a set of
     *        key/value pairs.
     * @return array
     */
    public function mutation($operation, $table, $mutation)
    {
        return [
            $operation => [
                'table' => $table,
                'columns' => array_keys($mutation),
                'values' => $this->mapper->encodeValuesAsSimpleType(array_values($mutation))
            ]
        ];
    }

    /**
     * Create a formatted delete mutation.
     *
     * @param string $table The table name.
     * @param KeySet $keySet The keys to delete.
     * @return array
     */
    public function deleteMutation($table, KeySet $keySet)
    {
        return [
            self::OP_DELETE => [
                'table' => $table,
                'keySet' => $this->flattenKeySet($keySet),
            ]
        ];
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
        $mutations = $this->serializeMutations($mutations);
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $data += [
            'transactionId' => null,
            'session' => $session->name(),
            'mutations' => $mutations
        ];
        // Internal flag, need to unset before passing to serializer
        unset($data['singleUse']);
        if (isset($data['singleUseTransaction'])) {
            $data['singleUseTransaction'] = $this->createReadWriteTransactionOptions();
            // singleUseTransaction will not set in the request even if the transactionId set to null
            unset($data['transactionId']);
        }
        if ($data['requestOptions']) {
            $data['requestOptions'] = $this->serializer->decodeMessage(
                new RequestOptions,
                $data['requestOptions']
            );
        }
        $res = $this->createAndSendRequest(
            GapicSpannerClient::class,
            'commit',
            $data,
            $optionalArgs,
            CommitRequest::class,
            $this->getDatabaseNameFromSession($session),
            $this->routeToLeader
        );

        $time = $this->parseTimeString($res['commitTimestamp']);
        return [new Timestamp($time[0], $time[1]), $res];
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

        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $data['session'] = $session->name();
        $data['transactionId'] = $transactionId;

        $this->createAndSendRequest(
            GapicSpannerClient::class,
            'rollback',
            $data,
            $optionalArgs,
            RollbackRequest::class,
            $this->getDatabaseNameFromSession($session),
            $this->routeToLeader
        );
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

        $statsItem = $options['statsItem'] ?? 'rowCountExact';

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
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $data['transaction'] = $this->createTransactionSelector($data);
        $data += [
            'session' => $session->name(),
            'statements' => $this->formatStatements($statements)
        ];
        if ($data['requestOptions']) {
            $data['requestOptions'] = $this->serializer->decodeMessage(
                new RequestOptions,
                $data['requestOptions']
            );
        }

        $res = $this->createAndSendRequest(
            GapicSpannerClient::class,
            'executeBatchDml',
            $data,
            $optionalArgs,
            ExecuteBatchDmlRequest::class,
            $this->getDatabaseNameFromSession($session),
            $this->routeToLeader
        );

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
        // @TODO: Check what is the significance of these options here.
        // $options += [
        //     'index' => null,
        //     'limit' => null,
        //     'offset' => null,
        //     'transactionContext' => null
        // ];

        $context = $this->pluck('transactionContext', $options, false) ?: null;

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
            'requestOptions' => [],
            'singleUse' => false
        ];
        $isRetry = $options['isRetry'] ?? false;
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
            $options['transactionOptions']
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
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $data = [
            'database' => $databaseName
        ];
        $session = [
            'labels' => $this->pluck('labels', $options, false) ?: [],
            'creator_role' => $this->pluck('creator_role', $options, false) ?: ''
        ];
        $data['session'] = $this->serializer->decodeMessage(
            new GapicSession,
            $session
        );

        $res = $this->createAndSendRequest(
            GapicSpannerClient::class,
            'createSession',
            $data,
            $optionalArgs,
            CreateSessionRequest::class,
            $databaseName,
            $this->routeToLeader
        );

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
        $sessionNameComponents = GapicSpannerClient::parseName($sessionName);
        return new Session(
            $this->requestHandler,
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
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);

        $parameters = $this->pluck('parameters', $data, false) ?: [];
        $types = $this->pluck('types', $data, false) ?: [];
        $data += $this->mapper->formatParamsForExecuteSql($parameters, $types);
        $data = $this->formatSqlParams($data);
        $data += [
            'transaction' => $this->createTransactionSelector(
                $data + ['transaction' => ['id' => $transactionId]]
            ),
            'session' => $session->name(),
            'sql' => $sql,
            'partitionOptions' => $this->serializer->decodeMessage(
                new PartitionOptions,
                $this->partitionOptions($data)
            )
        ];

        $res = $this->createAndSendRequest(
            GapicSpannerClient::class,
            'partitionQuery',
            $data,
            $optionalArgs,
            PartitionQueryRequest::class,
            $this->getDatabaseNameFromSession($session),
            $this->routeToLeader
        );

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
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $data += [
            'transaction' => $this->createTransactionSelector(
                $data + ['transaction' => ['id' => $transactionId]]
            ),
            'session' => $session->name(),
            'table' => $table,
            'columns' => $columns,
            'keySet' => $this->serializer->decodeMessage(
                new GapicKeySet,
                $this->formatKeySet($keySet)
            ),
            'partitionOptions' => $this->serializer->decodeMessage(
                new PartitionOptions,
                $this->partitionOptions($data)
            )
        ];

        $res = $this->createAndSendRequest(
            GapicSpannerClient::class,
            'partitionRead',
            $data,
            $optionalArgs,
            PartitionReadRequest::class,
            $this->getDatabaseNameFromSession($session),
            $this->routeToLeader
        );

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
    private function partitionOptions(array $options)
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
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $transactionOptions = new TransactionOptions;
        $formattedTransactionOptions = $this->formatTransactionOptions(
            $this->pluck('transactionOptions', $data, false) ?: []
        );
        if (isset($formattedTransactionOptions['readOnly'])) {
            // @TODO: Check its a necessary check.
            $readOnlyClass = PHP_VERSION_ID >= 80100
                ? PBReadOnly::class
                : 'Google\Cloud\Spanner\V1\TransactionOptions\ReadOnly';
            $readOnly = $this->serializer->decodeMessage(
                new $readOnlyClass(), // @phpstan-ignore-line
                $formattedTransactionOptions['readOnly']
            );
            $transactionOptions->setReadOnly($readOnly);
        } elseif (isset($formattedTransactionOptions['readWrite'])) {
            $readWrite = new ReadWrite();
            $transactionOptions->setReadWrite($readWrite);
            $optionalArgs = $this->addLarHeader($optionalArgs, $this->routeToLeader);
        } elseif (isset($formattedTransactionOptions['partitionedDml'])) {
            $pdml = new PartitionedDml();
            $transactionOptions->setPartitionedDml($pdml);
            $optionalArgs = $this->addLarHeader($optionalArgs, $this->routeToLeader);
        }
        if (isset($data['requestOptions'])) {
            $data['requestOptions'] = $this->serializer->decodeMessage(
                new RequestOptions,
                $data['requestOptions']
            );
        }
        $data += [
            'session' => $session->name(),
            'options' => $transactionOptions
        ];

        return $this->createAndSendRequest(
            GapicSpannerClient::class,
            'beginTransaction',
            $data,
            $optionalArgs,
            BeginTransactionRequest::class,
            $this->getDatabaseNameFromSession($session),
            false
        );
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

                        $operation = $this->serializer->decodeMessage(
                            new Delete,
                            $data
                        );
                        break;
                    default:
                        $operation = new Write;
                        $operation->setTable($data['table']);
                        $operation->setColumns($data['columns']);

                        $modifiedData = [];
                        foreach ($data['values'] as $key => $param) {
                            $modifiedData[$key] = $this->fieldValue($param);
                        }

                        $list = new ListValue;
                        $list->setValues($modifiedData);
                        $values = [$list];
                        $operation->setValues($values);

                        break;
                }

                $setterName = $this->mutationSetters[$type];
                $mutation = new Mutation;
                $mutation->$setterName($operation);
                $serializedMutations[] = $mutation;
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
            $keySet['keys'] = [];

            foreach ($keys as $key) {
                $keySet['keys'][] = $this->formatListForApi((array) $key);
            }
        }

        if (isset($keySet['ranges'])) {
            foreach ($keySet['ranges'] as $index => $rangeItem) {
                foreach ($rangeItem as $key => $val) {
                    $rangeItem[$key] = $this->formatListForApi($val);
                }

                $keySet['ranges'][$index] = $rangeItem;
            }

            if (empty($keySet['ranges'])) {
                unset($keySet['ranges']);
            }
        }

        return $keySet;
    }

    /**
     * @param mixed $param
     * @return Value
     */
    private function fieldValue($param)
    {
        $field = new Value;
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
                $value = new Struct;
                $value->setFields($modifiedParams);

                break;
            case 'list_value':
                $setter = 'setListValue';
                $modifiedParams = [];
                foreach ($param as $item) {
                    $modifiedParams[] = $this->fieldValue($item);
                }
                $list = new ListValue;
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

    private function createReadWriteTransactionOptions(array $options = [])
    {
        $readWrite = $this->serializer->decodeMessage(
            new ReadWrite(),
            $options
        );
        $transactionOptions = new TransactionOptions;
        $transactionOptions->setReadWrite($readWrite);
        return $transactionOptions;
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
            $statement = $this->formatSqlParams($mappedStatement);
            $result[] = $this->serializer->decodeMessage(new Statement, $statement);
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
            $modifiedParams = [];
            foreach ($params as $key => $param) {
                $modifiedParams[$key] = $this->fieldValue($param);
            }
            $args['params'] = new Struct;
            $args['params']->setFields($modifiedParams);
        }

        if (isset($args['paramTypes']) && is_array($args['paramTypes'])) {
            foreach ($args['paramTypes'] as $key => $param) {
                $args['paramTypes'][$key] = $this->serializer->decodeMessage(new Type, $param);
            }
        }

        return $args;
    }

    /**
     * @param array $args
     * @param Transaction $transaction
     *
     * @return TransactionSelector
     */
    private function createTransactionSelector(array &$args, Transaction $transaction = null)
    {
        $selector = new TransactionSelector;
        if (isset($args['transaction'])) {
            $transaction = $this->pluck('transaction', $args);

            if (isset($transaction['singleUse'])) {
                $transaction['singleUse'] = $this->formatTransactionOptions($transaction['singleUse']);
            }

            if (isset($transaction['begin'])) {
                $transaction['begin'] = $this->formatTransactionOptions($transaction['begin']);
            }

            $selector = $this->serializer->decodeMessage($selector, $transaction);
        } elseif ($transaction && $transaction->id()) {
            $selector = $this->serializer->decodeMessage($selector, ['id' => $transaction->id()]);
        } elseif (isset($args['transactionId'])) {
            $selector = $this->serializer->decodeMessage($selector, ['id' => $this->pluck('transactionId', $args)]);
        }

        return $selector;
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
        list($data, $optionalArgs) = $this->splitOptionalArgs($args);
        $data = $this->formatSqlParams($data);
        $data['transaction'] = $this->createTransactionSelector($data);
        $queryOptions = $this->pluck('queryOptions', $data, false) ?: [];
        // Query options precedence is query-level, then environment-level, then client-level.
        $envQueryOptimizerVersion = getenv('SPANNER_OPTIMIZER_VERSION');
        $envQueryOptimizerStatisticsPackage = getenv('SPANNER_OPTIMIZER_STATISTICS_PACKAGE');
        if (!empty($envQueryOptimizerVersion)) {
            $queryOptions += ['optimizerVersion' => $envQueryOptimizerVersion];
        }
        if (!empty($envQueryOptimizerStatisticsPackage)) {
            $queryOptions += ['optimizerStatisticsPackage' => $envQueryOptimizerStatisticsPackage];
        }
        $queryOptions += $this->defaultQueryOptions;
        $this->setDirectedReadOptions($data);
        if ($queryOptions) {
            $data['queryOptions'] = $this->serializer->decodeMessage(
                new QueryOptions,
                $queryOptions
            );
        }
        if (isset($data['requestOptions'])) {
            $data['requestOptions'] = $this->serializer->decodeMessage(
                new RequestOptions,
                $data['requestOptions']
            );
        }
        $optionalArgs = $this->conditionallyUnsetLarHeader($optionalArgs, $this->routeToLeader);
        $databaseName = $this->pluck('database', $data);

        return $this->createAndSendRequest(
            GapicSpannerClient::class,
            'executeStreamingSql',
            $data,
            $optionalArgs,
            ExecuteSqlRequest::class,
            $databaseName
        );
    }

    /**
     * @param array $args
     * @return \Generator
     */
    private function streamingRead(array $args)
    {
        list($data, $optionalArgs) = $this->splitOptionalArgs($args);
        $keySet = $this->pluck('keySet', $data);
        $data['keySet']= $this->serializer->decodeMessage(new GapicKeySet, $this->formatKeySet($keySet));
        if (isset($data['requestOptions'])) {
            $data['requestOptions'] = $this->serializer->decodeMessage(
                new RequestOptions,
                $data['requestOptions']
            );
        }
        $this->setDirectedReadOptions($data);
        $data['transaction'] = $this->createTransactionSelector($data);
        $optionalArgs = $this->conditionallyUnsetLarHeader($optionalArgs, $this->routeToLeader);
        $databaseName = $this->pluck('database', $data);

        return $this->createAndSendRequest(
            GapicSpannerClient::class,
            'streamingRead',
            $data,
            $optionalArgs,
            ReadRequest::class,
            $databaseName
        );
    }

    /**
     * Set DirectedReadOptions if provided.
     *
     * @param array $args
     */
    private function setDirectedReadOptions(array &$args)
    {
        $directedReadOptions = $this->pluck('directedReadOptions', $args, false);
        if (!empty($directedReadOptions)) {
            $args['directedReadOptions'] = $this->serializer->decodeMessage(
                new DirectedReadOptions,
                $directedReadOptions
            );
        }
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
            'requestHandler' => get_class($this->requestHandler),
        ];
    }
}
