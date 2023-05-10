<?php
/*
 * Copyright 2022 Google LLC
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

// [START cloudresourcemanager_v3_generated_TagValues_GetIamPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\ResourceManager\V3\Client\TagValuesClient;

/**
 * Gets the access control policy for a TagValue. The returned policy may be
 * empty if no such policy or resource exists. The `resource` field should
 * be the TagValue's resource name. For example: `tagValues/1234`.
 * The caller must have the
 * `cloudresourcemanager.googleapis.com/tagValues.getIamPolicy` permission on
 * the identified TagValue to get the access control policy.
 *
 * @param string $resource REQUIRED: The resource for which the policy is being requested.
 *                         See the operation documentation for the appropriate value for this field.
 */
function get_iam_policy_sample(string $resource): void
{
    // Create a client.
    $tagValuesClient = new TagValuesClient();

    // Prepare the request message.
    $request = (new GetIamPolicyRequest())
        ->setResource($resource);

    // Call the API and handle any network failures.
    try {
        /** @var Policy $response */
        $response = $tagValuesClient->getIamPolicy($request);
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

    get_iam_policy_sample($resource);
}
// [END cloudresourcemanager_v3_generated_TagValues_GetIamPolicy_sync]
