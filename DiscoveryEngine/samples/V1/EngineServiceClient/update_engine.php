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

// [START discoveryengine_v1_generated_EngineService_UpdateEngine_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\EngineServiceClient;
use Google\Cloud\DiscoveryEngine\V1\Engine;
use Google\Cloud\DiscoveryEngine\V1\SolutionType;
use Google\Cloud\DiscoveryEngine\V1\UpdateEngineRequest;

/**
 * Updates an [Engine][google.cloud.discoveryengine.v1.Engine]
 *
 * @param string $engineDisplayName  The display name of the engine. Should be human readable. UTF-8
 *                                   encoded string with limit of 1024 characters.
 * @param int    $engineSolutionType The solutions of the engine.
 */
function update_engine_sample(string $engineDisplayName, int $engineSolutionType): void
{
    // Create a client.
    $engineServiceClient = new EngineServiceClient();

    // Prepare the request message.
    $engine = (new Engine())
        ->setDisplayName($engineDisplayName)
        ->setSolutionType($engineSolutionType);
    $request = (new UpdateEngineRequest())
        ->setEngine($engine);

    // Call the API and handle any network failures.
    try {
        /** @var Engine $response */
        $response = $engineServiceClient->updateEngine($request);
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
    $engineDisplayName = '[DISPLAY_NAME]';
    $engineSolutionType = SolutionType::SOLUTION_TYPE_UNSPECIFIED;

    update_engine_sample($engineDisplayName, $engineSolutionType);
}
// [END discoveryengine_v1_generated_EngineService_UpdateEngine_sync]
