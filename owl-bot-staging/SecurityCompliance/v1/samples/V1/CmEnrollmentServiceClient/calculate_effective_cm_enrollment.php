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

// [START cloudsecuritycompliance_v1_generated_CmEnrollmentService_CalculateEffectiveCmEnrollment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\CloudSecurityCompliance\V1\CalculateEffectiveCmEnrollmentRequest;
use Google\Cloud\CloudSecurityCompliance\V1\CalculateEffectiveCmEnrollmentResponse;
use Google\Cloud\CloudSecurityCompliance\V1\Client\CmEnrollmentServiceClient;

/**
 * Calculates the effective Compliance Manager enrollment for a resource.
 * An effective enrollment is either a direct enrollment of a
 * resource (if it exists), or an enrollment of the closest parent of a
 * resource that's enrolled in Compliance Manager.
 *
 * @param string $formattedName The name of the Compliance Manager enrollment to calculate.
 *
 *                              Supported formats are the following:
 *
 *                              * `organizations/{organization_id}/locations/{location}/cmEnrollment`
 *                              * `folders/{folder_id}/locations/{location}/cmEnrollment`
 *                              * `projects/{project_id}/locations/{location}/cmEnrollment`
 *                              Please see {@see CmEnrollmentServiceClient::cmEnrollmentName()} for help formatting this field.
 */
function calculate_effective_cm_enrollment_sample(string $formattedName): void
{
    // Create a client.
    $cmEnrollmentServiceClient = new CmEnrollmentServiceClient();

    // Prepare the request message.
    $request = (new CalculateEffectiveCmEnrollmentRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var CalculateEffectiveCmEnrollmentResponse $response */
        $response = $cmEnrollmentServiceClient->calculateEffectiveCmEnrollment($request);
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
    $formattedName = CmEnrollmentServiceClient::cmEnrollmentName('[ORGANIZATION]', '[LOCATION]');

    calculate_effective_cm_enrollment_sample($formattedName);
}
// [END cloudsecuritycompliance_v1_generated_CmEnrollmentService_CalculateEffectiveCmEnrollment_sync]
