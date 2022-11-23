<?php
/**
 * Copyright 2022 Google Inc.
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

namespace Google\Cloud\Firestore;

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\DebugInfoTrait;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Core\ValidateTrait;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\FieldValue\DeleteFieldValue;
use Google\Cloud\Firestore\FieldValue\DocumentTransformInterface;
use Google\Cloud\Firestore\FieldValue\FieldValueInterface;
use Google\Rpc\Code;

/**
 * Enqueue and write multiple mutations to Cloud Firestore.
 *
 * This class may be used directly for multiple non-transactional writes with
 * automatic retry on failure. To run changes in a transaction (with automatic
 * retry/rollback on failure), use {@see Google\Cloud\Firestore\Transaction}.
 * Single modifications can be made using the various methods on
 * {@see Google\Cloud\Firestore\DocumentReference}.
 *
 * Example:
 * ```
 * use Google\Cloud\Firestore\FirestoreClient;
 *
 * $firestore = new FirestoreClient();
 * $batch = $firestore->bulkWriter();
 * ```
 */
class BulkWriter
{
    use ArrayTrait;
    use DebugInfoTrait;
    use TimeTrait;
    use ValidateTrait;

    const TYPE_UPDATE = 'update';
    const TYPE_SET = 'set';
    const TYPE_CREATE = 'create';
    const TYPE_DELETE = 'delete';
    const TYPE_TRANSFORM = 'transform';

    /**
     * @var array Holds default configurations for Bulkwriter.
     * These values are experiementally derived after performance evaluations.
     * The underlying constants may change in backwards-incompatible ways.
     * Please use with caution, and test thoroughly when upgrading.
     */
    private static $defaultOptions = [
        /** The maximum number of writes that can be in a single batch. */
        'MAX_BATCH_SIZE' => 20,
        /** The maximum number of writes that can be in a batch containing retries. */
        'RETRY_MAX_BATCH_SIZE' => 20,
        /**
         * The maximum number of retries that will be attempted with backoff before stopping all retry
         * attempts.
         */
        'MAX_RETRY_ATTEMPTS' => 10,
        /**
         * The default initial backoff time in milliseconds after an error. Set to 1s according to
         * https://cloud.google.com/apis/design/errors.
         */
        'DEFAULT_BACKOFF_INITIAL_DELAY_MS' => 500,
        /** The default maximum backoff time in milliseconds when retrying an operation. */
        'DEFAULT_BACKOFF_MAX_DELAY_MS' => 60 * 1000,
        /** The default factor to increase the backup by after each failed attempt. */
        'DEFAULT_BACKOFF_FACTOR' => 1.5,
        /**
         * The default jitter to apply to the exponential backoff used in retries.
         * For example, a factor of 0.3 means a 30% jitter is applied.
         */
        'DEFAULT_JITTER_FACTOR' => 0.3,
        /**
         * The starting maximum number of operations per second as allowed by the 500/50/5 rule.
         *
         * @see [Ramping up traffic](https://cloud.google.com/firestore/docs/best-practices#ramping_up_traffic)
         */
        'DEFAULT_STARTING_MAXIMUM_OPS_PER_SECOND' => 20,
        /**
         * The maximum number of operations per second as allowed by the 500/50/5 rule.
         *
         * @see [Ramping up traffic](https://cloud.google.com/firestore/docs/best-practices#ramping_up_traffic)
         */
        'DEFAULT_MAXIMUM_OPS_PER_SECOND_LIMIT' => 500,
        /**
         * The rate by which to increase the capacity as specified by the 500/50/5 rule.
         *
         * @see [Ramping up traffic](https://cloud.google.com/firestore/docs/best-practices#ramping_up_traffic)
         */
        'RATE_LIMITER_MULTIPLIER' => 1.5,
        /**
         * How often the operations per second capacity should increase in milliseconds as specified by
         * the 500/50/5 rule.
         *
         * @see [Ramping up traffic](https://cloud.google.com/firestore/docs/best-practices#ramping_up_traffic)
         */
        'RATE_LIMITER_MULTIPLIER_MILLIS' => 1000,
    ];

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var ValueMapper
     */
    private $valueMapper;

    /**
     * @var string
     */
    private $database;

    /**
     * @var string|null
     */
    private $transaction;

    /**
     * @var bool
     */
    private $isLegacyWriteBatch;

    /**
     * @var int
     */
    private $maxBatchSize;

    /**
     * @var array
     */
    private $writes = [];

    /**
     * @var array
     */
    private $finalResponse = [];

    /**
     * Rate limiter used to throttle requests as per the 500/50/5 rule.
     *
     * @var RateLimiter
     */
    private $rateLimiter;

    /**
     * @var array {
     *     Failed mutations scheduled for retry. Each retry has following fields:
     *
     *     @type int $num_failed_attempts Number of past failures.
     *     @type int $scheduled_in_millis Latest timestamp in millis when retry
     *           can be attempted.
     *     @type int $backoff_in_millis Backoff time in millis included in
     *           `scheduled_in_millis`.
     * }
     */
    private $retryScheduledWrites = [];

    /**
     * @var callable Sets the conditions for whether or not a write should
     * be attempted to retry.
     */
    private $isRetryable;

    /**
     * @var array All unique documents added to mutate.
     */
    private $uniqueDocuments = [];

    /**
     * @var bool Whether this BulkWriter instance is closed.
     * Once closed, it cannot be opened again.
     */
    private $closed;

    /**
     * @var bool Whether BulkWriter greedily sends operations via
     * [https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#batchwriterequest](BatchWriteRequest)
     * as soon  as sufficient number of operations are enqueued.
     */
    private $greedilySend;

    /**
     * @var int The maximum delay time in millis for rescheduling a failed
     * mutation or awaiting a batch creation.
     */
    private $maxDelayTime;

