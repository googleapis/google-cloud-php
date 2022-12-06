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

// [START bigqueryreservation_v1_generated_ReservationService_ListAssignments_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\BigQuery\Reservation\V1\Assignment;
use Google\Cloud\BigQuery\Reservation\V1\ReservationServiceClient;

/**
 * Lists assignments.
 *
 * Only explicitly created assignments will be returned.
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
 * In this example, ListAssignments will just return the above two assignments
 * for reservation `res1`, and no expansion/merge will happen.
 *
 * The wildcard "-" can be used for
 * reservations in the request. In that case all assignments belongs to the
 * specified project and location will be listed.
 *
 * **Note** "-" cannot be used for projects nor locations.
 *
 * @param string $formattedParent The parent resource name e.g.:
 *
 *                                `projects/myproject/locations/US/reservations/team1-prod`
 *
 *                                Or:
 *
 *                                `projects/myproject/locations/US/reservations/-`
 *                                Please see {@see ReservationServiceClient::reservationName()} for help formatting this field.
 */
function list_assignments_sample(string $formattedParent): void
{
    // Create a client.
    $reservationServiceClient = new ReservationServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $reservationServiceClient->listAssignments($formattedParent);

        /** @var Assignment $element */
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
    $formattedParent = ReservationServiceClient::reservationName(
        '[PROJECT]',
        '[LOCATION]',
        '[RESERVATION]'
    );

    list_assignments_sample($formattedParent);
}
// [END bigqueryreservation_v1_generated_ReservationService_ListAssignments_sync]
