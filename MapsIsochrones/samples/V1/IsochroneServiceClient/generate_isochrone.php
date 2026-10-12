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

// [START isochrones_v1_generated_IsochroneService_GenerateIsochrone_sync]
use Google\ApiCore\ApiException;
use Google\Maps\Isochrones\V1\Client\IsochroneServiceClient;
use Google\Maps\Isochrones\V1\GenerateIsochroneRequest;
use Google\Maps\Isochrones\V1\GenerateIsochroneRequest\TravelDirection;
use Google\Maps\Isochrones\V1\GenerateIsochroneRequest\TravelMode;
use Google\Maps\Isochrones\V1\GenerateIsochroneResponse;
use Google\Protobuf\Duration;

/**
 * Calculates and returns a single isochrone for a given set of parameters.
 *
 * @param int $travelMode      The mode of transportation.
 * @param int $travelDirection The direction of travel.
 */
function generate_isochrone_sample(int $travelMode, int $travelDirection): void
{
    // Create a client.
    $isochroneServiceClient = new IsochroneServiceClient();

    // Prepare the request message.
    $travelDuration = new Duration();
    $request = (new GenerateIsochroneRequest())
        ->setTravelDuration($travelDuration)
        ->setTravelMode($travelMode)
        ->setTravelDirection($travelDirection);

    // Call the API and handle any network failures.
    try {
        /** @var GenerateIsochroneResponse $response */
        $response = $isochroneServiceClient->generateIsochrone($request);
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
    $travelMode = TravelMode::TRAVEL_MODE_UNSPECIFIED;
    $travelDirection = TravelDirection::TRAVEL_DIRECTION_UNSPECIFIED;

    generate_isochrone_sample($travelMode, $travelDirection);
}
// [END isochrones_v1_generated_IsochroneService_GenerateIsochrone_sync]
