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

// [START assuredworkloads_v1beta1_generated_AssuredWorkloadsService_DeleteWorkload_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AssuredWorkloads\V1beta1\AssuredWorkloadsServiceClient;

/**
 * Deletes the workload. Make sure that workload's direct children are already
 * in a deleted state, otherwise the request will fail with a
 * FAILED_PRECONDITION error.
 * In addition to assuredworkloads.workload.delete permission, the user should
 * also have orgpolicy.policy.set permission on the deleted folder to remove
 * Assured Workloads OrgPolicies.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function delete_workload_sample(): void
{
    // Create a client.
    $assuredWorkloadsServiceClient = new AssuredWorkloadsServiceClient();

    // Call the API and handle any network failures.
    try {
        $assuredWorkloadsServiceClient->deleteWorkload();
        printf('Call completed successfully.' . PHP_EOL);
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END assuredworkloads_v1beta1_generated_AssuredWorkloadsService_DeleteWorkload_sync]
