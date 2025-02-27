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

// [START fleetengine_v1_generated_TripService_DeleteTrip_sync]
use Google\ApiCore\ApiException;
use Google\Maps\FleetEngine\V1\Client\TripServiceClient;
use Google\Maps\FleetEngine\V1\DeleteTripRequest;

/**
 * Deletes a single Trip.
 *
 * Returns FAILED_PRECONDITION if the Trip is active and assigned to a
 * vehicle.
 *
 * @param string $formattedName Must be in the format `providers/{provider}/trips/{trip}`.
 *                              The provider must be the Project ID (for example, `sample-cloud-project`)
 *                              of the Google Cloud Project of which the service account making
 *                              this call is a member. Please see
 *                              {@see TripServiceClient::tripName()} for help formatting this field.
 */
function delete_trip_sample(string $formattedName): void
{
    // Create a client.
    $tripServiceClient = new TripServiceClient();

    // Prepare the request message.
    $request = (new DeleteTripRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $tripServiceClient->deleteTrip($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = TripServiceClient::tripName('[PROVIDER]', '[TRIP]');

    delete_trip_sample($formattedName);
}
// [END fleetengine_v1_generated_TripService_DeleteTrip_sync]
