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

// [START securitycenter_v1p1beta1_generated_SecurityCenter_SetFindingState_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenter\V1p1beta1\Finding;
use Google\Cloud\SecurityCenter\V1p1beta1\Finding\State;
use Google\Cloud\SecurityCenter\V1p1beta1\SecurityCenterClient;
use Google\Protobuf\Timestamp;

/**
 * Updates the state of a finding.
 *
 * @param string $formattedName The relative resource name of the finding. See:
 *                              https://cloud.google.com/apis/design/resource_names#relative_resource_name
 *                              Example:
 *                              "organizations/{organization_id}/sources/{source_id}/finding/{finding_id}". Please see
 *                              {@see SecurityCenterClient::findingName()} for help formatting this field.
 * @param int    $state         The desired State of the finding.
 */
function set_finding_state_sample(string $formattedName, int $state): void
{
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Prepare the request message.
    $startTime = new Timestamp();

    // Call the API and handle any network failures.
    try {
        /** @var Finding $response */
        $response = $securityCenterClient->setFindingState($formattedName, $state, $startTime);
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
    $state = State::STATE_UNSPECIFIED;

    set_finding_state_sample($formattedName, $state);
}
// [END securitycenter_v1p1beta1_generated_SecurityCenter_SetFindingState_sync]
