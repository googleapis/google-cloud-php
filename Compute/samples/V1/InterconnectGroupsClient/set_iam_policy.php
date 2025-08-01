<?php
/*
 * Copyright 2025 Google LLC
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

// [START compute_v1_generated_InterconnectGroups_SetIamPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Compute\V1\Client\InterconnectGroupsClient;
use Google\Cloud\Compute\V1\GlobalSetPolicyRequest;
use Google\Cloud\Compute\V1\Policy;
use Google\Cloud\Compute\V1\SetIamPolicyInterconnectGroupRequest;

/**
 * Sets the access control policy on the specified resource. Replaces any existing policy.
 *
 * @param string $project  Project ID for this request.
 * @param string $resource Name or id of the resource for this request.
 */
function set_iam_policy_sample(string $project, string $resource): void
{
    // Create a client.
    $interconnectGroupsClient = new InterconnectGroupsClient();

    // Prepare the request message.
    $globalSetPolicyRequestResource = new GlobalSetPolicyRequest();
    $request = (new SetIamPolicyInterconnectGroupRequest())
        ->setGlobalSetPolicyRequestResource($globalSetPolicyRequestResource)
        ->setProject($project)
        ->setResource($resource);

    // Call the API and handle any network failures.
    try {
        /** @var Policy $response */
        $response = $interconnectGroupsClient->setIamPolicy($request);
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
    $project = '[PROJECT]';
    $resource = '[RESOURCE]';

    set_iam_policy_sample($project, $resource);
}
// [END compute_v1_generated_InterconnectGroups_SetIamPolicy_sync]
