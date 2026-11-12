<?php
/*
 * Copyright 2026 Google LLC
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

// [START discoveryengine_v1_generated_DataStoreService_SetIamPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\DataStoreServiceClient;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;

/**
 * Sets the IAM access control policy for a
 * [DataStore][google.cloud.discoveryengine.v1.DataStore]. A `NOT_FOUND` error
 * is returned if the resource does not exist.
 *
 * **Important:** When setting a policy directly on a DataStore resource,
 * the only recommended roles in the bindings are:
 * `roles/discoveryengine.admin`
 * `roles/discoveryengine.agentspaceAdmin`
 * `roles/discoveryengine.viewer`
 * `roles/discoveryengine.agentspaceViewer`
 * `roles/discoveryengine.user`
 * `roles/discoveryengine.agentspaceUser`
 * Attempting to grant any other role will result in a warning in logging.
 *
 * @param string $resource REQUIRED: The resource for which the policy is being specified.
 *                         See the operation documentation for the appropriate value for this field.
 */
function set_iam_policy_sample(string $resource): void
{
    // Create a client.
    $dataStoreServiceClient = new DataStoreServiceClient();

    // Prepare the request message.
    $policy = new Policy();
    $request = (new SetIamPolicyRequest())
        ->setResource($resource)
        ->setPolicy($policy);

    // Call the API and handle any network failures.
    try {
        /** @var Policy $response */
        $response = $dataStoreServiceClient->setIamPolicy($request);
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
    $resource = '[RESOURCE]';

    set_iam_policy_sample($resource);
}
// [END discoveryengine_v1_generated_DataStoreService_SetIamPolicy_sync]
