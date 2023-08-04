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

// [START policysimulator_v1_generated_Simulator_CreateReplay_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\PolicySimulator\V1\Client\SimulatorClient;
use Google\Cloud\PolicySimulator\V1\CreateReplayRequest;
use Google\Cloud\PolicySimulator\V1\Replay;
use Google\Cloud\PolicySimulator\V1\ReplayConfig;
use Google\Rpc\Status;

/**
 * Creates and starts a [Replay][google.cloud.policysimulator.v1.Replay] using
 * the given [ReplayConfig][google.cloud.policysimulator.v1.ReplayConfig].
 *
 * @param string $parent The parent resource where this
 *                       [Replay][google.cloud.policysimulator.v1.Replay] will be created. This
 *                       resource must be a project, folder, or organization with a location.
 *
 *                       Example: `projects/my-example-project/locations/global`
 */
function create_replay_sample(string $parent): void
{
    // Create a client.
    $simulatorClient = new SimulatorClient();

    // Prepare the request message.
    $replayConfig = new ReplayConfig();
    $replay = (new Replay())
        ->setConfig($replayConfig);
    $request = (new CreateReplayRequest())
        ->setParent($parent)
        ->setReplay($replay);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $simulatorClient->createReplay($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Replay $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $parent = '[PARENT]';

    create_replay_sample($parent);
}
// [END policysimulator_v1_generated_Simulator_CreateReplay_sync]
