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

// [START privilegedaccessmanager_v1_generated_PrivilegedAccessManager_CheckOnboardingStatus_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\PrivilegedAccessManager\V1\CheckOnboardingStatusRequest;
use Google\Cloud\PrivilegedAccessManager\V1\CheckOnboardingStatusResponse;
use Google\Cloud\PrivilegedAccessManager\V1\Client\PrivilegedAccessManagerClient;

/**
 * `CheckOnboardingStatus` reports the onboarding status for a
 * project/folder/organization. Any findings reported by this API need to be
 * fixed before PAM can be used on the resource.
 *
 * @param string $formattedParent The resource for which the onboarding status should be checked.
 *                                Should be in one of the following formats:
 *
 *                                * `projects/{project-number|project-id}/locations/{region}`
 *                                * `folders/{folder-number}/locations/{region}`
 *                                * `organizations/{organization-number}/locations/{region}`
 *                                Please see {@see PrivilegedAccessManagerClient::organizationLocationName()} for help formatting this field.
 */
function check_onboarding_status_sample(string $formattedParent): void
{
    // Create a client.
    $privilegedAccessManagerClient = new PrivilegedAccessManagerClient();

    // Prepare the request message.
    $request = (new CheckOnboardingStatusRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var CheckOnboardingStatusResponse $response */
        $response = $privilegedAccessManagerClient->checkOnboardingStatus($request);
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
    $formattedParent = PrivilegedAccessManagerClient::organizationLocationName(
        '[ORGANIZATION]',
        '[LOCATION]'
    );

    check_onboarding_status_sample($formattedParent);
}
// [END privilegedaccessmanager_v1_generated_PrivilegedAccessManager_CheckOnboardingStatus_sync]
