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

// [START compute_v1_generated_ReservationBlocks_List_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Compute\V1\Client\ReservationBlocksClient;
use Google\Cloud\Compute\V1\ListReservationBlocksRequest;

/**
 * Retrieves a list of reservation blocks under a single reservation.
 *
 * @param string $project     Project ID for this request.
 * @param string $reservation The name of the reservation. Name should conform to RFC1035 or be a resource ID.
 * @param string $zone        Name of the zone for this request. Zone name should conform to RFC1035.
 */
function list_sample(string $project, string $reservation, string $zone): void
{
    // Create a client.
    $reservationBlocksClient = new ReservationBlocksClient();

    // Prepare the request message.
    $request = (new ListReservationBlocksRequest())
        ->setProject($project)
        ->setReservation($reservation)
        ->setZone($zone);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $reservationBlocksClient->list($request);

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
    $project = '[PROJECT]';
    $reservation = '[RESERVATION]';
    $zone = '[ZONE]';

    list_sample($project, $reservation, $zone);
}
// [END compute_v1_generated_ReservationBlocks_List_sync]
