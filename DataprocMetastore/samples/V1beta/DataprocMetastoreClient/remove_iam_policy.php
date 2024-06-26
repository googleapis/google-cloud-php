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

// [START metastore_v1beta_generated_DataprocMetastore_RemoveIamPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Metastore\V1beta\Client\DataprocMetastoreClient;
use Google\Cloud\Metastore\V1beta\RemoveIamPolicyRequest;
use Google\Cloud\Metastore\V1beta\RemoveIamPolicyResponse;

/**
 * Removes the attached IAM policies for a resource
 *
 * @param string $resource The relative resource name of the dataplane resource to remove
 *                         IAM policy, in the following form:
 *
 *                         `projects/{project_id}/locations/{location_id}/services/{service_id}/databases/{database_id}`
 *                         or
 *                         `projects/{project_id}/locations/{location_id}/services/{service_id}/databases/{database_id}/tables/{table_id}`.
 */
function remove_iam_policy_sample(string $resource): void
{
    // Create a client.
    $dataprocMetastoreClient = new DataprocMetastoreClient();

    // Prepare the request message.
    $request = (new RemoveIamPolicyRequest())
        ->setResource($resource);

    // Call the API and handle any network failures.
    try {
        /** @var RemoveIamPolicyResponse $response */
        $response = $dataprocMetastoreClient->removeIamPolicy($request);
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

    remove_iam_policy_sample($resource);
}
// [END metastore_v1beta_generated_DataprocMetastore_RemoveIamPolicy_sync]
