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
use Google\Cloud\Core\ValidateTrait;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;

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

        return $this->mapper->createTimestampWithNanos($res['commitTimestamp']);
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
     * }
     * @return Snapshot
     */
    public function snapshot(Session $session, array $options = [])
    {
        $options += [
            'singleUse' => false
        ];

        if (!$options['singleUse']) {
            $res = $this->beginTransaction($session, $options);
        } else {
            $res = [];
        }

        return $this->createSnapshot($session, $res + $options);
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
     * Create a Snapshot instance from a response object.
     *
     * @param Session $session The session the snapshot belongs to.
     * @param array $res [optional] The createTransaction response.
     * @return Snapshot
     */
    public function createSnapshot(Session $session, array $res = [])
    {
        $res += [
            'id' => null,
            'readTimestamp' => null
        ];

        if ($res['readTimestamp']) {
            $res['readTimestamp'] = $this->mapper->createTimestampWithNanos($res['readTimestamp']);
        }

        return new Snapshot($this, $session, $res);
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
            $keys['keys'] = $this->mapper->encodeValuesAsSimpleType($keys['keys']);
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
