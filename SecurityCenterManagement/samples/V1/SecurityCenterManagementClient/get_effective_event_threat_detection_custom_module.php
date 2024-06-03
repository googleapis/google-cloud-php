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

// [START securitycentermanagement_v1_generated_SecurityCenterManagement_GetEffectiveEventThreatDetectionCustomModule_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenterManagement\V1\Client\SecurityCenterManagementClient;
use Google\Cloud\SecurityCenterManagement\V1\EffectiveEventThreatDetectionCustomModule;
use Google\Cloud\SecurityCenterManagement\V1\GetEffectiveEventThreatDetectionCustomModuleRequest;

/**
 * Gets an effective ETD custom module. Retrieves the effective module at the
 * given level. The difference between an EffectiveCustomModule and a
 * CustomModule is that the fields for an EffectiveCustomModule are computed
 * from ancestors if needed. For example, the enablement_state for a
 * CustomModule can be either ENABLED, DISABLED, or INHERITED. Where as the
 * enablement_state for an EffectiveCustomModule is always computed to ENABLED
 * or DISABLED (the effective enablement_state).
 *
 * @param string $formattedName The resource name of the ETD custom module.
 *
 *                              Its format is:
 *
 *                              * `organizations/{organization}/locations/{location}/effectiveEventThreatDetectionCustomModules/{effective_event_threat_detection_custom_module}`.
 *                              * `folders/{folder}/locations/{location}/effectiveEventThreatDetectionCustomModules/{effective_event_threat_detection_custom_module}`.
 *                              * `projects/{project}/locations/{location}/effectiveEventThreatDetectionCustomModules/{effective_event_threat_detection_custom_module}`. Please see
 *                              {@see SecurityCenterManagementClient::effectiveEventThreatDetectionCustomModuleName()} for help formatting this field.
 */
function get_effective_event_threat_detection_custom_module_sample(string $formattedName): void
{
    // Create a client.
    $securityCenterManagementClient = new SecurityCenterManagementClient();

    // Prepare the request message.
    $request = (new GetEffectiveEventThreatDetectionCustomModuleRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var EffectiveEventThreatDetectionCustomModule $response */
        $response = $securityCenterManagementClient->getEffectiveEventThreatDetectionCustomModule($request);
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
    $formattedName = SecurityCenterManagementClient::effectiveEventThreatDetectionCustomModuleName(
        '[ORGANIZATION]',
        '[LOCATION]',
        '[EFFECTIVE_EVENT_THREAT_DETECTION_CUSTOM_MODULE]'
    );

    get_effective_event_threat_detection_custom_module_sample($formattedName);
}
// [END securitycentermanagement_v1_generated_SecurityCenterManagement_GetEffectiveEventThreatDetectionCustomModule_sync]
