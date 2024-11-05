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

// [START fleetengine_v1_generated_VehicleService_ListVehicles_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Maps\FleetEngine\V1\Client\VehicleServiceClient;
use Google\Maps\FleetEngine\V1\ListVehiclesRequest;
use Google\Maps\FleetEngine\V1\Vehicle;
use Google\Maps\FleetEngine\V1\Vehicle\VehicleType\Category;

/**
 * Returns a paginated list of vehicles associated with
 * a provider that match the request options.
 *
 * @param string $parent                       Must be in the format `providers/{provider}`.
 *                                             The provider must be the Project ID (for example, `sample-cloud-project`)
 *                                             of the Google Cloud Project of which the service account making
 *                                             this call is a member.
 * @param int    $vehicleTypeCategoriesElement Restricts the response to vehicles with one of the specified type
 *                                             categories. `UNKNOWN` is not allowed.
 */
function list_vehicles_sample(string $parent, int $vehicleTypeCategoriesElement): void
{
    // Create a client.
    $vehicleServiceClient = new VehicleServiceClient();

    // Prepare the request message.
    $vehicleTypeCategories = [$vehicleTypeCategoriesElement,];
    $request = (new ListVehiclesRequest())
        ->setParent($parent)
        ->setVehicleTypeCategories($vehicleTypeCategories);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $vehicleServiceClient->listVehicles($request);

        /** @var Vehicle $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $parent = '[PARENT]';
    $vehicleTypeCategoriesElement = Category::UNKNOWN;

    list_vehicles_sample($parent, $vehicleTypeCategoriesElement);
}
// [END fleetengine_v1_generated_VehicleService_ListVehicles_sync]
