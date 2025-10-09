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

// [START bigqueryreservation_v1_generated_ReservationService_FailoverReservation_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\Reservation\V1\Client\ReservationServiceClient;
use Google\Cloud\BigQuery\Reservation\V1\FailoverReservationRequest;
use Google\Cloud\BigQuery\Reservation\V1\Reservation;

/**
 * Fail over a reservation to the secondary location. The operation should be
 * done in the current secondary location, which will be promoted to the
 * new primary location for the reservation.
 * Attempting to failover a reservation in the current primary location will
 * fail with the error code `google.rpc.Code.FAILED_PRECONDITION`.
 *
 * @param string $formattedName Resource name of the reservation to failover. E.g.,
 *                              `projects/myproject/locations/US/reservations/team1-prod`
 *                              Please see {@see ReservationServiceClient::reservationName()} for help formatting this field.
 */
function failover_reservation_sample(string $formattedName): void
{
    // Create a client.
    $reservationServiceClient = new ReservationServiceClient();

    // Prepare the request message.
    $request = (new FailoverReservationRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Reservation $response */
        $response = $reservationServiceClient->failoverReservation($request);
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
    $formattedName = ReservationServiceClient::reservationName(
        '[PROJECT]',
        '[LOCATION]',
        '[RESERVATION]'
    );

    failover_reservation_sample($formattedName);
}
// [END bigqueryreservation_v1_generated_ReservationService_FailoverReservation_sync]
