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

use Google\ApiCore\ValidationException;
use Google\Cloud\Core\Exception\AbortedException;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;

/**
 * Manages interaction with Cloud Spanner inside a Transaction.
 *
 * Transactions can be started via
 * {@see \Google\Cloud\Spanner\Database::runTransaction()} (recommended) or via
 * {@see \Google\Cloud\Spanner\Database::transaction()}. Transactions should
 * always call {@see \Google\Cloud\Spanner\Transaction::commit()} or
 * {@see \Google\Cloud\Spanner\Transaction::rollback()} to ensure that locks are
 * released in a timely manner.
 *
 * If you do not plan on performing any writes in your transaction, a
 * {@see \Google\Cloud\Spanner\Snapshot} is a better solution which does not
 * require a commit or rollback and does not lock any data.
 *
 * Transactions may raise {@see \Google\Cloud\Core\Exception\AbortedException} errors
 * when the transaction cannot complete for any reason. In this case, the entire
 * operation (all reads and writes) should be reapplied atomically. Google Cloud
 * PHP handles this transparently when using
 * {@see \Google\Cloud\Spanner\Database::runTransaction()}. In other cases, it is
 * highly recommended that applications implement their own retry logic.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 *
 * $database = $spanner->connect('my-instance', 'my-database');
 *
 * $database->runTransaction(function (Transaction $t) {
 *     // do stuff.
 *
 *     $t->commit();
 * });
 * ```
 *
 * ```
 * // Get a transaction to manage manually.
 * $transaction = $database->transaction();
 * ```
 */
class Transaction implements TransactionalReadInterface
{
    use MutationTrait;
    use TransactionalReadTrait;

    /**
     * @var CommitStats
     */
    private $commitStats = [];

    /**
     * @var array
     */
    private $mutations = [];

    /**
     * @var bool
     */
    private $isRetry = false;

    private ValueMapper $mapper;

    /**
     * @param Operation $operation The Operation instance.
     * @param Session $session The session to use for spanner interactions.
     * @param string $transactionId [optional] The Transaction ID. If no ID is
     *        provided, the Transaction will be a Single-Use Transaction.
     * @param bool $isRetry Whether the transaction will automatically retry or not.
     * @param string $tag A transaction tag. Requests made using this transaction will
     *        use this as the transaction tag.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type array $begin The begin Transaction options.
     *           [Refer](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#transactionoptions)
     * }
     * @param ValueMapper $mapper Consumed internally for properly map mutation data.
     * @throws \InvalidArgumentException if a tag is specified on a single-use transaction.
     */
    public function __construct(
        Operation $operation,
        Session $session,
        $transactionId = null,
        $isRetry = false,
        $tag = null,
        $options = [],
        $mapper = null
    ) {
        $this->operation = $operation;
        $this->session = $session;
        $this->transactionId = $transactionId;
        $this->isRetry = $isRetry;

        $this->type = ($transactionId || isset($options['begin']))
            ? self::TYPE_PRE_ALLOCATED
            : self::TYPE_SINGLE_USE;

        if ($this->type == self::TYPE_SINGLE_USE && isset($tag)) {
            throw new \InvalidArgumentException(
                'Cannot set a transaction tag on a single-use transaction.'
            );
        }
        $this->tag = $tag;

        $this->context = SessionPoolInterface::CONTEXT_READWRITE;
        $this->options = $options;
        if (!is_null($mapper)) {
            $this->mapper = $mapper;
        }
    }

    /**
     * Get the commit stats for this transaction. Commit stats are only available after commit has been called with
     * `return_commit_stats` => true. If commit is called multiple times, only the commitStats for the last commit will
     * be available.
     *
     * Example:
     * ```
     * $transaction->commit(["returnCommitStats" => true]);
     * $commitStats = $transaction->getCommitStats();
     * ```
     *
     * @return array The commit stats
     */
    public function getCommitStats()
    {
        return $this->commitStats;
    }

