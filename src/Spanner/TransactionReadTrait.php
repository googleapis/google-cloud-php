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

/**
 * Shared methods for reads inside a transaction.
 */
trait TransactionReadTrait
{
    use TransactionConfigurationTrait;

    /**
     * @var Operation
     */
    private $operation;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var string
     */
    private $transactionId;

    /**
     * @var string
     */
    private $context;

    /**
     * Run a query.
     *
     * Example:
     * ```
     * $result = $transaction->execute(
     *     'SELECT * FROM Users WHERE id = @userId',
     *     [
     *          'parameters' => [
     *              'userId' => 1
     *          ]
     *     ]
     * );
     * ```
     * @param string $sql The query string to execute.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $parameters A key/value array of Query Parameters, where
     *           the key is represented in the query string prefixed by a `@`
     *           symbol.
     * }
     * @return Result
     */
    public function execute($sql, array $options = [])
    {
        $options['transactionType'] = $this->context;
        $options['transactionId'] = $this->transactionId;

        list($transactionOptions, $context) = $this->transactionSelector($options);
        $options['transaction'] = $transactionOptions;
        $options['transactionContext'] = $context;

        return $this->operation->execute($this->session, $sql, $options);
    }

    /**
     * Lookup rows in a table.
     *
     * Note that if no KeySet is specified, all rows in a table will be
     * returned.
     *
     * Example:
     * ```
     * $keySet = $spanner->keySet([
     *     'keys' => [10]
     * ]);
     *
     * $result = $database->read('Posts', [
     *     'keySet' => $keySet
     * ]);
     * ```
     *
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
    public function read($table, KeySet $keySet, array $columns, array $options = [])
    {
        $options['transactionType'] = $this->context;
        $options['transactionId'] = $this->transactionId;

        list($transactionOptions, $context) = $this->transactionSelector($options);
        $options['transaction'] = $transactionOptions;
        $options['transactionContext'] = $context;

        return $this->operation->read($this->session, $table, $keySet, $columns, $options);
    }

    /**
     * Retrieve the Transaction ID.
     *
     * Example:
     * ```
     * $id = $transaction->id();
     * ```
     *
     * @return string
     */
    public function id()
    {
        return $this->transactionId;
    }
}
