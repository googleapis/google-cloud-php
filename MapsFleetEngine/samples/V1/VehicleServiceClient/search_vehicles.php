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

// [START fleetengine_v1_generated_VehicleService_SearchVehicles_sync]
use Google\ApiCore\ApiException;
use Google\Maps\FleetEngine\V1\Client\VehicleServiceClient;
use Google\Maps\FleetEngine\V1\SearchVehiclesRequest;
use Google\Maps\FleetEngine\V1\SearchVehiclesRequest\VehicleMatchOrder;
use Google\Maps\FleetEngine\V1\SearchVehiclesResponse;
use Google\Maps\FleetEngine\V1\TerminalLocation;
use Google\Maps\FleetEngine\V1\TripType;
use Google\Maps\FleetEngine\V1\Vehicle\VehicleType;
use Google\Type\LatLng;

/**
 * Returns a list of vehicles that match the request options.
 *
 * @param string $parent             Must be in the format `providers/{provider}`.
 *                                   The provider must be the Project ID (for example, `sample-cloud-project`)
 *                                   of the Google Cloud Project of which the service account making
 *                                   this call is a member.
 * @param int    $pickupRadiusMeters Defines the vehicle search radius around the pickup point. Only
 *                                   vehicles within the search radius will be returned. Value must be between
 *                                   400 and 10000 meters (inclusive).
 * @param int    $count              Specifies the maximum number of vehicles to return. The value
 *                                   must be between 1 and 50 (inclusive).
 * @param int    $minimumCapacity    Specifies the number of passengers being considered for a trip.
 *                                   The value must be greater than or equal to one. The driver is not
 *                                   considered in the capacity value.
 * @param int    $tripTypesElement   Represents the type of proposed trip. Must include exactly one
 *                                   type. `UNKNOWN_TRIP_TYPE` is not allowed. Restricts the search to only
 *                                   those vehicles that can support that trip type.
 * @param int    $orderBy            Specifies the desired ordering criterion for results.
 */
function search_vehicles_sample(
    string $parent,
    int $pickupRadiusMeters,
    int $count,
    int $minimumCapacity,
    int $tripTypesElement,
    int $orderBy
): void {
    // Create a client.
    $vehicleServiceClient = new VehicleServiceClient();

    // Prepare the request message.
    $pickupPointPoint = new LatLng();
    $pickupPoint = (new TerminalLocation())
        ->setPoint($pickupPointPoint);
    $tripTypes = [$tripTypesElement,];
    $vehicleTypes = [new VehicleType()];
    $request = (new SearchVehiclesRequest())
        ->setParent($parent)
        ->setPickupPoint($pickupPoint)
        ->setPickupRadiusMeters($pickupRadiusMeters)
        ->setCount($count)
        ->setMinimumCapacity($minimumCapacity)
        ->setTripTypes($tripTypes)
        ->setVehicleTypes($vehicleTypes)
        ->setOrderBy($orderBy);

    // Call the API and handle any network failures.
    try {
        /** @var SearchVehiclesResponse $response */
        $response = $vehicleServiceClient->searchVehicles($request);
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
    $pickupRadiusMeters = 0;
    $count = 0;
    $minimumCapacity = 0;
    $tripTypesElement = TripType::UNKNOWN_TRIP_TYPE;
    $orderBy = VehicleMatchOrder::UNKNOWN_VEHICLE_MATCH_ORDER;

    search_vehicles_sample(
        $parent,
        $pickupRadiusMeters,
        $count,
        $minimumCapacity,
        $tripTypesElement,
        $orderBy
    );
}
// [END fleetengine_v1_generated_VehicleService_SearchVehicles_sync]
