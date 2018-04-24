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
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\V1\SpannerClient as GapicSpannerClient;

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
        $mutation = $this->arrayFilterRemoveNull($mutation);

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
     * @param Transaction $transaction The transaction to commit.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $transactionId The ID of the transaction.
     * }
     * @return Timestamp The commit Timestamp.
     */
    public function commit(Session $session, array $mutations, array $options = [])
    {
        $options += [
            'transactionId' => null
        ];

        $res = $this->connection->commit($this->arrayFilterRemoveNull([
            'mutations' => $mutations,
            'session' => $session->name(),
            'database' => $session->info()['database']
        ]) + $options);

        $time = $this->parseTimeString($res['commitTimestamp']);
        return new Timestamp($time[0], $time[1]);
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
        return $this->connection->rollback([
            'transactionId' => $transactionId,
            'session' => $session->name(),
            'database' => $session->info()['database']
        ] + $options);
    }

    /**
     * Run a query.
     *
     * @param Session $session The session to use to execute the SQL.
     * @param string $sql The query string.
     * @param array $options [optional] Configuration options.
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
                'database' => $session->info()['database']
            ] + $options);
        };

        return new Result($this, $session, $call, $context, $this->mapper);
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
                'database' => $session->info()['database']
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
            'isRetry' => false
        ];

        if (!$options['singleUse']) {
            $res = $this->beginTransaction($session, $options);
        } else {
            $res = [];
        }

        return $this->createTransaction($session, $res);
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

        $options['isRetry'] = isset($options['isRetry'])
            ? $options['isRetry']
            : false;

        return new Transaction($this, $session, $res['id'], $options['isRetry']);
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
     * @return Snapshot
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
     * @return Snapshot
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
     * @param array $options [optional] Configuration options.
     * @return Session
     */
    public function createSession($databaseName, array $options = [])
    {
        $res = $this->connection->createSession($options + [
            'database' => $databaseName
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
            'database' => $session->info()['database'],
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
            'database' => $session->info()['database'],
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
            'database' => $session->info()['database']
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
