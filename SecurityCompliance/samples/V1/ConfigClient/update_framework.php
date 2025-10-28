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

// [START cloudsecuritycompliance_v1_generated_Config_UpdateFramework_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\CloudSecurityCompliance\V1\Client\ConfigClient;
use Google\Cloud\CloudSecurityCompliance\V1\Framework;
use Google\Cloud\CloudSecurityCompliance\V1\UpdateFrameworkRequest;

/**
 * Updates a custom framework.
 * This method allows for partial updates of a framework. Use the
 * `update_mask` to specify which fields to update. Consider the following:
 *
 * - If you provide an `update_mask`, only the fields that are specified
 * in the mask are updated.
 * - If you don't provide an `update_mask`, all the fields that are present
 * in the request's `framework` body are used to overwrite the existing
 * resource.
 *
 * You can only update frameworks with the `CUSTOM` type.
 * A successful update creates a new version of the framework.
 *
 * @param string $frameworkName Identifier. The name of the framework, in the format
 *                              `organizations/{organization}/locations/{location}/frameworks/{framework_id}`.
 *                              The only supported location is `global`.
 */
function update_framework_sample(string $frameworkName): void
{
    // Create a client.
    $configClient = new ConfigClient();

    // Prepare the request message.
    $framework = (new Framework())
        ->setName($frameworkName);
    $request = (new UpdateFrameworkRequest())
        ->setFramework($framework);

    // Call the API and handle any network failures.
    try {
        /** @var Framework $response */
        $response = $configClient->updateFramework($request);
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
    $frameworkName = '[NAME]';

    update_framework_sample($frameworkName);
}
// [END cloudsecuritycompliance_v1_generated_Config_UpdateFramework_sync]
