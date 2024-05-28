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

// [START discoveryengine_v1beta_generated_ControlService_CreateControl_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1beta\Client\ControlServiceClient;
use Google\Cloud\DiscoveryEngine\V1beta\Control;
use Google\Cloud\DiscoveryEngine\V1beta\CreateControlRequest;
use Google\Cloud\DiscoveryEngine\V1beta\SolutionType;

/**
 * Creates a Control.
 *
 * By default 1000 controls are allowed for a data store.
 * A request can be submitted to adjust this limit.
 * If the [Control][google.cloud.discoveryengine.v1beta.Control] to create
 * already exists, an ALREADY_EXISTS error is returned.
 *
 * @param string $formattedParent     Full resource name of parent data store. Format:
 *                                    `projects/{project_number}/locations/{location_id}/collections/{collection_id}/dataStores/{data_store_id}`
 *                                    or
 *                                    `projects/{project_number}/locations/{location_id}/collections/{collection_id}/engines/{engine_id}`. Please see
 *                                    {@see ControlServiceClient::dataStoreName()} for help formatting this field.
 * @param string $controlDisplayName  Human readable name. The identifier used in UI views.
 *
 *                                    Must be UTF-8 encoded string. Length limit is 128 characters.
 *                                    Otherwise an INVALID ARGUMENT error is thrown.
 * @param int    $controlSolutionType Immutable. What solution the control belongs to.
 *
 *                                    Must be compatible with vertical of resource.
 *                                    Otherwise an INVALID ARGUMENT error is thrown.
 * @param string $controlId           The ID to use for the Control, which will become the final
 *                                    component of the Control's resource name.
 *
 *                                    This value must be within 1-63 characters.
 *                                    Valid characters are /[a-z][0-9]-_/.
 */
function create_control_sample(
    string $formattedParent,
    string $controlDisplayName,
    int $controlSolutionType,
    string $controlId
): void {
    // Create a client.
    $controlServiceClient = new ControlServiceClient();

    // Prepare the request message.
    $control = (new Control())
        ->setDisplayName($controlDisplayName)
        ->setSolutionType($controlSolutionType);
    $request = (new CreateControlRequest())
        ->setParent($formattedParent)
        ->setControl($control)
        ->setControlId($controlId);

    // Call the API and handle any network failures.
    try {
        /** @var Control $response */
        $response = $controlServiceClient->createControl($request);
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
    $formattedParent = ControlServiceClient::dataStoreName('[PROJECT]', '[LOCATION]', '[DATA_STORE]');
    $controlDisplayName = '[DISPLAY_NAME]';
    $controlSolutionType = SolutionType::SOLUTION_TYPE_UNSPECIFIED;
    $controlId = '[CONTROL_ID]';

    create_control_sample($formattedParent, $controlDisplayName, $controlSolutionType, $controlId);
}
// [END discoveryengine_v1beta_generated_ControlService_CreateControl_sync]
