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

namespace Google\Cloud\Bigquery;

/**
 * A trait used to build out configuration for jobs.
 */
trait JobConfigurationTrait
{
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
        if (isset($userDefinedOptions['jobConfig'])) {
            $config = $userDefinedOptions['jobConfig'] + $config;
        }

        unset($userDefinedOptions['jobConfig']);

        return [
            'projectId' => $projectId,
            'configuration' => [
                $name => $config
            ]
        ] + $userDefinedOptions;
    }
}
