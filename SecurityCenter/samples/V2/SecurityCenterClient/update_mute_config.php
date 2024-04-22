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

// [START securitycenter_v2_generated_SecurityCenter_UpdateMuteConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenter\V2\Client\SecurityCenterClient;
use Google\Cloud\SecurityCenter\V2\MuteConfig;
use Google\Cloud\SecurityCenter\V2\MuteConfig\MuteConfigType;
use Google\Cloud\SecurityCenter\V2\UpdateMuteConfigRequest;

/**
 * Updates a mute config. If no location is specified, default is
 * global.
 *
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
 * @param int    $muteConfigType   The type of the mute config, which determines what type of mute
 *                                 state the config affects. Immutable after creation.
 */
function update_mute_config_sample(string $muteConfigFilter, int $muteConfigType): void
{
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Prepare the request message.
    $muteConfig = (new MuteConfig())
        ->setFilter($muteConfigFilter)
        ->setType($muteConfigType);
    $request = (new UpdateMuteConfigRequest())
        ->setMuteConfig($muteConfig);

    // Call the API and handle any network failures.
    try {
        /** @var MuteConfig $response */
        $response = $securityCenterClient->updateMuteConfig($request);
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
    $muteConfigFilter = '[FILTER]';
    $muteConfigType = MuteConfigType::MUTE_CONFIG_TYPE_UNSPECIFIED;

    update_mute_config_sample($muteConfigFilter, $muteConfigType);
}
// [END securitycenter_v2_generated_SecurityCenter_UpdateMuteConfig_sync]
