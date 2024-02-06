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

// [START binaryauthorization_v1beta1_generated_BinauthzManagementServiceV1Beta1_DeleteAttestor_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BinaryAuthorization\V1beta1\BinauthzManagementServiceV1Beta1Client;

/**
 * Deletes an [attestor][google.cloud.binaryauthorization.v1beta1.Attestor]. Returns NOT_FOUND if the
 * [attestor][google.cloud.binaryauthorization.v1beta1.Attestor] does not exist.
 *
 * @param string $formattedName The name of the [attestors][google.cloud.binaryauthorization.v1beta1.Attestor] to delete, in the format
 *                              `projects/&#42;/attestors/*`. Please see
 *                              {@see BinauthzManagementServiceV1Beta1Client::attestorName()} for help formatting this field.
 */
function delete_attestor_sample(string $formattedName): void
{
    // Create a client.
    $binauthzManagementServiceV1Beta1Client = new BinauthzManagementServiceV1Beta1Client();

    // Call the API and handle any network failures.
    try {
        $binauthzManagementServiceV1Beta1Client->deleteAttestor($formattedName);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = BinauthzManagementServiceV1Beta1Client::attestorName('[PROJECT]', '[ATTESTOR]');

    delete_attestor_sample($formattedName);
}
// [END binaryauthorization_v1beta1_generated_BinauthzManagementServiceV1Beta1_DeleteAttestor_sync]
