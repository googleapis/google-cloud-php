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

// [START fleetengine_v1_generated_DeliveryService_CreateDeliveryVehicle_sync]
use Google\ApiCore\ApiException;
use Google\Maps\FleetEngine\Delivery\V1\Client\DeliveryServiceClient;
use Google\Maps\FleetEngine\Delivery\V1\CreateDeliveryVehicleRequest;
use Google\Maps\FleetEngine\Delivery\V1\DeliveryVehicle;

/**
 * Creates and returns a new `DeliveryVehicle`.
 *
 * @param string $parent            Must be in the format `providers/{provider}`. The provider must
 *                                  be the Google Cloud Project ID. For example, `sample-cloud-project`.
 * @param string $deliveryVehicleId The Delivery Vehicle ID must be unique and subject to the
 *                                  following restrictions:
 *
 *                                  * Must be a valid Unicode string.
 *                                  * Limited to a maximum length of 64 characters.
 *                                  * Normalized according to [Unicode Normalization Form C]
 *                                  (http://www.unicode.org/reports/tr15/).
 *                                  * May not contain any of the following ASCII characters: '/', ':', '?',
 *                                  ',', or '#'.
 */
function create_delivery_vehicle_sample(string $parent, string $deliveryVehicleId): void
{
    // Create a client.
    $deliveryServiceClient = new DeliveryServiceClient();

    // Prepare the request message.
    $deliveryVehicle = new DeliveryVehicle();
    $request = (new CreateDeliveryVehicleRequest())
        ->setParent($parent)
        ->setDeliveryVehicleId($deliveryVehicleId)
        ->setDeliveryVehicle($deliveryVehicle);

    // Call the API and handle any network failures.
    try {
        /** @var DeliveryVehicle $response */
        $response = $deliveryServiceClient->createDeliveryVehicle($request);
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
    $parent = '[PARENT]';
    $deliveryVehicleId = '[DELIVERY_VEHICLE_ID]';

    create_delivery_vehicle_sample($parent, $deliveryVehicleId);
}
// [END fleetengine_v1_generated_DeliveryService_CreateDeliveryVehicle_sync]
