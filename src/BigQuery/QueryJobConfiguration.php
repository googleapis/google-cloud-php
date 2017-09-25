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
 * Represents a configuration for a query job. For more information on the
 * available settings please see the
 * [Jobs configuration API documentation](https://cloud.google.com/bigquery/docs/reference/rest/v2/jobs#configuration).
 */
class QueryJobConfiguration
{
    use JobConfigurationTrait;

    const CREATE_DISPOSITION_CREATE_IF_NEEDED = 'CREATE_IF_NEEDED';
    const CREATE_DISPOSITION_CREATE_NEVER = 'CREATE_NEVER';
    const PRIORITY_INTERACTIVE = 'INTERACTIVE';
    const PRIORITY_BATCH = 'BATCH';
    const WRITE_DISPOSITION_WRITE_TRUNCATE = 'WRITE_TRUNCATE';
    const WRITE_DISPOSITION_WRITE_APPEND = 'WRITE_APPEND';
    const WRITE_DISPOSITION_WRITE_EMPTY = 'WRITE_EMPTY';

    /**
     * @var ValueMapper Maps values between PHP and BigQuery.
     */
    private $mapper;

    /**
     * @param ValueMapper $mapper Maps values between PHP and BigQuery.
     * @param string $projectId The project's ID.
     * @param array $config A set of configuration options for a job.
     */
    public function __construct(ValueMapper $mapper, $projectId, array $config)
    {
        $this->mapper = $mapper;
        $this->jobConfigurationProperties($projectId, $config);

        if (!isset($this->config['configuration']['query']['useLegacySql'])) {
            $this->config['configuration']['query']['useLegacySql'] = false;
        }
    }

    /**
     * Sets whether or not the query should allow large result sets.
     *
     * @param bool $allowLargeResults Whether or not to allow large result sets.
     * @return QueryJobConfiguration
     */
    public function allowLargeResults($allowLargeResults)
    {
        $this->config['configuration']['query']['allowLargeResults'] = $allowLargeResults;

        return $this;
    }

    /**
     * Sets the create disposition.
     *
     * @param string $createDisposition Determine Whether the job is allowed to
     *        create new tables. Acceptable values include `"CREATE_IF_NEEDED"`,
     *        `"CREATE_NEVER"`. Please note constants for these values exist
     *        on this class.
     * @return QueryJobConfiguration
     */
    public function createDisposition($createDisposition)
    {
        $this->config['configuration']['query']['createDisposition'] = $createDisposition;

        return $this;
    }

    /**
     * Sets the default dataset.
     *
     * @param array $defaultDataset The default dataset to use for unqualified
     *        table names in the query.
     * @return QueryJobConfiguration
     */
    public function defaultDataset(array $defaultDataset)
    {
        $this->config['configuration']['query']['defaultDataset'] = $defaultDataset;

        return $this;
    }

    /**
     * Sets the encryption configuration.
     *
     * @codeCoverageIgnoreEnd
     *
     * @param array $configuration Custom encryption configuration (e.g.,
     *        Cloud KMS keys).
     * @return QueryJobConfiguration
     */
    public function destinationEncryptionConfiguration(array $configuration)
    {
        $this->config['configuration']['query']['destinationEncryptionConfiguration'] = $configuration;

        return $this;
    }

    /**
     * Sets the destination table.
     *
     * @param array $destinationTable The table where the query results should
     *        be stored. If not set, a new table will be created to store the
     *        results. This property must be set for large results that exceed
     *        the maximum response size.
     * @return QueryJobConfiguration
     */
    public function destinationTable(array $destinationTable)
    {
        $this->config['configuration']['query']['destinationTable'] = $destinationTable;

        return $this;
    }

    /**
     * Sets whether or not to flatten results.
     *
     * @param bool $flattenResults Whether or not to flatten results.
     * @return QueryJobConfiguration
     */
    public function flattenResults($flattenResults)
    {
        $this->config['configuration']['query']['flattenResults'] = $flattenResults;

        return $this;
    }

    /**
     * Sets the maximum billing tier.
     *
     * @param int $maximumBillingTier Limits the billing tier for this job.
     * @return QueryJobConfiguration
     */
    public function maximumBillingTier($maximumBillingTier)
    {
        $this->config['configuration']['query']['maximumBillingTier'] = $maximumBillingTier;

        return $this;
    }

    /**
     * Sets the maximum bytes billed.
     *
     * @param int $maximumBytesBilled Limits the bytes billed for this job.
     * @return QueryJobConfiguration
     */
    public function maximumBytesBilled($maximumBytesBilled)
    {
        $this->config['configuration']['query']['maximumBytesBilled'] = $maximumBytesBilled;

        return $this;
    }

    /**
     * Sets parameters to be used on the query. Only available for standard SQL
     * queries.
     *
     * @param array $parameters Parameters to use on the query. When providing
     *        a non-associative array positional parameters (`?`) will be used.
     *        When providing an associative array named parameters will be used
     *        (`@name`).
     * @return QueryJobConfiguration
     */
    public function parameters(array $parameters)
    {
        $this->config['configuration']['query']['parameterMode'] = $this->isAssoc($parameters)
            ? 'named'
            : 'positional';
        $queryParams = [];

        foreach ($parameters as $name => $value) {
            $param = $this->mapper->toParameter($value);

            if ($this->config['configuration']['query']['parameterMode'] === 'named') {
                $param += ['name' => $name];
            }

            $queryParams[] = $param;
        }

        $this->config['configuration']['query']['queryParameters'] = $queryParams;

        return $this;
    }

    /**
     * Sets the priority.
     *
     * @param string $priority A priority for the query. Possible
     *        values include `"INTERACTIVE"` and `"BATCH"`. **Defaults to**
     *        `"INTERACTIVE"`. Please note constants for these values exist
     *        on this class.
     * @return QueryJobConfiguration
     */
    public function priority($priority)
    {
        $this->config['configuration']['query']['priority'] = $priority;

        return $this;
    }

    /**
     * Sets the SQL query.
     *
     * @param string $query SQL query text to execute.
     * @return QueryJobConfiguration
     */
    public function query($query)
    {
        $this->config['configuration']['query']['query'] = $query;

        return $this;
    }

    /**
     * Sets the schema update options. Allows the schema of the destination
     * table to be updated as a side effect of the query job.
     *
     * @param array $schemaUpdateOptions Schema update options.
     * @return QueryJobConfiguration
     */
    public function schemaUpdateOptions(array $schemaUpdateOptions)
    {
        $this->config['configuration']['query']['schemaUpdateOptions'] = $schemaUpdateOptions;

        return $this;
    }

    /**
     * Sets table definitions. If querying an external data source outside of
     * BigQuery, describes the data format, location and other properties of the
     * data source.
     *
     * @param array $tableDefinitions The table definitions.
     * @return QueryJobConfiguration
     */
    public function tableDefinitions(array $tableDefinitions)
    {
        $this->config['configuration']['query']['tableDefinitions'] = $tableDefinitions;

        return $this;
    }

    /**
     * Sets time partitioning.
     *
     * @param array $timePartitioning Time-based partitioning for the
     *        destination table.
     * @return QueryJobConfiguration
     */
    public function timePartitioning(array $timePartitioning)
    {
        $this->config['configuration']['query']['timePartitioning'] = $timePartitioning;

        return $this;
    }

    /**
     * Sets whether or not to use legacy SQL dialect.
     *
     * @param bool $useLegacySql
     * @return QueryJobConfiguration
     */
    public function useLegacySql($useLegacySql)
    {
        $this->config['configuration']['query']['useLegacySql'] = $useLegacySql;

        return $this;
    }

    /**
     * Sets whether or not to use the query cache.
     *
     * @param bool $useQueryCache Whether or not to use the query cache.
     * @return QueryJobConfiguration
     */
    public function useQueryCache($useQueryCache)
    {
        $this->config['configuration']['query']['useQueryCache'] = $useQueryCache;

        return $this;
    }

    /**
     * Specifies the default dataset to use for unqualified table names in the
     * query.
     *
     * @param string $priority
     * @return QueryJobConfiguration
     */
    public function userDefinedFunctionResources(array $userDefinedFunctionResources)
    {
        $this->config['configuration']['query']['userDefinedFunctionResources'] = $userDefinedFunctionResources;

        return $this;
    }

    /**
     * Specifies the default dataset to use for unqualified table names in the
     * query.
     *
     * @param string $priority
     * @return QueryJobConfiguration
     */
    public function writeDisposition($writeDisposition)
    {
        $this->config['configuration']['query']['writeDisposition'] = $writeDisposition;

        return $this;
    }
}
