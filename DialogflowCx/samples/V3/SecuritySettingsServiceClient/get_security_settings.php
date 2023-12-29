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

// [START dialogflow_v3_generated_SecuritySettingsService_GetSecuritySettings_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\Client\SecuritySettingsServiceClient;
use Google\Cloud\Dialogflow\Cx\V3\GetSecuritySettingsRequest;
use Google\Cloud\Dialogflow\Cx\V3\SecuritySettings;

/**
 * Retrieves the specified
 * [SecuritySettings][google.cloud.dialogflow.cx.v3.SecuritySettings]. The
 * returned settings may be stale by up to 1 minute.
 *
 * @param string $formattedName Resource name of the settings.
 *                              Format: `projects/<Project ID>/locations/<Location
 *                              ID>/securitySettings/<security settings ID>`. Please see
 *                              {@see SecuritySettingsServiceClient::securitySettingsName()} for help formatting this field.
 */
function get_security_settings_sample(string $formattedName): void
{
    // Create a client.
    $securitySettingsServiceClient = new SecuritySettingsServiceClient();

    // Prepare the request message.
    $request = (new GetSecuritySettingsRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var SecuritySettings $response */
        $response = $securitySettingsServiceClient->getSecuritySettings($request);
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
    $formattedName = SecuritySettingsServiceClient::securitySettingsName(
        '[PROJECT]',
        '[LOCATION]',
        '[SECURITY_SETTINGS]'
    );

    get_security_settings_sample($formattedName);
}
// [END dialogflow_v3_generated_SecuritySettingsService_GetSecuritySettings_sync]
