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

// [START binaryauthorization_v1beta1_generated_BinauthzManagementServiceV1Beta1_CreateAttestor_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BinaryAuthorization\V1beta1\Attestor;
use Google\Cloud\BinaryAuthorization\V1beta1\BinauthzManagementServiceV1Beta1Client;

/**
 * Creates an [attestor][google.cloud.binaryauthorization.v1beta1.Attestor], and returns a copy of the new
 * [attestor][google.cloud.binaryauthorization.v1beta1.Attestor]. Returns NOT_FOUND if the project does not exist,
 * INVALID_ARGUMENT if the request is malformed, ALREADY_EXISTS if the
 * [attestor][google.cloud.binaryauthorization.v1beta1.Attestor] already exists.
 *
 * @param string $formattedParent The parent of this [attestor][google.cloud.binaryauthorization.v1beta1.Attestor]. Please see
 *                                {@see BinauthzManagementServiceV1Beta1Client::projectName()} for help formatting this field.
 * @param string $attestorId      The [attestors][google.cloud.binaryauthorization.v1beta1.Attestor] ID.
 * @param string $attestorName    The resource name, in the format:
 *                                `projects/&#42;/attestors/*`. This field may not be updated.
 */
function create_attestor_sample(
    string $formattedParent,
    string $attestorId,
    string $attestorName
): void {
    // Create a client.
    $binauthzManagementServiceV1Beta1Client = new BinauthzManagementServiceV1Beta1Client();

    // Prepare any non-scalar elements to be passed along with the request.
    $attestor = (new Attestor())
        ->setName($attestorName);

    // Call the API and handle any network failures.
    try {
        /** @var Attestor $response */
        $response = $binauthzManagementServiceV1Beta1Client->createAttestor(
            $formattedParent,
            $attestorId,
            $attestor
        );
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
    $formattedParent = BinauthzManagementServiceV1Beta1Client::projectName('[PROJECT]');
    $attestorId = '[ATTESTOR_ID]';
    $attestorName = '[NAME]';

    create_attestor_sample($formattedParent, $attestorId, $attestorName);
}
// [END binaryauthorization_v1beta1_generated_BinauthzManagementServiceV1Beta1_CreateAttestor_sync]
