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
use Google\Cloud\Core\ConcurrencyControlTrait;
use Google\Cloud\Core\Exception\ConflictException;
use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Core\RetryDeciderTrait;
use Google\Cloud\Storage\StorageObject;
use Psr\Http\Message\StreamInterface;

/**
 * [Tables](https://cloud.google.com/bigquery/docs/tables) are a standard
 * two-dimensional table with individual records organized in rows, and a data
 * type assigned to each column (also called a field).
 */
class Table
{
    const MAX_RETRIES = 100;
    const INSERT_CREATE_MAX_DELAY_MICROSECONDS = 60000000;

    use ArrayTrait;
    use ConcurrencyControlTrait;
    use RetryDeciderTrait;

    /**
     * @var ConnectionInterface Represents a connection to BigQuery.
     */
    protected $connection;

    /**
     * @var array The table's identity.
     */
    private $identity;

    /**
     * @var array The table's metadata
     */
    private $info;

    /**
     * @var string|null A default geographic location.
     */
    private $location;

    /**
     * @var ValueMapper Maps values between PHP and BigQuery.
     */
    private $mapper;

    /**
     * @param ConnectionInterface $connection Represents a connection to
     *        BigQuery.
     * @param string $id The table's id.
     * @param string $datasetId The dataset's id.
     * @param string $projectId The project's id.
     * @param ValueMapper $mapper Maps values between PHP and BigQuery.
     * @param array $info [optional] The table's metadata.
     * @param string|null $location [optional] A default geographic location,
     *        used when no table metadata exists.
     */
    public function __construct(
        ConnectionInterface $connection,
        $id,
        $datasetId,
        $projectId,
        ValueMapper $mapper,
        array $info = [],
        $location = null
    ) {
        $this->connection = $connection;
        $this->info = $info;
        $this->mapper = $mapper;
        $this->identity = [
            'tableId' => $id,
            'datasetId' => $datasetId,
            'projectId' => $projectId
        ];
        $this->location = $location;
        $this->setHttpRetryCodes([502]);
        $this->setHttpRetryMessages([
            'rateLimitExceeded',
            'backendError'
        ]);
    }

    /**
     * Check whether or not the table exists.
     *
     * Example:
     * ```
     * if ($table->exists()) {
     *     echo 'Table exists!';
     * }
     * ```
     *
     * @return bool
     */
    public function exists()
    {
        try {
            $this->connection->getTable($this->identity + ['fields' => 'tableReference']);
        } catch (NotFoundException $ex) {
            return false;
        }

        return true;
    }

    /**
     * Delete the table.
     *
     * Please note that by default the library will not attempt to retry this
     * call on your behalf.
     *
     * Example:
     * ```
     * $table->delete();
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/tables/delete Tables delete API documentation.
     *
     * @param array $options [optional] Configuration options.
     */
    public function delete(array $options = [])
    {
        $this->connection->deleteTable(
            $options
            + ['retries' => 0]
            + $this->identity
        );
    }

    /**
     * Update the table.
     *
     * Providing an `etag` key as part of `$metadata` will enable simultaneous
     * update protection. This is useful in preventing override of modifications
     * made by another user. The resource's current etag can be obtained via a
     * GET request on the resource.
     *
     * Please note that by default the library will not automatically retry this
     * call on your behalf unless an `etag` is set.
     *
     * Example:
     * ```
     * $table->update([
     *     'friendlyName' => 'A friendly name.'
     * ]);
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/tables/patch Tables patch API documentation.
     * @see https://cloud.google.com/bigquery/docs/api-performance#patch Patch (Partial Update)
     *
     * @param array $metadata The available options for metadata are outlined
     *        at the [Table Resource API docs](https://cloud.google.com/bigquery/docs/reference/rest/v2/tables)
     * @param array $options [optional] Configuration options.
     */
    public function update(array $metadata, array $options = [])
    {
        $options = $this->applyEtagHeader(
            $options
            + $metadata
            + $this->identity
        );

        if (!isset($options['etag']) && !isset($options['retries'])) {
            $options['retries'] = 0;
        }

        return $this->info = $this->connection->patchTable($options);
    }

