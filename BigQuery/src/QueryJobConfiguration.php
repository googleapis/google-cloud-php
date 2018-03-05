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
 *
 * Example:
 * ```
 * use Google\Cloud\BigQuery\BigQueryClient;
 *
 * $bigQuery = new BigQueryClient();
 * $query = $bigQuery->query('SELECT commit FROM `bigquery-public-data.github_repos.commits` LIMIT 100');
 * ```
 */
class QueryJobConfiguration implements JobConfigurationInterface
{
    use JobConfigurationTrait;

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
     * Sets whether or not the query can produce arbitrarily large result
     * tables at a slight cost in performance. Only applies to queries
     * performed with legacy SQL dialect and requires a
     * {@see Google\Cloud\BigQuery\QueryJobConfiguration::destinationTable()} to
     * be set.
     *
     * Example:
     * ```
     * $query->allowLargeResults(true);
     * ```
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
     * Sets whether the job is allowed to create new tables.
     *
     * Example:
     * ```
     * $query->createDisposition('CREATE_NEVER');
     * ```
     *
     * @param string $createDisposition The create disposition. Acceptable
     *        values include `"CREATE_IF_NEEDED"`, `"CREATE_NEVER"`.
     * @return QueryJobConfiguration
     */
    public function createDisposition($createDisposition)
    {
        $this->config['configuration']['query']['createDisposition'] = $createDisposition;

        return $this;
    }

    /**
     * Sets the default dataset to use for unqualified table names in the query.
     *
     * Example:
     * ```
     * $dataset = $bigQuery->dataset('my_dataset');
     * $query->defaultDataset($dataset);
     * ```
     *
     * @param Dataset $defaultDataset The default dataset.
     * @return QueryJobConfiguration
     */
    public function defaultDataset(Dataset $defaultDataset)
    {
        $this->config['configuration']['query']['defaultDataset'] = $defaultDataset->identity();

        return $this;
    }

    /**
     * Sets the custom encryption configuration (e.g., Cloud KMS keys).
     *
     * Example:
     * ```
     * $query->destinationEncryptionConfiguration([
     *     'kmsKeyName' => 'my_key'
     * ]);
     * ```
     *
     * @param array $configuration Custom encryption configuration.
     * @return QueryJobConfiguration
     */
    public function destinationEncryptionConfiguration(array $configuration)
    {
        $this->config['configuration']['query']['destinationEncryptionConfiguration'] = $configuration;

        return $this;
    }

    /**
     * Sets the table where the query results should be stored. If not set, a
     * new table will be created to store the results. This property must be set
     * for large results that exceed the maximum response size.
     *
     * Example:
     * ```
     * $table = $bigQuery->dataset('my_dataset')
     *     ->table('my_table');
     * $query->destinationTable($table);
     * ```
     *
     * @param Table $destinationTable The destination table.
     * @return QueryJobConfiguration
     */
    public function destinationTable(Table $destinationTable)
    {
        $this->config['configuration']['query']['destinationTable'] = $destinationTable->identity();

        return $this;
    }

    /**
     * Sets whether or not to flatten all nested and repeated fields in the
     * query results. Only applies to queries performed with legacy SQL dialect.
     * {@see Google\Cloud\BigQuery\QueryJobConfiguration::allowLargeResults()}
     * must be true if this is set to false.
     *
     * Example:
     * ```
     * $query->useLegacySql(true)
     *     ->flattenResults(true);
     * ```
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
     * Sets the billing tier limit for this job. Queries that have resource
     * usage beyond this tier will fail (without incurring a charge). If
     * unspecified, this will be set to your project default.
     *
     * Example:
     * ```
     * $query->maximumBillingTier(1);
     * ```
     *
     * @see https://cloud.google.com/bigquery/pricing#high-compute High-Compute queries
     *
     * @param int $maximumBillingTier The maximum billing tier.
     * @return QueryJobConfiguration
     */
    public function maximumBillingTier($maximumBillingTier)
    {
        $this->config['configuration']['query']['maximumBillingTier'] = $maximumBillingTier;

        return $this;
    }

