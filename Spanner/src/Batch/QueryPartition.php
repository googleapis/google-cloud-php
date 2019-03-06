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

use Google\Cloud\Spanner\Session\Session;

/**
 * Represents a Query Partition.
 *
 * Partitions can be shared with other servers or processes by casting the
 * object to a string, or by calling {@see Google\Cloud\Spanner\Batch\QueryPartition::serialize()}.
 *
 * Note that when reading or querying against a partition, the request MUST be
 * made using the same Batch Snapshot with which the partition was initialized.
 * In practice, this means that a shared partition must be accompanied by its
 * corresponding snapshot. For more information, refer to usage notes on
 * {@see Google\Cloud\Spanner\Batch\BatchClient}.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 * $batch = $spanner->batch('instance-id', 'database-id');
 * $snapshot = $batch->snapshot();
 *
 * $partitions = $snapshot->partitionQuery(
 *     'SELECT * FROM Users WHERE firstName = @firstName AND location = @location',
 *     [
 *         'parameters' => [
 *             'firstName' => 'John',
 *             'location' => 'USA'
 *         ]
 *     ]
 * );
 * ```
 *
 * ```
 * // Serialize a partition to share it with another worker.
 * $partitionString = (string) $partition;
 * ```
 *
 * ```
 * // Calling QueryPartition::serialize() has the same effect.
 * $partitionString = $partition->serialize();
 * ```
 */
class QueryPartition implements PartitionInterface
{
    use PartitionTrait;

    /**
     * @var string
     */
    private $sql;

    /**
     * @param string $token The token identifying the partition.
     * @param string $sql The query string to execute.
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
     */
    public function __construct($token, $sql, $options)
    {
        $this->token = $token;
        $this->sql = $sql;
        $this->options = $options;
    }

    /**
     * Returns the SQL query string.
     *
     * Example:
     * ```
     * $sql = $partition->sql();
     * ```
     *
     * @return string
     */
    public function sql()
    {
        return $this->sql;
    }

    /**
     * Return a stringified representation of the QueryPartition object.
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
        return base64_encode(json_encode(get_object_vars($this) + [
            BatchClient::PARTITION_TYPE_KEY => static::class
        ]));
    }

    /**
     * Create a QueryPartition object from a deserialized array of partition data.
     *
     * @param array $data The partition data.
     * @return QueryPartition
     * @access private
     */
    public static function hydrate(array $data)
    {
        return new self(
            $data['token'],
            $data['sql'],
            $data['options']
        );
    }
}
