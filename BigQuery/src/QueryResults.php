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
 * [Query Response API Documentation](https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs/query#response-body)
 *
 * This class should be not instantiated directly, but as a result of
 * calling {@see BigQueryClient::runQuery()} or
 * {@see Job::queryResults()}.
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
     * @param array Default options to be used for calls to get query results.
     */
    private $queryResultsOptions;

    /**
     * @param ConnectionInterface $connection Represents a connection to
     *        BigQuery.
     * @param string $jobId The job's ID.
     * @param string $projectId The project's ID.
     * @param array $info The query result's metadata.
     * @param ValueMapper $mapper Maps values between PHP and BigQuery.
     * @param Job $job The job from which the query results originated.
     * @param array $queryResultsOptions Default options to be used for calls to
     *        get query results.
     */
    public function __construct(
        ConnectionInterface $connection,
        $jobId,
        $projectId,
        array $info,
        ValueMapper $mapper,
        Job $job,
        array $queryResultsOptions = []
    ) {
        $this->connection = $connection;
        $this->info = $info;
        $this->job = $job;
        $this->identity = [
            'jobId' => $jobId,
            'projectId' => $projectId,
            'location' => isset($info['jobReference']['location'])
                ? $info['jobReference']['location']
                : $job->identity()['location']
        ];
        $this->mapper = $mapper;
        $this->queryResultsOptions = $queryResultsOptions;
    }

    /**
     * Retrieves the rows associated with the query and merges them together
     * with the table's schema.
     *
     * Refer to the table below for a guide on how BigQuery types are mapped as
     * they come back from the API.
     *
     * | **PHP Type**                    | **BigQuery Data Type**               |
     * |---------------------------------|--------------------------------------|
     * | `\DateTimeInterface`            | `DATETIME`                           |
     * | {@see Bytes}                    | `BYTES`                              |
     * | {@see Date}                     | `DATE`                               |
     * | {@see \Google\Cloud\Core\Int64} | `INTEGER`                            |
     * | {@see Time}                     | `TIME`                               |
     * | {@see Timestamp}                | `TIMESTAMP`                          |
     * | Associative Array               | `RECORD`                             |
     * | Non-Associative Array           | `RECORD` (Repeated)                  |
     * | `float`                         | `FLOAT`                              |
     * | `int`                           | `INTEGER`                            |
     * | `string`                        | `STRING`                             |
     * | `bool`                          | `BOOLEAN`                            |
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
     *     Configuration options. Please note, these options will inherit the
     *     values set by either
     *     {@see BigQueryClient::runQuery()} or
     *     {@see Job::queryResults()}.
     *
     *     @type int $maxResults Maximum number of results to read per page.
     *     @type int $startIndex Zero-based index of the starting row.
     *     @type int $timeoutMs How long, in milliseconds, each API call will
     *           wait for query results to become available before timing out.
     *           Depending on whether the $maxRetries has been exceeded, the
     *           results will be polled again after the timeout has been reached.
     *           **Defaults to** `10000` milliseconds (10 seconds).
     *     @type int $maxRetries The number of times to poll the Job status,
     *           until the job is complete. By default, will poll indefinitely.
     *     @type bool $returnRawResults Returns the raw data types returned from
     *           BigQuery without converting their values into native PHP types or
     *           the custom type classes supported by this library.
     * }
     * @return ItemIterator
     * @throws JobException If the maximum number of retries while waiting for
     *         query completion has been exceeded.
     * @throws GoogleException Thrown in the case of a malformed response.
     */
    public function rows(array $options = [])
    {
        $options += $this->queryResultsOptions;
        $this->waitUntilComplete($options);
        $schema = $this->info['schema']['fields'];
        $returnRawResults = $options['returnRawResults'] ?? false;

        return new ItemIterator(
            new PageIterator(
                function (array $row) use ($schema, $returnRawResults) {
                    $mergedRow = [];

                    if ($row === null) {
                        return $mergedRow;
                    }

                    if (!array_key_exists('f', $row)) {
                        throw new GoogleException('Bad response - missing key "f" for a row.');
                    }

                    foreach ($row['f'] as $key => $value) {
                        $fieldSchema = $schema[$key];
                        $mergedRow[$fieldSchema['name']] = $returnRawResults
                            ? $value['v']
                            : $this->mapper->fromBigQuery($value, $fieldSchema);
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
     *     Configuration options. Please note, these options will inherit the
     *     values set by either
     *     {@see BigQueryClient::runQuery()} or
     *     {@see Job::queryResults()}.
     *
     *     @type int $maxResults Maximum number of results to read per page.
     *     @type int $startIndex Zero-based index of the starting row.
     *     @type int $timeoutMs How long, in milliseconds, each API call will
     *           wait for query results to become available before timing out.
     *           Depending on whether the $maxRetries has been exceeded, the
     *           results will be polled again after the timeout has been reached.
     *           **Defaults to** `10000` milliseconds (10 seconds).
     *     @type int $maxRetries The number of times to poll the Job status,
     *           until the job is complete. By default, will poll indefinitely.
     * }
     * @throws JobException If the maximum number of retries while waiting for
     *         query completion has been exceeded.
     */
    public function waitUntilComplete(array $options = [])
    {
        $options += $this->queryResultsOptions;
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
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs/getQueryResults#response-body
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
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs/getQueryResults
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
     * {@see QueryResults::reload()} to poll for query
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
     * Returns a reference to the {@see Job} instance used
     * to fetch the query results. This is especially useful when attempting to
     * access job statistics after calling
     * {@see BigQueryClient::runQuery()}.
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
    #[\ReturnTypeWillChange]
    public function getIterator()
    {
        return $this->rows();
    }
}
