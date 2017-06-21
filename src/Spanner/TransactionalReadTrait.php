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

use Google\Cloud\Spanner\Session\SessionPoolInterface;

/**
 * Shared methods for reads inside a transaction.
 */
trait TransactionalReadTrait
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
     * @var int
     */
    private $type;

    /**
     * @var int
     */
    private $state = self::STATE_ACTIVE;

    /**
     * @var array
     */
    private $options = [];

    /**
     * Run a query.
     *
     * @param string $sql The query string to execute.
     * @param array $options [optional] {
     *     Configuration options.
     *
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
     * @return Result
     */
    public function execute($sql, array $options = [])
    {
        $this->singleUseState();
        $this->checkReadContext();

        $options['transactionId'] = $this->transactionId;
        $options['transactionType'] = $this->context;

        $selector = $this->transactionSelector($options, $this->options);

        $options['transaction'] = $selector[0];

        return $this->operation->execute($this->session, $sql, $options);
    }

    /**
     * Lookup rows in a table.
     *
     * @param string $table The table name.
     * @param KeySet $keySet The KeySet to select rows.
     * @param array $columns A list of column names to return.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $index The name of an index on the table.
     *     @type int $limit The number of results to return.
     * }
     * @return Result
     */
    public function read($table, KeySet $keySet, array $columns, array $options = [])
    {
        $this->singleUseState();
        $this->checkReadContext();

        $options['transactionId'] = $this->transactionId;
        $options['transactionType'] = $this->context;
        $options += $this->options;
        $selector = $this->transactionSelector($options, $this->options);

        $options['transaction'] = $selector[0];

        return $this->operation->read($this->session, $table, $keySet, $columns, $options);
    }

    /**
     * Retrieve the Transaction ID.
     *
     * @return string|null
     */
    public function id()
    {
        return $this->transactionId;
    }

    /**
     * Get the Transaction Type.
     *
     * @return int
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * Check the transaction state, and update as necessary for single-use transactions.
     *
     * @return bool true if transaction is single use, false otherwise.
     * @throws \BadMethodCallException
     */
    private function singleUseState()
    {
        if ($this->type === self::TYPE_SINGLE_USE) {
            if ($this->state === self::STATE_SINGLE_USE_USED) {
                throw new \BadMethodCallException('This single-use transaction has already been used.');
            }

            $this->state = self::STATE_SINGLE_USE_USED;

            return true;
        }

        return false;
    }

    /**
     * Check whether the context is valid for a read operation. Reads are not
     * allowed in single-use read-write transactions.
     *
     * @throws \BadMethodCallException
     */
    private function checkReadContext()
    {
        if ($this->type === self::TYPE_SINGLE_USE && $this->context === SessionPoolInterface::CONTEXT_READWRITE) {
            throw new \BadMethodCallException('Cannot use a single-use read-write transaction for read or execute.');
        }
    }
}
