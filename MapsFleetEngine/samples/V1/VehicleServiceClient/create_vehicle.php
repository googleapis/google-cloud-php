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

// [START fleetengine_v1_generated_VehicleService_CreateVehicle_sync]
use Google\ApiCore\ApiException;
use Google\Maps\FleetEngine\V1\Client\VehicleServiceClient;
use Google\Maps\FleetEngine\V1\CreateVehicleRequest;
use Google\Maps\FleetEngine\V1\Vehicle;
use Google\Maps\FleetEngine\V1\Vehicle\VehicleType;

/**
 * Instantiates a new vehicle associated with an on-demand rideshare or
 * deliveries provider. Each `Vehicle` must have a unique vehicle ID.
 *
 * The following `Vehicle` fields are required when creating a `Vehicle`:
 *
 * * `vehicleState`
 * * `supportedTripTypes`
 * * `maximumCapacity`
 * * `vehicleType`
 *
 * The following `Vehicle` fields are ignored when creating a `Vehicle`:
 *
 * * `name`
 * * `currentTrips`
 * * `availableCapacity`
 * * `current_route_segment`
 * * `current_route_segment_end_point`
 * * `current_route_segment_version`
 * * `current_route_segment_traffic`
 * * `route`
 * * `waypoints`
 * * `waypoints_version`
 * * `remaining_distance_meters`
 * * `remaining_time_seconds`
 * * `eta_to_next_waypoint`
 * * `navigation_status`
 *
 * All other fields are optional and used if provided.
 *
 * @param string $parent    Must be in the format `providers/{provider}`.
 *                          The provider must be the Project ID (for example, `sample-cloud-project`)
 *                          of the Google Cloud Project of which the service account making
 *                          this call is a member.
 * @param string $vehicleId Unique Vehicle ID.
 *                          Subject to the following restrictions:
 *
 *                          * Must be a valid Unicode string.
 *                          * Limited to a maximum length of 64 characters.
 *                          * Normalized according to [Unicode Normalization Form C]
 *                          (http://www.unicode.org/reports/tr15/).
 *                          * May not contain any of the following ASCII characters: '/', ':', '?',
 *                          ',', or '#'.
 */
function create_vehicle_sample(string $parent, string $vehicleId): void
{
    // Create a client.
    $vehicleServiceClient = new VehicleServiceClient();

    // Prepare the request message.
    $vehicleVehicleType = new VehicleType();
    $vehicle = (new Vehicle())
        ->setVehicleType($vehicleVehicleType);
    $request = (new CreateVehicleRequest())
        ->setParent($parent)
        ->setVehicleId($vehicleId)
        ->setVehicle($vehicle);

    // Call the API and handle any network failures.
    try {
        /** @var Vehicle $response */
        $response = $vehicleServiceClient->createVehicle($request);
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
    $parent = '[PARENT]';
    $vehicleId = '[VEHICLE_ID]';

    create_vehicle_sample($parent, $vehicleId);
}
// [END fleetengine_v1_generated_VehicleService_CreateVehicle_sync]
