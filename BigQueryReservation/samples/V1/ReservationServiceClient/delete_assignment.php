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

// [START bigqueryreservation_v1_generated_ReservationService_DeleteAssignment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\Reservation\V1\ReservationServiceClient;

/**
 * Deletes a assignment. No expansion will happen.
 *
 * Example:
 *
 * * Organization `organizationA` contains two projects, `project1` and
 * `project2`.
 * * Reservation `res1` exists and was created previously.
 * * CreateAssignment was used previously to define the following
 * associations between entities and reservations: `<organizationA, res1>`
 * and `<project1, res1>`
 *
 * In this example, deletion of the `<organizationA, res1>` assignment won't
 * affect the other assignment `<project1, res1>`. After said deletion,
 * queries from `project1` will still use `res1` while queries from
 * `project2` will switch to use on-demand mode.
 *
 * @param string $formattedName Name of the resource, e.g.
 *                              `projects/myproject/locations/US/reservations/team1-prod/assignments/123`
 *                              Please see {@see ReservationServiceClient::assignmentName()} for help formatting this field.
 */
function delete_assignment_sample(string $formattedName): void
{
    // Create a client.
    $reservationServiceClient = new ReservationServiceClient();

    // Call the API and handle any network failures.
    try {
        $reservationServiceClient->deleteAssignment($formattedName);
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
    $formattedName = ReservationServiceClient::assignmentName(
        '[PROJECT]',
        '[LOCATION]',
        '[RESERVATION]',
        '[ASSIGNMENT]'
    );

    delete_assignment_sample($formattedName);
}
// [END bigqueryreservation_v1_generated_ReservationService_DeleteAssignment_sync]
