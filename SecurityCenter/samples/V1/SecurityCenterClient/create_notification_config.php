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

// [START securitycenter_v1_generated_SecurityCenter_CreateNotificationConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenter\V1\NotificationConfig;
use Google\Cloud\SecurityCenter\V1\SecurityCenterClient;

/**
 * Creates a notification config.
 *
 * @param string $formattedParent Resource name of the new notification config's parent. Its format
 *                                is "organizations/[organization_id]", "folders/[folder_id]", or
 *                                "projects/[project_id]". Please see
 *                                {@see SecurityCenterClient::projectName()} for help formatting this field.
 * @param string $configId        Required.
 *                                Unique identifier provided by the client within the parent scope.
 *                                It must be between 1 and 128 characters, and contains alphanumeric
 *                                characters, underscores or hyphens only.
 */
function create_notification_config_sample(string $formattedParent, string $configId): void
{
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $notificationConfig = new NotificationConfig();

    // Call the API and handle any network failures.
    try {
        /** @var NotificationConfig $response */
        $response = $securityCenterClient->createNotificationConfig(
            $formattedParent,
            $configId,
            $notificationConfig
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
    $formattedParent = SecurityCenterClient::projectName('[PROJECT]');
    $configId = '[CONFIG_ID]';

    create_notification_config_sample($formattedParent, $configId);
}
// [END securitycenter_v1_generated_SecurityCenter_CreateNotificationConfig_sync]
