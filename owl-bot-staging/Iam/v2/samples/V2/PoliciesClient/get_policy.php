<?php
/*
 * Copyright 2023 Google LLC
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

// [START iam_v2_generated_Policies_GetPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Iam\V2\PoliciesClient;
use Google\Cloud\Iam\V2\Policy;

/**
 * Gets a policy.
 *
 * @param string $name The resource name of the policy to retrieve. Format:
 *                     `policies/{attachment_point}/denypolicies/{policy_id}`
 *
 *
 *                     Use the URL-encoded full resource name, which means that the forward-slash
 *                     character, `/`, must be written as `%2F`. For example,
 *                     `policies/cloudresourcemanager.googleapis.com%2Fprojects%2Fmy-project/denypolicies/my-policy`.
 *
 *                     For organizations and folders, use the numeric ID in the full resource
 *                     name. For projects, you can use the alphanumeric or the numeric ID.
 */
function get_policy_sample(string $name): void
{
    // Create a client.
    $policiesClient = new PoliciesClient();

    // Call the API and handle any network failures.
    try {
        /** @var Policy $response */
        $response = $policiesClient->getPolicy($name);
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
    $name = '[NAME]';

    get_policy_sample($name);
}
// [END iam_v2_generated_Policies_GetPolicy_sync]
