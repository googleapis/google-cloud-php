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
use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;

/**
 * QueryResults represent the result of a BigQuery SQL query. Read more at the
 * [Query Response API Documentation](https://cloud.google.com/bigquery/docs/reference/v2/jobs/query#response).
 *
 * This class should be not instantiated directly, but as a result of
 * calling {@see Google\Cloud\BigQuery\BigQueryClient::runQuery()} or
 * {@see Google\Cloud\BigQuery\Job::queryResults()}.
 */
class QueryResults implements \IteratorAggregate
{
    use ArrayTrait;
    use JobWaitTrait;

    /**
     * @var ConnectionInterface Represents a connection to BigQuery.
     */
    protected $connection;

    /**
     * @var array The query result's identity.
     */
    private $identity;

    /**
     * @var array The query result's metadata.
     */
    private $info;

    /**
     * @var Job The job from which the query results originated.
     */
    private $job;

    /**
     * @var ValueMapper Maps values between PHP and BigQuery.
     */
    private $mapper;

    /**
     * @param ConnectionInterface $connection Represents a connection to
     *        BigQuery.
     * @param string $jobId The job's ID.
     * @param string $projectId The project's ID.
     * @param array $info The query result's metadata.
     * @param ValueMapper $mapper Maps values between PHP and BigQuery.
     * @param Job $job The job from which the query results originated.
     */
    public function __construct(
        ConnectionInterface $connection,
        $jobId,
        $projectId,
        array $info,
        ValueMapper $mapper,
        Job $job
    ) {
        $this->connection = $connection;
        $this->info = $info;
        $this->identity = [
            'jobId' => $jobId,
            'projectId' => $projectId
        ];
        $this->mapper = $mapper;
        $this->job = $job;
    }

    /**
     * Retrieves the rows associated with the query and merges them together
     * with the table's schema.
     *
     * Refer to the table below for a guide on how BigQuery types are mapped as
     * they come back from the API.
     *
     * | **PHP Type**                               | **BigQuery Data Type**               |
     * |--------------------------------------------|--------------------------------------|
     * | `\DateTimeInterface`                       | `DATETIME`                           |
     * | {@see Google\Cloud\BigQuery\Bytes}         | `BYTES`                              |
     * | {@see Google\Cloud\BigQuery\Date}          | `DATE`                               |
     * | {@see Google\Cloud\Core\Int64}             | `INTEGER`                            |
     * | {@see Google\Cloud\BigQuery\Time}          | `TIME`                               |
     * | {@see Google\Cloud\BigQuery\Timestamp}     | `TIMESTAMP`                          |
     * | Associative Array                          | `RECORD`                             |
     * | Non-Associative Array                      | `RECORD` (Repeated)                  |
     * | `float`                                    | `FLOAT`                              |
     * | `int`                                      | `INTEGER`                            |
     * | `string`                                   | `STRING`                             |
     * | `bool`                                     | `BOOLEAN`                            |
     *
     * Example:
     * ```
     * $rows = $queryResults->rows();
     *
     * foreach ($rows as $row) {
     *     echo $row['name'] . PHP_EOL;
     * }
     * ```
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $maxResults Maximum number of results to read per page.
     *     @type int $startIndex Zero-based index of the starting row.
     *     @type int $timeoutMs If not yet complete, how long to wait in
     *           milliseconds. **Defaults to** `10000` milliseconds (10 seconds).
     *     @type int $maxRetries The number of times to retry, checking if the
     *           query has completed. **Defaults to** `100`.
     * }
     * @return ItemIterator
     * @throws JobException If the maximum number of retries while waiting for
     *         query completion has been exceeded.
     * @throws GoogleException Thrown in the case of a malformed response.
     */
    public function rows(array $options = [])
    {
        $this->waitUntilComplete($options);
        $schema = $this->info['schema']['fields'];

        return new ItemIterator(
            new PageIterator(
                function (array $row) use ($schema) {
                    $mergedRow = [];

                    if ($row === null) {
                        return $mergedRow;
                    }

                    if (!array_key_exists('f', $row)) {
                        throw new GoogleException('Bad response - missing key "f" for a row.');
                    }

                    foreach ($row['f'] as $key => $value) {
                        $fieldSchema = $schema[$key];
                        $mergedRow[$fieldSchema['name']] = $this->mapper->fromBigQuery($value, $fieldSchema);
                    }

                    return $mergedRow;
                },
                [$this->connection, 'getQueryResults'],
                $options + $this->identity,
                [
                    'itemsKey' => 'rows',
                    'firstPage' => $this->info,
                    'nextResultTokenKey' => 'pageToken'
                ]
            )
        );
    }

    /**
     * Blocks until the query is complete.
     *
     * Example:
     * ```
     * $queryResults->waitUntilComplete();
     * ```
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $maxResults Maximum number of results to read per page.
     *     @type int $startIndex Zero-based index of the starting row.
     *     @type int $timeoutMs If not yet complete, how long to wait for the
     *           query to complete, in milliseconds. **Defaults to**
     *           `10000` milliseconds (10 seconds).
     *     @type int $maxRetries The number of times to retry, checking if the
     *           query has completed. **Defaults to** `100`.
     * }
     * @throws JobException If the maximum number of retries while waiting for
     *         query completion has been exceeded.
     */
    public function waitUntilComplete(array $options = [])
    {
        $maxRetries = $this->pluck('maxRetries', $options, false);
        $this->wait(
            function () {
                return $this->isComplete();
            },
            function () use ($options) {
                return $this->reload($options);
            },
            $this->job,
            $maxRetries
        );
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
     * Example:
     * ```
     * $queryResults->reload();
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/jobs/getQueryResults
     * Jobs getQueryResults API documentation.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $maxResults Maximum number of results to read per page.
     *     @type int $startIndex Zero-based index of the starting row.
     *     @type int $timeoutMs How long to wait for the query to complete, in
     *           milliseconds. **Defaults to** `10000` milliseconds (10 seconds).
     * }
     * @return array
     */
    public function reload(array $options = [])
    {
        return $this->info = $this->connection->getQueryResults(
            $options + $this->identity
        );
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

    /**
     * Checks the job's completeness. Useful in combination with
     * {@see Google\Cloud\BigQuery\QueryResults::reload()} to poll for query
     * status.
     *
     * Example:
     * ```
     * $isComplete = $queryResults->isComplete();
     *
     * while (!$isComplete) {
     *     sleep(1); // let's wait for a moment...
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
     * Returns a reference to the {@see Google\Cloud\BigQuery\Job} instance used
     * to fetch the query results. This is especially useful when attempting to
     * access job statistics after calling
     * {@see Google\Cloud\BigQuery\BigQueryClient::runQuery()}.
     *
     * Example:
     * ```
     * $job = $queryResults->job();
     * ```
     *
     * @return array
     */
    public function job()
    {
        return $this->job;
    }

    /**
     * @access private
     * @return ItemIterator
     * @throws JobException If the maximum number of retries while waiting for
     *         query completion has been exceeded.
     * @throws GoogleException Thrown in the case of a malformed response.
     */
    public function getIterator()
    {
        return $this->rows();
    }
}
