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
use Google\Cloud\BigQuery\Exception\JobException;
use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Exception\NotFoundException;

/**
 * [Jobs](https://cloud.google.com/bigquery/docs/reference/v2/jobs) are objects
 * that manage asynchronous tasks such as running queries, loading data, and
 * exporting data.
 */
class Job
{
    use ArrayTrait;
    use JobWaitTrait;

    const MAX_RETRIES = PHP_INT_MAX;

    /**
     * @var ConnectionInterface Represents a connection to BigQuery.
     */
    private $connection;

    /**
     * @var array The job's identity.
     */
    private $identity;

    /**
     * @var array The job's metadata
     */
    private $info;

    /**
     * @var ValueMapper $mapper Maps values between PHP and BigQuery.
     */
    private $mapper;

    /**
     * @param ConnectionInterface $connection Represents a connection to
     *        BigQuery.
     * @param string $id The job's ID.
     * @param string $projectId The project's ID.
     * @param ValueMapper $mapper Maps values between PHP and BigQuery.
     * @param array $info [optional] The job's metadata.
     */
    public function __construct(
        ConnectionInterface $connection,
        $id,
        $projectId,
        ValueMapper $mapper,
        array $info = []
    ) {
        $this->connection = $connection;
        $this->info = $info;
        $this->identity = [
            'jobId' => $id,
            'projectId' => $projectId
        ];
        $this->mapper = $mapper;
    }

    /**
     * Check whether or not the job exists.
     *
     * Example:
     * ```
     * echo $job->exists();
     * ```
     *
     * @return bool
     */
    public function exists()
    {
        try {
            $this->connection->getJob($this->identity + ['fields' => 'jobReference']);
        } catch (NotFoundException $ex) {
            return false;
        }

        return true;
    }

    /**
     * Requests that a job be cancelled. You will need to poll the job to ensure
     * the cancel request successfully goes through.
     *
     * Please note that by default the library will not attempt to retry this
     * call on your behalf.
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
     * @param array $options [optional] Configuration options.
     */
    public function cancel(array $options = [])
    {
        $this->connection->cancelJob(
            $options
            + ['retries' => 0]
            + $this->identity
        );
    }

    /**
     * Retrieves the results of a query job.
     *
     * Please note this method will trigger an initial network request, but
     * further polling may be necessary in order to access the full query
     * results. Polling for completion can be initiated by iterating on the
     * returned
     * {@see Google\Cloud\BigQuery\QueryResults}, or by calling either
     * {@see Google\Cloud\BigQuery\QueryResults::rows()} or
     * {@see Google\Cloud\BigQuery\QueryResults::waitUntilComplete()}.
     *
     * Example:
     * ```
     * $queryResults = $job->queryResults();
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
     *     @type int $initialTimeoutMs How long, in milliseconds, to wait for
     *           query results to become available before timing out.
     *           **Defaults to** `0` milliseconds (0 seconds). Please note
     *           that this option is used only for the initial call to get query
     *           results. To control the timeout for any subsequent calls while
     *           polling for query results to complete, please see the
     *           `$timeoutMs` option.
     *     @type int $timeoutMs How long, in milliseconds, each API call will
     *           wait for query results to become available before timing out.
     *           Depending on whether the $maxRetries has been exceeded,
     *           the results will be polled again after the timeout has been
     *           reached. **Defaults to** `10000` milliseconds (10 seconds).
     *           Please note that this option is used when iterating on the
     *           returned class, and will not apply immediately upon calling of
     *           this method.
     *     @type int $maxRetries The number of times to poll the Job status,
     *           until the job is complete. By default, will poll indefinitely.
     *           Please note that this option is used when iterating on the
     *           returned class, and will not block immediately upon calling of
     *           this method.
     * }
     * @return QueryResults
     */
    public function queryResults(array $options = [])
    {
        $timeoutMs = $this->pluck('initialTimeoutMs', $options, false) ?: 0;
        $queryResultsOptions = $options;
        $options['timeoutMs'] = $timeoutMs;

        return new QueryResults(
            $this->connection,
            $this->identity['jobId'],
            $this->identity['projectId'],
            $this->connection->getQueryResults($options + $this->identity),
            $this->mapper,
            $this,
            $queryResultsOptions
        );
    }

    /**
     * Blocks until the job is complete.
     *
     * Example:
     * ```
     * $job->waitUntilComplete();
     * ```
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $maxRetries The number of times to poll the Job status,
     *           until the job is complete. By default, will poll indefinitely.
     * }
     * @throws JobException If the maximum number of retries while waiting for
     *         job completion has been exceeded.
     */
    public function waitUntilComplete(array $options = [])
    {
        $maxRetries = $this->pluck('maxRetries', $options, false);
        $this->wait(
            function () use ($options) {
                return $this->isComplete($options);
            },
            function () use ($options) {
                return $this->reload($options);
            },
            $this,
            $maxRetries
        );
    }

    /**
     * Checks the job's completeness. Useful in combination with
     * {@see Google\Cloud\BigQuery\Job::reload()} to poll for job status.
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
     *
     * @param array $options [optional] Configuration options.
     * @return bool
     */
    public function isComplete(array $options = [])
    {
        return $this->info($options)['status']['state'] === 'DONE';
    }

    /**
     * Retrieves the job's details. If no job data is cached a network request
     * will be made to retrieve it.
     *
     * Example:
     * ```
     * $info = $job->info();
     * echo $info['statistics']['startTime'];
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/jobs#resource Jobs resource documentation.
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function info(array $options = [])
    {
        if (!$this->info) {
            $this->reload($options);
        }

        return $this->info;
    }

    /**
     * Triggers a network request to reload the job's details.
     *
     * Example:
     * ```
     * echo $job->isComplete(); // false
     * sleep(1); // let's wait for a moment...
     * $job->reload(); // execute a network request
     * echo $job->isComplete(); // true
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/jobs/get Jobs get API documentation.
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function reload(array $options = [])
    {
        return $this->info = $this->connection->getJob($options + $this->identity);
    }

    /**
     * Retrieves the job's ID.
     *
     * Example:
     * ```
     * echo $job->id();
     * ```
     *
     * @return string
     */
    public function id()
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
     * echo $job->identity()['projectId'];
     * ```
     *
     * @return array
     */
    public function identity()
    {
        return $this->identity;
    }
}
