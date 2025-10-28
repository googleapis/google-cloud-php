<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Spanner\Batch;

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Session\SessionCache;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\TransactionOptionsBuilder;

/**
 * Provides Batch APIs used to read data from a Cloud Spanner database.
 *
 * Batch Clients are useful when one wants to read or query a large amount of
 * data from Cloud Spanner across multiple processes, even across multiple
 * machines. It allows creation of partitions of a Cloud Spanner database in
 * order to facilitate reading or querying of each partition independently at
 * the same snapshot.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient(['projectId' => 'my-project']);
 * $batch = $spanner->batch('instance-id', 'database-id');
 * ```
 *
 * ```
 * // Using Cloud Pub/Sub to share partitions with workers
 * use Google\Cloud\PubSub\PubSubClient;
 *
 * $pubsub = new PubSubClient();
 * $topic = $pubsub->topic('partition-queries');
 *
 * $snapshot = $batch->snapshot();
 *
 * // Executing a partition query will return a list of Partitions.
 * $partitions = $snapshot->partitionQuery('SELECT * FROM Users WHERE firstName = %s AND location = %s', [
 *     'parameters' => [
 *         'firstName' => 'John',
 *         'location' => 'USA'
 *     ]
 * ]);
 *
 * // Each partition is published to Cloud Pub/Sub, where it can be executed by
 * // a worker.
 * foreach ($partitions as $partition) {
 *     $topic->publish([
 *         'attributes' => [
 *             'snapshot' => $snapshot->serialize(),
 *             'partition' => $partition->serialize()
 *         ]
 *     ]);
 * }
 *
 * // Once all workers have finished, we will close the snapshot.
 * // The logic to determine whether the snapshot is no longer needed will vary
 * // and is not implemented here.
 * do {
 *     $finished = areWorkersDone();
 * } while(!$finished);
 * ```
 *
 * ```
 * // Using Cloud Pub/Sub to consume a partition and return a result.
 * use Google\Cloud\PubSub\PubSubClient;
 *
 * $pubsub = new PubSubClient();
 * $subscription = $pubsub->subscription('partition-query-consumer');
 *
 * $messages = $subscription->pull([
 *     'returnImmediately' => true,
 *     'maxMessages' => 1
 * ]);
 *
 * if ($messages) {
 *     $message = $messages[0];
 *     $snapshot = $batch->snapshotFromString($message->attribute('snapshot'));
 *     $partition = $batch->partitionFromString($message->attribute('partition'));
 *
 *     // Do something with the query result.
 *     processResult($snapshot->executePartition($partition));
 * }
 * ```
 */
class BatchClient
{
    use TimeTrait;
    use ArrayTrait;

    const PARTITION_TYPE_KEY = '__partitionTypeName';
    private const ALLOWED_PARTITION_TYPES = [
        QueryPartition::class,
        ReadPartition::class
    ];

    /**
     * @param Operation $operation A Cloud Spanner Operations wrapper.
     * @param SessionCache $session The session to which the batch client instance is scoped.
     */
    public function __construct(
        private Operation $operation,
        private SessionCache $session,
    ) {
    }

    /**
     * Create a batch snapshot.
     *
     * Example:
     * ```
     * $snapshot = $batch->snapshot();
     * ```
     *
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     See [ReadOnly](https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.TransactionOptions.ReadOnly)
     *     for detailed description of available options.
     *
     *     @type bool $transactionOptions.strong Read at a timestamp where all previously committed
     *           transactions are visible.
     *     @type Timestamp $transactionOptions.readTimestamp Executes all reads at the given
     *           timestamp.
     *     @type Duration $transactionOptions.exactStaleness Represents a number of seconds. Executes
     *           all reads at a timestamp that is $exactStaleness old.
     * }
     * @return BatchSnapshot
     */
    public function snapshot(array $options = [])
    {
        // Single Use transactions are not supported in batch mode.
        $options['transactionOptions']['singleUse'] = false;
        $options['transactionOptions']['returnReadTimestamp'] = true;

        $txnOptions = (new TransactionOptionsBuilder())
            ->configureReadOnlyTransactionOptions($options['transactionOptions']);

        /** @var BatchSnapshot */
        return $this->operation->snapshot($this->session, [
            'className' => BatchSnapshot::class,
            'transactionOptions' => $txnOptions
        ] + $options);
    }

    /**
     * Create a {@see \Google\Cloud\Spanner\Batch\BatchSnapshot} from a snapshot
     * identifier.
     *
     * This method can be used to deserialize a snapshot which is
     * shared across multiple servers or processes.
     *
     * Example:
     * ```
     * $snapshot = $batch->snapshotFromString($snapshotString);
     * ```
     *
     * @param string $identifier A stringified representation of {@see \Google\Cloud\Spanner\Batch\BatchSnapshot}.
     * @return BatchSnapshot
     */
    public function snapshotFromString($identifier)
    {
        $data = json_decode(base64_decode($identifier), true);
        $missing = array_diff(
            ['sessionName', 'transactionId', 'readTimestamp'],
            array_keys($data)
        );

        if ($missing) {
            throw new \InvalidArgumentException('Invalid identifier.');
        }

        if ($data['readTimestamp']) {
            if (!($data['readTimestamp'] instanceof Timestamp)) {
                $time = $this->parseTimeString($data['readTimestamp']);
                $data['readTimestamp'] = new Timestamp($time[0], $time[1]);
            }
        }
        return new BatchSnapshot(
            $this->operation,
            $this->session,
            [
                'id' => $data['transactionId'],
                'readTimestamp' => $data['readTimestamp']
            ]
        );
    }

    /**
     * Create a {@see \Google\Cloud\Spanner\Batch\PartitionInterface} instance.
     *
     * This method can be used to deserialize a partition which is
     * shared across multiple servers or processes.
     *
     * Example:
     * ```
     * $partition = $batch->partitionFromString($partitionString);
     * ```
     *
     * @param string $partition Partition data
     * @return PartitionInterface
     */
    public function partitionFromString($partition)
    {
        $data = json_decode(base64_decode($partition), true);
        if (!isset($data[self::PARTITION_TYPE_KEY])) {
            throw new \InvalidArgumentException('Invalid partition data.');
        }

        $class = $data[self::PARTITION_TYPE_KEY];
        if (!in_array($class, self::ALLOWED_PARTITION_TYPES)) {
            throw new \InvalidArgumentException('Invalid partition type.');
        }

        unset($data[self::PARTITION_TYPE_KEY]);

        return $class::hydrate($data);
    }
}
