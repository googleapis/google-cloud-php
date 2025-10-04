<?php
/*
 * Copyright 2025 Google LLC
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

// [START cloudsecuritycompliance_v1_generated_Config_CreateFramework_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\CloudSecurityCompliance\V1\Client\ConfigClient;
use Google\Cloud\CloudSecurityCompliance\V1\CreateFrameworkRequest;
use Google\Cloud\CloudSecurityCompliance\V1\Framework;

/**
 * Creates a new Framework with type `Custom` under a given parent resource.
 * Frameworks with type `Built-in` are managed by Google and cannot be created
 * through this API.
 *
 * @param string $formattedParent The parent resource name, in the format
 *                                `organizations/{organization}/locations/{location}`. Please see
 *                                {@see ConfigClient::organizationLocationName()} for help formatting this field.
 * @param string $frameworkId     ID of the framework.
 *                                This is not the full name of the framework.
 *                                This is the last part of the full name of the framework.
 * @param string $frameworkName   Identifier. The name of the framework.
 *                                Format:
 *                                organizations/{organization}/locations/{location}/frameworks/{framework_id}
 */
function create_framework_sample(
    string $formattedParent,
    string $frameworkId,
    string $frameworkName
): void {
    // Create a client.
    $configClient = new ConfigClient();

    // Prepare the request message.
    $framework = (new Framework())
        ->setName($frameworkName);
    $request = (new CreateFrameworkRequest())
        ->setParent($formattedParent)
        ->setFrameworkId($frameworkId)
        ->setFramework($framework);

    // Call the API and handle any network failures.
    try {
        /** @var Framework $response */
        $response = $configClient->createFramework($request);
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
    $formattedParent = ConfigClient::organizationLocationName('[ORGANIZATION]', '[LOCATION]');
    $frameworkId = '[FRAMEWORK_ID]';
    $frameworkName = '[NAME]';

    create_framework_sample($formattedParent, $frameworkId, $frameworkName);
}
// [END cloudsecuritycompliance_v1_generated_Config_CreateFramework_sync]
