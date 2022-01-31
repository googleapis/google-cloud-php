<?php
/*
 * Copyright 2018 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/monitoring/v3/alert_service.proto
 * and updates to that file get reflected here through a refresh process.
 */

namespace Google\Cloud\Monitoring\V3;

use Google\Cloud\Monitoring\V3\Gapic\AlertPolicyServiceGapicClient;
use Google\ApiCore\PathTemplate;

/**
 * {@inheritdoc}
 */
class AlertPolicyServiceClient extends AlertPolicyServiceGapicClient
{
    /**
     * Formats a string containing the fully-qualified path to represent
     * a alert_policy_condition resource.
     *
     * @param string $project
     * @param string $alertPolicy
     * @param string $condition
     *
     * @return string The formatted alert_policy_condition resource.
     * @deprecated
     */
    public static function alertPolicyConditionName($project, $alertPolicy, $condition)
    {
        return (new PathTemplate('projects/{project}/alertPolicies/{alert_policy}/conditions/{condition}'))->render([
            'project' => $project,
            'alert_policy' => $alertPolicy,
            'condition' => $condition,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a project resource.
     *
     * @param string $project
     *
     * @return string The formatted project resource.
     * @deprecated
     */
    public static function projectName($project)
    {
        return (new PathTemplate('projects/{project}'))->render([
            'project' => $project,
        ]);
    }
}
