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

use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;

/**
 * Read-only snapshot Transaction.
 *
 * For full usage details, please refer to
 * {@see Google\Cloud\Spanner\Database::snapshot()}.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 *
 * $database = $spanner->connect('my-instance', 'my-database');
 * $snapshot = $database->snapshot();
 * ```
 *
 * @method execute() {
 *     Run a query.
 *
 *     Example:
 *     ```
 *     $result = $snapshot->execute(
 *         'SELECT * FROM Users WHERE id = @userId',
 *         [
 *              'parameters' => [
 *                  'userId' => 1
 *              ]
 *          ]
 *     );
 *
 *     $firstRow = $result
 *         ->rows()
 *         ->current();
 *     ```
 *
 *     @param string $sql The query string to execute.
 *     @param array $options [optional] {
 *         Configuration options.
 *
 *         @type array $parameters A key/value array of Query Parameters, where
 *               the key is represented in the query string prefixed by a `@`
 *               symbol.
 *     }
 *     @return Result
 * }
 * @method read() {
 *     Lookup rows in a table.
 *
 *     Example:
 *     ```
 *     $keySet = new KeySet([
 *         'keys' => [10]
 *     ]);
 *
 *     $columns = ['ID', 'title', 'content'];
 *
 *     $result = $snapshot->read('Posts', $keySet, $columns);
 *
 *     $firstRow = $result
 *         ->rows()
 *         ->current();
 *
 *     @param string $table The table name.
 *     @param KeySet $keySet The KeySet to select rows.
 *     @param array $columns A list of column names to return.
 *     @param array $options [optional] {
 *         Configuration Options.
 *
 *         @type string $index The name of an index on the table.
 *         @type int $offset The number of rows to offset results by.
 *         @type int $limit The number of results to return.
 *     }
 *     @return Result
 * }
 * @method id() {
 *     Retrieve the Transaction ID.
 *
 *     Example:
 *     ```
 *     $id = $snapshot->id();
 *     ```
 *
 *     @return string
 * }
 */
class Snapshot implements TransactionalReadInterface
{
    use TransactionalReadTrait;

    /**
     * @var Timestamp
     */
    private $readTimestamp;

    /**
     * @param Operation $operation The Operation instance.
     * @param Session $session The session to use for spanner interactions.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $id The Transaction ID. If no ID is provided,
     *           the Transaction will be a Single-Use Transaction.
     *     @type Timestamp $readTimestamp The read timestamp.
     * }
     */
    public function __construct(
        Operation $operation,
        Session $session,
        array $options = []
    ) {
        $this->operation = $operation;
        $this->session = $session;

        $options += [
            'id' => null,
            'readTimestamp' => null
        ];

        if ($options['readTimestamp'] && !($options['readTimestamp'] instanceof Timestamp)) {
            throw new \InvalidArgumentException('$options.readTimestamp must be an instance of Timestamp.');
        }

        $this->transactionId = $options['id'] ?: null;
        $this->readTimestamp = $options['readTimestamp'];
        $this->type = $options['id']
            ? self::TYPE_PRE_ALLOCATED
            : self::TYPE_SINGLE_USE;

        $this->context = SessionPoolInterface::CONTEXT_READ;
        $this->options = $options;
    }

    /**
     * Retrieve the Read Timestamp.
     *
     * For snapshot read-only transactions, the read timestamp chosen for the
     * transaction.
     *
     * Example:
     * ```
     * $timestamp = $snapshot->readTimestamp();
     * ```
     *
     * @return Timestamp
     */
    public function readTimestamp()
    {
        return $this->readTimestamp;
    }
}
