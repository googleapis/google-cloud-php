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

use Google\Cloud\Core\ArrayTrait;
use Ramsey\Uuid\Uuid;

/**
 * A utility trait implementing shared behavior between job configurations.
 */
trait JobConfigurationTrait
{
    use ArrayTrait;

    /**
     * @var string $jobIdPrefix
     */
    private $jobIdPrefix;

    /**
     * @var array $config
     */
    private $config = [];

    /**
     * Sets shared job configuration properties.
     *
     * @access private
     * @param string $projectId The project's ID.
     * @param array $config A set of configuration options for a job.
     * @param string|null $location The geographic location in which the job is
     *        executed.
     */
    public function jobConfigurationProperties(
        $projectId,
        array $config,
        $location
    ) {
        $this->config = array_replace_recursive([
            'projectId' => $projectId,
            'jobReference' => ['projectId' => $projectId]
        ], $config);

        if ($location && !isset($this->config['jobReference']['location'])) {
            $this->config['jobReference']['location'] = $location;
        }

        if (!isset($this->config['jobReference']['jobId'])) {
            $this->config['jobReference']['jobId'] = $this->generateJobId();
        }
    }

    /**
     * Sets dryRun flag. If set to true, don't actually run this job. A valid query will
     * return a mostly empty response with some processing statistics, while an
     * invalid query will return the same error it would if it wasn't a dry run.
     *
     * @param bool $dryRun Whether or not to execute as a dry run.
     * @return JobConfigurationInterface
     */
    public function dryRun($dryRun)
    {
        $this->config['configuration']['dryRun'] = $dryRun;

        return $this;
    }

    /**
     * Sets a prefix for the job ID.
     *
     * @param string $jobIdPrefix If provided, the job ID will be of format
     *        `{$jobIdPrefix}-{jobId}`.
     * @return JobConfigurationInterface
     */
    public function jobIdPrefix($jobIdPrefix)
    {
        $this->jobIdPrefix = $jobIdPrefix;

        return $this;
    }

    /**
     * Sets the labels associated with the job. Labels can use these to organize
     * and group jobs. Label keys and values can be no longer than 63 characters,
     * can only contain lowercase letters, numeric characters, underscores and
     * dashes. International characters are allowed. Label values are optional.
     * Label keys must start with a letter and each label in the list must have
     * a different key.
     *
     * @param array $labels The labels to apply.
     * @return JobConfigurationInterface
     */
    public function labels(array $labels)
    {
        $this->config['configuration']['labels'] = $labels;

        return $this;
    }

    /**
     * Specifies the geographic location of the job. Required for jobs started
     * outside of the US and EU regions.
     *
     * @param string $location The geographic location of the job.
     *        **Defaults to** a location specified in the client configuration,
     *        if provided, or through location metadata fetched by a network
     *        request
     *        (by calling {@see Google\Cloud\BigQuery\Table::reload()}, for example).
     * @return JobConfigurationInterface
     */
    public function location($location)
    {
        $this->config['jobReference']['location'] = $location;

        return $this;
    }

    /**
     * Returns the job config as an array.
     *
     * @access private
     * @return array
     */
    public function toArray()
    {
        if ($this->jobIdPrefix) {
            $this->config['jobReference']['jobId'] = sprintf(
                '%s-%s',
                $this->jobIdPrefix,
                $this->config['jobReference']['jobId']
            );
        }

        return $this->config;
    }

    /**
     * Generate a Job ID.
     *
     * @return string
     */
    protected function generateJobId()
    {
        return Uuid::uuid4()->toString();
    }
}
