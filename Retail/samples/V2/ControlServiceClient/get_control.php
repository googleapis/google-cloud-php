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

// [START retail_v2_generated_ControlService_GetControl_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Retail\V2\Control;
use Google\Cloud\Retail\V2\ControlServiceClient;

/**
 * Gets a Control.
 *
 * @param string $formattedName The resource name of the Control to get. Format:
 *                              `projects/{project_number}/locations/{location_id}/catalogs/{catalog_id}/controls/{control_id}`
 *                              Please see {@see ControlServiceClient::controlName()} for help formatting this field.
 */
function get_control_sample(string $formattedName): void
{
    // Create a client.
    $controlServiceClient = new ControlServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var Control $response */
        $response = $controlServiceClient->getControl($formattedName);
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
    $formattedName = ControlServiceClient::controlName(
        '[PROJECT]',
        '[LOCATION]',
        '[CATALOG]',
        '[CONTROL]'
    );

    get_control_sample($formattedName);
}
// [END retail_v2_generated_ControlService_GetControl_sync]
