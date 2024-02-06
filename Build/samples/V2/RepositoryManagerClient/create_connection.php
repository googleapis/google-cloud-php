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

// [START cloudbuild_v2_generated_RepositoryManager_CreateConnection_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Build\V2\Client\RepositoryManagerClient;
use Google\Cloud\Build\V2\Connection;
use Google\Cloud\Build\V2\CreateConnectionRequest;
use Google\Rpc\Status;

/**
 * Creates a Connection.
 *
 * @param string $formattedParent Project and location where the connection will be created.
 *                                Format: `projects/&#42;/locations/*`. Please see
 *                                {@see RepositoryManagerClient::locationName()} for help formatting this field.
 * @param string $connectionId    The ID to use for the Connection, which will become the final
 *                                component of the Connection's resource name. Names must be unique
 *                                per-project per-location. Allows alphanumeric characters and any of
 *                                -._~%!$&'()*+,;=&#64;.
 */
function create_connection_sample(string $formattedParent, string $connectionId): void
{
    // Create a client.
    $repositoryManagerClient = new RepositoryManagerClient();

    // Prepare the request message.
    $connection = new Connection();
    $request = (new CreateConnectionRequest())
        ->setParent($formattedParent)
        ->setConnection($connection)
        ->setConnectionId($connectionId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $repositoryManagerClient->createConnection($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Connection $result */
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
    $formattedParent = RepositoryManagerClient::locationName('[PROJECT]', '[LOCATION]');
    $connectionId = '[CONNECTION_ID]';

    create_connection_sample($formattedParent, $connectionId);
}
// [END cloudbuild_v2_generated_RepositoryManager_CreateConnection_sync]
