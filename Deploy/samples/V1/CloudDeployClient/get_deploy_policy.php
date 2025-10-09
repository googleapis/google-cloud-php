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

// [START clouddeploy_v1_generated_CloudDeploy_GetDeployPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Deploy\V1\Client\CloudDeployClient;
use Google\Cloud\Deploy\V1\DeployPolicy;
use Google\Cloud\Deploy\V1\GetDeployPolicyRequest;

/**
 * Gets details of a single DeployPolicy.
 *
 * @param string $formattedName Name of the `DeployPolicy`. Format must be
 *                              `projects/{project_id}/locations/{location_name}/deployPolicies/{deploy_policy_name}`. Please see
 *                              {@see CloudDeployClient::deployPolicyName()} for help formatting this field.
 */
function get_deploy_policy_sample(string $formattedName): void
{
    // Create a client.
    $cloudDeployClient = new CloudDeployClient();

    // Prepare the request message.
    $request = (new GetDeployPolicyRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var DeployPolicy $response */
        $response = $cloudDeployClient->getDeployPolicy($request);
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
    $formattedName = CloudDeployClient::deployPolicyName('[PROJECT]', '[LOCATION]', '[DEPLOY_POLICY]');

    get_deploy_policy_sample($formattedName);
}
// [END clouddeploy_v1_generated_CloudDeploy_GetDeployPolicy_sync]
