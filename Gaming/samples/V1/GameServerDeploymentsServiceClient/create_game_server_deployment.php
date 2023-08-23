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

// [START gameservices_v1_generated_GameServerDeploymentsService_CreateGameServerDeployment_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Gaming\V1\GameServerDeployment;
use Google\Cloud\Gaming\V1\GameServerDeploymentsServiceClient;
use Google\Rpc\Status;

/**
 * Creates a new game server deployment in a given project and location.
 *
 * @param string $formattedParent The parent resource name, in the following form:
 *                                `projects/{project}/locations/{location}`. Please see
 *                                {@see GameServerDeploymentsServiceClient::locationName()} for help formatting this field.
 * @param string $deploymentId    The ID of the game server delpoyment resource to be created.
 */
function create_game_server_deployment_sample(string $formattedParent, string $deploymentId): void
{
    // Create a client.
    $gameServerDeploymentsServiceClient = new GameServerDeploymentsServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $gameServerDeployment = new GameServerDeployment();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $gameServerDeploymentsServiceClient->createGameServerDeployment(
            $formattedParent,
            $deploymentId,
            $gameServerDeployment
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var GameServerDeployment $result */
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
    $formattedParent = GameServerDeploymentsServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $deploymentId = '[DEPLOYMENT_ID]';

    create_game_server_deployment_sample($formattedParent, $deploymentId);
}
// [END gameservices_v1_generated_GameServerDeploymentsService_CreateGameServerDeployment_sync]
