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
 * Gets the effective Event Threat Detection custom module at the given level.
 *
 * The difference between an
 * [EffectiveEventThreatDetectionCustomModule][google.cloud.securitycentermanagement.v1.EffectiveEventThreatDetectionCustomModule]
 * and an
 * [EventThreatDetectionCustomModule][google.cloud.securitycentermanagement.v1.EventThreatDetectionCustomModule]
 * is that the fields for an `EffectiveEventThreatDetectionCustomModule` are
 * computed from ancestors if needed. For example, the enablement state for an
 * `EventThreatDetectionCustomModule` can be `ENABLED`, `DISABLED`, or
 * `INHERITED`. In contrast, the enablement state for an
 * `EffectiveEventThreatDetectionCustomModule` is always computed as `ENABLED`
 * or `DISABLED`.
 *
 * @param string $formattedName The resource name of the Event Threat Detection custom module, in
 *                              one of the following formats:
 *
 *                              * `organizations/{organization}/locations/{location}/effectiveEventThreatDetectionCustomModules/{custom_module}`
 *                              * `folders/{folder}/locations/{location}/effectiveEventThreatDetectionCustomModules/{custom_module}`
 *                              * `projects/{project}/locations/{location}/effectiveEventThreatDetectionCustomModules/{custom_module}`
 *                              Please see {@see SecurityCenterManagementClient::effectiveEventThreatDetectionCustomModuleName()} for help formatting this field.
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
