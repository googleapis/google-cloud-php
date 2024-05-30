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

// [START securitycenter_v2_generated_SecurityCenter_CreateNotificationConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenter\V2\Client\SecurityCenterClient;
use Google\Cloud\SecurityCenter\V2\CreateNotificationConfigRequest;
use Google\Cloud\SecurityCenter\V2\NotificationConfig;

/**
 * Creates a notification config.
 *
 * @param string $formattedParent Resource name of the new notification config's parent. Its format
 *                                is "organizations/[organization_id]/locations/[location_id]",
 *                                "folders/[folder_id]/locations/[location_id]", or
 *                                "projects/[project_id]/locations/[location_id]". Please see
 *                                {@see SecurityCenterClient::organizationLocationName()} for help formatting this field.
 * @param string $configId        Required.
 *                                Unique identifier provided by the client within the parent scope.
 *                                It must be between 1 and 128 characters and contain alphanumeric
 *                                characters, underscores, or hyphens only.
 */
function create_notification_config_sample(string $formattedParent, string $configId): void
{
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Prepare the request message.
    $notificationConfig = new NotificationConfig();
    $request = (new CreateNotificationConfigRequest())
        ->setParent($formattedParent)
        ->setConfigId($configId)
        ->setNotificationConfig($notificationConfig);

    // Call the API and handle any network failures.
    try {
        /** @var NotificationConfig $response */
        $response = $securityCenterClient->createNotificationConfig($request);
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
    $formattedParent = SecurityCenterClient::organizationLocationName('[ORGANIZATION]', '[LOCATION]');
    $configId = '[CONFIG_ID]';

    create_notification_config_sample($formattedParent, $configId);
}
// [END securitycenter_v2_generated_SecurityCenter_CreateNotificationConfig_sync]