    /**
     * Execute a Cloud Spanner DML statement.
     *
     * Data Manipulation Language (DML) allows you to execute statements which
     * modify the state of the database (i.e. inserting, updating or deleting
     * rows). DML supports INSERT, UPDATE and DELETE statements. For
     * more on DML syntax, visit the
     * [DML syntax guide](https://cloud.google.com/spanner/docs/dml-syntax).
     *
     * To execute a SQL query (such as a SELECT), use
     * {@see \Google\Cloud\Spanner\Transaction::execute()}.
     *
     * Mutations performed via DML will be visible to subsequent operations
     * within the same transaction. In other words, unlike with other mutation
     * methods provided, you can read your uncommitted writes. If a transaction
     * is not committed (either because of a rollback or error), the DML writes
     * will not be applied.
     *
     * Example:
     * ```
     * $modifiedRowCount = $transaction->executeUpdate('UPDATE Posts SET content = @content WHERE id = @id', [
     *     'parameters' => [
     *         'content' => 'Hello world!',
     *         'id' => 10
     *     ]
     * ]);
     * ```
     *
     * ```
     * // Example of executeUpdate while using DML Structs
     * $statement = "UPDATE Posts SET title = 'Updated Title' " .
     *     "WHERE STRUCT<Title STRING, Content STRING>(Title, Content) = @post";
     *
     * $postValue = new StructValue();
     * $postValue->add('Title', 'Updated Title')
     *           ->add('Content', 'Sample Content');
     *
     * $postType = new StructType();
     * $postType->add('Title', Database::TYPE_STRING)
     *          ->add('Content', Database::TYPE_STRING);
     *
     * $modifiedRowCount = $transaction->executeUpdate($statement, [
     *     'parameters' => [
     *         'post' => $postValue
     *     ],
     *     'types' => [
     *         'post' => $postType
     *     ]
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.ExecuteSqlRequest ExecuteSqlRequest
     * @see https://cloud.google.com/spanner/docs/dml-syntax DML Syntax Guide
     * @codingStandardsIgnoreEnd
     *
     * @param string $sql The query string to execute.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type array $parameters A key/value array of Query Parameters, where
     *           the key is represented in the query string prefixed by a `@`
     *           symbol.
     *     @type array $types A key/value array of Query Parameter types.
     *           Generally, Google Cloud PHP can infer types. Explicit type
     *           declarations are required in the case of struct parameters,
     *           or when a null value exists as a parameter.
     *           Accepted values for primitive types are defined as constants on
     *           {@see \Google\Cloud\Spanner\Database}, and are as follows:
     *           `Database::TYPE_BOOL`, `Database::TYPE_INT64`,
     *           `Database::TYPE_FLOAT64`, `Database::TYPE_TIMESTAMP`,
     *           `Database::TYPE_DATE`, `Database::TYPE_STRING`,
     *           `Database::TYPE_BYTES`. If the value is an array, use
     *           {@see \Google\Cloud\Spanner\ArrayType} to declare the array
     *           parameter types. Likewise, for structs, use
     *           {@see \Google\Cloud\Spanner\StructType}.
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as the transaction tag should have already
     *         been set when creating the transaction.
     * }
     * @return int The number of rows modified.
     */
    public function executeUpdate($sql, array $options = [])
    {
        if (isset($options['transaction']['begin']['excludeTxnFromChangeStreams'])) {
            throw new ValidationException(
                'The excludeTxnFromChangeStreams option cannot be set for individual DML requests.'
                . ' This option should be set at the transaction level.'
            );
        }
        $options = $this->buildUpdateOptions($options);
        return $this->operation
            ->executeUpdate($this->session, $this, $sql, $options);
    }

