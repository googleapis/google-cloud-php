<?php
/*
 * Copyright 2023 Google LLC
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

// [START dialogflow_v3_generated_SecuritySettingsService_CreateSecuritySettings_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\SecuritySettings;
use Google\Cloud\Dialogflow\Cx\V3\SecuritySettingsServiceClient;

/**
 * Create security settings in the specified location.
 *
 * @param string $formattedParent             The location to create an
 *                                            [SecuritySettings][google.cloud.dialogflow.cx.v3.SecuritySettings] for.
 *                                            Format: `projects/<Project ID>/locations/<Location ID>`. Please see
 *                                            {@see SecuritySettingsServiceClient::locationName()} for help formatting this field.
 * @param string $securitySettingsDisplayName The human-readable name of the security settings, unique within
 *                                            the location.
 */
function create_security_settings_sample(
    string $formattedParent,
    string $securitySettingsDisplayName
): void {
    // Create a client.
    $securitySettingsServiceClient = new SecuritySettingsServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $securitySettings = (new SecuritySettings())
        ->setDisplayName($securitySettingsDisplayName);

    // Call the API and handle any network failures.
    try {
        /** @var SecuritySettings $response */
        $response = $securitySettingsServiceClient->createSecuritySettings(
            $formattedParent,
            $securitySettings
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
    $formattedParent = SecuritySettingsServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $securitySettingsDisplayName = '[DISPLAY_NAME]';

    create_security_settings_sample($formattedParent, $securitySettingsDisplayName);
}
// [END dialogflow_v3_generated_SecuritySettingsService_CreateSecuritySettings_sync]