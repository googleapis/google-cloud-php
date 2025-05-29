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

// [START iam_v3_generated_PolicyBindings_SearchTargetPolicyBindings_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Iam\V3\Client\PolicyBindingsClient;
use Google\Cloud\Iam\V3\PolicyBinding;
use Google\Cloud\Iam\V3\SearchTargetPolicyBindingsRequest;

/**
 * Search policy bindings by target. Returns all policy binding objects bound
 * directly to target.
 *
 * @param string $target          The target resource, which is bound to the policy in the binding.
 *
 *                                Format:
 *
 *                                * `//iam.googleapis.com/locations/global/workforcePools/POOL_ID`
 *                                * `//iam.googleapis.com/projects/PROJECT_NUMBER/locations/global/workloadIdentityPools/POOL_ID`
 *                                * `//iam.googleapis.com/locations/global/workspace/WORKSPACE_ID`
 *                                * `//cloudresourcemanager.googleapis.com/projects/{project_number}`
 *                                * `//cloudresourcemanager.googleapis.com/folders/{folder_id}`
 *                                * `//cloudresourcemanager.googleapis.com/organizations/{organization_id}`
 * @param string $formattedParent The parent resource where this search will be performed. This
 *                                should be the nearest Resource Manager resource (project, folder, or
 *                                organization) to the target.
 *
 *                                Format:
 *
 *                                * `projects/{project_id}/locations/{location}`
 *                                * `projects/{project_number}/locations/{location}`
 *                                * `folders/{folder_id}/locations/{location}`
 *                                * `organizations/{organization_id}/locations/{location}`
 *                                Please see {@see PolicyBindingsClient::organizationLocationName()} for help formatting this field.
 */
function search_target_policy_bindings_sample(string $target, string $formattedParent): void
{
    // Create a client.
    $policyBindingsClient = new PolicyBindingsClient();

    // Prepare the request message.
    $request = (new SearchTargetPolicyBindingsRequest())
        ->setTarget($target)
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $policyBindingsClient->searchTargetPolicyBindings($request);

        /** @var PolicyBinding $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
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
    $target = '[TARGET]';
    $formattedParent = PolicyBindingsClient::organizationLocationName('[ORGANIZATION]', '[LOCATION]');

    search_target_policy_bindings_sample($target, $formattedParent);
}
// [END iam_v3_generated_PolicyBindings_SearchTargetPolicyBindings_sync]