    /**
     * Execute multiple DML statements.
     *
     * This method allows many statements to be run with lower latency than
     * submitting them sequentially with
     * {@see \Google\Cloud\Spanner\Transaction::executeUpdate()}.
     *
     * Statements are executed in order, sequentially. Execution will stop at
     * the first failed statement; the remaining statements will not be run.
     *
     * Please note that in the case of failure of any provided statement, this
     * method will NOT throw an exception. Rather, check the `successful` key
     * in the returned array. If `successful` is false, some statements may have
     * been applied; you must inspect the `results` key in the returned array to
     * find the first failed statement. Error details are returned inline with
     * the first failed statement. Subsequent statements after an error will
     * never be applied.
     *
     * Example:
     * ```
     * use Google\Cloud\Spanner\Database;
     *
     * $res = $transaction->executeUpdateBatch([
     *     [
     *         'sql' => 'UPDATE posts SET post_status = @status WHERE author_id = @authorId',
     *         'parameters' => [
     *             'status' => 'unpublished',
     *             'authorId' => 1
     *         ]
     *     ], [
     *         'sql' => 'UPDATE authors SET author_permissions = @permissions WHERE author_id = @authorId',
     *         'parameters' => [
     *             'permissions' => null,
     *             'authorId' => 1
     *         ],
     *         'types' => [
     *             'permissions' => Database::TYPE_ARRAY
     *         ]
     *     ]
     * ]);
     *
     * if ($res->error()) {
     *     echo 'An error occurred: ' . $res->error()['status']['message'];
     * } else {
     *     echo 'Updated ' . array_sum($res->rowCounts()) . ' row(s) ' .
     *          'across ' . count($res->rowCounts()) . ' statement(s)';
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.ExecuteBatchDmlRequest ExecuteBatchDmlRequest
     * @codingStandardsIgnoreEnd
     *
     * @param array[] $statements A list of DML statements to run. Each statement
     *        must contain a `sql` key, where the value is a DML string. If the
     *        DML contains placeholders, values are provided as a key/value array
     *        in key `parameters`. If parameter types are required, they must be
     *        provided in key `types`. Generally, Google Cloud PHP can
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
     *         Please note, the `transactionTag` setting will be ignored as the transaction tag should have already
     *         been set when creating the transaction.
     * }
     * @return BatchDmlResult
     * @throws \InvalidArgumentException If any statement is missing the `sql` key.
     */
    public function executeUpdateBatch(array $statements, array $options = [])
    {
        $options = $this->buildUpdateOptions($options);
        return $this->operation
            ->executeUpdateBatch(
                $this->session,
                $this,
                $statements,
                $options
            );
    }

    /**
     * Roll back a transaction.
     *
     * Rolls back a transaction, releasing any locks it holds. It is a good idea
     * to call this for any transaction that includes one or more Read or
     * ExecuteSql requests and ultimately decides not to commit.
     *
     * This closes the transaction, preventing any future API calls inside it.
     *
     * Rollback will NOT error if the transaction is not found or was already aborted.
     *
     * Example:
     * ```
     * $transaction->rollback();
     * ```
     *
     * @param array $options [optional] Configuration Options.
     * @return void
     */
    public function rollback(array $options = [])
    {
        if ($this->state !== self::STATE_ACTIVE) {
            throw new \BadMethodCallException('The transaction cannot be rolled back because it is not active');
        }

        if ($this->type === self::TYPE_SINGLE_USE) {
            throw new \BadMethodCallException('Cannot roll back a single-use transaction.');
        }

        $this->state = self::STATE_ROLLED_BACK;

        $this->operation->rollback($this->session, $this->transactionId, $options);
    }

