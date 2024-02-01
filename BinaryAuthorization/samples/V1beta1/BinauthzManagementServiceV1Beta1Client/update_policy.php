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

// [START binaryauthorization_v1beta1_generated_BinauthzManagementServiceV1Beta1_UpdatePolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BinaryAuthorization\V1beta1\BinauthzManagementServiceV1Beta1Client;
use Google\Cloud\BinaryAuthorization\V1beta1\Policy;

/**
 * Creates or updates a project's [policy][google.cloud.binaryauthorization.v1beta1.Policy], and returns a copy of the
 * new [policy][google.cloud.binaryauthorization.v1beta1.Policy]. A policy is always updated as a whole, to avoid race
 * conditions with concurrent policy enforcement (or management!)
 * requests. Returns NOT_FOUND if the project does not exist, INVALID_ARGUMENT
 * if the request is malformed.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_policy_sample(): void
{
    // Create a client.
    $binauthzManagementServiceV1Beta1Client = new BinauthzManagementServiceV1Beta1Client();

    // Call the API and handle any network failures.
    try {
        /** @var Policy $response */
        $response = $binauthzManagementServiceV1Beta1Client->updatePolicy();
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END binaryauthorization_v1beta1_generated_BinauthzManagementServiceV1Beta1_UpdatePolicy_sync]
