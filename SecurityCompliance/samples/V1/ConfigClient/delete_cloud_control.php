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

// [START cloudsecuritycompliance_v1_generated_Config_DeleteCloudControl_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\CloudSecurityCompliance\V1\Client\ConfigClient;
use Google\Cloud\CloudSecurityCompliance\V1\DeleteCloudControlRequest;

/**
 * Deletes a single Custom CloudControl, including all its
 * major and minor revisions.
 *
 * - This operation can only be performed on CloudControls with type `CUSTOM`.
 * Built-in CloudControls cannot be deleted.
 * - The CloudControl cannot be deleted if any of its revisions are currently
 * referenced by any Framework.
 * - This action is permanent and cannot be undone.
 *
 * @param string $formattedName Name of the resource, in the format
 *                              `organizations/{organization}/locations/{location}/CloudControls/{CloudControl}`. Please see
 *                              {@see ConfigClient::cloudControlName()} for help formatting this field.
 */
function delete_cloud_control_sample(string $formattedName): void
{
    // Create a client.
    $configClient = new ConfigClient();

    // Prepare the request message.
    $request = (new DeleteCloudControlRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $configClient->deleteCloudControl($request);
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
    $formattedName = ConfigClient::cloudControlName('[ORGANIZATION]', '[LOCATION]', '[CLOUD_CONTROL]');

    delete_cloud_control_sample($formattedName);
}
// [END cloudsecuritycompliance_v1_generated_Config_DeleteCloudControl_sync]
