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

// [START securitycentermanagement_v1_generated_SecurityCenterManagement_UpdateEventThreatDetectionCustomModule_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenterManagement\V1\Client\SecurityCenterManagementClient;
use Google\Cloud\SecurityCenterManagement\V1\EventThreatDetectionCustomModule;
use Google\Cloud\SecurityCenterManagement\V1\UpdateEventThreatDetectionCustomModuleRequest;
use Google\Protobuf\FieldMask;

/**
 * Updates an ETD custom module at the given level. All config fields can be
 * updated when updating the module at resident level. Only enablement state
 * can be updated when updating the module at inherited levels. Updating the
 * module has a side-effect that it updates all descendants that are inherited
 * from this module.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_event_threat_detection_custom_module_sample(): void
{
    // Create a client.
    $securityCenterManagementClient = new SecurityCenterManagementClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $eventThreatDetectionCustomModule = new EventThreatDetectionCustomModule();
    $request = (new UpdateEventThreatDetectionCustomModuleRequest())
        ->setUpdateMask($updateMask)
        ->setEventThreatDetectionCustomModule($eventThreatDetectionCustomModule);

    // Call the API and handle any network failures.
    try {
        /** @var EventThreatDetectionCustomModule $response */
        $response = $securityCenterManagementClient->updateEventThreatDetectionCustomModule($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END securitycentermanagement_v1_generated_SecurityCenterManagement_UpdateEventThreatDetectionCustomModule_sync]
