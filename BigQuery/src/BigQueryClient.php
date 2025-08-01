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

use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\BigQuery\Connection\Rest;
use Google\Cloud\BigQuery\Exception\JobException;
use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\ClientTrait;
use Google\Cloud\Core\Int64;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Core\RetryDeciderTrait;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Google Cloud BigQuery allows you to create, manage, share and query data.
 * Find more information at the
 * [Google Cloud BigQuery Docs](https://cloud.google.com/bigquery/docs).
 *
 * Example:
 * ```
 * use Google\Cloud\BigQuery\BigQueryClient;
 *
 * $bigQuery = new BigQueryClient();
 * ```
 */
class BigQueryClient
{
    use ArrayTrait;
    use ClientTrait, RetryDeciderTrait {
        ClientTrait::jsonEncode insteadof RetryDeciderTrait;
        ClientTrait::jsonDecode insteadof RetryDeciderTrait;
    }

    const VERSION = '1.34.0';

    const MAX_DELAY_MICROSECONDS = 32000000;

    const SCOPE = 'https://www.googleapis.com/auth/bigquery';
    const INSERT_SCOPE = 'https://www.googleapis.com/auth/bigquery.insertdata';

    /**
     * @var ConnectionInterface Represents a connection to BigQuery.
     * @internal
     */
    protected $connection;

    /**
     * @var string The default geographic location.
     */
    private $location;

    /**
     * @var ValueMapper Maps values between PHP and BigQuery.
     */
    private $mapper;

    /**
     * Create a BigQuery client.
     *
     * @param array $config [optional] {
     *     Configuration options.
     *
     *     @type string $apiEndpoint The hostname with optional port to use in
     *           place of the default service endpoint. Example:
     *           `foobar.com` or `foobar.com:1234`.
     *     @type string $projectId The project ID from the Google Developer's
     *           Console.
     *     @type CacheItemPoolInterface $authCache A cache for storing access
     *           tokens. **Defaults to** a simple in memory implementation.
     *     @type array $authCacheOptions Cache configuration options.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type FetchAuthTokenInterface $credentialsFetcher A credentials
     *           fetcher instance.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *           Only valid for requests sent over REST.
     *     @type array $keyFile The contents of the service account credentials
     *           .json file retrieved from the Google Developer's Console.
     *           Ex: `json_decode(file_get_contents($path), true)`.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type float $requestTimeout Seconds to wait before timing out the
     *           request. **Defaults to** `0` with REST and `60` with gRPC.
     *     @type int $retries Number of retries for a failed request. **Defaults
     *           to** `3`.
     *     @type array $scopes Scopes to be used for the request.
     *     @type string $quotaProject Specifies a user project to bill for
     *           access charges associated with the request.
     *     @type bool $returnInt64AsObject If true, 64 bit integers will be
     *           returned as a {@see Int64} object for 32 bit
     *           platform compatibility. **Defaults to** false.
     *     @type string $location If provided, determines the default geographic
     *           location used when creating datasets and managing jobs. Please
     *           note: This is only required for jobs started outside of the US
     *           and EU regions. Also, if location metadata has already been
     *           fetched over the network it will take precedent over this
     *           setting (by calling
     *           {@see Table::reload()}, for example).
     * }
     */
    public function __construct(array $config = [])
    {
        $this->location = $this->pluck('location', $config, false);
        $this->setHttpRetryCodes([502]);
        $this->setHttpRetryMessages([
            'rateLimitExceeded',
            'backendError'
        ]);
        $config += [
            'scopes' => [self::SCOPE],
            'projectIdRequired' => true,
            'returnInt64AsObject' => false,
            'restRetryFunction' => $this->getRetryFunction(),
            //@codeCoverageIgnoreStart
            'restCalcDelayFunction' => function ($attempt) {
                return min(
                    mt_rand(0, 1000000) + (pow(2, $attempt) * 1000000),
                    self::MAX_DELAY_MICROSECONDS
                );
            }
            //@codeCoverageIgnoreEnd
        ];

        $this->connection = new Rest($this->configureAuthentication($config));
        $this->mapper = new ValueMapper($config['returnInt64AsObject']);
    }

    /**
     * Returns a BigQuery job configuration.
     *
     * The job configuration is passed to either
     * {@see BigQueryClient::runQuery()} or
     * {@see BigQueryClient::startQuery()}. A
     * configuration can be built using fluent setters or by providing a full
     * set of options at once.
     *
     * Unless otherwise specified, all configuration options will default based on the
     * [query job configuration](https://cloud.google.com/bigquery/docs/reference/rest/v2/Job#jobconfigurationquery)
     * except for `configuration.query.useLegacySql`, which defaults to `false`
     * in this client.
     *
     * Example:
     * ```
     * $queryJobConfig = $bigQuery->query(
     *     'SELECT commit FROM `bigquery-public-data.github_repos.commits` LIMIT 100'
     * );
     * ```
     *
     * ```
     * // Set create disposition using fluent setters.
     * $queryJobConfig = $bigQuery->query(
     *     'SELECT commit FROM `bigquery-public-data.github_repos.commits` LIMIT 100'
     * )->createDisposition('CREATE_NEVER');
     * ```
     *
     * ```
     * // This is equivalent to the above example, using array configuration
     * // instead of fluent setters.
     * $queryJobConfig = $bigQuery->query(
     *     'SELECT commit FROM `bigquery-public-data.github_repos.commits` LIMIT 100',
     *     [
     *         'configuration' => [
     *             'query' => [
     *                 'createDisposition' => 'CREATE_NEVER'
     *             ]
     *         ]
     *     ]
     * );
     * ```
     *
     * ```
     * // Set a region to run the job in.
     * $queryJobConfig = $bigQuery->query(
     *     'SELECT name FROM `my_project.users_dataset.users` LIMIT 100'
     * )->location('asia-northeast1');
     * ```
     *
     * @param string $query A BigQuery SQL query.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $configuration Job configuration. Please see the
     *           [API documentation](https://cloud.google.com/bigquery/docs/reference/rest/v2/Job#jobconfiguration)
     *           for the available options.
     *     @type array $configuration.query Query job configuration. Please see the
     *           [documentation](https://cloud.google.com/bigquery/docs/reference/rest/v2/Job#jobconfigurationquery)
     *           for the available options.
     * }
     * @return QueryJobConfiguration
     */
    public function query($query, array $options = [])
    {
        return (new QueryJobConfiguration(
            $this->mapper,
            $this->projectId,
            $options,
            $this->location
        ))->query($query);
    }

    /**
     * Returns a BigQuery job configuration.
     *
     * The job configuration is passed to either
     * {@see BigQueryClient::runQuery()} or
     * {@see BigQueryClient::startQuery()}. A
     * configuration can be built using fluent setters or by providing a full
     * set of options at once.
     *
     * Unless otherwise specified, all configuration options will default based on the
     * [query job configuration](https://cloud.google.com/bigquery/docs/reference/rest/v2/Job#jobconfigurationquery)
     * except for `configuration.query.useLegacySql`, which defaults to `false`
     * in this client.
     *
     * As this method is an alias, please see
     * {@see BigQueryClient::query()} for usage examples.
     *
     * @param string $query A BigQuery SQL query.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $configuration Job configuration. Please see the
     *           [API documentation](https://cloud.google.com/bigquery/docs/reference/rest/v2/Job#jobconfiguration)
     *           for the available options.
     *     @type array $configuration.query Query job configuration. Please see the
     *           [documentation](https://cloud.google.com/bigquery/docs/reference/rest/v2/Job#jobconfigurationquery)
     *           for the available options.
     * }
     * @return QueryJobConfiguration
     */
    public function queryConfig($query, array $options = [])
    {
        return $this->query($query, $options);
    }

    /**
     * Runs a BigQuery SQL query in a synchronous fashion.
     *
     * This method is ideal for queries which return results quickly - otherwise
     * we highly recommend utilizing {@see BigQueryClient::startQuery()}
     * as it provides better mechanisms for fine grained control over result polling.
     *
     * Unless `$options.maxRetries` is specified, this method will block until
     * the query completes, at which time the result set will be returned.
     *
     * Queries constructed using
     * [standard SQL](https://cloud.google.com/bigquery/docs/reference/standard-sql/)
     * can take advantage of parameterization.
     *
     * Refer to the table below for a guide on how parameter types are mapped to
     * their BigQuery equivalents.
     *
     * | **PHP Type**                               | **BigQuery Data Type**               |
     * |--------------------------------------------|--------------------------------------|
     * | `\DateTimeInterface`                       | `DATETIME`                           |
     * | {@see Bytes}                               | `BYTES`                              |
     * | {@see Date}                                | `DATE`                               |
     * | {@see Int64}                               | `INT64`                              |
     * | {@see Time}                                | `TIME`                               |
     * | {@see Timestamp}                           | `TIMESTAMP`                          |
     * | Associative Array                          | `STRUCT`                             |
     * | Non-Associative Array                      | `ARRAY`                              |
     * | `float`                                    | `FLOAT64`                            |
     * | `int`                                      | `INT64`                              |
     * | `string`                                   | `STRING`                             |
     * | `resource`                                 | `BYTES`                              |
     * | `bool`                                     | `BOOL`                               |
     * | `object` (Outside types specified above)   | **ERROR** `InvalidArgumentException` |
     *
     * Example:
     * ```
     * $queryJobConfig = $bigQuery->query(
     *     'SELECT commit FROM `bigquery-public-data.github_repos.commits` LIMIT 100'
     * );
     * $queryResults = $bigQuery->runQuery($queryJobConfig);
     *
     * foreach ($queryResults as $row) {
     *     echo $row['commit'];
     * }
     * ```
     *
     * ```
     * // Construct a query utilizing named parameters.
     * $query = 'SELECT commit FROM `bigquery-public-data.github_repos.commits`' .
     *          'WHERE author.date < @date AND message = @message LIMIT 100';
     * $queryJobConfig = $bigQuery->query($query)
     *     ->parameters([
     *         'date' => $bigQuery->timestamp(new \DateTime('1980-01-01 12:15:00Z')),
     *         'message' => 'A commit message.'
     *     ]);
     * $queryResults = $bigQuery->runQuery($queryJobConfig);
     *
     * foreach ($queryResults as $row) {
     *     echo $row['commit'];
     * }
     * ```
     *
     * ```
     * // Construct a query utilizing positional parameters.
     * $query = 'SELECT commit FROM `bigquery-public-data.github_repos.commits` WHERE message = ? LIMIT 100';
     * $queryJobConfig = $bigQuery->query($query)
     *     ->parameters(['A commit message.']);
     * $queryResults = $bigQuery->runQuery($queryJobConfig);
     *
     * foreach ($queryResults as $row) {
     *     echo $row['commit'];
     * }
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs/insert Jobs insert API Documentation.
     *
     * @param QueryJobConfiguration $query A BigQuery SQL query configuration.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $maxResults The maximum number of rows to return per page
     *           of results. Setting this flag to a small value such as 1000 and
     *           then paging through results might improve reliability when the
     *           query result set is large.
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
     *           the custom type classes supported by this library. Default is false.
     *     @type boolean $formatOptions.useInt64Timestamp Optional. Output
     *           timestamp as usec int64. Default is false.
     * }
     * @return QueryResults
     * @throws JobException If the maximum number of retries while waiting for
     *         query completion has been exceeded.
     */
    public function runQuery(JobConfigurationInterface $query, array $options = [])
    {
        $queryResultsOptions = $this->pluckArray([
            'maxResults',
            'startIndex',
            'timeoutMs',
            'maxRetries',
            'returnRawResults',
            'formatOptions',
            'formatOptions.useInt64Timestamp'
        ], $options);
        $queryResultsOptions['initialTimeoutMs'] = 10000;

        $queryResults = $this->startQuery(
            $query,
            $options
        )->queryResults($queryResultsOptions + $options);
        $queryResults->waitUntilComplete();
        return $queryResults;
    }

    /**
     * Runs a BigQuery SQL query in an asynchronous fashion.
     *
     * Queries constructed using
     * [standard SQL](https://cloud.google.com/bigquery/docs/reference/standard-sql/)
     * can take advantage of parameterization. For more details and examples
     * please see {@see BigQueryClient::runQuery()}.
     *
     * Example:
     * ```
     * $queryJobConfig = $bigQuery->query(
     *     'SELECT commit FROM `bigquery-public-data.github_repos.commits` LIMIT 100'
     * );
     * $job = $bigQuery->startQuery($queryJobConfig);
     * $queryResults = $job->queryResults();
     *
     * foreach ($queryResults as $row) {
     *     echo $row['commit'];
     * }
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/jobs/insert Jobs insert API documentation.
     *
     * @param QueryJobConfiguration $query A BigQuery SQL query configuration.
     * @param array $options [optional] Configuration options.
     * @return Job
     */
    public function startQuery(JobConfigurationInterface $query, array $options = [])
    {
        return $this->startJob($query, $options);
    }

    /**
     * Lazily instantiates a job.
     *
     * There are no network requests made at this
     * point. To see the operations that can be performed on a job please
     * see {@see Job}.
     *
     * Example:
     * ```
     * $job = $bigQuery->job('myJobId');
     * ```
     *
     * @param string $id The id of the already run or running job to request.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $location The geographic location of the job. Required
     *           for jobs started outside of the US and EU regions.
     *           **Defaults to** a location specified in the client
     *           configuration.
     * }
     * @return Job
     */
    public function job($id, array $options = [])
    {
        return new Job(
            $this->connection,
            $id,
            $this->projectId,
            $this->mapper,
            [],
            isset($options['location'])
                ? $options['location']
                : $this->location
        );
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
     *     echo $job->id() . PHP_EOL;
     * }
     * ```
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs/list Jobs list API documentation.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type bool $allUsers Whether to display jobs owned by all users in
     *           the project. **Defaults to** `false`.
     *     @type int $maxResults Maximum number of results to return per page.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     *     @type string $stateFilter Filter for job state. Maybe be either
     *           `done`, `pending`, or `running`.
     *     @type int $maxCreationTime Milliseconds since the POSIX epoch. If set, only jobs created
     *           before or at this timestamp are returned.
     *     @type int $minCreationTime Milliseconds since the POSIX epoch. If set, only jobs created
     *           after or at this timestamp are returned.
     *     @type string $parentJobId If set, show only child jobs of the
     *           specified parent. Otherwise, show all top-level jobs.
     * }
     * @return ItemIterator<Job>
     */
    public function jobs(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);

        return new ItemIterator(
            new PageIterator(
                function (array $job) {
                    return new Job(
                        $this->connection,
                        $job['jobReference']['jobId'],
                        $this->projectId,
                        $this->mapper,
                        $job
                    );
                },
                [$this->connection, 'listJobs'],
                $options + ['projectId' => $this->projectId],
                [
                    'itemsKey' => 'jobs',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Lazily instantiates a dataset.
     *
     * There are no network requests made at this
     * point. To see the operations that can be performed on a dataset please
     * see {@see Dataset}.
     *
     * If the dataset is owned by a different project than the project used to authenticate the client,
     * provide the project ID as the second argument.
     *
     * Example:
     * ```
     * $dataset = $bigQuery->dataset('myDatasetId');
     * ```
     *
     * ```
     * // Reference a dataset from other project.
     * $dataset = $bigQuery->dataset('samples', 'bigquery-public-data');
     * ```
     *
     * @param string $id The id of the dataset to request.
     * @param string|null $projectId The id of the project. **Defaults to** current project id.
     * @return Dataset
     */
    public function dataset($id, $projectId = null)
    {
        return new Dataset(
            $this->connection,
            $id,
            $projectId ?: $this->projectId,
            $this->mapper,
            [],
            $this->location
        );
    }

    /**
     * Fetches datasets in the project.
     *
     * Example:
     * ```
     * $datasets = $bigQuery->datasets();
     *
     * foreach ($datasets as $dataset) {
     *     echo $dataset->id() . PHP_EOL;
     * }
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/datasets/list Datasets list API documentation.
     *
     * @codingStandardsIgnoreStart
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type bool $all Whether to list all datasets, including hidden ones.
     *           **Defaults to** `false`.
     *     @type int $maxResults Maximum number of results to return per page.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     *     @type string $filter An expression for filtering the results of the
     *           request by label. The syntax is "labels.<name>[:<value>]".
     *           Multiple filters can be ANDed together by connecting with a
     *           space. Example: "labels.department:receiving labels.active".
     *           See [Filtering datasets using labels](https://cloud.google.com/bigquery/docs/filtering-labels#filtering_datasets_using_labels)
     *           for details.
     * }
     * @codingStandardsIgnoreEnd
     * @return ItemIterator<Dataset>
     */
    public function datasets(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);

        return new ItemIterator(
            new PageIterator(
                function (array $dataset) {
                    return new Dataset(
                        $this->connection,
                        $dataset['datasetReference']['datasetId'],
                        $this->projectId,
                        $this->mapper,
                        $dataset
                    );
                },
                [$this->connection, 'listDatasets'],
                $options + ['projectId' => $this->projectId],
                [
                    'itemsKey' => 'datasets',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Creates a dataset.
     *
     * Please note that by default the library will not attempt to retry this
     * call on your behalf. Additionally, if a default location is provided in
     * the client configuration it will be used when creating the dataset.
     *
     * Example:
     * ```
     * $dataset = $bigQuery->createDataset('aDataset');
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/datasets/insert Datasets insert API documentation.
     *
     * @param string $id The id of the dataset to create.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $metadata The available options for metadata are outlined
     *           at the [Dataset Resource API docs](
     *           https://cloud.google.com/bigquery/docs/reference/rest/v2/datasets)
     * }
     * @return Dataset
     */
    public function createDataset($id, array $options = [])
    {
        if (isset($options['metadata'])) {
            $options += $options['metadata'];
            unset($options['metadata']);
        }

        if ($this->location && !isset($options['location'])) {
            $options['location'] = $this->location;
        }

        $response = $this->connection->insertDataset(
            [
                'projectId' => $this->projectId,
                'datasetReference' => [
                    'datasetId' => $id
                ]
            ]
            + $options
            + ['retries' => 0]
        );

        return new Dataset(
            $this->connection,
            $id,
            $this->projectId,
            $this->mapper,
            $response
        );
    }

    /**
     * Starts a job in a synchronous fashion, waiting for the job to complete
     * before returning.
     *
     * Example:
     * ```
     * $job = $bigQuery->runJob($jobConfig);
     * echo $job->isComplete(); // true
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs/insert Jobs insert API Documentation.
     *
     * @param JobConfigurationInterface $config The job configuration.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $maxRetries The number of times to retry, checking if the
     *           job has completed. **Defaults to** `100`.
     * }
     * @return Job
     */
    public function runJob(JobConfigurationInterface $config, array $options = [])
    {
        $maxRetries = $this->pluck('maxRetries', $options, false);
        $job = $this->startJob($config, $options);
        $job->waitUntilComplete(['maxRetries' => $maxRetries]);

        return $job;
    }

    /**
     * Starts a job in an asynchronous fashion. In this case, it will be
     * required to manually trigger a call to wait for job completion.
     *
     * Example:
     * ```
     * $job = $bigQuery->startJob($jobConfig);
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs/insert Jobs insert API Documentation.
     *
     * @param JobConfigurationInterface $config The job configuration.
     * @param array $options [optional] Configuration options.
     * @return Job
     */
    public function startJob(JobConfigurationInterface $config, array $options = [])
    {
        $response = null;
        $config = $config->toArray() + $options;

        if (isset($config['data'])) {
            $response = $this->connection->insertJobUpload($config)->upload();
        } else {
            $response = $this->connection->insertJob($config);
        }

        return new Job(
            $this->connection,
            $config['jobReference']['jobId'],
            $this->projectId,
            $this->mapper,
            $response
        );
    }

    /**
     * Create a Bytes object.
     *
     * Example:
     * ```
     * $bytes = $bigQuery->bytes('hello world');
     * ```
     *
     * @param string|resource|StreamInterface $value The bytes value.
     * @return Bytes
     */
    public function bytes($value)
    {
        return new Bytes($value);
    }

    /**
     * Create a Date object.
     *
     * Example:
     * ```
     * $date = $bigQuery->date(new \DateTime('1995-02-04'));
     * ```
     *
     * @param \DateTimeInterface $value The date value.
     * @return Date
     */
    public function date(\DateTimeInterface $value)
    {
        return new Date($value);
    }

    /**
     * Create an Int64 object. This can be used to work with 64 bit integers as
     * a string value while on a 32 bit platform.
     *
     * Example:
     * ```
     * $int64 = $bigQuery->int64('9223372036854775807');
     * ```
     *
     * @param string $value The 64 bit integer value in string format.
     * @return Int64
     */
    public function int64($value)
    {
        return new Int64($value);
    }

    /**
     * Create a Time object.
     *
     * Example:
     * ```
     * $time = $bigQuery->time(new \DateTime('12:15:00.482172'));
     * ```
     *
     * @param \DateTimeInterface $value The time value.
     * @return Time
     */
    public function time(\DateTimeInterface $value)
    {
        return new Time($value);
    }

    /**
     * Create a Timestamp object.
     *
     * Example:
     * ```
     * $timestamp = $bigQuery->timestamp(new \DateTime('2003-02-05 11:15:02.421827Z'));
     * ```
     *
     * @param \DateTimeInterface $value The timestamp value.
     * @return Timestamp
     */
    public function timestamp(\DateTimeInterface $value)
    {
        return new Timestamp($value);
    }

    /**
     * Create a Numeric object.
     *
     * Numeric represents a value with a data type of
     * [Numeric](https://cloud.google.com/bigquery/docs/reference/standard-sql/data-types#numeric_type).
     *
     * It supports a fixed 38 decimal digits of precision and 9 decimal digits of scale, and values
     * are in the range of -99999999999999999999999999999.999999999 to
     * 99999999999999999999999999999.999999999.
     *
     * Example:
     * ```
     * $numeric = $bigQuery->numeric('99999999999999999999999999999999999999.999999999');
     * ```
     *
     * @param string|int|float $value The Numeric value.
     * @return Numeric
     * @throws \InvalidArgumentException
     */
    public function numeric($value)
    {
        return new Numeric($value);
    }

    /**
     * Create a BigNumeric object.
     *
     * Numeric represents a value with a data type of
     * [BIGNUMERIC](https://cloud.google.com/bigquery/docs/reference/standard-sql/data-types#numeric_type).
     *
     * It supports 76.76 (the 77th digit is partial) decimal digits of precision
     * and 38 decimal digits of scale. Values are in the range of
     * -5.7896044618658097711785492504343953926634992332820282019728792003956564819968E+38
     * to 5.7896044618658097711785492504343953926634992332820282019728792003956564819967E+38.
     *
     * Example:
     * ```
     * $bigNumeric = $bigQuery->bigNumeric('999999999999999999999999999999999999999999999.99999999999999');
     * ```
     *
     * @param string|int|float $value The Numeric value.
     * @return BigNumeric
     * @throws \InvalidArgumentException
     */
    public function bigNumeric($value)
    {
        return new BigNumeric($value);
    }

    /**
     * Create a Geography object.
     *
     * Example:
     * ```
     * $geography = $bigQuery->geography('POINT(10 20)');
     * ```
     *
     * @param string $value The geography data in WKT format.
     * @return Geography
     */
    public function geography($value)
    {
        return new Geography($value);
    }

    /**
     * Create a BigQuery Json object.
     *
     * Json represents a value with a data type of
     * [JSON](https://cloud.google.com/bigquery/docs/reference/standard-sql/data-types#json_type)
     *
     * Example:
     * ```
     * use Google\Cloud\BigQuery\BigQueryClient;
     *
     * $bigQuery = new BigQueryClient();
     * $json = $bigQuery->json('{"key":"value"}');
     * ```
     *
     * @param string|null $value The JSON string value.
     * @return Json
     * @throws InvalidArgumentException If the given $value is not string|null.
     */
    public function json($value)
    {
        return new Json($value);
    }

    /**
     * Get a service account for the KMS integration.
     *
     * Example:
     * ```
     * $serviceAccount = $bigQuery->getServiceAccount();
     * ```
     *
     * @param array $options [optional] Configuration options.
     *
     * @return string
     */
    public function getServiceAccount(array $options = [])
    {
        $resp = $this->connection->getServiceAccount($options + ['projectId' => $this->projectId]);
        return $resp['email'];
    }

    /**
     * Returns a BigQuery copy job configuration.
     *
     * The copy job configuration is passed to either
     * {@see BigQueryClient::runJob()} or
     * {@see BigQueryClient::startJob()}. A
     * configuration can be built using fluent setters or by providing a full
     * set of options at once.
     *
     * Example:
     * ```
     * $copyJobConfig = $bigQuery->copy()
     *     ->sourceTable($otherTable)
     *     ->destinationTable($myTable);
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs/insert Jobs insert API Documentation.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $configuration Job configuration. Please see the
     *           [API documentation](https://cloud.google.com/bigquery/docs/reference/rest/v2/Job#jobconfiguration)
     *           for the available options.
     *     @type array $configuration.copy Copy job configuration. Please see the
     *           [documentation](https://cloud.google.com/bigquery/docs/reference/rest/v2/Job#jobconfigurationtablecopy)
     *           for the available options.
     * }
     * @return CopyJobConfiguration
     */
    public function copy(array $options = [])
    {
        return new CopyJobConfiguration(
            $this->projectId,
            $options,
            $this->location
        );
    }

    /**
     * Returns a BigQuery extract job configuration.
     *
     * The extract job configuration is passed to either
     * {@see BigQueryClient::runJob()} or
     * {@see BigQueryClient::startJob()}. A
     * configuration can be built using fluent setters or by providing a full
     * set of options at once.
     *
     * Example:
     * ```
     * $extractJobConfig = $bigQuery->extract()
     *     ->sourceTable($table)
     *     ->destinationUris(['gs://my-bucket/table.csv']);
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs/insert Jobs insert API Documentation.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $configuration Job configuration. Please see the
     *           [API documentation](https://cloud.google.com/bigquery/docs/reference/rest/v2/Job#jobconfiguration)
     *           for the available options.
     *     @type array $configuration.extract Extract job configuration. Please see the
     *           [documentation](https://cloud.google.com/bigquery/docs/reference/rest/v2/Job#jobconfigurationextract)
     *           for the available options.
     * }
     * @return ExtractJobConfiguration
     */
    public function extract(array $options = [])
    {
        return new ExtractJobConfiguration(
            $this->projectId,
            $options,
            $this->location
        );
    }

    /**
     * Returns a BigQuery load job configuration.
     *
     * The load job configuration is passed to either
     * {@see BigQueryClient::runJob()} or
     * {@see BigQueryClient::startJob()}. A
     * configuration can be built using fluent setters or by providing a full
     * set of options at once.
     *
     * Example:
     * ```
     * $loadJobConfig = $bigQuery->load()
     *     ->destinationTable($table)
     *     ->sourceUris(['gs://my-bucket/table.csv']);
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs/insert Jobs insert API Documentation.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $configuration Job configuration. Please see the
     *           [API documentation](https://cloud.google.com/bigquery/docs/reference/rest/v2/Job#jobconfiguration)
     *           for the available options.
     *     @type array $configuration.load Load job configuration. Please see the
     *           [documentation](https://cloud.google.com/bigquery/docs/reference/rest/v2/Job#jobconfigurationload)
     *           for the available options.
     * }
     * @return LoadJobConfiguration
     */
    public function load(array $options = [])
    {
        return new LoadJobConfiguration(
            $this->projectId,
            $options,
            $this->location
        );
    }
}
