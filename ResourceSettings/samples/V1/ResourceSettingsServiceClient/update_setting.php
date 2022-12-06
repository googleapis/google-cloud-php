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

// [START resourcesettings_v1_generated_ResourceSettingsService_UpdateSetting_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ResourceSettings\V1\ResourceSettingsServiceClient;
use Google\Cloud\ResourceSettings\V1\Setting;

/**
 * Updates a setting.
 *
 * Returns a `google.rpc.Status` with `google.rpc.Code.NOT_FOUND` if the
 * setting does not exist.
 * Returns a `google.rpc.Status` with `google.rpc.Code.FAILED_PRECONDITION` if
 * the setting is flagged as read only.
 * Returns a `google.rpc.Status` with `google.rpc.Code.ABORTED` if the etag
 * supplied in the request does not match the persisted etag of the setting
 * value.
 *
 * On success, the response will contain only `name`, `local_value` and
 * `etag`.  The `metadata` and `effective_value` cannot be updated through
 * this API.
 *
 * Note: the supplied setting will perform a full overwrite of the
 * `local_value` field.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_setting_sample(): void
{
    // Create a client.
    $resourceSettingsServiceClient = new ResourceSettingsServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $setting = new Setting();

    // Call the API and handle any network failures.
    try {
        /** @var Setting $response */
        $response = $resourceSettingsServiceClient->updateSetting($setting);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END resourcesettings_v1_generated_ResourceSettingsService_UpdateSetting_sync]
