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

// [START logging_v2_generated_ConfigServiceV2_GetSettings_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Logging\V2\ConfigServiceV2Client;
use Google\Cloud\Logging\V2\Settings;

/**
 * Gets the Log Router settings for the given resource.
 *
 * Note: Settings for the Log Router can be get for Google Cloud projects,
 * folders, organizations and billing accounts. Currently it can only be
 * configured for organizations. Once configured for an organization, it
 * applies to all projects and folders in the Google Cloud organization.
 *
 * See [Enabling CMEK for Log
 * Router](https://cloud.google.com/logging/docs/routing/managed-encryption)
 * for more information.
 *
 * @param string $formattedName The resource for which to retrieve settings.
 *
 *                              "projects/[PROJECT_ID]/settings"
 *                              "organizations/[ORGANIZATION_ID]/settings"
 *                              "billingAccounts/[BILLING_ACCOUNT_ID]/settings"
 *                              "folders/[FOLDER_ID]/settings"
 *
 *                              For example:
 *
 *                              `"organizations/12345/settings"`
 *
 *                              Note: Settings for the Log Router can be get for Google Cloud projects,
 *                              folders, organizations and billing accounts. Currently it can only be
 *                              configured for organizations. Once configured for an organization, it
 *                              applies to all projects and folders in the Google Cloud organization. Please see
 *                              {@see ConfigServiceV2Client::settingsName()} for help formatting this field.
 */
function get_settings_sample(string $formattedName): void
{
    // Create a client.
    $configServiceV2Client = new ConfigServiceV2Client();

    // Call the API and handle any network failures.
    try {
        /** @var Settings $response */
        $response = $configServiceV2Client->getSettings($formattedName);
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
    $formattedName = ConfigServiceV2Client::settingsName('[PROJECT]');

    get_settings_sample($formattedName);
}
// [END logging_v2_generated_ConfigServiceV2_GetSettings_sync]
