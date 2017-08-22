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

use Google\Cloud\Core\ArrayTrait;
use Ramsey\Uuid\Uuid;

/**
 * A trait used to build out configuration for jobs.
 */
trait JobConfigurationTrait
{
    use ArrayTrait;

    /**
     * Builds a configuration for a job.
     *
     * @param string $name
     * @param string $projectId
     * @param array $config
     * @param array $userDefinedOptions
     * @return array
     */
    public function buildJobConfig($name, $projectId, array $config, array $userDefinedOptions)
    {
        $jobIdPrefix = $this->pluck('jobIdPrefix', $userDefinedOptions, false);

        if (isset($userDefinedOptions['jobConfig'])) {
            $config = $userDefinedOptions['jobConfig'] + $config;
        }

        unset($userDefinedOptions['jobConfig']);

        return [
            'projectId' => $projectId,
            'jobReference' => [
                'projectId' => $projectId,
                'jobId' => $this->generateJobId($jobIdPrefix)
            ],
            'configuration' => [
                $name => $config
            ]
        ] + $userDefinedOptions;
    }

    /**
     * Generate a Job ID with an optional user-defined prefix.
     *
     * @param string $jobIdPrefix [optional] If given, the returned job ID will
     *        be of format `{$jobIdPrefix-}{jobId}`. **Defaults to** `null`.
     * @return string
     */
    protected function generateJobId($jobIdPrefix = null)
    {
        $jobId = '';

        if ($jobIdPrefix) {
            $jobId = $jobIdPrefix . '-';
        }

        return $jobId . Uuid::uuid4();
    }
}
