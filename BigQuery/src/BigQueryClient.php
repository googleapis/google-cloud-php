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
use Google\Cloud\BigQuery\Job;
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

    const VERSION = '1.6.0';

    const MAX_DELAY_MICROSECONDS = 32000000;

    const SCOPE = 'https://www.googleapis.com/auth/bigquery';
    const INSERT_SCOPE = 'https://www.googleapis.com/auth/bigquery.insertdata';

    /**
     * @var ConnectionInterface Represents a connection to BigQuery.
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
     *     @type bool $returnInt64AsObject If true, 64 bit integers will be
     *           returned as a {@see Google\Cloud\Core\Int64} object for 32 bit
     *           platform compatibility. **Defaults to** false.
     *     @type string $location If provided, determines the default geographic
     *           location used when creating datasets and managing jobs. Please
     *           note: This is only required for jobs started outside of the US
     *           and EU regions. Also, if location metadata has already been
     *           fetched over the network it will take precedent over this
     *           setting (by calling
     *           {@see Google\Cloud\BigQuery\Table::reload()}, for example).
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
            'restCalcDelayFunction' => function ($attempt) {
                return min(
                    mt_rand(0, 1000000) + (pow(2, $attempt) * 1000000),
                    self::MAX_DELAY_MICROSECONDS
                );
            }
        ];

        $this->connection = new Rest($this->configureAuthentication($config));
        $this->mapper = new ValueMapper($config['returnInt64AsObject']);
    }

    /**
     * Returns a job configuration to be passed to either
     * {@see Google\Cloud\BigQuery\BigQueryClient::runQuery()} or
     * {@see Google\Cloud\BigQuery\BigQueryClient::startQuery()}. A
     * configuration can be built using fluent setters or by providing a full
     * set of options at once.
     *
     * Unless otherwise specified, all configuration options will default based
     * on the [Jobs configuration API documentation](https://goo.gl/vSTbGp)
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
     * @param array $options [optional] Please see the
     *        [API documentation for Job configuration](https://goo.gl/vSTbGp)
     *        for the available options.
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
     * Returns a job configuration to be passed to either
     * {@see Google\Cloud\BigQuery\BigQueryClient::runQuery()} or
     * {@see Google\Cloud\BigQuery\BigQueryClient::startQuery()}. A
     * configuration can be built using fluent setters or by providing a full
     * set of options at once.
     *
     * Unless otherwise specified, all configuration options will default based
     * on the [Jobs configuration API documentation](https://goo.gl/vSTbGp)
     * except for `configuration.query.useLegacySql`, which defaults to `false`
     * in this client.
     *
     * As this method is an alias, please see
     * {@see Google\Cloud\BigQuery\BigQueryClient::query()} for usage examples.
     *
     * @param string $query A BigQuery SQL query.
     * @param array $options [optional] Please see the
     *        [API documentation for Job configuration](https://goo.gl/vSTbGp)
     *        for the available options.
     * @return QueryJobConfiguration
     */
    public function queryConfig($query, array $options = [])
    {
        return $this->query($query, $options);
    }

    /**
     * Runs a BigQuery SQL query in a synchronous fashion.
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
     * | {@see Google\Cloud\BigQuery\Bytes}         | `BYTES`                              |
     * | {@see Google\Cloud\BigQuery\Date}          | `DATE`                               |
     * | {@see Google\Cloud\Core\Int64}             | `INT64`                              |
     * | {@see Google\Cloud\BigQuery\Time}          | `TIME`                               |
     * | {@see Google\Cloud\BigQuery\Timestamp}     | `TIMESTAMP`                          |
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
     * @see https://cloud.google.com/bigquery/docs/reference/v2/jobs/query Query API documentation.
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
            'maxRetries'
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
     * please see {@see Google\Cloud\BigQuery\BigQueryClient::runQuery()}.
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
        $config = $query->toArray();
        $response = $this->connection->insertJob($config + $options);

        return new Job(
            $this->connection,
            $config['jobReference']['jobId'],
            $this->projectId,
            $this->mapper,
            $response
        );
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
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/jobs/list Jobs list API documentation.
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
        return new Dataset(
            $this->connection,
            $id,
            $this->projectId,
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
     * @see https://cloud.google.com/bigquery/docs/reference/v2/datasets/list Datasets list API documentation.
     *
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
     * }
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
     * @see https://cloud.google.com/bigquery/docs/reference/v2/datasets/insert Datasets insert API documentation.
     *
     * @param string $id The id of the dataset to create.
     * @param array $options [optional] {
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
     * [Numeric](https://cloud.google.com/bigquery/docs/reference/standard-sql/data-types#numeric-type).
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
}
