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

use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\ValidateTrait;
use RuntimeException;

/**
 * Common interface for running operations against Google Cloud Spanner. This
 * class is intended for internal use by the client library only. Implementors
 * should access these operations via {@see Google\Cloud\Spanner\Database} or
 * {@see Google\Cloud\Spanner\Transaction}.
 */
class Operation
{
    use ValidateTrait;

    const OP_INSERT = 'insert';
    const OP_UPDATE = 'update';
    const OP_INSERT_OR_UPDATE = 'insertOrUpdate';
    const OP_REPLACE = 'replace';

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var Instance
     */
    private $instance;

    /**
     * @param ConnectionInterface $connection A connection to Google Cloud
     *        Spanner.
     * @param Instance $instance The current Cloud Spanner instance.
     */
    public function __construct(
        ConnectionInterface $connection,
        Instance $instance,
        Database $database
    ) {
        $this->connection = $connection;
        $this->instance = $instance;
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
                'values' => array_values($mutation)
            ]
        ];
    }

    /**
     * Create a formatted delete mutation.
     *
     * @param string $table The table name.
     * @param array $keySet [KeySet](https://cloud.google.com/spanner/reference/rest/v1/KeySet).
     * @return array
     */
    public function deleteMutation($table, $keySet)
    {
        return [
            'delete' => [
                'table' => $table,
                'keySet' => $keySet
            ]
        ];
    }

    /**
     * Commit all enqueued mutations.
     *
     * @codingStandardsIgnoreStart
     * @param Session $session The session ID to use for the commit.
     * @param array $mutations The mutations to commit.
     * @param array $options [optional] Configuration options.
     * @return array [CommitResponse](https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.CommitResponse)
     * @codingStandardsIgnoreEnd
     */
    public function commit(Session $session, array $mutations, array $options = [])
    {
        if (!isset($options['transactionId'])) {
            $options['singleUseTransaction'] = ['readWrite' => []];
        }

        try {
            $res = $this->connection->commit([
                'mutations' => $mutations,
                'session' => $session->name()
            ] + $options);

            return $res;
        } catch (\Exception $e) {

            // maybe do something here?

            throw $e;
        }
    }

    /**
     * Rollback a Transaction
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
            'session' => $session->name()
        ] + $options);
    }

    /**
     * Run a query
     *
     * @param Session $session The session to use to execute the SQL.
     * @param string $sql The query string.
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function execute(Session $session, $sql, array $options = [])
    {
        $options += [
            'params' => [],
            'paramTypes' => []
        ];

        $res = $this->connection->executeSql([
            'sql' => $sql,
            'session' => $session->name()
        ] + $options);

        return new Result($res);
    }

    /**
     * Lookup rows in a database.
     *
     * @param Session $session The session in which to read data.
     * @param string $table The table to read from.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $index
     *     @type array $columns
     *     @type KeySet $keySet
     *     @type string $offset
     *     @type int $limit
     * }
     */
    public function read(Session $session, $table, array $options = [])
    {
        $options += [
            'index' => null,
            'columns' => [],
            'keySet' => [],
            'offset' => null,
            'limit' => null,
        ];

        if (!empty($options['keySet']) && !($options['keySet']) instanceof KeySet) {
            throw new RuntimeException('$options.keySet must be an instance of KeySet');
        }

        if (empty($options['keySet'])) {
            $options['keySet'] = new KeySet();
            $options['keySet']->setAll(true);
        }

        $options['keySet'] = $options['keySet']->keySetObject();

        $res = $this->connection->read([
            'table' => $table,
            'session' => $session->name()
        ] + $options);

        return new Result($res);
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
            'instance' => $this->instance,
            'sessionPool' => $this->sessionPool
        ];
    }
}
