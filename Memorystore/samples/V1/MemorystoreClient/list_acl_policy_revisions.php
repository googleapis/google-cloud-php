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

// [START memorystore_v1_generated_Memorystore_ListAclPolicyRevisions_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Memorystore\V1\AclPolicyRevision;
use Google\Cloud\Memorystore\V1\Client\MemorystoreClient;
use Google\Cloud\Memorystore\V1\ListAclPolicyRevisionsRequest;

/**
 * Lists all ACL policy revisions in a given ACL policy.
 *
 * @param string $formattedParent The resource name of the ACL policy to list revisions for.
 *                                Format: "projects/{project}/locations/{location}/aclPolicies/{acl_policy}"
 *                                Please see {@see MemorystoreClient::aclPolicyName()} for help formatting this field.
 */
function list_acl_policy_revisions_sample(string $formattedParent): void
{
    // Create a client.
    $memorystoreClient = new MemorystoreClient();

    // Prepare the request message.
    $request = (new ListAclPolicyRevisionsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $memorystoreClient->listAclPolicyRevisions($request);

        /** @var AclPolicyRevision $element */
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
    $formattedParent = MemorystoreClient::aclPolicyName('[PROJECT]', '[LOCATION]', '[ACL_POLICY]');

    list_acl_policy_revisions_sample($formattedParent);
}
// [END memorystore_v1_generated_Memorystore_ListAclPolicyRevisions_sync]
