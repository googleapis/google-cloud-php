<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

/**
 * Represents a configuration for an extract job. For more information on the
 * available settings please see the
 * [Jobs configuration API documentation](https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs#configuration).
 *
 * Example:
 * ```
 * use Google\Cloud\BigQuery\BigQueryClient;
 *
 * $bigQuery = new BigQueryClient();
 * $table = $bigQuery->dataset('my_dataset')
 *     ->table('my_table');
 * $extractJobConfig = $table->extract('gs://my_bucket/target.csv');
 * ```
 */
class ExtractJobConfiguration implements JobConfigurationInterface
{
    use JobConfigurationTrait;

    /**
     * @param string $projectId The project's ID.
     * @param array $config A set of configuration options for a job.
     * @param string|null $location The geographic location in which the job is
     *        executed.
     */
    public function __construct($projectId, array $config, $location)
    {
        $this->jobConfigurationProperties($projectId, $config, $location);
    }

    /**
     * Sets the compression type to use for exported files.
     *
     * Example:
     * ```
     * $extractJobConfig->compression('GZIP');
     * ```
     *
     * @param string $compression The compression type. Acceptable values
     *        include `"GZIP"`, `"NONE"`. **Defaults to** `"NONE"`.
     * @return ExtractJobConfiguration
     */
    public function compression($compression)
    {
        $this->config['configuration']['extract']['compression'] = $compression;

        return $this;
    }

    /**
     * Sets the exported file format. Tables with nested or repeated fields
     * cannot be exported as CSV.
     *
     * Example:
     * ```
     * $extractJobConfig->destinationFormat('NEWLINE_DELIMITED_JSON');
     * ```
     *
     * @param string $destinationFormat The exported file format. Acceptable
     *        values include `"CSV"`, `"NEWLINE_DELIMITED_JSON"`, `"AVRO"`.
     *        **Defaults to** `"CSV"`.
     * @return ExtractJobConfiguration
     */
    public function destinationFormat($destinationFormat)
    {
        $this->config['configuration']['extract']['destinationFormat'] = $destinationFormat;

        return $this;
    }

    /**
     * Sets a list of fully-qualified Google Cloud Storage URIs where the
     * extracted table should be written.
     *
     * Example:
     * ```
     * $extractJobConfig->destinationUris([
     *     'gs://my_bucket/destination.csv'
     * ]);
     * ```
     *
     * @param array $destinationUris The destination URIs.
     * @return ExtractJobConfiguration
     */
    public function destinationUris(array $destinationUris)
    {
        $this->config['configuration']['extract']['destinationUris'] = $destinationUris;

        return $this;
    }

    /**
     * Sets the delimiter to use between fields in the exported data.
     *
     * Example:
     * ```
     * $extractJobConfig->fieldDelimiter(',');
     * ```
     *
     * @param string $fieldDelimiter The field delimiter. **Defaults to** `","`.
     * @return ExtractJobConfiguration
     */
    public function fieldDelimiter($fieldDelimiter)
    {
        $this->config['configuration']['extract']['fieldDelimiter'] = $fieldDelimiter;

        return $this;
    }

    /**
     * Sets whether or not to print out a header row in the results.
     *
     * Example:
     * ```
     * $extractJobConfig->printHeader(false);
     * ```
     *
     * @param bool $printHeader Whether or not to print out a header row.
     *        **Defaults to** `true`.
     * @return ExtractJobConfiguration
     */
    public function printHeader($printHeader)
    {
        $this->config['configuration']['extract']['printHeader'] = $printHeader;

        return $this;
    }

    /**
     * Sets a reference to the table being exported.
     *
     * Example:
     * ```
     * $table = $bigQuery->dataset('my_dataset')
     *     ->table('my_table');
     * $extractJobConfig->sourceTable($table);
     * ```
     *
     * @param Table $sourceTable
     * @return ExtractJobConfiguration
     */
    public function sourceTable(Table $sourceTable)
    {
        $this->config['configuration']['extract']['sourceTable'] = $sourceTable->identity();

        return $this;
    }

    /**
     * Sets whether to use logical types when extracting to AVRO format.
     *
     * If destinationFormat is set to "AVRO", this flag indicates whether to
     * enable extracting applicable column types (such as TIMESTAMP) to their
     * corresponding AVRO logical types (timestamp-micros), instead of only
     * using their raw types (avro-long).
     *
     * Example:
     * ```
     * $extractJobConfig->useAvroLogicalTypes(true);
     * ```
     *
     * @param bool $useAvroLogicalTypes
     * @return ExtractJobConfiguration
     */
    public function useAvroLogicalTypes($useAvroLogicalTypes)
    {
        $this->config['configuration']['extract']['useAvroLogicalTypes'] = $useAvroLogicalTypes;
    }
}
