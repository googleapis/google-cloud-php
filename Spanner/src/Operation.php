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

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Core\ValidateTrait;
use Google\Cloud\Spanner\Batch\QueryPartition;
use Google\Cloud\Spanner\Batch\ReadPartition;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\V1\SpannerClient as GapicSpannerClient;
use Google\Rpc\Code;

/**
 * Common interface for running operations against Cloud Spanner. This class is
 * intended for internal use by the client library only. Implementors should
 * access these operations via {@see Google\Cloud\Spanner\Database} or
 * {@see Google\Cloud\Spanner\Transaction}.
 *
 * Usage examples may be found in classes making use of this class:
 * * {@see Google\Cloud\Spanner\Database}
 * * {@see Google\Cloud\Spanner\Transaction}
 */
class Operation
{
    use ArrayTrait;
    use TimeTrait;
    use ValidateTrait;

    const OP_INSERT = 'insert';
    const OP_UPDATE = 'update';
    const OP_INSERT_OR_UPDATE = 'insertOrUpdate';
    const OP_REPLACE = 'replace';
    const OP_DELETE = 'delete';

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var ValueMapper
     */
    private $mapper;

    /**
     * @param ConnectionInterface $connection A connection to Google Cloud
     *        Spanner.
     * @param bool $returnInt64AsObject If true, 64 bit integers will be
     *        returned as a {@see Google\Cloud\Core\Int64} object for 32 bit
     *        platform compatibility.
     */
    public function __construct(ConnectionInterface $connection, $returnInt64AsObject)
    {
        $this->connection = $connection;
        $this->mapper = new ValueMapper($returnInt64AsObject);
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
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
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
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     * }
     * @return array An array containing {@see Google\Cloud\Spanner\Timestamp}
     *               at index 0 and the commit response as an array at index 1.
     */
    public function commitWithResponse(Session $session, array $mutations, array $options = [])
    {
        $options += [
            'transactionId' => null
        ];

        $res = $this->connection->commit($this->arrayFilterRemoveNull([
            'mutations' => $mutations,
            'session' => $session->name(),
            'database' => $this->getDatabaseNameFromSession($session)
        ]) + $options);

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
     */
    public function rollback(Session $session, $transactionId, array $options = [])
    {
        $this->connection->rollback([
            'transactionId' => $transactionId,
            'session' => $session->name(),
            'database' => $this->getDatabaseNameFromSession($session)
        ] + $options);
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
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
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

        $call = function ($resumeToken = null) use ($session, $sql, $options) {
            if ($resumeToken) {
                $options['resumeToken'] = $resumeToken;
            }

            return $this->connection->executeStreamingSql([
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
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     * }
     * @return int
     * @throws \InvalidArgumentException If the SQL string isn't an update operation.
     */
    public function executeUpdate(
        Session $session,
        Transaction $transaction,
        $sql,
        array $options = []
    ) {
        $res = $this->execute($session, $sql, [
            'transactionId' => $transaction->id()
        ] + $options);

        // Iterate through the result to ensure we have query statistics available.
        iterator_to_array($res->rows());

        $stats = $res->stats();
        if (!$stats) {
            throw new \InvalidArgumentException(
                'Partitioned DML response missing stats, possible due to non-DML statement as input.'
            );
        }

        $statsItem = isset($options['statsItem'])
            ? $options['statsItem']
            : 'rowCountExact';

        return $stats[$statsItem];
    }

    /**
     * Execute multiple DML statements.
     *
     * For detailed usage instructions, see
     * {@see Google\Cloud\Spanner\Transaction::executeUpdateBatch()}.
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
     *        {@see Google\Cloud\Spanner\Database}, and are as follows:
     *        `Database::TYPE_BOOL`, `Database::TYPE_INT64`,
     *        `Database::TYPE_FLOAT64`, `Database::TYPE_TIMESTAMP`,
     *        `Database::TYPE_DATE`, `Database::TYPE_STRING`,
     *        `Database::TYPE_BYTES`. If the value is an array, use
     *        {@see Google\Cloud\Spanner\ArrayType} to declare the array
     *        parameter types. Likewise, for structs, use
     *        {@see Google\Cloud\Spanner\StructType}.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     * }
     * @return BatchDmlResult
     * @throws \InvalidArgumentException If any statement is missing the `sql` key.
     */
    public function executeUpdateBatch(
        Session $session,
        Transaction $transaction,
        array $statements,
        array $options = []
    ) {
        $stmts = [];
        foreach ($statements as $statement) {
            if (!isset($statement['sql'])) {
                throw new \InvalidArgumentException('Each statement must contain a SQL key.');
            }

            $parameters = $this->pluck('parameters', $statement, false) ?: [];
            $types = $this->pluck('types', $statement, false) ?: [];
            $stmts[] = [
                'sql' => $statement['sql']
            ] + $this->mapper->formatParamsForExecuteSql($parameters, $types);
        }

        $res = $this->connection->executeBatchDml([
            'session' => $session->name(),
            'database' => $this->getDatabaseNameFromSession($session),
            'transactionId' => $transaction->id(),
            'statements' => $stmts
        ] + $options);

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
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     * }
     * @return Result
     */
    public function read(Session $session, $table, KeySet $keySet, array $columns, array $options = [])
    {
        $options += [
            'index' => null,
            'limit' => null,
            'offset' => null,
            'transactionContext' => null
        ];

        $context = $this->pluck('transactionContext', $options);

        $call = function ($resumeToken = null) use ($table, $session, $columns, $keySet, $options) {
            if ($resumeToken) {
                $options['resumeToken'] = $resumeToken;
            }

            return $this->connection->streamingRead([
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
     * }
     * @return Transaction
     */
    public function transaction(Session $session, array $options = [])
    {
        $options += [
            'singleUse' => false,
            'isRetry' => false,
            'requestOptions' => []
        ];
        $transactionTag = $this->pluck('tag', $options, false);
        if (isset($transactionTag)) {
            $options['requestOptions']['transactionTag'] = $transactionTag;
        }

        if (!$options['singleUse']) {
            $res = $this->beginTransaction($session, $options);
        } else {
            $res = [];
        }

        return $this->createTransaction($session, $res, ['tag' => $transactionTag]);
    }

    /**
     * Create a Transaction instance from a response object.
     *
     * @param Session $session The session the transaction belongs to.
     * @param array $res [optional] The createTransaction response.
     * @param array $options [optional] Options for the transaction object.
     * @return Transaction
     */
    public function createTransaction(Session $session, array $res = [], array $options = [])
    {
        $res += [
            'id' => null
        ];
        $options += [
            'tag' => null
        ];

        $options['isRetry'] = isset($options['isRetry'])
            ? $options['isRetry']
            : false;

        return new Transaction($this, $session, $res['id'], $options['isRetry'], $options['tag']);
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

        if (!$options['singleUse']) {
            $res = $this->beginTransaction($session, $options);
        } else {
            $res = [];
        }

        $className = $this->pluck('className', $options);
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
     * }
     * @return Session
     */
    public function createSession($databaseName, array $options = [])
    {
        $res = $this->connection->createSession([
            'database' => $databaseName,
            'session' => [
                'labels' => $this->pluck('labels', $options, false) ?: []
            ]
        ] + $options);

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
     * @param string $sessionName The session's name.
     * @return Session
     */
    public function session($sessionName)
    {
        $sessionNameComponents = GapicSpannerClient::parseName($sessionName);
        return new Session(
            $this->connection,
            $sessionNameComponents['project'],
            $sessionNameComponents['instance'],
            $sessionNameComponents['database'],
            $sessionNameComponents['session']
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
     *           {@see Google\Cloud\Spanner\ValueMapper}, and are as follows:
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

        $parameters = $this->pluck('parameters', $options, false) ?: [];
        $types = $this->pluck('types', $options, false) ?: [];
        $options += $this->mapper->formatParamsForExecuteSql($parameters, $types);

        $options = $this->partitionOptions($options);

        $res = $this->connection->partitionQuery([
            'session' => $session->name(),
            'database' => $this->getDatabaseNameFromSession($session),
            'transactionId' => $transactionId,
            'sql' => $sql
        ] + $options);

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

        $options = $this->partitionOptions($options);

        $res = $this->connection->partitionRead([
            'session' => $session->name(),
            'database' => $this->getDatabaseNameFromSession($session),
            'transactionId' => $transactionId,
            'table' => $table,
            'columns' => $columns,
            'keySet' => $this->flattenKeySet($keySet)
        ] + $options);

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
        $options['partitionOptions'] = array_filter([
            'partitionSizeBytes' => $this->pluck('partitionSizeBytes', $options, false),
            'maxPartitions' => $this->pluck('maxPartitions', $options, false)
        ]);

        return $options;
    }

    /**
     * Execute a service call to begin a transaction or snapshot.
     *
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.BeginTransactionRequest BeginTransactionRequest
     *
     * @param Session $session The session to start the snapshot in.
     * @param array $options [optional] Configuration options.
     * @return array
     */
    private function beginTransaction(Session $session, array $options = [])
    {
        $options += [
            'transactionOptions' => []
        ];

        return $this->connection->beginTransaction($options + [
            'session' => $session->name(),
            'database' => $this->getDatabaseNameFromSession($session)
        ]);
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
     * Represent the class in a more readable and digestable fashion.
     *
     * @access private
     * @codeCoverageIgnore
     */
    public function __debugInfo()
    {
        return [
            'connection' => get_class($this->connection),
        ];
    }
}
