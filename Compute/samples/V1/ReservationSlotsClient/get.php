<?php
/*
 * Copyright 2026 Google LLC
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

// [START compute_v1_generated_ReservationSlots_Get_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Compute\V1\Client\ReservationSlotsClient;
use Google\Cloud\Compute\V1\GetReservationSlotRequest;
use Google\Cloud\Compute\V1\ReservationSlotsGetResponse;

/**
 * Retrieves information about the specified reservation slot.
 *
 * @param string $parentName      The name of the parent reservation and parent block, formatted as
 *                                reservations/{reservation_name}/reservationBlocks/{reservation_block_name}/reservationSubBlocks/{reservation_sub_block_name}
 * @param string $project         The project ID for this request.
 * @param string $reservationSlot The name of the reservation slot, formatted as RFC1035 or a resource ID
 *                                number.
 * @param string $zone            The name of the zone for this request, formatted as RFC1035.
 */
function get_sample(
    string $parentName,
    string $project,
    string $reservationSlot,
    string $zone
): void {
    // Create a client.
    $reservationSlotsClient = new ReservationSlotsClient();

    // Prepare the request message.
    $request = (new GetReservationSlotRequest())
        ->setParentName($parentName)
        ->setProject($project)
        ->setReservationSlot($reservationSlot)
        ->setZone($zone);

    // Call the API and handle any network failures.
    try {
        /** @var ReservationSlotsGetResponse $response */
        $response = $reservationSlotsClient->get($request);
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
    $parentName = '[PARENT_NAME]';
    $project = '[PROJECT]';
    $reservationSlot = '[RESERVATION_SLOT]';
    $zone = '[ZONE]';

    get_sample($parentName, $project, $reservationSlot, $zone);
}
// [END compute_v1_generated_ReservationSlots_Get_sync]
