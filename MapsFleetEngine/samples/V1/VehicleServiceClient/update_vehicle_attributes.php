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

// [START fleetengine_v1_generated_VehicleService_UpdateVehicleAttributes_sync]
use Google\ApiCore\ApiException;
use Google\Maps\FleetEngine\V1\Client\VehicleServiceClient;
use Google\Maps\FleetEngine\V1\UpdateVehicleAttributesRequest;
use Google\Maps\FleetEngine\V1\UpdateVehicleAttributesResponse;
use Google\Maps\FleetEngine\V1\VehicleAttribute;

/**
 * Partially updates a vehicle's attributes.
 * Only the attributes mentioned in the request will be updated, other
 * attributes will NOT be altered. Note: this is different in `UpdateVehicle`,
 * where the whole `attributes` field will be replaced by the one in
 * `UpdateVehicleRequest`, attributes not in the request would be removed.
 *
 * @param string $name Must be in the format `providers/{provider}/vehicles/{vehicle}`.
 *                     The provider must be the Project ID (for example, `sample-cloud-project`)
 *                     of the Google Cloud Project of which the service account making
 *                     this call is a member.
 */
function update_vehicle_attributes_sample(string $name): void
{
    // Create a client.
    $vehicleServiceClient = new VehicleServiceClient();

    // Prepare the request message.
    $attributes = [new VehicleAttribute()];
    $request = (new UpdateVehicleAttributesRequest())
        ->setName($name)
        ->setAttributes($attributes);

    // Call the API and handle any network failures.
    try {
        /** @var UpdateVehicleAttributesResponse $response */
        $response = $vehicleServiceClient->updateVehicleAttributes($request);
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

    update_vehicle_attributes_sample($name);
}
// [END fleetengine_v1_generated_VehicleService_UpdateVehicleAttributes_sync]
