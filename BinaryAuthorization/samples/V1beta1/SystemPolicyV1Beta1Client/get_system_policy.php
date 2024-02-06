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

// [START binaryauthorization_v1beta1_generated_SystemPolicyV1Beta1_GetSystemPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BinaryAuthorization\V1beta1\Policy;
use Google\Cloud\BinaryAuthorization\V1beta1\SystemPolicyV1Beta1Client;

/**
 * Gets the current system policy in the specified location.
 *
 * @param string $formattedName The resource name, in the format `locations/&#42;/policy`.
 *                              Note that the system policy is not associated with a project. Please see
 *                              {@see SystemPolicyV1Beta1Client::policyName()} for help formatting this field.
 */
function get_system_policy_sample(string $formattedName): void
{
    // Create a client.
    $systemPolicyV1Beta1Client = new SystemPolicyV1Beta1Client();

    // Call the API and handle any network failures.
    try {
        /** @var Policy $response */
        $response = $systemPolicyV1Beta1Client->getSystemPolicy($formattedName);
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
    $formattedName = SystemPolicyV1Beta1Client::policyName('[PROJECT]');

    get_system_policy_sample($formattedName);
}
// [END binaryauthorization_v1beta1_generated_SystemPolicyV1Beta1_GetSystemPolicy_sync]
