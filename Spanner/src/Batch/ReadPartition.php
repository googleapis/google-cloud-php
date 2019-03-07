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

/**
 * Represents a Read Partition.
 *
 * Partitions can be shared with other servers or processes by casting the
 * object to a string, or by calling {@see Google\Cloud\Spanner\Batch\ReadPartition::serialize()}.
 *
 * Note that when reading or querying against a partition, the request MUST be
 * made using the same Batch Snapshot with which the partition was initialized.
 * In practice, this means that a shared partition must be accompanied by its
 * corresponding snapshot. For more information, refer to usage notes on
 * {@see Google\Cloud\Spanner\Batch\BatchClient}.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\KeySet;
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 * $batch = $spanner->batch('instance-id', 'database-id');
 * $snapshot = $batch->snapshot();
 *
 * $keySet = new KeySet(['all' => true]);
 * $columns = ['id', 'firstName', 'lastName'];
 * $partitions = $snapshot->partitionRead('Users', $keySet, $columns);
 * ```
 *
 * ```
 * // Serialize a partition to share it with another worker.
 * $partitionString = (string) $partition;
 * ```
 *
 * ```
 * // Calling ReadPartition::serialize() has the same effect.
 * $partitionString = $partition->serialize();
 * ```
 */
class ReadPartition implements PartitionInterface
{
    use PartitionTrait;

    /**
     * @var string
     */
    private $table;

    /**
     * @var KeySet
     */
    private $keySet;

    /**
     * @var array
     */
    private $columns;

    /**
     * @param string $token The token identifying the partition.
     * @param string $table The table name.
     * @param KeySet $keySet The KeySet to select rows.
     * @param string[] $columns A list of column names to return.
     * @param array $options {
     *     Configuration Options
     *
     *     @type int $maxPartitions The desired maximum number of partitions to
     *           return. For example, this may be set to the number of workers
     *           available. The maximum value is currently 200,000. This is only
     *           a hint. The actual number of partitions returned may be smaller
     *           than this maximum count request. **Defaults to** `10000`.
     *     @type int $partitionSizeBytes The desired data size for each
     *           partition generated. This is only a hint. The actual size of
     *           each partition may be smaller or larger than this size request.
     *           **Defaults to** `1000000000` (i.e. 1 GiB).
     *     @type string $index The name of an index on the table.
     * }
     */
    public function __construct(
        $token,
        $table,
        KeySet $keySet,
        array $columns,
        array $options
    ) {
        $this->token = $token;
        $this->table = $table;
        $this->keySet = $keySet;
        $this->columns = $columns;
        $this->options = $options;
    }

    /**
     * Return the table name.
     *
     * Example:
     * ```
     * $table = $partition->table();
     * ```
     *
     * @return string
     */
    public function table()
    {
        return $this->table;
    }

    /**
     * Return the KeySet.
     *
     * Example:
     * ```
     * $keySet = $partition->keySet();
     * ```
     *
     * @return KeySet
     */
    public function keySet()
    {
        return $this->keySet;
    }

    /**
     * Return the list of columns.
     *
     * Example:
     * ```
     * $columns = $partition->columns();
     * ```
     *
     * @return array
     */
    public function columns()
    {
        return $this->columns;
    }

    /**
     * Return a stringified representation of the ReadPartition object.
     *
     * Example:
     * ```
     * $partitionString = $partition->serialize();
     * ```
     *
     * @return string
     */
    public function serialize()
    {
        $vars = get_object_vars($this);
        $vars['keySet'] = $vars['keySet']->keySetObject();

        return base64_encode(json_encode($vars + [
            BatchClient::PARTITION_TYPE_KEY => static::class
        ]));
    }

    /**
     * Create a ReadPartition object from a deserialized array of partition data.
     *
     * @param array $data The partition data.
     * @return ReadPartition
     * @access private
     */
    public static function hydrate(array $data)
    {
        return new self(
            $data['token'],
            $data['table'],
            KeySet::fromArray($data['keySet']),
            $data['columns'],
            $data['options']
        );
    }
}
