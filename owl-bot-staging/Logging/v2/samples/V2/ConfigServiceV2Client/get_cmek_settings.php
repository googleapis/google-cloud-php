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

// [START logging_v2_generated_ConfigServiceV2_GetCmekSettings_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Logging\V2\CmekSettings;
use Google\Cloud\Logging\V2\ConfigServiceV2Client;

/**
 * Gets the Logging CMEK settings for the given resource.
 *
 * Note: CMEK for the Log Router can be configured for Google Cloud projects,
 * folders, organizations and billing accounts. Once configured for an
 * organization, it applies to all projects and folders in the Google Cloud
 * organization.
 *
 * See [Enabling CMEK for Log
 * Router](https://cloud.google.com/logging/docs/routing/managed-encryption)
 * for more information.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function get_cmek_settings_sample(): void
{
    // Create a client.
    $configServiceV2Client = new ConfigServiceV2Client();

    // Call the API and handle any network failures.
    try {
        /** @var CmekSettings $response */
        $response = $configServiceV2Client->getCmekSettings();
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END logging_v2_generated_ConfigServiceV2_GetCmekSettings_sync]
