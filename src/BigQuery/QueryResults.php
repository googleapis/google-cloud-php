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

namespace Google\Cloud\BigQuery;

use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\Exception\GoogleException;

/**
 * QueryResults represent the result of a BigQuery SQL query. Read more at the
 * [Query Response API Documentation](https://cloud.google.com/bigquery/docs/reference/v2/jobs/query#response).
 *
 * This class should be not instantiated directly, but as a result of
 * calling {@see Google\Cloud\BigQuery\BigQueryClient::runQuery()} or
 * {@see Google\Cloud\BigQuery\Job::queryResults()}.
 */
class QueryResults
{
    /**
     * @var ConnectionInterface $connection Represents a connection to BigQuery.
     */
    private $connection;

    /**
     * @var array The query result's identity.
     */
    private $identity;

    /**
     * @var array The query result's metadata.
     */
    private $info;

    /**
     * @var array The options to use when reloading query data.
     */
    private $reloadOptions;

    /**
     * @param ConnectionInterface $connection Represents a connection to
     *        BigQuery.
     * @param string $jobId The job's ID.
     * @param string $projectId The project's ID.
     * @param array $info The query result's metadata.
     * @param array $reloadOptions The options to use when reloading query data.
     */
    public function __construct(ConnectionInterface $connection, $jobId, $projectId, array $info, array $reloadOptions)
    {
        $this->connection = $connection;
        $this->info = $info;
        $this->reloadOptions = $reloadOptions;
        $this->identity = [
            'jobId' => $jobId,
            'projectId' => $projectId
        ];
    }

    /**
     * Retrieves the rows associated with the query and merges them together
     * with the table's schema. It is recommended to check the completeness of
     * the query before attempting to access rows.
     *
     * Example:
     * ```
     * $isComplete = $queryResults->isComplete();
     *
     * if ($isComplete) {
     *     $rows = $queryResults->rows();
     *
     *     foreach ($rows as $row) {
     *         echo $row['name'];
     *     }
     * }
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return array
     * @throws GoogleException Thrown if the query has not yet completed.
     */
    public function rows(array $options = [])
    {
        if (!$this->isComplete()) {
            throw new GoogleException('The query has not completed yet.');
        }

        if (!isset($this->info['rows'])) {
            return;
        }

        $schema = $this->info['schema']['fields'];

        while (true) {
            $options['pageToken'] = isset($this->info['pageToken']) ? $this->info['pageToken'] : null;

            foreach ($this->info['rows'] as $row) {
                $mergedRow = [];

                foreach ($row['f'] as $key => $value) {
                    $mergedRow[$schema[$key]['name']] = $value['v'];
                }

                yield $mergedRow;
            }

            if (!$options['pageToken']) {
                return;
            }

            $this->info = $this->connection->getQueryResults($options + $this->identity);
        }
    }

    /**
     * Checks the query's completeness. Useful in combination with
     * {@see Google\Cloud\BigQuery\QueryResults::reload()} to poll for query status.
     *
     * Example:
     * ```
     * $isComplete = $queryResults->isComplete();
     *
     * while (!$isComplete) {
     *     sleep(1); // small delay between requests
     *     $queryResults->reload();
     *     $isComplete = $queryResults->isComplete();
     * }
     *
     * echo 'Query complete!';
     * ```
     *
     * @return bool
     */
    public function isComplete()
    {
        return $this->info['jobComplete'];
    }

    /**
     * Retrieves the cached query details.
     *
     * Example:
     * ```
     * $info = $queryResults->info();
     * echo $info['totalBytesProcessed'];
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/jobs/getQueryResults#response
     * Jobs getQueryResults API response documentation.
     *
     * @return array
     */
    public function info()
    {
        return $this->info;
    }

    /**
     * Triggers a network request to reload the query's details.
     *
     * Useful when needing to poll an incomplete query
     * for status. Configuration options will be inherited from
     * {@see Google\Cloud\BigQuery\Job::queryResults()} or
     * {@see Google\Cloud\BigQuery\BigQueryClient::runQuery()}, but they can be
     * overridden if needed.
     *
     * Example:
     * ```
     * $queryResults->isComplete(); // returns false
     * sleep(1); // let's wait for a moment...
     * $queryResults->reload(); // executes a network request
     * $queryResults->isComplete(); // true
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/jobs/getQueryResults
     * Jobs getQueryResults API documentation.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $maxResults Maximum number of results to read.
     *     @type int $startIndex Zero-based index of the starting row.
     *     @type int $timeoutMs How long to wait for the query to complete, in
     *           milliseconds. **Defaults to** `10000` milliseconds (10 seconds).
     * }
     * @return array
     */
    public function reload(array $options = [])
    {
        $options += $this->identity;
        return $this->info = $this->connection->getQueryResults($options + $this->reloadOptions);
    }

    /**
     * Retrieves the query result's identity.
     *
     * An identity provides a description of a nested resource.
     *
     * Example:
     * ```
     * echo $queryResults->identity()['projectId'];
     * ```
     *
     * @return array
     */
    public function identity()
    {
        return $this->identity;
    }
}
