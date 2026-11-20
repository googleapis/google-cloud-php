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

// [START admanager_v1_generated_TrafficForecastSegmentService_UpdateTrafficForecastSegment_sync]
use Google\Ads\AdManager\V1\Client\TrafficForecastSegmentServiceClient;
use Google\Ads\AdManager\V1\Targeting;
use Google\Ads\AdManager\V1\TrafficForecastSegment;
use Google\Ads\AdManager\V1\UpdateTrafficForecastSegmentRequest;
use Google\ApiCore\ApiException;

/**
 * Updates a `TrafficForecastSegment` object.
 *
 * @param string $trafficForecastSegmentDisplayName Name of the TrafficForecastSegment. This field must be unique
 *                                                  among all segments for this network.
 */
function update_traffic_forecast_segment_sample(string $trafficForecastSegmentDisplayName): void
{
    // Create a client.
    $trafficForecastSegmentServiceClient = new TrafficForecastSegmentServiceClient();

    // Prepare the request message.
    $trafficForecastSegmentTargeting = new Targeting();
    $trafficForecastSegment = (new TrafficForecastSegment())
        ->setDisplayName($trafficForecastSegmentDisplayName)
        ->setTargeting($trafficForecastSegmentTargeting);
    $request = (new UpdateTrafficForecastSegmentRequest())
        ->setTrafficForecastSegment($trafficForecastSegment);

    // Call the API and handle any network failures.
    try {
        /** @var TrafficForecastSegment $response */
        $response = $trafficForecastSegmentServiceClient->updateTrafficForecastSegment($request);
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
    $trafficForecastSegmentDisplayName = '[DISPLAY_NAME]';

    update_traffic_forecast_segment_sample($trafficForecastSegmentDisplayName);
}
// [END admanager_v1_generated_TrafficForecastSegmentService_UpdateTrafficForecastSegment_sync]
