<?php
/*
 * Copyright 2025 Google LLC
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

// [START networkservices_v1_generated_NetworkServices_GetMeshRouteView_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\NetworkServices\V1\Client\NetworkServicesClient;
use Google\Cloud\NetworkServices\V1\GetMeshRouteViewRequest;
use Google\Cloud\NetworkServices\V1\MeshRouteView;

/**
 * Get a single RouteView of a Mesh.
 *
 * @param string $formattedName Name of the MeshRouteView resource.
 *                              Format:
 *                              projects/{project}/locations/{location}/meshes/{mesh}/routeViews/{route_view}
 *                              Please see {@see NetworkServicesClient::meshRouteViewName()} for help formatting this field.
 */
function get_mesh_route_view_sample(string $formattedName): void
{
    // Create a client.
    $networkServicesClient = new NetworkServicesClient();

    // Prepare the request message.
    $request = (new GetMeshRouteViewRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var MeshRouteView $response */
        $response = $networkServicesClient->getMeshRouteView($request);
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
    $formattedName = NetworkServicesClient::meshRouteViewName(
        '[PROJECT]',
        '[LOCATION]',
        '[MESH]',
        '[ROUTE_VIEW]'
    );

    get_mesh_route_view_sample($formattedName);
}
// [END networkservices_v1_generated_NetworkServices_GetMeshRouteView_sync]
