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

// [START fleetengine_v1_generated_DeliveryService_UpdateDeliveryVehicle_sync]
use Google\ApiCore\ApiException;
use Google\Maps\FleetEngine\Delivery\V1\Client\DeliveryServiceClient;
use Google\Maps\FleetEngine\Delivery\V1\DeliveryVehicle;
use Google\Maps\FleetEngine\Delivery\V1\UpdateDeliveryVehicleRequest;
use Google\Protobuf\FieldMask;

/**
 * Writes updated `DeliveryVehicle` data to Fleet Engine, and assigns
 * `Tasks` to the `DeliveryVehicle`. You cannot update the name of the
 * `DeliveryVehicle`. You *can* update `remaining_vehicle_journey_segments`,
 * but it must contain all of the `VehicleJourneySegment`s to be persisted on
 * the `DeliveryVehicle`. The `task_id`s are retrieved from
 * `remaining_vehicle_journey_segments`, and their corresponding `Tasks` are
 * assigned to the `DeliveryVehicle` if they have not yet been assigned.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_delivery_vehicle_sample(): void
{
    // Create a client.
    $deliveryServiceClient = new DeliveryServiceClient();

    // Prepare the request message.
    $deliveryVehicle = new DeliveryVehicle();
    $updateMask = new FieldMask();
    $request = (new UpdateDeliveryVehicleRequest())
        ->setDeliveryVehicle($deliveryVehicle)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var DeliveryVehicle $response */
        $response = $deliveryServiceClient->updateDeliveryVehicle($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END fleetengine_v1_generated_DeliveryService_UpdateDeliveryVehicle_sync]
