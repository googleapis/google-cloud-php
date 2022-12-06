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

// [START resourcesettings_v1_generated_ResourceSettingsService_GetSetting_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ResourceSettings\V1\ResourceSettingsServiceClient;
use Google\Cloud\ResourceSettings\V1\Setting;

/**
 * Gets a setting.
 *
 * Returns a `google.rpc.Status` with `google.rpc.Code.NOT_FOUND` if the
 * setting does not exist.
 *
 * @param string $formattedName The name of the setting to get. See [Setting][google.cloud.resourcesettings.v1.Setting] for naming
 *                              requirements. Please see
 *                              {@see ResourceSettingsServiceClient::settingName()} for help formatting this field.
 */
function get_setting_sample(string $formattedName): void
{
    // Create a client.
    $resourceSettingsServiceClient = new ResourceSettingsServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var Setting $response */
        $response = $resourceSettingsServiceClient->getSetting($formattedName);
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
    $formattedName = ResourceSettingsServiceClient::settingName('[PROJECT_NUMBER]', '[SETTING_NAME]');

    get_setting_sample($formattedName);
}
// [END resourcesettings_v1_generated_ResourceSettingsService_GetSetting_sync]
