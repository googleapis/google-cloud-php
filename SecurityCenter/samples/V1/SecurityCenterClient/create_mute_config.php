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

// [START securitycenter_v1_generated_SecurityCenter_CreateMuteConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenter\V1\MuteConfig;
use Google\Cloud\SecurityCenter\V1\SecurityCenterClient;

/**
 * Creates a mute config.
 *
 * @param string $formattedParent  Resource name of the new mute configs's parent. Its format is
 *                                 "organizations/[organization_id]", "folders/[folder_id]", or
 *                                 "projects/[project_id]". Please see
 *                                 {@see SecurityCenterClient::projectName()} for help formatting this field.
 * @param string $muteConfigFilter An expression that defines the filter to apply across
 *                                 create/update events of findings. While creating a filter string, be
 *                                 mindful of the scope in which the mute configuration is being created.
 *                                 E.g., If a filter contains project = X but is created under the project = Y
 *                                 scope, it might not match any findings.
 *
 *                                 The following field and operator combinations are supported:
 *
 *                                 * severity: `=`, `:`
 *                                 * category: `=`, `:`
 *                                 * resource.name: `=`, `:`
 *                                 * resource.project_name: `=`, `:`
 *                                 * resource.project_display_name: `=`, `:`
 *                                 * resource.folders.resource_folder: `=`, `:`
 *                                 * resource.parent_name: `=`, `:`
 *                                 * resource.parent_display_name: `=`, `:`
 *                                 * resource.type: `=`, `:`
 *                                 * finding_class: `=`, `:`
 *                                 * indicator.ip_addresses: `=`, `:`
 *                                 * indicator.domains: `=`, `:`
 * @param string $muteConfigId     Unique identifier provided by the client within the parent scope.
 *                                 It must consist of only lowercase letters, numbers, and hyphens, must start
 *                                 with a letter, must end with either a letter or a number, and must be 63
 *                                 characters or less.
 */
function create_mute_config_sample(
    string $formattedParent,
    string $muteConfigFilter,
    string $muteConfigId
): void {
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $muteConfig = (new MuteConfig())
        ->setFilter($muteConfigFilter);

    // Call the API and handle any network failures.
    try {
        /** @var MuteConfig $response */
        $response = $securityCenterClient->createMuteConfig($formattedParent, $muteConfig, $muteConfigId);
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
    $muteConfigFilter = '[FILTER]';
    $muteConfigId = '[MUTE_CONFIG_ID]';

    create_mute_config_sample($formattedParent, $muteConfigFilter, $muteConfigId);
}
// [END securitycenter_v1_generated_SecurityCenter_CreateMuteConfig_sync]
