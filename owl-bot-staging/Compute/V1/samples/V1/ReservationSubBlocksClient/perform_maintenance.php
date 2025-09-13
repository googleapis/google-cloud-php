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

// [START compute_v1_generated_ReservationSubBlocks_PerformMaintenance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Compute\V1\Client\ReservationSubBlocksClient;
use Google\Cloud\Compute\V1\PerformMaintenanceReservationSubBlockRequest;
use Google\Rpc\Status;

/**
 * Allows customers to perform maintenance on a reservation subBlock
 *
 * @param string $parentName          The name of the parent reservation and parent block. In the format of reservations/{reservation_name}/reservationBlocks/{reservation_block_name}
 * @param string $project             Project ID for this request.
 * @param string $reservationSubBlock The name of the reservation subBlock. Name should conform to RFC1035 or be a resource ID.
 * @param string $zone                Name of the zone for this request. Zone name should conform to RFC1035.
 */
function perform_maintenance_sample(
    string $parentName,
    string $project,
    string $reservationSubBlock,
    string $zone
): void {
    // Create a client.
    $reservationSubBlocksClient = new ReservationSubBlocksClient();

    // Prepare the request message.
    $request = (new PerformMaintenanceReservationSubBlockRequest())
        ->setParentName($parentName)
        ->setProject($project)
        ->setReservationSubBlock($reservationSubBlock)
        ->setZone($zone);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $reservationSubBlocksClient->performMaintenance($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $parentName = '[PARENT_NAME]';
    $project = '[PROJECT]';
    $reservationSubBlock = '[RESERVATION_SUB_BLOCK]';
    $zone = '[ZONE]';

    perform_maintenance_sample($parentName, $project, $reservationSubBlock, $zone);
}
// [END compute_v1_generated_ReservationSubBlocks_PerformMaintenance_sync]
