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
use Google\Cloud\Exception\NotFoundException;
use Google\Cloud\Storage\Object;

/**
 * [BigQuery Tables](https://cloud.google.com/bigquery/docs/tables) are a
 * standard two-dimensional table with individual records organized in rows, and
 * a data type assigned to each column (also called a field).
 */
class Table
{
    use JobConfigurationTrait;

    /**
     * @var ConnectionInterface $connection Represents a connection to BigQuery.
     */
    private $connection;

    /**
     * @var array The table's metadata
     */
    private $data;

    /**
     * @var array The table's identity.
     */
    private $identity;

    /**
     * @param ConnectionInterface $connection Represents a connection to
     *        BigQuery.
     * @param string $id The table's id.
     * @param string $datasetId The dataset's id.
     * @param string $projectId The project's id.
     * @param array $data The table's metadata.
     */
    public function __construct(ConnectionInterface $connection, $id, $datasetId, $projectId, array $data = [])
    {
        $this->connection = $connection;
        $this->data = $data;
        $this->identity = [
            'tableId' => $id,
            'datasetId' => $datasetId,
            'projectId' => $projectId
        ];
    }

    /**
     * Check whether or not the table exists.
     *
     * Example:
     * ```
     * $table->exists();
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
     * Retrieves the rows associated with the table and merges them together
     * with the schema.
     *
     * Example:
     * ```
     * foreach ($table->getRows() as $row) {
     *     echo $row['name'];
     * }
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/tabledata/list Tabledata list API Documentation.
     *
     * @param array $options {
     *     Configuration options.
     *
     *     @type int $maxResults Maximum number of results to return.
     *     @type int $startIndex Zero-based index of the starting row.
     * }
     * @return \Generator
     */
    public function getRows(array $options = [])
    {
        $options['pageToken'] = null;
        $schema = $this->getInfo()['schema']['fields'];

        do {
            $response = $this->connection->listTableData($options + $this->identity);

            if (!isset($response['rows'])) {
                return;
            }

            foreach ($response['rows'] as $rows) {
                $row = [];

                foreach ($rows['f'] as $key => $field) {
                    $row[$schema[$key]['name']] = $field['v'];
                }

                yield $row;
            }

            $options['pageToken'] = isset($response['nextPageToken']) ? $response['nextPageToken'] : null;
        } while ($options['pageToken']);
    }

    /**
     * Runs a copy job which copies this table to a specified destination table.
     *
     * Example:
     * ```
     * $sourceTable = $bigQuery->dataset('myDataset')->table('mySourceTable');
     * $destinationTable = $bigQuery->dataset('myDataset')->table('myDestinationTable');
     *
     * $sourceTable->copy($destinationTable);
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/jobs Jobs insert API Documentation.
     *
     * @param Table $destination The destination table.
     * @param array $options {
     *     Configuration options.
     *
     *     @type array $jobConfig Configuration settings for a copy job are
     *           outlined in the [API Docs for `configuration.copy`](https://goo.gl/m8dro9).
     *           If not provided default settings will be used.
     * }
     * @return Job
     */
    public function copy(Table $destination, array $options = [])
    {
        $config = $this->buildJobConfig(
            'copy',
            $this->identity['projectId'],
            [
                'destinationTable' => $destination->getIdentity(),
                'sourceTable' => $this->identity
            ],
            $options
        );

        $response = $this->connection->insertJob($config);

        return new Job($this->connection, $response['jobReference']['jobId'], $this->identity['projectId'], $response);
    }

    /**
     * Runs an extract job which exports the contents of a table to Cloud
     * Storage.
     *
     * Example:
     * ```
     * $destinationObject = $storage->bucket('myBucket')->object('tableOutput');
     * $table->export($destinationObject);
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/jobs Jobs insert API Documentation.
     *
     * @param Object $destination The destination object.
     * @param array $options {
     *     Configuration options.
     *
     *     @type array $jobConfig Configuration settings for an extract job are
     *           outlined in the [API Docs for `configuration.extract`](https://goo.gl/SQ9XAE).
     *           If not provided default settings will be used.
     * }
     * @return Job
     */
    public function export(Object $destination, array $options = [])
    {
        $objIdentity = $destination->getIdentity();
        $config = $this->buildJobConfig(
            'extract',
            $this->identity['projectId'],
            [
                'sourceTable' => $this->identity,
                'destinationUris' => ['gs://' . $objIdentity['bucket'] . '/' . $objIdentity['object']]
            ],
            $options
        );

        $response = $this->connection->insertJob($config);

        return new Job($this->connection, $response['jobReference']['jobId'], $this->identity['projectId'], $response);
    }

    /**
     * Runs a load job which loads the provided data into the table.
     *
     * Example:
     * ```
     * $table->load(fopen('/path/to/my/data.csv', 'r'));
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/jobs Jobs insert API Documentation.
     *
     * @param string|resource|StreamInterface $data The data to load.
     * @param array $options {
     *     Configuration options.
     *
     *     @type array $jobConfig Configuration settings for a load job are
     *           outlined in the [API Docs for `configuration.load`](https://goo.gl/j6jyHv).
     *           If not provided default settings will be used.
     * }
     * @return Job
     */
    public function load($data, array $options = [])
    {
        $response = null;
        $config = $this->buildJobConfig(
            'load',
            $this->identity['projectId'],
            ['destinationTable' => $this->identity],
            $options
        );

        if ($data) {
            $config['data'] = $data;
            $response = $this->connection->insertJobUpload($config)->upload();
        } else {
            $response = $this->connection->insertJob($config);
        }

        return new Job(
            $this->connection,
            $response['jobReference']['jobId'],
            $this->identity['projectId'],
            $response
        );
    }

    /**
     * Runs a load job which loads data from a file in a Storage bucket into the
     * table.
     *
     * Example:
     * ```
     * $object = $storage->bucket('myBucket')->object('important-data.csv');
     * $table->load($object);
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/jobs Jobs insert API Documentation.
     *
     * @param Object $destination The object to load data from.
     * @param array $options {
     *     Configuration options.
     *
     *     @type array $jobConfig Configuration settings for a load job are
     *           outlined in the [API Docs for `configuration.load`](https://goo.gl/j6jyHv).
     *           If not provided default settings will be used.
     * }
     * @return Job
     */
    public function loadFromStorage(Object $object, array $options = [])
    {
        $objIdentity = $object->getIdentity();
        $options['jobConfig']['sourceUris'] = ['gs://' . $objIdentity['bucket'] . '/' . $objIdentity['object']];

        return $this->load(null, $options);
    }

    /**
     * Retrieves the table's details. If no table data is cached a network
     * request will be made to retrieve it.
     *
     * Example:
     * ```
     * $info = $table->getInfo();
     * echo $info['friendlyName'];
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/tables#resource Tables resource documentation.
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
     * Triggers a network request to reload the table's details.
     *
     * Example:
     * ```
     * $table->reload();
     * $info = $table->getInfo();
     * echo $info['friendlyName'];
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/tables/get Tables get API documentation.
     *
     * @param array $options Configuration options.
     * @return array
     */
    public function reload(array $options = [])
    {
        return $this->data = $this->connection->getTable($options + $this->identity);
    }

    /**
     * Retrieves the table's ID.
     *
     * Example:
     * ```
     * echo $table->getId();
     * ```
     *
     * @return string
     */
    public function getId()
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
     * echo $table->getIdentity()['projectId'];
     * ```
     *
     * @return array
     */
    public function getIdentity()
    {
        return $this->identity;
    }
}
