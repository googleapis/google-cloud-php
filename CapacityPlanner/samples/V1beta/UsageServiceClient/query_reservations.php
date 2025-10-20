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

// [START capacityplanner_v1beta_generated_UsageService_QueryReservations_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\CapacityPlanner\V1beta\Client\UsageServiceClient;
use Google\Cloud\CapacityPlanner\V1beta\QueryReservationsRequest;
use Google\Cloud\CapacityPlanner\V1beta\QueryReservationsRequest\ReservationDataLevel;
use Google\Cloud\CapacityPlanner\V1beta\QueryReservationsRequest\ReservationType;
use Google\Cloud\CapacityPlanner\V1beta\QueryReservationsResponse;

/**
 * Returns a list of the reservations that are in the parent parameter
 * and match your specified filters.
 *
 * @param string $formattedParent      The compute engine resource and location for the time series
 *                                     values to return. The format is:
 *
 *                                     projects/{project}/locations/{location} or
 *                                     organizations/{organization}/locations/{location} or
 *                                     folders/{folder}/locations/{location}
 *                                     Please see {@see UsageServiceClient::locationName()} for help formatting this field.
 * @param string $cloudResourceType    The resource for the reserved values to return. Possible values
 *                                     include "gce-vcpus", "gce-ram", "gce-local-ssd", "gce-gpu" and "gce-vm".
 * @param int    $reservationType      The Reservation type for example, future reservation request and
 *                                     allocation. If unspecified, all types are
 *                                     included.
 * @param int    $reservationDataLevel Reservations output data format.
 */
function query_reservations_sample(
    string $formattedParent,
    string $cloudResourceType,
    int $reservationType,
    int $reservationDataLevel
): void {
    // Create a client.
    $usageServiceClient = new UsageServiceClient();

    // Prepare the request message.
    $request = (new QueryReservationsRequest())
        ->setParent($formattedParent)
        ->setCloudResourceType($cloudResourceType)
        ->setReservationType($reservationType)
        ->setReservationDataLevel($reservationDataLevel);

    // Call the API and handle any network failures.
    try {
        /** @var QueryReservationsResponse $response */
        $response = $usageServiceClient->queryReservations($request);
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
    $formattedParent = UsageServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $cloudResourceType = '[CLOUD_RESOURCE_TYPE]';
    $reservationType = ReservationType::RESERVATION_TYPE_UNSPECIFIED;
    $reservationDataLevel = ReservationDataLevel::RESERVATION_DATA_LEVEL_UNSPECIFIED;

    query_reservations_sample(
        $formattedParent,
        $cloudResourceType,
        $reservationType,
        $reservationDataLevel
    );
}
// [END capacityplanner_v1beta_generated_UsageService_QueryReservations_sync]
