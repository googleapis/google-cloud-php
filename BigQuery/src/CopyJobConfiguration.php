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
 * Represents a configuration for a copy job. For more information on the
 * available settings please see the
 * [Jobs configuration API documentation](https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs#configuration).
 *
 * Example:
 * ```
 * use Google\Cloud\BigQuery\BigQueryClient;
 *
 * $bigQuery = new BigQueryClient();
 * $sourceTable = $bigQuery->dataset('my_dataset')
 *     ->table('my_source_table');
 * $destinationTable = $bigQuery->dataset('my_dataset')
 *     ->table('my_destination_table');
 *
 * $copyJobConfig = $sourceTable->copy($destinationTable);
 * ```
 */
class CopyJobConfiguration implements JobConfigurationInterface
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
     * Set whether the job is allowed to create new tables. Creation, truncation
     * and append actions occur as one atomic update upon job completion.
     *
     * Example:
     * ```
     * $copyJobConfig->createDisposition('CREATE_NEVER');
     * ```
     *
     * @param string $createDisposition The create disposition. Acceptable
     *        values include `"CREATED_IF_NEEDED"`, `"CREATE_NEVER"`. **Defaults
     *        to** `"CREATE_IF_NEEDED"`.
     * @return CopyJobConfiguration
     */
    public function createDisposition($createDisposition)
    {
        $this->config['configuration']['copy']['createDisposition'] = $createDisposition;

        return $this;
    }

    /**
     * Sets the custom encryption configuration (e.g., Cloud KMS keys).
     *
     * Example:
     * ```
     * $copyJobConfig->destinationEncryptionConfiguration([
     *     'kmsKeyName' => 'my_key'
     * ]);
     * ```
     *
     * @param array $configuration Custom encryption configuration.
     * @return CopyJobConfiguration
     */
    public function destinationEncryptionConfiguration(array $configuration)
    {
        $this->config['configuration']['copy']['destinationEncryptionConfiguration'] = $configuration;

        return $this;
    }

    /**
     * Sets the destination table.
     *
     * Example:
     * ```
     * $table = $bigQuery->dataset('my_dataset')
     *     ->table('my_table');
     * $copyJobConfig->destinationTable($table);
     * ```
     *
     * @param Table $destinationTable The destination table.
     * @return CopyJobConfiguration
     */
    public function destinationTable(Table $destinationTable)
    {
        $this->config['configuration']['copy']['destinationTable'] = $destinationTable->identity();

        return $this;
    }

    /**
     * Sets the source table to copy.
     *
     * Example:
     * ```
     * $table = $bigQuery->dataset('my_dataset')
     *     ->table('source_table');
     * $copyJobConfig->sourceTable($table);
     * ```
     *
     * @param Table $sourceTable The destination table.
     * @return CopyJobConfiguration
     */
    public function sourceTable(Table $sourceTable)
    {
        $this->config['configuration']['copy']['sourceTable'] = $sourceTable->identity();

        return $this;
    }

    /**
     * Sets the action that occurs if the destination table already exists. Each
     * action is atomic and only occurs if BigQuery is able to complete the job
     * successfully. Creation, truncation and append actions occur as one atomic
     * update upon job completion.
     *
     * Example:
     * ```
     * $copyJobConfig->writeDisposition('WRITE_TRUNCATE');
     * ```
     *
     * @param string $writeDisposition The write disposition. Acceptable values
     *        include `"WRITE_TRUNCATE"`, `"WRITE_APPEND"`, `"WRITE_EMPTY"`.
     *        **Defaults to** `"WRITE_EMPTY"`.
     * @return CopyJobConfiguration
     */
    public function writeDisposition($writeDisposition)
    {
        $this->config['configuration']['copy']['writeDisposition'] = $writeDisposition;

        return $this;
    }
}
