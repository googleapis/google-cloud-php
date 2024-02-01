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

// [START bigqueryreservation_v1_generated_ReservationService_SearchAllAssignments_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\BigQuery\Reservation\V1\Assignment;
use Google\Cloud\BigQuery\Reservation\V1\Client\ReservationServiceClient;
use Google\Cloud\BigQuery\Reservation\V1\SearchAllAssignmentsRequest;

/**
 * Looks up assignments for a specified resource for a particular region.
 * If the request is about a project:
 *
 * 1. Assignments created on the project will be returned if they exist.
 * 2. Otherwise assignments created on the closest ancestor will be
 * returned.
 * 3. Assignments for different JobTypes will all be returned.
 *
 * The same logic applies if the request is about a folder.
 *
 * If the request is about an organization, then assignments created on the
 * organization will be returned (organization doesn't have ancestors).
 *
 * Comparing to ListAssignments, there are some behavior
 * differences:
 *
 * 1. permission on the assignee will be verified in this API.
 * 2. Hierarchy lookup (project->folder->organization) happens in this API.
 * 3. Parent here is `projects/&#42;/locations/*`, instead of
 * `projects/&#42;/locations/*reservations/*`.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function search_all_assignments_sample(): void
{
    // Create a client.
    $reservationServiceClient = new ReservationServiceClient();

    // Prepare the request message.
    $request = new SearchAllAssignmentsRequest();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $reservationServiceClient->searchAllAssignments($request);

        /** @var Assignment $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END bigqueryreservation_v1_generated_ReservationService_SearchAllAssignments_sync]
