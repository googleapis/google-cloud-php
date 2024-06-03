<?php
/*
 * Copyright 2024 Google LLC
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
 * This file was automatically generated - do not edit!
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

// [START composer_v1_generated_Environments_CreateUserWorkloadsConfigMap_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Orchestration\Airflow\Service\V1\Client\EnvironmentsClient;
use Google\Cloud\Orchestration\Airflow\Service\V1\CreateUserWorkloadsConfigMapRequest;
use Google\Cloud\Orchestration\Airflow\Service\V1\UserWorkloadsConfigMap;

/**
 * Creates a user workloads ConfigMap.
 *
 * This method is supported for Cloud Composer environments in versions
 * composer-3.*.*-airflow-*.*.* and newer.
 *
 * @param string $formattedParent The environment name to create a ConfigMap for, in the form:
 *                                "projects/{projectId}/locations/{locationId}/environments/{environmentId}"
 *                                Please see {@see EnvironmentsClient::environmentName()} for help formatting this field.
 */
function create_user_workloads_config_map_sample(string $formattedParent): void
{
    // Create a client.
    $environmentsClient = new EnvironmentsClient();

    // Prepare the request message.
    $userWorkloadsConfigMap = new UserWorkloadsConfigMap();
    $request = (new CreateUserWorkloadsConfigMapRequest())
        ->setParent($formattedParent)
        ->setUserWorkloadsConfigMap($userWorkloadsConfigMap);

    // Call the API and handle any network failures.
    try {
        /** @var UserWorkloadsConfigMap $response */
        $response = $environmentsClient->createUserWorkloadsConfigMap($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}

/**
 * Helper to execute the sample.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function callSample(): void
{
    $formattedParent = EnvironmentsClient::environmentName('[PROJECT]', '[LOCATION]', '[ENVIRONMENT]');

    create_user_workloads_config_map_sample($formattedParent);
}
// [END composer_v1_generated_Environments_CreateUserWorkloadsConfigMap_sync]
