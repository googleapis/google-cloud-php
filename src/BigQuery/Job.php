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

/**
 * [Jobs](https://cloud.google.com/bigquery/docs/reference/v2/jobs) are objects
 * that manage asynchronous tasks such as running queries, loading data, and
 * exporting data.
 */
class Job
{
    /**
     * @var ConnectionInterface $connection Represents a connection to BigQuery.
     */
    private $connection;

    /**
     * @var array The job's metadata
     */
    private $data;

    /**
     * @var array The job's identity.
     */
    private $identity;

    /**
     * @param ConnectionInterface $connection Represents a connection to
     *        BigQuery.
     * @param string $id The job's ID.
     * @param string $projectId The project's ID.
     * @param array $data The job's metadata.
     */
    public function __construct(ConnectionInterface $connection, $id, $projectId, array $data = [])
    {
        $this->connection = $connection;
        $this->data = $data;
        $this->identity = [
            'jobId' => $id,
            'projectId' => $projectId
        ];
    }

    /**
     * Check whether or not the job exists.
     *
     * Example:
     * ```
     * $job->exists();
     * ```
     *
     * @return bool
     */
    public function exists()
    {
        try {
            $this->connection->getJob($this->identity + ['fields' => 'jobReference']);
        } catch (\Exception $ex) {
            if ($ex->getCode() === 404) {
                return false;
            }

            throw $ex;
        }

        return true;
    }

    /**
     * Requests that a job be cancelled. You will need to poll the job to ensure
     * the cancel request successfully goes through.
     *
     * Example:
     * ```
     * $job->cancel();
     *
     * $isComplete = $job->isComplete();
     *
     * while (!$isComplete) {
     *     sleep(1); // let's wait for a moment...
     *     $job->reload();
     *     $isComplete = $job->isComplete();
     * }
     *
     * echo 'Job successfully cancelled.';
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/jobs/cancel Jobs cancel API documentation.
     *
     * @param array $options Configuration options.
     */
    public function cancel(array $options = [])
    {
        $this->connection->cancelJob($options + $this->identity);
    }

    /**
     * Retrieves the results of a query job.
     *
     * Example:
     * ```
     * $job = $bigQuery->runQueryAsJob('SELECT * FROM [bigquery-public-data:usa_names.usa_1910_2013]');
     * $queryResults = $job->getQueryResults();
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/jobs/getQueryResults
     * Jobs getQueryResults API documentation.
     *
     * @param array $options {
     *     Configuration options.
     *
     *     @type int $maxResults Maximum number of results to read.
     *     @type int $startIndex Zero-based index of the starting row.
     *     @type int $timeoutMs How long to wait for the query to complete, in
     *           milliseconds. Defaults to 10000 milliseconds (10 seconds).
     * }
     * @return array
     */
    public function getQueryResults(array $options = [])
    {
        $response = $this->connection->getQueryResults($options + $this->identity);

        return new QueryResults(
            $this->connection,
            $this->identity['jobId'],
            $this->identity['projectId'],
            $response,
            $options
        );
    }

    /**
     * Checks the job's completeness. Useful in combination with
     * {@see Job::reload} to poll for job status.
     *
     * Example:
     * ```
     * $isComplete = $job->isComplete();
     *
     * while (!$isComplete) {
     *     sleep(1); // let's wait for a moment...
     *     $job->reload();
     *     $isComplete = $job->isComplete();
     * }
     *
     * echo 'Query complete!';
     * ```
     * @param array $options Configuration options.
     * @return bool
     */
    public function isComplete(array $options = [])
    {
        return $this->getInfo($options)['status']['state'] === 'DONE';
    }

    /**
     * Retrieves the job's details. If no job data is cached a network request
     * will be made to retrieve it.
     *
     * Example:
     * ```
     * $info = $job->getInfo();
     * echo $info['statistics']['startTime'];
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/jobs#resource Jobs resource documentation.
     *
     * @param array $options Configuration options.
     * @return array
     */
    public function getInfo(array $options = [])
    {
        if (!$this->data) {
            $this->reload($options);
        }

        return $this->data;
    }

    /**
     * Triggers a network request to reload the job's details.
     *
     * Example:
     * ```
     * $job->isComplete(); // returns false
     * sleep(1); // let's wait for a moment...
     * $job->reload(); // execute a network request
     * $job->isComplete(); // true
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/jobs/get Jobs get API documentation.
     *
     * @param array $options Configuration options.
     * @return array
     */
    public function reload(array $options = [])
    {
        return $this->data = $this->connection->getJob($options + $this->identity);
    }

    /**
     * Retrieves the job's ID.
     *
     * Example:
     * ```
     * echo $job->getId();
     * ```
     *
     * @return string
     */
    public function getId()
    {
        return $this->identity['jobId'];
    }

    /**
     * Retrieves the job's identity.
     *
     * An identity provides a description of a nested resource.
     *
     * Example:
     * ```
     * echo $job->getIdentity()['projectId'];
     * ```
     *
     * @return array
     */
    public function getIdentity()
    {
        return $this->identity;
    }
}
