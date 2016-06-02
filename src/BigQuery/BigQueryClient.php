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
use Google\Cloud\BigQuery\Connection\Rest;

/**
 * Google Cloud BigQuery client. Allows you to create, manage, share and query
 * data. Find more information at
 * [Google Cloud BigQuery Docs](https://cloud.google.com/bigquery/what-is-bigquery).
 */
class BigQueryClient
{
    use JobConfigurationTrait;

    const SCOPE = 'https://www.googleapis.com/auth/bigquery';
    const INSERT_SCOPE = 'https://www.googleapis.com/auth/bigquery.insertdata';

    /**
     * @var ConnectionInterface $connection Represents a connection to BigQuery.
     */
    protected $connection;

    /**
     * @var string The project ID created in the Google Developers Console.
     */
    private $projectId;

    /**
     * Create a BigQuery client.
     *
     * Example:
     * ```
     * use Google\Cloud\BigQuery\BigQueryClient;
     *
     * $bigQuery = new BigQueryClient([
     *     'projectId' => 'myAwesomeProject'
     * ]);
     * ```
     *
     * @param array $config {
     *     Configuration options.
     *
     *     @type string $projectId The project ID from the Google Developer's
     *           Console.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *     @type string $keyFile The contents of the service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type int $retries Number of retries for a failed request. Defaults
     *           to 3.
     *     @type array $scopes Scopes to be used for the request.
     * }
     */
    public function __construct(array $config = [])
    {
        if (!isset($config['projectId'])) {
            throw new \InvalidArgumentException('A projectId is required.');
        }

        if (!isset($config['scopes'])) {
            $config['scopes'] = [self::SCOPE];
        }

        $this->connection = new Rest($config);
        $this->projectId = $config['projectId'];
    }

    /**
     * Runs a BigQuery SQL query in a synchronous fashion. Rows are returned
     * immediately as long as the query completes within a specified timeout. In
     * the case that the query does not complete in the specified timeout, you
     * are able to poll the query's status until it is complete.
     *
     * Example:
     * ```
     * $queryResults = $bigQuery->runQuery('SELECT * FROM [bigquery-public-data:usa_names.usa_1910_2013]');
     *
     * $isComplete = $queryResults->isComplete();
     *
     * while (!$isComplete) {
     *     sleep(1); // let's wait for a moment...
     *     $queryResults->reload(); // trigger a network request
     *     $isComplete = $queryResults->isComplete(); // check the query's status
     * }
     *
     * foreach ($queryResults->rows() as $row) {
     *     echo $row['name'];
     * }
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/jobs/query Query API documentation.
     *
     * @param string $query A BigQuery SQL query.
     * @param array $options {
     *     Configuration options.
     *
     *     @type int $maxResults The maximum number of rows to return per page
     *           of results. Setting this flag to a small value such as 1000 and
     *           then paging through results might improve reliability when the
     *           query result set is large.
     *     @type array $defaultDataset Specifies the default datasetId and
     *           projectId to assume for any unqualified table names in the
     *           query. If not set, all table names in the query string must be
     *           qualified in the format 'datasetId.tableId'.
     *     @type int $timeoutMs How long to wait for the query to complete, in
     *           milliseconds. Defaults to 10000 milliseconds (10 seconds).
     *     @type bool $useQueryCache Whether to look for the result in the query
     *           cache.
     *     @type bool $useLegacySql Specifies whether to use BigQuery's legacy
     *           SQL dialect for this query.
     * }
     * @return QueryResults
     */
    public function runQuery($query, array $options = [])
    {
        $response = $this->connection->query([
            'projectId' => $this->projectId,
            'query' => $query
        ] + $options);

        return new QueryResults(
            $this->connection,
            $response['jobReference']['jobId'],
            $this->projectId,
            $response,
            $options
        );
    }

    /**
     * Runs a BigQuery SQL query in an asynchronous fashion. Running a query
     * in this fashion requires you to poll for the status before being able
     * to access results.
     *
     * Example:
     * ```
     * $job = $bigQuery->runQueryAsJob('SELECT * FROM [bigquery-public-data:usa_names.usa_1910_2013]');
     *
     * $isComplete = false;
     * $queryResults = $job->queryResults();
     *
     * while (!$isComplete) {
     *     sleep(1); // let's wait for a moment...
     *     $queryResults->reload(); // trigger a network request
     *     $isComplete = $queryResults->isComplete(); // check the query's status
     * }
     *
     * foreach ($queryResults->rows() as $row) {
     *     echo $row['name'];
     * }
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/jobs/insert Jobs insert API documentation.
     *
     * @param string $query A BigQuery SQL query.
     * @param array $options {
     *     Configuration options.
     *
     *     @type array $jobConfig Configuration settings for a query job are
     *           outlined in the [API Docs for `configuration.query`](https://goo.gl/PuRa3I).
     *           If not provided default settings will be used.
     * }
     * @return Job
     */
    public function runQueryAsJob($query, array $options = [])
    {
        $config = $this->buildJobConfig(
            'query',
            $this->projectId,
            ['query' => $query],
            $options
        );

        $response = $this->connection->insertJob($config);

        return new Job($this->connection, $response['jobReference']['jobId'], $this->projectId, $response);
    }

