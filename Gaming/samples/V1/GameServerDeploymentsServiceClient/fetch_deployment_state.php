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

// [START gameservices_v1_generated_GameServerDeploymentsService_FetchDeploymentState_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Gaming\V1\FetchDeploymentStateResponse;
use Google\Cloud\Gaming\V1\GameServerDeploymentsServiceClient;

/**
 * Retrieves information about the current state of the game server
 * deployment. Gathers all the Agones fleets and Agones autoscalers,
 * including fleets running an older version of the game server deployment.
 *
 * @param string $name The name of the game server delpoyment, in the following form:
 *                     `projects/{project}/locations/{location}/gameServerDeployments/{deployment}`.
 */
function fetch_deployment_state_sample(string $name): void
{
    // Create a client.
    $gameServerDeploymentsServiceClient = new GameServerDeploymentsServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var FetchDeploymentStateResponse $response */
        $response = $gameServerDeploymentsServiceClient->fetchDeploymentState($name);
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
    $name = '[NAME]';

    fetch_deployment_state_sample($name);
}
// [END gameservices_v1_generated_GameServerDeploymentsService_FetchDeploymentState_sync]