    /**
     * Retrieves the rows associated with the table and merges them together
     * with the schema.
     *
     * Example:
     * ```
     * $rows = $table->rows();
     *
     * foreach ($rows as $row) {
     *     echo $row['name'] . PHP_EOL;
     * }
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/tabledata/list Tabledata list API Documentation.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $maxResults Maximum number of results to return per page.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     *     @type int $startIndex Zero-based index of the starting row.
     * }
     * @return ItemIterator<array>
     * @throws GoogleException
     */
    public function rows(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);
        $schema = $this->info()['schema']['fields'];

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
                [$this->connection, 'listTableData'],
                $options + $this->identity,
                [
                    'nextResultTokenKey' => 'pageToken',
                    'itemsKey' => 'rows',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Starts a job in an synchronous fashion, waiting for the job to complete
     * before returning.
     *
     * Example:
     * ```
     * $job = $table->runJob($jobConfig);
     * echo $job->isComplete(); // true
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs/insert Jobs insert API Documentation.
     *
     * @deprecated Use {@see Google\Cloud\BigQuery\BigQueryClient::runJob()}.
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
     * $job = $table->startJob($jobConfig);
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs/insert Jobs insert API Documentation.
     *
     * @deprecated Use {@see Google\Cloud\BigQuery\BigQueryClient::startJob()}.
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
            $this->identity['projectId'],
            $this->mapper,
            $response
        );
    }

    /**
     * Returns a copy job configuration to be passed to either
     * {@see Google\Cloud\BigQuery\BigQueryClient::runJob()} or
     * {@see Google\Cloud\BigQuery\BigQueryClient::startJob()}. A
     * configuration can be built using fluent setters or by providing a full
     * set of options at once.
     *
     * Example:
     * ```
     * $sourceTable = $bigQuery->dataset('myDataset')
     *     ->table('mySourceTable');
     * $destinationTable = $bigQuery->dataset('myDataset')
     *     ->table('myDestinationTable');
     *
     * $copyJobConfig = $sourceTable->copy($destinationTable);
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs/insert Jobs insert API Documentation.
     *
     * @param Table $destination The destination table.
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
    public function copy(Table $destination, array $options = [])
    {
        return (new CopyJobConfiguration(
            $this->identity['projectId'],
            $options,
            isset($this->info['location'])
                ? $this->info['location']
                : $this->location
        ))
            ->destinationTable($destination)
            ->sourceTable($this);
    }

    /**
     * Returns an extract job configuration to be passed to either
     * {@see Google\Cloud\BigQuery\BigQueryClient::runJob()} or
     * {@see Google\Cloud\BigQuery\BigQueryClient::startJob()}. A
     * configuration can be built using fluent setters or by providing a full
     * set of options at once.
     *
     * Example:
     * ```
     * $destinationObject = $storage->bucket('myBucket')->object('tableOutput');
     * $extractJobConfig = $table->extract($destinationObject);
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs/insert Jobs insert API Documentation.
     *
     * @param string|StorageObject $destination The destination object. May be
     *        a {@see Google\Cloud\Storage\StorageObject} or a URI pointing to
     *        a Google Cloud Storage object in the format of
     *        `gs://{bucket-name}/{object-name}`.
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
    public function extract($destination, array $options = [])
    {
        if ($destination instanceof StorageObject) {
            $destination = $destination->gcsUri();
        }

        return (new ExtractJobConfiguration(
            $this->identity['projectId'],
            $options,
            isset($this->info['location'])
                ? $this->info['location']
                : $this->location
        ))
            ->destinationUris([$destination])
            ->sourceTable($this);
    }

    /**
     * Returns a load job configuration to be passed to either
     * {@see Google\Cloud\BigQuery\BigQueryClient::runJob()} or
     * {@see Google\Cloud\BigQuery\BigQueryClient::startJob()}. A
     * configuration can be built using fluent setters or by providing a full
     * set of options at once.
     *
     * Example:
     * ```
     * $loadJobConfig = $table->load(fopen('/path/to/my/data.csv', 'r'));
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs/insert Jobs insert API Documentation.
     *
     * @param string|resource|StreamInterface $data The data to load.
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
    public function load($data, array $options = [])
    {
        $config = (new LoadJobConfiguration(
            $this->identity['projectId'],
            $options,
            isset($this->info['location'])
                ? $this->info['location']
                : $this->location
        ))
            ->destinationTable($this);

        if ($data) {
            $config->data($data);
        }

        return $config;
    }

    /**
     * Returns a load job configuration to be passed to either
     * {@see Google\Cloud\BigQuery\BigQueryClient::runJob()} or
     * {@see Google\Cloud\BigQuery\BigQueryClient::startJob()}. A
     * configuration can be built using fluent setters or by providing a full
     * set of options at once.
     *
     * Example:
     * ```
     * $object = $storage->bucket('myBucket')->object('important-data.csv');
     * $loadJobConfig = $table->loadFromStorage($object);
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs/insert Jobs insert API Documentation.
     *
     * @param string|StorageObject $object The object to load data from. May be
     *        a {@see Google\Cloud\Storage\StorageObject} or a URI pointing to a
     *        Google Cloud Storage object in the format of
     *        `gs://{bucket-name}/{object-name}`.
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
    public function loadFromStorage($object, array $options = [])
    {
        if ($object instanceof StorageObject) {
            $object = $object->gcsUri();
        }

        $options['configuration']['load']['sourceUris'] = [$object];

        return $this->load(null, $options);
    }

    /**
     * Insert a record into the table without running a load job.
     *
     * Please note that by default the library will not automatically retry this
     * call on your behalf unless an `insertId` is set.
     *
     * Example:
     * ```
     * $row = [
     *     'city' => 'Detroit',
     *     'state' => 'MI'
     * ];
     *
     * $insertResponse = $table->insertRow($row, [
     *     'insertId' => '1'
     * ]);
     *
     * if (!$insertResponse->isSuccessful()) {
     *     $row = $insertResponse->failedRows()[0];
     *
     *     print_r($row['rowData']);
     *
     *     foreach ($row['errors'] as $error) {
     *         echo $error['reason'] . ': ' . $error['message'] . PHP_EOL;
     *     }
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/tabledata/insertAll Tabledata insertAll API Documentation.
     * @see https://cloud.google.com/bigquery/streaming-data-into-bigquery Streaming data into BigQuery.
     *
     * @param array $row Key/value set of data matching the table's schema.
     * @param array $options [optional] {
     *     Please see
     *     {@see Google\Cloud\BigQuery\Table::insertRows()} for the
     *     other available configuration options.
     *
     *     @type string $insertId Used to
     *           [ensure data consistency](https://cloud.google.com/bigquery/streaming-data-into-bigquery#dataconsistency).
     * }
     * @return InsertResponse
     * @throws \InvalidArgumentException
     * @codingStandardsIgnoreEnd
     */
    public function insertRow(array $row, array $options = [])
    {
        $row = ['data' => $row];

        if (isset($options['insertId'])) {
            $row['insertId'] = $options['insertId'];
            unset($options['insertId']);
        }

        return $this->insertRows([$row], $options);
    }

    /**
     * Insert records into the table without running a load job.
     *
     * Please note that by default the library will not automatically retry this
     * call on your behalf unless an `insertId` is set.
     *
     * Example:
     * ```
     * $rows = [
     *     [
     *         'insertId' => '1',
     *         'data' => [
     *             'city' => 'Detroit',
     *             'state' => 'MI'
     *         ]
     *     ],
     *     [
     *         'insertId' => '2',
     *         'data' => [
     *             'city' => 'New York',
     *             'state' => 'NY'
     *         ]
     *     ]
     * ];
     *
     * $insertResponse = $table->insertRows($rows);
     *
     * if (!$insertResponse->isSuccessful()) {
     *     foreach ($insertResponse->failedRows() as $row) {
     *         print_r($row['rowData']);
     *
     *         foreach ($row['errors'] as $error) {
     *             echo $error['reason'] . ': ' . $error['message'] . PHP_EOL;
     *         }
     *     }
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/tabledata/insertAll Tabledata insertAll API Documentation.
     * @see https://cloud.google.com/bigquery/streaming-data-into-bigquery Streaming data into BigQuery.
     *
     * @param array $rows The rows to insert. Each item in the array must
     *        contain a `data` key which is to hold a key/value array with data
     *        matching the schema of the table. Optionally, one may also provide
     *        an `insertId` key which will be used to
     *        [ensure data consistency](https://cloud.google.com/bigquery/streaming-data-into-bigquery#dataconsistency).
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type bool $autoCreate Whether or not to attempt to automatically
     *           create the table in the case it does not exist. Please note, it
     *           will be required to provide a schema through
     *           $tableMetadata['schema'] in the case the table does not already
     *           exist. **Defaults to** `false`.
     *     @type array $tableMetadata Metadata to apply to table to be created. The
     *           full set of metadata are outlined at the
     *           [Table Resource API docs](https://cloud.google.com/bigquery/docs/reference/rest/v2/tables).
     *           Only applies when `autoCreate` is `true`.
     *     @type int $maxRetries The maximum number of times to attempt creating the
     *           table in the case of failure. Please note, each retry attempt
     *           may take up to two minutes. Only applies when `autoCreate` is
     *           `true`. **Defaults to** `100`.
     *     @type bool $skipInvalidRows Insert all valid rows of a request, even
     *           if invalid rows exist. The default value is `false`, which
     *           causes the entire request to fail if any invalid rows exist.
     *           **Defaults to** `false`.
     *     @type bool $ignoreUnknownValues Accept rows that contain values that
     *           do not match the schema. The unknown values are ignored.
     *           The default value is `false`, which treats unknown values as errors.
     *           **Defaults to** `false`.
     *     @type string $templateSuffix If specified, treats the destination
     *           table as a base template, and inserts the rows into an instance
     *           table named "{destination}{templateSuffix}". BigQuery will
     *           manage creation of the instance table, using the schema of the
     *           base template table. See
     *           [Creating tables automatically using template tables](https://cloud.google.com/bigquery/streaming-data-into-bigquery#template-tables)
     *           for considerations when working with templates tables.
     * }
     * @return InsertResponse
     * @throws \InvalidArgumentException If a provided row does not contain a
     *         `data` key, if a schema is not defined when `autoCreate` is
     *         `true`, or if less than 1 row is provided.
     * @codingStandardsIgnoreEnd
     */
    public function insertRows(array $rows, array $options = [])
    {
        if (count($rows) === 0) {
            throw new \InvalidArgumentException('Must provide at least a single row.');
        }

        foreach ($rows as $row) {
            if (!isset($row['data'])) {
                throw new \InvalidArgumentException('A row must have a data key.');
            }

            if (!isset($options['retries']) && !isset($row['insertId'])) {
                $options['retries'] = 0;
            }

            foreach ($row['data'] as $key => $item) {
                $row['data'][$key] = $this->mapper->toBigQuery($item);
            }

            $row['json'] = $row['data'];
            unset($row['data']);
            $options['rows'][] = $row;
        }

        return new InsertResponse(
            $this->handleInsert($options),
            $options['rows']
        );
    }

    /**
     * Retrieves the table's details. If no table data is cached a network
     * request will be made to retrieve it.
     *
     * Example:
     * ```
     * $info = $table->info();
     * echo $info['selfLink'];
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/tables Tables resource documentation.
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
     * Triggers a network request to reload the table's details.
     *
     * Example:
     * ```
     * $table->reload();
     * $info = $table->info();
     * echo $info['selfLink'];
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/tables/get Tables get API documentation.
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function reload(array $options = [])
    {
        return $this->info = $this->connection->getTable($options + $this->identity);
    }

    /**
     * Retrieves the table's ID.
     *
     * Example:
     * ```
     * echo $table->id();
     * ```
     *
     * @return string
     */
    public function id()
    {
        return $this->identity['tableId'];
    }

    /**
     * Retrieves the table's identity.
     *
     * An identity provides a description of a nested resource.
     *
     * Example:
     * ```
     * echo $table->identity()['projectId'];
     * ```
     *
     * @return array
     */
    public function identity()
    {
        return $this->identity;
    }

    /**
     * Delay execution in microseconds.
     *
     * @param int $microSeconds
     */
    protected function usleep($microSeconds)
    {
        usleep($microSeconds);
    }

    /**
     * Handles inserting table data and manages custom retry logic in the case
     * a table needs to be created.
     *
     * @param array $options Configuration options.
     * @return array
     */
    private function handleInsert(array $options)
    {
        $attempt = 0;
        $metadata = $this->pluck('tableMetadata', $options, false) ?: [];
        $autoCreate = $this->pluck('autoCreate', $options, false) ?: false;
        $maxRetries = $this->pluck('maxRetries', $options, false) ?: self::MAX_RETRIES;

        while (true) {
            try {
                return $this->connection->insertAllTableData(
                    $this->identity + $options
                );
            } catch (NotFoundException $ex) {
                if ($autoCreate === true && $attempt <= $maxRetries) {
                    if (!isset($metadata['schema'])) {
                        throw new \InvalidArgumentException(
                            'A schema is required when creating a table.'
                        );
                    }

                    $this->usleep(mt_rand(1, self::INSERT_CREATE_MAX_DELAY_MICROSECONDS));

                    try {
                        $this->connection->insertTable($metadata + [
                            'projectId' => $this->identity['projectId'],
                            'datasetId' => $this->identity['datasetId'],
                            'tableReference' => $this->identity,
                            'retries' => 0
                        ]);
                    } catch (ConflictException $ex) {
                    } catch (\Exception $ex) {
                        $retryFunction = $this->getRetryFunction();

                        if (!$retryFunction($ex)) {
                            throw $ex;
                        }
                    }

                    $this->usleep(self::INSERT_CREATE_MAX_DELAY_MICROSECONDS);
                    $attempt++;
                } else {
                    throw $ex;
                }
            }
        }
    }
}
