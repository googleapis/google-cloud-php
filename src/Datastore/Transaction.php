<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Datastore;

/**
 * Represents a Transaction
 *
 * A transaction is a set of Datastore operations on one or more entities. Each
 * transaction is guaranteed to be atomic, which means that transactions are
 * never partially applied. Either all of the operations in the transaction are
 * applied, or none of them are applied.
 *
 * It is highly recommended that users read and understand the underlying
 * concepts in [Transactions](https://cloud.google.com/datastore/docs/concepts/transactions)
 * before beginning.
 *
 * @see https://cloud.google.com/datastore/docs/concepts/transactions Transactions
 */
class Transaction
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var transactionId
     */
    private $transactionId;

    /**
     * @param ConnectionInterface $connection A connection Google Cloud Datastore
     * @param string $projectId The Cloud Platform Project ID
     * @param string $transactionId A unique indentifier representing the transaction
     */
    public function __construct($connection, $projectId, $transactionId)
    {
        $this->connection = $connection;
        $this->projectId = $projectId;
        $this->transactionId = $transactionId;
    }

    /**
     * Get the transaction ID
     *
     * Example:
     * ```
     * echo $transaction->id();
     * ```
     *
     * @return string
     */
    public function id()
    {
        return $this->transactionId;
    }

    /**
     * Rollback a transaction
     *
     * Example:
     * ```
     * $transaction->rollback();
     * ```
     *
     * @param array $options Configuration Options
     * @return void
     */
    public function rollback(array $options = [])
    {
        $this->connection->rollback($options + [
            'projectId' => $this->projectId,
            'transaction' => $this->transactionId
        ]);
    }

    /**
     * Present a nicer debug result to people using php 5.6 or greater.
     * @return array
     * @codeCoverageIgnore
     * @access private
     */
    public function __debugInfo()
    {
        return [
            'transactionId' => $this->transactionId,
            'projectId' => $this->projectId,
            'connection' => get_class($this->connection)
        ];
    }
}
