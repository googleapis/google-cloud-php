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

// [START gdchardwaremanagement_v1alpha_generated_GDCHardwareManagement_ListHardwareGroups_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\GdcHardwareManagement\V1alpha\Client\GDCHardwareManagementClient;
use Google\Cloud\GdcHardwareManagement\V1alpha\HardwareGroup;
use Google\Cloud\GdcHardwareManagement\V1alpha\ListHardwareGroupsRequest;

/**
 * Lists hardware groups in a given order.
 *
 * @param string $formattedParent The order to list hardware groups in.
 *                                Format: `projects/{project}/locations/{location}/orders/{order}`
 *                                Please see {@see GDCHardwareManagementClient::orderName()} for help formatting this field.
 */
function list_hardware_groups_sample(string $formattedParent): void
{
    // Create a client.
    $gDCHardwareManagementClient = new GDCHardwareManagementClient();

    // Prepare the request message.
    $request = (new ListHardwareGroupsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $gDCHardwareManagementClient->listHardwareGroups($request);

        /** @var HardwareGroup $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
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
    $formattedParent = GDCHardwareManagementClient::orderName('[PROJECT]', '[LOCATION]', '[ORDER]');

    list_hardware_groups_sample($formattedParent);
}
// [END gdchardwaremanagement_v1alpha_generated_GDCHardwareManagement_ListHardwareGroups_sync]
