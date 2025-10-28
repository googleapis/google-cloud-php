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

// [START cloudsecuritycompliance_v1_generated_Config_UpdateCloudControl_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\CloudSecurityCompliance\V1\Client\ConfigClient;
use Google\Cloud\CloudSecurityCompliance\V1\CloudControl;
use Google\Cloud\CloudSecurityCompliance\V1\UpdateCloudControlRequest;

/**
 * Updates a custom cloud control.
 * This method allows for partial updates of a cloud control. Use the
 * `update_mask` to specify which fields to update. Consider the following:
 *
 * - If you provide an `update_mask`, only the fields that are specified
 * in the mask are updated.
 * - If you don't provide an `update_mask`, all the fields that are present
 * in the request's `cloud_control` body are used to overwrite the existing
 * resource.
 *
 * You can only update cloud controls with the `CUSTOM` type.
 * A successful update creates a new version of the cloud control.
 *
 * @param string $cloudControlName Identifier. The name of the cloud control, in the format
 *                                 `organizations/{organization}/locations/{location}/cloudControls/{cloud_control_id}`.
 *                                 The only supported location is `global`.
 */
function update_cloud_control_sample(string $cloudControlName): void
{
    // Create a client.
    $configClient = new ConfigClient();

    // Prepare the request message.
    $cloudControl = (new CloudControl())
        ->setName($cloudControlName);
    $request = (new UpdateCloudControlRequest())
        ->setCloudControl($cloudControl);

    // Call the API and handle any network failures.
    try {
        /** @var CloudControl $response */
        $response = $configClient->updateCloudControl($request);
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
    $cloudControlName = '[NAME]';

    update_cloud_control_sample($cloudControlName);
}
// [END cloudsecuritycompliance_v1_generated_Config_UpdateCloudControl_sync]
