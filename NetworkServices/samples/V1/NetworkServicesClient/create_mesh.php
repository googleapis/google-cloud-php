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

// [START networkservices_v1_generated_NetworkServices_CreateMesh_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkServices\V1\Client\NetworkServicesClient;
use Google\Cloud\NetworkServices\V1\CreateMeshRequest;
use Google\Cloud\NetworkServices\V1\Mesh;
use Google\Rpc\Status;

/**
 * Creates a new Mesh in a given project and location.
 *
 * @param string $formattedParent The parent resource of the Mesh. Must be in the
 *                                format `projects/&#42;/locations/global`. Please see
 *                                {@see NetworkServicesClient::locationName()} for help formatting this field.
 * @param string $meshId          Short name of the Mesh resource to be created.
 * @param string $meshName        Name of the Mesh resource. It matches pattern
 *                                `projects/&#42;/locations/global/meshes/<mesh_name>`.
 */
function create_mesh_sample(string $formattedParent, string $meshId, string $meshName): void
{
    // Create a client.
    $networkServicesClient = new NetworkServicesClient();

    // Prepare the request message.
    $mesh = (new Mesh())
        ->setName($meshName);
    $request = (new CreateMeshRequest())
        ->setParent($formattedParent)
        ->setMeshId($meshId)
        ->setMesh($mesh);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networkServicesClient->createMesh($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Mesh $result */
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
    $formattedParent = NetworkServicesClient::locationName('[PROJECT]', '[LOCATION]');
    $meshId = '[MESH_ID]';
    $meshName = '[NAME]';

    create_mesh_sample($formattedParent, $meshId, $meshName);
}
// [END networkservices_v1_generated_NetworkServices_CreateMesh_sync]
