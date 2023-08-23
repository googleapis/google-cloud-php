<?php
/*
 * Copyright 2022 Google LLC
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

// [START bigqueryreservation_v1_generated_ReservationService_MoveAssignment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\Reservation\V1\Assignment;
use Google\Cloud\BigQuery\Reservation\V1\ReservationServiceClient;

/**
 * Moves an assignment under a new reservation.
 *
 * This differs from removing an existing assignment and recreating a new one
 * by providing a transactional change that ensures an assignee always has an
 * associated reservation.
 *
 * @param string $formattedName The resource name of the assignment,
 *                              e.g.
 *                              `projects/myproject/locations/US/reservations/team1-prod/assignments/123`
 *                              Please see {@see ReservationServiceClient::assignmentName()} for help formatting this field.
 */
function move_assignment_sample(string $formattedName): void
{
    // Create a client.
    $reservationServiceClient = new ReservationServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var Assignment $response */
        $response = $reservationServiceClient->moveAssignment($formattedName);
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
    $formattedName = ReservationServiceClient::assignmentName(
        '[PROJECT]',
        '[LOCATION]',
        '[RESERVATION]',
        '[ASSIGNMENT]'
    );

    move_assignment_sample($formattedName);
}
// [END bigqueryreservation_v1_generated_ReservationService_MoveAssignment_sync]
