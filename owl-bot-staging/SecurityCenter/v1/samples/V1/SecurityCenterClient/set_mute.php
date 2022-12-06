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

// [START securitycenter_v1_generated_SecurityCenter_SetMute_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenter\V1\Finding;
use Google\Cloud\SecurityCenter\V1\Finding\Mute;
use Google\Cloud\SecurityCenter\V1\SecurityCenterClient;

/**
 * Updates the mute state of a finding.
 *
 * @param string $formattedName The [relative resource
 *                              name](https://cloud.google.com/apis/design/resource_names#relative_resource_name)
 *                              of the finding. Example:
 *                              "organizations/{organization_id}/sources/{source_id}/findings/{finding_id}",
 *                              "folders/{folder_id}/sources/{source_id}/findings/{finding_id}",
 *                              "projects/{project_id}/sources/{source_id}/findings/{finding_id}". Please see
 *                              {@see SecurityCenterClient::findingName()} for help formatting this field.
 * @param int    $mute          The desired state of the Mute.
 */
function set_mute_sample(string $formattedName, int $mute): void
{
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Call the API and handle any network failures.
    try {
        /** @var Finding $response */
        $response = $securityCenterClient->setMute($formattedName, $mute);
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
    $formattedName = SecurityCenterClient::findingName('[ORGANIZATION]', '[SOURCE]', '[FINDING]');
    $mute = Mute::MUTE_UNSPECIFIED;

    set_mute_sample($formattedName, $mute);
}
// [END securitycenter_v1_generated_SecurityCenter_SetMute_sync]
