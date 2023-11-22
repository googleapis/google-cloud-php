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

// [START telcoautomation_v1_generated_TelcoAutomation_CreateBlueprint_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\TelcoAutomation\V1\Blueprint;
use Google\Cloud\TelcoAutomation\V1\Client\TelcoAutomationClient;
use Google\Cloud\TelcoAutomation\V1\CreateBlueprintRequest;

/**
 * Creates a blueprint.
 *
 * @param string $formattedParent          The name of parent resource.
 *                                         Format should be -
 *                                         "projects/{project_id}/locations/{location_name}/orchestrationClusters/{orchestration_cluster}". Please see
 *                                         {@see TelcoAutomationClient::orchestrationClusterName()} for help formatting this field.
 * @param string $blueprintSourceBlueprint Immutable. The public blueprint ID from which this blueprint was
 *                                         created.
 */
function create_blueprint_sample(string $formattedParent, string $blueprintSourceBlueprint): void
{
    // Create a client.
    $telcoAutomationClient = new TelcoAutomationClient();

    // Prepare the request message.
    $blueprint = (new Blueprint())
        ->setSourceBlueprint($blueprintSourceBlueprint);
    $request = (new CreateBlueprintRequest())
        ->setParent($formattedParent)
        ->setBlueprint($blueprint);

    // Call the API and handle any network failures.
    try {
        /** @var Blueprint $response */
        $response = $telcoAutomationClient->createBlueprint($request);
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
    $formattedParent = TelcoAutomationClient::orchestrationClusterName(
        '[PROJECT]',
        '[LOCATION]',
        '[ORCHESTRATION_CLUSTER]'
    );
    $blueprintSourceBlueprint = '[SOURCE_BLUEPRINT]';

    create_blueprint_sample($formattedParent, $blueprintSourceBlueprint);
}
// [END telcoautomation_v1_generated_TelcoAutomation_CreateBlueprint_sync]
