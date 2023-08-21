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

// [START cloudoptimization_v1_generated_FleetRouting_OptimizeTours_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Optimization\V1\Client\FleetRoutingClient;
use Google\Cloud\Optimization\V1\OptimizeToursRequest;
use Google\Cloud\Optimization\V1\OptimizeToursResponse;

/**
 * Sends an `OptimizeToursRequest` containing a `ShipmentModel` and returns an
 * `OptimizeToursResponse` containing `ShipmentRoute`s, which are a set of
 * routes to be performed by vehicles minimizing the overall cost.
 *
 * A `ShipmentModel` model consists mainly of `Shipment`s that need to be
 * carried out and `Vehicle`s that can be used to transport the `Shipment`s.
 * The `ShipmentRoute`s assign `Shipment`s to `Vehicle`s. More specifically,
 * they assign a series of `Visit`s to each vehicle, where a `Visit`
 * corresponds to a `VisitRequest`, which is a pickup or delivery for a
 * `Shipment`.
 *
 * The goal is to provide an assignment of `ShipmentRoute`s to `Vehicle`s that
 * minimizes the total cost where cost has many components defined in the
 * `ShipmentModel`.
 *
 * @param string $parent Target project and location to make a call.
 *
 *                       Format: `projects/{project-id}/locations/{location-id}`.
 *
 *                       If no location is specified, a region will be chosen automatically.
 */
function optimize_tours_sample(string $parent): void
{
    // Create a client.
    $fleetRoutingClient = new FleetRoutingClient();

    // Prepare the request message.
    $request = (new OptimizeToursRequest())
        ->setParent($parent);

    // Call the API and handle any network failures.
    try {
        /** @var OptimizeToursResponse $response */
        $response = $fleetRoutingClient->optimizeTours($request);
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

    optimize_tours_sample($parent);
}
// [END cloudoptimization_v1_generated_FleetRouting_OptimizeTours_sync]
