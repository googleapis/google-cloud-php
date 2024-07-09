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

// [START securitycenter_v1_generated_SecurityCenter_DeleteEventThreatDetectionCustomModule_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenter\V1\Client\SecurityCenterClient;
use Google\Cloud\SecurityCenter\V1\DeleteEventThreatDetectionCustomModuleRequest;

/**
 * Deletes the specified Event Threat Detection custom module and all of its
 * descendants in the Resource Manager hierarchy. This method is only
 * supported for resident custom modules.
 *
 * @param string $formattedName Name of the custom module to delete.
 *
 *                              Its format is:
 *
 *                              * "organizations/{organization}/eventThreatDetectionSettings/customModules/{module}".
 *                              * "folders/{folder}/eventThreatDetectionSettings/customModules/{module}".
 *                              * "projects/{project}/eventThreatDetectionSettings/customModules/{module}". Please see
 *                              {@see SecurityCenterClient::eventThreatDetectionCustomModuleName()} for help formatting this field.
 */
function delete_event_threat_detection_custom_module_sample(string $formattedName): void
{
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Prepare the request message.
    $request = (new DeleteEventThreatDetectionCustomModuleRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $securityCenterClient->deleteEventThreatDetectionCustomModule($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = SecurityCenterClient::eventThreatDetectionCustomModuleName(
        '[ORGANIZATION]',
        '[MODULE]'
    );

    delete_event_threat_detection_custom_module_sample($formattedName);
}
// [END securitycenter_v1_generated_SecurityCenter_DeleteEventThreatDetectionCustomModule_sync]
