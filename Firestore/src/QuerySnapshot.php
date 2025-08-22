<?php
/**
 * Copyright 2017 Google Inc.
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

use Google\Cloud\Firestore\V1\ExplainMetrics;

/**
 * Represents the result set of a Cloud Firestore Query.
 *
 * Example:
 * ```
 * use Google\Cloud\Firestore\FirestoreClient;
 *
 * $firestore = new FirestoreClient();
 * $collection = $firestore->collection('users');
 * $query = $collection->where('age', '>', 18);
 *
 * $snapshot = $query->documents();
 * ```
 *
 * ```
 * // Snapshots can be iterated with foreach:
 * foreach ($snapshot as $user) {
 *     echo $user['name'] . PHP_EOL;
 * }
 * ```
 */
class QuerySnapshot implements \IteratorAggregate
{
    /**
     * @var Query
     */
    private $query;

    /**
     * @var DocumentSnapshot[]
     */
    private $rows;

    /**
     * @var null|ExplainMetrics
     */
    private null|ExplainMetrics $explainMetrics;

    /**
     * @param Query $query The Query which generated this snapshot.
     * @param DocumentSnapshot[] $rows The query result rows.
     */
    public function __construct(
        Query $query,
        array $rows,
        null|ExplainMetrics $explainMetrics = null
    ) {
        $this->query = $query;
        $this->rows = $rows;
        $this->explainMetrics = $explainMetrics;
    }

    /**
     * Check if the result is empty.
     *
     * Example:
     * ```
     * $empty = $snapshot->isEmpty();
     * ```
     *
     * @return bool|null
     */
    public function isEmpty()
    {
        return empty($this->rows);
    }

    /**
     * Returns the size of the result set.
     *
     * Example:
     * ```
     * $size = $snapshot->size();
     * ```
     *
     * @return int|null
     */
    public function size()
    {
        return count($this->rows);
    }

    /**
     * Return the formatted and decoded rows. If the stream is interrupted,
     * attempts will be made on your behalf to resume.
     *
     * Example:
     * ```
     * $rows = $snapshot->rows();
     * ```
     *
     * @return DocumentSnapshot[]
     */
    public function rows()
    {
        return $this->rows;
    }

    /**
     * Gets `ExplainMetrics` when the `explainOptions` option is supplied.
     * If `ExplainOptions::setAnalyze` is set to `false`, the query is
     * planned and not executed, returning only the {@see V1\PlanSummary}
     * instead of the {@see V1\ExecutionStats} and result.
     *
     * @return null|ExplainMetrics
     */
    public function getExplainMetrics()
    {
        return $this->explainMetrics;
    }

    /**
     * @access private
     * @return \ArrayIterator
     */
    #[\ReturnTypeWillChange]
    public function getIterator()
    {
        return new \ArrayIterator($this->rows);
    }
}
