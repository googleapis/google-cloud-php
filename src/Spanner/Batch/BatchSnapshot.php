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

use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\SnapshotTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\TransactionalReadInterface;

/**
 * Represents a Read-Only Batch Transaction in Cloud Spanner.
 *
 * Batch Snapshots can be shared with other servers or processes by casting the
 * object to a string, or by calling {@see Google\Cloud\Spanner\Batch\BatchSnapshot::serialize()}.
 *
 * Please note that it is important that Snapshots are closed when they are no
 * longer needed. Closing a snapshot is accomplished by calling
 * {@see Google\Cloud\Spanner\Batch\BatchSnapshot::close()}. Snapshots should be
 * closed only after all workers have finished processing. Closing a snapshot
 * before all workers have processed will result in call failures.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 * $batch = $spanner->batch('instance-id', 'database-id');
 * $snapshot = $batch->snapshot();
 * ```
 *
 * ```
 * // Serialize a snapshot to share it with another worker.
 * $snapshotString = (string) $snapshot;
 * ```
 *
 * ```
 * // Calling BatchSnapshot::serialize() has the same effect.
 * $snapshotString = $snapshot->serialize();
 * ```
 */
class BatchSnapshot implements TransactionalReadInterface
{
    use SnapshotTrait;

    /**
     * @param Operation $operation The Operation instance.
     * @param Session $session The session to use for spanner interactions.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $id The Transaction ID.
     *     @type Timestamp $readTimestamp The read timestamp.
     * }
     */
    public function __construct(Operation $operation, Session $session, array $options = [])
    {
        $this->initialize($operation, $session, $options);
    }

    /**
     * Closes all open resources.
     *
     * When the snapshot is no longer needed, it is important to call this method
     * to free up resources allocated by the Batch Client.
     *
     * Methods on this instance which make service calls will fail if the snapshot
     * has been closed.
     *
     * Example:
     * ```
     * $snapshot->close();
     * ```
     *
     * @param array $options [optional] Configuration Options
     * @return void
     */
    public function close(array $options = [])
    {
        $this->session->delete($options);
    }

    /**
     * Begin a partitioned read.
     *
     * Example:
     * ```
     * use Google\Cloud\Spanner\KeySet;
     *
     * $keySet = new KeySet(['all' => true]);
     * $columns = ['id', 'firstName', 'lastName'];
     * $partitions = $snapshot->partitionRead('Users', $keySet, $columns);
     * ```
     *
     * @param string $table The table name.
     * @param KeySet $keySet The KeySet to select rows.
     * @param string[] $columns A list of column names to return.
     * @param array $options {
     *     Configuration Options
     *
     *     @type int $maxPartitions The desired maximum number of partitions to
     *           return. For example, this may be set to the number of workers
     *           available. The maximum value is currently 200,000. This is only
     *           a hint. The actual number of partitions returned may not always
     *           match the requested value. **Defaults to** `10000`.
     *     @type int $partitionSizeBytes The desired data size for each
     *           partition generated. This is only a hint. The actual size of
     *           each partition may be smaller or larger than this size request.
     *           **Defaults to** `1000000000` (i.e. 1 GiB).
     *     @type string $index The name of an index on the table.
     * }
     * @return ReadPartition[]
     */
    public function partitionRead($table, KeySet $keySet, array $columns, array $options = [])
    {
        return $this->operation->partitionRead(
            $this->session,
            $this->transactionId,
            $table,
            $keySet,
            $columns,
            $options
        );
    }

    /**
     * Begin a partitioned SQL query.
     *
     * Example:
     * ```
     * use Google\Cloud\Spanner\Timestamp;
     *
     * $queryString = 'SELECT * FROM Users WHERE joinDate < @joinDate AND lastLogin > @loginCutoff';
     * $partitions = $snapshot->partitionQuery($queryString, [
     *     'parameters' => [
     *         'joinDate' => new Timestamp(new \DateTime('2017-01-01')),
     *         'loginDate' => new Timestamp(new \DateTime('2017-12-31'))
     *     ]
     * ]);
     * ```
     *
     * @param string $sql The query string to execute.
     * @param array $options {
     *     Configuration Options
     *
     *     @type int $maxPartitions The desired maximum number of partitions to
     *           return. For example, this may be set to the number of workers
     *           available. The maximum value is currently 200,000. This is only
     *           a hint. The actual number of partitions returned may not always
     *           match the requested value. **Defaults to** `10000`.
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
    public function partitionQuery($sql, array $options = [])
    {
        return $this->operation->partitionQuery(
            $this->session,
            $this->transactionId,
            $sql,
            $options
        );
    }

    /**
     * Read rows from a partition.
     *
     * Partitions are created by calling {@see Google\Cloud\Spanner\Batch\BatchSnapshot::partitionRead()}
     * or {@see Google\Cloud\Spanner\Batch\BatchSnapshot::partitionQuery()}.
     * Generally, those partitions will be distributed to worker processes, each
     * of which will call this method with the partition it was given.
     *
     * Example:
     * ```
     * $result = $snapshot->executePartition($partition);
     * ```
     *
     * @param PartitionInterface $partition The partition to read.
     * @param array $options Configuration Options.
     * @return Result
     * @throws \BadMethodCallException If an invalid partition type is given.
     */
    public function executePartition(PartitionInterface $partition, array $options = [])
    {
        if ($partition instanceof QueryPartition) {
            return $this->executeQuery($partition);
        } elseif ($partition instanceof ReadPartition) {
            return $this->executeRead($partition);
        }

        throw new \BadMethodCallException('Unsupported partition type.');
    }

    /**
     * Return a stringified representation of the BatchSnapshot object.
     *
     * Example:
     * ```
     * $snapshotString = $snapshot->serialize();
     * ```
     *
     * @return string
     */
    public function serialize()
    {
        return base64_encode(json_encode([
            'sessionName' => $this->session->name(),
            'transactionId' => $this->transactionId,
            'readTimestamp' => $this->readTimestamp->formatAsString()
        ]));
    }

    /**
     * Cast the snapshot to a string.
     *
     * @return string
     * @access private
     */
    public function __toString()
    {
        return $this->serialize();
    }

    /**
     * Run executeStreamingSql with a partition.
     *
     * @param QueryPartition $partition The partition.
     * @return Result
     */
    private function executeQuery(QueryPartition $partition)
    {
        return $this->execute($partition->sql(), [
            'partitionToken' => $partition->token()
        ] + $partition->options());
    }

    /**
     * Run streamingRead with a partition.
     *
     * @param ReadPartition $partition The partition.
     * @return Result
     */
    private function executeRead(ReadPartition $partition)
    {
        return $this->read($partition->table(), $partition->keySet(), $partition->columns(), [
            'partitionToken' => $partition->token()
        ] + $partition->options());
    }
}
