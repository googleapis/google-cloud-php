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

// [START bigqueryreservation_v1_generated_ReservationService_CreateCapacityCommitment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\Reservation\V1\CapacityCommitment;
use Google\Cloud\BigQuery\Reservation\V1\ReservationServiceClient;

/**
 * Creates a new capacity commitment resource.
 *
 * @param string $formattedParent Resource name of the parent reservation. E.g.,
 *                                `projects/myproject/locations/US`
 *                                Please see {@see ReservationServiceClient::locationName()} for help formatting this field.
 */
function create_capacity_commitment_sample(string $formattedParent): void
{
    // Create a client.
    $reservationServiceClient = new ReservationServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var CapacityCommitment $response */
        $response = $reservationServiceClient->createCapacityCommitment($formattedParent);
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
    $formattedParent = ReservationServiceClient::locationName('[PROJECT]', '[LOCATION]');

    create_capacity_commitment_sample($formattedParent);
}
// [END bigqueryreservation_v1_generated_ReservationService_CreateCapacityCommitment_sync]
