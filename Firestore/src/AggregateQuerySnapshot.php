<?php
/**
 * Copyright 2023 Google Inc.
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

use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\TimeTrait;

/**
 * Represents the result set of an AggregateQuery.
 *
 * Example:
 * ```
 * use Google\Cloud\Firestore\FirestoreClient;
 *
 * $firestore = new FirestoreClient();
 * $collection = $firestore->collection('users');
 * $query = $collection->where('age', '>', 18);
 *
 * $snapshot = $query->count();
 * ```
 */
class AggregateQuerySnapshot
{
    use TimeTrait;

    /**
     * @var Timestamp
     */
    private $readTime;

    /**
     * @var array
     */
    private $aggregateFields = [];

    /**
     * @var string
     */
    private $transaction;

    /**
     * An immutable snapshot of aggregate query results.
     *
     * @param array $snapshot Result of an AggregateQuery.
     */
    public function __construct($snapshot = [])
    {
        if (isset($snapshot['transaction'])) {
            $this->transaction = $snapshot['transaction'];
        }
        if (isset($snapshot['readTime'])) {
            $time = $this->parseTimeString($snapshot['readTime']);
            $this->readTime = new Timestamp($time[0], $time[1]);
        }
        if (isset($snapshot['result']['aggregateFields'])) {
            $this->aggregateFields = $snapshot['result']['aggregateFields'];
        }
    }

    /**
     * Get the transaction id.
     *
     * @return string
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * Get the Aggregation read time.
     *
     * @return Timestamp
     */
    public function getReadTime()
    {
        return $this->readTime;
    }

    /**
     * Get the Query Aggregation value.
     *
     * @param string $alias The aggregation alias.
     * @return mixed
     * @throws \InvalidArgumentException If provided alias does not exist in result.
     */
    public function get($alias)
    {
        if (!isset($this->aggregateFields[$alias])) {
            throw new \InvalidArgumentException('alias does not exist');
        }
        $result = $this->aggregateFields[$alias];
        if (is_array($result)) {
            $key = array_key_first($result);
            if ($key == 'nullValue') {
                return null;
            }
            // `$result` would contain only one of
            // (@see https://cloud.google.com/firestore/docs/reference/rest/v1/Value)
            return $result[$key];
        }
        return $result;
    }
}
