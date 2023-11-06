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

// [START fleetengine_v1_generated_VehicleService_UpdateVehicleLocation_sync]
use Google\ApiCore\ApiException;
use Maps\Fleetengine\V1\VehicleLocation;
use Maps\Fleetengine\V1\VehicleServiceClient;

/**
 * Deprecated: Use the `UpdateVehicle` method instead.
 * UpdateVehicleLocation updates the location of the vehicle.
 *
 * @param string $name Must be in the format
 *                     `providers/{provider}/vehicles/{vehicle}`.
 *                     The {provider} must be the Project ID (for example, `sample-cloud-project`)
 *                     of the Google Cloud Project of which the service account making
 *                     this call is a member.
 */
function update_vehicle_location_sample(string $name): void
{
    // Create a client.
    $vehicleServiceClient = new VehicleServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $currentLocation = new VehicleLocation();

    // Call the API and handle any network failures.
    try {
        /** @var VehicleLocation $response */
        $response = $vehicleServiceClient->updateVehicleLocation($name, $currentLocation);
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

    update_vehicle_location_sample($name);
}
// [END fleetengine_v1_generated_VehicleService_UpdateVehicleLocation_sync]