    /**
     * Lazily instantiates a job. There are no network requests made at this
     * point. To see the operations that can be performed on a job please
     * see {@see Google\Cloud\BigQuery\Job}.
     *
     * Example:
     * ```
     * $job = $bigQuery->job('myJobId');
     * ```
     *
     * @param string $id The id of the job to request.
     * @return Job
     */
    public function job($id)
    {
        return new Job($this->connection, $id, $this->projectId);
    }

    /**
     * Fetches jobs in the project.
     *
     * Example:
     * ```
     * // Get all jobs with the state of 'done'
     * $jobs = $bigQuery->jobs([
     *     'stateFilter' => 'done'
     * ]);
     *
     * foreach ($jobs as $job) {
     *     var_dump($job->id());
     * }
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/jobs/list Jobs list API documentation.
     *
     * @param array $options {
     *     Configuration options.
     *
     *     @type bool $allUsers Whether to display jobs owned by all users in
     *           the project. Defaults to false.
     *     @type int $maxResults Maximum number of results to return.
     *     @type string $stateFilter Filter for job state. Maybe be either
     *           `done`, `pending`, or `running`.
     * }
     * @return \Generator
     */
    public function jobs(array $options = [])
    {
        $options['pageToken'] = null;

        do {
            $response = $this->connection->listJobs($options + ['projectId' => $this->projectId]);

            if (!isset($response['jobs'])) {
                return;
            }

            foreach ($response['jobs'] as $job) {
                yield new Job(
                    $this->connection,
                    $job['jobReference']['jobId'],
                    $this->projectId,
                    $job
                );
            }

            $options['pageToken'] = isset($response['nextPageToken']) ? $response['nextPageToken'] : null;
        } while ($options['pageToken']);
    }

    /**
     * Lazily instantiates a dataset. There are no network requests made at this
     * point. To see the operations that can be performed on a dataset please
     * see {@see Google\Cloud\BigQuery\Dataset}.
     *
     * Example:
     * ```
     * $dataset = $bigQuery->dataset('myDatasetId');
     * ```
     *
     * @param string $id The id of the dataset to request.
     * @return Dataset
     */
    public function dataset($id)
    {
        return new Dataset($this->connection, $id, $this->projectId);
    }

    /**
     * Fetches datasets in the project.
     *
     * Example:
     * ```
     * $datasets = $bigQuery->datasets();
     *
     * foreach ($datasets as $dataset) {
     *     var_dump($dataset->id());
     * }
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/datasets/list Datasets list API documentation.
     *
     * @param array $options {
     *     Configuration options.
     *
     *     @type bool $all Whether to list all datasets, including hidden ones.
     *     @type int $maxResults Maximum number of results to return.
     * }
     * @return \Generator
     */
    public function datasets(array $options = [])
    {
        $options['pageToken'] = null;

        do {
            $response = $this->connection->listDatasets($options + ['projectId' => $this->projectId]);

            if (!isset($response['datasets'])) {
                return;
            }

            foreach ($response['datasets'] as $dataset) {
                yield new Dataset(
                    $this->connection,
                    $dataset['datasetReference']['datasetId'],
                    $this->projectId,
                    $dataset
                );
            }

            $options['pageToken'] = isset($response['nextPageToken']) ? $response['nextPageToken'] : null;
        } while ($options['pageToken']);
    }

    /**
     * Creates a dataset.
     *
     * Example:
     * ```
     * $dataset = $bigQuery->createDataset('aDataset');
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/datasets/insert Datasets insert API documentation.
     *
     * @param string $id The id of the dataset to create.
     * @param array $options {
     *     Configuration options.
     *
     *     @type array $metadata The available options for metadata are outlined
     *           at the
     *           [Dataset Resource API docs](https://cloud.google.com/bigquery/docs/reference/v2/datasets#resource)
     * }
     * @return Dataset
     */
    public function createDataset($id, array $options = [])
    {
        if (isset($options['metadata'])) {
            $options += $options['metadata'];
            unset($options['metadata']);
        }

        $response = $this->connection->insertDataset([
            'projectId' => $this->projectId,
            'datasetReference' => [
                'datasetId' => $id
            ]
        ] + $options);

        return new Dataset($this->connection, $id, $this->projectId, $response);
    }
}
