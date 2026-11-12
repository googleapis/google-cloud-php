<?php
/*
 * Copyright 2026 Google LLC
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

// [START observability_v1_generated_Observability_GetSettings_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Observability\V1\Client\ObservabilityClient;
use Google\Cloud\Observability\V1\GetSettingsRequest;
use Google\Cloud\Observability\V1\Settings;

/**
 * Get Settings
 *
 * @param string $formattedName Name of the settings to retrieve.
 *
 *                              Name format:
 *
 *                              "projects/[PROJECT_ID]/locations/[LOCATION]/settings"
 *                              "folders/[FOLDER_ID]/locations/[LOCATION]/settings"
 *                              "organizations/[ORGANIZATION_ID]/locations/[LOCATION]/settings"
 *                              Please see {@see ObservabilityClient::settingsName()} for help formatting this field.
 */
function get_settings_sample(string $formattedName): void
{
    // Create a client.
    $observabilityClient = new ObservabilityClient();

    // Prepare the request message.
    $request = (new GetSettingsRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Settings $response */
        $response = $observabilityClient->getSettings($request);
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
    $formattedName = ObservabilityClient::settingsName('[PROJECT]', '[LOCATION]');

    get_settings_sample($formattedName);
}
// [END observability_v1_generated_Observability_GetSettings_sync]
