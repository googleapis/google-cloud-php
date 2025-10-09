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

// [START securitycenter_v1_generated_SecurityCenter_ValidateEventThreatDetectionCustomModule_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenter\V1\Client\SecurityCenterClient;
use Google\Cloud\SecurityCenter\V1\ValidateEventThreatDetectionCustomModuleRequest;
use Google\Cloud\SecurityCenter\V1\ValidateEventThreatDetectionCustomModuleResponse;

/**
 * Validates the given Event Threat Detection custom module.
 *
 * @param string $formattedParent Resource name of the parent to validate the Custom Module under.
 *
 *                                Its format is:
 *
 *                                * `organizations/{organization}/eventThreatDetectionSettings`.
 *                                * `folders/{folder}/eventThreatDetectionSettings`.
 *                                * `projects/{project}/eventThreatDetectionSettings`. Please see
 *                                {@see SecurityCenterClient::eventThreatDetectionSettingsName()} for help formatting this field.
 * @param string $rawText         The raw text of the module's contents. Used to generate error
 *                                messages.
 * @param string $type            The type of the module (e.g. CONFIGURABLE_BAD_IP).
 */
function validate_event_threat_detection_custom_module_sample(
    string $formattedParent,
    string $rawText,
    string $type
): void {
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Prepare the request message.
    $request = (new ValidateEventThreatDetectionCustomModuleRequest())
        ->setParent($formattedParent)
        ->setRawText($rawText)
        ->setType($type);

    // Call the API and handle any network failures.
    try {
        /** @var ValidateEventThreatDetectionCustomModuleResponse $response */
        $response = $securityCenterClient->validateEventThreatDetectionCustomModule($request);
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
    $formattedParent = SecurityCenterClient::eventThreatDetectionSettingsName('[ORGANIZATION]');
    $rawText = '[RAW_TEXT]';
    $type = '[TYPE]';

    validate_event_threat_detection_custom_module_sample($formattedParent, $rawText, $type);
}
// [END securitycenter_v1_generated_SecurityCenter_ValidateEventThreatDetectionCustomModule_sync]
