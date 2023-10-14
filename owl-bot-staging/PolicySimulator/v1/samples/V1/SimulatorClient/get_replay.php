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

// [START policysimulator_v1_generated_Simulator_GetReplay_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\PolicySimulator\V1\Client\SimulatorClient;
use Google\Cloud\PolicySimulator\V1\GetReplayRequest;
use Google\Cloud\PolicySimulator\V1\Replay;

/**
 * Gets the specified [Replay][google.cloud.policysimulator.v1.Replay]. Each
 * `Replay` is available for at least 7 days.
 *
 * @param string $formattedName The name of the [Replay][google.cloud.policysimulator.v1.Replay]
 *                              to retrieve, in the following format:
 *
 *                              `{projects|folders|organizations}/{resource-id}/locations/global/replays/{replay-id}`,
 *                              where `{resource-id}` is the ID of the project, folder, or organization
 *                              that owns the `Replay`.
 *
 *                              Example:
 *                              `projects/my-example-project/locations/global/replays/506a5f7f-38ce-4d7d-8e03-479ce1833c36`
 *                              Please see {@see SimulatorClient::replayName()} for help formatting this field.
 */
function get_replay_sample(string $formattedName): void
{
    // Create a client.
    $simulatorClient = new SimulatorClient();

    // Prepare the request message.
    $request = (new GetReplayRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Replay $response */
        $response = $simulatorClient->getReplay($request);
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
    $formattedName = SimulatorClient::replayName('[PROJECT]', '[LOCATION]', '[REPLAY]');

    get_replay_sample($formattedName);
}
// [END policysimulator_v1_generated_Simulator_GetReplay_sync]