    /**
     * Sets a bytes billed limit for this job. Queries that will have bytes
     * billed beyond this limit will fail (without incurring a charge). If
     * unspecified, this will be set to your project default.
     *
     * Example:
     * ```
     * $query->maximumBytesBilled(3000);
     * ```
     *
     * @param int $maximumBytesBilled The maximum allowable bytes to bill.
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
     * For examples of usage please see
     * {@see Google\Cloud\BigQuery\BigQueryClient::runQuery()}.
     *
     * @param array $parameters Parameters to use on the query. When providing
     *        a non-associative array positional parameters (`?`) will be used.
     *        When providing an associative array named parameters will be used
     *        (`@name`).
     * @return QueryJobConfiguration
     */
    public function parameters(array $parameters)
    {
        $queryParams = [];
        $this->config['configuration']['query']['parameterMode'] = $this->isAssoc($parameters)
            ? 'named'
            : 'positional';

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
     * Sets a priority for the query.
     *
     * Example:
     * ```
     * $query->priority('BATCH');
     * ```
     *
     * @param string $priority The priority. Acceptable values include
     *        `"INTERACTIVE"`, `"BATCH"`. **Defaults to** `"INTERACTIVE"`.
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
     * Example:
     * ```
     * $query->query(
     *     'SELECT commit FROM `bigquery-public-data.github_repos.commits` LIMIT 100'
     * );
     * ```
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
     * Sets options to allow the schema of the destination table to be updated
     * as a side effect of the query job. Schema update options are supported
     * in two cases: when writeDisposition is `"WRITE_APPEND"`; when
     * writeDisposition is `"WRITE_TRUNCATE"` and the destination table is a
     * partition of a table, specified by partition decorators. For normal
     * tables, `"WRITE_TRUNCATE"` will always overwrite the schema.
     *
     * Example:
     * ```
     * $query->schemaUpdateOptions([
     *     'ALLOW_FIELD_ADDITION'
     * ]);
     * ```
     *
     * @param array $schemaUpdateOptions Schema update options. Acceptable
     *        values include `"ALLOW_FIELD_ADDITION"` (allow adding a nullable
     *        field to the schema),  `"ALLOW_FIELD_RELAXATION"` (allow relaxing
     *        a required field in the original schema to nullable).
     * @return QueryJobConfiguration
     */
    public function schemaUpdateOptions(array $schemaUpdateOptions)
    {
        $this->config['configuration']['query']['schemaUpdateOptions'] = $schemaUpdateOptions;

        return $this;
    }

    /**
     * Sets table definitions for querying an external data source outside of
     * BigQuery. Describes the data format, location and other properties of the
     * data source.
     *
     * Example:
     * ```
     * $query->tableDefinitions([
     *     'autodetect' => true,
     *     'sourceUris' => [
     *         'gs://my_bucket/table.json'
     *     ]
     * ]);
     * ```
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
     * Sets time-based partitioning for the destination table.
     *
     * Example:
     * ```
     * $query->timePartitioning([
     *     'type' => 'DAY'
     * ]);
     * ```
     *
     * @param array $timePartitioning Time-based partitioning configuration.
     * @return QueryJobConfiguration
     */
    public function timePartitioning(array $timePartitioning)
    {
        $this->config['configuration']['query']['timePartitioning'] = $timePartitioning;

        return $this;
    }

    /**
     * Sets whether or not to use legacy SQL dialect. When not set, defaults to
     * false in this client.
     *
     * Example:
     * ```
     * $query->useLegacySql(true);
     * ```
     *
     * @param bool $useLegacySql Whether or not to use legacy SQL dialect.
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
     * Example:
     * ```
     * $query->useQueryCache(true);
     * ```
     *
     * @see https://cloud.google.com/bigquery/querying-data#query-caching Query Caching
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
     * Sets user-defined function resources used in the query.
     *
     * Example:
     * ```
     * $query->userDefinedFunctionResources([
     *     ['resourceUri' => 'gs://my_bucket/code_path']
     * ]);
     * ```
     *
     * @param array $userDefinedFunctionResources User-defined function
     *        resources used in the query. This is to be formatted as a list of
     *        sub-arrays containing either a key `resourceUri` or `inlineCode`.
     * @return QueryJobConfiguration
     */
    public function userDefinedFunctionResources(array $userDefinedFunctionResources)
    {
        $this->config['configuration']['query']['userDefinedFunctionResources'] = $userDefinedFunctionResources;

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
     * $query->writeDisposition('WRITE_TRUNCATE');
     * ```
     *
     * @param string $writeDisposition The write disposition. Acceptable values
     *        include `"WRITE_TRUNCATE"`, `"WRITE_APPEND"`, `"WRITE_EMPTY"`.
     *        **Defaults to** `"WRITE_EMPTY"`.
     * @return QueryJobConfiguration
     */
    public function writeDisposition($writeDisposition)
    {
        $this->config['configuration']['query']['writeDisposition'] = $writeDisposition;

        return $this;
    }
}
