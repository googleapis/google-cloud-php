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

// [START logging_v2_generated_ConfigServiceV2_UpdateSettings_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Logging\V2\ConfigServiceV2Client;
use Google\Cloud\Logging\V2\Settings;

/**
 * Updates the Log Router settings for the given resource.
 *
 * Note: Settings for the Log Router can currently only be configured for
 * Google Cloud organizations. Once configured, it applies to all projects and
 * folders in the Google Cloud organization.
 *
 * [UpdateSettings][google.logging.v2.ConfigServiceV2.UpdateSettings]
 * will fail if 1) `kms_key_name` is invalid, or 2) the associated service
 * account does not have the required
 * `roles/cloudkms.cryptoKeyEncrypterDecrypter` role assigned for the key, or
 * 3) access to the key is disabled. 4) `location_id` is not supported by
 * Logging. 5) `location_id` violate OrgPolicy.
 *
 * See [Enabling CMEK for Log
 * Router](https://cloud.google.com/logging/docs/routing/managed-encryption)
 * for more information.
 *
 * @param string $name The resource name for the settings to update.
 *
 *                     "organizations/[ORGANIZATION_ID]/settings"
 *
 *                     For example:
 *
 *                     `"organizations/12345/settings"`
 *
 *                     Note: Settings for the Log Router can currently only be configured for
 *                     Google Cloud organizations. Once configured, it applies to all projects and
 *                     folders in the Google Cloud organization.
 */
function update_settings_sample(string $name): void
{
    // Create a client.
    $configServiceV2Client = new ConfigServiceV2Client();

    // Prepare any non-scalar elements to be passed along with the request.
    $settings = new Settings();

    // Call the API and handle any network failures.
    try {
        /** @var Settings $response */
        $response = $configServiceV2Client->updateSettings($name, $settings);
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
    $name = '[NAME]';

    update_settings_sample($name);
}
// [END logging_v2_generated_ConfigServiceV2_UpdateSettings_sync]
