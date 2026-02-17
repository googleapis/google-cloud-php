<?php
/**
 * Copyright 2026 Google Inc. All Rights Reserved.
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

use Ramsey\Uuid\Uuid;

/**
 * Represents a configuration for a stateless query.
 *
 * This class is used internally by {@see BigQueryClient::runQuery()} to
 * determine if a query can be executed using the stateless `jobs.query`
 * endpoint and to build the corresponding request.
 *
 * @internal
 */
class StatelessJobConfiguration implements JobConfigurationInterface
{
    use JobConfigurationTrait;

    /**
     * Returns an array that represents a QueryRequest for a stateless query.
     * Returns null if one of the conditions are not met for a stateless query.
     *
     * @return array<mixed>|null
     */
    public static function getQueryRequest(JobConfigurationInterface $jobConfiguration): array|null
    {
        $config = $jobConfiguration->toArray();
        $queryConfig = $config['configuration']['query'];

        if (
            isset($queryConfig['destinationTable']) ||
            isset($queryConfig['tableDefinitions']) ||
            isset($queryConfig['createDisposition']) ||
            isset($queryConfig['writeDisposition']) ||
            (
                isset($queryConfig['priority']) &&
                $queryConfig['priority'] !== 'INTERACTIVE'
            ) ||
            (isset($queryConfig['useLegacySql']) && $queryConfig['useLegacySql']) ||
            isset($queryConfig['maximumBillingTier']) ||
            isset($queryConfig['timePartitioning']) ||
            isset($queryConfig['rangePartitioning']) ||
            isset($queryConfig['clustering']) ||
            isset($queryConfig['destinationEncryptionConfiguration']) ||
            isset($queryConfig['schemaUpdateOptions']) ||
            isset($queryConfig['jobTimeoutMs']) ||
            isset($queryConfig['jobId'])
        ) {
            return null;
        }

        if (isset($config['configuration']['dryRun']) && $config['configuration']['dryRun']) {
            return null;
        }

        if (
            isset($config['jobReference']['jobId']) &&
            method_exists($jobConfiguration, 'isJobIdGenerated') &&
            !$jobConfiguration->isJobIdGenerated()
        ) {
            return null;
        }

        return [
            'query' => $queryConfig['query'],
            'maxResults' => $queryConfig['maxResults'] ?? null,
            'defaultDataset' => $queryConfig['defaultDataset'] ?? null,
            'timeoutMs' => $queryConfig['timeoutMs'] ?? null,
            'useQueryCache' => $queryConfig['useQueryCache'] ?? null,
            'useLegacySql' => false,
            'queryParameters' => $queryConfig['queryParameters'] ?? null,
            'parameterMode' => $queryConfig['parameterMode'] ?? null,
            'labels' => $config['configuration']['labels'] ?? null,
            'createSession' => $queryConfig['createSession'] ?? null,
            'maximumBytesBilled' => $queryConfig['maximumBytesBilled'] ?? null,
            'location' => $config['jobReference']['location'] ?? null,
            'formatOptions' => [
                'useInt64Timestamp' => true
            ],
            'requestId' => self::generateJobId(),
            'jobCreationMode' => self::JOB_CREATION_MODE_OPTIONAL
        ];
    }

    /**
     * Generate a Job ID.
     *
     * @return string
     */
    protected static function generateJobId()
    {
        return Uuid::uuid4()->toString();
    }
}