    /**
     * @param ConnectionInterface $connection A connection to Cloud Firestore
     * @param ValueMapper $valueMapper A Value Mapper instance
     * @param string $database The current database
     * @param array $options [optional] {
     *     Configuration options is an array.
     *
     *     Please note that the default values are experiementally derived after
     *     performance evaluations. The underlying constants may change in backwards-
     *     incompatible ways. Please use with caution, and test thoroughly when
     *     upgrading.
     *
     *     For legacy reasons if provided as `string` or `null`, its assumed
     *     to be transaction id for Google\Cloud\Firestore\WriteBatch.
     *
     *     @type int $maxBatchSize Maximum number of requests per BulkWriter batch.
     *           **Defaults to** `20`.
     *     @type bool $greedilySend Flag to indicate whether BulkWriter greedily
     *           sends batches. **Defaults to** `true`.
     *     @type bool $isThrottlingEnabled Flag to indicate whether rate of
     *           sending writes can be throttled. **Defaults to** `true`.
     *     @type int $initialOpsPerSecond Initial number of operations per second.
     *           **Defaults to** `20`.
     *     @type int $maxOpsPerSecond Maximum number of operations per second.
     *           **Defaults to** `500`.
     *     @type callable $isRetryable Default retry handler for individial writes
     *           status code to be retried. Should accept error code and return
     *           true if retryable.
     * }
     */
    public function __construct(ConnectionInterface $connection, $valueMapper, $database, $options = null)
    {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->database = $database;
        $this->closed = false;
        $this->isLegacyWriteBatch = false;
        $this->maxDelayTime = self::$defaultOptions['DEFAULT_BACKOFF_MAX_DELAY_MS'];
        if (is_null($options) || !is_array($options)) {
            // convert to transaction id for legacy WriteBatch
            $this->transaction = $options;
            $this->isLegacyWriteBatch = true;
            $options = [];
        }
        $this->finalResponse = [
            'writeResults' => [],
            'status' => [],
        ];
        $options += [
            'maxBatchSize' => self::$defaultOptions['MAX_BATCH_SIZE'],
            'greedilySend' => true,
            'isThrottlingEnabled' => true,
            'initialOpsPerSecond' => self::$defaultOptions['DEFAULT_STARTING_MAXIMUM_OPS_PER_SECOND'],
            'maxOpsPerSecond' => self::$defaultOptions['DEFAULT_MAXIMUM_OPS_PER_SECOND_LIMIT'],
            'isRetryable' => $this->defaultWriteErrorHandler(),
        ];
        $this->isRetryable = $this->pluck('isRetryable', $options);
        $this->maxBatchSize = $this->pluck('maxBatchSize', $options);
        $this->greedilySend = $this->pluck('greedilySend', $options);
        if ($options['initialOpsPerSecond'] < 1) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Value for argument "initialOpsPerSecond" must be greater than 1, but was: %s',
                    $options['initialOpsPerSecond']
                )
            );
        }
        if ($options['maxOpsPerSecond'] < 1) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Value for argument "maxOpsPerSecond" must be greater than 1, but was: %s',
                    $options['maxOpsPerSecond']
                )
            );
        }
        if ($options['initialOpsPerSecond'] > $options['maxOpsPerSecond']) {
            throw new \InvalidArgumentException(
                "'maxOpsPerSecond' cannot be less than 'initialOpsPerSecond'."
            );
        }
        if ($options['isThrottlingEnabled'] === false) {
            $this->rateLimiter = new RateLimiter(
                PHP_INT_MAX,
                PHP_INT_MAX,
                PHP_INT_MAX,
                PHP_INT_MAX
            );
        } else {
            $startingRate = $options['initialOpsPerSecond'];
            $maxRate = $options['maxOpsPerSecond'];
            // The initial validation step ensures that the maxOpsPerSecond is
            // greater than initialOpsPerSecond. If this inequality is true, that
            // means initialOpsPerSecond was not set and maxOpsPerSecond is less
            // than the default starting rate.
            if ($maxRate < $startingRate) {
                $startingRate = $maxRate;
            }
            // Ensure that the batch size is not larger than the number of allowed
            // operations per second.
            if ($startingRate < $this->maxBatchSize) {
                $this->maxBatchSize = $startingRate;
            }
            $this->rateLimiter = new RateLimiter(
                $startingRate,
                self::$defaultOptions['RATE_LIMITER_MULTIPLIER'],
                self::$defaultOptions['RATE_LIMITER_MULTIPLIER_MILLIS'],
                $maxRate
            );
        }
    }

    /**
     * Enqueue a document creation.
     *
     * This operation will fail (when committed) if the document already exists.
     *
     * Example:
     * ```
     * $batch->create($documentName, [
     *     'name' => 'John'
     * ]);
     * ```
     *
     * @param DocumentReference|string $document The document to target, either
     *        as a string document name, or DocumentReference object. Please
     *        note that DocumentReferences will be used only for the document
     *        name. Field data must be provided in the `$fields` argument.
     * @param array $fields An array containing fields, where keys are the field
     *        names, and values are field values. Nested arrays are allowed.
     *        Note that unlike {@see Google\Cloud\Firestore\DocumentReference::update()},
     *        field paths are NOT supported by this method.
     * @param array $options Configuration options
     * @return BulkWriter
     * @throws \InvalidArgumentException If `FieldValue::deleteField()` is found in the fields list.
     * @throws \InvalidArgumentException If `FieldValue::serverTimestamp()` is found in an array value.
     */
    public function create($document, array $fields, array $options = [])
    {
        $this->checkWriterConditions($document);
        // Record whether the document is empty before any filtering.
        $emptyDocument = count($fields) === 0;

        list($fields, $sentinels, $metadata) = $this->filterFields($fields);

        if ($metadata['hasDelete']) {
            throw new \InvalidArgumentException('Cannot delete fields when creating a document.');
        }

        // Cannot create a document that already exists!
        $precondition = ['exists' => false];

        // Enqueue an update operation if an empty document was provided,
        // or if there are still fields after filtering.
        $transformOptions = [];
        if (!empty($fields) || $emptyDocument) {
            $this->writes[] = $this->createDatabaseWrite(self::TYPE_CREATE, $document, [
                'fields' => $this->valueMapper->encodeValues($fields),
                'precondition' => $precondition,
            ] + $options);
        } else {
            // If no UPDATE mutation is enqueued, we need the precondition applied
            // to the transform mutation.
            $transformOptions = [
                'precondition' => $precondition,
            ];
        }

        // document transform operations are enqueued as a separate mutation.
        $this->enqueueTransforms($document, $sentinels, $transformOptions);

        return $this;
    }

    /**
     * Enqueue a set mutation.
     *
     * Unless `$options['merge']` is set to `true, this method replaces all
     * fields in a Firestore document.
     *
     * Example:
     * ```
     * $batch->set($documentName, [
     *     'name' => 'John'
     * ]);
     *
     * @codingStandardsIgnoreStart
     * @param DocumentReference|string $document The document to target, either
     *        as a string document name, or DocumentReference object. Please
     *        note that DocumentReferences will be used only for the document
     *        name. Field data must be provided in the `$fields` argument.
     * @param array $fields An array containing fields, where keys are the field
     *        names, and values are field values. Nested arrays are allowed.
     *        Note that unlike {@see Google\Cloud\Firestore\BulkWriter::update()},
     *        field paths are NOT supported by this method.
     * @param array $options {
     *     Configuration Options
     *
     *     @type bool $merge If true, unwritten fields will be preserved.
     *           Otherwise, they will be overwritten (removed). **Defaults to**
     *           `false`.
     * }
     * @return BulkWriter
     * @codingStandardsIgnoreEnd
     * @throws \InvalidArgumentException If `FieldValue::deleteField()` is found in the document when `$options.merge`
     *         is not `true`.
     * @throws \InvalidArgumentException If `FieldValue::serverTimestamp()` is found in an array value.
     */
    public function set($document, array $fields, array $options = [])
    {
        $this->checkWriterConditions($document);
        $merge = $this->pluck('merge', $options, false) ?: false;

        // Record whether the document is empty before any filtering.
        $emptyDocument = count($fields) === 0;

        list($fields, $sentinels, $metadata) = $this->filterFields($fields);

        if (!$merge && $metadata['hasDelete']) {
            throw new \InvalidArgumentException('Delete cannot appear in data unless `$options[\'merge\']` is set.');
        }

        // Enqueue a write if any of the following conditions are met
        // - if there are still fields remaining after sentinels were removed
        // - if the user provided an empty set to begin with
        // - if the user provided only transform sentinel values AND did not specify merge behavior
        // - if the user provided only delete sentinel field values.

        $updateNotRequired = count($fields) === 0
            && !$emptyDocument
            && !$metadata['hasUpdateMask']
            && $metadata['hasTransform'];

        $shouldEnqueueUpdate = $fields
            || $emptyDocument
            || ($updateNotRequired && !$merge)
            || $metadata['hasUpdateMask'];

        if ($shouldEnqueueUpdate) {
            $write = [];
            $write['fields'] = $this->valueMapper->encodeValues($fields);

            if ($merge) {
                $write['updateMask'] = $this->pathsToStrings($this->encodeFieldPaths($fields), $sentinels);
            }

            $this->writes[] = $this->createDatabaseWrite(self::TYPE_SET, $document, array_merge($options, $write));
        }

        // document transform operations are enqueued as a separate mutation.
        $this->enqueueTransforms($document, $sentinels, $options);

        return $this;
    }

    /**
     * Enqueue an update with field paths and values.
     *
     * Merges provided data with data stored in Firestore.
     *
     * Calling this method on a non-existent document will raise an exception.
     *
     * This method supports various sentinel values, to perform special operations
     * on fields. Available sentinel values are provided as methods, found in
     * {@see Google\Cloud\Firestore\FieldValue}.
     *
     * Note that field names must be provided using field paths, encoded either
     * as a dot-delimited string (i.e. `foo.bar`), or an instance of
     * {@see Google\Cloud\Firestore\FieldPath}. Nested arrays are not allowed.
     *
     * Please note that conflicting paths will result in an exception. Paths
     * conflict when one path indicates a location nested within another path.
     * For instance, path `a.b` cannot be set directly if path `a` is also
     * provided.
     *
     * Example:
     * ```
     * $batch->update($documentName, [
     *     ['path' => 'name', 'value' => 'John'],
     *     ['path' => 'country', 'value' => 'USA'],
     *     ['path' => 'cryptoCurrencies.bitcoin', 'value' => 0.5],
     *     ['path' => 'cryptoCurrencies.ethereum', 'value' => 10],
     *     ['path' => 'cryptoCurrencies.litecoin', 'value' => 5.51]
     * ]);
     * ```
     *
     * ```
     * // Google Cloud PHP provides special field values to enable operations such
     * // as deleting fields or setting the value to the current server timestamp.
     * use Google\Cloud\Firestore\FieldValue;
     *
     * $batch->update($documentName, [
     *     ['path' => 'country', 'value' => FieldValue::deleteField()],
     *     ['path' => 'lastLogin', 'value' => FieldValue::serverTimestamp()]
     * ]);
     * ```
     *
     * ```
     * // If your field names contain special characters (such as `.`, or symbols),
     * // using {@see Google\Cloud\Firestore\FieldPath} will properly escape each element.
     *
     * use Google\Cloud\Firestore\FieldPath;
     *
     * $batch->update($documentName, [
     *     ['path' => new FieldPath(['cryptoCurrencies', 'big$$$coin']), 'value' => 5.51]
     * ]);
     * ```
     *
     * @param DocumentReference|string $document The document to target, either
     *        as a string document name, or DocumentReference object. Please
     *        note that DocumentReferences will be used only for the document
     *        name. Field data must be provided in the `$data` argument.
     * @param array[] $data A list of arrays of form
     *        `[FieldPath|string $path, mixed $value]`.
     * @param array $options Configuration options
     * @return BulkWriter
     * @throws \InvalidArgumentException If data is given in an invalid format
     *         or is empty.
     * @throws \InvalidArgumentException If any field paths are empty.
     * @throws \InvalidArgumentException If field paths conflict.
     */
    public function update($document, array $data, array $options = [])
    {
        $this->checkWriterConditions($document);
        if (!$data || $this->isAssoc($data)) {
            throw new \InvalidArgumentException(
                'Field data must be provided as a list of arrays of form `[string|FieldPath $path, mixed $value]`.'
            );
        }

        $paths = [];
        $fields = [];
        foreach ($data as $field) {
            $this->arrayHasKeys($field, ['path', 'value']);

            $path = ($field['path'] instanceof FieldPath)
                ? $field['path']
                : FieldPath::fromString($field['path']);

            if (!$path->path()) {
                throw new \InvalidArgumentException('Field Path cannot be empty.');
            }

            $paths[] = $path;

            $keys = $path->path();
            $num = count($keys);

            // Construct a nested array to represent a nested field path.
            // For instance, `a.b.c` = 'foo' will become
            // `['a' => ['b' => ['c' => 'foo']]]`
            $val = $field['value'];
            foreach (array_reverse($keys) as $index => $key) {
                if ($num >= $index + 1) {
                    $val = [
                        $key => $val,
                    ];
                }
            }

            $fields = $this->arrayMergeRecursive($fields, $val);
        }

        if (count(array_unique($paths)) !== count($paths)) {
            throw new \InvalidArgumentException('Duplicate field paths are not allowed.');
        }

        // Record whether the document is empty before any filtering.
        $emptyDocument = count($fields) === 0;

        list($fields, $sentinels, $metadata) = $this->filterFields($fields, $paths);

        // to conform to specification.
        if (isset($options['precondition']['exists'])) {
            throw new \InvalidArgumentException('Exists preconditions are not supported by this method.');
        }

        // We only want to enqueue an update write if there are non-sentinel fields
        // OR no transform sentinels are found.
        // We MUST always enqueue at least one write, so if there are no fields
        // and no transform sentinels, we can assume an empty write is intended
        // and enqueue an empty UPDATE operation.
        $shouldEnqueueUpdate = $fields
            || $emptyDocument
            || $metadata['hasUpdateMask'];

        if ($shouldEnqueueUpdate) {
            $write = [
                'fields' => $this->valueMapper->encodeValues($fields),
                'updateMask' => $this->pathsToStrings($paths, $sentinels, true),
            ];

            $this->writes[] = $this->createDatabaseWrite(
                self::TYPE_UPDATE,
                $document,
                $write + $this->formatPrecondition($options, true)
            );
        } else {
            // If no update write is enqueued, preconditions must be applied to
            // a transform.
            $options = $this->formatPrecondition($options, true);
        }

        // document transform operations are enqueued as a separate mutation.
        $this->enqueueTransforms($document, $sentinels, $options);

        return $this;
    }

    /**
     * Delete a Firestore document.
     *
     * Example:
     * ```
     * $batch->delete($documentName);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @param DocumentReference|string $document The document to target, either
     *        as a string document name, or DocumentReference object.
     * @param array $options Configuration Options
     * @return BulkWriter
     * @codingStandardsIgnoreEnd
     */
    public function delete($document, array $options = [])
    {
        $this->checkWriterConditions($document);
        $options = $this->formatPrecondition($options);
        $this->writes[] = $this->createDatabaseWrite(self::TYPE_DELETE, $document, $options);

        return $this;
    }

    /**
     * Flushes the enqueued writes in batches with auto-retries. Please note:
     *     - This method is blocking and may execute many sequential batch write requests.
     *     - Gradually ramps up writes as specified by the 500/50/5 rule.
     *     - Does not guarantee the order of writes.
     *     - Accepts unique document references only.
     * Read more: [Ramping up traffic](https://cloud.google.com/firestore/docs/best-practices#ramping_up_traffic)
     *
     * Example:
     * ```
     * $batch->flush();
     * ```
     *
     * @param bool $waitForRetryableFailures Flag to indicate whether to wait for
     *         retryable failures. **Defaults to** `false`.
     * @return array [https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#BatchWriteResponse](BatchWriteResponse)
     */
    public function flush($waitForRetryableFailures = false)
    {
        while (true) {
            $batchIds = $this->createWritesBatchIds($waitForRetryableFailures);
            $writesBatch = [];
            foreach ($batchIds as $batchId) {
                $writesBatch[] = $this->writes[$batchId];
            }
            $batchSize = count($writesBatch);
            if ($batchSize <= 0) {
                // no more writes to process
                break;
            }
            $response = $this->sendBatch($writesBatch);
            for ($i = 0; $i < $batchSize; $i++) {
                $writeResult = $response['writeResults'][$i];
                $status = $response['status'][$i];
                $this->finalResponse['writeResults'][$batchIds[$i]] = $writeResult;
                $this->finalResponse['status'][$batchIds[$i]] = $status;
                if ($status['code'] !== Code::OK) {
                    $this->handleSendBatchFailure($batchIds[$i], $status['code']);
                } else {
                    // try delete from retries
                    unset($this->retryScheduledWrites[$batchIds[$i]]);
                }
            }
        }
        ksort($this->finalResponse['writeResults']);
        ksort($this->finalResponse['status']);
        return $this->finalResponse;
    }

    /**
     * Commit writes to the database.
     * Not to be used together with flush / close.
     *
     * Example:
     * ```
     * $batch->commit();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Firestore.Commit Commit
     *
     * @internal Only supposed to be used internally in Transaction class.
     * @access private
     * @param array $options Configuration Options
     * @return array [https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#commitresponse](CommitResponse)
     * @codingStandardsIgnoreEnd
     */
    public function commit(array $options = [])
    {
        unset($options['merge'], $options['precondition']);

        $response = $this->connection->commit(array_filter([
            'database' => $this->database,
            'writes' => $this->writes,
            'transaction' => $this->transaction,
        ]) + $options);

        if (isset($response['commitTime'])) {
            $time = $this->parseTimeString($response['commitTime']);
            $response['commitTime'] = new Timestamp($time[0], $time[1]);
        }

        if (isset($response['writeResults'])) {
            foreach ($response['writeResults'] as &$result) {
                if (isset($result['updateTime'])) {
                    $time = $this->parseTimeString($result['updateTime']);
                    $result['updateTime'] = new Timestamp($time[0], $time[1]);
                }
            }
        }

        return $response;
    }

    /**
     * Rollback a transaction.
     *
     * If the class was created without a Transaction ID, this method will fail.
     * Not to be used together with flush / close.
     *
     * This method is intended for use internally and should not be considered
     * part of the public API.
     *
     * @internal Only supposed to be used internally in Transaction class.
     * @access private
     * @param array $options Configuration Options
     * @return void
     * @throws \RuntimeException If no transaction ID is provided at class construction.
     */
    public function rollback(array $options = [])
    {
        if (!$this->transaction) {
            throw new \RuntimeException('Cannot rollback because no transaction id was provided.');
        }

        $this->connection->rollback([
            'database' => $this->database,
            'transaction' => $this->transaction,
        ] + $options);
    }

    /**
     * Check if the BulkWriter has any writes enqueued.
     *
     * @access private
     * @return bool
     */
    public function isEmpty()
    {
        return !(bool) $this->writes;
    }

    /**
     * Close the bulk writer instance for further writes.
     * Also, flushes all retries and pending writes.
     *
     * @return array [https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#BatchWriteResponse](BatchWriteResponse)
     */
    public function close()
    {
        $this->closed = true;
        return $this->flush(true);
    }

    /**
     * Gets updated backoff duration provided last status code and backoff duration.
     *
     * @internal
     * @access private
     * @param int $lastStatus Previous status code of batchWrite
     * @param int $backoffDurationInMillis Previous backoff duration in milliseconds
     * @return int
     */
    public function getBackoffDuration($lastStatus, $backoffDurationInMillis = 0)
    {
        if ($lastStatus === Code::RESOURCE_EXHAUSTED) {
            $backoffDurationInMillis = $this->maxDelayTime;
        } elseif ($backoffDurationInMillis <= 0) {
            $backoffDurationInMillis = self::$defaultOptions['DEFAULT_BACKOFF_INITIAL_DELAY_MS'];
        } else {
            $backoffDurationInMillis *= self::$defaultOptions['DEFAULT_BACKOFF_FACTOR'];
        }
        return min($this->maxDelayTime, $backoffDurationInMillis);
    }

    /**
     * Change the maximum delay time for rescheduling a failed mutation or
     * awaiting a batch creation.
     *
     * @internal
     * @access private
     * @param int $maxTime The maximum delay time in millis for rescheduling
     *            a failed mutation or awaiting a batch creation.
     * @return void
     */
    public function setMaxRetryTimeInMs($maxTime)
    {
        $this->maxDelayTime = max(0, $maxTime);
    }

    /**
     * Reschedule failed mutations if retryable.
     *
     * @param int $writesId Sequence of mutation among all enqueued writes
     * @param int $lastRunStatusCode Previous status code of batchWrite
     * @return void
     */
    private function handleSendBatchFailure($writesId, $lastRunStatusCode)
    {
        if (!call_user_func_array($this->isRetryable, [$lastRunStatusCode])) {
            return;
        }
        $numFailedAttempts = 1;
        $backoffDurationInMillis = 0;
        if (array_key_exists($writesId, $this->retryScheduledWrites)) {
            $numFailedAttempts += $this->retryScheduledWrites[$writesId]['num_failed_attempts'];
            $backoffDurationInMillis = $this->retryScheduledWrites[$writesId]['backoff_in_millis'];
        }
        // calculate the new backoff time
        $backoffDurationInMillis = $this->getBackoffDuration($lastRunStatusCode, $backoffDurationInMillis);
        $rescheduleTime = floor(microtime(true) * 1000) + $backoffDurationInMillis;
        // upsert to reschedule array
        $this->retryScheduledWrites[$writesId] = [
            'scheduled_in_millis' => $rescheduleTime,
            'backoff_in_millis' => $backoffDurationInMillis,
            'num_failed_attempts' => $numFailedAttempts,
        ];
    }

    /**
     * Get whether individual writes with provided status code shall be retried.
     * The default error handler retries for UNAVAILABLE and ABORTED errors.
     *
     * @return callable Accepts error code and returns true if retryable.
     */
    private function defaultWriteErrorHandler()
    {
        return function ($lastRunStatusCode) {
            return in_array($lastRunStatusCode, [
                Code::UNAVAILABLE,
                Code::ABORTED,
            ]);
        };
    }

    /**
     * Creates writes array indices which form a batch
     *
     * @param bool $waitForRetryableFailures Flag to indicate whether to wait for
     *        retryable failures. **Defaults to** `false`.
     * @return array
     */
    private function createWritesBatchIds($waitForRetryableFailures = false)
    {
        $writesBatchIds = [];
        $curTimeInMillis = floor(microtime(true) * 1000);
        $maxScheduledDelayInMillis = 0;
        $batchSize = $this->maxBatchSize;
        // check for scheduling fresh writes
        foreach (array_keys($this->writes) as $writeId) {
            if (count($writesBatchIds) >= $batchSize) {
                break;
            }
            // ignore if write has a result and result is already successful
            if (array_key_exists($writeId, $this->finalResponse['status']) &&
                $this->finalResponse['status'][$writeId]['code'] === Code::OK) {
                continue;
            }
            // ignore if write is yet to reach rescheduled time OR retried more than enough
            if (array_key_exists($writeId, $this->retryScheduledWrites)) {
                if ($this->retryScheduledWrites[$writeId]['num_failed_attempts'] >=
                    self::$defaultOptions['MAX_RETRY_ATTEMPTS']
                ) {
                    // let the failures eventually trickle down to finalResponse
                    continue;
                }

                if (!$waitForRetryableFailures &&
                    $this->retryScheduledWrites[$writeId]['scheduled_in_millis'] > $curTimeInMillis) {
                    // cannot wait for writes that are yet to be scheduled
                    continue;
                }
                // Delay greater than 0 implies that this batch is a retry.
                // Retries are sent with RETRY_MAX_BATCH_SIZE in order to guarantee
                // that the batch is under the 10MiB limit.
                $batchSize = self::$defaultOptions['RETRY_MAX_BATCH_SIZE'];
                $maxScheduledDelayInMillis = max(
                    $maxScheduledDelayInMillis,
                    $this->retryScheduledWrites[$writeId]['scheduled_in_millis']
                );
            }

            $writesBatchIds[] = $writeId;
        }
        // sleep needs delay, not the actual timestamp
        $maxScheduledDelayInMillis -= $curTimeInMillis;

        if ($maxScheduledDelayInMillis > 0) {
            $actualDelay = $this->applyJitter($maxScheduledDelayInMillis);
            // sleep for max possible delay to form batches for all writes
            usleep($actualDelay * 1000);
        }
        return $writesBatchIds;
    }

    /**
     * Sends a batch write request to the database.
     *
     * @param array $writes The writes to send in a batch. Please note:
     *            - Writes do not apply atomically
     *            - Writes do not guarantee ordering.
     *            - Each write can succeed or fail independently.
     * @param array $options [optional] {
     *     Configuration options
     *
     *     @type array $labels
     *           Labels associated with this batch write.
     * }
     * @return array [https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#BatchWriteResponse](BatchWriteResponse)
     */
    private function sendBatch(array $writes, array $options = [])
    {
        $rateLimiterDelayMs = $this->rateLimiter->getNextRequestDelayMs(count($writes));
        // avoid very long sleep
        $rateLimiterDelayMs = min(
            $rateLimiterDelayMs,
            $this->maxDelayTime
        );
        if ($rateLimiterDelayMs > 0) {
            usleep($rateLimiterDelayMs * 1000);
        }
        $this->rateLimiter->tryMakeRequest(count($writes));

        unset($options['merge'], $options['precondition']);
        $options += ['labels' => []];

        $response = $this->connection->batchWrite(array_filter([
            'database' => $this->database,
            'writes' => $writes,
        ]) + $options);

        if (isset($response['writeResults'])) {
            foreach ($response['writeResults'] as &$result) {
                if (isset($result['updateTime'])) {
                    $time = $this->parseTimeString($result['updateTime']);
                    $result['updateTime'] = new Timestamp($time[0], $time[1]);
                }
            }
        }

        return $response;
    }

    /**
     * Enqueue transforms for CREATE, UPDATE, and SET calls.
     *
     * @param DocumentReference|string $document The document to target, either
     *        as a string document name, or DocumentReference object.
     * @param DocumentTransformInterface[] $transforms
     * @param array $options
     * @return void
     */
    private function enqueueTransforms($document, array $transforms, array $options = [])
    {
        $operations = [];

        foreach ($transforms as $transform) {
            if (!($transform instanceof DocumentTransformInterface)) {
                continue;
            }

            $args = $transform->args();
            if (!$transform->sendRaw()) {
                if (is_array($args) && !$this->isAssoc($args)) {
                    $args = $this->valueMapper->encodeArrayValue($args);
                } else {
                    $args = $this->valueMapper->encodeValue($args);
                }
            }

            $operations[] = [
                'fieldPath' => $transform->fieldPath()->pathString(),
                $transform->key() => $args,
            ];
        }

        if ($operations) {
            $this->writes[] = $this->createDatabaseWrite(self::TYPE_TRANSFORM, $document, [
                'fieldTransforms' => $operations,
            ] + $options);
        }
        if ($this->greedilySend &&
            count($this->createWritesBatchIds()) >= $this->maxBatchSize
        ) {
            $this->flush();
        }
    }

    /**
     * @param string $type The write operation type.
     * @param DocumentReference|string $document The document to target, either
     *        as a string document name, or DocumentReference object.
     * @param array $options {
     *     Configuration Options.
     *
     *     @type array $updateMask A list of field paths to update in this document.
     *     @type array $currentDocument An optional precondition.
     *     @type array $fields An array of document fields and their values. Required
     *           if $type is `update`.
     * }
     * @return array
     */
    private function createDatabaseWrite($type, $document, array $options = [])
    {
        $mask = $this->pluck('updateMask', $options, false);
        if ($mask !== null) {
            sort($mask);
            $mask = ['fieldPaths' => $mask];
        }

        $document = ($document instanceof DocumentReference)
            ? $document->name()
            : $document;

        return $this->arrayFilterRemoveNull([
            'updateMask' => $mask,
            'currentDocument' => $this->validatePrecondition($options),
        ]) + $this->createDatabaseWriteOperation($type, $document, $options);
    }

    /**
     * Validates a document precondition, if set.
     *
     * @codingStandardsIgnoreStart
     * @param array $options Configuration Options
     * @return array|void [Precondition](https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Precondition)
     * @throws \InvalidArgumentException If the precondition is invalid.
     * @codingStandardsIgnoreEnd
     */
    private function validatePrecondition(array &$options)
    {
        $precondition = isset($options['precondition'])
            ? $options['precondition']
            : null;

        if (!$precondition) {
            return;
        }

        if (isset($precondition['exists'])) {
            return $precondition;
        }

        if (isset($precondition['updateTime'])) {
            if (!($precondition['updateTime'] instanceof Timestamp)) {
                throw new \InvalidArgumentException(
                    'Precondition Update Time must be an instance of `Google\\Cloud\\Core\\Timestamp`'
                );
            }

            return [
                'updateTime' => $precondition['updateTime']->formatForApi(),
            ];
        }

        throw new \InvalidArgumentException('Preconditions must provide either `exists` or `updateTime`.');
    }

    /**
     * Create the write operation object.
     *
     * @param string $type The write type.
     * @param string $document The document to target, either
     *        as a string document name, or DocumentReference object.
     * @param array $options Configuration Options.
     * @return array
     * @throws \InvalidArgumentException If $type is not a valid value.
     */
    private function createDatabaseWriteOperation($type, $document, array $options = [])
    {
        switch ($type) {
            case self::TYPE_UPDATE:
                return [
                    'update' => $this->arrayFilterRemoveNull([
                        'name' => $document,
                        // empty array -> set to null and filter for conformance.
                        'fields' => $this->pluck('fields', $options, false) ?: null,
                    ]),
                ];
                break;

            case self::TYPE_SET:
            case self::TYPE_CREATE:
                return [
                    'update' => [
                        'name' => $document,
                        'fields' => $this->pluck('fields', $options, false) ?: [],
                    ],
                ];
                break;

            case self::TYPE_DELETE:
                return ['delete' => $document];
                break;

            case self::TYPE_TRANSFORM:
                return [
                    'transform' => [
                        'document' => $document,
                        'fieldTransforms' => $this->pluck('fieldTransforms', $options),
                    ],
                ];
                break;

            // @codeCoverageIgnoreStart
            default:
                throw new \InvalidArgumentException(sprintf(
                    'Write operation type `%s is not valid. Allowed values are update, delete, verify, transform.',
                    $type
                ));
                break;
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * Filter fields, removing sentinel values from the field list and recording
     * their location.
     *
     * @param array $fields The structured fields input.
     * @param FieldPath[] $inputPaths The paths provided by update-paths.
     * @return array An array containing the output fields at position 0,
     *         a sentinels list at position 1, and metadata at position 2.
     *         Metadata includes `array $types`, a list of class names of
     *         sentinels, and `bool $hasTransform`, indicating whether any
     *         instanceof of `DocumentTransformInterface` existed in the
     *         original input data.
     */
    private function filterFields(array $fields, array $inputPaths = [])
    {
        return $this->filterFieldsRecursive(
            $fields,
            [],
            [
                'hasTransform' => false,
                'hasUpdateMask' => false,
                'hasDelete' => false,
            ],
            $inputPaths,
            new FieldPath([])
        );
    }

    /**
     * Recurses through the fields, filtering out sentinel values and
     * performing common validation.
     *
     * @param array $fields The original structured fields.
     * @param array $sentinels A list of sentinel values.
     * @param array $metadata A set of metadata describing the provided fields.
     * @param FieldPath[] $inputPaths The paths provided by update-paths.
     * @param FieldPath $path A field path instance used to track the current
     *        working path.
     * @param bool $inArray [optional] Whether or not we are recursing within
     *        an array.
     * @return array An array containing the output fields, a sentinels list,
     *         and metadata.
     * @throws \InvalidArgumentException
     */
    private function filterFieldsRecursive(
        array $fields,
        array $sentinels,
        array $metadata,
        array $inputPaths,
        FieldPath $path,
        $inArray = false
    ) {
        foreach ($fields as $key => $value) {
            $currentPath = $path->child($key);

            if (is_array($value) && !empty($value)) {
                list($fields[$key], $sentinels, $metadata) = $this->filterFieldsRecursive(
                    $value,
                    $sentinels,
                    $metadata,
                    $inputPaths,
                    $currentPath,
                    $inArray ?: !$this->isAssoc($value)
                );

                if (empty($fields[$key])) {
                    unset($fields[$key]);
                }
            } elseif ($value instanceof FieldValueInterface) {
                $value->setFieldPath($currentPath);
                $sentinels[] = $value;

                // Sentinels cannot be used within a non-associative array.
                if ($inArray) {
                    throw new \InvalidArgumentException(sprintf(
                        '%s values cannot be used anywhere within a non-associative array value. ' .
                        'Invalid value found at %s.',
                        FieldValue::class,
                        $currentPath->pathString()
                    ));
                }

                // Delete cannot be nested in update-paths
                // (i.e. the only case where `$inputPaths` would be available)
                $illegalNestedDelete = $inputPaths
                    && $value instanceof DeleteFieldValue
                    && !in_array($currentPath, $inputPaths);

                if ($illegalNestedDelete) {
                    throw new \InvalidArgumentException(sprintf(
                        '%s::deleteField() values cannot be nested. ' .
                        'Invalid value found at %s.',
                        FieldValue::class,
                        $currentPath->pathString()
                    ));
                }

                // Values of type `DocumentTransformInterface` cannot contain nested transforms.
                if ($value instanceof DocumentTransformInterface) {
                    $args = $value->args();
                    if (is_array($args) && !$this->isAssoc($args)) {
                        foreach ($args as $arg) {
                            if ($arg instanceof DocumentTransformInterface) {
                                throw new \InvalidArgumentException(sprintf(
                                    'Document transforms cannot contain %s values. ' .
                                    'Invalid value found at %s.',
                                    FieldValue::class,
                                    $currentPath->pathString()
                                ));
                            }
                        }
                    }
                }

                // Remove the sentinel value from the fields array.
                unset($fields[$key]);

                // Record whether the mutation contains a transform value.
                if (!$metadata['hasTransform'] && $value instanceof DocumentTransformInterface) {
                    $metadata['hasTransform'] = true;
                }

                // Record whether an update mask is required.
                if (!$metadata['hasUpdateMask'] && $value->includeInUpdateMask()) {
                    $metadata['hasUpdateMask'] = true;
                }

                // Record whether a field delete is provided.
                if (!$metadata['hasDelete'] && $value instanceof DeleteFieldValue) {
                    $metadata['hasDelete'] = true;
                }
            }
        }

        return [$fields, $sentinels, $metadata];
    }

    /**
     * Correctly formats a precondition for a write.
     *
     * @param array $options Configuration options input.
     * @param bool $mustExist If true, the precondition will always include at
     *        least `exists=true` precondition. **Defaults to** `false`.
     * @return array Modified configuration options.
     */
    private function formatPrecondition(array $options, $mustExist = false)
    {
        if (!isset($options['precondition']) && !$mustExist) {
            return $options;
        }

        $precondition = isset($options['precondition'])
            ? $options['precondition']
            : [];

        if (isset($precondition['updateTime'])) {
            return $options;
        }

        if ($mustExist) {
            $precondition['exists'] = true;
        }

        $options['precondition'] = $precondition;

        return $options;
    }

    /**
     * Create a list of fields paths from field data.
     *
     * The return value of this method does not include the field values. It
     * merely provides a list of field paths which were included in the input.
     *
     * @param array $fields A list of fields to map as paths.
     * @param FieldPath|null $path The parent path (used internally).
     * @return FieldPath[]
     */
    private function encodeFieldPaths(array $fields, $path = null)
    {
        $output = [];

        if (!$path) {
            $path = new FieldPath([]);
        }

        foreach ($fields as $key => $val) {
            $currentPath = $path->child($key);

            if (is_array($val) && !empty($val) && $this->isAssoc($val)) {
                $output = array_merge(
                    $output,
                    $this->encodeFieldPaths($val, $currentPath)
                );
            } else {
                $output[] = $currentPath;
            }
        }

        return $output;
    }

    /**
     * Convert a set of {@see Google\Cloud\Firestore\FieldPath} objects to strings.
     *
     * @param FieldPath[] $paths The input paths.
     * @param FieldValueInterface[] $sentinels Sentinel values.
     * @param bool $checkPrefixes Whether to search the paths for illegal path
     *        prefixes.
     * @return string[]
     */
    private function pathsToStrings(array $paths, array $sentinels, $checkPrefixes = false)
    {
        $out = [];
        $excluded = [];
        foreach ($sentinels as $sentinel) {
            $path = $sentinel->fieldPath()
                ? $sentinel->fieldPath()->pathString()
                : null;

            if (!$sentinel->includeInUpdateMask()) {
                $excluded[] = $path;
                continue;
            }

            $out[] = $path;
        }

        foreach ($paths as $path) {
            $path = $path->pathString();
            if (!in_array($path, $excluded)) {
                $out[] = $path;
            }
        }

        // The flag isn't really necessary since prefixes can only happen in
        // update-paths, but using it lets us bypass the unnecessary check
        // unless we need it.
        if ($checkPrefixes) {
            $this->checkPrefixes($out);
        }

        // Remove any duplicate values before returning.
        return array_unique($out);
    }

    /**
     * Check list of FieldPaths for prefix paths and throw exception.
     *
     * @param string[] $paths
     * @throws \InvalidArgumentException If prefix paths are found.
     */
    private function checkPrefixes(array $paths)
    {
        sort($paths);

        for ($i = 1; $i < count($paths); $i++) {
            $prefix = $paths[$i - 1];
            $suffix = $paths[$i];

            $prefix = explode('.', $prefix);
            $suffix = explode('.', $suffix);

            $isPrefix = count($prefix) < count($suffix)
            && $prefix === array_slice($suffix, 0, count($prefix));

            if ($isPrefix) {
                throw new \InvalidArgumentException(sprintf(
                    'Field path conflict detected for field path `%s`. ' .
                    'Conflicts occur when a field path descends from another ' .
                    'path. For instance `a.b` is not allowed when `a` is also ' .
                    'provided.',
                    implode('.', $prefix)
                ));
            }
        }
    }

    /**
     * Check whether BulkWriter is writeable with the provided document.
     *
     * @param DocumentReference|string $document The document to target.
     * @throws \InvalidArgumentException If document is not unique.
     */
    private function checkWriterConditions($document)
    {
        if ($this->isLegacyWriteBatch) {
            // perform no checks for legacy WriteBatch
            return;
        }
        if ($this->closed) {
            throw new \InvalidArgumentException('firestore: BulkWriter has been closed');
        }
        if (is_null($document)) {
            throw new \InvalidArgumentException('firestore: nil document contents');
        }
        if ($document instanceof DocumentReference) {
            $document = $document->name();
        }
        if (in_array($document, $this->uniqueDocuments)) {
            throw new \InvalidArgumentException(
                'firestore: bulkwriter: received duplicate mutations for path: ' .
                $document
            );
        }
        $this->uniqueDocuments[] = $document;
    }

    /**
     * Applies jitter to backoff duration.
     *
     * @param int $backoffMs The backoff duration in milliseconds.
     * @return int Jittered backoff duration in milliseconds.
     */
    private function applyJitter($backoffMs)
    {
        if ($backoffMs <= 0) {
            return 0;
        }
        // Random value in [-0.3, 0.3]
        $resolution = 1000.0;
        $jitter = self::$defaultOptions['DEFAULT_JITTER_FACTOR'] *
            mt_rand(-$resolution, $resolution) / $resolution;
        return (int) min($this->maxDelayTime, $backoffMs + $jitter * $backoffMs);
    }
}