    /**
     * Commit and end the transaction.
     *
     * It is advised that transactions be run inside
     * {@see \Google\Cloud\Spanner\Database::runTransaction()} in order to take
     * advantage of automated transaction retry in case of a transaction aborted
     * error.
     *
     * Example:
     * ```
     * $transaction->commit();
     * ```
     *
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type array $mutations An array of mutations to commit. May be used
     *           instead of or in addition to enqueing mutations separately.
     *     @type bool $returnCommitStats If true, commit statistics will be
     *           returned and accessible via {@see \Google\Cloud\Spanner\Transaction::getCommitStats()}.
     *           **Defaults to** `false`.
     *     @type Duration $maxCommitDelay The amount of latency this request
     *           is willing to incur in order to improve throughput.
     *           **Defaults to** null.
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see \Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `requestTag` setting will be ignored as it is not supported for commit requests.
     * }
     * @return Timestamp The commit timestamp.
     * @throws \BadMethodCall If the transaction is not active or already used.
     * @throws AbortedException If the commit is aborted for any reason.
     */
    public function commit(array $options = [])
    {
        if ($this->state !== self::STATE_ACTIVE) {
            throw new \BadMethodCallException('The transaction cannot be committed because it is not active');
        }

        // For commit, A transaction ID is mandatory for non-single-use transactions,
        // and the `begin` option is not supported.
        if (empty($this->transactionId) && isset($this->options['begin'])) {
            // Since the begin option is not supported in commit, unset it.
            unset($this->options['begin']);

            // A transaction ID is mandatory for non-single-use transactions.
            if ($this->type !== self::TYPE_SINGLE_USE) {
                // Execute the beginTransaction RPC.
                $transaction = $this->operation->transaction($this->session, $this->options);
                // Set the transaction ID of the current transaction.
                $this->transactionId = $transaction->id();
            }
        }

        if (!$this->singleUseState()) {
            $this->state = self::STATE_COMMITTED;
        }

        $options += [
            'mutations' => [],
            'requestOptions' => []
        ];

        $options['mutations'] += $this->getMutations();

        $options['transactionId'] = $this->transactionId;

        unset($options['requestOptions']['requestTag']);
        if (isset($this->tag)) {
            $options['requestOptions']['transactionTag'] = $this->tag;
        }

        $t = $this->transactionOptions($options);

        $options[$t[1]] = $t[0];

        $res = $this->operation->commitWithResponse($this->session, $this->pluck('mutations', $options), $options);
        if (isset($res[1]['commitStats'])) {
            $this->commitStats = $res[1]['commitStats'];
        }

        return $res[0];
    }

    /**
     * Retrieve the Transaction State.
     *
     * Will be one of `Transaction::STATE_ACTIVE`,
     * `Transaction::STATE_COMMITTED`, or `Transaction::STATE_ROLLED_BACK`.
     *
     * Example:
     * ```
     * $state = $transaction->state();
     * ```
     *
     * @return int
     */
    public function state()
    {
        return $this->state;
    }

    /**
     * Check whether the current transaction is a retry transaction.
     *
     * When using {@see \Google\Cloud\Spanner\Database::runTransaction()},
     * transactions are automatically retried when a conflict causes it to abort.
     * In such cases, subsequent invocations of the transaction callable will
     * provide a transaction where `$transaction->isRetry()` is true. This can
     * be useful for debugging and understanding how code is working.
     *
     * Example:
     * ```
     * if ($transaction->isRetry()) {
     *     echo 'This is a retry transaction!';
     * }
     * ```
     *
     * @return bool
     */
    public function isRetry()
    {
        return $this->isRetry;
    }

    /**
     * Build the update options.
     *
     * @param array $options The update options
     * @return array
     */
    private function buildUpdateOptions(array $options): array
    {
        unset($options['requestOptions']['transactionTag']);
        if (isset($this->tag)) {
            $options['requestOptions']['transactionTag'] = $this->tag;
        }
        $options['seqno'] = $this->seqno;
        $this->seqno++;

        $options['transactionType'] = $this->context;
        if (empty($this->transactionId) && isset($this->options['begin'])) {
            $options['begin'] = $this->options['begin'];
        } else {
            $options['transactionId'] = $this->transactionId;
        }
        $selector = $this->transactionSelector($options);
        $options['transaction'] = $selector[0];

        return $this->addLarHeader($options);
    }
}
