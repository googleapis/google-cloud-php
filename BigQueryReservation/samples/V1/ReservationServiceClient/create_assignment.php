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

// [START bigqueryreservation_v1_generated_ReservationService_CreateAssignment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\Reservation\V1\Assignment;
use Google\Cloud\BigQuery\Reservation\V1\ReservationServiceClient;

/**
 * Creates an assignment object which allows the given project to submit jobs
 * of a certain type using slots from the specified reservation.
 *
 * Currently a
 * resource (project, folder, organization) can only have one assignment per
 * each (job_type, location) combination, and that reservation will be used
 * for all jobs of the matching type.
 *
 * Different assignments can be created on different levels of the
 * projects, folders or organization hierarchy.  During query execution,
 * the assignment is looked up at the project, folder and organization levels
 * in that order. The first assignment found is applied to the query.
 *
 * When creating assignments, it does not matter if other assignments exist at
 * higher levels.
 *
 * Example:
 *
 * * The organization `organizationA` contains two projects, `project1`
 * and `project2`.
 * * Assignments for all three entities (`organizationA`, `project1`, and
 * `project2`) could all be created and mapped to the same or different
 * reservations.
 *
 * "None" assignments represent an absence of the assignment. Projects
 * assigned to None use on-demand pricing. To create a "None" assignment, use
 * "none" as a reservation_id in the parent. Example parent:
 * `projects/myproject/locations/US/reservations/none`.
 *
 * Returns `google.rpc.Code.PERMISSION_DENIED` if user does not have
 * 'bigquery.admin' permissions on the project using the reservation
 * and the project that owns this reservation.
 *
 * Returns `google.rpc.Code.INVALID_ARGUMENT` when location of the assignment
 * does not match location of the reservation.
 *
 * @param string $formattedParent The parent resource name of the assignment
 *                                E.g. `projects/myproject/locations/US/reservations/team1-prod`
 *                                Please see {@see ReservationServiceClient::reservationName()} for help formatting this field.
 */
function create_assignment_sample(string $formattedParent): void
{
    // Create a client.
    $reservationServiceClient = new ReservationServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var Assignment $response */
        $response = $reservationServiceClient->createAssignment($formattedParent);
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
    $formattedParent = ReservationServiceClient::reservationName(
        '[PROJECT]',
        '[LOCATION]',
        '[RESERVATION]'
    );

    create_assignment_sample($formattedParent);
}
// [END bigqueryreservation_v1_generated_ReservationService_CreateAssignment_sync]
