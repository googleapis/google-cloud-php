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

// [START memorystore_v1beta_generated_Memorystore_UpdateInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Memorystore\V1beta\Client\MemorystoreClient;
use Google\Cloud\Memorystore\V1beta\Instance;
use Google\Cloud\Memorystore\V1beta\PscAutoConnection;
use Google\Cloud\Memorystore\V1beta\UpdateInstanceRequest;
use Google\Rpc\Status;

/**
 * Updates the parameters of a single Instance.
 *
 * @param string $instancePscAutoConnectionsProjectId        The consumer project_id where PSC connections are established.
 *                                                           This should be the same project_id that the instance is being created in.
 * @param string $formattedInstancePscAutoConnectionsNetwork The network where the PSC endpoints are created, in the form of
 *                                                           projects/{project_id}/global/networks/{network_id}. Please see
 *                                                           {@see MemorystoreClient::networkName()} for help formatting this field.
 */
function update_instance_sample(
    string $instancePscAutoConnectionsProjectId,
    string $formattedInstancePscAutoConnectionsNetwork
): void {
    // Create a client.
    $memorystoreClient = new MemorystoreClient();

    // Prepare the request message.
    $pscAutoConnection = (new PscAutoConnection())
        ->setProjectId($instancePscAutoConnectionsProjectId)
        ->setNetwork($formattedInstancePscAutoConnectionsNetwork);
    $instancePscAutoConnections = [$pscAutoConnection,];
    $instance = (new Instance())
        ->setPscAutoConnections($instancePscAutoConnections);
    $request = (new UpdateInstanceRequest())
        ->setInstance($instance);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $memorystoreClient->updateInstance($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Instance $result */
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
    $instancePscAutoConnectionsProjectId = '[PROJECT_ID]';
    $formattedInstancePscAutoConnectionsNetwork = MemorystoreClient::networkName(
        '[PROJECT]',
        '[NETWORK]'
    );

    update_instance_sample(
        $instancePscAutoConnectionsProjectId,
        $formattedInstancePscAutoConnectionsNetwork
    );
}
// [END memorystore_v1beta_generated_Memorystore_UpdateInstance_sync]
