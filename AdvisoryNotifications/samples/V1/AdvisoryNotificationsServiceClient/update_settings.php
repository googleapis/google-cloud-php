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

// [START advisorynotifications_v1_generated_AdvisoryNotificationsService_UpdateSettings_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AdvisoryNotifications\V1\Client\AdvisoryNotificationsServiceClient;
use Google\Cloud\AdvisoryNotifications\V1\Settings;
use Google\Cloud\AdvisoryNotifications\V1\UpdateSettingsRequest;

/**
 * Update notification settings.
 *
 * @param string $settingsEtag Fingerprint for optimistic concurrency returned in Get requests.
 *                             Must be provided for Update requests. If the value provided does not match
 *                             the value known to the server, ABORTED will be thrown, and the client
 *                             should retry the read-modify-write cycle.
 */
function update_settings_sample(string $settingsEtag): void
{
    // Create a client.
    $advisoryNotificationsServiceClient = new AdvisoryNotificationsServiceClient();

    // Prepare the request message.
    $settingsNotificationSettings = [];
    $settings = (new Settings())
        ->setNotificationSettings($settingsNotificationSettings)
        ->setEtag($settingsEtag);
    $request = (new UpdateSettingsRequest())
        ->setSettings($settings);

    // Call the API and handle any network failures.
    try {
        /** @var Settings $response */
        $response = $advisoryNotificationsServiceClient->updateSettings($request);
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
    $settingsEtag = '[ETAG]';

    update_settings_sample($settingsEtag);
}
// [END advisorynotifications_v1_generated_AdvisoryNotificationsService_UpdateSettings_sync]
